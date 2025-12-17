    <?php
    
        //import database
    include("../connection.php");

    if($_POST){
        
        $result= $database->query("select * from webuser");
        $name=$_POST['name'];
        $idnumber=$_POST['idnumber'];
        $oldemail=$_POST["oldemail"];
        $email=$_POST['email'];
        $tele=$_POST['Tele'];
        $password=$_POST['password'];
        $cpassword=$_POST['cpassword'];
        $id=$_POST['id00'];
        
        if ($password==$cpassword){
            $error='3';
            $result= $database->query("select admin.aid from admin inner join webuser on admin.aemail=webuser.email where webuser.email='$email';");
                      if($result->num_rows==1){
                $id2=$result->fetch_assoc()["aid"];
            }else{
                $id2=$id;
            }
            
            echo $id2."jdfjdfdh";
            if($id2!=$id){
                $error='1';
                                    
            }else{

                $sql1="update admin set aemail='$email',aname='$name',apassword='$password',aidnumber='$idnumber',atel='$tele' where aid=$id ;";
                $database->query($sql1);
                
                $sql1="update webuser set email='$email' where email='$oldemail' ;";
                $database->query($sql1);
                
                $error= '4';
                
            }
            
        }else{
            $error='2';
        }
              
        
    }else{
        //header('location: signup.php');
        $error='3';
    }
    

    header("location: admin.php?action=edit&error=".$error."&id=".$id);
    ?>
       
</body>
</html>