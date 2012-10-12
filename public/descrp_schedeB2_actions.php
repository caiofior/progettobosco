<?

// ########################### arboree #################################################
// cancellazione di una voce di arboree 
if( isset($_REQUEST['delete_arboreeB2']) ) {
	$schede		= $_REQUEST['schedB2'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('arboree2', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_arboreeB2']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### arbusti #################################################
// cancellazione di una voce di arbusti 
if( isset($_REQUEST['delete_arbuB2']) ) {
	$schede		= $_REQUEST['schedB2'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arbu ('arbusti2', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_arbuB2']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### erbacee #################################################
// cancellazione di una voce di erbacee 
if( isset($_REQUEST['delete_erbaB2']) ) {
	$schede		= $_REQUEST['schedB2'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_erba ('erbacee2', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_erbaB2']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### note singole voci #################################################
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
if( isset($_REQUEST['delete_noteB2']) ) {
	$schede		= $_REQUEST['schedB2'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_nota	= $_REQUEST['cod_nota'];
	list( $res , $id ) = cancellaPart_note ($proprieta, $particella, $cod_nota, 'note_b2') ;

	unset($_REQUEST['delete_noteB2']) ;	

	if( !$res ) echo "errore" ;
	
}

?>


