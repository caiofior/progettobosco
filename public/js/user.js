/**
 * User functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$("#user").dataTable( {
        "oLanguage": {
            "sUrl": "js/DataTables/locale/it_IT.json"
        },
        "aoColumns": [
            { "bVisible": false, "sName": "user.id"},
            { "sName": "username", "sWidth": "20%"},
            { "sName": "first_name", "sWidth": "10%" },
            { "sName": "phone", "sWidth": "10%" },
            { "sName": "address_city", "sWidth": "10%"},
            { "sName": "organization", "sWidth": "10%" },
            { "sName": "creation_datetime", "sWidth": "10%" },
            { "sName": "actions", "sWidth": "30%"}

        ],
        "bStateSave": true,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "user.php"
});
$(document).on("click","#user .delete",function(){
    el = $(this).parent("a");
    $.colorbox({
        "html"  :   "Vuoi cancellare l'utente ?"+
                    " <a id=\"user_delete_confirm\"href=\""+el.attr("href")+"\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions confirm\"/> </a>"+
                    " <a id=\"user_delete_cancel\"href=\"#\"><img src=\"images/empty.png\" title=\"Conferma cancellazione\" class=\"actions cancel\"/> </a>",
        "onLoad": function() {
            $('#cboxClose').remove();
        }
    });
   return false;
});
$(document).on("click","#user .edit",function(){
    el = $(this).parent("a");
    $.ajax({
         type: "POST",
         url: el.attr("href"),
         data: {"xhr":1},
         dataType: "json",
         success: function(response) {
             if (response == true) {
                 $("#user").dataTable().fnReloadAjax();
             }
         }
     });
   return false;
});
$(document).on("click","#user_delete_confirm",function(){
   el = $(this); 
   $.ajax({
            type: "POST",
            url: el.attr("href"),
            data: {"confirm":1,"xhr":1},
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    $("#user").dataTable().fnReloadAjax();
                }
            }
   });
   $.colorbox.close();
   return false;
});
$(document).on("click","#user_delete_cancel",function(){
   $.colorbox.close();
   return false;
});
