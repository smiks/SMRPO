[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field">
		<h3>Edit Board</h3>
	</div>
	<br>
	<div id="field" style="overflow: auto;">
		<form action='?projectID={{projectID}}' method='post'>
			<input type='hidden' name='groupID' value='{{groupID}}'>
			<input type='hidden' name='projectID' value='{{projectID}}'>
			<input type='hidden' name='limitCol1' value='{{limitCol1}}'>
			<input type='hidden' name='limitCol2' value='{{limitCol2}}'>
			<input type='hidden' name='limitCol3' value='{{limitCol3}}'>
			<input type='hidden' name='nCols1' value='{{nCols1}}'>
			<input type='hidden' name='nCols2' value='{{nCols2}}'>
			<input type='hidden' name='nCols3' value='{{nCols3}}'>
			<input type='hidden' name='colorCol1' value='{{colorCol1}}'>
			<input type='hidden' name='colorCol2' value='{{colorCol2}}'>
			<input type='hidden' name='colorCol3' value='{{colorCol3}}'>

			<center>
				<label>Board name</label>
				<input type="text" name="boardName" id="textinput_200" value='{{boardName}}' readonly><br>
				<br>
				<table style='width: 99%;'>
					<tr>
						<td colspan='{{nCols1}}' style='background-color: {{colorCol1}}'>
							<center>
								BackLog  <br>
								Limit: <input type='number' name='limitP1' value='{{limitP1}}'>
							</center>
						</td>
						<td colspan='{{nCols2}}' style='background-color: {{colorCol2}}'>
							<center>
								Development <br>
								Limit: <input type='number' name='limitP2' value='{{limitP2}}'>
							</center>
						</td>
						<td colspan='{{nCols3}}' style='background-color: {{colorCol3}}'>
							<center>
								Done <br>
								Limit: <input type='number' name='limitP3' value='{{limitP3}}'>
							</center>
						</td>
					</tr>
					<tr>
						<?
							if($nCols1 == 0){
								echo"<td style='width: {$wCol1}%; padding: 1px; border-style: dotted; border-width: 1px;'>
								<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=1' style='text-decoration: none; color: #000;' title='Add column'><big><big>+</big></big></a>
								</td>";
							}
							for($i=0; $i<$nCols1; $i++){
								$column = $i+1;
								$fName = "1_".($column);
								$fLimit = $fName."_limit";
								$name = $nameC1[$column];
								$limit = $limitC1[$column];
								$columnID = $colIDC1[$column];
								$leftAdd = "";
								$rightAdd = "";
								$remove   = "<a href='?page=edittable&projectID={$projectID}&remove={$columnID}&pos={$column}' style='text-decoration: none; color: #000;' title='Remove column'>&#9747;</a>";
								if($i == 0){
									$leftAdd = "<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=1' style='text-decoration: none; color: #000;' title='Add column to left'><big><big>&lArr;+</a>{$remove}</big></big>";
								}
								elseif($i+1 == $nCols1 && $nCols1 > 2){
									$rightAdd = "<big><big>{$remove}</big></big><a href='?page=edittable&projectID={$projectID}&addRight={$column}&P=1' style='text-decoration: none; color: #000;' title='Add column to right'><big><big>+&rArr;</big></big></a>";
								}
								else{
									$rightAdd = "<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=1' style='text-decoration: none; color: #000;' title='Add column to left'><big><big>&lArr;+ </a> {$remove} <a href='?page=edittable&projectID={$projectID}&addRight={$column}&P=1' style='text-decoration: none; color: #000;' title='Add column to right'>+&rArr;</big></big></a>";
								}								
								echo"
									<td style='width: {$wCol1}%; padding: 1px; border-style: dotted; border-width: 1px;'>
										Column Name <br>
										<input type='text' name='{$fName}' id='textinput_100' value='{$name}' required><br>
										Column Limit <br>
										<input type='number' name='{$fLimit}' style='width: 50px;' value='{$limit}' min='0' max='50'><br>
										<center>
										Options <br>
										{$leftAdd}
										{$rightAdd}
										</center>
									</td>
								";
							}

							if($nCols2 == 0){
								echo"<td style='width: {$wCol2}%; padding: 1px; border-style: dotted; border-width: 1px;'>
								<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=2' style='text-decoration: none; color: #000;' title='Add column'><big><big>+</big></big></a></td>";
							}

							for($i=0; $i<$nCols2; $i++){
								$column = $i+1+$nCols1;
								$fName = "2_".($i+1);
								$fLimit = $fName."_limit";
								$name = $nameC2[$column];
								$limit = $limitC2[$column];
								$columnID = $colIDC2[$column];
								$leftAdd = "";
								$rightAdd = "";
								$remove   = "<a href='?page=edittable&projectID={$projectID}&remove={$columnID}&pos={$column}' style='text-decoration: none; color: #000;' title='Remove column'>&#9747;</a>";
								if($i == 0){
									$leftAdd = "<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=2' style='text-decoration: none; color: #000;' title='Add column to left'><big><big>&lArr;+</a>{$remove}</big></big>";
								}
								elseif($i+1 == $nCols2 && $nCols2 > 2){
									$rightAdd = "<big><big>{$remove}</big></big><a href='?page=edittable&projectID={$projectID}&addRight={$column}&P=2' style='text-decoration: none; color: #000;' title='Add column to right'><big><big>+&rArr;</big></big></a>";
								}
								else{
									$rightAdd = "<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=2' style='text-decoration: none; color: #000;' title='Add column to left'><big><big>&lArr;+ </a> {$remove} <a href='?page=edittable&projectID={$projectID}&addRight={$column}&P=2' style='text-decoration: none; color: #000;' title='Add column to right'>+&rArr;</big></big></a>";
								}
								echo"
									<td style='width: {$wCol2}%; padding: 1px; border-style: dotted; border-width: 1px;'>
										Column Name <br>
										<input type='text' name='{$fName}' id='textinput_100' value='{$name}' required><br>
										Column Limit <br>
										<input type='number' name='{$fLimit}' style='width: 50px;' value='{$limit}' min='0' max='50'><br>
										<center>
										Options <br>
										{$leftAdd}
										{$rightAdd}
										</center>
									</td>
								";
							}

							if($nCols3 == 0){
								echo"<td style='width: {$wCol3}%; padding: 1px; border-style: dotted; border-width: 1px;'>
								<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=3' style='text-decoration: none; color: #000;' title='Add column'><big><big>+</big></big></a></td>";
							}
							for($i=0; $i<$nCols3; $i++){
								$column = $i+1+$nCols1+$nCols2;
								$fName = "3_".($i+1);
								$fLimit = $fName."_limit";
								$name = $nameC3[$column];
								$limit = $limitC3[$column];
								$columnID = $colIDC3[$column];
								$leftAdd = "";
								$rightAdd = "";
								$remove   = "<a href='?page=edittable&projectID={$projectID}&remove={$columnID}&pos={$column}' style='text-decoration: none; color: #000;' title='Remove column'>&#9747;</a>";
								if($i == 0){
									$leftAdd = "<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=3' style='text-decoration: none; color: #000;' title='Add column to left'><big><big>&lArr;+</a>{$remove}</big></big>";
								}
								elseif($i+1 == $nCols3 && $nCols3 > 2){
									$rightAdd = "<big><big>{$remove}</big></big><a href='?page=edittable&projectID={$projectID}&addRight={$column}&P=3' style='text-decoration: none; color: #000;' title='Add column to right'><big><big>+&rArr;</big></big></a>";
								}
								else{
									$rightAdd = "<a href='?page=edittable&projectID={$projectID}&addLeft={$column}&P=3' style='text-decoration: none; color: #000;' title='Add column to left'><big><big>&lArr;+ </a> {$remove} <a href='?page=edittable&projectID={$projectID}&addRight={$column}&P=3' style='text-decoration: none; color: #000;' title='Add column to right'>+&rArr;</big></big></a>";
								}
								echo"
									<td style='width: {$wCol3}%; padding: 1px; border-style: dotted; border-width: 1px;'>
										Column Name <br>
										<input type='text' name='{$fName}' id='textinput_100' value='{$name}' required><br>
										Column Limit <br>
										<input type='number' name='{$fLimit}' style='width: 50px;' value='{$limit}' min='0' max='50'><br>
										<center>
										Options <br>
										{$leftAdd}
										{$rightAdd}
										</center>
									</td>
								";
							}
						?>
					</tr>
					<tr>
						<td colspan='{{totalCols}}'>
							<br>
						</td>
					</tr>					
					<tr>
						<td colspan='{{totalCols}}'>
							<center>
								<input type='submit' value='Submit'>
							</center>
						</td>
					</tr>
				</table>
					
			</center>
		</form>
		<br>
		&nbsp;
		<br>
	</div>

</div>




[include]app/views/footer.view.php[/include]