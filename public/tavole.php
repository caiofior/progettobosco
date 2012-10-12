<div id='home' class='descrp'>
  <div class='b_title'>Tavole di cubatura</div>

    <form id='tavole_form' name='tavole_form' action="?page=tavole" method="get">
	<table class='descrp'>
	<tbody class='center'>
		<input type='hidden' name='page' value='tavole' />
		<input type='hidden' name='scheda' value='tavole' />
	    <?PHP
	   echo  "<tr><td>Seleziona tavola</td></tr>";

	   echo  "<tr><td><select id='tavole_select' name='tavola'>";
		echo  "	<option value='-1'>tavola...</option>
			<option value='-2'>nuova tavola...</option>";
		$tavole = getCodiciTavole();
		foreach ($tavole as $tavola){
		  $selected = ( isset($_POST['tavola']) and $_POST['tavola'] == $tavola->codice )? 'selected' : ' ' ;
		  echo "<option value='".$tavola->codice."' ".$selected." >$tavola->codice $tavola->descriz</option>\n";
		  }
	    echo "</select></td></tr>";
	    $tavola = ( isset($_POST['tavola']) ) ? $_POST['tavola'] : 'null' ;
	    //if( isset($_POST['tavola']) )
	      echo "<tr><td><input type='submit' value='Inserisci/Modifica' /></td></tr>";
	echo "</tbody></table>";
    echo "</form>";
echo "</div>";
?>