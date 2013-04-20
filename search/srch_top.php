 <form name="srch" id= "srch_frm">
 <input name="strsrch" type="text" class="inpt_search" id="srh_str">
 </form> 
<script type="text/javascript"> 
function findValue(li) {
	if( li == null ) return alert("No match!");
	if( !!li.extra ) var sValue = li.extra[0];
	else var sValue = li.selectValue;
	//alert (li.extra[1]);
	//alert (sValue);
	 //document.srch.submit();
}

function selectItem(li) {
	findValue(li);
	//alert(li);
}
function lookupAjax(){
	var oSuggest = $("#srh_str")[0].autocompleter;
 	//oSuggest.findValue();
 	alert("ddd");
 	return false;
}
$(document).ready(function() {
	 $("#srh_str").val("(search)");
   	    $("#srh_str").focus(function() {  
	        $(this).removeClass("inpt_search").addClass("inpt_search2");  			
			$(this).val("");
	    });	
	    $("#srh_str").blur(function() {
	        $(this).removeClass("inpt_search2").addClass("inpt_search");  
			$(this).val("(search)");
	    });
		
	$("#srh_str").autocomplete(
		"/search/load.php",
		{
			delay:5,
			minChars:3,
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