<?php
session_start();
$errors=array() ;
$showalert=false;

if(isset($_POST['signup'])){
  $errors=array();
  include "partials/_dbconnect.php";
  $username=$_POST['username'];
  $password=$_POST['password'];
  $password2=$_POST['password2'];
  $email=trim(strtolower($_POST['email']));
  $exists=false;
  if($password!=""&&$username!=""&&$email!=""){
    $sql="select email from users;";
    $result=mysqli_query($con,$sql);
    while ($row=mysqli_fetch_assoc($result)){
        if(strcmp($email,$row['email'])==0){
        
          echo "<script>alert('Account already exists! Please login');";
          echo "window.location.href='login.php'</script>";
          return;
        }
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      array_push($errors, "The email is not valid");

    }
    if(strlen($password)<8){
      array_push($errors, "The password should be atleast 8 characters");
    }else{
      if($password==$password2){
          //insert userninto database
        $sql="insert into users (username,email,password,user_type) values ('". $username ."','". $email ."','". md5($password) ."','individual');";
        $result=mysqli_query($con,$sql);
        if($result){

            //fetch user id from database
            $getid="select user_id from users where username='".$username."';";
            $get=mysqli_query($con,$getid);
            $id= mysqli_fetch_assoc($get);

            $_SESSION['gh_userid']= $id['user_id'];
            $_SESSION['gh_username']=$username;
            $_SESSION['gh_email']=$email;
            $_SESSION['gh_usertype']='individual';
          header("location:update_personal.php");
        }else{
          echo 'Could not create account'.mysqli_error();
        }
      }else
      {
       array_push($errors, "The two passwords do not match");
      }
    }
  }else{
    array_push($errors, "Enter all the required details");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body >
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <?php include 'partials/_header.php'?>

    <section class="vh-auto" style="background-color: #eee;">
        <div class="container h-100" style=" padding:20px;">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Sign up</p>
                                    <?php if(count($errors)){echo'<div class="alert alert-danger"  role="alert">';
                                    include('partials/_error.php');
                                    echo'</div>';}
                                     ?>
                                    
                                    <form class="mx-1 mx-md-4" action='personal_signup.php' method="post">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-user fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="text" id="username" name='username' class="form-control" />
                                                <label class="form-label" for="username">Your Name</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="email" name="email" class="form-control" />
                                                <label class="form-label" for="email">Your Email</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="password1" name="password"
                                                    class="form-control" />
                                                <label class="form-label" for="password1">Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="password2" name="password2"
                                                    class="form-control" />
                                                <label class="form-label" for="password2">Repeat your password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" name="signup"
                                                class="btn btn-dark btn-lg" >Register</button>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <a href="login.php" class="link-secondary">Already have an account? Login</a>
                                        </div>

                                    </form>

                                </div>
                                <!-- <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="images/login.jpg" class="img-fluid" alt="Sample image">

                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



</body>

</html>