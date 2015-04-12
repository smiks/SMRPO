<?php

require_once 'Model.php';

class project extends Model{	
	
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

	public function getAllUsersWithAbilities ($role)
	{
		global $db;
		
		preg_match('/1\d\d/', $role, $matches);

		if (sizeOf($matches) > 0){
			$ret = $this->sql("SELECT * FROM User WHERE abilities LIKE ('1__') AND active=1;", $return = "array", $key ="id_user");
		}
		else
		{
			preg_match('/\d\d1/', $role, $matches);
			if (sizeOf($matches) > 0)
			$ret = $this->sql("SELECT * FROM User WHERE abilities LIKE ('__1') AND active=1;", $return = "array", $key ="id_user");
		}

		return ($ret);
	}

	public function getAllProjects(){
		return $this->sql("SELECT * FROM Project;", $return = "array", $key ="id_project");
	}

	public function addProject($projectNumber, $projectName, $productOwner, $startDate, $endDate, $group)
	{
		global $db;

		$sql = "INSERT INTO Project (active, date_end, date_start, name, number) VALUES ('1', '{$endDate}', '{$startDate}', '{$projectName}', '{$projectNumber}');";
		$projectID = $this->insertID($sql);

		$db -> query("INSERT INTO User_Project (project_id, user_id) VALUES ('{$projectID}', '{$productOwner}');");

		$gn = $db->query("SELECT group_name FROM Groups WHERE group_id = '{$group}';");

		$groupName = $db -> fetch_single($gn);

		$db -> query("INSERT INTO Groups (group_name, project_id) VALUES ('{$groupName}', '{$projectID}');");

		return true;
	}

}