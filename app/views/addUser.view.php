[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<center>

<br><div class="center_block_header"> Add user </div><br>

<div class="center_block">

	<form action='?page=adduser' method='post'>
			
				
		<label class="cool_font"> Name </label><br>
		<input type="text" name="name"><br>

		<label class="cool_font"> Surname </label><br>
		<input type="text" name="surname"><br>

		<label class="cool_font"> Email </label><br>
		<input type="email" name="email"><br>

		<label class="cool_font"> Abilities </label><br>
		<input type="checkbox" value="1" name="productOwner"> Product owner&nbsp;<br>
		<input type="checkbox" value="1" name="kanbanmaster"> Kanban master<br>
		<input type="checkbox" value="1" name="developer"> Developer
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
		<br>

		<label class="cool_font"> Administrator </label><br>
		Yes: <input type="radio" value="1" name="administrator">
		&nbsp;&nbsp;&nbsp;
		No: <input type="radio" value="0" name="administrator" checked><br>

		<br>
		<label class="cool_font"> Password </label><br>
		<input type="password" name="password"><br>

		<label class="cool_font"> Re-type password </label><br>
		<input type="password" name="repassword" ><br>				
		
		<input type='submit' value='Add' name='submit'><br>
			
	</form>
	
</div>
</center>
[include]app/views/footer.view.php[/include]