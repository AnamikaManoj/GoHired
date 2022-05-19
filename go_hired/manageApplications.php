<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
<?php include 'partials/_header.php';
include'partials/_dbconnect.php'?>

<?php 
    $sql="SELECT * FROM applications inner join jobs on applications.jobid=jobs.job_id where applications.uid=".$_SESSION["gh_userid"];
    $result=mysqli_query($con,$sql);
    while($row=mysqli_fetch_assoc($result)){
      // echo($row['job_id']);
      $company=$row['uid'];
      $result2=mysqli_query($con,'select * from company inner join users on company.uid = users.user_id where company.uid='.$company.';');
      $row2=mysqli_fetch_assoc($result2);
      // '<!--". $row2['company_logo']."-->'
      echo "<div class='mx-3 my-3'>
      <div class='card my-3'>
            <div class='card-header'>".$row2['username'] ."
            </div>

            <div class='card-body'>
            <div>
            <div>
            <a  class='btn btn-dark'  style='float: right; padding:15px; border-radius:30px'>". $row['status']."</a>
              </div>
              <a href='jobdescription.php?job_id=". $row['job_id']."' class='links' >
                <img src='profile_pictures/". $row2['company_logo']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                <h5 class='card-title'>". $row['job_title'] ."</h5>
                
                <table style='width:85%;'>
                <tr>
                    <td class='col-md-6'>
                        <p >Location: ".$row['location']  ." </p>
                    </td>
                    <td class='col-md-6'>
                        <p >Applied on: ".$row['applied_on']  ."</p>
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
               </a>
                </div>
            </div>
           


        </div>
    </div";
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>

