<?php 
namespace forest\form\control;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form control forest compartment collection
 */
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
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Form control forest compartment collection
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
        $dbname = $this->content->getTable()->getAdapter()->getConfig();
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