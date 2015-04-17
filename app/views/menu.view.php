<div class="menu_bar">
	<div id="logo">
		<img alt="Logo" src="../../static/images/header_logo.png"/>
		&nbsp;
		<big>
			<?
			$user = new user();
			$info = $user->userInfoByID($_SESSION['userid']);
			$name = strtoupper($info['name']);
			$surname = strtoupper($info['surname']);
			echo("Welcome, {$name} {$surname} &nbsp; (<a href='?page=logout' style='color: #cc0000;'>Logout</a>)");
			$isKM = $_SESSION['isKanbanMaster'];
			?>
                        
		</big>
	</div>

	<div id="menu">

		<div id="menu_option" onClick="location.href='?page=creategroup'">
			<a href="?page=creategroup">Create group</a>
		</div>
		
		<div id="menu_option" onClick="location.href='?page=groups'">
			<a href="?page=groups">Groups</a>
		</div>

		<? if($isKM) { ?>
		<div id="menu_option" onClick="location.href='?page=createproject'">
			<a href="?page=createproject">Create project</a>
		</div>
		<? } ?>

		<div id="menu_option" onClick="location.href='?page=projects'">
			<a href="?page=projects">Projects</a>
		</div>

		<? if($isAdministrator) { ?>
		<div id="menu_option" onClick="location.href='?page=adminpanel'">
			<a href='?page=adminpanel'>Admin Panel</a>
		</div>
		<? } ?>
	</div>

</div>