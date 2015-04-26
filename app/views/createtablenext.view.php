[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field">
		<h3>Create Board</h3>
	</div>
	<br>
	<div id="field" style="overflow: auto;">
		<form action='?page=createtablesub' method='post'>
			<input type='hidden' name='groupID' value='{{groupID}}'>
			<input type='hidden' name='projectID' value='{{projectID}}'>
			<input type='hidden' name='colorColsOne' value='{{limitCol1}}'>
			<input type='hidden' name='colorColsTwo' value='{{limitCol2}}'>
			<input type='hidden' name='colorColsThree' value='{{limitCol3}}'>
			<center>
				<label>Board name</label>
				<input type="text" name="boardName" id="textinput_200" value='{{boardName}}' readonly><br>
				<br>
				<table style='width: 99%;'>
					<tr>
						<td colspan='{{nCols1}}' style='background-color: {{colorCol1}}'>
							<center>
								BackLog <br>
								Limit: {{limitCol1}}
							</center>
						</td>
						<td colspan='{{nCols2}}' style='background-color: {{colorCol2}}'>
							<center>
								Development <br>
								Limit: {{limitCol2}}
							</center>
						</td>
						<td colspan='{{nCols3}}' style='background-color: {{colorCol3}}'>
							<center>
								Done <br>
								Limit: {{limitCol3}}
							</center>
						</td>
					</tr>
					<tr>
						<?
							for($i=0; $i<$nCols1; $i++){
								$fName = "1_".($i+1);
								$fLimit = $fName."_limit";
								echo"
									<td style='width: {$wCol1}%; padding: 1px; border-style: dotted; border-width: 1px;'>
										Column Name <br>
										<input type='text' name='{$fName}' id='textinput_100'><br>
										Column Limit <br>
										<input type='number' name='{$fLimit}' style='width: 50px;' value='0' min='0' max='50'><br>
									</td>
								";
							}

							for($i=0; $i<$nCols2; $i++){
								$fName = "2_".($i+1);
								$fLimit = $fName."_limit";
								echo"
									<td style='width: {$wCol2}%; padding: 1px; border-style: dotted; border-width: 1px;'>
										Column Name <br>
										<input type='text' name='{$fName}' id='textinput_100'><br>
										Column Limit <br>
										<input type='number' name='{$fLimit}' style='width: 50px;' value='0' min='0' max='50'><br>
									</td>
								";
							}

							for($i=0; $i<$nCols3; $i++){
								$fName = "3_".($i+1);
								$fLimit = $fName."_limit";
								echo"
									<td style='width: {$wCol3}%; padding: 1px; border-style: dotted; border-width: 1px;'>
										Column Name <br>
										<input type='text' name='{$fName}' id='textinput_100'><br>
										Column Limit <br>
										<input type='number' name='{$fLimit}' style='width: 50px;' value='0' min='0' max='50'><br>
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