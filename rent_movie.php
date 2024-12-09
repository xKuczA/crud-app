<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'header_user.php';
include 'db.php';


$userId = (int)$_SESSION['user_id']; 

// Obsługa formularza wypożyczenia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = (int)$_POST['movie_id']; // Konwertujemy ID filmu na liczbę całkowitą

    // Pobranie danych filmu
    $movie = $movies->findOne(['_id' => $movieId]);

    if (!$movie || !$movie['available']) {
        echo "<p>Film jest niedostępny lub nie istnieje.</p>";
    } else {
        // Sprawdzenie limitu wypożyczeń
        $client = $clients->findOne(['_id' => $userId]);
        if ($client['active_rentals'] >= 3) {
            echo "<p>Osiągnąłeś limit wypożyczeń (3 filmy).</p>";
        } else {
            // Dodanie wypożyczenia
            $rentals->insertOne([
                '_id' => $rentals->countDocuments() + 1, // Generowanie ID dla wypożyczenia
                'client_id' => $userId,
                'movie_id' => $movieId,
                'rental_date' => new MongoDB\BSON\UTCDateTime(),
                'planned_return_date' => new MongoDB\BSON\UTCDateTime((new DateTime('+2 days'))->getTimestamp() * 1000),
                'actual_return_date' => null
            ]);

            // Zmiana statusu filmu na niedostępny
            $movies->updateOne(['_id' => $movieId], ['$set' => ['available' => false]]);

            // Zwiększenie liczby aktywnych wypożyczeń użytkownika
            $clients->updateOne(['_id' => $userId], ['$inc' => ['active_rentals' => 1]]);

            echo "<p>Film został pomyślnie wypożyczony.</p>";
        }
    }
}

// Pobranie listy dostępnych filmów
$availableMovies = $movies->find(['available' => true]);
?>

<h1>Wypożycz Film</h1>
<form method="POST">
    <label for="movie_id">Wybierz Film:</label>
    <select name="movie_id" required>
        <?php foreach ($availableMovies as $movie): ?>
            <option value="<?php echo $movie['_id']; ?>">
                <?php echo htmlspecialchars($movie['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Wypożycz</button>
</form>

<?php include 'footer.php'; ?>
