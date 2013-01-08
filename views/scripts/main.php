<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it"> 
    <head>
        <meta name="Author" content="Chiara Lora" />
        <meta http-equiv="Content-Language" content="it" /> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="includes/css/common1.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="includes/images/favicon.ico" type="image/ico" />
        <script src="includes/js/mootools.core.js" type="text/javascript"></script>
        <script src="includes/js/default.js" type="text/javascript"></script>
        <?php if(is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['HEADERS'])) require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['HEADERS']; ?>
    </head>
    <body class="body">
        <div id='header'>
	<div id='isafa'></div> <a href='<?php echo $GLOBALS['BASE_URL'];?>'><div id='logo'></div></a> <div id='iss'></div>
	</div>
	<div id='line'></div>
        <?php if (
                key_exists('CONTENT', $this->blocks) && 
                is_string($this->blocks['CONTENT'])  && 
                is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['CONTENT'])
                ) require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['CONTENT']; 
        else if (
                key_exists('CONTENT', $this->blocks) && 
                is_array($this->blocks['CONTENT'])
                ) {
                    foreach($this->blocks['CONTENT'] as $content) {
                        if (is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content))
                         require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content; 
                    }
                }
        ?>
        
    </body>
</html>
