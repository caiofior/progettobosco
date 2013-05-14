<?php
$PHPUNIT = true;
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$dir = __DIR__.DIRECTORY_SEPARATOR;
if ($argc < 3) {
    echo 'KML path is required';
    exit;
} 
$placemark = array();
$field_name=null;
$poligoncoll = new \forest\geo\Polygon($argv[1]);

function startElement($parser, $name, $attrs) 
{
    if ($name == 'SIMPLEDATA' && $attrs['NAME'] =='ID_AV')
        $GLOBALS['field_name'] =$attrs['NAME'];
    else if ($name=='COORDINATES')
        $GLOBALS['field_name']='coordinates';
}

function endElement($parser, $name) 
{
    if ($name == 'PLACEMARK')
        $GLOBALS['poligoncoll'] = new \forest\geo\Polygon($GLOBALS['argv'][1]);
    $GLOBALS['field_name']=null;
}
function getElementText( $parser ,  $data ) {
    if ($GLOBALS['field_name']=='ID_AV') {
        $GLOBALS['poligoncoll']->setIdAv($data);
    }
    if ($GLOBALS['field_name']=='coordinates'){
        $coordinates = explode(' ', $data);
        foreach ($coordinates as $coordinate) {
            $coordinate = explode(',', $coordinate);
            if (sizeof($coordinate) <> 2) continue;
            $coordinate = array_combine(array('latitude','longitude'), $coordinate);
            $poly = $GLOBALS['poligoncoll']->appendItem();
            $poly->setData($coordinate);
        }
        $GLOBALS['poligoncoll']->emptyColl();
        $GLOBALS['poligoncoll']->insert();
    }
}
$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, 'startElement', 'endElement');
xml_set_character_data_handler ( $xml_parser, 'getElementText');

if (!($fp = fopen($argv[2], 'r'))) {
    die('could not open XML input');
}

while ($data = fread($fp, 4096)) {
    if (!xml_parse($xml_parser, $data, feof($fp))) {
        die(sprintf('XML error: %s at line %d',
                    xml_error_string(xml_get_error_code($xml_parser)),
                    xml_get_current_line_number($xml_parser)));
    }
}
xml_parser_free($xml_parser);