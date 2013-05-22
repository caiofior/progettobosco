<?php 
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * KML page controller
 */
//header('Content-type: application/vnd.google-earth.kml+xml');
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$poligon = new \forest\geo\Polygon($_REQUEST['table']);
$poligon->loadFromId($_REQUEST['id_av']);
echo '<?xml version="1.0" encoding="utf-8" ?>'.PHP_EOL; ?>
<kml xmlns="http://www.opengis.net/kml/2.2">
<Document><Folder><name>forest_compartment</name>
<Schema name="forest_compartment" id="forest_compartment">
    <SimpleField name="ID_AV" type="string"></SimpleField>
</Schema>
<Placemark>
	<Style><LineStyle><color>ff0000ff</color></LineStyle><PolyStyle><fill>0</fill></PolyStyle></Style>
	<ExtendedData><SchemaData schemaUrl="#forest_compartment">
		<SimpleData name="OBJECTID"><?php echo $_REQUEST['id_av']?></SimpleData>
	</SchemaData></ExtendedData>
      <Polygon><outerBoundaryIs><LinearRing><coordinates><?php
foreach($poligon->getVertexColl() as $key=>$poligonitem) {
  if ($key!= 0) echo ' ';
  echo $poligonitem->getRawData('latitude').','.$poligonitem->getRawData('longitude');
}?></coordinates></LinearRing></outerBoundaryIs></Polygon>
  </Placemark>
</kml>