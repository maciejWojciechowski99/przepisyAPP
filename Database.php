<?php

class Database
{
    protected $dbname = 'przepisy';
    protected $dbhost = 'localhost';
    protected $dbuser = 'root';
    protected $dbpass = null;

    public function connection() : PDO
    {
        return new PDO("mysql:dbname=$this->dbname;host=$this->dbhost", $this->dbuser, $this->dbpass);
    }
    
    // Funkcja dodająca nowy przepis użytkownika do bazy danych
    public function addRecipe(string $tytul, string $opis, int $user_id) : bool
    {
        $pdo = $this->connection();
        $sql = "INSERT INTO przepisy_dodane (user_id, tytul, opis, przepis_uzytkownika)
                VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE
                tytul = VALUES(tytul), opis = VALUES(opis), przepis_uzytkownika = VALUES(przepis_uzytkownika)";
        
        return $pdo->prepare($sql)->execute([$user_id, $tytul, $opis, $_SESSION['user']]);
    }

    // Funkcja pobierająca wpis o przepisie z bazy danych na podstawie ID
    public function getEntryById(int $id)
    {
        $pdo = $this->connection();
        $sql = "SELECT * FROM przepisy_dodane WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Funkcja aktualizująca wpis o przepisie w bazie danych
    public function updateEntry(int $id, string $tytul, string $opis) : bool
    {
        $pdo = $this->connection();
        $sql = "UPDATE przepisy_dodane SET tytul = ?, opis = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$tytul, $opis, $id]);
    }

    // Funkcja pobierająca listę wpisów o przepisach z bazy danych
    public function getEntries(int $limit = null) : PDOStatement|false
    {
        $pdo = $this->connection();
        $przepis_uzytkownika = isset($_SESSION['user']) ? $_SESSION['user'] : null;

        if ($przepis_uzytkownika !== null) {
            $sql = $limit > 0 ? "SELECT * FROM przepisy_dodane WHERE przepis_uzytkownika = ? ORDER BY id DESC LIMIT $limit" : "SELECT * FROM przepisy_dodane WHERE przepis_uzytkownika = ? ORDER BY id DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$przepis_uzytkownika]);

            return $stmt;
        } else {
            return false;
        }
    }

    // Funkcja usuwająca wpis o przepisie z bazy danych na podstawie ID
    public function deleteEntry(int $id) : bool
    {
        $pdo = $this->connection();
        $sql = "DELETE FROM przepisy_dodane WHERE id = ?";
        return $pdo->prepare($sql)->execute([$id]);
    }

    // Funkcje pobierające informacje o autorze, tytule przepisu na podstawie ID
    public function getAuthorById(int $id) : ?string
    {
        $pdo = $this->connection();
        $sql = "SELECT opis FROM przepisy_dodane WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchColumn();
        return $result ? $result : null;
    }

    public function getTitleById(int $id) : ?string
    {
        $pdo = $this->connection();
        $sql = "SELECT tytul FROM przepisy_dodane WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetchColumn();
        return $result ? $result : null;
    }

     // Funkcje obsługujące dodawanie, weryfikację użytkowników
    public function addUser(string $login, string $haslo, string $email) : bool
    {
        $pdo = $this->connection();
        $sql = "INSERT INTO uzytkownicy (login, haslo, email) VALUES (?, ?, ?)";
        return $pdo->prepare($sql)->execute([$login, $haslo, $email]);
    }

    public function verifyLogin(string $login, string $password) : bool
    {
        $pdo = $this->connection();
        $sql = "SELECT id, haslo FROM uzytkownicy WHERE login = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && $userData['haslo'] === $password) {
            session_start();
            $_SESSION['user'] = $login;
            $_SESSION['user_id'] = (int)$userData['id'];
            header("Location: index.php");
            exit();
        } else {
            return false;
        }
    }

    // Funkcje sprawdzające dostępność loginu w bazie danych
    public function isLoginTaken(string $login) : bool
    {
        $pdo = $this->connection();
        $sql = "SELECT COUNT(*) FROM uzytkownicy WHERE login = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }


    // Funkcje sprawdzające adresu email w bazie danych
    public function isEmailTaken(string $email) : bool
    {
        $pdo = $this->connection();
        $sql = "SELECT COUNT(*) FROM uzytkownicy WHERE email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $count = $stmt->fetchColumn();
        return $count > 0;
    }

   // Funkcje pobierające informacje o użytkowniku na podstawie loginu
    public function getUserInfo(string $login)
    {
        $pdo = $this->connection();
        $sql = "SELECT * FROM uzytkownicy WHERE login = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Funkcje obsługujące dodawanie przepisu do ulubionych
    public function addToFavorites(int $recipeId) : bool
    {
        $pdo = $this->connection();
        $sql = "UPDATE przepisy_dodane SET ulubione_przepisy = 1 WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$recipeId]);
    }

    // Funkcje pobierające listę ulubionych przepisów
    public function getFavoriteEntries(int $limit = null) : PDOStatement|false
    {
        $pdo = $this->connection();
        $przepis_uzytkownika = isset($_SESSION['user']) ? $_SESSION['user'] : null;

        if ($przepis_uzytkownika !== null) {
            $sql = $limit > 0 ? "SELECT * FROM przepisy_dodane WHERE przepis_uzytkownika = ? AND ulubione_przepisy = 1 ORDER BY id DESC LIMIT $limit" : "SELECT * FROM przepisy_dodane WHERE przepis_uzytkownika = ? AND ulubione_przepisy = 1 ORDER BY id DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$przepis_uzytkownika]);

            return $stmt;
        } else {
            return false;
        }
    }

    // Funkcja usuwająca przepis z ulubionych na podstawie ID
    public function removeFromFavorites(int $id) : bool
    {
        $pdo = $this->connection();
        $sql = "UPDATE przepisy_dodane SET ulubione_przepisy = 0 WHERE id = ?";
        return $pdo->prepare($sql)->execute([$id]);
    }
    
}
