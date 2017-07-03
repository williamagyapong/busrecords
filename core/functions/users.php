<?php
 //admin login function
function login()
{
	//initialize neccessary variables
	$username = escape(trim($_POST['username']));
	$password = escape(trim($_POST['password']));

	if(empty($username)||empty($password))
	{
		echo "<h2>All fields are required</h2>";
	}
	else{
		//hash the password
		$password = md5($password);
		//select existing credentials
		
			$prevData = select("SELECT * FROM admin WHERE username='$username' AND password = '$password'");

			if(!empty($prevData))
			{ 
				//create session variable to keep track of the admininstrator
				$_SESSION['ADMINID'] = $prevData[0]['id'];
				if(isset($_SESSION['ADMINID']))
				{
					header("Location: admindashboard.php");
				}
				else
				{
					echo "<h2 style='color:#0000ff'>Unsuccessful login</h2>";
				}
				
			}
			else{
				echo "<h2 style='color:#0000ff'>&nbsp;&nbsp;Invalid user credentials !</h2>";
			}
		
		}
		
}

		
function authenticate()
{
	$url = "http://localhost/store-app/public/index.php";
	
	
       if(!isset($_SESSION['ADMINID'])){

       	  header("Location:$url");
       }
}

function settleDebt()
{   
	$debtorId = $_POST['cust-id'];
	$amount = $_POST['amount'];
	$debt   = $_POST['debt'];
	if(is_numeric($amount))
	{  
		if($amount == $debt) {

			if(update('sales', ['customer_id'=>$debtorId], ['customer_id'=>0])) {
                  
    	      if(update('customers', ['id'=>$debtorId], ['paid'=>$amount],'+')&&update('customers', ['id'=>$debtorId], ['owing'=>$amount],'-')) {
               
               	   echo "<h2>Debt fully settled !</h2>";
               	   return true;
    	    } else {
    	    	 return false;
    	    }
          }
	 } elseif($amount<$debt){
	 	   $bal = $debt - $amount;
	 	   if(update('customers', ['id'=>$debtorId], ['paid'=>$amount],'+')&&update('customers', ['id'=>$debtorId], ['owing'=>$amount],'-')) {
               
               	   echo "<h2>GH&cent;". $bal." of debt still remaining !</h2>";
                    return true;
    	    } else {
    	    	 return false;
    	    }
	 	  
	 } else{

 	   return false;
    }          
    
  }
}

function getDebtors($name=null)
{  
if($name) {

   return select("SELECT * FROM `customers` WHERE `name` LIKE '$name%' AND `owing`!= 0   ORDER BY `date` DESC");

} else {

  return select("SELECT * FROM `customers` WHERE `owing`!= 0 ORDER BY `date` DESC");
}

}

?>