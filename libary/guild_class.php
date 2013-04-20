<?
function getGUIlink($id) {
  $base_url_gui="/guilds/";
  return $base_url_gui.$id.".html";
}

function getGUIstate_fix_error_export($id,$dtt) {
    $sql = "select * from `".gui_data."` where gui_id ='".$id."' and date <> '2013.01.28' order by date desc limit 0,1";
    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
$date = new DateTime($m[1]);
$now = new DateTime($dtt);

if ($date->diff($now)->format("%d") <7){
  if ($m[4] <95){
      return $m[1];
    }
}

}


function getGUIstate($id,$dtt) {
    $sql = "select * from `".gui_data."` where gui_id ='".$id."' and date <> '2013.01.28' and date = '".$dtt."' order by date desc";
    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
    if(mysql_num_rows($res) ===1) {
      $mz[2]=$m[5];
      $mz[3]=1;
    }
    return $mz;
  }

function getGUIAVratepos($sid,$dtt,$id) {
$sql ="SELECT sum(data) as s,data_str
FROM
  ".calc_data."
WHERE
  type = 3
  and s_id ='".$sid."'
   and date = '".$dtt."'
  group by data_str
  order by s desc";
  $i=1;
   $res=mysql_query($sql); 
    if ($m = mysql_fetch_array($res))
        {
            do
                {
                  //printf ("%s - %s ",$m[1],$m[0]);
                  if ($m[1]==$id){
                    return $i;
                  }
                  $i++;
                }
            while ($m = mysql_fetch_array($res));
        }
return txt_no;
}
function getGUIlist($sid,$dtt) {
$sql ="SELECT `".list_gui."`.*
     , ".gui_data.".*
     , count(".av_gui.".av_id)
FROM
  `".list_gui."`
LEFT JOIN ".gui_data."
ON `".list_gui."`.id = ".gui_data.".gui_id
LEFT JOIN ".av_gui."
ON `".list_gui."`.id = ".av_gui.".gui_id
WHERE
  `".list_gui."`.srv_id = '".$sid."'
  AND ".gui_data.".srv_id = '".$sid."'
  AND ".gui_data.".`date` = '".$dtt."'
GROUP BY
  `".list_gui."`.id";

   $res=mysql_query($sql); 
    if ($m = mysql_fetch_array($res))
        {
            do
                {
                        //$avt[]=$m[];
                        //printf("%s - %s  - %s<br>",$m[5],$m[6],mysql_num_rows($res)); 
                    printf("<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>\n",$m[2],$m[2],$m[2],$m[2],$m[2],$m[2],$m[2]) ;        
                }
            while ($m = mysql_fetch_array($res));
        }
//return $avt;
}

function getGUIname($id) {
  global $gui_global;
  if ($gui_global[$id]){

  } else {
    $sql = "select * from `".list_gui."` where id ='".$id."'";
    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
    $gui_global[$id]=$m;
  }
    return $gui_global[$id]; 
}
function getSRVname($id) {
   global $srv_global;
   if ($srv_global[$id]){
   } else {
      $sql = "select * from `".table_server."` where sid ='".$id."'";
      $res=mysql_query($sql);
      $m = mysql_fetch_array($res);
      $srv_global[$id]=$m;
  }
    return $srv_global[$id]; 
  }


/*
function getGUIname($id) {
  global $gui_global;
  if ($gui_global[$id]){

  } else {
    $sql = "select * from `".list_gui."` where id ='".$id."'";
    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
    $gui_global[$id]=$m;
  }
    return $gui_global[$id]; 
}
*/

function getGUIserv($id) {
    $sql = "select * from `".list_gui."` where id ='".$id."'";
    $res=mysql_query($sql);
    $m = mysql_fetch_array($res);
    return $m[3]; 
}
function getGUIdata($id) {
    $dtt=date("Y.m.d");
    $sql ="SELECT * FROM   ".gui_data." WHERE  gui_id = '".$id."'
  AND (date = '".$dtt."'
  OR date = subdate('".$dtt."', INTERVAL 1 DAY)
  OR date = subdate('".$dtt."', INTERVAL 7 DAY)
  OR date = subdate('".$dtt."', INTERVAL 15 DAY)
  ) ORDER BY  date DESC";
    $res=mysql_query($sql);
    if ($m = mysql_fetch_array($res))
        {
            do
                {
                    if(mysql_num_rows($res) ==4){
                        $avt[]=$m[5];
                        printf("%s - %s  - %s<br>",$m[5],$m[6],mysql_num_rows($res));    
                    }
                $sid = $m[2];
                }
            while ($m = mysql_fetch_array($res));
        }

     $sql2 ="SELECT * FROM  ".calc_data." WHERE s_id = '".$sid."'
  AND type =1 AND (date = '".$dtt."'
  OR date = subdate('".$dtt."', INTERVAL 1 DAY)
  OR date = subdate('".$dtt."', INTERVAL 7 DAY)
  OR date = subdate('".$dtt."', INTERVAL 15 DAY)
  ) ORDER BY  date DESC"; 
   $res2=mysql_query($sql2);
    if ($m2 = mysql_fetch_array($res2))
        {
            do
                {
                    if(mysql_num_rows($res2) ==4){
                        $avt[]=$m2[5];
                        printf("!!%s - %s  - %s<br>",$m2[5],$m2[6],mysql_num_rows($res));    
                    }
                }
            while ($m2 = mysql_fetch_array($res2));
        }
    return $avt;
        
        echo "<br>";
    $m = mysql_fetch_array($res);
    foreach($avt as $index => $val){
       // echo("$index -> $val <br>");
    }
    //echo count($m);
    
  }
function getGUI_Events($gid) {
  $sql = "SELECT id, date, 'pos' as t, val,s_id, 'none' as nick
FROM
  ".pos_chg."
WHERE
  ".pos_chg.".obj_id = '".$gid."'
  AND ".pos_chg.".type = 1
UNION ALL
SELECT id, date, 'pos_chg' as t, val,s_id, 'none' as nick
FROM
  ".pos_chg."
WHERE
  ".pos_chg.".obj_id = '".$gid."'
  AND ".pos_chg.".type = 2
UNION ALL
SELECT ".av_chg.".id,".av_chg.".date,'av' as t,av_id,cur_data, ".list_avatars.".av_name
FROM  ".av_chg."
LEFT JOIN ".list_avatars."
ON ".av_chg.".av_id = ".list_avatars.".id
WHERE
type = 3 and 
  (cur_data = '".$gid."'
  OR prev_data = '".$gid."'  )
  order by date desc";
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
function getGUI_AVlist($gid,$cid) {
  //Список Автаров 
$base = "/avatars";
$sql = "SELECT *
FROM
  ".av_gui."
LEFT JOIN ".list_avatars."
ON ".av_gui.".av_id =  ".list_avatars.".id
LEFT JOIN ".av_data_cur."
ON ".av_gui.".av_id = ".av_data_cur.".av_id


LEFT JOIN ".av_data_7."
ON ".av_gui.".av_id = ".av_data_7.".av_id
WHERE
  gui_id = '".$gid."'
  AND  ".list_avatars.".c_id = '".$cid."'
  order by  ".av_data_cur.".rate desc";
        $res=mysql_query($sql);
    if ($m = mysql_fetch_array($res))
        {
            do
                {
                  //$avt[]=$m[5];
                  if ($m[18]){
                    printf ("<tr class =\"istop\">");
                    printf ("<td class=\"pos\">%s</td>",$m[17]);
                    printf ("<td><a href=\"%s\"> %s</a></td>",getAVlink($m[2]),$m[7]);
                    printf ("<td>%s</td>",$m[18]);
                    
                    
                    if ($m[25]) {
                      printf ("<td>+%s</td>",$m[18]-$m[25]);
                    } else {
                      printf ("<td>%s</td>","new");
                    }
                  } else {
                    printf ("<tr class =\"isout\">");
                    printf ("<td colspan =2><a href=\"%s\"> %s</a></td>",getAVlink($m[2]),$m[7]);                    
                    printf ("<td >Out </td>",$m[18]);
                  }

                  printf ("</tr>\n");
                  //printf("%s - %s  - %s<br>",$m[7],$m[18],mysql_num_rows($res));    
                    
                $sid = $m[2];
                }
            while ($m = mysql_fetch_array($res));
        }


}

function getGUI_Sum1($gid,$dtt,$s_id) {
$sql = "SELECT sum(data) FROM ".calc_data." WHERE data_str = '".$gid."'   AND date = '".$dtt."' ";
$sql2 = "SELECT sum(data) FROM ".calc_data." WHERE date = '".$dtt."' AND s_id = '".$s_id."' AND type = 2";
$res=mysql_query($sql);
$res2=mysql_query($sql2);
$m = mysql_fetch_array($res);
$m2 = mysql_fetch_array($res2);
//Процент  одетости по серверу
$cr[]= round($m[0]/ $m2[0]*100,2);
$summ_gui=$m[0];
$sql = "SELECT count(*) from  ".av_gui."  left JOIN  ".list_avatars."  on ".av_gui.".av_id=".list_avatars.".id    where gui_id ='".$gid."' and is_top = 1";
$res=mysql_query($sql);
$m = mysql_fetch_array($res);
//Количество аватаров в топе
$cr[]=$m[0];
$sql = "select * from ".gui_data." where gui_id = '".$gid."' order by date desc limit 0,2";
$res=mysql_query($sql);
$i =1;
if ($m = mysql_fetch_array($res))
  {
      do
          {
            if ($i==1){
              $buf_avt=$m[5]; 
              $buf_pos = $m[4];
              $buf_lvl = $m[6];
            }
            if ($i==2) {
              $buf_avt2=$m[5]; 
            }
            $i++;
          }
      while ($m = mysql_fetch_array($res));
  }
//Прирост за день, позиция, уровень  
 $cr[] = $buf_avt - $buf_avt2;
 $cr[] = $buf_pos;
 $cr[] = $buf_lvl;
$sql = "select * from ".calc_data." where type =1 and s_id ='".$s_id."' order by date  desc limit 0,2";
$res=mysql_query($sql);
$i =1;
if ($m = mysql_fetch_array($res))
  {
      do
          {
            if ($i==1){
              $buf_avt=$m[5]; 

            }
            if ($i==2) {
              $buf_avt2=$m[5]; 
            }
            $i++;
          }
      while ($m = mysql_fetch_array($res));
  }
//прирост сервака за день
 $cr[] = $buf_avt - $buf_avt2;
 $cr[]=$summ_gui;
return $cr;
}
function getGUI_7_GUI($gid){
$sql = "select * from ".gui_data." where gui_id = '".$gid."' order by date desc limit 0,15";
$res=mysql_query($sql);
$i =1;
if ($m = mysql_fetch_array($res))
  {
      do
          {
            if ($i==1){
              $buf_avt=$m[5]; 
              $buf_pos = $m[4];
              $buf_lvl = $m[6];
            }
            if ($i==8) {
              $buf_avt2=$m[5]; 
            }
            if ($i==15) {
              $buf_avt3=$m[5]; 
            }
            $i++;
          }
      while ($m = mysql_fetch_array($res));
  }
//Приррост за 7дней
  $cr[] = $buf_avt - $buf_avt2;
  $cr[] = $buf_avt - $buf_avt3;
  return $cr;
}
function getGUI_Sum2($pos,$dtt,$s_id) {
$p1 = $pos -4;
$p2 = $pos +4;
$sql_fst = "select * from ".gui_data." where srv_id ='".$s_id."' and `date` = '".$dtt."' and pos BETWEEN '".$p1."' and '".$p2."' order by pos ";
$i=0;
$res=mysql_query($sql_fst);
if ($m = mysql_fetch_array($res))
  {
      do
          {
            if ($m[4] == $pos){
              $cr["cur"]["gid"] = $m[3];
              $bb=getGUI_7_GUI($m[3]);
              $cr["cur"]["avtcur"] = $m[5];
              $cr["cur"]["avt7"] = $bb[0];
              $cr["cur"]["avt14"] = $bb[1];
              $cr["cur"]["pos"] = $m[4];
              $gui_a=getGUIname($m[3]);
              $gui_n=$gui_a[2];          
              $cr["cur"]["name"] = $gui_n;
            } else {
              $cr[$i]["gid"] = $m[3];
              $bb=getGUI_7_GUI($m[3]);
              $cr[$i]["avtcur"] = $m[5];
              $cr[$i]["avt7"] = $bb[0];
              $cr[$i]["avt14"] = $bb[1];
              $cr[$i]["pos"] = $m[4];                         
              $gui_a=getGUIname($m[3]);
              $gui_n=$gui_a[2];          
              $cr[$i]["name"] = $gui_n;
            }
            $i++;

          }
      while ($m = mysql_fetch_array($res));
  }
return $cr;
}

function getGUI_SumSRV($pos,$dtt,$s_id) {
$sql = "select * from ".calc_data." where type =1 and s_id ='".$s_id."' order by date  desc limit 0,15";
$res=mysql_query($sql);
$i =1;
if ($m = mysql_fetch_array($res))
  {
      do
          {
            if ($i==1){
              $buf_avt=$m[5]; 

            }
            if ($i==8) {
              $buf_avt2=$m[5]; 
            }
            if ($i==15) {
              $buf_avt3=$m[5]; 
            }
            $i++;
          }
      while ($m = mysql_fetch_array($res));
  }
//прирост сервака за 7 дней
 $cr["srv7"] = $buf_avt - $buf_avt2;
 $cr["srv14"] = $buf_avt - $buf_avt3;
 return $cr;
}
function getGUI_engage($avt1,$avt2,$avtch1,$avtch2) {
 $cr=($avt1-$avt2)/($avtch2-$avtch1);
 return $cr;
}

?>