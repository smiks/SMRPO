[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	

<div id="toCenter">
	<br>
	<div id="field_50">
		<h2>Copy Table</h2>
	</div>
	<br>
	<div id="field_50">
		<form action='' method='post'>
			<input type="hidden" value="<?php echo $id; ?>" name="id">
			<br>
			<center>
			<big>Copy Table <b><?php echo $pname; ?></b>.</big>
			<br>
			Board name: <input type="text" name="boardname" id="textinput_200"><br>
			
			Select group: <br>
			<select name="selectedGroupID">
				<?php
				foreach($allGroups as $key => $value){
					$tmp   = $allGroups[$key];
					$group_id = $tmp["group_id"];
					$group_name = $tmp["group_name"];
					echo "<option value={$group_id}> {$group_name} </option> ";
				}	
				?>
			</select>
			
			</center>
			<br>
			<input type='submit' value='Copy table!' name='submit'><br>
		</form>
	</div>
</div>

[include]app/views/footer.view.php[/include]