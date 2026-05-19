<?php
require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/User.php';

class AuthController extends Controller {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userModel = new User();
            $user = $userModel->findByUsername($_POST['username']);
            if ($user && password_verify($_POST['password'], $user['PasswordHash'])) {
                $_SESSION['user_id'] = $user['stID'];
                $_SESSION['user_name'] = $user['FullName'];
                $this->redirect('product');
            } else {
                $_SESSION['error'] = 'Invalid username or password';
                $this->redirect('auth/login');
            }
        } else {
            // Hide sidebar on login page
            $this->view('auth/login', ['hideSidebar' => true]);
        }
    }

    public function logout() {
        session_destroy();
        $this->redirect('auth/login');
    }

    public function register() {
        // Hide sidebar on registration page
        $this->view('auth/register', ['hideSidebar' => true]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('auth/register');
        }

        $errors = [];
        if (empty($_POST['FullName'])) $errors[] = "Full name is required";
        if (empty($_POST['Username'])) $errors[] = "Username is required";
        if (empty($_POST['Password'])) $errors[] = "Password is required";
        if ($_POST['Password'] !== $_POST['ConfirmPassword']) $errors[] = "Passwords do not match";

        $userModel = new User();
        if ($userModel->findByUsername($_POST['Username'])) {
            $errors[] = "Username already taken";
        }

        if (!empty($errors)) {
            $_SESSION['error'] = implode('<br>', $errors);
            $this->redirect('auth/register');
        }

        $data = [
            'FullName' => $_POST['FullName'],
            'Gen' => $_POST['Gen'] ?? 'Other',
            'Dob' => !empty($_POST['Dob']) ? $_POST['Dob'] : null,
            'Position' => $_POST['Position'] ?? 'Staff',
            'Salary' => !empty($_POST['Salary']) ? $_POST['Salary'] : 0,
            'Stopwork' => 0,
            'Username' => $_POST['Username'],
            'PasswordHash' => password_hash($_POST['Password'], PASSWORD_DEFAULT)
        ];

        if ($userModel->create($data)) {
            $_SESSION['message'] = 'Registration successful. Please login.';
            $this->redirect('auth/login');
        } else {
            $_SESSION['error'] = 'Registration failed. Please try again.';
            $this->redirect('auth/register');
        }
    }
}