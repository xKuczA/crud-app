<?php
include 'header_user.php'; // Nagłówek dla użytkownika
include 'db.php'; // Połączenie z MongoDB
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'user') {
    header('Location: login.php');
    exit;
}

// Pobranie listy filmów
$moviesList = $movies->find([], ['sort' => ['title' => 1]]); // Sortowanie po tytule

?>

<h1>Lista Filmów</h1>
<table>
    <tr>
        <th>Tytuł</th>
        <th>Gatunek</th>
        <th>Reżyser</th>
        <th>Czas trwania</th>
        <th>Ocena</th>
        <th>Status</th>
        <th>Opis</th>
        <th>Aktorzy</th>
    </tr>
    <?php foreach ($moviesList as $movie): ?>
        <tr>
            <td><?php echo htmlspecialchars($movie['title']); ?></td>
            <td><?php echo htmlspecialchars($movie['genre']); ?></td>
            <td><?php echo htmlspecialchars($movie['director']); ?></td>
            <td><?php echo htmlspecialchars($movie['duration']); ?> min</td>
            <td><?php echo htmlspecialchars($movie['rating']); ?>/10</td>
            <td><?php echo $movie['available'] ? "Dostępny" : "Wypożyczony"; ?></td>
            <td><?php echo htmlspecialchars($movie['description']); ?></td>
            <td><?php echo htmlspecialchars(implode(', ', (array)$movie['actors'])); ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
