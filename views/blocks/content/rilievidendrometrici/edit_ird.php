<?php
$dcoll = $x->getDColl();
$dcoll->loadAll();
if($dcoll->count() == 0)
    $d = $dcoll->addItem();
else
    $d = $dcoll->getFirst();
?>
<p>Scheda D per il rilievo dendrometrico IRD</p>
<div id="n_camp_container">
    <label for="n_camp">N° Unità campionamento</label>
    <input id="n_camp" name="n_camp" value="<?php echo $d->getData('n_camp');?>">
</div>
<div id="codiope_container">
    <label for="codiope">Rilevatore</label>
    <input type="hidden" id="codiope" name="codiope" value="<?php echo $d->getData('codiope');?>"/>
    <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $d->getCollector()->getData('descriz');?>"/>
</div>
<div id="p_container">
    <label for="p">Pendenza</label>
    <input id="p" name="p" value="<?php echo $d->getData('p');?>">
</div>
<div id="x_container">
    <label for="x">X</label>
    <input id="x" name="x" value="<?php echo $d->getData('x');?>">
</div>
<div id="y_container">
    <label for="y">Y</label>
    <input id="y" name="y" value="<?php echo $d->getData('y');?>">
</div>
<div id="t_camp_container">
    <label >Tipo di unità campionaria</label>
    <?php $labels = array(
        1=>'IAS',
        2=>'IRD'
    );
    foreach ($labels as $key=>$value) : ?>
    <br/><input <?php echo ($key == $d->getData('t_camp') ? 'checked="checked"' : '')?> type="checkbox" name="t_camp" value="<?php echo $key;?>"><?php echo $value; ?>
    <?php endforeach; ?>
</div>
<div id="rag_container">
    <label for="rag">Raggio/Lato1</label>
    <input id="rag" name="rag" value="<?php echo $d->getData('rag');?>">
</div>
<div id="rag2_container">
    <label for="rag2">Lato2</label>
    <input id="rag2" name="rag2" value="<?php echo $d->getData('rag2');?>">
</div>