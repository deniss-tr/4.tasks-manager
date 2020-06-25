<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>admin panel</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/dashboard/">
    <!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


    <!-- Custom styles for this template -->
    <link href="../../styles/dashboard.css" rel="stylesheet">
  </head>
  <body>

<header>
  <div class="user-info">
	<span>User: </span>
	<span><?= $_SESSION['session_login'] ?></span>
	<span id="user-id"><?= $_SESSION["session_user_id"] ?></span>
  </div>
  <div>
	<a href="/logout" style="color: white">Sign out</a>
  </div>
</header>

	<div class="wrapper">
		<nav id="sidebarMenu" class="col-md-3 col-lg-2">
		  <div class="sidebar-sticky pt-3">
			<ul class="nav flex-column">
			  <li class="nav-item">
				<a class="nav-link" href="/admin">
				  <span data-feather="users"></span>
				  Users list
				</a>
			  </li>

			  <li class="nav-item">
				<a class="nav-link" href="/tasks">
				  <span data-feather="file"></span>
				  My tasks
				</a>
			  </li>
			</ul>
		  </div>
		</nav>

		<main role="main" class="col-md-9 col-lg-10">
		<?php include "tasks-table.phtml" ?>
		</main>
	</div>
	


    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="../../js/dashboard.js"></script>
</body>
</html>
