<!doctype html>
<html lang="en">
  <head>
	<?php 
		include('head.phtml');
	?>
    <title>Signin</title>
    <link href="styles/signin.css" rel="stylesheet">
  </head>
  <body>
	<?php 
		include('alert.phtml');
	?>
	<div class="text-center">
		<form class="form-signin" method="post" action="/login">
		  <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
		  <label for="inputLogin" class="sr-only">Login</label>
		  <input type="text" id="inputLogin" name="login" class="form-control" placeholder="Login"  autofocus>
		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" >
		  <div class="checkbox mb-3">
			<label>
			  <input type="checkbox" name="login-checkbox" value="remember-me"> Remember me
			</label>
		  </div>
		  <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		  <br>
		  <p><a href="/register">Sign up</a></p>
		</form>
	</div>
</body>
</html>
