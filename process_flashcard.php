<?php
include './include/dbconnect.php';
require_once './include/dbconnect.php';

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $term = $conn->real_escape_string($_POST['term']);
    $definition = $conn->real_escape_string($_POST['definition']);
    
    // Handle file upload
    $image_url = "";
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_url = $target_file;
        }
    }

    // Insert data into database
    $sql = "INSERT INTO flashcard (word, meaning, image_url, created_at) 
            VALUES ('$term', '$definition', '$image_url', CURRENT_TIMESTAMP)";

    if ($conn->query($sql) === TRUE) {
        echo "New flashcard created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();

    // Redirect back to create_course.html
    header("Location: create_course.html");
    exit();
}
?>