<?php

function redirect( $url ) {
	if (!headers_sent()) {
		header('Location: '.$url);
		exit;
	} else {
		echo '<script type="text/javascript">';
		echo 'window.location.href="'.$url.'";';
		echo '</script>';
		echo '<noscript>';
		echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
		echo '</noscript>';
		exit;
	}
}

//----------------------------------------------------------------------------
// funzioni generiche per la lettura della tabella ARCHIVI------------------------------------------
//----------------------------------------------------------------------------

function getArchivi($archivio, $nomecampo) {
	$query=	"	SELECT intesta 
			FROM archivi AS a
			WHERE a.archivio = '$archivio' AND a.nomecampo = '$nomecampo' ";
	$res=pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res))  $arr = $row ;
	return $arr ;
}  

//----------------------------------------------------------------------------
// funzioni per la pagina bosco.php ------------------------------------------
//----------------------------------------------------------------------------
function getDescrizioneBoschi() {
	$query=	"	SELECT d.descriz, p.codice, p.descrizion 
			FROM diz_regioni AS d RIGHT JOIN propriet AS p
			ON p.regione = d.codice;";
	$res=pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res))  $arr[] = $row ;
	return $arr ;
}   

function getDiz_regioni() { 
	$query = "	SELECT codice,descriz FROM diz_regioni " ;
	$res=pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
//----------------------------------------------------------------------------
// funzioni per la pagina bosco_actions.php ----------------------------------
//----------------------------------------------------------------------------
function inserisciBosco($codice ,$regione , $descrizion ) {
//INSERT INTO "PROPRIET" ("CODICE", "DESCRIZION", "REGIONE", "OBJECTID") VALUES (E'14003', E'PIETRABBONDANTE', E'14', 4);
	$query = " 	INSERT INTO propriet ( codice , descrizion , regione )
			VALUES ( '$codice' , '$descrizion' , '$regione');" ;
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	return array(($res),$id) ;
}
function cancellaBosco($codice) {
	$query = " 	DELETE FROM propriet 
			WHERE codice = '$codice'" ;
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	return array(($res),null) ;
}

function modificaBosco($codice, $regione , $descrizion ) {
	$query = " 	UPDATE propriet 
			SET descrizion='$descrizion',regione='$regione' 
			WHERE codice = '$codice'" ;
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	return array(($res),null) ;
}
function getCodiciBoschiCodice( $codice  ) {

	$query = "	SELECT codice,descrizion,regione 
			FROM propriet WHERE codice='$codice'";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr = $row ;
	return $arr ;
}
//----------------------------------------------------------------------------  
// funzioni per la pagina descrp.php -----------------------------------------
//----------------------------------------------------------------------------
function getCodiciBoschi() {
	$query = "  SELECT codice, descrizion
		    FROM propriet" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getCodiciBoschiDiz_reg() {
	$query = "  SELECT p.codice, p.descrizion, d.descriz
		    FROM propriet AS p LEFT JOIN diz_regioni AS d
		    ON p.regione=d.codice" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getCodiciPart( $codice ) {
	$query = "	SELECT cod_part
			FROM partcomp 
			WHERE proprieta='$codice'" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getCodiciPart2( $codice ) {
	$query = "	SELECT a.proprieta, a.cod_part, a.toponimo, b.u, a.codiope,  u.descriz
			FROM schede_a AS a LEFT JOIN 
			    (schede_b AS b LEFT JOIN 
			     usosuolo AS u ON b.u = u.codice)
			    ON (a.proprieta = b.proprieta) AND (a.cod_part = b.cod_part) 
			WHERE (a.proprieta='$codice')
			ORDER BY a.proprieta, a.cod_part, a.toponimo" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getSchede_b ( $u ) {
	$schede_b = ( empty($u) ) ? 'scheda B vuoto':( ($u == '-1') ? 'scheda B cambiata!' : ( ($u == '1') ? 'B1' : (($u =='13') ? 'B4' : ( ($u =='2' or $u >= '10') ? 'B2' : 'B3') ) ) ) ;
	return $schede_b ;
}

//----------------------------------------------------------------------------
// Funzioni per la pagina descrp-schede.php ----------------------------------
//----------------------------------------------------------------------------

/////////////////////////////////////////////////////
// ATTENZIONEEEE!!: il campo 'cod_part' della tabella 'schede_a' contiene uno spazio dopo i numeri: es. cos_part='0002 '
// fare attenzione nelle query
/////////////////////////////////////////////////////

function  fctControlloSchedeB ($proprieta){
		echo "Attenzione! Possibilità creazione nuova scheda solo con 'Scheda A'" ;
		die("bosco = $proprieta. <br />Tornare in 'Descrizione Particellare', ed inserire la 'Scheda A'.");
}

function getDiz_regioniCod( $proprieta ) { 
	$query=		"SELECT d.codice, d.descriz 
			FROM diz_regioni AS d RIGHT JOIN propriet AS p
			ON p.regione = d.codice
			WHERE p.codice='$proprieta'";
	$res=pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr = $row ;
	return $arr ;
}

function getInfoPropriet( $proprieta ) {
	$query = "SELECT codice, descrizion 
		  FROM propriet
		  WHERE codice= '$proprieta'";
 	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr = $row ;
	return $arr ;
}
function getInfoComuni($proprieta) {
	    $query = "SELECT p.regione, c.codice, c.descriz
		          FROM comuni AS c, propriet AS p
		          WHERE c.regione = p.regione and p.codice='$proprieta'";
	     $res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	     $k=1;
	     while($row = pg_fetch_object($res)) {
	        $arr[$k] = $row ;
	        $k++;}
	    return $arr ;
	}
function getCod_descriz ($tavola){
$query = "	SELECT codice, descriz 
		FROM $tavola";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$k=1;
	while($row = pg_fetch_object($res)) {
		$arr[$k] = $row ;
		$k++;}
	return $arr ;
}

function getCod_descrizion ($tavola){
$query = "	SELECT codice, descrizion 
		FROM $tavola";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$k=1;
	while($row = pg_fetch_object($res)) {
		$arr[$k] = $row ;
		$k++;}
	return $arr ;
}

//-----------------------scheda descrp_schedeA.php-------------------------------
/*function generateArr_a(){
  // creazione dell'array $arr per la modifica e l'inserimento dei dati nella tabella schedaA
  $arr['datasch']=""; $arr['ap']=""; $arr['pp']=""; $arr['toponimo']=""; $arr['delimitata']=""; $arr['codiope']=""; $arr['comune']="";$arr['proprieta']="";
  $arr['e1']=""; $arr['pf1']="";
  $arr['a2']=""; $arr['a3']=""; $arr['a4']=""; $arr['a6']=""; $arr['a7']=""; $arr['a8']="";
  $arr['r2']=""; $arr['r3']=""; $arr['r4']=""; $arr['r5']=""; $arr['r6']=""; $arr['r7']="";
  $arr['f2']=""; $arr['f3']=""; $arr['f4']=""; $arr['f5']=""; $arr['f6']=""; $arr['f7']=""; $arr['f8']=""; $arr['f10']=""; 		$arr['f11']=""; $arr['f12']="";
  $arr['v3']=""; $arr['v1']=""; $arr['o']=""; 
  $arr['c1']=""; $arr['c2']=""; $arr['c3']=""; $arr['c4']=""; $arr['c5']=""; $arr['c6']="";
  $arr['p1']=""; $arr['p2']=""; $arr['p3']=""; $arr['p4']=""; $arr['p5']=""; $arr['p6']=""; $arr['p7']=""; $arr['p8']=""; $arr['p9']="";
  $arr['i1']=""; $arr['i2']=""; $arr['i3']=""; $arr['i4']=""; $arr['i5']=""; $arr['i6']=""; $arr['i7']=""; $arr['i8']=""; $arr['i21']=""; $arr['i22']="";
  $arr['m1']=""; $arr['m2']=""; $arr['m21']=""; $arr['m3']=""; $arr['m4']=""; $arr['m22']=""; $arr['m20']=""; $arr['m5']=""; $arr['m6']=""; $arr['m7']=""; $arr['m8']="";
  $arr['m9']=""; $arr['m10']=""; $arr['m12']=""; $arr['m13']=""; $arr['m15']=""; $arr['m14']=""; $arr['m23']=""; $arr['m16']=""; $arr['m17']=""; $arr['m18']=""; $arr['m19']=""; 
  $arr['note']="";
  $arr['sup']=""; $arr['sup_tot']="";  
  //gli ultimi tre campi di $arr non intervengono nelle funzioni di Modifica e Inserzione dati, ma solo per generare tutti i campi di $arr appena di fa una nuova particella
  $arr['bosc']="";  $arr['improd']="";  $arr['p_n_bosc']="";
return $arr;
}*/

function generateArr_a($proprieta) {
	$query = "SELECT p.regione, c.codice, c.descriz 
		  FROM comuni AS c, propriet AS p
		  WHERE c.regione = p.regione and p.codice='$proprieta'";
 	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$k=1;
	while($row = pg_fetch_object($res)) {
		$arr[$k] = $row ;
		$k++;}
	return $arr ;
}
function getInfoSchedaA( $proprieta , $particella ) {
	$query = "	SELECT 
			  ap,pp, comune, proprieta, delimitata,
			  codiope,datasch,sup_tot, sup,
			  toponimo, 
			  delimitata,  e1,  pf1,
			  a2,a3, a4,a5, a6, a7, a8,
			  r2, r3, r4, r5, r6, r7,
			  f2, f3, f4, f5, f6, f7, f8, f10, f11, f12,
			  v3, v1, o,
			  c1,c2, c3,c4,c5,c6,
			  p1,p2, p3, p4, p5, p6, p7, p8,  p9,
			  i1, i2, i3, i4, i5, i6, i7, i8, i21, i22,
			  m1, m2, m21, m3, m4, m22, m20, m5,m6,m7,m8,
			  m9, m10, m12, m13, m15, m14,m23, m16, m17, m18,m19,
			  note
			FROM schede_a 
			WHERE proprieta='$proprieta' AND cod_part = '$particella' ";
 	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = pg_fetch_object($res) ;

		$arr->improd = (!empty($arr->i1) and $arr->i1 != 0) ? $arr->i1 : ( (!empty($arr->i2) and $arr->i2 != 0) ? ($arr->sup_tot*$arr->i2/100) : 0);
		$arr->p_n_bosc = (!empty($arr->i21) and $arr->i21 != 0) ? $arr->i21 : ( (!empty($arr->i22) and $arr->i22 != 0) ? ($arr->sup_tot*$arr->i22 /100) : 0);
		$arr->bosc = $arr->sup_tot -(( $arr->improd)+ ($arr->p_n_bosc));
	return $arr ;
}

function getIntestazione ( $archivio , $campo ){
$query = "	SELECT intesta
		FROM archivi
		WHERE archivio = '$archivio' AND progetto_bosco = true AND nomecampo = '$campo'";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	while($row = pg_fetch_object($res)) $arr = $row ;
	return $arr ;
}


function getOstacoli (){
$query = "	SELECT codice, descriz 
		FROM ostacoli";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getPosfisio (){
$query = "	SELECT codice, descriz 
		FROM posfisio";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getEspo (){
$query = "	SELECT codice, descriz 
		FROM espo";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

// ########################## note A ############################################

function getInfoScheda_note( $proprieta , $particella, $note) {
$query = "	SELECT n.proprieta, n.cod_part, n.cod_nota, n.nota
		FROM $note AS n 
		WHERE proprieta='$proprieta' AND cod_part='$particella'";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
 	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getInfoSchedaNoteTutte($scheda) { // creo $note_tutte in descrp_schedeA.php
	$scheda = strtoupper($scheda);
	$query = "	SELECT nomecampo, intesta 
			FROM leg_note
			WHERE archivio='$scheda'";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getInfoSchedaNoteTutte_dif($scheda, $note) { // cerco tutte le note non ancora inserite nella tab NOTE_x
	$scheda = strtoupper($scheda);
	$query = "
SELECT l.nomecampo, l.intesta
FROM leg_note l
WHERE ( l.nomecampo NOT IN (SELECT n.cod_nota
FROM $note n LEFT JOIN leg_note l ON ( n.cod_nota = l.nomecampo) 
WHERE l.archivio='$scheda') AND l.archivio='$scheda' )";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

// +++++++++++++++++++++++++ catasto ++++++++++++++++++++++++++++++++++++++++++++

function getInfoSchedeCatasto( $proprieta , $particella ) {
$query = "	SELECT foglio, particella, sup_tot_cat, sup_tot, sup_bosc, sum_sup_non_bosc, porz_perc, note
			FROM catasto
			WHERE proprieta='$proprieta' AND cod_part='$particella'";
	$res = pg_query($query) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
 	 	
function getSumSchedeCatasto ( $proprieta , $particella ){
$query = "	SELECT sum(sup_tot) AS sum_sup_tot, sum(sup_bosc) AS sum_sup_bosc, sum(sum_sup_non_bosc) AS sum_sum_n_bosco
		FROM catasto
		WHERE proprieta='$proprieta' AND cod_part='$particella'
		GROUP BY (proprieta='$proprieta' AND cod_part='$particella')";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = pg_fetch_object($res) ;
	return $arr ;
}


//------------------------------------------------------
// usate: getInfoSchedaNote()

function esisteProprietaEParticella($scheda, $proprieta, $cod_part) {
	$query = "SELECT proprieta, cod_part
		  FROM $scheda
		  WHERE proprieta='$proprieta' and cod_part='$cod_part'";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = pg_fetch_object($res) ;
	return $arr ;
}

function getProprieta_scheda($scheda, $particella) {
$query = "	SELECT s.proprieta , p.descrizion
		FROM $scheda AS s LEFT JOIN propriet AS p
		ON s.proprieta = p.codice 
		WHERE s.cod_part = '$particella'";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = pg_fetch_object($res);
	return $arr ;
}

function getCod_descriz_struttura ($tavola, $s){
$query = "	SELECT s.codice, s.descriz 
		FROM $tavola AS s
		Where s.codice = '$s'";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	while($row = pg_fetch_object($res)) $arr = $row ;
	return $arr ;
}

function  getPresAss(){
$query = "	SELECT codice, valore 
		FROM pres_ass";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getCod_descriz_k ($tavola){
$query = "	SELECT codice, descriz 
			FROM $tavola";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getCod_descriz_regione ($tavola, $regione){
//  $arr=array();
$query = "	SELECT codice, descriz 
			FROM $tavola
			WHERE regione = '$regione'";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getCod_descriz_struttu ($tavola, $regione){
//  $arr=array();
$query = "	SELECT codice, descriz 
		FROM $tavola
		WHERE (regione = '$regione' or regione='00')";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getCod_nome ($tavola){
$query = "	SELECT cod_coltu, nome_itali 
		FROM $tavola";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

//----------------------------------------------------------------------------
// Funzioni per la pagina schede_b sched_b1 e sched_b2 ----------------------------------
//----------------------------------------------------------------------------


function getInfoArboree( $arboree, $codice , $particella, $cod_fo ) {
	$query = "SELECT a.cod_coltu, a.cod_coper, a.ordine_inser
		  FROM $arboree a 
		  WHERE a.proprieta='$codice' AND a.cod_part='$particella' AND a.cod_fo='$cod_fo'
		  ORDER BY a.ordine_inser";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getInfoArboree1( $arboree, $codice , $particella, $cod_fo ) {
	$query = "SELECT a.cod_coltu
		  FROM $arboree a 
		  WHERE a.proprieta='$codice' AND a.cod_part='$particella' AND a.cod_fo='$cod_fo'";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getInfoArbusti( $arbusti, $codice , $particella, $cod_fo ) {
	$query = "SELECT a.cod_coltu
		  FROM $arbusti AS a
		  WHERE a.proprieta='$codice' AND a.cod_part='$particella' AND a.cod_fo='$cod_fo'" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getInfoErbacee( $erbacee, $codice , $particella, $cod_fo ) {
	$query = "SELECT a.cod_coltu
		  FROM $erbacee AS a
		  WHERE a.proprieta='$codice' AND a.cod_part='$particella' AND a.cod_fo='$cod_fo'" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getInfoStime( $stime, $codice , $particella, $cod_fo ) {
	$query = "SELECT a.cod_coltu, a.cod_coper, a.massa_tot
		  FROM $stime a 
		  WHERE a.proprieta='$codice' AND a.cod_part='$particella' AND a.cod_fo='$cod_fo'";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function getInfoScheda( $proprieta , $particella , $scheda) {
	$query = "	SELECT  *
			FROM $scheda 
			WHERE proprieta='$proprieta' AND cod_part = '$particella' ";
 	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = pg_fetch_object($res) ;
	return $arr ;
}
// Generatore l'array delle colonne da information_schema di postgresql
function generate_Arr($scheda){
// sched_b2 ha 69 colonne!! OK -- SELECT count(*) FROM information_schema.columns WHERE table_name='sched_b2'; 
/*$arr['proprieta']=""; $arr['cod_part']="";*/
	$query = " SELECT column_name 
		    FROM information_schema.columns 
		    WHERE table_name='$scheda' ";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
  	$array = pg_fetch_all($res) ;
	$arr = array();
	foreach ($array as $key => $value){
		foreach( $value as $key2 => $value2)	$arr[$value2] = '';
	}
	$not_allowed = array('proprieta' => '', 'cod_part' => '', 'objectid' => '');
	$arr1 = array_diff_key($arr, $not_allowed);
	return $arr1;
}
// -----------###########--------------------
// Generatore l'array delle colonne dalla tabella  archivi
function generate_Arr_arch($scheda){
// OK -- SELECT count(*) FROM information_schema.columns WHERE table_name='sched_b2'; 
/*$arr['proprieta']=""; $arr['cod_part']="";*/
	$query = " SELECT nomecampo
		    FROM archivi
		    WHERE archivio='$scheda' and progetto_bosco='t' ";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
  	$array = pg_fetch_all($res) ;
	$arr = array();
	foreach ($array as $key => $value){
		foreach( $value as $key2 => $value2)	$arr[$value2] = '';
	}
	$not_allowed = array('proprieta' => '', 'cod_part' => '', 'objectid' => '');
	$arr1 = array_diff_key($arr, $not_allowed);
	return $arr1;
}
// -----------###########--------------------

function fill_Arr ($array, $proprieta,$particella, $cod_fo  ){
	// funzione usata per passare i valori alla matrice, partendo dai dati del form per poi fare le query
	foreach( array_keys($array) as $key ){
		if ($key=='cod_fo') {$array[$key] = $cod_fo;}
		elseif ($key=='id_av') {$array[$key] =trim($proprieta).trim($particella).trim($cod_fo)  ;}
		else {
			$val = (isset($_REQUEST[$key]))? $_REQUEST[$key] : null ;
			$array[$key] = $val ;
		}
	}
return $array;
}

function fill_Arr_dellB ($array, $proprieta,$particella, $cod_fo  ){
	// mi serve per riempire con campi vuoti la scheda_b quando si camcellano le sottoschede b1, b2, b3...
	foreach( array_keys($array) as $key ) {
		if ($key =='u') $val = '-1';
		else $val = (isset($_REQUEST[$key]))? $_REQUEST[$key] : null ;
		$array[$key] = $val ;
	}
	return $array;
}
function fill_Arr_dellCat ($array, $proprieta,$particella, $cod_fo  ){
	// mi serve per riempire con campi vuoti la tabella catasto quando si camcella la scheda a
	foreach( array_keys($array) as $key ) {
		$val = (isset($_REQUEST[$key]))? $_REQUEST[$key] : null ;
		$array[$key] = $val ;
	}
	return $array;
}
function parse_value (&$d, $key, $table = '') {
	switch ($key) {
// per sched_b2 ci sono 66 CASE.
// per sched_b1 ci sono 33 CASE. più 31 campi non usati
//cod_fo solo!!
		case "cod_fo":
			$d = (isset($d))	? "'$d'" 	: "' 1'";
		break;
// caratteri o ''		
		case "codiope"://schede_b1
		case "datasch":
		case "int3":
		case "a8": 	
		//case "p4":
		case "r7":
		case "f12":
		case "p8":
		case "p9":
		case "c6":
		case "i8":
		case "note":
		case "tipo_int_sug":
		case "tipo_prescr_sug":
		case "estraz_passata":
		case "estraz_futura":
		case "fito_bio_spec":
		case "fito_abio_spec":
		case "particella_cat": //catasto
		case "particella_cat_old": //catasto
		case "foglio": //catasto
		case "foglio_old": //catasto
		case "note": //catasto
			$d = (isset($d) and $d!='' )	? "'$d'" 	: "null";
		break;
// caratteri o '-1'
		case "cod_coltub":
		case "cod_coltua":
		case "fungo_ospi":
		case "int2":
		case "p2":
		case "p3":
		case "f":			
		case "s":			
		case "spe_nov":
		case "cod_coltup":
		case "cod_coltus":
			$d = (isset($d) and $d!='-1' )	? "'$d'" 	: "null" ;
		break;
// caratteri normali
		case "id_av":
		case "e1":
		case "pf1":
		case "a2":
		case "a3":
		case "a4":
		case "a5":
		case "a6":
		case "a7":
		case "r2":
		case "r3":
		case "r4":
		case "r5":
		case "r6":
		case "f2":
		case "f3":
		case "f4":
		case "f5":
		case "f6":
		case "f7":
		case "f8":
		case "f9":
		case "f10":
		case "f11":
		case "p7":
		case "u":
		case "l":/*sched_b1*/
		case "l1":
		case "e1":
		case "m":
		//var non usate sched_b1  "f2" "ce_mat": case "n_agam": case "senescenti": case "colt_cast":	 case "morta":  case "alberiterr": case "prep_terr":
		case "vig":
		case "v":
		case "p4":
		case "g1":	/*sched_b1*/
		case "tipo":/*sched_b2*/
		case "comp_spe":
		case "sesto_imp_arb":
		case "sesto_princ":
		case "vig_arb_princ":
		case "vig_arb_sec":
		case "qual_pri":
		case "colt_cast":
		case "vig_cast":
		case "sesto_imp_cast":
		case "sesto_imp_tart":
		case "o":
		case "vig_sug":
		case "v":
		case "d":
		case "n1":
		case "n2":
		case "n3":
		case "g":
		case "sr":
		case "se":
		case "sub_viab":
		case "fito_sug":
		case "t":	/*sched_b2*/
		    $d =(isset($d)) ?  "'$d'"	:  "null";
		break;
// booleani
		case "c1": // scheda_a
		case "c2": 
		case "c3": 
		case "c4": 
		case "c5":
		case "p1": 
		case "p2": 
		case "p3": 
		case "p4": 
		case "p5": 
		case "p6": 
		case "i3": 
		case "i4": 
		case "i5": 
		case "i6": 
		case "i7": 
		case "m1": 
		case "m2": 
		case "m3": 
		case "m4": 
		case "m5": 
		case "m6": 
		case "m7": 
		case "m8": 
		case "m9": 
		case "m10": 
		case "m12": 
		case "m13": 
		case "m14": 
		case "m15": 
		case "m16": 
		case "m17": 
		case "m18": 
		case "m21": 
		case "m22": 
		case "m20": 
		case "m23":
		case "fito_bio":// scheda_b1
		case "fito_abio":
			$d =(isset($d) and $d!='' ) ?  "true" 	: "false";
		break;
// numeri o null
		case "ap": 
		case "pp":
		case "pm": 
		case "v1": 
		case "v3": 
		case "i1": 
		case "i2": 
		case "i21": 
		case "i22": 
		case "anno_imp":
		case "anno_dest":
		case "dist":
		case "dist_princ":
		case "fall":
		case "num_piante":
		case "piant_tart":
		case "c1":
		case "ce":
		case "d1":
		case "d3":
		case "d5":
		case "d10":
		case "d11":
		case "d12":
		case "d13":			
		case "d14":
		case "d15":
		case "d16":	
		case "d21":
		case "d22":
		case "d23":
		case "d24":
		case "d25":
		case "d26":
		case "area_gis":			
		case "peri_gis":
		case "sup":
		case "sup_tot_cat":  
		case "sup_tot":  	
		case "sup_bosc": 
		case "sum_sup_non_bosc":  			
		case "porz_perc":  	
		case "ordine_inser": // arboree  arboree2  arboree4a arboree4b
		// case "cod_coper": // nelle arboree ma questo sta in insert_update.php -> saveInfoDescrp_arbo, perchè cambia a seconda della scheda	
		//var non usate sched_b1 'sup', 'q1', 'q2', 'n_mat', 'turni', 'c1', 'c2', 'sesto_imp_tra_file', 'sesto_imp_su_file', 'buche',  'chiarie',  'd2', 'd4', 'd6', 'd7', 'd8', 'd9', 'd14', 'd15', 'd16'
			$d =(isset($d) and $d!='' ) ?  $d	: "null";
		break;
		default: // usato per tutti quei campi al momento presenti nelle schede, ma mai utilizzati
			$d ="null";
	}
}

//----------------------------------------------------------------------------
// Funzioni per la pagina daticat.php ----------------------------------
//----------------------------------------------------------------------------

// usata la funzione getDiz_regioniCod, getCodiciBoschi


function getInfoCatasto( $codice , $particella) {
	$query = "	SELECT c.cod_part , c.foglio , c.particella , c.sup_tot , c.sup_bosc , c.note , c.porz_perc , p.descrizion
			FROM catasto AS c  
			WHERE c.proprieta = '$codice' AND c.cod_part='$particella '";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
//----------------------------------------------------------------------------
// Funzioni per la pagina rildend.php ----------------------------------
//----------------------------------------------------------------------------

// usata la funzione getCodiciBoschi, getCodiciPart

function getRilDend ( $codice , $particella) {
  echo "sono entrato";
	$query = "	SELECT d.descrizion AS diz_tiporil_descrizion
			FROM diz_tiporil AS d 
			LEFT JOIN schede_x AS s ON s.tipo_ril = d.codice
			WHERE s.proprieta= '$codice' AND s.cod_part='$particella'";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row;  
	return $arr ;
}

//----------------------------------------------------------------------------
// Funzioni per la pagina tavole.php ----------------------------------
//----------------------------------------------------------------------------

function getCodiciTavole() {
	$query = "  SELECT codice, descriz
		  FROM diz_tavole" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getInfoTavole($codice) {
	$query = "	SELECT codice,descriz,autore,funzione,
				tipo,forma,d_min,d_max,
				classe_d,h_min,h_max,classe_h,
				note, biomassa, assortimenti
			FROM diz_tavole 
			WHERE codice='$codice'";
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr = $row ;
	return $arr ;
}
function saveInfoTavole($dati) {
	
	$query = "	UPDATE diz_tavole
			SET 	descriz = '$dati->descriz',
				funzione = '$dati->funzione',
				autore = '$dati->autore',
				tipo = '$dati->tipo',
				forma = '$dati->forma',
				d_min = '$dati->d_min',
				d_max = '$dati->d_max',
				classe_d = '$dati->classe_d',
				classe_h = '$dati->classe_h',
				h_min = '$dati->h_min',
				h_max = '$dati->h_max',
				note = '$dati->note',
				biomassa = $dati->biomassa,
				assortimenti = $dati->assortimenti
			WHERE codice = '$dati->codice'
			RETURNING codice";
	echo $query ;
	$res = pg_query($query);
	
	if( pg_num_rows($res) == 0 ) {
		$query = "	INSERT INTO diz_tavole
				(codice,descriz,autore,funzione,tipo,forma,d_min,d_max,
				classe_d,classe_h,h_min,h_max,note, biomassa, assortimenti)
				VALUES
				('$dati->codice','$dati->descriz','$dati->autore','$dati->funzione','$dati->tipo','$dati->forma','$dati->d_min','$dati->d_max',
				'$dati->classe_d','$dati->classe_h','$dati->h_min','$dati->h_max','$dati->note',$dati->biomassa,$dati->assortimenti)";
		$res = pg_query($query);
	}
	return ($res) ;
}

//----------------------------------------------------------------------------
// Funzioni per la pagina viabilita.php ----------------------------------
//----------------------------------------------------------------------------

// usata la funzione getCodiciBoschi, getDiz_regioniCod, getCodiciBoschiCodice
function getCodiciStrade($codice) {
	$query = "  SELECT strada, nome_strada
		    FROM schede_e
		    WHERE proprieta='$codice'" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getInfoStrade($codice, $strada) {
	$query = "  SELECT nome_strada, da_valle, a_monte, lung_gis, data, codiope,
			   class_amm, class_prop, qual_att, qual_prop,
			   accesso, transitabi, manutenzione, urgenza, scarpate,
			   corsi_acqua, tombini, can_tras, can_lat, aib, piazzole,
			   imposti, reg_accesso, manufatti, altro, specifica, note
			   abstract, larg_min, larg_prev, raggio, fondo, pend_media, 
			   pend_max, contropend, q_piazzole
		    FROM schede_e
		    WHERE proprieta = '$codice' AND strada = '$strada'" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr = $row ;
	return $arr ;
}

// function getLabelInterventi(){
// 	$query = "  SELECT *
// 		    FROM int_via";
// 	$res = pg_query($query);
// 	$arr = array() ;
// 	while($row = pg_fetch_object($res)) $arr[] = $row ;
// 	return $arr ;
// }

//----------------------------------------------------------------------------
// Funzioni per la pagina dizionari.php ----------------------------------
//----------------------------------------------------------------------------

function getDizArbo()  { /*funzione usata tante volte!!*/
	$query = "  SELECT *
		    FROM diz_arbo" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getDizErba()  { /*funzione usata tante volte!!*/
	$query = "  SELECT *
		    FROM diz_erba" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}

function getDizFung()  { /*funzione usata tante volte!!*/
	$query = "  SELECT *
		    FROM diz_fung" ;
	$res = pg_query($query);
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr[] = $row ;
	return $arr ;
}
function array_to_object($array = array()) {
    if (!empty($array)) {
        $data = false;
        foreach ($array as $akey => $aval) {
            $data -> {$akey} = $aval;
        }
        return $data;
    }
    return false;
}
?>
