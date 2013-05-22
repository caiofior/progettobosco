<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$forest = $a->getForest();
$poligon = $a->getPoligon();
$centroid = $poligon->getCentroid();
var_dump($centroid->E());
var_dump($centroid->Long());
?>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/cartografia.css";
</script>
<div id="tabContent">
<div id="map-canvas"></div>
<script type="text/javascript" src="js/cartografia.js" defer="defer"></script>
</div>
</div>