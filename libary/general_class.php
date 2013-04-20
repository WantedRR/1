<?
function getMAINpagelink($type){
	if ($type==1) return "http://".$_SERVER['SERVER_NAME'];
	if ($type==2) return "http://".$_SERVER['SERVER_NAME']."/develop.html";
	if ($type==3) return "http://".$_SERVER['SERVER_NAME']."/subm/suggest.html";
	if ($type==4) return "http://".$_SERVER['SERVER_NAME']."/subm/error.html";
	if ($type==5) return "http://".$_SERVER['SERVER_NAME']."/donate.html";
	if ($type==6) return "http://".$_SERVER['SERVER_NAME']."/faq.html";
}
function show_text_date($g_date,$l){
	$r=explode("-",$g_date);
	if ($l =1){
		if ($r[1] =="01") $r[1]= txt_month_01_short;
		elseif ($r[1] =="02") $r[1]= txt_month_02_short;
		elseif ($r[1] =="03") $r[1]= txt_month_03_short;
		elseif ($r[1] =="04") $r[1]= txt_month_04_short;
		elseif ($r[1] =="05") $r[1]= txt_month_05_short;
		elseif ($r[1] =="06") $r[1]= txt_month_06_short;
		elseif ($r[1] =="07") $r[1]= txt_month_07_short;
		elseif ($r[1] =="08") $r[1]= txt_month_08_short;
		elseif ($r[1] =="09") $r[1]= txt_month_09_short;
		elseif ($r[1] =="10") $r[1]= txt_month_10_short;
		elseif ($r[1] =="11") $r[1]= txt_month_11_short;
		elseif ($r[1] =="12") $r[1]= txt_month_12_short;		
	} else {
		if ($r[1] =="01") $r[1]= txt_month_01;
		elseif ($r[1] =="02") $r[1]= txt_month_02;
		elseif ($r[1] =="03") $r[1]= txt_month_03;
		elseif ($r[1] =="04") $r[1]= txt_month_04;
		elseif ($r[1] =="05") $r[1]= txt_month_05;
		elseif ($r[1] =="06") $r[1]= txt_month_06;
		elseif ($r[1] =="07") $r[1]= txt_month_07;
		elseif ($r[1] =="08") $r[1]= txt_month_08;
		elseif ($r[1] =="09") $r[1]= txt_month_09;
		elseif ($r[1] =="10") $r[1]= txt_month_10;
		elseif ($r[1] =="11") $r[1]= txt_month_11;
		elseif ($r[1] =="12") $r[1]= txt_month_12;		
	}
	return $r[2]." ".$r[1]." ".$r[0];
}

function checklogin($login) {
	$login = trim($login);
	//echo strlen($login);
	if (strlen($login)==0) return -1;
	if (!preg_match("/^[a-zA-Z0-9]+$/",$login)) return -1;
	if ($login<>"Wanted") return -1;
	return $login;
}
function checkname($name) {
	$name = trim($name);
//	if (strlen($name)==0) return -1;
	if (!preg_match("/^[(\w) ]+$/",$name)) return -1;
	return $name;
}
function checkint($int) {
	$int = trim($int);
//	if (strlen($int)==0) return -1;

	if (!preg_match("/^[0-9]{1,4}$/is",$int)) return -1;
	return $int;
}

function is_date( $str ) {
    try {
        $dt = new DateTime( trim($str) );
    }
    catch( Exception $e ) {
        return false;
    }
    $month = $dt->format('m');
    $day = $dt->format('d');
    $year = $dt->format('Y');
    if( checkdate($month, $day, $year) ) {
        return true;
    }
    else {
        return false;
    }
}

?>