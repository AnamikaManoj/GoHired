<?php

include 'partials/_dbconnect.php';
session_start();
if(isset($_POST['post'])){
    $job_title=$_POST['job_title'];
    $no_positions=$_POST['no_positions'];
    $job_type=$_POST['job_type'];
    $salary=$_POST['salary']." ".$_POST['unit'];
    $location=$_POST['location'];
    $application_deadline=$_POST['application_deadline'];
    $experience=$_POST['experience'].' years';
    $job_description=nl2br(htmlspecialchars($_POST['job_description']));
    $skills=nl2br(htmlspecialchars($_POST['skills']));
    $perks=nl2br(htmlspecialchars($_POST['perks']));

    $sql = 'INSERT INTO jobs(uid,job_title,no_positions,job_description,job_type,salary,location,perks,skills,application_deadline, experience	)
     VALUES("'.$_SESSION['gh_userid'].'","'. $job_title .'","'. $no_positions .'","'. $job_description .'","'. $job_type .'","'. $salary .'","'. $location .'","'. $perks .'","'. $skills .'","' .$application_deadline .'","'. $experience .'")';
    $result=mysqli_query($con, $sql);
    $query=mysqli_query($con,'update company set no_jobs_posted=no_jobs_posted+1 where uid='.$_SESSION['gh_userid'].';');
    if($result){
        
        echo "<script>alert('Your job is posted successfully');";
       echo "window.location.href='index.php'</script>";
        return;

    }else{

        echo"<script>alert('Could not post your job :( Please try again later');</script>";
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
    <title>Post Job </title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">

</head>

<body>
    <?php include 'partials/_header.php'?>

    <center>
        <div class="container"
            style="width:75%;border:1px solid black;margin:30px;text-align:justify;padding:20px;border-radius: 20px;">
            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Post an Opening in your Firm</p>

            <form class="mx-1 mx-md-4" action="post.php" method="post" enctype="multipart/form-data">

                <div>
                    <!--class="col-md-8"-->
                    <!--first col-->

                    <div class="form-group mt-1">
                        <label for="job_title">Job title</label>
                        <input type="text" id="job_title" name="job_title" placeholder="Enter job title"
                            class="form-control" required />
                    </div>


                    <div>
                        <label for="job_description">Job description</label>
                        <textarea id="job_description" name="job_description" placeholder="Job description"
                            class="form-control mt-1" rows="3"></textarea>
                    </div>
                    <div class="form-group mt-1">
                        <label for="no_positions">No. Positions</label>
                        <input type="number" id="no_positions" name="no_positions"
                            placeholder="How many openings do you have?" class="form-control" required />
                    </div>
                    <div class="form-group mt-1">
                        <label for="experience">Experience required</label>
                        <input type="number" id="experience" name="experience"
                            placeholder="Years of experience required" class="form-control" required />
                    </div>
                    <div class="form-group mt-1">
                        <label for="job_type">Job Type</label>
                        <select class="form-select mt-1" name="job_type" id="job_type">
                            <option selected>Choose job type</option>
                            <option value="Full time">Full time</option>
                            <option value="Part time">Part time</option>
                            <option value="Internship">internship</option>
                        </select>
                    </div>

                    <div class="row mt-1">
                        <div class="col-md-6 ">
                            <label for="salary">salary</label>
                            <input type="text" name="salary" id="salary" placeholder="Enter salary"
                                class="form-control  ">
                        </div>
                        <div class="col-md-6 ">
                            <label for="salary"></label>
                            <select class="form-select " name="unit" id="unit">
                                <option selected value="LPA">LPA</option>
                                <option value="Per month">Per month</option>
                                <option value="Lumpsum">Lumpsum</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mt-1">
                        <label for="location">Job location</label>
                        <input type="text" id="location" name="location" placeholder="Enter job location"
                            class="form-control " required />
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-md-6">
                        <label for="perks">Perks</label>
                        <textarea id="perks" name="perks" placeholder="Enter the perks of this position" rows="1"
                            class="form-control mt-1"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="skills">Skills required</label>

                        <textarea id="skills" name="skills" placeholder="Enter skills required" rows="1"
                            class="form-control mt-1"></textarea>

                    </div>
                </div>
                <div class="form-group mt-1">
                    <label for="application_deadline">Application deadline</label>
                    <input type="date" id="application_deadline" name="application_deadline" placeholder="Choose a date"
                        class="form-control" required />
                </div>
                <br>
                <div class="d-flex justify-content-center mx-4 mb-2 mb-lg-4">
                    <button type="submit" class="btn btn-dark mt-2" name="post">Post Job</button>
                </div>

            </form>
        </div>

    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

</body>

</html>