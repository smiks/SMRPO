[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>

<br><div class="center_block_header"> Copy table </div><br>

<div class="center_block" style="max-width:10%;">
	
	
	<form action='' method='post'>
		<input type="hidden" value="<?php echo $id; ?>" name="id">
		
			
		<big> Copy table <b><?php echo $pname; ?></b>.</big>
		<br><br>
		
		<label class="cool_font"> Board name </label><br> 
		<input type="text" name="boardname"><br>
			
		<input type='submit' value='Copy table!' name='submit'><br>
	</form>
	
</div>
</center>
[include]app/views/footer.view.php[/include]