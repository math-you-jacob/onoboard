<!DOCTYPE html>
<html>

<head>
  <title>ONoBoard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>

  <meta charset="utf-8">
  <link rel="stylesheet" href="style.css"/>
</head>

<body background="background4.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
  <div class="container pt-3">
    <form action="" method="post">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" placeholder="Enter email" name="email" required>
      </div>
      <div class="form-group">
        <label for="pass">Password</label>
        <input type="password" class="form-control" placeholder="Enter password" name="pass" required>
      </div>
      <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" class="form-control" placeholder="Enter your First Name" name="fname" required>
      </div>
      <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" class="form-control" placeholder="Enter your Last Name" name="lname">
      </div>
      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="text" class="form-control" placeholder="Enter your Phone Number" name="phone" required>
      </div>
      <div class="form-group">
        <label for="region">Region</label>
        <input type="text" class="form-control" placeholder="Enter your Country" name="region">
      </div>
      <label for="tags">Tags of Interest</label><br>
      <select name='tags[]' multiple=2 required>
        <option value="job">Job</option>
        <option value="course">Courses</option>
        <option value="offer">Discount/offers</option>
        <option value="education">Education</option>
        <option value="government">Government</option>
        <option value="localbusiness">Local businesses</option>
      </select><br><br>
      <button type="submit" class="btn btn-danger" name='submit'>Register</button>
    </form>

<?php 
  if(isset($_POST['submit']))
  {
        session_start();
        $tagstring="";
        foreach ($_POST['tags'] as $tag)  
            $tagstring.=$tag . ',';
        include("user_class.php");
        $user=new UserClass();
        $user->email = $_POST['email'];  
        $user->pass= $_POST['pass']; 
        $user->fname=$_POST['fname'];
        $user->lname=$_POST['lname'];
        $user->phone=$_POST['phone'];
        $user->region=$_POST['region'];
        $user->tags=$tagstring;

        $result=$user->register();  
        if($result=="0")
        {
            echo '<div class="alert alert-warning">';
            echo "<br>An Account with this Email Address Already Exists :( . Use Another :) ";
            echo '</div>';
        }
        else if($result)
        {
          $result=$user->login();  
          $row_cnt=$result->num_rows;
          $row = mysqli_fetch_assoc($result);
          if($row_cnt!=0)
          {
            $_SESSION['userFirstName']=$row['FIRSTNAME'];
            $_SESSION['userid']=$row['USERID'];
            header('Location:userHome.php');
          }
        }
        else
        {
            $_SESSION['addaccountstatus']='false';
            header('Location:index.php');
        }
    }
   ?> 
   </div>
</body>

</html>