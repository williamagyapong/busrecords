<?php
 $host   = "localhost";
 $dbUser = "root";
 $dbPass = "";
 $dbname = "store";
 //make connection
 @mysql_connect($host, $dbUser, $dbPass)or die("Unable to connect to the server");

 //connect to the database
 @mysql_select_db($dbname) or die("Unable to connect to the database");
?>