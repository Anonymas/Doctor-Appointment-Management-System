<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS-->
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="stylesheet" href="../css/main.css"> 
    <!-- Boxicons CSS-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>PRIMECARE HEALTH</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sessions-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .sessions-table th, .sessions-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .sessions-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .sessions-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .search-box-container {
            text-align: center;
            margin-bottom: 20px;
         
        }
        .search-input {
            font-size: 20px;
            color: #333;
            padding: 50px 70px;
            border: 1px solid #ccc;
            border-radius: 20px;
            width: 90%;
            max-width: 1000px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .search-btn {
            font-size: 18px;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #4CAF50;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-btn:hover {
            background-color: #45a049;
        }
        .top-bar {
            display: flex;
            justify-content: center; /* Center the elements horizontally */
            align-items: center;
            margin: 5px 0;
            position: relative;
        }
        .top-bar .left, .top-bar .right {
            flex: 2; /* Allow flex items to grow */
            display: flex;
            justify-content: center; 
        }
        .system-date {
            text-align: center;
            margin: auto;
        }
    </style>
</head>
<body>

<?php
session_start();
if (isset($_SESSION["user"])) {
    if (($_SESSION["user"]) == "" || $_SESSION['usertype'] != 'p') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

// Import database
include("../connection.php");
$userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["pid"];
$username = $userfetch["pname"];

date_default_timezone_set('Africa/Nairobi');

$today = date('Y-m-d');
?>

<nav class="sidebar close"> 
    <header>
        <div class="image-text">
            <span class="image">
                <img src="../img/prime_care_logo.jpg" alt="logo">
            </span>
            <div class="text header-text"> 
                <span class="name"><?php echo substr($username, 0, 13); ?>..</span>
                <span class="profession"><?php echo substr($useremail, 0, 22); ?></span>
            </div>
        </div>
        <i class='bx bx-chevron-right toggle'></i>
    </header>  
    <div class="menu-bar">
        <div class="menu">
            <li class="search-box">
                <a href="#">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search ...">
                </a>
            </li>
            <ul class="menu-links">
                <li class="nav-link">
                    <a href="index.php">
                        <i class='bx bx-home-alt icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="schedule.php">
                        <i class='bx bx-plus-medical icon'></i>
                        <span class="text nav-text">Sessions</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="appointment.php">
                        <i class='bx bx-bar-chart-alt-2 icon'></i>
                        <span class="text nav-text">Bookings</span>
                    </a>
                </li>
                <li class="nav-link">
                    <a href="settings.php">
<i class='bx bx-cog icon'></i>
<span class="text nav-text">Settings</span>
</a>
</li>
</ul>
</div>
<div class="bottom-content">
<li>
<a href="../logout.php">
<i class='bx bx-log-out icon'></i>
<span class="text nav-text">Logout</span>
</a>
</li>
<li class="mode">
<div class="moon-sun">
<i class='bx bx-moon icon moon'></i>
<i class='bx bx-sun icon sun'></i>
</div>
<span class="mode-text text">Dark Mode</span>
<div class="toggle-switch">
<span class="switch"></span>
</div>
</li>
</div>
</div>

</nav>
<section class="home">
    <div class="top-bar">
        <div class="left">
            <a href="schedule.php">
                <button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top: 11px; padding-bottom: 11px; width: 125px;">
                    <font class="tn-in-text">Back</font>
                </button>
            </a>
        </div>
        <div class="right">
            <div class="search-box-container">
                <form action="schedule.php" method="post" class="header-search">
                    <input type="search" name="search" class="search-input" placeholder="Search BY Date (YYYY-MM-DD)" list="doctors">
                    <datalist id="doctors">
                        <?php
                        $list11 = $database->query("SELECT DISTINCT * FROM doctor;");
                        $list12 = $database->query("SELECT DISTINCT * FROM schedule GROUP BY title;");
                        for ($y = 0; $y < $list11->num_rows; $y++) {
                            $row00 = $list11->fetch_assoc();
                            $d = $row00["docname"];
                            echo "<option value='$d'><br/>";
                        };
    
                        for ($y = 0; $y < $list12->num_rows; $y++) {
                            $row00 = $list12->fetch_assoc();
                            $d = $row00["title"];
                            echo "<option value='$d'><br/>";
                        };
                        ?>
                    </datalist>
                    <input type="submit" value="Search" class="search-btn">
                </form>
            </div>
            <div class="system-date">
                <p style="font-size: 14px; color: rgb(119, 119, 119); padding: 0; margin: 0;">
                    System's Date
                </p>
                <p class="heading-sub12" style="padding: 0; margin: 0;">
                    <?php echo $today; ?>
                </p>
            </div>
        </div>
    </div>
    
    <div class="container">
        <div class="dash-body">
            <table class="sessions-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Doctor</th>
                        <th>Scheduled Date</th>
                        <th>Scheduled Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($_GET && isset($_GET["id"])) {
                        $id = $_GET["id"];
                        $sqlmain = "SELECT * FROM schedule INNER JOIN doctor ON schedule.docid = doctor.docid WHERE schedule.scheduleid = $id  ORDER BY schedule.scheduledate DESC";
                        $result = $database->query($sqlmain);
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $scheduleid = $row["scheduleid"];
                            $title = $row["title"];
                            $docname = $row["docname"];
                            $docemail = $row["docemail"];
                            $scheduledate = $row["scheduledate"];
                            $scheduletime = $row["scheduletime"];
                            $sql2 = "SELECT * FROM appointment WHERE scheduleid = $id";
                            $result12 = $database->query($sql2);
                            $apponum = ($result12->num_rows) + 1;
                            echo '<tr>
                                    <td>1</td>
                                    <td>' . $title . '</td>
                                    <td>' . $docname . '</td>
                                    <td>' . $scheduledate . '</td>
                                    <td>' . $scheduletime . '</td>
                                  </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
            <form action="booking-action.php" method="post">
    <input type="hidden" name="scheduleid" value="<?php echo $scheduleid; ?>">
    <input type="hidden" name="apponum" value="<?php echo $apponum; ?>">
    <input type="hidden" name="date" value="<?php echo $today; ?>">
    <input type="hidden" name="booknow" value="1"> 
    <button type="submit" class="login-btn btn-primary btn btn-book" style="margin-left: 10px; padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px; width: 95%; text-align: center;">Book now</button>
</form>
        </div>
    </div>
</section>
<script src="../js/script.js"></script>
</body>
</html>

            