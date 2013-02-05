<?php
$a = new \forest\form\A();
$a->loadFromId($_REQUEST['id']);
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'editnote' :
            $notatemplate = new forest\attribute\NoteTemplate();
            if ($_REQUEST['cod_nota'] == '')
                $formErrors->addError(FormErrors::required,'cod_nota','l\'intestazione','f');
            else {
                $notatemplate->loadFromId($_REQUEST['cod_nota']);
                if(is_null($notatemplate->getData()))
                    $formErrors->addError(FormErrors::wrong,'cod_nota','l\'intestazione','f');
            }
            if ($_REQUEST['text_nota'] == '') {
                $formErrors->addError(FormErrors::required,'text_nota','testo');
            }
            if ($formErrors->count() == 0) {
                $notes = $a->getNotes();
                $note = $notes->addItem();
                $note->setData($notatemplate->getData('nomecampo'),'cod_nota');
                $note->setData($_REQUEST['text_nota'],'nota');
                $note->insert();
            }
            if (key_exists('xhr', $_REQUEST)) {
                $formErrors->getJsonError ();
                exit;
            }
        break;
    }
}
die('HI');
?>
