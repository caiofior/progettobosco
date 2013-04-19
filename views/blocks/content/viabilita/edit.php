<?php
if (!isset($user))
    $user = $this->user;
if (!isset($forest))
    $forest = $this->forest;
    $e = $forest->getEColl()->getFirst();
if (
        key_exists('e_id', $_REQUEST) && 
        $_REQUEST['e_id'] != ''
        )
    $e-> loadFromId($_REQUEST['e_id']);
?>
                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a></div>
				<div class="post" id="viabilita_main_content">
					<h2>Viabilità</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>viabilita.php?id=<?php echo $forest->getData('codice');?>" method="post" id="viabilita_list">
                                        <div class="form_messages viabilita_messages" style="display: none;"></div>
                                         <fieldset id="general">
                                            <input type="hidden" id="id" name="codice_bosco" value="<?php echo $forest->getData('codice');?>"/>
                                            <input type="hidden" id="e_id" name="objectid" value="<?php echo $e->getData('objectid');?>"/>
                                        <div id="regione_container">
                                            <p class="no-border">Regione <?php echo $forest->getRegion()->getData('descriz');?><br/>
                                            Sistema informativo per l'assestamento forestale</p>     
                                        </div>
                                        <div id="bosco_container">
                                            <label for="bosco">Bosco</label>
                                            <input readonly="readonly" id="bosco" name="bosco" value="<?php echo $forest->getData('descrizion');?>">
                                        </div>
                                            <div id="codiope_container">
                                                <label for="codiope">Rilevatore</label>
                                                <input type="hidden" id="codiope" name="codiope" value="<?php echo $e->getData('codiope');?>"/>
                                                <input type="text" id="codiope_descriz" name="codiope_descriz" value="<?php echo $e->getCollector()->getData('descriz');?>"/>
                                            </div>
                                            <div id="data_container">
                                                <label for="data">Data</label>
                                                <input id="data" name="data" value="<?php echo $e->getData('data');?>">
                                            </div>
                                            <p id="note1">Scheda E per la descrizione della VIABILITA' FORESTALE E RURALE</p>
                                            <div id="lung_gis_container">
                                                <label for="lung_gis">Lunghezza (m)</label>
                                                <input id="lung_gis" name="lung_gis" value="<?php echo $e->getData('lung_gis');?>"/>
                                            </div>
                                            <div id="strada_container">
                                                <label for="strada">Percorso n°</label>
                                                <input id="strada" name="strada" value="<?php echo $e->getData('strada');?>"/>
                                            </div>
                                            <div id="nome_strada_container">
                                                <label for="nome_strada">Nome percorso</label>
                                                <input id="nome_strada" name="nome_strada" value="<?php echo $e->getData('nome_strada');?>"/>
                                            </div>
                                         </fieldset>
                                        </form>	
                                        
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>