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
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
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
  padding: 20px;
  width: 200px;
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

/* change the color of active or hovered links */
.navbar-custom .nav-item.active .nav-link,
.navbar-custom .nav-item:hover .nav-link {
    color: #ffffff;
}

/* for dropdown only - change the color of droodown */
.navbar-custom .dropdown-menu {
    background-color: #ff5500;
}
.navbar-custom .dropdown-item {
    color: #ffffff;
}
.navbar-custom .dropdown-item:hover,
.navbar-custom .dropdown-item:focus {
    color: #333333;
    background-color: rgba(255,255,255,.5);
}




#createPostDiv {
  width: 100%;
  padding: 50px 0;
  text-align: center;
  background-color: lightblue;
  margin-top: 20px;
}
.card {
    background-color: rgba(0, 0, 0,0.8);
}




</style>
</head>
<body background="background4.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
<div class="container">
    <div class="alert alert-primary" id="mainDiv">
    <br><h3 style='color:blue;text-align: center;'>Account Information</h3>
    <?php 
     include_once("user_class.php");
     $user=new UserClass(); 
     $user->userid=$_SESSION['userid'];
     $result=$user->getAccountDetails();
     $row=mysqli_fetch_array($result);
     echo "<table class='table table-striped'> 
              <div class='table responsive'>
                          <thead>
                              <tr>
                              <th></th>
                              <th>User ID</th>
                              <th>Email ID</th>
                              <th>First Name</th>
                              <th>Last Name</th>
                              <th>Phone</th>
                              <th>Region</th>
                              <th>Interested Tags</th>
                              </tr>
                          </thead>
                          <tbody>";
                          echo "<tr>
                                    <td scope='row'>
                                    <td>" . $row['USERID']. "</td>
                                    <td>" . $row['EMAIL'] ."</td>
                                    <td>" . $row['FIRSTNAME']. "</td>
                                    <td>" . $row['LASTNAME']. "</td>       
                                    <td>" . $row['PHONE']. "</td>
                                    <td>" . $row['REGION'] ."</td>
                                    <td>" . $row['TAGS'] ."</td>
                                    </tr>
                    
                            </tbody> 
                    </div>
            </table>";     
    ?>
    <div class="row">
      <div class="col-sm">
        <button class="btn btn-primary form-control  btn-block" onclick="return editTab();document.location.reload();">Edit Account Information</button></div>
    <div class="col-sm">
        <button class="btn btn-danger form-control btn-block" onclick="return deleteAccountTab()">Delete your Account</button></div>
      <div class="col-sm">
        <button class="btn btn-primary form-control btn-block" onclick="return changePasswordTab();document.location.reload();">Change Account Password</button></div>
    </div>
    <br>

    <div id="deleteAccountDiv" class="alert alert-danger" style="display:none;text-align:center;">
      <br>
      <br><h4 >When you delete your Account,all data associated will be peremanently lost</h4>
      <?php $addr='user_class.php?fn=deleteUserAccount&userid='.$_SESSION['userid'];
      echo "<a href=$addr class='btn btn-outline-danger' >Delete Account</a>"; ?>
    </div>


    <div id="editDiv" style='display:none' class="alert alert-warning">
            
                <h3>Edit your Account Details</h3>
                <form action="" method="post">
                <div class="form-group">
                    <label for="fname">Change First Name</label>
                    <input type="text" class="form-control"  name="fname" id="fname" required>
                </div>
                <div class="form-group">
                    <label for="lname">Change Last Name</label>
                    <input type="text" class="form-control"  name="lname" id="lname" required>
                </div>
                <div class="form-group">
                    <label for="phone">Change Phone Number</label>
                    <input type="text" class="form-control"  name="phone"id="phone" required>
                </div>
                <div class="form-group">
                    <label for="region">Change Region</label>
                    <input type="text" class="form-control"  name="region" id="region" required>
                </div>
                <label for="tags">Add new Tags of Interest</label><br>
                <select name='tags[]' multiple=2 required>
                    <option value="job" selected>Job</option>
                    <option value="course">Courses</option>
                    <option value="offer">Discount/offers</option>
                    <option value="education">Education</option>
                    <option value="government">Government</option>
                    <optin value="localbusiness">Local businesses</option>
                </select><br><br>
                <button type="submit" class="btn btn-danger" name='Done'>Done</button>
                </form>
                <?php 
                if(isset($_POST['Done']))
                {
                        $tagstring="";
                        foreach ($_POST['tags'] as $tag)  
                            $tagstring.=$tag . ',';
                        include_once("user_class.php");
                        $user=new UserClass();  
                        $user->fname=$_POST['fname'];
                        $user->lname=$_POST['lname'];
                        $user->phone=$_POST['phone'];
                        $user->region=$_POST['region'];
                        $user->tags=$tagstring;
                        $user->userid=$_SESSION['userid'];
                        $result=$user->updateDetails();
                        if($result)
                        {
                            echo '<div class="alert alert-success"> ';
                            echo "<br>Account Information Updated :)";
                            echo '</div>';
                        }
                        
                }
                ?>
    </div>

    
    
    

    
    
    
    <div id="changePasswordDiv" style="display:none" class="alert alert-warning">
       
        <br>
        <form action="" method="post">
        <div class="form-group">
            <label for="pass">New Password</label>
            <input type="password" class="form-control" placeholder="Enter new password" name="pass" required>
        </div>
        <div class="form-group">
            <label for="passre">Confirm new Password</label>
            <input type="password" class="form-control" placeholder="Enter new password again"  name="passre" required>
        </div>
        <button type="submit" class="btn btn-danger" name='submitpass'>Update Password</button>
        </form>  
        <?php
        if(isset($_POST['submitpass']))
        {
            if($_POST['pass']==$_POST['passre'])
            {
                include_once("user_class.php");
                $user=new UserClass(); 
                $user->pass=$_POST['pass'];
                $user->userid=$_SESSION['userid'];
                $result=$user->updatePassword();
                if($result)
                {
                    echo '<div class="alert alert-success"> ';
                    echo "<br>Password Successfully Updated :)";
                    echo '</div>';
                }
            }
            else{
                    echo '<div class="alert alert-danger"> ';
                    echo "<br>Passwords are not matching :(";
                    echo '</div>';
            }
                
        }
        ?>
    </div>

 
 
 

<script>
   function editTab()
    {
      var x = document.getElementById("editDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("changePasswordDiv").style.display = "none";
        document.getElementById("deleteAccountDiv").style.display = "none";

      } 
      else{
        x.style.display = "none"; 
        document.getElementById("changePasswordDiv").style.display = "none";
        document.getElementById("deleteAccountDiv").style.display = "none";
        return;
      }
    }
    function deleteAccountTab()
    {
      var x = document.getElementById("deleteAccountDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("editDiv").style.display = "none";
        document.getElementById("changePasswordDiv").style.display = "none";
        

      } 
      else{
        x.style.display = "none"; 
        document.getElementById("editDiv").style.display = "none";
        document.getElementById("changePasswordDiv").style.display = "none";
        return;
      }
    }
    function changePasswordTab()
    {
      var x = document.getElementById("changePasswordDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("editDiv").style.display = "none";
        document.getElementById("deleteAccountDiv").style.display = "none";
      } 
      else{
        x.style.display = "none"; 
        document.getElementById("editDiv").style.display = "none";
        document.getElementById("deleteAccountDiv").style.display = "none";
        return;
      }
    }

    
</script>
</div>
</div> 
 </body>
 </html>
