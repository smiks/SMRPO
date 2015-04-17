<?php

require_once 'Model.php';
require_once 'core/Functions.php';

class board extends Model{	
	
	private function cleanInput($value)
	{
		$replace     = array("'",'"','<','>','\\');
		$replacement = array("&#39;",'&quot;','&lt;','&gt;','&#092;');
		$outputVal   = str_replace($replace, $replacement, $value);
		return $outputVal;
	}

	public function getBoardID($groupID){
		$sql = "SELECT board_id FROM Board WHERE group_id = '{$groupID}' LIMIT 1;";
		return ($this->sql($sql, $return="single"));
	}

}