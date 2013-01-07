<?php
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php'); 
$message = '';
if( isset($_POST['insert']) ) {
	$codice 	= $_POST['codice1'] ;
	$descrizion 	= $_POST['descrizion1'] ;
	$regione 	= $_POST['regione1'] ;
	
	list( $res , $id ) = inserisciBosco($codice, $regione, $descrizion ) ;
	
	if( $res ) 	$message =  "<b><i>inserimento avvenuto con successo</i></b>" ;
	else 		$message =  "<b><i>errore, probabilmente codice (PK) già inserito" ;

}

if( isset($_POST['delete']) ) {
	$codice 	= $_POST['codice'] ;
	
	list( $res , $id ) = cancellaBosco($codice) ;
	
	if( $res ) 	$message =  "<b><i>cancellazione avvenuta con successo ( codice $codice )</i></b>" ;
	else 		$message =  "<b><i>errore</i></b>" ;
}

if( isset($_POST['modify']) ) {
	$codice 	= $_POST['codice'] ;
	$descrizion 	= $_POST['descrizion'] ;
	$regione 	= $_POST['regione'] ;
	
	list( $res , $id ) = modificaBosco($codice, $regione, $descrizion) ;
	
	if( $res ) 	$message =  "<b><i>modifica avvenuta con successo ( codice $codice )</i></b>" ;
	else 		$message =  "<b><i>errore</i></b>" ;
}

$view = new Zend_View(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$view->message = $message;
$view->blocks = array(
      'HEADERS' => 'general'.DIRECTORY_SEPARATOR.'header.php',
      'CONTENT' => array(
          'general'.DIRECTORY_SEPARATOR.'menu.php',
          'content'.DIRECTORY_SEPARATOR.'bosco.php'
          )
    );
echo $view->render('main.php');