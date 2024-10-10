<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'include/dbconnect.php';

// Check if the connection was successful
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT fd.deck_id, fd.deckname AS name, fd.description, fd.created_at, COUNT(f.flashcard_id) AS term_count, u.username AS creator
        FROM flashcard_deck fd
        LEFT JOIN flashcard f ON fd.deck_id = f.deck_id
        LEFT JOIN users u ON fd.user_id = u.user_id
        GROUP BY fd.deck_id, fd.deckname, fd.description, fd.created_at, u.username";

$result = mysqli_query($link, $sql);

// Check if the query was successful
if (!$result) {
    die("ERROR: Could not execute query: $sql. " . mysqli_error($link));
}

$decks = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $decks[] = $row;
    }
}

// Debugging: Output the decks array
var_dump($decks);


mysqli_close($link);

// Set the content type to JSON
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode($decks);
?>