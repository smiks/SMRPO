[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<div id="toCenter">
<?
if($boardID == 0){
?>
	<div id="field">
		<a href='?page=newboard'> Create new board for this project. </a>
	</div>
<?	
}
?>
</div>
[include]app/views/footer.view.php[/include]