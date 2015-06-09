[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<center>
<br><div class="center_block_header"> 
	Add project to Board
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">


	<form action='?page=addtoboard' method='post'>
	
		<label class="cool_font"> Group name </label><br>
		<input type="text" id="groupName" name="groupName" placeholder=<?php echo $groupName; ?> readonly /><br>
			
		<label class="cool_font"> Select board </label><br>
			<select name="boards">
			<?
			foreach($boards as $id => $value){
				$board = $boards[$id];
				$boardName = $board['name'];
				echo"<option value='{$board['board_id']}'>{$boardName}</option>";
			}
			?>
			</select><br>
		<input type="hidden" value=<?php echo $projectID; ?> name="projectID" id="projectID"/>
		<input type="hidden" value=<?php echo $groupID; ?> name="groupID" id="groupID"/>
			
		<input type="submit" value="Submit"/><br>
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>

[include]app/views/footer.view.php[/include]