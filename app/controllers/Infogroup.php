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
		$groupid = Functions::input("GET")["groupID"];
		$groupName = Functions::input("GET")["groupName"];
		
		$group = new group();
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
		
		$data = array("groupName" => $groupName, "active" => $active, "inactive" => $inactive);
		
		
		$this->show("infogroup.view.php", $data);
	}

}