[include]app/views/header.view.php[/include]
[include]app/views/adminmenu.view.php[/include]	

<center>
<br><div class="center_block_header"> Copy table </div><br>

<div class="center_block" style="max-width:20%;">

	
	<? if(isset($error)) { ?>
		{{error}}
	<? } else { ?>
		{{message}} 
	<? } ?>
	
</div>
</center>
[include]app/views/footer.view.php[/include]