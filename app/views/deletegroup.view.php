[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>
<br><div class="center_block_header"> Delete group </div><br>

<div class="center_block">
	
	
	<form action='' method='post'>
		<input type="hidden" value="{{groupid}}" name="groupid"><br>
			
		<center><big>Are you sure you want to</big><br><big> delete group <b>{{groupName}}</b></big>?<br><center>
		
		<br>
		
		<input type='submit' value='Yes, delete it!' name='submit'><br>
	</form>
	
</div>
</center>
[include]app/views/footer.view.php[/include]