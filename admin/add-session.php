<?php
    // Starts a new session or resumes an existing session
    session_start();

    // Checks if a user session is set
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
    
    // Checks if the form has been submitted via POST method
    if ($_POST) {
        // Includes the database connection file
        include("../connection.php");

        // Retrieves form data from the POST request
        $title = $_POST["title"];
        $docid = $_POST["docid"];
        $nop = $_POST["nop"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        // SQL query to insert the new schedule into the database
        $sql = "insert into schedule (docid, title, scheduledate, scheduletime, nop) values ($docid, '$title', '$date', '$time', $nop);";

        // Executes the SQL query
        $result = $database->query($sql);

        // Redirects to the schedule page with an action and title in the query string
        header("location: schedule.php?action=session-added&title=$title");
    }
?>
