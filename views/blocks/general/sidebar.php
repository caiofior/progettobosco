			<!-- sidebar -->
			<div id="sidebar">
							
                        <div class="sidemenu">
					
 				<h3><?php echo $this->user->getData('username'); ?></h3>				
					<ul>
						<li><a href="<?php echo $GLOBALS['BASE_URL'];?>?logout=1">Esci</a></li>
                                                <li><a href="<?php echo $GLOBALS['BASE_URL'];?>profile.php">Dati personali</a></li>
                                                <li><a href="<?php echo $GLOBALS['BASE_URL'];?>profile.php?action=password">Password</a></li>
					</ul>
					
				</div>

				
				
			<!-- /sidebar -->				
			</div>