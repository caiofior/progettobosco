<?php 
if(   isset($_REQUEST['schedaA']) ) 	{/* isset($_POST['scheda'])*/

  $codice = $_REQUEST["codice"];
  $particella = $_REQUEST['particella'];
  $scheda = $_REQUEST['schedaA'];
  $elenco = null ;
  $info = null ;
  $arr = array();


// controllo inserimento valori di codice e particella
  if ($codice == '-1' or $particella == '-1') {
	  echo 'Attenzione! Errore inserimento codice o particella<br />';
	  die("codice= $codice e particella=$particella");
  }

// creazione delle variabili per la modifica e l'inserimento dei dati nella tabella schedaA
  // $arr['datasch']="" ;
  // $arr['ap']="" ;
  // $arr['pp']="" ;
  // $arr['toponimo']="" ;
  // $arr['delimitata']="" ;
  $arr['codiope']="" ; $arr['comune']="" ;
  $arr['e1']="" ; $arr['pf1']="" ;
  $arr['a2']="" ; $arr['a3']="" ; $arr['a4']="" ; $arr['a6']="" ; $arr['a7']="" ; $arr['a8']="" ;
  $arr['r2']="" ; $arr['r3']="" ; $arr['r4']="" ; $arr['r5']="" ; $arr['r6']="" ; $arr['r7']="" ;
  $arr['f2']="" ; $arr['f3']="" ; $arr['f4']="" ; $arr['f5']="" ; $arr['f6']="" ; $arr['f7']="" ; $arr['f8']="" ; $arr['f10']="" ; 		$arr['f11']="" ; $arr['f12']="" ;
  $arr['v3']="" ; $arr['v1']="" ; $arr['o']="" ; 
  $arr['c1']="" ; $arr['c2']="" ; $arr['c3']="" ; $arr['c4']="" ; $arr['c5']="" ; $arr['c6']="" ;
  $arr['p1']="" ; $arr['p2']="" ; $arr['p3']="" ; $arr['p4']="" ; $arr['p5']="" ; $arr['p6']="" ; $arr['p7']="" ; $arr['p8']="" ; $arr['p9']="" ;
  $arr['i1']="" ; $arr['i2']="" ; $arr['i3']="" ; $arr['i4']="" ; $arr['i5']="" ; $arr['i6']="" ; $arr['i7']="" ; $arr['i8']="" ; $arr['i21']="" ; $arr['i22']="" ;
  $arr['m1']="" ; $arr['m2']="" ; $arr['m21']="" ; $arr['m3']="" ; $arr['m4']="" ; $arr['m22']="" ; $arr['m20']="" ; $arr['m5']="" ; $arr['m6']="" ; $arr['m7']="" ; $arr['m8']="" ;
  $arr['m9']="" ; $arr['m10']="" ; $arr['m12']="" ; $arr['m13']="" ; $arr['m15']="" ; $arr['m14']="" ; $arr['m23']="" ; $arr['m16']="" ; $arr['m17']="" ; $arr['m18']="" ; $arr['m19']="" ; 
  $arr['note']="";
  $arr['sup_tot']="";


$cat['sup_tot_cat']="" ; $cat['sup_tot']="" ;$cat['sup_bosc']="" ; $cat['porz_perc']="" ;$cat['note']="" ;
// $arr['']="" ; $arr['']="" ; $arr['']="" ; $arr['']="" ; $arr['']="" ; $arr['']="" ; $arr['']="" ; $arr['']="" ; $arr['']="" ; 

  //se si vuole modificare o inserire i dati di una particella si fanno eseguire l'UPDATE o l'INSERT nella tabella SCHEDE_A con la funzione saveInfoDescrp($info, $codice, $particella) 
  if( isset($_REQUEST['inserisci_dati']) or isset($_REQUEST['modifica_dati'])) {
	foreach( array_keys($arr) as $key ) {
		if( //per le variabili booleane si assegnano valori true o false
		    $key=='c1' or  $key=='c2' or  $key=='c3' or  $key=='c4' or  $key=='c5' or 
		    $key=='p1' or  $key=='p2' or  $key=='p3' or  $key=='p4' or  $key=='p5' or $key=='p6' or
		    $key=='i3' or  $key=='i4' or  $key=='i5' or  $key=='i6' or  $key=='i7'
		      or $key=='m1' or  $key=='m2' or  $key=='m3' or  $key=='m4' or  $key=='m5' or  $key=='m6' or  $key=='m7' or
		    $key=='m8' or  $key=='m9' or  $key=='m10' or  $key=='m12' or  $key=='m13' or  $key=='m14' or  $key=='m15' or
		    $key=='m16' or  $key=='m17' or  $key=='m18' or  $key=='m20' or  $key=='m21' or  $key=='m22' or  $key=='m23') 
			 {	$val = (isset($_REQUEST[$key]))? 'true' : 'false';}
		else 	 {	$val = $_REQUEST[$key] ;}
		$arr[$key] = $val ;
	}
	$info = array_to_object($arr) ;
	saveInfoDescrp($info, $codice, $particella) ;
	unset($_REQUEST['new']) ;
  }
  if (isset($_REQUEST['modify_cat'])){
	foreach (array_keys($cat) as $gigi){
		$v = $_REQUEST[$gigi] ;
		$cat[$gigi] = $v ;
	}
	$cat = array_to_object($cat) ;
	modifyInfoSchedeCatasto($cat, $codice, $particella) ;
}

  //se si vuole creare una nuova particella prima di fare l'INSERT nella tabella SCHEDE_A con la funzione saveInfoDescrp($info, $codice, $particella), si fa creare un nuovo record con le due chiavi primarie (proprieta, cod_part) nuove.
  if( isset($_REQUEST['new']) ) {
	  $arr['codice'] = $codice ;
	  $arr['particella'] = $particella ;
	  $info = array_to_object($arr) ;
	  }
  else 	{ 
  //se si vuole semplicemente interrogare la tabella SCHEDE_A si fanno le SELECT con le funzioni getInfoSchedaA(.., ..), getComune(..), getRilevato (...) dalle rispettive tabelle: SCHEDE_A, COMUNI, RILEVATO
	  $info = getInfoSchedaA($codice, $particella);
	  $comune = getComune ($info->comune);
	  $rilevato = getRilevato ($info->codiope);
	}


// interrogazioni tabelle per estrarre i nomi dei possibili valori che si possono attribuire ai campi singoli di SCHEDE_A 
  $regione = getDiz_regioniCod($codice);
  $boschi = getCodiciBoschiCodice( $codice );
  $propriet = getInfoPropriet( $codice);
  $posfisio = getPosfisio () ;
  $espo = getEspo ();
  $ostacoli = getOstacoli ();
  $note_a= getInfoSchedaANote( $codice , $particella );
//  $superfici = getSchedaASuperfici ( $codice , $particella );
//   $superfici['bosc'] = $info->sup_tot -(( $superfici['improd'])+ ($superfici['p_n_bosc']));
//    $info->bosc = $info->sup_tot -(( $info->improd)+ ($info->p_n_bosc));


  $catasto = getInfoSchedeCatasto ( $codice , $particella );
  $sum_catasto = getSumSchedeCatasto ( $codice , $particella );

// interrogazioni TABELLA 'catasto' per estrarre i nomi delle colonne per poi fare le tabelle di SCHEDE_A
$archivio = 'catasto';
	$dati_catasto = array (0=>"foglio", "particella", "Sup. totale particella catasto", "Sup. afferente particella forestale (ha)", "di cui boscata (ha)", "non boscata (ha)", "% afferente", "Note");

// interrogazioni TABELLA 'archivi' per estrarre i nomi delle colonne per poi fare le tabelle di SCHEDE_A
  $pascolo = array (1=>'bovini', 'ovini', 'caprini', 'equini', 'altro');
  $archivio = 'schede_a';
	$indici_a = array ('a2', 'a3', 'a4', 'a6', 'a7');// 'a8' è la nota di commento, mentre manca 'a5'
	      foreach ($indici_a AS $k => $ak)   $dissesto[$ak] = getIntestazione ( $archivio , $ak )->intesta;
	$indici_r = array ('r2', 'r3', 'r4', 'r5', 'r6');// 'r7' è la nota di commento
	      foreach ($indici_r AS $k => $rk)   $limite_radici[$rk] = getIntestazione ( $archivio , $rk )->intesta;
	$indici_f = array ('f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f10', 'f11');// 'f12' è nota di commento, mentre manca 'f9' 
	      foreach ($indici_f AS $k => $fk)   $fattori_alt[$fk] = getIntestazione ( $archivio , $fk )->intesta;
	$indici_p = array ('p1','p2','p3','p4','p5','p6'); // 'p7' sono le specie pascolanti, 'p10' specifica specie, 'p8' specifica altri fattori
	      foreach ($indici_p AS $k => $pk)   $fattori_part[$pk] = getIntestazione ( $archivio , $pk )->intesta;
	$indici_m = array ('m1', 'm2', 'm21', 'm3', 'm4', 'm22', 'm20', 'm5','m6','m7','m8', 'm9', 'm10', 'm12', 'm13', 'm15', 'm14', 'm23', 'm16', 'm17', 'm18');// 'm11'campo mancante, 'm19' è la nota di commento
	      foreach ($indici_m AS $k => $mk)   $manufatti[$mk] = getIntestazione ( $archivio , $mk )->intesta;
	$indici_c = array ('c1','c2', 'c3', 'c4', 'c5');// 'c6' è la nota di commento
	      foreach ($indici_c AS $k => $ck)   $condizionamenti[$ck] = getIntestazione ( $archivio , $ck )->intesta;
	$indici_i = array ('i3', 'i4', 'i5', 'i6', 'i7');// 'i8' è la nota di commento, mentre'i1','i2' e 'i21','i22'sono le superfici
	      foreach ($indici_i AS $k => $ik)   $improduttivi[$ik] = getIntestazione ( $archivio , $ik )->intesta;

?>
<div id='home' class='descrp_schede'>

  <form name="descrp_schede_form" action="#" method="post">

  <div id='descrp_schede'>
 	<div id='descrp_schede_top'>  
		<div id='b_title_descrp' class="white"><span>Regione
		    <?php  if (isset($_REQUEST['codice']) and $_REQUEST['codice'] != 'bosco...'){ echo $regione->descriz ; }
			    else echo "...";  ?><span>
			    <br /><span>Sistema informativo per l'assestamento forestale<span>
		</div> <!--//DIV: b_title_reg-->

		<div  class='bottone_alto'>
		      <table> <tbody class='center'><tr><td>
		      <?  if( isset($_GET['new']))
				  echo "<input class='grande grande1' title='Inserisci dati di $propriet->descrizion particella $particella' type='submit' name='inserisci_dati' value='Inserisci dati' />";
			  else	echo "<input class='grande grande1' title='Modifica dati di $propriet->descrizion particella $particella' type='submit' name='modifica_dati' value='Modifica dati' />";?>
		      </td></tr></tbody></table>
		</div>
		<div id='ds_top_top' class='daticat'>
		      <div class='block1010'><table width='400px'><caption>Bosco</caption>
		      <tr><td><?php echo $propriet->descrizion?></td></tr></TABLE></div>

		      <div class='block1010'><table width='350px'><caption>Rilevatore</caption>
		      <tr><td><?php echo $rilevato->descriz?></td></tr></TABLE></div> 

		      <div class='block1010'><table width='200px'><caption>Data del rilievo</caption>
		      <tr><td> <input type='text' name='datasch' value='<?php echo $info->datasch?>'/></td></tr></TABLE></div>
		</div> <!--id='ds_top_top' class='daticat'-->
        </div> 
      <!-- id='descrp_schede_top'-->
      <?php
//------------------------------------------------------------ Scheda A -------------------------------------------------
if ($scheda == 'Scheda A') {    


?>  
      
    <div id='ds_center1' >

	    <div id="ds_container1" class='tavole'>
		  <div id='ds_title' class='block'>Scheda A per la descrizione di<br />FATTORI AMBIENTALI E DI GESTIONE</div>
		  <div class='block10'><table width='250px'><caption>Comune</caption>
		  <tr><td><input type='text' name='comuni_descriz' value='<?php echo $comune->descriz?>' /></td></tr></TABLE></div>
		  <div class='block1010'><table width='200px'><caption>Altitudine prevalente (m)</caption>
		  <tr><td><input type='text' name='ap' value='<?php echo $info->ap?>' /></td></tr></TABLE></div>
		  <div class='block10'><table width='250px'><caption>Nome del Luogo</caption>
		  <tr><td><input type='text' name='toponimo' value='<?php echo $info->toponimo?>' /></td></tr></TABLE></div>
 		  <div class='block1010'><table width='200px'><caption>Pendenza prevalente (%)</caption> 
		  <tr><td><input type='text' name='pp' value='<?php echo $info->pp?>' /></td></tr></TABLE></div>
	    </div> <!--id="ds_container" class='tavole'-->

	    <div id="ds_container2" class='tavole'>
		  <div class='block10'><table width='110px'><caption>Superficie (ha)</caption>
		  <tr><td><input type='text' name='sup_tot' value='<?php echo $info->sup_tot?>' /></td></tr></TABLE></div>
		  <div class='block10'><table width='110px'><caption>Sup. boscata (ha)</caption>
		  <tr><td class='grey'><?php echo $info->bosc?></td></tr></TABLE></div> 
		  <div class='block10'><table width='110px'><caption>Improduttivi (ha)</caption>
		  <tr><td class='grey'><?php echo $info->improd?></td></tr></TABLE></div>
		  <div class='block10'><table width='110px'><caption>Produttivi non<br />boscati (ha)</caption>
		  <tr class='grey'><td><?php echo $info->p_n_bosc?></td></tr></TABLE></div> 
	    </div> <!--id="ds_container2" class='tavole'-->

	    <div id="ds_container3" class='tavole'>
		  <div class='block1010'><table width='200px'><caption>Particella/Sottoparticella</caption>
		  <tr><td><?php echo $particella ?></td></tr></TABLE><span> questo dato non cambia</span></div>

		  <div class='block1010'><table width='250px'><caption>Sottoparticella</caption>
		  <tr><td><input type="radio" class='radio_dis' name="delimitata" value="t" <? if($info->delimitata == 't'):echo " checked"; endif; ?> /></td><td>delimitata</td>
		      <td><table width='150px'><caption>estesa sul ...(%)</caption><tr><td><input type='text' name='sup' value='<?php echo $info->sup?>' /></td></tr></table>
		      </td></tr>
		  <tr><td><input type="radio" class='radio_dis' name="delimitata" value="f" <? if($info->delimitata == 'f'):echo " checked"; endif; ?> /></td><td>non<br />delimitata</td><td></td></tr>
		  </TABLE></div> 
	    <span> DeLIMITATA è la colonna giusta? -->null!</span>
	    </div> <!--id="ds_container3" class='tavole'-->
    </div><!-- id='ds_center1' -->

    <div id='ds_center2' >
<!--  -->
<!-- Posizione fisiografica prevalente  -->
<!--  -->
	    <div id="ds_container4" class='tavole'>
		  <div class='block10'><table  class='row'><caption class="span"><span>Posizione fisiografica prevalente</span></caption>
		  <tr><?php foreach ( $posfisio as $indice => $pos ) {
			    $k = $indice + 1;
			    echo "<td><input type='radio' class='radio_dis' name='pf1' value='$k'"; if($info->pf1 == $k ): echo " checked"; endif;
			    echo " /></td><th>$pos->descriz</th>\n"; }  ?>
		  </tr></TABLE></div>  
	    </div> <!--id="ds_containe5" class='tavole'-->

<!--  -->
<!-- Esposizione prevalente  -->
<!--  -->
	    <div id="ds_container5" class='tavole'>
		  <div class='block'><table><caption class="span"><span width='250px'>Esposizione prevalente</span></caption>
	    <?php
		  echo "<tr><td colspan='2'></td><td><input type='radio' name='e1' value='1'"; if($info->e1 == '1'):echo " checked"; endif; echo "/>N</td><td colspan='2'></td></tr>\n";
		  echo "<tr><td></td><td><input type='radio' name='e1' value='8' "; if($info->e1 == '8'):echo " checked"; endif; 
			echo "/>NO</td><td></td><td><input type='radio' name='e1' value='2'"; if($info->e1 == '2'):echo " checked"; endif;  
			echo "/>NE</td><td></td></tr>\n";
		  echo "<tr><td><input type='radio' name='e1' value='7'" ; if($info->e1 == '7'):echo " checked"; endif;  
		  echo "/>O</td><td></td><td><input type='radio' name='e1' value='9'"; if($info->e1 == '9'):echo " checked"; endif;  
		  echo "/>null</td><td></td><td><input type='radio' name='e1' value='3'"; if($info->e1 == '3'):echo " checked"; endif; 
		  echo "/>E</td></tr>\n";
		  echo " <tr><td></td><td><input type='radio' name='e1' value='6'"; if($info->e1 == '6'):echo " checked"; endif; 
			echo "/>SO</td><td></td><td><input type='radio' name='e1' value='4'"; if($info->e1 == '4'):echo " checked"; endif; echo "/>SE</td><td></td></tr>\n";
		  echo "<tr><td colspan='2'></td><td><input type='radio' name='e1' value='5'"; if($info->e1 == '5'):echo " checked"; endif;
		  echo " />S</td><td colspan='2'></td></tr>\n";?>
		  </TABLE></div> 
	    </div> <!--id="ds_container5" class='tavole'-->

	    <div id="ds_container6" class='tavole'>
<!--  -->
<!-- Dissesto  -->
<!--  -->
		  <div class='block10'><table class="checkbox_in"><caption class="span"><span>Dissesto</span></caption>
		  <tr class='back_blue'><td></td><th>assente</th><th>&lt;5%</th><th>&lt;1/3</th><th>&gt;1/3</th><th>pericolo di<br />peggioramento</th><td></td></tr>
 		  <?php 
		    foreach ( $dissesto as $ak => $a) { 
			      echo "<tr><th>$a</th>\n";
			      echo "<td><input type='radio' name='$ak' value='0'"; if($info->$ak ==  0 ): echo " checked"; endif;
			      echo " /></td>\n" ; 
			      for( $i=2; $i<=4; $i++ ) {
				  echo "<td><input type='radio' name='$ak' value='$i'"; if($info->$ak ==  $i ): echo " checked"; endif;
				  echo " /></td>\n" ; }
			      echo "<td><input type='radio' name='$ak' value='1'"; if($info->$ak ==  1 ): echo " checked"; endif;
			      echo " /></td>\n" ; 
			      if ($ak == 'a7'){
				    echo "<td><table width='200px'><caption>specifica altri fattori</caption>";
				    echo "<tr><td><input type='text' name='a8' value='$info->a8' /></td></tr></TABLE>\n";
				    }
			      else { echo "<td></td></tr>\n";}
			}
 		 ?>
		  </TABLE></div> 
	    <span style='color:#580000'> campo a5 ma non viene usato ??? Intestazione colonne -> piu1_3</span>
	    </div> 
	    <!--id="ds_container6" class='tavole'-->
    </div>
    <!-- id='ds_center2' -->

    <div id='ds_center3' >

	    <div id="ds_container7" class='tavole'>
<!--  -->
<!-- Limiti dello sviluppo delle radici -->
<!--  -->
		  <div class='block10'><table class="checkbox_in"><caption class="span"><span>Limiti dello sviluppo delle radici</span></caption>
		  <tr class='back_blue'><td></td><th>assenti o<br />limitati</th><th>&lt;5%</th><th>&lt;2/3</th><th>&gt;2/3</th></tr>
		  <?php
		    foreach ( $limite_radici as $rk => $r) { 
			      echo "<tr><th>$r</th>\n";
			      for( $i=0; $i<=3; $i++ ) {
				  echo "<td><input type='radio' name='$rk' value='$i'"; if($info->$rk ==  $i ): echo " checked"; endif;
				  echo " /></td>\n" ; }
			      if ($rk == 'r6'){
				    echo "<td><table width='200px'><caption>specifica altri fattori</caption>";
				    echo "<tr><td><input type='text' name='r7' value='$info->r7' /></td></tr></TABLE>\n";
				    }
			      else { echo "<td></td></tr>\n";}
			}
		 ?>
		  </TABLE></div> <span style='color:#580000'>  Intestazione colonne -> piu2_3 </span>
	    </div> 
	    <!--id="ds_container7" class='tavole'-->
    </div>
    <!-- id='ds_center3' -->

    <div id='ds_center4' >

	    <div id="ds_container8" class='tavole'>
<!--  -->
<!--Fattori di alterazione fitosanitaria  -->
<!--  -->
		  <div class='block10'><table class="checkbox_in"><caption class="span"><span>Fattori di alterazione fitosanitaria</span></caption>
		  <tr class='back_blue'><td></td><th>assenti</th><th>&lt;5%</th><th>&lt;1/3</th><th>&gt;1/3</th><th>pericolo di<br />peggioramento</th></tr>
		   <?php 
		    foreach ( $fattori_alt as $fk => $f) { 
			      echo "<tr><th>$f</th>\n";
			      echo "<td><input type='radio' name='$fk' value='0'"; if($info->$fk ==  0 ): echo " checked"; endif;
			      echo " /></td>\n" ; 
			      for( $i=2; $i<=4; $i++ ) {
				  echo "<td><input type='radio' name='$fk' value='$i'"; if($info->$fk ==  $i ): echo " checked"; endif;
				  echo " /></td>\n" ; }
			      echo "<td><input type='radio' name='$fk' value='1'"; if($info->$fk ==  1 ): echo " checked"; endif;
			      echo " /></td>\n" ;
			      if ($fk == 'f11'){
				    echo "<td><table width='200px'><caption>specifica altri fattori</caption>";
				    echo "<tr><td><input type='text' name='f11' value='$info->f11' /></td></tr></TABLE>\n";
				    }
			      else { echo "<td></td></tr>\n";}
			}
		 ?>
		  </TABLE></div> 
	    <span style='color:	#580000'>Non so perchè ma manca il campo f9 ??? Intestazione colonne -> piu1_3</span>
	    </div> 
	    <!--id="ds_container8" class='tavole'-->
    </div>
    <!-- id='ds_center4' -->


    <div id='ds_center5'  class='tavole'>

<!--  -->
<!-- Accessibilità -->
<!--  -->
	    <div id="ds_container9" class='tavole'>
		  <div class='block10'><table width='280px'><caption class="span"><span>Accessibilità</span></caption>
		  <tr><td><table  width='150px'><caption>insufficiente sul ...(%)</caption>
			  <tr><td><input type='text' name='v3' value='<?echo $info->v3?>'/></td></tr></table></td>
		   <td><table  width='120px'><caption>buona sul ...(%)</caption>
			  <tr><td><input type='text' name='v1' value='<?echo $info->v1?>' /></td></tr></table></td>
		  </tr></TABLE></div>   
	    </div> <!--id="ds_container9" class='tavole'-->
<!--  -->
<!-- Ostacoli agli interventi -->
<!--  -->
	    <div id="ds_container10" class='tavole'>
		  <div class='block10'><table class='row' width='700px'><caption class="span"><span>Ostacoli agli interventi</span></caption><tr class='back_blue'>
		  <?php foreach ( $ostacoli as $indice => $ostacolo ) {
			    $k = $indice + 1;
			    echo "<td><input type='radio' name='o' value='$k'"; if($info->o == $k ): echo " checked"; endif;
			    echo " /></td><th>$ostacolo->descriz</th>\n"; }  ?>
		  </tr></TABLE><span style='color:#580000'> ha senso che questi testi siano con sfondo blu? forse vanno bene così</span></div>   
	    </div> <!--id="ds_container10" class='tavole'-->

<!--  -->
<!-- Condizionamenti Eliminabili -->
<!--  -->
	    <div id="ds_container11" class='tavole'>
		  <div class='block10'><table><caption class="span"><span>Condizionamenti Eliminabili</span></caption><tr>
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
		  </td></tr></TABLE>
		  <span style='color:#580000'> primo checkbox sarebbe 'assenti', modifica 'intesta'in archivi</span></div>  
	    </div> <!--id="ds_container11" class='tavole'-->
<!--  -->
<!-- Fatti particolari -->
<!--  -->
	    <div id="ds_container12" class='tavole'>
		  <div class='block10'><table width='1115px'><caption class="span"><span>Fatti particolari</span></caption><tr>
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

				  echo "<td><table width='450px'><caption class='span'><span>specie pascolante</span></caption>\n<tr>";
				  foreach ($pascolo AS $j => $animale){
				      echo "<td><input type='radio' class='depends_on depends_group_pascoli' name='p7' value='$j'"; if($info->p7 == '$j' ): echo " checked"; endif;
				      echo " /></td><th>$animale</th>\n";
				  }
				  echo "<th><table width='100px'><caption>Specifica</caption><tr><td><input type='text' name='p9' value='$info->p9' /></td></tr></table></th>\n";
				  echo "</td></tr></table>"; 
			    }
			    else { 
				echo "<td><input type='checkbox' class='check_nessuno check_nessuno_group_fatti' name='$pk' value='$i'"; if($info->$pk == 't' ): echo " checked"; endif;
				echo " /></td><th>$p</th>\n"; 
			    }
		    }
?>
		    <td><table width='100px'><caption>specifica</caption>
			  <tr><td><input type='text' name='p8' value='<?php echo $info->p8 ?>' /></td></tr></TABLE></td>
		  </tr></TABLE></div>   
	    <span style='color:	#580000'>Qui alcune intestazioni non sono uguali, bisognerebbe modificare la tabella 'archivi'</span>
	    </div> 

	    <!--id="ds_container12" class='tavole'-->
    </div>
    <!-- id='ds_center5' -->


    <div id='ds_center6'  class='tavole'>
<!--  -->
<!-- Improduttivi inclusi non cartografati -->
<!--  -->
	    <div id="ds_container13" class='tavole'>
		  <div class='block10'><table width='800px'><caption class="span"><span>Improduttivi inclusi non cartografati</span></caption>
		      <tr><td><table><caption>superficie (ha)</caption><tr><td width="100px"><input type='text' name='i1' value='<?echo $info->i1 ?>' /></td></tr></table></td>
		      <td><table><caption>superficie (%)</caption><tr><td  width="100px"><input type='text' name='i2' value='<?echo $info->i2 ?>' /></td></tr></table></td>
		      <?php foreach ( $improduttivi as $ik =>  $imp ) {
				$i = trim($ik, 'i');
				echo "<td><input type='checkbox' name='$ik' value='$i'"; if($info->$ik == 't' ): echo "checked"; endif;
				echo " /></td><th>$imp</th>\n"; }   ?>
		      <td><table><caption>specifica</caption><tr><td  width="150px"><input type='text' name='i8' value='<?echo $info->i8?>' /></td></tr></table></td>
		  </tr></TABLE></div>  
<!--  -->
<!-- Improduttivi non boscati inclusi non cartografati -->
<!--  -->
		  <div class='block10'><table width='300px'><caption class="span"><span>Produttivi non boscati inclusi non cartografati</span></caption>
			<tr><td><table><caption>superficie (ha)</caption><tr><td width="100px"><input type='text' name='i21' value='<?echo $info->i21 ?>' /></td></tr></table></td>
			<td><table><caption>superficie (%)</caption><tr><td  width="100px"><input type='text' name='i22' value='<?echo $info->i22 ?>' /></td></tr></table></td> 
		  </tr></TABLE></div> 
	    </div> <!--id="ds_container13" class='tavole'-->

<!--  -->
<!-- Opere e manufatti -->
<!--  -->
	    <div id="ds_container14" class='tavole'>
		  <div class='block'><table width='1120px'><caption class="span"><span>Opere e manufatti</span></caption>
		      <?php 

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
		      <td colspan='2'><table><caption>specifica</caption><tr><td  width="150px"><input type='text' name='m19' value='<?echo $info->m19 ?>' /></td></tr></table></td>
		  </tr></TABLE>
		  <span style='color:#580000'>manca il campo m11, primo checkbox sarebbe 'assenti'</span></div>
	    </div> <!--id="ds_container14" class='tavole'-->
    </div>
    <!-- id='ds_center6' -->

    <div id='ds_center7'  class='tavole'>
<!--  -->
<!-- Note alle singole voci -->
<!--  -->
	    <div id="ds_container15" class='tavole'>
	      <div class='block10'><table width='1100px'><caption class="span"><span>NOTE alle singole voci</span></caption>
	      <tr><th>Parametro</th><th>Nota</th></tr> <!--<th>Proprietà</th><th>Particella</th>-->
	      <?php if (isset($note_a) AND !empty($note_a)){
			  foreach ($note_a as $n) {
			  echo "<tr><td class='center'>$n->cod_nota</td><td>$n->nota</td></tr>\n";//<td class='center'>$boschi->codice</td><td class='center'>$info->cod_part</td>
			  } 
		    }else { echo "<tr><td>...</td><td>...</tr>";}
	      ?></table></div>
	    </div> <!--id="ds_container15" class='tavole'-->
<!--  -->
<!-- NOTEj -->
<!--  -->
	    <div id="ds_container16" class='tavole'>
		  <div class='block10'><table class="big_200"><caption>NOTE</caption>
		  <tr><td class="top"><input type='text' name='note' value="...<?php echo $info->note?>" /></td></tr>
		  </table></div>

<?php
     echo "<div id='ds_center8'  class='tavole'>";
	    echo "<div  class='bottone_basso'><table> <tbody class='center'><tr><td>";
	    if( isset($_GET['new']) )	    echo "<input class='grande grande1' type='submit' name='inserisci_dati' value='Inserisci dati' />" ;
	    else    			    echo "<input class='grande grande1' type='submit' name='modifica_dati' value='Modifica dati' />" ;
	    echo "</td></tr></tbody></table></div>\n";
    echo "</div>\n";
}
//   fine della scheda A
?>
<!-- ################################################################ -->
</form>

  <form name='particelle_cat_form' action="#" method="post">
  <? $codice = $_REQUEST["codice"];
  $particella = $_REQUEST['particella'];
  $scheda = $_REQUEST['schedaA'];
?>
<!--  -->
<!-- Dati catastali -->
<!--  -->
		  <div id='contorno_dati' class='block10'>
			<table><tr><td>
				<table width='730px' class='checkbox_in'><caption class="span"><span class='light_span'>Dati catastali</span></caption>
 <?php					echo "<tr class='back_light_blue'>";
					foreach ($dati_catasto as $i => $d){
					    if ($i==7)  {echo "<td><div><table> <tbody class='center'><tr><td>";
						echo "<input class='grande grande2' title='bosco $propriet->descrizion e particella $particella' type='submit' name='modify_cat' value='Aggiorna\nsuperficie\ntotale' ";
						echo "/>";
// echo "<a class=' modifica' title='bosco $propriet->descrizion e particella $particella' href='#modify_cat=$codice&modify_cat2=$particella'>Aggiorna\nsuperficie\ntotale</a>";
					      
					echo "</td></tr></tbody></table></div></td></tr>";
						    echo "<tr class='back_light_blue'><th width='200px'>$d</th>\n" ;}// per l'ultima colonna NOTE faccio larghezza maggiore
					    else echo "<th rowspan='2'>$d</th>\n" ;}?>
				</tr><tr>
<?php					foreach ($catasto as $i => $c ) {
					    if ($i==7) echo " <td><input type='text' name='$i' value='$c' /></td>\n";
					    else echo " <td><input type='text' name='$i' value='$c' /></td>\n";
					    }   ?> </tr>
				<tr><td colspan='7'>--------------------</td></tr>
				<tr class='back_light_blue'>
				  <td colspan='2'></td><th>Totali</th><td><? echo $sum_catasto->sum_sup_tot."</td><td>".$sum_catasto->sum_sup_tot."</td><td>".$catasto->sum_sup_non_bosc; ?></td><td colspan='2'></td>
				</tr>
				</table>
			</td></tr></table>
		</div>
<!--  -->
<!-- bho -->
<!--  -->
		  <div class='block10'><table width='150px'>
		      <tr><td><table width="120px"><caption>superficie (ha)</caption><tr><td  class='grey'><?php echo $info->sup_tot ?></td></tr></table></td></tr>
			 <tr> <td><table width="120px"><caption>sup.boscata (ha)</caption><tr><td  class='grey'><?php echo $info->bosc ?></td></tr></table></td></tr>
			  <tr><td><table width="120px"><caption>produttivi non<br />boscati (ha)</caption><tr><td  class='grey'><?php echo $info->p_n_bosc?></td></tr></table></td></tr>
			  <tr><td><table width="120px"><caption>improduttivi (ha)</caption><tr><td  class='grey'><?php echo $info->improd?></td></tr></table></td></tr>
			  <tr class='back_blue'><th><span> N.B. per comodità di lettura sono riportati i dati</span></th></tr>
		  </table></div>
	    </div> 
	    <!--id="ds_container16" class='tavole'-->

    </div>
    <!-- id='ds_center7' -->

</div>
   <!--div id='descrp_schede'-->


</form>
</div>
<?php
//  <!--div id='home' class='descrp_schede'-->
}
?>