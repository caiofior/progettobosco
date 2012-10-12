<?
// ########################### arboree_a #################################################
// cancellazione di una voce di arboree 
if( isset($_REQUEST['delete_arboreeB4_a']) ) {
	$schede		= $_REQUEST['schedB4'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('arboree4a', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_arboreeB4_a']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### arboree_b #################################################
// cancellazione di una voce di arboree 
if( isset($_REQUEST['delete_arboreeB4_b']) ) {
	$schede		= $_REQUEST['schedB4'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('arboree4b', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_arboreeB4_b']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### erbacee #################################################
// cancellazione di una voce di erbacee 
if( isset($_REQUEST['delete_erbaB4']) ) {
	$schede		= $_REQUEST['schedB4'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_erba ('erbacee4', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_erbaB4']) ;	

	if( !$res ) echo "errore" ;
}
// ########################### note singole voci #################################################
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
if( isset($_REQUEST['delete_noteB4']) ) {
	$schede		= $_REQUEST['schedB4'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_nota	= $_REQUEST['cod_nota'];
	list( $res , $id ) = cancellaPart_note ($proprieta, $particella, $cod_nota, 'note_B4') ;

	unset($_REQUEST['delete_noteB4']) ;	

	if( !$res ) echo "errore" ;
	
}

?>


