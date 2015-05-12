[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<center>

<br><div class="center_block_header"> Add Card </div><br>

<div class="center_block" style="max-width:10%;">
	
	<p style="text-align:justify;">
	<? if(isset($error)) { ?>
		{{error}}
	<? } else { ?>
		{{message}}
	<? } ?>
	</p>
	
</div>
</center>
[include]app/views/footer.view.php[/include]