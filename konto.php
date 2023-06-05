<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil użytkownika</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="container-menu">
        <div class="logo">
            <a href="index.php"><img src="logo.jpg"></a>
        </div>
        <nav>
            <ul class="menu">
                <li><a href="index.php"><i class="fas fa-home"></i> Strona Główna</a></li>
                <?php
                session_start();
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

    <div class="account-container">
        <h1><i class="fas fa-user"></i> Twoje konto</h1>

        <?php
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
            echo "<p>Nazwa użytkownika: $username</p>";

            // Połączenie z bazą danych
            $servername = "localhost";
            $db_username = "root";
            $db_password = "";
            $dbname = "listazadan";
            $conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

            // Sprawdzenie połączenia
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            // Pobranie informacji o użytkowniku z bazy danych
            $sql = "SELECT email, password, is_admin FROM users WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Wyświetlanie emaila i hasła
                $email = $row['email'];
                echo "<p>Email: $email</p>";

                $is_admin = $row['is_admin'];
                echo "<p>Jesteś " . ($is_admin ? "adminem" : "<b>UŻYTKOWNIKIEM</b>") . "</p>";
            }

            mysqli_close($conn);
        } else {
            echo "<p>Nie jesteś zalogowany.</p>";
        }
        ?>

        <form class="logout" action="logout.php" method="post">
            <button class="btn-logout" type="submit"><i class="fas fa-sign-out-alt"></i> Wyloguj się</button>
        </form>

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