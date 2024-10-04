<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'include/dbconnect.php';

$sql = "SELECT f_term AS term, f_definition AS definition, f_image_url FROM flashcard";
$result = mysqli_query($link, $sql);

$flashcards = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $flashcards[] = $row;
    }
}

mysqli_close($link);

// Set the content type to JSON
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode($flashcards);
?>