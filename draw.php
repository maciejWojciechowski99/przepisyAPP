<?php
session_start();  // Rozpocznij lub wznow sesję
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Przepis na dzisiaj</title>
</head>
<body>
    <main class="sing__body">
    <?php include "config.php"; ?>

    <?php include "includes/nav.php"; ?>
    <section class="przepisy">
    <?php
// Pobierz losowy przepis dla danego użytkownika
$pdo = $database->connection(); // Załóżmy, że masz obiekt $database z instancją klasy Database
$przepis_uzytkownika = $_SESSION['user'];

$sql = "SELECT * FROM przepisy_dodane WHERE przepis_uzytkownika = ? ORDER BY RAND() LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$przepis_uzytkownika]);
$randomRecipe = $stmt->fetch(PDO::FETCH_ASSOC);

if ($randomRecipe) {
    // Tutaj wyświetlasz informacje o losowym przepisie
    echo '<div class="przepisy__tytul"><h2>Twój przepis na dzisiaj to:</h2>';
    echo "<p>Tytuł: " . $randomRecipe['tytul'] . "</p>";
    echo "<p>Opis: " . nl2br(htmlspecialchars($randomRecipe['opis'])) . "</p></div>";
} else {
    echo "<p>Brak przepisów dla danego użytkownika.</p>";
}
?>
</section>


    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.js"></script>
    </main>
</body>
</html>
