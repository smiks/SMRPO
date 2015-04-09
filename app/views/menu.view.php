<div class="menu_bar">
	<div id="logo">
		<img alt="Logo" src="../../static/images/header_logo.png"/>
	</div>

	<div id="menu">

		<? if($_GET['page'] != "homepage") { ?>
		<div id="menu_option">
			<a href="?page=homepage">Home</a>
		</div>
		<? } ?>
		
		<div id="menu_option">
			<a href="?page=creategroup">Create group</a>
		</div>

		<? if($isAdministrator) { ?>
		<div id="menu_option">
			<a href='?page=adminpanel'>Admin Panel</a>
		</div>
		<? } ?>

		<div id="menu_option">
			<a href='?page=logout' style='color: #cc0000;'>Logout</a>
		</div>
	</div>

</div>