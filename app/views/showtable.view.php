[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field"  style="width: 89%;">
		<h3> <?php echo $data['boardName']; ?></h3>
	</div>
	<?php
		$cells = $data['cells'];
		$cards = $data['cards'];
		$screenWidth = $data['screenWidth'];
		$xy = array();
		$maxY = 0;
		$maxX = 0;
		$maxLength = 0;
		$colCoor = array();
	?>
	<div style="width: 89%">
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
				
				if ($y > $maxY)
					$maxY = $y;
				if ($x > $maxX)
				{
					$maxX= $x;
					if($length > $maxLength)
						$maxLength = $length;
				}
				$echoLimit = "";
				if ($limit > 0)
					$echoLimit = "Limit: {$limit}";
				
				echo "<div style='position:absolute;top:{$y}px;left:{$x}px;width:{$length}px;border-radius:0px;border:2px solid white; border-top-color: {$color};'><b>{$name}</b><br>${echoLimit}</br></div>";
			}
			
			foreach ($xy as $id => $val)
			{
				$x = $xy[$id]['x'];
				$y = $xy[$id]['y'];
				echo "<div style='position:absolute;width:5px;left:{$x}px;top:{$y}px;bottom:0px;background-color:white;'></div>";
			}
			$maxY = $maxY + 42;
			$right = $screenWidth - $maxX - $maxLength;
			if ($right < 0)
				$right = 0;
			echo "<div style='position:absolute;height:5px;left:0px;top:{$maxY}px;right:{$right}px;background-color:white;'></div>";
			
			foreach ($cards as $cardId => $value)
			{
				$card = $cards[$cardId];
				$color = $card['color'];
				$colId = $card['column_id'];
				$name = $card['name'];
				
				$coordinates = $colCoor[$colId];
				$x = $coordinates['x'];
				$y = $coordinates['y'];
				if($maxY >= $y)
					$y = $maxY + 10;
				$length = $coordinates['length'];
				echo "<div style='position:absolute;top:{$y}px;left:{$x}px;width:{$length}px;height:100px;border-radius:0px;border:2px solid white; border-top-color: {$color};'><b>{$name}</b></div>";
				$colCoor[$colId] = array("x" => $x, "y" => $y+110, "length" => $length);
			}
		?>
	</div>
</div>

[include]app/views/footer.view.php[/include]