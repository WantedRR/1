<?
require 'conn.php';
require 'functions.php';
$fp = fopen("../date_up.php", "w");

$sql = "select * from ".gui_data." order by date desc limit 0,1";
$res=mysql_query($sql);
$m = mysql_fetch_array($res);
$date_up=$m[1];

$mytext = '<? $date_up = "'.$date_up.'" ?>'; // Исходная строка
$test = fwrite($fp, $mytext); 
?>