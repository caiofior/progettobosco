<?php
if (isset($this))
    $a = $this->a;
else {
    $a = new \forest\entity\A();
    $a->loadFromId($_REQUEST['id']);
}
$poligon = $a->getPoligon();
$centroid = $poligon->getCentroid();
?>
<script type="text/javascript">
    var center = {
    lat : <?php echo $centroid->Lat();?>,
    long : <?php echo $centroid->Long();?>,
    id_av : "<?php echo $GLOBALS['BASE_URL'].'kml.php?table=geo_particellare&id_av='.$poligon->getData('id_av'); ?>"
    };
</script>
<div id="forestcompartmentmaincontent">
<script type="text/javascript" >
document.getElementById("tabrelatedcss").href="css/cartografia.css";
</script>
<div id="tabContent">
<div id="map-canvas"></div>
<script type="text/javascript" src="js/cartografia.js" defer="defer"></script>
</div>
</div>