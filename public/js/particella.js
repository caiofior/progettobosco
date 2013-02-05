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
$("#cod_nota_descr").autocomplete({
    source: "bosco.php?task=autocomplete&action=cod_nota",
    select: function( event, ui ) {
        $("#cod_nota").val(ui.item.id )
    },
    change: function( event, ui ) {
            if ( !ui.item ) {
                  $("#cod_nota_descr").val("");
            }
    }
});
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