<?php

class Logger
{
    public static function log($message, $recipeTitle = "", $username = "")
    {
        $logFile = 'app.log';
        $logMessage = date('Y-m-d H:i:s') . ' - ' . $message;

        if ($recipeTitle !== "") {
            $logMessage .= " - tytuł przepisu: $recipeTitle";
        }

        if ($username !== "") {
            $logMessage .= " - Użytkownik: $username";
        }

        $logMessage .= PHP_EOL;

        file_put_contents($logFile, $logMessage, FILE_APPEND | LOCK_EX);
    }

    public static function logToDatabase($event_type, $message, $recipeTitle = "", $username = "")
    {
        $database = new Database(); // Utwórz obiekt klasy Database
        $pdo = $database->connection(); // Pobierz połączenie z bazy danych z obiektu Database

        // Zbuduj zapytanie SQL z prepared statements
        $timestamp = date('Y-m-d H:i:s');
        $sql = $pdo->prepare("INSERT INTO log_events (czas, typ_zdarzenia, wiadomosc, tytul_przepisu, uzytkownik)
                            VALUES (?, ?, ?, ?, ?)");

        // Wykonaj zapytanie SQL
        if ($sql->execute([$timestamp, $event_type, $message, $recipeTitle, $username])) {
            echo "";
        } else {
            echo "Error: " . $sql->errorInfo()[2];
        }
        
    }

    public static function logOut($pdo, $event_type, $message, $recipeTitle = "", $username = "")
{
    // Zbuduj zapytanie SQL z prepared statements
    $timestamp = date('Y-m-d H:i:s');
    $sql = $pdo->prepare("INSERT INTO log_events (czas, typ_zdarzenia, wiadomosc, tytul_przepisu, uzytkownik)
                        VALUES (?, ?, ?, ?, ?)");

    // Wykonaj zapytanie SQL
    if ($sql->execute([$timestamp, $event_type, $message, $recipeTitle, $username])) {
        echo "Logout log entry created successfully";
    } else {
        echo "Error: " . $sql->errorInfo()[2];
    }
}


    

}
