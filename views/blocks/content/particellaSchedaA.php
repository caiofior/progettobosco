<?php
$a = $this->a;
$forest = $a->getForest();
?><script type="text/javascript" >
document.write("<link rel=\"stylesheet\" type=\"text/css\" media=\"screen\" href=\"css/form_a.css\" />");
</script>
    <div id="tabContent">
    <form id="formA" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forma&action=manage&id=<?php echo $forest->getData('codice');?>">
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
        <div id="bosco_container">
            <label for="bosco">Bosco</label>
            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
        </div>
        <div id="codiope_container">
            <label for="codiope">Rilevatore</label>
            <input type="hidden" id="codiope" name="codiope" value="<?php echo $a->getData('codiope');?>"/>
            <input type="text" id="codiope_descriz" name="codiope" value="<?php echo $a->getCollector()->getData('descriz');?>"/>
        </div>
        <div id="datasch_container">
            <label for="datasch">Data del rilievo</label>
            <input id="datasch" name="datasch" value="<?php echo $a->getData('datasch');?>">
        </div>
        <div id="note_1">
            <h3 >Fattori ambientali e di gestione</h3>
        </div>
        <div id="sup_tot_container">
            <label for="sup_tot">Superficie totale (ha)</label>
            <input id="sup_tot" name="sup_tot" value="<?php echo $a->getData('sup_tot');?>"><br/>
        </div>
        <div id="boscata_calcolo_container">
            <label for="boscata_calcolo">Superficie boscata (ha)</label>
            <input id="boscata_calcolo" name="boscata_calcolo" value="<?php echo $a->getRawData('boscata_calcolo');?>"><br/>
        </div>
        <div id="cod_part_container">
            <label for="cod_part">Particella / sottoparticella</label>
            <input id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>">
        </div>
        <div id="comune_container">
            <label for="comune" class="double">Comune</label>
            <input type="hidden" id="comune" name="comune" value="<?php echo $a->getData('comune');?>">
            <input data-old-descriz="<?php echo $a->getMunicipality()->getData('descriz');?> (<?php echo $a->getMunicipality()->getRawData('province_code');?>)" id="comune_descriz" name="comune_descriz" value="<?php echo $a->getMunicipality()->getData('descriz');?> (<?php echo $a->getMunicipality()->getRawData('province_code');?>)">
        </div>
        <div id="ap_container">
            <label for="ap">Altitudine prevalente (m)</label>
            <input id="ap" name="ap" value="<?php echo $a->getData('ap');?>">
        </div>
        <div id="improduttivi_calcolo_container">
            <label for="improduttivi_calcolo">Improduttivi (ha)</label>
            <input readonly="readonly" id="improduttivi_calcolo" name="improduttivi_calcolo" value="<?php echo $a->getRawData('improduttivi_calcolo');?>">
        </div>
        <div id="prod_non_bosc_calcolo_container">
            <label for="prod_non_bosc_calcolo">Produttivi non boscati (ha)</label>
            <input readonly="readonly" id="prod_non_bosc_calcolo" name="prod_non_bosc_calcolo" value="<?php echo $a->getRawData('prod_non_bosc_calcolo');?>">
        </div>
        <div id="toponimo_container">
            <label for="toponimo" class="double">Toponimo</label>
            <input id="toponimo" name="toponimo" value="<?php echo $a->getData('toponimo');?>">
        </div>
        <div id="pp_container">
            <label for="pp">Pendenza prevalente (%)</label>
            <input id="pp" name="pp" value="<?php echo $a->getData('pp');?>">
        </div>
        </fieldset>
        <fieldset id="sub_forest_parcel">
                
        <legend>Sottoparticella</legend>
        <div id ="sup_container">
        <label for="sup">Estesa su (%)</label>
        <input id="sup" name="sup" value="<?php echo $a->getData('sup');?>">
        </div>
        <input type="radio" disabled="disabled" name="delimitata" <?php echo ($a->getData('delimitata') == 't' ? 'checked="checked"' : '')?> value="1">Delimitata<br/>
        <input type="radio" disabled="disabled" name="delimitata" <?php echo ($a->getData('delimitata') == 'f' ? 'checked="checked"' : '')?>value="0">Non delimitata
        
        </fieldset>
        <fieldset id="pf1container" >
        <legend>Posizione fisiografica prevalente</legend>
        <?php
        foreach($a->getControl('pf1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $a->getData('pf1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="pf1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="pf1_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="acontainer" >
        <legend>Dissesto</legend>
        <table>
            <tr>
                <td></td>
                <td>Assenti</td>
                <td>Pericolo peggioramento</td>
                <td>&lt; 5%</td>
                <td>&lt; 1/3</td>
                <td>&gt; 1/3</td>
            </tr>
            <tr>
                <td><label for="a2">Erosione superficiale o incanalata</label></td>
                <?php
        foreach($a->getControl('a2')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('a2'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="a2" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            <tr>
                <td><label for="a3">Erosione profonda o calanchiva</label></td>
                <?php
        foreach($a->getControl('a3')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('a2'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="a3" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            <tr>
                <td><label for="a4">Frane superficiali</label></td>
                        <?php
        foreach($a->getControl('a4')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('a4'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="a4" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
                
            </tr>
            <tr>
                <td><label for="a6">Rotolamento massi</label></td>
                <?php
                foreach($a->getControl('a6')->getItems() as $item) :
                $checked = '';
                if ($item->getData('codice') == $a->getData('a6'))
                    $checked = 'checked="checked"';
                ?>
                <td><input type="radio" name="a6" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
                <?php endforeach;?>
            </tr>
            <tr>
                <td><label for="a7">Altri fattori di dissesto</label></td>
                <?php
                foreach($a->getControl('a7')->getItems() as $item) :
                $checked = '';
                if ($item->getData('codice') == $a->getData('a7'))
                    $checked = 'checked="checked"';
                ?>
                <td><input type="radio" name="a7" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
                <?php endforeach;?>
            </tr>
        </table>
        <div id ="a8_container">
        <label for="a8">Specifica altri fattori</label>
        <input id="a8" name="a8" value="<?php echo $a->getData('a8');?>">
        </div>
        </fieldset>
        <fieldset id="e1container" >
        <legend>Esposizione prevalente</legend>
        <?php
        foreach($a->getControl('e1')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $a->getData('e1'))
            $checked = 'checked="checked"';
        ?>
        <div class="e1 <?php echo strtolower($item->getData('descriz')); ?>"><input type="radio" name="e1" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>" ><?php echo $item->getData('descriz'); ?></div>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="rcontainer">
            <legend>Limiti allo sviluppo delle radici</legend>
            <table>
                <tr>
                    <td></td>
                <td>Assenti o limitati</td>
                <td>&lt; 1/3</td>
                <td>&lt; 2/3</td>
                <td>&gt; 2/3</td>
                </tr>
                <tr>
                    <td><label for="r2">Superficialità terreno</label></td>
                           <?php
        foreach($a->getControl('r2')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r2'))
            $checked = 'checked="checked"';
        ?>
            <td><input type="radio" name="r2" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
                </tr>
                <tr>
                    <td><label for="r3">Rocciosità affiorante</label></td>
                            <?php
        foreach($a->getControl('r3')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r3'))
            $checked = 'checked="checked"';
        ?>
            <td><input type="radio" name="r3" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
                </tr>
                <tr>
                    <td><label for="r4">Pietrosità</label></td>
                            <?php
        foreach($a->getControl('r4')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r4'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="r4" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
                </tr>
                <tr>
                    <td><label for="r5">Ristagno idrico</label></td>
                            <?php
        foreach($a->getControl('r5')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r5'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="r5" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
                </tr>
                <tr>
                    <td><label for="r6">Altri fattori limitanti</label></td>
                    <?php
        foreach($a->getControl('r6')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('r6'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="r6" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
                </tr>
            </table>
         <div id="r7_container">
         <label for="r7">Specificare altre cause</label>
        <input id="r7" name="r7" value="<?php echo $a->getData('r7');?>">
        </div>
        </fieldset>
        <fieldset id="fcontainer">
        <legend>Fattori di alterazione fitosanitaria</legend>
            <table>
            <tr>
                <td></td>
                <td>Assenti</td>
                <td>Pericolo peggioramento</td>
                <td>&lt; 5%</td>
                <td>&lt; 1/3</td>
                <td>&gt; 1/3</td>
            </tr>
            <tr>
                <td><label for="f2">Bestiame</label></td>
                <?php
        foreach($a->getControl('f2')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f2'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f2" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            <tr>
                <td><label for="f3">Selvatici</label></td>
                <?php
        foreach($a->getControl('f3')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f3'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f3" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            <tr>
            <td><label for="f4">Patogeni o parassiti</label></td>
            <?php
        foreach($a->getControl('f4')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f4'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f4" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
             <tr>
            <td><label for="f5">Agenti metereologici</label></td>
            <?php
        foreach($a->getControl('f5')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f5'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f5" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
             <tr>
            <td><label for="f6">Movimenti di neve</label></td>
            <?php
        foreach($a->getControl('f6')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f6'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f6" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
             <tr>
            <td><label for="f7">Incendio</label></td>
            <?php
        foreach($a->getControl('f7')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f7'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f7" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            <tr>
            <td><label for="f8">Utilizzazioni o esbosco</label></td>
            <?php
        foreach($a->getControl('f8')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f8'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f8" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            <tr>
            <td><label for="f10">Attività turistico ricreative</label></td>
            <?php
        foreach($a->getControl('f10')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f10'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f10" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            <tr>
            <td><label for="f11">Altre cause</label></td>
            <?php
        foreach($a->getControl('f11')->getItems() as $item) :
        $checked = '';
        if ($item->getData('codice') == $a->getData('f11'))
            $checked = 'checked="checked"';
        ?>
        <td><input type="radio" name="f11" <?php echo $checked; ?> value="<?php echo $item->getRawData('codice'); ?>" ></td>
        <?php endforeach;?>
            </tr>
            </table>
         <div id="f12_container">
         <label for="f12">Specificare altre cause</label>
        <input id="f12" name="f12" value="<?php echo $a->getData('f12');?>">
        </div>
        </fieldset>
        <fieldset id="vcontainer">
            <legend>Accessibilità</legend>    
        <div id="v1_container">
            <label for="v1">Insufficiente sul %</label>
            <input readonly="readonly" id="v1" name="v1" value="<?php echo $forest->getData('v1');?>">
        </div>
        <div id="v3_container">
            <label for="v3">Buona sul %</label>
            <input readonly="readonly" id="v3" name="v3" value="<?php echo $forest->getData('v3');?>">
        </div>

        </fieldset>
        <fieldset id="ocontainer" >
        <legend>Ostacoli agli interventi</legend>
        <?php
        foreach($a->getControl('o')->getItems() as $item) :
        $checked = '';
        if ($item->getRawData('codice') == $a->getData('o'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="o" <?php echo $checked; ?> value="<?php echo $item->getData('codice'); ?>"><span class="o_descr"><?php echo $item->getData('descriz'); ?></span>
        <?php endforeach;?>
        </fieldset>
    </form>
</div>
