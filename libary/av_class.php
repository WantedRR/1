<?
function getAVlink($id) {
  $base_url_gui="/avatars/";
  return $base_url_gui.$id.".html";
}

function getFRAKElink($id) {
  $base_url_gui="my.php?frake_id=";
  return $base_url_gui.$id;
}
function getRACElink($id) {
  $base_url_gui="my.php?race_id=";
  return $base_url_gui.$id;
}
function getAV_GUI($id) {
$sql = "select date,gui_id from ".av_gui." where av_id = '".$id."'";
$res=mysql_query($sql);
$m = mysql_fetch_array($res);
return $m;
}
function getAVpos_rate($id,$dtt,$c_id,$s_id) {
$sql = "select round(avg(pos),0),max(pos),min(pos) from ".av_data."  where av_id = '".$id."' and date >subdate('".$dtt."', INTERVAL 31 DAY)";
$res=mysql_query($sql);
$m = mysql_fetch_array($res);
$ret=$m;
$sql = "select pos,rate from ".av_data." where av_id = '".$id."' order by date desc limit 0,1";
$res=mysql_query($sql);
$m = mysql_fetch_array($res);
$ret=array_merge((array)$ret, (array)$m);
$sql = "SELECT data FROM  ".calc_data." WHERE  s_id = '".$s_id."'   AND type = 2  AND sep = '".$c_id."' ORDER BY   date DESC LIMIT   0, 1";
$res=mysql_query($sql);
$m = mysql_fetch_array($res);
//Добавил 5 индекс
$ret=array_merge((array)$ret, (array)$m);
return $ret;

  //OR date = subdate('".$dtt."', INTERVAL 15 DAY
}

function getAVname($id) {
  $sql = "SELECT av_name FROM  `".list_avatars."` WHERE  ".list_avatars.".id ='".$id."'";
    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
    return $m[0];
}
function getAVall($id) {
    //$sql = "select * from `".av_gui."` where id ='".$id."'";
$sql = "SELECT *
FROM
  `".list_avatars."`


WHERE
  ".list_avatars.".id ='".$id."'";

    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
    return $m; 
}

function getAV_Events($avid){
$sql = "SELECT * from `".av_chg."` where av_id =".$avid." order by date desc, id desc";
    $res=mysql_query($sql);
    if ($m = mysql_fetch_array($res))
        {
            do
                {
                  $ev[]=$m;
                }
            while ($m = mysql_fetch_array($res));
        }
return $ev;
}
function getAVpos($avid){
  $sql_1 = "select pos from ".av_data_cur." where av_id ='".$avid."'";
  $res=mysql_query($sql_1);
  $m = mysql_fetch_array($res);
  return $m[0];
}
function getAVrenames($avid){
  $sql ="select * from ".renames." where prev_av_id = ".$avid." or cur_av_id =".$avid." and actual =1 order by date desc";
    $res=mysql_query($sql);
    if ($m = mysql_fetch_array($res))
        {
            do
                {
                  $ev[]=$m;
                }
            while ($m = mysql_fetch_array($res));
        }
      return $ev;
}
function getAVpos_ch($pos,$pos_d){
  $ch_pos =$pos_d-$pos;
  if ($ch_pos<0){
    $eng = "<span class=\"red\">$ch_pos</span>";
  } elseif ($ch_pos==0) {
    $eng = "<span class=\"av_gray\">$ch_pos</span>";
  } else {
    $eng = "<span class=\"av_green\">+$ch_pos</span>";
  }
  if (!$pos_d) $eng =txt_new;
  return $eng;
}
function getAV_Sum2($c_id,$pos,$s_id){

$p1 = $pos -4;
$p2 = $pos +4;
$sql_fst = "select * from ".av_data_cur." 
LEFT JOIN ".av_data_7."
ON ".av_data_cur.".av_id = ".av_data_7.".av_id
LEFT JOIN ".av_data_14."
ON ".av_data_cur.".av_id = ".av_data_14.".av_id
LEFT JOIN ".av_data_28."
ON ".av_data_cur.".av_id = ".av_data_28.".av_id
LEFT JOIN ".list_avatars."
ON ".av_data_cur.".av_id = ".list_avatars.".id
where ".av_data_cur.".srv_id ='".$s_id."' and ".av_data_cur.".c_id = '".$c_id."' and ".av_data_cur.".pos BETWEEN '".$p1."' and '".$p2."' order by ".av_data_cur.".pos ";
$i=0;
//echo $sql_fst;
$res=mysql_query($sql_fst);
if ($m = mysql_fetch_array($res))
  {
      do
          {
            if ($m[4] == $pos){
              $cr["cur"]["avid"] = $m[3];
              $cr["cur"]["ratecur"] = $m[5];
              $cr["cur"]["rate7"] = $m[12];
              $cr["cur"]["rate14"] = $m[19];
              $cr["cur"]["rate28"] = $m[26];
              $cr["cur"]["pos"] = $m[4];
              $cr["cur"]["pos7"] = $m[11];
              $cr["cur"]["pos14"] = $m[18];
              $cr["cur"]["pos28"] = $m[25];
              $cr["cur"]["avname"] = $m[31];
            } else {
              $cr[$i]["avid"] = $m[3];
              $cr[$i]["ratecur"] = $m[5];
              $cr[$i]["rate7"] = $m[12];
              $cr[$i]["rate14"] = $m[19];
              $cr[$i]["rate28"] = $m[26];
              $cr[$i]["pos"] = $m[4];
              $cr[$i]["pos7"] = $m[11];
              $cr[$i]["pos14"] = $m[18];
              $cr[$i]["pos28"] = $m[25];
              $cr[$i]["avname"] = $m[31];
            }            
            $i++;            
          }
      while ($m = mysql_fetch_array($res));
  }
  return $cr;
}

?>