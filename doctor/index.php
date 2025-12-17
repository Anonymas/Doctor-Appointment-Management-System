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
        
    
    </head>
    <body>

    <?php


session_start();

if(isset($_SESSION["user"])){
    if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
        header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }

}else{
    header("location: ../login.php");
}


//import database
include("../connection.php");
$userrow = $database->query("select * from doctor where docemail='$useremail'");
$userfetch=$userrow->fetch_assoc();
$userid= $userfetch["docid"];
$username=$userfetch["docname"];

?>

<nav class="sidebar close"> 
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../img/prime_care_logo.jpg" alt="logo">
            </span=>

            <div class="text header-text"> 
                <span class="name"> <?php echo substr($username,0,13)  ?>..</span>
                <span class="profession"> <?php echo substr($useremail,0,22) ?> </span>
            </div>

            </div>

        <i class='bx bx-chevron-right toggle' ></i>
    </header>  
    
<div class="menu-bar">
    <div class="menu">
        <li class="search-box">
            <a href="#">
                <i class='bx bx-search icon'></i>
                <input type="text" placeholder="Search ..." >
                </a>
        </li>
        <ul class="menu-links">
            <li class="nav-link">
                <a href="index.php">
                    <i class='bx bx-home-alt icon'></i>
                    <span class="text nav-text"> Dashboard</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="schedule.php">
                    <i class='bx bx-plus-medical icon'></i>
                    <span class="text nav-text">Sessions </span>
                </a>
            </li>
            <li class="nav-link">
                <a href="appointment.php">
                    <i class='bx bx-bar-chart-alt-2 icon'></i>
                    <span class="text nav-text"> Appointments</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="patient.php">
                    <i class='bx bxs-capsule icon'></i>
                    <span class="text nav-text"> Patients</span>
                </a>
            </li>
            <li class="nav-link">
                <a href="settings.php">
                    <i class='bx bx-cog icon'></i>
                    <span class="text nav-text"> Settings</span>
                </a>
            </li>
        </ul>
    </div>
   
<div class="bottom-content">
    <li class=""> 
            <a href="../logout.php">
        <i class='bx bx-log-out icon'></i>
         <span class="text nav-text">  Logout</span> 
    </a>
</li>

    <li class="mode">
       <div class="moon-sun">
        <i class='bx bx-moon icon moon'></i>
        <i class='bx bx-sun icon sun'></i>
       </div>

       <span class="mode-text text"> Dark Mode</span>

<div class="toggle-switch">
<span class="switch"></span>
</div>
    </li>
            </div>
        </div>
     </nav>
<section class="home">
    <div class="text">Dashboard </div>
    <div class="container">
    <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                            <td colspan="2" class="nav-bar" >
                                
                                
                            </td>
    <td width="15%">
                                <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                    System's Date
                                </p>
                                <p class="heading-sub12" style="padding: 0;margin: 0;">
                                    <?php 
                                date_default_timezone_set('Africa/Nairobi');
        
                                $today = date('Y-m-d');
                                echo $today;
                                
                                ?>
                                </p>
                            </td>
                            <td width="10%">
                                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                            </td>
        
        
                        </tr>
                        <tr>
                    <td colspan="4">
                    <div style="height: 200px;">
        <img src="../hospital.jpg" alt="Hospital" style="width:100%; max-height: 200%;">
    </div>
                       
    <section class="hero-section">
    <div class="content">
        <h1>WELCOME TO PRIMECARE HEALTH.</h1>
        <p>
        Don't Worry! Here you Can View Your Appointments And Find Your Patients Online Anytime And from Anywhere.<br>
              View Your Sessions And Appointments As You Wish With Prime Care...
        </p>
        <button onclick="location.href='appointment.php'">
           View Appointments
        </button>
    
        </div>
    </div>
    </section>

<script src="../js/script.js"></script>

    </body>
</html>
