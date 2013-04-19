/**
 * Viabilita functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Viabilità management
 */
$("#viabilita_list").prepend("<a id=\"viabilita_list_update\" style=\"display:none;\" data-basehref=\""+$("#viabilita_list").attr("action")+"\" data-update=\"content_viabilita_list\"></a>");
$("#search").keyup(function(){
   el = $("#viabilita_list_update"); 
   search = $("#search");
   el.attr("href",el.data("basehref")+"&search="+search.val());
   el.trigger("click");
});
/**
* Manages operator description
*/
$("#codiope_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=collector",
    select: function( event, ui ) {
        $("#codiope").val(ui.item.id )
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});