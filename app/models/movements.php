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
}