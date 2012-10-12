  for( $i=0; $i<=4; $i++ ){echo "<td><input type='radio' name='f2_".$i."' value='".$i."'";
				if($info->f2 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			}  echo "</tr>\n <tr><th>selvatici</th>";
			for( $i=0; $i<=4; $i++ ){ echo "<td><input type='radio' name='f3_".$i."' value='".$i."'";
				if($info->f3 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			}  echo "</tr>\n <tr><th>pietrosità</th>";
			for( $i=0; $i<=4; $i++ ){echo "<td><input type='radio' name='f4_".$i."' value='".$i."'";
				if($info->f4 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			} ?></tr>
---------------------------------------------------------------

		  <tr><th>fitopatogeni e parassiti</th>
		  <?php for( $i=0; $i<=4; $i++ ){echo "<td><input type='radio' name='f6_".$i."' value='".$i."'";
				if($info->f6 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			} ?></tr>
		  <tr><th>agenti meteorici</th>
		  <?php for( $i=0; $i<=4; $i++ ){ echo "<td><input type='radio' name='f7_".$i."' value='".$i."'";
				if($info->f7 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			}  ?></tr>
		  <tr><th>utilizzazioni o esbosco</th>
		  <?php for( $i=0; $i<=4; $i++ ){echo "<td><input type='radio' name='f8_".$i."' value='".$i."'";
				if($info->f8 ==  $i ): echo "checked"; endif;echo " /></td>\n" ; 
			}  ?></tr>
		  <tr><th>attività turistico-ricreative</th>
		  <?php for( $i=0; $i<=4; $i++ ){echo "<td><input type='radio' name='f10_".$i."' value='".$i."'";
				if($info->f10 ==  $i ): echo "checked"; endif;echo " /></td>\n" ; 
			}  ?></tr>
		  <tr><th>altre cause</th>
		  <?php for( $i=0; $i<=4; $i++ ){echo "<td><input type='radio' name='f11_".$i."' value='".$i."'";
				if($info->f11 ==  $i ): echo "checked"; endif;echo " /></td>\n" ; 
			}  ?></tr>
---------------------------------------------------------------

	  <tr><th>superficialità terreno</th>
		  <?php for( $i=0; $i<=3; $i++ ){ echo "<td><input type='checkbox' name='r2_".$i."' value='".$i."'";
				if($info->r2 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			}  ?></tr>
		  <tr><th>rocciosità affiorante</th>
		  <?php for( $i=0; $i<=3; $i++ ){ echo "<td><input type='checkbox' name='r3_".$i."' value='".$i."'";
				if($info->r3 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			} ?></tr>
		  <tr><th>pietrosità</th>
		  <?php for( $i=0; $i<=3; $i++ ){ echo "<td><input type='checkbox' name='r4_".$i."' value='".$i."'";
				if($info->r4 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			} ?></tr>
		  <tr><th>ristagni d'acqua</th>
		  <?php for( $i=0; $i<=3; $i++ ){ echo "<td><input type='checkbox' name='r5_".$i."' value='".$i."'";
				if($info->r5 ==  $i ): echo "checked"; endif; echo " /></td>\n" ; 
			} ?></tr>
		  <tr><th>altri fattori limitanti</th>
		  <?php for( $i=0; $i<=3; $i++ ){ echo "<td><input type='checkbox' name='r6_".$i."' value='".$i."'";
				if($info->r6 ==  $i ): echo "checked"; endif;echo " /></td>\n" ; 
			}  ?></tr>

---------------------------------------------------------------
		  <tr><th>erosione superficiale o incanalata </th>
<?php for( $i=0; $i<=4; $i++ ){
			    echo "<td><input type='checkbox' name='a2_".$i."' value='".$i."'";
				if($info->a2 ==  $i ): echo "checked"; endif;
			    echo " /></td>\n" ; 
			}  ?></tr>
		  <tr><th>erosione catastrofica o calanchiva </th>
		  <?php for( $i=0; $i<=4; $i++ ){
			    echo "<td><input type='checkbox' name='a3_".$i."' value='".$i."'";
				if($info->a3 ==  $i ): echo "checked"; endif;
			    echo " /></td>\n" ; 
			} ?></tr>
		  <tr><th>frane superficiali</th>
		  <?php for( $i=0; $i<=4; $i++ ){
			    echo "<td><input type='checkbox' name='a4_".$i."' value='".$i."'";
				if($info->a4 ==  $i ): echo "checked"; endif;
			    echo " /></td>\n" ; 
			} ?></tr>
		  <tr><th>rotolamento massi</th>
		  <?php for( $i=0; $i<=4; $i++ ){
			    echo "<td><input type='checkbox' name='a6_".$i."' value='".$i."'";
				if($info->a6 ==  $i ): echo "checked"; endif;
			    echo " /></td>\n" ; 
			} ?></tr>
		  <tr><th>altri fattori di dissesto</th>
		  <?php for( $i=0; $i<=4; $i++ ){
			    echo "<td><input type='checkbox' name='a7_".$i."' value='".$i."'";
				if($info->a7 ==  $i ): echo "checked"; endif;
			    echo " /></td>\n" ; 
			}  ?></tr>
----------------------------------------------------------------
da function.php
<?
function getSchedaASuperfici ( $codice , $particella ){
$query = "	SELECT sup_tot, i1, i2, i21, i22
		FROM schede_a
		WHERE (proprieta='$codice' AND cod_part='$particella')";
	$res = pg_query($query) or die( __FUNCTION__."$query<br />".pg_last_error() ) ;
	$arr = array() ;
	while($row = pg_fetch_object($res)) $arr = $row ;

	$sup["improd"] = (!empty($arr->i1) and $arr->i1 != 0) ? $arr->i1 : ( (!empty($arr->i2) and $arr->i2 != 0) ? ($arr->sup_tot*$arr->i2/100) : 0);
	$sup["p_n_bosc"] = (!empty($arr->i21) and $arr->i21 != 0) ? $arr->i21 : ( (!empty($arr->i22) and $arr->i22 != 0) ? ($arr->sup_tot*$arr->i22 /100) : 0);
	return $sup ;
} ?>