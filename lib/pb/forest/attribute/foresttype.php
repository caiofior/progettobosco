<?php
namespace forest\attribute;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Forest Type attribute
 */
if (!class_exists('Content')) {
    $file = 'attribute'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Forest Type attribute
 */
class ForestType extends \Content implements template\Attribute {
     /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('diz_tipi');
    }
    /**
     * Load data from codice
     * @param string $codice
     */
    public function loadFromCode($code) {
        if ($code == '')
            return;
        $where = $this->table->getAdapter()->quoteInto('codice = ?', $code);
        $data = $this->table->fetchRow($where);
        if (is_null($data))
            throw new \Exception('Unable to find the forest type',1302111237);
        $this->data = $data->toArray();
    }
}
