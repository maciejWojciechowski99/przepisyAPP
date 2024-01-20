<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title>Rejestracja</title>
</head>
<body>
    <main class="registration__body">
        <?php include "config.php"; ?>
        <?php include "includes/nav.php"; ?>
        <?php require_once "Logger.php"; ?>

        <?php
        if ($_POST) {
            $login = trim($_POST['login']);
            $password = trim($_POST['haslo']);
            $email = trim($_POST['email']);
        
            if (empty($login) || empty($password) || empty($email)) {
                $errorMessage = "Próba rejestracji użytkownika z pustymi polami.";
                Logger::log('Error: ' . $errorMessage);
                echo "<div class='container mt-4 alert alert-danger'>Podano puste pola!</div>";
            } else {
                // sprawdzenie, czy długość loginu, hasła i emaila jest odpowiednia
                if (strlen($login) < 64 && strlen($password) < 3000 && strlen($email) < 64) {
                    // Sprawdź, czy login i adres e-mail są zajęte
                    $isLoginTaken = $database->isLoginTaken($login);
                    $isEmailTaken = $database->isEmailTaken($email);
                        if ($isLoginTaken && $isEmailTaken) {
                            $errorMessage = "Próba rejestracji użytkownika o loginie '$login' i adresie e-mail '$email' nieudana - login i adres e-mail są już zajęte.";
                            Logger::log('Error: ' . $errorMessage);
                            echo "<div class='container mt-4 alert alert-danger'>Login i adres email są zajęte!</div>";
                        } elseif ($isLoginTaken) {
                            $errorMessage = "Próba rejestracji użytkownika o loginie '$login' nieudana - login jest już zajęty.";
                            Logger::log('Error: ' . $errorMessage);
                            echo "<div class='container mt-4 alert alert-danger'>Login jest już zajęty!</div>";
                        } elseif ($isEmailTaken) {
                            $errorMessage = "Próba rejestracji użytkownika o loginie '$login' i adresie e-mail '$email' nieudana - adres e-mail jest już zajęty.";
                            Logger::log('Error: ' . $errorMessage);
                            echo "<div class='container mt-4 alert alert-danger'>Adres email jest już zajęty!</div>";
                        }
                        else {
                        // Sprawdź, czy hasło spełnia wymagania
                        $passwordRequirements = checkPasswordRequirements($password);

                        if ($passwordRequirements['valid']) {
                            // Dodaj użytkownika tylko jeśli login i adres e-mail nie są zajęte, a hasło spełnia wymagania
                            if ($database->addUser($login, $password, $email)) {
                                $successMessage = "Dodano nowego użytkownika: $login";
                                Logger::log('Success: ' . $successMessage);
                                echo "<div class='container mt-4 alert alert-success'>$successMessage</div>";
                            } else {
                                $errorMessage = "Wystąpił nieoczekiwany problem podczas rejestracji użytkownika: $login";
                                Logger::log('Error: ' . $errorMessage);
                                echo "<div class='container mt-4 alert alert-danger'>$errorMessage</div>";
                            }
                        } else {
                            echo "<div class='container mt-4 alert alert-danger'> Hasło musi zawierać przynajmniej 8 znaków i jeden znak specjalny}</div>";
                        }
                    }
                } else {
                    echo "<div class='container mt-4 alert alert-danger'>Wystąpił nieoczekiwany problem!</div>";
                }
            }
        }

        function checkPasswordRequirements($password) {
            $requirements = [
                'valid' => true,
                'message' => ''
            ];

            // Sprawdź, czy hasło ma przynajmniej 8 znaków
            if (strlen($password) < 8) {
                $requirements['valid'] = false;
                $requirements['message'] .= "Hasło musi mieć przynajmniej 8 znaków i przynajmniej jeden znak specjalny. ";
            }

            // Sprawdź, czy hasło zawiera znak specjalny
            if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password) && strlen($password) < 8) {
                $requirements['valid'] = false;
                $requirements['message'] .= "Hasło musi zawierać przynajmniej jeden znak specjalny. ";
            }

            return $requirements;
        }
        ?>

        <!-- Formularz -->
        <section  class="container mt-5">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="login" class="form-label">Login:</label>
                    <input type="text" class="form-control" id="login" name="login">
                </div>
                <div class="mb-3">
                    <label for="haslo" class="form-label">Hasło:</label>
                    <input type="password" class="form-control" id="haslo" name="haslo">
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        Hasło musi mieć przynajmniej 8 znaków i zawierać przynajmniej jeden znak specjalny.
                    </small>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Adres email:</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="">
                    <input type="submit" class="btn btn-primary" value="Zarejestruj się" style="display:block;margin: 0 auto;width:200px;" />
                </div>
            </form>
        </section>


        <script src="js/bootstrap.min.js"></script>
        <script src="js/popper.js"></script>
    </main>
</body>
</html>
