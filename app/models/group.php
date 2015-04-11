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
		$db -> query("INSERT INTO Users_Groups (user_id, group_id, permission) VALUES ('{$owner}', '{$groupID}', '100');");


		return true;
	}
	

	//brisanje clanov skupine
}