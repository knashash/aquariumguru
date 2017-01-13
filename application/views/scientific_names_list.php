<div class="sixteen columns">
	
	<h3>Scientific Names List</h3>
	
	<ul class="names_list">
	<?php
		foreach ($scientific_names as $scientific_name_details)
		{
			echo "<li><a href=\"/fish-profiles/scientific-name/".$scientific_name_details->name_url_friendly."\">".$scientific_name_details->scientific_name."</a></li>";
		}
	?>
	</ul>
</div>