                        <!-- main -->
			<div id="main">	
                            <div id="breadcrumb">
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>">Home</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php">Elenco Boschi</a> &gt;
                                <a href="<?php echo $GLOBALS['BASE_URL'];?>bosco.php?action=manage&amp;id=<?php echo $this->forest->getData('objectid');?>">Elenco Particelle</a>
                            </div>
				<div class="post">
                                    <?php $profile = $this->user->getProfile(); ?>
					<h2>Particellare</h2>
                                        <p>Particellare Catastale</p>
                                        <p>Particellare forestale - Scheda A</p>
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="cadastral">
                    <thead>
                            <tr>
                                <th colspan="13">&nbsp;</th>
                                <th colspan="8">Improduttivi inclusi non cartografati</th>
                                <th colspan="2">Produttivi non boscati inclusi non cartografati</th>
                                <th >&nbsp;</th>
                            </tr>
                            <tr>
                                    <th >Id</th>
                                    <th >Foglio</th>
                                    <th >Particella</th>
                                    <th >Superficie totale particella catastale</th>
                                    <th >Sup. afferente alla particella forestale (ha)</th>
                                    <th >di cui boscata (ha)</th>
                                    <th >Non boscata (ha)</th>
                                    <th >Somma non boscata (ha)</th>
                                    <th >% afferente</th>
                                    <th >Note</th>
                                    <th >Particella</th>
                                    <th> Superficieparticella forestale (ha)</th>
                                    <th> Somma inclusi improdut. + produt. (ha)</th>
                                    <th> Superficie (ha)</th>
                                    <th> Superficie (%)</th>
                                    <th> Rocce</th>
                                    <th> Acque</th>
                                    <th> Strade</th>
                                    <th> Viali tagliafuoco</th>
                                    <th> Altri fattori</th>
                                    <th> Specifica</th>
                                    <th> Superficie (ha)</th>
                                    <th> Superficie (%)</th>
                                    <th> Azioni</th>
                            </tr>
                    </thead>
                    <tbody>
                            <tr>
                                    <td colspan="24" class="dataTables_empty">Caricamento dei dati</td>
                            </tr>
                    </tbody>
                    <tfoot>
                            <tr>
                                    <th >Id</th>
                                    <th >Foglio</th>
                                    <th >Particella</th>
                                    <th >Superficie totale particella catastale</th>
                                    <th >Sup. afferente alla particella forestale (ha)</th>
                                    <th >di cui boscata (ha)</th>
                                    <th >Non boscata (ha)</th>
                                    <th >Somma non boscata (ha)</th>
                                    <th >% afferente</th>
                                    <th >Note</th>
                                    <th >Particella</th>
                                    <th> Superficieparticella forestale (ha)</th>
                                    <th> Somma inclusi improdut. + produt. (ha)</th>
                                    <th> Superficie (ha)</th>
                                    <th> Superficie (%)</th>
                                    <th> Rocce</th>
                                    <th> Acque</th>
                                    <th> Strade</th>
                                    <th> Viali tagliafuoco</th>
                                    <th> Altri fattori</th>
                                    <th> Specifica</th>
                                    <th> Superficie (ha)</th>
                                    <th> Superficie (%)</th>
                                    <th> Azioni</th>
                            </tr>
                            <tr>
                                <th colspan="13">&nbsp;</th>
                                <th colspan="8">Improduttivi inclusi non cartografati</th>
                                <th colspan="2">Produttivi non boscati inclusi non cartografati</th>
                                <th colspan=>&nbsp;</th>
                            </tr>
                    </tfoot>
            </table>
                                        <!-- /post -->	
				</div>	

			<!-- /main -->	
			</div>

	

