			<!-- sidebar -->
			<div id="sidebar">
							
                <div class="sidemenu" id="sidebar_register" id="login_form">
					
 						<h3>Accedi</h3>				
			
						<form action="<?php echo $GLOBALS['BASE_URL'];?>" method="post" >		
                                                        <div class="form_messages login_messages" style="display: none;"></div>
							<p >	
								<label for="username">email</label><br />
								<input id="username" class="required" name="username" value="" type="text" tabindex="1" />
							</p>
			
							<p>
								<label for="password">password</label><br />
								<input id="password" class="required" name="password" value="" type="password" tabindex="2" />
							</p>
			
			
							<p class="no-border">
								<input class="button" name="login" type="submit" value="Accedi" tabindex="3" />         		
                                                                 o <a href="#" data-update="sidebar_register">Registrati</a>
							</p>
					
						</form>	
					
				</div>

				
				
			<!-- /sidebar -->				
			</div>

