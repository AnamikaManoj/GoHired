<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include 'partials/_header.php'?>
<div class='position-absolute top-50 start-50 translate-middle '>
  <h2 class="text-center" style="color:gray"> Choose your account type</h2><br><br>
<div class="row align-items-center ">
  <div class="col-sm-4 text-center  ">
     
        <a href="college_signup.php" class="links"><img src='images/college.png'><br><br>
        <h4 class="card-text " >College</h4></a>
   
  </div>
    <div class="col-sm-4 text-center  ">

      <a href="personal_signup.php" class="links"><img src='images/user.png'><br><br>
        <h4 class="card-text ">Personal</h4></a>
  </div>
  <div class="col-sm-4 text-center  ">
  <a href="employer_signup.php"  class="links"><img src='images/company.png'><br><br>
        <h4 class="card-text  ">Employer</h4></a>
  </div>
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
