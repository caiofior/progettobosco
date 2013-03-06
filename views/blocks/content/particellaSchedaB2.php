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
        <div id="t_container">
            <label for="t" class="double">Tipo forestale</label>
            <input type="hidden" id="t" name="t" value="<?php echo $b->getData('t');?>">
            <input data-old-descriz="<?php echo $b->getForestType()->getData('descriz'); ?>" id="t_descriz" name="t_descriz" value="<?php echo $b->getForestType()->getData('descriz');?>">
        </div>
        </fieldset>
        <fieldset id="ucontainer" >
            <legend>Tipo</legend>
            <div>
        <?php
        $labels=array(
          10=> 'arboricoltura specializzata da legno',
          2=> 'castagneti da frutto',
          11=> 'impianti specializzati per tartuficoltura',
          12=> 'sugherete'
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
        <p id="tab1note">Arboricoltura specializzata da legno</p>
        <fieldset id="tipocontainer">
            <legend>Tipo di impianto</legend>
            <div>
        <?php
        $labels=array(
          1=> 'per biomasse',
          2=> 'a ciclo corto',
          3=> 'a ciclo medio lungo'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('tipo'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="tipo" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="tipo_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="tab1container">
        <div id="anno_imp_container">
            <label for="anno_imp">Anno d'impianto</label>
            <input id="anno_imp" name="anno_imp" value="<?php echo $b2->getData('anno_imp');?>">
        </div>
        <div id="anno_dest_container">
            <label for="anno_dest">Anno di possibile cambio di destinazione</label>
            <input id="anno_dest" name="anno_dest" value="<?php echo $b2->getData('anno_dest');?>">
        </div>
        <div id="cod_coltup_container">
            <label for="cod_coltup">Specie principale componente arborea</label>
            <input type="hidden" id="cod_coltup" name="cod_coltup" value="<?php echo $b2->getData('cod_coltup');?>"/>
            <input id="cod_coltup_descr" name="cod_coltup_descr" value="<?php echo $b2->getRawData('cod_coltup_descriz');?>"/>
        </div>
        <div id="cod_coltus_container">
            <label for="cod_coltus">Specie secondaria componente arborea</label>
            <input type="hidden" id="cod_coltus" name="cod_coltus" value="<?php echo $b2->getData('cod_coltus');?>"/>
            <input id="cod_coltus_descr" name="cod_coltus_descr" value="<?php echo $b2->getRawData('cod_coltus_descriz');?>"/>
        </div>
        <div id="dist_container">
            <label for="dist">Distanza tra le piante</label>
            <input id="dist" name="dist" value="<?php echo $b2->getData('dist');?>">
        </div>
        <div id="dist_princ_container">
            <label for="dist_princ">Distanza tra le piante della specie principale</label>
            <input id="dist_princ" name="dist_princ" value="<?php echo $b2->getData('dist_princ');?>">
        </div>
        <div id="fall_container">
            <label for="fall">Fallanze (%)</label>
            <input id="fall" name="fall" value="<?php echo $b2->getData('fall');?>">
        </div>
        </fieldset>
        <fieldset id="com_specontainer" >
        <legend>Composizione specifica</legend>
        <div>
        <?php
        $labels=array(
          1=> 'puro',
          2=> 'misto',
          3=> 'consociato'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('com_spe'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="com_spe" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="com_spe_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="sesto_imp_arbcontainer" >
        <legend>Sesto d'impianto</legend>
        <div>
        <?php
        $labels=array(
          1=> 'quadrato',
          2=> 'rettangolo',
          3=> 'quinconce',
          4=> 'settonce',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('sesto_imp_arb'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_imp_arb" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="sesto_imp_arb_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="sesto_imp_sp_princ_arbcontainer" >
        <legend>Sesto d'impianto specie principale</legend>
        <div>
        <?php
        $labels=array(
          1=> 'quadrato',
          2=> 'rettangolo',
          3=> 'quinconce',
          4=> 'settonce',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('sesto_imp_sp_princ'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_imp_sp_princ" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="sesto_imp_sp_princ_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vig_arb_princcontainer" >
        <legend>Vigoria specie principale</legend>
        <div>
        <?php
        $labels=array(
          1=> 'mediocre',
          2=> 'buona',
          3=> 'ottima'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('vig_arb_princ'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_arb_princ" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="vig_arb_princ_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vig_arb_seccontainer" >
        <legend>Vigoria specie secondaria</legend>
        <div>
        <?php
        $labels=array(
          1=> 'mediocre',
          2=> 'buona',
          3=> 'ottima'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('vig_arb_sec'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_arb_sec" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="vig_arb_sec_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="qual_pricontainer" >
        <legend>Qualità fusto specie principale</legend>
        <div>
        <?php
        $labels=array(
          1=> 'mediocre',
          2=> 'buona',
          3=> 'ottima'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('qual_pri'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="qual_pri" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="qual_pri_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="line1tab1"></div>
        <div id="line2tab1"></div>
        <p id="tab2note">Castagneto da frutto</p>
        <fieldset id="colt_castcontainer" >
        <legend>Stato</legend>
        <div>
        <?php
        $labels=array(
          1=> 'Coltivazione regolare',
          2=> 'Coltivazione irregolare',
          3=> 'Abbandonato',
          4=> 'In fase d\'impianto',
          5=> 'In fase di ricostruzione'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('colt_cast'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="colt_cast" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="colt_cast_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vig_castcontainer" >
        <legend>Vigoria</legend>
        <div>
        <?php
        $labels=array(
          1=> 'mediocre',
          2=> 'buona',
          3=> 'ottima'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('vig_cast'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_cast" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="vig_cast_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="sesto_imp_castcontainer" >
        <legend>Sesto d'impianto</legend>
        <div>
        <?php
        $labels=array(
          1=> 'quadrato',
          2=> 'rettangolo',
          3=> 'quinconce',
          4=> 'settonce',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('sesto_imp_cast'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_imp_cast" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="sesto_imp_cast_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="line1tab2"></div>
        <div id="line2tab2"></div>
        <p id="tab3note">Impianti speciali per la tartuficoltura</p>
        <fieldset id="tab3container">
        <div id="cod_coltub_container">
            <label for="cod_coltub">Specie simbionte</label>
            <input type="hidden" id="cod_coltub" name="cod_coltub" value="<?php echo $b2->getData('cod_coltub');?>"/>
            <input id="cod_coltub_descr" name="cod_coltub_descr" value="<?php echo $b2->getRawData('cod_coltub_descriz');?>"/>
        </div>
        <div id="cod_coltua_container">
            <label for="cod_coltua">Specie forestale accessoria</label>
            <input type="hidden" id="cod_coltua" name="cod_coltua" value="<?php echo $b2->getData('cod_coltua');?>"/>
            <input id="cod_coltua_descr" name="cod_coltua_descr" value="<?php echo $b2->getRawData('cod_coltua_descriz');?>"/>
        </div>
        <div id="num_piante_container">
            <label for="num_piante">N° totale piante (n/ha)</label>
            <input id="num_piante" name="num_piante" value="<?php echo $b2->getData('num_piante');?>">
        </div>
        <div id="piant_tart_container">
            <label for="piant_tart">Piante tartufigene (n/ha)</label>
            <input id="piant_tart" name="piant_tart" value="<?php echo $b2->getData('piant_tart');?>">
        </div>
        </fieldset>
        <fieldset id="sesto_imp_tartcontainer" >
        <legend>Sesto d'impianto</legend>
        <div>
        <?php
        $labels=array(
          1=> 'quadrato',
          2=> 'rettangolo',
          3=> 'quinconce',
          4=> 'settonce',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('sesto_imp_tart'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="sesto_imp_tart" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="sesto_imp_tart_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <div id="line1tab3"></div>
        <div id="line2tab3"></div>
        <p id="tab4note">Sughereta</p>
        <fieldset id="tab4container">
        <div id="s_container">
        <label for="s">Struttura</label>
        <select id="s" name="s">
            <option value="">Scegli un valore di copertura</option>
            <?php
            foreach($b2->getControl('s')->getItems() as $item) : ?>
            <option <?php echo ($item->getData('codice') == $b2->getData('s') ? 'selected="selected"' : '')?> value="<?php echo $item->getData('codice'); ?>"><?php echo $item->getData('descriz'); ?></option>
            <?php endforeach;?>
                </select>
        </div>
        <div id="fito_bio_container">
            <label for="fito_bio">agenti biologici</label>
            <input type="checkbox" <?php echo ($b2->getData('fito_bio')==1 ? 'checked="checked"' : ''); ?> id="fito_bio" name="fito_bio"value ="1">
        </div>
        <div id="fito_bio_spec_container">
            <label for="fito_bio_spec">Specifiche</label>
            <input id="fito_bio_spec" name="fito_bio_spec"value ="<?php echo $b2->getData('fito_bio_spec') ; ?>">
        </div>
        <div id="fito_abio_container">
            <label for="fito_abio">agentio abioti</label>
            <input type="checkbox" <?php echo ($b2->getData('fito_abio')==1 ? 'checked="checked"' : ''); ?> id="fito_abio" name="fito_abio"value ="1">
        </div>
        <div id="fito_abio_spec_container">
            <label for="fito_abio_spec">Specifiche</label>
            <input id="fito_abio_spec" name="fito_abio_spec"value ="<?php echo $b2->getData('fito_abio_spec') ; ?>">
        </div>
        <div id="spe_nov_container">
            <label for="spe_nov">Specie prevalente rinnovazione</label>
            <?php 
            $rennovationspecie = $b2->getRennovationSpecie();
            $value = '';
            if ($b2->getData('spe_nov') != '')
                $value = $rennovationspecie->getData('nome_itali').' | '.$rennovationspecie->getData('nome_scien');
            ?>
            <input type="hidden" id="spe_nov" name="spe_nov" value="<?php echo $b2->getData('spe_nov');?>"/>
            <input id="spe_nov_descr" name="spe_nov_descr" value="<?php echo $value; ?>" data-old-value="<?php echo $value; ?>">
        </div>
        </fieldset>
        <fieldset id="arboree2container" >
        <legend>Composizione strato arboreo</legend>
        <div id="newarboree2">
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
                <input type="hidden" id="cod_coltu2" name="cod_coltu2" value=""/>
                <input id="cod_coltu2_descr" name="cod_coltu2_descr" value=""/>
            </span>
            <span>
                <input id="cod_coper2" name="cod_coper2" value=""/>
            </span>
            <span>
                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&action=editerbacee&id=<?php echo $b2->getData('objectid');?>" data-update="content_schedab2_arboree2">
                    <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie"/>
                </a>
            </span>
            </div>
        </div>
        <?php require (__DIR__.DIRECTORY_SEPARATOR.'schedab2'.DIRECTORY_SEPARATOR.'arboree2.php');?>
        </fieldset>
        <fieldset id="ocontainer" >
        <legend>Origine</legend>
        <div>
        <?php
        $labels=array(
          1=> 'dissemin.',
          2=> 'artificiale',
          3=> 'agamica o ceduo in conver.',
          4=> 'bosco di neoformazione',
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('o'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="o" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="o_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vig_sugcontainer" >
        <legend>Vigoria</legend>
        <div>
        <?php
        $labels=array(
          1=> 'poco vigoros',
          2=> 'mediamente',
          3=> 'molto vigoros'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('vig_sug'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="vig_sug" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="vig_sug_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="fito_sugcontainer" >
        <legend>Stato fitosanitario</legend>
        <div>
        <?php
        $labels=array(
          1=> 'precario',
          2=> 'medio',
          3=> 'buono'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('fito_sug'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="fito_sug" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="fito_sug_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="vcontainer" >
        <legend>Stato fitosanitario</legend>
        <div>
        <?php
        $labels=array(
          1=> 'assenti',
          2=> 'presenti'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('v'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="v" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="v_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="dcontainer" >
        <legend>Densità</legend>
        <div>
        <?php
        $labels=array(
          1=> 'scarsa',
          2=> 'adeguata',
          3=> 'eccessiva'  
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('d'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="d" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="d_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n1container" >
        <legend>Novellame</legend>
        <div>
        <?php
        $labels=array(
          1=> 'assente',
          2=> 'sporadico',
          3=> 'diffuso'  
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('n1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n1" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="n1_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n1arrow_right"></fieldset>
        <fieldset id="n2container" >
        <legend>Novellame</legend>
        <div>
        <?php
        $labels=array(
          1=> 'libero',
          2=> 'sotto copertura'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('n2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n2" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="n2_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n3container" >
        <legend>Rinnovazione</legend>
        <div>
        <?php
        $labels=array(
          1=> 'sufficiente',
          2=> 'insufficiente'
        );
        foreach($labels as $key=>$item) :
        $checked = '';
        if ($key == $b2->getData('n3'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="n3" <?php echo $checked; ?> value="<?php echo $key; ?>"><div class="n3_descr"><?php echo $item; ?></div>
        <?php endforeach;?>
        </div>
        </fieldset>
        <fieldset id="n3arrow_right"></fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formb2.js" defer></script>
</div>