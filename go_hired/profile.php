<?php
session_start();
include 'partials/_dbconnect.php';
$userid=$_GET['userid'];
$query="select * from users where user_id=". $userid;
$result=mysqli_query($con,$query);
$row=mysqli_fetch_assoc($result);
$usertype=$row['user_type'];
$username=$row['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <?php include 'partials/_header.php'?>

    <center>
        

        <?php 

        if($usertype=='individual'){
            $result2=mysqli_query($con,'select * from individuals inner join users on individuals.uid=users.user_id where user_id='. $userid);
            $row2=mysqli_fetch_assoc($result2);

            echo"
            <div
            style='width:75%;color:azure;background-color:rgb(21, 20, 20);border:1px solid black;margin-top:10px;padding:20px;border-top-left-radius: 30px;border-top-right-radius: 30px;;'>

                <div style='margin:10px'>";
                if(empty($row2['profile_picture'])){
                echo" <img src='images/user.png'style='display:block; align-items: center; height:200px;width:200px; border-radius: 50%;'>";
                }
                else{
                echo"
                    <img src='profile_pictures/".$row2['profile_picture']."' style='display:block; align-items: center; height:200px;width:200px; border-radius: 50%;'>";
                }
                echo"
                <br>
                <h4>".$row2['username']."</h4>
                </div>
                
            </div>
            <div
                style='width:75%;border:1px solid black;margin-bottom: 10px;padding:40px;border-bottom-left-radius: 30px;border-bottom-right-radius: 30px;'>
                <div style='text-align: justify;'>";
                if(!empty($row2['linkedin_url'])){
                    echo"
                <h6 style='font-weight: 600;'> LinkedIn URL:</h6>
                <p>". $row2['linkedin_url'] ."</p>";
                }
                if(!empty($row2['github_repo'])){echo"
                <h6 style='font-weight: 600;'> Github Repo:</h6>
                <p>". $row2['github_repo'] ."</p>";
                }
              
                if(!empty($row2['objective'])){
                    echo"
                    <h6 style='font-weight: 600;'> Career Objective:</h6>
                    <hr size='5' width='100%' color='white' style='border-radius: 5px;'>
                    <p>". $row2['objective'] ."</p>
                    <br>";
                }
                if(!empty($row2['work_experience'])){
                    $eq=unserialize($row2['work_experience']);
                   echo"
                        <h6 style='font-weight: 600;'>Work Experience</h6>
                        <hr size='5' width='100%' color='white' style='border-radius: 5px;'>
                        <p id='weT'> <ul>";
                        for ($i=0;$i<count($eq);$i++){
                           
                            echo '<li><b><h6>'. ucwords($eq[$i]['position'.$i+1]).' at '. $eq[$i]['company'.$i+1].'</b><br>';
                            echo  $eq[$i]['desc'.$i+1].'</li><br>';
                         
                        }
                        echo"</ul></p>";
                }
                if(!empty($row2['educational_qualification'])){
                    $eq=unserialize($row2['educational_qualification']);
                        
                        echo"
                        <h6 style='font-weight: 600;'>Educational Qualification</h6>
                        <hr size='5' width='100%' color='white' style='border-radius: 5px;'>
                        <ul>";
                        for ($i=0;$i<count($eq);$i++){
                           
                            echo '<li><b>' . $eq[$i]['course'.$i+1].'-'.$eq[$i]['institution'.$i+1].'</b><br>';
                           
                            echo $eq[$i]['board'.$i+1].'<br>';
                            echo 'CGPA:'. $eq[$i]['cgpa'.$i+1].'<br></li><br>';
                         
                        }
                        echo"</ul>";
                }
                if(!empty($row2['projects'])){
                    $eq=unserialize($row2['projects']);
                    echo "
                    <h6 style='font-weight: 600;'>Projects</h6>
                    <hr size='5' width='100%' color='white' style='border-radius: 5px;'>
                    <ul>";
                    for ($i=0;$i<count($eq);$i++){
                        
                        echo '<li><b>' . $eq[$i]['title'.$i+1].'</b><br>';
                        
                        echo $eq[$i]['proj_desc'.$i+1].'<br><br>';
                       
                        
                    }
                    echo"</ul>";
                }
                if(!empty($row2['skills'])){
                    $eq=unserialize($row2['skills']);
                    echo"
                        <h6 style='font-weight: 600;'>Skills</h6>
                        <hr size='5' width='100%' color='white' style='border-radius: 5px;'>
                        <table style='width:97%;align-content:center' class='container'><ul>";
                        $k=0;
                        for ($j=0;$j<count($eq)/2;$j++){
                            echo'<tr >';
                            for($i=0;$i<2;$i++)
                            {
                            if(!empty($eq[$k]['skill'.$k+1])){
                            echo '<td class="col-md-6"><li>' . $eq[$k]['skill'.$k+1].'&nbsp;&nbsp;';
                            $dash=$eq[$k]['dash'.$k+1];
                            for($d=0;$d<$dash;$d++){
                                echo '<span class="fa fa-star checked"></span>';
                            }
                            echo '</li></td>';
                            $k++;
                        }
                        }
                            echo"</tr>";
                        }
                    echo"</ul></table><br>";
                }
                if(!empty($row2['languages'])){
                        $eq=unserialize($row2['languages']);
                        echo"
                        <h6 style='font-weight: 600;'>Languages</h6>
                        <hr size='5' width='100%' color='white' style='border-radius: 5px;'>
                        <table style='width:97%;'  class='container'><ul>";
                        $k=0;
                        for ($j=0;$j<count($eq)/2;$j++){
                            echo'<tr >';
                            for($i=0;$i<2;$i++)
                            {
                            if(!empty($eq[$k]['lang'.$k+1])){
                            echo '<td class="col-md-6"><li>' . $eq[$k]['lang'.$k+1].'</li></td>';
                            $k++;}
                            }
                            echo"</tr>";
                        }
                        echo"</ul></table>";
                    }
                echo"
                    </div>
                </div>
            </div>";
        }

        if($usertype=='company'){
            $result2=mysqli_query($con,'select * from company inner join users on company.uid=users.user_id where user_id='. $userid);
            $row2=mysqli_fetch_assoc($result2);
            echo "<div
            style='width:60%;color:azure;background-color:rgb(21, 20, 20);border:1px solid black;margin-top:10px;padding:20px;border-top-left-radius: 30px;border-top-right-radius: 30px;;'>

            <div style='margin:10px'>";
            if(empty($row2['company_logo'])){
            echo" <img src='images/company.png'style='display:block; align-items: center; height:200px;width:200px; border-radius: 50%;'>";
            }
            else{
            echo"
                <img src='profile_pictures/".$row2['company_logo']."'
                    style='display:block; align-items: center; height:200px;width:200px; border-radius: 50%;'>";
            }
            echo"
            <br>
            <h4>".$row2['username']."</h4>
            </div>
            
       </div>
       <div
                style='width:60%;border:1px solid black;margin-bottom: 10px;padding:20px;border-bottom-left-radius: 30px;border-bottom-right-radius: 30px;'>
                <div style='text-align: justify;padding:15px'>
                    <h6 style='font-weight: 600;' class='mt-2'>Hiring Manager: </h6>".$row2['company_username']  ." 
                    <table style='width:100%;'>
                    <tr>
                    <td>
                
                    <h6  style='font-weight: 600;' class='mt-2'>Contact: </h6>".$row2['company_phone'] ."
               </td><td>
                    <h6  style='font-weight: 600;' class='mt-2'>Email: </h6>".$row2['email'] ."
                </td></tr>
                <tr><td><h6  style='font-weight: 600;' class='mt-2'>No. People Hired: </h6>".$row2['no_hirings'] ."</td>
                <td><h6  style='font-weight: 600;' class='mt-2'>No. Total Jobs Posted: </h6>".$row2['no_jobs_posted'] ."</td></tr></table>
                    <h6 style='font-weight: 600;' class='mt-2'>Company size:</h6> ".$row2['company_size']  ." employees ";
                    if(!empty($row2['company_website'])){echo"
                    <h6 style='font-weight: 600;' class='mt-2'>Website URL :</h6> <a href='".$row2['company_website']."' class='links'>".$row2['company_website']."</a>"    ;
                    }
                    echo"
                    <h6 style='font-weight: 600;' class='mt-2'> Address: </h6>".$row2['company_address']  .",<br>".$row2['company_city'] .",".$row2['company_state'] .".<br> PINCODE:".$row2['company_pincode'] ."<br>
                    <h6 style='font-weight: 600;' class='mt-2'>About us: </h6> ".$row2['description']  ." 
            </div>
              
        </div>";
        }

        if($usertype=='college'){
            $result2=mysqli_query($con,'select * from colleges inner join users on colleges.uid=users.user_id where user_id='. $userid);
            $row2=mysqli_fetch_assoc($result2);
            echo "<div
            style='width:60%;color:azure;background-color:rgb(21, 20, 20);border:1px solid black;margin-top:10px;padding:20px;border-top-left-radius: 30px;border-top-right-radius: 30px;;'>

            <div style='margin:10px'>";
            if(empty($row2['college_logo'])){
            echo" <img src='images/college.png'style='display:block; align-items: center; height:200px;width:200px; border-radius: 50%;'>";
            }
            else{
            echo"
                <img src='profile_pictures/".$row2['college_logo']."'
                    style='display:block; align-items: center; height:200px;width:200px; border-radius: 50%;'>";
            }
            echo "
            <br>
            <h4>".$row2['username']."</h4>
            </div>
            
       </div>
       <div
                style='width:60%;border:1px solid black;margin-bottom: 10px;padding:20px;border-bottom-left-radius: 30px;border-bottom-right-radius: 30px;'>
                <div style='text-align: justify;padding:15px'>
                    <h6 style='font-weight: 600;' class='mt-2'>Placement Coordinator: </h6>".$row2['college_username']  ." 
                
                    <h6  style='font-weight: 600;' class='mt-2'>Contact: </h6>".$row2['college_phone'] ."
               
                    <h6  style='font-weight: 600;' class='mt-2'>Email: </h6>".$row2['email'] ."

                    <h6 style='font-weight: 600;' class='mt-2'>College size:</h6>". $row2['college_size'] ." students

                    <h6  style='font-weight: 600;' class='mt-2'>No. of students in the network: </h6>".$row2['no_students'] ."

                    <h6 style='font-weight: 600;' class='mt-2'> Address: </h6>".$row2['college_address']  .",<br>".$row2['college_city'] .", ".$row2['college_state'] .".<br> PINCODE:".$row2['college_pincode'] ."<br>
                    <h6 style='font-weight: 600;' class='mt-2'>Mission and Vision: </h6> ".$row2['mission_and_vision']  ." 
            </div>
              
        </div>";
        }
        ?>
    </center>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>