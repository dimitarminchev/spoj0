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
            <li class="active"><a href="index.php">Състезания</a></li>
            <li><a href="submit.php">Решение</a></li>
            <li><a href="status.php">Статус</a></li>
            <li><a href="register.php">Регистрация</a></li>
          </ul>
        </div>
      </div>
</nav>

<!-- Основно съдържание -->
<div class="container">


<?php
// mysql
include("init.php");

// contest number
if(!isset($_REQUEST["id"])) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Няма посочен номер на задача.<p></div>");
$id = (int)$_REQUEST["id"];

// sql
$sql =<<<EOT
SELECT p.*,
c.set_code as c_code,
c.name as c_name,
c.start_time as c_start,
c.duration as c_duration,
c.show_sources as c_show_sources,
UNIX_TIMESTAMP(c.start_time) as c_ustart,
UNIX_TIMESTAMP(NOW()) as unow,
NOW() > c.start_time as c_active,
(NOW() > c.start_time &&
UNIX_TIMESTAMP(NOW()) <
UNIX_TIMESTAMP(c.start_time)+c.duration*60) as c_online
FROM problems as p
INNER JOIN contests as c
ON p.contest_id = c.contest_id
HAVING 1=1
AND problem_id=$id
EOT;
// echo $sql;

// execute sql
$result = $conn->query($sql);
$row = $result->fetch_assoc();

// data for header
$name = $row["c_name"];
$letter = strtoupper($row["letter"]);
$about = $row["about"];


// NEW: Contest start time check!
$cstart = $row["c_start"];
$start = time() - strtotime($cstart);
if($start >= 0)
{


// header
echo<<<EOT
<h1>Условие</h1>
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
<div class="panel-heading"><h3 class="panel-title">буква</h3></div>
<div class="panel-body"><h3>$letter</h3></div>
</div>
</div>
<!-- 3 -->
<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">инфо</h3></div>
<div class="panel-body"><h3>$about</h3></div>
</div>
</div>
</div>
<!-- /row -->
EOT;



// file path
$filepath = $SETS_DIR."/".$row["c_code"]."/".$row["letter"];

// Read and print all description files
$files = glob("$filepath/description.*");
if(!empty($files))
{
	echo "<div>";
	for($i=0;$i<count($files);$i++)
	{
		$ext = pathinfo($files[$i], PATHINFO_EXTENSION);
		$file = pathinfo($files[$i], PATHINFO_FILENAME);
		echo "<a href='file.php?id=$id&ext=$ext'><img src='assets/$ext.png' style='margin:10px;'></a>";
	}
	echo "</div>";
}


// read and print description text file
$source = file_get_contents("$filepath/description.txt"); // or readfile("$filepath/description.txt");
if(!empty($source))
echo "<pre style='white-space: pre-line; font-family:courier; font-size: 16pt;'>$source</pre>";

// close
$conn->close();
?>


<!-- button -->
<p>
<a class="btn btn-primary btn-lg" href="javascript:history.back();" role="button">Задачи</a>
<a class="btn btn-info btn-lg" href="submit.php?id=<?php echo $id; ?>" role="button">Решение</a>
</p>


</div>
<!-- /Основно съдържание -->


<?php
// NEW: Not started yet!
} else {
$cstart = (new DateTime($cstart))->format("Състезанието започва на <b>d.m.Y</b> от <b>H:i</b> часа.");
echo  "<div class='jumbotron alert-danger'><h1>Проблем</h1><p>".$cstart."</p></div>";
}
?>


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

