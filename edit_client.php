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

// Obsługa formularza edycji klienta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clientId = (int)$_POST['client_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Aktualizacja danych klienta
    $updateData = [
        'first_name' => $first_name,
        'last_name' => $last_name,
        'address' => $address,
        'phone' => $phone,
        'username' => $username
    ];

    // Jeśli podano nowe hasło, aktualizuj je
    if (!empty($password)) {
        $updateData['password'] = password_hash($password, PASSWORD_BCRYPT);
    }

    $clients->updateOne(
        ['_id' => $clientId],
        ['$set' => $updateData]
    );
    echo "<p>Dane klienta zostały zaktualizowane pomyślnie.</p>";
}
?>

<h1>Edycja Klientów</h1>
<form method="POST">
    <label for="client_id">Wybierz Klienta:</label>
    <select name="client_id" required>
        <?php foreach ($clientsList as $client): ?>
            <option value="<?php echo $client['_id']; ?>">
                <?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="first_name">Imię:</label>
    <input type="text" name="first_name" required>

    <label for="last_name">Nazwisko:</label>
    <input type="text" name="last_name" required>

    <label for="address">Adres:</label>
    <input type="text" name="address" required>

    <label for="phone">Telefon:</label>
    <input type="text" name="phone" required>

    <label for="username">Login:</label>
    <input type="text" name="username" required>

    <label for="password">Hasło (zostaw puste, aby nie zmieniać):</label>
    <input type="password" name="password">

    <button type="submit">Zaktualizuj Klienta</button>
</form>

<?php include 'footer.php'; ?>
