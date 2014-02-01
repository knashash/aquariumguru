$(document).ready(function(){
		
		var profile_id = $('#profile_id').val();
		
		// update the image comments
		$("#edit_regions_form").submit(function( event ) {
			
			var selected_regions = new Array();
			$('#checkboxes input:checked').each(function() {
				selected_regions.push($(this).attr('value'));
			});

			var update_regions_request = $.ajax({
				type: "POST",
				url: "/admin/update_regions/",
				data: {profile_id:profile_id,regions_arr:selected_regions}
			});

			update_regions_request.done(function( msg ) {
				alert( 'regions successfully updated' );
			});

			event.preventDefault();
		});
});