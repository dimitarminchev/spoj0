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
</head>
<body>

<?php
//  Текуща страница
$active = "submit";

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
	// vars
	$problem_id = $conn->real_escape_string($_REQUEST["task"]);
	$user = $conn->real_escape_string($_REQUEST["user"]);
	$pass = md5($conn->real_escape_string($_REQUEST["password"]));
	$language = $conn->real_escape_string($_REQUEST["language"]);
	$code = $conn->real_escape_string($_REQUEST["code"]);
	$submit_time = date("Y-m-d H:i:s");

	// check for user
	$sql = "SELECT user_id FROM  spoj0.users WHERE name='$user' and pass_md5='$pass'";
	$result = $conn->query($sql);
        if ($result->num_rows == 0) echo "<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Неправилно потребителско име и/или парола.<p></div>";
	$row = $result->fetch_row();
	$user_id = $row[0];

	// prepare sql
	$sql = "INSERT INTO spoj0.runs (problem_id, user_id, submit_time, language, source_code, source_name, about, status, log) ".
	       "VALUES ('$problem_id','$user_id','$submit_time','$language','$code','program.$language','','waiting','')";

	// execute and message
	if($conn->query($sql)) echo "<div class='jumbotron alert-success'><h1>Решение</h1><p>Успешно е изпратено решение <b>$problem_id</b> на задача.</p></div>";
	else echo "<div class='jumbotron alert-danger'><h1>Решение</h1><p>Възникна проблем при изпращането на решение <b>$problem_id</b> на задача.</p></div>";

	// close
	$conn->close();


} else {
// GET

// problem number
$pid = "";
if(isset($_REQUEST["id"])) $pid = (int)$_REQUEST["id"];
?>

<!-- The Form -->
<h1>Решение</h1>
<form class="form-horizontal" action="submit.php" method="POST">
<fieldset>

<!-- Legend -->
<!-- <legend>Решение</legend> -->
<!-- task -->
<div class="form-group">
  <label class="col-md-4 control-label" for="task">Номер на задачата</label>
  <div class="col-md-4">
  <input id="task" name="task" type="text" placeholder="Например: 42" class="form-control input-md" required="" value="<?php echo $pid; ?>">
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
<!-- language -->
<div class="form-group">
  <label class="col-md-4 control-label" for="language">Език за програмиране</label>
  <div class="col-md-4">
   <select class="form-control" name="language" id="language" class="form-control input-md" >
    <option selected value="cpp">C++</option>
    <option value="cs">C#</option>
    <option value="java">Java</option>
   </select>
  </div>
</div>
<!-- code -->
<div class="form-group">
  <label class="col-md-4 control-label" for="code">Изходен код на програмата</label>
  <div class="col-md-4">
  <textarea id="code" name="code" placeholder="Тук копирайте и поставете Вашият програмен код съдържащ решението на задачата и подлежащ на проверка." rows="10" class="form-control input-md" required=""></textarea>
  </div>
</div>
<!-- Submit Button -->
<div class="form-group">
  <label class="col-md-4 control-label" for="submit"></label>
  <div class="col-md-4">
    <button id="submit" name="submit" class="btn btn-primary">Изпрати решението за проверка</button>
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

