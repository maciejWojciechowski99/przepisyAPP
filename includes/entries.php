<h2 class="display-5 header">Twoje przepisy</h2>

<section class="przepisy">
    <?php
    if (!isset($_SESSION['user'])) {
        // Jeśli nie jest zalogowany, możesz przekierować go do strony logowania lub wyświetlić komunikat
        echo "<p>Musisz być zalogowany, aby zobaczyć przepisy.</p>";
    } else {
        $entries = $database->getEntries();
        if ($_POST && isset($_POST['submit_usun'])) {
            $id = trim($_POST['usun']);
            $tytul = $database->getTitleById($id);
            if ($database->deleteEntry($id)) {
                $successMessage = "Usunięto przepis: $tytul";
                Logger::log('Success: ' . $successMessage, $tytul, $_SESSION['user']);
                echo "<p style='color:red;'>$successMessage</p>";
            } else {
                $errorMessage = "Wystąpił błąd podczas usuwania wpisu o ID: $id";
                Logger::log('Error: ' . $errorMessage, $tytul, $_SESSION['user']);
                echo "$errorMessage";
            }
        }

        if ($entries && $entries->rowCount() > 0) {
            foreach ($database->getEntries() as $entry) {
    ?>
                <div class="przepisy__tytul">
                    <p>Tytuł: <strong><?php echo $entry['tytul']; ?></strong> </p>
                    <p> Przepis: <br> <strong><?php echo nl2br(htmlspecialchars($entry['opis'])); ?></p></strong>
                    <form method="post">
                        <input type="hidden" name="usun" value="<?php echo $entry['id']; ?>">
                        <input class="deleteButton" type="submit" value="usuń" name="submit_usun">
                    </form>
                    <!-- system ocenienia -->
                    <div class="mb-3">
                        <label for="ocena" class="form-label">Ocena:</label>
                        <div class="rating" data-recipe-id="<?php echo $entry['id']; ?>">
                            <span class="star" data-value="1">&#9733;</span>
                            <span class="star" data-value="2">&#9733;</span>
                            <span class="star" data-value="3">&#9733;</span>
                            <span class="star" data-value="4">&#9733;</span>
                            <span class="star" data-value="5">&#9733;</span>
                        </div>
                        <input type="hidden" id="ocena" name="ocena" value="0">
                    </div>
                    <!-- Przycisk do dodawania do ulubionych -->
                    <div class="mb-3">
                        <form method="post">
                            <input type="hidden" name="dodaj_do_ulubionych" value="<?php echo $entry['id']; ?>">
                            <input class="btn btn-warning" type="submit" value="Dodaj do ulubionych" name="submit_ulubione">
                        </form>
                        <?php
                        if ($_POST && isset($_POST['submit_ulubione']) && $_POST['dodaj_do_ulubionych'] == $entry['id']) {
                            // Sprawdź, czy dodano przepis do ulubionych
                            $recipeIdToAddToFavorites = $_POST['dodaj_do_ulubionych'];
                            if ($database->addToFavorites($recipeIdToAddToFavorites)) {
                                echo "<p style='color:green;'>Dodano przepis do ulubionych.</p>";
                            } else {
                                echo "Wystąpił błąd podczas dodawania przepisu do ulubionych.";
                            }
                        }
                        ?>
                    </div>
                    <!-- Przycisk do edycji przepisu -->
                    <form method="post">
                        <input type="hidden" name="edytuj" value="<?php echo $entry['id']; ?>">
                        <input class="btn btn-warning" type="submit" value="Edytuj przepis" name="submit_edytuj">
                    </form>
                    <?php
                    if ($_POST && isset($_POST['submit_edytuj']) && $_POST['edytuj'] == $entry['id']) {
                        $idToEdit = $_POST['edytuj'];
                        $entryToEdit = $database->getEntryById($idToEdit);

                        if ($entryToEdit) {
                            // Przypisz dane przepisu do zmiennych
                            $tytulToEdit = $entryToEdit['tytul'];
                            $opisToEdit = $entryToEdit['opis'];

                            // Wyświetl formularz edycji
                    ?>
                            <div class="przepisy__tytul">
                                <form method="post">
                                    <input type="hidden" name="zapisz_edycje" value="<?php echo $idToEdit; ?>">
                                    <div class="mb-3">
                                        <label for="tytul" class="form-label">Tytuł:</label>
                                        <input type="text" class="form-control" id="tytul" name="tytul" value="<?php echo $tytulToEdit; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="opis" class="form-label">Opis:</label>
                                        <textarea class="form-control" id="opis" name="opis"><?php echo $opisToEdit; ?></textarea>
                                    </div>
                                    <input class="btn btn-warning" type="submit" value="Zapisz poprawki" name="submit_zapisz_edycje">
                                </form>
                            </div>
    <?php
                        }
                    }
    ?>
                    <?php
                    if ($_POST && isset($_POST['submit_zapisz_edycje'])) {
                        $idToSaveEdit = $_POST['zapisz_edycje'];
                        $newTytul = trim($_POST['tytul']);
                        $newOpis = trim($_POST['opis']);

                        if ($database->updateEntry($idToSaveEdit, $newTytul, $newOpis)) {
                            if ($_POST['zapisz_edycje'] == $idToSaveEdit) {
                                echo "<div class='container mt-4 alert alert-success'>Edytowano nowy przepis</div>";
                            }
                        } else {
                            if ($_POST['zapisz_edycje'] == $idToSaveEdit) {
                                echo "Wystąpił błąd podczas zapisywania poprawek do przepisu";
                            }
                        }
                    }
                    ?>
                </div>

                <!-- Skrypt obsługujące ocenianie przepisu -->
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const stars = document.querySelectorAll(".rating[data-recipe-id='<?php echo $entry['id']; ?>'] .star");
                        const hiddenInput = document.getElementById("ocena");
                        const recipeId = <?php echo $entry['id']; ?>;

                        let userRating = parseInt(localStorage.getItem(`userRating_${recipeId}`)) || 0;

                        stars.forEach((star) => {
                            star.addEventListener("click", function () {
                                const value = this.getAttribute("data-value");
                                userRating = value;
                                hiddenInput.value = userRating;
                                localStorage.setItem(`userRating_${recipeId}`, userRating);
                                updateStars();
                            });

                            star.addEventListener("mouseover", function () {
                                const value = this.getAttribute("data-value");
                                updateStars(value);
                            });

                            star.addEventListener("mouseout", function () {
                                updateStars();
                            });
                        });

                        function updateStars(hoverValue = 0) {
                            stars.forEach((star) => {
                                const starValue = parseInt(star.getAttribute("data-value"));
                                const isSelected = starValue <= userRating;
                                const isHovered = starValue <= hoverValue;
                                star.classList.toggle("selected", isSelected);
                                star.classList.toggle("hovered", isHovered);
                            });
                        }

                        // Początkowa aktualizacja gwiazdek
                        updateStars();
                    });
                </script>
    <?php
            }
        } else {
            echo "<p class=\"lead pt-4\">Obecnie brak przepisów...</p>";
        }
    }
    ?>
</section>