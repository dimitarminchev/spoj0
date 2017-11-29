<?php
// current page
$page = "status";

// header
include("header.php");

// init
include("init.php");

// container
$text = <<<EOT
<!-- container -->
<div class="container">
<h1>%s</h1>
EOT;
echo sprintf( $text, $lang["status"]["status"] );

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
r.status,
c.show_sources
FROM runs as r
INNER JOIN users as u ON r.user_id = u.user_id
INNER JOIN problems as p ON r.problem_id = p.problem_id
INNER JOIN contests as c ON p.contest_id = c.contest_id
EOT;


// check
if(isset($_REQUEST["id"])) {


// Part 1. single run status
$sql .= " WHERE r.run_id=".(int)$_REQUEST["id"]." ORDER BY r.run_id desc LIMIT $SQL_LIMIT";

// execute
$result = $conn->query($sql);
if ($result->num_rows == 0) 
die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
	$lang["status"]["problem"],
	$lang["status"]["info1"]
));	

// row
$row = $result->fetch_assoc();

// data
$contest = $row["ccode"]."&nbsp;<span class='label label-info'>".$row["contest_id"]."</span>";
$problem = strtoupper($row["pletter"])."&nbsp;<span class='label label-info'>".$row["problem_id"]."</span>";
$user = $row["uname"]."&nbsp;<span class='label label-info'>".$row["user_id"]."</span>";
$date = (new DateTime($row["submit_time"]))->format("d.m.y H:i:s");
$language = $row["language"];
if($row["show_sources"] == "1") 
$language.="&nbsp;<a target='_blank' class='btn btn-primary' href='code.php?id=".(int)$_REQUEST["id"]."'>Download</a>";
$stat = strtoupper($row["status"]);
switch($stat)
{
	case "OK": $stat = "<span class='label label-success'>$stat</span>"; break;
	case "WA": case "PE": $stat = "<span class='label label-warning'>$stat</span>"; break;
	default:  $stat = "<span class='label label-danger'>$stat</span>"; break;
}

// print
$text = <<<EOT
<div class="row">
<!-- 1 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">%s</h3></div>
<div class="panel-body"><h4>$contest</h4></div>
</div>
</div>
<!-- 2 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">%s</h3></div>
<div class="panel-body"><h4>$problem</h4></div>
</div>
</div>
</div>
<div class="row">
<!-- 3 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">%s</h3></div>
<div class="panel-body"><h4>$user</h4></div>
</div>
</div>
<!-- 4 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">%s</h3></div>
<div class="panel-body"><h4>$date</h4></div>
</div>
</div>
</div>
<div class="row">
<!-- 5 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">%s</h3></div>
<div class="panel-body"><h4>$language</h4></div>
</div>
</div>
<!-- 6 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title">%s</h3></div>
<div class="panel-body"><h4>$stat</h4></div>
</div>
</div>
</div>
<!-- /end -->
EOT;
echo sprintf( $text,  
	$lang["status"]["contest"], 	
	$lang["status"]["task"],
	$lang["status"]["user"], 	
	$lang["status"]["date"],	
	$lang["status"]["lang"], 
	$lang["status"]["stat"] 
);


} else {
// 2. multiple runs status



// table
$text = <<<EOT
<div class="row">
<div class="col-md-12">
<table class="table table-striped">
<thead>
<tr>
<th>%s</th>
<th>%s</th>
<th>%s</th>
<th>%s</th>
<th>%s</th>
<th>%s</th>
<th>%s</th>
<th class="pull-right">%s</th>
</tr>
</thead>
<tbody>
EOT;
echo sprintf( $text,  
	$lang["status"]["number"], 
	$lang["status"]["user"], 
	$lang["status"]["contest"], 	
	$lang["status"]["task"],		
	$lang["status"]["date"],	
	$lang["status"]["lang"], 
	$lang["status"]["score"], 
	$lang["status"]["action"] 
);

// execute
$sql .= " ORDER BY r.run_id desc LIMIT $SQL_LIMIT";
$result = $conn->query($sql);

// process
if ($result->num_rows > 0) {

// output data of each row
while($row = $result->fetch_assoc()) {

// rid
$rid = $row["run_id"];

// status
$stat = strtoupper($row["status"]);
switch($stat)
{
	case "OK": $stat = "<span class='label label-success'>$stat</span>"; break;
	case "WA": case "PE": $stat = "<span class='label label-warning'>$stat</span>"; break;
	default: $stat = "<span class='label label-danger'>$stat</span>"; break;
}

// table row	
$text = <<<EOT
<tr>
<td>$rid</td>
<td><span class='label label-info'>%s</span>&nbsp;%s</td>
<td><span class='label label-info'>%s</span>&nbsp;%s</td>
<td><span class='label label-info'>%s</span>&nbsp;%s</td>
<td>%s</td>
<td>%s</td>
<td>$stat</td>
<td class='pull-right'><a href='status.php?id=$rid' class='btn btn-primary' role='button'>%s</a></td>
</tr>
EOT;
echo sprintf( $text,  	
	$row["user_id"], $row["uname"], // user
	$row["contest_id"], $row["ccode"], // contest
	$row["problem_id"], strtoupper($row["pletter"]), // problem
	(new DateTime($row["submit_time"]))->format("d.m.y H:i:s"), // date
	$row["language"], // language
	$lang["status"]["info"] 
);
	
}}

// end table
echo "</tbody></table></div></div>";

// note
echo sprintf( "<p>%s <b>$SQL_LIMIT</b></p>", $lang["status"]["note"]  );

}

// info
$text = <<<EOT
<p><u>%s</u>:&nbsp;
<span class='label label-success'>OK</span> = %s,&nbsp;
<span class='label label-warning'>WA</span> = %s,&nbsp;
<span class='label label-warning'>PE</span> = %s,&nbsp;
<span class='label label-danger'>RE</span> = %s,&nbsp;
<span class='label label-danger'>CE</span> = %s,&nbsp;
<span class='label label-danger'>TL</span> = %s.</p>
EOT;
echo sprintf( $text,  	
	$lang["status"]["legend"],
	$lang["status"]["OK"],
	$lang["status"]["WA"],
	$lang["status"]["PE"],
	$lang["status"]["RE"],
	$lang["status"]["CE"],
	$lang["status"]["TL"]
);

// close
$conn->close();

// container end
echo <<<EOT
</div>
<!-- /container -->
EOT;

// footer
include("footer.php");
