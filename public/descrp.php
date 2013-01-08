<?php 
require (__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'include'.DIRECTORY_SEPARATOR.'pageboot.php'); 

$view = new Zend_View(array(
    'basePath' => __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'views'

));
$message = '';
$content = 'content'.DIRECTORY_SEPARATOR.'descrp.php';
if (isset( $_REQUEST['schedaA'] )  ) {
    $content = 'content'.DIRECTORY_SEPARATOR.'descrp_schedeA.php';
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

// ########################### note singole voci #################################################
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
if( isset($_REQUEST['delete_noteA']) ) {
	$schede		= $_REQUEST['schedaA'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$cod_nota	= $_REQUEST['cod_nota'];
	list( $res , $id ) = cancellaPartA_note ($proprieta, $particella, $cod_nota) ;

	unset($_REQUEST['delete_noteA']) ;	

	if( !$res ) echo "errore" ;
	
}

// ############################# catasto ###############################################
// cancellazione delle informazioni catastali
if( isset($_REQUEST['delete_catasto']) ) {
	$schede		= $_REQUEST['schedaA'] ;
	$proprieta 	= $_REQUEST['proprieta'] ;
	$particella	= $_REQUEST['particella'];
	$foglio	= $_REQUEST['foglio'];
	$particella_cat	= $_REQUEST['particella_cat'];
	
	list( $res , $id ) = cancellaCatasto ($proprieta, $particella, $foglio, $particella_cat) ;

	unset($_REQUEST['delete_catasto']) ;	

	if( !$res ) echo "errore" ;
	
}
}
if (isset( $_REQUEST['schedB1'] )  )  {
    $content = 'content'.DIRECTORY_SEPARATOR.'descrp_schedeB1.php';
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
}
if (isset( $_REQUEST['schedB2'] )  )  {
    $content = 'content'.DIRECTORY_SEPARATOR.'descrp_schedeB2.php';
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
}
if (isset( $_REQUEST['schedB3'] )  )  {
    $content = 'content'.DIRECTORY_SEPARATOR.'descrp_schedeB3.php';
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
}
if (isset( $_REQUEST['schedB4'] )  )  {
    $content = 'content'.DIRECTORY_SEPARATOR.'descrp_schedeB4.php';
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
}
$view->message = $message;
$view->blocks = array(
      'HEADERS' => 'general'.DIRECTORY_SEPARATOR.'header.php',
      'CONTENT' => array(
          'general'.DIRECTORY_SEPARATOR.'menu.php',
          $content
          )
    );
echo $view->render('main.php');