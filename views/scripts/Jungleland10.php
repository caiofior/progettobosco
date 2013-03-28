<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>


<meta charset="UTF-8">
<meta name="author" content="Claudio Fior" />
<?php $this->renderBlock('HEADERS'); ?>
<link rel="stylesheet" type="text/css" media="screen" href="css/screen.css" />
<link rel="stylesheet" type="text/css" media="screen" href="css/two_col.css" />
<link rel="stylesheet" type="text/css" media="screen" href="js/jquery-ui/css/smoothness/jquery-ui-1.10.0.custom.css"  />
<?php echo (isset($GLOBALS['DEBUG']) && $GLOBALS['DEBUG'] ? '<script type="text/javascript" >var DEBUG=true;</script>' : '') ;?>
</head>

<body>
<div id="ajaxloader" style="display: none;">
    <div>Caricamento in corso...<br/><img src="images/ajax-loader.gif" alt="Caricamento"/></div>
</div>
<!-- wrap -->
<div id="wrap">

	<!-- header -->
	<div id="header">			
	
		<a id="top"></a>
		
		<h1 id="logo-text"><a href="<?php echo $GLOBALS['BASE_URL'];?>" title=""><img src="images/progettobosco.png" alt="progettobosco" width="352" height="77"/></a></h1>		
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
        <script type="text/javascript" src="js/jquery-ui/js/jquery-1.9.0.js"></script>
        <script type="text/javascript" src="js/jquery-ui/js/jquery-ui-1.10.0.custom.min.js"></script>
        <script type="text/javascript" src="js/general.js"></script>
        <?php $this->renderBlock('FOOTER'); ?>	

</body>
</html>
