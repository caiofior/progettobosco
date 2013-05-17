/**
 * Comprese functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$("#compresa").prepend("<a id=\"content_comprese_list_update\" style=\"display:none;\" data-basehref=\""+$("#comprese_list").attr("action")+"\" data-update=\"content_comprese_list\"></a>");
$("#parameter, #operator, #value, #compresa").change(function (){
    trigger = $(this);
    compresa = $("#compresa").val();
    parameter = $("#parameter").val();
    operator = $("#operator").val();
    value = $("#value").val();
    if (
            trigger.attr("id") == "compresa" ||
            (
                parameter != "" &&
                operator != "" 
            )
        ) {
            el = $("#content_comprese_list_update");
            el.attr(
                    "href",el.data("basehref")+"&compresa="+compresa+
                    "&parameter="+parameter+
                    "&operator="+operator+
                    "&value="+value
            );
            el.click(); 
        }
    
});
function draggable () {
    $(".working_circle_selected").hide();
    $(".working_circle_not_selected").show();
    if ($("#compresa").val() != "" ) {
        $(".working_circle_selected").show();
        $(".working_circle_not_selected").hide();
        $("#content_comprese_listall ul li").draggable({ 
            containment: "#main",
            revert: true
        });
        $("#content_comprese_listselected p").droppable({drop:function(event, ui) {
            el = $("#content_comprese_list_update");
            el.attr("href",el.data("basehref")+"&compresa="+$("#compresa").val()+"&add="+ui.draggable.attr("id"));
            el.click();
        }});
        $("#content_comprese_listselected ul li").draggable({ 
            containment: "#main",
            revert: true

        });
         $("#content_comprese_listall p").droppable({drop:function(event, ui) {
            el = $("#content_comprese_list_update");
            el.attr("href",el.data("basehref")+"&compresa="+$("#compresa").val()+"&remove="+ui.draggable.attr("id"));
            el.click();

        }});
    }
}
draggable ();
$(document).ajaxComplete(function() {
    draggable ();
});

