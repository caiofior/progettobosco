<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
?>

<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/descrizione.css";
</script>
<div id="tabContent">
<script type="text/javascript" src="js/descrizione.js" defer="defer"></script>
</div>
</div>