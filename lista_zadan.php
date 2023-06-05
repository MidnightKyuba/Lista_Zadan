<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Zadań</title>
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

<main>
    <a href="dodaj_zadanie.php"><button class="btn">Dodaj nowe zadanie</button></a>
    <?php
        if (isset($_SESSION['username'])) {
            $userid = $_SESSION['userId'];

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

            if (isset($_POST['edit_task'])) {
                $id = $_POST['task_id'];
                $title = $_POST['task_title'];
                $description = $_POST['task_description'];
                $endDate = $_POST['task_date'];
                $priorityLevel = $_POST['task_priorityLevel'];
            
                // Edycja zadania w bazie danych
                $sql = "UPDATE tasks SET title='$title', description='$description', endDate='$endDate', priorityLevel=$priorityLevel WHERE id=$id";
                mysqli_query($conn, $sql);
            }

            if (isset($_POST['delete_task'])) {
                $id = $_POST['task_id'];
            
                // Usunięcie zadania w bazie danych
                $sql = "DELETE FROM tasks WHERE id=$id";
                mysqli_query($conn, $sql);
            }

            if (isset($_POST['change_status'])) {
                $id = $_POST['task_id'];
                $status = $_POST['task_status'];
            
                // Zmiana statusu zadania w bazie danych
                $sql = "UPDATE tasks SET status=$status WHERE id=$id ";
                mysqli_query($conn, $sql);
            }

            //Pobranie informacji o zadaniach danego użytkownika
            $sql = "SELECT id, title, description, status, endDate, priorityLevel FROM tasks WHERE userId = $userid OR groupId IN (SELECT groupId FROM usersgroups WHERE userId = $userid)";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                    echo '<tr>';
                        echo '<th>ID</th>';
                        echo '<th>Tytuł zadania</th>';
                        echo '<th>Opis zadania</th>';
                        echo '<th>Status</th>';
                        echo '<th>Termin</th>';
                        echo '<th>Poziom Priorytetu</th>';
                    echo '</tr>';
                $statusName = ['Nie Rozpoczęte','W Trakcie', 'Zakończone'];
                $priorityName = ['Niski','Średni','Wysoki'];
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                        echo '<td>'.$row['id'].'</td>';
                        echo '<form action="lista_zadan.php" method="POST">';
                            echo '<input class="edit-user" type="hidden" name="task_id" value="'.$row['id'].'">';
                            echo '<td><input class="edit-user" type="text" name="task_title" value="'.$row['title'].'" required></td>';
                            echo '<td><input class="edit-user" type="text" name="task_description" value="'.$row['description'].'"></td>';
                            echo '<td>';
                                echo '<select name="task_status">';
                                for($i=0;$i<count($statusName);$i++){
                                    echo '<option value="'.$i.'" ';
                                    if($row['status']==$i) echo ' selected';
                                    echo '>'.$statusName[$i].'</option>';
                                }
                                echo '</select>';
                            echo '</td>';
                            echo '<td><input class="edit-user" type="date" name="task_date" value="'.$row['endDate'].'"></td>';
                            echo '<td>';
                                echo '<select name="task_priorityLevel">';
                                for($i=0;$i<count($priorityName);$i++){
                                    echo '<option value="'.$i.'" ';
                                    if($row['priorityLevel']==$i) echo ' selected';
                                    echo '>'.$priorityName[$i].'</option>';
                                }
                                echo '</select>';
                            echo '</td>';
                            echo '<td>';
                                echo '<button class="edit" type="submit" name="edit_task">Edytuj</button>';
                                echo '<button class="delete" type="submit" name="delete_task">Usuń</button>';
                                echo '<button class="edit" type="submit" name="change_status">Zmień status</button>';
                            echo '</td>';
                        echo '</form>';
                    echo '</tr>';
                }   
                echo '</table>';
            }

            mysqli_close($conn);
        } else {
            echo "<p>Nie jesteś zalogowany.</p>";
        }
    ?>
</main>

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