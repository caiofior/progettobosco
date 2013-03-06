<?php
$b2 = new \forest\form\B2();
try{
$b2->loadFromId($_REQUEST['id']);
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
    $b2coll = $b->getB2Coll();
    if($b12coll->count() == 0) {
        $b2 = $b2coll->addItem ();
        $b2->insert();
        $b2coll = $b->getB2Coll();
    }
    $b2 = $b2coll->getFirst();
}
if (key_exists('action', $_REQUEST)) {
    switch ($_REQUEST['action']) {
        case 'editarboree':
            if (key_exists('arboree_id', $_REQUEST)) {
                $corkcovercomposition = new \forest\attribute\ForestCoverComposition();
                $corkcovercomposition->loadFromId($_REQUEST['arboree_id']);
            }
            else {
                $corkcovercompositioncoll = $b1->getForestCoverCompositionColl();
                $corkcovercomposition = $forestcovercompositioncoll->addItem();
            }
            if ($_REQUEST['cod_coltu'] == '')
                $formErrors->addError(FormErrors::required,'cod_coltu','la specie','f');
            if ($_REQUEST['cod_coper'] == '')
                $formErrors->addError(FormErrors::required,'cod_coper','la copertura','f');
            
            $corkcovercomposition->setData($_REQUEST['cod_coltu2'],'cod_coltu');
            $corkcovercomposition->setData($_REQUEST['cod_coper2'],'cod_coper');
                if (key_exists('arboree_id', $_REQUEST))
                    $corkcovercomposition->update();
                else
                    $corkcovercomposition->insert();
        break;
    }
}
if (key_exists('deletearboree', $_REQUEST)) {
    $corkcovercomposition = new \forest\attribute\CorkCoverComposition();
    $corkcovercomposition->loadFromId($_REQUEST['deletearboree']);
    $corkcovercomposition->delete();
}