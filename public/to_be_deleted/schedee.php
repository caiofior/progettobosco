<html><head>
<title>schede_e</title>
<body bgcolor=teal  text=black vlink=#0040cc link=#0080ff>
<basefont size="3" color=#000000 face="Arial,Verdana">
<table align=center ><tr><img src=progbosco.bmp border=0 usemap=#mymap></tr>
<br>
</table>
<b><font size=+2>Scheda E per la descrizione della VIABILITA' FORESTALE E RURALE</font></b>
<br>
<br>
<br>
<table width=100% height=20% border=1>
<tr><th colspan=24></th><th colspan=12>INTERVENTI</th><th colspan=1></th></tr>
<tr><th><font size=+1>Bosco</font></th><th><font size=+1>Rilevatore</font></th>
<th><font size=+1>Data</font></th><th><font size=+1>Lunghezza</font></th>
<th><font size=+1>Percorso</font></th>
<th><font size=+1>Nome percorso</font></th>
<th><font size=+1>Punto di partenza (a valle)</font></th>
<th><font size=+1>Punto di arrivo (a monte)</font></th>
<th><font size=+1>CLASSIFICAZIONE AMMINISTRATIVA</font></th>
<th><font size=+1>CLASSIFICAZIONE PROPOSTA</font></th>
<th><font size=+1>CLASSIFICAZIONE TECNICA ATTUALE</font></th>
<th><font size=+1>CLASSIFICAZIONE TECNICA PROPOSTA</font></th>
<th><font size=+1>LARGHEZZA MINIMA m </font></th>
<th><font size=+1>LARGHEZZA PREVALENTE m </font></th>
<th><font size=+1>RAGGIO MINIMO CURVE</font></th>
<th><font size=+1>FONDO</font></th>
<th><font size=+1>PENDENZA MEDIA %</font></th>
<th><font size=+1>PENDENZA MASSIMA %</font></th>
<th><font size=+1>CONTROPENDENZA %</font></th>
<th><font size=+1>PIAZZOLE DI SCAMBIO</font></th>
<th><font size=+1>ACCESSO</font></th>
<th><font size=+1>TRASITABILITA'</font></th>
<th><font size=+1>MANUTENZIONE E MIGLIORAMENTI PREVISTI</font></th>
<th><font size=+1>PRIORITA'</font></th>
<th><font size=+1>Consolidamento scarpate laterali</font></th>
<th><font size=+1>Manutenzione miglioramento attraversamento corsi d'acqua</font></th>
<th><font size=+1>tombini</font></th>
<th><font size=+1>cunette trasversali</font></th>
<th><font size=+1>cunette laterali</font></th>
<th><font size=+1>ripuliture A.I.B.</font></th>
<th><font size=+1>Creazione/miglioramento piazzole di scambio</font></th>
<th><font size=+1>Creazione/miglioramento imposti</font></th>
<th><font size=+1>Opere di regolamentaz. accesso</font></th>
<th><font size=+1>Manutenzione ripristino manufatti storici</font></th>
<th><font size=+1>Altro</font></th>
<th><font size=+1>Specifica</font></th>
<th><font size=+1>Note</font></th></tr>
<?php
  $codice=$_GET[codice];
  $strada=$_GET[strada];
  $conn=pg_Connect( "host=localhost user=geo dbname=bosco2" );
  $rubrica=pg_Exec($conn,"SELECT schede_e.nome_strada, schede_e.strada,schede_e.da_valle, schede_e.a_monte, schede_e.lung_gis, schede_e.data, schede_e.codiope, schede_e.scarpate, schede_e.corsi_acqua, schede_e.tombini, schede_e.can_tras, schede_e.can_lat, schede_e.aib, schede_e.piazzole, schede_e.imposti, schede_e.reg_accesso, schede_e.manufatti, schede_e.altro, schede_e.specifica, schede_e.note, schede_e.larg_min, schede_e.larg_prev, schede_e.raggio, schede_e.fondo, schede_e.pend_media, schede_e.pend_max, schede_e.contropend, acc_via.descriz AS acc_via_descriz, clas_pro.descriz AS clas_pro_descriz, clas_via.descriz AS clas_via_descriz, fondo.descriz AS fondo_descriz, manutenz.descriz AS manutenz_descriz, propriet.descrizion AS propriet_descrizion, qual_pro.descriz AS qual_pro_descriz, qual_via.descriz AS qual_via_descriz, transit.descrizion AS transit_descrizion, urgenza.descriz AS urgenza_descriz
FROM propriet RIGHT JOIN (((((((((clas_pro RIGHT JOIN schede_e ON clas_pro.codice = schede_e.class_prop) LEFT JOIN clas_via ON schede_e.class_amm = clas_via.codice) LEFT JOIN fondo ON schede_e.fondo = fondo.codice) LEFT JOIN manutenz ON schede_e.manutenzione = manutenz.codice) LEFT JOIN qual_pro ON schede_e.qual_proP = qual_pro.codice) LEFT JOIN qual_via ON schede_e.QUAL_ATT = qual_via.codice) LEFT JOIN transit ON schede_e.transitabi = transit.codice) LEFT JOIN urgenza ON schede_e.urgenza = urgenza.codice) LEFT JOIN acc_via ON schede_e.accesso = acc_via.codice) ON propriet.codice = schede_e.proprieta WHERE schede_e.proprieta='$codice';");
  $riga = 1;
  while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
    echo "<tr><td><font size=-1>$elenco->propriet_descrizion</font></td>\n";
    echo "<td><font size=-1>$elenco->codiope</font></td>\n";
    echo "<td><font size=-1>$elenco->data</font></td>\n";
    echo "<td><font size=-1>$elenco->lung_gis</font></td>\n";
    echo "<td><font size=-1>$elenco->strada</font></td>\n";
    echo "<td><font size=-1>$elenco->nome_strada</font></td>\n";
    echo "<td><font size=-1>$elenco->da_valle</font></td>\n";
    echo "<td><font size=-1>$elenco->a_monte</font></td>\n";
    echo "<td><font size=-1>$elenco->clas_via_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->clas_pro_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->qual_via_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->qual_pro_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->larg_min</font></td>\n";
    echo "<td><font size=-1>$elenco->larg_prev</font></td>\n";
    echo "<td><font size=-1>$elenco->raggio</font></td>\n";
    echo "<td><font size=-1>$elenco->fondo_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->pend_media</font></td>\n";
    echo "<td><font size=-1>$elenco->pend_max</font></td>\n";
    echo "<td><font size=-1>$elenco->contropend</font></td>\n";
    echo "<td><font size=-1>$elenco->piazzole_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->acc_via_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->transit_descrizion</font></td>\n";
    echo "<td><font size=-1>$elenco->manutenz_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->urgenza_descriz</font></td>\n";
    echo "<td><font size=-1>$elenco->scarpate</font></td>\n";
    echo "<td><font size=-1>$elenco->corsi_acqua</font></td>\n";
    echo "<td><font size=-1>$elenco->tombini</font></td>\n";
    echo "<td><font size=-1>$elenco->can_tras</font></td>\n";
    echo "<td><font size=-1>$elenco->can_lat</font></td>\n";
    echo "<td><font size=-1>$elenco->aib</font></td>\n";
    echo "<td><font size=-1>$elenco->piazzole</font></td>\n";
    echo "<td><font size=-1>$elenco->imposti</font></td>\n";
    echo "<td><font size=-1>$elenco->reg_accesso</font></td>\n";
    echo "<td><font size=-1>$elenco->manufatti</font></td>\n";
    echo "<td><font size=-1>$elenco->altro</font></td>\n";
    echo "<td><font size=-1>$elenco->specifica</font></td>\n";
    echo "<td><font size=-1>$elenco->note</font></td></tr>\n";

    $riga ++;
  }
 ?>
</table>
<br>
<br>
<br>
<div align=center>
<a href="viabilita.php">
<img src='esci.bmp' border='0' width='38' height='39'></img></a> Indietro
</div>


</body>
</html>


