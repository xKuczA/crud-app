<?php
include 'header_admin.php'; // Nagłówek dla administratora
include 'db.php'; // Połączenie z MongoDB
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany i ma rolę admina
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Pobranie listy filmów
$moviesList = $movies->find();

// Obsługa formularza edycji filmu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movieId = (int)$_POST['movie_id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $duration = (int)$_POST['duration'];
    $rating = (float)$_POST['rating'];
    $description = $_POST['description'];
    $actors = explode(',', $_POST['actors']);

    // Aktualizacja danych filmu
    $movies->updateOne(
        ['_id' => $movieId],
        ['$set' => [
            'title' => $title,
            'genre' => $genre,
            'director' => $director,
            'duration' => $duration,
            'rating' => $rating,
            'description' => $description,
            'actors' => $actors
        ]]
    );
    echo "<p>Dane filmu zostały zaktualizowane pomyślnie.</p>";
}
?>

<h1>Edycja Filmów</h1>
<form method="POST">
    <label for="movie_id">Wybierz Film:</label>
    <select name="movie_id" required>
        <?php foreach ($moviesList as $movie): ?>
            <option value="<?php echo $movie['_id']; ?>">
                <?php echo htmlspecialchars($movie['title']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="title">Tytuł:</label>
    <input type="text" name="title" required>

    <label for="genre">Gatunek:</label>
    <input type="text" name="genre" required>

    <label for="director">Reżyser:</label>
    <input type="text" name="director" required>

    <label for="duration">Czas trwania (w minutach):</label>
    <input type="number" name="duration" required>

    <label for="rating">Ocena (1-10):</label>
    <input type="number" step="0.1" name="rating" required>

    <label for="description">Opis:</label>
    <textarea name="description" required></textarea>

    <label for="actors">Aktorzy (oddziel przecinkami):</label>
    <input type="text" name="actors" required>

    <button type="submit">Zaktualizuj Film</button>
</form>

<?php include 'footer.php'; ?>
