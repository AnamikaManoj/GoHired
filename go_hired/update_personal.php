<?php 
session_start();
include 'partials/_dbconnect.php';
if(isset($_POST['update_profile'])){
    $wecount= $_COOKIE['wecount'];
    $eqcount=$_COOKIE['eqcount'];
    $langcount=$_COOKIE['langcount'];
    $skillcount=$_COOKIE['skillcount'];
    $projcount=$_COOKIE['projcount'];
    $contact=$_POST['contact'];
    $linkedin=$_POST['linkedin'];
    $github=$_POST['github'];
    $profileimg='';
    $work_experience="";
    $educational_qualification='';
    $projects='';
    $skills='';
    $languages='';
    $dob=$_POST['dob'];
    $cn_id=$_POST['cn_id'];

// image upload
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
                    echo '<script>alert("Prodile picture filetype not suported!");</script>';

                }
            }
        }else {
            echo '<script>alert("Your image couldn\'t be uploaded. Please try again later");</script>';
        }
    }
$objective=nl2br(htmlspecialchars($_POST['objective']));

//array for work experience
if($_POST['company1']!=''){
$arrwe=array();
$i=1;
while($i <= $wecount){
    $temparr=array();
    ${'company'.$i}=$_POST['company'.$i];
    ${'position'.$i}=$_POST['position'.$i];
    ${'desc'.$i}=nl2br(htmlspecialchars($_POST['desc'.$i]));

   $temparr['company'.$i]=${'company'.$i};
   $temparr['position'.$i]=${'position'.$i};
   $temparr['desc'.$i]=${'desc'.$i};
 $arrwe[$i-1]=$temparr;
 $i++;
}
$work_experience=serialize($arrwe);
}

//array for educational qualification
if($_POST['course1']!=''){
$arreq=array();
$i=1;
while($i <= $eqcount){
    $temparr=array();
    ${'course'.$i}=$_POST['course'.$i];
    ${'institution'.$i}=$_POST['institution'.$i];
    ${'board'.$i}=$_POST['board'.$i];
    ${'cgpa'.$i}=$_POST['cgpa'.$i];

   $temparr['course'.$i]=${'course'.$i};
   $temparr['institution'.$i]=${'institution'.$i};
   $temparr['board'.$i]=${'board'.$i};
   $temparr['cgpa'.$i]=${'cgpa'.$i};
 $arreq[$i-1]=$temparr;
 $i++;
}
$educational_qualification=serialize($arreq);
}

//array for project details
if($_POST['title1']!=''){
$arrproj=array();
$i=1;
while($i <= $projcount){
    $temparr=array();
    ${'title'.$i}=$_POST['title'.$i];
    ${'proj_desc'.$i}=nl2br(htmlspecialchars($_POST['proj_desc'.$i]));

   $temparr['title'.$i]=${'title'.$i};
   $temparr['proj_desc'.$i]=${'proj_desc'.$i};
 $arrproj[$i-1]=$temparr;
 $i++;
}
$projects=serialize($arrproj);
}

//skills array
if($_POST['skill1']!=''){
$arrskill=array();
$i=1;
while($i <= $skillcount){
    $temparr=array();
    ${'skill'.$i}=$_POST['skill'.$i];
    ${'dash'.$i}=$_POST['dash'.$i];

   $temparr['skill'.$i]=${'skill'.$i};
   $temparr['dash'.$i]=${'dash'.$i};
 $arrskill[$i-1]=$temparr;
 $i++;
}
$skills=serialize($arrskill);
}

//languages array
if($_POST['lang1']!=''){
$arrlang=array();
$i=1;
while($i <= $langcount){
    $temparr=array();
    ${'lang'.$i}=$_POST['lang'.$i];

   $temparr['lang'.$i]=${'lang'.$i};
 $arrlang[$i-1]=$temparr;
 $i++;
}
$languages=serialize($arrlang);
}

// Insert into Database
$sql = "INSERT INTO individuals(uid,individual_contact,	linkedin_url,github_repo,profile_picture,objective,	work_experience,educational_qualification,projects,skills,languages,cn_id,dob	) VALUES('". $_SESSION['gh_userid'] ."','". $contact ."','". $linkedin ."','". $github ."','". $profileimg ."','". $objective ."','". $work_experience ."','". $educational_qualification ."','". $projects ."','". $skills ."','". $languages ."','".$cn_id."','".$dob."')";
$result=mysqli_query($con, $sql);

echo $result;
if($result){
    $_SESSION['cn_id']=$cn_id;
    echo "<script>alert('Succesfully Updated your profile');";
    echo "window.location.href='index.php'</script>";
    return;

}
else echo mysqli_error($con);


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
    <script type="text/javascript">
    function valueChanged() {
        console.log("inside func");
        var checkBox = document.getElementById("cn_idcb");
        var text = document.getElementById("v");
        if (checkBox.checked == true) {
            text.style.display = "block";
        } else {
            text.style.display = "none";
        }
    }
    </script>
</head>

<body>
    <?php include 'partials/_header.php'?>

    <center>
        <div class="container"
            style="width:75%;border:1px solid rgb(123, 132, 132);margin:30px;text-align:justify;padding:20px;border-radius: 20px;">
            <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Update your Profile</p>

            <form class="mx-1 mx-md-4" action='update_personal.php' method="post" enctype="multipart/form-data">

                <div>
                    <!--class="col-md-8"-->
                    <!--first col-->
                    <h3>Personal Information</h3>
                    <div class="form-group mt-1">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" placeholder="Enter you name" class="form-control"
                            required disabled value="<?php echo $_SESSION['gh_username'];?>" />
                    </div>
                    <div class="form-group mt-1">
                        <label for="contact">Your contact</label>
                        <input type="text" id="contact" name="contact" placeholder="Enter you contact"
                            class="form-control" required />
                    </div>
                    <div class="form-group mt-1">
                        <label for="email">Your email ID</label>
                        <input type="text" id="email" name="email" placeholder="Enter you email ID"
                            class="form-control " required disabled value="<?php echo $_SESSION['gh_email'];?>" />
                    </div>
                    <div class="form-group mt-1">
                        <label for="linkedin">Your LinkedIn url</label>
                        <input type="text" id="linkedin" name="linkedin" placeholder="Enter your LinkedIn Profile ID"
                            class="form-control " />
                    </div>
                    <div class="form-group mt-1">
                        <label for="github">Your github repo ID</label>
                        <input type="text" id="github" name="github" placeholder="Enter you Github Profile ID"
                            class="form-control " />
                    </div>
                    <div class="form-group mt-1">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" class="form-control " />
                    </div>
                    <div class="form-group mt-1">
                        <label for="profile">Profile Picture (choose a PNG/JPEG/JPG image)</label>
                        <input type="file" id="profile" name="profile" class="form-control " />
                    </div>
                </div>

                <div>
                    <h3 class="my-3">Objective </h3>
                    <textarea id="objective" name="objective" placeholder="What is your career objective?"
                        class="form-control mt-1" rows="3"></textarea>
                </div>

                <div>
                    <h3 class="my-3">Work Experience</h3>
                    <div class="form-group mt-2 " id="we">
                        <input type="text" id="company1" name="company1" placeholder="Enter company name"
                            class="form-control mt-1 we1">
                        <input type="text" id="position1" name="position1" placeholder="Enter your position"
                            class="form-control mt-1 we2">
                        <textarea id="desc1" name="desc1" placeholder="Add a description" class="form-control mt-1 "
                            rows="3"></textarea>
                        <button type="button" class="btn btn-dark mt-2" name="add" id="add"
                            onclick="addNewexp()">Add</button>
                    </div>
                </div>
                <div>
                    <h3 class="my-3">Educational Qualification</h3>
                    <div class="form-group mt-2" id="eq">
                        <input type="text" id="course1" name="course1" placeholder="Enter course name"
                            class="form-control mt-1">
                        <input type="text" id="institution1" name="institution1" placeholder="Enter institution name"
                            class="form-control mt-1">
                        <input type="text" id="board1" name="board1" placeholder="Enter board/university name"
                            class="form-control mt-1">
                        <input type="cgpa" id="cgpa1" name="cgpa1" placeholder="Enter overall CGPA/Percentage"
                            class="form-control mt-1">
                        <button type="button" class="btn btn-dark mt-2" id="addeq" name="addeq"
                            onclick="addNewQual()">Add</button>
                    </div>
                </div>
                <div>
                    <h3 class="my-3">Projects</h3>
                    <div class="form-group mt-2" id="proj">
                        <input type="text" name="title1" id="title1" placeholder="Enter project title"
                            class="form-control mt-1">
                        <textarea id="proj_desc1" name="proj_desc1" placeholder="Add a description"
                            class="form-control mt-1" rows="3"></textarea>
                        <button type="button" class="btn btn-dark mt-2" id="addProj" onclick="addNewProj()">Add</button>
                    </div>
                </div>
                <div>
                    <h3 class="my-3">Skills</h3>
                    <div class="form-group mt-2" id="skill">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" name="skill1" id="skill1" placeholder="Enter skill"
                                    class="form-control mt-1 ski">
                            </div>
                            <div class="col-md-6">
                                <select class="form-select mt-1" name="dash1" id="dash1">
                                    <option selected>Choose expertise level</option>
                                    <option value="1">Novice</option>
                                    <option value="2">Intermediate</option>
                                    <option value="3">Proficient</option>
                                    <option value="4">Expert</option>

                                </select>
                            </div>
                        </div>
                        <button type="button" class="btn btn-dark mt-2" id="addSkill" required
                            onclick="addNewskill()">Add</button>
                    </div>
                </div>
                <div>
                    <h3 class="my-3">Languanges</h3>
                    <div class="form-group mt-2" id="lang">
                        <input type="text" id="lang1" name="lang1" placeholder="Enter language"
                            class="form-control mt-1">

                        <button type="button" class="btn btn-dark mt-2" id="addLang" onclick="addNewlang()">Add</button>
                    </div>
                </div>
                <div class=" mt-3 form-check">
                    <input type="checkbox" class="form-check-input"onclick="valueChanged()" id="cn_idcb">
                    <label class="form-check-label"  for="cn_idcb">I have a College Network
                        ID</label>
                </div>
                <div class="form-group mt-1" name='v' style='display:none' id='v'>
                    <label for="cn_id">College Network ID</label>
                    <input type="text" id="cn_id" name="cn_id" placeholder="Enter you College Network ID"
                        class="form-control " />
                </div>

                <div class="d-flex justify-content-center mx-4 mb-3 mb-lg-4">
                    <button type="submit" class="btn btn-dark mt-2" name="update_profile" onclick="validate()">Update
                        Profile</button>
                </div>

            </form>
        </div>

    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="script.js"></script>
</body>

</html>