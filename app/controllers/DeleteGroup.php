<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'app/models/log.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class DeleteGroup extends Controller{
	

	private function getGroupName($groupid)
	{
		$group= new group();
		return ($group-> getGroupName($groupid));
	}

	public function post() {
		$group= new group();
		$log = new log();
		
		$input = Functions::input("POST");
		$groupid = $input['groupid'];

		if ($group->deleteGroup($groupid))
		{
			$log->insertLog(1, "Deleted group with ID {$groupid}");
		    	$message = "Successfully deleted group with ID {$groupid}";
		    	$data = array("message" => $message);
		}
		else
		{
		    $data = array("error" => "Group was not deleted.");
		}
		
		$this->show("deletegroupsub.view.php", $data);
			
	}

	public function get() {

		$groupid = Functions::input("GET")["groupID"];
		
		$groupName = $this->getGroupName($groupid);
		$data = array("groupName" => $groupName, "groupid" => $groupid);

		$this->show("deletegroup.view.php", $data);

		
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