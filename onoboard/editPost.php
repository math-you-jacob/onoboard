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
    if($_SESSION['usermode']!="publisher")
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
<?php
 $deletePostAddress="user_class.php?fn=deletePost&postid=".$_GET['postid'];
 echo "<a class='btn btn-danger' href=$deletePostAddress>Delete Post</a>";
 ?>
<form action="" method="post">  
<textarea class="form-control" rows="5" name="content"></textarea>
        <select name="tag" class="custom-select">
        <option selected>Select Associated Tags</option>
        <option value="education">Education</option>
        <option value="Job">Job</option>
        <option value="local">Localbusines</option>
        <option value="government">Government</option>
        <option value="offer">Offer</option>
    </select>
        <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="customRadio" name="postmode" value="public" checked>
        <label class="custom-control-label" for="customRadio">Post in Public Mode</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
        <input type="radio" class="custom-control-input" id="customRadio2"  name="postmode" value="private">
        <label class="custom-control-label" for="customRadio2">Post in Private Mode</label>
        </div>
    <button type="submit" class="btn btn-danger" name="submit">Save Changes</button>
</form>
<?php
if(isset($_POST['submit']))
{
  include_once("user_class.php");
  $user=new UserClass();
  $user->content=$_POST['content'];
  $user->tag=$_POST['tag'];
  $user->mode=$_POST['postmode'];
  $user->postid=$_GET['postid'];
  $user->editPost();
}
?>
</div>
</body>
</HTML>