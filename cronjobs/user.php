<?php
require_once 'Model.php';

class user extends Model{

	public function getCards($groupId)
	{
		return $this->sql("SELECT * FROM Card LEFT JOIN Board ON (Card.board_id=Board.board_id) WHERE group_id='{$groupId}';", $return = "array", $key ="card_id");
	}
	
	public function getUsers()
	{
		return $this -> sql("SELECT group_id, user_id, name, surname, email FROM Users_Groups LEFT JOIN User ON (Users_Groups.user_id=User.id_user) WHERE permission LIKE ('_1_') AND abilities LIKE ('_1_') AND Users_Groups.active_end IS NULL AND locked=0 AND active=1;", $return = "array", $key = "group_id");
	}
	
	
}