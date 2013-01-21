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
    abstract protected function customSelect(Zend_Db_Select $select );
    /**
     * Load all contents
     * @param array $criteria
     */
    public function loadAll(array $criteria) {
        $profiler = $this->content->getTable()->getAdapter()->getProfiler();
        $profiler->setEnabled(true);
        $select = $this->customSelect($this->content->getTable()->select());
        $this->columns = null;
        if (key_exists('sColumns', $criteria))
            $this->columns=  explode(',', $criteria['sColumns']);
        if (key_exists('iSortingCols', $criteria) && is_array($this->columns)) {
            for ($c =0; $c < $criteria['iSortingCols'];$c++) {
                $sort = ' ASC';
                if (key_exists('iSortDir_'.$c, $criteria))
                    $sort = ' '.strtoupper($criteria['iSortDir_'.$c]);
                $select->order($this->columns[$criteria['iSortCol_'.$c]]);
            }
        }
        if (
                key_exists('iDisplayStart',$criteria ) ||
                key_exists('iDisplayLength',$criteria )
            )
        $select->limit($criteria['iDisplayLength'], $criteria['iDisplayStart']);
        $data = $this->content->getTable()->fetchAll(
                $select
                )->toArray();
        //var_dump($data);
        //var_dump($profiler->getLastQueryProfile()->getQuery());
        //die();
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
                'SELECT COUNT(*) AS count FROM "'.$this->content->getTable()->info('name').'";'
                ));
    }
    /**
     * Return the colum names
     */
    public function getColumns() {
        return $this->columns;
    }
}
