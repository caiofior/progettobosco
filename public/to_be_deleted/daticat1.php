<?php
if( isset($_GET['scheda']) and  $_GET['scheda'] == 'daticat1') {

?>
<b><font size=+2>Dati Catastali</font></b>
<br>
<br>
<br>

<table width=100% border=1>
<tr><th><font size=+1>Foglio</font></th><th><font size=+1>Particella catastale</font></th>
<th><font size=+1>Sup. totale afferente alla particella</font></th>
<th><font size=+1>Sup. boscata afferente alla particella</font></th>
<th><font size=+1>% afferente</font></th>
<th><font size=+1>Note</font></th>
<th><font size=+1>Bosco</font></th>
<th><font size=+1>Particella forestale</font></th></tr>
<?php
  $codice = $_GET['codice'];
 $rubrica = getInfoCatasto($codice) ;
  $riga = 1;
  while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
    echo "<tr><td><font>$elenco->foglio</font></td>\n";
    echo "<td><font>$elenco->particella</font></td>\n";
    echo "<td><font>$elenco->sup_tot</font></td>\n";
    echo "<td><font>$elenco->sup_bosc</font></td>\n";
    echo "<td><font>$elenco->porz_perc</font></td>\n";
    echo "<td><font>$elenco->note</font></td>\n";
    echo "<td><font>$elenco->descrizion</font></td>\n";
    echo "<td><font>$elenco->cod_part</font></td></tr>\n";

    $riga ++;
  }
echo "</table>";
}
 ?>




