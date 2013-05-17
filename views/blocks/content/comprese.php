                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb"><a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco boschi</a>&gt;<a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&amp;id=<?php echo $this->forest->getData('codice');?>">Elenco Particelle</a></div>
				<div class="post" id="comprese_main_content">
					<h2>Comprese / Classi colturali</h2>
                                        <form action="<?php echo $GLOBALS['BASE_URL'];?>comprese.php?<?php echo http_build_query($_GET);?>" method="post" id="comprese_list">
                                            <p>
                                               Queste sono tutte le comprese del bosco.<br/>
                                               <span class="working_circle_not_selected">Seleziona una compresa per vedere e modificare le particelle che la compongono.</span>
                                            </p>
                                        <p>
                                        <label for="compresa">Compresa/Classe colturale</label>
                                        <select class="large" id="compresa" name="compresa"  tabindex="1" >
                                            <option value="">Seleziona una compresa</option>
                                            <?php 
                                                $compresacoll = $this->forest->getWorkingCircleColl();
                                                $compresacoll->loadAll();
                                                foreach($compresacoll->getItems() as $compresa) : ?>
                                            <option  value="<?php echo $compresa->getData('objectid');?>"><?php echo $compresa->getData('descrizion');?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        <br/>
                                        <label for="parameter">Parametro</label>
                                        <select class="large" id="parameter" name="parameter"  tabindex="2" >
                                            <option value="">Seleziona una parametro</option>
                                            <?php 
                                                $archivecoll = $this->forest->getACollFiltering();
                                                foreach($archivecoll as $archive) : ?>
                                            <option  value="<?php echo $archive['id'];?>"><?php echo $archive['archivio'];?> - <?php echo $archive['intesta'];?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        <br />
                                        <label for="operator">Operatore</label>
                                        <select class="large" id="operator" name="operator"  tabindex="3" >
                                            <option value="">Seleziona una'operatore</option>
                                            <?php 
                                                $operatorcoll = new \forest\template\ControlColl('operator');
                                                $operatorcoll->loadAll();
                                                foreach($operatorcoll->getItems() as $operator) : ?>
                                            <option  value="<?php echo $operator->getData('codice');?>"><?php echo $operator->getData('descriz');?></option>        
                                            <?php endforeach; ?>
                                        </select>
                                        <br />
                                        <label for="value">Valore</label>
                                        <input class="large" id="value" name="value"  tabindex="4" >
                                        </form>
				<!-- /post -->	
				</div>
                                <?php require __DIR__.DIRECTORY_SEPARATOR.'comprese'.DIRECTORY_SEPARATOR.'list.php';?>
			<!-- /main -->	
			</div>