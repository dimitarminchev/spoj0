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
$active = "contests";

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

// contest number
if(!isset($_REQUEST["id"])) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Няма посочен номер на състезание.<p></div>");
$id = (int)$_REQUEST["id"];

// contest info
$sql = "SELECT * FROM contests WHERE contest_id=$id";
$result = $conn->query($sql);
if ($result->num_rows == 0) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Състезание с такъв номер не съществува.<p></div>");
$row = $result->fetch_assoc();
$name = $row["name"];
$start = new DateTime($row["start_time"]);
$start = $start->format("d.m.Y H:i");
$duration = $row["duration"];
// header
echo<<<EOT
<h1>Задачи</h1>
<div class="row">
<!-- 1 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">състезание</h3></div>
<div class="panel-body"><h3>$name</h3></div>
</div>
</div>
<!-- 2 -->
<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">начало</h3></div>
<div class="panel-body"><h3>$start</h3></div>
</div>
</div>
<!-- 3 -->
<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">продължителност</h3></div>
<div class="panel-body"><h3>$duration</h3></div>
</div>
</div>
</div>
<!-- /row -->
EOT;


// table
echo<<<EOT
<div class="row">
<div class="col-md-12">
<table class="table table-striped">
<thead>
<tr>
<th>номер</th>
<th>буква</th>
<th>инфо</th>
<th class="pull-right">действие</th>
</tr>
</thead>
<tbody>
EOT;

// sql
$sql = "SELECT * FROM problems WHERE contest_id=$id";
$result = $conn->query($sql);

// execute
if ($result->num_rows > 0)
{

 // output data of each row
 while($row = $result->fetch_assoc())
 {
	$id = $row["problem_id"];
	echo "<tr>";
	echo "<td>$id</td>";
	echo "<td>".strtoupper($row["letter"])."</td>";
	echo "<td>".$row["about"]."</td>";
	echo "<td class='pull-right'><a href='description.php?id=$id' class='btn btn-primary' role='button'>Условие</a>&nbsp;";
	echo "<a href='submit.php?id=$id' class='btn btn-info' role='button'>Решение</a>";
	echo "</tr>";
 }
}

// end table
echo "</tbody></table></div></div>";

// close
$conn->close();
?>



</div>
<!-- /Основно съдържание -->

<!-- Заключителна част -->
<div class="container">
<hr><p><a target="_blank" href="http://www.minchev.eu">Димитър Минчев</a> &copy;  <?php echo date("Y"); ?></p>
</div>
<!-- /footer -->

<!-- jQuery JavaScript Payload -->
<script src="assets/jquery.min.js"></script>
<!-- BootStrap JavaScript PayLoad -->
<script src="assets/bootstrap.min.js"></script>
<script src="assets/bootstrap-table.min.js"></script>

</body>
</html>
