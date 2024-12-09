<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'header_admin.php';
include 'db.php';


// Pobranie listy filmów
$moviesList = $movies->find();

// Obsługa usuwania filmu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = (int)$_POST['movie_id'];

    // Sprawdzenie, czy film jest wypożyczony
    $activeRentals = $rentals->countDocuments(['movie_id' => $movieId, 'actual_return_date' => null]);
    if ($activeRentals > 0) {
        echo "<p>Nie można usunąć filmu, ponieważ jest aktualnie wypożyczony.</p>";
    } else {
        // Usunięcie filmu z bazy danych
        $movies->deleteOne(['_id' => $movieId]);
        echo "<p>Film został pomyślnie usunięty.</p>";
    }
}
?>

<h1>Usuń Film</h1>
<form method="POST">
    <label for="movie_id">Wybierz Film do Usunięcia:</label>
    <select name="movie_id" required>
        <?php foreach ($moviesList as $movie): ?>
            <option value="<?php echo $movie['_id']; ?>">
                <?php echo htmlspecialchars($movie['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Usuń Film</button>
</form>

<?php include 'footer.php'; ?>
