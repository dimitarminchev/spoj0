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

<?php
//  Текуща страница
$active = "register";

// Стартира сесия
session_start();

// Избор на език
$language = "bulgarian"; // default language
if(isset($_REQUEST["lang"]))
if($_REQUEST["lang"] == "en") $_SESSION["spoj0"]["lang"] = "english";
else $_SESSION["spoj0"]["lang"] = "bulgarian";
if(isset($_SESSION["spoj0"]["lang"])) $language = $_SESSION["spoj0"]["lang"];

// Зареждане на езиковите настройки
$lang = parse_ini_file("$language.ini",true);
?>

<!-- Навигация -->
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"><?php echo $lang["index"]["nav"]; // Навигация ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="#">SPOJ</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
		    <li <?php if($active=="news") echo 'class="active"'; ?>><a href="news.php"><?php echo $lang["index"]["news"]; // Новини ?></a></li>
            <li <?php if($active=="contests") echo 'class="active"'; ?>><a href="index.php"><?php echo $lang["index"]["contests"]; // Състезания ?></a></li>
            <li <?php if($active=="submit") echo 'class="active"'; ?>><a href="submit.php"><?php echo $lang["index"]["submit"]; // Решение ?></a></li>
            <li <?php if($active=="status") echo 'class="active"'; ?>><a href="status.php"><?php echo $lang["index"]["status"]; // Статус ?></a></li>
			<li <?php if($active=="register") echo 'class="active"'; ?>><a href="register.php"><?php echo $lang["index"]["register"]; // Регистрация ?></a></li>
			<li <?php if($active=="questions") echo 'class="active"'; ?>><a href="questions.php"><?php echo $lang["index"]["questions"]; // Въпроси ?></a></li>
			<li <?php if($language=="bulgarian") echo 'class="active"'; ?>><a href="index.php?lang=bg"><img src="assets/bg.png" width="25px" /> Български</a></li>
			<li <?php if($language=="english") echo 'class="active"'; ?>><a href="index.php?lang=en"><img src="assets/uk.png" width="25px" /> English</a></li>
			<li><a href="#"><?php echo date("d.m.y H:i:s"); ?></a></li>
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
</div>
-->
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
<hr><p><a target="_blank" href="http://www.minchev.eu">Димитър Минчев</a> &copy; <?php echo date("Y"); ?></p>
</div>
<!-- /footer -->

<!-- jQuery JavaScript Payload -->
<script src="assets/jquery.min.js"></script>
<!-- BootStrap JavaScript PayLoad -->
<script src="assets/bootstrap.min.js"></script>
<script src="assets/bootstrap-table.min.js"></script>

</body>
</html>

