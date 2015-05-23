[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> 
	Comments
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">

	<form action='?page=comments&cardID={{cardID}}' method='post'>

		<label class="cool_font"> Comments </label><br>
		<?
			foreach($comments as $key => $value) {
				$comm = $comments[$key];
				$date = $comm['date'];
				$userName = strtoupper($comm['userName']);
				$userSurname = strtoupper($comm['userSurname']);
				$c = $comm['comment'];
				echo"<div>{$date} {$userName} {$userSurname}: <br>{$c}</div>";
			}
		?>
		
		<label class="cool_font"> Add comment </label><br>
		<input type='hidden' name='cardID' value='{{cardID}}'>
		<textarea id="comment" name="comment" placeholder="Comment" required="required" rows="5" cols="1" ></textarea><br>

		<input type="submit" value="Add comment"/><br>
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>
</center>
	
[include]app/views/footer.view.php[/include]