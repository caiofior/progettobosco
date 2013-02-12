<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new forest\form\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$b = $a->getBColl()->getFirst();
$b1 = $b->getB1Coll()->getFirst();
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/formb1.css";
</script>
    <div id="tabContent">
    <form id="formB1" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages forma_errors" style="display: none;"></div>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $a->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="note_1">
            <h3 >Schede B per descrivere una formazione arborea</h3>
        </div>
        <div id="u_container">
            <label class="double" for="u">Tipo: formazione arborea</label>
            <input type="checkbox" id="u" name="u" <?php echo ( $b->getData('u') == 1 ? 'checked="checked"' : ''); ?>>
        </div>
        <div id="t_container">
            <label for="t" class="double">Tipo forestale</label>
            <input type="hidden" id="t" name="t" value="<?php echo $b->getData('t');?>">
            <input data-old-descriz="<?php echo $b->getForestType()->getData('descriz'); ?>" id="t_descriz" name="t_descriz" value="<?php echo $b->getForestType()->getData('descriz');?>">
        </div>
        <div id="cod_part_container">
            <label class="double" for="cod_part">Particella / sottoparticella</label>
            <input readonly="readonly" id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
        </div>
        <div id="s_container">
            <label for="s" class="double">Struttura e sviluppo</label>
            <input type="hidden" id="s" name="s" value="<?php echo $b1->getData('s');?>">
            <input data-old-descriz="<?php echo $b1->getStructure()->getData('descriz'); ?>" id="s_descriz" name="s_descriz" value="<?php echo $b1->getStructure()->getData('descriz');?>">
        </div>
        <div id="c1_container">
            <label for="c1">Età prevalente accertata</label>
            <input id="c1" name="c1" value="<?php echo $b1->getData('c1');?>">
        </div>
        </fieldset>
        <fieldset id="mcontainer" >
        <legend>Matricinatura</legend>
        <?php
        foreach($b1->getControl('m')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('m'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="m" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="m_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="ocontainer" >
        <legend>Origine del bosco</legend>
        <?php
        $labels=array(
          1=> 'dissem. naturale',
          2=> 'artificiale',
          3=> 'agamica o<br/>ceduo in conver.',
          4=> 'incerta',
          5=> 'bosco di<br/> neoformazione'
        );
        foreach($b1->getControl('o')->getItems() as $item) :
        if ($item->getRawData('codice') == 4)
            continue;
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('o'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="o" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="o_descr"><?php echo $labels[$item->getRawData('codice')]; ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="vigcontainer" >
        <legend>Vigoria</legend>
        <?php
        $labels=array(
          1=> 'dissem. naturale',
          2=> 'artificiale',
          3=> 'agamica o<br/>ceduo in conver.',
          4=> 'incerta',
          5=> 'bosco di<br/> neoformazione'
        );
        foreach($b1->getControl('vig')->getItems() as $item) :
        if ($item->getRawData('codice') == 4)
            continue;
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('vig'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="vig_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="arboreecontainer" >
        <legend>Composizione strato arboreo</legend>
        <div id="newarboree">
                <div>
                    <span>
                        <div>Specie</div>
                    </span>
                    <span>
                        <div>Copertura</div>
                    </span>
                    <span>
                        <div>Azioni</div>
                    </span>
                </div>
            <div>
            <span>
                <input type="hidden" id="cod_coltu" name="cod_coltu" value=""/>
                <input id="cod_coltu_descr" name="cod_coltu_descr" value=""/>
            </span>

            <span>
                <select id="cod_coper" name="cod_coper">
                    <option value="">Scegli un valore di copertura</option>
                    <?php
                    $forestcovercomposition = new \forest\attribute\ForestCoverComposition();
                    foreach($forestcovercomposition->getControl('cod_coper')->getItems() as $item) : ?>
                    <option value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
                    <?php endforeach;?>
                </select>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editarboree&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_arboree">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arborea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'arboree.php');?>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formb1.js" defer></script>
</div>