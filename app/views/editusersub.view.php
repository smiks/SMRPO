[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<div id="toCenter">
	<div id="field_50">
		<h2>Edit User</h2>
	</div>
	<br>
	<div id="field_50">
		<? if(isset($error)) { ?>
		{{error}}
		<? } else { ?>
			{{message}}
		<? } ?>
	</div>
</div>

[include]app/views/footer.view.php[/include]