<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'include/dbconnect.php';

$deck_id = isset($_GET['deck_id']) ? intval($_GET['deck_id']) : 0;

// Fetch flashcards
$sql_flashcards = "SELECT f_term AS term, f_definition AS definition, f_image_url FROM flashcard WHERE deck_id = ?";
$stmt_flashcards = mysqli_prepare($link, $sql_flashcards);
mysqli_stmt_bind_param($stmt_flashcards, 'i', $deck_id);
mysqli_stmt_execute($stmt_flashcards);
$result_flashcards = mysqli_stmt_get_result($stmt_flashcards);

$flashcards = [];
if ($result_flashcards) {
    while ($row = mysqli_fetch_assoc($result_flashcards)) {
        $flashcards[] = $row;
    }
}
mysqli_stmt_close($stmt_flashcards);

// Fetch course details
$sql_course = "SELECT deckname AS name, description, created_at FROM flashcard_deck WHERE deck_id = ?";
$stmt_course = mysqli_prepare($link, $sql_course);
mysqli_stmt_bind_param($stmt_course, 'i', $deck_id);
mysqli_stmt_execute($stmt_course);
$result_course = mysqli_stmt_get_result($stmt_course);

$course = mysqli_fetch_assoc($result_course);
mysqli_stmt_close($stmt_course);

mysqli_close($link);

// Set the content type to JSON
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode([
    'course' => $course,
    'flashcards' => $flashcards
]);
?>