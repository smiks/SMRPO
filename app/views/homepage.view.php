[include]app/views/header.view.php[/include]
<div class="page">
[include]app/views/menu.view.php[/include]	
	<div class="center_block" id="page_login">
		<br><br><br>
		<div>
			<h1><center><img alt="Logo" src="../../static/images/logo7_1200.png" /></center></h1>
			<div id="login_block">
				<h3>Kanbanize</h3>
				<hr>
				{% if($isAdministrator) { %}
				<a href='?page=adminpanel'><button>Admin panel </button></a>
				{% } %}
				<br>
				<a href="?page=creategroup"><button> Create group </button></a>
			</div> 
		</div>
	</div>
</div>
[include]app/views/footer.view.php[/include]