<?php
$dcoll = $x->getDColl();
$dcoll->loadAll();
if($dcoll->count() == 0)
    $d = $dcoll->addItem();
else
    $d = $dcoll->getFirst();
?>
<fieldset>
<div id="data_container">
    <label for="data">Data</label>
    <input readonly="readonly" id="data" name="data" value="<?php echo $x->getData('data');?>">
</div>
<p >Scheda D per il rilievo dendrometrico IRD</p>
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
<div id="f_container">
    <label for="f">Fattore di numerazione relascopica</label>
    <input id="f" name="f" value="<?php echo $d->getData('f');?>">
</div>
<p id="note_ird1">Metodo di misurazione dell' incremento</p>
<p id="note_ird2">Conteggio del numero degli anelli contenuti negli ultimi</p>
<p id="note_ird3">misurazione in mm dello spessore delle ultime</p>
<div id="c_anel_container">
    <label for="c_anel">mm di raggio</label>
    <input id="c_anel" name="c_anel" value="<?php echo $d->getData('c_anel');?>">
</div>
<div id="m_anel_container">
    <label for="m_anel">cerchie annuali</label>
    <input id="m_anel" name="m_anel" value="<?php echo $d->getData('m_anel');?>">
</div>

<div id="note_container">
    <label for="note">Note</label>
    <textarea id="note" name="note" rows="5" cols="15"><?php echo $d->getData('note');?></textarea>
</div>
</fieldset>
<script type="text/javascript" src="js/rilievidendrometriciedit.js" defer="defer"></script>