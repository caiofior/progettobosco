<?php
if(   isset($_REQUEST['schedB2']) ) 	{

// 	inserisco controlli e azioni relativi alla scheda_b
 	include('descrp_schedeB2_actions.php') ;

	//assegnazione della variabili del form precedente
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
	//inizializzazione variabili
	$infoB = null ; // relative a tabella schede_b
	$infoB2 = null ; // relative a tabella schede_b2
	$cod_fo = ' 1'; //metto io forzatamente cod_fo =(spazio)1, perchè è rimasto da cose vecchie !!!!!!!!!!!!!!!!!!!!
 //###### genero l'array vuoto contenente tutti i campi della tabella schede_b e  sched_b2 che mi servono
	$arr = generate_Arr('sched_b2'); 	//##
	$b =   generate_Arr('schede_b');	//##
//###############################

//---------------------------- Modifica/Inserimento dati---------------------------------------------

  //se si vuole modificare o inserire i dati di una particella si fanno eseguire l'UPDATE o l'INSERT nella tabella SCHEDE_B con la funzione saveInfoDescrpB($info, $proprieta, $particella) 
	if( isset($_REQUEST['inserisci_dati']) or isset($_REQUEST['modifica_dati'])) {
	      $b = fill_Arr($b, $proprieta,$particella, $cod_fo );
	      $arr = fill_Arr($arr, $proprieta,$particella, $cod_fo );
	      	 saveInfoDescrp($b, $proprieta, $particella, 'schede_b');
	      	 saveInfoDescrp($arr, $proprieta, $particella, 'sched_b2');
	      	redirect("?page=descrp&schedB2=Scheda B2&particella=$particella&proprieta=$proprieta");
	}
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
	if( isset($_REQUEST['delete']) ) {
	      $b = fill_Arr_dellB($b, $proprieta,$particella, $cod_fo );	
		saveInfoDescrp($b, $proprieta, $particella, 'schede_b');

		list( $res , $id ) = cancellaPart($proprieta, $particella, 'sched_b2') ;
		
		if( $res ) 	{die('Tornare a Descrizione Particellare');}
		else 		echo "errore" ;
	}
// --------------------------------------------------------------------------------------
	//verifica se sono già stati inseriti i dati della Scheda B2, dopo aver creato per la Scheda A (ma sono noti solo $proprietà e $particella)
	$temp_var = esisteProprietaEParticella('sched_b2', $proprieta, $particella);
// echo "stampo temp_var ";print_r($temp_var);
	if( empty($temp_var)) { //caso in cui si debba riempire tabelle schede_b e sched_b2
// echo "non esiste particella, la devo inserire";
		$arr['proprieta'] = $proprieta ;
		$arr['particella'] = $particella ;
 		$arr['cod_fo'] = $cod_fo ;
		$b['proprieta'] = $proprieta ;
		$b['particella'] = $particella ;
 		$b['cod_fo'] = $cod_fo ;
		$infoB = array_to_object($b) ;
		$infoB2 = array_to_object($arr) ;
	} else 	{  // caso in cui si debba solo interrogare il database perchè i dati sono già stati inseriti
		$infoB = getInfoScheda( $proprieta , $particella , 'schede_b');
 		$infoB2 = getInfoScheda($proprieta, $particella , 'sched_b2');
	}

//echo "numero variabili sched_b2 = 69 - 1 (objectid), numero variabili usate ".count($arr)." fine.  ";

//-----------------------------Select per costruzione pagina-----------------------------------------
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di SCHEDE_A 
	$regione = getDiz_regioniCod($proprieta);
	$boschi = getCodiciBoschiCodice( $proprieta );
	$propriet = getInfoPropriet( $proprieta);
	$cod_proprieta = getCod_descrizion('propriet') ;

	$tipo = getCod_descrizion('tipo_imp');
	$comp_spe = getCod_descrizion('compo');
	$sesto = getCod_descriz('sesto');
	$colt_cast = getCod_descriz('coltcast');
	$vigs= getCod_descriz('vig_arb_cas');
	$struttura = getCod_descriz_struttu('struttu', $regione->codice) ;
	$origine = getCod_descriz('origine');
	$vigoria = getCod_descriz('vigoria'); 
	$fito_sug = getCod_descriz('fito_sug'); 
	$strati = getCod_descriz('strati');
	$tipo_int_sug = getCod_descrizion('tipo_int_sug');
	$prescriz = getCod_descriz('prescri2') ;
	$urgenza = getCod_descriz('urgenza') ;
	$pres_ass = getPresAss(); 
	$densita = getCod_descriz ('densita');
	$novell = getCod_descriz ('novell');
	$car_nove = getCod_descriz ('car_nove');
	$rinnov = getCod_descriz ('rinnov');
	$diz_arbo1 = getCod_nome('diz_arbo') ;
	$tipologia = getCod_descriz_regione('diz_tipi',$regione->codice ) ;
	$diz_fung = getDizFung();

// ############################### formB2_2 e 3 ############################################################## 

 $arr_arbo['cod_coltu']=""; $arr_arbo['cod_coper']=""; $arr_arbo['cod_coltu_old']=""; $arr_arbo['ordine_inser']="";
 $arr_arbo['id_av']="";
	 $arr = fill_Arr($arr_arbo, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arborB2']) or isset($_REQUEST['modify_arborB2']) ) {
		$info_arbo = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbo('arboree2', $info_arbo, $proprieta, $particella) ;
		redirect("?page=descrp&schedB2=Scheda B2&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBOREE si fanno le SELECT dalla tabella
	$arboree = getInfoArboree('arboree2', $proprieta , $particella, $cod_fo );
	$per_arbo = getCod_descriz ('per_arbo') ;
	$diz_arbo = getDizArbo();

// ################################ formB2_4 e 5 #############################################################

 $arr_arbu['cod_coltu']=""; $arr_arbu['cod_coltu_old']="";$arr_arbu['id_av']="";

	$arr = fill_Arr($arr_arbu, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arbuB2']) or isset($_REQUEST['modify_arbuB2']) ) {
		$info_arbu = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbu('arbusti2', $info_arbu, $proprieta, $particella) ;
		redirect("?page=descrp&schedB2=Scheda B2&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$arbusti = getInfoArbusti('arbusti2', $proprieta , $particella, $cod_fo );
// 	$diz_arbo = getDizArbo(); usata questa funzione anche per gli arbusti, perchè hanno la stessa tabella degli alberi
// #############################################################################################

// ################################ formB2_6 e 7 #############################################################
 $arr_erba['cod_coltu']=""; $arr_erba['cod_coltu_old']="";$arr_erba['id_av']="";
	$arr = fill_Arr($arr_erba, $proprieta, $particella, $cod_fo );
		if( isset($_REQUEST['insert_erbaB2']) or isset($_REQUEST['modify_erbaB2']) ) {
		$info_erba = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_erba('erbacee2', $info_erba, $proprieta, $particella) ;
		redirect("?page=descrp&schedB2=Scheda B2&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$erbacee = getInfoErbacee('erbacee2', $proprieta , $particella, $cod_fo );
	$diz_erba = getDizErba();
// #############################################################################################


// ############################### form per note singole voci ############################################################## 

 $arr_note['cod_nota']=""; $arr_note['cod_nota_old']=""; $arr_note['nota']="";

	if( isset($_REQUEST['insert_noteB2']) or isset($_REQUEST['modify_noteB2']) ) {
	      foreach( array_keys($arr_note) as $key ) {
			$val = ( isset($_REQUEST[$key]) )? $_REQUEST[$key] : null ;
			$arr_note[$key] = $val ;
	      }
	      $info_note = array_to_object($arr_note) ;// trasformazione da array in oggetto
	      saveInfoDescrp_note($info_note, $proprieta, $particella, 'note_b2') ;
	      redirect("?page=descrp&schedB2=Scheda B2&particella=$particella&proprieta=$proprieta");
	}

 //se si vuole semplicemente interrogare la tabella NOTE_A si fanno le SELECT con le funzioni getInfoSchedaA_note(.., ..) dalla tabella
	$info_note = getInfoScheda_note ($proprieta, $particella, 'note_b2');
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di note_A 
	$note_tutte= getInfoSchedaNoteTutte ('schede_b');
	$note_tutte_dif= getInfoSchedaNoteTutte_dif ('schede_b', 'note_b2');

// #############################################################################################
// ------------------------------------------------------------
?>

<div id='home' class='descrp_schede schedeB2'>
	<form name="descrp_schedeB2_form" action="#" method="post">
	<input type='hidden' name='schedB2' value='ok' />
		<div id='descrp_schede'>
		    <div id="centra">

			<div id='descrp_schede_top'>  

				<div id='b_title_descrp' class="white"><span>Regione
				    <?php  if (isset($_REQUEST['proprieta']) and $_REQUEST['proprieta'] != 'bosco...') echo $regione->descriz ;
					    else echo "...";  ?></span>
					    <br /><span>Sistema informativo per l'assestamento forestale</span>
				</div> <!--//DIV: b_title_reg-->
<!-- Bottone modifica o inserisci  -->
				<div  class='bottone_alto'>
				      <?  echo "<div class='mod_ins'>";
					  if( empty($temp_var))
					  // se la ho già inserito la SCHEDA_B2 allora tasto Modifica, altrimenti tasto Inserisci
						  echo "<input class='bot_descrp' title='Inserisci dati di $propriet->descrizion particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>";
					  else	{ echo "<input class='bot_descrp' title='Modifica dati di $propriet->descrizion particella $particella' type='submit' name='modifica_dati' value='Salva modifiche' /></div>";
					//ancora per query DELITE e che mi rimanda alla pagina descrp_schedeA.php
						  echo "<div id='cancella'><a class='bot_descrp' class='actions cancella' title='proprietà di $propriet->descrizion e particella $particella' href='?page=descrp&schedB2=ok&delete=ok&proprieta=$proprieta&particella=$particella'>Elimina dati</a></div>";}?>
				</div>
<!-- Bosco  -->
				<div id='ds_top_top' class='daticat'>
				      <div class='block10'><table width='400px' class="row"><caption>Bosco</caption>
				      <tr><td><?php echo " (".$boschi->codice.") ".$boschi->descrizion  ?></td></tr></table></div>
				      <input type='hidden' name='proprieta' value ='<?php echo $proprieta; ?>' />

				</div> <!--id='ds_top_top' class='daticat'-->
			</div>
<!-- 			 id='descrp_schede_top'>   -->


<?php
//------------------------------------------------------------ Scheda B2 -------------------------------------------------
if ($scheda == 'Scheda B2')  {  ?>

	<div id='ds_center1_B2' >
		<div id="ds_container1_B2" class='tavole'>
		      <div id='ds_title_B2' class='block'>Scheda B2 per la descrizione di una<br />FORMAZIONE ARBOREA SPECIALIZZATA PER PRODUZIONI NON LEGNOSE <br />OD IMPIANTI PER L'ARBORICOLTURA DEL LEGNO </div>
<!--Particella/Sottoparticella-->
		      <div class='block1010'><table width='200px'><caption>Particella/Sottoparticella</caption>
		      <tr><td><?php echo $particella ?></td></tr></table></div>
		      <input type='hidden' name='particella' value ='<?php echo $particella; ?>' />
		</div> <!--id="ds_container" class='tavole'-->

		<div id="ds_container2_B2" class='tavole'>
<!--Tipo-->
			<div class='block spazio'><table width="500px" class="row"><caption class="span"><span>Tipo</span></caption>
				<tr><td><input type='radio' id='opt10' name='u' value='10' 
					<? if ($infoB->u == '10')  { $infoB2->u = '10'; echo "checked";} ?> />
				</td><th>Arboricoltura specializzata da legno</th>
				<td><input type='radio' id='opt2' name='u' value='2'
					<? if ($infoB->u == '2')    { $infoB2->u = '2'; echo "checked";} ?> />
				    </td><th>Castagneti da frutto</th>
				<td><input type='radio' id='opt11' name='u' value='11'
				    <? if ($infoB->u == '11')   { $infoB2->u = '11';  echo "checked";} ?> />
				    </td><th>Impianti specializzati per la tartuficoltura</th>
				<td><input type='radio' id='opt12' name='u' value='12'
				    <? if ($infoB->u == '12')    { $infoB2->u = '12'; echo "checked";} ?> />
				    </td><th>Sugherete</th>
				</tr></table>
			</div> 
<!--Tipo forestale-->
			<div class='block spazio'><table width='300px' class="row"><caption>Tipo forestale</caption><tr><td>	
				<? 
if (!isset($tipologia)) echo "Table diz_tipi: codice $regione->codice ($regione->descriz) assente'";
 else{ 				echo "<select name='t'>";
					echo "<option value='' selected='selected'></option>";
					foreach( $tipologia as $tip ) {
						$selected = ( isset($infoB->t) and $infoB->t == $tip->codice )? 'selected' : ' ' ;
						echo "<option value='$tip->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$tip->codice | $tip->descriz</option>\n";}
				echo "</select>";/*echo "<input type='text' name='t' value='$infoB->t' />\n ";*/ 	}?>
				</td></tr></table>
 				 
			</div>
		</div> 
		<!--id="ds_container2_B2" class='tavole'-->
	</div>
	<!-- id='ds_center1_B2' -->

<!-- ####################### Arboricoltura ########################  -->
	<div id="opt10_fields">
	<div id='ds_center2_B2'  class='tavole'>
		<div class="riga_schedeB2"><p></p></div>
		<div id="ds_container3_B2" class='tavole'>
			<div id='bianco200' class='block1010'><p>Arboricoltura specializzata da legno</p></div>
<!-- Tipo di impianto -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>Tipo d'impianto</span></caption>
				<tr><?foreach ($tipo As $tip){
					echo "<td><input type='radio' class='radio_dis' name='tipo' value='$tip->codice'"; if ($infoB2->tipo == $tip->codice): echo "checked"; endif; echo "/></td><td>".$tip->descrizion."</td>\n";
				} ?></tr></table>
			</div>
<!-- Anno di impianto -->
			<div class='block10'><table width='150px' class="row"><caption>Anno d'impianto</caption> 
				<tr><td><input type="text"  class='anno' name="anno_imp" value='<? echo $infoB2->anno_imp ?>' /></td></tr></table>
			</div>
<!-- Anno possibile cambio destinazione -->
			<div class='block10'><table width='150px' class="row"><caption>Anno di possibile cambio di destinazione</caption> 
				<tr><td><input type="text" class='anno' name="anno_dest" value='<? echo $infoB2->anno_dest ?>' /></td></tr></table>
			</div>
		</div> 
		<!--ds_container3_B2-->

		<div id="ds_container4_B2" class='tavole'>
<!-- Composizione specifica -->
			<div class='block10'><table width='300px' class="row"><caption class="span"><span>Composizione specifica</span></caption>
				<tr><?foreach ($comp_spe As $comp){
					echo "<td><input type='radio' class='radio_dis' name='comp_spe' value='$comp->codice'"; if ($infoB2->comp_spe == $comp->codice): echo "checked"; endif; echo "/></td><td>".$comp->descrizion."</td>\n";
				} ?></tr></table>
			</div>
<!-- Specie principale componente arborea -->
			<div class='block10'><table width='300px' class="row"><caption>Specie principale componente arborea</caption> 
				<tr><td>
					<select name='cod_coltup'>
					<option value='-1' >...</option>
	  <?					foreach( $diz_arbo as $d ){
							  $selected1 =($d->cod_coltu == $infoB2->cod_coltup)? 'selected' : ''; 
							  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali  |  ($d->nome_scien)</option>\n";
						  } ?>
					</select>
				</td></tr></table>
			</div>
<!-- Specie secondaria componente arborea -->
			<div class='block10'><table width='300px' class="row"><caption>Specie secondaria componente arborea</caption> 
				<tr><td>
					<select name='cod_coltus'>
					<option value='-1' >...</option>
	  <?					foreach( $diz_arbo as $d ){
							  $selected1 =($d->cod_coltu == $infoB2->cod_coltus)? 'selected' : ''; 
							  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali | ($d->nome_scien)</option>\n";
						  } ?>
					</select>
				</td></tr></table>
			</div>
		</div> 
		<!--ds_container4_B2-->

		<div id="ds_container5_B2" class='tavole'>
<!-- Distanza tra le piante -->
			<div class='block10'><table width='150px' class="row"><caption>Distanza tra le piante</caption> 
				<tr><td><input type="text" class='num_dec1' name="dist" value='<? echo $infoB2->dist ?>' /></td></tr></table>
			</div>
<!-- Distanza tra le piante della specie principale -->
			<div class='block10'><table width='150px' class="row"><caption>Distanza tra le piante della specie principale</caption> 
				<tr><td><input type="text" class='num_dec1' name="dist_princ" value='<? echo $infoB2->dist_princ ?>' /></td></tr></table>
			</div>
<!-- Sesto d'impianto -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>Sesto d'impianto</span></caption>
				<tr><?foreach ($sesto As $ses){
					echo "<td><input type='radio' class='radio_dis' name='sesto_imp_arb' value='$ses->codice'"; if ($infoB2->sesto_imp_arb == $ses->codice): echo "checked"; endif; echo "/></td><td>".$ses->descriz."</td>\n";
				} ?></tr></table>
			</div>
<!-- Sesto d'impianto della specie principale-->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>Sesto d'impianto della specie principale</span></caption>
				<tr><?foreach ($sesto As $ses){
					echo "<td><input type='radio' class='radio_dis' name='sesto_princ' value='$ses->codice'"; if ($infoB2->sesto_princ == $ses->codice): echo "checked"; endif; echo "/></td><td>".$ses->descriz."</td>\n";
				} ?></tr></table>
			</div>
		</div> 
		<!--ds_container5_B2-->

		<div id="ds_container6_B2" class='tavole'>
<!-- Vigoria specie principale -->
			<div class='block10'><table width='300px' class="row"><caption class="span"><span>Vigoria specie principale</span></caption><tr>
				<?foreach ($vigs As $vig){
					echo "<td><input type='radio' class='radio_dis' name='vig_arb_princ' value='$vig->codice'"; if ($infoB2->vig_arb_princ == $vig->codice): echo "checked"; endif; echo "/></td><td>".$vig->descriz."</td>\n";
				} ?>
				</tr></table>
			</div>
<!-- Vigoria specie secondaria-->
			<div class='block10'><table width='300px' class="row"><caption class="span"><span>Vigoria specie secondaria</span></caption><tr>
				<?foreach ($vigs As $vig){
					echo "<td><input type='radio' class='radio_dis' name='vig_arb_sec' value='$vig->codice'"; if ($infoB2->vig_arb_sec == $vig->codice): echo "checked"; endif; echo "/></td><td>".$vig->descriz."</td>\n";
				} ?>
				</tr></table>
			</div>
<!-- Fallanza -->
			<div class='block10'><table width='100px' class="row"><caption>Fallanza (%)</caption> 
				<tr><td><input type="text" class="perc" name="dist" value='<? echo $infoB2->fall ?>' /></td></tr></table>
			</div>
<!-- Qualità fusto specie principale-->
			<div class='block10'><table width='300px' class="row"><caption class="span"><span>Qualità fusto specie principale</span></caption><tr>
				<td><input type='radio' class='radio_dis' name='qual_pri' value='1' <?if ($infoB2->qual_pri == 1): echo "checked"; endif; ?>/></td><td>mediocre</td>
				<td><input type='radio' class='radio_dis' name='qual_pri' value='2' <?if ($infoB2->qual_pri == 2): echo "checked"; endif; ?>/></td><td>buona</td>
				<td><input type='radio' class='radio_dis' name='qual_pri' value='3' <?if ($infoB2->qual_pri == 3): echo "checked"; endif; ?>/></td><td>ottima</td>
				</tr></table>
			</div>
		</div> 
		<!--ds_container6_B2-->
	</div>
	<!-- id='ds_center2_B2' -->
	</div><!-- id="opt10_fields"-->

<!-- ####################### Castagneto da frutto ########################  -->
	<div id="opt2_fields">
	<div id='ds_center3_B2'  class='tavole'>
		<div class="riga_schedeB2"><p></p></div>
		<div id="ds_container7_B2" class='tavole'>
			<div id='bianco200' class='block1010'><p>Castagneto da frutto</p></div>
<!--Stato-->
			<div class='block10'><table width='550px' class="row"><caption class="span"><span>Stato</span></caption>
				<tr><?foreach ($colt_cast As $cc){
					echo "<td><input type='radio' class='radio_dis' name='colt_cast' value='$cc->codice'"; if ($infoB2->colt_cast == $cc->codice): echo "checked"; endif; echo "/></td><td>".$cc->descriz."</td>\n";
				} ?></tr></table>
			</div>
<!-- Vigoria -->
			<div class='block10'><table width='250px' class="row"><caption class="span"><span>Vigoria</span></caption><tr>
				<?foreach ($vigs As $vig){
					echo "<td><input type='radio' class='radio_dis' name='vig_cast' value='$vig->codice'"; if ($infoB2->vig_cast == $vig->codice): echo "checked"; endif; echo "/></td><td>".$vig->descriz."</td>\n";
				} ?>
				</tr></table>
			</div>
<!-- Sesto d'impianto (castagno)-->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>Sesto d'impianto</span></caption>
				<tr><?foreach ($sesto As $ses){
					echo "<td><input type='radio' class='radio_dis' name='sesto_imp_cast' value='$ses->codice'"; if ($infoB2->sesto_imp_cast == $ses->codice): echo "checked"; endif; echo "/></td><td>".$ses->descriz."</td>\n";
				} ?></tr></table>
			</div>

		</div> 
		<!--ds_container7_B2-->
	</div>
	<!-- id='ds_center3_B2' -->
	</div><!-- id="opt2_fields"-->
<!-- ####################### Impianti speciali per la tartuficoltura ########################  -->
	<div id="opt11_fields">
	<div id='ds_center4_B2'  class='tavole'>
		<div class="riga_schedeB2"><p></p></div>
		<div id="ds_container8_B2" class='tavole'>
			<div id='bianco200' class='block1010'><p>Impianti speciali per la tartuficoltura</p></div>
<!-- Specie simbronte -->
			<div class='block10'><table width='350px' class="row"><caption>Specie simbronte</caption> 
					<tr><td><select name='cod_coltub'>
					<option value='-1' >...</option>
	  <?					foreach( $diz_arbo as $d ){
							  $selected1 =($d->cod_coltu == $infoB2->cod_coltub)? 'selected' : ''; 
							  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali | ($d->nome_scien)</option>\n";
						  } ?>
					</select></td></tr>
			</table></div>
<!-- Specie forestale accessoria -->
			<div class='block10'><table width='350px' class="row"><caption>Specie forestale accessoria</caption> 
					<tr><td><select name='cod_coltua'>
					<option value='-1' >...</option>
	  <?					foreach( $diz_arbo as $d ){
							  $selected1 =($d->cod_coltu == $infoB2->cod_coltua)? 'selected' : ''; 
							  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali | ($d->nome_scien)</option>\n";
						  } ?>
					</select></td></tr>
			</table></div>
<!-- Fungo ospite -->
			<div class='block10'><table width='350px' class="row"><caption>Fungo ospite</caption> 
					<tr><td><select name='fungo_ospi'>
					<option value='-1' >...</option>
	  <?					foreach( $diz_fung as $d ){
							  $selected1 =($d->cod_coltu == $infoB2->fungo_ospi)? 'selected' : ''; 
							  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome</option>\n";
						  } ?>
					</select></td></tr>
			</table></div>
		</div> 
		<!--ds_container8_B2-->
		<div id="ds_container9_B2" class='tavole'>
<!-- Sesto d'impianto (tartufaia)-->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>Sesto d'impianto</span></caption>
				<tr><?foreach ($sesto As $ses){
					echo "<td><input type='radio' class='radio_dis' name='sesto_imp_tart' value='$ses->codice'"; if ($infoB2->sesto_imp_tart == $ses->codice): echo "checked"; endif; echo "/></td><td>".$ses->descriz."</td>\n";
				} ?></tr></table>
			</div>
<!-- N° totale piante (n/ha)-->
			<div class='block10'><table width='170px' class="row"><caption>N° totale piante (n/ha)</caption> 
				<tr><td><input type="text" class="num" name="num_piante" value='<? echo $infoB2->num_piante ?>' /></td></tr></table>
			</div>
<!-- Piante tartufigene (n/ha)-->
			<div class='block10'><table width='170px' class="row"><caption>Piante tartufigene (n/ha)</caption> 
				<tr><td><input type="text" class="num" name="piant_tart" value='<? echo $infoB2->piant_tart ?>' /></td></tr></table>
			</div>
		</div> 
		<!--ds_container9_B2-->
	</div>
	<!-- id='ds_center4_B2' -->
	</div><!-- id="opt11_fields"-->
<!-- ############# Sugheraia #################  -->
	<div id="opt12_fields">
	<div id='ds_center5_B2'  class='tavole'>
		<div id='container5' class="riga_schedeB2"><p></p></div>
		<div id="ds_container10_B2" class='tavole'> 
			<div id='bianco200' class='block1010'><p>Sugheraia</p></div>
<!-- Struttura -->
			<div class='block'><table width='300px' class="row"><caption>Struttura</caption> 
				<tr><td><? echo "<select name='s'>";
					echo "<option value='-1' selected='selected'></option>\n";
					foreach( $struttura as $str ) {
						$selected = ( isset($infoB2->s) and  $infoB2->s == $str->codice)? 'selected' : ' ' ;
						echo "<option value='$str->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$str->codice | $str->descriz</option>\n";}
				echo "</select>";?>
				</td></tr></table>
			</div>

<!-- composizione strato arboreo  -->
		    <a name='container5_B2'> </a> 
		    <div id='arboree_cont' class='block'><table class='row'><caption class="span"><span>Composizione strato arboreo</span></caption>
		      <tr><td>
		      	<div id='arboree_int' class='block'><table id='arboree'>
		      		      
			      <tr class='center'><td><b>Specie</b></td><td><b>Copertura</b></td><td width='50px'><b>Ordine</b></td></tr>
			      <?php
			      foreach ($arboree AS $arbo){?>
				      <tr id='tr_3_<?echo $arbo->cod_coltu ?>'>
					  <td><select name='cod_coltu_arbo'>
						  <option value='-2' >...</option>
		 					 <?foreach( $diz_arbo as $d ){
								  $selected1 =($d->cod_coltu == $arbo->cod_coltu)? 'selected' : ''; 
								  if ($selected1!='') $nome= $d->nome_itali; 
								  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
							  } ?>
					  </select></td>
					  <td><select name='cod_coper_arbo'>
						  <option value='-2' >...</option>
		 					 <?foreach( $per_arbo as $p ){
								  $selected1 =($p->codice == $arbo->cod_coper)? 'selected' : ''; 
								  echo "<option value='$p->codice' $selected1 >$p->descriz</option>\n";
							  } ?>
					  </select></td>
					  <td><input type='text' name='ordine_inser_arbo' value='<?echo $arbo->ordine_inser?>' /></td>
					  <td><a href='#container5' onclick='javascript:schedeB2_form3("<?echo $arbo->cod_coltu ?>")'>Salva</a></td>
					  <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB2=Scheda B2&delete_arboreeB2=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container5"?>'>Elimina</a></td>
				      </tr>
	      		<?} ?>
			      <tr>
				  <td><select name='cod_coltu_arbo1'>
					  <option value='-1' > ...</option>
		 			  <?foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
				  </select></td>
				  <td><select name='cod_coper_arbo1'>
					  <option value='-1' > ...</option>
		  			 <?foreach( $per_arbo as $p ) echo "<option value='$p->codice'>$p->descriz</option>\n";?>
				  </select></td>
				  <td><input type='text' name='ordine_inser_arbo1' value='' /></td>
				  <td colspan='2' style='text-align:center'><a href='#' onclick='javascript:schedeB2_form2()'>Inserisci</a></td>
			      </tr>
		      	</table></div> <!-- <div id='arboree_int' class='block'><table id='arboree'> -->
		      		
		      </td></tr>
		    </table></div> 
  <!-- Origine -->
		    <div class='block'><table  class='row' width='350px'><caption class='span'><span> <? echo strtoupper('origine')?></span></caption><tr>
			    <?php foreach ( $origine as $k => $o ) {
				echo "<td><input type='radio' class='radio_dis' name='o' value='$o->codice'"; if($infoB2->o == $o->codice ): echo " checked"; endif; 
				echo " /></td><th>$o->descriz</th>\n"; }  ?>
		      </tr></table></div>  
<!-- Vigoria  -->
		    <div class='block10'><table  class='row' width='350px'><caption class="span"><span>Vigoria</span></caption>
			    <tr><?php foreach ( $vigoria as $k => $vig ) {
				echo "<td><input type='radio' class='radio_dis' name='vig' value='$vig->codice'"; if($infoB2->vig == $vig->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($vig->descriz)."</th>\n"; }?>
		    </tr></table></div>

<!-- stato fitosanitario  -->
		    <div class='block10'><table  class='row' width='230px'><caption class="span"><span>Stato fitosanitario</span></caption>
			    <tr><?php foreach ( $fito_sug as $k => $fit ) {
				echo "<td><input type='radio' class='radio_dis' name='fito_sug' value='$fit->codice'"; if($infoB2->fito_sug == $fit->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($fit->descriz)."</th>\n"; } ?>
		      </tr></table></div> 
<!--agenti biotici-->
		  <div  id="ds_container10_1_B2" class='tavole'>
			<div class='block1010'><table class="row">
				<tr><td><input type='checkbox' name='fito_bio' value='t' <?if ($infoB2->fito_bio == 't'): echo "checked"; endif; ?> /></td><th>Agenti biotici</th></tr></table>
			</div> 
			<!-- specifiche-->
			<div class='block10'><table width='150px' class="row"><caption>Specifiche</caption> 
				<tr><td><input type="text" name="fito_bio_spec" value='<? echo $infoB2->fito_bio_spec ?>' /></td></tr></table>
			</div>

		   </div> <!--id="ds_container10_1_B2" -->

<!--agenti abiotici-->
		  <div  id="ds_container10_2_B2" class='tavole'>
			<div class='block1010'><table class="row">
				<tr><td><input type='checkbox' name='fito_abio' value='t' <?if ($infoB2->fito_abio == 't'): echo "checked"; endif; ?> /></td><th>Agenti abiotici</th></tr></table>
			</div> 
			<!-- specifiche-->
			<div class='block10'><table width='150px' class="row"><caption>Specifiche</caption> 
				<tr><td><input type="text" name="fito_abio_spec" value='<? echo $infoB2->fito_abio_spec ?>' /></td></tr></table>
			</div>
		   </div> <!--id="ds_container10_1_B2" -->
<!-- Vuoti-lacune  -->
		     <div class='block10'><table  class='row'><caption class='span'><span>vuoti-lacune</span></caption><tr>
			<?  foreach ( $pres_ass AS $k => $ps ) {
				$k = $k + 1;
				echo "<td><input type='radio' class='radio_dis' name='v' value='$ps->codice'"; if($infoB2->v == $ps->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($ps->valore)."</th>\n"; }  ?>
		      </tr></table> 
		      </div>  
<!-- Densità  -->
		     <div class='block10'><table width='260px' class='row'><caption class='span'><span>Densità</span></caption><tr>
			  <?php foreach ( $densita AS $k => $d ) {
				if ($k != 1){
				echo "<td><input type='radio' class='radio_dis' name='d' value='$d->codice'"; if($infoB2->d == $d->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($d->descriz)."</th>\n";} }  ?>
		      </tr></table>
		      </div> 
		      
<!-- novellame  -->
		     <div class='block'><table class='row'><caption class='span'><span>NOVELLAME</span></caption><tr>
			   <?php foreach ( $novell AS $k => $n1 ) {
				echo "<td><input type='radio' class='radio_dis' name='n1' value='$n1->codice'"; if($infoB2->n1 == $n1->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n1->descriz)."</th>\n"; }  ?>
		      </tr></table></div>
		      <div class='block pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div>
		     <div class='block'><table  class='row'><caption class='vuoto'><span></span></caption><tr>
			   <? foreach ( $car_nove AS $k => $n2 ) {
				echo "<td><input type='radio' class='radio_dis' name='n2' value='$n2->codice'"; if($infoB2->n2 == $n2->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n2->descriz)."</th>\n"; }  ?>
		      </tr></table></div>  
 <!-- rinnovazione  -->
		     <div class='block'><table class='row'><caption class='span'><span>RINNOVAZIONE</span></caption><tr>
			   <? foreach ( $rinnov AS $k => $n3 ) {
				echo "<td><input type='radio' class='radio_dis' name='n3' value='$n3->codice'"; if($infoB2->n3 == $n3->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n3->descriz)."</th>\n"; }  ?>
		      </tr></table></div>
		     <div class='block pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div>
<!-- Specie prevalente rinnovazione  -->
		     <div class='block'><table  class='row'><caption>Specie prevalente rinnovazione</caption><tr>
				<td width='200px'><select name='spe_nov'> 
				<option value='-1' selected='selected'></option>
				<? foreach( $diz_arbo1 as $diz ) {
					  $selected = ( isset($infoB2->spe_nov) and $diz->cod_coltu == $infoB2->spe_nov )? 'selected' : '' ;
					  echo "<option value='$diz->cod_coltu' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$diz->cod_coltu | $diz->nome_itali</option>\n";
					}?>
				</select></td>
		      </tr></table></div>  
<!-- Categorie intervento per sugherete -->
			<div class='block'><table width='560px' class="row"><caption>Categorie intervento per sugherete</caption> 
				<tr><td><? echo "<select name='tipo_int_sug'>";
					echo "<option value='' selected='selected'></option>\n";
					foreach( $tipo_int_sug as $str ) {
						$selected = ( isset($infoB2->s) and  $infoB2->tipo_int_sug == $str->codice)? 'selected' : '' ;
						echo "<option value='$str->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$str->codice | $str->descrizion</option>\n";}
				echo "</select>";?>
				</td></tr></table>
			</div>
<!-- Interventi recenti  -->
		      <div class='block10'><table  class='row'><caption>Interventi recenti</caption><tr>
			<td width='250px'><select name='int2'> 
				<option value='-1' selected='selected'></option>
				<? foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB2->int2) and $pre->codice == $infoB2->int2 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n"; } ?>
			</select></td>
			</tr></table></div>
			<div class='block10'><table class='row'><caption>Specifiche</caption><tr>
			  <td width='120px'><input type='text' name='int3' value='<? echo $infoB2->int3 ?>' /></td>
			</tr></table></div>
<!--// Anno estrazione sughero-->
			<div class='block'><table class='row'><caption>Anno estraz. sugh.</caption><tr>
			  <td width='120px'><input type='text' class='anno' name='estraz_passata' value='<? echo $infoB2->estraz_passata?>' /></td> 
			</tr></table></div>
<!--Dati per orientamento dendrometrico-->
			<div  id="ds_container12_B2" class='tavole' class='block'><table class='row'><caption class='span'><span>Dati di orientamento dendrometrico</span></caption><tr><td>
				<div class='block10'><table class='row'><caption>n° alberi/ha</caption><tr>
				<td width='80px'><input type='text' class='num' name='d5' value='<?$infoB2->d5?>' /></td>
				</tr></table></div>
				<div class='block10'><table class='row'><caption>n° alberi produt./ha</caption><tr>
				<td width='120px'><input type='text' class='num' name='d10' value='<?$infoB2->d10?>' /></td>
				</tr></table></div>
				<div class='block10'><table class='row'><caption>n° polloni/ha</caption><tr>
				<td width='80px'><input type='text' class='num' name='d11' value='<?$infoB2->d11?>' /></td>
				</tr></table></div>
				<div class='block10'><table class='row'><caption>n° monocauli/ha</caption><tr>
				<td width='90px'><input type='text' class='num' name='d12' value='<?$infoB2->d12?>' /></td>
				</tr></table></div>
				<div class='block10'><table class='row'><caption>Diametro preval. (cm)</caption><tr>
				<td width='120px'><input type='text' class='num' name='d1' value='<?$infoB2->d1?>' /></td>
				</tr></table></div>
				<div class='block1010'><table  class='row'><caption>Altezza preval. (m)</caption><tr>
				<td width='120px'><input type='text' class='num' name='d3' value='<?$infoB2->d3?>' /></td>
				</tr></table></div>
				<div class='block1010'><table  class='row'><caption>Produzione media (q)</caption><tr>
				<td width='130px'><input type='text' class='num_dec1' name='d13' value='<?$infoB2->d13?>' /></td>
				</tr></table></div>
 			</td></tr></table>
			</div><!--id="ds_containe12_B2" class='tavole'-->
		</div>
		<!--ds_container10_B2-->
<!-- ##############################  -->
		<div id="ds_container11_B2" class='tavole'>
<!-- età prevalente accertata-->
			<div class='block10'><table width='180px' class="row"><caption>Età prevalente accertata</caption> 
				<tr><td><input type="text" class="num" name="c1" value='<? echo $infoB2->c1?>' /></td></tr></table>
			</div>
<!-- Copertura (%)-->
			<div class='block10'><table width='180px' class="row"><caption>Copertura (%)</caption> 
				<tr><td><input type="text" class="perc" name="ce" value='<? echo $infoB2->ce?>' /></td></tr></table>
			</div>
<!--Strato arbustivo-->
			<div class='block10'><table width='120px' class="row"><caption class="span"><span>Strato arbustivo</span></caption>
				<?foreach ($strati As $st){
					echo "<tr><td><input type='radio' class='radio_dis' name='sr' value='$st->codice'"; if ($infoB2->sr == $st->codice): echo "checked"; endif; echo "/></td><th>".$st->descriz."</th></tr>\n";
				} echo "</tr>"; ?>
			</table></div>
 <!-- specie significative strato arbustivo  -->
<!-- 	insert_arbuB2, modify_arbuB2, delete_arbuB2 -->
		      <div id='arbustive_cont' class='block1010'>
		      <table class='row'><caption class="span"><span>Specie arbustive significative</span></caption>
		      <tr><td>
		      	<div id='arbustive_int' class='block'>
		      	<table id='arbusti'>
			      <tr><td><b>Specie</b></td></tr>
	<?php			foreach ($arbusti AS $arbu){?>
				    <tr id='tr_5_<?echo $arbu->cod_coltu ?>'>
				      <td><select name='cod_coltu_arbu' onChange='javascript:schedeB2_form5("<?echo $arbu->cod_coltu?>" )'>
					<option value='-2' >...</option>
	  <?				foreach( $diz_arbo as $d ){
							$selected1 =($d->cod_coltu == $arbu->cod_coltu)? 'selected' : ''; 
							if ($selected1!='') $nome= $d->nome_itali; 
							echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
					    } ?>
				      </select></td>
	<!-- 			      <td><a href='#' onclick='javascript:schedeB2_form5("<?//echo $arbu->cod_coltu ?>")'>Salva</a></td> -->
				      <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB2=Scheda B2&delete_arbuB2=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbu->cod_coltu#container5"?>'>Elimina</a></td>
				    </tr>
	  <?			}?>
				  <tr>
				    <td><select name='cod_coltu_arbu1'>
				      <option value='-1' > ...</option>
	<?				foreach( $diz_arbo as $d ) 
						{echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";}?>
				    </select></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#' onclick='javascript:schedeB2_form4()'>Inserisci</a></td>
				  </tr>	      	
		      	</table></div>
		      </td></tr>
		      </table></div> 
<!--Strato erbaceo-->
			<div class='block10'><table width='120px' class="row"><caption class="span"><span>Strato erbaceo</span></caption>
				<?foreach ($strati As $st){
					echo "<tr><td><input type='radio' class='radio_dis' name='se' value='$st->codice'"; if ($infoB2->se == $st->codice): echo "checked"; endif; echo "/></td><th>".$st->descriz."</th></tr>\n";
				} echo "</tr>"; ?>
			</table></div>
 <!-- specie significative strato erbaceo  -->
<!-- 	insert_erbaB2, modify_erbaB2, delete_erbaB2 -->
		      <div  id='erbacee_cont' class='block1010'>
		      <table class='row'><caption class="span"><span>Specie erbacee significative</span></caption>
		      <tr><td><div id='erbacee_int' class='block'>
		      	<table id='erbacee'>
		      	<tr><td><b>Specie</b></td></tr>
			<?php
			foreach ($erbacee AS $erba){ ?>
			    <tr id='tr_7_<?echo $erba->cod_coltu ?>'>
			      <td><select name='cod_coltu_erba' onChange='javascript:schedeB2_form7("<?echo $erba->cod_coltu?>" )'>
				<option value='-2' >...</option>
  <?				foreach( $diz_erba as $d ){
						$selected1 =($d->cod_coltu == $erba->cod_coltu)? 'selected' : ''; 
						if ($selected1!='') $nome= $d->nome; 
						echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome</option>\n";
				    } ?>
			      </select></td>
			      <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB2=Scheda B2&delete_erbaB2=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$erba->cod_coltu#container5"?>'>Elimina</a></td>
			    </tr>
  <?			}?>
			  <tr>
			    <td><select name='cod_coltu_erba1'>
			      <option value='-1' > ...</option>
<?				foreach( $diz_erba as $d ) 
					{echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome</option>\n";}?>
			    </select></td>
			    <td colspan='2' style='text-align:center'>
			    <a href='#' onclick='javascript:schedeB2_form6()'>Inserisci</a></td>
			  </tr>
		      </table></div></td></tr>
			</table></div> 

<!-- Categorie intervento per sugherete -->
			<div class='block'><table width='480px' class="row"><caption>Categorie intervento per sugherete</caption> 
				<tr><td><? echo "<select name='tipo_prescr_sug'>";
					echo "<option value='' selected='selected'></option>\n";
					foreach( $tipo_int_sug as $str ) {
						$selected = ( isset($infoB2->s) and  $infoB2->tipo_prescr_sug == $str->codice)? 'selected' : '' ;
						echo "<option value='$str->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$str->codice | $str->descrizion</option>\n";}
				echo "</select>";?>
				</td></tr></table>
			</div>
<!-- ipotesi intervento  -->
		    <div class='block10'><table  class='row'><caption>Ipotesi di intervento</caption><tr>
			<td width='300px'><select name='p2'>
				<option value='-1' selected='selected'></option>	
				<? foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB2->p2) and $pre->codice == $infoB2->p2 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";} ?>
			</select></td>
			</tr></table></div>
<!--// Anno previsto estrazione sughero-->
			<div class='block'><table  class='row'><caption>Anno previsto estrazione sughero</caption><tr>
			  <td width='150px'><input type='text' class="anno" name='estraz_futura' value='<? echo $infoB2->estraz_futura?>' /></td> 
			</tr></table></div>
<!--/*ipotesi intervento  secondario*/-->
			<div class='block10'><table  class='row'><caption>Ipotesi di intervento (secondaria)</caption><tr>
			<td width='300px'><select name='p3'>
				<option value='-1' selected='selected'></option>	
				<?foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB2->p3) and $pre->codice == $infoB2->p3 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";} ?>
			</select></td>
			</tr></table></div>
			<div id='div_container6' class='block10'><table  class='row'><caption>Specifiche intervento di altro tipo</caption><tr>
			  <td width='150px'><input type='text' name='p4' value='<?echo $infoB2->p4?>' /></td> 
			</tr></table></div>
  <!-- Proprietà e condizionamenti -->
			<div class='block'><table  class='row' width='350px'><caption class='span'><span>Priorità e condizionamenti</span></caption><tr>
				<?php foreach ( $urgenza as $k => $u ) {
				    echo "<td><input type='radio' class='radio_dis' name='g1' value='$u->codice'"; if($infoB2->g1 == $u->codice ): echo " checked"; endif; 
				    echo " /></td><th>$u->descriz</th>\n"; }  ?>
			  </tr></table></div>  
			 <div class='block10 pad_t10'>
			 	<img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/>
				<div class='block'>	<a name='container6'> </a> </div>		      		      
	        </div>
  <!-- subordinato alla viabilità -->
			<div class='block'><table  class='row' width='70px'><caption>subordinato alla viabilità</caption><tr>
			<td><input type='radio' class='radio_dis' name='sub_viab' value='t' <? if($infoB2->sub_viab == 't'):echo " checked"; endif;?> /></td><th>sì</th></tr>
			<tr><td><input type='radio' class='radio_dis' name='sub_viab' value='f' <? if($infoB2->sub_viab == 'f'):echo " checked"; endif;?> /></td><th>no</th>
			  </tr></table></div>  
<!-- NOTEj -->
			<div class='block10'><table width='480px' height='100px'><caption>NOTE</caption>
			<tr><td class="top"><textarea name='note' rows="5" cols="65"><?php echo $infoB2->note?></textarea> </td></tr>
			</table></div>
		</div> 
		<!--ds_container11_B2 -->
	</div> 

	<!-- id='ds_center5_B2' -->
	</div><!-- id="opt12_fields"-->

	<div id='ds_center6_B2'  class='tavole'>
<!-- ############### Note alle singole voci ######################-->
<!-- qui inserisco le due variabili che poi passo al form sottostante (particelle_note_form)
che sono parametro_sing = cod_nota,  nota_sing = nota -->
		<div id='note_cont' class='block10'>
		<table class='row'><caption class="span"><span>NOTE alle singole voci</span></caption>
			<tr><td><div id='note_int' class='block' >
			<table id='note_sing' >
				<tr><td class='center' width='50%'><b>Parametro</b></td><td class='center' width='50%'><b>Nota</b></td></tr> 
		 	 	<?php //if (isset($info_note) AND !empty($info_note)){
					foreach ($info_note as $in){  ?>
						<tr class='no_repeat_schA' id='tr_<?echo $in->cod_nota; ?>'><td>
						<select name='parametro_sing'> 
							<option selected='selected' value='-2' > </option>
				  			<? foreach( $note_tutte as $nt ) {
								$selected1 =($nt->nomecampo == $in->cod_nota)? 'selected' : ''; 
								echo "<option value='$nt->nomecampo' $selected1>($nt->nomecampo) $nt->intesta</option>\n";
							}?>
						</select></td>
						<td><input name='nota_sing' type='text' value='<? echo $in->nota ?>' /></td>
						<td><a href='#container6' onclick='javascript:schedeB2_form9("<?echo $in->cod_nota ?>")'>Salva</a></td>
						<td><a class='delete_noteA' title='<?echo $in->cod_nota?>' href='<?php echo "?page=descrp&schedB2=Scheda B2&delete_noteB2=ok&proprieta=$proprieta&particella=$particella&cod_nota=$in->cod_nota#container6"?>'>Elimina</a></td>
					<?}
					//		} else  { echo "<tr><td>...</td><td>...</td>";	} ?>
				</tr>
				<tr><td>
				<select name='parametro_sing1'>
					<option selected='selected' value='-1' > nota...</option>
					 <? foreach( $note_tutte_dif as $ntd ) {echo "<option value='$ntd->nomecampo'>($ntd->nomecampo) $ntd->intesta</option>\n";} ?>
				</select></td>
				<td><input type='text' name='nota_sing1' value='' /></td>
				<td colspan='2' style='text-align:center'>
				<a href='#container6' onclick='javascript:schedeB2_form8()'>Inserisci</a></td></tr>	
			</table></div>
			</td></tr></table>
	      </div>

	</div>
	<!-- id='ds_center6_B2' -->
<!-- Bottone modifica o inserisci  -->
	<div class='centro'>
	<div  class='bottone_alto'>
	      <?  echo "<div class='mod_ins'>";
		  if( empty($temp_var))
			  echo "<input class='bot_descrp' title='Inserisci dati di $propriet->descrizion particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>";
		  else	{ echo "<input class='bot_descrp' title='Modifica dati di $propriet->descrizion particella $particella' type='submit' name='modifica_dati' value='Salva modifiche' /></div>";
		 echo "<div id='cancella'><a class='bot_descrp' class='actions cancella' title='proprietà di $propriet->descrizion e particella $particella' href='?page=descrp&schedB4=ok&delete=ok&proprieta=$proprieta&particella=$particella'>Elimina dati</a></div>";}?>
	</div>
	</div>
<?
 }
?>


		</div>
		<!--  <div id='centra'> -->
		</div>
		<!--  <div id='descrp_schedeB2'> -->
	</form>
<!-- 	<form name="descrp_schedeB2_form" action="#" method="post"> -->

<!-- ######################## form tabelle letarali ######################################## -->
<?
if ($scheda == 'Scheda B2') 	{ ?>
<!--// Attenzione!! vedere in js la funzione "formB2_1()"-->

 <!-- 	insert_arborB2, modify_arborB2, delete_arboreeB2 -->
	<form name='formB2_2' id='formB2_2' action="#container5" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='insert_arborB2' value='ok' />
	</form>

	<form name='formB2_3' id='formB2_3' action="#container5" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='modify_arborB2' value='ok' />
	</form>
<!-- 	insert_arbuB2, modify_arbuB2, delete_arbuB2 -->
	<form name='formB2_4' id='formB2_4' action="#container5" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_arbuB2' value='ok' />
	</form>

	<form name='formB2_5' id='formB2_5' action="#container5" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_arbuB2' value='ok' />
	</form>
<!-- 	insert_erbaB2, modify_erbaB2, delete_erbaB2 -->
	<form name='formB2_6' id='formB2_6' action="#container5" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_erbaB2' value='ok' />
	</form>

	<form name='formB2_7' id='formB2_7' action="#container5" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_erbaB2' value='ok' />
	</form>

<!-- ######################## form note singole voci######################################## -->

	<form name='formB2_8' id='formB2_8' action="#container6" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='insert_noteB2' value='ok' />
	</form>


	<form name='formB2_9' id='formB2_9' action="#container6" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB2'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB2' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='cod_nota_old' value='ok' />
		<input type='hidden' name='modify_noteB2' value='ok' />
	</form>



<?php } ?>
</div> 
<!-- <div id='home' class='descrp_schede'> -->
<?php
}
?>