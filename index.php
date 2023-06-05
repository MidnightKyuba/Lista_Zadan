<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strona główna</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Dodaj bibliotekę ikon Font Awesome -->
</head>
<body>
<header>
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

    <section class="hero">
        <div class="container-banner">
            <div class="hero-content">
                <h1>Lista Zadań</h1>
                <p>Zorganizuj swoje zadania i osiągnij sukces!</p>
                <?php if (isset($_SESSION['username'])) { ?>
                    <a href="lista_zadan.php" class="btn">Rozpocznij teraz</a>
                <?php } else { ?>
                    <a href="login.php" class="btn">Zaloguj się</a>
                <?php } ?>
            </div>
        </div>
    </section>

    <section class="content">
  <div class="container-main">
    <h2>Witaj na stronie głównej</h2>
    <div class="icons">
      <i class="fas fa-check"></i>
      <i class="fas fa-tasks"></i>
      <i class="fas fa-calendar"></i>
    </div>
    <div class="content-info">
      <div class="content-info-item">
        <i class="fas fa-check"></i>
        <h3>Zorganizuj swoje zadania</h3>
        <p>Tworzenie listy zadań pozwoli Ci na lepsze zorganizowanie swojego czasu i obowiązków. Niezapomniane zadania przestaną być problemem!</p>
      </div>
      <div class="content-info-item">
        <i class="fas fa-tasks"></i>
        <h3>Osiągnij sukces</h3>
        <p>Dzięki systematycznemu planowaniu i śledzeniu postępów, będziesz w stanie skutecznie realizować cele i osiągać sukcesy zarówno w pracy, jak i w życiu osobistym.</p>
      </div>
      <div class="content-info-item">
        <i class="fas fa-calendar"></i>
        <h3>Zaplanuj swój czas</h3>
        <p>Intuicyjne narzędzie do tworzenia harmonogramu pomoże Ci efektywnie zarządzać czasem. Łatwo zobaczysz, jakie zadania masz do wykonania i jakie masz wolne terminy.</p>
      </div>
    </div>
  </div>
</section>

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
