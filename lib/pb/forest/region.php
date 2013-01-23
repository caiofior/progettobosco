<?php
namespace forest;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Region
 */
if (!class_exists('Content')) {
    $file = array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Region
 */
class Region extends \Content {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('diz_regioni');
    }
    /**
     * Loads forest from its id
     * @param int $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        if (is_null($this->data))
            throw new \Exception('Unable to find the region',1301221541);
    }
    /*
    * Remaps user id value
    */
   public function setData($data, $field = null) {
       if (is_array($data) && key_exists('regione_codice', $data))
               $data['codice']=$data['regione_codice'];
       parent::setData($data, $field);
   }
}
