<div id='home' class='descrp'>
<div class='b_title'>Descrizioni particellari</div>
  <form id='particelle_form' name='particelle_form' action="?page=descrp" method="post">
	 <table class='descrp' width ='70%'>

	  <tbody class='center'>
<?php
$BX =null;
// prima riga per la scelta del bosco
		  echo "<tr><td>Bosco</td><td colspan='5'>\n";
		    echo "<select id='proprieta_select' name='proprieta' onChange='javascript:particelle_form.submit();'>"; 
		      echo "<option selected='selected' value='-1' >bosco...</option>\n";
		      $codici = getCodiciBoschiDiz_reg() ;
		      foreach( $codici as $codice ) {
			      $selected = ( isset($_POST['proprieta']) and $_POST['proprieta'] == $codice->codice )? 'selected' : ' ' ;
			echo "<option value='".$codice->codice."'". $selected.">".$codice->codice." | ".$codice->descrizion." | ".$codice->descriz."</option>\n";
			}
		    echo "</select></td></tr>\n";
		  $codice = ( isset($_POST['proprieta']) ) ? $_POST['proprieta'] : '-1' ;

// seconda riga per la scelta della particella
		  echo "<tr><td>Particella</td><td colspan='5'>\n";
		  $disabled = ( !isset($_POST['proprieta']) ||  $_POST['proprieta'] == '-1') ? 'disabled' : '' ;
		  //se non viene selezionato il bosco (proprieta) allora l'option della particella è disabilitato
		  echo "<select  id='descrp_select' name='particella' $disabled >" ;/* onChange='javascript:particelle_form.submit();'  */
		  echo "<option value='-1' >particella...</option>\n" ;
		  echo  "<option value='-2'>nuova particella...</option>\n";
			    $particelle = getCodiciPart2( $codice ) ;/*$particelle = getCodiciPart ( $codice, $schede_b ) ;*/
			    foreach( $particelle as $particella ) {
				    $selectedP = ( isset($_POST['particella']) and $_POST['particella']==$particella->cod_part )? 'selected': '' ;
				    $schede_b = getSchede_b($particella->u);
				    echo "<option value='$particella->cod_part' $selectedP >$particella->cod_part $particella->toponimo | $schede_b - $particella->descriz</option>\n" ;
					if (isset($selectedP) and $selectedP== 'selected')  $BX = $schede_b ;
			    }
		  echo "</select></td></tr>\n" ;
		  $particella = ( isset($_POST['particella']) ) ? $_POST['particella'] : '-1' ;
		  $BX = ($BX=='scheda B vuoto')? 'noB': $BX;  //cambio il valore di BX sennò ho tre parole staccate e non sono comode per fare le classi dei submit dopo.

// inizio bottoni sottostanti per visualizzare le schede A, B1, B2....
 	echo " <tr >";
 	echo " <tr >\n";
	      echo "<td><input id='ctrl_schedaA' type='submit' name='schedaA' class='conferma schedaA' title='scheda A' value='Scheda A' /></td>\n";
 	      echo "<td><input type='submit' name='schedB1' class='conferma' "; if ($BX!='B1' && $BX!='noB') echo" disabled";echo " title='scheda B1' value='Scheda B1' /></td>\n";
 	      echo "<td><input type='submit' name='schedB2' class='conferma' "; if ($BX!='B2' && $BX!='noB') echo" disabled";echo " title='scheda B2' value='Scheda B2' /></td>\n";
 	      echo "<td><input type='submit' name='schedB3' class='conferma' "; if ($BX!='B3' && $BX!='noB') echo" disabled";echo " title='scheda B3' value='Scheda B3' /></td>\n";
 	      echo "<td><input type='submit' name='schedB4' class='conferma' "; if ($BX!='B4' && $BX!='noB') echo" disabled";echo " title='scheda B4' value='Scheda B4' /></td>\n";
 	      echo "<td><input type='submit' name='schedeN' value='Scheda N' /></td>\n";
 		echo " </tr >";

?>	

		<tr><td></td>
		  <td colspan=2><input type="submit" name="elabora" value=" ELABORA
descrizioni
(Rigenara il testo
delle descrizioni)"> </td>
		  
		  <td colspan=2> <input type="submit" name="elabora" value=" MODIFICA descrizioni
(consente di modificare il
testo generato dal
programma)">      </td>
		</tr>

		<tr><td colspan=6><b>Visualizzazione problemi <br> inserimento dati</b></td></tr>

		<tr>
		  <td><input type="submit" name="scheda1" value="Schede A"></td>
		  <td><input type="submit" name="scheda1" value="Schede B1"></td>
		  <td><input type="submit" name="scheda1" value="Schede B2"></td>
		  <td><input type="submit" name="scheda1" value="Schede B3"></td>
		  <td><input type="submit" name="scheda1" value="Schede B4"></td>
		  <td></td>
		</tr>
	    

<?php	
      echo "</tbody></TABLE>";
  echo "</form></div>";


?>
