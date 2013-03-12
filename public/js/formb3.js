/* 
 * Form b3 controls
 */
$("#arbustivecontainer").prepend("<a id=\"arbustive_list_update\" style=\"display:none;\" href=\""+$("#formB3").attr("action")+"\" data-update=\"content_schedab3_arbustive\"></a>");
/**
 * Manages autocomplete arbustive cod coltu
 **/
function autocompleteColtuAr () {
        $("#cod_coltu_ar_descr").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu_ar&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu_ar").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu_ar_descr").val("");
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
autocompleteColtuAr ();
$(document).ajaxComplete(function() {
    autocompleteColtuAr ();
});
/**
 * Manages add new shrub
 */
$(document).on("click","#newarbustive .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu_ar" : $("#cod_coltu_ar").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_coltu_ar_descr").val("");
                     $("#cod_coltu_ar").val("");
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
 * Manages delete shrub
 **/
$(document).on("click","#content_schedab3_arbustive .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_arbustive\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#erbaceecontainer").prepend("<a id=\"erbacee_list_update\" style=\"display:none;\" href=\""+$("#formB3").attr("action")+"\" data-update=\"content_schedab3_erbacee\"></a>");
/**
 * Manages autocomplete erbacee cod coltu
 **/
function autocompleteColtuEr () {
        $("#cod_coltu_er_descr").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu_er&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu_er").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu_er_descr").val("");
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
autocompleteColtuEr ();
$(document).ajaxComplete(function() {
    autocompleteColtuEr ();
});
/**
 * Manages add new herbaceus
 */
$(document).on("click","#newerbacee .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu_er" : $("#cod_coltu_er").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_coltu_er_descr").val("");
                     $("#cod_coltu_er").val("");
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
 * Manages delete herbaceus
 **/
$(document).on("click","#content_schedab3_erbacee .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab_erbacee\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});