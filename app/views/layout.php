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
        }

        #sidebar ul li a:hover {
            color: #fff;
            background: #2c3136;
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

        .no-sidebar .wrapper {
            display: block;
        }

        .no-sidebar #content {
            width: 100%;
            margin-left: 0;
        }
    </style>
</head>

<body class="<?= isset($hideSidebar) && $hideSidebar ? 'no-sidebar' : '' ?>">
    <div class="wrapper">
        <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
            <nav id="sidebar">
                <div class="sidebar-header">
                    <h3>Product Mgt</h3>
                </div>
                <ul class="list-unstyled components">
                    <li><a href="<?= BASE_URL ?>dashboard">Dashboard</a></li>
                    <li><a href="<?= BASE_URL ?>staff">Staff</a></li>
                    <li><a href="<?= BASE_URL ?>product">Products</a></li>
                    <li><a href="<?= BASE_URL ?>supplier">Suppliers</a></li>
                    <li><a href="<?= BASE_URL ?>customer">Customers</a></li>
                    <li><a href="<?= BASE_URL ?>order">Sale</a></li>
                    <li><a href="<?= BASE_URL ?>import">Import Report</a></li>
                    <li><a href="<?= BASE_URL ?>payment">Payments</a></li>
                </ul>
                <div class="user-info">
                    <div>Welcome, <strong><?= htmlspecialchars($_SESSION['user_name'] ?? 'Guest') ?></strong></div>
                    <a href="<?= BASE_URL ?>auth/logout" class="btn btn-sm btn-outline-warning mt-2">Logout</a>
                </div>
            </nav>
        <?php endif; ?>

        <div id="content">
            <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
                <button type="button" id="sidebarCollapse" class="btn btn-dark">☰ Toggle Sidebar</button>
            <?php endif; ?>

            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success"><?= $_SESSION['message'];
                                                    unset($_SESSION['message']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= $_SESSION['error'];
                                                unset($_SESSION['error']); ?></div>
            <?php endif; ?>

            <?php include $viewFile; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php if (!isset($hideSidebar) || !$hideSidebar): ?>
        <script>
            document.getElementById('sidebarCollapse')?.addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('active');
            });
        </script>
    <?php endif; ?>
</body>

</html>