<?php
/**
 * @author Chiara Lora <chiara.lora@gmail.com>
 * @copyright CRA
 * Save and modufy functions
 */
//-- Schede_a ----------------------------------------------------

// ------------ formA2 --------------------------
function saveInfoDescrpA_note($dati, $proprieta, $particella) {
	$str_nota	=(isset($dati->nota) and  $dati->nota!='')		? "nota='".$dati->nota."'" 		: "nota=null";

	$query = "UPDATE note_a SET 
		 $str_nota, id_av='$dati->id_av'
		WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_nota='$dati->cod_nota'
		RETURNING cod_part";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;


    if( pg_num_rows($res) == 0 ) {
	$str_cod_nota	=(isset($dati->cod_nota) and  $dati->cod_nota!='')	? "'".$dati->cod_nota."'" 	: "''";
	$str_nota	=(isset($dati->nota) and  $dati->nota!='')		? "'".$dati->nota."'" 		: "null";

	$query1 = "	INSERT INTO note_a(proprieta, cod_part, cod_nota, nota, id_av) 
		VALUES ('$proprieta', '$particella', $str_cod_nota, $str_nota , '$dati->id_av')" ;
 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	

    }
	//if( pg_num_rows($res) == 0 )  {echo "<b><i>' Inserimento note A' avvenuto con successo.</i></b>";}
	//else echo "<b><i>'Modifica note A' avvenuta con successo.</i></b>";
	return ($res) ;
}


function cancellaPartA_note ($proprieta, $particella, $cod_nota){
	$query = " 	DELETE FROM note_a 
			WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_nota='$cod_nota'" ;
	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	//echo "<b><i>'Cancellazione note' di bosco ($proprieta) $particella avvenuta con successo.</i></b><br />";
	return array(($res),null) ;
}

// ------------ formA catasto = formA4-5 --------------------------

function saveInfoSchedeCatasto($cat, $proprieta, $particella, $scheda) {
	foreach( $cat  as $key => $d ){
		parse_value( $d , $key, $scheda); // ritorna la variabile 
	}	

	$str_sup_tot_cat=(isset($cat->sup_tot_cat) and $cat->sup_tot_cat!='') ?  "sup_tot_cat=".$cat->sup_tot_cat."" : "sup_tot_cat=null";
	$str_sup_tot=(isset($cat->sup_tot) and $cat->sup_tot!='') ?  "sup_tot=".$cat->sup_tot."" : "sup_tot=null";
	$str_sup_bosc=(isset($cat->sup_bosc) and $cat->sup_bosc!='') ?  "sup_bosc=".$cat->sup_bosc."" : "sup_bosc=null";
	$str_sum_sup_non_bosc=(isset($cat->sum_sup_non_bosc) and $cat->sum_sup_non_bosc!='') ?  "sum_sup_non_bosc=".$cat->sum_sup_non_bosc."" : "sum_sup_non_bosc=null";
	$str_porz_perc=(isset($cat->porz_perc) and $cat->porz_perc!='') ?  "porz_perc=".$cat->porz_perc."" : "porz_perc=null";
	
	
	$id_av= trim($proprieta).trim($particella)."1"  ;
	$query = "UPDATE catasto SET 
				particella='$cat->particella_cat', foglio='$cat->foglio', 
				-- sup_tot_cat=$cat->sup_tot_cat, sup_tot=$cat->sup_tot,
				-- sup_bosc=$cat->sup_bosc, sum_sup_non_bosc=$cat->sum_sup_non_bosc,
				-- porz_perc=$cat->porz_perc, 
				$str_sup_tot_cat, $str_sup_tot, $str_sup_bosc, $str_sum_sup_non_bosc,
				$str_porz_perc, note='$cat->note', id_av ='$id_av'
			  WHERE foglio='$cat->foglio_old' AND proprieta='$proprieta' 
				AND cod_part='$particella' AND particella='$cat->particella_cat_old'
			  RETURNING cod_part";
			  	echo $query;
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
    if( pg_num_rows($res) == 0 ) {
	// 	$dati->cod_coltu è PK
	$str_sup_tot_cat=(isset($cat->sup_tot_cat) and $cat->sup_tot_cat!='') ?  "".$cat->sup_tot_cat."" : "null";
	$str_sup_tot=(isset($cat->sup_tot) and $cat->sup_tot!='') ?  "".$cat->sup_tot."" : "null";
	$str_sup_bosc=(isset($cat->sup_bosc) and $cat->sup_bosc!='') ?  "".$cat->sup_bosc."" : "null";
	$str_sum_sup_non_bosc=(isset($cat->sum_sup_non_bosc) and $cat->sum_sup_non_bosc!='') ?  "".$cat->sum_sup_non_bosc."" : "null";
	$str_porz_perc=(isset($cat->porz_perc) and $cat->porz_perc!='') ?  $cat->porz_perc : "null";
	
		$query1 = "	INSERT INTO catasto (proprieta, cod_part, foglio, particella, 
					 sup_tot_cat, sup_tot, sup_bosc, porz_perc, note, id_av) 
				  	VALUES ('$proprieta', '$particella','$cat->foglio', '$cat->particella_cat',
				  	-- $cat->sup_tot_cat, $cat->sup_tot, $cat->sup_bosc, $cat->porz_perc,				  	
					$str_sup_tot_cat, $str_sup_tot, $str_sup_bosc, $str_sum_sup_non_bosc, $str_porz_perc,
				  	 '$cat->note', '$id_av' )" ;
	 		echo $query1;
	 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	
     }
	//if( pg_num_rows($res) == 0 )  {echo "<b><i>'Inserimento particella catastale avvenuto con successo.</i></b>";}
//	else echo "<b><i>'Modifica particella catastale avvenuta con successo.</i></b>";
	return ($res) ;
}
function cancellaCatasto ( $proprieta, $particella, $foglio, $particella_cat){
	$query = " 	DELETE FROM catasto 
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND foglio='$foglio' AND particella='$particella_cat'" ;
	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	//echo "<b><i>'Cancellazione della particella catastale $particella_cat avvenuta con successo.</i></b><br />";
	return array(($res),null) ;
}


///////////////////////////////////////////
//-- Schede_b ----------------------------------------------------
///////////////////////////////////////////
// Attenzione imposto valori costanti:
//cod_fo = ' 1' (non so bene perchè ma è costante)
//u = '1' -> impongo 1 perchè sempre scheda B1

// ###########    ###########
// nuove funzioni riassuntive: usate per ogni scheda per fare l'INSERT e l'UPDATE
// ###########    ###########

//---------sched_b, sched_b1, sched_b2, sched_b3, -------------------------
function saveInfoDescrp ($dati, $proprieta, $particella, $scheda){
	//  Sched_B2 contiene 69 record di cui: proprieta, cod_part, objectid.
	// qui facciamo le query con 66 + 2 (proprieta, cod_part) mentre non si considera  objectid (perchè è una variabile di arcgis)
	foreach( $dati as $key => $d ){
		parse_value( $dati[$key], $key, $scheda); // ritorna la variabile $dati
//		echo $key."=".$dati[$key].", ";
	}
	$query="UPDATE $scheda SET ";
	$sql = array();
	foreach( $dati as $key => $d )		$sql[] = " $key = $d " ;
	$query .= implode($sql,','); // collego le parti della query con la virgola
	$query .= " WHERE proprieta = '$proprieta' AND cod_part='$particella'
		  RETURNING cod_part" ;
	//echo $query;
 	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;


	if( pg_num_rows($res) == 0 ) {
	
		$query1 ="INSERT INTO $scheda ( proprieta, cod_part , ";
		foreach ($dati As $key => $d)		$sql1[] =  $key ;
		$query1 .= implode($sql1,' , '); // collego le parti della query con la virgola
		$query1 .= ") VALUES ( '$proprieta', '$particella' , ";
		foreach( $dati as $key => $d )		$sql2[] =  $d  ;
		$query1 .= implode($sql2,' , '); // collego le parti della query con la virgola
		$query1 .= ") ";
		//echo $query1;
	 	$res = pg_query($query1) or die( __FUNCTION__." $query1<br />".pg_last_error() );
	}

	//if( pg_num_rows($res) == 0 )  {echo "<b><i>'Inserimento dati' $scheda avvenuto con successo ($proprieta, $particella).</i></b>";}
	//else {echo "<b><i>'Modifica dati' $scheda avvenuta con successo($proprieta, $particella).</i></b>";}
	return ($res) ;
}

function cancellaPart($proprieta, $particella, $scheda) {
	$query = "DELETE FROM $scheda
		  WHERE proprieta='$proprieta' AND cod_part='$particella';" ;
	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	//echo "<b><i>'Cancellazione dati' bosco ($proprieta) $particella avvenuta con successo in $scheda.</i></b>";
	return array(($res),null) ;
}

//
// ------------formB1_2  formB2_2 e 3; DELL formB3_7; formB3_11; formB3_15; formB4_a_3; formB4_b_3 --------------------------
function saveInfoDescrp_arbo($arboree, $dati, $proprieta, $particella) {
	// $dati->cod_coltu è PK
	//echo $dati-> ordine_inser." ".$dati->cod_coper;

	if ($arboree=='arboree') $str_cod_coper=(isset($dati->cod_coper) and $dati->cod_coper!='-2' and $dati->cod_coper!='-1' ) ?  "cod_coper='".$dati->cod_coper."'" : "cod_coper=null";
	else  $str_cod_coper=(isset($dati->cod_coper) and $dati->cod_coper!='-2'  and $dati->cod_coper!='-1') ?  "cod_coper=$dati->cod_coper" : "cod_coper=null";
	$str_ordine_inser=(isset($dati->ordine_inser) and $dati->ordine_inser!='' ) ?  "ordine_inser=$dati->ordine_inser" : "ordine_inser=null";

	$query = "	UPDATE $arboree SET 
				$str_ordine_inser, $str_cod_coper, cod_coltu='$dati->cod_coltu', id_av='$dati->id_av'
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$dati->cod_coltu_old'
				RETURNING cod_part";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;

	if( pg_num_rows($res) == 0 ) {
	// $dati->cod_coltu è PK
		if ($arboree=='arboree') $str_cod_coper=(isset($dati->cod_coper) and $dati->cod_coper!='-2' and $dati->cod_coper!='-1' ) ?  "'".$dati->cod_coper."'" : "null";
		else  $str_cod_coper=(isset($dati->cod_coper) and $dati->cod_coper!='-2'  and $dati->cod_coper!='-1') ?  "$dati->cod_coper" : "null";
		$str_ordine_inser=(isset($dati->ordine_inser) and $dati->ordine_inser!='' ) ?  "$dati->ordine_inser" : "null";
		
		$query1 = "	INSERT INTO $arboree (proprieta, cod_part, cod_coltu, cod_coper, ordine_inser, id_av) 
				 	VALUES ('$proprieta', '$particella','$dati->cod_coltu' , $str_cod_coper, $str_ordine_inser , '$dati->id_av')" ;
	 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	
    }
	//if( pg_num_rows($res) == 0 )  {echo "<b><i>'Inserimento specie arborea' avvenuto con successo.</i></b>";echo $query1;}
	//else {echo "<b><i>'Modifica specie arborea' avvenuta con successo.</i></b>";echo $query;}
	return ($res) ;
}

function cancellaPart_arboree ($arboree, $proprieta, $particella, $cod_coltu){
	$query = " 	DELETE FROM $arboree 
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$cod_coltu'" ;
	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
//	echo "<b><i>'Cancellazione specie arborea' di bosco ($proprieta) $particella avvenuta con successo.</i></b><br />";
	return array(($res),null) ;
}
// ------------ formB3_6; formB3_10; formB3_14; formB3_15--------------------------
function saveInfoDescrp_arbo1($table, $dati, $proprieta, $particella) {
	// $dati->cod_coltu è PK
	$query = "	UPDATE $table SET 
				cod_coltu='$dati->cod_coltu', id_av='$dati->id_av'
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$dati->cod_coltu_old'
				RETURNING cod_part";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
    if( pg_num_rows($res) == 0 ) {
	// $dati->cod_coltu è PK
		$query1 = "	INSERT INTO $table (proprieta, cod_part, cod_coltu, id_av) 
				 	VALUES ('$proprieta', '$particella','$dati->cod_coltu', '$dati->id_av')" ;
	 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	
    }
	//if( pg_num_rows($res) == 0 )  {echo "<b><i>'Inserimento specie arborea' avvenuto con successo.</i></b>";echo $query1;echo " - ";echo $query;}
	//else {echo "<b><i>'Modifica specie arborea' avvenuta con successo.</i></b>";echo $query;}
	return ($res) ;
}
// ------------ formB1_4 e 5; formB2_4; formB3_2 e 3--------------------------

function saveInfoDescrp_arbu($arbusti, $dati, $proprieta, $particella) {
	$query = "	UPDATE $arbusti SET 
		 		cod_coltu='$dati->cod_coltu', id_av='$dati->id_av'
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$dati->cod_coltu_old'
				RETURNING cod_part";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
    if( pg_num_rows($res) == 0 ) {
	// 	$dati->cod_coltu è PK
		$query1 = "	INSERT INTO $arbusti (proprieta, cod_part, cod_coltu, id_av) 
				  	VALUES ('$proprieta', '$particella','$dati->cod_coltu', '$dati->id_av')" ;
	 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	
     }
	//if( pg_num_rows($res) == 0 )  {"<b><i>'Inserimento specie arbustiva' avvenuto con successo.</i></b>";}
	//else "<b><i>'Modifica specie arbustiva' avvenuta con successo.</i></b>";
	return ($res) ;
}

function cancellaPart_arbu ($arbusti, $proprieta, $particella, $cod_coltu){
	$query = " 	DELETE FROM $arbusti 
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$cod_coltu'" ;
	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	//echo "<b><i>'Cancellazione specie arbustiva di bosco ($proprieta) $particella avvenuta con successo.</i></b><br />";
	return array(($res),null) ;
}

// ------------ formB1_6 e 7;  formB2_6 e 7;  formB3_4 e 5;  formB4_6 e 7--------------------------
function saveInfoDescrp_erba($erbacee, $dati, $proprieta, $particella) {
	// $dati->cod_coltu è PK
	$query = "	UPDATE $erbacee SET 
		 		cod_coltu='$dati->cod_coltu', id_av='$dati->id_av'
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$dati->cod_coltu_old'
				RETURNING cod_part";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
    if( pg_num_rows($res) == 0 ) {
	// 	$dati->cod_coltu è PK
		$query1 = "	INSERT INTO $erbacee (proprieta, cod_part, cod_coltu, id_av) 
				  	VALUES ('$proprieta', '$particella','$dati->cod_coltu', '$dati->id_av')" ;
	 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	
     }
	//if( pg_num_rows($res) == 0 )  {echo "<b><i>'Inserimento specie erbacea' avvenuto con successo.</i></b>";}
	//else echo "<b><i>'Modifica specie erbacea' avvenuta con successo.</i></b>";
	return ($res) ;
	
}
function cancellaPart_erba ($erbacee, $proprieta, $particella, $cod_coltu){
	$query = " 	DELETE FROM $erbacee 
			WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$cod_coltu'" ;
	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	//echo "<b><i>'Cancellazione specie erbacea di bosco ($proprieta) $particella avvenuta con successo.</i></b><br />";
	return array(($res),null) ;
}
// ---------------------- formB1_10 e 11;
function saveInfoDescrp_stime($stime, $dati, $proprieta, $particella) {
			// funzione usata per passare i valori alla matrice, partendo dai dati del form per poi fare le query
	$str_cod_coper=(isset($dati->cod_coper) and $dati->cod_coper!='-2' and $dati->cod_coper!='-1' ) ?  "cod_coper='".$dati->cod_coper."'" : "cod_coper=null";
	$str_massa_tot=(isset($dati->massa_tot) and $dati->massa_tot!='' ) ?  "massa_tot=$dati->massa_tot" : "massa_tot=null";
	
	$query = "	UPDATE $stime SET 
				$str_massa_tot, $str_cod_coper, cod_coltu='$dati->cod_coltu', id_av='$dati->id_av'
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_coltu='$dati->cod_coltu_old'
				RETURNING cod_part";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	if( pg_num_rows($res) == 0 ) {
		$str_cod_coper=(isset($dati->cod_coper) and $dati->cod_coper!='-2' and $dati->cod_coper!='-1' ) ?  "'".$dati->cod_coper."'" : "null";
		$str_massa_tot=(isset($dati->massa_tot) and $dati->massa_tot!='' ) ?  "$dati->massa_tot" : "null";
		$query1 = "	INSERT INTO $stime (proprieta, cod_part, cod_coltu, cod_coper, massa_tot, id_av) 
				 	VALUES ('$proprieta', '$particella','$dati->cod_coltu' , $str_cod_coper, $str_massa_tot, '$dati->id_av' )" ;
	 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	
    }
	//if( pg_num_rows($res) == 0 )  {echo "<b><i>'Inserimento specie arborea' avvenuto con successo.</i></b>";echo $query1;}
	//else {echo "<b><i>'Modifica specie arborea' avvenuta con successo.</i></b>";echo $query;}
	return ($res) ;
}
// ########### NOTE ALLE SINGOLE VOCI formB1_8, formB1_9, formb2_8 , formb2_9, formb3_8, formb3_9,, formb4_8, formb4_9    ###########
function saveInfoDescrp_note($dati, $proprieta, $particella, $scheda) {
	$str_nota	=(isset($dati->nota) or  $dati->nota!='')		? "nota='".$dati->nota."'" 		: "nota=null";
	$str_cod_nota =(isset($dati->cod_nota) or  $dati->cod_nota!='')		? "cod_nota='".$dati->cod_nota."'" 		: "cod_nota=null";
	$query = "	UPDATE $scheda SET 
		 		$str_nota , $str_cod_nota
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_nota='$dati->cod_nota_old'
				RETURNING cod_part";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;

    if( pg_num_rows($res) == 0 ) {
		$str_cod_nota	=(isset($dati->cod_nota) or  $dati->cod_nota!='')	? "'".$dati->cod_nota."'" 	: "''";
		$str_nota	=(isset($dati->nota) or  $dati->nota!='')		? "'".$dati->nota."'" 		: "null";
	
		$query1 = "	INSERT INTO $scheda (proprieta, cod_part, cod_nota, nota) 
					VALUES ('$proprieta', '$particella', $str_cod_nota, $str_nota )" ;
	 	$res = pg_query($query1) or die( __FUNCTION__."$query1<br />".pg_last_error() );	
    }
	//if( pg_num_rows($res) == 0 )  {echo "<b><i>Inserimento note avvenuto con successo.</i></b>";}
	//else echo "<b><i>Modifica note avvenuta con successo.</i></b>";
	return ($res) ;
}

function cancellaPart_note ($proprieta, $particella, $cod_nota, $scheda){
	$query = " 	DELETE FROM  $scheda
				WHERE proprieta='$proprieta' AND cod_part='$particella' AND cod_nota='$cod_nota'" ;
	$res = pg_query($query) or die( __FUNCTION__." $query<br />".pg_last_error() ) ;
	$id = pg_last_oid($res);
	//echo "<b><i>'Cancellazione note' di bosco ($proprieta) $particella avvenuta con successo.</i></b><br />";
	return array(($res),null) ;
}
