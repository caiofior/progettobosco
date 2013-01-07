<html><head>
<title>Schede A Schede B1 Schede B2 Schede B3 </title>
<body bgcolor=teal text=white vlink=#0040cc link=#0080ff>
<BASEFONT size="4" color="#00FF66" face="Arial,Verdana">
<table width=100% height=100%><tr>
<td width=90% valign=middle>

<?php
$scheda=$_GET[scheda];
	if($scheda == "Schede A"){?>
<table width=100% height=75% border=1>
<tr><th colspan=19><font size=+3>Schede A per descrivere i fattori ambientali e di gestione</font></th></tr>
<?php 
$codice=$_GET[codice];
$cod_part=$_GET[cod_part];
$conn=pg_Connect( "host=localhost user=geo dbname=bosco2" );
$rubrica=pg_Exec($conn,"select propriet.descrizion,RiLEVATO.descriz AS rilevato_descriz,SCHEDE_A.datasch,SCHEDE_A.sup_tot,
SCHEDE_A.cod_part,comuni.descriz as comuni_descriz,SCHEDE_A.toponimo,SCHEDE_A.ap,SCHEDE_A.pp,SCHEDE_A.delimitata,posfisio.descriz AS posfisio_descriz,
espo.descriz AS espo_descriz,SCHEDE_A.a2,SCHEDE_A.a3,SCHEDE_A.a4,SCHEDE_A.a6,SCHEDE_A.a7,SCHEDE_A.a8,SCHEDE_A.r2,SCHEDE_A.r3,
SCHEDE_A.r4,SCHEDE_A.r5,SCHEDE_A.r6,SCHEDE_A.r7,SCHEDE_A.f2,SCHEDE_A.f3,SCHEDE_A.f4,SCHEDE_A.f5,SCHEDE_A.f6,
SCHEDE_A.f7,SCHEDE_A.f8,SCHEDE_A.f10,SCHEDE_A.f11,SCHEDE_A.f12,SCHEDE_A.v3,SCHEDE_A.v1,ostacoli.descriz AS ostacoli_descriz,SCHEDE_A.c1,
SCHEDE_A.c2,SCHEDE_A.c3,SCHEDE_A.c4,SCHEDE_A.c5,SCHEDE_A.c6,SCHEDE_A.p1,SCHEDE_A.p2,specie_p.descriz AS specie_p_descriz,SCHEDE_A.p9,
SCHEDE_A.p3,SCHEDE_A.p4,SCHEDE_A.p5,SCHEDE_A.p6,SCHEDE_A.p8,SCHEDE_A.i1,SCHEDE_A.i2,SCHEDE_A.i3,SCHEDE_A.i4,
SCHEDE_A.i5,SCHEDE_A.i6,SCHEDE_A.i7,SCHEDE_A.i8,SCHEDE_A.i21,SCHEDE_A.i22,SCHEDE_A.m1,SCHEDE_A.m2,SCHEDE_A.m3,
SCHEDE_A.m4,SCHEDE_A.m20,SCHEDE_A.m5,SCHEDE_A.m6,SCHEDE_A.m7,SCHEDE_A.m8,SCHEDE_A.m9,SCHEDE_A.m10,SCHEDE_A.m12,
SCHEDE_A.m13,SCHEDE_A.m15,SCHEDE_A.m14,SCHEDE_A.m16,SCHEDE_A.m17,SCHEDE_A.m18,SCHEDE_A.m19
FROm ((((((SCHEDE_A LEFT JOiN RiLEVATO ON RiLEVATO.codice = SCHEDE_A.codiope) LEFT JOiN comuni ON comuni.codice = SCHEDE_A.comune)LEFT JOiN posfisio ON posfisio.codice=SCHEDE_A.pf1)LEFT JOiN espo ON espo.codice = SCHEDE_A.e1)LEFT JOiN ostacoli ON ostacoli.codice = SCHEDE_A.o) LEFT JOiN specie_p ON specie_p.codice = SCHEDE_A.p7)iNNER JOiN propriet ON SCHEDE_A.proprieta = propriet.codice WHERE (SCHEDE_A.proprieta='$codice' AND SCHEDE_A.cod_part='$cod_part');");
$riga = 1;
$elenco = @pg_fetch_object ($rubrica ,$riga) ?>  
<tr><th><font>Bosco</font></th>
<th><font>Rilevatore</font></th>
<th><font>Data</font></th>
<th><font>Superficie(ha)</font></th>
<th><font>particella/Sottoparticella</font></th>
<th><font>Comune</font></th>
<th><font>Nome del luogo</font></th>
<th><font>Altitudine prevalente m</font></th>
<th><font>pendenza prevalente %</font></th>
<th><font>Delimitazione sottoparticella</font></th>
<th><font>posizione fisiografica prevalente</font></th>
<th><font>Esposizione prevalente</font></th></tr>
<tr><td><font size=-1><? echo $elenco->descrizion ?></font></td>
<td><font size=-1><? echo $elenco->rilevato_descriz ?></font></td>
<td><font size=-1><? echo $elenco->datasch ?></font></td>
<td><font size=-1><? echo $elenco->sup_tot ?></font></td>
<td><font size=-1><? echo $elenco->cod_part ?></font></td>
<td><font size=-1><? echo $elenco->comuni_descriz ?></font></td>
<td><font size=-1><? echo $elenco->toponimo ?></font></td>
<td><font size=-1><? echo $elenco->Ap ?></font></td>
<td><font size=-1><? echo $elenco->pp ?></font></td>
<td><font size=-1><? echo $elenco->delimitata ?></font></td>
<td><font size=-1><? echo $elenco->posfisio_descriz ?></font></td>
<td><font size=-1><? echo $elenco->espo_descriz ?></font></td></tr>
<tr></tr>
<tr><th colspan=6><font size=+1>Dissesto</font></th></tr>
<tr><th><font>erosione superficiale o incanalata </font></th>
<th><font>erosione catastrofica o calanchiva </font></th>
<th><font>frane superficiali</font></th>
<th><font>rotolamento massi</font></th>
<th><font>altri fattori di dissesto</font></th>
<th><font>specifica altri fattori</font></th></tr>
<tr>
<? if($elenco->a2==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->a2==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->a2==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->a2==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->a2==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->a3==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->a3==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->a3==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->a3==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->a3==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->a4==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->a4==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->a4==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->a4==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->a4==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->a6==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->a6==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->a6==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->a6==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->a6==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->a7==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->a7==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->a7==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->a7==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->a7==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";?>
<td><font size=-1><? echo $elenco->a8 ?></font></td></tr>
<tr></tr>    
<tr><th colspan=6><font size=+1>Limiti allo sviluppo delle radici</font></th><tr>
<tr><th><font>superficialità terreno</font></th>
<th><font>rocciosità affiorante</font></th>
<th><font>pietrosità</font></th>
<th><font>ristagni d'acqua</font></th>
<th><font>altri fattori limitanti</font></th>
<th><font>specifica altri fattori</font></th></tr>
<tr>
<?     if($elenco->r2==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->r2==1)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->r2==2)echo "<td><font size=-1>meno di 2/3</font></td>\n";
elseif($elenco->r2==3)echo "<td><font size=-1>pi di 2/3 </font></td>\n";
    if($elenco->r3==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->r3==1)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->r3==2)echo "<td><font size=-1>meno di 2/3</font></td>\n";
elseif($elenco->r3==3)echo "<td><font size=-1>pi di 2/3 </font></td>\n";
    if($elenco->r4==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->r4==1)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->r4==2)echo "<td><font size=-1>meno di 2/3</font></td>\n";
elseif($elenco->r4==3)echo "<td><font size=-1>pi di 2/3 </font></td>\n";
    if($elenco->r5==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->r5==1)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->r5==2)echo "<td><font size=-1>meno di 2/3</font></td>\n";
elseif($elenco->r5==3)echo "<td><font size=-1>pi di 2/3 </font></td>\n";
    if($elenco->r6==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->r6==1)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->r6==2)echo "<td><font size=-1>meno di 2/3</font></td>\n";
elseif($elenco->r6==3)echo "<td><font size=-1>pi di 2/3 </font></td>\n";?>
<td><font size=-1><? echo $elenco->r7 ?></font></td></tr>
<tr></tr>  
<tr><th colspan=10><font size=+1>Fattori di alterazione fitosanitaria</font></th><tr>
<tr><th><font>bestiame</font></th>
<th><font>selvatici</font></th>
<th><font>fitopatogeni e parassiti</font></th>
<th><font>agenti meteorici</font></th>
<th><font>movimenti di neve</font></th>
<th><font>incendio</font></th>
<th><font>utilizzazioni o esbosco</font></th>
<th><font>attività turistico-ricreative</font></th>
<th><font>altre cause</font></th>
<th><font>specifica altre cause</font></th></tr>
<tr>
<?     if($elenco->f2==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f2==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f2==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f2==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f2==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f3==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f3==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f3==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f3==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f3==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f4==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f4==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f4==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f4==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f4==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f5==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f5==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f5==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f5==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f5==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f6==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f6==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f6==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f6==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f6==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f7==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f7==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f7==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f7==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f7==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f8==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f8==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f8==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f8==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f8==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f10==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f10==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f10==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f10==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f10==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";
    if($elenco->f11==0)echo "<td><font size=-1>assenti</font></td>\n";
elseif($elenco->f11==1)echo "<td><font size=-1>pericolo dissesto/alterazione</font></td>\n";
elseif($elenco->f11==2)echo "<td><font size=-1>meno del 5%</font></td>\n";
elseif($elenco->f11==3)echo "<td><font size=-1>meno di 1/3</font></td>\n";
elseif($elenco->f11==4)echo "<td><font size=-1>pi di 1/3 </font></td>\n";?>
<td><font size=-1><?echo $elenco->F12 ?></font></td></tr>
<tr></tr>
<tr><th colspan=2><font size=+1>Accessibilità</font></th></tr>
<tr><th><font>insufficiente sul...(%)</font></th>
<th><font>buona sul...(%)</font></th></tr>
<tr><td><font size=-1><?echo $elenco->V3 ?></font></td>
<td><font size=-1><?echo $elenco->V1 ?></font></td></tr>
<tr></tr>
<tr><th><font size=+1>Ostacoli agli interventi</font></th></tr>
<tr><td><font size=-1><? echo $elenco->ostacoli_descriz ?></font></td></tr>
<tr></tr>
<tr><th colspan=6><font size=+1>Condizionamenti eliminabili</font></th></tr>
<tr><th><font>nessuno</font></th>
<th><font>eccesso di pascolo</font></th>
<th><font>eccesso di selvatici</font></th>
<th><font>contestazioni di proprietà</font></th>
<th><font>altre cause</font></th>
<th><font>Specifica</font></th></tr>
<tr>
<? 
    if($elenco->c1==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->c1==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->c2==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->c2==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->c3==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->c3==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->c4==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->c4==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->c5==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->c5==1)echo "<td><font size=-1>Si</font></td>\n";?>
<td><font size=-1><?echo $elenco->c6 ?></font></td></tr>
<tr></tr>
<tr><th colspan=9><font size=+1>Fatti particolari</font></th></tr>
<tr><th><font>nessuno</font></th>
<th><font>pascolo in bosco</font></th>
<th><font>Specie pascolante</font></th>
<th><font>Specifica specie pascolante</font></th>
<th><font>emergenze storico-naturalistiche</font></th>
<th><font>sorgenti,fonti</font></th>
<th><font>usi civici</font></th>
<th><font>altri fatti</font></th>
<th><font>Specifica</font></th></tr>
<tr>
<?     if($elenco->p1==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->p1==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->p2==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->p2==1)echo "<td><font size=-1>Si</font></td>\n";?>
<td><font size=-1><?echo $elenco->specie_p_descriz ?></font></td>
<td><font size=-1><?echo $elenco->p9 ?></font></td>
<?     if($elenco->p3==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->p3==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->p4==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->p4==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->p5==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->p5==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->p6==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->p6==1)echo "<td><font size=-1>Si</font></td>\n";?>
<td><font size=-1><?echo $elenco->p8 ?></font></td></tr>
<tr></tr>
<tr><th colspan=8><font size=+1>Improduttivi inclusi non cartografati</font></th></tr>
<tr><th><font>superficie (ha)</font></th>
<th><font>superficie (%)</font></th>
<th><font>rocce</font></th>
<th><fon>acque</font></th>
<th><font>strade</font></th>
<th><font>viali tagliafuoco</font></th>
<th><font>altri fattori</font></th>
<th><font>Specifica</font></th></tr>
<tr>
<td><font size=-1><?echo $elenco->i1 ?></font></td>
<td><font size=-1><?echo $elenco->i2 ?></font></td>
<?  if($elenco->i3==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->i3==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->i4==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->i4==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->i5==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->i5==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->i6==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->i6==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->i7==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->i7==1)echo "<td><font size=-1>Si</font></td>\n";?>
<td><font size=-1><?echo $elenco->i8 ?></font></td></tr>
<tr></tr>
<tr><th colspan=4><font size=+1>Produttivi non boscati inclusi non cartografati</font></th></tr>
<tr><th colspan=2><font>superficie (ha)</font></th>
<th colspan=2><font>superficie (%)</font></th></tr>
<tr>
<td><font size=-1><?echo $elenco->i21 ?></font></td>
<td><font size=-1><?echo $elenco->i22 ?></font></td></tr>
<tr></tr>    
<tr><th colspan=19><font size=+1 >Opere e manufatti</font></th></tr>
<tr><th><font >strade camionabili</font></th>
<th><font >piste camionabili</font></th>
<th><font >strade trattorabili</font></th>
<th><font >piste forestali</font></th>
<th><font >piazzali o buche di carico</font></th>
<th><font >edifici</font></th>
<th><font >sistemazioni</font></th>
<th><font >gradonamenti</font></th>
<th><font >muri recinti</font></th>
<th><font >paravalanghe</font></th>
<th><font >elettrodotti</font></th>
<th><font >tracciati teleferiche</font></th>
<th><font >condotte idriche</font></th>
<th><font >cave</font></th>
<th><font >aree sosta e parcheggi</font></th>
<th><font >sentieri guidati</font></th>
<th><font >impianti sciistici</font></th>
<th><font >altre cose</font></th>
<th><font >Specifica</font></th></tr>
<tr>
<? 
    if($elenco->m1==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m1==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m2==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m2==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m3==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m3==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m4==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m4==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m20==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m20==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m5==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m5==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m6==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m6==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m7==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m7==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m8==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m8==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m9==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m9==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m10==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m10==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m12==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m12==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m13==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m13==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m15==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m15==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m14==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m14==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m16==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m16==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m17==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m17==1)echo "<td><font size=-1>Si</font></td>\n";
    if($elenco->m18==0)echo "<td><font size=-1>No</font></td>\n";
elseif($elenco->m18==1)echo "<td><font size=-1>Si</font></td>\n";?>
<td><font size=-1><?echo $elenco->m19 ?></font></td></tr>
</table>
<br>
<table border=1>
<tr><th colspan=2><font size=+1>Note alle singole voci</font><th></tr>
<tr><th>parametro </th><th>Nota</th>
<?php
$rubrica=pg_Exec($conn,"select leg_note.intesta,note_A.nota FROm note_A LEFT JOiN leg_note ON leg_note.nomecampo = note_A.cod_nota WHERE note_A.proprieta='$codice' AND note_A.cod_part='$cod_part';");
$riga = 1;
while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
echo "<tr><td><font size=-1>$elenco->intesta</font></td>\n";
echo "<td><font size =-1>$elenco->nota</font></td></tr>\n";
$riga++;
}
?>
</table>
<br>
<table border=1>
<tr><th colspan=6><font size=+1>Dati catastali</font><th></tr>
<tr><th>Foglio </th><th>partic. cat.</th><th>Sup. totale</th><th>Sup. boscata</th><th>% afferente</th><th>note</th></tr>
<?php
$rubrica=pg_Exec($conn,"select foglio,particella,sup_tot,sup_bosc,porz_perc,note FROm CATASTO WHERE proprieta='$codice' AND cod_part='$cod_part';");
$riga = 1;
while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
echo "<tr><td><font size=-1>$elenco->foglio</font></td>\n";
echo "<td><font size=-1>$elenco->particella</font></td>\n";
echo "<td><font size=-1>$elenco->sup_tot</font></td>\n";
echo "<td><font size=-1>$elenco->sup_bosc</font></td>\n";
echo "<td><font size=-1>$elenco->porz_perc</font></td>\n";
echo "<td><font size =-1>$elenco->note</font></td></tr>\n";
$riga++;
}
?>
</table><?}

elseif($scheda == "Schede B1"){?>
	<h1 align=center><font size=+3>Scheda B per descrivere una formazione arborea</font></h1>
	<?php 
	$codice=$_GET[codice];
	$cod_part=$_GET[cod_part];
	$conn=pg_Connect( "host=localhost user=geo dbname=bosco2" );
	$rubrica=pg_Exec($conn,"select pROpRiET.descrizion,SCHED_B1.cod_part,struttu.descriz AS struttu_descriz,matrici.descriz AS matrici_descriz,origine.descriz AS origine_descriz 
FROm (((SCHED_B1 LEFT JOiN struttu ON struttu.codice =SCHED_B1.s)LEFT JOiN matrici ON matrici.codice = SCHED_B1.m)LEFT JOiN origine ON origine.codice = SCHED_B1.o) iNNER JOiN pROpRiET ON pROpRiET.codice = SCHED_B1.proprieta WHERE SCHED_B1.proprieta='$codice' AND SCHED_B1.cod_part='$cod_part';");
	$riga=1;
 	$elenco = @pg_fetch_object ($rubrica ,$riga)
	?>
	<table width=100% height=70%>
	<tr>
	<TD COLSpAN=3>Bosco <iNpUT size="40" TYpE="TEXT" NAmE=codice VALUE="<?echo $elenco->descrizion?>"></TD>
	<TD COLSpAN=3>particella/Sottoparticella <iNpUT TYpE="TEXT" size="5" NAmE=codpart VALUE="<?echo $elenco->cod_part?>"></TD>
	<TD COLSpAN=2></TD>
	</tr>
	<tr>
	<TD COLSpAN=3>Struttura e sviluppo <iNpUT size="40" TYpE="TEXT" NAmE=struttura VALUE="<?echo $elenco->struttu_descriz?>"></TD>
	<TD COLSpAN=1>matricinatura<iNpUT TYpE="TEXT" NAmE=matrici VALUE="<?echo $elenco->matrici_descriz?>"></TD></tr>
	<tr><TD colspan=3>Origine del bosco<iNpUT size="40" TYpE="TEXT" NAmE=origine VALUE="<?echo $elenco->origine_descriz?>"></TD>
	<TD COLSpAN=1></TD>
	</tr>	
	<tr><td COLSpAN=2><u>Composizione strato arboreo</u></td></tr>
	<tr><td>Specie</td><td>Copertura</td></tr>
	<?
	$rubrica=pg_Exec($conn,"select DiZ_ARBO.nome_itali,pER_ARBO.descriz FROm (ARBOREE LEFT JOiN pER_ARBO ON pER_ARBO.codice = ARBOREE.COD_COpER)LEFT JOiN DiZ_ARBO ON DiZ_ARBO.cod_coltu =ARBOREE.cod_coltu WHERE ARBOREE.proprieta='$codice' AND ARBOREE.cod_part='$cod_part';");
	$riga=1;
	while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {?>
	<tr><td><font size=-1><?echo $elenco->nome_itali?></font></td>
	<td><font size=-1><? echo $elenco->descriz?></font></td></tr><?
	$riga ++;
	}
	$rubrica=pg_Exec($conn,"select SCHED_B1.c1,vigoria.descriz AS vigoria_descriz,pRES_ASS.valore,SCHED_B1.ce,densita.descriz AS densita_descriz,strati.descriz AS strati_descriz
FROm (((SCHED_B1 LEFT JOiN vigoria ON vigoria.codice =SCHED_B1.vig)LEFT JOiN pRES_ASS ON pRES_ASS.codice = SCHED_B1.v)LEFT JOiN densita ON densita.codice = SCHED_B1.d) LEFT JOiN strati ON strati.codice = SCHED_B1.sr WHERE SCHED_B1.proprieta='$codice' AND SCHED_B1.cod_part='$cod_part';");
	$riga=1;
 	$elenco = @pg_fetch_object ($rubrica ,$riga)
	?>
	<tr>
	<TD COLSpAN=2>Età prevalente accertata <iNpUT size="5" TYpE="TEXT" NAmE=eta VALUE="<?echo $elenco->c1?>"></TD>
	<TD COLSpAN=1>Vigoria<iNpUT TYpE="TEXT" NAmE=vigoria VALUE="<?echo $elenco->vigoria_descriz?>"></TD>
	</tr>
	<tr>
	<TD COLSpAN=2>Vuoti-lacune<iNpUT size="10" TYpE="TEXT" NAmE=vuoti VALUE="<?echo $elenco->valore?>"></TD>
	<TD colspan=2>Grado di copertura<iNpUT size="5" TYpE="TEXT" NAmE=gradocop VALUE="<?echo $elenco->ce?>"></TD>
	<TD COLSpAN=1>Densità<iNpUT TYpE="TEXT" NAmE=densita VALUE="<?echo $elenco->densita_descriz?>"></TD>
	</tr>
	<tr>
	<TD colspan=2>Strato arbustivo: diffusione<iNpUT size="10" TYpE="TEXT" NAmE=sr VALUE="<?echo $elenco->strati_descriz?>"></TD></tr>
	<tr><td colspan=2><u>Specie significative strato arbustivo</u></td></tr>
	<?
	$rubrica=pg_Exec($conn,"SELECT ARBUSTi.cod_coltu,DiZ_ARBO.nome_itali FROm ARBUSTi iNNER JOiN DiZ_ARBO ON DiZ_ARBO.cod_coltu = ARBUSTi.cod_coltu WHERE ARBUSTi.proprieta='$codice' AND ARBUSTi.cod_part='$cod_part';");
	$riga=1;
	while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {?>
	<tr><td colspan=2><font size=-1><? echo $elenco->nome_itali?></font></td></tr><?
	$riga ++;
	}
	$rubrica=pg_Exec($conn,"select strati.descriz FROm SCHED_B1 LEFT JOiN strati ON strati.codice = SCHED_B1.se WHERE SCHED_B1.proprieta='$codice' AND SCHED_B1.cod_part='$cod_part';");
	$riga=1;
 	$elenco = @pg_fetch_object ($rubrica ,$riga)
	?>
	<tr>
	<TD colspan=2>Strato erbaceo: diffusione<iNpUT size="10" TYpE="TEXT" NAmE=se VALUE="<?echo $elenco->descriz?>"></TD></tr>
	<tr><td colspan=2><u>Specie significative strato erbaceo</u></td></tr>
	<?
	$rubrica=pg_Exec($conn,"select DiZ_ERBA.nome FROm ERBAceE LEFT JOiN DiZ_ERBA ON DiZ_ERBA.cod_coltu =ERBAceE.cod_coltu WHERE ERBAceE.proprieta='$codice' AND ERBAceE.cod_part='$cod_part';");
	$riga=1;
	while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
	echo "<tr><td><font size=-1>$elenco->nome</font></td></tr>\n";
	$riga ++;
	}
	$rubrica=pg_Exec($conn,"SELECT novell.descriz AS novell_descriz,car_nove.descriz AS car_nove_descriz,rinnov.descriz AS rinnov_descriz,DiZ_ARBO.nome_itali,prescriz.descriz AS prescriz_descriz,SCHED_B1.int3,funzione.descriz AS funzione_descriz,sistema.descriz AS sistema_descriz
 FROm ((((((SCHED_B1 iNNER JOiN prescriz ON prescriz.codice=SCHED_B1.int2)LEFT JOiN funzione ON funzione.codice=SCHED_B1.f)LEFT JOiN sistema ON sistema.codice=SCHED_B1.g)LEFT JOiN novell ON novell.codice=SCHED_B1.n1)LEFT JOiN car_nove ON car_nove.codice=SCHED_B1.n2)LEFT JOiN rinnov ON rinnov.codice=SCHED_B1.n3)LEFT JOiN DiZ_ARBO ON DiZ_ARBO.cod_coltu=SCHED_B1.spe_nov WHERE SCHED_B1.proprieta='$codice' AND SCHED_B1.cod_part='$cod_part';");
	$riga=1;
 	$elenco = @pg_fetch_object ($rubrica ,$riga)
	?>
	<tr>
	<TD >Novellame<iNpUT size="10" TYpE="TEXT" NAmE=novel VALUE="<?echo $elenco->novell_descriz?>"></TD>
	<TD ><iNpUT size="15" TYpE="TEXT" NAmE=novel1 VALUE="<?echo $elenco->car_nove_descriz?>"></TD>
	<TD >Rinnovazione<iNpUT size="10" TYpE="TEXT" NAmE=rinnov VALUE="<?echo $elenco->rinnov_descriz?>"></TD>
	<TD COLSpAN=3>Specie prevalente rinnovazione<iNpUT TYpE="TEXT" NAmE=srinnov VALUE="<?echo $elenco->nome_itali?>"></TD>
	</tr>
	<tr>
	<TD COLSpAN=2>interventi recenti<iNpUT TYpE="TEXT" NAmE=int VALUE="<?echo $elenco->prescriz_descriz?>"></TD>
	<TD COLSpAN=2>Specifiche<iNpUT TYpE="TEXT" NAmE=specifiche VALUE="<?echo $elenco->int3?>"></TD>
	</tr>
	<tr>
	<TD COLSpAN=2>Funzione<iNpUT size="40" TYpE="TEXT" NAmE=funzione VALUE="<?echo $elenco->funzione_descriz?>"></TD>
	<TD COLSpAN=3>Orientamento selvicolturale<iNpUT size="50" TYpE="TEXT" NAmE=ori VALUE="<?echo $elenco->sistema_descriz?>"></TD>
	</tr>
<?	$rubrica=pg_Exec($conn,"SELECT SCHED_B1.p2,prescriz.descriz FROm SCHED_B1 iNNER JOiN prescriz ON prescriz.codice=SCHED_B1.p2 WHERE SCHED_B1.proprieta='$codice' AND SCHED_B1.cod_part='$cod_part';");
	$riga=1;
 	$elenco = @pg_fetch_object ($rubrica ,$riga)
	?>
	<tr>
	<TD COLSpAN=2>ipotesi di intervento futuro<iNpUT size="20" TYpE="TEXT" NAmE=p2 VALUE="<?echo $elenco->descriz?>"></TD>
<?	$rubrica=pg_Exec($conn,"SELECT prescriz.descriz,urgenza.descriz AS urgenza_descriz,Si_No.valore,SCHED_B1.d1,SCHED_B1.d3,SCHED_B1.d5 FROm ((SCHED_B1 iNNER JOiN prescriz ON prescriz.codice=SCHED_B1.p3)LEFT JOiN urgenza ON urgenza.codice=SCHED_B1.g1)LEFT JOiN Si_No ON Si_No.codice=SCHED_B1.sub_viab WHERE SCHED_B1.proprieta='$codice' AND SCHED_B1.cod_part='$cod_part';");
	$riga=1;
 	$elenco = @pg_fetch_object ($rubrica ,$riga)
	?>
	<TD COLSpAN=3>ipotesi di intervento futuro (secondario)<iNpUT size="40" TYpE="TEXT" NAmE=p3 VALUE="<?echo $elenco->descriz?>"></TD>
	<TD>Specifiche<iNpUT size="30" TYpE="TEXT" NAmE=spec VALUE="<?echo $elenco->p4?>"></TD>
	</tr>
	<tr>
	<TD COLSpAN=2>priorità e condizionamenti<iNpUT size="20" TYpE="TEXT" NAmE=g1 VALUE="<?echo $elenco->urgenza_descriz?>"></TD>
	<TD COLSpAN=2>Subordinato alla viabilità<iNpUT size="5" TYpE="TEXT" NAmE=p3 VALUE="<?echo $elenco->valore?>"></TD>
	</tr>
	<tr>
	<TH COLSpAN=2>Dati di orientamento dendrometrico</TH>
	</tr>
	<tr>
	<TD COLSpAN=1>Diametro (cm)<iNpUT size="5" TYpE="TEXT" NAmE=d1 VALUE="<?echo $elenco->d1?>"></TD>
	<TD COLSpAN=1>Altezza (m)<iNpUT size="5" TYpE="TEXT" NAmE=d3 VALUE="<?echo $elenco->d3?>"></TD>
	<TD COLSpAN=1>n alberi/ha<iNpUT size="5" TYpE="TEXT" NAmE=d5 VALUE="<?echo $elenco->d5?>"></TD>
	</tr>
	
</tr>
</table>
<br>
<table border=0>
<tr><th colspan=2><u>Note alle singole voci</u><th></tr>
<tr><th>parametro </th><th>Nota</th>
<?php
$rubrica=pg_Exec($conn,"select leg_note.intesta,note_B.nota FROm note_B LEFT JOiN leg_note ON leg_note.nomecampo = note_B.cod_nota WHERE note_B.proprieta='$codice' AND note_B.cod_part='$cod_part';");
$riga = 1;
while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
echo "<tr><td><font size=-1>$elenco->intesta</font></td>\n";
echo "<td><font size =-1>$elenco->nota</font></td></tr>\n";
$riga++;
}
?>
</table>
<?
}
elseif($scheda == "Schede B2"){ 

}
elseif($scheda == "Schede B3"){ 

}
elseif($scheda == "Schede N"){ 

}
elseif($scheda == "Problemi Schede A"){?>
	<h1 align=center><font size=+5>problemi Scheda A</font></h1>
	<table width=100% border=1>
	<tr><th><font size=+2>Bosco</font></th><th><font size=+2>particella</font></th>
	<th><font size=+2>tabella</font></th><th><font size=+2>Nota</font></th></tr>
	<?php
  	$codice=$_GET[codice];
	$cod_part=$_GET[cod_part];
	$conn=pg_Connect( "host=localhost user=geo dbname=bosco2" );
	$rubrica=pg_Exec($conn,"SELECT pROBLEmi_A.tabella, pROBLEmi_A.cod_part, pROBLEmi_A.nota, pROpRiET.descrizion
FROm pROBLEmi_A LEFT JOiN pROpRiET ON pROBLEmi_A.proprieta=pROpRiET.codice WHERE pROBLEmi_A.proprieta='$codice'AND pROBLEmi_A.cod_part='$cod_part';");
  	$riga = 1;
  	while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
    	echo "<tr><td><font size=+1>$elenco->descrizion</font></td>\n";
    	echo "<td><font size=+1>$elenco->cod_part</font></td>\n";
    	echo "<td><font size=+1>$elenco->tabella</font></td>\n";
    	echo "<td><font size=+1>$elenco->nota</font></td></tr>\n";
    	$riga ++;
  	}
 	?>
	</table>
<? 
}
elseif($scheda == "Problemi Schede B1"){?>
	<h1 align=center><font size=+5>problemi Scheda B1</font></h1>
	<table width=100% border=1>
	<tr><th><font size=+2>proprieta'</font></th><th><font size=+2>cod_part</font></th><th><font size=+2>cod_fo</font></th>
	<th><font size=+2>tabella</font></th><th><font size=+2>Nota</font></th></tr>
	<?php
  	$codice=$_GET[codice];
	$cod_part=$_GET[cod_part];
	$conn=pg_Connect( "host=localhost user=geo dbname=bosco2" );
	$rubrica=pg_Exec($conn,"SELECT pROBLEmi_B1.cod_fo,pROBLEmi_B1.tabella, pROBLEmi_B1.cod_part, pROBLEmi_B1.nota, pROpRiET.descrizion
FROm pROBLEmi_B1 iNNER JOiN pROpRiET ON pROBLEmi_B1.proprieta=pROpRiET.codice WHERE pROBLEmi_B1.proprieta='$codice'AND pROBLEmi_B1.cod_part='$cod_part';");
  	$riga = 1;
  	while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
    	echo "<tr><td><font size=+1>$elenco->descrizion</font></td>\n";
    	echo "<td><font size=+1>$elenco->cod_part</font></td>\n";
    	echo "<td><font size=+1>$elenco->cod_fo</font></td>\n";
    	echo "<td><font size=+1>$elenco->tabella</font></td>\n";
    	echo "<td><font size=+1>$elenco->nota</font></td></tr>\n";
    	$riga ++;
  	}
 	?>
	</table>
<? 
}
elseif($scheda == "Problemi Schede B2"){?>
	<h1 align=center><font size=+5>problemi Scheda B2</font></h1>
	<table width=100% border=1>
	<tr><th><font size=+2>proprieta'</font></th><th><font size=+2>cod_part</font></th><th><font size=+2>cod_fo</font></th>
	<th><font size=+2>tabella</font></th><th><font size=+2>Nota</font></th></tr>
	<?php
  	$codice=$_GET[codice];
	$cod_part=$_GET[cod_part];
	$conn=pg_Connect( "host=localhost user=geo dbname=bosco2" );
	$rubrica=pg_Exec($conn,"SELECT pROBLEmi_B2.cod_fo,pROBLEmi_B2.tabella, pROBLEmi_B2.cod_part, pROBLEmi_B2.nota, pROpRiET.descrizion
FROm pROBLEmi_B2 iNNER JOiN pROpRiET ON pROBLEmi_B2.proprieta=pROpRiET.codice WHERE pROBLEmi_B2.proprieta='$codice'AND pROBLEmi_B2.cod_part='$cod_part';");
  	$riga = 1;
  	while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
    	echo "<tr><td><font size=+1>$elenco->descrizion</font></td>\n";
    	echo "<td><font size=+1>$elenco->cod_part</font></td>\n";
    	echo "<td><font size=+1>$elenco->cod_fo</font></td>\n";
    	echo "<td><font size=+1>$elenco->tabella</font></td>\n";
    	echo "<td><font size=+1>$elenco->nota</font></td></tr>\n";
    	$riga ++;
  	}
 	?>
	</table>
<? 
}
elseif($scheda == "Problemi Schede B3"){?>
	<h1 align=center><font size=+5>problemi Scheda B3</font></h1>
	<table width=100% border=1>
	<tr><th><font size=+2>proprieta'</font></th><th><font size=+2>cod_part</font></th><th><font size=+2>cod_fo</font></th>
	<th><font size=+2>tabella</font></th><th><font size=+2>Nota</font></th></tr>
	<?php
  	$codice=$_GET[codice];
	$cod_part=$_GET[cod_part];
	$conn=pg_Connect( "host=localhost user=geo dbname=bosco2" );
	$rubrica=pg_Exec($conn,"SELECT pROBLEmi_B3.cod_fo,pROBLEmi_B3.tabella, pROBLEmi_B3.cod_part, pROBLEmi_B3.nota, pROpRiET.descrizion
FROm pROBLEmi_B3 iNNER JOiN pROpRiET ON pROBLEmi_B3.proprieta=pROpRiET.codice WHERE pROBLEmi_B3.proprieta='$codice'AND pROBLEmi_B3.cod_part='$cod_part';");
  	$riga = 1;
  	while ($elenco = @pg_fetch_object ($rubrica ,$riga)) {
    	echo "<tr><td><font size=+1>$elenco->descrizion</font></td>\n";
    	echo "<td><font size=+1>$elenco->cod_part</font></td>\n";
    	echo "<td><font size=+1>$elenco->cod_fo</font></td>\n";
    	echo "<td><font size=+1>$elenco->tabella</font></td>\n";
    	echo "<td><font size=+1>$elenco->nota</font></td></tr>\n";
    	$riga ++;
  	}
 	?>
	</table>
<? 
}else{
echo "Nessuna scheda selezionata\n";
}
?>
<br>
<br>
<div align=center>
<a href="descrp.php">
<img src='esci.bmp' border='0' width='38' height='39'></img></a> indietro
</div>
</td></tr></table>
</body>
</html>