/* 
 * Fom b2 controls
 */
/**
 * Manages forest type description
 **/
$("#t_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=t&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#t").val(ui.item.id );
        $("#formB1").trigger("submit");
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
 * Manages cod coltup
 **/
$("#cod_coltup_descr").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=cod_coltu&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#cod_coltup").val(ui.item.id );
        $("#formB2").trigger("submit");
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#cod_coltup_descr").val($("#cod_coltup_descr").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
/**
 * Manages cod coltus
 **/
$("#cod_coltus_descr").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=cod_coltu&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#cod_coltus").val(ui.item.id );
        $("#formB2").trigger("submit");
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#cod_coltus_descr").val($("#cod_coltus_descr").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
/**
 * Manages cod coltub
 **/
$("#cod_coltub_descr").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=cod_coltu&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#cod_coltub").val(ui.item.id );
        $("#formB2").trigger("submit");
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#cod_coltub_descr").val($("#cod_coltub_descr").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
/**
 * Manages cod coltua
 **/
$("#cod_coltua_descr").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=cod_coltu&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#cod_coltua").val(ui.item.id );
        $("#formB2").trigger("submit");
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#cod_coltub_descr").val($("#cod_coltua_descr").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});