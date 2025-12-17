<?php
session_start();

if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
    }
} else {
    header("location: ../login.php");
}

if ($_POST) {
    include("../connection.php");

    $title = $_POST["title"];
    $docid = $_POST["docid"];
    $nop = $_POST["nop"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    
    if (isset($_POST["scheduleid"]) && !empty($_POST["scheduleid"])) {
        $scheduleid = $_POST["scheduleid"];

        $sql = "UPDATE schedule SET title='$title', scheduledate='$date', scheduletime='$time', nop=$nop, docid='$docid' WHERE scheduleid=$scheduleid;";
        
        if ($database->query($sql) === TRUE) {
            header("location: schedule.php?action=session-updated&title=$title");
        } else {
            echo "Error updating record: " . $database->error;
        }
    } else {
        echo "Error: scheduleid is not set or is empty.";
    }
}
        // Redirects to the schedule page with an action and title in the query string
        header("location: schedule.php?action=session-added&title=$title");
?>


    }
