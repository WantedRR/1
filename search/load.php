
<?
require '../conn.php';
require '../libary/guild_class.php';
require '../libary/av_class.php';
require '../libary/srv_class.php';
require '../libary/general_class.php';
require '../lang/ru-ru.php';
//sleep(1);

$ff=trim(iconv('utf-8','cp1251',$_GET["q"]));

//$im[]=iconv('cp1251', 'utf-8', $m2[8]);
//$sql="select * from `".list_avatars."` where lower(av_name) like '%".$ff."%' LIMIT 0,10";

//$ff=checkint($ff);
if (!preg_match("/^[à-ÿÀ-ß]+$/",$ff)){
	printf("<p>%s</p>",txt_input_wrong);
} else {
$ff=trim(iconv('cp1251','utf-8',mb_strtolower($ff)));


$sql = "SELECT 'av'
     , a.av_name
  ,a.id
     , a.s_id
     , a.c_id
     , a.f_id


FROM
 `".list_avatars."`  a
WHERE
  lower(av_name) LIKE '%".$ff."%'
limit 0,10
  UNION all
  SELECT
    'gui',
    b.gui_name
    ,b.id
    ,b.srv_id
    ,''
    ,b.frake_id
FROM
  `".list_gui."` b
WHERE
  lower(gui_name) LIKE '%".$ff."%' limit 0,10";


$res=mysql_query($sql);
if ($myrow = mysql_fetch_array($res))
	{	
		do
			{
				$srv_name=getSRVname($myrow[3]);
				if ($myrow[0] =='av'){
					$c= "txt_class_$myrow[4]";
					$c2= "txt_frake_$myrow[5]";

					printf("<p>%s <a href=\"%s\">%s</a>(%s,%s) <br>%s</p>\n",txt_avatar,getAVlink($myrow[2]),$myrow[1],$$c,$$c2,$srv_name[1],$myrow[1]);
					//printf("%s \n",$myrow[1]);
				}
				if ($myrow[0] =='gui'){
					printf("<p>%s <a href=\"%s\">%s</a> </p>\n",txt_guild,getGUIlink($myrow[2]),$myrow[1]);
				}
				//printf("%s \n",$myrow[2]);
			}
		while ($myrow = mysql_fetch_array($res));
	}

}
?>