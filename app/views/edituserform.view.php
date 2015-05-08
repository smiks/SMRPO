[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	
<center>

<br><div class="center_block_header"> Edit user: {{r['name']}} {{r['surname']}} </div><br>

<div class="center_block">

	
	
	<form action='?page=editusersub' method='post'>
		<input type="hidden" value="{{r['id_user']}}" name="userid">
				
		<label class="cool_font"> Name </label><br>
		<input type="text" value="{{r['name']}}" name="name"><br>



		<label class="cool_font"> Surname </label><br>
		<input type="text" value="{{r['surname']}}" name="surname"><br>

		<label class="cool_font"> Email </label><br>
		<input type="email" value="{{r['email']}}" name="email"><br>

		<label class="cool_font"> Abilities </label><br>
		<input type="checkbox" value="1" name="productOwner" {{isOwner}} > Product owner&nbsp;<br>
		<input type="checkbox" value="1" name="kanbanmaster" {{isKM}} > Kanban master<br>
		<input type="checkbox" value="1" name="developer" {{isDev}} > Developer
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
		<br>

		<label class="cool_font"> Administrator </label><br>
		Yes: <input type="radio" value="1" name="administrator" <? if($isAdmin == 1) echo("checked") ?> >
		&nbsp;&nbsp;&nbsp;
		No: <input type="radio" value="0" name="administrator" <? if($isAdmin == 0) echo("checked") ?> ><br>

		<br>
		
		<label class="cool_font"> New password (optional) </label><br>
		<input type="password" name="password"><br>

		<label class="cool_font"> Re-type password </label><br>
		<input type="password" name="repassword"><br>				
		<center><i class="cool_font" style="font-size:10px;">(Note: password will not change if left blank)</i></center>
		<br>
		<input type='submit' value='Edit' name='submit'><br>
			
	</form>
	
</div>
<center>
[include]app/views/footer.view.php[/include]