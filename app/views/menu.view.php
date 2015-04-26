<div class="menu_bar">
	<div id="logo">
		<img alt="Logo" src="../../static/images/header_logo.png"/>
		&nbsp;
		<big>
			<?
			$isKM = $_SESSION['isKanbanMaster'];
			$user = new user();
			$info = $user->userInfoByID($_SESSION['userid']);
			$name = strtoupper($info['name']);
			$surname = strtoupper($info['surname']);
			$KM   = "";
			if($isKM){
				$KM = "<small>(Kanban master)</small>";
			}
			echo("{$name} {$surname} {$KM} &nbsp; (<a href='?page=logout' style='color: #cc0000;'>Logout</a>)");
			if($_SESSION['isAdministrator'] == 1) {
				echo"&nbsp;&nbsp;&nbsp;<a href='?page=adminpanel'>Admin Panel</a>";
			}
			?>
		</big>
	</div>

	<div id="menu">
		<?
		if($isKM){
		?>
		<div id="menu_option" onClick="location.href='?page=creategroup'">
			<a href="?page=creategroup">Create group</a>
		</div>
		
		<div id="menu_option" onClick="location.href='?page=groups'">
			<a href="?page=groups">Groups</a>
		</div>

		<div id="menu_option" onClick="location.href='?page=createproject'">
			<a href="?page=createproject">Create project</a>
		</div>
		<? } ?>

		<div id="menu_option" onClick="location.href='?page=projects'">
			<a href="?page=projects">Projects</a>
		</div>
	</div>

</div>