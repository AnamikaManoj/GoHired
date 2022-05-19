<?php
$errors=array() ;
session_start();
include 'partials/_dbconnect.php';
if(isset($_POST['login'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    $sql="select * from users where email='". $email ."' and password='". md5($password). "';";
    $result=mysqli_query($con,$sql);
    echo mysqli_error($con);
    if($result){
        $num=mysqli_num_rows($result);
        if($num==1){
            $row=mysqli_fetch_assoc($result);
            $_SESSION['gh_userid']= $row['user_id'];
                $_SESSION['gh_username']=$row['username'];
                $_SESSION['gh_email']=$email;
                $_SESSION['gh_usertype']=$row['user_type'];
                if($row['gh_usertype']=='individual'){
                    $r3=mysqli_query($con,'Select * from individuals where uid='.$row['user_id']);
                    $_SESSION['cn_id']=$r3['cn_id'];
                }else{
                    $_SESSION['cn_id']=0;
                }
                header("location:index.php");
        }else{
            array_push($errors, "Email or Password is invalid");
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
    <title>Login</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <?php include 'partials/_header.php'?>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100" style=" padding:20px;">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">

                                    <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Login</p>

                                    <?php if(count($errors)){echo'<div class="alert alert-danger"  role="alert">';
                                    include('partials/_error.php');
                                    echo'</div>';}
                                     ?>

                                    <form class="mx-1 mx-md-4" action="login.php" method="post">

                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="email" name="email" class="form-control" />
                                                <label class="form-label" for="email"> Email</label>
                                            </div>
                                        </div>



                                        <div class="d-flex flex-row align-items-center mb-4">
                                            <i class="fa fa-key fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="password" name="password"
                                                    class="form-control" />
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <button type="submit" id="login" name="login"
                                                class="btn btn-dark btn-lg">Login</button>
                                        </div>
                                        <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                                            <a href="signup.php" class="link-secondary">New Here? Create an Account</a>
                                        </div>
                                    </form>

                                </div>
                                <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="images/login.jpg" class="img-fluid" style="width:480px;height:430px;"
                                        alt="Sample image">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>