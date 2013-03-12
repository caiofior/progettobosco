<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new forest\form\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$b3 = $b->getB3Coll()->getFirst();
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formb3.css";
</script>
    <div id="tabContent">
    <form id="formB3" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formb3_errors" style="display: none;"></div>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $b3->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="note_1">
            <h3 >Schede B3 per descrivere una formazione arbustiva-erbacea-improduttiva privo vegetazione</h3>
        </div>
        <div id="cod_part_container">
            <label  for="cod_part">Particella / sottoparticella</label>
            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
        </div>
        <div id="t_container">
            <label for="t" >Tipo forestale</label>
            <input type="hidden" id="t" name="t" value="<?php echo $b->getData('t');?>">
            <input data-old-descriz="<?php echo $b->getForestType()->getData('descriz'); ?>" id="t_descriz" name="t_descriz" value="<?php echo $b->getForestType()->getData('descriz');?>">
        </div>
        </fieldset>
        <fieldset id="ucontainer" >
            <legend>Tipo</legend>
            <div>
        <?php
        $labels=array(
          3=> 'formazione arbustiva',
          4=> 'incolto erbaceo',
          5=> 'pascolo',
          6=> 'prato pascolo',
          7=> 'coltivo',
          9=> 'improduttivo privo veget.',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b->getData('u'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="u" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="u_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
            </div>
        </fieldset>
        <p id="tab1note">Formazione arbustiva</p>
        <fieldset id="tab1container">
        <div id="hcontainer">
            <label for="h">Altezza media</label>
            <input id="h" name="h" value="<?php echo $b3->getData('h');?>">
        </div>      
        <div id="cop_arbucontainer">
            <label for="cop_arbu">Copertura (%)</label>
            <input id="cop_arbu" name="cop_arbu" value="<?php echo $b3->getData('cop_arbu');?>">
        </div>
        </fieldset>
        <fieldset id="secontainer" >
        <legend>Diffusione strato erbaceo</legend>
        <?php
        foreach($b3->getControl('se')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b3->getData('se'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="se" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="arbustivecontainer" >
        <legend>Strato arbustivo - specie significative</legend>
        <div id="newarbustive">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltu_ar" name="cod_coltu_ar" value=""/>
                <input id="cod_coltu_ar_descr" name="cod_coltu_ar_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&action=editarbustive&id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_arbustive">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'arbustive.php');?>
        </fieldset>
        <fieldset id="erbaceecontainer" >
        <legend>Specie erbacee significative</legend>
        <div id="newerbacee">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltu_er" name="cod_coltu_er" value=""/>
                <input id="cod_coltu_er_descr" name="cod_coltu_er_descr" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb3&action=editerbacee&id=<?php echo $b3->getData('objectid');?>" data-update="content_schedab3_erbacee">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab3'.DIRECTORY_SEPARATOR.'erbacee.php');?>
        </fieldset>
        <p id="tab2note">Incolto erbaceo</p>
        <fieldset id="tab2container">
        <div id="cop_erbacontainer">
            <label for="cop_erba">Copertura (%)</label>
            <input id="cop_erba" name="cop_erba" value="<?php echo $b3->getData('cop_erba');?>">
        </div>      
        <div id="sr_perccontainer">
            <label for="sr_perc">Copertura  strato arbustivo % </label>
            <input id="sr_perc" name="sr_perc" value="<?php echo $b3->getData('sr_perc');?>">
        </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formb3.js" defer></script>
</div>