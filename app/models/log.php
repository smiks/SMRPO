<?php

require_once 'Model.php';
require_once 'core/Functions.php';

class log extends Model{	
	
	private function cleanInput($value)
	{
		$replace     = array("'",'"','<','>','\\');
		$replacement = array("&#39;",'&quot;','&lt;','&gt;','&#092;');
		$outputVal   = str_replace($replace, $replacement, $value);
		return $outputVal;
	}

	public function insertLog($userid, $action)
	{
		global $db;
		$date = Functions::dateTime();
		$action = $this->cleanInput($action);
		$db -> query("INSERT INTO log (userid, timestamp, action) VALUES ('{$userid}', '{$date}', '{$action}');");
	}

}