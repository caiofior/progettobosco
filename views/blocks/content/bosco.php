                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a></div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Boschi</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?<?php echo http_build_query($_GET);?>" method="post" id="forest_list">		
                                                        <p>Filtra le foreste per regione e denominazione.</p>
                                                        	
								<label for="regione">Regione</label>
                                                                <select id="regione" name="regione"  tabindex="1" >
                                                                    <option value="">Italia</option>
                                                                    <?php 
                                                                        $forestcoll = $this->user->getForestColl($this->user->getData('is_admin') != 't'); 
                                                                        $regioncoll = $forestcoll->getRegionColl();
                                                                        foreach($regioncoll->getItems() as $region) : ?>
                                                                    <option value="<?php echo $region->getData('codice');?>"><?php echo $region->getData('descriz');?></option>        
                                                                    <?php endforeach; ?>
                                                                </select>

								<label for="descrizion">Denominazione</label>
								<input class="large" id="descrizion" name="descrizion" value="" type="text" tabindex="2" />
                                                        <?php 
                                                        require __DIR__.DIRECTORY_SEPARATOR.'boscoForestlist.php'; 
                                                        ?>
                                        
                                        </form>	
	
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
