                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a></div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Modifica bosco</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage" method="post" id="manage_bosco">
                                        <div class="form_messages bosco_messages" style="display: none;"></div>
                                        <p>Per modificare o inserire un bosco è necessario indicare la regione 
                                            , la denominazione e un codice identificativo composto da lettere
                                            e numeri.</p>
                                        <p>
                                        <label for="regione">Regione</label>
                                        <select class="large" id="regione" name="regione"  tabindex="1" >
                                            <option value="">Seleziona la regione</option>
                                            <?php 
                                                $regioncoll = new \forest\RegionColl();
                                                $regioncoll->loadAll();
                                                foreach($regioncoll->getItems() as $region) : ?>
                                            <option value="<?php echo $region->getData('codice');?>"><?php echo $region->getData('descriz');?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        </p>
                                        <p >	
                                            <label for="descrizion">Descrizione</label>
                                            <input class="large" id="descrizion" name="descrizion" value="<?php echo $this->forest->getData('descrizion');?>" type="text" tabindex="2" />
                                        </p>
                                        <p >	
                                            <label for="codice">Codice</label>
                                            <input class="large" id="codice" name="codice" value="<?php echo $this->forest->getData('codice');?>" type="text" tabindex="3" />
                                        </p>
                                        <p class="no-border">
                                                <input class="button" name="update" type="submit" value="Aggiorna" tabindex="4" />         		
                                        </p>
                                        </form>	
	
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
