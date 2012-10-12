<?php
  
if( isset($_POST['insert']) ) {
	$codice 	= $_POST['codice1'] ;
	$descrizion 	= $_POST['descrizion1'] ;
	$regione 	= $_POST['regione1'] ;
	
	list( $res , $id ) = inserisciBosco($codice, $regione, $descrizion ) ;
	
	if( $res ) 	echo "<b><i>inserimento avvenuto con successo</i></b>" ;
	else 		echo "<b><i>errore, probabilmente codice (PK) già inserito" ;

}

if( isset($_POST['delete']) ) {
	$codice 	= $_POST['codice'] ;
	
	list( $res , $id ) = cancellaBosco($codice) ;
	
	if( $res ) 	echo "<b><i>cancellazione avvenuta con successo ( codice $codice )</i></b>" ;
	else 		echo "<b><i>errore</i></b>" ;
}

if( isset($_POST['modify']) ) {
	$codice 	= $_POST['codice'] ;
	$descrizion 	= $_POST['descrizion'] ;
	$regione 	= $_POST['regione'] ;
	
	list( $res , $id ) = modificaBosco($codice, $regione, $descrizion) ;
	
	if( $res ) 	echo "<b><i>modifica avvenuta con successo ( codice $codice )</i></b>" ;
	else 		echo "<b><i>errore</i></b>" ;
}
?>