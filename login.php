<!DOCTYPE html> <!-- Declares the document type and version of HTML -->
<html lang="en"> <!-- Specifies the language of the document -->
<head>
    <meta charset="UTF-8"> <!-- Sets the character encoding for the document -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Instructs Internet Explorer to use its latest rendering engine -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Sets the viewport properties for responsive design -->
    <link rel="stylesheet" href="css/main.css"> <!-- Links to an external CSS file for main styles -->
    <link rel="stylesheet" href="css/login.css"> <!-- Links to an external CSS file for login page styles -->
        
    <title>Login</title> <!-- Sets the title of the page -->
</head>
<body>
<div class="blur-background">
    <?php
    session_start(); // Starts the session to maintain data across multiple pages

    $_SESSION["user"]=""; // Initializes session variable "user" to an empty string
    $_SESSION["usertype"]=""; // Initializes session variable "usertype" to an empty string
    
    // Set the new timezone
    date_default_timezone_set('Africa/Nairobi'); // Sets the default timezone to Africa/Nairobi

    $date = date('Y-m-d'); // Retrieves the current date in the format 'Year-Month-Day'

    $_SESSION["date"]=$date; // Sets the session variable "date" to the current date

    // Import database
    include("connection.php"); // Includes a PHP file to establish a database connection

    if($_POST){ // Checks if there is POST data submitted
        $email = $_POST['useremail']; // Retrieves the submitted email from the form
        $password = $_POST['userpassword']; // Retrieves the submitted password from the form
        
        $error = '<label for="promter" class="form-label"></label>'; // Initializes error message variable

        $result = $database->query("select * from webuser where email='$email'"); // Queries the database to select user data based on the submitted email
        if($result->num_rows == 1){ // Checks if a user with the submitted email exists
            $utype = $result->fetch_assoc()['usertype']; // Retrieves the user type from the database result
            if ($utype == 'p'){ // Checks if the user type is 'p' (patient)
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'"); // Queries the patient table to validate the email and password
                if ($checker->num_rows == 1){ // Checks if the credentials match a patient record
                    // Patient dashboard
                    $_SESSION['user'] = $email; // Sets the session variable "user" to the email
                    $_SESSION['usertype'] = 'p'; // Sets the session variable "usertype" to 'p' (patient)
                    header('location: patient/index.php'); // Redirects to the patient dashboard page
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>'; // Sets an error message for invalid credentials
                }
            } elseif ($utype == 'a'){ // Checks if the user type is 'a' (admin)
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'"); // Queries the admin table to validate the email and password
                if ($checker->num_rows == 1){ // Checks if the credentials match an admin record
                    // Admin dashboard
                    $_SESSION['user'] = $email; // Sets the session variable "user" to the email
                    $_SESSION['usertype'] = 'a'; // Sets the session variable "usertype" to 'a' (admin)
                    header('location: admin/index.php'); // Redirects to the admin dashboard page
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>'; // Sets an error message for invalid credentials
                }
            } elseif ($utype == 'd'){ // Checks if the user type is 'd' (doctor)
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'"); // Queries the doctor table to validate the email and password
                if ($checker->num_rows == 1){ // Checks if the credentials match a doctor record
                    // Doctor dashboard
                    $_SESSION['user'] = $email; // Sets the session variable "user" to the email
                    $_SESSION['usertype'] = 'd'; // Sets the session variable "usertype" to 'd' (doctor)
                    header('location: doctor/index.php'); // Redirects to the doctor dashboard page
                } else {
                    $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>'; // Sets an error message for invalid credentials
                }
            }
        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cant find any account for this email.</label>'; // Sets an error message for non-existing email
        }
    } else {
        $error = '<label for="promter" class="form-label">&nbsp;</label>'; // Sets an empty label if no POST data is submitted
    }
    ?>
    <center>
    <div class="container"> <!-- Starts a container div -->
        <table border="0" style="margin: 0;padding: 0;width: 60%;"> <!-- Creates a table with specific styling -->
            <tr> <!-- Starts a table row -->
                <td> <!-- Starts a table data cell -->
                    <p class="header-text">Login Here!</p> <!-- Displays a header text -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <a href="index.html" class="non-style-link"> <img src="prime_care_logo.png" alt="Prime Care Logo" class="melow"> </a> <!-- Displays an image linked to the homepage -->
        <div class="form-body"> <!-- Starts a div for form elements -->
            <tr> <!-- Starts a table row -->
                <td> <!-- Starts a table data cell -->
                    <p class="sub-text">Login with your details to continue</p> <!-- Displays a sub-text -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <form action="" method="POST"> <!-- Starts a form for user login -->
                <td class="label-td"> <!-- Starts a table data cell with specific class -->
                    <label for="useremail" class="form-label">Email: </label> <!-- Displays a label for email input -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td"> <!-- Starts a table data cell with specific class -->
                    <input type="email" name="useremail" class="input-text" placeholder="Email Address" required> <!-- Displays an email input field -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td"> <!-- Starts a table data cell with specific class -->
                    <label for="userpassword" class="form-label">Password: </label> <!-- Displays a label for password input -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td"> <!-- Starts a table data cell with specific class -->
                    <input type="password" name="userpassword" class="input-text" placeholder="Password" required> <!-- Displays a password input field -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td><br> <!-- Starts a table data cell with line break -->
                <?php echo $error ?> <!-- Displays error message -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td> <!-- Starts a table data cell -->
                    <input type="submit" value="Login" class="login-btn btn-primary btn"> <!-- Displays a login button -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
        </div> <!-- Ends the form-body div -->
            <tr> <!-- Starts a table row -->
                <td> <!-- Starts a table data cell -->
                    <br> <!-- Line break -->
                    <label for="" class="sub-text" style="font-weight: 280;">Don't have an account&#63; </label> <!-- Displays a sub-text -->
                    <a href="signup.php" class="hover-link1 non-style-link">Sign Up</a> <!-- Displays a link to the signup page -->
                    <br><br>
                    <a href="forgot_password.php" class="hover-link1 non-style-link">Forgot Password?</a> <!-- Displays a link to the forgot password page -->
                    <br><br><br> <!-- Line breaks -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
        </form> <!-- Ends the form -->
        </table> <!-- Ends the table -->
    </div> <!-- Ends the container div -->
</div>
</center> <!-- Centers the content -->
</body>
</html> <!-- Ends the HTML document -->
