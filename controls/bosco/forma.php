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
                if (key_exists('note_id', $_REQUEST)) {
                   $note = new forest\attribute\NoteA();
                   $note->loadFromId($_REQUEST['note_id']);
                } else {
                    $notes = $a->getNotes();
                    $note = $notes->addItem();
                }
                $note->setData($notatemplate->getData('nomecampo'),'cod_nota');
                $note->setData($_REQUEST['text_nota'],'nota');
                if (key_exists('note_id', $_REQUEST))
                    $note->update();
                else
                    $note->insert();
            }
            if (key_exists('xhr', $_REQUEST)) {
                $formErrors->getJsonError ();
                exit;
            }
        break;
        case 'cadastraltable':
            $cadastralcoll = $a->getCadastalColl();
            $cadastralcoll->loadAll($_REQUEST);
            $response =array(
                'sEcho'=>  intval($_REQUEST['sEcho']),
                'iTotalRecords'=>$cadastralcoll->countAll(),
                'iTotalDisplayRecords'=>$cadastralcoll->count(),
                'sColumns'=>  implode(',',$cadastralcoll->getColumns()),
                'aaData'=>array()
            );
            foreach($cadastralcoll->getItems() as $cadastral) :
                
                $datarow = array();
                $datarow[]=intval($cadastral->getData('objectid'));
                $datarow[]=$cadastral->getData('foglio');
                $datarow[]=$cadastral->getData('particella');
                $datarow[]=floatval($cadastral->getData('sup_tot_cat'));
                $datarow[]=floatval($cadastral->getData('sup_tot'));
                $datarow[]=floatval($cadastral->getData('sup_bosc'));
                $datarow[]=floatval($cadastral->getData('sum_sup_no_bosc'));
                $datarow[]=floatval($cadastral->getData('porz_perc'));
                $datarow[]=$cadastral->getData('note');
                ob_start();
                ?>
        <div class="table_actions">
            <a href="user.php?action=delete&id=<?php echo intval($cadastral->getData('objectid'));?>"><img class="actions delete" src="images/empty.png" title="Cancella"/></a>
        </div>
                <?php $datarow[]=  ob_get_clean();
                $response['aaData'][]=$datarow;
            endforeach;
            header('Content-type: application/json');
            echo Zend_Json::encode($response);
            exit;
        break;
    }
}
if (key_exists('deletenote', $_REQUEST)) {
    $notaa = new \forest\attribute\NoteA();
    $notaa->loadFromId($_REQUEST['deletenote']);
    $notaa->delete();
}
