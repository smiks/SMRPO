<?php

require_once 'Model.php';

class project extends Model{	



	public function addProject($projectNumber, $projectName, $client, $startDate, $endDate, $group)
	{
		global $db;

		$sql = "INSERT INTO Project (active, date_end, date_start, name, number, client) VALUES ('1', '{$endDate}', '{$startDate}', '{$projectName}', '{$projectNumber}', '{$client}');";
		$projectID = $this->insertID($sql);

		$db -> query("INSERT INTO Group_Project (group_id, project_id) VALUES ('{$group}', '{$projectID}');");

		return true;
	}
	
	// Function needed in Controller/CopyTable.php (no need for adding group here)
	public function addNewProject($id_project, $number, $active, $date_start, $date_end, $name, $client){
		global $db;
		$db -> query("INSERT INTO Project (id_project, number, active, date_start, date_end, name, client) 
			VALUES ('{$id_project}', '{$number}', '{$active}', '{$date_start}', '{$date_end}', '{$name}', '{$client}');");
		return true;
	}
	
	// Function needed in Controller/CopyTable.php 
	public function addNewGroup_Project($gp_id, $project_id, $group_id){
		global $db;
		$db -> query("INSERT INTO Group_Project (gp_id, project_id, group_id) 
			VALUES ('{$gp_id}', '{$project_id}', '{$group_id}');");
		return true;
	}
	
	public function activeUserOnProject($userId, $projectId)
	{
		global $db;
	
		$q = $db -> query("SELECT COUNT(*) FROM Group_Project LEFT JOIN Users_Groups ON (Group_Project.group_id=Users_Groups.group_id) WHERE Users_Groups.user_id='{$userId}' AND Users_Groups.active_end IS NULL AND Group_Project.project_id 	='{$projectId}';");
		$num = $db -> fetch_single($q);
		
		return $num;
	}

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
	
	public function deleteProject($id){
		global $db;
		$db -> query("DELETE FROM Project WHERE id_project='{$id}';");
		$db -> query("DELETE FROM Group_Project WHERE project_id='{$id}';");
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

	public function getProjectsByUserID ($userID)
	{
		$sql = "SELECT * FROM Users_Groups 
		LEFT JOIN Group_Project ON (Users_Groups.group_id=Group_Project.group_id) 
		INNER JOIN Project ON (Group_Project.project_id=Project.id_project) 
		WHERE Users_Groups.permission LIKE ('_1_') 
		AND Users_Groups.user_id='{$userID}'
		AND Project.id_project 
		NOT IN 
		(SELECT project_id FROM Board);";
		
		return $this -> sql($sql, $return="array", $key="project_id");
	}

	public function getAllProjects(){
		return $this->sql("SELECT * FROM Project;", $return = "array", $key ="id_project");
	}
	
	public function getLastProjectID(){
		$sql = "SELECT MAX(id_project) FROM Project;";
		return ($this->sql($sql, $return="single"));
	}

	public function getProject($id){
		global $db;
		$q = $db -> query("SELECT * FROM Project WHERE id_project = '{$id}';");
		$data = $db -> fetch_row($q);
		return($data);
	}

	public function getGroupName($id){
		global $db;
		$q1 = $db -> query("SELECT group_id FROM Group_Project WHERE project_id='{$id}';");
		$group = $db -> fetch_single($q1);
		$q = $db -> query("SELECT group_name FROM Groups WHERE group_id = '{$group}';");
		$data = $db -> fetch_single($q);
		return($data);
	}
	
	public function getGroupId($id){
		global $db;
		$q1 = $db -> query("SELECT group_id FROM Group_Project WHERE project_id='{$id}';");
		$data = $db -> fetch_single($q1);
		return($data);
	}
	

	public function getDevelopers($projectID){

		$sql = "SELECT DISTINCT u.name as UserName, u.surname as UserSurname, u.id_user
				FROM User u
				INNER JOIN Users_Groups ug on u.id_user = ug.user_id
				INNER JOIN Group_Project gp on ug.group_id = gp.group_id
				WHERE ug.permission LIKE'001' AND gp.project_id = '{$projectID}' AND ug.active_end IS NULL;";
		return $this->sql($sql, $return = "array", $key ="id_user");

	}
	public function getGroupProjectByProjectID($projectID){
		return $this->sql("SELECT * FROM Group_Project WHERE project_id='{$projectID}';", $return = "array", $key ="project_id");
	}

	/* checks if user with given user ID is kanban master in project with giver project ID */
	public function isKanbanMaster($projectID, $userid)
	{
		$sql = "SELECT COUNT(*) FROM Group_Project LEFT JOIN Users_Groups ON (Users_Groups.group_id = Group_Project.group_id)
				WHERE Users_Groups.user_id = '{$userid}' AND Group_Project.project_id = '{$projectID}' AND Users_Groups.permission LIKE ('_1_') LIMIT 1;";
				#echo($sql);
		return 0 < $this->sql($sql, $return = "single");
	}

	public function isProductOwner($projectID, $userid)
	{
		$sql = "SELECT COUNT(*) FROM Group_Project LEFT JOIN Users_Groups ON (Users_Groups.group_id = Group_Project.group_id)
				WHERE Users_Groups.user_id = '{$userid}' AND Group_Project.project_id = '{$projectID}' AND Users_Groups.permission LIKE ('1__') LIMIT 1;";
		return 0 < $this->sql($sql, $return = "single");
	}

	public function isMemberOfProject($projectID, $userid){
		$sql = "SELECT COUNT(*) FROM Group_Project LEFT JOIN Users_Groups ON (Users_Groups.group_id = Group_Project.group_id)
				WHERE Users_Groups.user_id = '{$userid}' AND Group_Project.project_id = '{$projectID}' LIMIT 1;";
		return 0 < $this->sql($sql, $return = "single");
	}

	public function removeProject($projectID){
		$sql = "DELETE FROM Project WHERE id_project='{$projectID}' LIMIT 1;";
		$db -> query($sql);
	}

	public function updateProject($id, $code, $name, $client, $start, $end, $group)
	{
		global $db;

		$db -> query("UPDATE Project SET number='{$code}', name='{$name}', date_start='{$start}', date_end='{$end}', client='{$client}' WHERE id_project='{$id}';");

		$db -> query("UPDATE Group_Project SET group_id='{$group}' WHERE project_id='{$id}';");

        return true;
	}


}