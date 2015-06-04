[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>
<br><div class="center_block_header"> Move Card - WIP VIOLATION DETECTED</div><br>

<div class="center_block">
	<form action='' method='post'>
		Are you sure you want to move card with ID {{cardID}}?
		WIP violation will be recorded.
		<input type='submit' name='submitYes' value='Yes, I want to'>
		<br>
		<input type='submit' name='submitNo' value='No, I do not want to'>
	</form>
</div>
</center>
[include]app/views/footer.view.php[/include]