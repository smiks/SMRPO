[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	

<div id="toCenter">
	<div id="field_50">
		<h2>Delete Group</h2>
	</div>
	<br>
	<div id="field_50">
		<form action='' method='post'>
			<label>Group: </label>
			<input type="hidden" value="{{groupid}}" name="groupid">
			<input type="text" readonly value='{{groupName}}'>
			<br>
			<input type='submit' value='Delete' name='submit'><br>
		</form>
	</div>
</div>

[include]app/views/footer.view.php[/include]