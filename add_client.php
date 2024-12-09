<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'header_admin.php'; // Nagłówek dla administratora
include 'db.php'; // Połączenie z MongoDB


// Obsługa formularza dodawania klienta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $registration_date = new MongoDB\BSON\UTCDateTime();

    // Sprawdzenie, czy użytkownik już istnieje
    $existingClient = $clients->findOne(['username' => $username]);
    if ($existingClient) {
        echo "<p>Użytkownik o podanym loginie już istnieje.</p>";
    } else {
        // Dodanie nowego klienta
        $clients->insertOne([
            '_id' => $clients->countDocuments() + 1, // Generowanie ID
            'username' => $username,
            'password' => $password,
            'role' => 'user',
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address' => $address,
            'phone' => $phone,
            'registration_date' => $registration_date,
            'active_rentals' => 0
        ]);
        echo "<p>Nowy klient został dodany pomyślnie.</p>";
    }
}
?>

<h1>Dodaj Klienta</h1>
<form method="POST">
    <label for="username">Login:</label>
    <input type="text" name="username" required>
    <label for="password">Hasło:</label>
    <input type="password" name="password" required>
    <label for="first_name">Imię:</label>
    <input type="text" name="first_name" required>
    <label for="last_name">Nazwisko:</label>
    <input type="text" name="last_name" required>
    <label for="address">Adres:</label>
    <input type="text" name="address" required>
    <label for="phone">Telefon:</label>
    <input type="text" name="phone" required>
    <button type="submit">Dodaj Klienta</button>
</form>

<?php include 'footer.php'; ?>
