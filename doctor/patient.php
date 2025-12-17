<?php
session_start();

// Include database connection
include("../connection.php");

// Function to fetch patient details
function getPatientDetails($database, $userid, $keyword = null, $filter = null)
{
    $sql = "SELECT * FROM appointment INNER JOIN patient ON patient.pid=appointment.pid INNER JOIN schedule ON schedule.scheduleid=appointment.scheduleid WHERE schedule.docid=$userid";

    if (!empty($keyword)) {
        $sql .= " AND (patient.pemail='$keyword' OR patient.pname='$keyword' OR patient.pname LIKE '%$keyword%' OR patient.pname LIKE '$keyword%' OR patient.pname LIKE '%$keyword')";
    }

    if (!empty($filter)) {
        if ($filter == 'all') {
            $sql = "SELECT * FROM patient";
        }
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

// Initialize $keyword and $filter to null
$keyword = null;
$filter = null;

// Fetch patients based on search and filter
$searchtype = "";
$result = getPatientDetails($database, $userid, isset($_POST["search12"]) ? $database->real_escape_string($_POST["search12"]) : $keyword, isset($_POST["showonly"]) ? $database->real_escape_string($_POST["showonly"]) : $filter);
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
        .patients-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .patients-table th, .patients-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .patients-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .patients-table tr:nth-child(even) {
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
<div class="text"><?php echo $searchtype ?>All Patients</div>
    <div class="container">
        <div class="dash-body">
            <div class="search-box-container">
                <form action="" method="post">
                    <input type="text" class="search-input" name="search12" placeholder="Search Patient name or Email" value="<?php echo isset($_POST['search12']) ? $_POST['search12'] : ''; ?>">
                    <input type="submit" class="search-btn" value="Search">
                </form>
            </div>
            
            <div class="top-bar">
                <div class="left">
                    <a href="patient.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </div>
                <div class="right">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;">System's Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;"><?php echo $today; ?></p>
                </div>
            </div>
            
            <div>
                <p class="heading-main12" style="font-size:18px;color:rgb(49, 49, 49)">My Patients (<?php echo $result->num_rows; ?>)</p>
            </div>

    <table class="patients-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>ID Number</th>
                <th>Telephone</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows == 0) {
                echo '<tr><td colspan="7">No patients found</td></tr>';
            } else {
                $count = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                        <td>' . $count++ . '</td>
                        <td>' . substr($row["pname"], 0, 35) . '</td>
                        <td>' . substr($row["pidnumber"], 0, 12) . '</td>
                        <td>' . substr($row["ptel"], 0, 10) . '</td>
                        <td>' . substr($row["pemail"], 0, 20) . '</td>
                        <td>' . substr($row["pdob"], 0, 10) . '</td>
                        <td>
                        <div class="actions">
                        <a href="?action=view&id=' . $row["pid"] . '" class="btn-primary-soft btn">View</a>
                        </div>
                        </td>
                        </tr>';
                        }
                        }
                        ?>
                        </tbody>
                        </table>
                        </section>
                        <?php include("patient-popups.php"); ?>
                        <script src="../js/script.js"></script>
                        </body>
                        </html>
