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
		<?php
			foreach ($profile_images as $image_details)
			{
				echo "<div class=\"two columns thumbnail_container\">";
					echo "<img src=\"/uploads/".$image_details->image_small."\">";
				echo "</div>";
			}
		?>

		<div class="five columns profile_details">
			<table>
				<tr>
					<th>Profile Data Summary</th>
				</tr>
				<tr>
					<td>Category</td><td>African Cichlids</td>
				</tr>
				<tr>
					<td>Family</td><td>Cichlidae</td>
				</tr>
				<tr>
					<td>Eco-System</td><td>Stream</td>
				</tr>
				<tr>
					<td>Region</td><td>Sub-Saharan Africa</td>
				</tr>
				<tr>
					<td>Countries</td><td>Congo</td>
				</tr>
				<tr>
					<td>Diet</td><td>Omnivore</td>
				</tr>
				<tr>
					<td>Activity</td><td>Diurnal</td>
				</tr>
				<tr>
					<td>Colors</td><td>Gray, Brown</td>
				</tr>
				<tr>
					<td>Markings</td><td>Striped</td>
				</tr>
				<tr>
					<td>Algae Eater</td><td>No</td>
				</tr>
				<tr>
					<td>Schools</td><td>No</td>
				</tr>
				<tr>
					<td>Swim Region</td><td>Bottom</td>
				</tr>
				<tr>
					<td>Lifespan</td><td>Unknown</td>
				</tr>
				<tr>
					<td>Min Tank Size</td><td>20 Gallons</td>
				</tr>
				<tr>
					<td>PH Level</td><td>6-8</td>
				</tr>
				<tr>
					<td>DH Level</td><td>2-20</td>
				</tr>
				<tr>
					<td>Temperature</td><td>75-88</td>
				</tr>
				<tr>
					<td>Size (Max)</td><td>12cm</td>
				</tr>
				<tr>
					<td>Size (Female)</td><td>8cm</td>
				</tr>
				<tr>
					<td>Size (Male)</td><td>12cm</td>
				</tr>
			</table>
		</div>

	</div>
	
	<!-- Images and Specs Summary Column -->
	<div class="four columns">
		<p class="description_header">General Description</p>
		<?php echo $main_profile[0]->general_description?>
	</div>

</div>