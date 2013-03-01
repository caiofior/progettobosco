<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new forest\form\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$b2 = $b->getB2Coll()->getFirst();
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formb2.css";
</script>
    <div id="tabContent">
    <form id="formB2" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formb1_errors" style="display: none;"></div>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $b2->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
                    <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="note_1">
            <h3 >Schede B2 per descrivere una formazione specializzata per produzioni non legnose od impianti per arboricoltura da legno</h3>
        </div>
        <div id="cod_part_container">
            <label class="double" for="cod_part">Particella / sottoparticella</label>
            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
        </div>
        </fieldset>
        <fieldset id="ucontainer" >
            <legend>Tipo</legend>
        <?php
        foreach($b2->getControl('u')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b2->getData('u'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="u" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="m_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>

    </form>
</div>
<script type="text/javascript" src="js/formb2.js" defer></script>
</div>