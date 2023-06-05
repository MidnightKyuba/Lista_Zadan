<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>Rejestracja</title>
</head>

<body>
    <?php
    session_start();
    // Sprawdzenie, czy użytkownik jest już zalogowany
    if (isset($_SESSION['username'])) {
        // Użytkownik jest już zalogowany, przekierowanie na odpowiednią stronę
        if ($_SESSION['is_admin']) {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit;
    }
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
    <h2>Rejestracja</h2>
    <form action="register_process.php" method="POST">
        <div class="form-group">
            <label for="username">Nazwa użytkownika:</label>
            <input class="login-register" type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Adres e-mail:</label>
            <input class="login-register" type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Hasło:</label>
            <input class="login-register" type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Potwierdź hasło:</label>
            <input class="login-register" type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit">Zarejestruj</button>
    </form>
    <p>Posiadasz już konto? <a href="login.php">Zaloguj się</a></p>
</div>

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

    <script src="script.js"></script>
</body>

</html>