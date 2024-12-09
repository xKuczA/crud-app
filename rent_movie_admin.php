<?php
include 'header_admin.php';
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = (int)$_POST['client_id'];
    $movieId = (int)$_POST['movie_id'];

    $movie = $movies->findOne(['_id' => $movieId, 'available' => true]);
    $client = $clients->findOne(['_id' => $clientId]);

    if (!$movie) {
        echo "<p>Film jest niedostępny lub nie istnieje.</p>";
    } elseif ($client['active_rentals'] >= 3) {
        echo "<p>Klient osiągnął limit wypożyczeń (3 filmy).</p>";
    } else {
        $nextRentalId = $rentals->countDocuments() + 1;
        $rentals->insertOne([
            '_id' => $nextRentalId,
            'client_id' => $clientId,
            'movie_id' => $movieId,
            'rental_date' => new MongoDB\BSON\UTCDateTime(),
            'planned_return_date' => new MongoDB\BSON\UTCDateTime((new DateTime('+2 days'))->getTimestamp() * 1000),
            'actual_return_date' => null
        ]);

        $movies->updateOne(['_id' => $movieId], ['$set' => ['available' => false]]);
        $clients->updateOne(['_id' => $clientId], ['$inc' => ['active_rentals' => 1]]);

        echo "<p>Film został wypożyczony pomyślnie.</p>";
    }
}
?>

<h1>Wypożycz film</h1>
<form method="POST">
    <label for="client_id">ID Klienta:</label>
    <input type="number" name="client_id" required>
    <label for="movie_id">ID Filmu:</label>
    <input type="number" name="movie_id" required>
    <button type="submit">Wypożycz</button>
</form>
<?php include 'footer.php'; ?>
