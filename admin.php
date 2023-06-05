<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Administracyjny</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Dodaj bibliotekę ikon Font Awesome -->
</head>
<body>
<?php
// Plik admin.php

session_start();

// Sprawdzenie, czy użytkownik jest zalogowany jako admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit;
}

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

// Obsługa dodawania użytkownika
if (isset($_POST['add_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Haszowanie hasła
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Dodaj użytkownika do bazy danych
    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$hashedPassword', '$email')";
    mysqli_query($conn, $sql);

    // Przekierowanie po dodaniu użytkownika
    header("Location: admin.php");
    exit;
}

// Obsługa edycji użytkownika
if (isset($_POST['edit_user'])) {
    $user_id = $_POST['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Pobierz obecny adres e-mail użytkownika
    $sql = "SELECT email FROM users WHERE id = $user_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $currentEmail = $row['email'];

    // Zaktualizuj dane użytkownika w bazie danych
    $sql = "UPDATE users SET username = '$username'";

    // Sprawdź, czy adres e-mail ma zostać zaktualizowany
    if (!empty($email)) {
        $sql .= ", email = '$email'";
    } else {
        $sql .= ", email = '$currentEmail'";
    }

    $sql .= " WHERE id = $user_id";

    mysqli_query($conn, $sql);
}

// Obsługa usuwania użytkownika
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];

    // Usuń użytkownika z bazy danych
    $sql = "DELETE FROM users WHERE id = $user_id";
    mysqli_query($conn, $sql);
}

// Obsługa dodawania grupy
if (isset($_POST['add_group'])) {
    $group_name = $_POST['group_name'];
    $group_description = $_POST['group_description'];

    // Dodawanie grupy do bazy danych
    $sql = "INSERT INTO groups (name, description) VALUES ('$group_name', '$group_description')";
    mysqli_query($conn, $sql);
}

// Obsługa dodawania użytkownika do grupy
if (isset($_POST['add_user_to_group'])) {
    $groupId = $_POST['group_for_user_id'];
    $userId = $_POST['user_for_group_id'];

    $sql = "SELECT * FROM usersgroups WHERE groupId=$groupId AND userId = $userId";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) === 0){
        // Dodawanie użytkownika do grupy w bazie danych
        $sql2 = "INSERT INTO usersgroups (groupId, userId) VALUES ($groupId, $userId)";
        mysqli_query($conn, $sql2); 
    }
}

// Pobierz listę użytkowników z bazy danych
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);

?>
<header>
    <div class="container-menu">
        <div class="logo">
            <a href="index.php"><img src="logo.jpg"></a>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="index.php"><i class="fas fa-home"></i> Strona Główna</a></li>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li><a href="lista_zadan.php"><i class="fas fa-tasks"></i> Lista Zadań</a></li>';
                    if ($_SESSION['username'] === 'admin') {
                        echo '<li><a href="admin.php"><i class="fas fa-cogs"></i> Panel Administracyjny</a></li>';
                        echo '<li><a href="profil.php"><i class="fas fa-user-shield"></i> Admin</a></li>';
                    } else {
                        echo '<li><a href="konto.php"><i class="fas fa-user"></i> ' . $_SESSION['username'] . '</a></li>';
                    }
                } else {
                    echo '<li><a href="login.php"><i class="fas fa-user"></i> Konto</a></li>';
                }
                ?>
            </ul>
        </nav>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>
<div class="container">
    <h1 class="title-h1">Panel Administracyjny</h1>

    <h2 class="title-h2">Dodaj użytkownika</h2>
    <form action="admin.php" method="POST">
        <input class="add-user" type="text" name="username" placeholder="Nazwa użytkownika" required>
        <input class="add-user" type="password" name="password" placeholder="Hasło" required>
        <input class="add-user" type="email" name="email" placeholder="Adres e-mail" required>
        <button class="btn" type="submit" name="add_user">Dodaj użytkownika</button>
    </form>

    <h2 class="title-h2">Edytuj użytkownika</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nazwa użytkownika</th>
            <th>Adres e-mail</th>
            <th>Akcje</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                    <form action="admin.php" method="POST">
                        <input class="edit-user" type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                        <td><input class="edit-user" type="text" name="username" value="<?php echo $row['username']; ?>" required></td>
                        <td><input class="edit-user" type="email" name="email" value="<?php echo $row['email']; ?>"></td>
                        <td>
                            <button class="edit" type="submit" name="edit_user">Edytuj</button>
                            <button class="delete" type="submit" name="delete_user">Usuń</button>
                        </td>
                    </form>
            </tr>
        <?php } ?>
    </table>
    <h2 class="title-h2">Dodaj grupę</h2>
    <form action="admin.php" method="POST">
        <label>Nazwa grupy</label>
        <input class="add-user" type="text" name="group_name">
        <label>Opis grupy</label>
        <input class="add-user" type="text" name="group_description">
        <button class="btn" type="submit" name="add_group">Dodaj</button>
    </form>
    <?php 
        $sql2 = "SELECT id, name FROM groups";
        $result2 = mysqli_query($conn,$sql2);
    ?>
    <h2 class="title-h2">Dodaj użytkownika do grupy</h2>
    <form action="admin.php" method="POST">
        <select name="group_for_user_id">
            <?php while ($row2 = mysqli_fetch_assoc($result2)) { ?>
                <option value="<?php echo $row2['id']?>"><?php echo $row2['name']?></option>
            <?php } ?>
        </select>
        <select name="user_for_group_id">
            <?php
                $sql3 = "SELECT id, username FROM users";
                $result3 = mysqli_query($conn,$sql3);
                while ($row3 = mysqli_fetch_assoc($result3)) { ?>
                <option value="<?php echo $row3['id']?>"><?php echo $row3['username']?></option>
            <?php } ?>
        </select>
        <button class="btn" type="submit" name="add_user_to_group">Dodaj</button>
    </form>
</div>
</body>
</html>

<?php
// Zamknięcie połączenia z bazą danych
mysqli_close($conn);
?>
<footer>
    <div class="container-footer">
        <div class="footer-content">
        <div class="footer-info">
            <h3>Lista Zadań</h3>
            <p>Zorganizuj swoje zadania i osiągnij sukces!</p>
            <p>Twórz listy zadań, śledź postępy i efektywnie zarządzaj czasem.</p>
            <p>Kontakt: info@przykladowa-strona-zadan.pl</p>
            <p>Telefon: 123-456-789</p>
        </div>
        <div class="footer-icons">
            <a href="https://www.facebook.com"><i class="fab fa-facebook"></i></a>
            <a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a>
            <a href="https://www.linkedin.com"><i class="fab fa-linkedin"></i></a>
            <a href="https://www.youtube.com"><i class="fab fa-youtube"></i></a>
        </div>
        </div>
    </div>
</footer>

    <div class="container-footer">
        <p>Strona "Lista Zadań" Eliza Kozieł, Jakub Lewandowski, Jakub Kittel, Hubert Hejnowicz &copy; 2023</p>
    </div>

    <script src="script.js"></script> <!-- Dodaj plik JavaScript -->
</body>
</html>
