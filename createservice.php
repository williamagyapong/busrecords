<?php
   
   
   require_once'core/init.php';
   $user = new User();

   if(!$user->isLoggedIn()) {
      Redirect::to(502);
   }
   
?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>stock</title>
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	 <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
   <? require'includes/header.php';?>
   <br><br>
  <div class="w3-container w3-section" style=" ;position: fixed;">
   &nbsp; &nbsp;<a class= "btn btn-info" href="dashboard.php" title="Home page"><span class="glyphicon glyphicon-home"></span></a>
   <a class= "btn btn-info" href="services.php" title="Return"><span class="glyphicon glyphicon-backward"></span></a>
   <!-- <a class= "btn btn-info" href="add-stock.php">Add Stock</a> -->
  </div><br><br><br>
   
   <?php
      if(input::exist('create'))
     {
      //Use addProduct function(core/functions/product.php)
        $service = new Service();
        $service->create();
     }

   ?>
   
   	   <div class="updatestock">
           <br><br>
   	   	   <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" role="form">
   	   	   	<fieldset>
   	   	   		<legend>Create New Service</legend>
              <div class="form-group">
                  <input type="text" name="type" required class="form-control text_input" placeholder="Service type" autocomplete="off" title="eg. GHC 1.00 per roll">
              </div>
   	   	   		<div class="form-group">
                  <input type="text" name="rate" required class="form-control text_input" placeholder="rate charged" autocomplete="off">
              </div>          
             
              <div class="form-group">
                  <input type="submit" name="create" value="Create" class="form-control text_input submit-btn2">
              </div>

   	   	   		

   	   	   	</fieldset>
   	   	   </form>
   	   </div>
   	
      

      <script type="text/javascript" src="js/jquery.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
      <!-- javascript code  -->
      <script type="text/javascript">
       function myAlert(msg){
         var span
         span = document.getElementById('alert');
         span.innerHTML = msg;
       }

       function myHide(){
         var span
         span = document.getElementById('alert');
         span.innerHTML = "";
       }

       $(document).ready(function(){
          //hides all vissible h2 elements after 4 seconds with a hiding speed of 2.5 seconds
          setTimeout(function(){
             $('.h2').fadeOut(2500)
           },4000)
      })
      </script>
</body>
</html>