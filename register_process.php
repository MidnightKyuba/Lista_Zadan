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

// Pobranie danych z formularza rejestracji
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirmPassword = $_POST['confirm_password'];

// Sprawdzenie, czy użytkownik o podanej nazwie już istnieje
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // Użytkownik już istnieje
    echo "Użytkownik o podanej nazwie już istnieje. Za 5 sekundy przeniesie Cię znów do rejestracji";
    header("Refresh: 5; url=register.php");
    exit;
} else {
    // Sprawdzenie, czy hasła się zgadzają
    if ($password !== $confirmPassword) {
        // Wyświetl komunikat o niezgodności haseł
        echo "Hasła nie są identyczne. Za 5 sekundy przeniesie Cię znów do rejestracji";
        header("Refresh: 5; url=register.php");
        exit;
    } elseif (strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/\d/", $password)) {
        // Wyświetl komunikat o nieprawidłowym formacie hasła
        echo "Hasło musi mieć co najmniej 8 znaków i zawierać co najmniej jedną wielką literę i jedną cyfrę. Za 5 sekundy przeniesie Cię znów do rejestracji";
        header("Refresh: 5; url=register.php");
        exit;
    } else {
        // Haszowanie hasła admina
        if ($username === 'admin') {
            $hashedPassword = $password; // Tu podaj zahaszowane hasło admina
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Haszowanie hasła dla innych użytkowników
        }

        // Haszowanie hasła dla potwierdzenia
        $hashedConfirmPassword = password_hash($confirmPassword, PASSWORD_DEFAULT);

        // Dodanie nowego użytkownika do bazy danych
        $sql = "INSERT INTO users (username, email, password, confirm_password, is_admin) VALUES ('$username', '$email', '$hashedPassword', '$hashedConfirmPassword', 0)";

        if (mysqli_query($conn, $sql)) {
            // Rejestracja udana
            echo "Rejestracja udana. Możesz się teraz zalogować.";
            header("Location: login.php"); // Przekierowanie do strony logowania
            exit; // Zakończenie działania skryptu
        } else {
            // Błąd rejestracji
            echo "Błąd rejestracji: " . mysqli_error($conn);
        }
    }
}

mysqli_close($conn);
?>
