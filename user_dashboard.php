<?php
include 'header_user.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
?>
<div class="container">
<h1>Panel Użytkownika</h1>
<p>Witaj, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
<ul>
    <li><a href="list_movie_user.php">Przeglądaj filmy</a></li>
    <li><a href="rent_movie.php">Wypożycz film</a></li>
</ul>
</div>

<?php include 'footer.php'; ?>
