<?php
$b1 = new \forest\form\B1();
$b1->loadFromId($_REQUEST['id']);
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'editarboree':
            if (key_exists('arboree_id', $_REQUEST)) {
                $forestcovercomposition = new \forest\attribute\ForestCoverComposition();
                $forestcovercomposition->loadFromId($_REQUEST['arboree_id']);
            }
            else {
                $forestcovercompositioncoll = $b1->getForestCoverCompositionColl();
                $forestcovercomposition = $forestcovercompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu','la specie','f');
            if ($_REQUEST['cod_coper'] == '')
                $formErrors->addError(FormErrors::required,'cod_coper','la copertura','f');
            
            $forestcovercomposition->setData($_REQUEST['cod_coltu'],'cod_coltu');
            $forestcovercomposition->setData($_REQUEST['cod_coper'],'cod_coper');
                if (key_exists('arboree_id', $_REQUEST))
                    $forestcovercomposition->update();
                else
                    $forestcovercomposition->insert();
        break;
        case 'editarbustive':
            if (key_exists('arbustive_id', $_REQUEST)) {
                $shrubcomposition = new \forest\attribute\ShrubComposition();
                $shrubcomposition->loadFromId($_REQUEST['arbustive_id']);
            }
            else {
                $shrubcompositioncoll = $b1->getShrubCompositionColl();
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
                $herbaceuscomposition = new \forest\attribute\HerbaceusComposition();
                $herbaceuscomposition->loadFromId($_REQUEST['erbacee_id']);
            }
            else {
                $herbaceuscompositioncoll = $b1->getHerbaceusCompositionColl();
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
        case 'editdesteem':
            if (key_exists('arboree_id', $_REQUEST)) {
                $forestmassesteem = new \forest\attribute\ForestMassEsteem();
                $forestmassesteem->loadFromId($_REQUEST['arboree_id']);
            }
            else {
                $forestmassesteemcoll = $b1->getForestMassEsteemColl();
                $forestmassesteem = $forestmassesteemcoll->addItem();
            }
            if ($_REQUEST['cod_coltu'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu','la specie','f');
            if ($_REQUEST['cod_coper'] == '')
                $formErrors->addError(FormErrors::required,'cod_coper','la copertura','f');
            if ($_REQUEST['massa_tot'] == '')
                $formErrors->addError(FormErrors::required,'massa_tot','la massa totale','f');            
            $forestmassesteem->setData($_REQUEST['cod_coltu'],'cod_coltu');
            $forestmassesteem->setData(substr($_REQUEST['cod_coper'],0,1),'cod_coper');
            $forestmassesteem->setData($_REQUEST['massa_tot'],'massa_tot');
                if (key_exists('arboree_id', $_REQUEST))
                    $forestmassesteem->update();
                else
                    $forestmassesteem->insert();
        break;
    }
}
if (key_exists('deletearboree', $_REQUEST)) {
    $forestcovercomposition = new \forest\attribute\ForestCoverComposition();
    $forestcovercomposition->loadFromId($_REQUEST['deletearboree']);
    $forestcovercomposition->delete();
} else if (key_exists('deletearbustive', $_REQUEST)) {
    $shrubcomposition = new \forest\attribute\ShrubComposition();
    $shrubcomposition->loadFromId($_REQUEST['deletearbustive']);
    $shrubcomposition->delete();
} else if (key_exists('deleteerbacee', $_REQUEST)) {
    $herbaceuscomposition = new \forest\attribute\HerbaceusComposition();
    $herbaceuscomposition->loadFromId($_REQUEST['deleteerbacee']);
    $herbaceuscomposition->delete();
} else if (key_exists('deletemassesteem', $_REQUEST)) {
    $forestmassesteem = new \forest\attribute\ForestMassEsteem();
    $forestmassesteem->loadFromId($_REQUEST['deletemassesteem']);
    $forestmassesteem->delete();
}

