<?php
$a = $this->a;
$forest = $a->getForest();
?><div id="tabContent">
    <form id="formA" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forma&action=manage&id=87">
        <fieldset>
        
        <label for="bosco">Bosco</label>
        <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>"><br />
        <label for="codiope">Rilevatore</label>
        <input type="hidden" id="codiope" name="codiope" value="<?php echo $a->getData('codiope');?>"/>
        <input type="text" id="codiope_descriz" name="codiope" value="<?php echo $a->getCollector()->getData('descriz');?>"/><br/>
        <label for="datasch">Data del rilievo</label>
        <input id="datasch" name="datasch" value="<?php echo $a->getData('datasch');?>">
        <h3>Fattori ambientali e di gestione</h3>
        <label for="cod_part">Particella / sottoparticella</label>
        <input id="cod_part" name="cod_part" value="<?php echo $a->getData('cod_part');?>"><br/>
        <label for="sup_tot">Superficie totale (ha)</label>
        <input id="sup_tot" name="sup_tot" value="<?php echo $a->getData('sup_tot');?>"><br/>
        <label for="boscata_calcolo">Superficie boscata (ha)</label>
        <input id="boscata_calcolo" name="boscata_calcolo" value="<?php echo $a->getRawData('boscata_calcolo');?>"><br/>
        <label for="improduttivi_calcolo">Improduttivi (ha)</label>
        <input readonly="readonly" id="improduttivi_calcolo" name="improduttivi_calcolo" value="<?php echo $a->getRawData('improduttivi_calcolo');?>"><br/>
        <label for="prod_non_bosc_calcolo">Produttivi non boscati (ha)</label>
        <input readonly="readonly" id="prod_non_bosc_calcolo" name="prod_non_bosc_calcolo" value="<?php echo $a->getRawData('prod_non_bosc_calcolo');?>"><br/>
        <label for="comune">Comune</label>
        <input type="hidden" id="comune" name="comune" value="<?php echo $a->getData('comune');?>">
        <input id="comune_descriz" name="comune_descriz" value="<?php echo $a->getMunicipality()->getData('descriz');?> (<?php echo $a->getMunicipality()->getRawData('province_code');?>)"><br/>
        <label for="ap">Altitudine prevalente (m)</label>
        <input id="ap" name="ap" value="<?php echo $a->getData('ap');?>"><br/>
        <label for="pp">Pendenza prevalente (%)</label>
        <input id="pp" name="pp" value="<?php echo $a->getData('pp');?>"><br/>
        
        </fieldset>
        <fieldset>
                
        <legend>Sottoparticella</legend>
        <label for="sup">Estesa su (%)</label>
        <input id="sup" name="sup" value="<?php echo $a->getData('sup');?>"><br/>
        <input type="radio" disabled="disabled" name="delimitata" <?php echo ($a->getData('delimitata') == 't' ? 'checked="checked"' : '')?> value="1">Delimitata<br/>
        <input type="radio" disabled="disabled" name="delimitata" <?php echo ($a->getData('delimitata') == 'f' ? 'checked="checked"' : '')?>value="0">Non delimitata<br/>
        
        </fieldset>
        <fieldset id="pf1container">
        <legend>Posizione fisiografica prevalente</legend>
        <?php
        $physiographicPositionColl = new forest\attribute\PhysiographicPositionColl();
        $physiographicPositionColl->loadAll();
        foreach($physiographicPositionColl->getItems() as $physiographicPosition) :
        $checked = '';
        if ($physiographicPosition->getRawData('codice') == $a->getData('pf1'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="pf1" <?php echo $checked; ?> value="<?php echo $physiographicPosition->getData('codice'); ?>"><?php echo $physiographicPosition->getData('descriz'); ?><br/>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="e1container">
        <legend>Esposizione prevalente</legend>
        <?php
        $aspectcoll = new \forest\attribute\AspectColl();
        $aspectcoll->loadAll();
        foreach($aspectcoll->getItems() as $aspect) :
        $checked = '';
        if ($aspect->getRawData('codice') == $a->getData('e1'))
            $checked = 'checked="checked"';
        ?>
        <div class="e1 <?php echo strtolower($aspect->getData('descriz')); ?>"><input type="radio" name="e1" <?php echo $checked; ?> value="<?php echo $aspect->getData('codice'); ?>" ><?php echo $aspect->getData('descriz'); ?></div>
        <?php endforeach;?>
        </fieldset>
        <fieldset id="acontainer">
        <legend>Dissesto</legend>
        <label>Erosione superficiale o incanalata</label><br/>
        <?php
        $surfaceerosioncoll = new \forest\attribute\SurfaceErosionColl();
        $surfaceerosioncoll->loadAll();
        foreach($surfaceerosioncoll->getItems() as $surfaceerosion) :
        $checked = '';
        if ($surfaceerosion->getRawData('codice') == $a->getRawData('a2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="a2" <?php echo $checked; ?> value="<?php echo $surfaceerosion->getRawData('codice'); ?>" ><?php echo $surfaceerosion->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="a3">Erosione profonda o calanchiva</label><br/>
        <?php
        $catastrophicerosioncoll = new \forest\attribute\CatastrophicErosionColl();
        $catastrophicerosioncoll->loadAll();
        foreach($catastrophicerosioncoll->getItems() as $catastrophicerosion) :
        $checked = '';
        if ($catastrophicerosion->getRawData('codice') == $a->getRawData('a3'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="a3" <?php echo $checked; ?> value="<?php echo $catastrophicerosion->getRawData('codice'); ?>" ><?php echo $catastrophicerosion->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="a4">Frane superficiali</label><br/>
        <?php
        $surfacelandslidecoll = new \forest\attribute\SurfaceLandslideColl();
        $surfacelandslidecoll->loadAll();
        foreach($surfacelandslidecoll->getItems() as $surfacelandslide) :
        $checked = '';
        if ($surfacelandslide->getRawData('codice') == $a->getRawData('a4'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="a4" <?php echo $checked; ?> value="<?php echo $surfacelandslide->getRawData('codice'); ?>" ><?php echo $surfacelandslide->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="a6">Rotolamento massi</label><br/>
        <?php
        $stonerollingcoll = new \forest\attribute\SurfaceLandslideColl();
        $stonerollingcoll->loadAll();
        foreach($stonerollingcoll->getItems() as $stonerolling) :
        $checked = '';
        if ($stonerolling->getRawData('codice') == $a->getRawData('a6'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="a6" <?php echo $checked; ?> value="<?php echo $stonerolling->getRawData('codice'); ?>" ><?php echo $stonerolling->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="a7">Altri fattori di dissesto</label><br/>
        <?php
        $otherinstabilitycoll = new \forest\attribute\OtherInstabilityColl();
        $otherinstabilitycoll->loadAll();
        foreach($otherinstabilitycoll->getItems() as $otherinstability) :
        $checked = '';
        if ($otherinstability->getRawData('codice') == $a->getRawData('a7'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="a7" <?php echo $checked; ?> value="<?php echo $otherinstability->getRawData('codice'); ?>" ><?php echo $otherinstability->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="a8">Specifica altri fattori</label>
        <input id="a8" name="a8" value="<?php echo $a->getData('a8');?>"><br/>
        </fieldset>
        <fieldset>
        <legend>Limiti allo sviluppo delle radici</legend>
        <label for="r2">Superficialità terreno</label><br/>
        <?php
        $superficialsoilcoll = new \forest\attribute\SuperficialSoilColl();
        $superficialsoilcoll->loadAll();
        foreach($superficialsoilcoll->getItems() as $superficialsoil) :
        $checked = '';
        if ($superficialsoil->getRawData('codice') == $a->getRawData('r2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="r2" <?php echo $checked; ?> value="<?php echo $superficialsoil->getRawData('codice'); ?>" ><?php echo $superficialsoil->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="r3">Rocciosità affiorante</label><br/>
        <?php
        $superficialrockcoll = new \forest\attribute\SuperficialRockColl();
        $superficialrockcoll->loadAll();
        foreach($superficialrockcoll->getItems() as $superficialrock) :
        $checked = '';
        if ($superficialrock->getRawData('codice') == $a->getRawData('r3'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="r3" <?php echo $checked; ?> value="<?php echo $superficialrock->getRawData('codice'); ?>" ><?php echo $superficialrock->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="r4">Pietrosità</label><br/>
        <?php
        $rockinesscoll = new \forest\attribute\RockinessColl();
        $rockinesscoll->loadAll();
        foreach($rockinesscoll->getItems() as $rockiness) :
        $checked = '';
        if ($rockiness->getRawData('codice') == $a->getRawData('r4'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="r4" <?php echo $checked; ?> value="<?php echo $rockiness->getRawData('codice'); ?>" ><?php echo $rockiness->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="r5">Ristagno idrico</label><br/>
        <?php
        $waterstasiscoll = new \forest\attribute\WaterStasisColl();
        $waterstasiscoll->loadAll();
        foreach($waterstasiscoll->getItems() as $waterstasis) :
        $checked = '';
        if ($waterstasis->getRawData('codice') == $a->getRawData('r5'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="r5" <?php echo $checked; ?> value="<?php echo $waterstasis->getRawData('codice'); ?>" ><?php echo $waterstasis->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>  
        <label for="r6">Altri fattori limitanti</label><br/>
        <?php
        $otherrootlimitingfactorcoll = new \forest\attribute\OtherRootLimitingFactorColl();
        $otherrootlimitingfactorcoll->loadAll();
        foreach($otherrootlimitingfactorcoll->getItems() as $otherrootlimitingfactor) :
        $checked = '';
        if ($otherrootlimitingfactor->getRawData('codice') == $a->getRawData('r6'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="r6" <?php echo $checked; ?> value="<?php echo $otherrootlimitingfactor->getRawData('codice'); ?>" ><?php echo $otherrootlimitingfactor->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>  
        <label for="r7">Specificare altre cause</label>
        <input id="r7" name="r7" value="<?php echo $a->getData('r7');?>"><br/>
        </fieldset>
        <fieldset>
        <legend>Fattori di alterazione fitosanitaria</legend>
        <label for="f2">Bestiame</label><br/>
        <?php
        $livestockcoll = new \forest\attribute\LivestockColl();
        $livestockcoll->loadAll();
        foreach($livestockcoll->getItems() as $livestock) :
        $checked = '';
        if ($livestock->getRawData('codice') == $a->getRawData('f2'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="f2" <?php echo $checked; ?> value="<?php echo $livestock->getRawData('codice'); ?>" ><?php echo $livestock->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>
        <label for="f3">Selvatici</label><br/>
        <?php
        $wildanimalcoll = new \forest\attribute\WildAnimalColl();
        $wildanimalcoll->loadAll();
        foreach($wildanimalcoll->getItems() as $wildanimal) :
        $checked = '';
        if ($wildanimal->getRawData('codice') == $a->getRawData('f3'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="f3" <?php echo $checked; ?> value="<?php echo $wildanimal->getRawData('codice'); ?>" ><?php echo $wildanimal->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>  
        <label for="f4">Patogeni o parassiti</label><br/>
        <?php
        $wildanimalcoll = new \forest\attribute\WildAnimalColl();
        $wildanimalcoll->loadAll();
        foreach($wildanimalcoll->getItems() as $wildanimal) :
        $checked = '';
        if ($wildanimal->getRawData('codice') == $a->getRawData('f4'))
            $checked = 'checked="checked"';
        ?>
        <input type="radio" name="f4" <?php echo $checked; ?> value="<?php echo $wildanimal->getRawData('codice'); ?>" ><?php echo $wildanimal->getRawData('descriz'); ?>
        <?php endforeach;?>
        <br/>  
        </fieldset>
    </form>
</div>
