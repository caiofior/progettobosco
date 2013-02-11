<?php
/**
 * Manages Region
 * 
 * Manages Region
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest;
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
 * Manages Region
 * 
 * Manages Region
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
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
    /**
     * Remaps region codice
     * @param variant $data
     * @param string|null $field
     */
   public function setData($data, $field = null) {
       if (is_array($data) && key_exists('regione_codice', $data))
               $data['codice']=$data['regione_codice'];
       parent::setData($data, $field);
   }
}
