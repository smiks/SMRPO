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
				$selected = "";
				if($projectID2 == $projectID){
					$selected = " selected ";
				}
				echo"<option value='{$projectID2}' {$selected}>{$projectName }</option>";
			}
			?>
			</select><br>
		<table>
		<tr>
			<td><big><b>Filter</b></big><br>&nbsp;</td>
			<td><center><big><b>Select filter</b></big> <br><input type='checkbox' id='checkAll'></center></td>
		</tr>
		<tr>
		<td colspan="2">
		<label class="cool_font"> Select date range of card creation </label>
		</td>
		</tr>
		<tr>
		<td>
			<input style="width:165px; float:left; margin-left:5px" type = "date" id = "fromDateCreation" name="fromDateCreation" value="{{fromDateCreation}}" />
			<input style="width:165px; float:left; margin-left:5px" type = "date" id = "toDateCreation" name="toDateCreation" value="<? echo(Functions::dateDB()); ?>" />
		</td>
		<td><center>
			<input type='checkbox' name='filters[]' value='creation' class='chk'>
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<label class="cool_font"> Select date range of koncanje kartice :) </label>
		</td>
		</tr>
		<tr>
		<td>
			<input style="width:165px; float:left; margin-left:5px" type = "date" id = "fromDateDone" name="fromDateDone" value="{{fromDateDone}}" />
			<input style="width:165px; float:left; margin-left:5px" type = "date" id = "toDateDone" name="toDateDone" value="<?php $date = Functions::dateDB(); echo"{$date}"; ?>" />
		</td>
		<td><center>
		<input type='checkbox' name='filters[]' value='done' class='chk'>
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<label class="cool_font"> Select date range of card development </label>
		</td>
		</tr>
		<tr>
		<td>
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "fromDateDev" name="fromDateDev" value="{{fromDateDev}}" />
		<input style="width:165px; float:left; margin-left:5px" type = "date" id = "toDateDev" name="toDateDev" value="<?php $date = Functions::dateDB(); echo"{$date}"; ?>" />
		</td>
		<td><center>
		<input type='checkbox' name='filters[]' value='develop' class='chk'>
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<label class="cool_font"> Select size range of a card </label>
		</td>
		</tr>
		<tr>
		<td>
		<input style="width:165px; float:left; margin-left:5px" type="number" id="minSize" name="minSize" value="1" min="1" max="{{maxSize}}" />
		<input style="width:165px; float:left; margin-left:5px" type="number" id="maxSize" name="maxSize" value="{{maxSize}}" min="1" max="{{maxSize}}"/><br>
		</td>
		<td><center>
		<input type='checkbox' name='filters[]' value='range' class='chk'>
		</td>
		</tr>
		<tr>
		<td colspan="2">
		<label class="cool_font"> Select card type </label>
		</td>
		</tr>
		<tr>
		<td>
		<select name="tip">
			<option value="0"> New feature </option>
			<option value="1"> Silver bullet </option>
			<option value="2"> Rejected </option>
		</select><br>
		</td>
		<td><center>
		<input type='checkbox' name='filters[]' value='type' class='chk'>			
		</td>
		</tr>
		<?
		if($goto == "time"){
		?>
			<tr>
				<td>
			<label class="cool_font">Start Column</label><br>
			<select name='startCol'>
			<?
				foreach($colNames as $id => $name){
					echo"<option value='{$id}'>{$name}</option>";
				}

			?>
			</select>
			<br>
			<label class="cool_font">End Column</label><br>
			<select name='endCol'>
			<?
				$len = sizeOf($colNames);
				$counter = 1;
				foreach($colNames as $id => $name){
					$selected = "";
					if($counter == $len){
						$selected = " selected ";
					}
					echo"<option value='{$id}' {$selected}>{$name}</option>";
					$counter++;
				}

			?>
			</select>				
				</td>
			</tr>
		<?
		}
		?>
		</table>
		<input type="hidden" name="goto" value="{{goto}}" />
		<input type="hidden" name="boardID" value="{{boardID}}">
		<input type="hidden" name="width" value="{{width}}">
		<input type="submit" value="Submit"/><br>
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>


       <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Filter' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						Selecing project is mandatory. For Selected project you can select what filters you want to apply <br>
						(checkboxes on the right) and settings for each one of them (one the left). If you selected Average Lead Time<br>
						you also have to select column range (start and end column).
					</p>
				</div>
				<div class="modal-footer">
					<a href="#close" class="btn">Okay, thanks!</a>  <!--CHANGED TO "#close"-->
				</div>
			</div>
		</div>
		</div>
		
	<!-- /Modal -->


<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="static/js/checkAll.js"></script>
[include]app/views/footer.view.php[/include]