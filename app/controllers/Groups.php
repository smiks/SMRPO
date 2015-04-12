<?php

require_once 'Controller.php';
require_once 'app/models/user.php';
require_once 'app/models/group.php';
require_once 'core/Cache.php';
require_once 'core/Functions.php';

Functions::forceLogin();

class Groups extends Controller{

	public function __construct() {
		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->getGroupsToShow();
		}
		
	}
	//vrne vse skupine, katerih vpisani član je KM
	private function getGroups()
	{
		$group = new group();
		return ($group-> getAllGroups($_SESSION['userid']));
	}

	public function getGroupsToShow()
	{
		$group = new group();

		$groups = $this->getGroups();  // get dictionary of groups key: group_id

		/* ce imas sposobnosti biti KM, lahko pregledas svoje skupine */
		$isMaster = false;
		$user = new user();
		$isMaster = $user->isKanbanMaster($_SESSION['userid']);

		if($isMaster)
		{
			$data = array();
			$tmp = array();
			foreach($groups as $key => $value)
			{
				foreach ($value as $key2 => $value2) 
				{
					if($key2 == "group_name")
					{
						$groupName = $value2;
					}
				}

				$members = $group->getMembers($key);
				$data[$key] = array("groupName" => $groupName, "members" => $members);
			}
			$data = array("viewdata" => $data);
			$this->show("groups.view.php", $data);
		}
		else
		{
			$error = "Access Denied";
			$errorCode = "403";
			$data = array("error" => $error, "errorCode" => $errorCode);
			$this->show("error.view.php", $data);		
		}
	}

}