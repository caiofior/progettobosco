<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Content object collection
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Content object collection
 */
abstract class ContentColl {
    /**
     * Contet of the collection
     * @var Content
     */
    protected $content;
    /**
     * Array of items
     * @var array
     */
    protected $items=array();
    /**
     * Columns array
     * @var array
     */
    protected $columns=null;
     /**
     * Instantiates the collection
     */
    public function __construct(Content $content) {
        $this->content = $content;
    }
    /**
     * Customizes select statement
     * @param Zend_Db_Select $select Zend Db Select
     */
    abstract protected function customSelect(Zend_Db_Select $select,array $criteria );
    /**
     * Load all contents
     * @param array $criteria
     */
    public function loadAll(array $criteria=null) {
        if (is_null($criteria))
            $criteria = array();
        if (key_exists('iDisplayStart', $criteria))
                $criteria['start']=$criteria['iDisplayStart'];
        if (key_exists('iDisplayLength', $criteria))
                $criteria['length']=$criteria['iDisplayLength'];
        if (key_exists('sSearch', $criteria))
                $criteria['search']=$criteria['sSearch'];
        $select = $this->customSelect($this->content->getTable()->select(), $criteria);
        $this->columns = null;
        if (key_exists('sColumns', $criteria))
            $this->columns=  explode(',', $criteria['sColumns']);
        if (key_exists('iSortingCols', $criteria) && is_array($this->columns)) {
            for ($c =0; $c < $criteria['iSortingCols'];$c++) {
                $sort = ' ASC';
                if (key_exists('sSortDir_'.$c, $criteria))
                    $sort = ' '.strtoupper($criteria['sSortDir_'.$c]);
                $select->order($this->columns[$criteria['iSortCol_'.$c]].' '.$sort);
            }
        }
        if (
                key_exists('start',$criteria ) ||
                key_exists('length',$criteria )
            )
        $select->limit($criteria['length'], $criteria['start']);
        $data = $this->content->getTable()->fetchAll(
                $select
                )->toArray();
        $this->items=array();
        foreach($data as $dataitem) {
            $item = clone $this->content;
            $item->setData($dataitem);
            array_push($this->items, $item);
        }
    }
    /**
     * Returns the collection items
     * @return array
     */
    public function getItems() {
        return $this->items;
    }
     /**
     * Returns the collection items
     * @return array
     */
    public function count() {
        return sizeof($this->items);
    }
    /**
     * Returns all contents without any filter
     */
    public function countAll() {
        return intval($this->content->getTable()->getAdapter()->fetchOne(
                $this->content->getTable()->select()->from($this->content->getTable()->info('name'),'COUNT(*)')
                ));
    }
    /**
     * Return the colum names
     */
    public function getColumns() {
        return $this->columns;
    }
    /**
     * Add new item to the collection
     * @return \Content
     */
    public function addItem() {
        return  clone $this->content;
    }
    /**
     * Return the first item of the collection
     * @return \Content
     */
    public function getFirst() {
        $this->loadAll(array(
            'start'=>0,
            'length'=>1
        ));
        return $this->items[0];
    }
}
