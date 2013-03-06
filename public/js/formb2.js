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
$("#arboree2container").prepend("<a id=\"arboree2_list_update\" style=\"display:none;\" href=\""+$("#formB2").attr("action")+"\" data-update=\"content_schedab2_arboree2\"></a>");
/**
 * Manages autocomplete arboree cod coltu
 **/
function autocompleteColtu () {
        $("#cod_coltu2_descr, #content_schedab2_arboree2 input.cod_coltu2").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu").val(ui.item.id );
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu2_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    arboree_id = $(this).data("arboree-id");
                    $("#cod_coper2_"+arboree_id).trigger("change");
                }
        }
    }).focus(function() {
        $(this).val("").autocomplete("search","")
    }).blur(function () {
        el = $(this);
        old = el.data("old-value");
        if (typeof old == "string" && el.val() == "") {
            el.val(old);
        }
    });
}
autocompleteColtu ();
$(document).ajaxComplete(function() {
    autocompleteColtu ();
});
/**
 * Manages edit arboree cod_coper
 **/
$(document).on("change","#content_schedab2_arboree2 select", function() {
    el = $("#newarboree2 .addnew").parent("a");
    arboree_id = $(this).data("arboree-id");
    data = {
        "xhr":1,
        "arboree_id":arboree_id,
        "cod_coltu" : $("#cod_coltu2_"+arboree_id).val(),
        "cod_coper" : $("#cod_coper2_"+arboree_id).val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    $("#arboree2_list_update").trigger("click");
                    status = true;
                }
                else {
                    $.each(response["names"], function(id,val) {
                        $("#"+val).addClass("error");
                    });
                    $("#ajaxloader").hide();
                }
                
            },
            error: function(jqXHR , textStatus,  errorThrown) {
                $("#ajaxloader").hide();
            }
        });
     
        return status;
    
});
/**
 * Manages add new forest cover
 */
$(document).on("click","#newarboree2 .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu" : $("#cod_coltu").val(),
        "cod_coper" : $("#cod_coper").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_coltu_descr").val("");
                     $("#cod_coltu").val("");
                     $("#cod_coper option").removeAttr("selected");
                    status = true;
                }
                else {
                    $.each(response["names"], function(id,val) {
                        $("#"+val).addClass("error");
                    });
                    $("#ajaxloader").hide();
                }
                
            },
            error: function(jqXHR , textStatus,  errorThrown) {
                $("#ajaxloader").hide();
            }
        });
     
        return status;  
    
});
/**
 * Manages delete forest cover
 **/
$(document).on("click","#content_schedab2_arboree2 .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_arboree\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#codcover_delete_confirm",function(){
   $.colorbox.close();
});
$(document).on("click","#codcover_delete_cancel",function(){
   $.colorbox.close();
   return false;
});