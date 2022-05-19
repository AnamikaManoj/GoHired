<?php
session_start();
if(isset($_POST['logout'])){
    unset($_SESSION['gh_username']);
    unset( $_SESSION['gh_usertype']);
    unset( $_SESSION['gh_email']);
    unset( $_SESSION['gh_userid']);

    session_destroy();
    header("location=index.php");
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel='stylesheet' type="text/css" href="style.css">
    <title>Go Hired!</title>
<link rel="shortcut icon" href="images/logo.ico" />

</head>

<body>
    <?php   include 'partials/_header.php';?>
    <?php include 'partials/_dbconnect.php';?>

    <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner txtmov ">
            <div class="carousel-item active">
                <img src="images/resume-banner.jpg" class="d-block w-100 img" alt="Welcomt to go Hired!">
                <div class="position-absolute top-50 start-50 translate-middle" style="color:white">
                    <h2 style="font-weight:700;">Find your Dream job now!</h2>
                </div>
            </div>
        </div>
    </div>

    <?php echo"<div class='container'>
    <form action='index.php' method='post' >
    
    <div class='container row my-3'>
    <h5> Filter by: </h5>
    <div class='col-md-4 mt-1'>
        <input class='form-control col-md-3 me-2' name='search' type='search' placeholder='Title' aria-label='Search'>
        </div>
        <div class='col-md-4 mt-1'>
        <select name='job_type'  class=' form-select me-2'>
        <option selected >Job Type</option>
        <option  value='Full'>Full time</option>
        <option value='Part'>Part time</option>
        <option value='Internship'>Internship</option>
        </select></div><div class='col-md-4 mt-1'>
        <input class='form-control col-md-4 me-2' name='location' type='search' placeholder='Location' aria-label='Search'></div>
        <div class='col-md-3 mt-1'>
        <button type='submit' name='filter' class='btn col-md-4 me-2 btn-dark'>Filter</button>
        </div>
    </div>
    </form>";
    if(!isset($_SESSION['gh_usertype'])||$_SESSION['gh_usertype']=='company'||$_SESSION['gh_usertype']=='college'||$_SESSION['cn_id']==0){
    if(isset($_POST['filter'])){
        $search=strtolower($_POST['search']);
        $location=$_POST['location'];
        $job_type=$_POST['job_type'];
        $sql2="select * from jobs where match (`job_title`,`job_description`,`skills`) against ('" .$search. "') or match (`location`) against ('" . $location."') or match (`job_type`) against('". $job_type ."')"  ;
        $result2=mysqli_query($con,$sql2);
        echo mysqli_error($con);
        echo "<h4> Search results for ".$_POST['search'];if($location) echo"/".$location;if($job_type!='Job Type') echo "/".$job_type; echo "</h4>";
        while($fjobs=mysqli_fetch_assoc($result2)){
            $query= mysqli_query($con,'select * from company inner join users on company.uid = users.user_id where company.uid='.$fjobs['uid']);
            $fresult=mysqli_fetch_assoc($query);
        echo "
        <div class='mx-3 my-3'>
        <div class='card my-3'>
            <div class='card-header'>".$fresult['username'] ."
            </div>

            <div class='card-body'>
            <div>
            <div>
                <a href='jobdescription.php?job_id=". $fjobs['job_id']."' class='btn btn-dark ' style='float: right; padding:15px; border-radius:30px' >View Details</a>
              </div>
                <img src='profile_pictures/". $fresult['company_logo']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                <h5 class='card-title'>". $fjobs['job_title'] ."</h5>
                
                <table style='width:85%;'>
                <tr>
                    <td class='col-md-6'>
                        <p >Location: ".$fjobs['location']  ." </p>
                    </td>
                    <td class='col-md-6'>
                        <p >Apply before: ".$fjobs['application_deadline']  ."</p>
                    </td>
                    
                </tr>
                <tr>
                    <td class='col-md-6'>
                        <p >Job type: ".$fjobs['job_type']  ."</p>
                    </td>
                    <td class='col-md-6'>
                        <p >Salary: ".$fjobs['salary']  ." </p>
                    </td>
                    
                </tr>
                </table>
               
                </div>
            </div>
        </div>
    </div>
    ";
        }
     } else{
    $sql="SELECT * FROM jobs";
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_assoc($result)){
      // echo($row['job_id']);
      $company=$row['uid'];
      $result2=mysqli_query($con,'select * from company inner join users on company.uid = users.user_id where company.uid='.$row["uid"].';');
      $row2=mysqli_fetch_assoc($result2);
      // '<!--". $row2['company_logo']."-->'
      echo "<div class='mx-3 my-3'>
      <div class='card my-3'>
            <div class='card-header'>".$row2['username'] ."
            </div>

            <div class='card-body'>
            <div>
            <div>
                <a href='jobdescription.php?job_id=". $row['job_id']."' class='btn btn-dark ' style='float: right; padding:15px; border-radius:30px' >View Details</a>
              </div>
                <img src='profile_pictures/". $row2['company_logo']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                <h5 class='card-title'>". $row['job_title'] ."</h5>
                
                <table style='width:85%;'>
                <tr>
                    <td class='col-md-6'>
                        <p >Location: ".$row['location']  ." </p>
                    </td>
                    <td class='col-md-6'>
                        <p >Apply before: ".$row['application_deadline']  ."</p>
                    </td>
                    
                </tr>
                <tr>
                    <td class='col-md-6'>
                        <p >Job type: ".$row['job_type']  ."</p>
                    </td>
                    <td class='col-md-6'>
                        <p >Salary: ".$row['salary']  ." </p>
                    </td>
                    
                </tr>
            </table>
               
                </div>
            </div>
           


        </div>
    </div";
    }}
    echo'</div>';
}



else{
    if($_SESSION['gh_usertype']=='individual'){
        $qquery=mysqli_query($con,"select * from individuals where uid='".$_SESSION['gh_userid']."'");
        $qrow=mysqli_fetch_assoc($qquery); //$qrow['cn_id'];
        $cquery=mysqli_query($con,"select * from colleges where uid='".$qrow['cn_id']."'");
        if(isset($_POST['filter'])){   
            $search=strtolower($_POST['search']);
            $location=$_POST['location'];
            $job_type=$_POST['job_type'];
            echo mysqli_error($con);
            echo "<h4> Search results for ".$_POST['search'];if($location) echo"/".$location;if($job_type!='Job Type') echo "/".$job_type; echo "</h4>";
            while($row3=mysqli_fetch_assoc($cquery)){ 
                if(!empty($row3['jobs'])){
                $jobs=unserialize($row3['jobs']);
                $num=count($jobs);
                for($i=0;$i<$num;$i++){
            $sql2="select * from jobs  where  (match (`job_title`,`job_description`,`skills`) against ('" .$search. "') or match (`location`) against ('" . $location."') or match (`job_type`) against('". $job_type ."') ) and job_id=".$jobs[$i]  ;
        
            $result2=mysqli_query($con,$sql2);
            echo mysqli_error($con);
            while($fjobs=mysqli_fetch_assoc($result2)){
                $query= mysqli_query($con,'select * from company inner join users on company.uid = users.user_id where company.uid='.$fjobs['uid']);
                $fresult=mysqli_fetch_assoc($query);
                echo "
                <div class='mx-3 my-3'>
                <div class='card my-3'>
                    <div class='card-header'>".$fresult['username'] ."
                    </div>

                    <div class='card-body'>
                    <div>
                    <div>
                        <a href='jobdescription.php?job_id=". $fjobs['job_id']."' class='btn btn-dark ' style='float: right; padding:15px; border-radius:30px' >View Details</a>
                    </div>
                        <img src='profile_pictures/". $fresult['company_logo']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                        <h5 class='card-title'>". $fjobs['job_title'] ."</h5>
                        
                        <table style='width:85%;'>
                        <tr>
                            <td class='col-md-6'>
                                <p >Location: ".$fjobs['location']  ." </p>
                            </td>
                            <td class='col-md-6'>
                                <p >Apply before: ".$fjobs['application_deadline']  ."</p>
                            </td>
                            
                        </tr>
                        <tr>
                            <td class='col-md-6'>
                                <p >Job type: ".$fjobs['job_type']  ."</p>
                            </td>
                            <td class='col-md-6'>
                                <p >Salary: ".$fjobs['salary']  ." </p>
                            </td>
                            
                        </tr>
                        </table>
                    
                        </div>
                    </div>
                </div>
            </div>";
            }
        }
    }
}
        }
      else{

            while($row3=mysqli_fetch_assoc($cquery)){ 
                if(!empty($row3['jobs'])){
                $jobs=unserialize($row3['jobs']);
                $num=count($jobs);
                for($i=0;$i<$num;$i++){
                    $sql="SELECT * FROM jobs where job_id=". $jobs[$i];
                    $result=mysqli_query($con,$sql);
                    while($row=mysqli_fetch_assoc($result)){
                    // echo($row['job_id']);
                        $company=$row['uid'];
                        $result2=mysqli_query($con,'select * from company inner join users on company.uid = users.user_id where company.uid='.$company.';');
                        $row2=mysqli_fetch_assoc($result2);
                        // '<!--". $row2['company_logo']."-->'
                        echo "
                        
                        <div class='card my-3'>
                                <div class='card-header'>".$row2['username'] ."
                                </div>
                    
                                <div class='card-body'>
                            
                                <div>
                                <a  class='btn btn-dark' name='view_applications' href='jobdescription.php?job_id=". $row['job_id']."' style='float: right; padding:15px; border-radius:30px'>View Details</a>
                                </div>
                                <a href='jobdescription.php?job_id=". $row['job_id']."' class='links' >
                                    <img src='profile_pictures/". $row2['company_logo']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                                    <h5 class='card-title'>". $row['job_title'] ."</h5>
                                    
                                    <table style='width:85%;'>
                                    <tr>
                                        <td>
                                            <p >Location: ".$row['location']  ." </p>
                                        </td>
                                        <td>
                                            <p >Apply before: ".$row['application_deadline']  ."</p>
                                        </td>
                                        
                                    </tr>
                                    <tr>
                                        <td>
                                            <p >Job type: ".$row['job_type']  ."</p>
                                        </td>
                                        <td>
                                            <p >Salary: ".$row['salary']  ." </p>
                                        </td>
                                        
                                    </tr>
                                </table>
                                </a> 
                                    </div>
                                
                            
                    
                    
                            </div>
                          ";

                    }
                
            
                }
            }
        }}
}else{
            echo'<div class="container text-center" style="margin: 0;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><a class="links" href="index.php"><h4><i class="fa-solid fa-plus-large"></i>No jobs added by your college</h4></a></div>';
        }

}
   
?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>