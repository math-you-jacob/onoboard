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
  if($_SESSION['usermode']!="normal")
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
<meta charset="utf-8">
<link rel="stylesheet" href="style.css"/>
</head>
<body background="background4.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
 <div class="container pt-5">
    <form action="" method="post">
        <div class="form-group">
            <label for="request">Create your Request for Publisher Account</label>
            <input type="text" class="form-control" placeholder="we are ..example college\institution name..,we would like a publisher account to intereact with our audience...Other details.." name="request">
        </div>
        <button type="Submit" class="btn btn-danger" name='submit'>Send Request</button>
    </form><br>
<?php 
    if(isset($_POST['submit']))
    {
        include("user_class.php");
        $user=new UserClass();
        $user->userid = $_SESSION['userid'];  
        $user->request=$_POST['request'];
        $result=$user->upgradeRequest(); 
        if($result)
        {
            echo '<div class="alert alert-success">';  
            echo '<br>Request Successfuly Submitted';
            echo '</div>';
        }
        else if($result=="0")
        {
            echo '<div class="alert alert-danger">';  
            echo '<br>Failed to Submit Request,Looks like you have already submitted a request.Please wait until it gets processed';
            echo '</div>';
        }
        else
        {
            echo 'something went wrong';
        }
    }
 echo '</div>';
?> 
<body>
</html>