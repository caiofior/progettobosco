/**
 * Comprese functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$("#compresa").prepend("<a id=\"content_comprese_list_update\" style=\"display:none;\" data-basehref=\""+$("#comprese_list").attr("action")+"\" data-update=\"content_comprese_list\"></a>");
$("#compresa").change(function() {
    el = $("#content_comprese_list_update");
    el.attr("href",el.data("basehref")+"&compresa="+$(this).val());
    el.click();
});
function draggable () {
    $("#content_comprese_listall ul li").draggable({ 
        containment: "#main"});
    $("#content_comprese_listselected p").droppable({drop:function() {
        console.log("HI");
    }});
    $("#content_comprese_listselected ul li").draggable({ 
        containment: "#main"});
    $("#content_comprese_listall p").droppable({drop:function() {
        console.log("HI");
    }});
}
draggable ();
$(document).ajaxComplete(function() {
    draggable ();
});

