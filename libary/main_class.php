<?
function getMainClass($dtt){
  $scl = 0;
  $sql = "select sum(data) as e1,sep from all_calc where date = '".$dtt."' and type =2 group by sep order by e1 desc";      
     $res=mysql_query($sql); 
      if ($m = mysql_fetch_array($res))
          {
              do
                {
                  $ret[]=$m;
                  $scl = $scl + $m[0];
                }
            while ($m = mysql_fetch_array($res));
        }
//$ret[2]=  $scl;
return $ret;
}

function getMaintop($sid,$cid,$fid,$dtt){
$sql ="SELECT *
FROM
  `".av_data_cur."`
LEFT JOIN `".list_avatars."`
ON `".av_data_cur."`.av_id = `".list_avatars."`.id
LEFT JOIN `".av_data_7."`
ON `".av_data_cur."`.av_id = `".av_data_7."`.av_id
WHERE
   `".av_data_cur."`.c_id = ".$cid."
  AND `".list_avatars."`.f_id = ".$fid." order by `".av_data_cur."`.rate desc limit 0,10
";
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
function getMainclassgraph($cid){ 
  $sql_g="SELECT count(f_id),sum(rate),f_id
FROM
  `".av_data_cur."`
LEFT JOIN `".list_avatars."`
ON av_data_cur.av_id = `".list_avatars."`.id
WHERE
 `".av_data_cur."`.c_id = ".$cid."
  group by f_id order by f_id";
  
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
?>