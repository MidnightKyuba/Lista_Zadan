<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['user_id']) || !$_SESSION['username']) {
    header("Location: user.html");
    exit();
}

// Wyświetlenie listy zadań dla użytkownika
echo "Lista Zadań";
?>
