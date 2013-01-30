<?php
$a = $this->a;
$forest = $a->getForest();
?><div id="tabContent">
    <form action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=forma&action=manage&id=87">
        <label for="bosco">Bosco</label>
        <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>"><br />
        <label for="codiope">Rilevatore</label>
        <select id="codiope" name="codiope">
            <option value="">Seleziona</option>
            <?php
            $collectorcoll = new forest\attribute\CollectorColl();
            $collectorcoll->loadAll();
            foreach($collectorcoll->getItems() as $collector) :
                $selected = '';
                if ($collector->getData('codice') == $a->getData('codiope'))
                    $selected = 'selected="selected"';
            ?>
            <option <?php echo $selected; ?> value ="<?php echo $collector->getData('codice'); ?>"><?php echo $collector->getData('descriz'); ?></option>
            <?php endforeach; ?>
        </select>
        <br/>
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
        <fieldset>
        <legend>Sottoparticella</legend>
        <div class="hideme">
        <label for="sup">Estesa su (%)</label>
        <input id="sup" name="sup" value="<?php echo $a->getData('sup');?>"><br/>
        <input type="radio" name="delimitata" <?php echo ($a->getData('delimitata') == 't' ? 'checked="checked"' : '')?> value="1">Delimitata<br/>
        <input type="radio" name="delimitata" <?php echo ($a->getData('delimitata') == 'f' ? 'checked="checked"' : '')?>value="0">Non delimitata<br/>
        </div>
        </fieldset>
        <fieldset>
        <legend>Posizione fisiografica prevalente</legend>
        <div class="hideme">
        <input type="radio" name="pf1" <?php echo ($a->getData('delimitata') == 't' ? 'checked="checked"' : '')?> value="1">Delimitata<br/>
        <input type="radio" name="pf1" <?php echo ($a->getData('delimitata') == 'f' ? 'checked="checked"' : '')?>value="0">Non delimitata<br/>
        </div>
        </fieldset>
    </form>
</div>