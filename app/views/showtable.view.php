[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<div id="toCenter">
	<br>
	<div id="field"  style="width: 89%;">
		<h3> <?php echo $data['boardName']; ?></h3>
	</div>
	<?php
		$cells = $data['cells'];
	?>
	<div style="width: 89%">
		<?php
			foreach ($cells as $cellId => $value)
			{
				$cell = $cells[$cellId];
				$x = $cell['x'];
				$y = $cell['y'];
				$length = $cell['length'];
				$name = $cell['name'];
				$limit = $cell['limit'];
				
				echo "<div style='position:absolute;top:{$y}px;left:{$x}%;width:{$length}%;border-radius:0px;border:2px solid white;'><b>{$name}</b><br>Limit: ${limit}</br></div>";
			}
		?>
	</div>
</div>

[include]app/views/footer.view.php[/include]