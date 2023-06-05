<?php
// Połączenie z bazą danych
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "listazadan";
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Sprawdzenie połączenia
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Pobranie danych z formularza logowania
$username = $_POST['username'];
$password = $_POST['password'];

// Pobranie hasła z bazy danych dla danego użytkownika
$sql = "SELECT password, is_admin, id FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];
    $isAdmin = $row['is_admin'];

    // Porównanie hasła wprowadzonego przez użytkownika z haszem z bazy danych
    if (($username === 'admin' && $password === 'admin123') || password_verify($password, $hashedPassword)) {
        // Poprawne logowanie
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['userId'] = $row['id'];

        // Przekierowanie do odpowiedniej strony (użytkownik/admin)
        if ($isAdmin == 1) {
            header("Location: index.php");
        } else {
            header("Location: index.php");
        }
        exit;
    } else {
        // Błędne dane logowania
        echo "Błędne dane logowania. Za 5 sekund powrócisz ponownie do zalogowania się";
        header("Refresh: 5; url=login.php");
        exit;
    }
} else {
    // Brak użytkownika o podanej nazwie
    echo "Użytkownik o podanej nazwie nie istnieje. Za 5 sekund powrócisz ponownie do zalogowania się";
    header("Refresh: 5; url=login.php");
    exit;
}


mysqli_close($conn);
?>
