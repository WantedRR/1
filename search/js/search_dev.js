$(document).ready(function(){
closesub(1);closesub(2);closesub(3);closesub(4);
var str=$("#htext").val();
var ma=$("#hmax").val();
var mad=$("#frmmax").val();
var mas=$("#storhmax").val();
var maf=$("#fotomax").val();
var limp=parseInt($("#hlim").val());
var limd=parseInt($("#frmlim").val());
var lims=parseInt($("#storlim").val());
var limf=parseInt($("#fotolim").val());
$("#nlnk").click(function(){
  limp=parseInt($("#hlim").val());ma=$("#hmax").val();
  lm=limp+10;
  if(lm<ma){
	  $("#page_load").show();
	  $("#srch_art").fadeTo("fast",0.01)
	  closesub(4);
	  $("#hlim").val(lm);
	  limp=parseInt($("#hlim").val());
	  $.ajax({
			 url:"/core/search/ajax_srch2.php",
			 cache:false,
			 type:"POST",
			 data:({strsrch:str,tbl:"dw_article",lim:limp}),
			 success:function(html){
				 $("#srch_art").fadeTo("fast",1)
				 $("#srch_art").html(html);
				 $("#page_load").hide();}
			});
	  }});
$("#plnk").click(function(){
	limp=parseInt($("#hlim").val());
	if(limp>=10){
		$("#page_load").show();
		$("#srch_art").fadeTo("fast",0.01)
		closesub(4);
		lm=limp-10;
		$("#hlim").val(lm);
		$.ajax({
				url:"/core/search/ajax_srch2.php",
				cache:false,
				type:"POST",
				data:({strsrch:str,tbl:"dw_article",lim:lm}),
				success:function(html){
					$("#srch_art").fadeTo("fast",1)
					$("#srch_art").html(html);
					$("#page_load").hide();}
				});
	}});
$.ajax({
	url:"/core/search/ajax_srch2.php",
	cache:false,
	type:"POST",
	data:({strsrch:str,tbl:"dw_article",lim:limp}),
	success:function(html){
		$("#srch_art").html(html);
		$("#page_load").hide();	
		showsub(1);
		$("#stor_load").hide();	
		
	}})

$("a[nv~='searchbut']").mouseover(function(){
	$(this).css('text-decoration','underline')
	$(this).css('cursor','pointer')
	});
$("a[nv~='searchbut']").mouseout(function(){
	$(this).css('text-decoration','none')
	});
 $("#srch_art").html("<p>asdasd</p>");
});
