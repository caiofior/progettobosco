<?php
$scheda = ( isset($_GET['scheda']) ) ? $scheda = $_GET['scheda'] : 'null';


If ($scheda == 'arbo_arbu'){
 	echo "<table><thead>";
 	echo "<tr><th>codice</th><th colspan=3>nome</th><th>form_b</th><th>codice</th> <th>cod_ifer</th> <th>cod_ifni</th> <th>cod_cartfo</th> <th>cod_cens</th> <th>priorita</th></tr> ";
//       </thead>
// 
//       <tbody>
// 		      echo "<option  selected='selected'>particella...</option>" ;
// 	$alberi = getDizArbo;
// 	foreach ($alberi as $albero) {
// 		echo "<option value='".$particella->cod_part."'". $selected.">".$particella->cod_part."</option>\n" ;
// 		}
	echo "</thead></table>";
}

/*
If ($scheda == 'erbacee'){
}
If ($scheda == 'tipi_for'){
}
If ($scheda == 'rilev'){
}
If ($scheda == 'reg'){
}
If ($scheda == 'prov'){
}
If ($scheda == 'com_mont'){
}
If ($scheda == 'comuni'){
}*/

?>