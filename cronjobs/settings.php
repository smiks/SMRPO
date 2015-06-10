<?php

require_once 'Model.php';

class settings extends Model{

	public function getCriticalDays()
	{
		$sql = "SELECT value FROM Settings WHERE name LIKE 'criticalDays' LIMIT 1;";
		return $this -> sql($sql, $return  = "single");
	}
	
	public function insertCriticalDays($value)
	{
		global $db;
		$sql = "UPDATE Settings SET value = '{$value}' WHERE id=1;";
		
		$db -> query($sql);
	}

}