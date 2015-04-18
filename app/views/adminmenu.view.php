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
			?>
		</big>
	</div>

	<div id="menu">

		<div id="menu_option" onClick="location.href='?page=projects'">
			<a href='?page=projects'>Projects</a>
		</div>

		<div id="menu_option" onClick="location.href='?page=edituser'">
			<a href='?page=edituser'>Edit User</a>
		</div>

		<div id="menu_option" onClick="location.href='?page=adduser'">
			<a href='?page=adduser'>Add User</a>
		</div>

		<div id="menu_option" onClick="location.href='?page=deleteuser'">
			<a href='?page=deleteuser'>Delete User</a>
		</div>
	</div>

</div>