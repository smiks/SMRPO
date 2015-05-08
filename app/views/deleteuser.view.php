[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<center>
<br><div class="center_block_header"> Delete user </div><br>

<div class="center_block">

	
	<form action='' method='post'>
		<label class="cool_font">User</label>
		<select name="userid">
			<?
			foreach($users as $key => $value){
				$user    = $users[$key];
				$name    = strtoupper($user['name']);
				$surname = strtoupper($user['surname']);
				$uid     = $user['id_user'];
				echo"<option value='{$uid}'>{$name} {$surname}</option>";
			}
			?>
		</select><br>
		
		<input type='submit' value='Delete' name='submit'><br>
		
		</form>
	
</div>
<center>
[include]app/views/footer.view.php[/include]