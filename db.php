<?php
require 'vendor/autoload.php';

$client = new MongoDB\Client("mongodb+srv://pawelkuczera1:connect1@cluster0.jztpn.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0");
$db = $client->projekt_wypozyczalnia;

$clients = $db->clients;
$movies = $db->movies;
$rentals = $db->rentals;
?>
