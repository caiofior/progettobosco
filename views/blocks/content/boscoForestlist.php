                                                        <div id="content_boscoForestlist" >       
                                                        <ul >
                                                            <?php 
                                                                if (!isset($forestcoll))
                                                                    $forestcoll = $user->getForestColl($user->getData('is_admin') != 't');
                                                                else
                                                                    $user = $this->user;
                                                                if (!key_exists('start', $_GET))
                                                                    $_GET['start']=0;
                                                                if (!key_exists('search', $_GET))
                                                                    $_GET['search']=null;
                                                                if (!key_exists('regione', $_GET))
                                                                    $_GET['regione']=null;
                                                                $items_in_page =2;
                                                                $forestcoll->loadAll(
                                                                        array(
                                                                    'start'=>$_GET['start'],
                                                                    'length'=>$items_in_page,
                                                                    'search'=>$_GET['search'],
                                                                    'regione'=>$_GET['regione']
                                                                )
                                                                );
                                                            foreach($forestcoll->getItems() as $forest) :
                                                            ?>
                                                            <li >
                                                                <a href="" data-update="content_boscoForestlist">
                                                                <img class="actions edit" src="images/empty.png" title="Visualizza/Modifica"/>
                                                                </a>
                                                                <?php if ($user->isUserForestAdmin($forest)) : ?>
                                                                <a href="" data-update="content_boscoForestlist">
                                                                <img class="actions delete" src="images/empty.png" title="Cancella"/>
                                                                </a>
                                                                <?php endif; ?>
                                                                <?php
                                                                echo $forest->getData('descrizion');?>
                                                            </li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <?php
                                                        $start = $_GET['start'];
                                                        unset($_GET['start']);
                                                        $baseurl = http_build_query($_GET);
                                                        $actions =array(
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
                                                        
                                                        if ($start>0) {
                                                            $actions['prev']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
                                                                'data-update'=>'data-update="content_boscoForestlist"'
                                                            );
                                                            $actions['first']=array(
                                                                'url'=>'href="?'.$baseurl.'&start=0"',
                                                                'data-update'=>'data-update="content_boscoForestlist"'
                                                            );
                                                        }
                                                        $countall =$forestcoll->countAll(array('search'=>$_GET['search']));
                                                        
                                                        if ($start<$countall-$items_in_page) {
                                                             $actions['next']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$countall-$items_in_page-1).'"',
                                                                'data-update'=>'data-update="content_boscoForestlist"'
                                                            );
                                                             $actions['last']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.($countall-$items_in_page).'"',
                                                                'data-update'=>'data-update="content_boscoForestlist"'
                                                            );
                                                        }
                                                        ?>
                                                        <div>
                                                            <a <?php echo $actions['first']['url'];?> <?php echo $actions['first']['data-update'];?> >
                                                                <img class="actions first" src="images/empty.png" title="Primo">
                                                            </a>
                                                            <a <?php echo $actions['prev']['url'];?> <?php echo $actions['prev']['data-update'];?> >
                                                                <img class="actions prev" src="images/empty.png" title="Precedente">
                                                            </a>
                                                            <a <?php echo $actions['next']['url'];?> <?php echo $actions['next']['data-update'];?> >
                                                                <img class="actions next" src="images/empty.png" title="Successivo">
                                                            </a>
                                                            <a <?php echo $actions['last']['url'];?> <?php echo $actions['last']['data-update'];?> >
                                                                <img class="actions last" src="images/empty.png" title="Ultimo">
                                                            </a>
                                                            <a href="bosco.php?action=manage" >
                                                                <img class="actions addnew" src="images/empty.png" title="Aggiungi una nuova foresta"/>
                                                            </a>
                                                        </div>
                                                        </div>
