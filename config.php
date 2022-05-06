<?php
$host = 'localhost';
$dbuser = 'root';
$dbname = 'internet';
$dbpass = '';
$sitename = 'БД АТС';
$db_url = 'http://' . $host . "/openserver/phpmyadmin/";


$connect = mysqli_connect($host, $dbuser, $dbpass, $dbname) or die("Can`t connect to " . $dbname);
mysqli_query($connect, 'SET NAMES UTF8') or die("Error: " . mysqli_error($connect));
$v = mysqli_fetch_assoc(mysqli_query($connect, "SELECT version FROM changelog ORDER BY version desc"));
$version = "версія " . $v['version'];
