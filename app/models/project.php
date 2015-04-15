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
	
	public function deleteProject($id){
		global $db;
		$db -> query("DELETE FROM Project WHERE id_project='{$id}';");
		$db -> query("DELETE FROM User_Project WHERE project_id='{$id}';");
		$db -> query("DELETE FROM Groups WHERE project_id='{$id}';");
		return true;
	}


	//All Groups
	public function getAllGroupsFromDb(){
		return $this->sql("SELECT DISTINCT * FROM Groups;", $return = "array", $key ="group_id");
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

	public function getProject($id){
		global $db;
		$q = $db -> query("SELECT * FROM Project WHERE id_project = '{$id}';");
		$data = $db -> fetch_row($q);
		return($data);
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

	public function updateProject($id, $code, $name, $owner, $start, $end, $group)
	{
		global $db;

		$db -> query("UPDATE Project SET number='{$code}', name='{$name}', date_start='{$start}', date_end='{$end}' WHERE id_project='{$id}';");

		$db -> query("UPDATE User_Project SET user_id='{$owner}' WHERE project_id='{$id}';");

		$db -> query("DELETE FROM Groups WHERE project_id='{$id}';");

		$gn = $db->query("SELECT group_name FROM Groups WHERE group_id = '{$group}';");

		$groupName = $db -> fetch_single($gn);

		$db -> query("INSERT INTO Groups (group_name, project_id) VALUES ('{$groupName}', '{$id}');");

        return true;

	}

}