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


	public function existsPriorityColumn($boardID) {
		global $db;

		$q = $db -> query ("SELECT COUNT(*) FROM Col WHERE board_id='{$boardID}' AND priority_col='1';");

		$exists = $db -> fetch_single($q);

		if ($exists > 0)
			return true;
		return false;	
	}

	public function getPriorityColumn($boardID) {
		global $db;
		$q = $db -> query("SELECT * FROM Col WHERE board_id = '{$boardID}' AND priority_col='1';");
		$data = $db -> fetch_row($q);
		return($data);
	}
}