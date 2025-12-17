<?php
if ($_GET) {
    $id = $_GET["id"];
    $action = $_GET["action"];
    if ($action == 'drop') {
        $nameget = $_GET["name"];
        echo '
        <div id="popup1" class="overlay">
            <div class="popup">
                <center>
                    <h2>Are you sure?</h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                        You want to delete this record<br>(' . substr($nameget, 0, 40) . ').
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <a href="delete-session.php?id=' . $id . '" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;Yes&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="schedule.php" class="non-style-link"><button class="btn-primary btn" style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;No&nbsp;&nbsp;</font></button></a>
                    </div>
                </center>
            </div>
        </div>
        '; 
    } elseif ($action == 'view') {
        $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid  where  schedule.scheduleid=$id";
        $result= $database->query($sqlmain);
        $row=$result->fetch_assoc();
        $docname=$row["docname"];
        $scheduleid=$row["scheduleid"];
        $title=$row["title"];
        $scheduledate=$row["scheduledate"];
        $scheduletime=$row["scheduletime"];
        
       
        $nop=$row['nop'];


        $sqlmain12= "select * from appointment inner join patient on patient.pid=appointment.pid inner join schedule on schedule.scheduleid=appointment.scheduleid where schedule.scheduleid=$id;";
        $result12= $database->query($sqlmain12);
        echo '
        <div id="popup1" class="overlay">
                <div class="popup" style="width: 70%;">
                <center>
                    <h2></h2>
                    <a class="close" href="schedule.php">&times;</a>
                    <div class="content">
                        
                        
                    </div>
                    <div class="abc scroll" style="display: flex;justify-content: center;">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                    
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">View Details.</p><br><br>
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
                                <label for="Email" class="form-label">Doctor of this session: </label>
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
                                <label for="spec" class="form-label"><b>Patients Already Registered for this Session:</b> ('.$result12->num_rows."/".$nop.')</label>
                                <br><br>
                            </td>
                        </tr>

                        
                        <tr>
                        <td colspan="4">
                            <center>
                             <div class="abc scroll">
                             <table width="100%" class="sub-table scrolldown" border="0">
                             <thead>
                             <tr>   
                                    <th class="table-headin">
                                         Patient ID
                                     </th>
                                     <th class="table-headin">
                                         Patient name
                                     </th>
                                     <th class="table-headin">
                                         
                                         Appointment number
                                         
                                     </th>
                                    
                                     
                                     <th class="table-headin">
                                         Patient Telephone
                                     </th>
                                     
                             </thead>
                             <tbody>';
                             
            
            
                                     
                                     $result= $database->query($sqlmain12);
            
                                     if($result->num_rows==0){
                                         echo '<tr>
                                         <td colspan="7">
                                         <br><br><br><br>
                                         <center>
                                         
                                         
                                         <br>
                                         <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No Appointments Found!</p>
                                         <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Appointments &nbsp;</font></button>
                                         </a>
                                         </center>
                                         <br><br><br><br>
                                         </td>
                                         </tr>';
                                         
                                     }
                                     else{
                                     for ( $x=0; $x<$result->num_rows;$x++){
                                         $row=$result->fetch_assoc();
                                         $apponum=$row["apponum"];
                                         $pid=$row["pid"];
                                         $pname=$row["pname"];
                                         $ptel=$row["ptel"];
                                         
                                         echo '<tr style="text-align:center;">
                                            <td>
                                            '.substr($pid,0,15).'
                                            </td>
                                             <td style="font-weight:600;padding:25px">'.
                                             
                                             substr($pname,0,25)
                                             .'</td >
                                             <td style="text-align:center;font-size:23px;font-weight:500; color: var(--btnnicetext);">
                                             '.$apponum.'
                                             
                                             </td>
                                             <td>
                                             '.substr($ptel,0,25).'
                                             </td>
                                             
                                             
            
                                             
                                         </tr>';
                                         
                                     }
                                 }
                                      
                                 
            
                                echo '</tbody>
            
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
}

?>