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
    <link href="css/todolist.css" rel="stylesheet">
    <title>Lista todo</title>
</head>
<body>
    <main class="sing__body">
    <?php include "config.php"; ?>

    <?php include "includes/nav.php"; ?>


    <section class="todo">
    <div class="container__items--toDoList">
            <div class="container__items--toDoList--title">
                <p>Lista zakupów</p>
                <p> <span class="container__items--toDoList--title-counter"></span></p>
            </div>
            <div class="container__items--toDoList--mainElement">
                <ul class="container__items--toDoList--mainElement--list">

                </ul>
                <input id="addElement-toDoList" class="container__items--toDoList--mainElement-addElement" placeholder="+ Dodaj nowy element checklisty" type="text">
            </div>
        </div>


        </section>

    
    <script src="js/todolist.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/popper.js"></script>
    </main>
</body>
</html>
