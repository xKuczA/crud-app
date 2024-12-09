<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'header_admin.php';
include 'db.php';


// Obsługa formularza dodawania filmu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $director = $_POST['director'];
    $duration = (int)$_POST['duration'];
    $rating = (float)$_POST['rating'];
    $description = $_POST['description'];
    $actors = explode(',', $_POST['actors']);
    $added_date = new MongoDB\BSON\UTCDateTime();

    // Sprawdzenie, czy film o podanym tytule już istnieje
    $existingMovie = $movies->findOne(['title' => $title]);
    if ($existingMovie) {
        echo "<p>Film o podanym tytule już istnieje.</p>";
    } else {
        // Dodanie nowego filmu do bazy danych
        $movies->insertOne([
            '_id' => $movies->countDocuments() + 1, // Generowanie ID
            'title' => $title,
            'genre' => $genre,
            'director' => $director,
            'duration' => $duration,
            'rating' => $rating,
            'description' => $description,
            'actors' => $actors,
            'added_date' => $added_date,
            'available' => true
        ]);
        echo "<p>Nowy film został dodany pomyślnie.</p>";
    }
}
?>

<h1>Dodaj Film</h1>
<form method="POST">
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

    <button type="submit">Dodaj Film</button>
</form>

<?php include 'footer.php'; ?>
