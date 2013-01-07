<div id='home' class='bosco'>
<div id='titolo' class='b_title'>Bosco</div>

	<div id='table_bosco'>
    <table id='bosco'>
      <thead><tr class='back_blue'><th width='120px'>Regione</th> <th width='50px'>Codice</th> <th width='150px'>Descrizione</th> <th  width='150px'colspan=2>Azioni</th></tr></thead>
      <tbody>
<?php
	$ids = getDiz_regioni();          //diz_regioni.codice, diz_regioni.descriz
	$codici = getdescrizioneBoschi(); //diz_regioni.descriz, propriet.codice, propriet.descrizion
	foreach( $codici as $codice ){?>
		<form action="#" method='post'>
		<tr><td><select name='regione'>
			<option selected='selected' value='-2' >...</option>
			<?foreach ($ids as $idd){
				$selected1 =($idd->descriz == $codice->descriz)? 'selected' : ''; 
				echo "<option value='$idd->codice' $selected1> $idd->descriz ($idd->codice)</option>\n";
			}?>
		</select></td>

		<td><input type='text' name='codice' value='<?php echo $codice->codice?>' ></td>
		<td><input type='text' name='descrizion' id='descrizion' value='<?php echo $codice->descrizion?>' ></td>
		<td><input type="submit" name="modify" id="modify"  class='actions modifica' title='<?echo $codice->descrizion?>' value='Salva'></td>
		<td><input type="submit" name="delete"  class='actions cancella' title='<?echo $codice->descrizion?>' value='Elimina'>
		</td></tr>
		</form>
<?
	}
?>
	<form  name='bosco_form' action="#" method="post">   <!-- FORM x gestire i campi a compilazione dell'utente (regione, codice, descrizIONE) -->
		<tr><td><select id='bosco_select' name='regione1' onChange='javascript:bosco_regione();'> 
		<?php	echo "<option selected='selected' value='-1' >bosco...</option>\n";
			foreach( $ids as $id ) { 
				$selected = ( !isset($_POST['insert']) and isset($_POST['regione1']) and $_POST['regione1'] == $id->codice )? 'selected' : ' ' ;
				echo "<option value='$id->codice' $selected> $id->descriz ($id->codice)</option>\n";}
			$id = ( isset($_POST['regione1']) ) ? $_POST['regione1'] : '-1' ;?>
		  </select></td>
		  <td><input TYPE="text" NAME="codice1" VALUE="<?if ( !isset($_POST['insert']) and isset($_POST['regione1'])): echo $id; endif;?>"></td>
		  <td><input TYPE="text" NAME="descrizion1" VALUE=""></td>
		  <td colspan='2' style='text-align:center'><input type="submit" name="insert" value="Inserisci"></td>
	 </form>
	 </tr>
      </tbody>
    </table>
    </div>
    <?php echo $this->message; ?>
</div>
