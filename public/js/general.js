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
     $(messages_selector).hide();
     $("#ajaxloader").show();
     el = $(this);
     el.find(".error").removeClass("error");
     data = el.serializeArray();
     data.push({ name: "xhr", value: "1" });
     data.push({ name: el.find(":submit").attr("name"), value: "1" });
     $.post(el.attr("action"), data, function(response) {
       $("#ajaxloader").hide();
       if (response == true)
           return true;
       $.each(response["names"], function(id,val) {
           $("#"+val).addClass("error");
       });
       $(messages_selector).text(response["messages"]).show();  
       return false;   
     });
     
     return false;  
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
  if (el.val() == "") el.val(value);
  el.focus(function (){
  el = $(this);
  if (el.val()==value) el.val("");
}).blur(function (){
  el = $(this);
  if (el.val()=="") el.val(value);
});
}

