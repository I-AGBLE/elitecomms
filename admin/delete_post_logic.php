<?php 
require 'config/database.php';



if (isset($_GET['id'])) {
// sanitize id 
$id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

// Fetch the post (scroll) securely using a prepared statement
$query = "SELECT * FROM scrolls WHERE id = ?";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


// Check if scroll exists
if (mysqli_num_rows($result) == 1) {
    $scroll = mysqli_fetch_assoc($result);
    // Get the images stored for the scroll
    $image_names = explode(',', $scroll["images"]);  // Assuming multiple images are stored as a comma-separated list

// Delete each image if it exists on the server
foreach ($image_names as $image_name) {
    $image_path = '../images/' . trim($image_name);  // Ensure no extra spaces
    if (is_file($image_path)) {
        unlink($image_path);  // Delete the image from the server
    }
}


    // Delete the scroll record from the database
    $delete_scroll_query = "DELETE FROM scrolls WHERE id=$id LIMIT 1";
    $delete_scroll_result = mysqli_query($connection, $delete_scroll_query);

    // Check if the deletion was successful
    if (!mysqli_errno($connection)) {
        $_SESSION["delete_scroll_success"] = "Scroll Deleted Successfully.";
        header("location: " . ROOT_URL . "admin/user_profile.php");
        die();
    }
}




} else {
    header('location: ' . ROOT_URL .'admin/user_profile.php');
    die();
}