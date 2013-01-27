/**
 * User functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Forest Lis management
 */
$("#forest_list").prepend("<a id=\"forest_list_update\" style=\"display:none;\" data-basehref=\""+$("#forest_list").attr("action")+"\" data-update=\"content_boscoForestlist\"></a>");
$("#descrizion").keyup(function(){
   el = $("#forest_list_update"); 
   search = $("#descrizion_search");
   regione = $("#regione");
   el.attr("href",el.data("basehref")+"&regione="+regione.val()+"&search="+search.val());
   el.trigger("click");
});
$("#regione").change(function() {
    el = $("#forest_list_update");
    regione = $("#regione");
    el.attr("href",el.data("basehref")+"&regione="+regione.val());
    el.trigger("click");
});
$(document).on("change",$("#current"),function() {
   el = $("#forest_list_update"); 
   search = $("#descrizion_search");
   regione = $("#regione");
   current = $("#current");
   el.attr("href",el.data("basehref")+"&regione="+regione.val()+"&search="+search.val()+"&start="+current.val());
   el.trigger("click");
});
/**
 * Forest for management
 */
formAjax("#manage_bosco",".bosco_messages");
defaultInputValue("#descrizion","Nome del bosco");
defaultInputValue("#codice","Codice (a-z0-9)");
$("#regione").change(function() {
    $("#prefissocodice").text($(this).find(":selected").attr("value"));
});

