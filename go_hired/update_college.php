<?php
include 'partials/_dbconnect.php';
session_start();
if(isset($_POST['update_college'])){
    $contact=$_POST['contact'];
    $name=$_POST['name'];
    $profileimg='';
    $address=$_POST['address'];
    $city=$_POST['city'];
    $state=$_POST['state'];
    $pincode=$_POST['pincode'];
    $college_size=$_POST['college_size'];
    $mission_and_vision=$_POST['mission_and_vision'];

    if(isset($_FILES['profile'])){
        $img_name = $_FILES['profile']['name'];
        $img_size = $_FILES['profile']['size'];
        $tmp_name = $_FILES['profile']['tmp_name'];
        $error = $_FILES['profile']['error'];

        if ($error === 0) {
            if ($img_size > 1000000) {
                echo'<script>alert("Your image size exceeds the limit.<br>Please choose a smaller image.");</script>';
            }else {
                $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                $img_ex_lc = strtolower($img_ex);
                $allowed_exs = array("jpg", "jpeg", "png"); 

                if (in_array($img_ex_lc, $allowed_exs)) {
                    $profileimg = 'profile'. $_SESSION['gh_userid'] .'.'. $img_ex_lc;
                    $img_upload_path = "profile_pictures/".$profileimg;
                    move_uploaded_file($tmp_name, $img_upload_path);

                }else {
                    echo '<script>alert("Profile picture filetype not suported!");</script>';

                }
            }
        }else {
            echo '<script>alert("Your image couldn\'t be uploaded. Please try again later");</script>';
        }
    }
    echo'<script>console.log("at insert");</script>';
    $sql = "INSERT INTO colleges(uid,college_username,college_logo,college_phone,college_state,college_city,college_address,college_pincode,mission_and_vision,college_size	) VALUES('". $_SESSION['gh_userid'] ."','". $name ."','". $profileimg ."','". $contact ."','". $state ."','". $city ."','". $address ."','". $pincode ."','" .$mission_and_vision ."','". $college_size ."')";
    $result=mysqli_query($con, $sql);
    if($result){
        
        echo "<script>alert('Succesfully Updated your profile');";
        echo "window.location.href='index.php'</script>";
        return;

    }else{
        echo "<script>alert('Something went wrong<br>Please update your profile later');";
       echo "window.location.href='index.php'</script>";

    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update your profile</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <?php include 'partials/_header.php'?>

    <center>
        <div class="container"
            style="width:75%;border:1px solid rgb(123, 132, 132);margin:30px;text-align:justify;padding:20px;border-radius: 20px;">
            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Update your Profile</p>

            <form class="mx-1 mx-md-4" action="update_college.php" method="post" enctype="multipart/form-data">

                <div>
                    <!--class="col-md-8"-->
                    <!--first col-->

                    <div class="form-group mt-1" >
                        <label for="collegename">College Name</label>
                        <input type="text" id="name" name="collegename" class="form-control" required disabled
                            value="<?php echo $_SESSION['gh_username'];?>" />
                    </div>
                    <div class="form-group mt-1">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter your name" class="form-control"
                            required />
                    </div>
                    <div class="form-group mt-1">
                        <label for="contact">Official contact</label>
                        <input type="text" id="contact" name="contact" placeholder="Enter your contact"
                            class="form-control" required />
                    </div>
                    <div class="form-group mt-1">
                        <label for="email">Official email ID</label>
                        <input type="text" id="email" name="email" placeholder="Enter your email ID"
                            class="form-control " required disabled value="<?php echo $_SESSION['gh_email'];?>" />
                    </div>
                    <div class="form-group mt-1">
                        <label for="college_size">College size</label>
                        <select class="form-select mt-1" name="college_size" id="college_size">
                            <option selected>Choose college size</option>
                            <option value="Less than 200">Less than 200</option>
                            <option value="200 - 500">200 - 500</option>
                            <option value="500 - 1000">500 - 1000</option>
                            <option value="1000 - 2000">1000 - 2000</option>
                            <option value="More than 2000">More than 2000</option>

                        </select>
                    </div>
                    <div>
                    <label for="mission_and_vision">Mission and Vision</label>
                    <textarea id="mission_and_vision" name="mission_and_vision" placeholder="What is your college's mission and vision?"
                        class="form-control mt-1" rows="3"></textarea>
                </div>
                    <div class="form-group mt-1">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" placeholder="Enter your address"
                            class="form-control " required />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="city">City</label>
                            <input type="text" name="city" id="city" placeholder="Enter city" class="form-control  ">
                        </div>
                        <div class="col-md-6">
                            <label for="state">State</label>
                            <input type="text" name="state" id="state" placeholder="Enter state" class="form-control  ">
                        </div>
                    </div>
                    <div class="form-group mt-1">
                        <label for="pincode">PINCODE</label>
                        <input type="text" id="pincode" name="pincode" placeholder="Enter your pincode"
                            class="form-control " required />
                    </div>
                </div>
                <div class="form-group mt-1">
                    <label for="profile">College Logo (choose a PNG/JPEG/JPG image)</label>
                    <input type="file" id="profile" name="profile" class="form-control " />
                </div>
                <br>
                <div class="d-flex justify-content-center mx-4 mb-2 mb-lg-4">
                    <button type="submit" class="btn btn-dark mt-2" name="update_college" >Update
                        Profile</button>
                </div>

            </form>
        </div>

    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>