<?php
require_once 'Controller.php';
require_once '../app/models/Import.php';
require_once '../app/models/ImportDetail.php';
require_once '../app/models/Supplier.php';
require_once '../app/models/Product.php';

class ImportController extends Controller {
    private $importModel;
    private $importDetailModel;
    private $supplierModel;
    private $productModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) $this->redirect('auth/login');
        $this->importModel = new Import();
        $this->importDetailModel = new ImportDetail();
        $this->supplierModel = new Supplier();
        $this->productModel = new Product();
    }

    // List all imports (Import Report)
    public function index() {
        $imports = $this->importModel->getAll();
        $this->view('imports/index', ['imports' => $imports]);
    }

    // Show form to create new import
    public function add() {
        $suppliers = $this->supplierModel->getActive();
        $products = $this->productModel->getAll();
        $this->view('imports/add', ['suppliers' => $suppliers, 'products' => $products]);
    }

    // Store new import and update product stock
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect('import');

        $importCode = 'IMP-' . date('Ymd') . '-' . rand(100, 999);
        $supID = $_POST['supID'];
        $notes = $_POST['Notes'] ?? '';

        // Start transaction
        global $pdo;
        $pdo->beginTransaction();
        try {
            // 1. Create import record (total 0 for now)
            $importData = [
                'ImportCode' => $importCode,
                'supID' => $supID,
                'stID' => $_SESSION['user_id'],
                'TotalAmount' => 0,
                'Notes' => $notes
            ];
            $this->importModel->create($importData);
            $importId = $pdo->lastInsertId();

            // 2. Add details and accumulate total
            $proIds = $_POST['proId'];
            $quantities = $_POST['quantity'];
            $costPrices = $_POST['costPrice'];
            $total = 0;

            for ($i = 0; $i < count($proIds); $i++) {
                if (!empty($proIds[$i]) && $quantities[$i] > 0) {
                    $this->importDetailModel->addItem($importId, $proIds[$i], $quantities[$i], $costPrices[$i]);
                    $sub = $quantities[$i] * $costPrices[$i];
                    $total += $sub;

                    // Update product quantity (add stock)
                    $stmt = $pdo->prepare("UPDATE tbProducts SET Qty = Qty + ? WHERE ProID = ?");
                    $stmt->execute([$quantities[$i], $proIds[$i]]);
                }
            }

            // 3. Update total amount in import
            $this->importModel->updateTotal($importId, $total);

            $pdo->commit();
            $_SESSION['message'] = "Import saved and stock updated.";
            $this->redirect('import');
        } catch (Exception $e) {
            $pdo->rollBack();
            $_SESSION['error'] = "Import failed: " . $e->getMessage();
            $this->redirect('import/add');
        }
    }

    // View single import details
    public function view_import_details($id) {
        $import = $this->importModel->find($id);
        if (!$import) {
            $_SESSION['error'] = "Import not found";
            $this->redirect('import');
        }
        $details = $this->importDetailModel->getByImport($id);
        $this->view('imports/view', ['import' => $import, 'details' => $details]);
    }

    // Delete import (and reverse stock? Usually not allowed. We'll just delete without stock rollback)
    public function delete($id) {
        $import = $this->importModel->find($id);
        if ($import) {
            $this->importModel->delete($id);
            $_SESSION['message'] = "Import deleted. Stock was not reversed – adjust manually if needed.";
        } else {
            $_SESSION['error'] = "Import not found";
        }
        $this->redirect('import');
    }
}