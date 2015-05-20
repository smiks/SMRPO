<?php

require_once 'Model.php';

class comment extends Model{	
	
	public function addComment($cardID, $comment, $userID)
	{
		global $db;

		$date = date("Y-m-d"); 

		$db -> query("INSERT INTO Comment (card_id, comment, user_id, date) VALUES ('{$cardID}', '{$comment}', '{$userID}', '{$date}');");

		$db -> query("INSERT INTO History (card_id, type, event, user_id, details, date) VALUES ('{$cardID}', 'comment', 'Comment added', '{$userID}', '{$comment}', '{$date}');");

		return true;
	}	

	public function getCommentsForCardID($cardID)
	{
		return $this -> sql("SELECT * FROM Comment WHERE card_id='{$cardID}';", $return="array", $key="card_id");
	}
	
}