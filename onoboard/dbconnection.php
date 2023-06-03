<?php
    class dbconn
    {
      var $con;
      var $res;

      function dbconn()
      {
        $this->con=new mysqli("localhost","root","","onoboard");
        if($this->con->connect_error) 
        {
          die("Connection Failed: ".$con->connect_error);
        }
        return $this->con;    
      }
      function query($sql)
      {
        $res=mysqli_query($this->con,$sql)or die("Connection Failed: ");
        return $res;
      }
    }
?>