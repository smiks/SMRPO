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
			<big>Copy Table of a project <b><?php echo $pname; ?></b>.</big>
			<br>
			Are you sure you want to copy this table? <?php echo $id; ?>
			</center>
			<br>
			<input type='submit' value='Yes, copy table!' name='submit'><br>
		</form>
	</div>
</div>

[include]app/views/footer.view.php[/include]