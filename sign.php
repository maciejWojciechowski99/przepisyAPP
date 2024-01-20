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
    <title>Dodaj przepis</title>
    <style>
        .char-counter {
            margin-top: 5px;
            color: #888;
        }

        .char-limit-exceeded {
            color: red;
        }
    </style>
</head>
<body>
    <main class="sing__body">
    <?php include "config.php"; ?>
    <?php require_once "Logger.php"; ?>
    <?php include "includes/nav.php"; ?>

    <?php

        // Sprawdź, czy użytkownik jest zalogowany
        if (!isset($_SESSION['user'])) {
            echo "<div class='container mt-4 alert alert-danger'>Musisz być zalogowany, aby dodać przepis!</div>";
        } else {
            if ($_POST) {
                $tytul = isset($_POST['tytul']) ? trim($_POST['tytul']) : "";
                $tresc_przepisu = isset($_POST['tresc_przepisu']) ? trim($_POST['tresc_przepisu']) : "";
            
                if ("" == $tytul || "" == $tresc_przepisu) {
                    $errorMessage = "Podano puste pola!";
                    Logger::log('Error: ' . $errorMessage);
                    echo "<div class='container mt-4 alert alert-danger'>$errorMessage</div>";
                } else {
            
                    if (strlen($tytul) < 64 && strlen($tresc_przepisu) < 3000) {
                        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
            
                        if ($database->addRecipe($tytul, $tresc_przepisu, $user_id)) {
                            $successMessage = "Dodano nowy przepis";
                            Logger::log('Success: ' . $successMessage, $tytul, $_SESSION['user']);
                            echo "<div class='container mt-4 alert alert-success'>$successMessage</div>";
                        } else {
                            $errorMessage = "Wystąpił nieoczekiwany problem!";
                            Logger::log('Error: ' . $errorMessage, $tytul, $_SESSION['user']);
                            echo "<div class='container mt-4 alert alert-danger'>$errorMessage</div>";
                        }
                    }
                }
            }

            // Formularz do dodawania przepisu
            echo '<section class="container mt-5">
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="tytul" class="form-label">Tytuł:</label>
                        <input type="text" class="form-control" id="tytul" name="tytul">
                    </div>
                    <div class="mb-3">
                        <label for="tresc_przepisu" class="form-label">Treść przepisu:</label>
                        <textarea class="form-control desctription" id="tresc_przepisu" name="tresc_przepisu" rows="3" placeholder="Składniki: &#10; Treść przepisu:" oninput="countChars(this)"></textarea>
                        <div id="charCounter" class="char-counter">Limit: 1024 znaków</div>
                        <div id="charLimitExceeded" class="char-limit-exceeded" style="display: none;">Przekroczono limit znaków!</div>
                    </div>
                    <div class="">
                        <input  type="submit" class="btn btn-primary" value="Dodaj Przepis" style="display:block;margin: 0 auto;width:200px;" />
                    </div>
                </form>
            </section>';
        }
    ?>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.js"></script>
    <script>
        function countChars(textarea) {
            var charCounter = document.getElementById('charCounter');
            var charLimitExceeded = document.getElementById('charLimitExceeded');
            var charLimit = 1024;

            var remainingChars = charLimit - textarea.value.length;
            charCounter.textContent = 'Pozostało: ' + remainingChars + ' znaków';

            if (remainingChars < 0) {
                charLimitExceeded.style.display = 'block';
            } else {
                charLimitExceeded.style.display = 'none';
            }
        }
    </script>
    </main>
</body>
</html>
