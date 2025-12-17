<?php
session_start();

// Include database connection
include("../connection.php");

// Function to fetch session details
function getSessionDetails($database, $userid, $date = null)
{
    $sql = "SELECT appointment.appoid, schedule.scheduleid, schedule.title, doctor.docname, patient.pname, schedule.scheduledate, schedule.scheduletime, appointment.apponum, appointment.appodate, schedule.nop 
            FROM schedule 
            INNER JOIN appointment ON schedule.scheduleid=appointment.scheduleid 
            INNER JOIN patient ON patient.pid=appointment.pid 
            INNER JOIN doctor ON schedule.docid=doctor.docid 
            WHERE doctor.docid=$userid";

    if (!empty($date)) {
        $sql .= " AND schedule.scheduledate = '$date'";
    }

    return $database->query($sql);
}

$useremail = $_SESSION["user"];

if (empty($useremail) || $_SESSION['usertype'] != 'd') {
    header("location: ../login.php");
    exit;
}

$userrow = $database->query("SELECT * FROM doctor WHERE docemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["docid"];
$username = $userfetch["docname"];

date_default_timezone_set('Africa/Nairobi');
$today = date('Y-m-d');

// Initialize $date to null
$date = null;

$insertkey = "";

// Fetch sessions based on date filter
$searchtype = "";
$result = getSessionDetails($database, $userid, isset($_POST["date"]) ? $database->real_escape_string($_POST["date"]) : $date);
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
        .cancel-link {
            color: #ff3333;
            text-decoration: none;
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
        .search-btn:hover {
            background-color: #45a049;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
        }
        .top-bar .left,
        .top-bar .right {
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

<?php include("sidebar.php"); ?>

<section class="home">
<div class="text"><?php echo $searchtype ?>All Sessions</div>
    <div class="container">
        <div class="dash-body">
            <div class="search-box-container">
                <form action="" method="post">
                    <input type="date" class="search-input" name="date" value="<?php echo isset($_POST['date']) ? $_POST['date'] : ''; ?>">
                    <input type="submit" class="search-btn" value="Filter">
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
                <p class="heading-main12" style="font-size:18px;color:rgb(49, 49, 49)">My Sessions (<?php echo $result->num_rows; ?>)</p>
            </div>
            <!--Export buttons -->
            <div>
        <form id="exportForm" action="exportschedule.php" method="post">
            <input type="hidden" name="export_data" id="export_data" value="">
            <button type="button" class="exportbtn" onclick="exportTo('export_excel')">Export to Excel</button>
            <button type="button" class="exportbtn" onclick="exportTo('export_pdf')">Export to PDF</button>
        </form>
    </div>
    <table class="appointments-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Session Title</th>
                <th>Doctor</th>
                <th>Scheduled Date</th>
                <th>Scheduled Time</th>
                <th>Max num that can be booked</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows == 0) {
                echo '<tr><td colspan="7">No sessions found</td></tr>';
            } else {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>' . $count++ . '</td>
                        <td>' . substr($row["title"], 0, 30) . '</td>
                        <td>' . $row["docname"] . '</td>
                        <td>' . substr($row["scheduledate"], 0, 10) . '</td>
                        <td>' . substr($row["scheduletime"], 0, 5) . '</td>
                        <td>' . $row["nop"] . '</td>
                        
                        
                        <td>
                            <div class="actions">
                                <a href="?action=view&id=' . $row["scheduleid"] . '" class="btn-primary-soft btn">View</a>
                                <a href="?action=drop&id=' . $row["scheduleid"] . '&name=' . $row["title"] . '" class="btn-primary-soft btn">Cancel Session</a>
                            </div>
                        </td>
                    </tr>';
                }
            }
            ?>
        </tbody>
    </table>
</section>

<?php include("popup.php"); ?>
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
                    if (i == 0 && cells[j].innerText == "Actions") {
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