$(document).ready(function(){

				$('#admin_login_form').submit(function(e) {

								var username = $('#username').val();
								var password = $('#password').val();
								$.ajax({
													type: "POST",
													url: "/admin/validate_login",
													data: {username:username,password:password},
													dataType: "json",
													success: function(data) {
														var url = "/admin"; 
														$(location).attr('href',url);
													},
													error: function(data) {
														$('#alert_box').show();
														$('#alert_box').addClass('alert_error');
														$('#alert_box').html(data.responseText);
													}
												})

								e.preventDefault();           
				});

								$('#forgot_password').click(function(e) {
								var username = $('#username').val();
								$.ajax({
													type: "POST",
													url: "/users/send_password_reset_link",
													data: {username:username},
													dataType: "json"
												}).success(function( data ) {
																$('#login-alert').show();
																$('#login-alert').removeClass('login-error');
																$('#login-alert').addClass('password-reset');
														$('#login-alert').html('Password reset link sent. Please check your email to continue.');
												}).fail(function( data ) {
													$('#login-alert').show();
													$('#login-alert').removeClass('password-reset');
													$('#login-alert').addClass('login-error');
													$('#login-alert').html(data.responseText);
												});

								e.preventDefault();
				});

				$('#log_out').click(function(e) {
								$.ajax({
													type: "POST",
													url: "/users/logout",
													dataType: "json"
												}).success(function( data ) {
																var url = "/";    
																$(location).attr('href',url);
												}).fail(function( data ) {
													
												});

								e.preventDefault();
				});
});