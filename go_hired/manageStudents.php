<?php
include 'partials/_dbconnect.php';
if(isset($_POST['remove'])){
    $id=$_GET['rm_id'];
    $update=mysqli_query($con,"update individuals set cn_id=0 where uid='".$id."'");
    echo mysqli_error($con);
    if($update){
        echo "<script>alert('Student removed successfully'); window.location.href='manageStudents.php'</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
<link rel="shortcut icon" href="images/logo.ico" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include 'partials/_header.php';?>

<?php
echo"
<div class='container' style='width:75%;margin-top:10px;padding:20px;'>
    <form action='manageStudents.php' method='post' >
    <div class='container  row'>
    <p>College Network ID: ".$_SESSION['gh_userid'] ." (Share with your students to add them to your network)</p>
    <div class='col-md-10'>
        <input class='form-control me-2' name='search' type='search' placeholder='Search' aria-label='Search'>
        </div>
        <div class='col-md-2'>
        <button type='submit' name='filter_name' class='btn  btn-dark'>Search</button>
        </div>
    </div>
    </form>";
    if(isset($_POST['filter_name'])){
        $search=strtolower($_POST['search']);
        $sql2="select * from individuals inner join users on individuals.uid = users.user_id where cn_id=".$_SESSION['gh_userid'] ." and match (`username`,`email`) against ('" .$search. "')" ;
        $result2=mysqli_query($con,$sql2);
        echo mysqli_error($con);
        $num=mysqli_num_rows($result2);
        while($row2=mysqli_fetch_assoc($result2)){
        echo "
        <div class='container' style='width:90%;border:1px solid rgb(123, 132, 132);margin:10px;padding:20px;border-radius: 20px;'>
            <div class='row'>
                <div class='col-md-10'>
                    <a href='profile.php?userid=".$row2["uid"]."' class='links'>
                    <img src='profile_pictures/". $row2['profile_picture']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                    <h5 class='card-title'>". $row2['username'] ."</h5>
                    <table style='width:85%;'>
                        <tr>
                            <td class='col-md-6'>
                                <p >Email: ".$row2['email']  ." </p>
                            </td>
                            <td class='col-md-6'>
                                <p >Contact: ".$row2['individual_contact']  ."</p>
                            </td>
                        <tr>
                        </tr>
                            <td class='col-md-6'>
                                <p >No: jobs Applied: ".$row2['no_jobs_applied']  ."</p>
                            </td> 
                        </tr>
                
                    </table>
                    </a>
                    
                </div>
                <div class='col-md-2' style='float: right;'>
                    <form action='manageStudents.php?rm_id=".$row2['uid']."' method='post'>
                        <table>
                            <tr>
                                <td>";
                                
                        
                            
                                echo " <button class='btn-dark '  type='submit' style=' padding:4px; border-radius:25px' name='remove'>Remove Student</button>;
                                
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    ";
    }
    if($num==0){
        echo'<div class="container text-center" style="margin: 0;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><h4>We could not find "'.$search.'" in your network.</h4></div>';
    }
}else{
$sql="select * from individuals inner join users on individuals.uid = users.user_id where cn_id=".$_SESSION['gh_userid'];
$result=mysqli_query($con,$sql);
$count=mysqli_num_rows($result);
while($row=mysqli_fetch_assoc($result)){
    

    echo "
        <div class='container' style='width:90%;border:1px solid rgb(123, 132, 132);margin:10px;padding:20px;border-radius: 20px;'>
        <div class='row'>
            <div class='col-md-10'>
                <a href='profile.php?userid=".$row["uid"]."' class='links'>
                <img src='profile_pictures/". $row['profile_picture']."' class='mx-2' alt='image' style='float:left;border-radius:100%;height:60px;width:60px''>
                <h5 class='card-title'>". $row['username'] ."</h5>
                <table style='width:85%;'>
                    <tr>
                        <td class='col-md-6'>
                            <p >Email: ".$row['email']  ." </p>
                        </td>
                        <td class='col-md-6'>
                            <p >Contact: ".$row['individual_contact']  ."</p>
                        </td>
                    <tr>
                    </tr>
                        <td class='col-md-6'>
                            <p >No: jobs Applied: ".$row['no_jobs_applied']  ."</p>
                        </td> 
                    </tr>
            
                </table>
                </a>
                
            </div>
            <div class='col-md-2' style='float: right;'>
            <form action='manageStudents.php?rm_id=". $row['uid'] ."' method='post'>
                <table>
                    <tr>
                        <td>";
                        
                
                    
                        echo " <button class='btn-dark '  type='submit' style=' padding:4px; border-radius:25px' name='remove'>Remove Student</button>;
                        
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        </div>
        </div>
    ";
    }
    if ($count==0){
        echo'<div class="container text-center" style="margin: 0;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"><h4>No Students added Yet</h4></div>';

    }
}
echo"<div>";
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>
