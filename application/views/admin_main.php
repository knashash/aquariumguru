<div class="sixteen columns">
	<h1 class="remove-bottom" style="margin-top: 40px">MAIN ADMIN SECTION</h1>
	<hr />

	<form id="form_fish_search">
		Needs Text: <input type="checkbox" name="needs_text" id="needs_text">
		Needs Images: <input type="checkbox" name="needs_images" id="needs_images"><br>

			Common Name:
			<select name="common_name" id="common_name" class="side_by_side">
			</select>

			Scientific Name:
			<select name="scientific_name" id="scientific_name" class="side_by_side">
			</select>

		<input type="submit" value="Submit">
	</form>
</div>


<div class="nine columns">
	<form class="custom" id="fish_profile_form">
		<input type="hidden" name="id" id="profile_id">
		<div class="side_by_side">
			<label for="scientific_name_e">Scientific Name:</label>
			<input type="text" id="scientific_name_e" disabled>
		</div>
		<div class="side_by_side">
			<label for="common_names">Common Name(s):</label>
			<textarea id="common_names" disabled></textarea>
		</div>
		<div class="side_by_side">
			<label for="profile_images">Profile Images: <a href="/admin/upload" target="_blank" id="upload_images">(upload)</a></label>
			<ul id="profile_images">

			</ul>
		</div>
		<br>

		<div>
			<label>General Description:</label>
			<textarea id="general_description" name="general_description"></textarea>
		</div>
		<br>

		<div>
			<label>Care/Diet</label>
			<textarea id="care_comments" name="care_comments"></textarea>
		</div>
		<br>

		<div>
			<label>Behavior:</label>
			<textarea id="behavior_comments" name="behavior_comments"></textarea>
		</div>
		<br>

		<div>
			<label>Breeding:</label>
			<textarea id="breeding_comments" name="breeding_comments"></textarea>
		</div>
		<br>

		<div>
			<label>Sexing:</label>
			<textarea id="sexing" name="sexing"></textarea>
		</div>
		<br>

		<div class="side_by_side">
			<label for="category">Category:</label>
			<select name="category" id="category"></select>
		</div>
		<div class="side_by_side">
			<label for="family">Family:</label>
			<select name="family" id="family"></select>
		</div>
		<div class="side_by_side">
			<label for="eco_system">Eco System:</label>
			<select name="eco_system" id="eco_system"></select>
		</div>
		<br>
		<div class="side_by_side">
			<label for="region">Region: <a href="#" id="edit_regions">edit</a></label>
			<ul id="regions_list">
			</ul>
		</div>
		<div class="side_by_side">
			<label for="countries">Country: <a href="#" id="edit_countries">edit</a></label>
			<ul id="countries_list">
			</ul>
		</div>
		<br>
		<div class="side_by_side">
			<label for="diet">Diet:</label>
			<select name="diet" id="diet">
				<option value=""/>
				<option value="omnivore"/>Omnivore
				<option value="carnivore"/>Carnivore
				<option value="herbivore"/>Herbivore
			</select>
		</div>
		<div class="side_by_side">
			<label for="activity">Activity:</label>
			<select name="activity" id="activity">
				<option value=""/>
				<option value="diurnal"/>Diurnal
				<option value="nocturnal"/>Nocturnal
				<option value="both"/>both
			</select>
		</div>
		<div class="side_by_side">
			<label for="tempermant">Tempermant:</label>
			<select name="tempermant" id="tempermant">
				<option value=""/>
				<option value="peaceful"/>Peaceful
				<option value="semi-aggressive"/>Semi-Aggressive
				<option value="Aggressive"/>Aggressive
				<option value="highly aggressive"/>Highly Aggressive
			</select>
		</div>
		<div class="side_by_side">
			<label for="breeding_difficulty_rank">Breeding Diff:</label>
			<select name="breeding_difficulty_rank" id="breeding_difficulty_rank">
				<?php
					for ($i=0;$i<11;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
				?>
			</select>
		</div>
		<div class="side_by_side">
			<label for="care_difficulty_rank">Care Diff:</label>
			<select name="care_difficulty_rank" id="care_difficulty_rank">
				<?php
					for ($i=0;$i<11;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
				?>
			</select>
		</div>
		<br>
		<div class="side_by_side">
			<label for="colors">Colors:</label>
			<input type="text" name="colors" id="colors">
		</div>
		<div class="side_by_side">
			<label for="markings">Markings:</label>
			<input type="text" name="markings" id="markings">
		</div>
		<br>
		<div class="side_by_side">
			<label for="algae_eating_rank">Algae Rank:</label>
			<select name="algae_eating_rank" id="algae_eating_rank">
				<?php
					for ($i=0;$i<11;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
				?>
			</select>
		</div>
		<div class="side_by_side">
			<label for="schooler">Schools:</label>
			<select name="schooler" id="schooler">
				<option value="">
				<option value=0>No
				<option value=1>Yes
			</select>
		</div>
		<div class="side_by_side">
			<label for="">Swim Regions:</label>
			B: <input type="checkbox" id="swim_region_b" name="swim_region_bottom"> M: <input type="checkbox" id="swim_region_m" name="swim_region_middle"> T: <input type="checkbox" id="swim_region_t" name="swim_region_top">
		</div>
		<br>
		<div class="side_by_side">
			<label for="lifespan">Lifespan:</label>
			<select name="lifespan" id="lifespan">
				<?php
					for ($i=0;$i<50;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
				?>
			</select>
		</div>
		<div class="side_by_side">
			<label for="min_tank_size">Min Tank Size:</label>
			<select name="min_tank_size" id="min_tank_size">
			<?php
					for ($i=0;$i<100;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select>
		</div>
		<br>
		<div class="side_by_side">
			<label for="">PH Level:</label>
			Low: 
			<select name="ph_low" id="ph_low" class="side_by_side">
				<?php
					for ($i=0;$i<20;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select> 
			- High: 
			<select name="ph_high" id="ph_high" class="side_by_side">
				<?php
					for ($i=0;$i<40;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select>
		</div>
		<div class="side_by_side">
			<label for="">DH Level:</label>
			Low: <select name="dh_low" id="dh_low" class="side_by_side">
			
			<?php
					for ($i=0;$i<20;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select> - High: <select name="dh_high" id="dh_high" class="side_by_side">
			
			<?php
					for ($i=0;$i<40;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select>
		</div>
		<br>
		<div class="side_by_side">
			<label for="">Temp Tolerance:</label>
			Low: <select name="temp_low" id="temp_low" class="side_by_side">
			<?php
					for ($i=0;$i<100;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select> - High: <select name="temp_high" id="temp_high" class="side_by_side">
			<?php
					for ($i=0;$i<120;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select>
		</div>
		<div class="side_by_side">
			<label for="">Size:</label>
			Max: <select name="max_size" id="max_size" class="side_by_side">
			<?php
					for ($i=0;$i<120;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select> Male:<select name="max_size_male" id="max_size_male" class="side_by_side">
			<?php
					for ($i=0;$i<120;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select> Female:<select name="max_size_female" id="max_size_female" class="side_by_side">
			<?php
					for ($i=0;$i<120;$i++)
					{
						echo "<option value=$i>$i\r\n";
					}
			?>
			</select>
		</div>
</div>

<div class="seven columns" id="comments_section">
</div>


<div class="sixteen columns">
	<input type="submit">
</div>

</form>

