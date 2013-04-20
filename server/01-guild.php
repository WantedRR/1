<?
require 'conn.php';
require 'libary/simple_html_dom.php';
require 'functions.php';

function get_containt_guild($sid) {
//$html = file_get_html('http://allods.mail.ru/guilds100.php?s=&securitytoken=guest&shard='.$sid.'');
$html = file_get_html('http://allods.mail.ru/guilds100.php?shard='.$sid.'');
sleep(1);
echo ('http://allods.mail.ru/guilds100.php?s=&securitytoken=guest&shard='.$sid.'');
 echo "<br>";
$elements =$html->find('tr'); 
$i =0;
foreach($elements as $element) {
    $i++;
    if ($i <>1)  {
		insert_buff_gui($element->children(0)->plaintext,str_replace(array("'",'"'),' ',$element->children(1)->plaintext),$element->children(2)->plaintext,$element->children(3)->plaintext,$sid);
	}

}

}


log_server("start","guild");
log_server("start","clear_buffer_gui");
clear_buffer_gui("ss","ss");
log_server("end","clear_buffer_gui");

$sql = "SELECT * FROM ".table_server."  ORDER by id";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				log_server("start",$m["sname"]);
				get_containt_guild($m["sid"]);
				//printf("<p>-%s</p>",$m2["name"]);
				log_server("end",$m["sname"]);
			}
		while ($m = mysql_fetch_array($res));
	}
log_server("end","guild");

$sql = "select count(*) as e1 from `".table_buffer_gui."`";
$res=mysql_query($sql);
$m = mysql_fetch_array($res);

echo "Count: <b>";
echo $m[0];

?>