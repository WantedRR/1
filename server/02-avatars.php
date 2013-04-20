<?
require 'conn.php';
require 'libary/simple_html_dom.php';
require 'functions.php';

function get_containt($sid,$cid) {
$html = file_get_html('http://allods.mail.ru/top100_gear.php?class='.$cid.'&s=&securitytoken=guest&shard='.$sid.'');
sleep(1);
$elements =$html->find('tr'); 
$i =0;
foreach($elements as $element) {
    $i++;
    //echo $element->children(0)->plaintext;
	insert_buff_av($element->children(0)->plaintext,substr($element->children(1)->innertext, 0 , strpos($element->children(1)->innertext, "<")),str_replace(array("'",'"'),' ',$element->children(1)->children(0)->plaintext),$element->children(3)->plaintext,$element->children(4)->plaintext,$element->children(5)->plaintext,$element->children(6)->plaintext,$sid) ;
}

}


log_server("start","avatars");
log_server("start","clear_buffer_av");
clear_buffer_av("ss","ss");
log_server("end","clear_buffer_av");

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
								log_server("start",$m["sname"]."-".$m2["name"]);
								get_containt($m["sid"],$m2["cid"]);
								//printf("<p>-%s</p>",$m2["name"]);
								log_server("end",$m["sname"]."-".$m2["name"]);
							}
						while ($m2 = mysql_fetch_array($res2));
					}
			}
		while ($m = mysql_fetch_array($res));
	}
log_server("end","avatars");


//echo $html->find('tr', 0);


//$content = strip_tags($content,»);
echo "done";

?>