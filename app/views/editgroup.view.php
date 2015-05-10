[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<center>

<br><div class="center_block_header"> 
	Edit group
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
</div><br>

<div class="center_block">
			
	<form action='?page=editgroup' method='post'>
		
			
		<label class="cool_font"> Group name </label><br>
		<input type="hidden" value="{{groupid}}" name="groupid">
		<input type = "text" name="groupname" value="{{groupName}}" /><br>
			
		<label class="cool_font"> Product owner </label><br>
			
		<select name="owners">
		<?
			foreach($allOwners as $key => $value){						
				$own   = $allOwners[$key];
				$name    = strtoupper($own['name']);
				$surname = strtoupper($own['surname']);
				$uid     = $own['id_user'];
				if ($uid  == $owner['user_id'])
					echo"<option value='{$uid}' selected>{$name} {$surname}</option>";
				else
					echo"<option value='{$uid}'>{$name} {$surname}</option>";
			}
		?>
		</select><br>
			
		<label class="cool_font"> Product developers </label><br>
		
		<select class="bigger_select" name="developers[]" multiple>
		<?
			$selected = array();
			foreach ($developers as $user_id => $r)
			{
				$selected[$r['user_id']] = 1;
			}
			foreach($allDevelopers as $key => $value){
				$developer   = $allDevelopers[$key];
				$name		 = strtoupper($developer['name']);
				$surname	 = strtoupper($developer['surname']);
				$uid		 = $developer['id_user'];
				$select = "";
				$sid = $developer['id_user'];
				if($selected[$sid] == 1){
					$select = " selected ";
				}
				echo"<option value='{$uid}' {$select}>{$name} {$surname}</option><br>";
			}
		?>
		</select><br>
			
		<input type="submit" value="Edit"/><br>
		
		
		<a href='?page=groups'><button class="submit_look_like_button" onClick="location.href='?page=groups'; return false;" >Cancel</button></a>
			
		
		
		
		{% if(isset($error)){ %}
			{{error}}
		{% } %}
		
		
	</form>
</div>
</center>

        <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Edit group' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						You can change group properties and click 'Edit' to save changes. Click 'Cancel' to
						go back to page 'Groups'. Read below for detailed description of how groups should be created!
						<br><br>
						Each development team has several members, each member may have multiple roles. 
						Each development team must have one KanbanMaster, one Product Owner and one or 
						more developers. The composition of the development team can alter during the 
						project. (adding new members or deleting existing ones). When deleting, the 
						excluded member is not physically deleted, but only marked as inactive. Time 
						intervals of active members are necessary to maintain. Inactive members are 
						no longer able to use the table.
						
					</p>
				</div>
				<div class="modal-footer">
					<a href="#close" class="btn">Okay, thanks!</a>  <!--CHANGED TO "#close"-->
				</div>
			</div>
		</div>
		</div>
		
	<!-- /Modal -->
	
[include]app/views/footer.view.php[/include]