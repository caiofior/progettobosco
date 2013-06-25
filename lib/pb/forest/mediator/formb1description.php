<?php
/**
 * Manages Form B1 Description
 * 
 * Manages Form B1 Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
namespace forest\mediator;


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
 * Manages Form B1 Description
 * 
 * Manages Form B1 Description
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class FormB1Description extends \forest\mediator\Description {
    /**
     * Refrerence to B1 entity
     * @var \forest\entity\b\B1
     */
    protected $b1;
    /**
     * Generates description iterating through all private methods and ading notes
     * @return string
     */
    protected function generateDescription() {
        $this->b1 = $this->b->getB1Coll ()->getFirst();
        $reflection = new \ReflectionClass(__CLASS__);
        foreach ($reflection->getMethods(\ReflectionMethod::IS_PRIVATE) as $method) {
            if($method->class == __CLASS__) {
                $method->setAccessible(true);
                $method->invoke($this);
            }
        }
       
        $this->t['b1']['note'] = '';
        $note = $this->b1->getData('note');
        if ($note != '')
            $this->t['b1']['note'] = 'Note:'.$this->b1->getData('note');
        
        $this->t['b1'] = array_reduce($this->t['b1'], create_function('$s,$i', '
            if($i != "")
                $s .= $i.", ";
            return $s;
        '));
        $this->t['b1'] = ucfirst(preg_replace('/, $/', '.', $this->t['b1']));
        if ($this->t['b1'] != '')
            $this->t['b1'] = 'Descrizione fisionomico-colturale'.PHP_EOL.$this->t['b1'];
        
    }
    private function coverComposition () {
        $cod_coper = array(
            1=>'',
            2=>'',
            3=>'',
            4=>''
        );
        $covercomposition = $this->b1->getCoverCompositionColl();
        $covercomposition->loadAll();
        foreach($covercomposition->getItems() as $coveritem) {
            if (!key_exists($coveritem->getData('cod_coper'), $cod_coper)) {
                $this->addIssue('b1', 'spe_arbq','Percentuale specie arboree non inserita');
                continue;
            }
            if ($cod_coper[$coveritem->getData('cod_coper')] != '')
                $cod_coper[$coveritem->getData('cod_coper')] .= ', ';
            $cod_coper[$coveritem->getData('cod_coper')] .= $coveritem->getRawData('cod_colt_nome_per_trad');
        }
        $cod_coper = array_filter($cod_coper);
        if (sizeof($cod_coper) == 0) {
            $this->addIssue('b1', 'spe_arbq','Specie arboree non inserite');
            return;
        }
    }
}