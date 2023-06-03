<?php 
    if(!isset($_POST['submit']))
    {
      alert("fss");
      header('Location:index.php');
      exit;
    }
    session_start();
    include("user_class.php");
    $user=new UserClass();
    $user->email = $_POST['email'];  
    $user->pass = $_POST['pass'];  
    $result=$user->login();  
    $row_cnt=$result->num_rows;
    $row = mysqli_fetch_assoc($result);
    if($row_cnt!=0)
    {
      $_SESSION['userFirstName']=$row['FIRSTNAME'];
      $_SESSION['userid']=$row['USERID'];
      $_SESSION['usermode']==$row['USERMODE'];
      if($row['USERMODE']=="admin")
      {
        header('Location:adminHome.php');
        exit;
      }
      if($row['USERMODE']=="normal")
       { header('Location:userHome.php');
        exit;
       }
      if($row['USERMODE']=="publisher")
      {
        header('Location:publisherHome.php');
        exit;
      }
    }
    else
    {
      $_SESSION['loginFailed']="";
      header('Location:index.php');
      exit;
    }
?>  