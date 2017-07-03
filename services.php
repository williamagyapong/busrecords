<?php
  require_once'core/init.php';
   $user = new User();

   if(!$user->isLoggedIn()) {
      Redirect::to(502);
   }

   
   $service = new Service();
    // initialize necessary variables
   $services = $service->get();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>services</title>
	<link rel="stylesheet" href="css/w3.css">
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <script type="text/javascript" src="../js/custom.js"></script>
  
</head>
<body>
    <?php require_once'includes/header.php'; ?>
    <br><br>
  <div class="w3-container w3-section" style="margin-bottom: 25px ;position: fixed;">
    <a class="btn btn-info" href="dashboard.php" title="Home page"><span class="glyphicon glyphicon-home"></span></a>
    <a class= "btn btn-info" href="createservice.php" title="Add New Service">New</a>
    <!-- <a class="btn btn-info" href="#" title="Return"><span class="glyphicon glyphicon-backward"></a> -->
  </div><br><br>
  <div class="msg-board">
   <?php
    if(Session::exist('SAVED'))
   {
      echo "<h2 class='h2'>changes saved</h2>";
      Session::delete('SAVED');
      
   }elseif(Session::exist('deleted')) {
      echo "<h2 class='h2'> One record deleted !</h2>";
       Session::delete('deleted');
       
   } elseif(Session::exist('error')) {
      echo "<h2 class='h2'>Sorry, you can't delete this record</h2>";
      Session::delete('error');
   }
   ?>
   </div>
    
   	   <div class="updatestock">
              <h2 style="text-align: center; color: red">Services Provided</h2>
              <?php if(empty($services)):?>
                <h2 style="color:#ccc;text-align:center">There is no item to display</h2>
              <?php else:?>
            <div class="table-responsive">
               <table  class="table table-bordered stock-table" style="padding:0" title="Click on an item to make changes">
                     <tr style="background:#eeeeee">
                        <th>Service Type</th>
                        <th title="">Rate</th>
                        <th>Date Created</th>
                        <th colspan="2">Action</th>
                     </tr>
                <?php
                       foreach($services as $service){
                ?>
              <form action="control.php" method="post">
                <tr>
                  <td><input type="text" name ="type" style="text-align:left;padding-left:20px;" value="<?php echo ucwords($service->type);?>"></td>

                  <td><input type="text" class="" name="rate" style="text-align:left;padding-left:20px;" value="<?php print($service->rate);?>" ></td>

                  <td><input type="text" name="date" size="9" readonly="readonly" value="<?php echo $service->date_created;?>" ></td>

                         <input type="hidden" name="service-id" value="<?php echo $service->service_id;?>">

                  <td><input class="btn btn-primary" type="submit" name="save" value="Save" title="click to save changes"></td>
                </form>
                <form action="display.php" method= "post">
                  <input type="hidden" name="service-id" value="<?php echo $service->service_id;?>">
                  <td><input class="btn btn-danger" type="submit" name="delete" value="Delete" title="click to delete record"></td>
                </form>
                </tr>
                  
                <?php };?>
              </table>
            </div>
            <?php endif;?>
   	   </div>
       
       <!-- display delete alert dialog box -->
      <?php if (Input::exist('delete')): 
           $id = Input::get('service-id');
      ?>
         <div class="alert">
             <div>WARNING</div>
              <br><br>
            <span>Do you want to delete this record ?</span>
            <form action="control.php" method="post">
              <input type="hidden" name="service-id" value="<?php echo $id ?>">
              <input type="submit" name="dno" value="NO" autofocus="yes">
              <input type="submit" name="dyes" value="YES">
            </form>
         </div>
      
      <?php endif;?>
      
       <!-- javascript/jquery -->
   <script type="text/javascript" src="js/jquery.js"></script>
   <script type="text/javascript" src="js/custom.js"></script>
   <script type="text/javascript">
      $(document).ready(function(){
          //hides all vissible h2 elements after 4 seconds with a hiding speed of 2.5 seconds
          setTimeout(function(){
             $('.h2').fadeOut(2500)
           },4000)
      })


   </script>
</body>
</html>