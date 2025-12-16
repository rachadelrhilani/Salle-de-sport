<?php
        try{
          $db_serveur = "localhost";
        $db_user = "root";
        $db_pass = "";
        $db_name = "sport";
        
        $connect = mysqli_connect($db_serveur, $db_user, $db_pass, $db_name); 
        }
        catch(mysqli_sql_exception){
           echo "sql is not connected";
        }
?>