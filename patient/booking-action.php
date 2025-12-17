<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- CSS-->
        <link rel="stylesheet" href="../css/style1.css">
        <link rel="stylesheet" href="../css/main.css"> 
       
                
          <!--  Boxicons CSS-->
          <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
          <title>
           PRIMECARE HEALTH
          </title>
          <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
</style>
    

    </head>
    <body>
<?php
session_start();

// Redirect if the user is not logged in or not a patient
if (!isset($_SESSION["user"]) || $_SESSION["user"] == "" || $_SESSION['usertype'] != 'p') {
    header("location: ../login.php");
    exit(); // Added to prevent further execution
}

// Import database connection
include("../connection.php");

// Get user details
$useremail = $_SESSION["user"];
$userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];
$usertel = $userfetch["ptel"];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["booknow"])) {
    // Get data from the form
    $apponum = $_POST["apponum"];
    $scheduleid = $_POST["scheduleid"];
    $date = $_POST["date"];
   

// Check if the patient has already booked this session on the same date
$sql = "SELECT COUNT(*) AS existing_booking FROM appointment WHERE scheduleid = $scheduleid AND pid = $userid AND appodate = '$date'";
$result = $database->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row["existing_booking"] > 0) {
        echo '
        <div id="popup1" class="overlay">
        <div class="popup">
            <center>
                <h2>BOOKING ERROR OCCURED</h2>
                <a class="close" href="schedule.php" onclick="closePopup()">×</a>
                <div class="content">
                    <p>You Cannot Book The Same Appointment Twice! </p> </br>
                    <p>Please Confirm Which Session You Are Booking... </p>
                </div>
                <div style="display: flex;justify-content: center;">
                
                <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                <br><br><br><br>
                </div>
            </center>
        </div>
    </div>
    ';
    echo '<script>document.getElementById("maxPatientsPopup").style.display = "block";</script>';
    exit(); // Added to prevent further execution

    }
}
    // Get the maximum number of patients for the session
    $sql = "SELECT nop FROM schedule WHERE scheduleid = $scheduleid";
    $result = $database->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $max_nop = $row["nop"];

        // Get the current number of bookings for the session
        $sql = "SELECT COUNT(*) AS booked_count FROM appointment WHERE scheduleid = $scheduleid";
        $result = $database->query($sql);
        $row = $result->fetch_assoc();
        $current_booked = $row["booked_count"];

        //Check if the session is full
        if ($current_booked < $max_nop) {
            // Insert the booking into the database
            $sql2 = "INSERT INTO appointment (pid, apponum, scheduleid, appodate, ptel, pname) VALUES ($userid, $apponum, $scheduleid, '$date', '$usertel', '$username')";
            if ($database->query($sql2)) {
                header("location: appointment.php?action=booking-added&id=$apponum&titleget=none");
                exit(); // Added to prevent further execution
            } else {
                header("location: schedule.php?action=error&message=Booking failed");
                exit(); // Added to prevent further execution
            }
        } else {
            // Maximum number of patients reached, display popup message
            echo '
            <div id="popup1" class="overlay">
                <div class="popup">
                    <center>
                        <h2>MAXIMUM APPOINTMENTS</h2>
                        <a class="close" href="schedule.php" onclick="closePopup()">×</a>
                        <div class="content">
                            <p>The Maximum Number Of Patients For This Session Has Been Reached.</p> </br>
                            <p>Please Wait Patiently As we Create More Sessions ! </p>
                        </div>
                        <div style="display: flex;justify-content: center;">
                        
                        <a href="schedule.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
                </div>
            </div>
            ';
            echo '<script>document.getElementById("maxPatientsPopup").style.display = "block";</script>';
            exit(); // Added to prevent further execution
        }
    } else {
        // Session not found
        header("location: schedule.php?action=error&message=Session not found");
        exit(); // Added to prevent further execution
    } 
}
?>


</body>
</html>
