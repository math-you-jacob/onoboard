<!DOCTYPE html>
<?php
  session_start();
  if(!isset($_SESSION['userid']))
  {
    header('Location:index.php');
    exit;
  }
if(isset($_SESSION['usermode']))
{
    if($_SESSION['usermode']!="admin")
    {
     header('Location:index.php');
     exit;
    }
}
?>
<html>
<head>
<title>ONoBoard</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css"/>
<meta charset="utf-8">
</head>
<body background="background4.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
<div class="container pt-5">
<div class="alert alert-success">
<br><h3 style='color:blue;text-align: center;'>Pending Publisher Requests</h3>
<?php
    include("user_class.php");
    $admin=new adminClass();
    $result=$admin->viewPublisherRequests();
    if ($result->num_rows > 0) {    
         echo "<div class='row'>";
      while($row=mysqli_fetch_array($result)) 
          {
            $user=new UserClass();
            $user->userid=$row['USERID'];
            $res=$user->getUserName();
            $r=mysqli_fetch_array($res);
            $username=$r['firstname'];

            $acceptRequestAddress="user_class.php?fn=acceptPublisherRequest&userid=".$row['USERID'];
            $rejectRequestAddress="user_class.php?fn=rejectPublisherRequest&userid=".$row['USERID'];
            echo "
            <div class='col-sm-6 col-lg-4'>
              <div class='card text-white bg-warning mb-3' style='max-width: 20rem;'>
                <div class='card-header'>Request from <h5>".$username."</h5></div>
              <div class='card-body'>
                <h6 class='card-title'>USER ID: ".$row['USERID']."</h6>
                <p class='card-text' style='font-size: 18px;'>".$row['REQUEST']."</p>
                <a class='btn btn-outline-success' href='".$acceptRequestAddress."'>Accept Request</a>
                <a class='btn btn-outline-danger' href='".$rejectRequestAddress."'>Reject Request</a>
              </div>
              </div>
            </div>";
          }  
    echo "</div>"; 
        }else{
                  echo '<div class="alert alert-success"> ';
                  echo "<br>No Pending Publisher Request";
                  echo '</div>';
        } 
?>
</div>
</div>
</body>
</html>
