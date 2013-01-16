/**
 * On page ready functions
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
$(function () {
   
   formAjax("#login_form",".login_messages");
   defaultInputValue("#username","Nome utente");
   defaultInputValue("#password","Password");
   
});
