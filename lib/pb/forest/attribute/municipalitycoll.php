<?php
namespace forest\attribute;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Municipality collection
 */
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
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 *
 * Manages Municipality collection
 */
class MunicipalityColl  extends \ContentColl implements template\AttributeColl {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Municipality());
    }
    /**
     * Sets the forest reference
     * @param \forest\Forest $forest
     */
    public function setForest(\forest\Forest $forest) {
        $this->forest = $forest;
    }
    /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        $select->setIntegrityCheck(false)
        ->from('comuni',array(
            '*',
            'province_code'=>new \Zend_Db_Expr('( SELECT sigla FROM province WHERE province.provincia=comuni.provincia)')
            ));
        if (key_exists('search', $criteria) && $criteria['search'] != '') {
            $select->where('descriz LIKE ? ','%'.$criteria['search'].'%');
        }
        $select->order('descriz');
        return $select;
    }
}