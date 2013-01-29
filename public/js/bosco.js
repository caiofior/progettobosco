/**
 * User functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Forest List management
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
$("#current").on("focus",$("#current"),function() {
    $("#confirm_move, #cancel_move").show();
    return false;
});
$("#cancel_move").on("click",$("#cancel_move"),function(e) {
    $("#confirm_move, #cancel_move").hide();
   return false;
});
$("#confirm_move").on("click",$("#confirm_move"),function() {
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

