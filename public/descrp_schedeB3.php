<?php
if(   isset($_REQUEST['schedB3']) ) 	{

// 	inserisco controlli e azioni relativi alla scheda_b
 	include('descrp_schedeB3_actions.php') ;

	//assegnazione della variabili del form precedente
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
	//inizializzazione variabili
	$infoB = null ; // relative a tabella schede_b
	$infoB3 = null ; // relative a tabella schede_B3
	$cod_fo = ' 1'; //metto io forzatamente cod_fo =(spazio)1, perchè è rimasto da cose vecchie !!!!!!!!!!!!!!!!!!!!
 //###### genero l'array vuoto contenente tutti i campi della tabella schede_b e  sched_B3 che mi servono
	$arr = generate_Arr_arch('sched_b3'); 	//##
	$b =   generate_Arr_arch('schede_b');	//##
//###############################

//---------------------------- Modifica/Inserimento dati---------------------------------------------

  //se si vuole modificare o inserire i dati di una particella si fanno eseguire l'UPDATE o l'INSERT nella tabella SCHEDE_B con la funzione saveInfoDescrpB($info, $proprieta, $particella) 
	if( isset($_REQUEST['inserisci_dati']) or isset($_REQUEST['modifica_dati'])) {
	      $b = fill_Arr($b, $proprieta,$particella, $cod_fo );
	      $arr = fill_Arr($arr, $proprieta,$particella, $cod_fo );
	      	 saveInfoDescrp($b, $proprieta, $particella, 'schede_b');
	      	 saveInfoDescrp($arr, $proprieta, $particella, 'sched_B3');
	      redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
	if( isset($_REQUEST['delete']) ) {
	      $b = fill_Arr_dellB($b, $proprieta,$particella, $cod_fo );	
		saveInfoDescrp($b, $proprieta, $particella, 'schede_b');
			     
		list( $res , $id ) = cancellaPart($proprieta, $particella, 'sched_B3') ;
		
		if( $res ) 	{die('Tornare a Descrizione Particellare');}
		else 		echo "errore" ;
	}
// --------------------------------------------------------------------------------------
	//verifica se sono già stati inseriti i dati della Scheda B3, dopo aver creato per la Scheda A (ma sono noti solo $proprietà e $particella)
	$temp_var = esisteProprietaEParticella('sched_B3', $proprieta, $particella);
// echo "stampo temp_var ";print_r($temp_var);
	if( empty($temp_var)) { //caso in cui si debba riempire tabelle schede_b e sched_B3
// echo "non esiste particella, la devo inserire";
		$arr['proprieta'] = $proprieta ;
		$arr['particella'] = $particella ;
 		$arr['cod_fo'] = $cod_fo ;
		$b['proprieta'] = $proprieta ;
		$b['particella'] = $particella ;
 		$b['cod_fo'] = $cod_fo ;
		$infoB = array_to_object($b) ;
		$infoB3 = array_to_object($arr) ;
	} else 	{  // caso in cui si debba solo interrogare il database perchè i dati sono già stati inseriti
		$infoB = getInfoScheda( $proprieta , $particella , 'schede_b');
 		$infoB3 = getInfoScheda($proprieta, $particella , 'sched_B3');
	}

	//echo "numero variabili sched_B3 = 36 - 1 (objectid), numero variabili usate ".count($arr)." fine.  ";
	//print_r($arr);

//-----------------------------Select per costruzione pagina-----------------------------------------
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di SCHEDE_A 
	$usosuolo = getCod_descriz('usosuol2');

	$regione = getDiz_regioniCod($proprieta);
	$boschi = getCodiciBoschiCodice( $proprieta );
	$propriet = getInfoPropriet( $proprieta);
	$cod_proprieta = getCod_descrizion('propriet') ;
	$comp_coti =  getCod_descriz('compcoti');
	$dens_coti = getCod_descriz('denscoti');
	$struttura = getCod_descriz_struttu('struttu', $regione->codice) ;
	$strati = getCod_descriz('strati');
	$mod_pasc = getCod_descriz('mod_pasc');
	$novell = getCod_descriz ('novell');
	$car_nove = getCod_descriz ('car_nove');
	$urgenza = getCod_descriz('urgenza') ;
	$fruitori = getCod_descriz('fruitori') ;
	$carico = getCod_descriz('carico') ;
	$disph2o = getCod_descriz('disph2o') ;
	$abbevera = getCod_descriz('abbevera') ;
	$meccaniz = getCod_descriz('meccaniz') ;
	$funzion2 = getCod_descriz('funzion2') ;
	$prescriz = getCod_descriz('prescri3') ;
	$infr_past = getCod_descriz('infr_past') ;
	

// ################################ formB3_2 e 3 #############################################################
 $arr_arbu['cod_coltu']=""; $arr_arbu['cod_coltu_old']=""; $arr_arbu['id_av']="";
	$arr = fill_Arr($arr_arbu, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arbuB3']) or isset($_REQUEST['modify_arbuB3']) ) {
		$info_arbu = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbu('arbusti3' , $info_arbu, $proprieta, $particella) ;
		redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$arbusti = getInfoArbusti('arbusti3', $proprieta , $particella, $cod_fo );
 	$diz_arbo = getDizArbo(); //usata questa funzione anche per gli arbusti, perchè hanno la stessa tabella degli alberi
// #############################################################################################
	
// ################################ formB3_4 e 5 #############################################################
 $arr_erba['cod_coltu']=""; $arr_erba['cod_coltu_old']=""; $arr_erba['id_av']="";
	$arr = fill_Arr($arr_erba, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_erbaB3']) or isset($_REQUEST['modify_erbaB3']) ) {
		$info_erba = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_erba('erbacee3', $info_erba, $proprieta, $particella) ;
		redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$erbacee = getInfoErbacee('erbacee3', $proprieta , $particella, $cod_fo );
	$diz_erba = getDizErba();
// #############################################################################################
	
// ################################ formB3_6 e 7 #############################################################
 $arr_arbo['cod_coltu']=""; $arr_arbo['cod_coltu_old']="";$arr_arbo['id_av']="";
	$arr = fill_Arr($arr_arbo, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arboB3']) or isset($_REQUEST['modify_arboB3']) ) {
		$info_arbo = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbo1('comp_arb', $info_arbo, $proprieta, $particella) ;
		redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$arboree = getInfoArboree1('comp_arb', $proprieta , $particella, $cod_fo );
// #############################################################################################
	
// ################################ formB3_10 e 11 #############################################################
 $arr_rinnovaz['cod_coltu']=""; $arr_rinnovaz['cod_coltu_old']="";$arr_rinnovaz['id_av']="";
	$arr = fill_Arr($arr_rinnovaz, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_rinnovazB3']) or isset($_REQUEST['modify_rinnovazB3']) ) {
		$info_rinnovaz = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbo1('rinnovaz', $info_rinnovaz, $proprieta, $particella) ;
		redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$rinnovaz = getInfoArboree1('rinnovaz', $proprieta , $particella, $cod_fo );
// #############################################################################################
// ################################ formB3_12 e 13 #############################################################
 $arr_infe['cod_coltu']=""; $arr_infe['cod_coltu_old']="";$arr_infe['id_av']="";
	$arr = fill_Arr($arr_infe, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_infeB3']) or isset($_REQUEST['modify_infeB3']) ) {
		$info_infe = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_erba('infestan', $info_infe, $proprieta, $particella) ;
		redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$infestanti = getInfoErbacee('infestan', $proprieta , $particella, $cod_fo );
// #############################################################################################
// ################################ formB3_14 e 15 #############################################################
 $arr_albe['cod_coltu']=""; $arr_albe['cod_coltu_old']="";$arr_albe['id_av']="";
	$arr = fill_Arr($arr_albe, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_alberaturaB3']) or isset($_REQUEST['modify_alberaturaB3']) ) {
		$info_albe = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbo1('arb_colt', $info_albe, $proprieta, $particella) ;
		redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$alberatura = getInfoArboree1('arb_colt', $proprieta , $particella, $cod_fo );
// #############################################################################################
// ############################### form per note singole voci 8 e 9 #########################################

 $arr_note['cod_nota']=""; $arr_note['cod_nota_old']=""; $arr_note['nota']="";

	if( isset($_REQUEST['insert_noteB3']) or isset($_REQUEST['modify_noteB3']) ) {
	      foreach( array_keys($arr_note) as $key ) {
		$val = ( isset($_REQUEST[$key]) )? $_REQUEST[$key] : null ;
		$arr_note[$key] = $val ;
	      }
	      $info_note = array_to_object($arr_note) ;// trasformazione da array in oggetto
	      saveInfoDescrp_note($info_note, $proprieta, $particella, 'note_b3') ;
	      redirect("?page=descrp&schedB3=Scheda B3&particella=$particella&proprieta=$proprieta");
	}

 //se si vuole semplicemente interrogare la tabella NOTE_A si fanno le SELECT con le funzioni getInfoSchedaA_note(.., ..) dalla tabella
	$info_note = getInfoScheda_note ($proprieta, $particella, 'note_b3');
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di note_A 
	$note_tutte= getInfoSchedaNoteTutte ('schede_b');
	$note_tutte_dif= getInfoSchedaNoteTutte_dif ('schede_b', 'note_b3');

// #############################################################################################
// ------------------------------------------------------------
?>

<div id='home' class='descrp_schede schedeB3'>
	<form name="descrp_schedeB3_form" action="#" method="post">
	<input type='hidden' name='schedB3' value='ok' />
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
					  // se la ho già inserito la SCHEDA_B3 allora tasto Modifica, altrimenti tasto Inserisci
						  echo "<input class='bot_descrp ModDell confermaMOD' title='Inserisci dati di $propriet->descrizion particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>";
					  else	{ echo "<input class='bot_descrp ModDell confermaMOD' title='Modifica dati di $propriet->descrizion particella $particella' type='submit' name='modifica_dati' value='Salva modifiche' /></div>";
					//ancora per query DELITE e che mi rimanda alla pagina descrp_schedeA.php
						  echo "<div id='cancella'><a class='bot_descrp ModDell confermaDELL' class='actions cancella' title='proprietà di $propriet->descrizion e particella $particella' href='?page=descrp&schedB3=ok&delete=ok&proprieta=$proprieta&particella=$particella'>Elimina dati</a></div>";}?>
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
//------------------------------------------------------------ Scheda B3 -------------------------------------------------
if ($scheda == 'Scheda B3')  {  ?>

	<div id='ds_center1_B3' >
		<div id="ds_container1_B3" class='tavole'>
		      <div id='ds_title_B3' class='block'>Scheda B3 per la descrizione di una<br />FORMAZIONE ARBUSTIVA-ERBACEA </div>
<!--Particella/Sottoparticella-->
		      <div class='block1010'><table width='200px'><caption>Particella/Sottoparticella</caption>
		      <tr><td><?php echo $particella ?></td></tr></table></div>
		      <input type='hidden' name='particella' value ='<?php echo $particella; ?>' />
		</div> <!--id="ds_container" class='tavole'-->

		<div id="ds_container2_B3" class='tavole'>
<!--Tipo-->
			<div class='block spazio'><table width="500px" class="row"><caption class="span"><span>Tipo</span></caption>
				<tr>
				<?php $u_validi = array(3, 4, 5, 6, 7, 8);
				 foreach ($usosuolo as $u){
				 	if( in_array($u->codice, $u_validi) ) {
						echo "<td><input type='radio' id='opt".$u->codice."' name='u' value='$u->codice' ";
						if ($infoB->u == $u->codice)  { $infoB3->u = $u->codice; echo "checked";};
						echo "/></td><th>$u->descriz</th>\n";
				 	}					 
				}	?>
				</tr></table>
			</div> 
<!--Tipo forestale-->
			<div class='block spazio'><table width='250px' class="row"><caption>Tipo forestale</caption><tr><td>	
				<? 
				if (!isset($tipologia)) echo "Table diz_tipi: codice $regione->codice ($regione->descriz) assente'";
			 	else{ 				
			 		echo "<select name='t'>";
					echo "<option value='' selected='selected'></option>";
					foreach( $tipologia as $tip ) {
						$selected = ( isset($infoB->t) and $infoB->t == $tip->codice )? 'selected' : ' ' ;
						echo "<option value='$tip->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$tip->codice | $tip->descriz</option>\n";
					}
					echo "</select>";/*echo "<input type='text' name='t' value='$infoB->t' />\n ";*/ 	
				 }?>
				</td></tr></table>	 
			</div>
			
		</div> 
		<!--id="ds_container2_B3" class='tavole'-->
	</div>
	<!-- id='ds_center1_B3' -->

<!-- ####################### Formazione Arbustiva ########################  -->
	<div id="opt3_fields">
	<div id='ds_center2_B3'  class='tavole'>
		<div class="riga_schedeB3"><p></p></div>
		
		<div id="ds_container3_B3" class='tavole'>
		<div id="ds_container3_prova" class='tavole'>
			<div id='biancoB3' class='block1010'><p>Formazione Arbustiva</p></div>
<!-- Altezza media -->
			<div class='block10'><table width='100px' class="row"><caption>Altezza media</caption> 
				<tr><td><input type="text"  class='num' name="h" value='<? echo $infoB3->h ?>' /></td></tr></table>
			</div>
<!-- Copertura (%) -->
			<div class='block10'><table width='100px' class="row"><caption>Copertura (%)</caption> 
				<tr><td><input type="text"  class='perc' name="cop_arbu" value='<? echo $infoB3->cop_arbu ?>' /></td></tr></table>
			</div>
<!--DIFFUSIONE STRATO ERBACEO-->
			<div class='block spazio'><table width="400px" class="row"><caption class="span"><span>DIFFUSIONE STRATO ERBACEO</span></caption>
				<tr>			
					<?php foreach ($strati as $se){
						echo "<td><input type='radio' class='radio_dis' name='se' value='$se->codice' ";
						if ($infoB3->se == $se->codice)  echo "checked";
						echo "/></td><th>$se->descriz</th>";
				}	?>
				</tr></table>
			</div> 	
		</div> 	<!-- nuovo prova  -->
			<!-- ####################### Incolto erbaceo ########################  -->
	<div id="opt4_fields">
	<div id='ds_center3_B3'  class='tavole'>		
		<div id="ds_container4_B3" class='tavole'>
			<div id='biancoB3' class='block1010'><p>Incolto erbaceo</p></div>
<!-- Copertura (%)-->
			<div class='block10'><table width='150px' class="row"><caption>Copertura (%)</caption> 
				<tr><td><input type="text" class="perc" name="cop_erba" value='<? echo $infoB3->cop_erba?>' /></td></tr></table>
			</div>
<!-- Copertura  strato arbustivo (%)-->
			<div class='block10'><table width='200px' class="row"><caption>Copertura  strato arbustivo (%)</caption> 
				<tr><td><input type="text" class="perc" name="sr_perc" value='<? echo $infoB3->sr_perc?>' /></td></tr></table>
			</div>		
		</div> 
		<!--ds_container4_B3-->
		
	</div>
	<!-- id='ds_center3_B3' -->
	</div><!-- id="opt4_fields"-->
<!-- ####################### FINE Incolto erbaceo ########################  -->
				
<!-- specie significative strato arbustivo  -->
			<!-- 	insert_arbuB3, modify_arbuB3, delete_arbuB3 -->
			  <a name='container3_B3'> </a> 
		      <div id='div_arbustive' class='block1010'>
		      <table class='row'><caption class="span"><span>Strato arbustivo - specie significative</span></caption>
		      <tr><td>
		      	<div id='arbustive_int' class='block'><table id='arbusti'>
			      <tr><td><b>Specie</b></td></tr>
					<?php foreach ($arbusti AS $arbu){ ?>
				    <tr id='tr_3_<?echo $arbu->cod_coltu ?>'>
				      <td><select name='cod_coltu_arbu' onChange='javascript:schedeB3_form3("<?echo $arbu->cod_coltu?>" )'>
					<option value='-2' >...</option>
	  					<?foreach( $diz_arbo as $d ){
							$selected1 =($d->cod_coltu == $arbu->cod_coltu)? 'selected' : ''; 
							if ($selected1!='') $nome= $d->nome_itali;
							echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
					    } ?>
				      </select></td>
				      <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB3=Scheda B3&delete_arbuB3=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbu->cod_coltu#container3_B3"?>'>Elimina</a></td>
				    </tr>
	 				 <? } ?>
				  <tr>
				    <td><select name='cod_coltu_arbu1'>
				      <option value='-1' > ...</option>
					<? 	foreach( $diz_arbo as $d ) 
						{echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";}?>
				    </select></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#container3_B3' onclick='javascript:schedeB3_form2()'>Inserisci</a></td>
				  </tr>
		      	</table></div>
		      </td></tr>
		      </table></div> 
			
<!-- specie significative strato erbaceo  -->
<!-- 	insert_erbaB3, modify_erbaB3, delete_erbaB3 -->
		      <div id='div_erbacee' class='block1010'>
		      <table class='row'><caption class="span"><span>Strato erbaceo - specie significative</span></caption>
		      <tr><td>
		      	<div id='erbacee_int'><table id='erbacee'>
		      <tr><td><b>Specie</b></td></tr>
			<?php
			foreach ($erbacee AS $erba){ ?>
			    <tr id='tr_5_<?echo $erba->cod_coltu ?>'>
			      <td><select name='cod_coltu_erba' onChange='javascript:schedeB3_form5("<?echo $erba->cod_coltu?>" )'>
				<option value='-2' >...</option>
  					<? foreach( $diz_erba as $d ){
						$selected1 =($d->cod_coltu == $erba->cod_coltu)? 'selected' : '';
						if ($selected1!='') $nome= $d->nome; 
						echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome</option>\n";
				    } ?>
			      </select></td>
			      <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB3=Scheda B3&delete_erbaB3=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$erba->cod_coltu#container3_B3"?>'>Elimina</a></td>
			    </tr>
  			<? }?>
			  <tr>
			    <td><select name='cod_coltu_erba1'>
			      <option value='-1' > ...</option>
			<?		foreach( $diz_erba as $d ) 
					{echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome</option>\n";}?>
			    </select></td>
			    <td colspan='2' style='text-align:center'>
			    <a href='#container3_B3' onclick='javascript:schedeB3_form4()'>Inserisci</a></td>
			  </tr>
		      	</table></div>
		      </td></tr>
			</table></div> 
			
		</div> 
		<!--ds_container3_B3-->

	</div>
	<!-- id='ds_center2_B3' -->
	</div><!-- id="opt3_fields"-->


<!-- ####################### Pascolo/Prato-pascolo ########################  -->
	<div id="opt6-7_fields">
	<div id='ds_center4_B3'  class='tavole'>
		<div id="ds_container5_B3" class='tavole'>
			<div id='biancoB3' class='block1010'><p>Pascolo/Prato-pascolo</p></div>
<!--COMPOSIZIONE COTICO-->
			<div class='block spazio'><table width="500px" class="row"><caption class="span"><span>COMPOSIZIONE COTICO</span></caption>
				<tr>			
					<?php foreach ($comp_coti as $c){
						echo "<td><input type='radio' class='radio_dis' name='comp_coti' value='$c->codice' ";
						if ($infoB3->comp_coti == $c->codice)  echo "checked";
						echo "/></td><th>$c->descriz</th>";
				}	?>
				</tr></table>
			</div> 		
<!--DENSITÀ COTICO-->
			<div class='block spazio'><table width="300px" class="row"><caption class="span"><span>COMPOSIZIONE COTICO</span></caption>
				<tr>			
					<?php foreach ($dens_coti as $c){
						echo "<td><input type='radio' class='radio_dis' name='dens_coti' value='$c->codice' ";
						if ($infoB3->dens_coti == $c->codice)  echo "checked";
						echo "/></td><th>$c->descriz</th>";
				}	?>
				</tr></table>
			</div> 	
<!--DIFFUSIONE INFESTANTI-->
			<div class='block spazio'><table width="350px" class="row"><caption class="span"><span>DIFFUSIONE INFESTANTI</span></caption>
				<tr>			
					<?php foreach ($strati as $s){
						echo "<td><input type='radio' class='radio_dis' name='infestanti' value='$s->codice' ";
						if ($infoB3->infestanti == $s->codice)  echo "checked";
						echo "/></td><th>$s->descriz</th>";
				}	?>
				</tr></table>
			</div> 
			
			<a name='container5_B3'></a>
				
<!-- Infestanti - specie significative -->
<!-- 	insert_infeB3, modify_infeB3, delete_infeB3 -->
		      <div id='div_infe' class='block10'>
		      <table class='row'><caption class="span"><span>Infestanti - specie significative</span></caption>
				<tr><td>
				  <div id='infe_int' class='block'><table id='infestanti'>
			      <tr><td><b>Specie</b></td></tr>
					<?php
					foreach ($infestanti AS $erba){ ?>
					    <tr id='tr_13_<?echo $erba->cod_coltu ?>'>
					      <td><select name='cod_coltu_erba_inf' onChange='javascript:schedeB3_form13("<?echo $erba->cod_coltu?>" )'>
						<option value='-2' >...</option>
		  					<? foreach( $diz_erba as $d ){
								$selected1 =($d->cod_coltu == $erba->cod_coltu)? 'selected' : ''; 
								if ($selected1!='') $nome= $d->nome; 
								echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome</option>\n";
						    } ?>
					      </select></td>
					      <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB3=Scheda B3&delete_infeB3=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$erba->cod_coltu#container5_B3"?>'>Elimina</a></td>
					    </tr>
		  			<? }?>
				  <tr>
				    <td><select name='cod_coltu_erba_inf1'>
				      <option value='-1' > ...</option>
				<?		foreach( $diz_erba as $d ) 
						{echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome</option>\n";}?>
				    </select></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#container5_B3' onclick='javascript:schedeB3_form12()'>Inserisci</a></td>
				  </tr>
			   </table></div>
			</td></tr>
			</table></div> 
<!--MODALITÀ PASCOLO-->
			<div class='block'><table width="250px" class="row"><caption class="span"><span>MODALITÀ PASCOLO</span></caption>
				<tr>			
					<?php foreach ($mod_pasc as $m){
						echo "<td><input type='radio' class='radio_dis' name='modalpasco' value='$m->codice' ";
						if ($infoB3->modalpasco == $m->codice)  echo "checked";
						echo "/></td><th>$m->descriz</th>";
				}	?>
				</tr></table>
			</div> 
<!-- DURATa (giorni)-->
			<div class='block10'><table width='150px' class="row"><caption>Durata (giorni)</caption> 
				<tr><td><input type="text" class="num" name="duratapasc" value='<? echo $infoB3->duratapasc?>' /></td></tr></table>
			</div>
<!-- SPECIE PASCOLANTE -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>SPECIE PASCOLANTE</span></caption> <tr>
	 			 <? foreach ($fruitori as $f){
						echo "<td><input type='radio' class='radio_dis' name='fruitori' value='$f->codice' ";
						if ($infoB3->fruitori == $f->codice)  echo "checked";
						echo "/></td><th>$f->descriz</th>";
						  } ?>		
			</tr></table></div>
<!-- CARICO -->
			<div class='block10'><table width='300px' class="row"><caption class="span"><span>CARICO</span></caption> <tr>
	 			 <? foreach ($carico as $f){
						echo "<td><input type='radio' class='radio_dis' name='caricopasc' value='$f->codice' ";
						if ($infoB3->caricopasc == $f->codice)  echo "checked";
						echo "/></td><th>$f->descriz</th>";
						  } ?>		
			</tr></table></div>
<!-- UBA/ha-->
			<div class='block10'><table width='150px' class="row"><caption class="span"><span>UBA/ha</span></caption> 
				<tr><td><input type="text" class="num" name="n_capi" value='<? echo $infoB3->n_capi?>' /></td></tr></table>
			</div>
<!-- DISPONIBILITÀ ACQUA -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>DISPONIBILITÀ ACQUA</span></caption> <tr>
	 			 <? foreach ($disph2o as $f){
						echo "<td><input type='radio' class='radio_dis' name='disph2o' value='$f->codice' ";
						if ($infoB3->disph2o == $f->codice)  echo "checked";
						echo "/></td><th>$f->descriz</th>";
						  } ?>		
			</tr></table></div>
<!-- Num. abbeveratoi-->
			<div class='block10'><table width='150px' class="row"><caption>Num. abbeveratoi</caption> 
				<tr><td><input type="text" class="num" name="n_abbevera" value='<? echo $infoB3->n_abbevera?>' /></td></tr></table>
			</div>
<!-- STATO ABBEVERATOI -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>STATO ABBEVERATOI</span></caption> <tr>
	 			 <? foreach ($abbevera as $f){
						echo "<td><input type='radio' class='radio_dis' name='$abbevera' value='$f->codice' ";
						if ($infoB3->abbevera == $f->codice)  echo "checked";
						echo "/></td><th>$f->descriz</th>";
						  } ?>		
			</tr></table></div>
<!-- POSSIBILITÀ MECCANIZZAZIONE  -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>POSSIBILITÀ MECCANIZZAZIONE</span></caption><tr>
	 			 <? foreach ($meccaniz as $f){
						echo "<td><input type='radio' class='radio_dis' name='possmeccan' value='$f->codice' ";
						if ($infoB3->possmeccan == $f->codice)  echo "checked";
						echo "/></td><th>$f->descriz</th>";
						  } ?>		
			</tr></table></div>
<!-- POSSIBILITÀ SPOSTAMENTO MUNGITRICI -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>POSSIBILITÀ SPOSTAMENTO MUNGITRICI</span></caption> <tr>
	 			 <? foreach ($meccaniz as $f){
						echo "<td><input type='radio' class='radio_dis' name='possmungit' value='$f->codice' ";
						if ($infoB3->possmungit == $f->codice)  echo "checked";
						echo "/></td><th>$f->descriz</th>";
						  } ?>		
			</tr></table></div>
<!-- INFRASTRUTTURE PASTORALI -->
			<div class='block10'><table width='350px' class="row"><caption class="span"><span>INFRASTRUTTURE PASTORALI</span></caption> <tr>
	 			 <? foreach ($infr_past as $f){
						echo "<td><input type='radio' class='radio_dis' name='infr_past' value='$f->codice' ";
						if ($infoB3->infr_past == $f->codice)  echo "checked";
						echo "/></td><th>$f->descriz</th>";
					} ?>		
			</tr></table></div>
		</div> 
		<!--ds_container5_B3-->	
		<div id="ds_container6_B3" class='tavole'>	
		
<!-- COMPOSIZIONE COMPONENTE ARBOREA  -->
		    <div class='block10' id='div_arboree'>
		    <table class='row'><caption class="span"><span>COMPOSIZIONE COMPONENTE ARBOREA</span></caption>
		      <tr><td>
 			  <div id='arboree_int' class='block'><table id='arboree'>
 			  	
			      <tr class='center'><td><b>Specie</b></td></tr>      
			      <?php
			      foreach ($arboree AS $arbo){?>
				      <tr id='tr_7_<?echo $arbo->cod_coltu?>'>
					  <td><select name='cod_coltu_arbo' onChange='javascript:schedeB3_form7("<?echo $arbo->cod_coltu?>" )'>
						  <option value='-2' >...</option>
		  					<?foreach( $diz_arbo as $d ){
								  $selected1 =($d->cod_coltu == $arbo->cod_coltu)? 'selected' : ''; 
								  if ($selected1!='') $nome= $d->nome_itali; 
								  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
							  } ?>
					  </select></td>
					  <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB3=Scheda B3&delete_comp_arbB3=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container5_B3"?>'>Elimina</a></td>
				      </tr>
	      		 <?} ?>
			      <tr>
				  <td><select name='cod_coltu_arbo1'>
					  <option value='-1' > ...</option>
		 			  <?foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
				  </select></td>
				  <td colspan='2' style='text-align:center'>
				  <a href='#' onclick='javascript:schedeB3_form6()'>Inserisci</a></td>
			      </tr>
			    </table></div>
				</td></tr>
		    </table></div> 
<!--Copertura (%)-->
			<div class='block1010'><table width='120px' class="row"><caption>Durata (giorni)</caption> 
				<tr><td><input type="text" class="perc" name="cop_arbo" value='<? echo $infoB3->cop_arbo?>' /></td></tr></table>
			</div>
<!-- novellame  -->
		     <div class='block'><table width='300px' class='row'><caption class='span'><span>NOVELLAME</span></caption><tr>
			   <?php foreach ( $novell AS $k => $n1 ) {
				echo "<td><input type='radio' class='radio_dis' name='n1' value='$n1->codice'"; if($infoB3->n1 == $n1->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n1->descriz)."</th>\n"; }  ?>
		      </tr></table></div>
		      <div class='block pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div>
		     <div class='block'><table width='160px' class='row'><caption class='vuoto'><span></span></caption><tr>
			   <? foreach ( $car_nove AS $k => $n2 ) {
				echo "<td><input type='radio' class='radio_dis' name='n2' value='$n2->codice'"; if($infoB3->n2 == $n2->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n2->descriz)."</th>\n"; }  ?>
		      </tr></table></div>  
<!-- COMPOSIZIONE RINNOVAZIONE ############# table: "rinnovaz" -->
		    <a name='container5_B3'> </a> 
		    <div class='block10' id='div_rinnovaz'><table class='row'><caption class="span"><span>COMPOSIZIONE RINNOVAZIONE</span></caption>
		      <tr><td>
 			  <div id='rinnovaz_int' class='block'><table id='rinnovaz'>
			      <tr class='center'><td><b>Specie</b></td></tr>
			      <?php
			      foreach ($rinnovaz AS $arbo){?>
				      <tr id='tr_11_<?echo $arbo->cod_coltu ?>'>
					  <td><select name='cod_coltu_rin' onChange='javascript:schedeB3_form11("<?echo $arbo->cod_coltu ?>")'>
						  <option value='-2' >...</option>
		  					<?foreach( $diz_arbo as $d ){
								  $selected1 =($d->cod_coltu == $arbo->cod_coltu)? 'selected' : ''; 
								  if ($selected1!='') $nome= $d->nome_itali; 
								  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
							  } ?>
					  </select></td>
					  <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB3=Scheda B3&delete_rinnovazB3=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container5_B3"?>'>Elimina</a></td>
				      </tr>
	      		  <?} ?>
			      <tr>
				  <td><select name='cod_coltu_rin1'>
					  <option value='-1' > ...</option>
		 			  <?foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
				  </select></td>
				  <td colspan='2' style='text-align:center'>
				  <a href='#container5_B3' onclick='javascript:schedeB3_form10()'>Inserisci</a></td>
			      </tr>
			      </table></div>
				</td></tr>
		    </table></div> 
<!--FUNZIONE PRINCIPALE -->
			<div class='block spazio'><table width='250px' class="row"><caption>FUNZIONE PRINCIPALE</caption><tr><td>	
				<? 				
			 		echo "<select name='f'>";
					echo "<option value='' selected='selected'></option>";
					foreach( $funzion2 as $f ) {
						$selected = ( isset($infoB3->f) and $infoB3->f == $f->codice )? 'selected' : ' ' ;
						echo "<option value='$f->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; 
						echo ">$f->codice | $f->descriz</option>\n";
					}
					echo "</select>";
				?>
				</td></tr></table></div>		      
<!--FUNZIONE ACCESSORIA -->
			<div class='block spazio'><table width='250px' class="row"><caption>FUNZIONE ACCESSORIA</caption><tr><td>	
				<? 				
			 		echo "<select name='f2'>";
					echo "<option value='' selected='selected'></option>";
					foreach( $funzion2 as $f ) {
						$selected = ( isset($infoB3->f2) and $infoB3->f2 == $f->codice )? 'selected' : ' ' ;
						echo "<option value='$f->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; 
						echo ">$f->codice | $f->descriz</option>\n";
					}
					echo "</select>";
				?>
				</td></tr></table></div>	
<!-- ipotesi di intervento  -->
		    <div class='block10'><table  class='row'><caption>Ipotesi di intervento</caption><tr>
			<td width='300px'><select name='p2'>
				<option value='-1' selected='selected'></option>	
				<? foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB3->p2) and $pre->codice == $infoB3->p2 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";} ?>
			</select></td>
			</tr></table></div>
<!-- ipotesi di intervento (secondaria)  -->
		    <div class='block10'><table  class='row'><caption>Ipotesi di intervento (secondaria)</caption><tr>
			<td width='300px'><select name='p3'>
				<option value='-1' selected='selected'></option>	
				<? foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB3->p3) and $pre->codice == $infoB3->p3 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";} ?>
			</select></td>
			</tr></table></div> 
<!-- Specifiche intervento di altro tipo  -->
			<div class='block10'><table  class='row'><caption>Specifiche intervento di altro tipo</caption><tr>
			  <td width='165px'><input type='text' name='p4' value='<?echo $infoB3->p4?>' /></td> 
			</tr></table></div>		
  <!-- Proprietà e condizionamenti -->
			<div class='block'><table  class='row' width='350px'><caption class='span'><span>Priorità e condizionamenti</span></caption><tr>
				<?php foreach ( $urgenza as $k => $u ) {
				    echo "<td><input type='radio' class='radio_dis' name='g1' value='$u->codice'"; if($infoB3->g1 == $u->codice ): echo " checked"; endif; 
				    echo " /></td><th>$u->descriz</th>\n"; }  ?>
			  </tr></table></div>  
			 <div class='block10 pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div>
  <!-- subordinato alla viabilità -->
			<div class='block'><table  class='row' width='90px'><caption>subordinato alla viabilità</caption><tr>
			<td><input type='radio' class='radio_dis' name='sub_viab' value='t' <? if($infoB3->sub_viab == 't'):echo " checked"; endif;?> /></td><th>sì</th></tr>
			<tr><td><input type='radio' class='radio_dis' name='sub_viab' value='f' <? if($infoB3->sub_viab == 'f'):echo " checked"; endif;?> /></td><th>no</th>
			  </tr></table></div>        
		      
		</div> 
		<!--ds_container6_B3-->		
	</div>
	<!-- id='ds_center4_B3' -->
	</div><!-- id="opt6-7_fields"-->
	
	
<!-- ############# Coltivo #################  -->
	<div id="opt7-8_fields">
	<div id='ds_center5_B3'  class='tavole'>
		<div id="ds_container7_B3" class='tavole'> 
		<div id='biancoB3' class='block1010'><p>Coltivo</p></div>
		<!--Tipo-->
			<div class='block'><table width="180px" class="row">
				<tr>
				<?php $u_validi1 = array(7, 8);
				 foreach ($usosuolo as $u){
				 	if( in_array($u->codice, $u_validi1) ) {
						echo "<td><input type='radio' name='u' value='$u->codice' ";
						if ($infoB->u == $u->codice)  { $infoB3->u = $u->codice; echo "checked";};
						echo "/></td><th>$u->descriz</th>";
				 	}					 
				}	?>
				</tr></table>
			</div> 
		
<!-- COMPOSIZIONE ALBERATURE  --> 
			<a name='container7_B3'></a>
		    <div class='block10' id='div_albe'><table class='row'><caption class="span"><span>COMPOSIZIONE ALBERATURE</span></caption>
		      <tr><td>
 			  <div id='albe_int' class='block'><table id='alberatura'>
			      <tr class='center'><td><b>Specie</b></td></tr> 
			      <?php
			      foreach ($alberatura AS $arbo){?>
				      <tr id='tr_15_<?echo $arbo->cod_coltu ?>'>
					  <td><select name='cod_coltu_albe' onChange='javascript:schedeB3_form15("<?echo $arbo->cod_coltu?>")'>
						  <option value='-2' >...</option>
		 					 <?foreach( $diz_arbo as $d ){
								  $selected1 =($d->cod_coltu == $arbo->cod_coltu)? 'selected' : ''; 
								  if ($selected1!='') $nome= $d->nome; 
								  echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
							  } ?>
					  </select></td>
					  <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB3=Scheda B3&delete_alberaturaB3=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container7_B3"?>'>Elimina</a></td>
				      </tr>
	  		     <?} ?>
			      <tr>
				  <td><select name='cod_coltu_albe1'>
					  <option value='-1' > ...</option>
		 			  <?foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
				  </select></td>
				  <td colspan='2' style='text-align:center'>
				  <a href='#container7_B3' onclick='javascript:schedeB3_form14()'>Inserisci</a></td>
			      </tr>
		      </table></div>
			</td></tr>
		    </table></div> 
<!--DIFFUSIONE ALBERATURE-->
			<div class='block'><table width="350px" class="row"><caption class="span"><span>DIFFUSIONE ALBERATURE</span></caption>
				<tr>			
					<?php foreach ($strati as $se){
						echo "<td><input type='radio' class='radio_dis' name='diffalbcol' value='$se->codice' ";
						if ($infoB3->diffalbcol == $se->codice)  echo "checked";
						echo "/></td><th>$se->descriz</th>";
				}	?>
				</tr></table>
			</div> 	
		    </div><!--ds_container7_B3-->
		    


	</div>
	<!-- id='ds_center5_B3' -->
	</div><!-- id="opt7-8_fields"-->

	<div id='ds_center6_B3'  class='tavole'>
 	      <a name='container6'> </a> 
<!-- ############### Note alle singole voci ######################-->
<!-- qui inserisco le due variabili che poi passo al form sottostante (particelle_note_form)
che sono parametro_sing = cod_nota,  nota_sing = nota -->
			<div class='block10'><table class='row'><caption class="span"><span>NOTE alle singole voci</span></caption>
			 <tr><td>
 			  <div id='note_sing_int' class='block'><table id='note_sing'>
				<tr><td class='center'><b>Parametro</b></td><td class='center'><b>Nota</b></td></tr> 
	 			<?php if (isset($info_note) AND !empty($info_note)){
				foreach ($info_note as $in){ ?>
				<tr class='no_repeat_schA' id='tr_<?echo $in->cod_nota; ?>'><td>
				<select name='parametro_sing'> 
					<option selected='selected' value='-2' > </option>
		  			<?foreach( $note_tutte as $nt ) {
						$selected1 =($nt->nomecampo == $in->cod_nota)? 'selected' : ''; 
						echo "<option value='$nt->nomecampo' $selected1>($nt->nomecampo) $nt->intesta</option>\n";
					}?>
				</select></td>
				<td><input name='nota_sing' type='text' value='<? echo $in->nota ?>' /></td>
				<td><a href='#' onclick='javascript:schedeB3_form9("<?echo $in->cod_nota ?>")'>Salva</a></td>
				<td><a class='delete_noteA' title='<?echo $in->cod_nota?>' href='<?php echo "?page=descrp&schedB3=Scheda B3&delete_noteB3=ok&proprieta=$proprieta&particella=$particella&cod_nota=$in->cod_nota#container7_B3"?>'>Elimina</a></td>
				<?}
				} else  { echo "<tr><td>...</td><td>...</td>";	} ?>
				</tr>
				<tr><td>
				<select name='parametro_sing1'>
					<option selected='selected' value='-1' > nota...</option>
					 <? foreach( $note_tutte_dif as $ntd ) {echo "<option value='$ntd->nomecampo'>($ntd->nomecampo) $ntd->intesta</option>\n";} ?>
				</select></td>
				<td><input type='text' name='nota_sing1' value='' /></td>
				<td colspan='2' style='text-align:center'>
				<a href='#container7_B3' onclick='javascript:schedeB3_form8()'>Inserisci</a></td></tr>
			  </table></div>
		  	</td></tr>
	      </table></div>

	
			   <div id="ds_container8_B3" class='tavole'>  
<!-- NOTEj -->
			<div class='block10'><table><caption>NOTE</caption>
			<tr><td class="top"><textarea name='note' rows="5" cols="120"><?php echo $infoB3->note?></textarea> </td></tr>
			</table></div>
		</div><!--ds_container8_B3-->
	</div>
	<!-- id='ds_center6_B3' -->
		
<!-- Bottone modifica o inserisci  -->
	<div class='centro'>
	<div  class='bottone_alto'>
	      <?  echo "<div class='mod_ins'>";
		  if( empty($temp_var))
			  echo "<input class='bot_descrp ModDell confermaMOD' title='Inserisci dati di $propriet->descrizion particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>";
		  else	{ echo "<input class='bot_descrp ModDell confermaMOD' title='Modifica dati di $propriet->descrizion particella $particella' type='submit' name='modifica_dati' value='Salva modifiche' /></div>";
		 echo "<div id='cancella'><a class='bot_descrp ModDell confermaDELL' class='actions cancella' title='proprietà di $propriet->descrizion e particella $particella' href='?page=descrp&schedB3=ok&delete=ok&proprieta=$proprieta&particella=$particella'>Elimina dati</a></div>";}?>
	</div>
	</div>
<?
 }
?>


			</div>
			<!--  <div id='centra'> -->

		</div>
		<!--  <div id='descrp_schedeB3'> -->
	</form>
<!-- 	<form name="descrp_schedeB3_form" action="#" method="post"> -->

<!-- ######################## form tabelle letarali ######################################## -->
<?
if ($scheda == 'Scheda B3') 	{ ?>
<!--// Attenzione!! vedere in js la funzione "formB3_1()"-->
<!-- 	insert_arbuB3, modify_arbuB3, delete_arbuB3 -->
	<form name='formB3_2' id='formB3_2' action="#container3_B3" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_arbuB3' value='ok' />
	</form>

	<form name='formB3_3' id='formB3_3' action="#container3_B3" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_arbuB3' value='ok' />
	</form>
	
<!-- 	insert_erbaB3, modify_erbaB3, delete_erbaB3 -->
	<form name='formB3_4' id='formB3_4' action="#container3_B3" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_erbaB3' value='ok' />
	</form>

	<form name='formB3_5' id='formB3_5' action="#container3_B3" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_erbaB3' value='ok' />
	</form>

<!-- 	insert_arboB3, modify_arboB3, delete_arboB3 -->
	<form name='formB3_6' id='formB3_6' action="#container5_B3" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_arboB3' value='ok' />
	</form>

	<form name='formB3_7' id='formB3_7' action="#container5_B3" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_arboB3' value='ok' />
	</form>
<!-- 	insert_rinnovazB3, modify_rinnovazB3, delete_rinnovazB3 -->
	<form name='formB3_10' id='formB3_10' action="#container5_B3" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_rinnovazB3' value='ok' />
	</form>

	<form name='formB3_11' id='formB3_11' action="#container5_B3" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_rinnovazB3' value='ok' />
	</form>
	
<!-- 	insert_infeB3, modify_infeB3, delete_infeB3 -->
	<form name='formB3_12' id='formB3_12' action="#container5_B3" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_infeB3' value='ok' />
	</form>

	<form name='formB3_13' id='formB3_13' action="#container5_B3" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_infeB3' value='ok' />
	</form>
<!-- 	insert_alberaturaB3, modify_alberaturaB3, delete_alberaturaB3 -->
	<form name='formB3_14' id='formB3_14' action="#container7_B3" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_alberaturaB3' value='ok' />
	</form>

	<form name='formB3_15' id='formB3_15' action="#container7_B3" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_alberaturaB3' value='ok' />
	</form>
<!-- ######################## form note singole voci######################################## -->

	<form name='formB3_8' id='formB3_8' action="#container7_B3" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='insert_noteB3' value='ok' />
	</form>


	<form name='formB3_9' id='formB3_9' action="#container7_B3" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB3'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB3' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />		
		<input type='hidden' name='cod_nota_old' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='modify_noteB3' value='ok' />
	</form>



<?php } ?>
</div> 
<!-- <div id='home' class='descrp_schede'> -->
<?php
}
?>