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

$sqlmain = "SELECT * FROM schedule INNER JOIN doctor ON schedule.docid=doctor.docid WHERE schedule.scheduledate>='$today' ORDER BY schedule.scheduledate ASC";
$insertkey = "";
$q = '';
$searchtype = "";

if ($_POST) {
    if (!empty($_POST["search"])) {
        $keyword = $database->real_escape_string($_POST["search"]);

        // Validate if keyword is a date in the format YYYY-MM-DD
        if (preg_match("/^\d{4}-\d{2}-\d{2}$/", $keyword)) {
            $sqlmain = "SELECT * FROM schedule INNER JOIN doctor ON schedule.docid=doctor.docid WHERE schedule.scheduledate>='$today' AND (schedule.scheduledate = '$keyword') ORDER BY schedule.scheduledate ASC";
        } else {
            $sqlmain = "SELECT * FROM schedule INNER JOIN doctor ON schedule.docid=doctor.docid WHERE schedule.scheduledate>='$today' AND (doctor.docname LIKE '%$keyword%' OR schedule.title LIKE '%$keyword%') ORDER BY schedule.scheduledate ASC";
        }
        
        $insertkey = $keyword;
        $searchtype = "Search Result : ";
        $q = '"';
    }
}

$result = $database->query($sqlmain);
?>

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
            font-size: 18px;
            color: #333;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 70%;
            max-width: 500px;
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
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
            position: relative;
        }
        .top-bar .left {
            margin-left: 10px;
        }
        .system-date {
            text-align: center;
            margin: auto;
        }
    </style>
</head>
<body>

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
        <div class="text"><?php echo $searchtype ?>Available Sessions</div>
                
            <div class="container">
        <div class="dash-body">
            <div class="search-box-container">
                <form action="" method="post">
                <input type="text" class="search-input" name="search" placeholder="Search via Date (YYYY-MM-DD) or Doctor Name or Title" value="<?php echo $insertkey ?>">
                    <input type="submit" class="search-btn" value="Search">
                </form>
            </div>
            
            <div class="top-bar">
                <div class="left">
                    <a href="schedule.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </div>
                <div class="right">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;">System's Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;"><?php echo $today; ?></p>
                </div>
            </div>
            
            <div>
                <p class="heading-main12" style="font-size:18px;color:rgb(49, 49, 49)">All Sessions (<?php echo $result->num_rows; ?>)</p>
            </div>

<!--Export buttons -->
<div>
        <form id="exportForm" action="export2.php" method="post">
            <input type="hidden" name="export_data" id="export_data" value="">
            <button type="button" class="exportbtn" onclick="exportTo('export_excel')">Export to Excel</button>
            <button type="button" class="exportbtn" onclick="exportTo('export_pdf')">Export to PDF</button>
        </form>
    </div>

            <table class="sessions-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Doctor</th>
                        <th>Scheduled Date</th>
                        <th>Scheduled Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result === false || $result->num_rows == 0) {
                        echo '<tr><td colspan="6">No sessions found</td></tr>';
                    } else {
                        $count = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>
                                <td>' . $count++ . '</td>
                                <td>' . $row["title"] . '</td>
                                <td>' . $row["docname"] . '</td>
                                <td>' . $row["scheduledate"] . '</td>
                                <td>' . $row["scheduletime"] . '</td>
                                <td><a href="booking.php?id=' . $row["scheduleid"] . '" class="btn btn-primary">Book Now</a></td>
                            </tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
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