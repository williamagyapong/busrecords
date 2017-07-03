<?php
   require_once'core/init.php';
   $user = new User();

   if(!$user->isLoggedIn()) {
      Redirect::to(502);
   }
     $service= New Service();
     $order = New Order();

     if(Input::exist('filter'))
     {
        $orders = $order->filter(Input::get('term'));
     }
     else
     {
         $orders =  $order->get();
     }
    
     //print_array($orders);die();
   
   //get day for display
   


   
   $total = 0;

   
   //$name   = ucfirst($seller['username']);//ucfirst() makes the first letter capital if it is small
   
   
   
?>
<!DOCTYPE html>
<html>
<head>
	<title>Daily Sales</title>
  <link rel="stylesheet" type="text/css" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
  
</head>
<body>
    <?php require_once'includes/header.php';?>
   <br><br>
  <div class="w3-container w3-section" style="width: 100% ;position: fixed;">
        <a class="btn btn-info" href="dashboard.php" title="Back Home"><span class="glyphicon glyphicon-home"></span></a>
       <a class="btn btn-info" href="porder.php" title="Place an order">Order</a>
       <!-- <a class="btn btn-info" href="view-sales.php"><</a>-->
    
         <form action="" method="post" class="w3-right">
           <input type="text" name="term" placeholder="filter results by ..." style="text-align: center;" title="you can sort the result by product">
           <input type="submit" name="filter" value="Filter" class="btn btn-default">
         </form>
      
  </div><br><br><br>
      
      

   	   <div class="updatestock">
              
                 
              </h2>
             <div class="w3-card-4 table-responsive">
              <table  class="table table-striped table-bordered stock-table" style="text-align:center">
              <!-- the same if statement with : used in place of {}. Observe the structure carefully-->
              <?php if(empty($orders)):?>
                <h2 style="color:#ccc;text-align:center;">There is no order for display</h2>
              <?php else:?>
                     <tr class="w3-black w3-hover-gray w3-text-white w3-text-hover-black">
                        <th>Customer</th>
                        <th>Service Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Date Placed</th>
                        <th>Date Needed</th>
                        <th>Status</th>
                     </tr>
   	   	    		<?php
                       foreach($orders as $order){
                        //print_array($salesProd);die();
                ?>
                     
                <tr>
                  <td style="text-align:left"><a href="customerorders.php?cid=<?php echo $order->customer_id?>" title="view customer details"><?php echo $order->name;?></a></td>

                  <td><?php echo $service->get($order->service_id)->type;?></td>

                  <td><?php printf("%.2f",$order->amount);?></td>

                  <td style="text-align:left"><?php echo $order->description;?></td>

                  <td><?php echo date('D-M-Y H:i', strtotime($order->placed_at));?></td>

                  <td><?php echo date('D-M-Y', strtotime($order->needed_on));?></td>
                  
                  <td style="text-align:left"><?php echo $order->status;?></td>
   	   	    		</tr>
                 
   	   	    		<?php };?><!-- end of foreach loop -->
                
   	   	    	</table>
             </div>
              <hr>
              
            <?php endif;?><!-- end of if statment -->
            

   	   </div>
</body>
</html>