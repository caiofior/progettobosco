<?php
/**
 * Manages Arboreal collection
 * 
 * Manages Arboreal collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\attribute;
if (!class_exists('Content')) {
    $file = 'form'.DIRECTORY_SEPARATOR.array(basename(__FILE__));
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
 * Manages Arboreal collection
 * 
 * Manages Arboreal collection
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class ArborealColl  extends \ContentColl  {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Arboreal());
    }
     /**
     * Customizes the select statement
     * @param \Zend_Db_Select $select
     * @param array $criteria Filtering criteria
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from($this->content->getTable()->info('name'));
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where(' LOWER(nome_itali) LIKE LOWER(?) OR LOWER(nome_scien) LIKE LOWER(?) ', '%'.$criteria['search'].'%');   
        }
        $select->order('nome_itali')->order('nome_scien');
        return $select;
    }
}
