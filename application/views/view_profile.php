<div id="profile_container">
	
	<div class="sixteen columns">
		
		<!-- Display the name the user serached for or clicked on -->
		<div class="seven columns">
			<h1><?php echo $main_profile[0]->searched_name?></h1>
		</div>

		
		<!-- Depending on if the scientific name or common name was searched for, we will adjust the format of the names display -->
		<div class="eight columns name_alts">
		<?php
			// Display the alternate common names if the scientific name was serached for
			if ($main_profile[0]->searched_name_type == 'scientific')
			{
				if (!empty($common_names))
				{
					echo "<p>Common Name(s):</p>";
				
					foreach ($common_names as $common_name_data_object_key => $common_name_data_object)
					{
						if ( end( array_keys( $common_names ) ) == $common_name_data_object_key ) 
						{
							echo "<h2>".$common_name_data_object->name."</h2>";
						}
						else
						{
							echo "<h2>".$common_name_data_object->name."</h2>, ";
						}
					}
				}
				
			}
			// Display the scientific name and alternate common names if a common name was serached for
			else
			{
				echo "<p>Scientific Name:</p><h2>".$main_profile[0]->scientific_name."</h2>";
				
				$counter = 0;
				
				foreach ($common_names as $common_name_data_object_key => $common_name_data_object)
				{
					if ($main_profile[0]->searched_name != $common_name_data_object->name)
					{
						if (!$counter)
						{
							echo "<p>Other Common Name(s):</p>";
						}
						
						if ( end( array_keys( $common_names ) ) == $common_name_data_object_key ) 
						{
							echo "<h2>".$common_name_data_object->name."</h2>";
						}
						else
						{
							echo "<h2>".$common_name_data_object->name."</h2>, ";
						}

						$counter++;
					}
				}
			}
		?>
		</div>
		<hr />
	</div>

	<?php
	if (!$main_profile[0]->completed)
	{
		echo "<div class=\"sixteen columns\" id=\"profile_incomplete_notice\">\n";
			echo "<span>Profile Data Incomplete</span>\n";
		echo "</div>\n";
	}
	?>
	
	<!-- Description/Comments Column -->
	<div class="seven columns">
		
		<div class="comments">
		<p class="comments_header">General Description</p>
		<?php echo $main_profile[0]->general_description?>
		</div>

		<div class="comments">
		<p class="comments_header">Care</p>
		<?php echo $main_profile[0]->care_comments?>
		</div>

		<div class="comments">
		<p class="comments_header">Behavior</p>
		<?php echo $main_profile[0]->behavior_comments?>
		</div>

		<div class="comments">
		<p class="comments_header">Sexing</p>
		<?php echo $main_profile[0]->sexing?>
		</div>

		<div class="comments">
		<p class="comments_header">Breeding</p>
		<?php echo $main_profile[0]->breeding_comments?>
		</div>

	</div>

	<!-- Images and Specs Summary Column -->
	<div class="five columns">
		
		<?php 
			if (!empty($profile_images))
			{
				echo "<div class=\"profile_thumbs\">";
				
					foreach ($profile_images as $image_details)
					{
						$image_small_arr = explode(".",$image_details->image_name);
						$image_small = $image_small_arr[0]."_small.".$image_small_arr[1];

						echo "<div class=\"two columns thumbnail_container\">";
							echo "<a href=\"/uploads/".$image_details->image_name."\" class=\"swipebox\" title=\"".$image_details->comments."\"><img src=\"/uploads/".$image_small."\"></a>";
						echo "</div>";
					}
				
				echo "</div>";
			}
		?>

		<div class="profile_details">
			<table class="profile_summary">
				<tr>
					<th colspan=2>Profile Data Summary</th>
				</tr>
				<tr>
					<td>Category:</td><td class="summary_value"><?php echo $main_profile[0]->category?></td>
				</tr>
				<tr>
					<td>Family:</td><td class="summary_value"><?php echo $main_profile[0]->family_name?></td>
				</tr>
				<tr>
					<td>Eco-System:</td><td class="summary_value"><?php echo $main_profile[0]->system?></td>
				</tr>
				<tr>
					<td>Region:</td><td class="summary_value"><?php echo $region_string?></td>
				</tr>
				<tr>
					<td>Countries:</td><td class="summary_value"><?php echo $country_string?></td>
				</tr>
				<tr>
					<td>Diet:</td><td class="summary_value"><?php echo $main_profile[0]->diet?></td>
				</tr>
				<tr>
					<td>Activity:</td><td class="summary_value"><?php echo $main_profile[0]->activity?></td>
				</tr>
				<tr>
					<td>Colors:</td><td class="summary_value"><?php echo $main_profile[0]->colors?></td>
				</tr>
				<tr>
					<td>Markings:</td><td class="summary_value"><?php echo $main_profile[0]->markings?></td>
				</tr>
				<tr>
					<td>Algae Eater:</td><td class="summary_value"><?php echo $algae_eater?></td>
				</tr>
				<tr>
					<td>Schools:</td><td class="summary_value"><?php echo $schooler?></td>
				</tr>
				<tr>
					<td>Swim Region:</td><td class="summary_value"><?php echo $swim_region_string?></td>
				</tr>
				<tr>
					<td>Lifespan(yrs):</td><td class="summary_value"><?php echo $main_profile[0]->lifespan?></td>
				</tr>
				<tr>
					<td>Min Tank Size(gal):</td><td class="summary_value"><?php echo $main_profile[0]->min_tank_size?></td>
				</tr>
				<tr>
					<td>PH Level:</td><td class="summary_value"><?php echo $ph_range_string?></td>
				</tr>
				<tr>
					<td>DH Level:</td><td class="summary_value"><?php echo $dh_range_string?></td>
				</tr>
				<tr>
					<td>Temperature:</td><td class="summary_value"><?php echo $temp_range_string?></td>
				</tr>
				<tr>
					<td>Size (Max):</td><td class="summary_value"><?php echo $main_profile[0]->max_size?></td>
				</tr>
				<tr>
					<td>Size (Female):</td><td class="summary_value"><?php echo $main_profile[0]->max_size_female?></td>
				</tr>
				<tr>
					<td>Size (Male):</td><td class="summary_value"><?php echo $main_profile[0]->max_size_male?></td>
				</tr>
			</table>
		</div>

	</div>
	
	<!-- Ads and supplmentary content (article links, other site links, blurbs etc...) -->
	<div class="four columns">
		<!--<p class="description_header">General Description</p>
		<?php echo $main_profile[0]->general_description?>-->
	</div>

</div>