<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Jobs</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<?php include 'partials/_header.php'?>
<?php include 'partials/_dbconnect.php';?>

<?php 
    $sql="SELECT * FROM jobs where uid=".$_SESSION["gh_userid"];
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_assoc($result)){
      // echo($row['job_id']);
      $company=$row['uid'];
      $result2=mysqli_query($con,'select * from company inner join users on company.uid = users.user_id where company.uid='.$_SESSION["gh_userid"].';');
      $row2=mysqli_fetch_assoc($result2);
      // '<!--". $row2['company_logo']."-->'
      echo "<div class='mx-3 my-3'>
      <div class='card my-3'>
            <div class='card-header'>".$row2['username'] ."
            </div>

            <div class='card-body'>
            <div>
            <div>
            <a  class='btn btn-dark' name='view_applications' href='applications.php?job_id=".$row['job_id']."&job_title=".$row['job_title'] ."' style='float: right; padding:15px; border-radius:30px'>View Applications</a>
              </div>
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
               
                </div>
            </div>
           


        </div>
    </div";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
