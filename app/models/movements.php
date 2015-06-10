<?php

require_once 'Model.php';

class movements extends Model{

	public function getMovements($boardId)
	{
		return $this -> sql("SELECT * FROM Movements WHERE board_id='{$boardId}';", $return="array", $key="id");
	}

	public function getCardMovements($cardID)
	{
		return $this -> sql("SELECT * FROM Movements WHERE card_id='{$cardID}';", $return="array", $key="id");
	}

	public function getCardStats($cardID, $columnID){
		$sql = "SELECT * FROM Movements WHERE card_id='{$cardID}' AND column_id='{$columnID}';";
		return $this -> sql($sql, $return="array", $key="id");
	}

	public function getDates($columnID, $boardID){
		$sql = "SELECT * FROM Movements WHERE column_id='{$columnID}' AND board_id='{$boardID}';";
		return $this -> sql($sql, $return="array", $key="id");
	}

	public function lastStatus($cardID){
		$sql = "SELECT MAX(id) FROM Movements WHERE card_id='{$cardID}' LIMIT 1;";
		return $this->sql($sql, $return="single");
	}

	public function moveCard($cardID, $columnID, $boardID, $lastMoveID){
		global $db;
		$date = Functions::dateDB();

		/* Because don't know why. */
		if(is_null($lastMoveID)){
			$sql = "INSERT INTO Movements (card_id, column_id, date_input, board_id) VALUES ('{$cardID}', '{$columnID}', '{$date}', '{$boardID}');";
			$db->query($sql);
		}
		else{
			$sql = "UPDATE Movements SET date_output='{$date}' WHERE id='{$lastMoveID}' LIMIT 1;";
			$db->query($sql);
			$sql = "INSERT INTO Movements (card_id, column_id, date_input, board_id) VALUES ('{$cardID}', '{$columnID}', '{$date}', '{$boardID}');";
			$db->query($sql);
		}
	}

	public function getInputDate($boardID, $colID, $cardID)
	{
		$sql = "SELECT date_input FROM Movements WHERE board_id='{$boardID}' AND card_id='{$cardID}' AND column_id='{$colID}' ORDER BY date_input ASC LIMIT 1;";
		return $this -> sql($sql, $return="single");
	}

	public function checkIfExists($boardID, $cardID, $fromDateDev, $toDateDev, $showSQL = false){
		$Develop = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND name LIKE('Development') LIMIT 1;", $return = "single");
		
		$sql = "SELECT COUNT(*) FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Develop}' LIMIT 1;";
		$subCols = $this -> sql($sql, $return="single");

		/* children exist */
		if($subCols > 0){
			$Develop = $this -> sql("SELECT column_id FROM Col WHERE board_id='{$boardID}' AND parent_id='{$Develop}' ORDER BY colOrder ASC LIMIT 1;", $return = "single");
		}

		/* huh, no kids you say ?? */
		$sql = "SELECT COUNT(*) 
				FROM Movements 
				WHERE 	card_id='{$cardID}' AND
						board_id='{$boardID}' AND 
						column_id='{$Develop}' AND 
						(date_input BETWEEN '{$fromDateDev}' AND '{$toDateDev}');";

		if($showSQL){
			echo"<br>{$sql}<br>";
		}

		$count = $this->sql($sql, $return="single");

		return ($count > 0);

	}

	public function getData($cardID){
		$sql = "SELECT * FROM Movements WHERE card_id='{$cardID}';";
		return $this->sql($sql, $return="array", $key="id");
	}
}