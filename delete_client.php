<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}
include 'header_admin.php';
include 'db.php';


// Pobranie listy klientów
$clientsList = $clients->find();

// Obsługa usuwania klienta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = (int)$_POST['client_id'];

    // Sprawdzenie, czy klient ma aktywne wypożyczenia
    $activeRentals = $rentals->countDocuments(['client_id' => $clientId, 'actual_return_date' => null]);
    if ($activeRentals > 0) {
        echo "<p>Nie można usunąć klienta, ponieważ ma aktywne wypożyczenia.</p>";
    } else {
        // Usunięcie klienta z bazy danych
        $clients->deleteOne(['_id' => $clientId]);
        echo "<p>Klient został pomyślnie usunięty.</p>";
    }
}
?>

<h1>Usuń Klienta</h1>
<form method="POST">
    <label for="client_id">Wybierz Klienta do Usunięcia:</label>
    <select name="client_id" required>
        <?php foreach ($clientsList as $client): ?>
            <option value="<?php echo $client['_id']; ?>">
                <?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Usuń Klienta</button>
</form>

<?php include 'footer.php'; ?>
