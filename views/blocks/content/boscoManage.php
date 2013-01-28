                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a></div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Modifica bosco</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage<?php echo (key_exists('id', $_REQUEST) ? '&id='.$_REQUEST['id'] : ''); ?>" method="post" id="manage_bosco">
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
                                                foreach($regioncoll->getItems() as $region) : 
                                                    $selected = '';
                                                    if ($region->getData('codice') == $this->forest->getData('regione'))
                                                        $selected = 'selected="selected"';
                                                    ?>
                                            <option <?php echo $selected; ?> value="<?php echo $region->getData('codice');?>"><?php echo $region->getData('descriz');?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        </p>
                                        <p >	
                                            <label for="descrizion">Descrizione</label>
                                            <input class="large" id="descrizion" name="descrizion" value="<?php echo $this->forest->getData('descrizion');?>" type="text" tabindex="2" />
                                        </p>
                                        <p >	
                                            <label for="codice">Codice<span id="prefissocodice"><?php echo $this->forest->getData('regione'); ?></span></label>
                                            <input class="large" id="codice" name="codice" value="<?php echo substr($this->forest->getData('codice'),2);?>" type="text" tabindex="3" />
                                        </p>
                                        <p class="no-border">
                                                <input class="button" name="update" type="submit" value="Aggiorna" tabindex="4" />         		
                                        </p>
                                        </form>	
                                        <?php if ($this->forest->getRawdata('forest_compartment_cont') > 0) : ?>
                                        <h2>Particelle forestali</h2>
                                        <?php endif; ?>
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
