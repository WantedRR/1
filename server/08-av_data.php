<?
require 'conn.php';
require 'functions.php';
$dtt=date("Y.m.d");
log_server("start","av_data_days");
av_data_days($dtt);
log_server("end","av_data_days");

?>