<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/log.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Editgroup extends Controller{
	
	public function get() {

		$groupid = Functions::input("GET")["groupID"];
		$groupName = Functions::input("GET")["groupName"];
		
		$group = new group();
		$members = $group->getMembers($groupid);
		$owner;
		$developers = array();
		
		foreach ($members as $userID => $r) {
			if($r['permission'] == "100"){
				$owner = $r;
			}
			if($r['permission'] == "001"){
				$developers[$userID] = $r;
			}
		}
		$user = new user();
		$allOwners = $user -> getAllUsersWithAbilities("100");
		$user = new user();
		$allDevelopers = $user -> getAllUsersWithAbilities("001");
		
		$data = array("groupName" => $groupName, "groupid" => $groupid, "owner" => $owner, "allOwners" => $allOwners, "developers" => $developers, "allDevelopers" => $allDevelopers);

		$this->show("editgroup.view.php", $data);
	
	}
	
	public function post()
	{
		$input = Functions::input("POST");
		$log = new log();

		$owner = $input["owners"];
		$gName = $input["groupname"];
		$developers = $input["developers"];
		$groupid = $input["groupid"];
		
		$dataToUpdate = array("owner" => $owner, "gName" => $gName, "developers" => $developers);
		
		$group = new group();
		if($group -> updateGroup($groupid, $dataToUpdate))
		{
			$log->insertLog($_SESSION['userid'], "Modified group with ID {$groupid}");
			$message = "Successfully modified group with ID {$groupid}";
			$data = array("message" => $message);
		}
		else{
			$data = array("error" => "User was not modified!");
		}
		
		$this->show("editgroupsub.view.php", $data);
	}
	
	public function __construct() {
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		$this->post();
	}
	elseif($_SERVER['REQUEST_METHOD'] == 'GET') {
		$this->get();
	}			
	}
}