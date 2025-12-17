<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>Create Account</title>
    <style>
        .container {
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
<div class="blur-background">
<?php

//Unset all the server side variables

session_start();

$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

// Set the new timezone
date_default_timezone_set('Africa/Nairobi');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

// Import database
include("connection.php");

$errorlist = array(
    '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
    '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>',
    '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
    '4' => "",
    '5' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid Email Format. Please enter a valid Email Address.</label>',
    '6' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password must be at least 8 characters long, include an upper case letter, a lower case letter, and a special character.</label>',
    '0' => "",
);

$error = $errorlist['0']; // Default to no error message

if ($_POST) {
    $result = $database->query("select * from webuser");

    $fname = $_SESSION['personal']['fname'];
    $lname = $_SESSION['personal']['lname'];
    $name = $fname . " " . $lname;
    $address = $_SESSION['personal']['address'];
    $idnumber = $_SESSION['personal']['idnumber'];
    $dob = $_SESSION['personal']['dob'];
    $email = $_POST['newemail'];
    $country_code = $_POST["country_code"];
    $tele = $_POST['tele'];
    $ptel = $country_code . $tele;
    $newpassword = $_POST['newpassword'];
    $cpassword = $_POST['cpassword'];

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = $errorlist['5'];
    } elseif (!preg_match('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}/', $newpassword)) {
        $error = $errorlist['6'];
    } elseif ($newpassword != $cpassword) {
        $error = $errorlist['2'];
    } else {
        $result = $database->query("select * from webuser where email='$email';");
        if ($result->num_rows == 1) {
            $error = $errorlist['1'];
        } else {
            $database->query("insert into patient(pemail,pname,ppassword, paddress,pidnumber,pdob,ptel) values('$email','$name','$newpassword','$address', '$idnumber','$dob','$ptel');");
            $database->query("insert into webuser values('$email','p','')");

            $_SESSION["user"] = $email;
            $_SESSION["usertype"] = "p";
            $_SESSION["username"] = $fname;

            header('Location: patient/index.php');
            exit;
        }
    }
}

?>

<center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <p class="header-text">Let's Get Started!</p>
                    <p class="sub-text">Add Your Personal Details to Continue.</p>
                </td>
            </tr>
            <a href="index.html" class="non-style-link"> <img src="prime_care_logo.png" alt="Prime Care Logo" class="melow"> </a>
            <tr>
                <form action="" method="POST">
                    <td class="label-td" colspan="2">
                        <label for="newemail" class="form-label">Email: </label>
                    </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="newemail" class="input-text" placeholder="Email Address" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Must be a valid email">
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="tele" class="form-label">Mobile Number: </label>
                </td>
            </tr>
            <tr>
        <td class="label-td" colspan="2">
            <select name="country_code" class="input-select" required>
                <option value="+254">+254 Kenya</option>
                <option value="+1">+1 USA</option>
                <option value="+44">+44 UK</option>
                <option value="+91">+91 India</option>
                <!-- Add more country codes as needed -->
            </select>
            <input type="tel" name="tele" class="input-text" placeholder="Example: 714987654" pattern="[0-9]{9}" required>
        </td>
    </tr>

            <tr>
                <td class="label-td" colspan="2">
                    <label for="newpassword" class="form-label">Create New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="newpassword" class="input-text" placeholder="New Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least 8 characters, including UPPER/lowercase and numbers and special characters">
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Confirm Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least 8 characters, including UPPER/lowercase and numbers and special characters">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $error ?> <!-- Displays error message -->
                </td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                </td>
                <td>
                    <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>
        </table>
    </div>
</center>
</body>
</html>
