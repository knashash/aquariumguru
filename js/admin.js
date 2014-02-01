var profile_id = 0;

$(document).ready(function(){
		
		get_common_names(0); //populate drop down with full list of common names
		get_scientific_names(0); //populate drop down with full list of scientific
		populate_categories();
		populate_families();
		populate_eco_systems();
		populate_regions();
		populate_countries();
		
		//populate appropriate scientific names when common name selected
		$('#common_name').change(function()
		{
				$("#scientific_name").val($('#common_name').val());
				profile_id = $('#common_name').val();
		});

		//populate appropriate common names when scientific name selected
		$('#scientific_name').change(function()
		{
				$("#common_name").val($('#scientific_name').val());
				profile_id = $('#scientific_name').val();
		});

		$('#form_fish_search').submit(function()
		{
				var common_names_str = '';

				// clear any input values using the append feature
				$('#profile_images').empty();
				$('#regions_list').empty();
				$('#countries_list').empty();
				
				$.ajax({
				type: "POST",
				url: "/fish_profiles/get_profile/",
				data: {profile_id:profile_id},
				async: true,
				dataType: "json",
				success: function( data ) {
					//$.each(data, function (index, value) {
							
							$('#profile_id').val(data.main_profile[0].id);
							
							$('#scientific_name_e').val(data.main_profile[0].scientific_name);

							$.each(data.common_names, function(index,value) {
								if (common_names_str.length>1)
								{
									common_names_str += ', '+value.name;
								}
								else
								{
									common_names_str = value.name;
								}
							});
							$('#common_names').val(common_names_str);

							$.each(data.regions, function(index,value) {
								$('#regions_list').append('<li>'+value.region+'</li>');
							});

							$.each(data.countries, function(index,value) {
								$('#countries_list').append('<li>'+value.country+'</li>');
							});

							$('#category').val(data.main_profile[0].category_id);
							$('#family').val(data.main_profile[0].family_id);
							$('#eco_system').val(data.main_profile[0].eco_system_id);
							
							//$('#country').val(this.country);
							$('#tempermant').val(data.main_profile[0].tempermant);
							$('#diet').val(data.main_profile[0].diet);
							$('#colors').val(data.main_profile[0].colors);
							$('#markings').val(data.main_profile[0].markings);
							$('#activity').val(data.main_profile[0].activity);
							$('#algae_eating_rank').val(data.main_profile[0].algae_eating_rank);
							$('#schooler').val(data.main_profile[0].schooler);
							$('#lifespan').val(data.main_profile[0].lifespan);
							$('#max_size').val(data.main_profile[0].max_size);
							$('#min_tank_size').val(data.main_profile[0].min_tank_size);
							$('#max_size_female').val(data.main_profile[0].max_size_female);
							$('#max_size_male').val(data.main_profile[0].max_size_male);
							$('#temp_high').val(data.main_profile[0].temp_high);
							$('#temp_low').val(data.main_profile[0].temp_low);
							$('#dh_high').val(data.main_profile[0].dh_high);
							$('#dh_low').val(data.main_profile[0].dh_low);
							$('#ph_high').val(data.main_profile[0].ph_high);
							$('#ph_low').val(data.main_profile[0].ph_low);
							$('#care_difficulty_rank').val(data.main_profile[0].care_difficulty_rank);
							$('#breeding_difficulty_rank').val(data.main_profile[0].breeding_difficulty_rank);

							if (data.main_profile[0].swim_region_bottom == 1) $('#swim_region_b').prop('checked', true);
							if (data.main_profile[0].swim_region_top == 1) 
							{
								$('#swim_region_t').prop('checked', true);
							}
							if (data.main_profile[0].swim_region_middle == 1) $('#swim_region_m').prop('checked', true);

							var image_count = 0;
							var image_comment = '';
							$.each(data.profile_images, function(index,value) {
								
								image_comment = value.comments;
								image_id = value.id;
								
								// truncate the image comments for display in the main admin area
								var allowed_length = 18;
								var truncated_comment = image_comment;
								if (image_comment.length > allowed_length)
								{
									truncated_comment = image_comment.substring(0,allowed_length)+'...';
								}

								image_count++;

								$('#profile_images').append('<li><a href=\'/admin/edit_image?image_id='+image_id+'\' target=\'_blank\'>image'+image_count+'</a> '+truncated_comment+'</li>');
							});
					//});
				}	
			});

			
			var other_comments = '';
			var breeding_comments = '';
			var general_comments = '';
			var behavior_comments = '';
			var care_comments = '';
			var sexing_comments = ''
			$.ajax({
				type: "POST",
				url: "/admin/get_comments/",
				data: {profile_id:profile_id},
				async: true,
				dataType: "json",
				success: function( data ) {
						var commentsObj = data[0];
						
						
						//============= BREEDING =============================
						if (commentsObj.BreedingComments)
						{
							breeding_comments += commentsObj.BreedingComments+"<br>";
						}
						if (commentsObj.breeding_comments)
						{
							breeding_comments += commentsObj.breeding_comments+"<br>";
						}


						//============= SEXING =============================
						if (commentsObj.Sexing)
						{
							sexing_comments += commentsObj.Sexing+"<br>";
						}
						if (commentsObj.sexing)
						{
							sexing_comments += commentsObj.sexing+"<br>";
						}


						//============= CARE AND DIET =============================
						if (commentsObj.care_comments)
						{
							care_comments += commentsObj.care_comments+"<br>";
						}

						if (commentsObj.Tank)
						{
							care_comments += commentsObj.Tank+"<br>";
						}

						if (commentsObj.Food)
						{
							care_comments += commentsObj.Food+"<br>";
						}

						if (commentsObj.diet_comments)
						{
							care_comments += commentsObj.diet_comments+"<br>";
						}

						
						//============= GENERAL/PHYSICAL DESCRIPTION =============================
						if (commentsObj.Description)
						{
							general_comments += commentsObj.Description+"<br>";
						}
						
						if (commentsObj.OtherComments)
						{
							general_comments += commentsObj.OtherComments+"<br>";
						}

						if (commentsObj.OtherComments2)
						{
							general_comments += commentsObj.OtherComments2+"<br>";
						}

						if (commentsObj.comments)
						{
							general_comments += commentsObj.comments+"<br>";
						}

						if (commentsObj.Habitat)
						{
							general_comments += commentsObj.Habitat+"<br>";
						}
						
						if (commentsObj.eco_system_comments)
						{
							general_comments += commentsObj.eco_system_comments+"<br>";
						}

						if (commentsObj.origin_comments)
						{
							general_comments += commentsObj.origin_comments+"<br>";
						}
						
						if (commentsObj.Size)
						{
							general_comments += "Size: "+commentsObj.Size+"<br>";
						}
						
						if (commentsObj.colors)
						{
							general_comments += "Colors: "+commentsObj.colors+"<br>";
						}
						
						if (commentsObj.markings)
						{
							general_comments += "Markings: "+commentsObj.markings+"<br>";
						}

						if (commentsObj.mouth)
						{
							general_comments += "Mouth: "+commentsObj.mouth+"<br>";
						}

						if (commentsObj.tail)
						{
							general_comments += "Tail: "+commentsObj.tail+"<br>";
						}

						
						//============= BEHAVIOR =============================
						if (commentsObj.SocialBehavior)
						{
							behavior_comments += commentsObj.SocialBehavior+"<br>";
						}

						if (commentsObj.activity)
						{
							behavior_comments += commentsObj.activity+"<br>";
						}
						
						if (commentsObj.tempermant_comments)
						{
							behavior_comments += commentsObj.tempermant_comments+"<br>";
						}

						if (commentsObj.SwimRegion)
						{
							behavior_comments += "Swim Region: "+commentsObj.SwimRegion+"<br>";
						}
						
						
						if (general_comments)
						{
							other_comments += "<h3>Description:</h3> "+general_comments+"<br><br>";
						}
						if (sexing_comments)
						{
							other_comments += "<h3>Sexing:</h3> "+sexing_comments+"<br><br>";
						}
						if (behavior_comments)
						{
							other_comments += "<h3>Social Behavior:</h3> "+behavior_comments+"<br><br>";
						}
						if (care_comments)
						{
							other_comments += "<h3>Care:</h3> "+care_comments+"<br><br>";
						}
						if (breeding_comments)
						{
							other_comments += "<h3>Breeding:</h3> "+breeding_comments+"<br><br>";
						}

						$('#comments_section').html(other_comments);
				}	
			});

			return false;
		});



		$( "#fish_profile_form" ).submit(function( event ) {
		  
			var profile_data = $("#fish_profile_form").serializeArray();

			$.ajax({
				type: "POST",
				url: "/fish_profiles/update_profile/",
				data: {profile_data:profile_data},
				dataType: "json",
				success: function(data) {
                //var obj = jQuery.parseJSON(data); if the dataType is not specified as json uncomment this
                // do what ever you want with the server response
				}
			});

			event.preventDefault();
		});

		
		$( "#upload_images" ).click(function( event ) {
		  
			var url = '/admin/upload?profile_id='+profile_id;
			var windowName = 'Image Uploader';

			window.open(url,"_blank","toolbar=no, scrollbars=yes, resizable=yes, top=100, left=500, width=400, height=400");

			event.preventDefault();
		});

		$( "#edit_countries" ).click(function( event ) {
		  
			var url = '/admin/edit_countries?profile_id='+profile_id;
			var windowName = 'Edit Countries';

			window.open(url,"_blank","toolbar=no, scrollbars=yes, resizable=yes, top=100, left=500, width=400, height=400");

			event.preventDefault();
		});

		$( "#edit_regions" ).click(function( event ) {
		  
			var url = '/admin/edit_regions?profile_id='+profile_id;
			var windowName = 'Edit Regions';

			window.open(url,"_blank","toolbar=no, scrollbars=yes, resizable=yes, top=100, left=500, width=400, height=400");

			event.preventDefault();
		});
	
});


/**
  * @desc retrieve a list of common names and populate the dropdown
  * @param int profile_id - the profile id of the fish
  * @return void
*/ 
function get_common_names(profile_id)
{
		var dd_common_name = $("#common_name");
	
		dd_common_name.empty();
		dd_common_name.append($("<option />").val(0).text('')); 
		
		$.ajax({
				type: "POST",
				url: "/admin/get_common_names/",
				data: {profile_id:profile_id},
				async: true,
				dataType: "json",
				success: function( data ) {
					$.each(data, function (index) {
						dd_common_name.append($("<option />").val(this.profile_id).text(this.name));
					});
					if (profile_id) $("#common_name").val(profile_id);
				}	
		});
}


/**
  * @desc retrieve a list of scientific names and populate the dropdown
  * @param int profile_id - the profile id of the fish
  * @return void
*/ 
function get_scientific_names(profile_id)
{
	var dd_scientific_name = $("#scientific_name");
	
	dd_scientific_name.empty();
	dd_scientific_name.append($("<option />").val(0).text('')); 
	
	$.ajax({
				type: "POST",
				url: "/admin/get_scientific_names/",
				data: {profile_id:profile_id},
				async: true,
				dataType: "json",
				success: function( data ) {
					var dd_scientific_name = $("#scientific_name");
					$.each(data, function (index) {
						dd_scientific_name.append($("<option />").val(this.id).text(this.scientific_name));
					});
				}
				
		});
}


/**
  * @populate the categories drop down list
  * @return void
*/ 
function populate_categories()
{
	var dd_categories = $("#category");
	
	dd_categories.empty();
	dd_categories.append($("<option />").val(0).text('')); 
	
	$.ajax({
				type: "POST",
				url: "/admin/get_categories/",
				async: true,
				dataType: "json",
				success: function( data ) {
					$.each(data, function (index) {
						dd_categories.append($("<option />").val(this.id).text(this.category));
					});
				}
				
		});
}

/**
  * @populate the families drop down list
  * @return void
*/ 
function populate_families()
{
	var dd_family = $("#family");
	
	dd_family.empty();
	dd_family.append($("<option />").val(0).text('')); 
	
	$.ajax({
				type: "POST",
				url: "/admin/get_families/",
				async: true,
				dataType: "json",
				success: function( data ) {
					$.each(data, function (index) {
						dd_family.append($("<option />").val(this.id).text(this.family_name));
					});
				}
				
		});
}


/**
  * @populate the eco systems drop down list
  * @return void
*/ 
function populate_eco_systems()
{
	var dd_eco_system = $("#eco_system");
	
	dd_eco_system.empty();
	dd_eco_system.append($("<option />").val(0).text('')); 
	
	$.ajax({
				type: "POST",
				url: "/admin/get_eco_systems/",
				async: true,
				dataType: "json",
				success: function( data ) {
					$.each(data, function (index) {
						dd_eco_system.append($("<option />").val(this.id).text(this.system));
					});
				}
				
		});
}


/**
  * @populate the regions multi select box
  * @return void
*/ 
function populate_regions()
{
	var dd_regions = $("#regions");
	
	dd_regions.empty();
	
	$.ajax({
				type: "POST",
				url: "/admin/get_regions/",
				async: true,
				dataType: "json",
				success: function( data ) {
					$.each(data, function (index) {
						dd_regions.append($("<option />").val(this.id).text(this.region));
					});
				}
				
		});
}

/**
  * @populate the countries multi select box
  * @return void
*/ 
function populate_countries()
{
	var dd_countries = $("#countries");
	
	dd_countries.empty();
	
	$.ajax({
				type: "POST",
				url: "/admin/get_countries/",
				async: true,
				dataType: "json",
				success: function( data ) {
					$.each(data, function (index) {
						dd_countries.append($("<option />").val(this.id).text(this.country));
					});
				}
				
		});
}