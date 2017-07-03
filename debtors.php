<?php

 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }//prevents unautorized visitors

   
   $totalDebt = 0;
   $totalPaid = 0;
   
   if(isset($_POST['search'])) {
      $name = $_POST['name'];
      $debtors = $user->getDebtors($name);
   } else {
      $debtors = $user->getDebtors();
   }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Debtors</title>
	
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
	<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
   <?php require 'includes/header.php'; ?>

     <br>
     &nbsp; &nbsp;<a class="btn btn-info" href="admindashboard.php">Home</a>
     <a class="btn btn-info" href="accounts.php">Return</a><br><br>

     <div class="view">
                  <form action="debtors.php" method="post" role="form">
                  <input type="text" name="name" style = "text-align:center"  placeholder="Enter name to search for" autocomplete="off">
                  <input type="submit" value="Search" name="search" class="btn btn-default">
                  </form>
       </div><br>
     
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
          <form  action="debtors.php" method="post" role="form">
             
              <input type="hidden" name="cust-id" value="<?php echo $_POST['cust-id'];?>">
                <input type="hidden" name="debt" value="<?php echo $_POST['debt'];?>">
            <div class="form-group">
               <input type="text" class="numberonly" name="amount" required="required" placeholder="Enter amount owing" autocomplete="off" style="text-align:center">

               <input type="submit" name="pay" value="Settle" class="btn btn-default">
            </div>
            
            
          </form>
        </center>
         	
         <?php endif;?>
         
        <div class="table-responsive">
        	<table class="table table-striped table-bordered" style="text-align:center;width:95%; margin-left:2.5%; margin-top:20px;">
     	 	 
     	 	 	<tr>
     	 	 	 <th></th>
	     	 	 <th>Name</th>
	     	 	 <th>Contact</th>
	     	 	 <th>Amount Paid<br>GH&cent;</th>
	     	 	 <th>Debt<br>GH&cent;</th>
	     	 	 <th>Date</th>
	     	 	 <th>Action</th>
     	 	   </tr>
     	 
     	 	 	<?php 
     	 	 	 $count = 0;
     	 	 	foreach($debtors as $debtor):
                  $date = strtotime($debtor->date);
                  $formatedDate = date("Y-m-d",$date);
                  $totalDebt    += $debtor->owing;
                  $totalPaid    += $debtor->paid;
                  $count++;
     	 	 	?>
     	 	      <tr>
     	 	    	<td><?php echo $count?></td>
	     	 	 	<td style="text-align:left"><?php echo $debtor->name ;?></td>
	     	 	 	<td><?php echo "0".$debtor->contact ;?></td>
	     	 	    <td><?php printf("%.2f",$debtor->paid);?></td>
	     	 	    <td><?php printf("%.2f",$debtor->owing);?></td>
	     	 	    <td><?php echo $formatedDate ;?></td>
	     	 	    <td>
	     	 	     <form action="debtors.php" method="post">
	     	 	      <input type="hidden" name="cust-id" value="<?php echo $debtor->id;?>">
	     	 	      <input type="hidden" name="debt" value="<?php echo $debtor->owing;?>">
	     	 	      <input type="submit" name="settle" value="Settle" class="btn btn-primary">
	     	 	    
	     	 	     </form>
	     	 	    </td>
	     	 	   </tr>
              
     	 	 <?php endforeach;?> 
            <tr>
               <td colspan="3" style="font-weight:bold">Total</td>
               <td><?php printf("%.2f",$totalPaid);?></td>
               <td><?php printf("%.2f",$totalDebt);?></td>

            </tr>
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