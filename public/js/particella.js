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
$(document).on("click","#content_boscoForestCompartmentlist .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la particella selezionata ?"+
                    " <a id=\"bosco_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_boscoForestCompartmentlist\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"bosco_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
/**
 * Form a controls
 */
$("#datasch").datepicker({dateFormat:"yy-mm-dd"});
$("#comune_descriz").autocomplete({
    source: "bosco.php?task=autocomplete&action=municipality&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#comune").val(ui.item.id )
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#comune_descriz").val($("#comune_descriz").data("old-descriz"));
            }
    }
});
$("#codiope_descriz").autocomplete({
    source: "bosco.php?task=autocomplete&action=collector",
    select: function( event, ui ) {
        $("#codiope").val(ui.item.id )
    }
});
$(document).on("change","#sup",function(){
   el = $(this);
   if (el.val()> 0)
       $("input[name=delimitata]").removeAttr("disabled");
   else
       $("input[name=delimitata]").attr("disabled","disabled");
});
$("#sup").trigger("change");