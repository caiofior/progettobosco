                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>user.php">Utenti</a></div>
				<div class="post">
                                    <?php $profile = $this->user_detail->getProfile(); ?>
					<h2>Boschi associati all'utente <?php echo $this->user_detail->getData('username');?></h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>user.php?action=manage" method="post" id="profile_form">		
                                                        <div class="form_messages profile_messages" style="display: none;"></div>
                                                        <p >	
								<label for="regione">Regione</label>
								<input class="large" id="regione" name="regione" value="" type="text" tabindex="1" />

								<label for="descriz">Denominazione</label>
								<input class="large" id="descriz" name="descriz" value="" type="text" tabindex="2" />
                                                        <ul id="forest_list">
                                                            <?php $forestcoll = $this->user_detail->getForestColl(); 
                                                            foreach($forestcoll->getItems() as $forest) :?>
                                                            <li><?php echo $forest->getData('descrizion');?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                            
                                                        </p>
                                        </form>	
                                        	
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
