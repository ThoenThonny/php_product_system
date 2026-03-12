<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
        }
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
            height: 100vh;
            position: sticky;
            top: 0;
        }
        #sidebar.active {
            margin-left: -250px;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: #2c3136;
            text-align: center;
            border-bottom: 1px solid #4b545c;
        }
        #sidebar .sidebar-header h3 {
            color: #fff;
            margin: 0;
            font-size: 1.5rem;
        }
        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #4b545c;
        }
        #sidebar ul li a {
            padding: 10px 20px;
            font-size: 1.1em;
            display: block;
            color: #d3d3d3;
            text-decoration: none;
            transition: 0.3s;
        }
        #sidebar ul li a:hover {
            color: #fff;
            background: #2c3136;
        }
        #sidebar ul li.active > a {
            color: #fff;
            background: #007bff;
        }
        #sidebar .user-info {
            padding: 15px 20px;
            background: #2c3136;
            font-size: 0.9em;
            border-top: 1px solid #4b545c;
        }
        #sidebar .user-info a {
            color: #ffc107;
            text-decoration: none;
        }
        #sidebar .user-info a:hover {
            text-decoration: underline;
        }
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #sidebarCollapse {
                display: block;
            }
        }
        #sidebarCollapse {
            display: none;
            background: #343a40;
            color: #fff;
            border: none;
            padding: 10px 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        @media (max-width: 768px) {
            #sidebarCollapse {
                display: inline-block;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Product Mgt</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="<?= (isset($activePage) && $activePage == 'product') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>product">Products</a>
                </li>
                <li class="<?= (isset($activePage) && $activePage == 'supplier') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>supplier">Suppliers</a>
                </li>
                <li class="<?= (isset($activePage) && $activePage == 'customer') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>customer">Customers</a>
                </li>
                <li class="<?= (isset($activePage) && $activePage == 'order') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>order">Orders</a>
                </li>
                <li class="<?= (isset($activePage) && $activePage == 'payment') ? 'active' : '' ?>">
                    <a href="<?= BASE_URL ?>payment">Payments</a>
                </li>
            </ul>

            <div class="user-info">
                <div>Welcome, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Guest') ?></strong></div>
                <a href="<?= BASE_URL ?>auth/logout" class="btn btn-sm btn-outline-warning mt-2">Logout</a>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <button type="button" id="sidebarCollapse" class="btn btn-dark">
                ☰ Toggle Sidebar
            </button>

            <!-- Alert messages -->
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>