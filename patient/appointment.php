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
        .appointments-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .appointments-table th, .appointments-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .appointments-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .appointments-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .filter-form {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
            text-align: center;
          
        }
        .filter-form input[type="date"] {
            padding: 10px;
            margin-right: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);

        }
        .filter-form input[type="submit"] {
            font-size: 18px;
            color: #fff;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #4CAF50;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .exportbtn{
            font-size: 12px;
            color: #fff;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #4CAF50;
            cursor: pointer;
            transition: background-color 0.3s ease;
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

$sqlmain = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, doctor.docname, patient.pname, patient.ptel, schedule.scheduledate, schedule.scheduletime, appointment.apponum, appointment.appodate 
FROM schedule 
INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid 
INNER JOIN patient ON patient.pid=appointment.pid 
INNER JOIN doctor ON schedule.docid=doctor.docid  
WHERE patient.pid=$userid ";

if ($_POST) {
    if (!empty($_POST["scheduledate"])) {
        $scheduledate = $_POST["scheduledate"];
        $sqlmain .= " AND schedule.scheduledate='$scheduledate' ";
    }
}

$sqlmain .= "ORDER BY appointment.appodate ASC";
$result = $database->query($sqlmain);
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
    <div class="text">Appointments</div>
    <div class="container">
        <div class="dash-body">
            <div class="filter-form">
                <form action="" method="post">
                    <input type="date" name="scheduledate" id="date">
                    <input type="submit" name="filter" value="Filter">
                </form>
            </div>
            <div class="top-bar">
                <div class="left">
                    <a href="appointment.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </div>
                <div class="right">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;">System's Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;"><?php echo $today; ?></p>
                </div>
            </div>
            
            <div>
                <p class="heading-main12" style="font-size:18px;color:rgb(49, 49, 49)">Booked Appointments (<?php echo $result->num_rows; ?>)</p>
            </div>
            <!--Export buttons -->
            <div>
        <form id="exportForm" action="export.php" method="post">
            <input type="hidden" name="export_data" id="export_data" value="">
            <button type="button" class="exportbtn" onclick="exportTo('export_excel')">Export to Excel</button>
            <button type="button" class="exportbtn" onclick="exportTo('export_pdf')">Export to PDF</button>
        </form>
    </div>
    <table class="appointments-table">
                <thead>
                    <tr>
                        <th>Appointment Number</th>
                        <th>Session Title</th>
                        <th>Doctor</th>
                        <th>Scheduled Date</th>
                        <th>Scheduled Time</th>
                        <th>Appointment Date</th>
                        <th>Appointment Number</th>
                        <th>Patient Name</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows == 0) {
                        echo '<tr><td colspan="10">No Appointments found</td></tr>';
                    } else {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                                <td>' . $count++ . '</td>
                                <td>' . $row["title"] . '</td>
                                <td>' . $row["docname"] . '</td>
                                <td>' . $row["scheduledate"] . '</td>
                                <td>' . $row["scheduletime"] . '</td>
                                <td>' . $row["appodate"] . '</td>
                                <td>' . $row["apponum"] . '</td>
                                <td>' . $row["pname"] . '</td>
                                <td>' . $row["ptel"] . '</td>
                                <td><a href="?action=drop&id=' . $row["appoid"] . '&title=' . $row["title"] . '&doc=' . $row["docname"] . '" class="btn btn-primary">Cancel </a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<?php
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];
    if ($action == 'booking-added') {
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <br><br>
                    <h2>Booked Successfully.</h2>
                    <a class="close" href="appointment.php">&times;</a>
                    <div class="content">
                        Your Appointment number is ' . $id . '.<br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>';
    } elseif ($action == 'drop') {
        $title = $_GET["title"];
        $docname = $_GET["doc"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="appointment.php">&times;</a>
                    <div class="content">
                        You want to Cancel this Appointment?<br><br>
                        Session Name: &nbsp;<b>' . substr($title, 0, 40) . '</b><br>
                        Doctor name: &nbsp;<b>' . substr($docname, 0, 40) . '</b><br><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id=' . $id . '" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>';
    } elseif ($action == 'view') {
        $sqlmain = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, doctor.docname, patient.pname, schedule.scheduledate, schedule.scheduletime, appointment.apponum, appointment.appodate 
        FROM schedule 
        INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid 
        INNER JOIN patient ON patient.pid=appointment.pid 
        INNER JOIN doctor ON schedule.docid=doctor.docid  
        WHERE appointment.appoid=$id";

        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $appoinum = $row["apponum"];
        $title = $row["title"];
        $docname = $row["docname"];
        $scheduledate = $row["scheduledate"];
        $scheduletime = $row["scheduletime"];
        $appodate = $row["appodate"];

        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>View Details.</h2>
                    <a class="close" href="appointment.php">&times;</a>
                    <div class="content">
                        Appointment number: <b>' . $appoinum . '</b><br>
                        Session Title: <b>' . $title . '</b><br>
                        Doctor: <b>' . $docname . '</b><br>
                        Scheduled Date: <b>' . $scheduledate . '</b><br>
                        Scheduled Time: <b>' . $scheduletime . '</b><br>
                        Appointment Date: <b>' . $appodate . '</b><br>
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>';
    }
}
?>
  <script>
        function exportTo(action) {
            // Collect the displayed data (example assumes data in a table)
            var table = document.querySelector('table'); // Adjust selector based on your table structure
            var rows = table.rows;
            var data = [];
            var removeIndex = -1;

            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].cells;
                var rowData = [];
                for (var j = 0; j < cells.length; j++) {
                    // Find index of the "Action" column
                    if (i == 0 && cells[j].innerText == "Action") {
                        removeIndex = j;
                    } else if (j !== removeIndex) {
                        rowData.push(cells[j].innerText);
                    }
                }
                data.push(rowData);
            }

            // Convert data array to JSON
            var jsonData = JSON.stringify(data);

            // Set hidden input value and submit form
            document.getElementById('export_data').value = jsonData;
            var form = document.getElementById('exportForm');
            form.innerHTML += '<input type="hidden" name="' + action + '" value="1">';
            form.submit();
        }
    </script>
<script src="../js/script.js"></script>

</body>
</html>

