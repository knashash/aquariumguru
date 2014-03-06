<div id="profile_container">
	
	<div class="sixteen columns">
		<h1><?php echo $main_profile[0]->scientific_name?></h1>
		<hr />
	</div>
	
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
		
		<div class="profile_thumbs">
		<?php
			foreach ($profile_images as $image_details)
			{
				echo "<div class=\"two columns thumbnail_container\">";
					echo "<img src=\"/uploads/".$image_details->image_small."\">";
				echo "</div>";
			}
		?>
		</div>

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
					<td>PH Level:</td><td class="summary_value"><?php echo $main_profile[0]->ph_low?> - <?php echo $main_profile[0]->ph_high?></td>
				</tr>
				<tr>
					<td>DH Level:</td><td class="summary_value"><?php echo $main_profile[0]->dh_low?> - <?php echo $main_profile[0]->dh_high?></td>
				</tr>
				<tr>
					<td>Temperature:</td><td class="summary_value"><?php echo $main_profile[0]->temp_low?> - <?php echo $main_profile[0]->temp_high?></td>
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