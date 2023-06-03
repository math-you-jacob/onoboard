<!DOCTYPE html>
<?php
  session_start();
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
<body background="background3.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
  <div class="container pt-5">
    <h1>ONoBoard</h1>
    <h2>Your online notice board :)</h2>
    <form action="authentication.php" method="post">
      <div class="form-group">
        <label for="email" color=white>Email address</label>
        <input type="email" class="form-control" placeholder="Enter email" name="email">
      </div>
      <div class="form-group">
        <label for="pass">Password</label>
        <input type="password" class="form-control" placeholder="Enter password" name="pass">
      </div>
      <button type="submit" class="btn btn-danger" name="submit">Log In</button>
    </form><br>
    <a href="registerAccount.php" class="btn btn-success">Sign Up</a> 
  </div>
  <?php
  echo '<div class="container">';
  echo '<br><br>';
  if(isset($_SESSION['loginFailed']))
  {
      echo '<div class="alert alert-danger">';  
      echo '<br>Login Failed,Try Again.';
      echo '</div>';
  }
  if(isset($_SESSION['addaccountstatus']))
  {
      echo '<div class="alert alert-danger"> ';
      echo "<br>Account Not Added :( .Try Again";
      echo '</div>';
  }
  echo "</div>";
  session_destroy();//to destroy all session variables like userid.IMP:else userHome can be accesed without login because of userid.
?>
</body>
</html>

