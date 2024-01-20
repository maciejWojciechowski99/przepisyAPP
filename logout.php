
<?php require_once "Logger.php"; ?>
<?php require_once "Database.php"; ?>
<?php

session_start();

// Sprawdź, czy użytkownik jest zalogowany przed wylogowaniem
if (isset($_SESSION['user'])) {
    // Dodaj informację do logów o wylogowaniu
    $username = $_SESSION['user'];
    $successMessage = "Użytkownik '$username' został wylogowany.";
    
    // Utwórz obiekt klasy Database
    $database = new Database(); 
    // Pobierz połączenie z bazy danych z obiektu Database
    $pdo = $database->connection(); 

    // Wywołaj metodę logOut, przekazując aktualne połączenie PDO
    Logger::logOut($pdo, 'Success', $successMessage, '', $username);
}

// Zniszcz sesję
session_destroy();

// Przekieruj na stronę główną po wylogowaniu
header("Location: index.php");
exit();
?>
