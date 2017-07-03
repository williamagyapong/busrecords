<?php
require_once'core/init.php';
   $user = new User();

   if(!$user->isLoggedIn()) {
      Redirect::to(502);
   }

  $product = new Product();
  
/**
|This page dynamically switches between five interfaces{search 
|form(default), search results, sales form , sales report & final *sales 
|report} 
|based on either of five main actions activated by the user.
|
*/



 //initialize variables

 $showSearchForm = TRUE;
 $makeSale = FALSE;//use to control the make sales form
 $showReport= FALSE;//use to control the sales report table
 $showFinalReport=FALSE;
 $totalQty = 0;
 $totalPrice=0;
 $totalCost =0;

 //unset($_SESSION['sales']);
if(isset($_POST['search']))
{
     //searchProd(core/functions/products.php)
       $products = $product->search($_POST['name']);
  	if(!empty($products))
  	{
    		  
      		$showSearchResult=TRUE;//use to control the product result table
          $showSearchForm =FALSE;
          $showFinalReport=FALSE;
    	}
    	else{
        $showSearchResult = FALSE;
    		echo "<h2 class='hide-h2'> &nbsp; &nbsp;Product is not available</h2>";

    	}
}
elseif(isset($_POST['initiate-sale']))
{
    //create a session array to keep track of current sales details
    
  	$showSearchResult = FALSE;
    $showSearchForm =FALSE;
    //store session variables to be used later
  	$_SESSION['prod-id'] =  $_POST['prod-id'];
    if(!isset($_SESSION['qty-in-stock'])) {
      $_SESSION['qty-in-stock'] = $_POST['quantity'];
    }
  	
  
  	$makeSale = TRUE;
}
elseif(isset($_POST['make-sale']))
{
     //$showSearchForm =FALSE;
	//use makeSales function(core/functions/products.php)
      $salesInfo = $product->makeSales();

  	 if(!empty($salesInfo))
  	 {
        $product->trackSales($salesInfo);//store individual sales details
  	    $showReport = TRUE;
        //free some session variables after sales is done
        //unset($_SESSION['qty-in-stock']);
        unset($_SESSION['prod-id']);
  	 }else{
            $makeSale =TRUE;
            $showSearchForm = FALSE;
            //sales is rejected if the quantity bought exceeds what is available or the payment made is less than the cost of the item or both in which case the makeSales() function returns an empty array
            echo "<h2 style='color:red;' class='hide-h2'> &nbsp; &nbsp; Sales rejected!!</h2>";
            unset($_SESSION['sales']);//empty current sales basket;
       }
	
} elseif(isset($_POST['accept-sale'])) {

   if($product->salesApproved()) {
      $showFinalReport = TRUE;
      $showSearchForm  =FALSE;
   } else{
      $showReport = TRUE;//allow user to try approving sales again
      echo "<h2> Sorry, amount paid can't be lower than cost of sales. Please  try again.</h2>";
       //unset($_SESSION['sales']);//empty current sales basket;
   }
} elseif(isset($_POST['cancel'])) {
     if($product->cancelSales()) {
        unset($_SESSION['sales']);//empty current sales basket
     }
     
} 
 
elseif(isset($_GET['ended']))
    $showSearchForm = FALSE;


?>

<!DOCTYPE html>
<html>
<head>
	<title>make sales</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/sales.css">
</head>
<body>
    <?php require 'includes/header.php';?>
   <br>
    &nbsp; &nbsp; &nbsp; &nbsp;<a class="btn btn-info" href="admindashboard.php">Home</a>
    <a class="btn btn-info" href="view-sales.php">View Sales</a>
    <a class="btn btn-info" href="credit-sale.php">Credit Sales</a>
    <?php if($showSearchForm == TRUE && $showReport == FALSE):?>
       <br><br>
    <?php endif;?>
    <?php if($showReport==TRUE):?>
      <a class="btn btn-danger" href="sales.php?ended">End Sales</a><br><br>
    <?php endif;?>
    <?php if($showSearchForm==FALSE):?>
      <a class="btn btn-info" href="sales.php">Search</a><br><br>
    <?php endif;?>
    
   <div id="wrapper">
       <?php if($showSearchForm):?>
       <div class="addstock" style="height: 230px;" id="search">
          <br><br><br><br>
   	   	   <form action="sales.php" method="post">
   	   	   	<fieldset class="search-field">
   	   	   		<legend>Search Form</legend>
              
   	   	   		<div class="form-group">
                <input type="text" name="name" required class="form-control text_input" placeholder="Stock name" autocomplete="off">
              </div>

              <div class="form-group">
               <input type="submit" name="search" value="Search" class="form-control text_input submit-btn2">
              </div>

   	   	   	</fieldset>
   	   	   </form>
   	   </div>
       <?php endif;?>

   	   <?php if(isset($products)&&($showSearchResult==TRUE)){ ?>
   	   <div class="search-result">
   	      <h2 style="text-align: center; color: red">Search Result(s)</h2>
         <div class="table-responsive">
   	   	  <table class="table table-striped table-bordered"  id="table">
                     <tr>
                        <th>Item</th>
                        <th>Unit Price(&cent;)</th>
                        <th>Quantity</th>
                        <th>Action</th>
                     </tr>
   	   	    		<?php
                       foreach($products as $product){
   	   	    		?>
                     <form action="sales.php" method="post">
   	   	    		<tr>
   	   	    			<td><?php echo $product->name;?></td>

   	   	    			<td><?php printf("%.2f",$product->price);?></td>

   	   	    			<td style="text-align:center"><?php echo $product->quantity;?></td>


   	   	    			<input type="hidden" name="prod-id" value="<?php echo $product->id;?>">

   	   	    			<input type="hidden" name="quantity" value="<?php echo $product->quantity;?>">

   	   	    			<td><input type="submit" name="initiate-sale" value="Initiate Sale" style="font-weight:bold; height:38px; font-size:20px;" class="btn btn-default"></td>
   	   	    		</tr>
                  </form>
   	   	    		<?php };?><!-- end foreach loop-->
   	   	    	</table>
            </div>
   	   </div>
   	   <?php };?><!-- end if statement-->

   	   <?php if(isset($makeSale)&& ($makeSale==TRUE)){ ?>
   	   <div class="addstock">
   	   	   <form action="sales.php" method="post">
   	   	   	<fieldset>
   	   	   		<legend>Cash Sales Form</legend>
                <?php
            
   	   	   		$saleItem = $product->get($_SESSION['prod-id']);
   	   	   		?>

   	   	   		<div class="form-group">
                 <input type="text" name="name" required="required" class="form-control text_input" value="<?php echo $saleItem->name; ?>">
              </div>

              <div class="form-group">
                 <input type="text" name="quantity" required="required" class="form-control text_input numberonly" placeholder="Quantity bought" autocomplete="off">
              </div>

   	   	   		<input type="hidden" name="price" value="<?php echo $saleItem->price;?>" >

              <input type="hidden" name="cost" value="<?php echo $saleItem->cost;?>" >
              
   	   	   		<div class="form-group">
                 <input type="submit" name="make-sale" value="Submit" class="form-control text_input submit-btn2">
              </div>

   	   	   	</fieldset>
   	   	   </form>
   	   </div>
       <?php };?><!-- end  second if statement-->
       
       <?php if(isset($_GET['ended'])&& isset($_SESSION['sales'])){ ?>
       <div class="search-result">
   	      <h2 style="text-align: center; color: red">Sales Report</h2>
         <div class="table-responsive">
   	   	  <table class="table table-bordered table-striped" id="table" >
                     <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Cost of Sales</th>
                     </tr>
   	   	    		<?php
                     $count = 0;
                      //print_array($_SESSION['sales']);die();
                       foreach($_SESSION['sales'] as $salesProd){
                          $count++;       	
   	   	    		?>
                     
   	   	    		<tr>
                  <td><?php echo $count; ?></td>
   	   	    			<td><?php echo $salesProd['name'];?></td>

   	   	    			<td><?php printf("%.2f",$salesProd['price']);?></td>

   	   	    			<td style="text-align:center"><?php echo $salesProd['quantity'];?></td>

   	   	    			<td><?php printf("%.2f",$salesProd['cost']);?></td>
   	   	    		</tr>
                  
   	   	    		<?php 
                 $totalCost +=$salesProd['cost'];
                 $totalQty  +=$salesProd['quantity'];
                 $totalPrice +=$salesProd['price'];
                
              //} //end of inner loop
            }//end of outer loop
            ?><!-- end foreach loop-->

            <tr>
                  <td colspan="2"><b>Totals</b></td>
                  <td><b><?php printf("%.2f",$totalPrice);?></b></td>
                  <td style="text-align:center"><b><?php print($totalQty);?></b></td>
                  <td><b><?php printf("%.2f",$totalCost);?></b></td>
                </tr>
   	   	    	</table>
            </div>
              
              <!-- provide payment form -->
            <form action="sales.php" method="post" role="form">     
              
                 <fieldset>
                     <br><br>
                    <div class="form-group">
                      <input type="text" name="payment" required="required" class="form-control text_input numberonly" placeholder="Enter Amount" autocomplete="off">
                    </div>
                <input type="hidden" name="sales-cost" value="<?php echo $totalCost;?>">

                <div class="form-group">
                   <input type="submit" name="accept-sale" value="Accept Sales" class="submit-btn submit-btn2">

                   <input type="submit" name="cancel" value="Cancel Sales" class="submit-btn submit-btn2">
                </div>
                 </fieldset>
             </form>
   	   </div>
   	   <?php 
          //free session varialbe for next sale
          //unset($_SESSION['sales']);
       }
      ?><!-- end if statement-->

      <?php if(isset($_POST['accept-sale'])&& isset($_SESSION['sales'])&& $showFinalReport==true){ ?>
       <div class="search-result">
          <h2 style="text-align: center; color: red">Final Sales Report</h2>
         <div class="table-responsive">
          <table class="table table-striped table-bordered" id="table" >
                     <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Unit Price</th>
                        <th>Quantity</th>
                        <th>Cost of Sales</th>
                        <th>Payment</th>
                        <th>Balance</th>
                     </tr>
                <?php
                     $count = 0;
                      //print_array($_SESSION['sales']);die();
                       foreach($_SESSION['sales'] as $salesProd){
                          $count++;         
                ?>
                     
                <tr>
                  <td><?php echo $count; ?></td>
                  <td style="text-align:left;"><?php echo $salesProd['name'];?></td>

                  <td><?php printf("%.2f",$salesProd['price']);?></td>

                  <td style="text-align:center"><?php echo $salesProd['quantity'];?></td>

                  <td><?php printf("%.2f",$salesProd['cost']);?></td>
                  <td style="text-align:center">-</td>
                  <td style="text-align:center">-</td>
                </tr>
                  
                <?php 
                 $totalCost +=$salesProd['cost'];
                 $totalQty  +=$salesProd['quantity'];
                 $totalPrice +=$salesProd['price'];
                 $payment    = $_SESSION['payment'];
                 $balance    = $_SESSION['Balance'];
                 
                
              //} //end of inner loop
            }//end of outer loop
            ?><!-- end foreach loop-->

            <tr>
                  <td colspan="2"><b>Totals</b></td>
                  <td><b><?php printf("%.2f",$totalPrice);?></b></td>
                  <td style="text-align:center"><b><?php print($totalQty);?></b></td>
                  <td><b><?php printf("%.2f",$totalCost);?></b></td>
                  <td><b><?php printf("%.2f",$payment);?></b></td>
                  <td><b><?php printf("%.2f",$balance);?></b></td>
                </tr>
              </table>
             </div>
              
       </div>
       <?php 
          //free session varialbe for next sale
            unset($_SESSION['sales']);
            unset($_SESSION['payment']);
            unset($_SESSION['Balance']);
       }
      ?><!-- end if statement-->
   </div>

   <!-- javascript/jquery -->
   <script type="text/javascript" src="js/jquery.js"></script>
   <script type="text/javascript" src="js/custom.js"></script>
   <script type="text/javascript">
   	  $(document).ready(function(){
          //hides all vissible h2 elements after 4 seconds with a hiding speed of 2.5 seconds
          setTimeout(function(){
             $('.hide-h2').fadeOut(2500)
           },4000)
   	  })
   </script>
</body>
</html>