<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'header_admin.php';
include 'db.php';


// Obsługa zwrotu filmu
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rental_id'])) {
    $rentalId = (int)$_POST['rental_id'];

    // Pobranie wypożyczenia
    $rental = $rentals->findOne(['_id' => $rentalId]);

    if ($rental && !$rental['actual_return_date']) {
        // Ustawienie daty faktycznego zwrotu
        $rentals->updateOne(
            ['_id' => $rentalId],
            ['$set' => ['actual_return_date' => new MongoDB\BSON\UTCDateTime()]]
        );

        // Zmiana statusu filmu na dostępny
        $movies->updateOne(
            ['_id' => $rental['movie_id']],
            ['$set' => ['available' => true]]
        );

        // Zmniejszenie liczby aktywnych wypożyczeń klienta
        $clients->updateOne(
            ['_id' => $rental['client_id']],
            ['$inc' => ['active_rentals' => -1]]
        );

        echo "<p>Film został zwrócony pomyślnie.</p>";
    } else {
        echo "<p>Błąd: Nie można zwrócić tego filmu.</p>";
    }
}

// Pobranie listy wypożyczeń z dołączeniem informacji o klientach i filmach
$rentalsList = $rentals->aggregate([
    [
        '$lookup' => [
            'from' => 'movies',
            'localField' => 'movie_id',
            'foreignField' => '_id',
            'as' => 'movie_details'
        ]
    ],
    [
        '$lookup' => [
            'from' => 'clients',
            'localField' => 'client_id',
            'foreignField' => '_id',
            'as' => 'client_details'
        ]
    ]
]);
?>

<h1>Lista Wypożyczeń</h1>
<table>
    <tr>
        <th>Klient</th>
        <th>Film</th>
        <th>Data wypożyczenia</th>
        <th>Planowany zwrot</th>
        <th>Faktyczny zwrot</th>
        <th>Status</th>
        <th>Akcja</th>
    </tr>
    <?php foreach ($rentalsList as $rental): ?>
        <?php 
        $client = $rental['client_details'][0] ?? null;
        $movie = $rental['movie_details'][0] ?? null;
        ?>
        <tr>
            <td>
                <?php echo $client ? htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) : "Nieznany klient"; ?>
            </td>
            <td>
                <?php echo $movie ? htmlspecialchars($movie['title']) : "Nieznany film"; ?>
            </td>
            <td>
                <?php echo htmlspecialchars($rental['rental_date']->toDateTime()->format('Y-m-d H:i')); ?>
            </td>
            <td>
                <?php echo htmlspecialchars($rental['planned_return_date']->toDateTime()->format('Y-m-d H:i')); ?>
            </td>
            <td>
                <?php echo $rental['actual_return_date'] 
                    ? htmlspecialchars($rental['actual_return_date']->toDateTime()->format('Y-m-d H:i')) 
                    : "Brak"; ?>
            </td>
            <td>
                <?php echo $rental['actual_return_date'] ? "Zwrócony" : "W trakcie"; ?>
            </td>
            <td>
                <?php if (!$rental['actual_return_date']): ?>
                    <form method="POST" style="display: inline;">
                        <input type="hidden" name="rental_id" value="<?php echo $rental['_id']; ?>">
                        <button type="submit" class="return-button">Zwrot</button>
                    </form>
                <?php else: ?>
                    <span>-</span>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
