<?php
include 'header_admin.php';
include 'db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$moviesList = $movies->find();

echo "<h1>Lista Filmów</h1>";
echo "<table>
        <tr>
            <th>Lp</th>
            <th>Tytuł</th>
            <th>Gatunek</th>
            <th>Reżyser</th>
            <th>Czas trwania</th>
            <th>Status</th>
        </tr>";

$index = 1;
foreach ($moviesList as $movie) {
    echo "<tr>
            <td>" . $index++ . "</td>
            <td>" . htmlspecialchars($movie['title']) . "</td>
            <td>" . htmlspecialchars($movie['genre']) . "</td>
            <td>" . htmlspecialchars($movie['director']) . "</td>
            <td>" . htmlspecialchars($movie['duration']) . " min</td>
            <td>" . ($movie['available'] ? "Dostępny" : "Wypożyczony") . "</td>
          </tr>";
}
echo "</table>";

include 'footer.php';
?>
