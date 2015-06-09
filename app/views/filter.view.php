[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

	<center>
	<br><div class="center_block_header"> 
		Filter cards
		<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
	</div><br>
	
	<div class="center_block">
	<form action='?page=filter' method='post'>
	
		<label class="cool_font"> Select project </label><br>
			<select name="projects">
			<?
			foreach($projects as $projectID2 => $project){
				$projectName = $project['name'];
				echo"<option value='{$projectID2}'>{$projectName }</option>";
			}
			?>
			</select><br>
			
		<label class="cool_font"> Select date range of card creation </label><br>
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "fromDateCreation" name="fromDateCreation" value="{{fromDateCreation}}" />
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "toDateCreation" name="toDateCreation" value="<? echo(Functions::dateDB()); ?>" /><br>
		<label class="cool_font"> Select date range of koncanje kartice :) </label><br>
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "fromDateDone" name="fromDateDone" value="{{fromDateDone}}" />
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "toDateDone" name="toDateDone" value="<?php $date = Functions::dateDB(); echo"{$date}"; ?>" /><br>
		<label class="cool_font"> Select date range of card development </label><br>
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "fromDateDev" name="fromDateDev" value="{{fromDateDev}}" />
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "toDateDev" name="toDateDev" value="<?php $date = Functions::dateDB(); echo"{$date}"; ?>" /><br>
		<label class="cool_font"> Select size range of a card </label><br>
		<input style="width:165px; float:left; margin-left:5px" type="number" id="minSize" name="minSize" value="1" min="1" max="{{maxSize}}" />
		<input style="width:165px; float:left; margin-left:5px" type="number" id="maxSize" name="maxSize" value="{{maxSize}}" min="1" max="{{maxSize}}"/><br>
		<label class="cool_font"> Select card type </label><br>
		<select name="tip">
			<option value="0"> New feature </option>
			<option value="1"> Silver bullet </option>
			<option value="2"> Rejected </option>
		</select><br>
		
		<input type="hidden" name="goto" value="{{goto}}" />
		<input type="hidden" name="boardID" value="{{boardID}}">
		<input type="submit" value="Submit"/><br>
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>

[include]app/views/footer.view.php[/include]