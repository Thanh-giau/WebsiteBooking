<?php
if (!defined('BASE_URL')) {
define('BASE_URL', '/WebsiteBooking/admin/');
}
$user_name = isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Nha Khoa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 56px; 
            background-color: #f8f9fa;
        }
        .main-content {
            margin-left: 220px; 
            padding-top: 70px;
        }
        .navbar {
            z-index: 1030;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Dashboard</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <span class="navbar-text text-white mr-3">
                    Chào, <?php echo $user_name; ?>
                </span>
            </li>
            <li class="nav-item">
                <a class="btn btn-danger" href="<?php echo BASE_URL; ?>logout.php">Đăng xuất</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">