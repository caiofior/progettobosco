/* 
 * Fom b1 controls
 */
/**
 * Manages forest type description
 **/
$("#t_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=t&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#t").val(ui.item.id )
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#t_descriz").val($("#t_descriz").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
/**
 * Manages structure description
 **/
$("#s_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=s&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#s").val(ui.item.id )
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#s_descriz").val($("#s_descriz").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});

