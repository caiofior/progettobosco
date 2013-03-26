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
    <label for="rag">Raggio/Lato 1</label>
    <input id="rag" name="rag" value="<?php echo $d->getData('rag');?>">
</div>
<div id="rag2_container">
    <label for="rag2">Lato 2</label>
    <input id="rag2" name="rag2" value="<?php echo $d->getData('rag2');?>">
</div>
<div id="f_container">
    <label for="f">Fattore di numerazione relascopica</label>
    <input id="f" name="f" value="<?php echo $d->getData('f');?>">
</div>
<p>Metodo di misurazione dell'Incremento</p>
<p>Conteggio del numero degli anelli contenuti negli ultimi</p>
<div id="c_anel_container">
    <label for="c_anel">mm di raggio</label>
    <input id="c_anel" name="c_anel" value="<?php echo $d->getData('c_anel');?>">
</div>
<p>misurazione in mm dello spessore delle ultime</p>
<div id="m_anel_container">
    <label for="m_anel">cerchie annuali</label>
    <input id="m_anel" name="m_anel" value="<?php echo $d->getData('m_anel');?>">
</div>
<div id="note_container">
    <label for="note">Note</label>
    <textarea id="note" name="note" rows="5" cols="15"><?php echo $d->getData('note');?></textarea>
</div>