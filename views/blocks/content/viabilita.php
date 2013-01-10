<div id='home' class='descrp'>
      <div class='b_title'>Descrizioni Viabilità</div>
<form name="viabilita_form" action="?page=viabilita" method="post">
      <table>
      <?php
	  echo "<tr><td>Bosco</td>\n";
	  echo "<td class='td_320'><select name='codice' onChange='javascript:viabilita_form.submit();'>\n";
	  echo "<option selected='selected'>bosco...</option>";
	      $boschi = getCodiciBoschi();
	      foreach ($boschi as $bosco){
		      $selected = ( isset($_POST['codice']) and $_POST['codice'] == $bosco->codice )? 'selected' : ' ' ;
		      echo "<option value=$bosco->codice $selected> $bosco->descrizion</option>\n";
		      }
	      echo "</select>\n";
	  echo "</td></tr>\n";
	  $codice = ( isset($_POST['codice'])) ? $_POST['codice']: 'null';

	  echo "<tr><td>Strada</td>\n";
	  $disabled = ( !isset($_POST['codice']) ) ? 'disabled' : '' ;
	  echo "<td><select name='strada' onChange='javascript:viabilita_form.submit();' $disabled>\n";
	  echo "<option selected='selected'>strada...</option>";
	      $strade = getCodiciStrade($codice);
		      foreach ($strade as $strada){
		      $selected = ( isset($_POST['strada']) and $_POST['strada'] == $strada->strada )? 'selected' : ' ' ;
		      echo "<option value=$strada->strada $selected>$strada->strada $strada->nome_strada</option>\n";
		      }
	      echo "</select>\n";
	  echo "</td></tr>\n";
	  $strada = ( isset($_POST['strada'])) ? $_POST['strada']: 'null';
      ?>

	  <tr><td colspan="2"><a id='viab_button' href='?scheda=viab&codice=<?php echo $codice?>&strada=<?php echo $strada?>'>Schede E</a></td></tr>
	</table>

</form>

</div>
