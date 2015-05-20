[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<br><div class="center_block_header" style="width:97%">
		Cumulative flow
</div><br>

<div style="width:500px; height: 700px; margin-top: 20px; margin-left:10px; background-color:white; border-radius: 6px; font: 18px/18px BryantProBoldAlternateRegular">
	Filter data
	<form action='?page=cumulativeFlow' method='post'>
		<?php $date = Functions::dateDB(); ?>
		<div style="height:3px; background-color: #3F3F3E;margin-top:33px"></div>
		<div style = "float:left; padding-top:10px; padding-left:5px"> From date: </div>
		<input style="width:130px; float:left; margin-left:5px" type = "date" id = "fromDate" name="fromDate" />
		<div style = "float:left; padding-left:10px; padding-top:10px;"> To date: </div>
		<input style='width:130px; float:left; margin-left:5px' type = 'date' id = 'toDate' name='toDate' placeholder= <?php echo $date; ?> /> <br>
		<div style="height:3px; background-color: #3F3F3E;margin-top:33px"></div>
		<div style = "float:left; padding-top:10px; padding-left:5px"> Select columns: </div> <br><br>
		<div>
			<?php
				foreach($cols as $colId => $val)
				{
					$col = $cols[$colId];
					$name = $col['name'];
					$parentId = $col['parentId'];
					
					echo "<input type='checkbox' name=$name value=$name style='margin-left:80px'>$name<br>";
				}
			?>
		</div>
		<div style="height:3px; background-color: #3F3F3E;margin-top:33px"></div>
		<div style = "float:left; padding-top:10px; padding-left:5px"> Select cards: </div> <br><br>
		<div>
			<?php
				foreach($crds as $cardId => $val)
				{
					$card = $crds[$cardId];
					$name = $card ['name'];
					$colId= $card ['columnId'];
					
					echo "<input type='checkbox' name=$name value=$name style='margin-left:80px'>$name<br>";
				}
			?>
		</div>
	</form>
	
	
</div>

[include]app/views/footer.view.php[/include]