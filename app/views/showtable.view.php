[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<!-- Dont copy next 3 lines to header!! -->
<script type="text/javascript" src="../../static/js/jquery-2.1.4.js"></script>
<script type="text/javascript" src="../../static/js/dynamic_columns.js"></script>
<link type="text/css" rel="stylesheet" href="../../static/css/dynamic_columns.css" />

<br><br>
	
<center>
<?php

	/*
	VARS:
	$PID = projectID
	*/
	
	// Draw BoardName, always 100% width
	echo "
	<div style='width:100%;'>
		<h1 class='cool_font' style='color:white; font-size:40px;'> Board Name: {$boardName} </h1>
	</div><br>
	";
	
	//var_dump($allProjectNames);
	//exit();
	
	foreach($allProjectIDs as $PID){ // BEGIN ForLoop_1: gre cez vse projectID-je, ki se morajo izrisati na tabli (v resnici izrisuje swimline-e ... vsak projekt ima svoj swimline)
		
		echo "<div></div>
			<div id='swl_{$PID}_1' style='width:300%;'><br>
			<div class='center_block_header3' style='margin:2px 0 1px 0;line-height:40px;'>	
				Project: {$allProjectNames[$PID]} (ID#{$PID})	
				<a href='#info'><img src='../../static/images/info-icon.svg' style='width:20px;height:20px'/></a>
		";

			if($isKM){ 
				
				echo "
				<a href='?page=copyTable&projectID={$PID}'style='text-decoration:none;' title='Copy Table'>
					<img src='../../static/images/copy_icon.png' style='width:20px;height:20px;text-decoration:none;'  title='Copy Table'/>
				</a>
				";	 
			}
			if($isKM || $isPO){ 
				echo "
				<br>
				<a href='?page=createcard&projectID={$PID}' style='text-decoration:none;'>
					<font size='5'>Create new card</font>
				</a>
				";
			}
		
			if($isEmpty && $isKM){ 
				echo "
				&nbsp; &nbsp; 
				<a href='?page=edittable&projectID={$PID}&screenwidth={$screenWidth}' style='text-decoration:none; font-size:20px;'>
					Edit board
				</a>
				";
			}
			
			if($isKM){
				echo "
				&nbsp; &nbsp; 				
				<a href='?page=filter&boardId={$boardId}&projectID={$PID}&width={$screenWidth}&goto=flow' style='text-decoration:none; font-size:20px;'>
					Cumulative Flow
				</a>
				&nbsp; &nbsp; 				
				<a href='?page=filter&boardId={$boardId}&projectID={$PID}&width={$screenWidth}&goto=time' style='text-decoration:none; font-size:20px;'>
					Average Lead Time <img alt='Average Lead Time' title='Average Lead Time' src='../../static/images/analytics_icon.png' style='height:18px; width:18px;'/>
				</a>
				";				
			}
			echo "
				&nbsp; &nbsp; 				
				<a href='?page=filter&boardId={$boardId}&projectID={$PID}&width={$screenWidth}&goto=wip' style='text-decoration:none; font-size:20px;'>
					WIP Violations
				</a>";
		echo "	
			</div>
		";
		

	foreach ($cells as $cellId => $value) // tale foreach izrisuje stolpce
	{
		$cell = $cells[$cellId];
		$name = $cell['name'];
		$limit = $cell['limit'];
		$color = $cell['color'];
		$echoLimit = "";
		$parent_id = $cell['parent_id'];
		$column_id  = $cell['column_id'];
				
		// MAIN COLUMNS .... id_1 == extended column ... id_2 == shrinked column
		$number_of_sub_columns = 0; //var is needed for dynamic extension of column
		$name_no_whitespace = str_replace(' ', '', $name);
		
		if(is_null($parent_id)){
		
			if($isKM) {
				echo "	
				<div id='div_{$name_no_whitespace}_{$PID}_1' class='mainPanelBig outline'>
					<center><p><b> {$name}</b><br> Limit:{$limit}<br><a href='?page=editColumn&columnID={$column_id}&projectID={$PID}&width={$screenWidth}'>Edit column</a> </p></center>
					<div class='fake_underline' style='background-color:{$color};'></div>
				<div >
				";
			} else {
				echo "	
				<div id='div_{$name_no_whitespace}_{$PID}_1' class='mainPanelBig outline'>
					<center><p><b> {$name}</b><br> Limit:{$limit} <br> </p></center>
					<div class='fake_underline' style='background-color:{$color};'></div>
				<div >
				";
			}
			
			// <div style='display:flex;justify-content:center;'> to je bil zgornji prazni div, ampak ne delajo pozicije kartic in 
			
			//ADDING CARDS TO COLUMNS WITHOUT SUBCOLUMNS:
			$cards = $data[$PID]['cards'];
			foreach($cards as $cellId => $value){
				$card = $cards[$cellId];
				$card_column_id = $card['column_id'] ;
				
				if ($card_column_id == $column_id){
					$card_name = $card['name'];
					$card_size = $card['size'];
					$card_description = $card['description'];
					$card_id = $card['card_id'];
					$card_color = $card['color'];
					$card_limit = $card['limit'];
					$card_deadline = $card['deadline'];
									
					// get critical days from session
					$critical_days = $_SESSION['criticalDays'];
					$today = date('Y-m-j');
					$diff = strtotime($card_deadline) - strtotime($today);
					$diff = $diff / (3600*24);
									
					// if-else controlls critical cards
					if($diff < 0 || $diff <= $critical_days){
						echo "<div id='card_div' class='card_div_critical' style='border-color:{$card_color};'>";
					}
					else{
						echo "<div id='card_div' class='card_div' style='border-color:{$card_color};'>";
					}
					

					echo "
						<b>{$card_name}</b><br>
						<a href='?page=editcard&cardID={$card_id}&projectID={$PID}&width={$screenWidth}' style='text-decoration:none;'>
							<img alt='editCard' src='../../static/images/settings_icon.png' style='height:20px; width:23px;'/>
						</a>
						&nbsp;
						<a href='?page=movecard&cardID={$card_id}&projectID={$PID}&width={$screenWidth}' style='text-decoration:none;'>
							<img alt='editCard' src='../../static/images/move_icon.png' style='height:20px; width:20px;'/>
						</a><br>
						<a href='?page=comments&cardID={$card_id}'>Comments</a></br><br>
						<a href='?page=showHistory&cardID={$card_id}'>History</a></br>
					</div>";
				} // END: if ($card_column_id == $column_id)
			} // END: foreach($cards as $cellId => $value) ... adding cards to columns without subcolumns
			
				// ADDING SUBCOLUMNS TO MAIN COLUMNS
				foreach ($cells as $cellId => $value){
				
					$sub_cell = $cells[$cellId];
					$sub_name = $sub_cell['name'];
					$sub_parent_id = $sub_cell['parent_id'];
					$sub_limit = $sub_cell['limit'];
					$sub_color = $sub_cell['color'];
					$sub_column_id = $sub_cell['column_id'];
					
						
					if (!is_null($sub_parent_id) && ($sub_parent_id == $column_id) ){
						$number_of_sub_columns = $number_of_sub_columns + 1;
						$sub_name_no_whitespace = str_replace(' ', '', $sub_name);
						
						if($isKM) {
						echo "
						<center>
						<div id='sub_{$sub_name_no_whitespace}_{$PID}_1' class='child_column_big outline' style='display:inline-block;'>
							<center><p><b> {$sub_name}</b><br> Limit: {$sub_limit} <br><a href='?page=editColumn&columnID={$sub_column_id}&projectID={$PID}&width={$screenWidth}'>Edit column</a></br> </p></center>
						<div class='fake_underline_thin' style='background-color:{$color};'></div>
						";	
						} 
						else {
							echo "
							<center>
							<div id='sub_{$sub_name_no_whitespace}_{$PID}_1' class='child_column_big outline' 
							style='display:inline-block;'>
								<center><p><b> {$sub_name}</b><br> Limit: {$sub_limit} <br> </p></center>
								<div class='fake_underline_thin' style='background-color:{$color};'></div>
							";	
						}
						
							
							//ADDING CARDS TO SUBCOLUMNS:
							$cards = $data[$PID]['cards'];
							foreach($cards as $cellId => $value){
								$card = $cards[$cellId];
								$card_column_id = $card['column_id'] ;

								if ($card_column_id == $sub_column_id){
									$card_name = $card['name'];
									$card_size = $card['size'];
									$card_description = $card['description'];
									$card_id = $card['card_id'];
									$card_color = $card['color'];
									$card_deadline = $card['deadline'];
									
									// get critical days from session
									$critical_days = $_SESSION['criticalDays'];
									$today = date('Y-m-j');
									$diff = strtotime($card_deadline) - strtotime($today);
									$diff = $diff / (3600*24);
									
									// if-else controlls critical cards
									if($diff < 0 || $diff <= $critical_days){
										echo "<div id='card_div' class='card_div_critical' style='border-color:{$card_color};'>";
									}
									else{
										echo "<div id='card_div' class='card_div' style='border-color:{$card_color};'>";
									}
									echo "
									
										<b>{$card_name}</b><br>
										<a href='?page=editcard&cardID={$card_id}&projectID={$PID}&width={$screenWidth}' style='text-decoration:none;'>
											<img alt='editCard' src='../../static/images/settings_icon.png' style='height:20px; width:23px;'/>
										</a>
										&nbsp;
										<a href='?page=movecard&cardID={$card_id}&projectID={$PID}&width={$screenWidth}' style='text-decoration:none;'>
											<img alt='editCard' src='../../static/images/move_icon.png' style='height:20px; width:20px;'/>
										</a>
										<br>
										<a href='?page=comments&cardID={$card_id}'>Comments</a></br><br>
										<a href='?page=showHistory&cardID={$card_id}'>History</a></br>
									</div>";
								}
							}		
							
						echo "		
						</div>
							
						<div id='sub_{$sub_name_no_whitespace}_{$PID}_2' class='child_column_small outline' style='display:none;background-color:{$color};'>
							<center><b><p class='vertical_text'> {$sub_name} </p></b></center>
						</div> 
						</center>
						"; //end echo
						
					}
				}
				
				echo " <script> extend_function( '{$name_no_whitespace}_{$PID}', '{$number_of_sub_columns}' ); </script>";
	
			echo "	
			</div>	
			</div>
			 
			<div id='div_{$name_no_whitespace}_{$PID}_2' class='mainPanelSmall outline hidden' style='background-color:{$color};'>
				<center><b><p class='vertical_text'> {$name} </p></b></center>
			</div>	
			";
			
			// apply function sum_width(divName)
			echo " <script> sum_width('{$name_no_whitespace}_{$PID}'); </script>";
			
		} //end inner for_each
	} // end outter for_each
	
echo "</div>"; //end swimline div
//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>"; 
echo "
	
	<div id='swl_{$PID}_2' class='center_block_header hidden' style:'margin:10px 0 10px 0;'>
		Project: {$allProjectNames[$PID]} (ID#{$PID}).
		<a href='#info'><img src='../../static/images/info-icon.svg' style='width:20px;height:20px'/></a>
		<a href='?page=copyTable&blabla=333'>
			<img src='../../static/images/copy_icon.png' style='width:20px;height:20px;text-decoration:none;' />
		</a>
	</div>
	<br>
";
echo " <script> apply_width_to_swimline('swl_{$PID}_1'); </script>";
echo " <script> reset_div_sums(); </script>";
} // end: swimline for-each

?>
</center>
       <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Table' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						User may view the board. Administrator can view all boards. 
						Other users (Product Owner, KanbanMaster developer) may view only those 
						boards that relate to their development team. Only active users may view 
						the boards. <br><br>
						To create new card for current board click on 'Create new card' link. <br>
						If you would like to check Cumulative Flow, Average Lead Time or WIP Violations<br>
						click on proper link and you will get a filter.<br>
						Select filter settings and click Submit. You will get chosen option (Cumulative Flow, Average Lead Time or WIP Violation)<br>
						with filtered cards.
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