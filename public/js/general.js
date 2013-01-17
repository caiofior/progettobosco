/**
 * Comon functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */ 
/**
* Form ajax request
* @author Claudio Fior <caiofior@gmail.com>
* @copyright CRA
*/
function formAjax(selector,messages_selector) {
    $(selector).submit( function() {
        status = false;
        $(messages_selector).hide();
        $("#ajaxloader").show();
        el = $(this);
        el.find(".error").removeClass("error");
        data = el.serializeArray();
        $.each(data,function(id,val) {
            inp = el.find("[name=\""+val["name"]+"\"]");
            if (inp.data("default_value") == 1)
                val["value"]="";
        })
        data.push({
            name: "xhr", 
            value: "1"
        });
        data.push({
            name: el.find(":submit").attr("name"), 
            value: "1"
        });
        $.ajax({
            type: "POST",
            async: false,
            url: el.attr("action"),
            data: data,
            success: function(response) {
                $("#ajaxloader").hide();
                if (response == true) {
                    el.find(":submit").removeAttr("name");
                    status = true;
                }
                else {
                    $.each(response["names"], function(id,val) {
                        $("#"+val).addClass("error");
                    });
                    $(messages_selector).text(response["messages"]).show();  
                }
            },
            error: function(jqXHR , textStatus,  errorThrown) {
                if (typeof DEBUG != 'undefined') {
                    console.log(textStatus,errorThrown,$(jqXHR.responseText).text());
                }
                $("#ajaxloader").hide();
                $(messages_selector).text("Eorrore di connessione, riprova in un secondo momento").show();
            },
            dataType: "json"
        });
     
        return status;  
    });
}
/**
* Manages default username value 
* @author Claudio Fior <caiofior@gmail.com>
* @copyright CRA
* @param selector selctor of the form element
* @param value default value
*/
function defaultInputValue (selector,value) {
  el = $(selector);
  el.attr("title", value);
  if (el.val() == "") el.val(value).data("default_value",1);
  el.focus(function (){
  el = $(this);
  if (el.val()==value) el.val("").data("default_value",null);
}).blur(function (){
  el = $(this);
  if (el.val()=="") el.val(value).data("default_value",1);
});
}
/**
 * Dinamicaly updates elements 
 */
 $(document).on("click", "a[data-update]", function() {
    $("#ajaxloader").show();
    el = $(this);
    data = $.extend({"action":"xhr_update"}, el.data("update").split(" "));
    $.ajax({
        type: "GET",
        url: el.attr("href"),
        data: data,
        success: function(response) {
            $("#ajaxloader").hide();
            $.each(response, function(key,value) {
              $("#"+key).replaceWith(value);   
            });
        },
        error: function(jqXHR , textStatus,  errorThrown) {
            if (typeof DEBUG != 'undefined') {
                console.log(textStatus,errorThrown,$(jqXHR.responseText).text());
            }
            $("#ajaxloader").hide();
          },
        dataType: "json"
    });
    return false;
});
