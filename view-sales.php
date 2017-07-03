<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }
   
   $product = new Product();
   if(isset($_POST['view'])){
     $day = Input::get('date');
     
     $sales = $product->getSales($day, $day);
     $day = date('D M, Y', strtotime($day));
   }else{
     $today = date('Y-m-d');
     $sales = $product->getSales($today, $today);
     $day = date("D F, Y");
   }
   


   
   $total = 0;

   $seller = $user->data();
   //$name   = ucfirst($seller['username']);//ucfirst() makes the first letter capital if it is small
   
   
   
?>
<!DOCTYPE html>
<html>
<head>
	<title>Daily Sales</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
  
</head>
<body>
    <?php require'includes/header.php';?>
   <br>
 
        &nbsp; &nbsp;&nbsp; &nbsp; <a class="btn btn-info" href="admindashboard.php">Home</a>
       <a class="btn btn-info" href="expected-sales.php">Expected Sales</a>
       <a class="btn btn-info" href="all-sales.php" title="view all sales">View All</a>
       <a class="btn btn-info" href="sales.php">Return</a><br><br>
    
      
       <div class="view">
                  <form action="view-sales.php" method="post" role="form">
                  <input type="date" name="date" style = "text-align:center"  placeholder="Enter date as yy-mm-dd">
                 
                  <input type="submit" value="View Sales" name="view" class="btn btn-default">
                  </form>
       </div><br>

   	   <div class="updatestock">
              <h2 style="text-align: center; color: red">
                 Daily Sales: <?php echo $day;?>
                 
              </h2>
             <div class="table-responsive">
              <table  class="table table-striped table-bordered stock-table" style="text-align:center">
              <!-- the same if statement with : used in place of {}. Observe the structure carefully-->
              <?php if(empty($sales)):?>
                <h2 style="color:#ccc;text-align:center;">No sales available for the day specified</h2>
              <?php else:?>
                     <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity Sold</th>
                        <th>Amount</th>
                        <th>Time of Sale</th>
                     </tr>
   	   	    		<?php
                       foreach($sales as $salesProd){
                        //print_array($salesProd);die();
                ?>
                     
                <tr>
                  <td style="text-align:left"><?php echo $salesProd->name;?></td>

                  <td><?php printf("%.2f",$salesProd->price) ;?></td>

                  <td><?php echo $salesProd->qty_bought;?></td>

                  <td><?php printf("%.2f",$salesProd->sale_cost);?></td>

                  <td><?php echo $salesProd->time;?></td>
                  
   	   	    		</tr>
                  <?php $total += $salesProd->sale_cost;?>
   	   	    		<?php };?><!-- end of foreach loop -->
                <tr>
                  <td colspan="3"><b>Total Sales</b></td>
                  <td><b><?php printf("%.2f",$total);?></b></td>
                  <td></td>
                </tr>
   	   	    	</table>
             </div>
              <hr>
              
            <?php endif;?><!-- end of if statment -->
            

   	   </div>
</body>
</html>