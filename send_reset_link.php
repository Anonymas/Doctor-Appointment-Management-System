<?php
include("connection.php"); // Includes the database connection file

if ($_POST) {
    $email = $_POST['useremail'];
    $result = $database->query("select * from webuser where email='$email'");

    if ($result->num_rows == 1) {
        // Generate a unique reset token
        $reset_token = bin2hex(random_bytes(50));

        // Store the reset token in the database against the user
        $database->query("update webuser set reset_token='$reset_token' where email='$email'");

        // Send reset link to the user's email
        $reset_link = "http://yourwebsite.com/reset_password.php?token=" . $reset_token;
        $subject = "Password Reset Request";
        $message = "Click on the link below to reset your password:\n" . $reset_link;
        $headers = "From: no-reply@yourwebsite.com";

        mail($email, $subject, $message, $headers);

        echo "A password reset link has been sent to your email.";
    } else {
        echo "No account found with this email address.";
    }
}
?>
