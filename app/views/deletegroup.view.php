[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	

<div id="toCenter">
	<br>
	<div id="field_50">
		<h2>Delete Group</h2>
	</div>
	<br>
	<div id="field_50">
		<form action='' method='post'>
			<input type="hidden" value="{{groupid}}" name="groupid">
			<br>
			<center>
			<big>Deleting group <b>{{groupName}}</b>.</big>
			<br>
			Are you sure?
			</center>
			<br>
			<input type='submit' value='Yes, delete it!' name='submit'><br>
		</form>
	</div>
</div>

[include]app/views/footer.view.php[/include]