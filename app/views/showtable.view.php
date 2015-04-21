[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field"  style="width: 89%;">
		<h3> <?php echo $data['boardName']; ?></h3>
	</div>
	<?php
		$cells = $data['cells'];
		$xy = array();
		$maxY = 0;
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
				$color = "light{$color}";
				$xy[$cellId] = array("x" => $x, "y" => $y);
				
				if(count($cells) == $i+1)
					$xy[$cellId+1] = array("x" => $x+$length, "y" => $y);
				
				$i = $i+1;
				
				if ($y > $maxY)
					$maxY = $y;
				
				echo "<div style='position:absolute;top:{$y}px;left:{$x}px;width:{$length}px;border-radius:0px;border:2px solid white; border-top-color: {$color};'><b>{$name}</b><br>Limit: ${limit}</br></div>";
			}
			
			foreach ($xy as $id => $val)
			{
				$x = $xy[$id]['x'];
				$y = $xy[$id]['y'];
				echo "<div style='position:absolute;width:5px;left:{$x}px;top:{$y}px;bottom:0px;background-color:white;'></div>";
			}
			$maxY = $maxY + 42;
			echo "<div style='position:absolute;height:5px;left:0px;top:{$maxY}px;right:0px;background-color:white;'></div>";
		?>
	</div>
</div>

[include]app/views/footer.view.php[/include]