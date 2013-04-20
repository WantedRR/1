<?
require 'conn.php';
require 'functions.php';
log_server("start","srch_renames");
$dtt=date("Y.m.d");
$coef="10";
$coef="3";
$sql = "SELECT * FROM ".table_server."  ORDER by id";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				log_server("start","srch_renames - ".$m["sname"]);
				$sql2 = "SELECT * FROM ".table_class."  ORDER by id";
				$res2=mysql_query($sql2);
				if ($m2 = mysql_fetch_array($res2))
					{
						do
							{
								//printf("<h1><p>%s-%s</p></h1>",$m["sname"],$m2["name"]);
								srch_renames($m["sid"],$m2["cid"],$dtt,$coef);
							}
						while ($m2 = mysql_fetch_array($res2));
					}
				//srch_renames_gui($m["sid"],$dtt,$coef2);				
			}
		while ($m = mysql_fetch_array($res));
	}
$sql = "SELECT * FROM ".renames."  where actual = 1";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{				
				$sql2 ="SELECT * FROM  ".list_avatars." WHERE   (id = '".$m[3]."'  OR id = ".$m[4].")  AND is_top = 1";
				$res2=mysql_query($sql2);
				if (mysql_num_rows($res2) ==2) {
					//$rbuf = @mysql_query("UPDATE `".renames."` set actual = '2', date_up = '".$dtt."' where id = '".$m[0]."' ");
				}
				
			}
		while ($m = mysql_fetch_array($res));
	}

log_server("end","srch_renames");

?>