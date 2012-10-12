<?php 
function apri_html($text) {
?>
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo "$text"?></title>
  </head>
<?php
}
?>


<?php
function connessione_db(){
  $dbname="dumpSboarina";
  $conn=pg_Connect( "host=localhost user=postgres password=postgres dbname=$dbname" ) or die("Impossibile collegarsi al server");
  if(!$conn){
    die("Impossibile connettersi al database $dbname");
    }
return ($conn);
}
?>


<?php
function esci ($pagina) {
?>
  <br>
  <br>
  <div align=center>
    <a href="<?php echo "$pagina"?>">
      <img src='files/esci.bmp' border='0' width='38' height='39'></img>
    </a> 
    Menù principale
  </div>
<?php
}
?>

<?php
function pag_precedente ($indietro) {
?>
  <br>
  <br>
  <div align=center>
    <a href=<?php echo "$indietro"?>>
      <img src='files/esci.bmp' border='0' width='38' height='39'></img>
    </a> 
   Indietro
  </div>
<?php
}
?>

<?php
function logo_progbosco () {
?>
  <basefont size="3" color=#000000 face="Arial,Verdana">
    <table align=center >
      <tr>
	<img src=files/progbosco.bmp border=0 usemap=#mymap align="right">
      </tr>
      <br>
    </table>
<?php
}
?>