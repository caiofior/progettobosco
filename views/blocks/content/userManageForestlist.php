                                                        <div id="content_userManageForestlist" >       
                                                        <ul >
                                                            <?php 
                                                                if (!isset($forestcoll))
                                                                    $forestcoll = $user_detail->getForestColl(); 
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
                                                            $class='not_owned';
                                                            if(is_numeric($forest->getRawData('user_id')))
                                                                $class='owned';
                                                            ?>
                                                            <li clas="<?php echo $class; ?>"><?php echo $forest->getData('descrizion');?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                        <?php
                                                        $start = $_GET['start'];
                                                        unset($_GET['start']);
                                                        $baseurl = http_build_query($_GET);
                                                        $actions =array(
                                                            'prev'=>array(
                                                                'url'=>'',
                                                                'class'=>'',
                                                                'data-update'=>''
                                                            ),
                                                            'next'=>array(
                                                                'url'=>'',
                                                                'class'=>'',
                                                                'data-update'=>''
                                                            )
                                                        );
                                                        
                                                        if ($start>0) {
                                                            $actions['prev']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.max($start-$items_in_page,0).'"',
                                                                'class'=>'active',
                                                                'data-update'=>'data-update="content_userManageForestlist"'
                                                            );
                                                        }
                                                        $countall =$forestcoll->countAll(array('search'=>$_GET['search']));
                                                        
                                                        if ($start<$countall-$items_in_page) {
                                                             $actions['next']=array(
                                                                'url'=>'href="?'.$baseurl.'&start='.min($start+$items_in_page,$countall-$items_in_page).'"',
                                                                'class'=>'active',
                                                                'data-update'=>'data-update="content_userManageForestlist"'
                                                            );
                                                        }
                                                        ?>
                                                        <div>
                                                            <a class="<?php echo $actions['prev']['class'];?>" <?php echo $actions['prev']['url'];?> <?php echo $actions['prev']['data-update'];?> >Precedente</a>
                                                            <a class="<?php echo $actions['next']['class'];?>" <?php echo $actions['next']['url'];?> <?php echo $actions['next']['data-update'];?> >Successivo</a>
                                                        </div>
                                                        </div>
