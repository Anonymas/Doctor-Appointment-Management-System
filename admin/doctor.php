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
        .doctors-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .doctors-table th, .doctors-table td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }
        .doctors-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .doctors-table tr:nth-child(even) {
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

    
        session_start(); // Start the session
    
        if(isset($_SESSION["user"])){ // Check if session variable "user" is set
            if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){ // Check if user is not logged in or is not an admin
                header("location: ../login.php"); // Redirect to login page
            }
            else{
                $useremail=$_SESSION["user"]; // Store user email in variable
            }
    
        }else{
            header("location: ../login.php"); // Redirect to login page if session variable "user" is not set
        }
        
    
        //import database connection
        include("../connection.php");
        // Fetch user data from database
        $userrow = $database->query("select * from admin where aemail='$useremail'");
        $userfetch=$userrow->fetch_assoc();
        $userid= $userfetch["aid"]; // Store user ID
        $username=$userfetch["aname"]; // Store user name
          
        date_default_timezone_set('Africa/Nairobi');

$today = date('Y-m-d');
        ?>
<?php include("sidebar.php"); ?>

<section class="home">
<div class="text">Doctors</div>
    <div class="container">
        <div class="dash-body">
            <div class="search-box-container">
            <form action="" method="post">

<input type="search" name="search" class="search-input" placeholder="Search Doctor Name or Email" list="doctors">&nbsp;&nbsp;
                                <?php

                                echo '<datalist id="doctors">';
                                $list11 = $database->query("select  docname,docemail from  doctor;");

                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["docname"];
                                    $c=$row00["docemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';
?>
                            
                       
                            <input type="Submit" value="Search" class="search-btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        
                        </form>
               
            </div>
            
            <div class="top-bar">
                <div class="left">
                    <a href="doctor.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;width:125px"><font class="tn-in-text">Back</font></button></a>
                </div>
                <div class="right">
                    <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;">System's Date</p>
                    <p class="heading-sub12" style="padding: 0;margin: 0;"><?php echo $today; ?></p>
                </div>
            </div>
            
            <div>
                <p class="heading-main12" style="font-size:18px;color:rgb(49, 49, 49)">All Doctors (<?php echo $list11->num_rows; ?>)</p>
            </div>
            <tr >
                    
                    <td colspan="2">
                        <a href="?action=add&id=none&error=0" class="non-style-link"><button  class="login-btn btn-primary btn button-icon"  style="display: flex;justify-content: center;align-items: center;margin-left:75px;background-image: url('../img/icons/add.svg');">Add New Doctor</font></button>
                            </a></td>
                </tr>
                
                <?php
                    if($_POST){
                        $keyword=$_POST["search"];
                        
                        $sqlmain= "select * from doctor where docemail='$keyword' or docname='$keyword' or docname like '$keyword%' or docname like '%$keyword' or docname like '%$keyword%'";
                    }else{
                        $sqlmain= "select * from doctor order by docid desc";

                    }



                ?>
                  
                <tr>

    <table class="doctors-table">
        <thead>
            <tr>
                <th>NO</th>
                <th>Doctor Name</th>
                <th>Email</th>
                <th>Specialties</th>
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
                $docid=$row["docid"];
                $no=$count++;
                $name=$row["docname"];
                $email=$row["docemail"];
                $spe=$row["specialties"];
                $spcil_res= $database->query("select sname from specialties where id='$spe'");
                $spcil_array= $spcil_res->fetch_assoc();
                $spcil_name=$spcil_array["sname"];
                echo '<tr>
                <td> &nbsp;'.
                    substr($no,0,10)
                    .'</td>
                    <td> &nbsp;'.
                    substr($name,0,30)
                    .'</td>
                    <td>
                    '.substr($email,0,20).'
                    </td>
                    <td>
                        '.substr($spcil_name,0,50).'
                    </td>

                    <td>
                    <div class="actions">
                    <a href="?action=edit&id='.$docid.'&error=0" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn"  style="padding-left: 25px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Edit</font></button></a>
                    &nbsp;&nbsp;&nbsp;
                    <a href="?action=view&id='.$docid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn"  style="padding-left: 25px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
                   &nbsp;&nbsp;&nbsp;
                   <a href="?action=drop&id='.$docid.'&name='.$name.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn"  style="padding-left: 25px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>
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
if($_GET){

$id=$_GET["id"];
$action=$_GET["action"];
if($action=='drop'){
$nameget=$_GET["name"];
echo '
<div id="popup1" class="overlay">
<div class="popup">
<center>
    <h2>Are you sure?</h2>
    <a class="close" href="doctor.php">&times;</a>
    <div class="content">
        You want to delete this record<br>('.substr($nameget,0,40).').
        
    </div>
    <div style="display: flex;justify-content: center;">
    <a href="delete-doctor.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
    <a href="doctor.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>

    </div>
</center>
</div>
</div>
';
}elseif($action=='view'){
$sqlmain= "select * from doctor where docid='$id'";
$result= $database->query($sqlmain);
$row=$result->fetch_assoc();
$name=$row["docname"];
$email=$row["docemail"];
$spe=$row["specialties"];

$spcil_res= $database->query("select sname from specialties where id='$spe'");
$spcil_array= $spcil_res->fetch_assoc();
$spcil_name=$spcil_array["sname"];
$idnumber=$row['docidnumber'];
$tele=$row['doctel'];
echo '
<div id="popup1" class="overlay">
<div class="popup">
<center>
    <h2></h2>
    <a class="close" href="doctor.php">&times;</a>
    <div class="content">
        Prime Care<br>
        
    </div>
    <div style="display: flex;justify-content: center;">
    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
    
        <tr>
            <td>
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
            </td>
        </tr>
        
        <tr>
            
            <td class="label-td" colspan="2">
                <label for="name" class="form-label">Name: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                '.$name.'<br><br>
            </td>
            
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="Email" class="form-label">Email: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
            '.$email.'<br><br>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="idnumber" class="form-label">ID Number: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
            '.$idnumber.'<br><br>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="Tele" class="form-label">Telephone: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
            '.$tele.'<br><br>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="spec" class="form-label">Specialties: </label>
                
            </td>
        </tr>
        <tr>
        <td class="label-td" colspan="2">
        '.$spcil_name.'<br><br>
        </td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="doctor.php"><input type="button" value="OK" class="login-btn btn-primary-soft btn" ></a>
            
                
            </td>

        </tr>
       

    </table>
    </div>
</center>
<br><br>
</div>
</div>
';
}elseif($action=='add'){
$error_1=$_GET["error"];
$errorlist = array(
    '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
    '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>',
    '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
    '4' => "",
    '5' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid email format. Please enter a valid email address.</label>',
    '6' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password must be at least 8 characters long, include an upper case letter, a lower case letter, and a special character.</label>',
    '0' => "",
);
if($error_1!='4'){
echo '
<div id="popup1" class="overlay">
<div class="popup">
<center>

    <a class="close" href="doctor.php">&times;</a> 
    <div style="display: flex;justify-content: center;">
    <div class="abc">
    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
    <tr>
            <td class="label-td" colspan="2">'.
                $errorlist[$error_1]
            .'</td>
        </tr>
        <tr>
            <td>
                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Doctor.</p><br><br>
            </td>
        </tr>
        
        <tr>
            <form action="add-doctor.php" method="POST" class="add-new-form">
            <td class="label-td" colspan="2">
                <label for="name" class="form-label">Name: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="text" name="name" class="input-text" placeholder="Doctor Name" required><br>
            </td>
            
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="Email" class="form-label">Email: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="email" name="email" class="input-text" placeholder="Email Address" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Must be a valid email"><br>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="idnumber" class="form-label">ID Number: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="text" name="idnumber" class="input-text" placeholder="ID Number" required><br>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="Tele" class="form-label">Telephone: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" required><br>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="spec" class="form-label">Choose specialties: </label>
                
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <select name="spec" id="" class="box" >';
                    

                    $list11 = $database->query("select  * from  specialties order by sname asc;");

                    for ($y=0;$y<$list11->num_rows;$y++){
                        $row00=$list11->fetch_assoc();
                        $sn=$row00["sname"];
                        $id00=$row00["id"];
                        echo "<option value=".$id00.">$sn</option><br/>";
                    };



                    
    echo     '       </select><br>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <label for="password" class="form-label">Password: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="password" name="password" class="input-text" placeholder="Create a Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least 8 characters, including UPPER/lowercase and numbers and special characters"><br>
            </td>
        </tr><tr>
            <td class="label-td" colspan="2">
                <label for="cpassword" class="form-label">Confirm Password: </label>
            </td>
        </tr>
        <tr>
            <td class="label-td" colspan="2">
                <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least 8 characters, including UPPER/lowercase and numbers and special characters"><br>
            </td>
        </tr>
        

        <tr>
            <td colspan="2">
                <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
                <input type="submit" value="Add" class="login-btn btn-primary btn">
            </td>

        </tr>
       
        </form>
        </tr>
    </table>
    </div>
    </div>
</center>
<br><br>
</div>
</div>
';

}else{
echo '
<div id="popup1" class="overlay">
        <div class="popup">
        <center>
        <br><br><br><br>
            <h2>New Record Added Successfully!</h2>
            <a class="close" href="doctor.php">&times;</a>
            <div class="content">
                
                
            </div>
            <div style="display: flex;justify-content: center;">
            
            <a href="doctor.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

            </div>
            <br><br>
        </center>
</div>
</div>
';
}
}elseif($action=='edit'){
$sqlmain= "select * from doctor where docid='$id'";
$result= $database->query($sqlmain);
$row=$result->fetch_assoc();
$name=$row["docname"];
$email=$row["docemail"];
$spe=$row["specialties"];

$spcil_res= $database->query("select sname from specialties where id='$spe'");
$spcil_array= $spcil_res->fetch_assoc();
$spcil_name=$spcil_array["sname"];
$idnumber=$row["docidnumber"];
$tele=$row["doctel"];
$password=$row["docpassword"];

$error_1=$_GET["error"];
$errorlist = array(
    '1' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>',
    '2' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password Confirmation Error! Reconfirm Password</label>',
    '3' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;"></label>',
    '4' => "",
    '5' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Invalid email format. Please enter a valid email address.</label>',
    '6' => '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Password must be at least 8 characters long, include an upper case letter, a lower case letter, and a special character.</label>',
    '0' => "",
);

if($error_1!='4'){
echo '
<div id="popup1" class="overlay">
        <div class="popup">
        <center>
        
            <a class="close" href="doctor.php">&times;</a> 
            <div style="display: flex;justify-content: center;">
            <div class="abc">
            <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
            <tr>
                    <td class="label-td" colspan="2">'.
                        $errorlist[$error_1]
                    .'</td>
                </tr>
                <tr>
                    <td>
                        <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Edit Doctor Details.</p>
                    Doctor ID : '.$id.' (Auto Generated)<br><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <form action="edit-doc.php" method="POST" class="add-new-form">
                        <label for="Email" class="form-label">Email: </label>
                        <input type="hidden" value="'.$id.'" name="id00">
                        <input type="hidden" name="oldemail" value="'.$email.'" >
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                    <input type="email" name="email" class="input-text" placeholder="Email Address" value="'.$email.'" required pattern="[^@\s]+@[^@\s]+\.[^@\s]+" title="Must be a valid email"><br>
                    </td>
                </tr>
                <tr>
                    
                    <td class="label-td" colspan="2">
                        <label for="name" class="form-label">Name: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="name" class="input-text" placeholder="Doctor Name" value="'.$name.'" required><br>
                    </td>
                    
                </tr>
                
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="idnumber" class="form-label">ID Number: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="idnumber" class="input-text" placeholder="ID Number" value="'.$idnumber.'" required><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="Tele" class="form-label">Telephone: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="tel" name="Tele" class="input-text" placeholder="Telephone Number" value="'.$tele.'" required><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="spec" class="form-label">Choose specialties: ('.$spcil_name.')</label>
                        
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <select name="spec" id="" class="box">';
                            

                            $list11 = $database->query("select  * from  specialties;");

                            for ($y=0;$y<$list11->num_rows;$y++){
                                $row00=$list11->fetch_assoc();
                                $sn=$row00["sname"];
                                $id00=$row00["id"];
                                echo "<option value=".$id00.">$sn</option><br/>";
                            };



                            
            echo     '       </select><br><br>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="password" class="form-label">Password: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="password" name="password" class="input-text" placeholder="Create a Password" value="'.$password.'" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least 8 characters, including UPPER/lowercase and numbers and special characters"><br>
                        </td>
                </tr><tr>
                    <td class="label-td" colspan="2">
                        <label for="cpassword" class="form-label">Confirm Password: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" value="'.$password.'" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}" title="Must contain at least 8 characters, including UPPER/lowercase and numbers and special characters"><br>
                    </td>
                </tr>
                
    
                <tr>
                    <td colspan="2">
                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    
                        <input type="submit" value="Save" class="login-btn btn-primary btn">
                    </td>
    
                </tr>
            
                </form>
                </tr>
            </table>
            </div>
            </div>
        </center>
        <br><br>
</div>
</div>
';
}else{
echo '
<div id="popup1" class="overlay">
    <div class="popup">
    <center>
    <br><br><br><br>
        <h2>Edit Successfully!</h2>
        <a class="close" href="doctor.php">&times;</a>
        <div class="content">
            
            
        </div>
        <div style="display: flex;justify-content: center;">
        
        <a href="doctor.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;OK&nbsp;&nbsp;</font></button></a>

        </div>
        <br><br>
    </center>
</div>
</div>
';



}; };
};

?>
</div>
</div>
        </tbody>
    </table>
</section>


<script src="../js/script.js"></script>
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

</body>
</html>
