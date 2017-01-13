<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<title>Edit Countries</title>
</head>
<body>

<form id="edit_countries_form">
	<input type="hidden" id="profile_id" value=<?php echo $profile_id ?> >
	<div id="checkboxes">
	<?php

		foreach ($countries_list as $list_index => $value)
		{
			$country_name = $countries_list[$list_index]->country;
			$country_id = $countries_list[$list_index]->id;
			
			$checked_text = "";
			if (array_key_exists($country_id, $countries_profile_array))
			{
				$checked_text = "checked";
			}
			
			echo "<input type=\"checkbox\" value=\"$country_id\" $checked_text> $country_name "."|";
		}
	?>
	</div>
	<br><br>
	<div>
	<input type="submit" value="Update Countries">
	</div>
</form>

<script type="text/javascript" src="/js/edit_countries.js"></script>
</body>
</html>