<?
function getSRVlink($id) {
  $base_url_gui="/servers/";
  return $base_url_gui.$id.".html";
}
function getSRVlinkGUI($id) {
$base_url_gui="/servers/";
  return $base_url_gui.$id."/guilds.html";
}
function getSRVlinkRenames($id) {
$base_url_gui="/servers/";
  return $base_url_gui.$id."/renames.html";
}
function getSRVall($id) {
$base_url_gui="/servers/";
  return $base_url_gui."allserver.html";
}
function getSRVlinkclass($id,$cid) {
  $base_url_gui="/servers/";
  return $base_url_gui.$id."/".$cid.".html";
}

function getSRVEvents($sid,$dtt){
$sql="SELECT id
     , 'newbe'
     , id AS av_id
     , av_name
     , c_id
     , '-'
     , '-'
FROM
  `".list_avatars."`
WHERE
  `".list_avatars."`.date = '".$dtt."'
  AND s_id = '".$sid."'
UNION ALL
SELECT id
     , 'renames'
     , cur_av_id
     , '-'
     , '-'
     , prev_av_id
     , '-'
FROM
  ".renames."
WHERE
 ".renames.".date = '".$dtt."'
  AND s_id = '".$sid."'
UNION ALL

SELECT id
     , 'p_l_chg'
     , obj_id
     , '-'
     , type
     , val
     , '-'
FROM
  ".pos_chg."
WHERE
  ".pos_chg.".date = '".$dtt."'
  AND ".pos_chg.".s_id = '".$sid."'
UNION ALL

SELECT type
     , 'gui_chg'
     , av_id
     , av_name
     , c_id
     , prev_data
     , cur_data
FROM
  ".av_chg."
LEFT JOIN `".list_avatars."`
ON
".av_chg.".av_id = `".list_avatars."`.id

WHERE
  ".av_chg.".date = '".$dtt."'
  AND `".list_avatars."`.s_id = '".$sid."'";
//echo $sql;
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

function getSRVClass($sid,$dtt){
  $sql = "SELECT * from ".calc_data." where type = 2 and s_id = ".$sid." and date = '".$dtt."' order by data desc"; 
     $ssrv=0;
     $res=mysql_query($sql); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                  $ssrv = $ssrv + $m[5];
                }
            while ($m = mysql_fetch_array($res));
        }
//$ret[9]=  $ssrv;
return $ret;
}
function getSRVraceinclass($sid,$cid,$dtt){
$sql ="SELECT sum(rate) AS e1
     , r_id
FROM
  `".av_data_cur."`
LEFT JOIN `".list_avatars."`
ON `".av_data_cur."`.av_id = `".list_avatars."`.id
WHERE
  `".av_data_cur."`.c_id = ".$cid."
  AND `".av_data_cur."`.srv_id = ".$sid."
GROUP BY
  r_id
ORDER BY
  e1 DESC";
 //echo $sql;
   $res=mysql_query($sql); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                  
                }
            while ($m = mysql_fetch_array($res));
        }
return $ret;
}

function getSRVraceinclasslist($sid,$cid,$rid,$dtt){

$sql ="SELECT *
FROM
  `".av_data_cur."`
LEFT JOIN `".list_avatars."`
ON `".av_data_cur."`.av_id = `".list_avatars."`.id
LEFT JOIN `".av_data_7."`
ON `".av_data_cur."`.av_id = `".av_data_7."`.av_id
WHERE
  `".av_data_cur."`.srv_id = ".$sid."
  AND `".av_data_cur."`.c_id = ".$cid."
  AND `".list_avatars."`.r_id = ".$rid." limit 0,10";

   $res=mysql_query($sql); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                  
                }
            while ($m = mysql_fetch_array($res));
        }
return $ret;
}


function getSRVguilds($sid,$limit){
if ($sid) {
  $sql = "select * from `".vs_gui."` left join `".list_gui."` on `".vs_gui."`.gui_id =`".list_gui."`.id  where `".vs_gui."`.srv_id ='".$sid."'order by pos_cur limit 0,".$limit.""  ;
} else {
  $sql ="SELECT * FROM  `".vs_gui."` LEFT JOIN `".list_gui."` ON `".vs_gui."`.gui_id = `".list_gui."`.id ORDER BY  avt_cur desc LIMIT  0, ".$limit."";
}
   $res=mysql_query($sql); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                 
                }
            while ($m = mysql_fetch_array($res));
        }
return $ret;
}

function getSRVclassavg($sid,$cid,$avg){

}
function getSRVclassgraph($sid,$cid){ 
  $sql_g="SELECT count(f_id),sum(rate),f_id
FROM
  `".av_data_cur."`
LEFT JOIN `".list_avatars."`
ON av_data_cur.av_id = `".list_avatars."`.id
WHERE
  `".av_data_cur."`.srv_id = ".$sid."
  AND `".av_data_cur."`.c_id = ".$cid."
  group by f_id order by f_id";
  //echo $sql_g;
   $res=mysql_query($sql_g); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                  
                }
            while ($m = mysql_fetch_array($res));
        }
return $ret;
}
function getSRVclasslist($sid,$cid){
  $sql = "SELECT `".av_data_cur."`.*
     , a.av_name
     , a.r_id
     , a.date
     , a.f_id
     , b.pos
     , b.rate
     , c.pos
     , c.rate
     , d.pos
     , d.rate
  ,g.gui_id


FROM
  `".av_data_cur."`
LEFT JOIN `".list_avatars."` a
ON `".av_data_cur."`.av_id = a.id

LEFT JOIN `".av_data_7."` b
ON `".av_data_cur."`.av_id = b.av_id

LEFT JOIN `".av_data_14."` c
ON `".av_data_cur."`.av_id = c.av_id

LEFT JOIN `".av_data_28."` d
ON `".av_data_cur."`.av_id = d.av_id

LEFT JOIN `".av_gui."` g
ON `".av_data_cur."`.av_id = g.av_id



WHERE
  `".av_data_cur."`.srv_id = ".$sid."
  AND `".av_data_cur."`.c_id = ".$cid." 
  order by `".av_data_cur."`.pos";
  $res=mysql_query($sql); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                  
                }
            while ($m = mysql_fetch_array($res));
        }
return $ret;
}

function getSRVrenamelist($sid){
  $sql ="SELECT a.*
     , b.av_name
     , c.av_name
     , b.r_id
     , b.c_id
     , b.f_id
FROM
 `".renames."` a
LEFT JOIN `".av_list."` b
ON a.cur_av_id = b.id
LEFT JOIN `".av_list."` c
ON a.prev_av_id = c.id

WHERE
  a.s_id = ".$sid." and 
  a.actual = 1
ORDER BY
  id DESC";
  $res=mysql_query($sql); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                  
                }
            while ($m = mysql_fetch_array($res));
        }
return $ret;
}

?>