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
<style>
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #f7cb05;
  border: none;
  color: #1aa38a;
  text-align: center;
  text-color: #1aa38a;
  font-size: 28px;
  padding: 10px;
  width: 150px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}


.navbar-custom {
    background-color: #ff5500;
}

/* change the brand and text color */
.navbar-custom .navbar-brand,
.navbar-custom .navbar-text {
    color: rgba(255,255,255,.8);
}

/* change the link color */
.navbar-custom .navbar-nav .nav-link {
    color: yellow;
}



/* for dropdown only - change the color of droodown */
.navbar-custom .dropdown-menu {
    background-color: #ff5500;
}
.navbar-custom .dropdown-item {
    color: green;
}





#viewpublicPostDiv {
  width: 100%;
  padding: 50px 0;
  text-align: center;
  background-color: lightblue;
  margin-top: 20px;
}
.card {  
    background-color: rgba(0, 0, 0,0.9);
}


</style>
<head>
<body background="background4.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
  <nav class="navbar  navbar-expand-sm navbar-custom bg-primary  navbar-dark">
    <!--<a class="navbar-brand" href="C:\xampp\htdocs\onoboard\images\logo.png">
    <img src="bird.jpg" alt="Logo" style="width:40px;"> -->
    <ul class="navbar-nav">
    <h1 style="color:white;">ONoBoard</h1>
    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
      <li class="nav-item">
        <a class="nav-link" href="userAccountManagement.php"><h5>Account Management</h5></a>
      </li>
      &nbsp&nbsp&nbsp
      <li class="nav-item">
        <a class="nav-link" href="myPublishers.php"><h5>Manage Publishers</h5></a>
      </li>
      &nbsp&nbsp&nbsp
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">More</a>
      <div class="dropdown-menu">
        <a class="dropdown-item" href="requestPublisherAccount.php">Request Publisher Account</a>
        <a class="dropdown-item" href="createComplaint.php">Create a Complaint</a>
        <a class="dropdown-item" href="about.php">About ONoBoard</a>
      </div>
      </li>
   </ul>
  </nav>
  <a  href="logout.php" class="button"  style="vertical-align:middle;float:right"><span>Log Out</span></a>
  <br>
  <div class="container">  
   <div class="alert alert-danger">
     <?php
      echo"<div class='alert alert-danger'><h4 style='color:blue;text-align: center;'>Personal Notice Board of ".$_SESSION['userFirstName']."</h4></div><br>
      <div class='row'>
        <div class='col-sm'>
          <button class='btn btn-info form-control  btn-block' onclick='privateTab()'>Private Posts from my Publishers</button></div>
        <div class='col-sm'>
          <button class='btn btn-info form-control btn-block' onclick='tagTab()'>Public Posts on my interested Tags</button></div>
        <div class='col-sm'>
          <button class='btn btn-info form-control btn-block' onclick='savedTab()'>Saved Posts</button></div>
      </div><br>";
      ?>

      <div id='privateDiv' style='display:block'>
          <?php
            include_once("user_class.php");
            $user=new UserClass();
            $user->userid=$_SESSION['userid'];
            $result=$user->privatePosts();
            if ($result->num_rows > 0) {
                echo "<div class='row'>";
                while($row=mysqli_fetch_array($result)) 
                    {
                      $user=new UserClass();
                      $user->userid=$row['PUBLISHERID'];
                      $result=$user->getUserName();
                      $r=mysqli_fetch_array($result);
                      $publishername=$r['firstname'];
                      echo "
                      <div class='col-sm-6 col-lg-4'>
                        <div class='card text-white bg-warning mb-3' style='max-width: 18rem;'>
                          <div class='card-header'><h5>".$publishername."</h5></div>
                        <div class='card-body'>
                          <h5 class='card-title'>#".$row['TAG']."</h5>
                          <p class='card-text' style='font-size: 18px;'>".$row['CONTENT']."</p>";
                          $x="user_class.php?fn=addInterest&userid=".$_SESSION['userid']."&postid=".$row['POSTID'];
                          echo "<a class='btn btn-outline-danger' href='$x'>Interested/Save</a>
                         
                        </div>
                        </div>
                      </div>";
                    }  
              echo "</div>"; 
                  }else{
                            echo '<div class="alert alert-success"> ';
                            echo "<br>You have no Private Posts";
                            echo '</div>';
                  }
          ?>
      </div>

      <div id='tagDiv' style='display:none'>
          <?php
            include_once("user_class.php");
            $user=new UserClass();
            $user->userid=$_SESSION['userid'];
            $result=$user->tagPosts();
            if ($result->num_rows > 0) {
                echo "<div class='row'>";
                while($row=mysqli_fetch_array($result)) 
                    {
                      $user=new UserClass();
                      $user->userid=$row['PUBLISHERID'];
                      $result=$user->getUserName();
                      $r=mysqli_fetch_array($result);
                      $publishername=$r['firstname'];
                      echo "
                      <div class='col-sm-6 col-lg-4'>
                        <div class='card text-white bg-warning mb-3' style='max-width: 20rem;'>
                          <div class='card-header'><h5>".$publishername."</h5></div>
                        <div class='card-body'>
                        <h5 class='card-title'>#".$row['TAG']."</h5>
                        <p class='card-text' style='font-size: 18px;'>".$row['CONTENT']."</p>";
                        $x="user_class.php?fn=addInterest&userid=".$_SESSION['userid']."&postid=".$row['POSTID'];
                        echo "<a class='btn btn-outline-danger' href='$x'>Interested/Save</a>
                        
                      </div>
                      </div>
                    </div>";
                    }  
              echo "</div>"; 
                  }else{
                            echo '<div class="alert alert-success"> ';
                            echo "<br>There are no Public Posts based on your  interested tags";
                            echo '</div>';
                  }
          ?>
      </div>
      
      <div id='savedDiv' style='display:none'>
          <?php
            include_once("user_class.php");
            $user=new UserClass();
            $user->userid=$_SESSION['userid'];
            $result=$user->savedPosts();
            if ($result->num_rows > 0) {
                echo "<div class='row'>";
                while($row=mysqli_fetch_array($result)) 
                    {
                      $user=new UserClass();
                      $user->userid=$row['PUBLISHERID'];
                      $result=$user->getUserName();
                      $r=mysqli_fetch_array($result);
                      $publishername=$r['firstname'];
                      echo "
                      <div class='col-sm-6 col-lg-4'>
                        <div class='card text-white bg-warning mb-3' style='max-width: 18rem;'>
                          <div class='card-header'><h5>".$publishername."</h5></div>
                        <div class='card-body'>
                        <h5 class='card-title'>#".$row['TAG']."</h5>
                          <p class='card-text' style='font-size: 18px;'>".$row['CONTENT']."</p>";
                          $x="user_class.php?fn=removeSaved&userid=".$_SESSION['userid']."&postid=".$row['POSTID'];
                          echo "<a class='btn btn-outline-danger' href='$x'>Remove</a>
                           
                        </div>
                        </div>
                      </div>";
                         
                    }  
              echo "</div>"; 
                  }else{
                            echo '<div class="alert alert-success"> ';
                            echo "<br>No posts Saved";
                            echo '</div>';
                  }
          ?>
      </div>

      




   </div>
  </div>

<script>
 function privateTab()
    {
      var x = document.getElementById("privateDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("tagDiv").style.display = "none";
        document.getElementById("savedDiv").style.display = "none";

      } 
      else{
        x.style.display = "none"; 
      }
    }
    function tagTab()
    {
      var x = document.getElementById("tagDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("savedDiv").style.display = "none";
        document.getElementById("privateDiv").style.display = "none";
        

      } 
      else{
        x.style.display = "none"; 
      }
    }
    function savedTab()
    {
      var x = document.getElementById("savedDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("privateDiv").style.display = "none";
        document.getElementById("tagDiv").style.display = "none";
      } 
      else{
        x.style.display = "none"; 

      }
    }
    
  
  </script>
      
</body>
</HTML>
