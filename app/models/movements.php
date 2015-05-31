<?php

require_once 'Model.php';

class movements extends Model{
	
	public function getMovements($boardId)
	{
		return $this -> sql("SELECT * FROM Movements WHERE board_id='{$boardId}';", $return="array", $key="card_id");
	}
}