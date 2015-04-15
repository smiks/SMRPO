<?php
require_once 'Model.php';

class group extends Model {
	
	//funkcija vrne vse člane skupine
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

	/* Returns members of group (selected by group ID) */
	public function getMembers($groupid)
	{
		return $this->sql("SELECT ug_id, user_id, name, surname, permission FROM Users_Groups LEFT JOIN User ON (Users_Groups.user_id=User.id_user) WHERE group_id = '{$groupid}' AND Users_Groups.active_end IS NULL;", $return = "array", $key ="ug_id");
	}


	/* Adds group into DB. */
	public function addGroup($groupName, $developers, $owner)
	{
		global $db;
		
		$date = Functions::dateDB();

		/* Inserts group to a database and retrieves ID of inserted group. */
		$sql = "INSERT INTO Groups (group_name) VALUES ('{$groupName}');";
		$groupID = $this->insertID($sql);

		/* Prepares multi-insert SQL query. Query is used to add developers to a group. */
		$insertToUsers_Groups = "INSERT INTO Users_Groups (user_id, group_id, permission, active_start) VALUES <MULTIINESRT>;";
		$multiInsert = "";
		foreach($developers as $key => $value){
			$multiInsert .= "('{$value}', '{$groupID}', '001', '{$date}'), ";
		}
		$multiInsert = substr($multiInsert, 0, strlen($multiInsert)-2);
		$insertToUsers_Groups = str_replace("<MULTIINESRT>", $multiInsert, $insertToUsers_Groups);

		/* Executes multi-insert SQL query (adding developers). */
		$db -> query($insertToUsers_Groups);

		/* Adding group owner to a group. */
		$db -> query("INSERT INTO Users_Groups (user_id, group_id, permission, active_start) VALUES ('{$owner}', '{$groupID}', '100', '{$date}'), ('{$_SESSION['userid']}', '{$groupID}', '010', '{$date}');");
		return true;
	}
	
	/* Removing group from database. */
	 public function deleteGroup($groupid){
		  global $db;
		  $db -> query("DELETE FROM Users_Groups WHERE group_id='{$groupid}';");
		  $db -> query("DELETE FROM Groups WHERE group_id='{$groupid}';");
		  return true;
	 }
	 
	 /* Returns group name. */
	 public function getGroupName($groupid)
	 {
		global $db;
		$q = $db -> query ("SELECT group_name FROM Groups WHERE group_id='{$groupid}';");
		$groupname = $db -> fetch_single($q);
		return ($groupname);
 	}
	
	//urejanje skupine
	public function updateGroup($groupid, $dataToUpdate)
	{
		global $db;
		$date = Functions::dateDB();
		
		/* Data got after submit. Groupname, new owner and new developers crew. */
		$groupname = $dataToUpdate['gName'];
		$owner = $dataToUpdate['owner'];
		$developers = $dataToUpdate['developers'];
		
		$db -> query("UPDATE Groups SET group_name='{$groupname}' WHERE group_id='{$groupid}' LIMIT 1;");
		
		/* Getting old group crew. */
		$members = $this->getMembers($groupid);
		
		/* Making arrays with info about old owner and developers. */
		$oldOwner = 0;
		$oldDevs  = array();
		foreach ($members as $key => $value) {
			if($value['permission'] == "100"){
				$oldOwner = $value['user_id'];
			}
			if($value['permission'] == "001"){
				$oldDevs[$value['user_id']] = $value['user_id'];
			}
		}

		/* Updating new owner. Old one gets updated active_end date, new one is added to DB. */
		if($owner != $oldOwner){
			$sql = "UPDATE Users_Groups SET active_end='{$date}' WHERE user_id='{$oldOwner}' AND group_id='{$groupid}' AND permission='100' LIMIT 1;";
			$db -> query("{$sql}");
			$sql = "INSERT INTO Users_Groups (user_id, group_id, permission, active_start) VALUES ('{$owner}', '{$groupid}', '100','{$date}');";
			$db -> query($sql);
		}

		/* Adding new developers */
		foreach ($developers as $key => $value) {
			if(!in_array($value, $oldDevs)){
				$sql = "INSERT INTO Users_Groups (user_id, group_id, permission, active_start) VALUES ('{$value}', '{$groupid}', '001','{$date}')";
				$db -> query($sql);
			}
		}

		/* Removing old developers */
		foreach ($oldDevs as $key => $value) {
			if(!in_array($value, $developers)){
				$sql = "UPDATE Users_Groups SET active_end='{$date}' WHERE user_id='{$value}' AND group_id='{$groupid}' AND permission='001' LIMIT 1;";
				$db -> query($sql);			
			}
		}
		return true;
	}
}