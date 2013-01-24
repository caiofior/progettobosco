                                                        <div id="content_userManageForestlist" >       
                                                        <ul >
                                                            <?php 
                                                                if (!isset($forestcoll))
                                                                    $forestcoll = $user_detail->getForestColl(); 
                                                                else 
                                                                    $user_detail = $this->user_detail;
                                                                if (!key_exists('start', $_GET))
                                                                    $_GET['start']=0;
                                                                if (!key_exists('search', $_GET))
                                                                    $_GET['search']=null;
                                                                if (!key_exists('regione', $_GET))
                                                                    $_GET['regione']=null;
                                                                unset($_GET['owned_by']);
                                                                unset($_GET['notowned_by']);
                                                                unset($_GET['editowned_by']);
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
                                                                <?php 
                                                               if(
                                                                        is_array($forest->getRawData('write_users')) &&
                                                                        in_array($user_detail->getData('id'), $forest->getRawData('write_users'))
                                                                   ) : ?>
                                                                <a href="?<?php echo http_build_query($_GET);?>&forest_id=<?php echo $forest->getData('codice');?>&notowned_by=<?php echo $user_detail->getData('id');?>" data-update="content_userManageForestlist">
                                                                <img class="actions editowned" src="images/empty.png" title="Assegnato - scrittura"/>
                                                                </a>
                                                                <?php elseif(
                                                                        is_array($forest->getRawData('read_users')) &&
                                                                        in_array($user_detail->getData('id'), $forest->getRawData('read_users'))
                                                                   ) : ?>
                                                                <a href="?<?php echo http_build_query($_GET);?>&forest_id=<?php echo $forest->getData('codice');?>&editowned_by=<?php echo $user_detail->getData('id');?>" data-update="content_userManageForestlist">
                                                                <img class="actions owned" src="images/empty.png" title="Assegnato - lettura"/>
                                                                </a>
                                                                <?php else : ?>
                                                                <a href="?<?php echo http_build_query($_GET);?>&forest_id=<?php echo $forest->getData('codice');?>&owned_by=<?php echo $user_detail->getData('id');?>" data-update="content_userManageForestlist">
                                                                <img class="actions notowned" src="images/empty.png" title="Non assegnato"/>
                                                                </a>
                                                                <?php endif;
                                                                echo $forest->getData('descrizion');?>
                                                            </li>
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
