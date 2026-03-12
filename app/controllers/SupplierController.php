<?php
require_once 'Controller.php';
require_once '../app/models/Supplier.php';

class SupplierController extends Controller {
    private $supplierModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $suppliers = $this->supplierModel->getAll();
        $this->view('suppliers/index', ['suppliers' => $suppliers]);
    }

    public function add() {
        $this->view('suppliers/add');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('supplier');
        }
        $data = [
            'Supplier' => $_POST['Supplier'],
            'SupAdd' => $_POST['SupAdd'],
            'SupCon' => $_POST['SupCon'],
            'Status' => isset($_POST['Status']) ? 1 : 0
        ];
        if ($this->supplierModel->create($data)) {
            $_SESSION['message'] = 'Supplier added successfully.';
        } else {
            $_SESSION['error'] = 'Error adding supplier.';
        }
        $this->redirect('supplier');
    }

    public function edit($id) {
        $supplier = $this->supplierModel->find($id);
        if (!$supplier) {
            $_SESSION['error'] = 'Supplier not found.';
            $this->redirect('supplier');
        }
        $this->view('suppliers/edit', ['supplier' => $supplier]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('supplier');
        }
        $data = [
            'supID' => $id,
            'Supplier' => $_POST['Supplier'],
            'SupAdd' => $_POST['SupAdd'],
            'SupCon' => $_POST['SupCon'],
            'Status' => isset($_POST['Status']) ? 1 : 0
        ];
        if ($this->supplierModel->update($data)) {
            $_SESSION['message'] = 'Supplier updated successfully.';
        } else {
            $_SESSION['error'] = 'Error updating supplier.';
        }
        $this->redirect('supplier');
    }

    public function delete($id) {
        $supplier = $this->supplierModel->find($id);
        if ($supplier) {
            $this->supplierModel->delete($id);
            $_SESSION['message'] = 'Supplier deleted.';
        } else {
            $_SESSION['error'] = 'Supplier not found.';
        }
        $this->redirect('supplier');
    }
}