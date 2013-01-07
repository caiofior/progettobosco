<?php
if(   isset($_REQUEST['schedB1']) ) 	{

// 	inserisco controlli e azioni relativi alla scheda_b
	include('descrp_schedeB_actions.php') ;

	//assegnazione della variabili del form precedente
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
	//inizializzazione variabili
	$infoB = null ; // relative a tabella schede_b
	$infoB1 = null ; // relative a tabella schede_b1
	$cod_fo = ' 1'; //metto io forzatamente cod_fo =(spazio)1, perchè è rimasto da cose vecchie !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	$id_av = $proprieta.$particella.$cod_fo;
 //###### genero l'array vuoto contenente tutti i campi della tabella schede_b e  sched_b1 che mi servono
	$arr =   generate_Arr_arch('sched_b1');	//##
	$b =   generate_Arr('schede_b');	//##
 //###############################

//----------------------------Modifica/Inserimento dati-----------------------------------------
  //se si vuole modificare o inserire i dati di una particella si fanno eseguire l'UPDATE o l'INSERT nella tabella SCHEDE_B con la funzione saveInfoDescrpB($info, $proprieta, $particella) 
	if( isset($_REQUEST['inserisci_dati']) or isset($_REQUEST['modifica_dati'])) {
	      $b = fill_Arr($b, $proprieta,$particella, $cod_fo );
	      $arr = fill_Arr($arr, $proprieta,$particella, $cod_fo );
	      	 saveInfoDescrp($b, $proprieta, $particella, 'schede_b');
	      	 saveInfoDescrp($arr, $proprieta, $particella, 'sched_b1');

			// $scheda = 'Scheda B1';
	      redirect("?page=descrp&schedB1=Scheda B1&particella=$particella&proprieta=$proprieta");
	}
// cancellazione di una particella inserita nella scheda_a, con l'ancora href='?page=descrp&delete=$proprieta&particella=$particella'
	if( isset($_REQUEST['delete']) ) {
	      $b = fill_Arr_dellB($b, $proprieta,$particella, $cod_fo );	
		saveInfoDescrp($b, $proprieta, $particella, 'schede_b');

		list( $res , $id ) = cancellaPart($proprieta, $particella, 'sched_b1') ;
		
		if( $res ) 	{die('<br> Tornare a Descrizione Particellare');}
		else 		echo "errore" ;
	}
//----------------------------------------------------------------------------------------------------

	//verifica se sono già stati inseriti i dati della Scheda B1, dopo aver creato per la Scheda A (ma sono noti solo $proprietà e $particella)
	$temp_var = esisteProprietaEParticella('sched_b1', $proprieta, $particella);
	if( empty($temp_var)) { //caso in cui si debba riempire tabelle schede_b e sched_b1
		$arr['proprieta'] = $proprieta ;
		$arr['particella'] = $particella ;
 		$arr['cod_fo'] = $cod_fo ;
		$b['proprieta'] = $proprieta ;
		$b['particella'] = $particella ;
 		$b['cod_fo'] = $cod_fo ;
		$infoB = array_to_object($b) ;
		$infoB1 = array_to_object($arr) ;
	} else 	{  // caso in cui si debba solo interrogare il database perchè i dati sono già stati inseriti
		$infoB = getInfoScheda( $proprieta , $particella , 'schede_b');
 		$infoB1 = getInfoScheda($proprieta, $particella , 'sched_b1');
	}
//echo "numero variabili sched_b1 = 64 - 1 (objectid), numero variabili usate ".count($arr)." fine.  ";

//-----------------------------Select per costruzione pagina-----------------------------------------
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di SCHEDE_A 
	$regione = getDiz_regioniCod($proprieta);
	$boschi = getCodiciBoschiCodice( $proprieta );
	$propriet = getInfoPropriet( $proprieta);
	//   $struttura = getStruttura ($infoB1->s);

//dalla tabella Schede_b
//   $codici = getProprieta_scheda('schede_b');
	$pres_ass = getPresAss(); 

	$origine = array(1=>'dissemin. naturale', 'artificiale', 'agamica o ceduo in conver.', 'bosco neo formazione');    
      // tabelle proprieta descriz
	$cod_proprieta = getCod_descrizion('propriet') ;
	$struttura = getCod_descriz_struttu('struttu', $regione->codice) ;	
	$matrici = getCod_descriz('matrici');
	$origine = getCod_descriz('origine');
	$vigoria = getCod_descriz('vigoria'); 
	$densita = getCod_descriz (trim('$densita', '$'));
	$strati = getCod_descriz ('strati');
	$novell = getCod_descriz ('novell');
	$car_nove = getCod_descriz ('car_nove');
	$rinnov = getCod_descriz ('rinnov');
	$sistema =  getCod_descriz ('sistema');
	$intesta_int2 = getIntestazione('sched_b1', 'int2')->intesta;

//----------------------------------------------------------------------

// ############################### formB1_2 e 3 ############################################################## 

 $arr_arbo['cod_coltu']=""; $arr_arbo['cod_coltu_old']=""; $arr_arbo['cod_coper']=""; $arr_arbo['ordine_inser']="";
$arr_arbo['id_av']="";

	 $arr = fill_Arr($arr_arbo, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arborB1']) or isset($_REQUEST['modify_arborB1']) ) {
		$info_arbo = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbo('arboree', $info_arbo, $proprieta, $particella) ;
	      redirect("?page=descrp&schedB1=Scheda B1&particella=$particella&proprieta=$proprieta");
	}

//se si vuole semplicemente interrogare la tabella ARBOREE si fanno le SELECT dalla tabella
	$arboree = getInfoArboree('arboree', $proprieta , $particella, $cod_fo );
	$per_arbo = getCod_descriz ('per_arbo') ;
	$diz_arbo = getDizArbo();
 
// ################################ formB1_4 e 5 #############################################################
 $arr_arbu['cod_coltu']=""; $arr_arbu['cod_coltu_old']=""; $arr_arbu['id_av']="";

	$arr = fill_Arr($arr_arbu, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_arbuB1']) or isset($_REQUEST['modify_arbuB1']) ) {
		$info_arbu = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_arbu('arbusti', $info_arbu, $proprieta, $particella) ;
	      redirect("?page=descrp&schedB1=Scheda B1&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$arbusti = getInfoArbusti( 'arbusti', $proprieta , $particella, $cod_fo );
// 	$diz_arbo = getDizArbo(); usata questa funzione anche per gli arbusti, perchè hanno la stessa tabella degli alberi
// #############################################################################################

// ################################ formB1_6 e 7 #############################################################
 $arr_erba['cod_coltu']=""; $arr_erba['cod_coltu_old']=""; $arr_erba['id_av']="";
 
	$arr = fill_Arr($arr_erba, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_erbaB1']) or isset($_REQUEST['modify_erbaB1']) ) {
		$info_erba = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_erba('erbacee', $info_erba, $proprieta, $particella) ;
	      redirect("?page=descrp&schedB1=Scheda B1&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBUSTI si fanno le SELECT dalla tabella
	$erbacee = getInfoErbacee( 'erbacee', $proprieta , $particella, $cod_fo );
	$diz_erba = getDizErba();
// #############################################################################################
// ############################### formB1_10 e 11 ############################################################## 

 $arr_stime['cod_coltu']=""; $arr_stime['cod_coltu_old']=""; $arr_stime['cod_coper']=""; $arr_stime['massa_tot']="";
$arr_stime['id_av']="";

	 $arr = fill_Arr($arr_stime, $proprieta, $particella, $cod_fo );
	if( isset($_REQUEST['insert_specieB1']) or isset($_REQUEST['modify_specieB1']) ) {
		$info_stime = array_to_object($arr) ;// trasformazione da array in oggetto
		saveInfoDescrp_stime('stime_b1', $info_stime, $proprieta, $particella) ;
	      redirect("?page=descrp&schedB1=Scheda B1&particella=$particella&proprieta=$proprieta");
	}
//se si vuole semplicemente interrogare la tabella ARBOREE si fanno le SELECT dalla tabella
	$stime_b1 = getInfoStime('stime_b1', $proprieta , $particella, $cod_fo );

// ############################### form per note singole voci ############################################################## 

 $arr_note['cod_nota']=""; $arr_note['cod_nota_old']=""; $arr_note['nota']="";

	if( isset($_REQUEST['insert_noteB1']) or isset($_REQUEST['modify_noteB1']) ) {
	      foreach( array_keys($arr_note) as $key ) {
		$val = ( isset($_REQUEST[$key]) )? $_REQUEST[$key] : null ;
		$arr_note[$key] = $val ;
	      }
	      $info_note = array_to_object($arr_note) ;// trasformazione da array in oggetto
	      saveInfoDescrp_note($info_note, $proprieta, $particella, 'note_b') ;
	      redirect("?page=descrp&schedB1=Scheda B1&particella=$particella&proprieta=$proprieta");
	}

 //se si vuole semplicemente interrogare la tabella NOTE_A si fanno le SELECT con le funzioni getInfoSchedaA_note(.., ..) dalla tabella
	$info_note = getInfoScheda_note ($proprieta, $particella, 'note_b');
	// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di note_A 
	$note_tutte= getInfoSchedaNoteTutte ('schede_b');
	$note_tutte_dif= getInfoSchedaNoteTutte_dif ('schede_b', 'note_b');
// #############################################################################################

?>

<div id='home' class='descrp_schede schedeB1'>
	<form name="descrp_schedeB1_form" action="#" method="post">
	<input type='hidden' name='schedB1' value='ok' />
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
					  if( empty($temp_var)){ ?>
					  <!-- // se la ho già inserito la SCHEDA_B1 allora tasto Modifica, altrimenti tasto Inserisci -->
						  <input class='bot_descrp ModDell confermaMOD' title='<? echo "proprietà ".$propriet->descrizion." e particella ".$particella?>' type='submit' name='inserisci_dati' value='Inserisci dati' /></div>
					  <?} else	{?> <input class='bot_descrp ModDell confermaMOD' title='<? echo "proprietà ".$propriet->descrizion." e particella ",$particella?>' type='submit' name='modifica_dati' value='Salva modifiche' /></div>
					  <!--//ancora per query DELITE e che mi rimanda alla pagina descrp_schedeA.php-->
						  <div id='cancella'><a class='bot_descrp ModDell confermaDELL' class='actions cancella' title='proprietà di <?echo $propriet->descrizion?> e particella <?echo $particella?>' href='<?echo "?page=descrp&schedB1=ok&delete=ok&proprieta=$proprieta&particella=$particella"?>'>Elimina dati</a></div>
					 <? }?>
				</div>
<!-- Bosco  -->
				<div id='ds_top_top' class='daticat'>
				      <div class='block10'><table width='400px' class="row"><caption>Bosco</caption>
				      <tr><td> 
					  <select  name='proprieta'>
					    <option value='' selected='selected'></option>
					<?php foreach( $cod_proprieta as $cod ) {
						$selected = ( isset($infoB1->proprieta) and $infoB1->proprieta == $cod->codice )? 'selected' : '' ;
						echo "<option value='$cod->codice' $selected>$cod->codice | $cod->descrizion</option>\n";/*value='$cod->codice' */ } ?>
				      </select></td></tr></table></div>
				</div> <!--id='ds_top_top' class='daticat'-->
			</div>
<!-- 			<div id='descrp_schede_top'>   -->

<?php
//------------------------------------------------------------ Scheda B1 -------------------------------------------------
if ($scheda == 'Scheda B1')  {   

?>  
	<div id='ds_center1_B1' >
		<div id="ds_container1_B1" class='tavole'>
		      <div id='ds_title_B1' class='block'>Scheda B1 per la descrizione di una<br />FORMAZIONE ARBOREA</div>
<!--Particella/Sottoparticella-->
		      <div class='block1010'><table width='200px'><caption>Particella/Sottoparticella</caption>
		      <tr><td><?php echo $particella ?></td></tr></table></div>
		      <input type='hidden' name='particella' value ='<?php echo $particella; ?>' />
		</div> <!--id="ds_container" class='tavole'-->

		<div id="ds_container2_B1" class='tavole'>
<!--Cod_fo ATTENZIONE intentato da me!!!-->
<!--			<div class='block1010 spazio'><table class="row"><caption class="span"><span width='250px'>Codice Forestale</span></caption>
				<tr><td> <input type='text' name='cod_fo' value='<? //echo "$infoB1->cod_fo"?>' /></td></table>
			</div> -->
<!--Tipo-->
			<div class='block1010 spazio'><table class="row"><caption class="span"><span>Tipo</span></caption>
				<tr><td><input type='checkbox' name='u' value='1' <? if ($infoB->u == '1'): echo "checked"; endif; ?> /></td><th>formazione arborea</th></tr></table>
			</div> 
<!--Tipo forestale-->
			<div class='block1010'><table width='400px' class="row"><caption>Tipo forestale</caption><tr><td>	
				<? $tipologia = getCod_descriz_regione('diz_tipi',$regione->codice ) ;
if (!isset($tipologia)) echo "In diz_tipi non c'è il codice $regione->codice ($regione->descriz)'";
 else{ 				echo "<select name='t'>";
					echo "<option value='' selected='selected'></option>";
					foreach( $tipologia as $tip ) {
						$selected = ( isset($infoB->t) and $infoB->t == $tip->codice )? 'selected' : ' ' ;
						echo "<option value='$tip->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$tip->codice | $tip->descriz</option>\n";}
				echo "</select>";/*echo "<input type='text' name='t' value='$infoB->t' />\n ";*/ 	}?>
				</td></tr></table>
 				 
			</div>
		</div> <!--id="ds_container2_B1" class='tavole'-->
	</div><!-- id='ds_center1_B1' -->

    <div id='ds_center2_B1'  class='tavole'>
	    <div id="ds_container3_B1" class='tavole'>
 <!-- Struttura e sviluppo  -->
		    <div class='block10'><table width='280px' class="row"><caption>Struttura e sviluppo</caption><tr><td>	  
				<? echo "<select name='s'>";
					echo "<option value='-1' selected='selected'></option>\n";
					foreach( $struttura as $str ) {
						$selected = ( isset($infoB1->s) and  $infoB1->s == $str->codice)? 'selected' : ' ' ;
						echo "<option value='$str->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$str->codice | $str->descriz</option>\n";}
				echo "</select>";?>
			</td></tr></table></div>
<!-- Matricinatura  -->
		    <div class='block'><table width='350px'  class='row'><caption class="span"><span>Matricinatura</span></caption>
			    <tr><?php foreach ( $matrici as $k => $m ) {
				echo "<td><input type='radio' class='radio_dis' name='m' value='$m->codice'"; if($infoB1->m == $m->codice ): echo " checked"; endif; 
				echo " /></td><th>$m->descriz</th>\n"; }  ?>
		      </tr></table></div>  
  <!-- Origine del bosco  -->
		    <div class='block10'><table  class='row' width='400px'><caption class='span'><span> <?php echo strtoupper('origine del bosco') ?></span></caption><tr>
			    <?php foreach ( $origine as $k => $o ) {
				echo "<td><input type='radio' class='radio_dis' name='o' value='$o->codice'"; if($infoB1->o == $o->codice ): echo " checked"; endif; 
				echo " /></td><th>$o->descriz</th>\n"; }  ?>
		      </tr></table></div>  
	    </div> <!--id="ds_container3_B1" class='tavole'-->

 <!-- composizione strato arboreo  -->
	    <div id="ds_container5_B1" class='tavole'>
 	      <a name='container5'> </a> 
	      <div id='div_arboree' class='block'><table class='row'><caption class="span"><span>Composizione strato arboreo</span></caption>
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
					    <td><input type='text' name='ordine_inser_arbo' class='num' value='<?echo $arbo->ordine_inser?>' /></td>
					    <td><a href='#container5' onclick='javascript:schedeB1_form3("<?echo $arbo->cod_coltu ?>")'>Salva</a></td>
					    <td><a class='delete_confirm' title='<?echo $arbo->cod_coltu?>' href='<?php echo "?page=descrp&schedB1=Scheda B1&delete_arboreeB1=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container5"?>'>Elimina</a></td>
					</tr>
				<?} ?>
				<tr>
				    <td><select name='cod_coltu_arbo1'>
					    <option value='-1' > ...</option>
		   			  <?foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
				    </select></td>
				    <td><select name='cod_coper_arbo1'>
					    <option value='-1' > ...</option>
		   			 <? foreach( $per_arbo as $p ) echo "<option value='$p->codice'>$p->descriz</option>\n";?>
				    </select></td>
				    <td><input type='text' name='ordine_inser_arbo1' class='num' value='' /></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#container5' onclick='javascript:schedeB1_form2()'>Inserisci</a></td>
				</tr>
		    </table></div>
		  </td></tr>
	      </table></div> 
	    </div> <!--id="ds_containe5_B1" class='tavole'-->


    </div><!-- id='ds_center2_B1' -->

    <div id='ds_center3_B1'  class='tavole'>
	    <div id="ds_container6_B1" class='tavole'>
<!-- età prevalente accertata  -->
		    <div class='block10'><table width='150px'><caption>Età prevalente accettata</caption><tr><td>	  
			    <?php echo "<tr><td><input type='text' id='c1' class='num' name='c1' value='$infoB1->c1' />\n ";?>
			    </td></tr></table>
		    </div>
<!-- Vigoria  -->
		    <div class='block1010'><table  class='row'><caption class="span"><span>Vigoria</span></caption>
			    <tr><?php foreach ( $vigoria as $k => $vig ) {
				echo "<td><input type='radio' class='radio_dis' name='vig' value='$vig->codice'"; if($infoB1->vig == $vig->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($vig->descriz)."</th>\n"; }?>
		        </tr></table></div>

<!-- Vuoti-lacune  -->
		     <div class='block10'><table  class='row'><caption class='span'><span> <?php echo strtoupper('Vuoti- lacune')?></span></caption><tr>
			  <?php foreach ( $pres_ass AS $k => $ps ) {
				$k = $k + 1;
				echo "<td><input type='radio' class='radio_dis' name='v' value='$ps->codice'"; if($infoB1->v == $ps->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($ps->valore)."</th>\n"; }  ?>
		      </tr></table></div>  
<!-- grado di copertura  -->
		    <div class='block10'><table width='150px'><caption>Grado di copertura (%)</caption><tr><td>	  
			    <?php echo "<tr><td><input type='text' class='perc' name='ce' value='$infoB1->ce' />\n ";?>
			    </td></tr></table>
		    </div>
<!-- Densità  -->
		     <div class='block10'><table  class='row'><caption class='span'><span>Densità</span></caption><tr>
			  <?php foreach ( $densita AS $k => $d ) {
				if ($k != 1){
				echo "<td><input type='radio' class='radio_dis' name='d' value='$d->codice'"; if($infoB1->d == $d->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($d->descriz)."</th>\n";} }  ?>
		      </tr></table></div>  
	    </div> <!--id="ds_containe6_B1" class='tavole'-->

	    <div id="ds_container7_B1" class='tavole'>
<!-- strato arbustivo  -->
 	      <a name='container7'> </a> 
		     <div class='block10'><table class='row'><caption class='span'><span><?php echo strtoupper('Strato arbustivo')?> diffusione</span></caption>
		      <tr>
<?php			   foreach ( $strati AS $k => $sr ) {
				echo "<td><input type='radio' class='radio_dis' name='sr' value='$sr->codice'"; if($infoB1->sr == $sr->codice ): echo " checked"; endif; 
				echo " /></td><th>$sr->descriz</th>\n"; }  ?>
		      </tr></table></div>  
 <!-- specie significative strato arbustivo  -->
<!-- 	insert_arbuB1, modify_arbuB1, delete_arbuB1 -->
		      <div id='div_arbustive' class='block10'>
		      <table class='row'><caption class="span"><span>Specie significative strato arbustivo</span></caption>
		      <tr><td>
  				<div id='arbustive_int' class='block'><table id='arbusti'>
			      <tr><td><b>Specie</b></td></tr>
				<?php foreach ($arbusti AS $arbu){?>
				    <tr id='tr_5_<?echo $arbu->cod_coltu ?>'>
				      <td><select name='cod_coltu_arbu' onChange='javascript:schedeB1_form5("<?echo $arbu->cod_coltu?>" )'>
					<option value='-2' >...</option>
	  				<? foreach( $diz_arbo as $d ){
							$selected1 =($d->cod_coltu == $arbu->cod_coltu)? 'selected' : ''; 
							echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
					    } ?>
				      </select></td>
	<!-- 			      <td><a href='#' onclick='javascript:schedeB1_form5("<?//echo $arbu->cod_coltu ?>")'>Salva</a></td> -->
				      <td><a class='delete_confirm' title='<?echo $arbu->cod_coltu?>' href='<?php echo "?page=descrp&schedB1=Scheda B1&delete_arbuB1=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbu->cod_coltu#container7"?>'>Elimina</a></td>
				    </tr>
	  			<?}?>
				  <tr>
				    <td><select name='cod_coltu_arbu1'>
				      <option value='-1' > ...</option>
						<?foreach( $diz_arbo as $d ){ 
							echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";
						}?>
				    </select></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#' onclick='javascript:schedeB1_form4()'>Inserisci</a></td>
				  </tr>
				  </table></div>
				</td></tr>
		      </table></div> 
	    </div> <!--id="ds_containe7_B1" class='tavole'-->

	    <div id="ds_container8_B1" class='tavole'>
<!-- strato erbaceo  -->
 	      <a name='container8'> </a> 
		     <div class='block10'><table class='row'><caption class='span'><span> <?php echo strtoupper('Strato erbaceo')?>: diffusione</span></caption><tr>
			   <?php foreach ( $strati AS $k => $se ) {
				echo "<td><input type='radio' class='radio_dis' name='se' value='$se->codice'"; if($infoB1->se == $se->codice ): echo " checked"; endif; 
				echo " /></td><th>$se->descriz</th>\n"; }  ?>
		      </tr></table></div>  
 <!-- specie significative strato erbaceo  -->
<!-- 	insert_erbaB1, modify_erbaB1, delete_erbaB1 -->
		      <div id='div_erbacee' class='block10'>
		      <table class='row'><caption class="span"><span>Specie significative strato erbaceo</span></caption>
			      <tr><td>
  				  <div id='erbacee_int' class='block'><table id='erbacee'>
			      <tr><td><b>Specie</b></td></tr>
				<?php
				foreach ($erbacee AS $erba){ ?>
				    <tr id='tr_7_<?echo $erba->cod_coltu ?>'>
				      <td><select name='cod_coltu_erba' onChange='javascript:schedeB1_form7("<?echo $erba->cod_coltu?>" )'>
					<option value='-2' >...</option>
	  				<?foreach( $diz_erba as $d ){
							$selected1 =($d->cod_coltu == $erba->cod_coltu)? 'selected' : ''; 
							echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome</option>\n";
					    } ?>
				      </select></td>
				      <td><a class='delete_confirm' title='<?echo $erba->cod_coltu?>' href='<?php echo "?page=descrp&schedB1=Scheda B1&delete_erbaB1=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$erba->cod_coltu#container8"?>'>Elimina</a></td>
				    </tr>
	  			<?}?>
				  <tr>
				    <td><select name='cod_coltu_erba1'>
				      <option value='-1' > ...</option>
					<?foreach( $diz_erba as $d ) 
						{echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome</option>\n";}?>
				    </select></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#' onclick='javascript:schedeB1_form6()'>Inserisci</a></td>
				  </tr>
			   </table></div>
				</td></tr>
			</table></div> 
	    </div> <!--id="ds_containe8_B1" class='tavole'-->

	    <div id="ds_container9_B1" class='tavole'>
<!-- novellame  -->
		     <div class='block'><table class='row'><caption class='span'><span> <?php echo strtoupper('Novellame')?></span></caption><tr>
			   <?php foreach ( $novell AS $k => $n1 ) {
				echo "<td><input type='radio' class='radio_dis' name='n1' value='$n1->codice'"; if($infoB1->n1 == $n1->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n1->descriz)."</th>\n"; }  
		      echo "</tr></table></div>" ; 
		      echo "<div class='block pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div> ";
		     echo "<div class='block'><table  class='row'><caption class='vuoto'><span></span></caption><tr>";
			   foreach ( $car_nove AS $k => $n2 ) {
				echo "<td><input type='radio' class='radio_dis' name='n2' value='$n2->codice'"; if($infoB1->n2 == $n2->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n2->descriz)."</th>\n"; }  ?>
		      </tr></table></div>  
 <!-- rinnovazione  -->
		     <div class='block'><?php echo "<table class='row'><caption class='span'><span>".strtoupper('Rinnovazione')."</span></caption><tr>";
			   foreach ( $rinnov AS $k => $n3 ) {
				echo "<td><input type='radio' class='radio_dis' name='n3' value='$n3->codice'"; if($infoB1->n3 == $n3->codice ): echo " checked"; endif; 
				echo " /></td><th>".strtolower($n3->descriz)."</th>\n"; }  
		      echo "</tr></table></div>" ; 
		      echo "<div class='block pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div> ";?>
 <!-- Specie prevalente rinnovazione  -->
		      <div class='block'><table  class='row'><caption>Specie prevalente rinnovazione</caption><tr>
				<td width='200px'><select name='spe_nov'>
				<option value='-1' selected='selected'></option>
				<?php $diz_arbo = getCod_nome('diz_arbo') ;	
				foreach( $diz_arbo as $diz ) {
					  $selected = ( isset($infoB1->spe_nov) and $diz->cod_coltu == $infoB1->spe_nov )? 'selected' : '' ;
					  echo "<option value='$diz->cod_coltu' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$diz->cod_coltu | $diz->nome_itali</option>\n";
				}?>
			  	</select></td>
		      </tr></table></div>  
	    </div> <!--id="ds_containe9_B1" class='tavole'-->

	    <div id="ds_container10_B1" class='tavole'>
<!-- Interventi recenti  -->
		      <? echo "<div class='block10'><table  class='row'><caption>".ucfirst($intesta_int2)."</caption><tr>";
			echo "<td width='300px'>
				<select name='int2'>\n"; 
				echo "<option value='-1' selected='selected'></option>\n";
				$prescriz = getCod_descriz('prescriz') ;	
				foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB1->int2) and $pre->codice == $infoB1->int2 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";}
			echo "</select></td>";
			  /*echo "</tr><td width='200px'><input type='text' name='int2' value='$infoB1->int2' /></td>\n";*/ 
			echo "</tr></table></div>";
			echo "<div class='block10'><table class='row'><caption>Specifiche</caption><tr>";
			  echo "<td width='150px'><input type='text' name='int3' value='$infoB1->int3' /></td>\n"; 
			echo "</tr></table></div>"; ?>
<!--  Funzione -->
			<div class='block10'><table  class='row'><caption>Funzione</caption><tr>
			<td width='300px'><select name='f'>
				<option value='-1' selected='selected'></option>
				<?php $funzione = getCod_descriz('funzione') ;	
				foreach( $funzione as $f ) {
					  $selected = ( isset($infoB1->f) and $infoB1->f == $f->codice)? 'selected' : '' ;
					  echo "<option value='$f->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo ">$f->codice | $f->descriz</option>\n";}?>
			</select></td></tr>
			</table></div>
	    </div> <!--id="ds_containe10_B1" class='tavole'-->
    </div><!-- id='ds_center3_B1' -->


    <div id='ds_center4_B1'  class='tavole'>
	    <div id="ds_container11_B1" class='tavole'>
<!-- orientamento selviculturale -->
		     <div class='block10'><table class='row'  width='700px'><caption class='span'><span>Orientamento selviculturale</span></caption><tr>
			   <?php $i=1;
			   foreach ( $sistema AS $k => $g ) {
				echo "<td><input type='radio' class='radio_dis' name='g' value='$g->codice'"; if($infoB1->g == $g->codice ): echo " checked"; endif; 
				echo " /></td><th>$g->descriz</th>\n";
				if ( $i == ceil(count($sistema)/2) ) echo "</tr></tr>\n";
				$i++;}  ?>
		      </tr></table></div>  
<!-- ipotesi intervento futuro  -->
		      <? echo "<div class='block10'><table  class='row'><caption>Ipotesi di intervento futuro</caption><tr>";
			echo "<td width='300px'><select name='p2'>\n"; 
				echo "<option value='-1' selected='selected'></option>\n";
				$prescriz = getCod_descriz('prescriz') ;	
				foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB1->p2) and $pre->codice == $infoB1->p2 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";}
			echo "</select></td>";
			echo "</tr></table></div>";
/*ipotesi intervento futuro  secondario*/
			echo "<div class='block1010'><table  class='row'><caption>Ipotesi di intervento futuro (secondaria)</caption><tr>";
			echo "<td width='300px'><select name='p3'>\n"; 
				echo "<option value='-1' selected='selected'></option>\n";
				$prescriz = getCod_descriz('prescriz') ;	
				foreach( $prescriz as $pre ) {
					  $selected = ( isset($infoB1->p3) and $pre->codice == $infoB1->p3 )? 'selected' : '' ;
					  echo "<option value='$pre->codice' "; if($selected=='selected'): echo "selected = '$selected'"; endif; echo "> $pre->codice | $pre->descriz</option>\n";}
			echo "</select></td>";
			echo "</tr></table></div>";
			echo "<div class='block1010'><table  class='row'><caption>Specifiche</caption><tr>";
			  echo "<td width='150px'><input type='text' name='p4' value='$infoB1->p4' /></td>\n"; 
			echo "</tr></table></div>"; ?>

<!-- Priorità e condizionamenti  -->
		       <div class='block10'><table width='700px' class='row'><caption class='span'><span>Priorità e condizionamenti</span></caption><tr>
			<?$urgenza = getCod_descriz('urgenza') ;
			foreach( $urgenza as $g1 ) {
				echo "<td><input type='radio' class='radio_dis' name='g1' value='$g1->codice'"; if($infoB1->g1 == $g1->codice ): echo " checked"; endif; 
				echo " /></td><th>$g1->descriz</th>\n";
			} ?>
			<td><div class='block10 pad_t10'><img src='/DEV/includes/images/freccia_bianca.png' align='top' alt='freccia_bianca'/></div></td>
			<td><table class='row'width='160px'><caption>subordinato alla viabilità</caption>
			<tr><td><input type='radio' class='radio_dis' name='sub_viab' value='t'
				<?php if($infoB1->sub_viab == 't'):echo " checked"; endif;?> />
			</td><th>sì</th> 
			<td><input type='radio' class='radio_dis' name='sub_viab' value='f'
				<?php if($infoB1->sub_viab == 'f'):echo " checked"; endif; ?>/>
			</td><th>no</th></tr> 
			</table></td>
			</tr></table></div>
	    </div> <!--id="ds_containe11_B1" class='tavole'-->
	    
	     <a name='container13'> </a> 
<!-- Dati di orientamento dendrometrico -->
	<div class='block1010 biancoB1' width='290px'><p>Dati di orientamento dendrometrico</p></div>
	<div class='block1010 biancoB1' width='50px'><p>latifoglie</p></div>	
	<div class='block1010 biancoB1' width='50px'><p>conifere</p></div>
	
	    <div id="ds_container12_B1" class='tavole'>
			<div class='block10'><table class='row'><caption>Diametro preval. (cm)</caption><tr>
			<td width='120px'><input type='text' class='num' name='d1' value='<?echo $infoB1->d1?>' /></td>
			</tr></table></div>
			<div class='block10'><table  class='row'><caption>Altezza preval. (m)</caption><tr>
			<td width='120px'><input type='text' class='num' name='d3' value='<?echo $infoB1->d3?>' /></td>
			</tr></table></div>
			<div class='block10'><table  class='row'><caption>n° alberi/ha</caption><tr>
			<td width='120px'><input type='text' class='num' name='d5' value='<?echo $infoB1->d5?>' /></td>
			</tr></table></div>

			<div class='block10 conifere'><table class='row'><caption>Diametro preval. (cm)</caption><tr>
			<td width='120px'><input type='text' class='num' name='d14' value='<?echo $infoB1->d14?>' /></td>
			</tr></table></div>
			<div class='block10'><table  class='row'><caption>Altezza preval. (m)</caption><tr>
			<td width='120px'><input type='text' class='num' name='d15' value='<?echo $infoB1->d15?>' /></td>
			</tr></table></div>
			<div class='block10'><table  class='row'><caption>n° alberi/ha</caption><tr>
			<td width='120px'><input type='text' class='num' name='d16' value='<?echo $infoB1->d16?>' /></td>
			</tr></table></div>
			<div class='block10'><table class='row' width='900px'><caption class='span span_white'><span>Altre stime sintetiche ricavate esternamente a ProgettoBosco (Regione Lombardia)</span></caption>
				<tr><td><div id='stime_sint' class='block10'>
					<div class='block10'><table class='row'><caption>Provvigione reale (m3/ha)</caption><tr>
					<td width='170px'><input type='text' class='num' name='d21' value='<?echo $infoB1->d21?>' /></td>
					</tr></table></div>
					<div class='block10'><table  class='row'><caption>Provvigione reale (m3)</caption><tr>
					<td width='170px'><input type='text' class='num' name='d22' value='<?echo $infoB1->d22?>' /></td>
					</tr></table></div>
					<div class='block10'><table class='row'><caption>Incremento corrente (m3/ha)</caption><tr>
					<td width='170px'><input type='text' class='num' name='d23' value='<?echo $infoB1->d23?>' /></td>
					</tr></table></div>
					<div class='block10'><table  class='row'><caption>Incremento corrente (m3)</caption><tr>
					<td width='170px'><input type='text' class='num' name='d24' value='<?echo $infoB1->d24?>' /></td>
					</tr></table></div>
					<div class='block10'><table class='row'><caption>Classe di ferracità stimata</caption><tr>
					<td width='170px'><input type='text' class='num' name='d26' value='<?echo $infoB1->d26?>' /></td>
					</tr></table></div>
					<div class='block10'><table  class='row'><caption>Provvigione normale (m3/ha)</caption><tr>
					<td width='170px'><input type='text' class='num' name='d25' value='<?echo $infoB1->d25?>' /></td>
					</tr></table></div>
				</div>
				
		<!-- Per specie  -->
	    <div id="ds_container14_B1" class='tavole'>
	      <div id='div_specie_cont' class='block'><table class='row'><caption class="span"><span>Per specie</span></caption>
	      	<tr><td><div id='div_specie_int' class='block'>
				<table id='specie' ><tr class='center'><td><b>Specie</b></td><td><b>% specie</b></td><td><b>Massa totale</b></td></tr>
				<?php
				foreach ($stime_b1 AS $arbo){?>
				<tr id='tr_11_<?echo $arbo->cod_coltu ?>'>
					<td><select name='cod_coltu_specie'>
						<option value='-2' >...</option>
		    			<?foreach( $diz_arbo as $d ){
						    $selected1 =($d->cod_coltu == $arbo->cod_coltu)? 'selected' : ''; 
						    echo "<option value='$d->cod_coltu' $selected1 >($d->cod_coltu) $d->nome_itali</option>\n";
						 } ?>
					</select></td>
					<td><select name='cod_coper_specie'>
						<option value='-2' >...</option>
		    			<?foreach( $per_arbo as $p ){
						    $selected1 =($p->codice == $arbo->cod_coper)? 'selected' : ''; 
						    echo "<option value='$p->codice' $selected1 >$p->descriz</option>\n";
						} ?>
					    </select></td>
					 <td><input type='text' name='massa_tot_specie' value='<?echo $arbo->massa_tot?>' /></td>
					 <td><a href='#' onclick='javascript:schedeB1_form11("<?echo $arbo->cod_coltu ?>")'>Salva</a></td>
					 <td><a class='delete_specieB1 delete_confirm' title='<?echo $arbo->cod_coltu?>' href='<?php echo "?page=descrp&schedB1=Scheda B1&delete_specieB1=ok&proprieta=$proprieta&particella=$particella&cod_coltu=$arbo->cod_coltu#container13"?>'>Elimina</a></td>
				</tr>
				<?} ?>
				<tr>
				    <td><select name='cod_coltu_specie1'>
					    <option value='-1' > ...</option>
		    			<?foreach( $diz_arbo as $d ) echo "<option value='$d->cod_coltu'>($d->cod_coltu) $d->nome_itali</option>\n";?>
				    </select></td>
				    <td><select name='cod_coper_specie1'>
					    <option value='-1' > ...</option>
		    			<?foreach( $per_arbo as $p ) echo "<option value='$p->codice'>$p->descriz</option>\n";?>
				    </select></td>
				    <td><input type='text' name='massa_tot_specie1' value='' /></td>
				    <td colspan='2' style='text-align:center'>
				    <a href='#' onclick='javascript:schedeB1_form10()'>Inserisci</a></td>
				</tr>
				</table>
	      	</div></td></tr>
	      </table></div> 
	    </div> <!--id="ds_containe14_B1" class='tavole'-->

				
				
			</td></tr></table></div>
			
			
	    </div> <!--id="ds_containe12_B1" class='tavole'-->
	    
<!-- Note alle singole voci -->
	    <div id="ds_container13_B1" class='tavole'>
<!-- ############### Note alle singole voci ######################-->
<!-- qui inserisco le due variabili che poi passo al form sottostante (particelle_note_form)
che sono parametro_sing = cod_nota,  nota_sing = nota -->
			<div id='div_note_sing' class='block10'><table class='row'><caption class="span"><span>NOTE alle singole voci</span></caption>
			<tr><td>
			<div id='note_sing_int' class='block'><table id='note_sing'>
				<tr><td class='center' width='50%'><b>Parametro</b></td><td class='center' width='50%'><b>Nota</b></td></tr> 
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
				<td><a href='#' onclick='javascript:schedeB1_form9("<?echo $in->cod_nota ?>")'>Salva</a></td>
				<td><a class='delete_noteA' title='<?echo $in->cod_nota?>' href='<?php echo "?page=descrp&schedB1=Scheda B1&delete_noteB1=ok&proprieta=$proprieta&particella=$particella&cod_nota=$in->cod_nota#container13"?>'>Elimina</a></td>
				<?}
			} else  { echo "<tr><td>...</td><td>...</td>";	} ?>
			</tr>
			<tr><td>
			<select name='parametro_sing1'>
				<option selected='selected' value='-1' > nota...</option>
				 <?foreach( $note_tutte_dif as $ntd ) {echo "<option value='$ntd->nomecampo'>($ntd->nomecampo) $ntd->intesta</option>\n";}?>
			</select></td>
			<td><input type='text' name='nota_sing1' value='' /></td>
			<td colspan='2' style='text-align:center'>
			<a href='#' onclick='javascript:schedeB1_form8()'>Inserisci</a></td></tr>
		     </table></div>
		</td></tr>
	      </table></div>
<!-- NOTEj -->
			<div class='block10'><table width='900px' height='100px'><caption>NOTE</caption>
			<tr><td class="top"><textarea name='note' rows="5" cols="124"><?php echo $infoB1->note?></textarea> </td></tr>
			</table></div>
	    </div> <!--id="ds_container13_B1" class='tavole'-->
	    				    
    </div><!-- id='ds_center4_B1' -->
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
		<!--  <div id='descrp_schede'> -->
	</form>
<!-- 	<form name="descrp_schedeB1_form" action="#" method="post"> -->

<!-- ######################## form tabelle letarali ######################################## -->
<?
if ($scheda == 'Scheda B1') 	{ ?>
<!--// Attenzione!! vedere in js la funzione "formB1_1()"-->

 <!-- 	insert_arborB1, modify_arborB1, delete_arboreeB1 -->
	<form name='formB1_2' id='formB1_2' action="#container5" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='insert_arborB1' value='ok' />
	</form>

	<form name='formB1_3' id='formB1_3' action="#container5" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='ordine_inser' value='ok' />
		<input type='hidden' name='modify_arborB1' value='ok' />
	</form>

<!-- 	insert_arbuB1, modify_arbuB1, delete_arbuB1 -->
	<form name='formB1_4' id='formB1_4' action="#container7" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_arbuB1' value='ok' />
	</form>

	<form name='formB1_5' id='formB1_5' action="#container7" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_arbuB1' value='ok' />
	</form>

<!-- 	insert_erbaB1, modify_erbaB1, delete_erbaB1 -->
	<form name='formB1_6' id='formB1_6' action="#container8" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='insert_erbaB1' value='ok' />
	</form>

	<form name='formB1_7' id='formB1_7' action="#container8" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='modify_erbaB1' value='ok' />
	</form>
<!--// Attenzione!! vedere in js la funzione "formB1_1()"-->

 <!-- 	insert_specieB1, modify_specieB1, delete_specieB1 -->
	<form name='formB1_10' id='formB1_10' action="#container13" method="post">
<?	// form per  l'inserimento dell'ultimo valore 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='massa_tot' value='ok' />
		<input type='hidden' name='insert_specieB1' value='ok' />
	</form>

	<form name='formB1_11' id='formB1_11' action="#container13" method="post">
<?	// form per  modifica 
	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='ok' />
		<input type='hidden' name='cod_coper' value='ok' />
		<input type='hidden' name='cod_coltu' value='ok' />
		<input type='hidden' name='cod_coltu_old' value='ok' />
		<input type='hidden' name='massa_tot' value='ok' />
		<input type='hidden' name='modify_specieB1' value='ok' />
	</form>

<!-- ######################## form note singole voci######################################## -->

	<form name='formB1_8' id='formB1_8' action="#container13" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='insert_noteB1' value='ok' />
	</form>


	<form name='formB1_9' id='formB1_9' action="#container13" method="post">
<?	$proprieta = $_REQUEST["proprieta"];
	$particella = $_REQUEST['particella'];
	$scheda = $_REQUEST['schedB1'];
?>
		<input type='hidden' name='proprieta' value='<?echo  $proprieta ?>' />
		<input type='hidden' name='particella' value='<?echo  $particella ?>' />
		<input type='hidden' name='schedB1' value='<?echo  $scheda ?>' />
		<input type='hidden' name='cod_nota' value='ok' />
		<input type='hidden' name='cod_nota_old' value='ok' />
		<input type='hidden' name='nota' value='ok' />
		<input type='hidden' name='modify_noteB1' value='ok' />
	</form>
<?
}  ?>

<!-- ######################## FINE form tabelle letarali######################################## -->
</div> 
<!-- <div id='home' class='descrp_schede'> -->

<?php
}
?>