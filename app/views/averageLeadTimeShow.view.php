[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]	
<center>
<br><div class="center_block_header"> Analytics - Average Lead Time</div><br>

<div class="center_block">
	<?
		foreach($cardsStats as $name => $time){
			echo"<li> Card <b>{$name}</b> was under development for <b>{$time}</b> days. </li>";
		}
	?>
</center>
[include]app/views/footer.view.php[/include]