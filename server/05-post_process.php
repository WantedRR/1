<?
require 'conn.php';
require 'functions.php';
$dtt=date("Y.m.d");
$sql = "SELECT * FROM ".table_server."  ORDER by id";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				log_server("start","post_process_GUI - ".$m["sname"]);
				log_server("start","post_process_GUI");
				post_process_GUI($m["sid"],$dtt);
				log_server("start","post_process_AV_rate_GUI ".$m2["name"]);
				post_process_AV_rate_GUI($m["sid"],$dtt);							
				log_server("end","post_process_AV_rate_GUI ".$m2["name"]);
				$sql2 = "SELECT * FROM ".table_class."  ORDER by id";
				$res2=mysql_query($sql2);
				if ($m2 = mysql_fetch_array($res2))
					{
						do
							{
								log_server("start","post_process_AV- ".$m2["name"]);
								post_process_AV($m["sid"],$m2["cid"],$dtt);
								//printf("<p>-%s</p>",$m2["name"]);
							}
						while ($m2 = mysql_fetch_array($res2));
					}							
			}
		while ($m = mysql_fetch_array($res));
	}





log_server("end","post_process");

echo "done";

?>