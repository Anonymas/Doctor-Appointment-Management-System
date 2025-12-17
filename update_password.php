<?php
include("connection.php");

if ($_POST) {
    $reset_token = $_POST['reset_token'];
    $newpassword = $_POST['newpassword'];

    // Check if the reset token is valid
    $result = $database->query("select * from webuser where reset_token='$reset_token'");

    if ($result->num_rows == 1) {
        // Update the password in the database
        $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
        $database->query("update webuser set password='$hashed_password', reset_token=NULL where reset_token='$reset_token'");
        echo "Your password has been updated.";
    } else {
        echo "Invalid or expired reset token.";
    }
}
?>
