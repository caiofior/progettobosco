<div id='home' class='descrp'>
<div class='b_title'>Rilievi dendrometrici</div>
  <form name='particelle' action="?page=rildend" method="post">

  <table>
	<tbody>
<?php

	echo "<tr><td>Bosco</td><td>";
	  echo "<select name='codice' onChange='javascript:particelle.submit();'>\n";
	    echo "<option selected='selected'>bosco...</option>";
	    $codici = getCodiciBoschi() ;
	    foreach( $codici as $codice ) {
		    $selected = ( isset($_POST['codice']) and $_POST['codice'] == $codice->codice )? 'selected' : ' ' ;
		    echo "<option value='".$codice->codice."'". $selected.">".$codice->codice." ".$codice->descrizion."</option>\n";
		    }
	  echo "</select></td></tr>\n";
	$codice = ( isset($_POST['codice']) ) ? $_POST['codice'] : '-1' ;

// seconda riga per la scelta della particella
	echo "<tr><td>Particella</td><td>";
	$disabled = ( !isset($_POST['codice']) ) ? 'disabled' : '' ;
	//se non viene selezionato il bosco (codice) allora l'option della particella è disabilitato
	echo "<select name='particella' onChange='javascript:particelle.submit();' $disabled>\n" ;
	echo "<option>particella...</option>" ;
	  $particelle = getCodiciPart( $codice ) ;
	  foreach( $particelle as $particella ) {
		  $selected = ( isset($_POST['particella']) and $_POST['particella'] == $particella->cod_part )? 'selected' : ' ' ;
		  echo "<option value='".$particella->cod_part."'". $selected.">".$particella->cod_part."</option>\n" ;
		  }
	echo "</select></td></tr>\n" ;
	$particella = ( isset($_POST['particella']) ) ? $_POST['particella'] : '-1' ;

// terza riga per la scelta della particella
	echo "<tr><td>Tipo Rilievo</td><td>";
	$disabled = ( !isset($_POST['particella']) ) ? 'disabled' : '' ;
	echo "<select name='rildend' onChange='javascript:particelle.submit();' $disabled>\n" ;
  	echo "<option>tipo...</option>\n" ;
	  $rildendi = getRilDend($codice , $particella);
	    foreach( $rildendi as $rildend ) {
		  $selected = ( isset($_POST['rildend']) and $_POST['rildend'] == $rildend->diz_tiporil_descrizion )? 'selected' : ' ' ;
		  echo "<option value='".$rildend->diz_tiporil_descrizion."'". $selected.">".$rildend->diz_tiporil_descrizion."</option>\n" ;
		  }
	echo "</select></td></tr>\n" ;
	$rildend = ( isset($_POST['rildend']) ) ? $_POST['rildend'] : '-1' ;

	echo "<tr><td>Data Rilievo</td>";

	echo "<td>...</td></tr>\n";
 ?>
</tbody>


<!--<table>
  <tbody>
    <tr>
    <form action="insdendr.php" method="get"> 
    <td>Bosco</td>
    <td colspan="4"><select name='codice'>
    <?
    $rows = getCodiciBoschi();
    foreach ($rows as $row){
   // echo "<option value= '".$row->codice."'>".$row->codice." ".$row->descrizion."</option>\n";
    }

    ?>
    </select>
    <TD>Particella</TD>
    <TD colspan="1" width=100><select name='cod_part'>
    <?
   // $conn=connessione_db(); 
    $rows = getCodiciPart ();
    while($row = pg_fetch_object($query)){
    ?>
    <option value="<?echo "$row->cod_part"?>"><?echo "$row->cod_part"?></option>
    <?
    }
    ?>
    </select>
    <TD>Tipo rilievo</TD>
    <TD colspan="2" width=100><select name=tiporil>
    <?
    $query = pg_Exec($conn,"select SCHEDE_X.tipo_ril,diz_tiporil.descrizion from SCHEDE_X LEFT JOIN diz_tiporil ON diz_tiporil.codice =SCHEDE_X.tipo_ril ;");
    while($row = pg_fetch_object($query)){
    ?>
    <option value="<?echo "$row->tipo_ril"?>"><?echo "$row->descrizion"?></option>
    <?
    }
    ?>
    </select>
    </tr>
    <tr>
    <tr>
    <td colspan="6"></td>
    <td colspan="2">
    <input type="submit" value="Visualizza o inserisci
 dati dendrometrici"></form>
    </td></tr>
</tbody>
  </TABLE>-->
  </td>
  </tr>
</table>


</div>                     <!-- id='home' class='descrp'-->