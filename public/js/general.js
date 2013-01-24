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
    $(document).on("submit",selector, function() {
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
            dataType: "json",
            success: function(response) {
                if (response == true) {
                    el.find(":submit").removeAttr("name");
                    status = true;
                }
                else if (typeof(response)=="string") {
                    el.find(":submit").removeAttr("name");
                    $(messages_selector).html(response).addClass("succesfull").show();
                    status = false;
                }
                else {
                    $.each(response["names"], function(id,val) {
                        $("#"+val).addClass("error");
                    });
                    $(messages_selector).html(response["messages"]).show();  
                }
                $("#ajaxloader").hide();
            },
            error: function(jqXHR , textStatus,  errorThrown) {
                if (typeof DEBUG != 'undefined') {
                    console.log(textStatus,errorThrown,$(jqXHR.responseText).text());
                }
                $(messages_selector).text("Errore di connessione, riprova in un secondo momento").show();
                $("#ajaxloader").hide();
            }
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
    $(document).ajaxComplete(function (e){
        el = $(selector);
        el.attr("title", value);
        if (el.val()=="") el.val(value).data("default_value",1);
        e.stopPropagation();
    });
    $(el).on("focus",el,function (){
        if (el.val()==value) el.val("").data("default_value",null);
    }).on("blur",el,function (e){
        if (el.val()=="") el.val(value).data("default_value",1);
    });
    $(document).trigger("ajaxComplete");
    
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
