[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<center>
<br><div class="center_block_header"> 
	Add project to Board
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">

	<form action='?page=addprojecttoboard' method='post'>
			<input type="hidden" name="oldproject" value="{{projectID}}">
		<label class="cool_font"> Select project </label><br>
			<?
			if(sizeOf($projects) > 0){
				echo"<select name='project'>";
				foreach($projects as $id => $value){
					$project = $projects[$id];
					$projectName = $project['name'];
					echo"<option value='{$project['project_id']}'>{$projectName}</option>";
				}
				echo"</select>";
			}
			else{
				echo"<i>No projects available!</i>";
			}
			?>
			<br>
			
		<input type="submit" value="Submit"/><br>
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>

[include]app/views/footer.view.php[/include]