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
document.getElementById("tabrelatedcss").href="css/formb2.css";
</script>
    <div id="tabContent">
    <form id="formB2" action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?task=formb2&action=update&id=<?php echo $a->getData('objectid');?>">
        <div class="form_messages formb1_errors" style="display: none;"></div>
        <fieldset id="general">
            <input type="hidden" id="codice_bosco" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
            <input type="hidden" id="objectid" name="objectid" value="<?php echo $b1->getData('objectid');?>"/>
        <div id="regione_container">
            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
            Sistema informativo per l'assestamento forestale</p>     
        </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="js/formb2.js" defer></script>
</div>