<?php 
  require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }//prevents unautorized visitors
 
 $product = new Product();
 $show = FALSE;
 $totalCost = 0;
 $totalSales = 0;
 $products =$product->get();
 $current_prod = "";
 if(isset($_POST['query'])) {
     $show = TRUE;
     $productId = $_POST['product'];
     $from  = $_POST['from'];
     $to    = $_POST['to'];
    // print_array(displayProd($productId));die();

 } else {
  $productId = "all";
 	$from  = date('Y-m-d');
    $to    = date('Y-m-d');

 }

 $salesData = $product->getSalesByRange($from, $to, $productId);
 $outstandingSales = $product->getOutstanding($from, $to, $productId);
 $expenses   = 0;
 if($productId == 'all') {
   $current_prod = "All";
   $expenses   = $product->getExpense($from, $to);
 } else{

   $current_prod = $product->get($productId)->name;//Get product for display
 }


?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Income statement</title>

  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <script type="text/javascript" src="js/jquery.js"></script>
  <style type="text/css">
    .table{
      width: 80%;
      margin-top: 20px;
      margin-left: 9%;
      border-radius: 5px;

    }
    .td{
      text-align: center;
    }
  </style>
</head>
<body>
   
     <br>
   &nbsp; &nbsp;<a class="btn btn-info" href="admindashboard.php">Home</a>
    <?php if($show):?>
   <a class="btn btn-info" href="income.php" title="run income statement">Query</a>
    <?php endif;?>
   <a class="btn btn-info" href="accounts.php">Return</a><br><br>
    
     <!-- displaying income statement -->
       <?php if($show): ?>
        <div id="wrapper">
          
            <?php if(empty($salesData)):?>
               <h2 style="color: #0000ff;">&nbsp;&nbsp;No sales data available for income statement</h2>
             <?php else:?>
              <div>
                <center>
                 <h3 style="color:blue;">Product: <span style="color:red;"> <?php echo $current_prod;?></span></h3>
                 <h3 style="color:blue;">Income Statement from <?php echo "<i>".$from."</i>"; ?> to <?php echo "<i>".$to."</i>"; ?></h3>
                 </center>
              </div>
              <table class="table table-striped table-bordered" style="text-align:center">
                 <tr>
                  <th></th>
                  <th style="text-align:center">GH&cent;</th>
                  <th style="text-align:center">GH&cent;</th>
                 </tr>
                 <?php foreach($salesData as $stock) {
                         $totalCost += $stock->purch_cost;
                         $totalSales += $stock->sale_cost;
                         $netSales   = $totalSales - $outstandingSales;
                         $profit     = $netSales-$totalCost;
                         $netProfit  = $profit - $expenses;

                 }

                    ?>
                 <tr>
                    <td style="text-align:left">Total Sales</td>
                    <td><?php printf("%.2f",$totalSales); ?></td>
                    <td></td>
                 </tr>
                 <tr>
                   <td style="text-align:left">Less Outstanding Sales</td>
                   <td><u><?php printf("%.2f",$outstandingSales);?></u></td>
                   <td></td>
                 </tr>
                 <tr>
                   <td style="text-align:left">Net Sales</td>
                   <td></td>
                    <td><?php printf("%.2f",$netSales);?></td>
                 </tr>
                 <tr>
                   <td style="text-align:left">Less Total Purchases</td>
                   <td></td>
                   <td><u><?php printf("%.2f",$totalCost); ?></u></td>
                 </tr>
                 <tr>
                   <td style="text-align:left">Gross Profit</td>
                   <td></td>
                   <?php if($profit <0):?>
                   <td style="color:#ff0000;"><u>(<?php printf("%.2f",$profit);?>)</u></td>
                   <?php else:?>
                    <td><u><?php printf("%.2f",$profit);?></u></td>
                   <?php endif;?>
                 </tr>
                 <tr>
                   <td style="text-align:left">Less <span style="cursor:pointer">expenses</span></td>
                   <td></td>
                   <td><u><?php printf("%.2f",$expenses);?></u></td>
                 </tr>
                 <tr>
                   <td style="text-align:left">Net Profit</td>
                   <td></td>
                   <?php if($netProfit <0):?>
                   <td style="color:#ff0000;"><u>(<?php printf("%.2f",$netProfit);?>)</u></td>
                   <?php else:?>
                    <td><u><?php printf("%.2f",$netProfit);?></u></td>
                   <?php endif;?>
                 </tr>
                 
               
              </table>
             <?php endif;?>
        </div>
      <?php else: ?>
        <!-- provide income statement query form -->
         <div id="wrapper">
      <div class="addstock">
          <form action="income.php" method="post" role="form">
            <fieldset>
              <legend>Income Statement Query</legend><br><br>

             <div class="form-group">
                    <label>Product</label> <select name="product" required="required">
                    <option></option>
                    <option value="all">All products</option>
                    <?php 
                      foreach($products as $product):
                    ?>
                    <option value="<?php echo $product->id ?>"><?php echo $product->name ?></option>
                  <?php endforeach; ?>
                  </select><br><br>

              
                  <label>From</label> <input type="date" name="from" placeholder="yyy-mm-dd" required="required" size="5" class="form-control text_input">
              
              
                  <label>To</label> <input type="date" name="to" placeholder="yyy-mm-dd" required="required" class="form-control text_input"><br><br>

                <input type="submit" name="query" value="Run" class="btn btn-default btn-lg">
                   
             </div>
          
           </fieldset>
        </form>
      </div>

     </div>

      <?php endif; ?>
            

            
             
 <!-- included scripts -->
 
</body>
</html>