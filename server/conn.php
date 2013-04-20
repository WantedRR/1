<?


    $catid= @intval($catid);
    $id= @intval($id);
    $fid= @intval($fid);

ini_set("max_execution_time", "600");
Error_Reporting(E_ALL & ~E_NOTICE);
//Error_Reporting(0);
$db_name="desperado";	//aaca aaiiuo
$table="frake";		//oaaeeoa
$host="localhost";	//oino
$user="desperado";
$pass="#fgr723FtesI";
$link = mysql_connect($host,$user,$pass) or exit("DB Error... ");
//mysql_query("SET NAMES cp1251");
mysql_query("SET NAMES utf8");

define ("table_server","servers");
define ("table_class","classes");
define ("table_logs_server","log_server");

define ("table_buffer_av","buffers_av");

define ("table_buffer_gui","buffers_gui");
define ("table_buffer_gui_arhive","buffers_gui_arhive");
define ("list_gui","list_gui2");
define ("list_avatars","av_list");
define ("gui_top","gui_top_status");
define ("av_top","av_top_status");
define ("gui_data","data_gui");
define ("av_data","av_data");
define ("av_data_cur","av_data_cur");
define ("av_data_7","av_data_7");
define ("av_data_14","av_data_14");
define ("av_data_28","av_data_28");
define ("race_list","races");
define ("frake_list","frake");
define ("av_chg","av_chg_data");
define ("av_gui","av_gui_link");
define ("renames","av_renames");
define ("calc_data","all_calc");
define ("pos_chg","pos_lvl_chg");
define ("vs_gui","view_srv_gui");
define ("vs_gui_test","view_srv_gui_test");





//echo mysql_error();
mysql_select_db("$db_name",$link);
function log_action($xus,$xact,$xinfo) { 
	$rlog = @mysql_query("INSERT INTO `".table_logs."` VALUES(NULL,'".$_SERVER['REQUEST_URI']."','".date("Y.m.d H:i:s")."','".$_SERVER["REMOTE_ADDR"]."','".$xus."','".$xact."','".$xinfo."')");
}																										  
function log_server($xact,$xinfo) { 
	$rlog = @mysql_query("INSERT INTO `".table_logs_server."` VALUES(NULL,'".date("Y.m.d H:i:s")."','".$xact."','".$xinfo."')");
}
function insert_buff_av($pos,$nick,$guild,$rate,$class,$race,$frake,$sid) { 
	$nick=iconv('cp1251', 'utf-8', $nick);
	$guild=iconv('cp1251', 'utf-8', $guild);
	$class=iconv('cp1251', 'utf-8', $class);
	$race=iconv('cp1251', 'utf-8', $race);
	$frake=iconv('cp1251', 'utf-8', $frake);
	$rbuf = @mysql_query("INSERT INTO `".table_buffer_av."` VALUES(NULL,'".$pos."','".$nick."','".$guild."','".$rate."','".$class."','".$race."','".$frake."','".$sid."')");
}
function insert_buff_gui($pos,$gui_name,$gui_lvl,$rate,$sid) { 
	//printf ("%s -%s<br>",$gui_name,iconv('cp1251', 'utf-8', $gui_name));
	$gui_name=iconv('cp1251', 'utf-8', $gui_name);
	$rbuf = @mysql_query("INSERT INTO `".table_buffer_gui."` VALUES(NULL,'".$pos."','".$gui_name."','".$gui_lvl."','".$rate."','".$sid."')");
}		
?>
