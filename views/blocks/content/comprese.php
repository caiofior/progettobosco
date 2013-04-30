                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a></div>
				<div class="post" id="comprese_main_content">
					<h2>Comprese / Classi colturali</h2>
                                            <p>Queste sono tutte le particelle del bosco. Seleziona una compresa
                                               per vedere e modificare le particelle che la compongono.
                                            </p>
                                        <p>
                                        <label for="compresa">Compresa/Classe colturale</label>
                                        <select class="large" id="regione" name="compresa"  tabindex="1" >
                                            <option value="">Seleziona una compresa</option>
                                            <?php 
                                                $compresacoll = $this->forest->getCompresaColl();
                                                $compresacoll->loadAll();
                                                foreach($compresacoll->getItems() as $compresa) : ?>
                                            <option  value="<?php echo $compresa->getData('compresa');?>"><?php echo $compresa->getData('descrizion');?></option>        
                                            <?php endforeach; ?>
                                        </select>
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>