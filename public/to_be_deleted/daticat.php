<div id='home' class='daticat'>


<!--corpo principale della pagina-->
  <form name='daticat_form' action="?page=daticat" method="post">
  <div id='daticat'>

  <div id='daticat_top'>
<?php
      if (!isset($codice))   $codice = "undefine";
      if (!isset($particella))   $particella = "undefine";
      if (!isset($_GET['codice']))  $_GET['codice'] = "undefine";
      if (!isset($_GET['particella']))  $_GET['particella'] = "undefine";
      if (!isset($_POST['particella']))  $_POST['particella'] = "undefine";

	echo "<div id='b_title_reg' class='daticat'> ";
	      echo "Regione ";
	      if (isset($_GET['codice']) and $_GET['codice'] != 'undefine'){
		      $codice=$_GET['codice'] ;
		      $regione = getDiz_regioniCod($codice);
		      echo $regione->descriz;
 		    }
	      else echo "...";
	      echo "<br />Sistema informativo per l'assestamento forestale";
	echo "</div>";  //DIV: b_title_reg
?>
    <!--titolo della pagina-->
      <div id='b_title' class='daticat'>Procedura per<br>
      GESTIONE DEI DATI CATASTALI
      </div>                                                       <!--DIV:b_title-->

<?php
      // definizione delle variabili

    
	echo "<div id='daticat_bosco'>";

	//menù a tendina per scelta bosco
	    echo "<table id='daticat' class='descrp'>";
	      echo  "<tbody>";
		echo "<tr><td>Bosco</td><td>";
		  echo "<select name='codice' onChange='javascript:daticat_form.submit();'>";
		    echo "<option selected='selected'>bosco...</option>";
		    $codici = getCodiciBoschi();
		    foreach( $codici as $codice ) {
			    $selected = ( isset($_POST['codice']) and $_POST['codice'] == $codice->codice )? 'selected' : ' ' ;
			  echo "<option value='".$codice->codice."'". $selected.">".$codice->codice." ".$codice->descrizion."</option>\n";
			  }
		    echo "</select></td>";
		    $codice = ( isset($_POST['codice']) ) ? $_POST['codice'] : '-1' ; 
	      echo "</tbody>";
	    echo "</table>";

	echo "</div>";                         //<!--DIV:daticat_table-->
			
 	      $particella = ( isset($_POST['particella']) ) ? $_POST['particella'] : '-1' ;

	// tasti per scelta visualizzazione
	echo "<a class='daticat_button' href='?page=daticat&codice=".$codice."&particella=".$particella."'>Visualizza dati catastali</a>";
	echo "<a class='daticat_button' href='?page=daticat'>Aggiorna Superfici Totali particellare</a>";
?>
  </div>  <!--id='daticat_top'-->

    <div id='daticat_table1'>
<?php
	// nuovo menù a tendina per la scelta della particella

	echo "<table>";
	echo "<caption>Particellare Catastale</caption>";
	  echo "<tr><th>Foglio</th><th>Particella catastale</th><th>Sup. totale afferente alla particella</th><th>Sup. boscata afferente alla particella</th><th>% afferente</th><th>Note</th><th>Bosco</th><th>Particella forestale</th>"; 

	    echo  "<tbody>";
     if ( $_POST['particella'] = 'undefine') {
	      echo "<tr>";
		for ($i = 1; $i <= 7; $i++) {
		    echo "<td> ... </td>\n";
		    }
		    echo "<td>";
		      $disabled = ( !isset($_POST['codice']) ) ? 'disabled' : '' ;
		      //se non viene selezionato il bosco (codice) allora l'option della particella è disabilitato
		      echo "<select name='particella' onChange='javascript:daticat_form.submit();' $disabled>" ;
		      echo "<option  selected='selected'>particella...</option>" ;
			$particelle = getCodiciPart( $codice ) ;
			foreach( $particelle as $particella ) {
			    $selected = (isset($_POST['particella']) and $_POST['particella'] == $particella->cod_part )? 'selected' : ' ' ;
			    echo "<option value='".$particella->cod_part."'". $selected.">".$particella->cod_part."</option>\n" ;
			}
		      echo "</select></td></tr>" ;
	      $particella = ( isset($_POST['particella']) ) ? $_POST['particella'] : '-111' ;
      }

    if ( isset($_GET['particella']) AND $_GET['particella'] != '-1') {
	  $codice = $_GET['codice'];
	  $particella = $_GET['particella'];
	  $elenchi= getInfoCatasto($codice , $particella) ;
	  foreach( $elenchi as $elenco ){
		echo "<tr><td>$elenco->foglio</td>\n";
		echo "<td>$elenco->particella</td>\n";
		echo "<td>$elenco->sup_tot</td>\n";
		echo "<td>$elenco->sup_bosc</td>\n";
		echo "<td>$elenco->porz_perc</td>\n";
		echo "<td>$elenco->note</td>\n";
		echo "<td>$elenco->descrizion</td>\n";
		echo "<td>$elenco->cod_part</td></tr>\n";
		}
	      echo "</tbody>";
	  echo "</table>";
	  }  //if ( isset($particella))

	echo "<table>";
	echo "<caption>Particellare Forestale - Scheda A</caption>";
	  echo "<th>Superficie particella forestale</th><th>SOMMA INCLUSI improdut + produt</th><th> superficie (ha)</th><th>superficie (%)</th><th>rocce</th><th>acqua</th><th>strade</th><th>viali tagli</th><th>altri fatto</th><th>Specifica</th><th>superficie (ha)</th><th>superficie (%)</th></tr>"; //<th></th>
	    echo  "<tbody>";
	      echo "<tr>";
		for ($i = 1; $i <= 11; $i++) {
		    echo "<td> ... </td>\n";
		    }
	      echo "<td> ... </td></tr>";
	    echo  "</tbody>";
	echo "</table>";
    echo "</div>";  //DIV:daticat_table1
?>
   </div>                                <!--DIV:daticat-->
   </form>
</div>                          <!--DIV:home-->

	

