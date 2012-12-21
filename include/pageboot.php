<?php
// include functions
        set_include_path(get_include_path().PATH_SEPARATOR.'/usr/share/php/libzend-framework-php');
        require('Zend'.DIRECTORY_SEPARATOR.'Loader.php');
        require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb'.DIRECTORY_SEPARATOR.'autoloader.php') ;
	require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'functions.php') ;
        require(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'pb_base'.DIRECTORY_SEPARATOR.'insert_update.php') ;

// connession pg
	  $dbname="progettobosco15-05-11"; //progettobosco28-09-10 dumpSboarina  pietrabbondante
	  $conn=pg_Connect( "host=localhost user=postgres password=postgres dbname=$dbname" ) or die("Impossibile collegarsi al server");
	  if(!$conn){die("Impossibile connettersi al database $dbname");}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it"> 
	<head> 
		<meta name="Author" content="Chiara Lora" />
		
		<meta http-equiv="Content-Language" content="it" /> 
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Progetto Bosco DEV</title>

		<link href="includes/css/common1.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="includes/images/favicon.ico" type="image/ico" />
		<script src="includes/js/mootools.core.js" type="text/javascript"></script>
		<script src="includes/js/default.js" type="text/javascript"></script>

	</head>

	<body class="body"> 
<?php
	$page = '' ;
	echo "<div id='header'>\n";
	echo "<div id='isafa'></div> <a href='?page=main'><div id='logo'></div></a> <div id='iss'></div>\n";
	echo "</div>\n";
	echo "<div id='line'></div>\n";
      if( isset($_REQUEST['page']) and $_REQUEST['page'] != 'main' ) {
	
		$menu = array() ;
		$menu['bosco'] = "Bosco" ;
		$menu['descrp'] = "Descrizione Particellare" ;
		$menu['daticat'] = "Dati Catastali";
		$menu['rildend'] = "Rilievi Dendrometrici";
		$menu['tavole'] = "Tavole Cubatura";
		$menu['viabilita'] = "Descrizioni Viabilità";
		$menu['1'] = "Descrizioni Particellari";
		$menu['2'] = "Classi Colturali";
		$menu['dizionari'] = "Dizionari";
		$menu['4'] = "Dati Catastali";
		$menu['5'] = "Strumenti";
		$menu['6'] = "Elaborazioni Dati Dendro";
		$menu['8'] = "Piano interventi";
		$menu['9'] = "Decodifica Schede";
		$menu['10'] = "Gestione Stampe";

		echo "<ul id='navigatio_bar'>" ;
		foreach( $menu as $tag => $text ) {
			$extra_class = ( $_REQUEST['page'] == $tag ) ? "nav_bar_selected" : "nav_bar" ;
			echo "<li><a class='$extra_class' href=\"?page=$tag\">$text</a></li>\n" ;
		}
		echo "</ul>" ;
      }


	// controllo page
	if( isset( $_REQUEST['page'] ) ) {
		switch( $_REQUEST['page'] ) {
			case 'main' : 		$page = 'main.php' ; 
			break ;
			case 'bosco' : 		$page = 'bosco.php' ;
						include('bosco_actions.php') ;	
			break ;
			case 'descrp' : 	$page = 'descrp.php' ;
 						if (isset( $_REQUEST['schedaA'] )  )  $page = 'descrp_schedeA.php';
 						if (isset( $_REQUEST['schedB1'] )  )  $page = 'descrp_schedeB1.php';
 						if (isset( $_REQUEST['schedB2'] )  )  $page = 'descrp_schedeB2.php';
 						if (isset( $_REQUEST['schedB3'] )  )  $page = 'descrp_schedeB3.php';
 						if (isset( $_REQUEST['schedB4'] )  )  $page = 'descrp_schedeB4.php';
 						break ;
			case 'daticat' : 	$page = 'daticat.php' ;
						//if (isset( $_GET['scheda'] ) )  $page = 'daticat1.php';
			break ;
			case 'rildend' : 	$page = 'rildend.php' ; 
			break ;
			case 'viabilita' : 	$page = 'viabilita.php' ; 
						if (isset( $_REQUEST['scheda'] ) )  $page = 'viabilita1.php';
			break ;
			case 'tavole' : 	$page = 'tavole.php' ; 
						if (isset( $_REQUEST['scheda'] ) )  $page = 'tavole1.php';
			break ;
			case 'dizionari' : 	$page = 'dizionari.php' ; 
						if (isset( $_REQUEST['scheda'] ) )  $page = 'dizionari1.php';	
			break ;
			default : 		$page = 'main.php' ;
		}
	} else {
			$page = 'main.php' ;
		}
	//caricamento delle pagine
	include($page) ;

	//aggiungo bottone finale per tornare al menù principale
	if( $page != 'main' and  $page != 'index.php'){
	echo "<div id='footer'>";
	echo "<a class='main_button' id='menu_princ' href='?page=main'>Menù principale</a>";
	echo "</div>\n";
	}
	  
	echo "<div class='table block1010'>";
	echo "<br /><pre>POST	      ";
	print_r($_POST);
	echo "tot_POST:".count($_POST);
	echo "</pre>";
	echo "<pre>GET        ";
	print_r($_GET);
	echo "</pre></div>";
?>
	</body>
</html>
<?php
	//chiusura connessione pg
 
//pg_close($conn)
?>