<?php
require_once 'Controller.php';
require_once '../app/models/Customer.php';

class CustomerController extends Controller {
    private $customerModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        $this->customerModel = new Customer();
    }

    public function index() {
        $customers = $this->customerModel->getAll();
        $this->view('customers/index', ['customers' => $customers]);
    }

    public function add() {
        $this->view('customers/add');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer');
        }
        $data = [
            'CusName' => $_POST['CusName'],
            'CusContact' => $_POST['CusContact'],
            'Status' => isset($_POST['Status']) ? 1 : 0
        ];
        if ($this->customerModel->create($data)) {
            $_SESSION['message'] = 'Customer added successfully.';
        } else {
            $_SESSION['error'] = 'Error adding customer.';
        }
        $this->redirect('customer');
    }

    public function edit($id) {
        $customer = $this->customerModel->find($id);
        if (!$customer) {
            $_SESSION['error'] = 'Customer not found.';
            $this->redirect('customer');
        }
        $this->view('customers/edit', ['customer' => $customer]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('customer');
        }
        $data = [
            'cusID' => $id,
            'CusName' => $_POST['CusName'],
            'CusContact' => $_POST['CusContact'],
            'Status' => isset($_POST['Status']) ? 1 : 0
        ];
        if ($this->customerModel->update($data)) {
            $_SESSION['message'] = 'Customer updated successfully.';
        } else {
            $_SESSION['error'] = 'Error updating customer.';
        }
        $this->redirect('customer');
    }

    public function delete($id) {
        $customer = $this->customerModel->find($id);
        if ($customer) {
            $this->customerModel->delete($id);
            $_SESSION['message'] = 'Customer deleted.';
        } else {
            $_SESSION['error'] = 'Customer not found.';
        }
        $this->redirect('customer');
    }
}