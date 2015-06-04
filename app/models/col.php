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

	public function getAcceptanceTestingColumn($boardID) {
		global $db;
		$q = $db -> query("SELECT * FROM Col WHERE board_id = '{$boardID}' AND testing_col='1';");
		$data = $db -> fetch_row($q);
		return($data);
	}

	public function updateColumn($columnID, $name, $cardLimit, $priority_col, $testing_col, $boardID, $WIPViolation) {

		global $db;

		if($priority_col == 1) {
			$pr = $this -> getPriorityColumn($boardID);
			if($pr != null) {
				$prID = $pr["column_id"];
				$db -> query("UPDATE Col SET priority_col='0'WHERE column_id='{$prID}';");
			}
		}

		if($testing_col == 1) {
			$at = $this -> getAcceptanceTestingColumn($boardID);
			if($at != null) {
				$atID = $at["column_id"];
				$db -> query("UPDATE Col SET testing_col='0'WHERE column_id='{$atID}';");
			}
		}

		$db -> query("UPDATE Col SET name='{$name}', cardLimit='{$cardLimit}', priority_col='{$priority_col}', testing_col='{$testing_col}' WHERE column_id='{$columnID}';");

		//TUKAJ BO TREBA DODATI ŠE ZAPIS V TABELO ZA WIP KRŠITVE

		return true;

	}
}