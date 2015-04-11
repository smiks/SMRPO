[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<div id="toCenter">
	<div id="field_50">
		<h2>Add user</h2>
	</div>
	<br>
	<div id="field_50">
		<form action='?page=adduser' method='post'>
			<center>
				<br>
				<label>Name</label><br>
				<input type="text" name="name" id="textinput_200"><br>

				<label>Surname</label><br>
				<input type="text" name="surname" id="textinput_200"><br>

				<label>E-Mail</label><br>
				<input type="email" name="email" id="textinput_200"><br>

				<label>Abilities</label><br>
				<input type="checkbox" value="1" name="productOwner"> Product owner&nbsp;<br>
				<input type="checkbox" value="1" name="kanbanmaster"> Kanban master<br>
				<input type="checkbox" value="1" name="developer"> Developer
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
				<br>

				<label>Administrator</label><br>
				Yes: <input type="radio" value="1" name="administrator">
				&nbsp;&nbsp;&nbsp;
				No: <input type="radio" value="0" name="administrator"><br>

				<br>
				<label>Change password</label><br>
				<label>Password</label><br>
				<input type="password" name="password" id="textinput_200"><br>

				<label>Re-type Password</label><br>
				<input type="password" name="repassword" id="textinput_200"><br>				
				<br>
				<input type='submit' value='Edit' name='submit'><br>
			</center>
		</form>
	</div>
</div>

[include]app/views/footer.view.php[/include]