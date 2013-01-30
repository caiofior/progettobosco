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
$("#datasch").datepicker({dateFormat:"yy-mm-dd"});
$("#comune_descriz").autocomplete({
    source: "bosco.php?task=autocomplete&action=municipality",
    select: function( event, ui ) {
        $("#comune").val(ui.item.id )
    }
});
$("fieldset div.hideme").hide().parent("fieldset").css("border-width","0").find("legend").css("border-width","0").prepend('<a href="#" class="more"><img class="actions add" src="images/empty.png" title="Visualizza" /></a> ');
$(document).on("click","fieldset a.more",function(){
   hideElement($("fieldset a.less"));
   el = $(this);
   el.removeClass("more").addClass("less");
   el.find("img").removeClass("add").addClass("delete").attr("title","Nascondi");
   fieldset = el.parents("fieldset");
   fieldset.css("border-width","1px").find("legend").css("border-width","1px");
   fieldset.find("div.hideme").show();
   return false;
});
$(document).on("click","fieldset a.less",function(){
   hideElement($("fieldset a.less"));
   return false;
});
function hideElement(el) {
   el.removeClass("less").addClass("more");
   el.find("img").removeClass("delete").addClass("add").attr("title","Visualizza");
   fieldset = el.parents("fieldset");
   fieldset.css("border-width","0px").find("legend").css("border-width","0px");
   fieldset.find("div.hideme").hide();
}