<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Specifies the document type and sets the language to English -->
    <meta charset="UTF-8">
    <!-- Ensures compatibility with older versions of Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Sets the viewport to make the website look good on all devices -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Links to external CSS stylesheets -->
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/style1.css">
    <!-- Sets the title of the webpage -->
    <title>Administrator</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
            /* Adds a transition animation to elements with the class "popup" */
        }
    </style>
</head>
<body>
    <?php
    // Starts the session
    session_start();

    // Checks if a user session exists
    if (isset($_SESSION["user"])) {
        // Checks if the user session is empty or if the user type is not 'a' (admin)
        if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
            // Redirects to the login page if conditions are met
            header("location: ../login.php");
        }
    } else {
        // Redirects to the login page if no user session exists
        header("location: ../login.php");
    }

    // Includes the database connection file
    include("../connection.php");

    // Checks if the form has been submitted
    if ($_POST) {
        // Retrieves all records from the "webuser" table
        $result = $database->query("select * from webuser");

        // Gets the form data from the POST request
        $name = $_POST['name'];
        $idnumber = $_POST['idnumber'];
        $email = $_POST['email'];
        $tele = $_POST['Tele'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        // Checks if the password and confirm password match
        if ($password == $cpassword) {
            $error = '3'; // Sets an initial error code

            // Checks if the email already exists in the "webuser" table
            $result = $database->query("select * from webuser where email='$email';");
            if ($result->num_rows == 1) {
                $error = '1'; // Sets error code if email exists
            } else {
                // Inserts the new admin's details into the "admin" table
                $sql1 = "insert into admin(aemail,aname,apassword,aidnumber,atel) values('$email','$name','$password','$idnumber','$tele');";
                // Inserts the new user's details into the "webuser" table
                $sql2 = "insert into webuser values('$email','a','')";
                $database->query($sql1);
                $database->query($sql2);

                $error = '4'; // Sets success code
            }
        } else {
            $error = '2'; // Sets error code if passwords do not match
        }
    } else {
        $error = '3'; // Sets an initial error code if no POST request
    }

    // Redirects to the admin page with an action and error code in the query string
    header("location: admin.php?action=add&error=" . $error);
    ?>
</body>
</html>
