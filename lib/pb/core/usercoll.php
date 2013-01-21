<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages User account collection
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Manages User account collection
 */
class UserColl extends ContentColl {
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct(new User());
    }
    /**
     * Customizes the select statement
     * @param Zend_Db_Select $select
     * @return \Zend_Db_Select
     */
    protected function customSelect(Zend_Db_Select $select ) {
        $select->setIntegrityCheck(false); 
        $select->from('user', Zend_Db_Table_Select::SQL_WILDCARD);
        $select->join('profile','profile.id = '.$select->getAdapter()->quoteIdentifier('user').'.profile_id');
        return $select;
    }
}