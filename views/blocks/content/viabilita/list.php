                                                        <div id="content_tavole_list" >       
                                                        <ul >
                                                            <?php 
                                                                if (!isset($user))
                                                                    $user = $this->user;
                                                                if (!isset($ecoll))
                                                                    $ecoll = $this->forest->getEColl();
                                                                if (!key_exists('start', $_GET))
                                                                    $_GET['start']=0;
                                                                if (!key_exists('search', $_GET))
                                                                    $_GET['search']=null;
                                                                if (!key_exists('tipo', $_GET))
                                                                    $_GET['tipo']=null;
                                                                
                                                                $items_in_page =10;
                                                                $ecoll->loadAll(
                                                                        array(
                                                                    'start'=>$_GET['start'],
                                                                    'length'=>$items_in_page,
                                                                    'search'=>$_GET['search'],
                                                                    'tipo'=>$_GET['tipo'],
                                                                )
                                                                );
                                                            foreach($ecoll->getItems() as $e) :
                                                            ?>
                                                            <li >
                                                                <a href="tavole.php?action=manage&codice=<?php echo $e->getData('codice'); ?>" >
                                                                <img class="actions edit" src="images/empty.png" title="Visualizza/Modifica"/>
                                                                </a>
                                                                <?php if ($user->getData('is_admin') == 't') :?>
                                                                <a href="tavole.php?deletetable=1&codice=<?php echo $e->getData('codice'); ?>" >
                                                                <img class="actions delete" src="images/empty.png" title="Cancella"/>
                                                                </a>
                                                                <?php endif; ?>
                                                                Tavola <br/>
                                                                Codice: <?php echo $e->getData('codice');?><br/>
                                                                Descrizione: <?php echo $e->getData('descriz');?><br/>
                                                                Tipo: <?php echo $e->getRawData('tipo_descriz');?><br/>
                                                                Autore: <?php echo $e->getData('autore');?><br/>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <?php
                                                        $start = $_GET['start'];
                                                        unset($_GET['start']);
                                                        $baseurl = http_build_query($_GET);
                                                        $ections =array(
                                                            'first'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                            'prev'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                            'next'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                            'last'=>array(
                                                                'url'=>'',
                                                                'data-update'=>''
                                                            ),
                                                        );
                                                        $countall =$ecoll->countAll(array(
                                                                    'search'=>$_GET['search']
                                                                ));
                                                        $last_page = floor($countall/$items_in_page)*$items_in_page;

                                                        if ($start>0) {
                                                            $ections['prev']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
                                                                'data-update'=>'data-update="content_tavole_list"'
                                                            );
                                                            $ections['first']=array(
                                                                'url'=>'href="?'.$baseurl.'&start=0"',
                                                                'data-update'=>'data-update="content_tavole_list"'
                                                            );
                                                        }
                                                        
                                                        if ($start<$countall-$items_in_page) {
                                                            
                                                            $ections['next']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$last_page).'"',
                                                                'data-update'=>'data-update="content_tavole_list"'
                                                            );
                                                             $ections['last']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.$last_page .'"',
                                                                'data-update'=>'data-update="content_tavole_list"'
                                                            );
                                                        }
                                                        ?>
                                                        <div class="scrollcontrols">
                                                            <a <?php echo $ections['first']['url'];?> <?php echo $ections['first']['data-update'];?> >
                                                                <img class="actions first" src="images/empty.png" title="Primo">
                                                            </a>
                                                            <a <?php echo $ections['prev']['url'];?> <?php echo $ections['prev']['data-update'];?> >
                                                                <img class="actions prev" src="images/empty.png" title="Precedente">
                                                            </a>
                                                                                                                        <span>Bosco <input id="current" name="current" value="<?php echo $start; ?>" type="text"  /> di <?php echo $countall; ?></span>
                                                            <a href="#" style="display: none;" id="confirm_move">
                                                                <img class="actions confirm" src="images/empty.png" title="Vai">
                                                            </a>
                                                            <a href="#" style="display: none;" id="cancel_move">
                                                                <img class="actions cancel" src="images/empty.png" title="Annulla">
                                                            </a>
                                                            <a <?php echo $ections['next']['url'];?> <?php echo $ections['next']['data-update'];?> >
                                                                <img class="actions next" src="images/empty.png" title="Successivo">
                                                            </a>
                                                            <a <?php echo $ections['last']['url'];?> <?php echo $ections['last']['data-update'];?> >
                                                                <img class="actions last" src="images/empty.png" title="Ultimo">
                                                            </a>
                                                            <a href="tavole.php?action=createtavola" >
                                                                <img class="actions addnew" src="images/empty.png" title="Aggiungi una nuova tavola"/>
                                                            </a>
                                                        </div>
                                                        </div>