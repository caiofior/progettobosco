<?php
$b3 = new \forest\form\B3();
try{
$b3->loadFromId($_REQUEST['id']);
} catch (Exception $e) {
    $a = new \forest\form\A();
    $a->loadFromId($_REQUEST['id']);
    $bcoll = $a->getBColl();
    if ($bcoll->count() == 0) {
        $b = $bcoll->addItem ();
        $b->insert();
        $bcoll = $a->getBColl();
    }
    $b = $bcoll->getFirst();
    $b3coll = $b->getB3Coll();
    if($b3coll->count() == 0) {
        $b3 = $b3coll->addItem ();
        $b3->insert();
        $b3coll = $b->getB3Coll();
    }
    $b3 = $b3coll->getFirst();
}
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
                case 'editarbustive':
            if (key_exists('arbustive_id', $_REQUEST)) {
                $shrubcomposition = new \forest\attribute\B3ShrubComposition();
                $shrubcomposition->loadFromId($_REQUEST['arbustive_id']);
            }
            else {
                $shrubcompositioncoll = $b3->getShrubCompositionColl();
                $shrubcomposition = $shrubcompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu_ar'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu_ar','la specie','f');
           
            $shrubcomposition->setData($_REQUEST['cod_coltu_ar'],'cod_coltu');
            if (key_exists('arbustive_id', $_REQUEST))
                $shrubcomposition->update();
            else
                $shrubcomposition->insert();
        break;
        case 'editerbacee':
            if (key_exists('erbacee_id', $_REQUEST)) {
                $herbaceuscomposition = new \forest\attribute\B3HerbaceusComposition();
                $herbaceuscomposition->loadFromId($_REQUEST['erbacee_id']);
            }
            else {
                $herbaceuscompositioncoll = $b3->getHerbaceusCompositionColl();
                $herbaceuscomposition = $herbaceuscompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu_er'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu_er','la specie','f');
           
            $herbaceuscomposition->setData($_REQUEST['cod_coltu_er'],'cod_coltu');
            if (key_exists('erbacee_id', $_REQUEST))
                $herbaceuscomposition->update();
            else
                $herbaceuscomposition->insert();
        break;
        case 'editinfestanti':
            if (key_exists('erbacee_id', $_REQUEST)) {
                $herbaceuscomposition = new \forest\attribute\PastureWeed();
                $herbaceuscomposition->loadFromId($_REQUEST['erbacee_id']);
            }
            else {
                $herbaceuscompositioncoll = $b3->getPastureWeedColl();
                $herbaceuscomposition = $herbaceuscompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu_er'] == '')
                $formErrors->addError(FormErrors::required,'infestanti_er','la specie','f');
           
            $herbaceuscomposition->setData($_REQUEST['infestanti_er'],'cod_coltu');
            if (key_exists('infestanti_id', $_REQUEST))
                $herbaceuscomposition->update();
            else
                $herbaceuscomposition->insert();
        break;
         case 'update':
            if($_REQUEST['codice_bosco']== '')
                $formErrors->addError(FormErrors::required,'codice_bosco','bosco');
            if(!key_exists('u', $_REQUEST) || $_REQUEST['u']== '')
                $_REQUEST['u']='0';
            if(!key_exists('objectid', $_REQUEST) || $_REQUEST['objectid']== '') {
                $_REQUEST['objectid']=new \Zend_Db_Expr('DEFAULT');
            }
            
            if($_REQUEST['h'] != '' ) {
                if (!filter_var($_REQUEST['h'],FILTER_VALIDATE_FLOAT))
                    $formErrors->addError(FormErrors::valid_float,'h','altezza media');
            }
            
            if($_REQUEST['cop_arbu'] != '' ) {
                if (!filter_var($_REQUEST['cop_arbu'],FILTER_VALIDATE_FLOAT))
                    $formErrors->addError(FormErrors::valid_float,'cop_arbu','copertura(%)');
            }
            
            if($_REQUEST['duratapasc'] != '' ) {
                if (!filter_var($_REQUEST['duratapasc'],FILTER_VALIDATE_INT))
                    $formErrors->addError(FormErrors::valid_float,'duratapasc','durata pascolo');
            }
            
            $formErrors->setOkMessage(' I dati sono stati salvati alle '.  strftime('%k:%M:%S del %d %b'));
            if ($formErrors->count() == 0) {
                $b3->setData($_REQUEST);
                $b3->update();
                $log->setData(array(
                    'user_id'=>$user->getData('id'),
                    'username'=>$user->getData('username'),
                    'description'=>'Modifica della Scheda B3 '.$b3->getData('proprieta').' '.$b3->getData('cod_part'),
                    'objectid'=>$b3->getData('objectid'),
                ));
            }
            $formErrors->getJsonError();
            exit;
    }
}
if (key_exists('deletearbustive', $_REQUEST)) {
    $shrubcomposition = new \forest\attribute\B3ShrubComposition();
    $shrubcomposition->loadFromId($_REQUEST['deletearbustive']);
    $shrubcomposition->delete();
} else if (key_exists('deleteerbacee', $_REQUEST)) {
    $herbaceuscomposition = new \forest\attribute\B3HerbaceusComposition();
    $herbaceuscomposition->loadFromId($_REQUEST['deleteerbacee']);
    $herbaceuscomposition->delete();
} else if (key_exists('deleteinfestanti', $_REQUEST)) {
    $herbaceuscomposition = new \forest\attribute\PastureWeed();
    $herbaceuscomposition->loadFromId($_REQUEST['deleteinfestanti']);
    $herbaceuscomposition->delete();
}