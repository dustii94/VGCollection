<?php

try{
  // Configuration file outside of project (for security)
  $config = parse_ini_file('../config.ini');

  // Create connection (Params: servername, username, password, dbname)
  $db = new PDO("mysql:host=localhost;dbname=".$config['dbname'], $config['username'], $config['password']);

  // Show errors
  $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch(Exception $e){
  echo "Uh... $e";
}

?>
