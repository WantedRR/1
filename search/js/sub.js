function showsub(n)
{$('div[id^="sub_'+n+'_"]').each(function(){if($(this).is(':hidden'))
$(this).slideDown();else
$(this).slideUp();});}
function closesub(n)
{$('div[id^="sub_'+n+'_"]').each(function(){$(this).slideUp();});}