<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

include 'header_admin.php';
?>
<head>
<link rel="stylesheet" href="style.css">
</head>

<div class="container">
<h1>Panel Administratora</h1>
<p>Wybierz jedną z poniższych opcji:</p>

<ul>
    <li><a href="list_movies.php">Wyświetl listę filmów</a></li>
    <li><a href="list_rentals.php">Wyświetl listę wszystkich wypożyczeń</a></li>
    <li><a href="rent_movie_admin.php">Wypożycz film</a></li>
    <li><a href="add_client.php">Dodaj nowego klienta</a></li>
    <li><a href="edit_client.php">Modyfikuj dane klienta</a></li>
    <li><a href="delete_client.php">Usuń klienta</a></li>
    <li><a href="add_movie.php">Dodaj nowy film</a></li>
    <li><a href="edit_movie.php">Modyfikuj opis filmu</a></li>
    <li><a href="delete_movie.php">Usuń film</a></li>
</ul>
</div>

<?php include 'footer.php'; ?>
