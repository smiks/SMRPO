[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field">
		<h3>Create Board</h3>
	</div>
	<br>
	<div id="field">
		<form action='' method='post'>
			<input type='hidden' name='groupID' value='{{groupID}}'>
			<input type='hidden' name='projectID' value='{{projectID}}'>
			<center>
				<label>Board name</label>
				<input type="text" name="boardName" id="textinput_200"><br>
				<br>
				<label>Root Coloumns</label>
				<select name="numColoumns">
					
			</center>
		</form>
	</div>

</div>




[include]app/views/footer.view.php[/include]