<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Logowanie</title>
</head>
<body>
    <main class="registration__body">
        <?php include "config.php"; ?>
        <?php include "includes/nav.php"; ?>

        <?php
session_start();
require_once "Logger.php";
if ($_POST) {
    $login = htmlspecialchars(trim($_POST['login']));
    $haslo = trim($_POST['haslo']);

    if (empty($login) || empty($haslo)) {
         // Dodaj informację o błędnym logowaniu do logów
         $errorMessage = "podano puste pola przy próbie zalogowania";
         Logger::log('Error: ' . $errorMessage);
        echo "<div class='container mt-4 alert alert-danger'>Podano puste pola!</div>";
    } else {
        // Dodaj informację o udanym logowaniu do logów
        $successMessage = "Użytkownik '$login' zalogował się.";
        Logger::log('Success: ' . $successMessage);

        // Przykład użycia logowania udanego logowania
        $successMessage = "Użytkownik '$login' zalogował się.";
        Logger::logToDatabase('Success', $successMessage, '', $login);

        if ($database->verifyLogin($login, $haslo)) {
            // Pobierz informacje o zalogowanym użytkowniku (np. login i ID) z bazy danych
            $userInfo = $database->getUserInfo($login);

            // Ustaw dane zalogowanego użytkownika w sesji
            $_SESSION['user'] = $userInfo['login']; // Zakładając, że dane użytkownika są dostępne w $userInfo
            $_SESSION['user_id'] = (int)$userInfo['id']; // Ustaw user_id w sesji
            

            // Przekieruj na stronę główną
            header("Location: index.php");
            exit();
            
        } else {
            // Dodaj informację o błędnym logowaniu do logów
            $errorMessage = "Błędny login lub hasło dla użytkownika '$login'.";
            Logger::log('Error: ' . $errorMessage);
            echo "<div class='container mt-4 alert alert-danger'>Błędny login lub hasło!</div>";
        }
    }
}
?>
<!-- Formularz -->
<section class="container mt-5 text-center">
    <form action="" method="post">
        <div class="mb-3">
            <label for="login" class="form-label">Login:</label>
            <input type="text" class="form-control" id="login" name="login">
        </div>
        <div class="mb-3">
            <label for="haslo" class="form-label">Hasło:</label>
            <input type="password" class="form-control" id="haslo" name="haslo">
        </div>
        <div class="">
            <input type="submit" class="btn btn-primary " value="Zaloguj się" style="display:block;margin: 0 auto;width:200px;" />
        </div>
    </form>
    <section class="container mt-5 text-center">
        <form action="registration.php" method="post">
            <div class="mb-3">
                <label for="haslo" class="form-label">Nie masz konta? Zarejestruj się!</label>
                <input type="submit" class="btn btn-primary" value="Zarejestruj się" style="display:block;margin: 0 auto;width:200px;" />
            </div>
        </form>
    </section>
</section>


        <script src="js/bootstrap.min.js"></script>
        <script src="js/popper.js"></script>
    </main>
</body>
</html>
