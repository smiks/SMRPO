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

	/* returns ID of last subcolumn of main BackLog column */
	public function getBackLogID($boardID){
		$BackLog = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('BackLog') LIMIT 1;", $return = "single");
		return $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND parent_id='{$BackLog}' ORDER BY colOrder DESC LIMIT 1;", $return = "single");
	}

	/* returns ID of last subcolumn of main Development column */
	public function getDevelopID($boardID){
		$Develop = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('Development') LIMIT 1;", $return = "single");
		return $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Develop}' ORDER BY colOrder DESC LIMIT 1;", $return = "single");
	}

	/* returns IDs of all subcolumns of main Development column */
	public function getDevelopIDs($boardID){
		$Develop = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('Development') LIMIT 1;", $return = "single");
		return $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Develop}';", $return = "array", $key="column_id");
	}

	/* returns ID of first subcolumn of main Done column */
	public function getDoneID($boardID){
		$Done = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('Done') LIMIT 1;", $return = "single");
		return $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Done}' ORDER BY colOrder ASC LIMIT 1;", $return = "single");
	}

	/* reject column: last column of backlog */
	public function getRejectColumn($boardID){
		/* check if priority Column exists */
		$sql = "SELECT column_id FROM Col WHERE priority_col='1' AND board_id='{$boardID}' LIMIT 1;";
		$priorityID = $this->sql($sql, $return="single");
		if($priorityID != 0){
			return $priorityID;
		}
		/* if it doesnt exist move it to last backLog column */
		$sql = "SELECT column_id FROM Col WHERE name LIKE('BackLog') AND board_id='{$boardID}' LIMIT 1;";
		$backlogID = $this->sql($sql, $return="single");
		$sql = "SELECT column_id FROM Col WHERE parent_id='{$backlogID}' AND board_id='{$boardID}' ORDER BY colOrder DESC LIMIT 1;";
		return $this->sql($sql, $return="single");
	}

	public function isNeighbour($column1, $column2){
		/* checks if parent is not null */
		$sql = "SELECT parent_id FROM Col WHERE column_id='{$column1}' LIMIT 1;";
		$parent1 = $this->sql($sql, $return="single");
		$sql = "SELECT parent_id FROM Col WHERE column_id='{$column2}' LIMIT 1;";
		$parent2 = $this->sql($sql, $return="single");

		/* if moving to subcolumns */
		if(!is_null($parent1) && !is_null($parent2)){
			$sql = "SELECT colOrder FROM Col WHERE column_id='{$column1}' LIMIT 1;";
			$colOrd1 = $this->sql($sql, $return="single");
			$sql = "SELECT colOrder FROM Col WHERE column_id='{$column2}' LIMIT 1;";
			$colOrd2 = $this->sql($sql, $return="single");

			/* diff allowed: 1 */
			$diff =  abs($colOrd1-$colOrd2);
			if($diff == 1){
				return true;
			}
		}

		/* if moving to parent column and parent has a child -> not good */
		if(is_null($parent1)){
			$sql = "SELECT column_id FROM Col WHERE parent_id='{$column1}' LIMIT 1;";
			$colP1 = $this->sql($sql, $return="single");
			if($colP1 != 0){
				return false;
			}
		}
		if(is_null($parent2)){
			$sql = "SELECT column_id FROM Col WHERE parent_id='{$column2}' LIMIT 1;";
			$colP2 = $this->sql($sql, $return="single");
			if($colP2 != 0){
				return false;
			}
		}

		return false;
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