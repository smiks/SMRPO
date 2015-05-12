[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]


<div class="center_block_header" style="width:97%;">
	Table: {{boardName}} 
	<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a><br><br>
	<? if($isKM || $isPO){ ?>
		<a href='?page=createcard&projectID={{projectID}}' style="text-decoration:none; font-size:20px;">Create new card</a>
	<? }

	if($isEmpty && $isKM){
	?>
		&nbsp; &nbsp; <a href="?page=edittable&projectID={{projectID}}" style="text-decoration:none; font-size:20px;">Edit board</a>
	<?
	}
	?>		
</div>




	
	
<div id="toCenter" style="margin-top:2%;">
	<?php
		$xy = array();
		$maxY = 0;
		$colCoor = array();		
		$boardLength = 0;
		$numSwimLines = count($data);
		$maxLimit = 0;
	?>
	<br><br>
	<div style="width: 89%" >
		<?php
			$i = 0;
			foreach ($cells as $cellId => $value)
			{
				$cell = $cells[$cellId];
				$x = $cell['x'];
				$y = $cell['y'];
				$length = $cell['length'];
				$name = $cell['name'];
				$limit = $cell['limit'];
				$color = $cell['color'];
				$xy[$cellId] = array("x" => $x, "y" => $y);
				
				$colCoor[$cellId] = array ("x" => $x, "y" => $y+42, "length" => $length);
				
				if(count($cells) == $i+1)
					$xy[$cellId+1] = array("x" => $x+$length, "y" => $y);
				
				$i = $i+1;
				
				if($y == 162)
					$boardLength = $boardLength + $length;
				
				if ($y > $maxY)
					$maxY = $y;
				if ($maxLimit < $limit)
					$maxLimit = $limit;

				$echoLimit = "";
				if ($limit > 0)
					$echoLimit = "Limit: ${limit}";
				
				echo "<div style='position:absolute;top:{$y}px;left:{$x}px;width:{$length}px;border-radius:0px;border:2px solid white; border-top-color: {$color};'><b>{$name}</b><br>${echoLimit}</br></div>";
			}
			$border = ($numSwimLines-1) * (110*$maxLimit);
			foreach ($xy as $id => $val)
			{
				$x = $xy[$id]['x'];
				$y = $xy[$id]['y'];
				echo "<div style='position:absolute;width:5px;left:{$x}px;top:{$y}px;bottom:-{$border}px;background-color:white;'></div>";
			}
			
			$maxY = $maxY + 42;
			echo "<div style='position:absolute;height:5px;left:0px;top:{$maxY}px;width:{$boardLength}px;background-color:white;'></div>";
			
			$i=0;
			foreach ($data as $projectId => $value)
			{
				$cards = $data[$projectId ]['cards'];
				$maxy = $maxY + $i*(110 * $maxLimit);
				
				foreach ($cards as $cardId => $val)
				{
					$card = $cards[$cardId];
					$color = $card['color'];
					$colId = $card['column_id'];
					$name = $card['name'];
					$size = $card['size'];
					$description = $card['description'];
					
					$coordinates = $colCoor[$colId];
					$x = $coordinates['x'];
					$y = $coordinates['y'];
					
					if ($maxy >= $y)
						$y = $maxy + 10;
					
					$length = $coordinates['length'];
					echo "<div style='position:absolute;top:{$y}px;left:{$x}px;width:{$length}px;height:100px;border-radius:0px;border:2px solid white; border-top-color: {$color};'><b>Task {$cardId}: {$name}</b><a href='?page=editcard&cardID={$cardId}'><img alt='editCard' src='../../static/images/settings_2.png' style='height:15px; width:15px; float:right; padding-top:5px; padding-right:10px;'/></a><br>Size: {$size}</br><br>Description: {$description}</br></div>";
					$colCoor[$colId] = array("x" => $x, "y" => $y+110, "length" => $length);
				}
				$i = $i + 1;
				$maxy = $maxy + (110 * $maxLimit);
				if ($i < $numSwimLines)
					echo "<div style='position:absolute;height:5px;left:0px;top:{$maxy}px;width:{$boardLength}px;background-color:white;'></div>";	
			}
		?>
	</div>
</div>

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
						To create new card for current board click on 'Create new card' link. 

						
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