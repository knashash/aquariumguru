<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>Edit Regions</title>
</head>
<body>

<form id="edit_regions_form">
	<input type="hidden" id="profile_id" value=<?php echo $profile_id ?> >
	<div id="checkboxes">
	<?php

		foreach ($regions_list as $list_index => $value)
		{
			$region_name = $regions_list[$list_index]->region;
			$region_id = $regions_list[$list_index]->id;
			
			$checked_text = "";
			if (array_key_exists($region_id, $regions_profile_array))
			{
				$checked_text = "checked";
			}
			
			echo "<input type=\"checkbox\" value=\"$region_id\" $checked_text> $region_name "."|";
		}
	?>
	</div>
	<br><br>
	<div>
	<input type="submit" value="Update regions">
	</div>
</form>

<script type="text/javascript" src="/js/edit_regions.js"></script>
</body>
</html>