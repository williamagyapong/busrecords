<?php
 require_once'core/init.php';
 // handle deletion of service record
  $service = new Service();
  if(Input::exist('dyes')) {
      if($service->delete()) {

         Session::put('deleted', TRUE);
      	 Redirect::to("display.php");

      	} else{
           Session::put('error', TRUE);
      		 Redirect::to("display.php");
      	}
      
   } elseif (Input::exist('dno')) {
   	 Redirect::to("display.php");
   }


 // handle service update
    if(Input::exist('save'))
	   {
	      //use updateProduct function(core/functions/products.php)
	      if($service->update()) {
	      	  Session::put('SAVED', TRUE);
	      	  Redirect::to("display.php");
	      }

	      
	   }

     