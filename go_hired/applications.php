<?php
include 'partials/_dbconnect.php';
if(isset($_POST['update_status'])){
    echo $_GET['user_id'];
    $sql1="update applications set status='".$_POST['status']."' where uid=".$_GET['user_id'];
    $result1=mysqli_query($con,$sql1);
    if($result1){}else{die(mysqli_error($result1));}
    if($_POST['status']=='Hired'){
        $result2=mysqli_query($con,'select * from company inner join jobs on company.uid = jobs.uid where jobs.job_id='.$_GET["job_id"].';');
        $row2=mysqli_fetch_assoc($result2);

        $query="update company set no_hirings='".$row2['no_hirings']+1 ."' where uid=".$row2['uid'];
        $qresult=mysqli_query($con,$query);
    }
    header("location:applications.php?job_id=".$_GET['job_id']."&job_title=".$_GET['job_title']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <?php include 'partials/_header.php'?>
    <?php 
     echo"
     <div class='container' style='width:75%;margin-top:10px;padding:20px;'>
     <h3 class='text-center'>Applications on ".$_GET['job_title']." </h3>
     <form action='applications.php' method='post' >
    
                    <div class='container row my-3'>
                        <h5> Filter by: </h5>
                        
                            <div class='col-md-10  mt-1'>
                                <select name='status'  class=' form-select me-2'>
                                <option selected >Status</option>
                                <option  value='Hired'>Hired</option>
                                <option value='Rejected'>Rejected</option>
                                <option value='Shortlist'>Shortlisted</option>
                                </select>
                            </div>
                            
                            <div class='col-md-2 mt-1'>
                                <button type='submit' name='filter' class='btn col-md-4 me-2 btn-dark'>Filter</button>
                            </div>
                        </div>
                    
                </form>";
        
        $cn_id=$_GET['cn_id'];
        if(!$_SESSION['gh_userid']==$cn_id){
            if(isset($_POST['filter'])){
                $search=$_POST['status'];
                $sql="SELECT * FROM applications where jobid='". $_GET['job_id']."' and status='".$search."'";
                $result=mysqli_query($con,$sql);
                $num=mysqli_num_rows($result);
            } else{
                $sql="SELECT * FROM applications where jobid='". $_GET['job_id']."'";
                $result=mysqli_query($con,$sql);
                $num=mysqli_num_rows($result);
            }
           

            while($row=mysqli_fetch_assoc($result)){

                $result2=mysqli_query($con,'select * from individuals inner join users on individuals.uid = users.user_id where individuals.uid='.$row["uid"].';');
                $row2=mysqli_fetch_assoc($result2);
            
                
            
                echo"
                
                
                <div style='width:90%;border:1px solid rgb(123, 132, 132);margin:10px;padding:20px;border-radius: 20px;'>
                    <div class='row'>
                        <div class='col-md-10'>
                            <a href='profile.php?userid=".$row["uid"]."' class='links'>
                                <img src='profile_pictures/". $row2['profile_picture']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                                <h5 class='card-title'>". $row2['username'] ."</h5>
                                <table style='width:85%;'>
                                    <tr>
                                        <td class='col-md-8'>
                                            <p >Email: ".$row2['email']  ." </p>
                                        </td>
                                        <td class='col-md-4'>
                                            <p >Contact: ".$row2['individual_contact']  ."</p>
                                        </td>
                                    <tr>
                                    </tr>
                                        <td class='col-md-8'>
                                            <p >Date of Application: ".$row['applied_on']  ."</p>
                                        </td>
                                        <td class='col-md-4'>
                                            <p >Application status: ".$row['status']  ." </p>
                                        </td>  
                                    </tr>
                            
                                </table>
                                </a>
                            
                            </div>

                            <div class='col-md-2' style='float: right;'>
                                <form action='applications.php?user_id=".$row['uid']."&job_id=".$row['jobid']."&job_title=".$_GET['job_title']."' method='post'>
                                    <table>
                                        <tr>
                                            <td>";
                                            
                                    
                                        
                                            if($row['status']=='Hired'){
                                                echo"
                                                <select  disabled class='btn-dark ' style='appearance:none;padding:8px;  border-radius:25px' name='status' >
                                                <option >Hired candidate</option>";
                                            }else if($row['status']=='Rejected'){
                                                echo"
                                                <select  disabled class='btn-dark ' style='appearance:none;padding:8px;  border-radius:25px' name='status' >
                                                <option >Rejected candidate</option>";
                                            }
                                            else{
                                            echo"
                                                <select   class='btn-dark ' style='padding:4px; padding-right:16px; border-radius:25px' name='status' >
                                                <option >Actions</option>";
                                            }
                                            echo"
                                                    
                                                    <option value='Shortlisted'>Shortlist</option>
                                                    <option value='Hired'>Hire</option>
                                                    <option value='Rejected'>Reject</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>";
                                            if($row['status']=='Hired'||$row['status']=='Rejected'){
                                            
                                            }else{
                                            echo" <button class='btn-dark '  type='submit' style=' padding:4px; border-radius:25px' name='update_status'>Update status</button>";
                                            }
                                            echo"
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                ";
            
            }
            
    
            echo"</div>";
            if($num==0){
                echo'<div class="container text-center" style="margin: 0;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><h4>No Applications Yet</h4></div>';
            }
        }else{
            if(isset($_POST['filter'])){
                $search=$_POST['status'];
                $sql="SELECT * FROM applications where jobid='". $_GET['job_id']."' and status='".$search."'";
                $result=mysqli_query($con,$sql);
                $num=mysqli_num_rows($result);
            }else{
            $sql="SELECT * FROM applications where jobid='". $_GET['job_id']."'";
            $result=mysqli_query($con,$sql);
            $num=mysqli_num_rows($result);
            }
            while($row=mysqli_fetch_assoc($result)){

                $result2=mysqli_query($con,'select * from individuals inner join users on individuals.uid = users.user_id where individuals.uid='.$row["uid"].' and cn_id='.$cn_id.';');
                $row2=mysqli_fetch_assoc($result2);
            echo "<div style='width:90%;border:1px solid rgb(123, 132, 132);margin:10px;padding:20px;border-radius: 20px;'>
               
                    <a href='profile.php?userid=".$row["uid"]."' class='links'>
                        <img src='profile_pictures/". $row2['profile_picture']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                        <h5 class='card-title'>". $row2['username'] ."</h5>
                        <table style='width:85%;'>
                            <tr>
                                <td>
                                    <p >Email: ".$row2['email']  ." </p>
                                </td>
                                <td>
                                    <p >Contact: ".$row2['individual_contact']  ."</p>
                                </td>
                            <tr>
                            </tr>
                                <td>
                                    <p >Date of Application: ".$row['applied_on']  ."</p>
                                </td>
                                <td>
                                    <p >Application status: ".$row['status']  ." </p>
                                </td>  
                            </tr>
                    
                        </table>
                        </a>
                    
                    </div>";
            }
            echo '</div>';
    }

    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>