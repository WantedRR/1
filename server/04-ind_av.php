<?
require 'conn.php';
require 'functions.php';
$dtt=date("Y.m.d");
log_server("start","list_AV_process");
$sql = "SELECT * FROM ".table_server."  ORDER by id";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				$sql2 = "SELECT * FROM ".table_class."  ORDER by id";
				$res2=mysql_query($sql2);
				if ($m2 = mysql_fetch_array($res2))
					{
						do
							{
								log_server("start","list_AV_process - ".$m["sname"]."-".$m2["name"]);;
								list_av_process_long($m["sid"],$m2["cid"],$dtt);
								log_server("end","list_AV_process - ".$m["sname"]."-".$m2["name"]);
							}
						while ($m2 = mysql_fetch_array($res2));
					}
			}
		while ($m = mysql_fetch_array($res));
	}
log_server("end","list_AV_process");


?>