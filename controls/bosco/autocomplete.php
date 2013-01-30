<?php
$response=array();
switch ($_REQUEST['action']) {
    case 'municipality' :
        $municipalitycoll = new forest\attribute\MunicipalityColl();
        $municipalitycoll->loadAll(array(
            'start'=>0,
            'length'=>10,
            'search'=>$_REQUEST['term']
            ));

        foreach($municipalitycoll->getItems() as $municipality) {
            $data = array(
                'id'=>$municipality->getData('codice'),
                'value'=>$municipality->getData('descriz').' ('.$municipality->getRawData('province_code').')'
            );
            $response[]=$data;
        }
    break;
}
header('Content-type: application/json');
echo Zend_Json::encode($response);
exit;