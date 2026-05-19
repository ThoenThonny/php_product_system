<?php
require_once 'Controller.php';

class DashboardController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['user_id'])) $this->redirect('auth/login');
    }

    public function index() {
        global $pdo;

        // ==================== Core Stats ====================
        $totalProducts = $pdo->query("SELECT COUNT(*) FROM tbProducts")->fetchColumn();
        $totalCustomers = $pdo->query("SELECT COUNT(*) FROM tbCustomers")->fetchColumn();
        $totalSuppliers = $pdo->query("SELECT COUNT(*) FROM tbSuppliers")->fetchColumn();
        $totalSales = $pdo->query("SELECT COALESCE(SUM(Total),0) FROM tbOrders")->fetchColumn();
        $totalPayments = $pdo->query("SELECT COALESCE(SUM(Amount),0) FROM tbPayments")->fetchColumn();
        $pendingBalance = $totalSales - $totalPayments;

        // ==================== Today's Stats ====================
        $today = date('Y-m-d');
        $todaySales = $pdo->prepare("SELECT COALESCE(SUM(Total),0) FROM tbOrders WHERE DATE(OrdDate) = ?");
        $todaySales->execute([$today]);
        $todaySalesAmount = $todaySales->fetchColumn();

        $todayOrders = $pdo->prepare("SELECT COUNT(*) FROM tbOrders WHERE DATE(OrdDate) = ?");
        $todayOrders->execute([$today]);
        $todayOrdersCount = $todayOrders->fetchColumn();

        // ==================== Monthly Sales (last 6 months) ====================
        $monthlySales = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = date('Y-m', strtotime("-$i months"));
            $monthName = date('M Y', strtotime("-$i months"));
            $stmt = $pdo->prepare("SELECT COALESCE(SUM(Total),0) FROM tbOrders WHERE DATE_FORMAT(OrdDate, '%Y-%m') = ?");
            $stmt->execute([$month]);
            $monthlySales[] = ['month' => $monthName, 'total' => (float)$stmt->fetchColumn()];
        }

        // ==================== Low Stock (Qty < 10) ====================
        $lowStock = $pdo->query("
            SELECT ProName, Qty, MinStock 
            FROM tbProducts 
            WHERE Qty <= IF(MinStock > 0, MinStock, 10)
            ORDER BY Qty ASC LIMIT 10
        ")->fetchAll();

        // ==================== Recent Orders (last 5) ====================
        $recentOrders = $pdo->query("
            SELECT OrID, OrdDate, cusName, Total 
            FROM tbOrders ORDER BY OrdDate DESC LIMIT 5
        ")->fetchAll();

        // ==================== Recent Imports (last 5) ====================
        $recentImports = $pdo->query("
            SELECT ImportCode, ImportDate, TotalAmount 
            FROM tbImports ORDER BY ImportDate DESC LIMIT 5
        ")->fetchAll();

        // ==================== Top 5 Selling Products ====================
        $topProducts = $pdo->query("
            SELECT p.ProName, SUM(od.Quantity) as total_sold
            FROM tbOrderDetails od
            JOIN tbProducts p ON od.ProID = p.ProID
            GROUP BY od.ProID
            ORDER BY total_sold DESC LIMIT 5
        ")->fetchAll();

        // ==================== Recent Activities (combine orders & imports) ====================
        $recentActivities = $pdo->query("
            (SELECT 'order' as type, OrID as id, OrdDate as date, CONCAT('Order #', OrID, ' by ', cusName) as description
             FROM tbOrders)
            UNION
            (SELECT 'import' as type, ImportID as id, ImportDate as date, CONCAT('Import ', ImportCode) as description
             FROM tbImports)
            ORDER BY date DESC LIMIT 8
        ")->fetchAll();

        $this->view('dashboard/index', compact(
            'totalProducts', 'totalCustomers', 'totalSuppliers', 'totalSales', 'totalPayments', 'pendingBalance',
            'todaySalesAmount', 'todayOrdersCount', 'monthlySales', 'lowStock', 'recentOrders', 'recentImports',
            'topProducts', 'recentActivities'
        ));
    }
}