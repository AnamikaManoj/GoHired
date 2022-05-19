<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="style.css">
<?php
 error_reporting(0);
session_start();

echo '
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
    <img src="images/logo1.png" style="width:30px;height:30px"/>
        <a class="navbar-brand" href="index.php">Go Hired!</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>';
                
               
            if(!isset($_SESSION['gh_username'])){ echo'
                <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li><li class="nav-item">
                    <a class="nav-link" href="signup.php">Sign up</a>
                </li>
                </ul>
                </div>
               
            </div>
            
            ';}
            else{
                if($_SESSION['gh_usertype']=='individual'){
                    echo'<li class="nav-item">
                        <a class="nav-link" href="manageApplications.php">My Applications</a>
                    </li>';
                }else if($_SESSION['gh_usertype']=='company'){
                    echo'
                    <li class="nav-item">
                        <a class="nav-link" href="jobs.php">Manage Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="post.php">Post a Job</a>
                    </li>';
                }else if($_SESSION['gh_usertype']=='college'){
                    echo' <li class="nav-item">
                        <a class="nav-link" href="manageStudents.php">Manage Students</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manageNetwork.php">Manage Jobs</a>
                    </li>';
                }else{}
            echo'
            <li class="nav-item">
            <a class="nav-link" href="profile.php?userid='.$_SESSION['gh_userid'].'">Profile</a>
            </li>
            </ul>
            </div>
            <form class="d-flex " action="index.php" method="post">
            <li class="nav-item nav-link" style="color:white">';
            
            echo'
            
            Welcome, '.$_SESSION['gh_username'].' 
          
    <button type="submit" class="btn btn-primary mx-1" id="logout" name="logout">Logout </button></form>

        </div>';
        
        
            }
            echo'
           
    </div>
</nav>';

?>