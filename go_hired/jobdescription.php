<?php
session_start();

include 'partials/_dbconnect.php';
if(isset($_POST['apply'])){
    // $result2=mysqli_query($con,'select * from individuals inner join users on individuals.uid=users.user_id where user_id='. $userid);
    // $row2=mysqli_fetch_assoc($result2);

    $sql="insert into applications(uid,jobid,status) values('".$_SESSION['gh_userid']."','".$_GET['job_id']."','Applied')";
    $result=mysqli_query($con,$sql);
    $query=mysqli_query($con,'update individuals set no_jobs_applied=no_jobs_applied+1 where uid='.$_SESSION['gh_userid'].';');
    if($result){
        echo $_GET['job_id'];
        echo "<script>alert('Your application has been submitted successfully');";
        echo "window.location.href='manageApplications.php'</script>";
         return;
    }else{
        echo"<script>alert('Could not apply to the job :( Please try again later');</script>";
        echo "window.location.href='index.php'</script>";
    }
}
if(isset($_POST['view_applications'])){
    
}
if(isset($_POST['add_to_network'])){
    $jobs=array();
    $sql3="select * from colleges where uid='".$_SESSION['gh_userid']."'";
    $result3=mysqli_query($con,$sql3);
    if($row3=mysqli_fetch_assoc($result3)){ 
        if(!empty($row3['jobs'])){
        $jobs=unserialize($row3['jobs']);}
        $num=count($jobs);
        
        $jobs[$num] = $_GET['job_id'];;
        $sql="update colleges set jobs='".serialize($jobs)."' where uid='".$_SESSION['gh_userid']."'";
        $result=mysqli_query($con,$sql);
        if($result){
       
        echo "<script>alert('This job has been added to your network successfully');";
        echo "window.location.href='manageNetwork.php'</script>";
         return;
        }
    else{
        echo"<script>alert('Could not add this job to your network :( Please try again later');</script>";
        echo "window.location.href='index.php'</script>";
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job description</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <?php include 'partials/_header.php'?>
    <?php require 'partials/_dbconnect.php';?>

    <?php

$sql="SELECT * FROM jobs where job_id='". $_GET['job_id']."'";
$result=mysqli_query($con,$sql);

while($row=mysqli_fetch_assoc($result)){
    $result2=mysqli_query($con,'select * from company inner join users on company.uid = users.user_id where company.uid='.$row["uid"].';');
    $row2=mysqli_fetch_assoc($result2);
    
    echo "<center>
    <div style='width:75%;border:1px solid rgb(123, 132, 132);margin:10px;padding:40px;border-radius: 20px;'>

    <div style='text-align: justify;' ><a href='profile.php?userid=".$row2['uid']."' class='links'>
    <img src='profile_pictures/". $row2['company_logo']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:70px;width:70px'></a>
    <form action='jobdescription.php?job_id=".$_GET['job_id']."' method='post'>";

    if($_SESSION['gh_usertype']=='individual'){
        $sql3="select * from applications where uid='".$_SESSION['gh_userid']."' and jobid='".$_GET['job_id']."'";
        $result3=mysqli_query($con,$sql3);
        if(!$row3=mysqli_fetch_assoc($result3)){ echo"
        <button type='submit' class='btn btn-dark' name='apply' style='float: right; padding:15px; border-radius:30px'>Apply now</button>";}
        else{
            echo "<button type='submit' class=' btn-dark'  style='float: right; padding:15px; border-radius:30px'>".$row3['status']."</button>";
        }
    }

    else if($_SESSION['gh_usertype']=='college'){
        $jobs=array();
        $sql3="select * from colleges where uid='".$_SESSION['gh_userid']."'";
        $result3=mysqli_query($con,$sql3);
        if($row3=mysqli_fetch_assoc($result3)){ 
            if(!empty($row3['jobs'])){
                $jobs=unserialize($row3['jobs']);}
            $num=count($jobs);
            $added=0;
            for($i=0;$i<$num;$i++){
                if($jobs[$i]==$_GET['job_id']){
                    $added=1;
                    break;
                }
            }
                if($added){

                echo"
                <button type='submit' class='btn btn-dark'  style='float: right; padding:15px; border-radius:30px'>Added to Network</button>";
             }
             else{
                echo"
                <button type='submit' class='btn btn-dark' name='add_to_network' style='float: right; padding:15px; border-radius:30px'>Add to Network</button>";
            }
        }
         
     }
    elseif($_SESSION['gh_usertype']=='company'){

        if($row2['uid']==$_SESSION['gh_userid']){
            echo" <a  class='btn btn-dark' name='view_applications' href='applications.php?job_id=".$_GET['job_id']."&job_title=".$row['job_title']  ."' style='float: right; padding:15px; border-radius:30px'>View Applications</a>";
        }
    } else {
        echo"<a href='login.php' class='btn btn-dark' style='float: right; padding:15px; border-radius:30px'> Login to Apply now</a>";
    }
    
    echo"</form><a href='profile.php?userid=".$row2['uid']."' class='links'>
    <h3>".$row['job_title']  ."</h3>
    <h5 >".$row2['username']."</h5></a><br>
    <table style='width:100%;'>
        <tr>
            <td class='col-md-6'>
                <h6 style='font-weight: 600;'>Location: ".$row['location']  ." </h6>
            </td>
            <td class='col-md-6'>
                <h6 style='font-weight: 600;'>Salary: ".$row['salary']  ." </h6>
            </td>
        </tr>
        <tr>
            <td class='col-md-6'>
                <h6 style='font-weight: 600;'>Experience: ".$row['experience']  ." </h6>
            </td>
            <td class='col-md-6'>
                <h6 style='font-weight: 600;'>Apply before: ".$row['application_deadline']  ."</h6>
            </td>
        </tr>
        <tr>
            <td class='col-md-6'>
                <h6 style='font-weight: 600;'>Job type: ".$row['job_type']  ."</h6>
            </td>
            
        </tr>
    </table><br>
    
                <h6 style='font-weight: 600;'> Description:</h6>
            
    <p>".$row['job_description']  ."</p>
    <h6 style='font-weight: 600;'> Skills:</h6>
    <p>".$row['skills']  ."</p>
    <h6 style='font-weight: 600;'> Perks:</h6>
    <p>".$row['perks']  ."</p>
    <h6 style='font-weight: 600;'> No: positions: ".$row['no_positions']  ."</h6>
               
               
    </div>
</div>
</center>";
}


?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>