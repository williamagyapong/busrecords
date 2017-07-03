<?php
    require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }
     $product = new Product();
     $sales = $product->getExpectedSales();//from(core/functions/products.php)
     $total = 0;//initialize total sales to zero

   
?>
<!DOCTYPE html>
<html>
<head>
	<title>Expected Sales</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
  <style type="text/css">
    
    table{
      margin-left: 25%;
      color: black;
      background: white;
    }
    table th, td{
      padding: 10px;
    }
  </style>
</head>
<body>
    <?php require'includes/header.php';?>
   <br>
    &nbsp; &nbsp; &nbsp; &nbsp;<a class="btn btn-info" href="admindashboard.php">Home</a>
    <a class="btn btn-info" href="view-sales.php">Return</a><br><br>
   
   	   <div class="updatestock">
            <?php if(empty($sales)):?>
                <h2 style="color:#ccc;text-align:center;">No sales available</h2>
              <?php else:?>
              <h2 style="text-align: center; color: red">
                 Expected Sales for Remaining Stock </h2>
              
              <table  class="table table-striped table-bordered stock-table" style="text-align:center">
              <!-- the same if statement with ":" used in place of {}. Observe the structure carefully-->
              
                     <tr>
                        <th>Item</th>
                        <th>Price</th>
                        <th>Quantity-in-stock</th>
                        <th>Amount</th>
                     </tr>
   	   	    		<?php
                       foreach($sales as $salesProd){
                        //print_array($salesProd);die();
                ?>
                     
                <tr>
                  <td style="text-align:left"><?php echo $salesProd->name;?></td>

                  <td><?php printf("%.2f",$salesProd->price) ;?></td>

                  <td style="text-align:center"><?php echo $salesProd->quantity;?></td>

                  <td><?php printf("%.2f",($salesProd->price*$salesProd->quantity));?></td>
                  
   	   	    		</tr>
                  <?php $total += ($salesProd->price*$salesProd->quantity);?>
   	   	    		<?php };?><!-- end of foreach loop -->
                <tr>
                  <td colspan="3"><b>Total Sales</b></td>
                  <td><b><?php printf("%.2f",$total);?></b></td>
                </tr>
   	   	    	</table>
              <hr>
              
            <?php endif;?><!-- end of if statment -->
            

   	   </div>
</body>
</html>