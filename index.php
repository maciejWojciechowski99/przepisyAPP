<?php session_start(); ?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Strona główna</title>
</head>
<body>
    <!-- Pobranie modułów -->
    
    <?php require_once "Logger.php"; ?>

    <?php include 'config.php'; ?>

    <?php include "includes/nav.php"; ?>

    <?php include "includes/body.php"; ?>

    <?php include "includes/entries.php"; ?>

    <?php include "includes/footer.php"; ?>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/script.js"></script>
    <script src="js/rate.js"></script>
</body>
</html>
