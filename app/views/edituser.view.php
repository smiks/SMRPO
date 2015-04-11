[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<div id="toCenter">
	<div id="field_50">
		<h2>Edit User</h2>
	</div>
	<br>
	<div id="field_50">
		<form action='' method='post'>
			<label>User</label>
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
				</select>
			<br>
			<input type='submit' value='Select' name='submit'><br>
		</form>
	</div>
</div>

[include]app/views/footer.view.php[/include]