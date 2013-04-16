<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$n = $b->getNColl()->getFirst();

?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formn.css";
</script>
    <div id="tabContent">
        <form id="formN" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formn&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formb1_errors" style="display: none;"></div>
        <a class="deleteTab" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forest_compartment&action=manage&id=<?php echo $a->getData('objectid');?>" alt="Cancella Scheda">
            <img class="actions delete" src="images/empty.png" title="Cancella"/>
            Cancella scheda
        </a>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $n->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="codiope_container">
            <label for="codiope">Rilevatore</label>
            <input type="hidden" id="codiope" name="codiope" value="<?php echo $n->getData('codiope');?>"/>
            <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $n->getCollector()->getData('descriz');?>"/>
        </div>
        <div id="datasch_container">
            <label for="datasch">Data del rilievo</label>
            <input id="datasch" name="datasch" value="<?php echo $n->getData('datasch');?>">
        </div>
        <div id="note_1">
            <h3 >Schede N<br/>REGISTRO DEGLI EVENTI</h3>
        </div>
        <div id="sup_container">
            <label for="sup">Superficie (ha)</label>
            <input id="sup" name="sup" value="<?php echo $n->getData('sup');?>">
        </div>
        <div id="lung_container">
            <label for="lung">Lunghezza (m)</label>
            <input id="lung" name="lung" value="<?php echo $n->getData('lung');?>">
        </div>
        <div id="cod_part_container">
            <label for="cod_part">Particella/<br/>Sottoparticella</label>
            <input id="cod_part" readonly="readonly" name="cod_part" value="<?php echo $n->getData('cod_part');?>">
        </div>
        <div id="cod_part_container">
            <label for="cod_part">Particella/<br/>Sottoparticella</label>
            <input id="cod_part" readonly="readonly" name="cod_part" value="<?php echo $n->getData('cod_part');?>">
        </div>
        <div id="cod_ev_int_container">
            <label for="cod_ev_int">Codice evento</label>
            <input id="cod_ev_int" name="cod_ev_int" value="<?php echo $n->getData('cod_part');?>">
        </div>
        <div id="dataeven_container">
            <label for="dataeven">Mese e Anno</label>
            <input id="dataeven" name="dataeven" value="<?php echo $n->getData('dataeven');?>">
        </div>
        <fieldset id="l_container" >
            <legend>LOCALIZZAZIONE nella parte.....</legend>
            <div>
        <?php
        $labels=array(
          1=> 'N',
          2=> 'E',
          3=> 'S',
          4=> 'O',
          5=> 'Centrale',
          6=> 'Alta',
          7=> 'Bassa',
          8=> 'Sul crinale',
          9=> 'A mezza costa',
          10=>'Nei compluvi',
          11=>'Sui dossi',
          12=>'Presso i fossi',
          13=>'Lungo la strada',
          14=>'Altrove'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $n->getData('l'))
            $checked = 'checked="checked"';
        ?>
        <input type="checkbox" name="l" <?php echo $checked; ?> value="<?php echo $key; ?>"/><div><?php echo $item; ?></div>
        <?php if ($key/4 == intval($key/4)) : ?>
        <br/>
        <?php endif;
        endforeach;?>
            </div>
            <div id="l1_container">
            <label for="l1">specificare</label>
            <input id="l1" name="l1" value="<?php echo $n->getData('l1');?>">
            </div>
        </fieldset>
            
            
    </form>
</div>
<script type="text/javascript" src="js/formn.js" defer="defer"></script>
</div>