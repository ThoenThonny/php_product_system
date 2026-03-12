<?php
require_once 'Controller.php';
require_once '../app/models/Payment.php';
require_once '../app/models/Order.php';

class PaymentController extends Controller {
    private $paymentModel;
    private $orderModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        $this->paymentModel = new Payment();
        $this->orderModel = new Order();
    }

    public function index() {
        $payments = $this->paymentModel->getAll();
        $this->view('payments/index', ['payments' => $payments]);
    }

    public function add() {
        $orders = $this->orderModel->getAll();
        $this->view('payments/add', ['orders' => $orders]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('payment');
        }

        // Generate a unique PayCode
        $payCode = 'PAY' . time() . rand(100, 999);

        $data = [
            'PayCode' => $payCode,
            'stID' => $_SESSION['user_id'],
            'FullName' => $_SESSION['user_name'],
            'OrID' => $_POST['OrID'],
            'Amount' => $_POST['Amount']
        ];

        if ($this->paymentModel->create($data)) {
            $_SESSION['message'] = 'Payment recorded successfully.';
        } else {
            $_SESSION['error'] = 'Error recording payment.';
        }
        $this->redirect('payment');
    }

    public function delete($payCode) {
        $payment = $this->paymentModel->find($payCode);
        if ($payment) {
            $this->paymentModel->delete($payCode);
            $_SESSION['message'] = 'Payment deleted.';
        } else {
            $_SESSION['error'] = 'Payment not found.';
        }
        $this->redirect('payment');
    }
}