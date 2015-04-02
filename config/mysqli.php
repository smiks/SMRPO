<?php

if(!defined('MONO_ON')) { exit; }

if (!extension_loaded('mysqli')) {
   if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
       dl('php_mysqli.dll');
   } else {
       dl('mysqli.so');
   }
}

class database {
  var $host;
  var $user;
  var $pass;
  var $database;
  var $persistent=0;
  var $last_query;
  var $result;
  var $connection_id;
  var $num_queries=0;
  var $start_time;
  function configure($host, $user, $pass, $database, $persistent=0)
  {
    $this->host=$host;
    $this->user=$user;
    $this->pass=$pass;
    $this->database=$database;
    return 1; //Success.
  }
  function connect()
  {
    if(!$this->host) { $this->host="localhost"; }
    if(!$this->user) { $this->user="root"; }
    $this->connection_id=mysqli_connect($this->host, $this->user, $this->pass) or $this->connection_error();
    mysqli_select_db($this->connection_id, $this->database);
    return $this->connection_id;
  }
  function disconnect()
  {
    if($this->connection_id) { mysqli_close($this->connection_id); $this->connection_id=0; return 1; }
    else { return 0; }
  }
  function change_db($database)
  {
    mysqli_select_db($this->connection_id, $database);
    $this->database=$database;
  }
  function query($query)
  {
    $this->last_query=$query;
    $this->num_queries++;
    $this->result=mysqli_query($this->connection_id, $this->last_query) or $this->query_error();
    return $this->result;
  }
  function fetch_row($result=0)
  {
    if(!$result) { $result=$this->result; }
    return mysqli_fetch_assoc($result);
  }
  function num_rows($result=0)
  {
    if(!$result) { $result=$this->result; }
    return mysqli_num_rows($result);
  }
  function insert_id()
  {
    return mysqli_insert_id($this->connection_id);
  }
  function connection_error()
  {
    die("<b>FATAL ERROR:</b> Could not connect to database on {$this->host} (".mysqli_connect_error().")");
  }
  function query_error()
  {
    die("<b>QUERY ERROR:</b> ".mysqli_error()."<br />
    Query was {$this->last_query}");
  }
  function fetch_single($result=0)
  {
    if(!$result) { $result=$this->result; }
    //Ugly hack here
    mysqli_data_seek($result, 0);
    $temp=mysqli_fetch_array($result);
    return $temp[0];
  }

  function set_charset($charset)
  {
    return mysqli_set_charset($this->connection_id, $charset);
  }

}
?>