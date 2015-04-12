<?php

require_once 'Model.php';

class group extends Model{	
	
	//fnkcija vrne vse člane skupine
	public function suitableGroup($groupId)
	{
		global $db;
		
		$q1 = $db -> query("SELECT COUNT(*) FROM Users_Groups WHERE group_id=('{$groupId}') AND permissions LIKE (‘1__’);");
		$q2 = $db -> query("SELECT COUNT(*) FROM Users_Groups WHERE group_id=('{$groupId}') AND permissions LIKE (‘_1_’);");
		$q3 = $db -> query("SELECT COUNT(*) FROM Users_Groups WHERE group_id=('{$groupId}') AND permissions LIKE (‘__1’);");

		$numOfOwners = $db -> fetch_single($q1);
		$numOfMasters = $db -> fetch_single($q2);
		$numOfDevelopers = $db -> fetch_single($q3);
		
		$data = array("numberOfOwners" => $numberOfOwners, "numberOfMasters" => $numberOfMasters, "numberOfDevelopers" => $numberOfDevelopers);
		
	   return($data);

	}

	//funkcija vrne vse skupine, za katere je userid KM
	public function getAllGroups($userid){
		return $this->sql("SELECT * FROM Users_Groups LEFT JOIN Groups ON (Users_Groups.group_id=Groups.group_id) WHERE permission LIKE ('_1_') AND user_id='{$userid}' AND Users_Groups.active_end IS NULL ORDER BY group_name ASC;", $return = "array", $key ="group_id");
		
	}

	//funkcija vrne vse člane skupine
	public function getMembers($groupid)
	{
		return $this->sql("SELECT user_id, name, surname, permission FROM Users_Groups LEFT JOIN User ON (Users_Groups.user_id=User.id_user) WHERE group_id = '{$groupid}' AND Users_Groups.active_end IS NULL;", $return = "array", $key ="user_id");
	}


	//dodajanje clanov skupini
	public function addGroup($groupName, $developers, $owner)
	{
		global $db;

		$sql = "INSERT INTO Groups (group_name) VALUES ('{$groupName}');";
		$groupID = $this->insertID($sql);
		$insertToUsers_Groups = "INSERT INTO Users_Groups (user_id, group_id, permission) VALUES <MULTIINESRT>;";
		$multiInsert = "";
		foreach($developers as $key => $value){
			$multiInsert .= "('{$value}', '{$groupID}', '001'), ";
		}
		$multiInsert = substr($multiInsert, 0, strlen($multiInsert)-2);
		$insertToUsers_Groups = str_replace("<MULTIINESRT>", $multiInsert, $insertToUsers_Groups);
		$db -> query($insertToUsers_Groups);
		$db -> query("INSERT INTO Users_Groups (user_id, group_id, permission) VALUES ('{$owner}', '{$groupID}', '100'), ('{$_SESSION['userid']}', '{$groupID}', '010');");
		#$db -> query("INSERT INTO Users_Groups (user_id, group_id, permission) VALUES ('{$_SESSION['userid']}', '{$groupID}', '010');");


		return true;
	}
	

	//brisanje clanov skupine
}