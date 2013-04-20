 <form name="srch" id= "srch_frm" action="/search/" method="post">Поиск
 <input name="strsrch" type="text" class="inpt_search" id="srh_str">
 <input type="submit" value=" " class="inpt_ok">
 </form> 
<script type="text/javascript"> 
function findValue(li) {
	if( li == null ) return alert("No match!");
	if( !!li.extra ) var sValue = li.extra[0];
	else var sValue = li.selectValue;
	 document.srch.submit();
}

function selectItem(li) {
	findValue(li);
}
function lookupAjax(){
	var oSuggest = $("#srh_str")[0].autocompleter;
 	oSuggest.findValue();
 	return false;
}
$(document).ready(function() {
   	    $("#srh_str").focus(function() {  
	        //$(this).removeClass("idleInput").addClass("activeInput");  
			//alert ("asd");
			$(this).val("");
	    });	
	    $("#srh_str").blur(function() {
			//$(this).val("(поиск)");
	    });
		
	$("#srh_str").autocomplete(
		"/core/search/load.php",
		{
			delay:500,
			minChars:2,
			matchSubset:1,
			matchContains:2,
			cacheLength:0,
			onItemSelect:selectItem,
			onFindValue:findValue,
			autoFill:true
		}
	);
});
</script> 