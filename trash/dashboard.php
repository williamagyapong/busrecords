<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }
 
 $admin = $user->data();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
  
	<style type="text/css">
    body{
      background: white;
      min-height: 500px;
      /*background-image: url(images/background3.jpg);*/
      background-repeat: no-repeat;
      background-size: 100%;
    }
    #wrapper{
	    width: 200px;
  		min-height: 300px;
  		position: relative;
  		left: 50%;
  		margin-left: -100px;
  		border: 1px solid #ccc;
  		/*border-top-right-radius: 10px;*/
  		padding-left: 10%;
  		padding-top: 20%;
  		background: white;
    }
    #wrapper a{
      text-decoration: none;
    }
  span{
    color: blue;
  }
 
 /* #header{
   margin-top: -30px;
   padding-top: 10px;
 }*/
  </style>
</head>
<body>
   <?php
     require'includes/header.php';
   ?>

     <div class="logged">
      <h3>
         <span class="glyphicon glyphicon-user" style="color: #000" title="Current User"><?php echo $admin->username; ?></span><a href="logout.php?logout=admin" style="display: inline;"><span class="glyphicon glyphicon-log-out" style="margin-left: 10px;cursor: pointer;" title="Exit"></span></a>
      </h3>
  </div>
   <div class="side-menu">
   	   <div id="wrapper">
      <!-- the same if statement with ":" used in place of {}. Observe the structure carefully-->
       
    	
    	<a class="button" href="display.php">Services</a><br><br>

      <a class="button" href="orders.php">Orders</a><br><br>
      <a class="button" href="customers.php">Customers</a><br><br>
      <a class="button" href="events.php">Events Schedule</a><br><br>
      <a class="button" href="accounts.php">Accounts</a><br><br>

     
  
    </div> 
  </div>
  
  

    <script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" >
	
	$(document).ready(function(){
    //currently disabled
		$('#showd').click(function(){
			$('.side-menu').toggle(500);
		})
	})
</script>

</body>
</html>