/**
 * User functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Forest Compartment list management
 */
$("#forestcompartment_list").prepend("<a id=\"forestcompartment_list_update\" style=\"display:none;\" data-basehref=\""+$("#forestcompartment_list").attr("action")+"\" data-update=\"content_boscoForestCompartmentlist\"></a>");
$("#search").keyup(function(){
   el = $("#forestcompartment_list_update"); 
   search = $("#search");
   usosuolo = $("#usosuolo");
   codiope = $("#codiope");
   el.attr("href",el.data("basehref")+"&usosuolo="+usosuolo.val()+"&codiope="+codiope.val()+"&search="+search.val());
   el.trigger("click");
});
$("#usosuolo, #codiope").change(function() {
   $("#search").val("").trigger("keyup");
});
/**
 * Form a controls
 */
$( "#datasch" ).datepicker({dateFormat:"yy-mm-dd"});
