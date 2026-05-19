<?php
require_once 'Controller.php';
require_once '../app/models/Order.php';
require_once '../app/models/OrderDetail.php';
require_once '../app/models/Customer.php';
require_once '../app/models/Product.php';
require_once '../app/models/Payment.php';

class OrderController extends Controller {
    private $orderModel;
    private $orderDetailModel;
    private $customerModel;
    private $productModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('auth/login');
        }
        $this->orderModel = new Order();
        $this->orderDetailModel = new OrderDetail();
        $this->customerModel = new Customer();
        $this->productModel = new Product();
    }

    public function index() {
        try {
            $orders = $this->orderModel->getAll();
            $this->view('orders/index', ['orders' => $orders, 'activePage' => 'order']);
        } catch (Exception $e) {
            die("Error in OrderController@index: " . $e->getMessage());
        }
    }

    public function add() {
        try {
            $customers = $this->customerModel->getActive();
            $products = $this->productModel->getAll();
            $this->view('orders/add', ['customers' => $customers, 'products' => $products, 'activePage' => 'order']);
        } catch (Exception $e) {
            die("Error in OrderController@add: " . $e->getMessage());
        }
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('order');
        }

        try {
            // Get customer name
            $customer = $this->customerModel->find($_POST['cusID']);
            $cusName = $customer ? $customer['CusName'] : '';

            // Create order
            $orderData = [
                'stID' => $_SESSION['user_id'],
                'FullName' => $_SESSION['user_name'],
                'cusID' => $_POST['cusID'],
                'cusName' => $cusName,
                'Total' => 0
            ];
            $orderId = $this->orderModel->create($orderData);

            // Add order details
            $proIds = $_POST['proId'];
            $quantities = $_POST['quantity'];
            $prices = $_POST['price'];
            $total = 0;

            for ($i = 0; $i < count($proIds); $i++) {
                if (!empty($proIds[$i]) && $quantities[$i] > 0) {
                    $this->orderDetailModel->addItem($orderId, $proIds[$i], $quantities[$i], $prices[$i]);
                    $total += $quantities[$i] * $prices[$i];
                }
            }

            // Update order total
            $this->orderModel->updateTotal($orderId, $total);

            $_SESSION['message'] = 'Order created successfully.';
            $this->redirect('order/view_order/' . $orderId);
        } catch (Exception $e) {
            die("Error in OrderController@store: " . $e->getMessage());
        }
    }

    public function view_order($id) {
        try {
            $order = $this->orderModel->find($id);
            if (!$order) {
                $_SESSION['error'] = 'Order not found.';
                $this->redirect('order');
            }
            $details = $this->orderDetailModel->getByOrder($id);
            $paymentModel = new Payment();
            $payments = $paymentModel->getByOrder($id);
            $this->view('orders/view', [
                'order' => $order,
                'details' => $details,
                'payments' => $payments,
                'activePage' => 'order'
            ]);
        } catch (Exception $e) {
            die("Error in OrderController@view: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $order = $this->orderModel->find($id);
            if ($order) {
                $this->orderModel->delete($id);
                $_SESSION['message'] = 'Order deleted.';
            } else {
                $_SESSION['error'] = 'Order not found.';
            }
            $this->redirect('order');
        } catch (Exception $e) {
            die("Error in OrderController@delete: " . $e->getMessage());
        }
    }
}