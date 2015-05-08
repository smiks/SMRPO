[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>

<br><div class="center_block_header"> Delete project </div><br>

<div class="center_block" style="max-width:20%;">
	
	
	<form action='' method='post'>
		
		<input type="hidden" value="<?php echo $projectid; ?>" name="projectid"><br>	
		<center><big>Are you sure you want to </big><br><big> delete project <b><?php echo $pname; ?></b>?</big><br></center>
		
		<br><input type='submit' value='Yes, delete it!' name='submit'><br>
		
		
	</form> 
	
</div>
</center>
[include]app/views/footer.view.php[/include]