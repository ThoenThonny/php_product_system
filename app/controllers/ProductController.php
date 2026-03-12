<?php
require_once 'Controller.php';
require_once '../app/models/Product.php';
require_once '../app/models/Supplier.php';

class ProductController extends Controller {
    private $productModel;
    private $supplierModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        $this->productModel = new Product();
        $this->supplierModel = new Supplier();
    }

    public function index() {
        $products = $this->productModel->getAll();
        $this->view('products/index', ['products' => $products]);
    }

    public function add() {
        $suppliers = $this->supplierModel->getActive();
        $this->view('products/add', ['suppliers' => $suppliers]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('product');
        }

        $data = [
            'ProCode' => $_POST['ProCode'],
            'ProName' => $_POST['ProName'],
            'Qty' => $_POST['Qty'],
            'UPIS' => $_POST['UPIS'],
            'SUP' => $_POST['SUP'],
            'Status' => isset($_POST['Status']) ? 1 : 0,
            'supID' => !empty($_POST['supID']) ? $_POST['supID'] : null,
            'ProductImage' => null
        ];

        // Handle file upload
        if (isset($_FILES['ProductImage']) && $_FILES['ProductImage']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['ProductImage']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $imageName = uniqid() . '.' . $ext;
                $uploadPath = 'assets/uploads/' . $imageName;
                if (move_uploaded_file($_FILES['ProductImage']['tmp_name'], '../public/' . $uploadPath)) {
                    $data['ProductImage'] = $imageName;
                } else {
                    $_SESSION['error'] = 'Failed to upload image.';
                }
            } else {
                $_SESSION['error'] = 'Invalid file type. Only JPG, PNG, GIF allowed.';
            }
        }

        if ($this->productModel->create($data)) {
            $_SESSION['message'] = 'Product added successfully.';
            $this->redirect('product');
        } else {
            $_SESSION['error'] = 'Error adding product.';
            $this->redirect('product/add');
        }
    }

    public function edit($id) {
        $product = $this->productModel->find($id);
        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            $this->redirect('product');
        }
        $suppliers = $this->supplierModel->getActive();
        $this->view('products/edit', ['product' => $product, 'suppliers' => $suppliers]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('product');
        }

        $product = $this->productModel->find($id);
        if (!$product) {
            $_SESSION['error'] = 'Product not found.';
            $this->redirect('product');
        }

        $data = [
            'ProID' => $id,
            'ProCode' => $_POST['ProCode'],
            'ProName' => $_POST['ProName'],
            'Qty' => $_POST['Qty'],
            'UPIS' => $_POST['UPIS'],
            'SUP' => $_POST['SUP'],
            'Status' => isset($_POST['Status']) ? 1 : 0,
            'supID' => !empty($_POST['supID']) ? $_POST['supID'] : null,
            'ProductImage' => $product['ProductImage']
        ];

        // Handle new image upload
        if (isset($_FILES['ProductImage']) && $_FILES['ProductImage']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $ext = strtolower(pathinfo($_FILES['ProductImage']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                if ($product['ProductImage']) {
                    $oldFile = '../public/assets/uploads/' . $product['ProductImage'];
                    if (file_exists($oldFile)) unlink($oldFile);
                }
                $imageName = uniqid() . '.' . $ext;
                $uploadPath = 'assets/uploads/' . $imageName;
                if (move_uploaded_file($_FILES['ProductImage']['tmp_name'], '../public/' . $uploadPath)) {
                    $data['ProductImage'] = $imageName;
                } else {
                    $_SESSION['error'] = 'Failed to upload new image.';
                }
            } else {
                $_SESSION['error'] = 'Invalid file type.';
            }
        }

        if ($this->productModel->update($data)) {
            $_SESSION['message'] = 'Product updated successfully.';
            $this->redirect('product');
        } else {
            $_SESSION['error'] = 'Error updating product.';
            $this->redirect('product/edit/' . $id);
        }
    }

    public function delete($id) {
        $product = $this->productModel->find($id);
        if ($product) {
            if ($product['ProductImage']) {
                $file = '../public/assets/uploads/' . $product['ProductImage'];
                if (file_exists($file)) unlink($file);
            }
            $this->productModel->delete($id);
            $_SESSION['message'] = 'Product deleted.';
        } else {
            $_SESSION['error'] = 'Product not found.';
        }
        $this->redirect('product');
    }

   
}