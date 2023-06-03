<!DOCTYPE html>
<?php
  session_start();
  if(!isset($_SESSION['userid']))
  {
    header('Location:index.php');
    exit;
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
<body background="background1.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
 <div class="container pt-5">
    <form action="" method="post">
        <div class="form-group">
            <label for="complaint">Brief your Complaint</label>
            <input type="text" class="form-control" placeholder="I have seen a post by ..example publisher name..,which i think goes against the community guidelines." name="complaint">
        </div>
        <button type="submit" class="btn btn-danger" name="submit">Send Complaint</button>
    </form><br>

<?php 
    if(isset($_POST['submit']))
    {
        include("user_class.php");
        $user=new UserClass();
        $user->userid = $_SESSION['userid'];  
        $user->complaint=$_POST['complaint'];
        $result=$user->createComplaint(); 
        if($result)
        {
            echo '<div class="alert alert-success">';  
            echo '<br>Complaint Successfuly Submitted';
            echo '</div>';
        }
        else
        {
            echo '<div class="alert alert-danger">';  
            echo '<br>Something went wrong.';
            echo '</div>';
        }
    }
 echo '</div>';
?> 
<body>
</html>