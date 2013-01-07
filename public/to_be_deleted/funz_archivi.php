<?
//creo una funzione che mi interroghi la tabella "archivi" e "nomi_arc" e mi generi da solo le variabili per costruire l'arrei contenenti tutti i valori delle schede e mi imposti anche le variabili da scrivere nel sql di Insert/update o Delete.

function generateArr_b2(){

// sched_b2 ha 69 colonne!! OK -- SELECT count(*) FROM information_schema.columns WHERE table_name='sched_b2'; 
/*$arr['proprieta']=""; $arr['cod_part']="";*/
$query = " SELECT column_name 
	  FROM information_schema.columns 
	  WHERE table_name='sched_b2' ";
$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
$arr = pg_fetch_object($res) ;
return $arr ;

}


?>