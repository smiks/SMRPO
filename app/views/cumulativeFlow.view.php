[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]
<head>
	<script type="text/javascript" src="../../static/js/canvasjs.min.js"></script>
	<script type="text/javascript">
		  window.onload = function () {
		  var chart = new CanvasJS.Chart("cumulative",
		    {
		      title:{
		        text: "   "   
		      },
		      animationEnabled: true,
		      axisY:{
		        title:"Number of cards",
		        interval: 3,
		        maximum: <?php echo ($number+2); ?>
		      },
		      axisX:{
		        title: "Days",
		        labelAngle: -45
		      },
		      toolTip:{
		        shared: true
		      },
		      data: [
		      
		      <?php foreach($cols as $colId => $value)
		      	{
		      		if ($cols[$colId]['checked'])
		      		{		      			
			      		?> 
			      		{        
				        type: "stackedArea",
				        name: "<?php echo $cols[$colId]['name']; ?>",
				        showInLegend: "true",
				        dataPoints: [
				        <?php foreach($numCards as $date => $val)
				        	{
				        		$y = $numCards[$date][$colId];			   				        		
				        		$year = date("Y", strtotime($date));
				        		$month = date("m", strtotime($date));
				        		$day = date("d", strtotime($date));
				        		
				        		?>
				        		{ y: Number(<?php echo $y; ?>) , x: new Date(Number(<?php echo $year; ?>), Number(<?php echo $month; ?>)-1, Number(<?php echo $day; ?>)) },
				        		<?php
				        	}
				        ?>
				        
				        ]
				      }, 
			      <?php
			      }
			} ?>      		               
		        
		      ]
		    });
		
		    chart.render();
		  }
		  </script>
</head>	  

<br><div class="center_block_header"> 
		Cumulative Flow
		<a href="#info"><img src="../../static/images/info-icon.svg" style="width:20px;height:20px"/></a>
	</div><br>
<div>
	<div style="width:530px; height: 700px; margin-top: 20px; margin-left:10px; background-color:white; border-radius: 6px; font: 18px/18px BryantProBoldAlternateRegular; float:left">
		Shown data
		<form action='?page=cumulativeFlow&width={{width}}&boardId={{boardId}}&projectID={{projectID}}' method='post'>
			<div style="height:3px; background-color: #3F3F3E;margin-top:33px"></div>
			<div style = "float:left; padding-top:10px; padding-left:5px"> From date: </div>
			<input style="width:165px; float:left; margin-left:5px" type = "date" id = "fromDate" name="fromDate" value="<?php echo"{$fromDate}"; ?>" />
			<div style = "float:left; padding-left:10px; padding-top:10px;"> To date: </div>
			<input style='width:165px; float:left; margin-left:5px' type = 'date' id = 'toDate' name='toDate' value="<?php echo"{$toDate}"; ?>" /> <br>
			<div style="height:3px; background-color: #3F3F3E;margin-top:33px"></div>
			<div style = "float:left; padding-top:10px; padding-left:5px"> Select columns: </div> <br><br>
			<div>
				<?php
					foreach($cols as $colId => $val)
					{
						$col = $cols[$colId];
						$name = $col['name'];
						$checked = $col['checked'];
						$showCheck = "checked";
						if(!$checked)
							$showCheck ="";
						echo "<input type='checkbox' name='$name' value='$name' style='margin-left:80px' {$showCheck} >$name<br>";
					}
				?>
			</div>
			<input type="hidden" value=<?php echo $boardId; ?> name="boardId" id="boardId"/>
			<input type="hidden" value=<?php echo $projectID; ?> name="projectID" id="projectID"/>
			<input type="hidden" value=<?php echo $width; ?> name="width" id="width"/>
			
			<input type="submit" value="Show cumulative flow" style = "width: 400px; margin-top:80px"/><br>
			<?php echo "<a href='?page=showtable&projectID={$projectID}&width={$width}' class='btn_signup'>Back</a>" ?>
		</form>
		
		
	</div>
	
	<?php $w = $width - 600; echo "<div id='cumulative' style='width:{$w}px; height: 700px; background-color:white; border-radius: 6px; font: 18px/18px BryantProBoldAlternateRegular; float:left; margin-top: 20px; margin-left:10px; overflow:auto;'>"; ?>
	
	
	</div>
</div>

       <!-- Modal -->
		<div style="margin-left:10%;">
		<div class="modal" id="info" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-header">
					<br><label class="cool_font" style="font-size:30px;">'Cumulative flow' help: </label><br><br>
					<a href="#close" class="close" aria-hidden="true">×</a> <!--CHANGED TO "#close"-->
				</div>
				<div class="modal-body" align="justify">
					<p>
						Applied filter settings from previous page are used to draw this cumulative flow chart.<br>
						You can alter chart settings on the left side. Settings that can be changed are <br>
						Date (X-axis) and columns (what columns should be presented).
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