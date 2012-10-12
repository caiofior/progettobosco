<?

// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
//if( isset($_GET['delete']) ) {
//	$proprieta 	= $_GET['proprieta'] ;
//	$particella	= $_GET['particella'];
	
//	list( $res , $id ) = cancellaPartB_rif($proprieta, $particella) ;
//	list( $res1 , $id ) = cancellaPartB3($proprieta, $particella) ;
	
//	if( $res and $res1 ) 	{die('Tornare a Descrizione Particellare');}
//	else 		echo "errore" ;
//}

// ########################### comp_arb-6, rinnovaz-10, alberatura-14 #################################################
// cancellazione di una voce di arboree 
if( isset($_REQUEST['delete_comp_arbB3']) ) {
	$schede		= $_REQUEST['schedB3'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('comp_arb',$proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_comp_arbB3']) ;	

	if( !$res ) echo "errore" ;
}
if( isset($_REQUEST['delete_rinnovazB3']) ) {
	$schede		= $_REQUEST['schedB3'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('rinnovaz',$proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_rinnovazB3']) ;	

	if( !$res ) echo "errore" ;
}
if( isset($_REQUEST['delete_alberaturaB3']) ) {
	$schede		= $_REQUEST['schedB3'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arboree ('arb_colt', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_rinnovazB3']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### arbusti #################################################
// cancellazione di una voce di arbusti 
if( isset($_REQUEST['delete_arbuB3']) ) {
	$schede		= $_REQUEST['schedB3'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_arbu ('arbusti3', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_arbuB3']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### erbacee #################################################
// cancellazione di una voce di erbacee 
if( isset($_REQUEST['delete_erbaB3']) ) {
	$schede		= $_REQUEST['schedB3'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_erba ('erbacee3', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_erbaB3']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### infestanti #################################################
// cancellazione di una voce di infestanti 
if( isset($_REQUEST['delete_infeB3']) ) {
	$schede		= $_REQUEST['schedB3'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_coltu	= $_REQUEST['cod_coltu'];
	list( $res , $id ) = cancellaPart_erba ('infestan', $proprieta, $particella, $cod_coltu) ;

	unset($_REQUEST['delete_infeB3']) ;	

	if( !$res ) echo "errore" ;
}
// ###########################   #################################################
// ########################### note singole voci #################################################
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
if( isset($_REQUEST['delete_noteB3']) ) {
	$schede		= $_REQUEST['schedB3'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_nota	= $_REQUEST['cod_nota'];
	list( $res , $id ) = cancellaPart_note ($proprieta, $particella, $cod_nota, 'note_b3') ;

	unset($_REQUEST['delete_noteB3']) ;	

	if( !$res ) echo "errore" ;
	
}

?>


