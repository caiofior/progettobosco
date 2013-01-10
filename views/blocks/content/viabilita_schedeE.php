<?php
      $archivio = "SCHEDE_E";
      $nomecampo = '';
      if (!isset($codice))   $codice = "undefine";
      if (!isset($strada))   $strada = "undefine";
      if (!isset($_GET['codice']))  $_GET['codice'] = "undefine";
      if (!isset($_GET['strada']))  $_GET['strada'] = "undefine";
      if (!isset($_POST['strada']))  $_POST['strada'] = "undefine";

      if (isset($_GET['codice'])) $codice = $_GET['codice'];
      if (isset($_GET['strada'])) $strada = $_GET['strada'];
      
      $boschi = getCodiciBoschiCodice( $codice );
      $info = getInfoStrade($codice, $strada);   
?>

<div id='home' class='viabilita'>

<form name="viabilita1_form" action="#" method="post">
  <div id='viab'>

      <div id='viab_top'>

	    <div id='b_title_reg'>Regione

	   <?php  if (isset($_GET['codice']) and $_GET['codice'] != 'bosco...'){
			  $regione = getDiz_regioniCod($codice);
			  echo $regione->descriz;
			}
		  else echo "...";  ?>

		  <br />Sistema informativo per l'assestamento forestale
	    </div> <!--//DIV: b_title_reg-->

	    <div id='viab_top_top' class='daticat'>
		  <div class='block1010'><table width='250px'><caption>Bosco</caption>
		  <tr><td><?php echo $boschi->descrizion?></td></tr></TABLE></div>

		  <div class='block1010'><table width='250px'><caption>Rilevatore</caption>
		  <tr><td>NonPervenuto.</td></tr></TABLE></div> 

		  <div class='block1010'><table><caption>Data</caption>
		  <tr><td><?php echo $info->data?></td></tr></TABLE></div>

		  <div class='block1010'><table width='100px'><caption>Lunghezza (m)</caption>
		  <tr><td><?php echo $info->lung_gis?></td></tr></TABLE></div>

		  <div class='block1010'><table width='100px'><caption>percorso n°</caption>
		  <tr><td><?php echo $strada?></td></tr></TABLE></div>
	    </div>  <!-- id='viab_top_top'-->

	    <div class='s_title block'>Scheda E per la descrizione della VIABILITA' FORESTALE E RURALE</div>

      </div> <!-- div viab_top-->

      <div id='viab_center' class='block1010'>

	      <div class='block1010'><table width='250px'><caption>Nome Percorso</caption>
	      <tr><td><?php $nome_strada=($info->nome_strada != '') ? $info->nome_strada : 'NonPervenuto'; echo $nome_strada ?></td></tr></TABLE></div> 

	      <div class='block1010'><table width='250px'><caption>Punto di partenza (a valle)</caption>
	      <tr><td><?php echo $info->da_valle?></td></tr></TABLE></div>
	  
	      <div class='block1010'><table width='250px'><caption>Punto di arrivo (a monte)</caption>
	      <tr><td><?php echo $info->a_monte?></td></tr></TABLE></div>
      </div> <!-- div viab_center-->

      <div id='viab_class' class='block1010'>
	     <div class='block1010'><table id='table1'><caption><?php $archivi=getArchivi($archivio, "CLASS_AMM" ); echo $archivi->intesta ?></caption>
	      <tr><td><input type="checkbox" name="class_amm" class='checkbox_dis' value="1" <? if($info->class_amm == '1'):echo "checked"; endif; ?> /> statale</td>
	      <td><input type="checkbox" name="class_amm" class='checkbox_dis' value="2" <? if($info->class_amm == '2'):echo "checked"; endif; ?>  /> provinciale</td>
	      <td><input type="checkbox" name="class_amm" class='checkbox_dis' value="3" <? if($info->class_amm == '3'):echo "checked"; endif; ?>  /> comunale</td>
	      <td><input type="checkbox" name="class_amm" class='checkbox_dis' value="4" <? if($info->class_amm == '4'):echo "checked"; endif; ?>  /> vicinale uso pubblico</td>
	      <td><input type="checkbox" name="class_amm" class='checkbox_dis' value="5" <? if($info->class_amm == '5'):echo "checked"; endif; ?>  /> vicinale uso privato</td>
	      <td><input type="checkbox" name="class_amm" class='checkbox_dis' value="6" <? if($info->class_amm == '6'):echo "checked"; endif; ?>  /> privata</td>
	      <td><input type="checkbox" name="class_amm" class='checkbox_dis' value="7" <? if($info->class_amm == '7'):echo "checked"; endif; ?> /> proprosta di tracciato</td>
	      </tr></table></div> 

	     <div class='block1010'><table id='table2' ><caption><?php $archivi=getArchivi($archivio, "CLASS_PROP" ); echo $archivi->intesta ?></caption>
	      <tr><td><input type="checkbox" name="class_prop" value="1" <? if($info->class_prop == '1'):echo "checked"; endif; ?> /> privata</td>
	      <td><input type="checkbox" name="class_prop" value="2" <? if($info->class_prop == '2'):echo "checked"; endif; ?>  /> comunale</td>
	      <td><input type="checkbox" name="class_prop" value="3" <? if($info->class_prop == '3'):echo "checked"; endif; ?>  /> vicinato uso pubblico</td>
	      <td><input type="checkbox" name="class_prop" value="4" <? if($info->class_prop == '4'):echo "checked"; endif; ?>  /> vicinale uso privato</td>
	      <td><input type="checkbox" name="class_prop" value="5" <? if($info->class_prop == '5'):echo "checked"; endif; ?>  /> provata</td>
	      <td><input type="checkbox" name="class_prop" value="6" <? if($info->class_prop == '6'):echo "checked"; endif; ?>  /> nessuna proprietà</td>
	      </tr></table></div> 
      </div> <!-- viab_clas -->

      <div id='viab_class_tec' class='block1010'>
	     <div class='block1010'><table id='table3'><caption>Classificazione Tecnica Attuale</caption>
	      <tr><td><input type="checkbox" name="qual_att" value="1" <? if($info->qual_att == '1'):echo "checked"; endif; ?> /> strada camionabile principale</td>
	      <td><input type="checkbox" name="qual_att" value="2" <? if($info->qual_att == '2'):echo "checked"; endif; ?> /> strada camionabile secondaria</td>
	      <td><input type="checkbox" name="qual_att" value="3" <? if($info->qual_att == '3'):echo "checked"; endif; ?> /> strada trattorabile e carrareccia</td>
	      <td><input type="checkbox" name="qual_att" value="4" <? if($info->qual_att == '4'):echo "checked"; endif; ?> /> pista camionabile</td>
	      <td><input type="checkbox" name="qual_att" value="5" <? if($info->qual_att == '5'):echo "checked"; endif; ?> /> pista di strascico principale (permanente)</td>
	      <td><input type="checkbox" name="qual_att" value="6" <? if($info->qual_att == '6'):echo "checked"; endif; ?> /> tracciato per mezzi agricoli minori</td>
	      <td><input type="checkbox" name="qual_att" value="7" <? if($info->qual_att == '7'):echo "checked"; endif; ?> /> mulattiera</td>
	      <td><input type="checkbox" name="qual_att" value="8" <? if($info->qual_att == '8'):echo "checked"; endif; ?> /> sentiero</td>
	      <td><input type="checkbox" name="qual_att" value="9" <? if($info->qual_att == '9'):echo "checked"; endif; ?> /> vecchio tracciato da recuperare</td>
	      <td><input type="checkbox" name="qual_att" value="10" <? if($info->qual_att == '10'):echo "checked"; endif; ?> /> proprosta di tracciato</td>
	      </tr></table></div> 

	     <div class='block1010'><table id='table4'><caption>Classificazione Tecnica Proposta</caption>
	      <tr><td><input type="checkbox" name="qual_prop" value="1" <? if($info->qual_prop == '1'):echo "checked"; endif; ?> /> strada camionabile principale</td>
	      <td><input type="checkbox" name="qual_prop" value="2" <? if($info->qual_prop == '2'):echo "checked"; endif; ?> /> strada camionabile secondaria</td>
	      <td><input type="checkbox" name="qual_prop" value="3" <? if($info->qual_prop == '3'):echo "checked"; endif; ?> /> strada trattorabile e carrareccia</td>
	      <td><input type="checkbox" name="qual_prop" value="4" <? if($info->qual_prop == '4'):echo "checked"; endif; ?> /> pista camionabile</td>
	      <td><input type="checkbox" name="qual_prop" value="5" <? if($info->qual_prop == '5'):echo "checked"; endif; ?> /> pista di strascico principale (permanente)</td>
	      <td><input type="checkbox" name="qual_prop" value="6" <? if($info->qual_prop == '6'):echo "checked"; endif; ?> /> tracciato per mezzi agricoli minori</td>
	      <td><input type="checkbox" name="qual_prop" value="7" <? if($info->qual_prop == '7'):echo "checked"; endif; ?> /> mulattiera</td>
	      <td><input type="checkbox" name="qual_prop" value="8" <? if($info->qual_prop == '8'):echo "checked"; endif; ?> /> sentiero</td>
	      </tr></table></div> 
      </div> <!-- viab_clas_tec -->

      <div id='viab_info1' class='block1010'>
	    <div class='block container'>
	      <div class='block1010'><table id='table5'><caption>Larghezza (m)</caption>	     
	      <tr><td><?php echo $info->larg_min." (minima)"?></td><td><?php echo $info->larg_prev." (prevalente)"?></td></tr></table></div>
	      <div class='block1010'><table id='table6'><caption>Raggio minimo Curve (m)</caption>
	      <tr><td><?php echo $info->raggio?></td></tr></table></div>
	    </div> 
	    <div class='block1010'><table id='table7'><caption>Fondo</caption>   
	      <tr><td><input type="checkbox" name="fondo" value="1" <? if($info->fondo == '1'):echo "checked"; endif; ?> /> natuale</td>   
		  <td><input type="checkbox" name="fondo" value="2" <? if($info->fondo == '2'):echo "checked"; endif; ?> /> migliorato</td>   
	    </tr></table></div>
      </div> <!-- viab_info1-->

      <div id='viab_info2' class='block1010'>
	    <div class='block container'>
		<div class='block1010'><table id='table8'><caption>Pendenza (%)</caption>	     
		<tr><td><?php echo $info->pend_media." (media)"?></td><td><?php echo $info->pend_max." (massima)"?></td></tr></table></div>
		<div class='block1010'><table id='table9'><caption>Contropendenza (%)</caption>
		<tr><td><?php echo $info->contropend?></td></tr></table></div>
	    </div> 
	    <div class='block1010'><table id='table10'><caption>Piazzola di scambio</caption>   
	      <tr><td><input type="checkbox" name="fondo" class='checkbox_escl radio_piazzola' value="1" <? if($info->q_piazzole == '1'):echo "checked"; endif; ?> /> assenti</td>   
	      <td><input type="checkbox" name="fondo" class='radio_piazzola' value="2" <? if($info->q_piazzole == '2'):echo "checked"; endif; ?> /> presenti ma insufficienti</td>   
	      <td><input type="checkbox" name="fondo" class='radio_piazzola' value="3" <? if($info->q_piazzole == '3'):echo "checked"; endif; ?> /> sufficienti</td>
	    </tr></table></div>

      </div> <!-- viab_info2-->

      <div id='viab_accesso' class='block1010'>
	     <div class='block container'><table id='table11'><caption>Accesso</caption>
	      <tr><td><input type="checkbox" name="accesso" value="1" <? if($info->accesso == '1'):echo "checked"; endif; ?> /> libero</td>
	      <td><input type="checkbox" name="accesso" value="2" <? if($info->accesso == '2'):echo "checked"; endif; ?> />  regolamentato</td>
	      <td><input type="checkbox" name="accesso" value="3" <? if($info->reg_accesso == 't'):echo "checked"; endif; ?> /> con sbarra</td>
	      <td><input type="checkbox" name="accesso" value="4" <? if($info->reg_accesso == 'f'):echo "checked"; endif; ?> /> da regolamentare</td>
	      </tr></table></div> 

	     <div class='block1010'><table id='table12'><caption>Transitabilità</caption>
	      <tr><td><input type="checkbox" name="transitabi" value="1" <? if($info->transitabi == '1'):echo "checked"; endif; ?> /> buona</td>
	      <td><input type="checkbox" name="transitabi" value="2" <? if($info->transitabi == '2'):echo "checked"; endif; ?> /> scarsa</td>
	      <td><input type="checkbox" name="transitabi" value="3" <? if($info->transitabi == '3'):echo "checked"; endif; ?> /> pessima</td>
	      </tr></table></div> 
      </div> <!-- viab_accesso -->

      <div id='viab_manu' class='block1010'>
	     <div class='block container'><table id='table13'><caption>Manutenzione e miglioramenti previsti</caption>
<!--collegato a "manutenz"-->
	      <tr><td><input type="checkbox" name="manutenzione" value="1" <? if($info->manutenzione == '1'):echo "checked"; endif; ?> /> non previsti</td>
	      <td><input type="checkbox" name="manutenzione" value="2" <? if($info->manutenzione == '2'):echo "checked"; endif; ?> />  ordinaria</td>
	      <td><input type="checkbox" name="manutenzione" value="3" <? if($info->manutenzione == '3'):echo "checked"; endif; ?> /> straordinari miglioramento</td>
	      <td><input type="checkbox" name="manutenzione" value="4" <? if($info->manutenzione == '4'):echo "checked"; endif; ?> /> riqualificazione</td>
	      <td><input type="checkbox" name="manutenzione" value="5" <? if($info->manutenzione == '5'):echo "checked"; endif; ?> /> progetto</td>
	      </tr></table></div> 

	     <div class='block1010'><table id='table14'><caption>Priorità</caption>
	      <tr><td><input type="checkbox" name="urgenza" value="1" <? if($info->urgenza == '1'):echo "checked"; endif; ?> /> immediata</td>
	      <td><input type="checkbox" name="urgenza" value="2" <? if($info->urgenza == '2'):echo "checked"; endif; ?> /> entro primo periodo</td>
	      <td><input type="checkbox" name="urgenza" value="3" <? if($info->urgenza == '3'):echo "checked"; endif; ?> /> entro secondo periodo</td>
	      <td><input type="checkbox" name="urgenza" value="4" <? if($info->urgenza == '4'):echo "checked"; endif; ?> /> differibile</td>
	      </tr></table></div> 
      </div> <!-- viab_manu -->

      <div id='viab_interventi' class='block1010'>
	     <div class='block1010'><table id='table15'><caption>Interventi</caption> <!--collegato a "int_via"-->
	      <tr><td><input type="checkbox" name="qual_att" value="1" <? if($info->scarpate == 't'):echo "checked"; endif; ?> /> consolidamento scarpate laterali</td>
	      <td><input type="checkbox" name="qual_att" value="2" <? if($info->corsi_acqua== 't'):echo "checked"; endif; ?> /> manutenzione miglioramento attraversamento corsi d''acqua</td>
	      <td><input type="checkbox" name="qual_att" value="3" <? if($info->tombini == 't'):echo "checked"; endif; ?> /> tombini</td>
	      <td><input type="checkbox" name="qual_att" value="4" <? if($info->can_tras == 't'):echo "checked"; endif; ?> /> cunette trasversali</td>
	      <td><input type="checkbox" name="qual_att" value="5" <? if($info->can_lat == 't'):echo "checked"; endif; ?> /> cunette laterali</td>
	      <td><input type="checkbox" name="qual_att" value="6" <? if($info->aib == 't'):echo "checked"; endif; ?> /> ripuliture AIB</td></tr></table>

	      <table id='table16'>
	      <tr><td><input type="checkbox" name="qual_att" value="7" <? if($info->piazzole == 't'):echo "checked"; endif; ?> /> creazione/miglioramento piazzole di scambio</td>
	      <td><input type="checkbox" name="qual_att" value="8" <? if($info->imposti == 't'):echo "checked"; endif; ?> /> creazione miglioramento imposti</td>
	      <td><input type="checkbox" name="qual_att" value="9" <? if($info->reg_accesso == 't'):echo "checked"; endif; ?> /> opere di regolamentaz. accesso</td>
	      <td><input type="checkbox" name="qual_att" value="10" <? if($info->manufatti == 't'):echo "checked"; endif; ?> /> manutenzione ripristino manufatti storici</td>
	      <td><input type="checkbox" name="qual_att" value="11" <? if($info->altro == 't'):echo "checked"; endif; ?> /> altro</td>
	      <td><input type="text" name="specifica" value="specifica..."></td>
	      </tr></table></div> 
      </div> <!-- viab_interventi -->


  </div>  <!-- id='viab'-->
  </FORM>  <!--name="viabilita1_form"-->

</div> <!-- id='home' class='daticat'-->