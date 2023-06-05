<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany jako administrator
if (!isset($_SESSION['user_id']) || !$_SESSION['username'] || $_SESSION['is_admin'] != 1) {
    header("Location: admin.html");
    exit();
}
?>
