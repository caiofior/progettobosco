                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb">
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Bosco</a>
                            </div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Particella</h2>
                                        <p>I dati delle particelle forestali sono raccolti in
                                        sei schede di rilevamento.</p>
                                        <div id="formtab">
                                            <span class="active"><a href="#">Scheda A</a></span><span><a href="#">Scheda B1</a></span><span><a href="#">Scheda B2</a></span><span><a href="#">Scheda B3</a></span><span><a href="#">Scheda B4</a></span>
                                            <br />
                                            <span><a href="#">Scheda N</a></span>
                                        </div>
                                        <?php require __DIR__.DIRECTORY_SEPARATOR.'particellaSchedaA.php';?>
				<!-- /post -->	
				</div>	
                            

                            
			<!-- /main -->	
			</div>
