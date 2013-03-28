<?php

namespace forest\form;
use forest\entity\AColl;

$PHPUNIT = true;
require (__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'include' . DIRECTORY_SEPARATOR . 'pageboot.php');
require ('PHPUnit/Autoload.php');
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-01-28 at 14:45:31.
 */
class ACollTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var AColl
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new AColl();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }
     /**
     * @covers AColl::loadAll
     */
    public function testLoadAll() {
        $forest = new \forest\Forest();
        $forest->loadFromCode('14003');
        $this->object->setForest($forest);
        $this->object->loadAll();
        $this->object->count();
        foreach($this->object->getItems() as $form_a) {
            var_dump($form_a->getRawData('usosuolo'));
        }
    }

}
