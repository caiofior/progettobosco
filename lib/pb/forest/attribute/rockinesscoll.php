<?php
namespace forest\attribute;
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages Rockiness collection
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
 * Manages Rockiness collection
 */
class RockinessColl  extends \ContentColl implements template\AttributeColl {
    /**
     * Forest Reference
     * @var \forest\Forest 
     */
    protected $forest;
    /**
     *Static values
     * @var array
     */
    private static $values=array(
        array('codice'=>0,'descriz'=>'Assenti'),
        array('codice'=>1,'descriz'=>'&lt; 1/3'),
        array('codice'=>2,'descriz'=>'&lt; 2/3'),
        array('codice'=>3,'descriz'=>'&gt; 2/3'),
    );

    /**
     * Instantiates the table
     */
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new Rockiness ());
    }
    /**
     * Sets the forest reference
     * @param \forest\Forest $forest
     */
    public function setForest(\forest\Forest $forest) {
        $this->forest = $forest;
    }
    /**
     * Loads all the data
     */
    public function loadAll(array $criteria = null) {
        $this->items=array();
        foreach (self::$values as $value) {
            $item = clone $this->content;
            $item->setData($value);
            array_push($this->items, $item);
        }
    }
    /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
     * @return \Zend_Db_Select
     */
    protected function customSelect(\Zend_Db_Select $select,array $criteria ) {
        return $select;
    }
}
