[include]app/views/header.view.php[/include]
[include]app/views/menu.view.php[/include]

<center>
<br><div class="center_block_header"> Edit Column - WIP VIOLATION DETECTED </div><br>

<div class="center_block" style="max-width:10%;">
	
	<p style="text-align:justify;">
	<? if(isset($error)) { ?>
		{{error}}
	<? } else { ?>
		{{message}}
	<? } ?>
	</p>

	<form action='?page=editColumnSub' method='post'>
		<input type="hidden" value="<?php echo $projectID; ?>" name="projectID" id="projectID">
		<input type="hidden" value="<?php echo $width; ?>" name="width" id="width">
		<input type="hidden" value="<?php echo $testing; ?>" name="testing" id="testing">
		<input type="hidden" value="<?php echo $priority; ?>" name="priority" id="priority">
		<input type="hidden" value="<?php echo $limit; ?>" name="limit" id="limit">
		<input type="hidden" value="<?php echo $cName; ?>" name="cName" id="cName">
		<input type="hidden" value="<?php echo $columnID; ?>" name="columnID" id="columnID">
		<input type='submit' name='submitYes' value='Yes, I want to'>
		<br>
		<input type='submit' name='submitNo' value='No, I do not want to'>
	</form>
	
</div>
</center>
[include]app/views/footer.view.php[/include]