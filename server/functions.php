<?
$run=mysql_query("SET profiling = 1;")or die("Invalid query: " . mysql_error());
$run=mysql_query("set profiling_history_size=100;") or die("Invalid query: " . mysql_error());
function list_gui_process($sid,$cid) {
//Гильдия попала в топ 100 сервера
$sql = "SELECT * FROM  ".table_buffer_gui." LEFT JOIN ".list_gui." ON ".table_buffer_gui.".gui_name = ".list_gui.".gui_name WHERE ".table_buffer_gui.".sid = ".$sid." AND list_gui.gui_name IS NULL";
echo $sql;
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				$rbuf = @mysql_query("INSERT INTO `".list_gui."` VALUES(NULL,'".date("Y.m.d")."','".$m[2]."','".$sid."',NULL)");
				///echo mysql_error();
				$guiid = mysql_insert_id();				
				$rtop = @mysql_query("INSERT INTO `".gui_top."` VALUES(NULL,'".date("Y.m.d H:i:s")."','".$guiid."','1','".$sid."')");
				//echo mysql_error();
			}
		while ($m = mysql_fetch_array($res));
	}
//Гильдия выпала из ТОП 100
$sql = "SELECT * FROM ".list_gui." left join ".table_buffer_gui." on ".list_gui.".gui_name = ".table_buffer_gui.".gui_name WHERE  srv_id= '".$sid."' and ".table_buffer_gui.".gui_name is null";
echo "<br>";
echo "<br>";
echo "<br>";
echo $sql;
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				$rtop = @mysql_query("INSERT INTO `".gui_top."` VALUES(NULL,'".date("Y.m.d")."','".$m[0]."','0','".$sid."')");
			}
		while ($m = mysql_fetch_array($res));
	}
}
function clear_buffer_av($sid,$cid) {
	$rtop = @mysql_query ("truncate table ".table_buffer_av." ");
}
function clear_buffer_gui($sid,$cid) {
	$rtop = @mysql_query ("truncate table ".table_buffer_gui." ");
}
function list_gui_process_long($sid,$cid) {
//Проверка на попадание в ТОП 100 заполнение листа	
	$sql = "SELECT * FROM  ".table_buffer_gui." where ".table_buffer_gui.".sid = ".$sid." ";
	$res=mysql_query($sql);
	if ($m = mysql_fetch_array($res))
		{
			do
				{
					$sql2 = "SELECT * FROM  ".list_gui." where srv_id = ".$sid." and gui_name = '".$m[2]."' ";					
					$res2=mysql_query($sql2);
					if(mysql_num_rows($res2) === 0) {
						//Гильдия попала в топ 100 сервера
						//printf("%s <br>",$m[2] );
						$rbuf = @mysql_query("INSERT INTO `".list_gui."` VALUES(NULL,'".date("Y.m.d")."','".$m[2]."','".$sid."',NULL)");
						$guiid = mysql_insert_id();				
						$rtop = @mysql_query("INSERT INTO `".gui_top."` VALUES(NULL,'".date("Y.m.d H:i:s")."','".$guiid."','1','".$sid."')");

					} else {
						//Гильдия была топ 100 сервера
						//printf("EXIS %s <br>",$m[2] );

					}
					
				}
		while ($m = mysql_fetch_array($res));
		}
//Обратная проверка на выбывание из ТОП100 		
	$sql = "SELECT * FROM  ".list_gui." where ".list_gui.".srv_id = ".$sid." ";
	$res=mysql_query($sql);
	if ($m = mysql_fetch_array($res))
		{
			do
				{
					$sql2 = "SELECT * FROM  ".table_buffer_gui." where sid = ".$sid." and gui_name = '".$m[2]."' ";					
					$res2=mysql_query($sql2);
					if(mysql_num_rows($res2) === 0) {
						//printf("droped %s <br>",$m[2] );
						$rtop = @mysql_query("INSERT INTO `".gui_top."` VALUES(NULL,'".date("Y.m.d H:i:s")."','".$m[0]."','0','".$sid."')");

					} else {
						//printf("%s <br>", $m[2] );
					}
				}
		while ($m = mysql_fetch_array($res));
		}

//Заполнение данных из буфера
	$sql = "SELECT * FROM  ".table_buffer_gui." LEFT JOIN ".list_gui." ON ".table_buffer_gui.".gui_name = ".list_gui.".gui_name WHERE (".table_buffer_gui.".sid = ".$sid." and ".list_gui.".srv_id=".$sid.") ";
	echo $sql;
	$res=mysql_query($sql);
	if ($m = mysql_fetch_array($res))
		{
			do
				{
					printf("%s <br>", $m[6] );
					$rtop = @mysql_query("INSERT INTO `".gui_data."` VALUES(NULL,'".date("Y.m.d H:i:s")."','".$sid."','".$m[6]."','".$m[1]."','".$m[4]."','".$m[3]."')");
				}
		while ($m = mysql_fetch_array($res));
		}
//Копирование вбуфера в архив
//$rtop = @mysql_query ("insert into ".table_buffer_gui_arhive." select * from ".table_buffer_gui." where sid = ".$sid." ");
}
function list_av_process_long($sid,$cid,$dt_us) {

$sql = "SELECT ".table_buffer_av.".* , ".frake_list.".fid  , ".table_class.".cid  ,races.id as race_id
FROM ".table_buffer_av."
LEFT JOIN frake
ON ".table_buffer_av.".frake = ".frake_list.".fname
LEFT JOIN classes
ON ".table_buffer_av.".class = ".table_class.".name
LEFT JOIN races
ON ".table_buffer_av.".race = ".race_list.".race_name
WHERE
  sid = ".$sid." and cid= ".$cid." ";
//echo $sql;
//Проверка на попадание в ТОП 100 заполнение листа	
$i == 0;
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
					//log_server("FLAG","list_AV_process - ".$m["sname"]."-".$m2[0]);

					$sql2 = "SELECT * FROM  ".list_avatars." where s_id = ".$sid." and av_name = '".$m[2]."' and c_id = '".$cid."' ";
					//echo $sql2;			
					$res2=mysql_query($sql2);					
					if(mysql_num_rows($res2) === 0) {
						//Автар попал в топ 100 сервера
						$rbuf = @mysql_query("INSERT INTO `".list_avatars."` VALUES(NULL,'".$dt_us."','".$dt_us."','".$m[2]."','".$sid."','".$cid."','".$m[9]."','".$m[11]."','1')");				
						$avid = mysql_insert_id();				
						$rtop = @mysql_query("INSERT INTO `".av_top."` VALUES(NULL,'".$dt_us."','".$avid ."','1','".$sid."')");				
					} else {

						//был  в топ 100 сервера и есть в буфере, проверяем статус топа.
						$m2 = mysql_fetch_array($res2);
						if ($m2[8] ==0 ){
							//Апдейтим вновь вернувшегося аватара в топ 100
							//printf ("%s - %s -%s<br>", $m2[3], $m2[8], $m[0]);
							$rbuf = @mysql_query("UPDATE `".list_avatars."` set is_top = '1', date_up = '".$dt_us."' where id = '".$m2[0]."' ");
							$rtop = @mysql_query("INSERT INTO `".av_top."` VALUES(NULL,'".$dt_us."','".$m2[0] ."','3','".$sid."')");
						}
						//
						
						if ($m2[6] <> $m[9] ){
							//Change frake
							$rtop = @mysql_query("INSERT INTO `".av_chg."` VALUES(NULL,'".$dt_us."','1','".$m2[0]."','".$m2[6]."','". $m[9]."')");
							$rbuf = @mysql_query("UPDATE `".list_avatars."` set f_id = '".$m[9]."', date_up = '".$dt_us."' where id = '".$m2[0]."' ");
							//printf ("%s - %s -%s<br>", $m2[3], $m2[6], $m[9]);
						}
						if ($m2[7] <> $m[11] ){
							//change race
							$rtop = @mysql_query("INSERT INTO `".av_chg."` VALUES(NULL,'".$dt_us."','2','".$m2[0]."','".$m2[7]."','". $m[11]."')");
							$rbuf = @mysql_query("UPDATE `".list_avatars."` set r_id = '".$m[11]."', date_up = '".$dt_us."' where id = '".$m2[0]."' ");
							
						}
						
					}

				$i++;
				
			}
		while ($m = mysql_fetch_array($res));
	}
	$
//Проверка на выбывание из ТОП 100 аватаров
$k=0;
log_server("start","list_AV_process - status TOP");
$sql = "SELECT * FROM  ".list_avatars." where ".list_avatars.".s_id = ".$sid." and c_id =".$cid." ";
//echo $sql;
	$res=mysql_query($sql);
	if ($m = mysql_fetch_array($res))
		{
			do
				{
					$sql2 = "SELECT * FROM  ".table_buffer_av." left join classes on ".table_buffer_av.".class=classes.name where sid = ".$sid." and nikname = '".$m[3]."' and classes.cid = '".$cid."'";
					//log_server("start","list_AV_process - status TOP: ". $k);
					$res2=mysql_query($sql2);
					if(mysql_num_rows($res2) === 0) {
						//printf("droped %s <br>",$m[1] );
						// $rsql_buf= $rsql_buf."INSERT INTO `".av_top."` VALUES(NULL,'".$dt_us."','".$m[0] ."','0','".$sid."');\n";
						$rtop = @mysql_query("INSERT INTO `".av_top."` VALUES(NULL,'".$dt_us."','".$m[0] ."','0','".$sid."')");
						if ($m[8] <> 0) {
							$rbuf = @mysql_query("UPDATE `".list_avatars."` set is_top = '0', date_up = '".$dt_us."' where id = '".$m[0]."' ");
						}
					} else {
						//printf("%s <br>", $m[2] );
					}
					$k++;
				}
		while ($m = mysql_fetch_array($res));
		}

//Заполнение статусов ГИ
log_server("start","list_AV_process - status GUI");
$sql = "SELECT * FROM ".table_buffer_av." 
LEFT JOIN classes
ON ".table_buffer_av.".class = ".table_class.".name
WHERE  sid = ".$sid." and cid= ".$cid." ";


	$res=mysql_query($sql);
	if ($m = mysql_fetch_array($res))
		{
			do
				{
					$sql2 = "SELECT * FROM  ".list_gui." where ".list_gui.".srv_id = ".$sid." and gui_name ='". $m[3]."' ";
					$res2=mysql_query($sql2);
					$m2 = mysql_fetch_array($res2);
					$sql3 = "SELECT * FROM  ".list_avatars." where ".list_avatars.".s_id = ".$sid." and av_name ='". $m[2]."' and c_id = '".$cid."' ";					
					$res3=mysql_query($sql3);
					$m3 = mysql_fetch_array($res3);
					
					$sql4 = "SELECT * FROM  ".av_gui." where av_id = ".$m3[0]."  ";
					//if (mysql_errno() <> 0) {
			//			echo mysql_errno();
						echo mysql_error();
					//printf ("<br>-------------<br><small> %s <br> %s <br> %s <br> %s</small><br>",$sql4,$sql3,$sql2,$sql);			
					//}

					//printf ("<small> %s </small><br>",$sql4);				
					$res4=mysql_query($sql4);
					$m4 = mysql_fetch_array($res4);
					if(mysql_num_rows($res4) === 0) {						
						//Данный av_id не имел связи с ГИ.
						if (mysql_num_rows($res2) === 0) {
							//ГИ не найдена в списке ГИ
							if (strlen($m[3])>0){
								//Но ГИ есть у игрока
								$gild_id = 0;
							} else {
								$gild_id ="-1";
							}
						} else {
							$gild_id=$m2[0]; 
						}

						$rtop = @mysql_query("INSERT INTO `".av_gui."` VALUES(NULL,'".$dt_us."','".$m3[0] ."','".$gild_id."')");
						
					} else {
					// Линк существовал.
						if (mysql_num_rows($res2) === 0) {
							//ГИ не найдена в списке ГИ
							if (strlen($m[3])>0){
								//Но ГИ есть у игрока
								$gild_id = 0;
							} else {
								$gild_id ="-1";
							}
						} else {
							$gild_id = $m2[0];
						}
						if ($gild_id == $m4[3]) {
							//ГИ не изменилась 
						} else {							
							//ГИ изменилась $gild_id - новая, $m4[3] -старая.$m3[0] - аватар
							$rtop = @mysql_query("INSERT INTO `".av_chg."` VALUES(NULL,'".$dt_us."','3','".$m3[0]."','".$m4[3]."','".$gild_id."')");
							$rtop = @mysql_query("UPDATE `".av_gui."` set gui_id = '".$gild_id."', date = '".$dt_us."' where av_id = '".$m3[0]."' ");
						}
					}
					//printf("%s - %s (%s-%s)<br>", $m[3],$m2[0], $m3[3],$m3[0] );
				}
		while ($m = mysql_fetch_array($res));
		}
//Заполнение данных из буфера
log_server("start","list_AV_process - copying data");
$sql = "SELECT ".table_buffer_av.".*
  ,".list_avatars.".av_name
  ,".list_avatars.".id
  ,".list_avatars.".c_id
FROM
  ".table_buffer_av."

LEFT JOIN classes
ON ".table_buffer_av.".class = classes.name

LEFT JOIN ".list_avatars."
ON ".table_buffer_av.".nikname = ".list_avatars.".av_name
where (".list_avatars.".c_id = ".$cid." and classes.cid = ".$cid." and sid = ".$sid." and s_id = ".$sid." and ".list_avatars.".is_top = 1 )";
	$res=mysql_query($sql);
	if ($m = mysql_fetch_array($res))
		{
			do
				{
					//printf("%s <br>", $m[6] );
					$rtop = @mysql_query("INSERT INTO `".av_data."` VALUES(NULL,'".$dt_us."','".$sid."','".$m[10]."','".$m[1]."','".$m[4]."','".$m[11]."')");
				}
		while ($m = mysql_fetch_array($res));
		}

//printf("%s <br><br>Next Server <br><br>", $sql);
echo $rsql_buf;
}
function post_process_AV($sid,$cid,$dt_us) {
$sql="select sum(rate) as e1 from `".av_data."` where date='".$dt_us."' and srv_id ='".$sid."' and c_id ='".$cid."'";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				if ($m[0] == null){
				} else {
					$rtop = @mysql_query("INSERT INTO `".calc_data."` VALUES(NULL,'".$dt_us."','".$sid."','2','".$cid."','".$m[0]."',NULL)");
					//printf("%s <br> %s - %s <br>",$sid, $cid, $m[0] );
				}
			}
	while ($m = mysql_fetch_array($res));
	}

}
function post_process_AV_rate_GUI($sid,$dt_us) {
$sql = "select * from `".list_gui."` where srv_id ='".$sid."'";


$res=mysql_query($sql);

if ($m = mysql_fetch_array($res))

	{
		do
			{
				//printf("<h1>%s</h1>",$m[2]);
				$gui_id=$m[0];
				$sql2 = "select *,sum(rate) from ".av_gui."
				  left join ".av_data."
				  on ".av_gui.".av_id = ".av_data.".av_id  
				  where ".av_gui.".gui_id ='".$gui_id."' 
				  and ".av_gui.".date < subdate('".$dt_us."', INTERVAL -1 DAY)
				  and ".av_data.".date = '".$dt_us."'
				  group by c_id";

				  $sql4 ="SELECT *,sum(rate)
					FROM
					  ".av_chg."
					LEFT JOIN av_data
					ON ".av_chg.".av_id = ".av_data.".av_id

					WHERE
					  ".av_chg.".date = subdate('".$dt_us."', INTERVAL -1 DAY)
					  AND ".av_data.".`date` = '".$dt_us."'
					  AND ".av_chg.".type = 3
					  AND ".av_chg.".prev_data = '".$gui_id."'
					  group by c_id";


				$res2=mysql_query($sql2);
				
				if ($m2 = mysql_fetch_array($res2))
					{
						do
							{
								$rtop = @mysql_query("INSERT INTO `".calc_data."` VALUES(NULL,'".$dt_us."','".$sid."','3','".$m2[10]."','".$m2[11]."','".$gui_id."')");
								//printf("%s - %s<br>",$m2[10],$m2[11]);
							}
					while ($m2 = mysql_fetch_array($res2));
					}
				$res4=mysql_query($sql4);
				//echo "---------------------<br>";
				
				if ($m4 = mysql_fetch_array($res4))
					{
						do
							{	
								$sql_chk = "SELECT * FROM  `".calc_data."` where s_id = ".$sid." and type = 3 and sep ='".$m4[12]."' and data_str ='".$gui_id."' ";					
								$res_chk=mysql_query($sql_chk);
								if(mysql_num_rows($res_chk) === 0) {
									//echo "NULL";
									$rtop = @mysql_query("INSERT INTO `".calc_data."` VALUES(NULL,'".$dt_us."','".$sid."','3','".$m4[12]."','".$m4[13]."','".$gui_id."')");

								} else {
									$m_chk = mysql_fetch_array($res_chk);
									$sm=$m_chk[5]+$m4[13];
									$rtop = @mysql_query("UPDATE `".calc_data."` set data ='".$sm."' where id = '".$m_chk[0]."'");
									
									//echo "UPDATE `".calc_data."` set data ='".$sm."' where id = '".$m_chk[0]."'";
									//echo"<br>";
									//echo $m_chk[5]+$m4[13]."<br>";

								}
								//printf("%s - %s<br>",$m4[12],$m4[13]);
							}
					while ($m4 = mysql_fetch_array($res4));
					}
				echo mysql_error();				
				//echo "<br>";
			}
	while ($m = mysql_fetch_array($res));
	}

}

function post_process_GUI($sid,$dt_us) {
$sql="select sum(avt) as e1 from `".gui_data."` where date='".$dt_us."' and srv_id ='".$sid."'";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				if ($m[0] == null){
				} else {
					$rtop = @mysql_query("INSERT INTO `".calc_data."` VALUES(NULL,'".$dt_us."','".$sid."','1','0','".$m[0]."',NULL)");
					//printf("%s <br> %s - %s <br>",$sql, $sid, $m[0] );
				}
			}
	while ($m = mysql_fetch_array($res));
	}
}
function getGUIstate_srv($id,$dtt) {
    $sql = "select * from `".gui_data."` where gui_id ='".$id."' and date <> '2013.01.28' and date = '".$dtt."' order by date desc";
    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
    if(mysql_num_rows($res) ===1) {
      $mz[2]=$m[5];
      $mz[3]=1;
    }
    return $mz;
  }

function srch_renames_gui($sid,$dt_us,$coef_us) {
$sql="SELECT *
FROM
  `".gui_top."`
LEFT JOIN `".gui_data."`
ON `".gui_top."`.gui_id = `".gui_data."`.gui_id

WHERE
  top_status = 1
  AND `".gui_top."`.date = '".$dt_us."'
  AND `".gui_top."`.srv_id = '".$sid."'
  AND `".gui_data."`.date = '".$dt_us."'

  AND `".gui_data."`.pos < '95'";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{

				printf("<b>%s  (pos=%s)</b><br>", $m[2] ,$m[9], $m[9] );

			}
	while ($m = mysql_fetch_array($res));
	}


}
function srch_renames($sid,$cid,$dt_us,$coef_us) {
//$sql="SELECT * FROM  ".list_avatars." WHERE  date = '".$dt_us."'  AND s_id = '".$sid."'  AND c_id = '".$cid."'";


$sql="SELECT ".list_avatars.".*,".av_data.".*
FROM
  ".list_avatars."
LEFT JOIN ".av_data."
ON ".list_avatars.".id = ".av_data.".av_id
WHERE
  ".list_avatars.".date = '".$dt_us."'
  and ".av_data.".date = '".$dt_us."'
  AND ".list_avatars.".s_id = '".$sid."' 
  AND ".list_avatars.".c_id = '".$cid."'
  and ".av_data.".pos < '95'";

//Запрос к листу автаров для получения новых топов
  //echo $sql;
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{

				printf("<b>%s  - %s(ID=%s)</b><br>", $m[3] ,$m[13], $m[0] );
				//Запрос на выбывших аватаров подходящих по параметрам к найденным
				$sql2="SELECT ".av_top.".*
				     , ".list_avatars.".*
				     , ".av_data.".*
				FROM
				  ".av_top."
				LEFT JOIN ".list_avatars."
				ON ".av_top.".av_id = ".list_avatars.".id
				LEFT JOIN av_data
				ON ".av_top.".av_id = ".av_data.".av_id

				WHERE
				  ".av_top.".date = '".$dt_us."'
				  and ".av_data.".date =  subdate('".$dt_us."', INTERVAL 1 DAY)
				  AND ".av_top.".top_status = 0
				  AND ".list_avatars.".c_id = '".$cid."'
				  AND ".list_avatars.".f_id = '".$m[6]."'
				  AND ".list_avatars.".r_id = '".$m[7]."'
				  AND ".av_top.".srv_id = '".$sid."'
				  AND (".av_data.".pos between ".intval($m[13]-$coef_us)." and ".intval($m[13]+$coef_us).")";
				// printf("<small>%s</small>  <br>", $sql2 ,$m[13], $m[0] );
				$res2=mysql_query($sql2);
				if ($m2 = mysql_fetch_array($res2))
					{
						do
							{
								//$ss="INSERT INTO `".renames."` VALUES(NULL,'".$dt_us."','".$dt_us."','". $m[0] ."','".$m2[17]."','".$sid."','1')";
								//printf("-----------!%s  - %s(ID=%s)<br>%s<br>", $m2[8] ,$m2[18], $m2[17],$ss);
								$rtop = @mysql_query("INSERT INTO `".renames."` VALUES(NULL,'".$dt_us."','".$dt_us."','". $m[0] ."','".$m2[17]."','".$sid."','1')");
							}
						while ($m2 = mysql_fetch_array($res2));
					}	








			}
	while ($m = mysql_fetch_array($res));
	}


}
function av_data_days($dtt) {
	$rtop = @mysql_query("truncate table `".av_data_cur."`");
	$rtop = @mysql_query("truncate table `".av_data_7."`");
	$rtop = @mysql_query("truncate table `".av_data_14."`");
	$rtop = @mysql_query("truncate table `".av_data_28."`");

	echo mysql_error();
	$rtop = @mysql_query("INSERT INTO `".av_data_cur."` SELECT * from `".av_data."` where date ='".$dtt."' ");
	echo mysql_error();
	$rtop = @mysql_query("INSERT INTO `".av_data_7."` SELECT * from `".av_data."` where date = subdate('".$dtt."', INTERVAL 7 DAY) ");
	echo mysql_error();
	$rtop = @mysql_query("INSERT INTO `".av_data_14."` SELECT * from `".av_data."` where date = subdate('".$dtt."', INTERVAL 14 DAY) ");
	$rtop = @mysql_query("INSERT INTO `".av_data_28."` SELECT * from `".av_data."` where date = subdate('".$dtt."', INTERVAL 28 DAY) ");

	echo mysql_error();
}

function pos_lvl_chg($sid) {
$sql = "select * from `".list_gui."` where srv_id ='".$sid."'";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				$sql2 = "select * from `".gui_data."` where gui_id ='".$m[0]."'  group by lvl order by date";
				$res2=mysql_query($sql2);
				if ($m2 = mysql_fetch_array($res2))
				{
					do
						{
							//printf ("<b> %s </b> - %s - %s<br>",$m[2],$m2[1],$m2[6]);
							$rtop = @mysql_query("INSERT INTO `".pos_chg."` VALUES(NULL,'".$sid."','".$m2[1]."','1','0','".$m[0]."','".$m2[6]."')");
						}
					while ($m2 = mysql_fetch_array($res2));
					}
				$sql2 = "select * from `".gui_data."` where gui_id ='".$m[0]."'  group by pos order by date";
				$res2=mysql_query($sql2);
				if ($m2 = mysql_fetch_array($res2))
				{
					do
						{
							//printf ("<b> %s </b> - %s - %s<br>",$m[2],$m2[1],$m2[6]);
							$rtop = @mysql_query("INSERT INTO `".pos_chg."` VALUES(NULL,'".$sid."','".$m2[1]."','2','0','".$m[0]."','".$m2[4]."')");
						}
					while ($m2 = mysql_fetch_array($res2));
					}					
			}
	while ($m = mysql_fetch_array($res));
	}
}
function gui_data_srv($sid,$dtt) {
$sql = "select * from `".list_gui."` where srv_id ='".$sid."'";

$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				$sql_1 = "select * from `".gui_data."` where gui_id ='".$m[0]."' and date ='".$dtt."' ";
				$res_1=mysql_query($sql_1);				
				$sql_2 = "select * from `".gui_data."` where gui_id ='".$m[0]."' and date = subdate('".$dtt."', INTERVAL 14 DAY) ";				
				$res_2=mysql_query($sql_2);
				$sql_3 = "SELECT count(*) FROM ".av_gui." WHERE  gui_id = '".$m[0]."'";
				$res_3=mysql_query($sql_3);
				$sql_4 = "SELECT sum(data) FROM ".calc_data."  WHERE  data_str ='".$m[0]."'  and date ='".$dtt."'";
				$res_4=mysql_query($sql_4);
				$sql_5 = "SELECT sum(data) FROM ".calc_data."  WHERE  data_str ='".$m[0]."'  and date =subdate('".$dtt."', INTERVAL 14 DAY)";
				$res_5=mysql_query($sql_5);
				$sql_6 = "SELECT count(*) from  ".av_gui."  left JOIN  ".list_avatars."  on ".av_gui.".av_id=".list_avatars.".id    where gui_id ='".$m[0]."' and is_top = 1";
				$res_6=mysql_query($sql_6);
				if (mysql_num_rows($res_1)) {
					$m_1 = mysql_fetch_array($res_1);
					$m_2 = mysql_fetch_array($res_2);
					$m_3 = mysql_fetch_array($res_3);
					$m_4 = mysql_fetch_array($res_4);
					$m_5 = mysql_fetch_array($res_5);
					$m_6 = mysql_fetch_array($res_6);
					//printf ("%s - %s - %s - %s - %s - %s - %s<br>",$m[0],mysql_num_rows($res_1),mysql_num_rows($res_2),mysql_num_rows($res_3),mysql_num_rows($res_4),mysql_num_rows($res_5),mysql_num_rows($res_6));
					//printf ("%s - %s - %s - %s - %s - %s - %s - %s - %s - %s - %s<br>",$m[0],$m_1[4],$m_1[5],$m_1[6],$m_2[4],$m_2[5],$m_2[6],$m_3[0],$m_4[0],$m_5[0],$m_6[0]);
					$rf = @mysql_query("INSERT INTO `".vs_gui."` VALUES(NULL,'".$sid."','".$m[0]."','".$m_1[5]."','".$m_2[5]."','".$m_1[4]."','".$m_2[4]."','".$m_3[0]."','".$m_6[0]."','".$m_4[0]."','".$m_5[0]."','".$m_1[6]."','".$m_2[6]."')");
				}
			}
	while ($m = mysql_fetch_array($res));
	}
}
function define_gui_frake($sid) {

$sql = "select * from `".list_gui."` where srv_id ='".$sid."' and frake_id is null";
$res=mysql_query($sql);
if ($m = mysql_fetch_array($res))
	{
		do
			{
				$sql2="select count(f_id) as e1,f_id from `".av_gui."`
				  left join ".list_avatars." 
				  on `".av_gui."`.av_id = ".list_avatars." .id
				  where gui_id =".$m[0]."
				  group by f_id
				  order by e1 desc";
				$res2=mysql_query($sql2);
				if (mysql_num_rows($res2)){
					$m2 = mysql_fetch_array($res2);
					$rbuf = @mysql_query("UPDATE `".list_gui."` set frake_id = '".$m2[1]."' where id = '".$m[0]."' ");
					//echo $m2[1]."!!!!!";
				}
				//printf ("%s <br>",$m[2]);
			}
	while ($m = mysql_fetch_array($res));
	}




}

?>