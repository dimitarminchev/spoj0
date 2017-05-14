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

// welcome
echo<<<EOT
<!-- Заглавна част -->
<div class="jumbotron">
<h1>SPOJ</h1>
<p>Електронна тренировъчна система за автоматично оценяване на задачи по програмиране.</p>
<p><a class="btn btn-primary" target="_blank" href="http://atp.bfu.bg" role="button">Академия за таланти по програмиране</a></p>
</div>
EOT;

// table
echo<<<EOT
<div class="row">
<div class="col-md-12">
<table class="table table-striped">
<thead>
<tr>
<th>номер</th>
<th>наименование на състезанието</th>
<th>начало</th>
<th>продължителност</th>
<th class="pull-right">действие</th>
</tr>
</thead>
<tbody>
EOT;

// sql
$sql = "SELECT * FROM contests ORDER BY contest_id DESC";
$result = $conn->query($sql);

// execute
if ($result->num_rows > 0)
{

 // output data of each row
 while($row = $result->fetch_assoc())
 {
	$id = $row["contest_id"];
	$date = (new DateTime($row["start_time"]))->format("d.m.Y H:i");

	echo "<tr>";
	echo "<td>$id</td>";
	echo "<td>".$row["name"]."</td>";
	echo "<td>$date</td>";
	echo "<td>".$row["duration"]."</td>";
	echo "<td class='pull-right'><a href='contest.php?id=$id' class='btn btn-info' role='button'>Задачи</a>&nbsp;";
	echo "<a href='board.php?id=$id' class='btn btn-info' role='button'>Класиране</a></td>";
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
