<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="author" content="Dimitar Minchev">
<title>SPOJ</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="assets/bootstrap.min.css" >
<link rel="stylesheet" href="assets/bootstrap-theme.min.css">
<link rel="stylesheet" href="assets/bootstrap-table.min.css">
<style>body { padding-top: 50px; }</style>
<!-- TODO: google recapcha api
<script src="https://www.google.com/recaptcha/api.js"></script>
-->
</head>
<body>

<!-- Навигация -->
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Навигация</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
	  <a class="navbar-brand" href="#">SPOJ</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Състезания</a></li>
            <li><a href="submit.php">Решение</a></li>
            <li><a href="status.php">Статус</a></li>
            <li class="active"><a href="register.php">Регистрация</a></li>
          </ul>
        </div>
      </div>
</nav>

<!-- Основно съдържание -->
<div class="container">


<?php
// init
include("init.php");

// POST
if($_SERVER['REQUEST_METHOD']=='POST')
{
	// data
	$user = $conn->real_escape_string($_REQUEST["user"]);
	$pass = md5($conn->real_escape_string($_REQUEST["password"]));
	$name = $conn->real_escape_string($_REQUEST["name"]);
	$email = "email:".$conn->real_escape_string($_REQUEST["email"]);
	// sql and execute
	$sql = "INSERT INTO spoj0.users (name, pass_md5, display_name, about) VALUES ('$user','$pass','$name','$email')";
	$result = $conn->query($sql); 
	// message
	if($result) echo "<div class='jumbotron alert-success'><h1>Регистрация</h1><p>Потребителят е регистриран успешно.</p></div>";
	else echo "<div class='jumbotron alert-danger'><h1>Регистрация</h1><p>Възникна проблем при регистрирането на потребителят.</p></div>";
	// close
	$conn->close();

} else {
?>




<!-- header -->
<div class="jumbotron">
<h1>Регистрация</h1>
<p>За да изпращате решения трябва да се регистрирате, като попълните настоящият електронен формуляр. 
Моля запомнете потребителското име и паролата си, те ще са Ви необходими.</p>
</div>

<!-- The Form -->
<form class="form-horizontal" action="register.php" method="POST">
<fieldset>

<!-- Legend -->
<legend>Регистрация</legend>
<!-- name -->
<div class="form-group">
  <label class="col-md-4 control-label" for="name">Име и фамилия</label>
  <div class="col-md-4">
  <input id="name" name="name" type="text" placeholder="Например: Димитър Минчев" class="form-control input-md" required="">
  </div>
</div>
<!-- email -->
<div class="form-group">
  <label class="col-md-4 control-label" for="email">Електронна поща</label>
  <div class="col-md-4">
  <input id="email" name="email" type="text" placeholder="Например: dimitar.minchev@gmail.com" class="form-control input-md" required="">    
  </div>
</div>
<!-- user -->
<div class="form-group">
  <label class="col-md-4 control-label" for="user">Потребител</label>
  <div class="col-md-4">
  <input id="user" name="user" type="text" placeholder="Например: dimitar" class="form-control input-md" required="">   
  </div>
</div>
<!-- pass -->
<div class="form-group">
  <label class="col-md-4 control-label" for="password">Парола</label>
  <div class="col-md-4">
    <input id="password" name="password" type="password" placeholder="Например: minchev" class="form-control input-md" required="">
  </div>
</div>
<!-- TODO: Google Recapcha
<div class="form-group">
<label class="col-md-4 control-label" for="recapcha"></label>
<div class="col-md-4">
<div class="g-recaptcha" data-sitekey="6LeZxQsUAAAAANhwzMKG7AOa1oT0q7LOOd58eWoa"></div>
</div>
-->
</div>
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Регистрация</button>
  </div>
</div>

</fieldset>
</form>



<?php 
}
// END GET 
?>



</div> 
<!-- /Основно съдържание -->

<!-- Заключителна част -->
<div class="container">
<hr><p><a target="_blank" href="http://www.minchev.eu">Димитър Минчев</a> &copy; 2016</p>
</div>
<!-- /footer -->

<!-- jQuery JavaScript Payload -->
<script src="assets/jquery.min.js"></script>
<!-- BootStrap JavaScript PayLoad -->
<script src="assets/bootstrap.min.js"></script>
<script src="assets/bootstrap-table.min.js"></script>

</body>
</html>

