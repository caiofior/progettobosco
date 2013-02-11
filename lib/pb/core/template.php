<?php
/**
 * Manages templates
 * 
 * Manages templates
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
/**
 * Manages templates
 * 
 * Manages templates
 * 
 * @author Claudio Fior <caiofior@gmail.com>
 * @copyright CRA
 */
class Template extends Zend_View {
    /**
     * Render a template block
     * @param string $block_name
     */
    public function renderBlock($block_name) {
        $script_path = $this->getScriptPaths();
        $script_path = array_shift($script_path);
        if(
            key_exists($block_name, $this->blocks) && 
            is_string($this->blocks[$block_name])  && 
            is_file($script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks[$block_name])
        ) 
            require $script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks[$block_name]; 
        else if (
                   key_exists($block_name, $this->blocks) && 
                   is_string($this->blocks[$block_name]) 
                )
                    trigger_error ('Enable to find block '.$script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks[$block_name]);
        else if (
            key_exists($block_name, $this->blocks) && 
            is_array($this->blocks[$block_name])
        )   {
            foreach($this->blocks[$block_name] as $content) {
                if (is_file($script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content))
                    require $script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content; 
                else 
                    trigger_error ('Enable to find block '.$script_path.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content);
                        }
            }
    }

}