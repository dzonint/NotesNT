<?php 
    require 'admin/database.php';
    !empty($_SESSION['logged_in']) ? header("Location: notes.php") : $a = 1;
?> 
<!doctype html>

<html>
	<head>
		<title>NotesNT</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
        <link rel="icon" href="img/icon.png">  
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <link href="css/login.css" rel="stylesheet">
	</head>

	<body>  
    <?php include("modules/navbar.php"); ?>  
    <div class="container">
    	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-login">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-6">
								<a href="#" class="active" id="login-form-link">Login</a>
							</div>
							<div class="col-xs-6">
								<a href="#" id="register-form-link">Register</a>
							</div>
						</div>
						<hr>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-lg-12">
                                <!-- Login form. -->
								<form id="login-form" method="post" role="form" style="display: block;">
									<div class="form-group">
										<input type="text" name="login-username" id="login-username" tabindex="1" class="form-control" placeholder="Username" required>
									</div>
									<div class="form-group">
										<input type="password" name="login-password" id="login-password" tabindex="2" class="form-control" placeholder="Password" required>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="button" name="login-submit" id="login-submit" tabindex="3" class="form-control btn btn-login" value="Login">
											</div>
										</div>
									</div>
								</form>
                                
                                <!-- Register form. -->
								<form id="register-form" action="admin/controller.php" method="post" role="form" style="display: none;">
									<div class="form-group">
										<input type="text" name="username" id="reg-username" tabindex="1" class="form-control" placeholder="Username" value="" required>
									</div>
									<div class="form-group">
										<input type="email" name="email" id="reg-email" tabindex="1" class="form-control" placeholder="E-mail address" value="" required>
									</div>
									<div class="form-group">
										<input type="password" name="password" id="reg-password" tabindex="2" class="form-control pwd"  placeholder="Password" required>
									</div>
									<div class="form-group">
										<input type="password" name="confirm-password" id="confirm-password" tabindex="2" class="form-control pwd" placeholder="Confirm password" required>
									</div>
									<div class="form-group">
                                        <div class="row">
											<div class="col-sm-6 col-sm-offset-3" id="message" style="text-align:center;color:red;">
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-sm-offset-3">
												<input type="button" name="register-submit" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Register">
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</body>
    
    <script>
    // Show login.
    $('#login-form-link').click(function(e) {
		$("#login-form").delay(100).fadeIn(100);
 		$("#register-form").fadeOut(100);
		$('#register-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
    
    // Show register.
	$('#register-form-link').click(function(e) {
		$("#register-form").delay(100).fadeIn(100);
 		$("#login-form").fadeOut(100);
		$('#login-form-link').removeClass('active');
		$(this).addClass('active');
		e.preventDefault();
	});
   

// Response in the functions below contains variables status_code and status_message. status_code = 0 means OK.
function checkUsername() {    
    var username = $('#reg-username').val();
    if(username.length == 0){
       $('#reg-username').removeClass('ok').addClass('error');
       $("#message").html('<small>Enter a username.</small><br>');
       return;
    }
    $.ajax({
        url: "admin/controller.php?check-username="+username,
        method: "GET",
        success: function(response) {
            var object = JSON.parse(response);
            if(object.status_code != 0) {
                $('#reg-username').removeClass('ok').addClass('error');
                $("#message").html('<small>'+object.status_message+'</small><br>');
            } else {
                $('#reg-username').removeClass('error').addClass('ok');
                $("#message").html('');
            }
        }
    });
}
    
function checkEmail() {    
    var email = $('#reg-email').val();
    if((email.length == 0) || (email.indexOf("@") == -1)){
       $('#reg-email').removeClass('ok').addClass('error');
       $("#message").html('<small>Enter a valid e-mail address.</small><br>');
       return;
    }
    $.ajax({
        url: "admin/controller.php?check-email="+email,
        method: "GET",
        success: function(response) { 
            var object = JSON.parse(response);
            if(object.status_code != 0) {
                $('#reg-email').removeClass('ok').addClass('error');
                $("#message").html('<small>'+object.status_message+'</small><br>');
            } else {
                $('#reg-email').removeClass('error').addClass('ok');
                $("#message").html('');
            }
        }
    });
}    

function checkPasswords() {
    var pass = $('#reg-password').val();
    var repass = $('#confirm-password').val();
    if(pass.length == 0){
       $('#reg-password').removeClass('ok').addClass('error');
       $("#message").html('<small>Enter a password.</small><br>');
       return;
    }
    else if(repass.length == 0){
       $('#confirm-password').removeClass('ok').addClass('error');
       $("#message").html('<small>Confirm your password.</small><br>');
       return;
    }
    else if (pass != repass) {
        $('#reg-password').removeClass('ok').addClass('error');
        $('#confirm-password').removeClass('ok').addClass('error');
        $("#message").html('<small>Passwords do not match.</small><br>');
    }
    else {
        $('#reg-password').removeClass('error').addClass('ok');
        $('#confirm-password').removeClass('error').addClass('ok');
        $("#message").html('');
    }
}
    
function registerAccount(){
    checkUsername;
    checkEmail;
    checkPasswords;
    if($('#reg-username').hasClass('ok') && $('#reg-email').hasClass('ok') && $('.pwd').hasClass('ok'))
        {
           $.ajax({
                    url: "admin/controller.php",
                    data: {create_author : 1,
                           username : $('#reg-username').val(),
                           password : $('#reg-password').val(),
                           email : $('#reg-email').val()},
                    method: "POST",
                    success: function(response) {
                        var object = JSON.parse(response);
                        if(object.status_code != 0)
                            alert(object.status_message);
                        else {
                            alert("Registration complete.");
                            location.reload();
                        }
                    }
                }); 
        }
    else
        $("#message").html('<small>Please fill in all fields.</small><br>');
}
    
function Login(){
    $.ajax({
            url: "admin/controller.php",
            data: { login : 1,
                    username : $('#login-username').val(),
                    password : $('#login-password').val()},
            method: "POST",
            success: function(response) {
                var object = JSON.parse(response);
                if(object.status_code != 0)
                    alert(object.status_message);
                else
                    window.location.href = "notes.php";
            }
            });
}    

    // Blur event is sent to an element when it loses focus.
    $('#reg-username').blur(checkUsername);
    $('#reg-email').blur(checkEmail);    
    $('.pwd').blur(checkPasswords);
    $('#register-submit').click(registerAccount);
    $('#login-submit').click(Login);
    $("#message").html('<small>Please enter all fields.</small><br>');

</script>

</html>