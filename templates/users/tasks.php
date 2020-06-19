<?php
session_start();
?>

<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">	
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="../../styles/to-do.css" rel="stylesheet">
    <title>to-do</title>
  </head>
  <body>
  
	<header>
	  <div class="user-info">
		<span>User: </span>
		<span><?= $_SESSION['session_login'] ?></span>
	  </div>
	  <div>
		<a href="/logout" style="color: white">Sign out</a>
	  </div>
	</header>

    <div class="wrapper">
		<div class="title">
		  <h1>To-do List</h1>
		</div>

		<div class="task">
		  <div class="task-text">Одна из двух колонок</div>
		  <div class="btns"> 
			<div class="btn-group-toggle done" data-toggle="buttons">
				<label class="btn btn-outline-success">
					<input type="checkbox" data-toggle="buttons"><i class="fa fa-check" aria-hidden="true"></i>
				</label>
			</div>
			<a href="#" class="btn btn-outline-warning" role="button" aria-pressed="true">
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
			<a href="#" class="btn btn-outline-danger" role="button" aria-pressed="true">
				<i class="fa fa-trash" aria-hidden="true"></i>
			</a>
		  </div>
		</div>
		
		<div class="task">
		  <div class="task-text">Одна из двух колонок</div>
		  <div class="btns"> 
			<div class="btn-group-toggle done" data-toggle="buttons">
				<label class="btn btn-outline-success">
					<input type="checkbox" data-toggle="buttons"><i class="fa fa-check" aria-hidden="true"></i>
				</label>
			</div>
			<a href="#" class="btn btn-outline-warning" role="button" aria-pressed="true">
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
			<a href="#" class="btn btn-outline-danger" role="button" aria-pressed="true">
				<i class="fa fa-trash" aria-hidden="true"></i>
			</a>
		  </div>
		</div>
		
		<div class="form-container">
			<form class="add-form">
			  <div class="text-aria">	
				<label for="txt" class="sr-only">Text</label>
				<input type="text" class="form-control txt" id="txt" placeholder="Text">
			  </div>
			  <button type="submit" class="btn btn-primary add">Add</button>
			</form>
		</div>
	</div>


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
  </body>
</html>