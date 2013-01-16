<?php
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Logs user data
 */
/**
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 * Logs user data
 */
class Log extends Content {
    const CLEANUP_LOG =  " creation_datetime < NOW() - INTERVAL '1 month'";
    /**
     * Instantiates the table
     */
    public function __construct() {
        parent::__construct('log');
        $this->table->delete(self::CLEANUP_LOG);
    }
    /**
     * Loads profile from its id
     * @param int $id
     */
    public function loadFromId($id) {
        parent::loadFromId($id);
        if (is_null($this->data))
            throw new Exception('Unable to find the log',1301151428);
    }
    /**
     * Adds a new log entry
     */
    public function insert() {
        $this->data['creation_datetime']='NOW()';
        parent::insert();
    }

}

