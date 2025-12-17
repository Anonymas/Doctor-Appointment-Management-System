<!DOCTYPE html> <!-- Declares the document type and version of HTML -->
<html lang="en"> <!-- Specifies the language of the document -->
<head>
    <meta charset="UTF-8"> <!-- Sets the character encoding for the document -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Instructs Internet Explorer to use its latest rendering engine -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Sets the viewport properties for responsive design -->
    <link rel="stylesheet" href="css/main.css"> <!-- Links to an external CSS file for main styles -->
    <link rel="stylesheet" href="css/signup.css"> <!-- Links to an external CSS file for signup page styles -->
        
    <title>Sign Up</title> <!-- Sets the title of the page -->
    
</head>
<body>
<div class="blur-background">
<?php
//Unset all the server side variables

session_start(); // Starts the session to maintain data across multiple pages

$_SESSION["user"]=""; // Initializes session variable "user" to an empty string
$_SESSION["usertype"]=""; // Initializes session variable "usertype" to an empty string

// Set the new timezone
date_default_timezone_set('Africa/Nairobi'); // Sets the default timezone to Africa/Nairobi
$date = date('Y-m-d'); // Retrieves the current date in the format 'Year-Month-Day'
$_SESSION["date"]=$date; // Sets the session variable "date" to the current date

if($_POST){ // Checks if there is POST data submitted

    

    $_SESSION["personal"]=array( // Stores personal details in a session array
        'fname'=>$_POST['fname'], // Retrieves and stores the first name from the form
        'lname'=>$_POST['lname'], // Retrieves and stores the last name from the form
        'address'=>$_POST['address'], // Retrieves and stores the address from the form
        'idnumber'=>$_POST['idnumber'], // Retrieves and stores the ID number from the form
        'dob'=>$_POST['dob'] // Retrieves and stores the date of birth from the form
    );


    print_r($_SESSION["personal"]); // Outputs the stored personal details
    header("location: create-account.php"); // Redirects to the create-account page

}

?>


    <center>
    <div class="container"> <!-- Starts a container div -->
        <table border="0"> <!-- Starts a table -->
            <tr> <!-- Starts a table row -->
                <td colspan="2"> <!-- Starts a table data cell spanning two columns -->
                    <p class="header-text">Let's Get Started!</p> <!-- Displays a header text -->
                    <p class="sub-text">Add Your Personal Details to Continue</p> <!-- Displays a sub-text -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <a href="index.html" class="non-style-link"> <img  src="prime_care_logo.png"  alt="Prime Care Logo" class="melow"> </a> <!-- Displays an image linked to the homepage -->
                    <tr> <!-- Starts a table row -->
                <form action="" method="POST" > <!-- Starts a form for user signup -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                    <label for="name" class="form-label">Name: </label> <!-- Displays a label for name input -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td"> <!-- Starts a table data cell with specific class -->
                    <input type="text" name="fname" class="input-text" placeholder="First Name" required> <!-- Displays an input field for first name -->
                </td> <!-- Ends the table data cell -->
                <td class="label-td"> <!-- Starts a table data cell with specific class -->
                    <input type="text" name="lname" class="input-text" placeholder="Last Name" required> <!-- Displays an input field for last name -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                    <label for="address" class="form-label">Address: </label> <!-- Displays a label for address input -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                    <input type="text" name="address" class="input-text" placeholder="Address" required> <!-- Displays an input field for address -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                    <label for="idnumber" class="form-label">ID Number</label> <!-- Displays a label for ID number input -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                    <input type="text" name="idnumber" class="input-text" placeholder="ID Number" required> <!-- Displays an input field for ID number -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
             <tr> <!-- Starts a table row -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                    <label for="dob" class="form-label">Date of Birth: </label> <!-- Displays a label for date of birth input -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                    <input type="date" name="dob" class="input-text" required> <!-- Displays an input field for date of birth -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td class="label-td" colspan="2"> <!-- Starts a table data cell with specific class spanning two columns -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->

            <tr> <!-- Starts a table row -->
                <td> <!-- Starts a table data cell -->
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" > <!-- Displays a reset button -->
                </td> <!-- Ends the table data cell -->
                <td> <!-- Starts a table data cell -->
                    <input type="submit" value="Next" class="login-btn btn-primary btn"> <!-- Displays a submit button -->
                </td> <!-- Ends the table data cell -->

            </tr> <!-- Ends the table row -->
            <tr> <!-- Starts a table row -->
                <td colspan="2"> <!-- Starts a table data cell spanning two columns -->
                    <br> <!-- Line break -->
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label> <!-- Displays a sub-text -->
                    <a href="login.php" class="hover-link1 non-style-link">Login</a> <!-- Displays a link to the login page -->
                    <br><br><br> <!-- Line breaks -->
                </td> <!-- Ends the table data cell -->
            </tr> <!-- Ends the table row -->

                    </form> <!-- Ends the form -->
            </tr> <!-- Ends the table row -->
        </table> <!-- Ends the table -->

    </div> <!-- Ends the container div -->
</div>
</center> <!-- Centers the content -->
</body>
</html> <!-- Ends the HTML document --> 
