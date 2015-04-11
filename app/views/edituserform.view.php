[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<div id="toCenter">
	<div id="field_50">
		<h2>Edit User {{r['name']}} {{r['surname']}}</h2>
	</div>
	<br>
	<div id="field_50">
		<form action='?page=editusersub' method='post'>
			<input type="hidden" value="{{r['id_user']}}" name="userid">
			<center>
				<br>
				<label>Name</label><br>
				<input type="text" value="{{r['name']}}" name="name" id="textinput_200"><br>

				<label>Surname</label><br>
				<input type="text" value="{{r['surname']}}" name="surname" id="textinput_200"><br>

				<label>E-Mail</label><br>
				<input type="email" value="{{r['email']}}" name="email" id="textinput_200"><br>

				<label>Abilities</label><br>
				<input type="checkbox" value="1" name="productOwner" {{isOwner}} > Product owner&nbsp;<br>
				<input type="checkbox" value="1" name="kanbanmaster" {{isKM}} > Kanban master<br>
				<input type="checkbox" value="1" name="developer" {{isDev}} > Developer
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
				<br>

				<label>Administrator</label><br>
				Yes: <input type="radio" value="1" name="administrator" <? if($isAdmin == 1) echo("checked") ?> >
				&nbsp;&nbsp;&nbsp;
				No: <input type="radio" value="0" name="administrator" <? if($isAdmin == 0) echo("checked") ?> ><br>

				<br>
				<label>Change password</label><br>
				<label>Password</label><br>
				<input type="password" name="password" id="textinput_200"><br>

				<label>Re-type Password</label><br>
				<input type="password" name="repassword" id="textinput_200"><br>				
				<i>(Note: password will not change if left blank.)</i>
				<br>
				<input type='submit' value='Edit' name='submit'><br>
			</center>
		</form>
	</div>
</div>

[include]app/views/footer.view.php[/include]