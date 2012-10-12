<?php  
if( isset($_GET['scheda']) ) 	{

$tavola = $_GET['tavola'];
$elenco = null ;

$arr['codice'] = "" ;
$arr['descriz'] = "" ;
$arr['autore'] = "" ;
$arr['note'] = "" ;
$arr['tipo'] = "" ;
$arr['forma'] = "" ;
$arr['biomassa'] = "" ;
$arr['assortimenti'] = "" ;
$arr['d_min'] = "" ;
$arr['d_max'] = "" ;
$arr['h_min'] = "" ;
$arr['h_max'] = "" ;
$arr['classe_d'] = "" ;
$arr['classe_h'] = "" ;
$arr['funzione'] = "" ;
if( isset($_POST['inserisci_dati']) or isset($_POST['modifica_dati'])) {
	
	foreach( array_keys($arr) as $key ) {
		if( $key == 'biomassa' or $key == 'assortimenti' ) 	$val = (isset($_POST[$key]))? 'true' : 'false';
		else 							$val = $_POST[$key] ;
		$arr[$key] = $val ;
	}
	$elenco = array_to_object($arr) ;
//	print_r($elenco);
	saveInfoTavole($elenco) ;
	unset($_GET['new']) ;
}

if( isset($_GET['new']) ) {
	$arr['codice'] = $tavola ;
	$elenco = array_to_object($arr) ;
}
else {
	$elenco = getInfoTavole($tavola);
}
?>
<div id='home' class='bosco'>
  <div class='b_title'>Tavole di cubatura</div>
    
    <form name='tavole1_form' action='#' method='post'>
    <div id='tavole1_top'>
	    <div class='tavole'>
		    <table>
			<tr><td class='bold'>Codice</td>
			    <td class='td_320'><input type='text' name='codice' value='<?=$elenco->codice ?>' /></td></tr>
			<tr><td class='bold'>Descrizione</td>
			    <td class='td_320'><input type="text" name=descriz value="<?echo $elenco->descriz?>" /></td></tr>
			<tr><td class='bold'>Autore</td>
			    <td class='td_320'><input type="text" name=autore value="<?echo $elenco->autore?>" /></td></tr>
		    </table>
	    </div>
	    <div class='tavole'>
		    <table>
			<tr><td class='bold'>Note</td><td><input id='nota_tavole' type='text' name='note' value="<?echo $elenco->note ?>" /></td></tr>
		    </table>
	    </div>

    </div>
      
    <div id='tavole1_center' >

	      <div class='tavole'>
		      <table>
			  <caption>Tipo</caption> 
			  <tr><td><input type="radio" name="tipo" value="1"<? if($elenco->tipo == 1):echo "checked"; endif; ?> /> Doppia entrata</td></tr>
			  <tr><td><input type="radio" name="tipo" value="2"<? if($elenco->tipo == 2):echo "checked"; endif; ?> /> Una entrata</td></tr>
			  <tr><td><input type="radio" name="tipo" value="3"<? if($elenco->tipo == 3):echo "checked"; endif; ?> /> Tariffe</td></tr>
			  <tr><td><input type="radio" name="tipo" value="4"<? if($elenco->tipo == 4):echo "checked"; endif; ?> /> Popolamento</td></tr>
			</table>
	      </div>
	  <div id='contenitore2div' class='tavole'>
	      <div class='tavole'>
			<table>
			    <caption>Forma</caption>
			    <tr><td><input type="radio" name="forma" value="1"<? if($elenco->forma == 1):echo "checked"; endif; ?> />Tabellare</td></tr>
			    <tr><td><input type="radio" name="forma" value="2"<? if($elenco->forma == 2):echo "checked"; endif; ?> />Funzione</td></tr>
		      </table>
	      </div>

	      <div class='tavole'>
			<table>
			    <tr><td><input type="checkbox" name="biomassa" <?=($elenco->biomassa == 't' )?"checked":""?> />Modello per biomassa</td></tr>
			    <tr><td><input type="checkbox" name="assortimenti" <?=($elenco->assortimenti == 't' )?"checked":""?> />Assortimento</td></tr>
		      </table>
	      </div>

	 </div>  <!--box contenete 2 div con le loro tabelle-->
  
    </div> <!--box largo 800px-->

    <div id='tavole1_center1' >
	      <div class='tavole'>
		      <table>
			    <caption>Campi di variazione</caption>
			  <tr><td colspan="2" class='bold'>Diametri cm</td><td colspan="2" class='bold'>Altezze m</td></tr>
			  <tr><td class="colonna1">min</td><td class="colonna2"><input type="text" name="d_min" value="<?echo $elenco->d_min?>"></td>
			      <td class="colonna1">min</td><td class="colonna2"><input type="text" name="h_min" value="<?echo $elenco->h_min?>"></td></tr>
			  <tr><td>max</td><td><input type="text" name="d_max" value="<?echo $elenco->d_max?>"></td>
			      <td>max</td><td><input type="text" name="h_max" value="<?echo $elenco->h_max?>"></td></tr>
			  <tr><td>Ampiezza classe</td><td><input type="text" name="classe_d" value="<?echo $elenco->classe_d?>"></td>
			      <td>Ampiezza classe</td><td><input type="text" name="classe_h" value="<?echo $elenco->classe_h?>"></td></tr>
		      </table>
	      </div>
    </div>

    <div id='tavole1_center2' >
	      <div class='tavole'>
		      <table>
			  <caption>Funzione</caption>
			  <tr><td class='td_800'><input type="text" name="funzione" value="<?echo $elenco->funzione?>"></td></tr>
		      </table>
	      </div>
    </div>
<?php
    if( isset($_GET['new']) )
	    echo "<input type='submit' name='inserisci_dati' value='inserisci dati' />" ;
    else
	    echo "<input type='submit' name='modifica_dati' value='modifica dati' />" ;
?>
    </form>
</div>
<?php
}
?>