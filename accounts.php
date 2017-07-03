<?php
 require_once 'core/init.php';
 $user = new User();

 if(!$user->isLoggedIn()) {
    Redirect::to(502);
 }//prevents unautorized visitors
  $product = new Service();
  $expenses = $product->getExpenses();

  //handle deletion of expense
  $totalExpense = 0;

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Accounts</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

  <style type="text/css">
    body{
      background-image:url(images/background3.jpg); 
      background-repeat:no-repeat;
      background-size: 100%; 
    }
    h2{
      color: #0000ff;
    }

      li{
        font-weight: bold;
        font-size: 18px;
      }
    
  </style>
</head>
<body>
   <?php require_once'includes/header.php' ?>

     
   <nav class="navbar navbar-default" role="navigation" style=" border-right-bottom-radius:">
      <div class="container-fluid">
        
        <ul class="nav navbar-nav">
          <li><a href="dashboard.php"><span class="glyphicon glyphicon-home" title="Home page"></span></a></li>

          <li><a href="debtors.php">Debtors</a></li>
          <li class="dropdown">
            <a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Expenses<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="#" data-toggle="modal" aria-controls="collapse-post" data-target="#expenses">Enter Expenses</a></li>
                <li class="divider"></li>

                <li><a href="#" data-toggle="modal" aria-controls="collapse-post" data-target="#view-expenses">View Expenses</a></li>
              </ul>
          </li>
          
          <li><a href="income.php">Income</a></li>
        </ul>
      </div>

    </nav>

          
    <?php 
      $id = 0;
      
     if(isset($_POST['enter']))
     {
        if($product->insertExpense()) {
          echo "<h2>&nbsp;&nbsp;Expense successfully entered.</h2>";
          $id = 1;
        }
        else{
          echo "<h2>&nbsp;&nbsp;Invalid expense amount input.</h2>";
        }
     } elseif(isset($_POST['delete'])) {
          $id = $_POST['expense-id'];
         if(DB::getInstance()->delete('expenses', ['id', '=', $id])) {
           echo "<h2>&nbsp;&nbsp;One expense item deleted.</h2>";

         } else{
            echo "<h2>&nbsp;&nbsp;Error deleting expense.</h2>";
         }
     }
    ?>

    <!-- Modal for entering expenses form-->
    <div id="expenses" class="modal fade" role="dialog"  data-backdrop=false >
      <div class="modal-dialog" style="width:90%">

        <!-- Modal content-->
        <div class="modal-content">  
          <div class="modal-header ">
            <h3 class="modal-title title" style="text-align:center; color:blue">Expenses</h3>
          </div>
          <div class="prev-modal-body modal-body">
             <form action="accounts.php" method="post" role="form" >
                <div class="form-group">
                  <input type="text" name="description" placeholder="Description" required="required" class="form-control text_input" autocomplete="off">
                </div>
                <div class="form-group">
                  <input type="text" name="amount" placeholder="Expense amount" class="form-control text_input" required="required" autocomplete="off">
                </div>
                <div class="form-group">
                  <input type="submit" name="enter" value="Save" class="btn btn-primary btn-lg">
                </div>
                
             </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal" title="Close modal">Close</button>
        </div>
     </div>
    </div> 
  </div>
  <!-- Modal for viewing expenses -->
    <div id="view-expenses" class="modal fade" role="dialog"  data-backdrop=false >
      <div class="modal-dialog" style="width:90%">

        <!-- Modal content-->
        <div class="modal-content">  
          <div class="modal-header ">
            <h3 class="modal-title title" style="text-align:center; color:blue">Showing Expenses</h3>
          </div>
          <div class="prev-modal-body modal-body">
             <?php if(empty($expenses)):?>
              <h2>No Expenses</h2>
            <?php else: ?>
             <div class="table-responsive">
              <table class="table table-striped table-bordered" style="width:90%;text-align:center;">
                 <tr>
                   <th>Description</th>
                   <th>Amount</th>
                   <th>Date Entered</th>
                   <th>Action</th>
                 </tr>
                 <?php foreach($expenses as $expense):
                     $totalExpense += $expense->amount;
                 ?>
                  <tr>
                     <td style="text-align:left;"><?php echo $expense->description;?></td>
                     <td><?php echo $expense->amount;?></td>
                     <td><?php echo $expense->date;?></td>
                     <td>
                       <form action="accounts.php" method="post" onsubmit="return deleteAlert()">
                          <input type="hidden" name="expense-id" value="<?php echo $expense['id'];?>">
                          <input type="submit" name="delete" value="Delete" title="delete record" class="btn btn-default">
                       </form>
                     </td>
                  </tr>
                <?php endforeach;?>
                  <tr>
                     <td style="text-align:left; font-weight:bold">Total Expenses</td>
                     <td> <?php echo $totalExpense;?></td>
                  </tr>
              </table>
             </div>
            <?php endif;?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
     </div>
    </div> 
  </div>
  
 <script type="text/javascript" src="js/jquery.js"></script>
 <script type="text/javascript" src="js/custom.js"></script>
  <script src="js/bootstrap.min.js"></script>

  <script type="text/javascript">

     function deleteAlert(){
       var response = confirm("Item will be permanently deleted.");
       if(response) {
         return true;
       } else {
         return false;
       }
     }

    //refreshes the page every time expense is entered or deleted to update the expense table; 
    var id = "<?php echo $id; ?>";
     if(id !=0){
       window.location = "accounts.php";
       id = 0;
     }
  </script>
</body>
</html>