<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }//prevents unautorized visitors

   
   
   if(isset($_POST['search'])) {
      $name = $_POST['name'];
      $customers = DB::getInstance()->get()->results();
   } else {
      $customers = DB::getInstance()->get('customers', array())->results();
   }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Customers</title>
	<link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body class="w3-light-grey w3-content" style="max-width:1600px">
   <?php require 'includes/header.php'; ?>

     <br><br>
  <div class="w3-section w3-bottombar w3-padding-16">
         
        
        <a href="dashboard.php" class="w3-button w3-white"><i class="fa fa-home w3-margin-right"></i>Home</a>
        <a href="orders.php" class="w3-button w3-white"><i class="fa fa-refresh w3-margin-right"></i>Orders</a>
        <!-- <a href="customers.php" class="w3-button w3-white w3-hide-small"><i class="fa fa-angle-double-left w3-margin-right"></i>Return</a> -->
        <form action="" method="post" class="w3-right w3-hide-small">
           <input type="text" name="term" placeholder="filter results by ..." style="text-align: center;" title="you can sort the result by product">
           <input type="submit" name="filter" value="Filter" class="btn btn-default">
         </form>
    </div>
  
     
    
     
 <div  id="wrapper">
         <?php 
            if(isset($_POST['pay'])) {
      
               if($user->settleDebt()) {
                 
               } else {
                 echo "<h3>Unable to settle debt. Please try again.</h3>";
            }
          }
        ?>
         <?php if(isset($_POST['settle'])):?>
         	
          <br><br>
        <center>
          <form  action="customers.php" method="post" role="form">
             
              <input type="hidden" name="cust-id" value="<?php echo $_POST['cust-id'];?>">
                <input type="hidden" name="debt" value="<?php echo $_POST['debt'];?>">
            <div class="form-group">
               <input type="text" class="numberonly" name="amount" required="required" placeholder="Enter amount owing" autocomplete="off" style="text-align:center">

               <input type="submit" name="pay" value="Settle" class="btn btn-default">
            </div>
            
            
          </form>
        </center>
         	
         <?php endif;?>
         
        <div class="w3-card-4 w3-white table-responsive">
        	<table class="table table-striped table-bordered" style="text-align:center;width:95%; margin-left:2.5%; margin-top:20px;">
     	 	 
     	 	 	<tr class="w3-black w3-hover-gray w3-text-white w3-text-hover-black">
     	 	 	 <th></th>
	     	 	 <th>Name</th>
	     	 	 <th>Phone</th>
	     	 	 <th>Email</th>
	     	 	 <th>Business</th>
	     	 	 <th>Location</th>
	     	 	 <th>Action</th>
     	 	   </tr>
     	 
     	 	 	<?php 
     	 	 	 $count = 0;
     	 	 	foreach($customers as $customer):
                  /*$date = strtotime($customer->date);
                  $formatedDate = date("Y-m-d",$date);
                  $totalDebt    += $customer->owing;
                  $totalPaid    += $customer->paid;*/
                  $count++;
     	 	 	?>
     	 	      <tr>
     	 	    	<td><?php echo $count?></td>
	     	 	 	<td style="text-align:left"><a href="customerorders.php?token=c12123446rufd&&cid=<?php echo $customer->customer_id?>" title="view customer details"><?php echo $customer->name;?></a></td>
	     	 	 	<td><?php echo $customer->phone ;?></td>
	     	 	    <td style="text-align:left"><?php echo $customer->email;?></td>
	     	 	    <td style="text-align:left"><?php echo $customer->business;?></td>
	     	 	    <td style="text-align:left"><?php echo $customer->location ;?></td>
	     	 	    <td>
	     	 	     <form action="customers.php" method="post">
	     	 	      <input type="hidden" name="cust-id" value="<?php echo $customer->customer_id;?>">
	     	 	      <!-- <input type="hidden" name="debt" value="<?php echo $customer->owing;?>"> -->
	     	 	      <input type="submit" name="settle" value="Settle" class="btn btn-primary">
	     	 	    
	     	 	     </form>
	     	 	    </td>
	     	 	   </tr>
              
     	 	 <?php endforeach;?> 
           
     	 </table>
        </div>
     </div>
     
     <script type="text/javascript" src="js/jquery.js"></script>
     <script type="text/javascript" src="js/custom.js"></script>
     <script type="text/javascript">
     	
     	$(document).ready(function(){
     		
     	})
     </script>
   </body>
</html>