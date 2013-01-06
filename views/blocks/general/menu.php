<?php

                $menu = array(
		$menu['bosco'] = 'Bosco' ,
		$menu['descrp'] = 'Descrizione Particellare' ,
		$menu['daticat'] = 'Dati Catastali',
		$menu['rildend'] = 'Rilievi Dendrometrici',
		$menu['tavole'] = 'Tavole Cubatura',
		$menu['viabilita'] = 'Descrizioni Viabilità',
		$menu['1'] = 'Descrizioni Particellari',
		$menu['2'] = 'Classi Colturali',
		$menu['dizionari'] = 'Dizionari',
		$menu['4'] = 'Dati Catastali',
		$menu['5'] = 'Strumenti',
		$menu['6'] = 'Elaborazioni Dati Dendro',
		$menu['8'] = 'Piano interventi',
		$menu['9'] = 'Decodifica Schede',
		$menu['10'] = 'Gestione Stampe',
                );
?>
		<ul id='navigatio_bar'>
                    <?php 
		foreach( $menu as $tag => $text ) :
			$extra_class = (isset($_REQUEST) && key_exists('page',$_REQUEST) && $_REQUEST['page'] == $tag ) ? "nav_bar_selected" : "nav_bar" ;
                ?>
			<li><a class='<?php echo $extra_class; ?>' href="?page=<?php echo $tag; ?>"><?php echo $text; ?></a></li>
		<?php endforeach; ?>
		</ul>
