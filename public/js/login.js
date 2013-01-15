 $(function () {
   $("#login_form").submit( function() {
     el = $(this);
     data = el.serializeArray();
     data.push({ name: "xhr", value: "1" });
     data.push({ name: "login", value: "1" });
     $.get(el.attr("action"), data, function() {
       return false;   
     });
     
     return false;  
   });
 });
