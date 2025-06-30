<?php
session_start(); // Bắt đầu session

// Hủy tất cả các biến session
$_SESSION = array();

// Nếu muốn hủy session hoàn toàn, hãy xóa cả cookie session.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Cuối cùng, hủy session
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit();
?>