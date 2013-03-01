                        <?php
                        $a = $this->a;
                        $forest = $a->getForest();
                        ?>
                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb">
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco Boschi</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&id=<?php echo $forest->getData('objectid');?>">Elenco Particelle</a>
                            </div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Particella</h2>
                                        <p>I dati delle particelle forestali sono raccolti in
                                        sei schede di rilevamento.</p>
                                        <div id="formtab">
                                            <span class="active"><a data-update="content_particellaSchedaA" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda A</a></span><span><a data-update="content_particellaSchedaB1" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda B1</a></span><span><a data-update="content_particellaSchedaB2" data-destination="forestcompartmentmaincontent" href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?id=<?php echo $a->getData('objectid');?>">Scheda B2</a></span><span><a href="#">Scheda B3</a></span><span><a href="#">Scheda B4</a></span>
                                            <br />
                                            <span><a href="#">Scheda N</a></span>
                                        </div>
                                        
                                        <?php require __DIR__.DIRECTORY_SEPARATOR.'particellaSchedaB2.php';?>
                                        </div>
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
