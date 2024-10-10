<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection
require_once 'include/dbconnect.php';

// Get form data
$term = $_POST['f_term'] ?? '';
$definition = $_POST['f_definition'] ?? '';
$image_url = "";

// Determine if we are editing or deleting
$action = $_POST['action'] ?? '';
$flashcard_id = $_POST['id'] ?? '';

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png'];
    if (in_array($imageFileType, $allowedTypes)) {
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

// Handle edit operation
if ($action === 'edit' && !empty($flashcard_id)) {
    if ($image_url) {
        $sql = "UPDATE flashcard SET f_term = ?, f_definition = ?, f_image_url = ? WHERE flashcard_id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, 'sssi', $term, $definition, $image_url, $flashcard_id);
            if (mysqli_stmt_execute($stmt)) {
                // Redirect back to create_course.html after successful update
                header('Location: create_course.html'); // Pass a query parameter if needed
                exit(); // Always exit after a redirect
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($link);
        }
    } else {
        $sql = "UPDATE flashcard SET f_term = ?, f_definition = ? WHERE flashcard_id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, 'ssi', $term, $definition, $flashcard_id);
            if (mysqli_stmt_execute($stmt)) {
                // Redirect back to create_course.html after successful update
                header('Location: create_course.html'); // Pass a query parameter if needed
                exit(); // Always exit after a redirect
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
}


// Handle delete operation
elseif ($action === 'delete' && !empty($_POST['flashcard_id'])) {
    $flashcard_id = $_POST['flashcard_id'];  // Use the correct key from the form data
    $sql = "DELETE FROM flashcard WHERE flashcard_id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $flashcard_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "Record deleted successfully";
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($link);
    }
}
// Handle insert operation
else {
    $sql = "INSERT INTO flashcard (f_term, f_definition, f_image_url, created_at) VALUES (?, ?, ?, CURRENT_TIMESTAMP)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sss', $term, $definition, $image_url);
        if (mysqli_stmt_execute($stmt)) {
                // Redirect back to create_course.html after successful update
                header('Location: create_course.html'); // Pass a query parameter if needed
                exit(); // Always exit after a redirect
        } else {
            echo "Error: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($link);
    }
}

// Close the database connection
mysqli_close($link);
?>
