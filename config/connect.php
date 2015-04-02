<?php
global $_CONFIG;
define("MONO_ON", 1);
require "mysqli.php";
$db=new database;
$db->configure($_CONFIG['hostname'],$_CONFIG['username'],$_CONFIG['password'],$_CONFIG['database'],$_CONFIG['persistent']);
$db->connect();
$c=$db->connection_id;