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
            <li><a href="index.php">Състезания</a></li>
            <li><a href="submit.php">Решение</a></li>
            <li class="active"><a href="status.php">Статус</a></li>
	    <li><a href="register.php">Регистрация</a></li>
          </ul>
        </div>
      </div>
</nav>

<!-- Основно съдържание -->
<div class="container">
<h1>Статус</h1>

<?php
// init
include("init.php");

// var
$limit = 200;
$order = " ORDER BY r.run_id desc LIMIT $limit";

// sql
$sql =<<<EOT
SELECT
r.run_id,
r.user_id,
r.problem_id,
u.display_name as uname,
c.set_code as ccode,
p.letter as pletter,
c.contest_id,
r.submit_time,
r.language,
r.status
FROM runs as r
INNER JOIN users as u ON r.user_id = u.user_id
INNER JOIN problems as p ON r.problem_id = p.problem_id
INNER JOIN contests as c ON p.contest_id = c.contest_id
EOT;



// check
if(isset($_REQUEST["id"])) {



// Part 1. single run status
$sql .= " WHERE r.run_id=".(int)$_REQUEST["id"].$order;

// execute
$result = $conn->query($sql);
if ($result->num_rows == 0) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Решение с този номер на съществува.<p></div>");
$row = $result->fetch_assoc();

// data
$contest = $row["ccode"]."&nbsp;<span class='label label-info'>".$row["contest_id"]."</span>";
$problem = strtoupper($row["pletter"])."&nbsp;<span class='label label-info'>".$row["problem_id"]."</span>";
$user = $row["uname"]."&nbsp;<span class='label label-info'>".$row["user_id"]."</span>";
$date = (new DateTime($row["submit_time"]))->format("d.m.y H:i:s");
$language = $row["language"];
$stat = strtoupper($row["status"]);
if($stat=="OK") $stat = "<span class='label label-success'>OK</span>";
else if($stat == "WA" || $stat == "PE")  $stat = "<span class='label label-warning'>$stat</span>";
else $stat = "<span class='label label-danger'>$stat</span>";

// print
echo <<<EOT
<div class="row">
<!-- 1 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">състезание</h3></div>
<div class="panel-body"><h4>$contest</h4></div>
</div>
</div>
<!-- 2 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">задача</h3></div>
<div class="panel-body"><h4>$problem</h4></div>
</div>
</div>
</div>
<div class="row">
<!-- 3 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">потребител</h3></div>
<div class="panel-body"><h4>$user</h4></div>
</div>
</div>
<!-- 4 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">дата</h3></div>
<div class="panel-body"><h4>$date</h4></div>
</div>
</div>
</div>
<div class="row">
<!-- 5 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">език</h3></div>
<div class="panel-body"><h4>$language</h4></div>
</div>
</div>
<!-- 6 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">статус</h3></div>
<div class="panel-body"><h4>$stat</h4></div>
</div>
</div>
</div>
<!-- /end -->
EOT;



} else {
// 2. multiple runs status



// table
echo<<<EOT
<div class="row">
<div class="col-md-12">
<table class="table table-striped">
<thead>
<tr>
<th>номер</th>
<th>потребител</th>
<th>състезание</th>
<th>задача</th>
<th>дата</th>
<th>език</th>
<th>резултат</th>
<th class="pull-right">действие</th>
</tr>
</thead>
<tbody>
EOT;

// execute
$sql .= $order;
$result = $conn->query($sql);

// process
if ($result->num_rows > 0)
{

 // output data of each row
 while($row = $result->fetch_assoc())
 {
	$rid = $row["run_id"];
	$pid = $row["problem_id"];
	$date = (new DateTime($row["submit_time"]))->format("d.m.y H:i:s");
	echo "<tr>";
	echo "<td>$pid</td>";
	echo "<td><span class='label label-info'>".$row["user_id"]."</span>&nbsp;".$row["uname"]."</td>";
	echo "<td><span class='label label-info'>".$row["contest_id"]."</span>&nbsp;".$row["ccode"]."</td>";
	echo "<td><span class='label label-info'>".$row["problem_id"]."</span>&nbsp;".strtoupper($row["pletter"])."</td>";
	echo "<td>$date</td>";
	echo "<td>".$row["language"]."</td>";
	// status
	$stat = strtoupper($row["status"]);
	if($stat=="OK") $stat = "<span class='label label-success'>OK</span>";
	else if($stat == "WA" || $stat == "PE")  $stat = "<span class='label label-warning'>$stat</span>";
	else $stat = "<span class='label label-danger'>$stat</span>";
	echo "<td>$stat</td>";
	// info button
	echo "<td class='pull-right'><a href='status.php?id=$rid' class='btn btn-primary' role='button'>Информация</a></td>";
	echo "</tr>";
 }
}

// end table
echo "</tbody></table></div></div>";

// note
echo "<p><u>Бележка</u>: На страницата са изведени само последните <b>$limit</b> изпратени задачи.</p>";


}


// info
echo<<<EOT
<p><u>Легенда</u>:&nbsp;
<span class='label label-success'>OK</span> = успешно решение,&nbsp;
<span class='label label-warning'>WA</span> = неверен отговор,&nbsp;
<span class='label label-warning'>PE</span> = неправилно представяне,&nbsp;
<span class='label label-danger'>RE</span> = грешка при изпълнение,&nbsp;
<span class='label label-danger'>CE</span> = грешка при компилиране.</p>
EOT;

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