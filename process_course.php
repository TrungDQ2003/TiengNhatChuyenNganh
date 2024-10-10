<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once 'include/dbconnect.php';

// Check if the request method is POST and the create_course button was clicked
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_course'])) {
    $deck_name = $_POST['deck_name']; // Get the name of the deck from the form
    $description = $_POST['description']; // Get the description

    // Prepare the SQL statement to insert a new flashcard deck
    $sql = "INSERT INTO flashcard_deck (deck_name, description, created_at) VALUES (?, ?, NOW())"; // Using NOW() for created_at
    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind parameters (deck_name and description are strings)
        mysqli_stmt_bind_param($stmt, 'ss', $deck_name, $description);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Redirect to HomePage.html after successful creation
            header('Location: HomePage.html'); // Redirect to the home page
            exit(); // Always exit after a redirect
        } else {
            // Handle execution error
            echo "Error executing query: " . mysqli_error($link);
        }
        mysqli_stmt_close($stmt);
    } else {
        // Handle preparation error
        echo "Error preparing statement: " . mysqli_error($link);
    }
}

// Close the database connection
mysqli_close($link);
?>
