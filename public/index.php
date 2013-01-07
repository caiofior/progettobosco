<?php
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php');
$view = new Zend_View(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$view->blocks = array(
      'HEADERS' => 'general'.DIRECTORY_SEPARATOR.'header.php',
      'CONTENT' => 'content'.DIRECTORY_SEPARATOR.'index.php'
    );
echo $view->render('main.php');
exit; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it"> 
	<head> 
	</head>

	<body class="body"> 
<?php
	$page = '' ;
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