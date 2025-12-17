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
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .session-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .session-table th, .session-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .session-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .session-table tr:nth-child(even) {
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
        }
        .top-bar .left,
        .top-bar .right {
            display: flex;
            align-items: center;
        }
    </style>

    </head>
    <body>

        <?php

    
        session_start();
    
        if(isset($_SESSION["user"])){
            if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
                header("location: ../login.php");
            }
            else{
                $useremail=$_SESSION["user"];
            }
    
        }else{
            header("location: ../login.php");
        }
        
    
        //import database
        include("../connection.php");
        $userrow = $database->query("select * from admin where aemail='$useremail'");
        $userfetch=$userrow->fetch_assoc();
        $userid= $userfetch["aid"];
        $username=$userfetch["aname"];
    
        date_default_timezone_set('Africa/Nairobi');
        $today = date('Y-m-d'); 
        ?>

<?php include("sidebar.php"); ?>

<section class="home">
    <div class="text">Schedule Manager </div>
    <div class="container">
    <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="schedule.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;"></p>
                                           
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

                        $list110 = $database->query("select  * from  schedule;");

                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        
                    </td>


                </tr>
               
                <tr>
                    <td colspan="4" >
                        <div style="display: flex;margin-top: 40px;">
                        
                        <a href="?action=add-session&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="margin-left:25px;background-image: url('../img/icons/add.svg');">Add a Session</font></button>
                        </a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                    
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)">All Sessions (<?php echo $list110->num_rows; ?>)</p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
                        <tr>
                           <td width="10%">

                           </td> 
                        <td width="5%" style="text-align: center;">
                        Date:
                        </td>
                        <td width="30%">
                        <form action="" method="post">
                            
                            <input type="date" name="sheduledate" id="date" class="search-input" style="margin: 0;width: 95%;">

                        </td>
                        <td width="5%" style="text-align: center;">
                        Doctor:
                        </td>
                        <td width="30%">
                        <select name="docid" id="" class="search-input" >
                            <option value="" disabled selected hidden>Choose Doctor Name </option><br/>
                                
                            <?php 
                            
                                $list11 = $database->query("select  * from  doctor order by docname asc;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $sn=$row00["docname"];
                                    $id00=$row00["docid"];
                                    echo "<option value=".$id00.">$sn</option><br/>";
                                };


                                ?>

                        </select>
                    </td>
                    <td width="12%">
                        <input type="submit"  name="filter" value=" Filter" class="search-btn"  style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>

                    </tr>
                    
                            </table>

                        </center>
                    </td>
                    
                </tr>
                
                <?php
                    if($_POST){
                        //print_r($_POST);
                        $sqlpt1="";
                        if(!empty($_POST["sheduledate"])){
                            $sheduledate=$_POST["sheduledate"];
                            $sqlpt1=" schedule.scheduledate='$sheduledate' ";
                        }


                        $sqlpt2="";
                        if(!empty($_POST["docid"])){
                            $docid=$_POST["docid"];
                            $sqlpt2=" doctor.docid=$docid ";
                        }

                        $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid ";
                        $sqllist=array($sqlpt1,$sqlpt2);
                        $sqlkeywords=array(" where "," and ");
                        $key2=0;
                        foreach($sqllist as $key){

                            if(!empty($key)){
                                $sqlmain.=$sqlkeywords[$key2].$key;
                                $key2++;
                            };
                        };
                        
                                               
                     }else{
                        $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  order by schedule.scheduledate desc";

                    }

                ?>
                  
                  <tr>
<!--Export buttons -->

<table class="session-table">
    
    <thead>
    <div>
        <form id="exportForm" action="exportschedule.php" method="post">
            <input type="hidden" name="export_data" id="export_data" value="">
            <button type="button" class="exportbtn" onclick="exportTo('export_excel')">Export to Excel</button>
            <button type="button" class="exportbtn" onclick="exportTo('export_pdf')">Export to PDF</button>
        </form>
    </div>
        <tr>
            <th>NO</th>
            <th>Session Title</th>
            <th>Doctor</th>
            <th>Sheduled Date </th>
            <th>Sheduled Time</th>
            <th>Max num that can be booked</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
                    
                        <?php

                            
                            $result= $database->query($sqlmain);
                            if ($result->num_rows == 0) {
                                echo '<tr><td colspan="7">No sessions found</td></tr>';
                            } else {
                                $count = 1;
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $scheduleid=$row["scheduleid"];
                                    $title=$row["title"];
                                    $docname=$row["docname"];
                                    $no=$count++;
                                    $scheduledate=$row["scheduledate"];
                                    $scheduletime=$row["scheduletime"];
                                    $nop=$row["nop"];
                                    echo '<tr>
                                    <td> &nbsp;'.
                                        substr($no,0,10)
                                        .'</td>
                                        <td> &nbsp;'.
                                        substr($title,0,30)
                                        .'</td>
                                        <td>
                                        '.substr($docname,0,20).'
                                        </td>
                                        <td >
                                            '.substr($scheduledate,0,10).' 
                                        </td>
                                        <td> &nbsp;'.
                                        substr($scheduletime,0,5)
                                        .'</td>
                                        <td style="text-align:center;">
                                            '.$nop.'
                                        </td>

                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <a href="?action=view&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 25px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="?action=edit&id='.$scheduleid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-edit"  style="padding-left: 25px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Edit</font></button></a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="?action=drop&id='.$scheduleid.'&name='.$title.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-delete"  style="padding-left: 25px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>
                                        </div>
                                        </td>
                                    </tr>';
                                    
                                }
                            }
                                 
                            ?>
 
                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
                       
                        
                        
            </table>
        </div>
    </div>
    <?php

if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];

    // Add Session
    if ($action == 'add-session') {
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <a class="close" href="schedule.php">&times;</a>
                    <div style="display: flex; justify-content: center;">
                        <div class="abc">
                            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                                <tr>
                                    <td class="label-td" colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <p style="padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;">Add New Session.</p><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <form action="add-session.php" method="POST" class="add-new-form">
                                            <label for="title" class="form-label">Session Title : </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="text" name="title" class="input-text" placeholder="Name of this Session" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="docid" class="form-label">Select Doctor: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <select name="docid" class="box">
                                            <option value="" disabled selected hidden>Choose Doctor Name from the list</option><br/>';
        
        $list11 = $database->query("select * from doctor order by docname asc;");
        for ($y = 0; $y < $list11->num_rows; $y++) {
            $row00 = $list11->fetch_assoc();
            $sn = $row00["docname"];
            $id00 = $row00["docid"];
            echo "<option value=".$id00.">$sn</option><br/>";
        }

        echo '
                                        </select><br><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="nop" class="form-label">Maximum Number of Patients : </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="number" name="nop" class="input-text" min="0" placeholder="Number of Patients" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="date" class="form-label">Session Date: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="date" name="date" class="input-text" min="'.date('Y-m-d').'" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <label for="time" class="form-label">Schedule Time: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td" colspan="2">
                                        <input type="time" name="time" class="input-text" placeholder="Time" required><br>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <input type="submit" value="Place this Session" class="login-btn btn-primary btn" name="shedulesubmit">
                                    </td>
                                </tr>
                            </form>
                            </table>
                        </div>
                    </div>
                </center>
                <br><br>
            </div>
        </div>
        ';
    }

    // Session Added
    elseif ($action == 'session-added') {
        $titleget = $_GET["title"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <br><br>
                    <h2>Session Placed.</h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                        '.substr($titleget, 0, 40).' was scheduled.<br><br>
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <a href="schedule.php" class="non-style-link"><button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                    </div>
                </center>
            </div>
        </div>
        ';
    }

    // Drop Session
    elseif ($action == 'drop') {
        $nameget = $_GET["name"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>('.substr($nameget, 0, 40).').
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <a href="delete-session.php?id='.$id.'" class="non-style-link"><button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button class="btn-primary btn" style="display: flex; justify-content: center; align-items: center; margin: 10px; padding: 10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>
        ';
    }

    // View Session
    elseif ($action == 'view') {
        $sqlmain = "select schedule.scheduleid, schedule.title, doctor.docname, schedule.scheduledate, schedule.scheduletime, schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduleid=$id";
        $result = $database->query($sqlmain);
        $row = $result->fetch_assoc();
        $docname = $row["docname"];
        $scheduleid = $row["scheduleid"];
        $title = $row["title"];
        $scheduledate = $row["scheduledate"];
        $scheduletime = $row["scheduletime"];
        $nop = $row['nop'];

        $sqlmain12 = "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.scheduleid=$id;";
        $result12 = $database->query($sqlmain12);
        echo '
        <div id="popup1" class="overlay">
            <div class="popup" style="width: 70%;">
                <center>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content"></div>
                    <div class="abc scroll" style="display: flex; justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;">View Details.</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">Session Title: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$title.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">Session Doctor: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$docname.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="idnumber" class="form-label">Scheduled Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$scheduledate.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">Scheduled Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$scheduletime.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label"><b>Patients Registered for this Session:</b> ('.$result12->num_rows.'/'.$nop.')</label><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <center>
                                        <div class="abc scroll">
                                            <table width="100%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>
                                                        <th class="table-headin">Patient ID</th>
                                                        <th class="table-headin">Patient name</th>
                                                        <th class="table-headin">Appointment number</th>
                                                        <th class="table-headin">Patient Telephone</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
        $result = $database->query($sqlmain12);
        if ($result->num_rows == 0) {
            echo '
                                                    <tr>
                                                        <td colspan="7">
                                                            <br><br><br><br>
                                                            <center>
                                                                
                                                                <br>
                                                                <p class="heading-main12" style="margin-left: 45px; font-size: 20px; color: rgb(49, 49, 49)">No Appointments Found!</p>
                                                                <a class="non-style-link" href="appointment.php"><button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left: 20px;">&nbsp; Show all Appointments &nbsp;</button></a>
                                                            </center>
                                                            <br><br><br><br>
                                                        </td>
                                                    </tr>';
        } else {
            for ($x = 0; $x < $result->num_rows; $x++) {
                $row = $result->fetch_assoc();
                $apponum = $row["apponum"];
                $pid = $row["pid"];
                $pname = $row["pname"];
                $ptel = $row["ptel"];
                echo '
                                                    <tr style="text-align:center;">
                                                        <td>'.substr($pid, 0, 15).'</td>
                                                        <td style="font-weight: 600; padding: 25px;">'.substr($pname, 0, 25).'</td>
                                                        <td style="text-align: center; font-size: 23px; font-weight: 500; color: var(--btnnicetext);">'.$apponum.'</td>
                                                        <td>'.substr($ptel, 0, 25).'</td>
                                                    </tr>';
            }
        }
        echo '
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </div>
                </center>
                <br><br>
            </div>
        </div>
        ';
    }

    // Edit Session
elseif ($action == 'edit') {
    $sqlmain = "select * from schedule where scheduleid=$id";
    $result = $database->query($sqlmain);
    $row = $result->fetch_assoc();
    $title = $row["title"];
    $docid = $row["docid"];
    $scheduledate = $row["scheduledate"];
    $scheduletime = $row["scheduletime"];
    $nop = $row["nop"];
    echo '
    <div id="popup1" class="overlay">
        <div class="popup">
            <center>
                <a class="close" href="schedule.php">&times;</a>
                <div style="display: flex; justify-content: center;">
                    <div class="abc">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td class="label-td" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>
                                    <p style="padding: 0; margin: 0; text-align: left; font-size: 25px; font-weight: 500;">Edit Session.</p><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <form action="edit-session.php" method="POST" class="add-new-form">
                                        <input type="hidden" name="scheduleid" value="'.$id.'">
                                        <label for="title" class="form-label">Session Title : </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="text" name="title" class="input-text" value="'.$title.'" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="docid" class="form-label">Select Doctor: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <select name="docid" class="box">';
    
    $list11 = $database->query("select * from doctor order by docname asc;");
    for ($y = 0; $y < $list11->num_rows; $y++) {
        $row00 = $list11->fetch_assoc();
        $sn = $row00["docname"];
        $id00 = $row00["docid"];
        $selected = ($docid == $id00) ? "selected" : "";
        echo "<option value=\"$id00\" $selected>$sn</option><br/>";
    }

    echo '
                                    </select><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nop" class="form-label">Number of Patients/Appointment Numbers : </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="number" name="nop" class="input-text" value="'.$nop.'" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="date" class="form-label">Session Date: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="date" name="date" class="input-text" value="'.$scheduledate.'" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="time" class="form-label">Schedule Time: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <input type="time" name="time" class="input-text" value="'.$scheduletime.'" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="submit" value="Save Changes" class="login-btn btn-primary btn" name="editsubmit">
                                </td>
                            </tr>
                        </form>
                        </table>
                    </div>
                </div>
            </center>
            <br><br>
        </div>
    </div>
    ';
}
}
?>

    </div>

    </div>
    </section>
    <script>
function validateForm() {
    var password = document.querySelector('input[name="password"]').value;
    var cpassword = document.querySelector('input[name="cpassword"]').value;

    if (password !== cpassword) {
        alert("Passwords do not match");
        return false;
    }
    return true;
}
</script>
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