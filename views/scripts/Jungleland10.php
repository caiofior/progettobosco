<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>


<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Erwin Aligam - styleshout.com" />
<?php 
            if(
                    key_exists('HEADERS', $this->blocks) && 
                    is_string($this->blocks['HEADERS'])  && 
                    is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['HEADERS'])
                    ) require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['HEADERS']; 
                    else if (
                    key_exists('HEADERS', $this->blocks) && 
                    is_array($this->blocks['HEADERS'])
                    ) {
                        foreach($this->blocks['HEADERS'] as $content) {
                            if (is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content))
                                 require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content; 
                            }
                        }
?>
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->

</head>

<body>

<!-- wrap -->
<div id="wrap">

	<!-- header -->
	<div id="header">			
	
		<a name="top"></a>
		
		<h1 id="logo-text"><a href="<?php echo $GLOBALS['BASE_URL'];?>" title="">progettobosco</a></h1>		
		<p id="slogan">pianificazione forestale a portata di mouse ... </p>					
		

					
	<!-- /header -->					
	</div>
	
	<!-- content -->
	<div id="content-wrap" class="clear">
	
		<div id="content">		
			        <?php
        if (
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

        <?php
        if (
            key_exists('SIDEBAR', $this->blocks) && 
            is_string($this->blocks['SIDEBAR'])  && 
            is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['SIDEBAR'])
            ) require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['SIDEBAR']; 
        else if (
            key_exists('SIDEBAR', $this->blocks) && 
            is_array($this->blocks['SIDEBAR'])
            ) {
                foreach($this->blocks['SIDEBAR'] as $content) {
                    if (is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content))
                         require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content; 
                    }
                }
        ?>		
		
			
		<!-- /content -->	
		</div>				
	<!-- /content-wrap -->	
	</div>	
<!-- /wrap -->
</div>

	

        <?php
        if (
            key_exists('FOOTER', $this->blocks) && 
            is_string($this->blocks['FOOTER'])  && 
            is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['FOOTER'])
            ) require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$this->blocks['FOOTER']; 
        else if (
            key_exists('FOOTER', $this->blocks) && 
            is_array($this->blocks['FOOTER'])
            ) {
                foreach($this->blocks['FOOTER'] as $content) {
                    if (is_file(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content))
                         require __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'blocks'.DIRECTORY_SEPARATOR.$content; 
                    }
                }
        ?>		



</body>
</html>
