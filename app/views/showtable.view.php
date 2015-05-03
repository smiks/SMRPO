[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field"  style="width: 89%; float:left; ">
		<h3 style="float:left; padding-left:350px;"> <?php echo $boardName; ?></h3>
		<?
		if($isKM || $isPO){
		?>
		<div style="float:right;" id="menu_option" onClick="location.href='?page=createcard<? echo"&projectID={$projectID}"; ?>'">
			<? echo"<a href='?page=createcard&projectID={$projectID}'>Create card</a>"; ?>
		</div>
		<?
		}
		?>
	</div>
	<?php
		$xy = array();
		$maxY = 0;
		$colCoor = array();		
		$boardLength = 0;
		$numSwimLines = count($data);
		$maxLimit = 0;
	?>
	<?
	if($isEmpty && $isKM){
	?>
	<div id="field" style="width: 89%">
		This board is empty! You can edit it. <a href="?page=edittable&projectID={{projectID}}">Link</a>
	</div>
	<?
	}
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
					$echoLimit = "Limit: {$limit}";
				
				echo "<div style='position:absolute;top:{$y}px;left:{$x}px;width:{$length}px;border-radius:0px;border:2px solid white; border-top-color: {$color};'><b>Task {$cardId}: {$name}</b><br>${echoLimit}</br></div>";
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
					
					$coordinates = $colCoor[$colId];
					$x = $coordinates['x'];
					$y = $coordinates['y'];
					
					if ($maxy >= $y)
						$y = $maxy + 10;
					
					$length = $coordinates['length'];
					echo "<div style='position:absolute;top:{$y}px;left:{$x}px;width:{$length}px;height:100px;border-radius:0px;border:2px solid white; border-top-color: {$color};'><b>{$name}</b></div>";
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

[include]app/views/footer.view.php[/include]