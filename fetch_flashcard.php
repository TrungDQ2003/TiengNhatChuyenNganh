<?php
require_once 'dbconnect.php';

$sql = "SELECT word AS f_term, f_definition FROM flashcard";
$result = mysqli_query($link, $sql);
$flashcards = [];
if ($result) {
    // Fetch the data as an associative array
    while ($row = mysqli_fetch_assoc($result)) {
        $flashcards[] = $row;
    }
}

// Close the database connection
mysqli_close($link);

header('Content-Type: application/json');


// Return the data as a JSON response
echo json_encode($flashcards);
?>