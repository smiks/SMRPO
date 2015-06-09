<?php

require_once 'Model.php';

class history extends Model{	
	
	public function insertHistory($cardID, $type, $event, $userID, $details, $date)
	{
		global $db;

		$db -> query("INSERT INTO History (card_id, type, event, user_id, details, date) VALUES ('{$cardID}', '{$type}', '{$event}', '{$userID}', '{$details}', '{$date}');");

		return true;
	}	

	public function getHistoryForCardID($cardID)
	{
		return $this -> sql("SELECT * FROM History WHERE card_id='{$cardID}';", $return="array", $key="history_id");
	}
	
	public function getCreateDate($cardID)
	{
		$sql = "SELECT date FROM History WHERE card_id='{$cardID}' AND type LIKE ('create');";
		return $this -> sql($sql, $return="single");
	}
	
	
}