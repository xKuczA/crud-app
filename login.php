<?php
session_start();
if (isset($_SESSION['user'])) {
    echo "Zalogowany użytkownik: " . $_SESSION['user'];
}

include 'header_guest.php'; // Sprawdź, czy plik ten nie wysyła danych HTML

include 'db.php'; // Plik połączenia z bazą danych

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugowanie: Sprawdź, czy dane z formularza są odbierane
    echo "Otrzymano login: $username <br>";

    // Pobierz użytkownika z bazy danych
    $user = $clients->findOne(['username' => $username]);

    if ($user) {
        // Debugowanie: Sprawdź, czy użytkownik został znaleziony
        echo "Znaleziono użytkownika: {$user['username']} <br>";

        // Sprawdź hasło
        if (password_verify($password, $user['password'])) {
            echo "Hasło poprawne! <br>"; // Debugowanie: Potwierdź poprawne hasło

            // Ustaw dane sesji
            $_SESSION['user_id'] = (string)$user['_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Przekierowanie w zależności od roli użytkownika
            if ($user['role'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: user_dashboard.php');
            }
            exit;
        } else {
            echo "<p>Nieprawidłowe hasło.</p>";
        }
    } else {
        echo "<p>Nie znaleziono użytkownika o podanym loginie.</p>";
    }
}
?>

<h1>Logowanie</h1>
<form method="POST">
    <label for="username">Login:</label>
    <input type="text" name="username" required>
    <label for="password">Hasło:</label>
    <input type="password" name="password" required>
    <button type="submit">Zaloguj</button>
</form>

<?php include 'footer.php'; ?>
