/**
 * On page ready functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */

 formAjax("#login_form",".login_messages");
 formAjax("#recoverpassword_form",".recoverpassword_messages");
 defaultInputValue("#username","Nome utente");
 $(document).on("click",".password_recover",function(){
     $("#passwordrecover_container").show();
    return false; 
 });
