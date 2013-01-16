<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>


<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Erwin Aligam - styleshout.com" />
<?php $this->renderBlock('HEADERS'); ?>
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<!--[if IE 6]><link rel="stylesheet" type="text/css" href="css/ie6.css" media="screen" /><![endif]-->

</head>

<body>
<div id="ajaxloader" style="display: none;">
    <div>Caricamento in corso...<br/><img src="images/ajax-loader.gif"/></div>
</div>
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
		<?php $this->renderBlock('CONTENT'); ?>
                <?php $this->renderBlock('SIDEBAR'); ?>
			
		<!-- /content -->	
		</div>				
	<!-- /content-wrap -->	
	</div>	
<!-- /wrap -->
</div>
        <script type="text/javascript" src="js/general.js"></script>
        <?php $this->renderBlock('FOOTER'); ?>	

</body>
</html>
