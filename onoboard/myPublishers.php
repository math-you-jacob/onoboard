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
</head>
<body background="background4.jpg" style="background-repeat: no-repeat;background-attachment: fixed;background-size: 100% 100%;">
  <div class="container">
    <div class="alert alert-success" id="mainDiv">
    <br><h3 style='color:blue;text-align: center;'>Manage My Private Publishers</h3><br>
    <div class="row">
      <div class="col-sm">
        <button class="btn btn-primary form-control  btn-block" onclick="myPublishersTab()">Publishers you follow</button></div>
      <div class="col-sm">
        <button class="btn btn-warning form-control btn-block" onclick="findNewPublishersTab()">Find new Publsihers</button></div>
      <div class="col-sm">
        <button class="btn btn-danger form-control btn-block" onclick="pendingTab()">Pending Private Audience Requests</button></div>
    </div>

       
    

   


        <div id="myPublishersDiv" style="display:block">
        <table class="table table-striped">                     
                   <?php 

                      include_once("user_class.php");
                      $user=new UserClass();
                      $user->userid=$_SESSION['userid'];
                      $result=$user->findPublishers("accepted");
                      if ($result->num_rows > 0) {
                      $serialNo=0;
                        while($row = $result->fetch_assoc()) {
                          echo "<div class='table responsive'>
                          <thead>
                              <tr>
                              <th></th>
                              <th>Publisher</th>
                              <th>Email</th>
                              <th>Tags</th>
                              <th>Region</th>
                              <th>Unfollow Publisher</th>
                              </tr>
                          </thead>
                          <tbody>";
                        $serialNo++;
                        $rejectaddr='user_class.php?fn=unfollowPublisher&userid='.$_SESSION['userid'].'&publisherid='.$row['USERID'];
                            echo "<tr>
                                    <td scope='row'>".$serialNo."</td>
                                    <td>" . $row['FIRSTNAME']. "</td>
                                    <td>" . $row['EMAIL'] ."</td>
                                    <td>" . $row['TAGS'] ."</td>
                                    <td>" . $row['REGION'] ."</td>
                                    <td> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href=$rejectaddr class='btn btn-outline-danger'>Unfollow</a>
                                    </tr>";
                                    }
                                } else {
                                    echo "<br><h2>You are not following any Publishers</h2>";
                                } 
                    ?>
                 </tbody> 
              </div>
            </table>
        </div>
        
        <div id="pendingDiv" style="display:none">
        <table class="table table-striped">                     
                   <?php 

                      include_once("user_class.php");
                      $user=new UserClass();
                      $user->userid=$_SESSION['userid'];
                      $result=$user->findPublishers("pending");
                      if ($result->num_rows > 0) {
                                    echo "<div class='table responsive'>
                                    <thead>
                                        <tr>
                                        <th></th>
                                        <th>Publisher</th>
                                        <th>Email</th>
                                        <th>Tags</th>
                                        <th>Region</th>
                                        <th>Audience Request</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                        $serialNo=0;
                        while($row = $result->fetch_assoc()) {
                        $serialNo++;
                        $addr='user_class.php?fn=cancelAudienceRequest&userid='.$_SESSION['userid'].'&publisherid='.$row['userid']; 
                                  echo "<tr>
                                    <td scope='row'>".$serialNo."</td>
                                    <td>" . $row['firstname']. "</td>
                                    <td>" . $row['email'] ."</td>
                                    <td>" . $row['tags'] ."</td>
                                    <td>" . $row['region'] ."</td>
                                    <td> <a href=$addr class='btn btn-outline-danger'>Cancel Request</a>
                                    </tr>";
                                    }
                                } else {
                                    
                                    echo "<br><h2>No pending Requests</h2>";
                                } 
                    ?>
                 </tbody> 
              </div>
            </table>
        </div>






        <div id="findNewPublishersDiv" style="display:none">
        <table class="table table-striped">    
                   <?php 

                      include_once("user_class.php");
                      $user=new UserClass();
                      $user->userid=$_SESSION['userid'];
                      $result=$user->findPublishers("new");
                      if ($result->num_rows > 0) {
                                  echo "<div class='table responsive'>
                                    <thead>
                                        <tr>
                                        <th></th>
                                        <th>Publisher</th>
                                        <th>Email</th>
                                        <th>Tags</th>
                                        <th>Region</th>
                                        <th>Audience Request</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                      $serialNo=0;
                        while($row = $result->fetch_assoc()) {
                        $serialNo++;
                        $addr='user_class.php?fn=sendAudienceRequest&userid='.$_SESSION['userid'].'&publisherid='.$row['userid']; 
                                    echo "<tr>
                                    <td scope='row'>".$serialNo."</td>
                                    <td>" . $row['firstname']. "</td>
                                    <td>" . $row['email'] ."</td>
                                    <td>" . $row['tags'] ."</td>
                                    <td>" . $row['region'] ."</td>
                                    <td> <a href=$addr class='btn btn-outline-primary'>Send Request</a>
                                    </tr>";
                                    }
                                } else {
                                    echo "<br><h2>No new Publishers</h2>";
                                } 
                    ?>
                 </tbody> 
              </div>
            </table>
        </div>
        
        
        











      </div>
  </div>
<script>
    function myPublishersTab()
    {
      var x = document.getElementById("myPublishersDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("mainDiv").class ="alert alert-success";
        document.getElementById("findNewPublishersDiv").style.display = "none";
        document.getElementById("pendingDiv").style.display = "none";
      } 
    }
    function findNewPublishersTab()
    {
      var x = document.getElementById("findNewPublishersDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("mainDiv").class ="alert alert-warning";
        document.getElementById("myPublishersDiv").style.display = "none";
        document.getElementById("pendingDiv").style.display = "none";
      } 
    }
    function pendingTab()
    {
      var x = document.getElementById("pendingDiv");
      if (x.style.display === "none") 
      {
        x.style.display = "block";
        document.getElementById("myPublishersDiv").style.display = "none";
        document.getElementById("findNewPublishersDiv").style.display = "none";
      } 
    }
    

</script>
</body>
</html>


