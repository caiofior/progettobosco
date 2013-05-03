/**
 * Home functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */

 formAjax("#login_form",".login_messages");
 formAjax("#recoverpassword_form",".recoverpassword_messages");
 defaultInputValue("#username","Nome utente (email)");
 $(document).on("click",".password_recover",function(){
     $("#passwordrecover_container").show();
     $(window).scrollTop($("#passwordrecover_container").offset().top);
     return false; 
 });
 /**
  * Set focus to the top
  */
$(document).on("click", "a[data-update]",function () {
    $(window).scrollTop(0);
});