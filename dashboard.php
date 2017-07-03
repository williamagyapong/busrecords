<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }
 
 $admin = $user->data();
 $services = DB::getInstance()->get('services', array())->results();
 $orders = DB::getInstance()->get('orders', array())->results();
 $customers = DB::getInstance()->get('customers', array())->results();
?>

<!-- front end matter -->
<!DOCTYPE html>
<html>
<title>Dashboard</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">-->
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
html,body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
a{text-decoration: none;}
</style>
<body class="w3-light-grey">

<!-- Top container -->
<?php require_once 'includes/header.php';?>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="images/willi.jpg" class="w3-circle w3-margin-right" style="width:46px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong><?php echo $admin->username; ?></strong></span><br>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="logout.php" class="w3-bar-item w3-button" title="Exit"><i class="fa fa-sign-out"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="#" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-bullseye fa-fw"></i>  Overview</a>
    <a href="services.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-eye fa-fw"></i>  Services</a>
    <a href="orders.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-refresh fa-fw"></i>  Orders</a>
    <a href="customers.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-users fa-fw"></i> Customers </a>
    <a href="accounts.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-line-chart fa-fw"></i>  Accounts</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-bell fa-fw"></i> Events </a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-history fa-fw"></i>  History</a>
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a><br><br>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
     <a href="services.php">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-eye w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 title="number of sevices"><?php echo count($services);?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Services</h4>
      </div>
     </a>
    </div>
    <div class="w3-quarter">
     <a href="#">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-bell w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 title="number of events">20</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Events</h4>
      </div>
     </a>
    </div>
    <div class="w3-quarter">
     <a href="customers.php">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 title="number of customers"><?php echo count($customers);?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Customers</h4>
      </div>
     </a>
    </div>
    <div class="w3-quarter">
     <a href="orders.php">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-refresh w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3 title="number of orders"><?php echo count($orders);?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Orders</h4>
      </div>
      </a>
    </div>
    <div class="w3-quarter">
     <a href="accounts.php">
      <div class="w3-container w3-brown w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-line-chart w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Accounts</h4>
      </div>
     </a>
    </div>
    <div class="w3-quarter">
     <a href="#">
      <div class="w3-container w3-yellow w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-cog w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Settings</h4>
      </div>
     </a>
    </div>
    <div class="w3-quarter">
     <a href="#">
      <div class="w3-container w3-pale-red w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-history w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>History</h4>
      </div>
     </a>
    </div>
  </div>


  <hr>
  <div class="w3-container">
    <h5>General Stats</h5>
    <p>New Visitors</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-green" style="width:25%">+25%</div>
    </div>

    <p>New Users</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-orange" style="width:50%">50%</div>
    </div>

    <p>Bounce Rate</p>
    <div class="w3-grey">
      <div class="w3-container w3-center w3-padding w3-red" style="width:75%">75%</div>
    </div>
  </div>
  <hr>

  
  <br>
  <div class="w3-container w3-dark-grey w3-padding-32">
    <div class="w3-row">
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-green">Design</h5>
        <p>Logo</p>
        <p>Cards</p>
        <p>Flyers</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-red">Photography</h5>
        <p>Pictures</p>
        <p>Photo shoot</p>
        <p>Picture editing</p>
      </div>
      <div class="w3-container w3-third">
        <h5 class="w3-bottombar w3-border-orange">General</h5>
        <p>Printing</p>
        <p>Typing</p>
        <p>.......</p>
        <p>More</p>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    
    <p>Powered by <a href="#" target="_blank">Agyapong William</a></p>
  </footer>

  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>

