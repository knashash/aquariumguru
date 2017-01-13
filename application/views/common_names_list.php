<div class="sixteen columns">
	
	<h3>Common Names List</h3>
	
	<ul class="names_list">
	<?php
		foreach ($common_names as $common_name_details)
		{	
			echo "<li><a href=\"/fish-profiles/common-name/".$common_name_details->name_url_friendly."\">".$common_name_details->name."</a></li>";
		}
	?>
	</ul>
</div>