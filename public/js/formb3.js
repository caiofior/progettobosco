/* 
 * Form b3 controls
 */
/**
 * Delete B3 form
 */
$(document).on("click",".deleteTab",function(){
    $.colorbox({
        "html"  :   "Vuoi cancellare la scheda selezionata ?"+
                    " <a id=\"deleteTab_confirm\"href=\""+$(this).attr("href")+"&deleteTab3=1\" ><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"deleteTab_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#deleteTab_confirm",function(){
   $.colorbox.close();
});
$(document).on("click","#deleteTab_cancel",function(){
   $.colorbox.close();
   return false;
});
/**
 * Manages forest type description
 **/
$("#t_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=t&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#t").val(ui.item.id );
        $("#formB2").trigger("submit");
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#t_descriz").val($("#t_descriz").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
});
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
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_arbustive\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
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
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_erbacee\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#infestatisscontainer").prepend("<a id=\"infestanti_list_update\" style=\"display:none;\" href=\""+$("#formB3").attr("action")+"\" data-update=\"content_schedab3_infestanti\"></a>");
/**
 * Manages autocomplete infestanti cod coltu
 **/
function autocompleteInfestanti () {
        $("#infestanti_er_descr").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu_er&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#infestanti_er_er").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#infestanti_er_descr").val("");
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
autocompleteInfestanti ();
$(document).ajaxComplete(function() {
    autocompleteInfestanti ();
});
/**
 * Manages add new herbaceus
 */
$(document).on("click","#newinfestanti .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu_er" : $("#infestanti_er").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#infestanti_er_descr").val("");
                     $("#infestanti_er").val("");
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
 * Manages delete infestanti
 **/
$(document).on("click","#content_schedab3_infestanti .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_infestanti\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#arboreecontainer").prepend("<a id=\"arboree_list_update\" style=\"display:none;\" href=\""+$("#formB2").attr("action")+"\" data-update=\"content_schedab3_arboree\"></a>");
/**
 * Manages autocomplete arboree cod coltu
 **/
function autocompleteColtu () {
        $("#cod_coltu_descr, #content_schedab3_arboree input.cod_coltu2").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltu").val(ui.item.id );
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltu_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    arboree_id = $(this).data("arboree-id");
                    $("#cod_coper_"+arboree_id).trigger("change");
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
 * Manages add new forest cover
 */
$(document).on("click","#newarboree .addnew",function(){
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
$(document).on("click","#content_schedab3_arboree .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_arboree\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
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
$("#rinnovazionecontainer").prepend("<a id=\"rinnovazione_list_update\" style=\"display:none;\" href=\""+$("#formB2").attr("action")+"\" data-update=\"content_schedab3_rinnovazione\"></a>");
/**
 * Manages autocomplete arboree cod coltu
 **/
function autocompleteColtuR () {
        $("#cod_coltur_descr, #content_schedab3_rinnovazione input.cod_coltu2").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltur").val(ui.item.id );
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltur_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    arboree_id = $(this).data("arboree-id");
                    $("#cod_coper_"+arboree_id).trigger("change");
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
autocompleteColtuR ();
$(document).ajaxComplete(function() {
    autocompleteColtuR ();
});
/**
 * Manages add new forest cover
 */
$(document).on("click","#newrinnovazione .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu" : $("#cod_coltu").val()
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
$(document).on("click","#content_schedab3_rinnovazione .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_arboree\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#alberaturecontainer").prepend("<a id=\"alberature_list_update\" style=\"display:none;\" href=\""+$("#formB2").attr("action")+"\" data-update=\"alberature\"></a>");
/**
 * Manages autocomplete alebrature cod coltu
 **/
function autocompleteColtuT () {
        $("#cod_coltut_descr, #content_schedab3_alberature input.cod_coltut").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_coltu&objectid="+$("#objectid").val(),
        select: function( event, ui ) {
            $("#cod_coltur").val(ui.item.id );
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_coltur_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    arboree_id = $(this).data("arboree-id");
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
autocompleteColtuT ();
$(document).ajaxComplete(function() {
    autocompleteColtuT ();
});
/**
 * Manages add new forest cover
 */
$(document).on("click","#newalberature .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_coltu" : $("#cod_coltu").val()
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
$(document).on("click","#content_schedab3_alberature .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la specie selezionata ?"+
                    " <a id=\"codcover_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_alberature\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"codcover_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$("#notescontainer").prepend("<a id=\"notes_list_update\" style=\"display:none;\" href=\""+$("#formB3").attr("action")+"\" data-update=\"content_schedab3_note\"></a>");
/**
 * Manages autocomplete note code
 **/
function autocompleteCodeNote () {
        $("#cod_nota_descr, #content_schedab3_note input").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_nota&archivio=schedab3",
        select: function( event, ui ) {
            $("#cod_nota").val(ui.item.id )
        },
        change: function( event, ui ) {
                if ( !ui.item ) {
                      $("#cod_nota_descr").val("");
                }
                el = $(this);
                old = el.data("old-value");
                if (typeof old == "string" && el.val() != "" && el.val() != old) {
                    note_id = $(this).data("note-id");
                    $("#text_nota_"+note_id).trigger("change");
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
autocompleteCodeNote ();
$(document).ajaxComplete(function() {
    autocompleteCodeNote ();
});
/**
 * Manages edit note text
 **/
$(document).on("change","#content_schedab3_note textarea", function() {
    el = $("#newnote .addnew").parent("a");
    note_id = $(this).data("note-id");
    data = {
        "xhr":1,
        "note_id":note_id,
        "cod_nota" : $("#cod_nota_"+note_id).val(),
        "text_nota" : $("#text_nota_"+note_id).val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    $("#notes_list_update").trigger("click");
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
 * Manages add new note
 */
$(document).on("click","#newnote .addnew",function(){
    status = false;
    el = $(this).parent("a");
    data = {
        "xhr":1,
        "cod_nota" : $("#cod_nota").val(),
        "text_nota" : $("#text_nota").val()
    };
    $.ajax({
            type: "POST",
            async: false,
            url: el.attr("href"),
            data: data,
            dataType: "json",
            success: function(response) {
                if (response == true) {
                     $("#cod_nota_descr").val("");
                     $("#cod_nota").val("");
                     $("#text_nota").val("");
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
 * Manages delete note
 **/
$(document).on("click","#content_schedab3_note .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la nota selezionata ?"+
                    " <a id=\"note_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedab3_note\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
                    " <a id=\"note_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Annulla cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#note_delete_confirm",function(){
   $.colorbox.close();
});
$(document).on("click","#note_delete_cancel",function(){
   $.colorbox.close();
   return false;
});
formAjax("#formB3",".formb3_errors");
$("fieldset > div > input,fieldset > input,fieldset > div > select").change(function () {
   $("#formB3").trigger("submit");
});
$("fieldset > div > input").dblclick(function () {
    $(this).val("");
});
$("fieldset").dblclick(function () {
    $(this).find("input:checkbox,input:radio").removeAttr("checked");
});