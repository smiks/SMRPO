[include]app/views/header.view.php[/include]

<div style="background-color:#FFFFFF">
	<div style="background-color: #D0E0EB; height:30px">
		WELCOME
		{% if($isAdministrator) { %}
		<a href='?page=adminpanel'>Admin Panel</a>
		{% } %}
		&nbsp;
		<div style="float:right; padding-right:5px; padding-top:5px"><a href='?page=logout'>Logout</a></div>
		&nbsp;
	</div>
</div>

<div>
	<a href="?page=creategroup"><button> Create group </button></a>
</div>
[include]app/views/footer.view.php[/include]