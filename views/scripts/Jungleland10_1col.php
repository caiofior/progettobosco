<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>


<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />
<meta name="author" content="Erwin Aligam - styleshout.com" />
<?php $this->renderBlock('HEADERS'); ?>
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/one_col.css" />
<link rel="stylesheet" type="text/css" media="screen" href="js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css"  />
<?php echo (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG'] ? '<script type="text/javascript" >var DEBUG=true;</script>' : '') ;?>
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
		
		<h1 id="logo-text"><a href="<?php echo $GLOBALS['BASE_URL'];?>" title=""><img src="images/progettobosco.png" alt="progettobosco" width="352px" height="77px"/></a></h1>		
		<p id="slogan">pianificazione forestale a portata di mouse ... </p>					
		

					
	<!-- /header -->					
	</div>
	
	<!-- content -->
	<div id="content-wrap" class="clear">
	
		<div id="content">		
		<?php $this->renderBlock('CONTENT'); ?>
			
		<!-- /content -->	
		</div>				
	<!-- /content-wrap -->	
	</div>	
<!-- /wrap -->
</div> 
        <script type="text/javascript" src="js/jquery-ui/js/jquery-1.8.3.js"></script>
        <script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <?php $this->renderBlock('FOOTER'); ?>	

</body>
</html>
