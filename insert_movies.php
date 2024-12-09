<?php
require 'db.php';

// Definicja filmów
$movieData = [
    [
        '_id' => 1,
        'title' => "The Shawshank Redemption",
        'genre' => "Drama",
        'director' => "Frank Darabont",
        'duration' => 142,
        'rating' => 9.3,
        'description' => "Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.",
        'actors' => ["Tim Robbins", "Morgan Freeman", "Bob Gunton"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 2,
        'title' => "The Godfather",
        'genre' => "Crime, Drama",
        'director' => "Francis Ford Coppola",
        'duration' => 175,
        'rating' => 9.2,
        'description' => "The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.",
        'actors' => ["Marlon Brando", "Al Pacino", "James Caan"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 3,
        'title' => "The Dark Knight",
        'genre' => "Action, Crime, Drama",
        'director' => "Christopher Nolan",
        'duration' => 152,
        'rating' => 9.0,
        'description' => "When the menace known as the Joker wreaks havoc and chaos on Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.",
        'actors' => ["Christian Bale", "Heath Ledger", "Aaron Eckhart"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 4,
        'title' => "Pulp Fiction",
        'genre' => "Crime, Drama",
        'director' => "Quentin Tarantino",
        'duration' => 154,
        'rating' => 8.9,
        'description' => "The lives of two mob hitmen, a boxer, a gangster's wife, and a pair of diner bandits intertwine in four tales of violence and redemption.",
        'actors' => ["John Travolta", "Uma Thurman", "Samuel L. Jackson"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 5,
        'title' => "Schindler's List",
        'genre' => "Biography, Drama, History",
        'director' => "Steven Spielberg",
        'duration' => 195,
        'rating' => 9.0,
        'description' => "In German-occupied Poland during World War II, industrialist Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.",
        'actors' => ["Liam Neeson", "Ralph Fiennes", "Ben Kingsley"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 6,
        'title' => "Forrest Gump",
        'genre' => "Drama, Romance",
        'director' => "Robert Zemeckis",
        'duration' => 142,
        'rating' => 8.8,
        'description' => "The presidencies of Kennedy and Johnson, the Vietnam War, the Watergate scandal and other historical events unfold from the perspective of an Alabama man with an IQ of 75, whose only desire is to be reunited with his childhood sweetheart.",
        'actors' => ["Tom Hanks", "Robin Wright", "Gary Sinise"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 7,
        'title' => "Fight Club",
        'genre' => "Drama",
        'director' => "David Fincher",
        'duration' => 139,
        'rating' => 8.8,
        'description' => "An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into much more.",
        'actors' => ["Brad Pitt", "Edward Norton", "Meat Loaf"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 8,
        'title' => "Inception",
        'genre' => "Action, Adventure, Sci-Fi",
        'director' => "Christopher Nolan",
        'duration' => 148,
        'rating' => 8.8,
        'description' => "A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.",
        'actors' => ["Leonardo DiCaprio", "Joseph Gordon-Levitt", "Elliot Page"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 9,
        'title' => "The Matrix",
        'genre' => "Action, Sci-Fi",
        'director' => "Lana Wachowski, Lilly Wachowski",
        'duration' => 136,
        'rating' => 8.7,
        'description' => "When a beautiful stranger leads computer hacker Neo to a forbidding underworld, he discovers the shocking truth—the life he knows is an elaborate deception of an evil cyber-intelligence.",
        'actors' => ["Keanu Reeves", "Laurence Fishburne", "Carrie-Anne Moss"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
    [
        '_id' => 10,
        'title' => "The Lord of the Rings: The Return of the King",
        'genre' => "Action, Adventure, Drama",
        'director' => "Peter Jackson",
        'duration' => 201,
        'rating' => 8.9,
        'description' => "Gandalf and Aragorn lead the World of Men against Sauron's army to draw his gaze from Frodo and Sam as they approach Mount Doom with the One Ring.",
        'actors' => ["Elijah Wood", "Viggo Mortensen", "Ian McKellen"],
        'added_date' => new MongoDB\BSON\UTCDateTime(),
        'available' => true
    ],
];

// Wstawianie danych do kolekcji
$result = $movies->insertMany($movieData);

echo "Inserted {$result->getInsertedCount()} movies successfully.";
?>
