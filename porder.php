<?php
  require_once'core/init.php';
   $user = new User();

   if(!$user->isLoggedIn()) {
      Redirect::to(502);
   }

   
   $order = new Service();
    // initialize necessary variables
   $orders = $order->get();
   
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	  <title>Orders</title>
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	  <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
   <?php require_once'includes/header.php' ?>
   <br>
  <div class="w3-container w3-section" style="margin-bottom: 25px ;position: fixed;">
   &nbsp; &nbsp;<a class= "btn btn-info" href="dashboard.php" title="Home page"><span class="glyphicon glyphicon-home"></span></a>
   <a class= "btn btn-info" href="orders.php" title="Return"><span class="glyphicon glyphicon-backward"></span></a>
  </div>
   <br><br>
   <?php
      if(isset($_POST['add-stock']))
       {
        //Use addProduct function(core/functions/product.php)
          $product->add();
       }
   ?>
   <div id="wrapper">
   	   <div class="addstock">
            <br>
   	   	   <form  action="add-stock.php" method="post" name="myForm" onsubmit="return isNumber('quantity')" role="form">
   	   	   	<fieldset>
                 <legend>Add Stock</legend><br>
                    <div class="form-group">
                     <label style="color: #000000">Stock Name</label>
                     <select name="id" required="required">
                          <option value="">--select item--</option>
                          <?php foreach($orders as $product): ?>
                            <option value="<?php echo $product->id?>"><?php echo $product->name ?> 
                            </option>
                          <?php endforeach;?>
                     </select>
                    </div>
              
              <div class="form-group">
              <input type="text" name="quantity" required class="form-control text_input numberonly" placeholder="Quantity" autocomplete="off">
              </div>
              <div class="form-group">     
              <input type="submit" name="add-stock" value="Add" class="form-control text_input submit-btn2"> 
              </div>
              

   	   	   	</fieldset>
   	   	   </form>
   	   </div>
   	</div>
     
      <!-- included scripts -->
      <script type="text/javascript" src="js/jquery.js"></script>
      <script type="text/javascript" src="js/custom.js"></script>
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
     


      
      </script>
</body>
</html>