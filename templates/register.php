<!doctype html>
<html lang="en">
  <head>
	<?php 
		include('head.phtml');
	?>
    <title>Sign up</title>

    <link href="styles/signup.css" rel="stylesheet">
  </head>
  <body>
  	<?php 
		include('alert.phtml');
	?>
	<div class="text-center">
		<form class="form-signup" method="post" action="/register">
		  <h1 class="h3 mb-3 font-weight-normal">Create your account</h1>
		  <label for="inputLogin" class="sr-only">Login</label>
		  <input type="text" name="login" id="inputLogin" class="form-control" placeholder="Login" required>
		  <br>
		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
		  <div class="checkbox mb-3">

		  </div>
		  <button class="btn btn-lg btn-success btn-block" name= "register" type="submit">Create account</button>
		  <br>
		  <p><a href="/login">Back</a></p>
		</form>
	</div>
</body>
</html>