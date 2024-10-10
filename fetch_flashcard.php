<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'include/dbconnect.php';

<<<<<<< HEAD
// Get the flashcard_id from the query parameters (if any)
$flashcard_id = $_GET['id'] ?? '';

if ($flashcard_id) {
    // Case 1: Fetch a specific flashcard by flashcard_id
    $sql = "SELECT flashcard_id, f_term AS term, f_definition AS definition, f_image_url FROM flashcard WHERE flashcard_id = ?";
    
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind the flashcard_id as an integer
        mysqli_stmt_bind_param($stmt, 'i', $flashcard_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($flashcard = mysqli_fetch_assoc($result)) {
            // Return the flashcard details as JSON
            echo json_encode($flashcard);
        } else {
            echo json_encode(['error' => 'Flashcard not found']);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
=======
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
>>>>>>> 076dd5082e2c3f11f8295c55997c751c90450cd8
    }
} else {
    // Case 2: Fetch all flashcards (used in create_course.html)
    $sql = "SELECT flashcard_id, f_term AS term, f_definition AS definition, f_image_url FROM flashcard";
    $result = mysqli_query($link, $sql);

    $flashcards = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $flashcards[] = $row;
        }
    }

    // Set the content type to JSON and return all flashcards
    header('Content-Type: application/json');
    echo json_encode($flashcards);
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
<<<<<<< HEAD
?>
=======

// Set the content type to JSON
header('Content-Type: application/json');

// Return the data as a JSON response
echo json_encode([
    'course' => $course,
    'flashcards' => $flashcards
]);
?>
>>>>>>> 076dd5082e2c3f11f8295c55997c751c90450cd8
