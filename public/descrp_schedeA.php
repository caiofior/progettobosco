<?php 
if(   isset($_REQUEST['schedaA']) ) 	{/* isset($_POST['scheda'])*/

	// inserisco controlli e azioni relativi alla scheda_a
	include('descrp_schedeA_actions.php') ;
	//assegnazione della variabili del form precedente
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST["particella"];
	$scheda = $_REQUEST['schedaA'];
	$info = null ;  // relative a tabella scheda_a
	$cod_fo = ' 1'; //metto io forzatamente cod_fo =(spazio)1, perchè è rimasto da cose vecchie !!!!!!!!!!!!!!!!!!!!
 //###### genero l'array vuoto contenente tutti i campi della tabella schede_a che mi servono
	$arr = generate_Arr_arch('schede_a'); //##
 //###############################
//print_r($arr);
//echo" in totale sono ".count($arr)." variabili.";
//----------------------------Modifica/Inserimento dati-----------------------------------------

  //se si vuole modificare o inserire i dati di una particella si fanno eseguire l'UPDATE o l'INSERT nella tabella SCHEDE_A con la funzione saveInfoDescrp($info, $proprieta, $particella) 
	// assegnazione dei nomi degli elementi dell'oggetto $arr e dei loro rispettivi valori inseriti con il form "descrp_schede_form"
	if( isset($_REQUEST['inserisci_dati']) or isset($_REQUEST['modifica_dati'])) {
		$arr = fill_Arr($arr, $proprieta,$particella, $cod_fo );

	      saveInfoDescrp($arr, $proprieta, $particella, 'schede_a');
		  redirect("?page=descrp&schedaA=Scheda A&particella=$particella&proprieta=$proprieta");
	}
// Per "Elimina dati"
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
if( isset($_REQUEST['delete']) ) {	
	list( $res , $id ) = cancellaPart($proprieta, $particella, 'schede_a') ;
	 redirect("?page=descrp");	
}	

//-------------------------------Nuovo record------------------------------------------------------------------
	$temp_var = esisteProprietaEParticella('catasto', $proprieta, $particella);
	if( empty($temp_var)and isset($_REQUEST['new'])) {
 //caso in cui si debba riempire tabelle schede_a e catasto, oppure si crei una nuvo tabella a
		$arr['proprieta'] = $proprieta ;
		$arr['particella'] = $particella ;
 		$arr['cod_fo'] = $cod_fo ;
		$info = array_to_object($arr) ;
	} else 	{  // caso in cui si debba solo interrogare il database perchè i dati sono già stati inseriti
		$info = getInfoSchedaA( $proprieta , $particella);
	}

//-----------------------------Select per costruzione pagina-----------------------------------------
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di SCHEDE_A 
	$comune = getInfoComuni ($proprieta);
	$rilevato = getCod_descriz ('rilevato');
	$regione = getDiz_regioniCod($proprieta);
	$boschi = getCodiciBoschiCodice( $proprieta );
	$info_propriet = getInfoPropriet( $proprieta );
	$cod_propriet = getCod_descrizion( 'propriet' );
	$posfisio = getPosfisio () ;
	$espo = getEspo ();
	$ostacoli = getOstacoli ();

	// interrogazioni tabella 'archivi' per estrarre i nomi delle colonne per poi fare le tabelle di SCHEDE_A
	$archivio = 'schede_a';
	$indici_a = array ('a2', 'a3', 'a4', 'a6', 'a7');// 'a8' è la nota di commento, mentre manca 'a5'
	      foreach ($indici_a AS $k => $ak)   $dissesto[$ak] = getIntestazione ( $archivio , $ak )->intesta;
	$indici_r = array ('r2', 'r3', 'r4', 'r5', 'r6');// 'r7' è la nota di commento
	      foreach ($indici_r AS $k => $rk)   $limite_radici[$rk] = getIntestazione ( $archivio , $rk )->intesta;
	$indici_f = array ('f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f10', 'f11');// 'f12' è nota di commento, mentre manca 'f9' 
	      foreach ($indici_f AS $k => $fk)   $fattori_alt[$fk] = getIntestazione ( $archivio , $fk )->intesta;
	$indici_p = array ('p1','p2','p3','p4','p5','p6'); // 'p7' sono le specie pascolanti, 'p9' specifica specie, 'p8' specifica altri fattori
	      foreach ($indici_p AS $k => $pk)   $fattori_part[$pk] = getIntestazione ( $archivio , $pk )->intesta;
	$pascolo = array (1=>'bovini', 'ovini', 'caprini', 'equini', 'altro');	
	$indici_m = array ('m1', 'm2', 'm21', 'm3', 'm4', 'm22', 'm20', 'm5','m6','m7','m8', 'm9', 'm10', 'm12', 'm13', 'm15', 'm14', 'm23', 'm16', 'm17', 'm18');// 'm11'campo mancante, 'm19' è la nota di commento
	      foreach ($indici_m AS $k => $mk)   $manufatti[$mk] = getIntestazione ( $archivio , $mk )->intesta;
	$indici_c = array ('c1','c2', 'c3', 'c4', 'c5');// 'c6' è la nota di commento
	      foreach ($indici_c AS $k => $ck)   $condizionamenti[$ck] = getIntestazione ( $archivio , $ck )->intesta;
	$indici_i = array ('i3', 'i4', 'i5', 'i6', 'i7');// 'i8' è la nota di commento, mentre'i1','i2' e 'i21','i22'sono le superfici
	      foreach ($indici_i AS $k => $ik)   $improduttivi[$ik] = getIntestazione ( $archivio , $ik )->intesta;
//----------------------------------------------------------------------

// ############################### formA2 ############################################################## 

 $arr_note['cod_nota']=""; $arr_note['nota']="";


	if( isset($_REQUEST['insert_noteA']) or isset($_REQUEST['modify_noteA']) ) {
	      foreach( array_keys($arr_note) as $key ) {
		$val = ( isset($_REQUEST[$key]) )? $_REQUEST[$key] : null ;
		$arr_note[$key] = $val ;
	      }
		  $arr_note['id_av'] =trim($proprieta).trim($particella).trim($cod_fo);
	      $info_note = array_to_object($arr_note) ;// trasformazione da array in oggetto
	      saveInfoDescrpA_note($info_note, $proprieta, $particella) ;
	      redirect("?page=descrp&schedaA=Scheda A&particella=$particella&proprieta=$proprieta");
	}

 //se si vuole semplicemente interrogare la tabella NOTE_A si fanno le SELECT con le funzioni getInfoScheda_note(.., ..) dalla tabella
	$info_note = getInfoScheda_note ($proprieta, $particella, 'note_a');
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di note_A 
	$note_tutte= getInfoSchedaNoteTutte ('schede_a');

// #############################################################################################


?>
<div id='home' class='descrp_schede schedeA'>
  <form name="descrp_schede_form" action="#" method="post">
  <input type='hidden' name='schedaA' value='Scheda A' />
  <div id='descrp_schede'>
  <div id="centra">  <!--serve per centrare tutta la pagina rispetto ai 1200px della barra superiore-->
 	<div id='descrp_schede_top'>  
		<div id='b_title_descrp' class="white"><span>Regione
		    <?php  if (isset($_REQUEST['proprieta']) and $_REQUEST['proprieta'] != 'bosco...'){ echo $regione->descriz ; }
			    else echo "...";  ?><span>
			    <br /><span>Sistema informativo per l'assestamento forestale<span>
		</div> <!--//DIV: b_title_reg-->
<!-- Bottone modifica/cancella o inserisci  -->
		<div  class='bottone_alto'>
		      <?    echo "<div class='mod_ins'>";
			  if( isset($_REQUEST['new'])) //bottone per query di INSERT (vedi descrp_schedeA_actions.php)
				  echo "<input class='bot_descrp ModDell confermaMOD' title='proprietà $info_propriet->descrizion e particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>";
			  else	{//bottone per query di UPDATE (vedi descrp_schedeA_actions.php)
				  echo "<input class='bot_descrp ModDell confermaMOD' title='proprietà $info_propriet->descrizion e particella $particella' type='submit' name='modifica_dati' value='Salva modifiche' /></div>";

// 				  echo "<input class='grande h40px' title='Elimina dati di $info_propriet->descrizion particella $particella' type='submit' name='elimina_dati' value='Elimina dati' />";

				  //ancora per query DELITE e che mi rimanda alla pagina descrp_schedeA.php
				  echo "<div id='cancella'><a class='bot_descrp ModDell confermaDELL'  title='proprietà di $info_propriet->descrizion e particella $particella' href='?page=descrp&schedaA=Scheda A&delete=ok&proprieta=$proprieta&particella=$particella'>Elimina dati</a></div>";}?>
		</div>

<!-- Bosco  -->
		<div id='ds_top_top' class='daticat'>
		      <div class='block10'><table width='370px'><caption>Bosco</caption>
		      <tr><td>
			    <? 	  echo "<select name='proprieta'>
					    <option value='' selected='selected'></option>\n";
				  foreach( $cod_propriet as $pro ) {
					  $selected = ( isset($info->proprieta) and  $info->proprieta == $pro->codice)? 'selected' : ' ' ;
					  echo "<option value='$pro->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$pro->codice | $pro->descrizion</option>\n";}
			    echo "</select>";?></td></tr></table></div>

		      <div class='block1010'><table width='350px'><caption>Rilevatore</caption>
			  <tr><td>
			    <?echo "<select name='codiope'>";
				  echo "<option value='' selected='selected'></option>\n";
				  foreach( $rilevato as $ril ) {
					  $selected = ( isset($info->codiope) and  $info->codiope == $ril->codice)? 'selected' : ' ' ;
					  echo "<option value='$ril->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$ril->codice | $ril->descriz</option>\n";}
			    echo "</select>";?></td></tr></table>
		     </div> 

		      <div title='aaaa/mm/gg o aaaa-mm-gg' class='block1010'><table width='160px'><caption>Data del rilievo</caption>
		      <tr><td> <input type='text' class='controllo_data' name='datasch' value='<?php echo $info->datasch?>'/></td></tr></table></div>
<!--RegExp UK che mi serve: ^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$-->
<!-- RegExp IT che mi serve: ([1-9]0[1-9][12][0-9]3[01])[- /.]([1-9]0[1-9]1[012])[- /.][0-9]{4}$  -->
		</div> <!--id='ds_top_top' class='daticat'-->
        </div> 
      <!-- id='descrp_schede_top'-->
      <?php
//------------------------------------------------------------ Scheda A -------------------------------------------------
if ($scheda == 'Scheda A') {    
// echo"info "; print_r($info);
// $i=0;
// foreach($info AS $inf) $i++;
// echo $i;

?>  
      
    <div id='ds_center1'  class='tavole'>
	    <div id="ds_container1" class='tavole'>
		  <div id='ds_title' class='block'>Scheda A per la descrizione di<br />FATTORI AMBIENTALI E DI GESTIONE</div>
		  <div class='block10'><table width='250px'><caption>Comune</caption>
		  <tr><td> 
		  <?echo "<select name='comune'>";
			echo "<option value='' selected='selected'></option>\n";
			foreach( $comune as $com ) {
				$selected = ( isset($info->comune) and  $info->comune == $com->codice)? 'selected' : ' ' ;
				echo "<option value='$com->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$com->codice | $com->descriz</option>\n";}
		echo "</select>";?>
		</td></tr></table></div>
		  <div class='block10'><table width='160px'><caption>Altitudine prevalente (m)</caption>
		  <tr><td><input type='text' class='num' name='ap' value='<?php echo $info->ap?>' /></td></tr></table></div>
		  <div class='block10'><table width='250px'><caption>Nome del Luogo</caption>
		  <tr><td><input type='text' name='toponimo' value='<?php echo $info->toponimo?>' /></td></tr></table></div>
 		  <div class='block10'><table width='160px'><caption>Pendenza prevalente (%)</caption> 
		  <tr><td><input type='text' class='perc' name='pp' value='<?php echo $info->pp?>' /></td></tr></table></div>
	    </div> <!--id="ds_container" class='tavole'-->

	    <div id="ds_container2" class='tavole'>
		  <div id="spazio_sup" class="block"></div>
		  <div class='block10'><table width='110px'><caption>Superficie (ha)</caption>
		  <tr><td><input type='text' class='num' id='sup_tot' name='sup_tot' value='<?php echo $info->sup_tot?>' /></td></tr></table></div>
		  <div class='block'><table width='110px'><caption>Sup. boscata (ha)</caption>
		  <tr><td id='bosc' class='grey'><?if(isset($info->bosc)) echo $info->bosc; else echo "...";?></td></tr></table></div> 
		  <div id='improduttivi' class='block10'><table width='110px'><caption>Improduttivi (ha)</caption>
		  <tr><td id='improd' class='grey'><?php if(isset($info->improd)) echo $info->improd; else echo"..."; ?></td></tr></table></div>
		  <div class='block'><table width='110px'><caption>Produttivi non<br />boscati (ha)</caption>
		  <tr id='p_n_bosc' class='grey'><td><?php if(isset($info->p_n_bosc)) echo $info->p_n_bosc; else echo"...";?></td></tr></table></div> 
	    </div> <!--id="ds_container2" class='tavole'-->

	    <div id="ds_container3" class='tavole'>
		  <div class='block1010'><table width='160px'><caption>Particella/Sottoparticella</caption>
		  <tr><td><?php echo $particella ?></td></tr></table></div>
			      <input type='hidden' name='particella' value ='<?php echo $particella; ?>' />
		  <div class='block1010'><table width='250px'><caption>Sottoparticella</caption>
		  <tr><td><input type="radio" class='radio_dis' name="delimitata" value="t" <? if($info->delimitata == 't'):echo " checked"; endif; ?> /></td><td>delimitata</td>
		      <td><table width='150px'><caption>estesa sul ...(%)</caption><tr><td><input type='text' class='perc def0' name='sup' value='<?php if (isset($info->sup) and $info->sup!='') {echo $info->sup;} else{echo "0";} ?>' /></td></tr></table>
		      </td></tr>
		  <tr><td><input type="radio" class='radio_dis' name="delimitata" value="f" <? if($info->delimitata == 'f'):echo " checked"; endif; ?> /></td><td>non<br />delimitata</td><td></td></tr>
		  </table></div> 
	    </div> <!--id="ds_container3" class='tavole'-->
    </div>
<!-- id='ds_center1' -->


    <div id='ds_center2'  class='tavole'>
<!-- Posizione fisiografica prevalente  -->
	    <div id="ds_container4" class='tavole'>
		  <div class='block'><table  class='row'><caption class="span"><span>Posizione fisiografica prevalente</span></caption>
		  <tr><?php foreach ( $posfisio as $indice => $pos ) {
			    $k = $indice + 1;
			    echo "<td><input type='radio' class='radio_dis' name='pf1' value='$k'"; if($info->pf1 == $k ): echo " checked"; endif;
			    echo " /></td><th>$pos->descriz</th>\n"; }  ?>
		  </tr></table></div>  
	    </div> <!--id="ds_containe5" class='tavole'-->
<!-- Esposizione prevalente  -->
	    <div id="ds_container5" class='tavole'>
		  <div class='block'><table><caption class="span"><span>Esposizione prevalente</span></caption>
	    <?php
		  echo "<tr><td colspan='2'></td><td><input type='radio' class='radio_dis' name='e1' value='1'"; if($info->e1 == '1'):echo " checked"; endif; echo "/>N</td><td colspan='2'></td></tr>
		  <tr><td></td><td><input type='radio' class='radio_dis' name='e1' value='8' "; if($info->e1 == '8'):echo " checked"; endif; 
		  echo "/>NO</td><td></td>
		  <td><input type='radio' class='radio_dis' name='e1' value='2'"; if($info->e1 == '2'):echo " checked"; endif; 
		  echo "/>NE</td><td></td></tr>
		  <tr><td><input type='radio' class='radio_dis' name='e1' value='7'" ; if($info->e1 == '7'):echo " checked"; endif;  
		  echo "/>O</td><td></td>
		  <td><input type='radio' class='radio_dis' name='e1' value='9'"; if($info->e1 == '9'):echo " checked"; endif;  
		  echo "/>null</td><td></td>
		  <td><input type='radio' class='radio_dis' name='e1' value='3'"; if($info->e1 == '3'):echo " checked"; endif; 
		  echo "/>E</td></tr>
		  <tr><td></td><td><input type='radio' class='radio_dis' name='e1' value='6'"; if($info->e1 == '6'):echo " checked"; endif; echo "/>SO</td><td></td>
		  <td><input type='radio' class='radio_dis' name='e1' value='4'"; if($info->e1 == '4'):echo " checked"; endif; 
		  echo "/>SE</td><td></td></tr>
		  <tr><td colspan='2'></td><td><input type='radio' class='radio_dis' name='e1' value='5'"; if($info->e1 == '5'):echo " checked"; endif;echo " />S</td><td colspan='2'></td></tr>\n";?>
		  </table></div> 
	    </div> <!--id="ds_container5" class='tavole'-->

	    <div id="ds_container6" class='tavole'>
<!-- Dissesto  -->
		  <div class='block10'><table class="checkbox_in"><caption class="span"><span>Dissesto</span></caption>
		  <tr class='back_blue'><td></td><th>assente</th><th>&lt;5%</th><th>&lt;1/3</th><th>&gt;1/3</th><th>pericolo di<br />peggioramento</th><td></td></tr>
 		  <?php 
		    foreach ( $dissesto as $ak => $a) { 
			      echo "<tr><th>$a</th>\n";
			      echo "<td><input type='radio' class='radio_dis' name='$ak' value='0'"; if($info->$ak ==  '0' ): echo " checked"; endif;
			      echo " /></td>\n" ; 
			      for( $i=2; $i<=4; $i++ ) {
				  echo "<td><input type='radio' class='radio_dis' name='$ak' value='$i'"; if($info->$ak ==  $i ): echo " checked"; endif;
				  echo " /></td>\n" ; }
			      echo "<td><input type='radio' class='radio_dis' name='$ak' value='1'"; if($info->$ak ==  '1' ): echo " checked"; endif;
			      echo " /></td>\n" ; 
			      if ($ak == 'a7'){
				    echo "<td><table width='200px'><caption>specifica altri fattori</caption>";
				    echo "<tr><td><input type='text' name='a8' value='$info->a8' /></td></tr></table>\n";
				    }
			      else { echo "<td></td></tr>\n";}
			}
 		 ?>
		  </table></div> 
	    </div> 
	    <!--id="ds_container6" class='tavole'-->
    </div>
    <!-- id='ds_center2' -->

    <div id='ds_center3'  class='tavole'>

	    <div id="ds_container7" class='tavole'>
<!-- Limiti dello sviluppo delle radici -->
		  <div class='block10'><table class="checkbox_in"><caption class="span"><span>Limiti dello sviluppo delle radici</span></caption>
		  <tr class='back_blue'><td></td><th>assenti o<br />limitati</th><th>&lt;5%</th><th>&lt;2/3</th><th>&gt;2/3</th></tr>
		  <?php
		    foreach ( $limite_radici as $rk => $r) { 
			      echo "<tr><th>$r</th>\n";
			      for( $i=0; $i<=3; $i++ ) {
				  echo "<td><input type='radio' class='radio_dis' name='$rk' value='$i'"; if($info->$rk ==  $i ): echo " checked"; endif;
				  echo " /></td>\n" ; }
			      if ($rk == 'r6'){
				    echo "<td><table width='200px'><caption>specifica altri fattori</caption>";
				    echo "<tr><td><input type='text' name='r7' value='$info->r7' /></td></tr></table>\n";
				    }
			      else { echo "<td></td></tr>\n";}
			}
		 ?>
		  </table></div> 
	    </div> 
	    <!--id="ds_container7" class='tavole'-->
    </div>
    <!-- id='ds_center3' -->

    <div id='ds_center4'  class='tavole'>
	    <div id="ds_container8" class='tavole'>
<!--Fattori di alterazione fitosanitaria  -->
		  <div class='block10'><table class="checkbox_in"><caption class="span"><span>Fattori di alterazione fitosanitaria</span></caption>
		  <tr class='back_blue'><td></td><th>assenti</th><th>&lt;5%</th><th>&lt;1/3</th><th>&gt;1/3</th><th>pericolo di<br />peggioramento</th></tr>
		   <?php 
		    foreach ( $fattori_alt as $fk => $f) { 
			      echo "<tr><th>$f</th>\n";
			      echo "<td><input type='radio' class='radio_dis' name='$fk' value='0'"; if($info->$fk ==  0 ): echo " checked"; endif;
			      echo " /></td>\n" ; 
			      for( $i=2; $i<=4; $i++ ) {
				  echo "<td><input type='radio' class='radio_dis' name='$fk' value='$i'"; if($info->$fk ==  $i ): echo " checked"; endif;
				  echo " /></td>\n" ; }
			      echo "<td><input type='radio' class='radio_dis' name='$fk' value='1'"; if($info->$fk ==  1 ): echo " checked"; endif;
			      echo " /></td>\n" ;
			      if ($fk == 'f11'){
				    echo "<td><table width='200px'><caption>specifica altri fattori</caption>";
				    echo "<tr><td><input type='text' name='f12' value='$info->f12' /></td></tr></table>\n";
				    }
			      else { echo "<td></td></tr>\n";}
			}
		 ?>
		  </table></div> 
	    </div> 
	    <!--id="ds_container8" class='tavole'-->
    </div>
    <!-- id='ds_center4' -->


    <div id='ds_center5'  class='tavole'>
<!-- Accessibilità -->
	    <div id="ds_container9" class='tavole'>
		  <div class='block10'><table width='280px'><caption class="span"><span>Accessibilità</span></caption>
		  <tr><td><table  width='150px'><caption>insufficiente sul ...(%)</caption>
			  <tr><td><input type='text' class='perc v3' id='v3' name='v3' value='<?echo $info->v3?>'/></td></tr></table></td>
		   <td><table  width='120px'><caption>buona sul ...(%)</caption>
			  <tr><td><input type='text' class='perc v1' id='v1' name='v1' value='<?echo $info->v1?>' /></td></tr></table></td>
		  </tr></table></div>   
	    </div> <!--id="ds_container9" class='tavole'-->
<!-- Ostacoli agli interventi -->
	    <div id="ds_container10" class='tavole'>
		  <div class='block10'><table class='row' width='700px'><caption class="span"><span>Ostacoli agli interventi</span></caption><tr> <!-- class='back_blue' -->
		  <?php foreach ( $ostacoli as $indice => $ostacolo ) {
			    $k = $indice + 1;
			    echo "<td><input type='radio' class='radio_dis' name='o' value='$k'"; if($info->o == $k ): echo " checked"; endif;
			    echo " /></td><th>$ostacolo->descriz</th>\n"; }  ?>
		  </tr></table></div>   
	    </div> <!--id="ds_container10" class='tavole'-->
<!-- Condizionamenti Eliminabili -->
	    <div id="ds_container11" class='tavole'>
		  <div class='block'><table><caption class="span"><span>Condizionamenti Eliminabili</span></caption><tr>
		  <?php $contatore = 1;
			foreach ( $condizionamenti as $ck =>  $c ) {
			    $i = trim($ck, 'c');
			    if ($contatore == 1){
				echo "<td><input type='checkbox' class='check_nessuno_capo check_nessuno check_nessuno_group_condizioni' name='$ck' value='$i'"; if($info->$ck == 't' ): echo " checked"; endif;
				echo " /></td><th>$c</th>\n"; }
			    else {echo "<td><input type='checkbox' class='check_nessuno check_nessuno_group_condizioni' name='$ck' value='$i'"; if($info->$ck == 't' ): echo " checked"; endif;
			    echo " /></td><th>$c</th>\n"; }
			    $contatore++;
			}?>  <td>
			<table width='200px'><caption>specifica</caption>
			<tr><td><input type='text' name='c6' value='<?php echo $info->c6?>' /></td></tr></table>
		  </td></tr></table>
		  </div>  
	    </div> <!--id="ds_container11" class='tavole'-->
<!-- Fatti particolari -->
	    <div id="ds_container12" class='tavole'>
		  <div class='block10'><table width='1000px'><caption class="span"><span>Fatti particolari</span></caption><tr>
		  <?php 
		    
		    foreach ( $fattori_part as $pk => $p) { 
			    $i = intval(trim($pk, 'p'));
 			    if ($i == 1 ){
				echo "<td><input type='checkbox' class='check_nessuno_capo check_nessuno check_nessuno_group_fatti' name='$pk' value='$i'"; if($info->$pk == 't' ): echo " checked"; endif;
				echo " /></td><th>$p</th>\n";
			    }
			    else if ($i==2) {
				  echo "<td><input type='checkbox' class='check_nessuno check_nessuno_group_fatti depends_on depends_group_pascoli depends_capo' name='$pk' value='$i'"; if($info->$pk == 't' ): echo " checked"; endif;
				  echo " /></td><th>$p</th>\n";

				  echo "<td><table width='410px'><caption class='span'><span>specie pascolante</span></caption>\n<tr>";
				  foreach ($pascolo AS $j => $animale){
				      echo "<td><input type='radio' class='depends_on depends_group_pascoli' name='p7' value='$j'"; if($info->p7 == '$j' ): echo " checked"; endif;
				      echo " /></td><th>$animale</th>\n";
				  }
				  echo "<th><table width='90px'><caption>Specifica</caption><tr><td><input type='text' name='p9' value='$info->p9' /></td></tr></table></th>\n";
				  echo "</td></tr></table>"; 
			    }
			    else { 
				echo "<td><input type='checkbox' class='check_nessuno check_nessuno_group_fatti' name='$pk' value='$i'"; if($info->$pk == 't' ): echo " checked"; endif;
				echo " /></td><th>$p</th>\n"; 
			    }
		    }
?>
		    <td><table width='100px'><caption>specifica</caption>
			  <tr><td><input type='text' name='p8' value='<?php echo $info->p8 ?>' /></td></tr></table></td>
		  </tr></table></div>   
	    </div> 
	    <!--id="ds_container12" class='tavole'-->
    </div>
    <!-- id='ds_center5' -->


    <div id='ds_center6'  class='tavole'>
<!-- Improduttivi inclusi non cartografati -->
	    <div id="ds_container13" class='tavole'>
		  <div class='block10'><table width='760px'><caption class="span"><span>Improduttivi inclusi non cartografati</span></caption>
		      <tr><td><table><caption>superficie (ha)</caption><tr><td width="100px"><input type='text' class='num' id='i1' name='i1' value='<? if (isset($info->i1)  and $info->i1!=''){echo $info->i1;} else {echo 0; } ?>' /></td></tr></table></td>
		      <td><table><caption>superficie (%)</caption><tr><td  width="100px"><input type='text' class='perc' id='i2' name='i2' value='<? if (isset($info->i2)  and $info->i2!=''){echo $info->i2;} else {echo 0; }  ?>' /></td></tr></table></td>
		      <?php foreach ( $improduttivi as $ik =>  $imp ) {
				$i = trim($ik, 'i');
				echo "<td><input type='checkbox' name='$ik' value='$i'"; if($info->$ik == 't' ): echo "checked"; endif;
				echo " /></td><th>$imp</th>\n"; }   ?>
		      <td><table><caption>specifica</caption><tr><td  width="150px"><input type='text' name='i8' value='<?echo $info->i8?>' /></td></tr></table></td>
		  </tr></table></div>  
<!-- Produttivi non boscati inclusi non cartografati -->
		  <div class='block10'><table width='300px'><caption class="span"><span>Produttivi non boscati inclusi non cartografati</span></caption>
			<tr><td><table><caption>superficie (ha)</caption><tr><td width="100px"><input type='text' class='num' id='i21' name='i21' value='<?if (isset($info->i21)  and $info->i21!=''){echo $info->i21;} else {echo 0; } ?>' /></td></tr></table></td>
			<td><table><caption>superficie (%)</caption><tr><td  width="100px"><input type='text' class='perc' id='i22' name='i22' value='<?if (isset($info->i22)  and $info->i22!=''){echo $info->i22;} else {echo 0; } ?>' /></td></tr></table></td> 
		  </tr></table></div> 
	    </div> <!--id="ds_container13" class='tavole'-->
<!-- Opere e manufatti -->
	    <div id="ds_container14" class='tavole'>
		  <div class='block10'><table><caption class="span"><span>Opere e manufatti</span></caption>
		      <tr><?php 
				$contatore = 1;
				foreach ( $manufatti as $mk => $m) { 
					$i = trim($mk,'m');
					if ($contatore==1){
					    echo "<td><input type='checkbox' class='check_nessuno_capo check_nessuno check_nessuno_group_opere'  name='$mk' value='$i'"; if($info->$mk == 't' ): echo " checked"; endif;
					    echo " /></td><th>$m</th>\n"; 
					} else {
					    echo "<td><input type='checkbox' class='check_nessuno check_nessuno_group_opere' name='$mk' value='$i'"; if($info->$mk == 't' ): echo " checked"; endif;
					    echo " /></td><th>$m</th>\n";
					}
					if ($i == 8 ): echo " </tr><tr>"; endif;
					$contatore++;
				} ?>
		      <td colspan='2'><table><caption>specifica</caption><tr><td  width="130px"><input type='text' name='m19' value='<?echo $info->m19 ?>' /></td></tr></table></td>
		  </tr></table>
		  </div>
	    </div> <!--id="ds_container14" class='tavole'-->
    </div>
    <!-- id='ds_center6' -->

    <div id='ds_center7'  class='tavole'>
<!-- ############### Note alle singole voci ######################-->
<!-- qui inserisco le due variabili che poi passo al form sottostante (particelle_note_form)
che sono parametro_sing = cod_nota,  nota_sing = nota -->
	<div id="ds_container15" class='tavole'>
 	      <a name='container15'> </a> 
	      <div id='div_note_singole_a' class='block10'><table class='row'><caption class="span"><span>NOTE alle singole voci</span></caption>
			<tr><td>
			<div id='note_singole_a_int' class='block'><table id='note_singole_a'>
				<tr><td class='center' width='50%'><b>Parametro</b></td><td class='center' width='50%'><b>Nota</b></td></tr> 
				<?php foreach ($info_note as $in){  ?>
						<tr id='tr_<?echo $in->cod_nota; ?>'><td>
						<select name='parametro_sing'>
							<option selected='selected' value='-2' >...</option>
							<?foreach( $note_tutte as $nt ){
								$selected1 =($nt->nomecampo == $in->cod_nota)? 'selected' : ''; 
								echo "<option value='$nt->nomecampo' $selected1 > ($nt->nomecampo) $nt->intesta</option>\n";
							} ?>
						</select></td>
						<td><input name='nota_sing' type="text" value='<? echo $in->nota ?>' /></td>
						<td><a href='#' onclick='javascript:schedeA_form3("<?echo $in->cod_nota ?>")'>Salva</a></td>
						<td><a class='delete_noteA' title='<?echo $in->cod_nota?>' href='<?php echo "?page=descrp&schedaA=Scheda A&delete_noteA=ok&proprieta=$proprieta&particella=$particella&cod_nota=$in->cod_nota#container15"?>'>Elimina</a></td>
					<?} ?>
				</tr>
		
				<tr><td>
				<select name='parametro_sing1'>
					<option selected='selected' value='-1' > nota...</option>
					<? foreach( $note_tutte as $nt ) echo "<option value='$nt->nomecampo'>($nt->nomecampo) $nt->intesta</option>\n";?>
				</select></td>
				<td><input type='text' name='nota_sing1' value='' /></td>
				<td colspan='2' style='text-align:center'>
				<a href='#' onclick='javascript:schedeA_form2()'>Inserisci</a>
				</td></tr>
			</table></div>
			</td></tr>
	      </table></div>

	</div> <!--id="ds_container15" class='tavole'-->
<!-- NOTEj -->
	<div id="ds_container16" class='tavole'>
		<div class='block'><table class="big_200"><caption>NOTE</caption>
		<tr><td class="top">
			<textarea name='note'  rows="12" cols="21"><?php echo $info->note?></textarea> 
		 </table>
		</div>

		     <div id='ds_center8'  class='tavole'>
				<div  class='bottone_basso'>
			    <div class='mod_ins'>
				<?php if( isset($_REQUEST['new']) ) { ?><!--//bottone per query di INSERT (vedi descrp_schedeA_actions.php-->
				    <input class='bot_descrp ModDell confermaMOD' title='<? echo "proprietà ".$propriet->descrizion." e particella ".$particella?>' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>
				<? } else	{ ?><!--//bottone per query di UPDATE (vedi descrp_schedeA_actions.php)-->
				    <input class='bot_descrp ModDell confermaMOD' title='salva modifiche di <? echo $info_propriet->descrizion?> particella <? echo $particella?>' type='submit' name='modifica_dati' value='Salva modifiche' /></div>
					 <!--//ancora per query DELITE e che mi rimanda alla pagina descrp_schedeA.php-->
				    <div id='cancella'><a class='bot_descrp ModDell confermaDELL' title='proprietà di <?echo $propriet->descrizion?> e particella <?echo $particella?>' href='<? echo "?page=descrp&delete=$proprieta&particella=$particella"?>'>Elimina dati</a></div>
				<? } ?>
			</div>  <!-- id='ds_center8'  class='tavole'-->

    </div> <!--id="ds_container16" class='tavole'-->

<?php
}
//   fine della scheda A
?>
</form>
<!-- ######################## form note singole voci######################################## -->
<?
if ($scheda == 'Scheda A') 	{ 
// Attenzione!! vedere in js la funzione "formA2()"
/*	foreach ($info_note as $in){*/ ?>
<!-- 	<form name='formA2' id='formA2' action="#" method="post"> -->


	<form name='formA2' id='formA2' action="#container15" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedaA'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedaA' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='insert_noteA' value='ok' />
	</form>


	<form name='formA3' id='formA3' action="#container15" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedaA'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedaA' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='modify_noteA' value='ok' />
	</form>
<?php
}

/*<!-- ############################# form catasto################################### -->*/


//+++++++++++++++++++++++++++++++ Catasto  Form 4-5 +++++++++++++++++++++++++++++++++++++++
  // creazione dell'oggetto $cat per la modifica e l'inserimento dei dati nella tabella catasto
  $cat['foglio']=""; $cat['particella_cat']=""; $cat['sup_tot_cat']=""; $cat['sup_tot']=""; $cat['sup_bosc']=""; 
  $cat['sum_sup_non_bosc']="";  $cat['porz_perc']=""; $cat['note']="";
  $cat['foglio_old']="";    $cat['particella_cat_old']="";  

  // modifche legate alla tabella CATASTO

	if (isset($_REQUEST['insert_catasto']) or isset($_REQUEST['modify_catasto']) ){
	      $cat = fill_Arr($cat, $proprieta, $particella, $cod_fo );
	
	      $cat = array_to_object($cat) ;
	      saveInfoSchedeCatasto($cat, $proprieta, $particella, 'catasto') ;
	      redirect("?page=descrp&schedaA=Scheda A&particella=$particella&proprieta=$proprieta");	  
	}

	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di CATASTO per poi fare le tabelle di SCHEDE_A
	$catasto = getInfoSchedeCatasto ( $proprieta , $particella );
	$sum_catasto = getSumSchedeCatasto ( $proprieta , $particella );
	$info_cat = getInfoScheda($proprieta, $particella , 'catasto');
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

if ($scheda == 'Scheda A') 	{ ?>
  <form name='particelle_cat_form' action="#" method="post">
  <? $proprieta = $_REQUEST["proprieta"];
  $particella = $_REQUEST['particella'];
  $scheda = $_REQUEST['schedaA'];
?>


<div id='ds_center9'  class='tavole'>
<!--	<div id="ds_container17" class='tavole'>
		
 Dati catastali -->
 <div id='contorno_dati_cat' class='block'>
	<table><caption class="span"><span class='light_span'>Dati catastali</span></caption>
		<tr><td>
			<div  id='interno_dati_cat' class='block'>
			<table id='dati_catastali'><tr class='back_blue'> 
				<th width='62px'>foglio</th>
				<th width='62px'>particella</th>
				<th width='62px'>Sup. totale particella catasto</th>
				<th width='62px'>Sup. afferente particella forestale (ha)</th>
				<th width='62px'><span class='green'>di cui boscata (ha)</span></th>
				<th width='62px'>non boscata (ha)</th><th>% afferente</th>
				<th width='150px'>Note</th>
				</tr>
			<?php 
			/*foglio, particella, sup_tot_cat, sup_tot, sup_bosc, sum_sup_non_bosc, porz_perc, note*/
			foreach ($catasto as $l => $cat ) {?>		
				<tr id='tr_A_<?echo $cat->foglio."_".$cat->particella ?>' >
					<td class='border'><input type='text' name='foglio' value='<?echo $cat->foglio?>' /></td>
					<td class='border'><input type='text' name='particella_cat' value='<?echo $cat->particella?>' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sup_tot_cat' value='<?echo $cat->sup_tot_cat?>' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sup_tot' value='<?echo $cat->sup_tot?>' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sup_bosc' value='<?echo $cat->sup_bosc?>' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sum_sup_non_bosc' value='<?echo $cat->sum_sup_non_bosc?>' /></td>
					<td class='border'><input type='text' class='perc2' name='porz_perc' value='<?echo $cat->porz_perc?>' /></td>
					<td class='border'><input type='text' name='note' value='<?echo $cat->note?>' /></td> 
				<td><a href='#container15' onclick='javascript:schedeA_form5("<?echo $cat->foglio?>_<?echo "$cat->particella" ?>")'>Salva</a></td>
				<td><a class='delete_catasto' title='<?echo $cat->foglio?>' href='<?php echo "?page=descrp&schedaA=Scheda A&delete_catasto=ok&proprieta=$proprieta&particella=$particella&particella_cat=$cat->particella&foglio=$cat->foglio#container15"?>'>Elimina</a></td>
			  </tr>
			<? }  ?>
			<tr>
				<td class='border'><input type='text' name='foglio1' value='' /></td>
					<td class='border'><input type='text' name='particella_cat1' value='' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sup_tot_cat1' value='' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sup_tot1' value='' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sup_bosc1' value='' /></td>
					<td class='border'><input type='text' class='num_dec2' name='sum_sup_non_bosc1' value='' /></td>
					<td class='border'><input type='text' class='perc2' name='porz_perc1' value='' /></td>
					<td class='border'><input type='text' name='note1' value='' /></td> 
			<td colspan='2' style='text-align:center'><a href='#container15' onclick='javascript:schedeA_form4()'>Inserisci</a></td>
			</tr>
		</table>
		</div>
		</td></tr>
		
		<tr><td>
			<table id='dati_catastali_sum'><tr class='back_blue_top'>
			  <th>Totali</th>
			  <? if (isset($sum_catasto->sum_sup_tot)) echo "<td class='border'>".$sum_catasto->sum_sup_tot."</td>" ;
			  if (isset($sum_catasto->sum_sup_bosc)) echo "<td class='border'>".$sum_catasto->sum_sup_bosc."</td>"; 
			  if (isset($sum_catasto->sum_sum_n_bosco)) echo "<td class='border'>".$sum_catasto->sum_sum_n_bosco."</td>"; ?>
			</tr></table>
		<!--	</td></tr>
		</table> -->
	
	</td></tr></table>
	</div>
<!-- bho -->
		  <div class='block1010'><table width='130px'>
		      <tr><td><table width="120px"><caption>superficie (ha)</caption><tr><td  class='grey'><?if(isset($info->sup_tot)) echo $info->sup_tot; else echo "...";?></td></tr></table></td></tr>
			 <tr> <td><table width="120px"><caption>sup.boscata (ha)</caption><tr><td  class='grey'><?if(isset($info->bosc)) echo $info->bosc; else echo "...";?></td></tr></table></td></tr>
			  <tr><td><table width="120px"><caption>produttivi non<br />boscati (ha)</caption><tr><td  class='grey'><?if(isset($info->p_n_bosc)) echo $info->p_n_bosc; else echo "...";?></td></tr></table></td></tr>
			  <tr><td><table width="120px"><caption>improduttivi (ha)</caption><tr><td  class='grey'><?if(isset($info->improd)) echo $info->improd; else echo "...";?></td></tr></table></td></tr>
			  <tr class='back_blue'><th><span> N.B. per comodità di lettura sono riportati i dati</span></th></tr>
		  </table>
		  </div>
	</div>
	</div>
	<!--id="ds_container17" class='tavole'-->
    </div>
    <!-- id='ds_center9' -->


   </div>
    <!--  <div id='centra'> -->
   </div>
   <!--div id='descrp_schede'-->
   </form>
<? } ?>
<!-- ############################## fine FORM tabella CATASTO ###########################  -->

<?
if ($scheda == 'Scheda A') 	{ ?>
<!--// Attenzione!! vedere in js la funzione "formA_1()"-->

 <!-- 	insert_arborA, modify_arborA, delete_arboreeA -->
	<form name='formA4' id='formA4' action="#container15" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedaA'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedaA' value='<?echo  $scheda ?>' />
		<input type='hidden' name='foglio' value='ok' />
		<input type='hidden' name='particella_cat' value='ok' />		
		<input type='hidden' name='sup_tot_cat' value='ok' />
		<input type='hidden' name='sup_tot' value='ok' />
		<input type='hidden' name='sup_bosc' value='ok' />
		<input type='hidden' name='sum_sup_non_bosc' value='ok' />	
		<input type='hidden' name='porz_perc' value='ok' />
		<input type='hidden' name='note' value='ok' />
		<input type='hidden' name='insert_catasto' value='ok' />
	</form>

	<form name='formA5' id='formA5' action="#container15" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedaA'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedaA' value='<?echo  $scheda ?>' />
		<input type='hidden' name='foglio' value='ok' />
		<input type='hidden' name='foglio_old' value='ok' />
		<input type='hidden' name='particella_cat' value='ok' />
		<input type='hidden' name='particella_cat_old' value='ok' />
		<input type='hidden' name='sup_tot_cat' value='ok' />
		<input type='hidden' name='sup_tot' value='ok' />
		<input type='hidden' name='sup_bosc' value='ok' />
		<input type='hidden' name='sum_sup_non_bosc' value='ok' />	
		<input type='hidden' name='porz_perc' value='ok' />
		<input type='hidden' name='note' value='ok' />
		<input type='hidden' name='modify_catasto' value='ok' />
	</form>
<?php
}
?>


</div>
<?php
//  <!--div id='home' class='descrp_schede'-->
}
?>