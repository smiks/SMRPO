[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>
<br><div class="center_block_header"> Add project do board </div><br>
<div class="center_block">

	
	<? if(isset($error)) { ?>
		{{error}}
	<? } else { ?>
		{{message}}
	<? } ?>
	
</div>
</center>
[include]app/views/footer.view.php[/include]