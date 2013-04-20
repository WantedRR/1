<?
 
if ($graph_type ==1){
//График гильдия по классам гироскоп	
	$sql2 = "SELECT DATE_FORMAT(date, '%d.%m'), data from ".calc_data." where type = 3 and data_str = ".$gid." and sep = '".$m[4]."' order by date desc limit 0,14";
	$res2=mysql_query($sql2);				    
	if ($m2 = mysql_fetch_array($res2))
	    {
	        do
	            {
	            	$im[]=$m2[1];
	            	$im2[]=$m2[0];
	            }
	        while ($m2 = mysql_fetch_array($res2));
	    }
	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
			 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);
			 $MyData->addPoints($im,"Score");
			 $MyData->addPoints($im2,"Labels");
			 $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
			 $MyData->setAbscissa("Labels");		 
			 $myPicture = new pImage(400,190,$MyData);
			 $myPicture->setGraphArea(40,10,350,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"libary/pChart2.1.3/fonts/pf_arma_five.ttf","FontSize"=>6));
			 $myPicture->drawScale(array("LabelSkip"=>3,"AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));

			 $myPicture->drawLineChart(0,0,0,0);
			 $myPicture->drawPlotChart(array("PlotSize"=>2,"PlotBtxt_guild_av_inorder"=>TRUE));

			 $BoundsSettings = array("MinDisplayR"=>237,"MinDisplayG"=>23,"MinDisplayB"=>48,"MaxDisplayR"=>0,"MaxDisplayG"=>0,"MaxDisplayB"=>0);
			 $myPicture->writeBounds(BOUND_BOTH,$BoundsSettings);
			 //$myPicture->writeBounds();

			 $myPicture->drawLegend(630,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		     $myPicture->render("cache/".$name_file);
	     unset($im);
	     unset($im2);
}
if ($graph_type ==2){
//Саммари по классам
	$sql2 = "select * from ".calc_data."

  left join classes 
  on all_calc.sep = classes.cid


	 where data_str = ".$gid."  and date ='".$dtt."' order by data desc";
	$res2=mysql_query($sql2);	

	$im2[]="0";
	if ($m2 = mysql_fetch_array($res2))
	    {
	    	unset($im2);
	        do
	            {
	            	$im[]=iconv('utf-8', 'utf-8', $m2[8]);
	            	$im2[]=$m2[5];
	     
	            }
	        while ($m2 = mysql_fetch_array($res2));
	    }
 $MyData = new pData();  
 if(mysql_num_rows($res2) >1){
 	$gsize =30*mysql_num_rows($res2) + 10;
 } else {
	$gsize =40;
 }
 $MyData->addPoints($im2,"Hits");
 $MyData->addPoints($im,"Browsers");
 $MyData->setSerieDescription("Browsers","Browsers");
 $MyData->setAbscissa("Browsers");
  $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
 //$MyData->setAbscissaName("Browsers");
 $myPicture = new pImage(300,300,$MyData);
 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
 $myPicture->setGraphArea(70,10,280,$gsize);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM)); 
 $Palette = array("0"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "1"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "2"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "3"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "4"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "5"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "6"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "7"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "8"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "9"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  );
  $myPicture->drawBarChart(array("LabelSkip"=>10,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));
  $myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
  $myPicture->render("cache/".$name_file);

 unset($im);
 unset($im2);
}
if ($graph_type ==3){
     unset($im);
	 unset($im2);

if ($gt3_ser==1){
	$sql2="SELECT *
	     , DATE_FORMAT(date, '%d.%m')
	FROM
	  ".calc_data."

	WHERE
	  s_id = ".$serverid."
	  AND type = 1
	ORDER BY
	  date DESC
	LIMIT
	  0, 31";
} else {
		$sql2 = "SELECT *
	     , DATE_FORMAT(date, '%d.%m')
	FROM
	  ".gui_data." 
	WHERE
	  gui_id = ".$gid."
	ORDER BY
	  date DESC
	LIMIT
	  0, 31";
}



$i = 1;
	$res2=mysql_query($sql2);	
	if ($m2 = mysql_fetch_array($res2))
	    {
	        do
	            {
	            	$im[$i]=$m2[5];
	            	$im2[$i]=$m2[7];
	            	if ($i <> 1){
	            		//$im2[$i]=$m2[7];            		
	            		$dim[$i]= $im[$i-1] - $im[$i];
	            		$avg = $avg + $dim[$i];
	            	}
					$i++;

	            }
	        while ($m2 = mysql_fetch_array($res2));
	    }   
	    	unset($im2[$i-1]);
/*	    	
$sql3="select * from ".calc_data." where type =1 and s_id =1 order by date desc limit 0,31"	;
$i = 1;	
	$res3=mysql_query($sql3);	
	if ($m3 = mysql_fetch_array($res3))
	    {
	        do
	            {
	            	$im3[$i]=$m3[5];	            	
	            	if ($i <> 1){
	            		$dim2[$i]= ($im3[$i-1] - $im3[$i])/100;
	            		
	            	}
					$i++;

	            }
	        while ($m3 = mysql_fetch_array($res3));
	    }   */
	    	$avg = round($avg/($i -1));
	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
	    	$dim = array_reverse($dim);
	    	//$dim2 = array_reverse($dim2);


			 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);
			 $MyData->addPoints($dim,"Score");
			 //$MyData->addPoints($dim2,"avg");
			 $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
			 $MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_guild_graph_avtgrow));
			 $MyData->addPoints($im2,"Labels");
			 $MyData->setAbscissa("Labels");			 
			 $myPicture = new pImage(450,200,$MyData);		 
			 $myPicture->setGraphArea(60,10,450,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>3,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $myPicture->drawLineChart(0,0,0,0);
			 $myPicture->drawPlotChart(array("PlotSize"=>1,"PlotBorder"=>TRUE));
			 $myPicture->drawThreshold($avg,array("WriteCaption"=>TRUE,"Caption"=>"AVG=".$avg,"CaptionAlpha"=>100,"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,"Alpha"=>70,"Ticks"=>2,"R"=>255,"G"=>0,"B"=>0));
			 $BoundsSettings = array("MinDisplayR"=>237,
			 						 "MinDisplayG"=>23,
			 						 "MinDisplayB"=>48,
			 						 "MaxDisplayR"=>0,
			 						 "MaxDisplayG"=>0,
			 						 "MaxDisplayB"=>0
			 						 //"ExcludedSeries"=>"Labels"
			 						 );
			 //$BoundsSettings["ExcludedSeries"]="avg";
			 $myPicture->writeBounds(BOUND_BOTH,$BoundsSettings);
			 //$myPicture->writeBounds();
			 $myPicture->drawLegend(630,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		     $myPicture->render("cache/".$name_file);
	     unset($im);
	     unset($im2);
	     unset($dim);
	     unset($dim2);



}
if ($graph_type ==4){
	//График приходов и уходов по дням..

$sql2 = "SELECT DISTINCT (date) AS d1
             , t2.inc, t3.exi, DATE_FORMAT(date, '%d.%m') as de
FROM
  ".av_chg." AS t1
LEFT JOIN
(SELECT date AS d2
      , count(prev_data) AS inc
 FROM
   ".av_chg."
 WHERE
   (prev_data = ".$gid.")
   AND type = 3
 GROUP BY
   d2) AS t2
ON t2.d2 = t1.`date`
LEFT JOIN
(SELECT date AS d3
      , count(cur_data) AS exi
 FROM
   ".av_chg."
 WHERE
   (cur_data = ".$gid.")
   AND type = 3
 GROUP BY
   d3) AS t3
ON t3.d3 = t1.`date`
  order by d1 desc limit 0,30";
	     unset($im);
	     unset($im2);
	     unset($im3);

	$res2=mysql_query($sql2);	
	if ($m2 = mysql_fetch_array($res2))
	    {
	        do
	            {

	        		

	  
	        			$im2[] = $m2[2];

	        			$im[] = $m2[1];


	        		$im3[] = $m2[3];
	        		//printf ("<br>%s :%s :%s", $m2[3],$m2[2],$m2[1]);

	            }
	        while ($m2 = mysql_fetch_array($res2));
	    } 

	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
	    	$im3 = array_reverse($im3);
			 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);			 
			 $MyData->addPoints($im2,iconv('utf-8', 'utf-8', txt_guild_av_in));		 			 
			 $MyData->addPoints($im,iconv('utf-8', 'utf-8', txt_guild_av_out));
			 $MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_guild_graph_count_pers));
			 $MyData->addPoints($im3,"dt");
			 $MyData->setAbscissa("dt");			 
			 
			 $myPicture = new pImage(450,200,$MyData);		 
			 $myPicture->setGraphArea(60,10,450,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>3,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $myPicture->drawLegend(230,5,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

			 $myPicture->drawBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO));
			 
		     $myPicture->render("cache/".$name_file);


}
if ($graph_type ==6){
//График рейтинга одетости по серверу..
$sql_g6="SELECT DISTINCT (date) , t2.s2, t3.s3, round(t3.s3/t2.s2*100,2) , DATE_FORMAT(date, '%d.%m') FROM  ".calc_data." AS t1 
left join (SELECT date AS d2, sum(data) AS s2 FROM  ".calc_data." WHERE  s_id =".$gui_all[3]." and type =2 GROUP BY  d2) as t2  ON t2.d2 = t1.date
left join (SELECT date AS d3, sum(data) AS s3 FROM  ".calc_data." WHERE  data_str = ".$gid." GROUP BY  d3) as t3  ON t3.d3 = t1.date
ORDER BY t1.date DESC
  limit 0,30";
unset($im);
unset($im2);
unset($dim);
$i = 1;
$k = 1;
$res_g6=mysql_query($sql_g6);	
	if ($m_g6 = mysql_fetch_array($res_g6))
	    {
	        do
	            {
	            	if ($k <> 30) {
		            	$im[]=$m_g6[3];
	            		$im2[]=$m_g6[4];
	            	}
	            	if ($i==5) {
	            		$ag=$ag+$m_g6[3];
	            		
	            		$dim[]=$ag/5;
	            		//printf ("!!! 5 - %s <br>",$dim[$k-1]);
	            		$ag=0;
	            		$i=0;
	            	} else {
	            		//$dim[]=void;
	            		$ag=$ag+$m_g6[3];
	            	}
	            	//printf ("!%s - %s <br>",$i,$ag);

	            	//$im2[]=$m2[0];
	            	//printf ("$k- %s <br>",$m_g6[3]);
	            	$i++;
	            	$k++;
	            }
	        while ($m_g6 = mysql_fetch_array($res_g6));
	    }



	    $im = array_reverse($im);
	    $im2 = array_reverse($im2);
	    $dim = array_reverse($dim);
			 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);
			 $MyData->addPoints($im,"Score");
			// $MyData->addPoints($dim,"avg");
			 $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
			 $MyData->addPoints($im2,"Labels");
			 $MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_guild_avintop_cron));
			 $MyData->setAbscissa("Labels");			 
			 $myPicture = new pImage(450,200,$MyData);		 
			 $myPicture->setGraphArea(60,10,440,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>3,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $myPicture->drawSplineChart(0,0,0,0);
			 $myPicture->drawPlotChart(array("PlotSize"=>1,"PlotBorder"=>TRUE));
			 $myPicture->drawThreshold($avg,array("WriteCaption"=>TRUE,"Caption"=>"AVG=".$avg,"CaptionAlpha"=>100,"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,"Alpha"=>70,"Ticks"=>2,"R"=>255,"G"=>0,"B"=>0));
			 $BoundsSettings = array("MinDisplayR"=>237,
			 						 "MinDisplayG"=>23,
			 						 "MinDisplayB"=>48,
			 						 "MaxDisplayR"=>0,
			 						 "MaxDisplayG"=>0,
			 						 "MaxDisplayB"=>0
			 						 //"ExcludedSeries"=>"Labels"
			 						 );
			 //$BoundsSettings["ExcludedSeries"]="avg";
			 $myPicture->writeBounds(BOUND_BOTH,$BoundsSettings);
			 //$myPicture->writeBounds();
			 $myPicture->drawLegend(630,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		     $myPicture->render("cache/".$name_file);
}

if ($graph_type ==7){
	//график позиции аватара
unset($im);
unset($im2);
unset($dim);
$sql_av = "SELECT DATE_FORMAT(date, '%d.%m'), pos from ".av_data." where av_id ='".$av_all[0]."' order by date desc limit 0,30";
	$res_av=mysql_query($sql_av);				    
	if ($m_av = mysql_fetch_array($res_av))
	    {
	        do
	            {
	            	$im[]=$m_av[1];
	            	$im2[]=$m_av[0];
	            }
	        while ($m_av = mysql_fetch_array($res_av));
	    }
	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
				 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);
			 $MyData->addPoints($im,"Score");
			// $MyData->addPoints($dim,"avg");
			 $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
			 $MyData->addPoints($im2,"Labels");
			 $MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_avatar_graph_pos));
			 $MyData->setAbscissa("Labels");			 
			 $myPicture = new pImage(450,200,$MyData);		 
			 $myPicture->setGraphArea(60,10,440,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>3,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $myPicture->drawSplineChart(0,0,0,0);
			 $myPicture->drawPlotChart(array("PlotSize"=>1,"PlotBorder"=>TRUE));
			 $myPicture->drawThreshold($avg,array("WriteCaption"=>TRUE,"Caption"=>"AVG=".$avg,"CaptionAlpha"=>100,"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,"Alpha"=>70,"Ticks"=>2,"R"=>255,"G"=>0,"B"=>0));
			 $BoundsSettings = array("MinDisplayR"=>237,
			 						 "MinDisplayG"=>23,
			 						 "MinDisplayB"=>48,
			 						 "MaxDisplayR"=>0,
			 						 "MaxDisplayG"=>0,
			 						 "MaxDisplayB"=>0
			 						 //"ExcludedSeries"=>"Labels"
			 						 );
			 //$BoundsSettings["ExcludedSeries"]="avg";
			 $myPicture->writeBounds(BOUND_BOTH,$BoundsSettings);
			 //$myPicture->writeBounds();
			 $myPicture->drawLegend(630,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		     $myPicture->render("cache/".$name_file);


}
if ($graph_type ==8){
	//график изменений рейтинга автарв
unset($avg);
unset($im);
unset($im2);
unset($im3);
unset($im4);
unset($dim);
unset($dim2);
$i = 1;
$sql_av = "SELECT DATE_FORMAT(a.date, '%d.%m'), a.rate, DATE_FORMAT(a.date, '%w') ,b.data
from ".av_data." a 

left join ".calc_data." b
on a.`date`=b.`date`



where a.av_id ='".$av_all[0]."'

  and b.s_id=a.srv_id
  and b.sep=a.c_id
  and b.type=2


 order by a.date desc limit 0,31";



	$res_av=mysql_query($sql_av);				    
	if ($m_av = mysql_fetch_array($res_av))
	    {
	        do
	            {
	            	$im[$i]=$m_av[1];
	            	$im4[$i]=$m_av[3];
	            	$im2[$i]=$m_av[0];
	            	$im3[$i]=$m_av[2];
	            	if ($i <> 1){
	            		$dim[$i]= $im[$i-1] - $im[$i];
	            		$dim2[$i]= ($im4[$i-1] - $im4[$i])/100;
	            		$avg = $avg + $dim[$i];
	            		$avg2 = $avg2 + $dim2[$i];
	            	}
					$i++;
	            }
	        while ($m_av = mysql_fetch_array($res_av));
	    }
	    	unset($im2[$i-1]);
	    	unset($im3[$i-1]);
	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
	    	$im3 = array_reverse($im3);
	    	$dim = array_reverse($dim);
	    	$dim2 = array_reverse($dim2);	    

			 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my3.color", TRUE);
			 $MyData->addPoints($dim,"Score");
			 $MyData->addPoints($dim2,"AVG");
			 $MyData->setSerieTicks("AVG",3);
			 $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
			 $MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_avatar_graph_rate));
			 
			 $MyData->addPoints($im2,"Labels");
			 $MyData->setAbscissa("Labels");			 
			 $myPicture = new pImage(450,200,$MyData);		 
			 $myPicture->setGraphArea(60,20,450,170);

			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>3,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $MyData->setSerieDrawable("AVG",FALSE);
			 $myPicture->drawBarChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO));
			 $MyData->setSerieDrawable("AVG",TRUE);
			 $MyData->setSerieDrawable("Score",FALSE);
			 $myPicture->drawSplineChart();
			 $count = count($im3);
			 for ($i = 0; $i < $count; $i++) {
			 	if ($im3[$i]==4){			 		
					$myPicture->drawXThreshold($i,array("CaptionAlign"=>CAPTION_RIGHT_BOTTOM,"WriteCaption"=>TRUE,"Caption"=>iconv('utf-8', 'utf-8', txt_day_04),"Alpha"=>70,"Ticks"=>2,"R"=>0,"G"=>0,"B"=>0));
				}
			 }

			$TextSettings = array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Angle"=>0,"FontSize"=>7);
			$myPicture->drawText(250,19,iconv('utf-8', 'utf-8', txt_avatar_graph_rate_grow_allperiod. " ".$avg.",             : ".$avg2.""),$TextSettings);
			 $myPicture->drawThreshold($avg,array("WriteCaption"=>TRUE,"Caption"=>"AVG=".$avg,"CaptionAlpha"=>100,"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,"Alpha"=>70,"Ticks"=>2,"R"=>255,"G"=>0,"B"=>0));
			 $BoundsSettings = array("MinDisplayR"=>237,
			 						 "MinDisplayG"=>23,
			 						 "MinDisplayB"=>48,
			 						 "MaxDisplayR"=>0,
			 						 "MaxDisplayG"=>0,
			 						 "MaxDisplayB"=>0
			 						 //"ExcludedSeries"=>"Labels"
			 						 );
			 //$BoundsSettings["ExcludedSeries"]="avg";
			 //$myPicture->writeBounds(BOUND_BOTH,$BoundsSettings);
			 //$myPicture->writeBounds();
			 $myPicture->drawLegend(365,11,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		     $myPicture->render("cache/".$name_file);
}


if ($graph_type ==9){
	//график рейтинга аватара
unset($im);
unset($im2);
unset($dim);
$sql_av = "SELECT DATE_FORMAT(date, '%d.%m'), rate from ".av_data." where av_id ='".$av_all[0]."' order by date desc limit 0,30";
	$res_av=mysql_query($sql_av);				    
	if ($m_av = mysql_fetch_array($res_av))
	    {
	        do
	            {
	            	$im[]=$m_av[1];
	            	$im2[]=$m_av[0];
	            }
	        while ($m_av = mysql_fetch_array($res_av));
	    }
	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
				 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);
			 $MyData->addPoints($im,"Score");
			// $MyData->addPoints($dim,"avg");
			 //$MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,0);
			 $MyData->addPoints($im2,"Labels");
			 $MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_avatar_graph_pos));
			 $MyData->setAbscissa("Labels");			 
			 $myPicture = new pImage(450,200,$MyData);		 
			 $myPicture->setGraphArea(60,10,440,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>3,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $myPicture->drawLineChart(0,0,0,0);
			 $myPicture->drawPlotChart(array("PlotSize"=>1,"PlotBorder"=>TRUE));
			 $myPicture->drawThreshold($avg,array("WriteCaption"=>TRUE,"Caption"=>"AVG=".$avg,"CaptionAlpha"=>100,"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,"Alpha"=>70,"Ticks"=>2,"R"=>255,"G"=>0,"B"=>0));
			 $BoundsSettings = array("MinDisplayR"=>237,
			 						 "MinDisplayG"=>23,
			 						 "MinDisplayB"=>48,
			 						 "MaxDisplayR"=>0,
			 						 "MaxDisplayG"=>0,
			 						 "MaxDisplayB"=>0
			 						 //"ExcludedSeries"=>"Labels"
			 						 );
			 //$BoundsSettings["ExcludedSeries"]="avg";
			// $myPicture->writeBounds(BOUND_BOTH,$BoundsSettings);
			 //$myPicture->writeBounds();
			 $myPicture->drawLegend(630,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		     $myPicture->render("cache/".$name_file);
}

if ($graph_type ==10){
//Круговой график по классу на сервере во фракциях

$MyData = new pData();  
$MyData->loadPalette("libary/pChart2.1.3/palettes/my2.color", TRUE);
 $MyData->addPoints(array($cl_gr[0][1],$cl_gr[1][1]),"ScoreA");
 //$MyData->addPoints(array(77,33),"ScoreB");
 $MyData->setSerieDescription("ScoreA","Application A");

 /* Define the absissa serie */
 $c2 = txt_frake_.$cl_gr[1][2];
 $c1 = txt_frake_.$cl_gr[0][2];
 $MyData->addPoints(array(iconv('utf-8', 'utf-8', $$c1), iconv('utf-8', 'utf-8', $$c2)),"Labels");
 $MyData->setAbscissa("Labels");

 $myPicture = new pImage(162,160,$MyData);

 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

 $myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>50));

 $PieChart = new pPie($myPicture,$MyData);


 $PieChart->draw2DPie(77,77,array("WriteValues"=>TRUE,"ValuePosition"=>PIE_VALUE_INSIDE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>FALSE,"BorderR"=>255,"BorderG"=>255,"BorderB"=>255));

 /* Write the legend */
 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>6));
 $myPicture->setShadow(TRUE,array("X"=>0,"Y"=>0,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
 $myPicture->drawText(79,135, iconv('utf-8', 'utf-8', txt_server_graph_rateinclass),array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
 $PieChart->drawPieLegend(40,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 $myPicture->render("cache/".$name_file);
}
if ($graph_type ==11){
//Круговой график по классу на сервере во фракциях

$MyData = new pData();  
$MyData->loadPalette("libary/pChart2.1.3/palettes/my2.color", TRUE);
 $MyData->addPoints(array($cl_gr[0][0],$cl_gr[1][0]),"ScoreA");
 //$MyData->addPoints(array(77,33),"ScoreB");
 $MyData->setSerieDescription("ScoreA","Application A");

 /* Define the absissa serie */
 $c2 = txt_frake_.$cl_gr[1][2];
 $c1 = txt_frake_.$cl_gr[0][2];
 $MyData->addPoints(array(iconv('utf-8', 'utf-8', $$c1), iconv('utf-8', 'utf-8', $$c2)),"Labels");
 $MyData->setAbscissa("Labels");

 $myPicture = new pImage(162,160,$MyData);

 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>10,"R"=>80,"G"=>80,"B"=>80));

 $myPicture->setShadow(TRUE,array("X"=>2,"Y"=>2,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>50));

 $PieChart = new pPie($myPicture,$MyData);


 $PieChart->draw2DPie(77,77,array("WriteValues"=>TRUE,"ValuePosition"=>PIE_VALUE_INSIDE,"DataGapAngle"=>10,"DataGapRadius"=>6,"Border"=>FALSE,"BorderR"=>255,"BorderG"=>255,"BorderB"=>255));

 /* Write the legend */
 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>6));
 $myPicture->setShadow(TRUE,array("X"=>0,"Y"=>0,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>20));
 $myPicture->drawText(79,135, iconv('utf-8', 'utf-8', txt_server_graph_cntinclass),array("DrawBox"=>TRUE,"BoxRounded"=>TRUE,"R"=>0,"G"=>0,"B"=>0,"Align"=>TEXT_ALIGN_TOPMIDDLE));

 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>6,"R"=>0,"G"=>0,"B"=>0));
 $PieChart->drawPieLegend(40,8,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
 $myPicture->render("cache/".$name_file);


}
if ($graph_type ==12){
//Саммари в классе по серверам
	$sql2 = "select * from ".calc_data."
  left join ".table_server."
on ".calc_data.".s_id=".table_server.".sid

WHERE
  date = '".$dtt."'
  and sep = '".$val[1]."'
  AND type = 2
  order by data desc";

	$res2=mysql_query($sql2);	
	$im2[]="0";
	if ($m2 = mysql_fetch_array($res2))
	    {
	    	unset($im2);
	        do
	            {
	            	$im[]=iconv('utf-8', 'utf-8', $m2[8]);
	            	$im2[]=$m2[5];
	     
	            }
	        while ($m2 = mysql_fetch_array($res2));
	    }
 $MyData = new pData();  
 if(mysql_num_rows($res2) >1){
 	$gsize =30*mysql_num_rows($res2) + 10;
 } else {
	$gsize =40;
 }
 $MyData->addPoints($im2,"Hits");
 $MyData->addPoints($im,"Browsers");
 $MyData->setSerieDescription("Browsers","Browsers");
 $MyData->setAbscissa("Browsers");
  $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
 //$MyData->setAbscissaName("Browsers");
 $myPicture = new pImage(340,320,$MyData);
 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
 $myPicture->setGraphArea(90,10,280,$gsize);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM)); 
 $Palette = array("0"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "1"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "2"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "3"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "4"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "5"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "6"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "7"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "8"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "9"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  );
  $myPicture->drawBarChart(array("LabelSkip"=>10,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));
  $myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
  $myPicture->render("cache/".$name_file);

 unset($im);
 unset($im2);
}
if ($graph_type ==13){
	//График прироста классов на сервере.
$sql2 = "SELECT *, DATE_FORMAT(date, '%d.%m')
FROM
  all_calc
WHERE
  s_id = ".$serverid."
  AND type = 2
and date > subdate('".$dtt."', INTERVAL 8 DAY)
ORDER BY
  date DESC";

	     unset($im);
	     unset($im2);
	     unset($im_dt);
//echo $sql2;
$cl2 = getSRVClass($serverid,$dtt);


$i=0;
	$res2=mysql_query($sql2);	
	if ($m2 = mysql_fetch_array($res2))
	    {
	        do
	            {
	            	if ($dt_chk<>$m2[1]){
	            		$i++;
	            		$im_dt[$i]=$m2[7];
	            	}
	            	foreach($cl2 as $index => $val){						   
	            			if ($m2[4]==$val[4]){
	            				$im[$val[4]][$i]=$m2[5];
				            	if ($i <> 1){
				            		$dim[$val[4]][$i]= $im[$val[4]][$i-1] - $im[$val[4]][$i];
				            		//echo $dim[$val[4]][$i]."<br>";
				            	}

	            				/*
				            	$im[$val[4]][$i]=$m2[5];
				            	if ($i <> 1){
				            		$dim[$val[4]][$i]= $im[$val[4]][$i-1] - $im[$val[4]][$i];
				            		echo $dim[$val[4]][$i]."<br>";
				            	}
				            	*/
				            	//printf ("%s - %s - %s - !%s<br>",$val[4],$im_dt[$i],$im[$val[4]][$i],$dim[$val[4]][$i]);
				            }
						}
					$dt_chk=$m2[1];
					
	            }
	        while ($m2 = mysql_fetch_array($res2));
	    } 

 unset($im_dt[$i-1]);
 $MyData = new pData();
 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);			 
unset($im);
foreach($cl2 as $index => $val){
	$im[]=$dim[$val[4]];
}
$im_dt = array_reverse($im_dt);
foreach($dim as $in => $va){
	$va = array_reverse($va);
	foreach($va as $in2 => $va2){
		//printf ("%s ",$va2);
		$clt="txt_class_".$in;
		$MyData->addPoints($va2,iconv('utf-8', 'utf-8', $$clt));
	}
	//echo"<br>";
	//$im[]=$dim[$val[4]];
	//unset($dim[$val[4]][$i-1]);
}
//echo $im.$val[4];
/*
	    	unset($im2[$i-1]);
	    	unset($im3[$i-1]);
	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
	    	$im3 = array_reverse($im3);
	    	$dim = array_reverse($dim);	
	    	$im = array_reverse($im);
	    	$im2 = array_reverse($im2);
	    	$im3 = array_reverse($im3);
			 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);			 
			 $MyData->addPoints($im2,iconv('utf-8', 'utf-8', txt_guild_av_in));
			 */		 			 
			 //$MyData->addPoints($im,iconv('utf-8', 'utf-8', txt_guild_av_out));
			 //$MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_guild_graph_count_pers));
			 $MyData->addPoints($im_dt,"dt");
			 $MyData->setAbscissa("dt");			 
			 
			 $myPicture = new pImage(950,200,$MyData);		 
			 $myPicture->setGraphArea(60,10,950,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>0,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $myPicture->drawLegend(230,5,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));

			 $myPicture->drawLineChart(array("DisplayValues"=>TRUE,"DisplayColor"=>DISPLAY_AUTO));
			 
		     $myPicture->render("cache/".$name_file);


}
if ($graph_type ==14){
	//ОТносительный прирост авторитета гильдии.
$sql = "SELECT a.*
	     , DATE_FORMAT(a.date, '%d.%m')
    ,b.`data`
	FROM
	 ".gui_data."  a
  left join ".calc_data." b
on a.date = b.date

	WHERE
	  a.gui_id = ".$gid."
  and b.type=1
  and b.s_id=".$srv_gr."
	ORDER BY
	  a.date DESC
	LIMIT
	  0, 31";
	  //echo $sql;
     unset($im);
     unset($im2);
     unset($im3);
     unset($dim);
     unset($dim2);
     unset($dim3);
     unset($avg);
	$i =1;
	$res2=mysql_query($sql);	
	if ($m2 = mysql_fetch_array($res2))
	    {
	        do
	            {
	            	$im[$i]=$m2[5];
	            	$im2[$i]=$m2[8];
	            	$im3[$i]=$m2[7];
	            	if ($i <> 1){
	            		//$im2[$i]=$m2[7];            		
	            		$dim[$i]= $im[$i-1] - $im[$i];
	            		$dim2[$i]= $im2[$i-1] - $im2[$i];
	            		//$avg = $avg + $dim[$i];
	            	}
					$i++;
	            }
	        while ($m2 = mysql_fetch_array($res2));
	    } 
		unset($im3[$i-1]);
    	$im3 = array_reverse($im3);
    	$dim2 = array_reverse($dim2);
    	$dim = array_reverse($dim);
$count = count($dim);
 for ($i = 0; $i < $count; $i++) {
 	//printf ("%s - %s - %s    - %s<br>",$dim[$i],$dim2[$i],$im3[$i],round($dim[$i]/$dim2[$i]*100,2));
 	$dim3[$i]=round($dim[$i]/$dim2[$i]*100,2);
 	$avg = $avg+$dim3[$i];
 	//printf ("<b>%s</b><br>",$avg);
 }

 $avg=round($avg/$i,2);

			 $MyData = new pData();
			 $MyData->loadPalette("libary/pChart2.1.3/palettes/my.color", TRUE);
			 $MyData->addPoints($dim3,"Score");
			 //$MyData->addPoints($dim2,"avg");
			 $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
			 $MyData->setAxisName(0,iconv('utf-8', 'utf-8', txt_guild_graph_avtgrow_rel));
			 $MyData->addPoints($im3,"Labels");
			 $MyData->setAbscissa("Labels");			 
			 $myPicture = new pImage(450,200,$MyData);		 
			 $myPicture->setGraphArea(60,10,450,170);
			 $myPicture->drawFilledRectangle(30,30,680,190,array("R"=>255,"G"=>255,"B"=>255,"Alpha"=>20));
			 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
			 $myPicture->drawScale(array("AxisR"=>255,"AxisG"=>255,"AxisB"=>255,"LabelSkip"=>3,"DrawSubTicks"=>TRUE,"CycleBackground"=>TRUE));
			 $myPicture->drawLineChart(0,0,0,0);
			 $myPicture->drawPlotChart(array("PlotSize"=>1,"PlotBorder"=>TRUE));
			 $myPicture->drawThreshold($avg,array("WriteCaption"=>TRUE,"Caption"=>"AVG=".$avg."%","CaptionAlpha"=>100,"CaptionR"=>0,"CaptionG"=>0,"CaptionB"=>0,"Alpha"=>70,"Ticks"=>2,"R"=>255,"G"=>0,"B"=>0));
			 $BoundsSettings = array("MinDisplayR"=>237,
			 						 "MinDisplayG"=>23,
			 						 "MinDisplayB"=>48,
			 						 "MaxDisplayR"=>0,
			 						 "MaxDisplayG"=>0,
			 						 "MaxDisplayB"=>0
			 						 //"ExcludedSeries"=>"Labels"
			 						 );
			 //$BoundsSettings["ExcludedSeries"]="avg";
			 $myPicture->writeBounds(BOUND_BOTH,$BoundsSettings);
			 //$myPicture->writeBounds();
			 $myPicture->drawLegend(630,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
		     $myPicture->render("cache/".$name_file);


}
if ($graph_type ==15){
//График класса в других гильдиях	
	unset($im);
	unset($im2);
	unset($im3);
	unset($im4);
	unset($im5);
$sql_gg ="SELECT a.*,b.data
FROM
  ".calc_data." a
LEFT JOIN ".calc_data." b
ON a.data_str = b.data_str

WHERE
  a.type = 3
  AND b.type = 3
  AND a.sep = '".$m[4]."'
  AND b.sep = '".$m[4]."'
  AND a.s_id = '".$gui_all[3]."'
  AND b.s_id = '".$gui_all[3]."'
  AND a.date = '".$dtt."'
  AND b.date = subdate('".$dtt."', INTERVAL 7 DAY)
ORDER BY
  a.data DESC";


	$i =1;
	$res_gg=mysql_query($sql_gg);	
	if ($m_gg = mysql_fetch_array($res_gg))
	    {
	        do
	            {
	            	//echo $gui_all[0];
	            	if ($m_gg[6]==$gui_all[0]){
	            		$gui_pos_class = $i;
	            		//printf ("%s -%s",$i,$m_gg[5]);
	            	}
	            	$im[$i] = $m_gg[5];
	            	$im2[$i] = $m_gg[6];
	            	$im3[$i] = $m_gg[5]-$m_gg[7];
 					$i++;
	            }
	        while ($m_gg = mysql_fetch_array($res_gg));
	    }

$k = 0;
for ($i = $gui_pos_class-4; $i <= $gui_pos_class+3; $i++) {
	if ($im[$i]){
		$k++;
		$rt=getGUIname($im2[$i]);
		//printf ("%s -%s (%s)<br>",$rt[2],$im[$i],$im3[$i]);
		$im4[$k] =$i." ".$rt[2];
		$im5[$k] =$im[$i];
	} 
    //echo $i;
}





 $MyData = new pData();  
 if($k>1){
 	$gsize =30*$k + 10;
 } else {
	$gsize =40;
 }
 $MyData->addPoints($im5,"Hits");
 $MyData->addPoints($im4,"Browsers");
 $MyData->setSerieDescription("Browsers","Browsers");
 $MyData->setAbscissa("Browsers");
  $MyData->setAxisDisplay(0,AXIS_FORMAT_METRIC,1);
 //$MyData->setAbscissaName("Browsers");
 $myPicture = new pImage(340,300,$MyData);
 $myPicture->setFontProperties(array("FontName"=>"libary/pChart2.1.3/fonts/tahoma.ttf","FontSize"=>7));
 $myPicture->setGraphArea(140,10,320,$gsize);
 $myPicture->drawScale(array("CycleBackground"=>TRUE,"DrawSubTicks"=>TRUE,"GridR"=>0,"GridG"=>0,"GridB"=>0,"GridAlpha"=>10,"Pos"=>SCALE_POS_TOPBOTTOM)); 
 $Palette = array("0"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "1"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "2"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "3"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "4"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "5"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "6"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "7"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  "8"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>30),
                  "9"=>array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>15),
                  );
  $myPicture->drawBarChart(array("LabelSkip"=>10,"DisplayPos"=>LABEL_POS_INSIDE,"DisplayValues"=>TRUE,"Rounded"=>TRUE,"Surrounding"=>30,"OverrideColors"=>$Palette));
  $myPicture->drawLegend(570,215,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
  $myPicture->render("cache/".$name_file);











	unset($im);
	unset($im2);
	unset($im3);
}
?>