<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Infogroup extends Controller{

	public function __construct() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->get();
		}
		
	}
	
	public function get()
	{
		$group = new group();		
		$groupid = Functions::input("GET")["groupID"];
		$groupName = $group->getGroupName($groupid);
		
		$members = $group -> getAllMembers($groupid);
		$active = array();
		$inactive = array();
		
		foreach ($members as $userid => $info)
		{
			if ($info['active_end'] == null)
				$active[$userid] = $info;
			else
				$inactive[$userid] = $info;
		}
		
		if(empty($groupName)){
			$error = "Group not found.";
			$errorCode = "404";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);
		}
		else
		{
			$data = array("groupName" => $groupName, "active" => $active, "inactive" => $inactive);			
			$this->show("infogroup.view.php", $data);
		}
		
	}

}