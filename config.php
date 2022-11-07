<?php

   define('DB_SERVER', 'us-cdbr-east-06.cleardb.net');
   define('DB_USERNAME', 'bb38448cc7530c');
   define('DB_PASSWORD', 'b83a2b78');
   define('DB_DATABASE', 'heroku_78c23a779fcb235');
   $db = new PDO('mysql:host='.DB_SERVER.';dbname='.DB_DATABASE, DB_USERNAME, DB_PASSWORD);
  
  ?>


 