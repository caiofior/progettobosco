/**
 * Form a controls
 */
$("#datasch").datepicker({dateFormat:"yy-mm-dd"});
/**
 * Manages comune description
 **/
$("#comune_descriz").autocomplete({
    minLength: 0,
    source: "bosco.php?task=autocomplete&action=municipality&codice="+$("#codice_bosco").val(),
    select: function( event, ui ) {
        $("#comune").val(ui.item.id )
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#comune_descriz").val($("#comune_descriz").data("old-descriz"));
            }
    }
}).focus(function() {
    $(this).val("").autocomplete("search","")
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
$(document).on("change","#sup",function(){
   el = $(this);
   if (el.val()> 0)
       $("input[name=delimitata]").removeAttr("disabled");
   else
       $("input[name=delimitata]").attr("disabled","disabled");
});
$("#sup").trigger("change");
$("#notescontainer").prepend("<a id=\"notes_list_update\" style=\"display:none;\" href=\""+$("#formA").attr("action")+"\" data-update=\"content_schedaa_note\"></a>");
/**
 * Manages autocomplete noe code
 **/
function autocompleteCodeNote () {
        $("#cod_nota_descr, #content_schedaa_note input").autocomplete({
        minLength: 0,
        source: "bosco.php?task=autocomplete&action=cod_nota",
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
$(document).on("change","#content_schedaa_note textarea", function() {
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
                    //$(messages_selector).html(response["messages"]).show();  
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
                    //$(messages_selector).html(response["messages"]).show();  
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
$(document).on("click","#content_schedaa_note .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare la nota selezionata ?"+
                    " <a id=\"note_delete_confirm\"href=\""+el.attr("href")+"\" data-update=\"content_schedaa_note\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\" /> </a>"+
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
/**
 * Manages cadastral table
 */
$("#cadastral").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "objectid"},
            { "sName": "foglio", "sWidth": "10%"},
            { "sName": "particella", "sWidth": "10%" },
            { "sName": "sup_tot_cat", "sWidth": "10%" },
            { "sName": "sup_tot", "sWidth": "10%"},
            { "sName": "sup_bosc", "sWidth": "10%" },
            { "sName": "sum_sup_non_bosc", "sWidth": "10%" },
            { "sName": "porz_perc", "sWidth": "10%" },
            { "sName": "note", "sWidth": "10%"},
            { "sName": "actions", "sWidth": "20%"}

        ],
        "bStateSave": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "bosco.php?task=forma&action=cadastraltable&id="+$("#objectid").val()
});