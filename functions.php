<?php
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['admin']);
}

function redirectIfNotLoggedIn($role) {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== $role) {
        header("Location: login.php");
        exit;
    }
}

function sanitize($input) {
    return htmlspecialchars(trim($input));
}
?>
