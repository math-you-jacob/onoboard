<?php
    include_once("dbconnection.php");
    class UserClass
    {
		
		function UserClass()
    	{
    		$this->dbconn=new dbconn();
        }
		function getUserName()
		{
			$sql="SELECT firstname FROM users WHERE userid='$this->userid'";
			$result=$this->dbconn->query($sql);
            return $result;
		}
		function login()
        {
        $sql="SELECT * FROM users WHERE email='$this->email' AND password='$this->pass'";
        $result=$this->dbconn->query($sql);
        return $result;
        }
        function register()
    	{
			$sql="SELECT * FROM users WHERE email='$this->email';";
			$result=$this->dbconn->query($sql);
			$row_cnt=$result->num_rows;
            if($row_cnt==1)
            	return "0";
			$sql="INSERT INTO users(email,password,firstname,lastname,phone,region,tags)VALUES('$this->email','$this->pass','$this->fname','$this->lname','$this->phone','$this->region','$this->tags');";
    		$result=$this->dbconn->query($sql);
    		return $result;
    	}
		function upgradeRequest()
		{
			$sql="SELECT * FROM publisher_requests WHERE userid='$this->userid';";
			$result=$this->dbconn->query($sql);
			$row_cnt=$result->num_rows;
            if($row_cnt==1)
            	return "0";
			$sql="INSERT INTO publisher_requests(userid,request)VALUES('$this->userid','$this->request');";
            $result=$this->dbconn->query($sql);
    		return $result;		
		}
		function createComplaint()
		{
			$sql="INSERT INTO complaints(userid,complaint)VALUES('$this->userid','$this->complaint');";
            $result=$this->dbconn->query($sql);
    		return $result;		
		}
		function createPost()
		{
			$sql="INSERT INTO announcements(publisherid,mode,content,tag) VALUES('$this->userid','$this->mode','$this->content','$this->tag');";
		    $result=$this->dbconn->query($sql);
		}
		function viewPublisherPosts()
		{
			$sql="SELECT * FROM announcements WHERE publisherid='$this->userid'";
			$result=$this->dbconn->query($sql); 
    		return $result;
		}
		function privatePosts()
		{
			$sql="SELECT * FROM announcements WHERE publisherid IN(SELECT DISTINCT publisherid FROM audience WHERE userid='$this->userid' AND request_status='accepted')";  
			$result=$this->dbconn->query($sql); 
    		return $result;
		}
		function tagPosts()
		{
			$sql="SELECT tags FROM users WHERE userid='$this->userid'";
			$result=$this->dbconn->query($sql);
			$p=mysqli_fetch_array($result);
			$tags=explode(",",$p['tags']);
			$taglength=count($tags);
			$search="LIKE '%";
			$i=0;
			while($i<$taglength)
			{
              $search.=$tags[$i];
			  if($i+2<$taglength)
			  {
				  $search.="%' OR tag LIKE '%";
			  }
			  elseif($i+2==$taglength)
			  {
				  $search.="%'";
			  }
			  $i++;
			}
			$sql="SELECT * FROM announcements WHERE (tag ".$search.") AND mode='public'"; 
			$result=$this->dbconn->query($sql); 
    		return $result;
		}
		function searchPost()
		{ 
				$sql="SELECT userid FROM users WHERE usermode='publisher' AND(firstname LIKE '%'$this->searchstring'%' OR lastname LIKE '%'$this->searchstring'%')";
				$result=$this->dbconn->query($sql); 
				$publisherids="";
				while($srow=mysqli_fetch_array($result)) 
                {
					$publisherids=$publisherids+$srow['userid'];
				}
			$sql="SELECT * FROM announcements WHERE content LIKE '%'$this->searchstring'%' OR tag LIKE '%'$this->searchstring'%' OR timestamp LIKE '%'$this->searchstring'%' OR publisherid LIKE '%'$publisherids'%'";
			$result=$this->dbconn->query($sql); 
			return $result;

		}
		function deletePost()
		{
			$postid=$_GET['postid'];
			$sql="DELETE FROM announcements WHERE postid='$postid'";
			$result=$this->dbconn->query($sql);
		}
		function editPost()
		{
			$postid=$_GET['postid'];
			$sql="UPDATE announcements SET mode='$this->mode',content='$this->content',tag='$this->tag' WHERE postid='$this->postid'";
			$result=$this->dbconn->query($sql);
			header("Location:publisherHome.php");
		}
		function addInterest()
		{
			$postid=$_GET['postid'];
			$userid=$_GET['userid'];
			$sql="UPDATE announcements SET interested=interested+1 WHERE postid='$postid'";
			$this->dbconn->query($sql);
			$sql="INSERT INTO saved VALUES($userid,$postid)";
			$this->dbconn->query($sql);

		}
		function savedPosts()
		{
			$sql="SELECT * FROM announcements WHERE  postid IN(SELECT DISTINCT postid FROM saved WHERE userid='$this->userid')";
			$result=$this->dbconn->query($sql);
			return $result;
		}
		function removeSaved()
		{
			$postid=$_GET['postid'];
			$userid=$_GET['userid'];
			$sql="DELETE FROM saved WHERE userid=$userid AND postid=$postid";
			$this->dbconn->query($sql);
		}
		function findPublishers($param)
		{
			
			if($param=="accepted"){
			$sql="SELECT * FROM users WHERE userid IN(SELECT publisherid FROM audience WHERE userid='$this->userid' AND request_status='accepted')";}
			elseif($param=="pending"){
			$sql="SELECT userid,firstname,lastname,email,region,tags FROM users WHERE userid IN(SELECT publisherid FROM audience WHERE userid='$this->userid' AND request_status='pending')";}
			elseif($param=="new"){
				$sql="SELECT userid,firstname,lastname,email,region,tags FROM users WHERE usermode='publisher' AND userid NOT IN(SELECT DISTINCT publisherid FROM audience WHERE userid='$this->userid')";}
			elseif($param=="all"){
			$sql="SELECT * FROM users WHERE usermode='publisher'";}
			else{
			echo("Wrong parameter passed to findPublishers()");}
			$result=$this->dbconn->query($sql);
             return $result;
		}
		function findAudience($param)
		{
			
			if($param=="accepted"){
			$sql="SELECT userid,firstname,lastname,email,phone,region FROM users WHERE userid IN(SELECT userid FROM audience where publisherid='$this->publisherid' AND request_status='accepted')";}
			elseif($param=="pending"){
			$sql="SELECT userid,firstname,lastname,email,phone,region FROM users WHERE userid IN(SELECT userid FROM audience where publisherid='$this->publisherid' AND request_status='pending')";	 
		}
			else{
			echo("Wrong parameter passed to findPublishers()");}
			$result=$this->dbconn->query($sql);
			return $result;
		}
		
		function  sendAudienceRequest()
		{
			$userid=$_GET['userid'];
			$publisherid=$_GET['publisherid'];
			$sql="INSERT INTO audience(userid,publisherid,request_status) VALUES($userid,$publisherid,'pending')";
			$this->dbconn->query($sql);
		}
		function  cancelAudienceRequest()
		{
			$userid=$_GET['userid'];
			$publisherid=$_GET['publisherid'];
			$sql="DELETE FROM audience WHERE userid=$userid AND publisherid=$publisherid";
			$this->dbconn->query($sql);
		}
		function  acceptAudienceRequest()
		{
			$userid=$_GET['userid'];
			$publisherid=$_GET['publisherid'];
			$sql="UPDATE audience SET request_status='accepted' WHERE userid=$userid AND publisherid=$publisherid";
			$this->dbconn->query($sql);
		}
		
		function getAudienceList()
		{
			$sql="SELECT * FROM audience WHERE publisherid='$this->userid'";
			$result=$this->dbconn->query($sql);
			return $result;
		}
		function getAccountDetails()
		{
			$sql="SELECT * FROM users WHERE userid='$this->userid'";
    		$result=$this->dbconn->query($sql);
    		return $result;	
		}
		function updateDetails()
    	{
			$sql="UPDATE users SET firstname='$this->fname', lastname='$this->lname', phone='$this->phone', region='$this->region', tags='$this->tags' where userid='$this->userid'";
    		$result=$this->dbconn->query($sql);
    		return $result;
		}
	    function updatePassword()
    	{
			$sql="UPDATE users SET password='$this->pass' where userid='$this->userid'";
    		$result=$this->dbconn->query($sql);
    		return $result;
		}
    	
        function deleteUser()
        {
			$userid=$_GET['userid'];
			$sql="DELETE FROM users where userid='$userid'";
            $this->dbconn->query($sql);
		}
		
	}
	class adminClass
	{
		function adminClass()
    	{
    		$this->dbconn=new dbconn();
        }
		function viewPublisherRequests()
		{
			$sql = "SELECT * FROM publisher_requests;";
			$result= $this->dbconn->query($sql);
			return $result;
		}
		function viewComplaints()
		{
			$sql = "SELECT * FROM complaints;";
			$result= $this->dbconn->query($sql);
			return $result;
		}
		function acceptPublisherRequest()
		{
			
            $userid=$_GET['userid'];
			$sql="UPDATE users SET usermode='publisher' where userid='$userid'";
			$result=$this->dbconn->query($sql);
			$sql="DELETE FROM publisher_requests where userid='$userid'";
			$result=$this->dbconn->query($sql);
		}
		function rejectPublisherRequest()
		{
			
            $userid=$_GET['userid'];
			$sql="DELETE FROM publisher_requests where userid='$userid'";
			$result=$this->dbconn->query($sql);
		}
		function deleteComplaint()
		{
			$complaintid=$_GET['complaintid'];
			$sql="DELETE FROM complaints where complaintid=$complaintid";
			$result=$this->dbconn->query($sql);
		}
		function viewAllPosts()
		{
			$sql="SELECT FROM announcements";
			$result=$this->dbconn->query($sql);
			return $result;
		}
	}
if(isset($_GET['fn']))
{
	if($_GET['fn']=="acceptPublisherRequest")
    {
		$admin=new adminClass();
		$admin->acceptPublisherRequest();
		header("Location:Requests.php");
		exit;
	}
	if($_GET['fn']=="rejectPublisherRequest")
    {
		$admin=new adminClass();
		$admin->rejectPublisherRequest();
		header("Location:Requests.php");
		exit;

	}
	if($_GET['fn']=="sendAudienceRequest")
    {
		$user=new UserClass();
		$user->sendAudienceRequest();
		header("Location:myPublishers.php");
		exit;

	}
	if($_GET['fn']=="cancelAudienceRequest")
    {
		$user=new UserClass();
		$user->cancelAudienceRequest();
		header("Location:myPublishers.php");
		exit;

	}
	if($_GET['fn']=="acceptAudienceRequest")
    {
		$user=new UserClass();
		$user->acceptAudienceRequest();
		header("Location:managePrivateAudience.php");
		exit;

	}
	if($_GET['fn']=="rejectAudienceRequest")
    {
		$user=new UserClass();
		$user->cancelAudienceRequest();
		header("Location:managePrivateAudience.php");
		exit;

	}
	if($_GET['fn']=="unfollowPublisher")
    {
		$user=new UserClass();
		$user->cancelAudienceRequest();
		header("Location:mypublishers.php");
		exit;
	} 
	if($_GET['fn']=="deleteComplaint")
    {
		$admin=new adminClass();
		$admin->deleteComplaint();
		header("Location:viewComplaints.php");
		exit;

	}
	if($_GET['fn']=="deletePost")

	{
		$user=new UserClass();
		$user->deletePost();
		header("Location:publisherHome.php");
		exit;
	}
	if($_GET['fn']=="adminDeletePost")

	{
		$user=new UserClass();
		$user->deletePost();
		header("Location:adminHome.php");
		exit;
	}
	if($_GET['fn']=="addInterest")
	{
		$user=new UserClass();
		$user->addInterest();
		header("Location:userHome.php");
		exit;
	}
	if($_GET['fn']=="removeSaved")
	{
		$user=new UserClass();
		$user->removeSaved();
		header("Location:userHome.php");
		exit;
	}
	if($_GET['fn']=="deleteUserAccount")
	{
		$user=new UserClass();
		$user->deleteUser();
		header("Location:logout.php");
		exit;
	}

}	
?>