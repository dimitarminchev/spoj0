<?php
// Текуща страница
$page = "contests";

// Заглавна част на документа
include("header.php");
?>



<!-- Основно съдържание -->
<div class="container">


<?php
// mysql
include("init.php");

// contest number
if(!isset($_REQUEST["id"])) 
die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
	$lang["description"]["problem"],
	$lang["description"]["info1"]
));
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

// NEW: Contest start time check!
if($row["c_ustart"] > $row["unow"])
die( sprintf("<div class='jumbotron alert-danger'><h1> %s </h1><p> %s.<p></div>",
	$lang["description"]["problem"],
	$lang["description"]["info2"]
));
$id = (int)$_REQUEST["id"];

// data for header
$name = $row["c_name"];
$letter = strtoupper($row["letter"]);
$about = $row["about"];

// header
$text = <<<EOT
<h1> %s </h1>
<div class="row">
<!-- 1 -->
<div class="col-md-6">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title"> %s </h3></div>
<div class="panel-body"><h3>$name</h3></div>
</div>
</div>
<!-- 2 -->
<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title"> %s </h3></div>
<div class="panel-body"><h3>$letter</h3></div>
</div>
</div>
<!-- 3 -->
<div class="col-md-3">
<div class="panel panel-default">
<div class="panel-heading"><h3 class="panel-title"> %s </h3></div>
<div class="panel-body"><h3>$about</h3></div>
</div>
</div>
</div>
<!-- /row -->
EOT;
echo sprintf( $text, 
	$lang["description"]["description"], 
	$lang["description"]["contest"], 
	$lang["description"]["letter"], 
	$lang["description"]["about"]
);


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


// buttons
$text = <<<EOT
<p>
<a class="btn btn-primary btn-lg" href="javascript:history.back();" role="button"> %s </a>
<a class="btn btn-info btn-lg" href="submit.php?id=$id" role="button"> %s </a>
</p>
EOT;
echo sprintf( $text, 
	$lang["description"]["problems"], 
	$lang["description"]["submit"]
);
?>




</div>
<!-- /Основно съдържание -->



<?php
// Заключителна част на документа
include("footer.php");
