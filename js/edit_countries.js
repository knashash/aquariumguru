$(document).ready(function(){
		
		var profile_id = $('#profile_id').val();
		
		// update the image comments
		$("#edit_countries_form").submit(function( event ) {
			
			var selected_countries = new Array();
			$('#checkboxes input:checked').each(function() {
				selected_countries.push($(this).attr('value'));
			});

			var update_countries_request = $.ajax({
				type: "POST",
				url: "/admin/update_countries/",
				data: {profile_id:profile_id,countries_arr:selected_countries}
			});

			update_countries_request.done(function( msg ) {
				alert( 'countries successfully updated' );
			});

			event.preventDefault();
		});
});