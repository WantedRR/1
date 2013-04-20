<?
require 'conn.php';
require 'functions.php';
$dtt=date("Y.m.d");
$d1 = date ("U");
log_server("start","gui_data_srv");
$sql = "SELECT * FROM ".table_server."  ORDER by id";
$rtop = @mysql_query ("truncate table ".vs_gui." ");
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				//log_server("start","list_gui_process - ".$m["sname"]);;
				gui_data_srv($m["sid"],$dtt);
				define_gui_frake($m["sid"]);
				//log_server("end","list_gui_process - ".$m["sname"]);
			}
		while ($m = mysql_fetch_array($res));
	}
log_server("end","gui_data_srv");
$d2 = date ("U");

echo $d1;
echo "<br>";
echo $d2;
echo "<br>";


?>