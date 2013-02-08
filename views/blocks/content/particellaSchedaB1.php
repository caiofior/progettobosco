<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new forest\form\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
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
    </form>
</div>
<script type="text/javascript" src="js/formb1.js" defer></script>
</div>