<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once 'include/dbconnect.php';

// Get form data
$term = $_POST['term'] ?? '';
$definition = $_POST['definition'] ?? '';
$image_url = "";

// Check if an image was uploaded
if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Validate file type (optional but recommended)
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png'];
    if (in_array($imageFileType, $allowedTypes)) {
        // Check file size (e.g., max 2MB)
        if ($_FILES["image"]["size"] <= 2000000) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_url = $target_file;
            } else {
                die("Failed to upload file.");
            }
        } else {
            die("File is too large.");
        }
    } else {
        die("Invalid file type.");
    }
}

// Prepare an SQL query with placeholders
$sql = "INSERT INTO flashcard (f_term, f_definition, f_image_url, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";

// Initialize prepared statement
if ($stmt = mysqli_prepare($link, $sql)) {
    
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, 'sss', $term, $definition, $image_url);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        // Redirect on success
        header("Location: create_course.html");
        exit();
    } else {
        // If an error occurred, output it
        die("Error: " . mysqli_stmt_error($stmt));
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    // In case of preparation failure
    die("Error: " . mysqli_error($link));
}

// Close the database connection
mysqli_close($link);
?>
