[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

		
	<br>
	<div class="center_block_header">
		Create Group
		<a href="http://dev.smrpo.avatar-rpg.net/?page=creategroup#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
	</div><br>
			
	<div class="center_block">
		<form action='?page=creategroup' method='post'>
			
			<label class="cool_font"> Group name </label><br>
			<input type="text" name="groupname" placeholder="Group name" required /><br>
			
			<label class="cool_font"> Product owner </label><br>
			<select name="owners">
			<?
			foreach($owners as $key => $value){
				$owner   = $owners[$key];
				$name    = strtoupper($owner['name']);
				$surname = strtoupper($owner['surname']);
				$uid     = $owner['id_user'];
				echo"<option value='{$uid}'>{$name} {$surname}</option>";
			}
			?>
			</select><br>
			
			<label class="cool_font"> Product developers </label><br>
			<select class="bigger_select" name="developers[]" multiple >
			<?
			foreach($developers as $key => $value){
				$developer = $developers[$key];
				$name = strtoupper($developer['name']);
				$surname = strtoupper($developer['surname']);
				$uid = $developer['id_user'];
				echo"<option value='{$uid}'>{$name} {$surname}</option>";
			}
			?>
			</select><br>
			

			<input type="submit" value="Create"/><br>
				
			
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
					<br><label class="cool_font" style="font-size:30px;">'Create group' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						
						Input group name, choose one Product owner and select one or more developers.
						You will be informed about changes afret clicking 'create' button. 
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