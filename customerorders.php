<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }//prevents unautorized visitors

 $order = New Order();
 $service = New Service(); 
if(Input::exist('cid','get' ))
{
  $orders = $order->get(Input::get('cid'));
  $customer = DB::getInstance()->get('customers', array('customer_id', '=', Input::get('cid')))->first();
}
else
{
  Redirect::to(404);
}
   
   
 if(isset($_POST['search'])) {
    $name = $_POST['name'];
    $customers = DB::getInstance()->get()->results();
 } else {
    $customers = DB::getInstance()->get('customers', array())->results();
 }
?>


<!-- front end matter -->
<!DOCTYPE html>
<html>
  <title>customer orders</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  
  <style>
  body,h1,h2,h3,h4,h5,h6 {font-family: "Raleway", sans-serif}
  a{
    display: inline;
  }
  </style>
<body class="w3-light-grey w3-content" style="max-width:1600px">

<?php require 'includes/header.php'; ?>
 
    <br><br>
     <!-- &nbsp; &nbsp;<a class="btn btn-info" href="dashboard.php"><span class="glyphicon glyphicon-home"></span></a>
     <a class="btn btn-info" href="orders.php"><span class="glyphicon glyphicon-backward"></span></a><br><br> -->
<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:280px;" id="mySidebar"><br>
  <div class="w3-container">
    <a href="#" onclick="w3_close()" class="w3-hide-large w3-right w3-xlarge w3-padding w3-hover-grey" title="close menu">
      <i class="fa fa-remove"></i>
    </a>
    <img src="images/avatarmale.png" style="width:45%;" class="w3-round"><br><br>
    <h4><b><?php echo $customer->name ?></b></h4>
    
  </div>
  <div class="w3-bar-block">
    <a href="#portfolio" onclick="w3_close()" class="w3-bar-item w3-button w3-padding "><i class="fa fa-th-large fa-fw w3-margin-right w3-text-teal"></i><?php echo $customer->business ?></a> 
    <a href="#contact" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-phone fa-fw w3-margin-right w3-text-teal"></i><?php echo $customer->phone ?></a>
     <a href="#about" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-envelope fa-fw w3-margin-right w3-text-teal"></i> <?php echo $customer->email;?><a href="#about" onclick="w3_close()" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bank fa-fw w3-margin-right w3-text-teal"></i><?php echo $customer->business;?></a> </a> 
  </div>
  
</nav>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px">
  <header id="portfolio">
      <!-- <a href="#"><img src="images/avatamale.png" style="width:65px;" class="w3-circle w3-right w3-margin w3-hide-large w3-hover-opacity"></a> -->
      <!-- <span class="w3-button w3-hide-large w3-xxlarge w3-hover-text-grey" onclick="w3_open()"><i class="fa fa-bars"></i></span> -->
      <div class="w3-container">
      <h1><b>Orders</b><span class="w3-badge w3-teal w3-margin-left"><?php echo count($orders);?></span></h1>
      <div class="w3-section w3-bottombar w3-padding-16">
         
        
        <a href="dashboard.php" class="w3-button w3-white"><i class="fa fa-home w3-margin-right"></i>Home</a>
        <?php if(Input::exist('token','get')):?>
          <a href="orders.php" class="w3-button w3-white"><i class="fa fa-refresh w3-margin-right"></i>Orders</a>
          <a href="customers.php" class="w3-button w3-white"><i class="fa fa-angle-double-left w3-margin-right"></i>Return</a>
        <?php else:?>
           <a href="customers.php" class="w3-button w3-white"><i class="fa fa-users w3-margin-right"></i>Customers</a>
          <a href="orders.php" class="w3-button w3-white"><i class="fa fa-angle-double-left w3-margin-right"></i>Return</a>
        <?php endif;?>
        
      </div>
      </div>
    </header>
  <div class="w3-card-4 w3-white table-responsive">
              <table  class="table table-striped table-bordered stock-table" style="text-align:center">
              <!-- the same if statement with : used in place of {}. Observe the structure carefully-->
              <?php if(empty($orders)):?>
                <h2 style="color:#ccc;text-align:center;">There is no order for display</h2>
              <?php else:?>
                     <tr class="w3-black w3-hover-gray w3-text-white w3-text-hover-black">
                        
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
                
                  <td><?php echo $service->get($order->service_id)->type;?></td>

                  <td><?php printf("%.2f",$order->amount);?></td>

                  <td style="text-align:left"><?php echo $order->description;?></td>

                  <td><?php echo date('D-M-Y H:i', strtotime($order->placed_at));?></td>

                  <td><?php echo date('D-M-Y', strtotime($order->needed_on));?></td>
                  
                  <td style="text-align:left"><?php echo $order->status;?></td>
                </tr>
                 
                <?php };?><!-- end of foreach loop -->
                <?php endif;?>
              </table>
             </div>
 
  <!-- <div class="w3-black w3-center w3-padding-24">Powered by <a href="#" target="_blank" class="w3-hover-opacity">Agyapong William</a></div> -->

<!-- End page content -->
</div>


<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
  
<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}
</script>

</body>
</html>
