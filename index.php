<?php
 
 require_once 'core/init.php';
 
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">

	<style type="text/css">
    body{
      background: white;
      min-height: 500px;
      /*background-image: url(images/background3.jpg);*/
      background-repeat: no-repeat;
      background-size: 100%;
    }
    
  .wrap{
    background-image: url(images/sailboat.jpg);
    min-height:500px;max-height:600px;
  }
 }
  </style>
</head>
<body>
<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <!-- <span class="w3-bar-item w3-center">BusinessRecords</span> -->
  <span class="w3-bar-item w3-right"><i class="fa fa-arrows"></i> BusinessRecords</span>
</div>
   <?php
     //require'includes/header.php';
   ?>

   <!-- Image Header -->


<?php
    // handle user login process
  if(Input::exist('login')) {
     
        $validate = new Validate();

        $validation = $validate->check($_POST, array(
                    'username' => array('required'=> true),
                    'password' => array('required'=> true)
          ));

        if($validation->passed()) {
          //log user in
          $user = new User();

          //$remember = (Input::get('remember')=='on')? true: false;
          $login = $user->login(Input::get('username'), Input::get('password'));
          if($login) {
             Redirect::to('dashboard.php');
            //header('Location: profile.php');
          } else {
                    echo "<p>Sorry, invalid username or password!</p>";
          }
        } else {
          foreach($validation->errors() as $error) {
            echo $error.'<br><hr>';
          }
        }
      }
  echo "</div>";

   ?>
    
<div class="container-fluid" >
  <div class="row">
    <div class="wrap">
      <br><br><br><br>
   <form action="index.php" method="post" role="form">
     <fieldset>
    
          <br><br><br>
      <div class="form-group">
         <input type="text" name="username" placeholder="username" class="form-control text_input" required="required" autocomplete="off">
      </div>
    
      <div class="form-group">
        <input type="password" name="password" placeholder="password" class="form-control text_input" required ="required">
      </div>
    

      <div class="form-group">
        <input type="submit" name="login" value="Login" class="form-control text_input submit-btn2">
      </div>


    </fieldset>
  </form>
    </div>
    
  </div>
 
</div>

<?php require'includes/footer.php' ?>
</body>
</html>

