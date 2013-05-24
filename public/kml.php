<?php 
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * KML page controller
 */
header('Content-type: application/vnd.google-earth.kml+xml');
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$poligon = new \forest\geo\Polygon($_REQUEST['table']);
$poligon->loadFromId($_REQUEST['id_av']);
echo '<?xml version="1.0" encoding="utf-8" ?>'.PHP_EOL; ?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Placemark id="<?php echo $poligon->getData('id_av');?>">
	<Style><LineStyle><color>ff0000ff</color></LineStyle><PolyStyle><fill>0</fill></PolyStyle></Style>
      <Polygon><outerBoundaryIs><LinearRing><coordinates><?php
foreach($poligon->getVertexColl() as $key=>$poligonitem) {
  if ($key!= 0) echo ' ';
  echo $poligonitem->getRawData('longitude').','.$poligonitem->getRawData('latitude');
}?></coordinates></LinearRing></outerBoundaryIs></Polygon>
</Placemark>
</kml>