<?php
include 'db.php'; // Połączenie z bazą danych

// Sprawdzenie, czy użytkownik admin już istnieje
$existingAdmin = $clients->findOne(['username' => 'admin']);
if ($existingAdmin) {
    echo "<p>Użytkownik admin już istnieje w bazie danych.</p>";
} else {
    // Hasło admin zaszyfrowane
    $hashedPassword = password_hash('admin', PASSWORD_BCRYPT);

    // Dodanie użytkownika admin do kolekcji clients
    $clients->insertOne([
        '_id' => $clients->countDocuments() + 1, // Automatyczny ID
        'username' => 'admin',
        'password' => $hashedPassword,
        'role' => 'admin', // Rola: admin
        'first_name' => 'Administrator',
        'last_name' => 'Systemu',
        'address' => 'Nie dotyczy',
        'phone' => '000000000',
        'registration_date' => new MongoDB\BSON\UTCDateTime(),
        'active_rentals' => 0
    ]);

    echo "<p>Użytkownik admin został pomyślnie dodany do bazy danych.</p>";
}
?>
