<?
echo '<script src="/core/search/js/sub.js" type="text/javascript" language="javascript"></script>';
echo '<script src="/core/search/js/search_dev.js" type="text/javascript" language="javascript"></script>';
function checksrch($name) {
	$name = trim($name);
	if( strlen($name)>64) return -1;
	if (!preg_match("/^[(\w) .:,-_а-яА-Я]+$/",$name)) return -1;
	if (strstr($name,"--")) return -1;
		
	return $name;
}
echo strpos($name,"--");
if (checksrch($_POST["strsrch"])<> -1 ){
	$mr=mysql_fetch_array(mysql_query("SELECT count(*) as e FROM ".table_sw." WHERE ask='".$_POST['strsrch']."'"));
	//echo "SELECT * FROM ".table_sw." WHERE ask='".$_POST['strsrch']."'";
	log_action($_SESSION['g'],"SEARCH",$_POST['strsrch']);
	if($mr["e"]==0) {
		//echo "0";
		$r = @mysql_query("INSERT INTO ".table_sw." VALUES(NULL,'".$_POST['strsrch']."','1','".date("Y.m.d H:i:s")."','".date("Y.m.d H:i:s")."')");
		//echo "INSERT INTO ".table_sw." VALUES(NULL,'".$_POST['strsrch']."','1','".date("Y.m.d H:i:s")."','".date("Y.m.d H:i:s")."')";
	} else{
		//echo "1";
		$r = @mysql_query("UPDATE ".table_sw." SET count=count+1, datec='".date("Y.m.d H:i:s")."' WHERE ask = '".$_POST['strsrch']."'");	
	}
	

echo '<div class="add_art">';
echo '<div class="add_info">';
echo '<div id="srch_result">';
echo '<p>Результаты поиска по запросу <strong>'.$_POST['strsrch'].'</strong></p>';
echo '<input type="hidden" name="htext" id="htext" value="'.$_POST['strsrch'].'" />';
echo '<input type="hidden" name="hlim" id="hlim" value="0">';
echo '<input type="hidden" name="hmax" id="hmax" value="0">';
echo '<input type="hidden" name="frmlim" id="frmlim" value="0">';
echo '<input type="hidden" name="frmmax" id="frmmax" value="0">';
echo '<input type="hidden" name="storlim" id="storlim" value="0">';
echo '<input type="hidden" name="stormax" id="stormax" value="0">';
echo '<input type="hidden" name="fotolim" id="fotolim" value="0">';
echo '<input type="hidden" name="fotomax" id="fotomax" value="0">';
//echo '<div id="srch_load"><img src=".\loading\loading29.gif">Loading......</div>';
echo '<div class="razd_frm">
		<table width="690px" class="razd_frm_table" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td class="frm_table_left"></td>
		    <td valign ="top" width = "30px" onclick="showsub(1)"> <div id="page_load"><img src="/core/search/img/load_big.gif" height="30px"></div></td>
		    <td valign ="top" width="590px" onclick="showsub(1)" class="addinfo"><br><b>Результаты поиска в статьях</b> <b id="art_result"></b></td>
		    <td class="frm_table_left">';
echo'</td></tr></table></div>';
echo "<div class=\"sub_razd\"id=\"sub_1_\"><div id=\"srch_art\">s</div>";
echo'<table width="100%" class="sub_table" border="0" cellspacing="0" cellpadding="0">
     <tr class="bot_form_view">';
echo'<td class="pinfo">Страницы <a nv="searchbut" id="plnk">&lt;предидущая</a>&nbsp;&nbsp;&nbsp;<a nv="searchbut" id="nlnk">следующая&gt;</a>';
echo'</td></tr></table></div>';





echo '<div class="razd_frm">
		<table width="690px" class="razd_frm_table" border="0" cellspacing="0" cellpadding="0">
		  <tr>
		    <td class="frm_table_left"></td>
		    <td valign ="top" width = "30px" onclick="showsub(3)"> <div id="stor_load"><img src="/core/search/img/load_big.gif" height="30px"></div></td>
		    <td valign ="top" width="590px" onclick="showsub(3)" class="addinfo"><br><b>Результаты поиска в магазине</b> <b id="store_result"></b></td>
		    <td class="frm_table_left">';
echo'</td></tr></table></div>';
echo "<div class=\"sub_razd\"id=\"sub_3_\"><div id=\"srch_stor\"></div>";
echo'<table width="100%" class="sub_table" border="0" cellspacing="0" cellpadding="0">
     <tr class="bot_form_view">';
echo'<td class="pinfo">Страницы <a nv="searchbut" id="pstor">&lt;предидущая</a>&nbsp;&nbsp;&nbsp;<a nv="searchbut" id="nstor">следующая&gt;</a>';
echo'</td></tr></table></div>';








//echo '<div id="srch_forum"></div><div id="navs_forum">as2</div>';
//echo '<div id="srch_mag"></div><div id="navs_mag">as3</div>';
//echo '<div id="srch_foto"></div><div id="navs_foto">as4</div>';




}
echo '</div>';
echo '</div>';
echo '</div>';

?>
