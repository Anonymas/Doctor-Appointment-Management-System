<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Reset Password</title>
</head>
<body>
<div class="blur-background">
    <center>
    <div class="container">
        <table border="0" style="margin: 0;padding: 0;width: 60%;">
            <tr>
                <td>
                    <p class="header-text">Reset Your Password</p>
                </td>
            </tr>
            <a href="index.html" class="non-style-link"> <img src="prime_care_logo.png" alt="Prime Care Logo" class="melow"> </a>
        <div class="form-body">
            <tr>
                <td>
                    <p class="sub-text">Enter your new password</p>
                </td>
            </tr>
            <tr>
                <form action="update_password.php" method="POST">
                <td class="label-td">
                    <input type="hidden" name="reset_token" value="<?php echo $_GET['token']; ?>">
                    <label for="newpassword" class="form-label">New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="password" name="newpassword" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td><br>
                    <input type="submit" value="Reset Password" class="login-btn btn-primary btn">
                </td>
            </tr>
        </div>
                </form>
        </table>
    </div>
</div>
</center>
</body>
</html>
