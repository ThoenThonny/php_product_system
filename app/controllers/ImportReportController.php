<?php
require_once 'Controller.php';
require_once '../app/models/Import.php';

class ImportReportController extends Controller {
    private $importModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        $this->importModel = new Import();
    }

    // Same as ImportController@index – shows all imports
    public function index() {
        $imports = $this->importModel->getAll();
        $this->view('imports/index', ['imports' => $imports]);
    }
}