<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Forgot Password</title>
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
                    <p class="sub-text">Enter your email address to reset your password</p>
                </td>
            </tr>
            <tr>
                <form action="send_reset_link.php" method="POST">
                <td class="label-td">
                    <label for="useremail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                </td>
            </tr>
            <tr>
                <td><br>
                    <input type="submit" value="Send Reset Link" class="login-btn btn-primary btn">
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
