<?php

require_once 'Model.php';

class col extends Model{	
	
	public function getColumn($columnId)
	{
		global $db;
		$q = $db -> query("SELECT * FROM Col WHERE column_id = '{$columnId}';");
		$data = $db -> fetch_row($q);
		return($data);
	}
	
	public function getAllColumns($boardId)
	{
		return $this -> sql("SELECT * FROM Col WHERE board_id='{$boardId}';", $return = "array", $key ="column_id");
	}
	
}