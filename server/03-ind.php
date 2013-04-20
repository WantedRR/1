<?
require 'conn.php';
require 'functions.php';

//Обработка гильдий
$sql = "SELECT * FROM ".table_server."  ORDER by id";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				log_server("start","list_gui_process - ".$m["sname"]);;
				list_gui_process_long($m["sid"],'ss');
				log_server("end","list_gui_process - ".$m["sname"]);
			}
		while ($m = mysql_fetch_array($res));
	}
log_server("end","guild");


//log_server("start","list_gui_process - 2");
//list_gui_process_long('1','ss');
//log_server("end","list_gui_process - 2");
?>