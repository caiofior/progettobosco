<div id="content_schedab_arboree">
    <?php
    if (!isset($a)) {
        $a = new forest\form\A();
        $a->loadFromId($_REQUEST['id']);
        $forest = $a->getForest();
        $b = $a->getBColl()->getFirst();
        $b1 = $b->getB1Coll()->getFirst();
    }
    $forestcovercompositioncoll = $b1->getForestCoverComposition();
    
    if (!key_exists('start', $_GET))
            $_GET['start']=0;
    $items_in_page =2;
    
    $forestcovercompositioncoll->loadAll(array(
        'start'=>$_GET['start'],
        'length'=>$items_in_page
    ));
    foreach ($forestcovercompositioncoll->getItems() as $forestcovercomposition) :
    ?>
    <div>
        <span>
            <div>
                <input type="hidden" id="cod_coltu_<?php echo $forestcovercomposition->getData('objectid');?>" name="cod_coltu_<?php echo $forestcovercomposition->getData('objectid');?>" value="<?php echo $forestcovercomposition->getRawData('cod_coltu');?>"/>
                <input id="cod_coltu_descr_<?php echo $forestcovercomposition->getData('objectid');?>" data-codecoltu-id="<?php echo $forestcovercomposition->getData('objectid');?>" name="cod_coltu_descr_<?php echo $forestcovercomposition->getData('objectid');?>" value="<?php echo $forestcovercomposition->getRawData('cod_colt_descriz');?>" data-old-value="<?php echo $forestcovercomposition->getRawData('cod_colt_descriz');?>">
            </div>
        </span>
        <span>
            <div>
                <input type="hidden" id="cod_coper_<?php echo $forestcovercomposition->getData('objectid');?>" name="cod_coper_<?php echo $forestcovercomposition->getData('objectid');?>" value="<?php echo $forestcovercomposition->getRawData('cod_coper');?>"/>
                <input id="cod_coper_descr_<?php echo $forestcovercomposition->getData('objectid');?>" data-codecoper-id="<?php echo $forestcovercomposition->getData('objectid');?>" name="cod_coper_descr_<?php echo $forestcovercomposition->getData('objectid');?>" value="<?php echo $forestcovercomposition->getRawData('cod_coper_descriz');?>" data-old-value="<?php echo $forestcovercomposition->getRawData('cod_coper_descriz');?>">
            </div>
        </span>
        <span>
            <div>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forma&id=<?php echo $b1->getData('objectid');?>&deletenote=<?php echo $forestcovercomposition->getData('objectid');?>"  >
                    <img class="actions delete" src="images/empty.png" title="Cancella"/>
                </a>
            </div>
        </span>
    </div>
    <?php endforeach; 
    
    $start = $_GET['start'];
    unset($_GET['start']);
    unset($_GET['task']);
    unset($_GET['action']);
    $baseurl = http_build_query($_GET);
    $actions =array(
        'first'=>array(
            'url'=>'',
            'data-update'=>''
        ),
        'prev'=>array(
            'url'=>'',
            'data-update'=>''
        ),
        'next'=>array(
            'url'=>'',
            'data-update'=>''
        ),
        'last'=>array(
            'url'=>'',
            'data-update'=>''
        ),
    );
    $countall =$forestcovercompositioncoll->countAll();
    $last_page = floor($countall/$items_in_page)*$items_in_page;

    if ($start>0) {
        $actions['prev']=array(
            'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
            'data-update'=>'data-update="content_schedaa_note"'
        );
        $actions['first']=array(
            'url'=>'href="?'.$baseurl.'&start=0"',
            'data-update'=>'data-update="content_schedaa_note"'
        );
    }

    if ($start<$countall-$items_in_page) {

        $actions['next']=array(
            'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
            'data-update'=>'data-update="content_schedaa_note"'
        );
         $actions['last']=array(
            'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
            'data-update'=>'data-update="content_schedaa_note"'
        );
    }
    ?>
    <div id="scrollcontrols">
        <span>
        <a <?php echo $actions['first']['url'];?> <?php echo $actions['first']['data-update'];?> >
            <img class="actions first" src="images/empty.png" title="Primo">
        </a>
        <a <?php echo $actions['prev']['url'];?> <?php echo $actions['prev']['data-update'];?> >
            <img class="actions prev" src="images/empty.png" title="Precedente">
        </a>
        </span>
        <span>
            Nota <input id="current" name="current" value="<?php echo $start; ?>" type="text"  /> di <?php echo $countall; ?></span>
        <a href="#" style="display: none;" id="confirm_move">
            <img class="actions confirm" src="images/empty.png" title="Vai">
        </a>
        <a href="#" style="display: none;" id="cancel_move">
            <img class="actions cancel" src="images/empty.png" title="Annulla">
        </a>
        </span>
        <span>
        <a <?php echo $actions['next']['url'];?> <?php echo $actions['next']['data-update'];?> >
            <img class="actions next" src="images/empty.png" title="Successivo">
        </a>
        <a <?php echo $actions['last']['url'];?> <?php echo $actions['last']['data-update'];?> >
            <img class="actions last" src="images/empty.png" title="Ultimo">
        </a>
        </span>
    </div>
</div>
    