<?php
require 'config/database.php';

// if submit is clicked 
if (isset($_POST['submit'])) {
    // sanitize user input
    $service_number_or_email = filter_var($_POST['service_number_or_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_human = filter_var($_POST['confirm_human'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate user input 
    if (!$service_number_or_email) {
        $_SESSION['signin'] = 'Enter Service Number or Email!';
    } elseif (!$password) {
        $_SESSION['signin'] = 'Enter Password!';
    } elseif (!empty($confirm_human)) {
        $_SESSION['signin'] = 'Somethings Are Made For Humans Only!';
    } else {
        // fetch user from db
        $fetch_tribesman_query = "SELECT * FROM tribesmen WHERE service_number = '$service_number_or_email' OR
        email = '$service_number_or_email'";
        $fetch_tribesmen_result = mysqli_query($connection, $fetch_tribesman_query);

        // find one matching record 
        if (mysqli_num_rows($fetch_tribesmen_result) == 1) {
            // convert record to assoc array 
            $tribesmen_record =  mysqli_fetch_assoc($fetch_tribesmen_result);
            $db_password = $tribesmen_record['password'];

            // Check if user is blocked
            if (isset($tribesmen_record['blocked']) && $tribesmen_record['blocked'] == 1) {
                header('location: ' . ROOT_URL . 'unauthorized.php');
                die();
            }

            //verify password
            if (password_verify($password, $db_password)) {
                // use tribesmen id to set session for access control
                $_SESSION['user_id'] = $tribesmen_record['id'];

                // set session if user is admin 
                if ($tribesmen_record['is_admin'] == '1') {
                    $_SESSION['user_is_admin'] = true;
                }

                // log user in
                $_SESSION["signin_success"] = "Welcome To The Elite Communications Platform";
                header("location: " . ROOT_URL . "admin/");
                die();

            } else {
                $_SESSION["signin"] = "Invalid Credentials!";
            }
        } else {
            $_SESSION["signin"] = "User Not Found!";
        }
    }

    // redirect back to login page with user input 
    if (isset($_SESSION["signin"])) {
        $_SESSION["signin_data"] = $_POST;
        header('location: ' . ROOT_URL);
        die();
    }
} else {
    header('location: ' . ROOT_URL);
    die();
}