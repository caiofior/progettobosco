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
    }
}
if (key_exists('deletearboree', $_REQUEST)) {
    $forestcovercomposition = new \forest\attribute\ForestCoverComposition();
    $forestcovercomposition->loadFromId($_REQUEST['deletearboree']);
    $forestcovercomposition->delete();
}
