<?php
require_once 'config/database.php';

if (isset($_GET['id'])) {
    // Sanitize and validate id
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    //  proceed if $id is valid and user is authenticated
    if ($id && isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
        // Fetch the user securely
        $query = "SELECT avatar FROM tribesmen WHERE id = ?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Check if user exists
        if ($result && mysqli_num_rows($result) === 1) {
            $tribesmen = mysqli_fetch_assoc($result);

            $image_name = trim($tribesmen["avatar"]);
            $image_path = '../images/' . $image_name;
            // Only delete if not a default image and file exists
            if (
                $image_name &&
                is_file($image_path) &&
                !str_contains($image_name, 'default') &&
                is_writable($image_path)
            ) {
                @unlink($image_path);
            }

            // --- Delete images belonging to the user's posts (scrolls) ---
            // Fetch images column from scrolls created by this user
            $select_images_query = "SELECT id, images FROM scrolls WHERE created_by = ?";
            $stmt_imgs = mysqli_prepare($connection, $select_images_query);
            if ($stmt_imgs) {
                mysqli_stmt_bind_param($stmt_imgs, "i", $id);
                mysqli_stmt_execute($stmt_imgs);
                $result_imgs = mysqli_stmt_get_result($stmt_imgs);

                if ($result_imgs) {
                    while ($scroll = mysqli_fetch_assoc($result_imgs)) {
                        $images_csv = isset($scroll['images']) ? $scroll['images'] : '';
                        // images are stored comma separated; split and delete each
                        $images = array_filter(array_map('trim', explode(',', $images_csv)));
                        foreach ($images as $img) {
                            // use basename to avoid path traversal
                            $img_file = basename($img);
                            if ($img_file) {
                                $img_path = '../images/' . $img_file;
                                if (is_file($img_path) && is_writable($img_path)) {
                                    @unlink($img_path);
                                }
                            }
                        }

                        // Clear images field for this scroll to avoid stale references
                        $update_scroll_query = "UPDATE scrolls SET images = '' WHERE id = ? LIMIT 1";
                        $stmt_upd = mysqli_prepare($connection, $update_scroll_query);
                        if ($stmt_upd) {
                            mysqli_stmt_bind_param($stmt_upd, "i", $scroll['id']);
                            mysqli_stmt_execute($stmt_upd);
                            mysqli_stmt_close($stmt_upd);
                        }
                    }
                }

                mysqli_stmt_close($stmt_imgs);
            }

            // Delete the user record from the database securely
            $delete_profile_query = "DELETE FROM tribesmen WHERE id = ? LIMIT 1";
            $stmt_del = mysqli_prepare($connection, $delete_profile_query);
            mysqli_stmt_bind_param($stmt_del, "i", $id);
            $delete_profile_result = mysqli_stmt_execute($stmt_del);

            if ($delete_profile_result) {
                // Destroy session if user deleted their own account
                session_unset();
                session_destroy();
                session_start();
                $_SESSION["delete_profile_success"] = "Account Deleted Successfully.";
                header("Location: " . ROOT_URL);
                exit;
            } else {
                $_SESSION["delete_profile"] = "Database Operation Failed!.";
                header('Location: ' . ROOT_URL . 'admin/');
                exit;
            }
        } else {
            $_SESSION["delete_profile"] = "User not found!.";
            header('Location: ' . ROOT_URL . 'admin/');
            exit;
        }
    } else {
        $_SESSION["delete_profile"] = "Unauthorized or invalid user!";
        header('Location: ' . ROOT_URL . 'admin/');
        exit;
    }
} else {
    $_SESSION["delete_profile"] = "Operation Failed!";
    header('Location: ' . ROOT_URL . 'admin/');
    exit;
}