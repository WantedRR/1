<?
require 'conn.php';
require 'functions.php';
$dtt=date("Y.m.d");
log_server("start","pos_lvl_chg");
$rtop = @mysql_query ("truncate table ".pos_chg." ");
$sql = "SELECT * FROM ".table_server."  ORDER by id";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				log_server("start","pos_lvl_chg - ".$m["sname"]."-".$m2["name"]);

				pos_lvl_chg($m["sid"],$dtt);
				log_server("end","pos_lvl_chg - ".$m["sname"]);
			}
		while ($m = mysql_fetch_array($res));
	}
log_server("end","pos_lvl_chg");
?>		