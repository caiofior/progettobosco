/**
 * tavole functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Forest List management
 */
$("#tavole_list").prepend("<a id=\"tavole_list_update\" style=\"display:none;\" data-basehref=\""+$("#tavole_list").attr("action")+"\" data-update=\"content_tavole_list\"></a>");
$("#search").keyup(function(){
   el = $("#tavole_list_update"); 
   search = $("#search");
   tipo = $("#tipo");
   el.attr("href",el.data("basehref")+"&tipo="+tipo.val()+"&search="+search.val());
   el.trigger("click");
});
$("#tipo").change(function() {
    $("#search").trigger("keyup");
});
