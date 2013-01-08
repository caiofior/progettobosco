<?php
if(   isset($_REQUEST['schedB4']) ) 	{

	//assegnazione della variabili del form precedente
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
	//inizializzazione variabili
	$infoB = null ; // relative a tabella schede_b
	$infoB4 = null ; // relative a tabella schede_B4
	$cod_fo = ' 1'; //metto io forzatamente cod_fo =(spazio)1, perchè è rimasto da cose vecchie !!!!!!!!!!!!!!!!!!!!
 //###### genero l'array vuoto contenente tutti i campi della tabella schede_b e  sched_B4 che mi servono
	$arr = generate_Arr_arch('sched_b4'); 	//##
	$b =   generate_Arr_arch('schede_b');	//##
//###############################

//---------------------------- Modifica/Inserimento dati---------------------------------------------

  //se si vuole modificare o inserire i dati di una particella si fanno eseguire l'UPDATE o l'INSERT nella tabella SCHEDE_B con la funzione saveInfoDescrpB($info, $proprieta, $particella) 
	if( isset($_REQUEST['inserisci_dati']) or isset($_REQUEST['modifica_dati'])) {
	      $b = fill_Arr($b, $proprieta,$particella, $cod_fo );
	      $arr = fill_Arr($arr, $proprieta,$particella, $cod_fo );
	      	 saveInfoDescrp($b, $proprieta, $particella, 'schede_b');
	      	 saveInfoDescrp($arr, $proprieta, $particella, 'sched_b4');
	      redirect("?page=descrp&schedB4=Scheda B4&particella=$particella&proprieta=$proprieta");
	}
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
	if( isset($_REQUEST['delete']) ) {
	      $b = fill_Arr_dellB($b, $proprieta,$particella, $cod_fo );	
		saveInfoDescrp($b, $proprieta, $particella, 'schede_b');

		list( $res , $id ) = cancellaPart($proprieta, $particella, 'sched_b4') ;
		
		if( $res ) 	{die('Tornare a Descrizione Particellare');}
		else 		echo "errore" ;
	}
// --------------------------------------------------------------------------------------
	//verifica se sono già stati inseriti i dati della Scheda B4, dopo aver creato per la Scheda A (ma sono noti solo $proprietà e $particella)
	$temp_var = esisteProprietaEParticella('sched_b4', $proprieta, $particella);
	if( empty($temp_var)) { //caso in cui si debba riempire tabelle schede_b e sched_B4
		$arr['proprieta'] = $proprieta ;
		$arr['particella'] = $particella ;
 		$arr['cod_fo'] = $cod_fo ;
		$b['proprieta'] = $proprieta ;
		$b['particella'] = $particella ;
 		$b['cod_fo'] = $cod_fo ;
		$infoB = array_to_object($b) ;
		$infoB4 = array_to_object($arr) ;
	} else 	{  // caso in cui si debba solo interrogare il database perchè i dati sono già stati inseriti
		$infoB = getInfoScheda( $proprieta , $particella , 'schede_b');
 		$infoB4 = getInfoScheda($proprieta, $particella , 'sched_b4');
	}

//echo "numero variabili sched_B4 = 26 - 1 (objectid), numero variabili usate ".count($arr)." (fine)non uso neanche tipo...non so a cosa serva).  ";
//print_r($arr);

//-----------------------------Select per costruzione pagina-----------------------------------------
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di SCHEDE_A 
	$usosuolo = getCod_descriz('usosuol2');

	$regione = getDiz_regioniCod($proprieta);
	$boschi = getCodiciBoschiCodice( $proprieta );
	$propriet = getInfoPropriet( $proprieta);
	$cod_proprieta = getCod_descrizion('propriet') ;
	$vert = getCod_descriz('struttu_vert');
	$moti_macchia = getCod_descriz('moti_macchia');
	$prescriz = getCod_descriz('prescriz_globale') ;
	$strati = getCod_descriz('strati');
	$funzione = getCod_descriz('funzione') ;	
	$sistema =  getCod_descriz ('sistema');
	$urgenza = getCod_descriz('urgenza') ;
	
// ############################### formB4_a_2 e 3 ############################################################## 

 $arr_arbo_a['cod_coltu']=""; $arr_arbo_a['cod_coltu_old']=""; $arr_arbo_a['cod_coper']=""; $arr_arbo_a['ordine_inser']="";
$arr_arbo_a['id_av']="";
	$arr = fill_Arr($arr_arbo_a, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arborB4_a']) or isset($_REQUEST['modify_arborB4_a']) ) {
		$info_arbo = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbo('arboree4a', $info_arbo, $proprieta, $particella) ;
		redirect("?page=descrp&schedB4=Scheda B4&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBOREE si fanno le SELECT dalla tabella
	$arboree_a = getInfoArboree('arboree4a', $proprieta , $particella, $cod_fo );
	$per_arbo = getCod_descriz ('per_arbo') ;
	$diz_arbo = getDizArbo();

// ############################### formB4_b_2 e 3 ############################################################## 
 $arr_arbo_b['cod_coltu']=""; $arr_arbo_b['cod_coltu_old']=""; $arr_arbo_b['cod_coper']=""; $arr_arbo_b['ordine_inser']="";
$arr_arbo_b['id_av']="";
	$arr = fill_Arr($arr_arbo_b, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arborB4_b']) or isset($_REQUEST['modify_arborB4_b']) ) {
		$info_arbo = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbo('arboree4b', $info_arbo, $proprieta, $particella) ;
		redirect("?page=descrp&schedB4=Scheda B4&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBOREE si fanno le SELECT dalla tabella
	$arboree_b = getInfoArboree('arboree4b', $proprieta , $particella, $cod_fo );
	
// ################################ formB4_6 e 7 #############################################################
 $arr_erba['cod_coltu']=""; $arr_erba['cod_coltu_old']="";
 $arr_erba['id_av']="";
	$arr = fill_Arr( $arr_erba, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_erbaB4']) or isset($_REQUEST['modify_erbaB4']) ) {
		$info_erba = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_erba('erbacee4', $info_erba, $proprieta, $particella) ;
		redirect("?page=descrp&schedB4=Scheda B4&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$erbacee = getInfoErbacee('erbacee4', $proprieta , $particella, $cod_fo );
	$diz_erba = getDizErba();
// #############################################################################################
 // ############################### form per note singole voci 8 e 9 #########################################

 $arr_note['cod_nota']=""; $arr_note['cod_nota_old']=""; $arr_note['nota']="";

	if( isset($_REQUEST['insert_noteB4']) or isset($_REQUEST['modify_noteB4']) ) {
	      foreach( array_keys($arr_note) as $key ) {
		$val = ( isset($_REQUEST[$key]) )? $_REQUEST[$key] : null ;
		$arr_note[$key] = $val ;
	      }
	      $info_note = array_to_object($arr_note) ;// trasformazione da array in oggetto
	      saveInfoDescrp_note($info_note, $proprieta, $particella, 'note_B4') ;
	      redirect("?page=descrp&schedB4=Scheda B4&particella=$particella&proprieta=$proprieta");
	}

 //se si vuole semplicemente interrogare la tabella NOTE_A si fanno le SELECT con le funzioni getInfoSchedaA_note(.., ..) dalla tabella
	$info_note = getInfoScheda_note ($proprieta, $particella, 'note_B4');
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di note_A 
	$note_tutte= getInfoSchedaNoteTutte ('schede_b');
	$note_tutte_dif= getInfoSchedaNoteTutte_dif ('schede_b', 'note_B4');

// #############################################################################################	
// ------------------------------------------------------------
?>

<div id='home' class='descrp_schede schedeB4'>
	<form name="descrp_schedeB4_form" action="#" method="post">
	<input type='hidden' name='schedB4' value='ok' />
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
					  // se la ho già inserito la SCHEDA_B4 allora tasto Modifica, altrimenti tasto Inserisci
						  echo "<input class='bot_descrp ModDell confermaMOD' title='Inserisci dati di $propriet->descrizion particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>";
					  else	{ echo "<input class='bot_descrp ModDell confermaMOD' title='Modifica dati di $propriet->descrizion particella $particella' type='submit' name='modifica_dati' value='Salva modifiche' /></div>";
					//ancora per query DELITE e che mi rimanda alla pagina descrp_schedeA.php
					 echo "<div id='cancella'><a class='bot_descrp ModDell confermaDELL' class='actions cancella' title='proprietà di $propriet->descrizion e particella $particella' href='?page=descrp&schedB4=ok&delete=ok&proprieta=$proprieta&particella=$particella'>Elimina dati</a></div>";}?>
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
//------------------------------------------------------------ Scheda B4 -------------------------------------------------
if ($scheda == 'Scheda B4')  {  ?>

	<div id='ds_center1_B4' >
		<div id="ds_container1_B4" class='tavole'>
		      <div id='ds_title_B4' class='block'>Scheda B4 per la descrizione di una<br />FORMAZIONE A MACCHIA MEDITERRANEA </div>
<!--Particella/Sottoparticella-->
		      <div class='block1010'><table width='200px'><caption>Particella/Sottoparticella</caption>
		      <tr><td><?php echo $particella ?></td></tr></table></div>
		      <input type='hidden' name='particella' value ='<?php echo $particella; ?>' />
		</div> <!--id="ds_container" class='tavole'-->

		<div id="ds_container2_B4" class='tavole'>
<!--Tipo-->
			<div class='block1010' ><table class="row" width='200px'><caption class="span"><span>Tipo</span></caption>
				<tr><td><input type='checkbox' name='u' value='13' <? if ($infoB->u == '13'): echo "checked"; endif; ?> /></td><th>formazione a macchia mediterranea</th></tr></table>
			</div> 
<!--Tipo forestale-->
			<div class='block spazio'><table width='300px' class="row"><caption>Tipo forestale</caption><tr><td>	
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
		<!--id="ds_container2_B4" class='tavole'-->
	</div>
	<!-- id='ds_center1_B4' -->

	<div id='ds_center2_B4'  class='tavole'>
		<div class="riga_schedeB4"><p></p></div>
		
		<div id="ds_container3_B4" class='tavole'>
		<a name='container3_B4'> </a> 		
<!--Struttura verticale -->
			<div class='block spazio'><table width="300px" class="row"><caption class="span"><span>Struttura verticale</span></caption>
				<tr><?php foreach ($vert as $v){
						echo "<td><input type='radio' class='radio_dis' name='vert' value='$v->codice' ";
						if ($infoB4->vert == $v->codice)  echo "checked";
						echo "/></td><th>$v->descriz</th>";
				}	?>
				</tr></table>
			</div> 	
			
<!-- ####################### Piano Dominato ########################  -->
			<div class='block1010 biancoB4'><p>Piano Dominato o strato fino ad altezza 2m </p></div>
<!-- Altezza media -->
			<div class='block10'><table width='100px' class="row"><caption>Altezza media</caption> 
				<tr><td><input type="text"  class='num' name="h_min2" value='<? echo $infoB4->h_min2 ?>' /></td></tr></table>
			</div>
<!-- Copertura (%) -->
			<div class='block10'><table width='100px' class="row"><caption>Copertura (%)</caption> 
				<tr><td><input type="text"  class='perc' name="ce_min2" value='<? echo $infoB4->ce_min2 ?>' /></td></tr></table>
			</div>	
<!-- composizione strato arboreo  -->
	      <div id='arboree' class='block'><table class='row'><caption class="span"><span>Composizione strato arboreo-arbustivo</span></caption>
			<tr><td>
		      	<div id='arboree_int' class='block'><table id='arboree'>			
					<tr class='center'><td><b>Specie</b></td><td><b>Copertura</b></td><td width='50px'><b>Ordine</b></td></tr>
					<?php
					foreach ($arboree_a AS $arbo){?>
						<tr id='tr_3_<?echo $arbo->cod_coltu ?>'>
						    <td><select name='cod_coltu_arboa'>
							    <option value='-2' >...</option>
			    					<?foreach( $diz_arbo as $d ){
									    $selected1 =($d->cod_coltu == $arbo->cod_coltu)? 'selected' : ''; 
									    echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
								    } ?>
						    </select></td>
						    <td><select name='cod_coper_arboa'>
							    <option value='-2' >...</option>
			    					<?foreach( $per_arbo as $p ){
									    $selected1 =($p->codice == $arbo->cod_coper)? 'selected' : ''; 
									    echo "<option value='$p->codice' $selected1 >$p->descriz</option>\n";
								    } ?>
						    </select></td>
						    <td><input type='text' name='ordine_inser_arboa' value='<?echo $arbo->ordine_inser?>' /></td>
						    <td><a href='#container3_B4' onclick='javascript:schedeB4_a_form3("<?echo $arbo->cod_coltu ?>")'>Salva</a></td>
						    <td><a class='delete_confirm' title='<?echo $arbo->cod_coltu?>' href='<?php echo "?page=descrp&schedB4=Scheda B4&delete_arboreeB4_a=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container3_B4"?>'>Elimina</a></td>
						</tr>
					<?} ?>
					<tr>
					    <td><select name='cod_coltu_arboa1'>
						    <option value='-1' > ...</option>
			    			<?foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
					    </select></td>
					    <td><select name='cod_coper_arboa1'>
						    <option value='-1' > ...</option>
			    			<?foreach( $per_arbo as $p ) echo "<option value='$p->codice'>$p->descriz</option>\n";?>
					    </select></td>
					    <td><input type='text' name='ordine_inser_arboa1' value='' /></td>
					    <td colspan='2' style='text-align:center'>
					    <a href='#container3_B4' onclick='javascript:schedeB4_a_form2()'>Inserisci</a></td>
					</tr>
		      </table></div> <!-- <div id='arboree_int' class='block'><table id='arboree'> -->	
		      </td></tr>
	      </table></div> 
		</div> 
		<!--ds_container3_B4-->	      
<!-- ####################### Piano Dominante ########################  -->
		<div id="ds_container4_B4" class='tavole'>
			
			<div class='block1010 biancoB4'><p>Piano Dominante o strato oltre i 2m di altezza</p></div>
<!-- Altezza media -->
			<div class='block10'><table width='100px' class="row"><caption>Altezza media</caption> 
				<tr><td><input type="text"  class='num' name="h_mag2" value='<? echo $infoB4->h_mag2 ?>' /></td></tr></table>
			</div>
<!-- Copertura (%) -->
			<div class='block10'><table width='100px' class="row"><caption>Copertura (%)</caption> 
				<tr><td><input type="text"  class='perc' name="ce_mag2" value='<? echo $infoB4->ce_mag2 ?>' /></td></tr></table>
			</div>	
<!-- composizione strato arboreo- arbust -->
	      <div id='arboree_b' class='block'><table class='row'><caption class="span"><span>Composizione strato arboreo-arbustivo</span></caption>
			<tr><td>
		      	<div id='arboree_b_int' class='block'><table id='arboree_b'>
			<tr class='center'><td><b>Specie</b></td><td><b>Copertura</b></td><td width='50px'><b>Ordine</b></td></tr>
			<?php
			foreach ($arboree_b AS $arbo){?>
				<tr id='tr_3_<?echo $arbo->cod_coltu ?>'>
				    <td><select name='cod_coltu_arbob'>
					    <option value='-2' >...</option>
	    				<?foreach( $diz_arbo as $d ){
							    $selected1 =($d->cod_coltu == $arbo->cod_coltu)? 'selected' : ''; 
							    echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
						    } ?>
				    </select></td>
				    <td><select name='cod_coper_arbob'>
					    <option value='-2' >...</option>
	    					<?foreach( $per_arbo as $p ){
							    $selected1 =($p->codice == $arbo->cod_coper)? 'selected' : ''; 
							    echo "<option value='$p->codice' $selected1 >$p->descriz</option>\n";
						    } ?>
				    </select></td>
				    <td><input type='text' name='ordine_inser_arbob' value='<?echo $arbo->ordine_inser?>' /></td>
				    <td><a href='#container3_B4' onclick='javascript:schedeB4_b_form3("<?echo $arbo->cod_coltu ?>")'>Salva</a></td>
				    <td><a class='delete_confirm' title='<?echo $arbo->cod_coltu?>' href='<?php echo "?page=descrp&schedB4=Scheda B4&delete_arboreeB4_b=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container3_B4"?>'>Elimina</a></td>
				</tr>
			<?} ?>
			<tr>
			    <td><select name='cod_coltu_arbob1'>
				    <option value='-1' > ...</option>
	   				 <? foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
			    </select></td>
			    <td><select name='cod_coper_arbob1'>
				    <option value='-1' > ...</option>
	    			<? foreach( $per_arbo as $p ) echo "<option value='$p->codice'>$p->descriz</option>\n";?>
			    </select></td>
			    <td><input type='text' name='ordine_inser_arbob1' value='' /></td>
			    <td colspan='2' style='text-align:center'>
			    <a href='#container3_B4' onclick='javascript:schedeB4_b_form2()'>Inserisci</a></td>
			</tr>
			</td></tr>
	      </table></div> 
	      </table></div> 			
				</div> 
				<!--ds_container4_B4-->
	</div>
	<!-- id='ds_center2_B4' -->


	<div id='ds_center3_B4'  class='tavole'>
		<div id="ds_container5_B4" class='tavole'>
<!-- Motivo -->	
			<div class='block spazio'><table width="700px" class="row"><caption class="span"><span>Motivo che ha determinato e/o determina l'esistenza della macchia meriterr.</span></caption>
				<tr><?php foreach ($moti_macchia as $motivo1){
						echo "<td><input type='radio' class='radio_dis' name='motivo1' value='$motivo1->codice' ";
						if ($infoB4->motivo1 == $motivo1->codice)  echo "checked";
						echo "/></td><th>$motivo1->descriz</th>";
				}	?>
				<td><table><tr><th><input type="text"  width="80px" class="motivo2" name="motivo2" value='<? echo $infoB4->motivo2 ?>' /></th></tr></table></td>
				</tr></table>
			</div> 	
<!--Strato erbaceo-->
			<div class='block10'><table width='120px' class="row"><caption class="span"><span>Strato erbaceo</span></caption>
				<?foreach ($strati As $st){
					echo "<tr><td><input type='radio' class='radio_dis' name='se' value='$st->codice'"; if ($infoB4->se == $st->codice): echo "checked"; endif; echo "/></td><th>".$st->descriz."</th></tr>\n";
				} echo "</tr>"; ?>
			</table></div>
 <!-- specie significative strato erbaceo  -->
<!-- 	insert_erbaB4, modify_erbaB4, delete_erbaB4 -->
		      <div id='div_erbacee' class='block1010'>
		      <table class='row'><caption class="span"><span>Specie erbacee significative</span></caption>
		     <tr><td>
		     	<div id='erbacee_int'class='block' ><table id='erbacee' >
				    <tr><td><b>Specie</b></td></tr>
					<?php
					foreach ($erbacee AS $erba){ ?>
					    <tr id='tr_7_<?echo $erba->cod_coltu ?>'>
					      <td><select name='cod_coltu_erba' onChange='javascript:schedeB4_form7("<?echo $erba->cod_coltu?>" )'>
						<option value='-2' >...</option>
		  				<?foreach( $diz_erba as $d ){
								$selected1 =($d->cod_coltu == $erba->cod_coltu)? 'selected' : ''; 
								if ($selected1!='') $nome= $d->nome; 
								echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome</option>\n";
						    } ?>
					      </select></td>
					      <td><a class='delete_confirm' title='<?echo $nome?>' href='<?php echo "?page=descrp&schedB4=Scheda B4&delete_erbaB4=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$erba->cod_coltu#container3_B4"?>'>Elimina</a></td>
					    </tr>
		  			<?}?>
					<tr>
				    <td><select name='cod_coltu_erba1'>
				      <option value='-1' > ...</option>
					<?foreach( $diz_erba as $d ) 
						{echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome</option>\n";}?>
				    </select></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#container3_B4' onclick='javascript:schedeB4_form6()'>Inserisci</a></td>
				 	</tr>
			  </table></div>
		     </td></tr>
			</table></div> 	
			
<div id="ds_container6_B4" class='tavole'>	
			    <a name='container6_B4'> </a> 			
<!-- Interventi recenti -->
		    <div class='block10'><table class='row' width='250px'><caption>Interventi recenti</caption><tr>
			<td><select name='int2'> 
				<option value='-1' selected='selected'></option>
				<? foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB4->int2) and $pre->codice == $infoB4->int2 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n"; } ?>
			</select></td>
			</tr></table></div>	
			<div class='block10'><table class='row'><caption>Specifiche</caption><tr>
			  <td width='120px'><input type='text' name='int3' value='<? echo $infoB4->int3 ?>' /></td>
			</tr></table></div>	
<!--FUNZIONE-->
			<div class='block spazio'><table width='250px' class="row"><caption>Funzione</caption><tr><td>	
				<? 				
			 		echo "<select name='f'>";
					echo "<option value='' selected='selected'></option>";
					foreach( $funzione as $f ) {
						$selected = ( isset($infoB4->f) and $infoB4->f == $f->codice )? 'selected' : ' ' ;
						echo "<option value='$f->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; 
						echo ">$f->codice | $f->descriz</option>\n";
					}
					echo "</select>";
				?>
				</td></tr></table></div>
		</div>		
<!-- 	ds_container6_B4	-->		
<!-- orientamento selviculturale -->
		     <div class='block10'><table class='row'  width='750px'><caption class='span'><span>Orientamento selviculturale</span></caption><tr>
			   <?php $i=1;
			   foreach ( $sistema AS $k => $g ) {
				echo "<td><input type='radio' class='radio_dis' name='g' value='$g->codice'"; if($infoB4->g == $g->codice ): echo " checked"; endif; 
				echo " /></td><th>$g->descriz</th>\n";
				if ( $i == ceil(count($sistema)/2) ) echo "</tr></tr>\n";
				$i++;}  ?>
		      </tr></table></div>  		      		
		</div> 
		<!--ds_container5_B4-->
	
		<div id="ds_container7_B4" class='tavole'>	
<!-- ipotesi intervento futuro  -->
		       <div class='block10'><table  class='row'><caption>Ipotesi di intervento futuro</caption><tr>
				<td width='300px'><select name='p2'>
				<option value='-1' selected='selected'></option>
				<?$prescriz = getCod_descriz('prescriz') ;	
				foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB4->p2) and $pre->codice == $infoB4->p2 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";}?>
			</select></td>
			</tr></table></div>
<!--ipotesi intervento futuro  secondario -->
			<div class='block10'><table  class='row'><caption>Ipotesi di intervento futuro (secondaria)</caption><tr>
			<td width='300px'><select name='p3'>
				echo "<option value='-1' selected='selected'></option>
				<?$prescriz = getCod_descriz('prescriz') ;	
				foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB4->p3) and $pre->codice == $infoB4->p3 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";} ?>
			</select></td>
			</tr></table></div>
			<div class='block10'><table  class='row'><caption>Specifiche</caption><tr>
			  <td width='120px'><input type='text' name='p4' value='<? echo $infoB4->p4 ?>' /></td>
			</tr></table></div>	     
  <!-- Proprietà e condizionamenti -->
			<div class='block'><table  class='row' width='350px'><caption class='span'><span>Priorità e condizionamenti</span></caption><tr>
				<?php foreach ( $urgenza as $k => $u ) {
				    echo "<td><input type='radio' class='radio_dis' name='g1' value='$u->codice'"; if($infoB4->g1 == $u->codice ): echo " checked"; endif; 
				    echo " /></td><th>$u->descriz</th>\n"; }  ?>
			  </tr></table></div>  
			 <div class='block10 pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div>
  <!-- subordinato alla viabilità -->
			<div class='block'><table  class='row' width='70px'><caption>subordinato alla viabilità</caption><tr>
			<td><input type='radio' class='radio_dis' name='sub_viab' value='t' <? if($infoB4->sub_viab == 't'):echo " checked"; endif;?> /></td><th>sì</th></tr>
			<tr><td><input type='radio' class='radio_dis' name='sub_viab' value='f' <? if($infoB4->sub_viab == 'f'):echo " checked"; endif;?> /></td><th>no</th>
			  </tr></table></div>    
		</div> 
		<!--ds_container7_B4-->
		
	</div>
	<!-- id='ds_center3_B4' -->
	
		    
<!-- NOTEj -->


	<div id='ds_center4_B4'  class='tavole'>
<!-- ############### Note alle singole voci ######################-->
<!-- qui inserisco le due variabili che poi passo al form sottostante (particelle_note_form)
che sono parametro_sing = cod_nota,  nota_sing = nota -->
			<div  id='div_note_sing' class='block10'><table class='row'><caption class="span"><span>NOTE alle singole voci</span></caption>
			 <tr><td>
		     	<div id='note_sing_int'class='block' ><table id='note_sing' >
			
			<tr><td class='center' width='50%'><b>Parametro</b></td><td class='center' width='50%'><b>Nota</b></td></tr> 
<?php			foreach ($info_note as $in){ ?>
			<tr class='no_repeat_schA' id='tr_<?echo $in->cod_nota; ?>'><td>
			<select name='parametro_sing'> 
				<option selected='selected' value='-2' > </option>
<?	  			foreach( $note_tutte as $nt ) {
					$selected1 =($nt->nomecampo == $in->cod_nota)? 'selected' : ''; 
					echo "<option value='$nt->nomecampo' $selected1>($nt->nomecampo) $nt->intesta</option>\n";
				}?>
			</select></td>
			<td><input name='nota_sing' type='text' value='<? echo $in->nota ?>' /></td>
			<td><a href='#container6_B4' onclick='javascript:schedeB4_form9("<?echo $in->cod_nota ?>")'>Salva</a></td>
			<td><a class='delete_noteA' title='<?echo $in->cod_nota?>' href='<?php echo "?page=descrp&schedB4=Scheda B4&delete_noteB4=ok&proprieta=$proprieta&particella=$particella&cod_nota=$in->cod_nota#container6_B4"?>'>Elimina</a></td>
<?			} ?>
		</tr>
		<tr><td>
		<select name='parametro_sing1'>
			<option selected='selected' value='-1' > nota...</option>
			 <? foreach( $note_tutte_dif as $ntd ) {echo "<option value='$ntd->nomecampo'>($ntd->nomecampo) $ntd->intesta</option>\n";} ?>
		</select></td>
		<td><input type='text' name='nota_sing1' value='' /></td>
		<td colspan='2' style='text-align:center'>
		<a href='#container7_B4' onclick='javascript:schedeB4_form8()'>Inserisci</a></td></tr>
		 </table></div>
		     </td></tr>
	      </table></div>
	      
	  <!-- NOTEj -->
			<div class='block10'><table width='900px' height='100px'><caption>NOTE</caption>
			<tr><td class="top"><textarea name='note' rows="5" cols="120"><?php echo $infoB4->note?></textarea> </td></tr>
			</table></div>
	      
	</div>
	<!-- id='ds_center4_B4' -->
	
<!-- Bottone modifica o inserisci  -->
	<div class='centro'>
	<div  class='bottone_alto'>
	      <?  echo "<div class='mod_ins'>";
		  if( empty($temp_var))
		  // se la ho già inserito la SCHEDA_B4 allora tasto Modifica, altrimenti tasto Inserisci
			  echo "<input class='bot_descrp ModDell confermaMOD' title='Inserisci dati di $propriet->descrizion particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>";
		  else	{ echo "<input class='bot_descrp ModDell confermaMOD' title='Modifica dati di $propriet->descrizion particella $particella' type='submit' name='modifica_dati' value='Salva modifiche' /></div>";
		//ancora per query DELITE e che mi rimanda alla pagina descrp_schedeA.php
		 echo "<div id='cancella'><a class='bot_descrp ModDell confermaDELL' class='actions cancella' title='proprietà di $propriet->descrizion e particella $particella' href='?page=descrp&schedB4=ok&delete=ok&proprieta=$proprieta&particella=$particella'>Elimina dati</a></div>";}?>
	</div>
	</div>
<?
 }
?>


			</div>
			<!--  <div id='centra'> -->

		</div>
		<!--  <div id='descrp_schedeB4'> -->
	</form>
<!-- 	<form name="descrp_schedeB4_form" action="#" method="post"> -->

<!-- ######################## form tabelle letarali ######################################## -->
<?
if ($scheda == 'Scheda B4') 	{ ?>
<!--// Attenzione!! vedere in js la funzione "formB4_1()"-->
<!-- 	insert_arbuB4, modify_arbuB4, delete_arbuB4 --> <!-- 	insert_arborB4_a, modify_arborB4_a, delete_arboreeB4_a -->
	<form name='formB4_a_2' id='formB4_a_2' action="#container3_B4" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='insert_arborB4_a' value='ok' />
	</form>

	<form name='formB4_a_3' id='formB4_a_3' action="#container3_B4" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='modify_arborB4_a' value='ok' />
	</form>
	
<!-- ######################## ######################## -->
 <!-- 	insert_arborB4_b, modify_arborB4_b, delete_arboreeB4_b -->
	<form name='formB4_b_2' id='formB4_b_2' action="#container3_B4" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='insert_arborB4_b' value='ok' />
	</form>

	<form name='formB4_b_3' id='formB4_b_3' action="#container3_B4" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='modify_arborB4_b' value='ok' />
	</form>
<!-- 	insert_erbaB4, modify_erbaB4, delete_erbaB4 -->
	<form name='formB4_6' id='formB4_6' action="#container3_B4" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_erbaB4' value='ok' />
	</form>

	<form name='formB4_7' id='formB4_7' action="#container3_B4" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_erbaB4' value='ok' />
	</form>

<!-- ######################## form note singole voci######################################## -->

	<form name='formB4_8' id='formB4_8' action="#container6_B4" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='insert_noteB4' value='ok' />
	</form>


	<form name='formB4_9' id='formB4_9' action="#container6_B4" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB4'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB4' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />		
		<input type='hidden' name='cod_nota_old' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='modify_noteB4' value='ok' />
	</form>



<?php } ?>
</div> 
<!-- <div id='home' class='descrp_schede'> -->
<?php
}
?>