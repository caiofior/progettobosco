<?
// controllo inserimento valori di codice e particella derivanti da descrp.php
if (isset($_REQUEST["particella"])){
	if ($_REQUEST["proprieta"] == '-1' or $_REQUEST["particella"] == '-1') {
		$proprieta= $_REQUEST["proprieta"];
		$particella= $_REQUEST["particella"];
		echo 'Attenzione! Errore inserimento ';
		die("bosco = $proprieta e particella = $particella. <br />Tornare in 'Descrizione Particellare'.");
	}
}
elseif ($_REQUEST["proprieta"] == '-1' ) {
	$proprieta= $_REQUEST["proprieta"];
	echo 'Attenzione! Errore inserimento ';
	die("bosco = $proprieta. <br />Tornare in 'Descrizione Particellare'.");
}

// ########################### arboree #################################################
// cancellazione di una voce di arboree 
if( isset($_REQUEST['delete_arboreeB1']) ) {
	$schede		= $_REQUEST['schedB1'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('arboree', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_arboreeB1']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### arbusti #################################################
// cancellazione di una voce di arbusti 
if( isset($_REQUEST['delete_arbuB1']) ) {
	$schede		= $_REQUEST['schedB1'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arbu ('arbusti', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_arbuB1']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### erbacee #################################################
// cancellazione di una voce di  erbacee
if( isset($_REQUEST['delete_erbaB1']) ) {
	$schede		= $_REQUEST['schedB1'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_erba ('erbacee', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_erbaB1']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### Per specie stima_b1 #################################################
// cancellazione di una voce di arboree 
if( isset($_REQUEST['delete_specieB1']) ) {
	$schede		= $_REQUEST['schedB1'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('stime_b1', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_specieB1']) ;	

	if( !$res ) echo "errore" ;
}
// ########################### note singole voci #################################################
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
if( isset($_REQUEST['delete_noteB1']) ) {
	$schede		= $_REQUEST['schedB1'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_nota	= $_REQUEST['cod_nota'];
	list( $res , $id ) = cancellaPart_note ($proprieta, $particella, $cod_nota, 'note_b') ;

	unset($_REQUEST['delete_noteB1']) ;	

	if( !$res ) echo "errore" ;
	
}

?>