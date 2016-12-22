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
