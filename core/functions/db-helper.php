<?php

function escape($str)
{
  $str =  mysql_real_escape_string($str);
  //$str =  strip_tags($str);
  //$str =  htmlentities($str);

  return $str;
}


function print_array($array)
{
	echo "<pre>";
	 print_r($array);
	echo "</pre>";
}

  function insert($table, array $data)
 {
 	  // builds  query statement
 	  $fields = '';

      $values = '';

    foreach ($data as $key => $value) 
    {
       $fields .= '`'.$key.'`,';
       if(is_numeric($value))
        $values .= $value.',';
      else
        $values .= "'".$value."',";
    }    

    $fields = rtrim($fields, ',');
    $values = rtrim($values, ',');

    $sql = 'INSERT INTO '.'`'.$table.'` '.'('.$fields.') VALUES ('.$values.')';

    // runs the query against database
    $query_run = mysql_query($sql);

    if ($query_run) 
    {
      return true;
    }
    else
    {
       return false;
    }
       
     
 } //end of insert function

#use case
 /*insert('users',[
 	   'fname'=>'william',
 	   'lname'=>'agyapong',
 	   'username'=>'willisco'
 	]);*/

 function select($sql)
 {
    $results = [];

    if($queryrun = mysql_query($sql))
    {
      while($sqlresult = mysql_fetch_assoc($queryrun))
      {

        $results[] = $sqlresult;
      }

    }
    else{
      return "Please make sure to enter the right query statement";
    }
    return $results;
 }

 function update( $table, array $where, array $data, $operator=null)
 {
    $fieldsValues ="";
    foreach($data as $field =>$value)
    {
       if($operator && is_numeric($value)) {
         $fieldsValues .= '`'.$field.'` = '.'`'.$field.'` '.$operator." '$value',";
       } else {
        $fieldsValues .= '`'.$field.'` = '."'$value',";
       }
       
    }

    $fieldsValues = rtrim($fieldsValues,",");
    foreach($where as $key => $id) {

         $sql = "UPDATE ". '`'.$table.'` '. "SET ".$fieldsValues." WHERE ".'`'.$key.'` ='.$id;
           //echo $sql;die();
        if(mysql_query($sql))                                                                                     
        {
          return true;
        }else{
          return false;
        }
    }
    
 }

 
 function delete($table, $id, $field=null)
 {
    if($field) {
          $query = "DELETE FROM $table WHERE $field = '{$id}'";
          if(mysql_query($query)) {
            return true;
          } else {
            return false;
          }

    } else{
          $query = "DELETE FROM $table WHERE id = '{$id}'";
          if(mysql_query($query)) {
            return true;
          } else {
            return false;
          }
    }
 }
 //delete('products', 2);die();
?>