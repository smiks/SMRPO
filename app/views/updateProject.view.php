[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> Update project </div><br>

<div class="center_block" style="max-width:10%;">
	
	
	<? if(isset($error)) { ?>
		{{error}}
	<? } else { ?>
		{{message}}
	<? } ?>
	
	
</div>
</center>
[include]app/views/footer.view.php[/include]