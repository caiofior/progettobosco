			<!-- main -->
			<div id="main">	
					
				<div class="post">
			
					<h2>Benvenuto</h2>
					
                                        <p>Puoi aggiungere i dati di un bosco, modificarne uno
                                        già esistente o aggiornare i tuoi dati personali</p>
				        <ul class="index_menu">
                                            <?php if ($this->user->getData('is_admin')) :?>
                                            <li><a href='<?php echo $GLOBALS['BASE_URL'];?>user.php'>Amministra utenti</a></li>
                                            <?php endif; ?>
                                            <li><a class="bosco" href='<?php echo $GLOBALS['BASE_URL'];?>bosco.php'>Bosco</a></li>
                                        </ul>
				<!-- /post -->	
				</div>	
                            

                            <!--
<div id='home'>

  
  
  <a class='main_button' id='edp' href='<?php echo $GLOBALS['BASE_URL'];?>descrp.php''>Elaborazione descrizioni particellari</a>

  <a class='main_button' id='tavole' href='<?php echo $GLOBALS['BASE_URL'];?>tavole.php'>Tavole di cubatura</a>

  <a class='main_button' id='descrp' href='<?php echo $GLOBALS['BASE_URL'];?>descrp.php'>Descrizioni particellari</a>

  <a class='main_button' id='comprese' href='?'>Comprese/Classi colturali</a>

  <a class='main_button' id='dizionari' href='<?php echo $GLOBALS['BASE_URL'];?>dizionari.php'>Dizionari</a>

  <a class='main_button' id='daticat' href='<?php echo $GLOBALS['BASE_URL'];?>daticat.php'>Dati catastali</a>

  <a class='main_button' id='spazio' href='?'></a>

  <a class='main_button' id='strumenti' href='?'>Strumenti</a>

  <a class='main_button' id='rildend' href='<?php echo $GLOBALS['BASE_URL'];?>rildend.php'>Rilievi dendrometrici</a>

  <a class='main_button' id='elabdp' href='?'>Elaborazione dati dendrometrici</a>

  <a class='main_button' id='gsta' href='?'>Gestione stampe</a>

  <a class='main_button' id='viab' href='<?php echo $GLOBALS['BASE_URL'];?>viabilita.php'>Descrizioni viabilità</a>

  <a class='main_button' id='piano' href='?'>Piano degli interventi</a>

  <a class='main_button' id='decod' href='?'>Decodifica schede</a>

</div>
                            -->
			<!-- /main -->	
			</div>
