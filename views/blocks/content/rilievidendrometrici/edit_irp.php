<?php
$g1coll = $x->getG1Coll();
$g1coll->loadAll();
if($g1coll->count() == 0)
    $g1 = $g1coll->addItem();
else
    $g1 = $g1coll->getFirst();
?>
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/irp.css";
</script>
<fieldset>
<div id="data_container">
    <label for="data">Data</label>
    <input readonly="readonly" id="data" name="data" value="<?php echo $x->getData('data');?>">
</div>
<p >Schede G per il rilievo dendrometrico (IRP) con<br/>applicazione delle TAVOLE DI POPOLAMENTO</p>
<div id="fatt_num_container">
    <label for="fatt_num">Fattore di numerazione</label>
    <input id="fatt_num" name="fatt_num" value="<?php echo $g1->getData('fatt_num');?>">
</div>
<div id="codiope_container">
    <label for="codiope">Rilevatore</label>
    <input type="hidden" id="codiope" name="codiope" value="<?php echo $g1->getData('codiope');?>"/>
    <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $g1->getCollector()->getData('descriz');?>"/>
</div>
<div id="d_ogni_container">
    <label for="d_ogni">È stato misurato un diametro ogni:</label>
    <input id="d_ogni" name="d_ogni" value="<?php echo $g1->getData('d_ogni');?>">
</div>
<fieldset id="ird_table_container" >
    <legend><span>Composizione strato arboreo - arbustiva</span></legend>
    <div id="new_ird">
            <div>
                <span>
                    <div>Specie</div>
                </span>
                <span>
                    <div>Diametro</div>
                </span>
                <span>
                    <div>Frequenza</div>
                </span>
                <span>
                    <div>Altezza</div>
                </span>
                <span>
                    <div>Increm</div>
                </span>
                <span>
                    <div>Frequenza prelievo</div>
                </span>
                <span>
                    <div>Forma</div>
                </span>
                <span>
                    <div>Azioni</div>
                </span>
            </div>
        <div>
        <span>
            <div>
            <input type="hidden" id="specie" name="specie" value=""/>
            <input id="specie_descr" name="specie_descr" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="diam" name="diam" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="frequenza" name="frequenza" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="h" name="h" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="i" name="i" value=""/>
            </div>
        </span>
        <span>
            <div>
            <input id="freq_prel" name="freq_prel" value=""/>
            </div>
        </span>
        <span>
            <div>
            <select id="poll_matr" name="poll_matr" value="">
                <option></option>
                <?php foreach( $g1->getD1Coll()->getFirst()->getControl('poll_matr')->getItems() as $poll) :?>
                <option value="<?php echo $poll->getData('codice'); ?>"><?php echo $poll->getData('descriz'); ?></option>
                <?php endforeach; ?>
            </select>
            </div>
        </span>
        <span>
            <div>
            <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formd&amp;action=editarbustive&amp;id=<?php echo $g1->getData('objectid');?>" data-update="content_rilievidendrometrici_ird">
                <img class="actions addnew" src="images/empty.png" title="Aggiungi una specie arbustiva"/>
            </a>
            </div>
        </span>
        </div>
    </div>
    <?php require (__DIR__.DIRECTORY_SEPARATOR.'listird.php');?>
</fieldset>
</fieldset>
<script type="text/javascript" src="js/ird.js" defer="defer"></script>