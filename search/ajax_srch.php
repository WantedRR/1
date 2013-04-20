<?
function checksrch($name) {
	$name = trim($name);
	//if (!preg_match("/^[(\w) .:,-_]+$/",$name)) return -1;
	return $name;
}
setlocale(LC_ALL, array('ru_RU.CP1251', 'Russian_Russia.1251'));
require_once("../../libary/phpmorphy-0.3.7/src/common.php");
require_once("../cnct.php.inc");
$dir = '../../libary/phpmorphy-0.3.7/dicts';
$lang = 'ru_RU';
$opts = array(
		'storage' => PHPMORPHY_STORAGE_MEM,
		'with_gramtab' => false,
		'predict_by_suffix' => true, 
		'predict_by_db' => true
	);


if (checksrch($_POST["strsrch"])<> -1 ){
$ff=trim(mysql_real_escape_string(iconv("UTF-8", "WINDOWS-1251", $_POST['strsrch'])));
//$ff=iconv("WINDOWS-1251", "WINDOWS-1251", $_POST['strsrch']);
try {
    $morphy = new phpMorphy($dir, $lang, $opts);
} catch(phpMorphy_Exception $e) {
    die(': ' . $e->getMessage());
}
$word = $ff;
$word = strtoupper(iconv("WINDOWS-1251", "WINDOWS-1251", $word));

$words = preg_split('#\s|[ ]#', $word, -1, PREG_SPLIT_NO_EMPTY);
$en_words;
	$bulk_words = array();
	foreach ( $words as $v )
	if ( strlen($v) > 3 ) {
		$bulk_words[] = strtoupper($v);
		if (preg_match("/^[a-zA-Z0-9]+$/",$v)) $en_words=$en_words." +".$v;
	}
	
	$base_form = $morphy->getBaseForm($bulk_words);
	
	$fullList = array();
	if ( is_array($base_form) && count($base_form) )
		foreach ( $base_form as $k => $v )
			//echo  $k;
			//echo "<br>";
			if ( is_array($v) ) 
				foreach ( $v as $v1 )
					if ( strlen($v1) > 3 )
						$fullList[$v1] = 1;
	
	$words = join(' +', array_keys($fullList));
if ($_POST["tbl"] == $table_art) {
	sleep(1);
} else {
	sleep(1);
}
//echo "<br><br>".$_POST["tbl"];
if ($_POST["tbl"] == table_art) {
//left outer join ".table_menu."  on ".table_art.".sub= ".table_menu.".path
$tmax="hmax";
$countmax="art_result";
$sql_s="SELECT SQL_CALC_FOUND_ROWS *, 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `".table_si."` i
  left join `".table_art."` a on a.sub=i.t_id
  WHERE (weight = '0' or weight ='1') and `name` <>'' and hide <>'2' and type <>'1' and catid <> '-1' and `table`='".table_art."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  group by sub
  ORDER BY rel DESC LIMIT ".$_POST["lim"].",10 ";
  
  $sql_2="SELECT SQL_CALC_FOUND_ROWS count(*), 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `".table_si."` i
  left join `".table_art."` a on a.sub=i.t_id
  WHERE (weight = '0' or weight ='1') and `name` <>'' and hide <>'2' and type <>'1' and catid <> '-1' and `table`='".table_art."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  ORDER BY rel DESC";
} 
if ($_POST["tbl"] == $table_frm) {
$tmax="frmmax";
$countmax="frm_result";
$sql_s="SELECT SQL_CALC_FOUND_ROWS *, 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `$table_si` i
  left join `$table_frm` a on a.id=i.t_id left join `$table_frm` a2 on a2.id=a.parentid
  WHERE a.state='1' and `table`='".$table_frm."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  ORDER BY rel DESC LIMIT ".$_POST["lim"].",10 ";
  
  $sql_2="SELECT SQL_CALC_FOUND_ROWS count(*), 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `$table_si` i
  left join `$table_frm` a on a.id=i.t_id
  WHERE `state`='1' and `table`='".$table_frm."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  ORDER BY rel DESC";
} 
if ($_POST["tbl"] == table_products) {

$tmax="stormax";
$countmax="store_result";
$sql_s="SELECT SQL_CALC_FOUND_ROWS *, 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `".table_si."` i left join `".table_products."` a  on a.productID=i.t_id
  WHERE `table`='".table_products."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  ORDER BY rel DESC LIMIT ".$_POST["lim"].",5 ";
  
  $sql_2="SELECT SQL_CALC_FOUND_ROWS count(*), 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `".table_si."` i left join `".table_products."` a  on a.productID=i.t_id
  WHERE `table`='".table_products."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  ORDER BY rel DESC";
}
if ($_POST["tbl"] == $table_foto) {
$tmax="fotomax";
$countmax="foto_result";
$sql_s="SELECT SQL_CALC_FOUND_ROWS *, 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `$table_si` i left join `aa_foto` a  on a.sub=i.t_id
  WHERE `table`='".$table_foto."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  ORDER BY rel DESC LIMIT ".$_POST["lim"].",12 ";
  
  $sql_2="SELECT SQL_CALC_FOUND_ROWS count(*), 
  MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) AS rel 
  FROM `$table_si` i left join `aa_foto` a  on a.sub=i.t_id
  WHERE `table`='".$table_foto."' and MATCH (text_orig,text_index) 
  AGAINST ('>".$ff." <".$words.$en_words."' IN BOOLEAN MODE) 
  ORDER BY rel DESC";
} 

//echo $sql_2;
//echo "<br><br>";
//echo $sql_s;
//$sql_s="SELECT SQL_CALC_FOUND_ROWS *, MATCH (text_orig,text_index) AGAINST ('>".$ff." <(+".$words.$en_words.")' IN BOOLEAN MODE) AS rel FROM `$table_si` WHERE MATCH (text_orig,text_index) AGAINST ('>".$ff." <(+".$words.$en_words.")' IN BOOLEAN MODE) ORDER BY rel DESC LIMIT 0, 10";
$q2=mysql_query($sql_2);
if(mysql_num_rows($q2)===1){
$r2=mysql_fetch_array($q2);

}
//
 

$q=mysql_query($sql_s);
if(mysql_num_rows($q2)){
while ($m =mysql_fetch_array($q))
	{
		if ($_POST["tbl"] == $table_foto) {
								printf("<a href=\"http://%s/inc/foto/vers.php?bid=1&fd=%s\" rel=\"clearbox[gallery=b%s,,type=image,,tnhrf=http://%s/foto/small/%s,,title=%s,,dlhrf=http://%s/?catid=%s&amp;id=%s&amp;&fid=%s]\"><img src=/inc/foto/vers.php?mid=1&fd=%s alt=\"%s\" class=\"imgsrc\"></a> ", $_SERVER['SERVER_NAME'],$r[6],$r[0], $_SERVER['SERVER_NAME'],$r[6],$r[10],$_SERVER['SERVER_NAME'], $r[0], $r[0],$r[6],$r[6],  $r[11]);
		}else{
			echo '<div class="sub"><table  class="sub_table" border="0" cellspacing="0" cellpadding="0">';
			if ($key ==1){
			  echo'<tr class="subtbl1">';
			} else{
			  echo'<tr>';				
			}
			$dt=substr_replace($r2[8],'',16,16);

			  echo'<td width="30px"></td>
			    <td width="100%">';
				if ($_POST["tbl"] == table_art) {
					/////
				echo "<div class=\"add_info\"><table width=\"100%\"><tr><td width=\"1%\">";				
				if (strlen($m["al"]) >1) {				
				} else{
					
					$s= "select i.alias,a.type,a.path,a.img from ".table_cat." i left join ".table_menu." a on a.alias=i.alias   where i.id ='".$m["catid"]."'";
					$r=mysql_query($s);
					$ma = mysql_fetch_array($r);
					$temp_cat=$cat_alias;
					$cat_alias=$ma[0];
					$sub_type=$ma[1];
				if 	(strlen($ma[0])>1){
				
				if ($ma[2]==$m["sub"]){
				$f= "../../core/menu/img/".$ma[3];	
				if(!file_exists($f) or strlen($ma[3])<1){
					printf("<a href=\"http://%s/%s/\"><img src=\"/core/content/img/%s\" alt =\"%s\" border = 0/></a></td>",$_SERVER['SERVER_NAME'], $ma[0],"noimage.jpg",$m["name"]);
				}else{
					printf("<a href=\"http://%s/%s/\"><img src=\"/core/menu/img/%s\" alt =\"%s\" border = 0/></a></td>",$_SERVER['SERVER_NAME'], $ma[0],$ma[3],$m["name"]);
				}
				printf("<td valign=\"top\"><a href=\"http://%s/%s/\">%s</a><br><br>",$_SERVER['SERVER_NAME'], $ma[0],$m["name"]);
				if (strlen($m["annot"]) <1) {
					$annot= strip_tags(substr($m["text"], 0, 200))." ...";
				} else{
					$annot =$m["annot"];
				}
				printf("<a href=\"http://%s/%s/\" class=\"annot\">%s</a>",$_SERVER['SERVER_NAME'], $ma[0],$m["descr"]);
				printf("<div class=\"more\"><a href=\"http://%s/%s/\" class=\"annot\"><img src=\"/core/content/img/next.gif\"  border = 0/></a></div>",$_SERVER['SERVER_NAME'],$ma[0],$annot);
				echo "</td></tr></table></div>";
				} else {
				$f= "../../core/content/img/".$m["image"];
				if(!file_exists($f) or strlen($m["image"])<1){
					printf("<a href=\"http://%s/%s/%s.html\"><img src=\"/core/content/img/%s\" alt =\"%s\" border = 0></a></td>",$_SERVER['SERVER_NAME'], $cat_alias,$m["alias"],"noimage.jpg",$m["name"]);;
				} else {
					printf("<a href=\"http://%s/%s/%s.html\"><img src=\"/core/content/img/%s\" alt =\"%s\" border = 0></a></td>",$_SERVER['SERVER_NAME'], $cat_alias,$m["alias"],$m["image"],$m["name"]);
				}
				printf("<td valign=\"top\"><a href=\"http://%s/%s/%s.html\">%s</a><br><br>",$_SERVER['SERVER_NAME'], $cat_alias,$m["alias"],$m["name"]);
				if (strlen($m["annot"]) <1) {
					$annot= strip_tags(substr($m["text"], 0, 200))." ...";
				} else{
					$annot =$m["annot"];
				}
				printf("<a href=\"http://%s/%s/%s.html\" class=\"annot\">%s</a>",$_SERVER['SERVER_NAME'], $cat_alias,$m["alias"],$annot);
				printf("<div class=\"more\"><a href=\"http://%s/%s/%s.html\" class=\"annot\"><img src=\"/core/content/img/next.gif\"  border = 0/></a></div>",$_SERVER['SERVER_NAME'], $cat_alias,$m["alias"],$annot);
				
				}
				
				}
				echo "</td></tr></table></div>";
				}
									
					///////
					//printf("<a href=\"http://%s/?catid=%s&amp;id=%s\" target=\"_blank\">%s</a>",$_SERVER['SERVER_NAME'],$r[8],$r[9],$r[13],$r2[1]);
				}
				if ($_POST["tbl"] == $table_frm) {

					printf("<a href=\"http://%s/frm/%s/content/%s-%s.html\" target=\"_blank\">%s</a>",$_SERVER['SERVER_NAME'],$r[31],$r[18],$r[2],$r[7]);
				}
				if ($_POST["tbl"] == $table_products) {
					$prev= "../store/products_pictures/".$r[14];					
					if (file_exists($prev)){
						printf("<a href=\"http://%s/store/index.php?productID=%s\" target=\"_blank\"><img src=\"/store/products_pictures/%s\" align = left class=\"imgsrc\"></a>",$_SERVER['SERVER_NAME'],$r[6],$r[14],$r[2],$r[7]);
					} else {
											
					}
					printf("<a href=\"http://%s/store/index.php?productID=%s\" target=\"_blank\">%s</a><p>%s</p>",$_SERVER['SERVER_NAME'],$r[6],$r[8],$r[19],$r[7]);
				}
			//	if ($_POST["tbl"] == $table_foto) {

			//		printf("<a href=\"http://%s/inc/foto/vers.php?bid=1&fd=%s\" rel=\"clearbox[gallery=b%s,,type=image,,tnhrf=http://%s/foto/small/%s,,title=%s,,dlhrf=http://%s/?catid=%s&amp;id=%s&amp;&fid=%s]\"><img src=/inc/foto/vers.php?mid=1&fd=%s alt=\"%s\" class=\"imgsrc\"></a> ", $_SERVER['SERVER_NAME'],$r[5],$r[0], $_SERVER['SERVER_NAME'],$r[6],$r[10],$_SERVER['SERVER_NAME'], $r[0], $r[0],$r[5],$r[5],  $r[10]);
				//}
				echo '<br></td>
			    <td width="10px">'.$dt.'<br>'.substr($r["rel"],0,4).'</td>
			    <td width="30px" align="center">'.$r2[6].'</td>
			  </tr>
			</table>		
			</div>
		';
		if($key==1) {
			$key=2;
		}else{
			$key=1;
		}	
	}
	}
		// Конец нижней панели
		//echo "</div>";	
	
}
//end chkstring post 
}
?>
<script type="text/javascript"> $(document).ready(function(){$(<? echo $tmax ?>).val("<? echo $r2[0]; ?>");});</script> 
<script type="text/javascript"> $(document).ready(function(){$(<? echo $countmax ?>).html("<? echo $r2[0]; ?>");});</script> 
								   
