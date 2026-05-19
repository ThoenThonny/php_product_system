<?php
require_once 'Controller.php';
require_once '../app/models/Staff.php';

class StaffController extends Controller {
    private $staffModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        $this->staffModel = new Staff();
    }

    // List all staff
    public function index() {
    $search = $_GET['search'] ?? '';
    $status = $_GET['status'] ?? 'all'; // all, active, inactive

    if (!empty($search)) {
        $staffs = $this->staffModel->searchByName($search, $status);
    } else {
        $staffs = $this->staffModel->getAll($status);
    }
    $this->view('staff/index', ['staffs' => $staffs, 'search' => $search, 'status' => $status]);
}

    // Show add form
    public function add() {
        $this->view('staff/add');
    }

    // Store new staff
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('staff');
        }

        $errors = [];
        if (empty($_POST['FullName'])) $errors[] = "Full name is required";
        if (empty($_POST['Username'])) $errors[] = "Username is required";
        if (empty($_POST['Password'])) $errors[] = "Password is required";
        if ($_POST['Password'] !== $_POST['ConfirmPassword']) $errors[] = "Passwords do not match";

        // Check unique username
        if ($this->staffModel->findByUsername($_POST['Username'])) {
            $errors[] = "Username already taken";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('staff/add');
        }

        $data = [
            'FullName' => $_POST['FullName'],
            'Gen'      => $_POST['Gen'] ?? 'Other',
            'Dob'      => !empty($_POST['Dob']) ? $_POST['Dob'] : null,
            'Position' => $_POST['Position'] ?? '',
            'Salary'   => !empty($_POST['Salary']) ? $_POST['Salary'] : 0,
            'Stopwork' => isset($_POST['Stopwork']) ? 1 : 0,
            'Username' => $_POST['Username'],
            'Password' => $_POST['Password']
        ];

        if ($this->staffModel->create($data)) {
            $_SESSION['message'] = "Staff added successfully.";
        } else {
            $_SESSION['error'] = "Failed to add staff.";
        }
        $this->redirect('staff');
    }

    // Show edit form
    public function edit($id) {
        $staff = $this->staffModel->find($id);
        if (!$staff) {
            $_SESSION['error'] = "Staff not found";
            $this->redirect('staff');
        }
        $this->view('staff/edit', ['staff' => $staff]);
    }

    // Update staff (without password)
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('staff');
        }

        $data = [
            'stID'      => $id,
            'FullName'  => $_POST['FullName'],
            'Gen'       => $_POST['Gen'],
            'Dob'       => $_POST['Dob'],
            'Position'  => $_POST['Position'],
            'Salary'    => $_POST['Salary'],
            'Stopwork'  => isset($_POST['Stopwork']) ? 1 : 0,
            'Username'  => $_POST['Username']
        ];

        // Check if username is changed and already exists
        $existing = $this->staffModel->find($id);
        if ($existing['Username'] !== $data['Username'] && $this->staffModel->findByUsername($data['Username'])) {
            $_SESSION['error'] = "Username already taken";
            $this->redirect('staff/edit/' . $id);
        }

        if ($this->staffModel->update($data)) {
            $_SESSION['message'] = "Staff updated successfully.";
        } else {
            $_SESSION['error'] = "Update failed.";
        }
        $this->redirect('staff');
    }

    // Change password form & process
    public function changePassword($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (empty($_POST['new_password'])) {
                $_SESSION['error'] = "New password cannot be empty";
            } elseif ($_POST['new_password'] !== $_POST['confirm_password']) {
                $_SESSION['error'] = "Passwords do not match";
            } else {
                $this->staffModel->updatePassword($id, $_POST['new_password']);
                $_SESSION['message'] = "Password changed successfully.";
            }
            $this->redirect('staff');
        }

        $staff = $this->staffModel->find($id);
        if (!$staff) {
            $_SESSION['error'] = "Staff not found";
            $this->redirect('staff');
        }
        $this->view('staff/change_password', ['staff' => $staff]);
    }

    // Delete staff
    public function delete($id) {
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "You cannot delete your own account.";
        } else {
            $staff = $this->staffModel->find($id);
            if ($staff) {
                $this->staffModel->delete($id);
                $_SESSION['message'] = "Staff deleted.";
            } else {
                $_SESSION['error'] = "Staff not found.";
            }
        }
        $this->redirect('staff');
    }
}