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

	/* return colOrder depending on column_id and board_id */
	public function getColOrder($colID, $boardID){
		$sql = "SELECT colOrder FROM Col WHERE column_id = '{$colID}' AND board_id = '{$boardID}' LIMIT 1;";
		return $this->sql($sql, $return="single");
	}

	/* returns IDs and names of columns between col1 and col2 (both included) */
	public function getColumnsBetween($col1, $col2, $boardID){
		$order1 = $this->getColOrder($col1, $boardID);
		$order2 = $this->getColOrder($col2, $boardID);
		$sql = "SELECT name, column_id FROM Col WHERE colOrder >= {$order1} AND colOrder <= {$order2} AND board_id = '{$boardID}' ";
		return $this->sql($sql, $return="array", $key="column_id");
	}

	/* returns name of a column with given ID */
	public function getColName($columnID){
		$sql = "SELECT name FROM Col WHERE column_id = '{$columnID}' LIMIT 1;";
		return $this->sql($sql, $return="single");
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

	/* returns IDs of all subcolumns of main Done column */
	public function getDoneIDs($boardID){
		$Done = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('Done') LIMIT 1;", $return = "single");
		return $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Done}';", $return = "array", $key="column_id");
	}

	/* returns first subcolumn of development or development if it does not have any subcolumn */
	public function getFirstDevColDate($boardID){
		$Develop = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('Development') LIMIT 1;", $return = "single");
		$sql = "SELECT COUNT(*) FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Develop}' LIMIT 1;";
		$subCols = $this -> sql($sql, $return="single");
		if($subCols > 0){
			$sql = "SELECT Movements.date_input FROM Movements LEFT JOIN Col ON (Movements.column_id=Col.column_id) WHERE Col.board_id='{$boardID}' AND Col.parent_id='{$Develop}' ORDER BY Col.colOrder ASC, Movements.date_input ASC LIMIT 1;";
			return $this->sql($sql, $return="single");
		}
		$sql = "SELECT Movements.date_input FROM Movements LEFT JOIN Col ON (Movements.column_id=Col.column_id) WHERE Col.board_id='{$boardID}' Col.name LIKE ('Development') ORDER BY Movements.date_input ASC LIMIT 1;";
		return $this->sql($sql, $return="single");
	}

	/* returns cardLimit of a parent of given column */
	public function getParentLimit($columnID){
		$sql = "SELECT parent_id FROM Col WHERE column_id = '{$columnID}' LIMIT 1;";
		$parentID = $this->sql($sql, $return="single");
		$sql = "SELECT cardLimit FROM Col WHERE column_id = '{$parentID}' LIMIT 1;";
		return $this->sql($sql, $return="single");
	}


	/* first column after testing (if any) otherwise first column in done (related to date_input) */
	public function getNextTesting($boardID){

		/* if no subcolumn return DONE column no matter what */
		$Done = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('Done') LIMIT 1;", $return = "single");
		$child = $this -> sql("SELECT COUNT(*) FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Done}' LIMIT 1;", $return = "single");
		if($child == 0){
			return $Done;
		}

		/* if Done parent has subcolumns, find testingCol */
		$sql = "SELECT column_id FROM Col WHERE board_id = '{$boardID}' AND testing_col = 1 LIMIT 1;";
		$tCol = $this->sql($sql, $return="single");
		/* if testingCol  return next */
		if($tCol != 0){
			$sql = "SELECT column_id
					FROM Col
					WHERE board_id =  '{$boardID}' AND parent_id = '{$Done}' AND
					colOrder > (SELECT colOrder FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Done}' AND testing_col=1) LIMIT 1;";
			return $this -> sql($sql, $return="single");

		}
		/* if no testingCol return First */
		else{
			$sql = "SELECT column_id
					FROM Col
					WHERE board_id =  '{$boardID}' AND parent_id = '{$Done}' ORDER BY colOrder ASC LIMIT 1;";
			return $this -> sql($sql, $return="single");
		}	
		
	}


	/* returns date of first card insert to development columns */
	public function getStartDevelpomentDate($boardID, $showSQL=false){
		$innerSQL = "SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE ('Development') LIMIT 1";
		$sql = "SELECT date_input FROM Movements LEFT JOIN Col ON (Movements.column_id=Col.column_id) WHERE Col.board_id='{$boardID}' AND Col.parent_id = ({$innerSQL}) ORDER BY date_input ASC LIMIT 1;";
		if($showSQL){
			echo"<li>{$sql}</li>";
		}
		return $this->sql($sql, $return="single");
	}

	/* returns date of first card insert to done columns (testing column - acceptance ready column is not counted) */
	public function getStartDoneDate($boardID, $showSQL=false){
		$innerSQL = "SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE ('Done') LIMIT 1";
		$sql = "SELECT date_input FROM Movements LEFT JOIN Col ON (Movements.column_id=Col.column_id) WHERE Col.board_id='{$boardID}' AND Col.parent_id = ({$innerSQL}) AND testing_col = 0 ORDER BY date_input ASC LIMIT 1;";
		if($showSQL){
			echo"<li>{$sql}</li>";
		}
		return $this->sql($sql, $return="single");
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