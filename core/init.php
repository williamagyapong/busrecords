<?php
/**
|----------------------------------------------------
|    REGISTER SESSION
|----------------------------------------------------
*/
    session_start(); 

/**
|----------------------------------------------------
|     SET THE DEFAULT TIMEZONE
|----------------------------------------------------
*/

     date_default_timezone_set("UTC");

/**
|----------------------------------------------------
|     GLOBAL VARIABLES
|----------------------------------------------------
*/

// set global variables
$GLOBALS['config'] = array(
        'mysql'=>array(
              'host'=>'127.0.0.1',
              'db'=>'bus_record',
              'password'=>'',
              'username'=>'root'
        	),

        'remember'=>array(
             'cookie_name'=>'hash',
             'cookie_expiry'=>604800
        	),

        'session'=>array(
             'session_name'=>'user',
             'token_name'=>'csrf_token'
        	),

        'app'=>array(
              'name'=>'busrecords',
              'version'=>'1.0',
              
          )
	);


/**
|---------------------------------------------
|      FILES REQUIREMENTS
|---------------------------------------------
*/

// autoload classes
spl_autoload_register(function($class_name){
    require_once 'classes/'.$class_name.'.php';
});

// access functions
require_once 'functions.php';



?>
