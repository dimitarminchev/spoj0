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
// refresh
header("refresh: 5;");
// init
include("init.php");

// contest number
if(!isset($_REQUEST["id"])) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Няма посочен номер на състезание.<p></div>");
$cid = (int)$_REQUEST["id"];

// contest info
$sql = "SELECT * FROM contests WHERE contest_id=$cid";
$result = $conn->query($sql);
if ($result->num_rows == 0) die("<div class='jumbotron alert-danger'><h1>Проблем</h1><p>Състезание с такъв номер не съществува.<p></div>");
$row = $result->fetch_assoc();
$name = $row["name"];
$start = new DateTime($row["start_time"]);
$start = $start->format("d.m.Y H:i");
$duration = $row["duration"]; 
// header
echo<<<EOT
<h1>Класиране</h1>
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

// sql
$sql =<<<EOT
SELECT
r.run_id,
u.display_name as u_name,
u.user_id,
u.hidden as u_hidden,
p.letter as p_letter,
p.problem_id,
c.contest_id,
UNIX_TIMESTAMP(r.submit_time) as s_time,
UNIX_TIMESTAMP(c.start_time) as c_time,
c.duration,
r.status
FROM runs as r
INNER JOIN users as u ON r.user_id = u.user_id
INNER JOIN problems as p ON r.problem_id = p.problem_id
INNER JOIN contests as c ON p.contest_id = c.contest_id
HAVING contest_id = $cid
ORDER BY r.run_id
EOT;
// execute
$result = $conn->query($sql);


// generate ratings in json format
$rate = array();
while($row = $result->fetch_assoc())
{
	// id, time & letter
        $id = $row["user_id"];
        $time = ($row["s_time"] - $row["c_time"]) / 60;
	$letter = strtoupper($row["p_letter"]);

	// skip solutions after the contest
	if($time > $row["duration"]) continue;

	// user, submits & run
        $rate[$id]["username"] = $row["u_name"];
        $rate[$id]["submits"] = $rate[$id]["submits"] + 1;
        $rate[$id]["runs"][$letter] = $rate[$id]["runs"][$letter] + 1;

        // times
	if(!isset($rate[$id]["answers"][$letter]) || $rate[$id]["answers"][$letter] == 0)
        if($row["status"] == "ok")
	{
		$rate[$id]["times"][$letter] = floor($time);
	}
        else
	{
		$rate[$id]["times"][$letter] = 0;
	}

	// answers, solved & totaltime
	if(isset($rate[$id]["times"][$letter]) && $rate[$id]["times"][$letter] > 0)
	{
		if($row["status"] == "ok" && $rate[$id]["answers"][$letter] == 0)
		{
			$rate[$id]["solved"] = $rate[$id]["solved"] + 1;
			$time = $time + ($rate[$id]["runs"][$letter]-1) * 20;
                	$rate[$id]["time"] = $rate[$id]["time"] + $time;
		}
		$rate[$id]["answers"][$letter] = 1;
	}
	else
	{
		$rate[$id]["answers"][$letter] = 0;
	}
}

// reindex
$rate = array_values($rate);
//print_r($rate);

// bubble sort
for($i=0;$i<count($rate);$i++)
for($j=0;$j<count($rate);$j++)
if($rate[$i]["solved"] >=  $rate[$j]["solved"])
{
	if($rate[$i]["solved"] ==  $rate[$j]["solved"])
	{
		// order by: time
		if($rate[$i]["time"] < $rate[$j]["time"])
		{
			$temp = $rate[$i];
			$rate[$i] = $rate[$j];
			$rate[$j] = $temp;
		}
	}
	else
	{
		// order by: solved
		$temp = $rate[$i];
		$rate[$i] = $rate[$j];
		$rate[$j] = $temp;
	}
}

// json
//$json = json_encode($rate);
//print_r($json);

// tasks counter
$res = $conn->query("SELECT count(problem_id) FROM spoj0.problems WHERE contest_id=$cid");
$res = $res->fetch_row();
$taskscounter = $res[0];

// table
echo "<div class='row'><div class='col-md-12'><table class='table table-striped'><thead><tr><th>№</th><th>име</th><th>решени</th><th>време</th>";
for($i=0;$i<$taskscounter;$i++) echo "<th>".chr($i+65)."</th>";
echo "<th class='pull-right'>опити</th></tr></thead><tbody>";

// process table
for ($i=0;$i<count($rate);$i++)
{
	// data
	$no = $i+1;
	$user = $rate[$i]["username"];
	$solved = $rate[$i]["solved"];
	$time = floor($rate[$i]["time"]);
	$submits = $rate[$i]["submits"];

	// forming tasks and colors
	$tasks = "";
	for($j=0;$j<$taskscounter;$j++)
	{
		if(isset($rate[$i]["answers"][chr($j+65)]))
		{
			$t = $rate[$i]["times"][chr($j+65)];
			$r = $rate[$i]["runs"][chr($j+65)];
			if($rate[$i]["answers"][chr($j+65)]==1)
			$tasks .= "<td class='bg-success'>$t<br><span class='label label-success'>$r</span></td>";
			else
			$tasks .= "<td class='bg-danger'>$t<br><span class='label label-danger'>$r</span></td>";
		} else $tasks .= "<td>0</td>";
	}
	// print single row
	echo "<tr><td>$no</td><td>$user</td><td>$solved</td><td>$time</td>$tasks<td class='pull-right'>$submits</td>";
}

// end table
echo "</tbody></table></div></div>";

// close
$conn->close();

// final
echo "<a href='board-offline.php?id=$cid' class='btn btn-primary' role='button'>Класиране след състезание</a></td>";
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
