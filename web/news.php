<?php
// current page
$page = "news";

// header
include("header.php");

// container
echo sprintf( "<div class='container'><h1>%s</h1>", $lang["nav"]["news"] );

// query
$result = $conn->query("SELECT * FROM news ORDER BY new_id DESC");

// execute
if ($result->num_rows > 0)

// print
while($row = $result->fetch_assoc()) 
echo sprintf( "<h3>%s</h3><div>%s</div><p>%s</p><hr>", $row["topic"], (new DateTime($row["new_time"]))->format("d.m.Y H:i:s"), $row["content"]);

// close
$conn->close();

// container end
echo "</div>";

// Заключителна част на документа
include("footer.php");
