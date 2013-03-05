<?php 
/**
 * Manages Form control forest compartment collection
 * 
 * Manages Form control forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\form\control;
if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
    $PHPUNIT=true;
    require (__DIR__.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'..'.
                DIRECTORY_SEPARATOR.'include'.
                DIRECTORY_SEPARATOR.'pageboot.php');
}
/**
 * Manages Form control forest compartment collection
 * 
 * Manages Form control forest compartment collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ItemColl extends \ContentColl {
    /**
     * Initalizes the table
     * @param string $tablename
     */
    public function __construct($tablename) {
        parent::__construct(new Item($tablename));
    }
    /**
     * Loads all data
     * @param array $criteria
     */
    public function loadAll(array $criteria = null) {
        $table =$this->content->getTable();
        if(is_null($table))
            throw new \Exception('Unable to find the attribite in this form',1303041646);
        $dbname = $table->getAdapter()->getConfig();
        $dbname = $dbname['dbname'];
        $items = $GLOBALS['CACHE']->load($dbname.'_'.$this->content->getTable()->info('name'));
        if (is_array($items))
            $this->items = $items;
        else {
            parent::loadAll();
            $GLOBALS['CACHE']->save($this->items,$dbname.'_'.$this->content->getTable()->info('name'));
        }
    }
    /**
     * Customizes the selct
     * @param \Zend_Db_Select $select
     * @param array $criteria
     * @return \Zend_Db_Select
     */
    public function customSelect(\Zend_Db_Select $select, array $criteria) {
        return $select;
    }
    
}