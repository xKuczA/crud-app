<?php
session_start();
if (isset($_SESSION['user'])) {
    echo "Zalogowany użytkownik: " . $_SESSION['user'];
}


include 'header_guest.php';
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $clients->findOne(['username' => $username]);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = (string)$user['_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: user_dashboard.php');
        }
        exit;
    } else {
        echo "<p>Błędny login lub hasło.</p>";
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
