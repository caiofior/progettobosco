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
        <div id="ce_container">
            <label for="ce">Grado di copertura (%)</label>
            <input id="ce" name="ce" value="<?php echo $b1->getData('ce');?>">
        </div>
        <div id="spe_nov_container">
            <label for="spe_nov">Specie prevalente rinnovazione</label>
            <?php 
            $rennovationspecie = $b1->getRennovationSpecie();
            $value = '';
            if ($b1->getData('spe_nov') != '')
                $value = $rennovationspecie->getData('nome_itali').' | '.$rennovationspecie->getData('nome_scien');
            ?>
            <input type="hidden" id="spe_nov" name="spe_nov" value="<?php echo $b1->getData('spe_nov');?>"/>
            <input id="spe_nov_descr" name="spe_nov_descr" value="<?php echo $value; ?>" data-old-value="<?php echo $value; ?>">
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
                    $cod_coper_coll= $forestcovercomposition->getControl('cod_coper');
                    foreach($cod_coper_coll->getItems() as $item) : ?>
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
        <fieldset id="prep_terrcontainer" >
        <legend>Preparazione terreno</legend>
        <?php
        foreach($b1->getControl('prep_terr')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('prep_terr'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="prep_terr" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="prep_terr_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="vcontainer" >
        <legend>Vuoti - lacune</legend>
        <?php
        foreach($b1->getControl('v')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('v'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="v" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="v_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="dcontainer" >
        <legend>Densità d'impianto</legend>
        <?php
        $labels=array(
            2=>'Scarsa',
            3=>'Adeguata',
            4=>'Eccessiva'
        );
        foreach($b1->getControl('d')->getItems() as $item) :
        if (!key_exists($item->getRawData('codice'), $labels))
                continue;
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('d'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="d" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="d_descr"><?php echo $labels[$item->getRaWData('codice')]; ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="sestocontainer" >
        <legend>Sesto d'impianto</legend>
        <div id="sesto_imp_tra_file_container">
            <label for="sesto_imp_tra_file">tra file/gradoni (m)</label>
            <input id="sesto_imp_tra_file" name="sesto_imp_tra_file" value="<?php echo $b1->getData('sesto_imp_tra_file');?>">
        </div>
        <div id="sesto_imp_su_file_container">
            <label for="sesto_imp_su_file">sulla fila/gradone (m)</label>
            <input id="sesto_imp_su_file" name="sesto_imp_su_file" value="<?php echo $b1->getData('sesto_imp_su_file');?>">
        </div>
        <div id="buche_container">
            <label for="buche">buche (n/ha)</label>
            <input id="buche" name="buche" value="<?php echo $b1->getData('buche');?>">
        </div>
        </fieldset>
        <fieldset id="srcontainer" >
        <legend>Strato arbustivo: diffusione</legend>
        <?php
        foreach($b1->getControl('sr')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('sr'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sr" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="sr_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="arbustivecontainer" >
        <legend>Specie significative strato arbustivo</legend>
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
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editerbacee&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_erbacee">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'arbustive.php');?>
        </fieldset>
         <fieldset id="secontainer" >
        <legend>Strato erbaceo: diffusione</legend>
        <?php
        foreach($b1->getControl('se')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('se'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="se" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="se_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="erbaceecontainer" >
        <legend>Specie significative strato erbaceo</legend>
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
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb1&action=editerbacee&id=<?php echo $b1->getData('objectid');?>" data-update="content_schedab_arbustive">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie erbacea"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab'.DIRECTORY_SEPARATOR.'erbacee.php');?>
        </fieldset>
        <fieldset id="n1container" >
        <legend>Novellame</legend>
        <?php
        foreach($b1->getControl('n1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('n1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="n1_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="n1arrow_right"></fieldset>
        <fieldset id="n2container" >
        <?php
        foreach($b1->getControl('n2')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('n2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n2" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="n2_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="n3container" >
        <legend>Rinnovazione</legend>
        <?php
        foreach($b1->getControl('n3')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $b1->getData('n3'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n3" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="n3_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="n3arrow_right"></fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formb1.js" defer></script>
</div>