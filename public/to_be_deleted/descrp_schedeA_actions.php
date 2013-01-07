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

?>