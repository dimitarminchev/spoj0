<?php
// Текуща страница
$page = "status";

// Заглавна част на документа
include("header.php");
?>



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
<p><u>Legend</u>:&nbsp;
<span class='label label-success'>OK</span> = successful solution,&nbsp;
<span class='label label-warning'>WA</span> = wrong answer,&nbsp;
<span class='label label-warning'>PE</span> = presentation error,&nbsp;
<span class='label label-danger'>RE</span> = runtime error,&nbsp;
<span class='label label-danger'>CE</span> = compilation error,&nbsp;
<span class='label label-danger'>TL</span> = time limit.</p>
EOT;


// close
$conn->close();
?>



</div>
<!-- /Основно съдържание -->



<?php
// Заключителна част на документа
include("footer.php");
