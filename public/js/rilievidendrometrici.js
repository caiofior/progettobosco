/**
 * Relives functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Data field
 */
$("#data").datepicker({dateFormat:"yy-mm-dd"});
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
$("#selector").prepend("<a id=\"formx_update\" style=\"display:none;\" data-basehref=\""+$("#formX").attr("action")+"\" data-update=\"content_rilievidendrometrici_edit\"></a>");
$("#formX #tipo_ril").change(function() {
    $("#formx_update").attr("href",$("#formX").attr("action")+"&tipo_ril="+$(this).val()).trigger("click");
    return false;
});
