$(document).ready(function(){
		
		// declare image id for global use
		var image_id = $('#image_id').val();
		
		// update the image comments
		$( "#edit_image_form" ).submit(function( event ) {
			
			var image_comments = $('#image_comments').val();

			var update_image_request = $.ajax({
				type: "POST",
				url: "/admin/update_image/",
				data: {image_id:image_id,image_comments:image_comments}
			});

			update_image_request.done(function( msg ) {
				alert( 'image successfully updated' );
			});

			event.preventDefault();
		});

		// delete the image (mark as inactive)
		$( "#delete_image" ).click(function( event ) {

			var r = confirm( "Sure you want to delete this image?" );
			if (r == true)
			{
				var delete_image_request = $.ajax({
					type: "POST",
					url: "/admin/delete_image/",
					data: {image_id:image_id}
				});

				delete_image_request.done(function( msg ) {
					alert( 'image has been marked for deletion' );
				});
			}

			event.preventDefault();
		});
});