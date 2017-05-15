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
<!-- TODO: google recapcha api
<script src="https://www.google.com/recaptcha/api.js"></script>
-->
</head>
<body>


<?php
// Стартиране на сесия
session_start();

// Инициализация
include("init.php");

// Избор на език
$language = "bulgarian"; // default language
if(isset($_REQUEST["lang"])) {
if($_REQUEST["lang"] == "en") $_SESSION["spoj0"]["lang"] = "english";
else $_SESSION["spoj0"]["lang"] = "bulgarian";
}
if(isset($_SESSION["spoj0"]["lang"])) $language = $_SESSION["spoj0"]["lang"];

// Зареждане на езиковите настройки
$lang = parse_ini_file("$language.ini",true);

// NEW URI
$parsed = parse_url($_SERVER["REQUEST_URI"]);
$query = $parsed['query'];
parse_str($query, $params);
// unset($params['lang']);
$params['lang'] = "bg";
$url_bg = $parsed['path']."?".http_build_query($params);
$params['lang'] = "en";
$url_en = $parsed['path']."?".http_build_query($params);
?>

<!-- Навигация -->
<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only"><?php echo $lang["nav"]["nav"]; // Навигация ?></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="#">SPOJ</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
		    <!-- <li <?php if($page=="news") echo 'class="active"'; ?>><a href="news.php"><?php echo $lang["nav"]["news"]; // Новини ?></a></li> -->
            <li <?php if($page=="contests") echo 'class="active"'; ?>><a href="index.php"><?php echo $lang["nav"]["contests"]; // Състезания ?></a></li>
            <li <?php if($page=="submit") echo 'class="active"'; ?>><a href="submit.php"><?php echo $lang["nav"]["submit"]; // Решение ?></a></li>
            <li <?php if($page=="status") echo 'class="active"'; ?>><a href="status.php"><?php echo $lang["nav"]["status"]; // Статус ?></a></li>
			<li <?php if($page=="register") echo 'class="active"'; ?>><a href="register.php"><?php echo $lang["nav"]["register"]; // Регистрация ?></a></li>
			<!-- <li <?php if($page=="questions") echo 'class="active"'; ?>><a href="questions.php"><?php echo $lang["nav"]["questions"]; // Въпроси ?></a></li> -->
			<li <?php if($language=="bulgarian") echo 'class="active"'; ?>><a href="<?php echo $url_bg; ?>"><img src="assets/bg.png" width="25px" /> Български</a></li>
			<li <?php if($language=="english") echo 'class="active"'; ?>><a href="<?php echo $url_en; ?>"><img src="assets/uk.png" width="25px" /> English</a></li>
			<li><a href="#"><?php echo date("d.m.Y H:i:s"); ?></a></li>
          </ul>
        </div>		
      </div>
</nav>
