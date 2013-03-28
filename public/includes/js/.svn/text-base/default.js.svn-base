function bosco_regione() {
      if(document.bosco_form.regione1.value!="-1")
	 document.bosco_form.submit();
      else
	 document.bosco_form.codice1.value="";
}
// ----------------------------------------------------------- Scheda A
function schedeA_form2() {
	document.formA2.cod_nota.value = document.descrp_schede_form.parametro_sing1.value ;
	document.formA2.nota.value = document.descrp_schede_form.nota_sing1.value;
	var parametro_sing= document.descrp_schede_form.parametro_sing1.value;
	if (parametro_sing!='-1'){
		if( !confirm("Hai inserito una nota alle singole voci")) return false ;
		else 	document.formA2.submit();		
	} else {
		alert('Il valore del Parametro della nota non può essere nullo.');
	}
}
function schedeA_form3( cod ) {
	var tr = $('tr_'+cod);
	document.formA3.cod_nota.value = tr.getElement('select[name=parametro_sing]').value ;
	document.formA3.nota.value = tr.getElement('input[name=nota_sing]').value;
	if( !confirm("Vuoi modificare questa nota alle singole voci?")) return false ;
	else 	document.formA3.submit();
}
/*foglio, particella_cat, sup_tot_cat, sup_tot, sup_bosc, sum_sup_non_bosc, porz_perc, note*/
function schedeA_form4() {
	document.formA4.foglio.value = document.particelle_cat_form.foglio1.value ;
	document.formA4.particella_cat.value = document.particelle_cat_form.particella_cat1.value;
	document.formA4.sup_tot_cat.value = document.particelle_cat_form.sup_tot_cat1.value;
	document.formA4.sup_tot.value = document.particelle_cat_form.sup_tot1.value;
	document.formA4.sup_bosc.value = document.particelle_cat_form.sup_bosc1.value;
	document.formA4.sum_sup_non_bosc.value = document.particelle_cat_form.sum_sup_non_bosc1.value;
	document.formA4.porz_perc.value = document.particelle_cat_form.porz_perc1.value;
	document.formA4.note.value = document.particelle_cat_form.note1.value;
	var foglio=document.particelle_cat_form.foglio1.value ;
	var particella_cat= document.particelle_cat_form.particella_cat1.value;
	if (foglio.replace(/\s+/g,'')!='' && particella_cat.replace(/\s+/g,'')!=''){
		if( !confirm("vuoi inserire questi dati catastali?")) return false ;
		else 	document.formA4.submit();
	} else {
		alert('I valori di foglio e particella non possono essere nulli.');
	}
} 

function schedeA_form5( cod ) {
	var array = cod.split("_");
	var tr = $('tr_A_'+cod);
	document.formA5.foglio.value = tr.getElement('input[name=foglio]').value;
	document.formA5.foglio_old.value = array[0];
	document.formA5.particella_cat.value = tr.getElement('input[name=particella_cat]').value;
	document.formA5.particella_cat_old.value = array[1];
	document.formA5.sup_tot_cat.value = tr.getElement('input[name=sup_tot_cat]').value;
	document.formA5.sup_tot.value = tr.getElement('input[name=sup_tot]').value;
	document.formA5.sup_bosc.value = tr.getElement('input[name=sup_bosc]').value;
	document.formA5.sum_sup_non_bosc.value = tr.getElement('input[name=sum_sup_non_bosc]').value;
	document.formA5.porz_perc.value = tr.getElement('input[name=porz_perc]').value;
	document.formA5.note.value = tr.getElement('input[name=note]').value;
	if( !confirm("Vuoi modificare questi dati catastali?")) return false ;
	else 	document.formA5.submit();
}
// -----------------------form 2 e 3 per Scheda B1 e Scheda B2 --------------
var nome = ['formB1','formB2'];// 
var scheda =['schedeB1','schedeB2'];// 

for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form2";
 	var form = nome[x]+"_2";
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_coltu.value = document.descrp_"+scheda[x]+"_form.cod_coltu_arbo1.value ;"+
	 	" document."+form+".cod_coper.value = document.descrp_"+scheda[x]+"_form.cod_coper_arbo1.value ;"+
	 	" document."+form+".ordine_inser.value = document.descrp_"+scheda[x]+"_form.ordine_inser_arbo1.value;"+
	 	" if (confirm(\""+form+": Hai inserito una specie nella composizione dello strato arboreo\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }
  
for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form3";
 	var form = nome[x]+"_3";
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_3_'+cod); "+
  	"	document."+form+".cod_coltu.value = tr.getElement('select[name=cod_coltu_arbo]').value ;"+
  	"	document."+form+".cod_coper.value = tr.getElement('select[name=cod_coper_arbo]').value ;"+  
  	"	document."+form+".ordine_inser.value = tr.getElement('input[name=ordine_inser_arbo]').value;"+	
  	"   document."+form+".cod_coltu_old.value = cod ; "+
  	"   if( confirm(\"Vuoi modificare questa specie nella composizione dello strato arboreo?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}
// ----------------------------- Scheda B2 -------------------

	//SCHEDB1: Genero i form pari schedeB1_form4-------------------------------
var num_form0 = [ "4","6"];
var arr1 = [ 'arbu1', 'erba1'];
var strato = [ 'arbustivo' , 'erbaceo'];

for (x=0; x<num_form0.length;x++){
 	var nome_form = "schedeB1_form"+num_form0[x];
 	var form = "formB1_"+num_form0[x];
 	var cod_coltu_arr = "cod_coltu_"+arr1[x];
 	var tipo_strato = strato[x];
 	
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_coltu.value = document.descrp_schedeB1_form."+cod_coltu_arr+".value ;"+
	 	" if (confirm(\""+form+": Hai inserito una specie nella composizione dello strato "+tipo_strato+"\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }
 
  	//SCHEDB1: Genero i form dispari (schedeB1_form5) --------------------------
var num_form1 = ["5","7"];
var arr = ['arbu', 'erba'];
var strato = ['arbustivo' , 'erbaceo'];

for (x=0; x<num_form1.length;x++){
 	var nome_form = "schedeB1_form"+num_form1[x];
 	var form = "formB1_"+num_form1[x];
 	var cod_coltu_arr = "cod_coltu_"+arr[x];
 	var tipo_strato = strato[x];
 	
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_"+num_form1[x]+"_'+cod); "+
  	"	document."+form+".cod_coltu.value = tr.getElement('select[name="+cod_coltu_arr+"]').value ;"+
  	"   document."+form+".cod_coltu_old.value = cod ; "+
  	"   if( confirm(\""+form+":Vuoi modificare questa specie nella composizione dello strato "+tipo_strato+"?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}
// -----------------------form 10 e 11 per Scheda B1 --------------
var nome = ['formB1'];// 
var scheda =['schedeB1'];// 

for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form10";
 	var form = nome[x]+"_10";
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_coltu.value = document.descrp_"+scheda[x]+"_form.cod_coltu_specie1.value ;"+
	 	" document."+form+".cod_coper.value = document.descrp_"+scheda[x]+"_form.cod_coper_specie1.value ;"+
	 	" document."+form+".massa_tot.value = document.descrp_"+scheda[x]+"_form.massa_tot_specie1.value;"+
	 	" if (confirm(\""+form+": Hai inserito una specie nella composizione dello strato arboreo\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }
  
for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form11";
 	var form = nome[x]+"_11";
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_11_'+cod); "+
  	"	document."+form+".cod_coltu.value = tr.getElement('select[name=cod_coltu_specie]').value ;"+
  	"	document."+form+".cod_coper.value = tr.getElement('select[name=cod_coper_specie]').value ;"+  
  	"	document."+form+".massa_tot.value = tr.getElement('input[name=massa_tot_specie]').value;"+	
  	"   document."+form+".cod_coltu_old.value = cod ; "+
  	"   if( confirm(\"Vuoi modificare questa specie nella composizione dello strato arboreo?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}

// -----------------------form 9r Scheda B1 --------------
function schedeB1_form9( cod ) {
	var tr = $('tr_'+cod);
	if( $$('.no_repeat_schA') ) {
		var groups =  new Array();
		var tr_mio = '';
		var tr_cod = '';
		var value = '';
		$$('.no_repeat_schA').each(function(el,i){	
			tr_cod 
			value = el.getElement('select[name=parametro_sing]').value;
			
			$$('.no_repeat_schA').each(function(el,i){	
				
				alert('cod '+cod+' value '+value);
				if (value == cod){
					tr_mio = cod;  
					alert('tr_mio '+tr_mio+' value '+value);
				} else {
					groups.include(value);
					alert('altro '+value);
				}
			});
		});
		if (groups.contains(tr_mio)){
// 			alert ('questa nota è già stata inserita!');
			confirm('questa nota è già stata inserita!') ;
		}
	}
	document.formB1_9.cod_nota.value = tr.getElement('select[name=parametro_sing]').value ;
	document.formB1_9.cod_nota_old.value = cod ;
	document.formB1_9.nota.value = tr.getElement('input[name=nota_sing]').value;
	if( !confirm("Vuoi modificare questa nota alle singole voci?")) return false;
	else 	document.formB1_9.submit();
}

// ------------------------------ Scheda B2 -----------------------------------

	//SCHEDB2: generazione dinamica delle funzioni che permettono di eseguire i form delle sotto tabelle di descrp_schedeB2.php
	//SCHEDB2: Genero i form pari schedeB2_form4-------------------------------
var num_form0 = [ "4","6"];
var arr1 = [ 'arbu1', 'erba1'];
var strato = [ 'arbustivo' , 'erbaceo'];

for (x=0; x<num_form0.length;x++){
 	var nome_form = "schedeB2_form"+num_form0[x];
 	var form = "formB2_"+num_form0[x];
 	var cod_coltu_arr = "cod_coltu_"+arr1[x];
 	var tipo_strato = strato[x];
 	
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_coltu.value = document.descrp_schedeB2_form."+cod_coltu_arr+".value ;"+
	 	" if (confirm(\""+form+": Hai inserito una specie nella composizione dello strato "+tipo_strato+"\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }
 	//SCHEDB2: Genero i form dispari (schedeB2_form5) --------------------------
var num_form1 = ["5","7"];
var arr = ['arbu', 'erba'];
var strato = ['arbustivo' , 'erbaceo'];

for (x=0; x<num_form1.length;x++){
 	var nome_form = "schedeB2_form"+num_form1[x];
 	var form = "formB2_"+num_form1[x];
 	var cod_coltu_arr = "cod_coltu_"+arr[x];
 	var tipo_strato = strato[x];
 	
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_"+num_form1[x]+"_'+cod); "+
  	"	document."+form+".cod_coltu.value = tr.getElement('select[name="+cod_coltu_arr+"]').value ;"+
  	"   document."+form+".cod_coltu_old.value = cod ; "+
  	"   if( confirm(\""+form+":Vuoi modificare questa specie nella composizione dello strato "+tipo_strato+"?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}


//------------------------------------------------ Scheda B3--------------------
	// generazione dinamica delle funzioni che permettono di eseguire i form delle sotto tabelle di descrp_schedeB3.php
	// Genero i form pari schedeB3_form2---------------------------------------
var num_form0 = ["2", "4","6","10", "12", "14"];
var arr1 = ['arbu1', 'erba1', 'arbo1', 'rin1', 'erba_inf1', 'albe1'];
var strato = ['arbustivo', 'erbaceo' , 'arboreo', 'della rinnovazione' , 'delle erbe infestanti' , 'dell\'alberatura'];

for (x=0; x<num_form0.length;x++){
 	var nome_form = "schedeB3_form"+num_form0[x];
 	var form = "formB3_"+num_form0[x];
 	var cod_coltu_arr = "cod_coltu_"+arr1[x];
 	var tipo_strato = strato[x];
 	
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_coltu.value = document.descrp_schedeB3_form."+cod_coltu_arr+".value ;"+
	 	" if (confirm(\""+form+": Hai inserito una specie nella composizione dello strato "+tipo_strato+"\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }

	// Genero i form dispari schedeB3_form3-------------------------------------
var num_form1 = ["3", "5","7","11", "13", "15"];
var arr = ['arbu', 'erba', 'arbo', 'rin', 'erba_inf', 'albe'];
var strato = ['arbustivo', 'erbaceo' , 'arboreo', 'della rinnovazione' , 'delle erbe infestanti' , 'dell\'alberatura'];

for (x=0; x<num_form1.length;x++){
 	var nome_form = "schedeB3_form"+num_form1[x];
 	var form = "formB3_"+num_form1[x];
 	var cod_coltu_arr = "cod_coltu_"+arr[x];
 	var tipo_strato = strato[x];
 	//alert(nome_form+" e "+cod_coltu);
 	
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_"+num_form1[x]+"_'+cod); "+
  	"	document."+form+".cod_coltu.value = tr.getElement('select[name="+cod_coltu_arr+"]').value ;"+
  	"   document."+form+".cod_coltu_old.value = cod ; "+
  	"   if( confirm(\""+form+":Vuoi modificare questa specie nella composizione dello strato "+tipo_strato+"?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}

//------------------------------------------------ Scheda B4--------------------
	// generazione dinamica delle funzioni che permettono di eseguire i form delle sotto tabelle di descrp_schedeB3.php
	// Genero i form pari schedeB4_form6---------------------------------------
var num_form0 = ["6"];
var arr1 = ['erba1'];
var strato = ['erbaceo'];

for (x=0; x<num_form0.length;x++){
 	var nome_form = "schedeB4_form"+num_form0[x];
 	var form = "formB4_"+num_form0[x];
 	var cod_coltu_arr = "cod_coltu_"+arr1[x];
 	var tipo_strato = strato[x];
 	
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_coltu.value = document.descrp_schedeB4_form."+cod_coltu_arr+".value ;"+
	 	" if (confirm(\""+form+": Hai inserito una specie nella composizione dello strato "+tipo_strato+"\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }

	// Genero i form dispari schedeB4_form7-------------------------------------
var num_form1 = ["7"];
var arr = ['erba'];
var strato = ['erbaceo'];

for (x=0; x<num_form1.length;x++){
 	var nome_form = "schedeB4_form"+num_form1[x];
 	var form = "formB4_"+num_form1[x];
 	var cod_coltu_arr = "cod_coltu_"+arr[x];
 	var tipo_strato = strato[x];
 	//alert(nome_form+" e "+cod_coltu);
 	
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_"+num_form1[x]+"_'+cod); "+
  	"	document."+form+".cod_coltu.value = tr.getElement('select[name="+cod_coltu_arr+"]').value ;"+
  	"   document."+form+".cod_coltu_old.value = cod ; "+
  	"   if( confirm(\""+form+":Vuoi modificare questa specie nella composizione dello strato "+tipo_strato+"?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}

// ----------------------- Scheda B4  --------------
var nome = ['formB4_a','formB4_b'];// 
var scheda =['schedeB4_a','schedeB4_b'];// 
var scheda_form = ['schedeB4','schedeB4'];// 
var arr = ['arboa', 'arbob'];
var strato = ['arboreo dominante', 'arboreo dominato'];

for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form2";
 	var form = nome[x]+"_2"; 		
 	var tipo_strato = strato[x];
 	
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_coltu.value = document.descrp_"+scheda_form[x]+"_form.cod_coltu_"+arr[x]+"1.value ;"+
	 	" document."+form+".cod_coper.value = document.descrp_"+scheda_form[x]+"_form.cod_coper_"+arr[x]+"1.value ;"+
	 	" document."+form+".ordine_inser.value = document.descrp_"+scheda_form[x]+"_form.ordine_inser_"+arr[x]+"1.value;"+
	 	" if (confirm(\""+form+": Hai inserito una specie nella composizione dello strato arboreo "+tipo_strato+".\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }
  
for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form3";
 	var form = nome[x]+"_3";
 	var tipo_strato = strato[x];
 	
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_3_'+cod); "+
  	"	document."+form+".cod_coltu.value = tr.getElement('select[name=cod_coltu_"+arr[x]+"]').value ;"+
  	"	document."+form+".cod_coper.value = tr.getElement('select[name=cod_coper_"+arr[x]+"]').value ;"+  
  	"	document."+form+".ordine_inser.value = tr.getElement('input[name=ordine_inser_"+arr[x]+"]').value;"+	
  	"   document."+form+".cod_coltu_old.value = cod ; "+
  	"   if( confirm(\"Vuoi modificare questa specie nella composizione dello strato arboreo "+tipo_strato+"?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}
// --------------------------NOTE SINGOLE VOCI TUTTE SCHEDE--------------------
//  form per le note alle singole voci: form pari
var nome = ['formB1','formB2', 'formB3', 'formB4'];// 
var scheda =['schedeB1','schedeB2', 'schedeB3', 'schedeB4'];// 

for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form8";
 	var form = nome[x]+"_8";
 	
 	eval("function "+nome_form+"(){"+
	 	" document."+form+".cod_nota.value = document.descrp_"+scheda[x]+"_form.parametro_sing1.value ;"+
	 	" document."+form+".nota.value = document.descrp_"+scheda[x]+"_form.nota_sing1.value ;"+
	 	" if (confirm(\""+form+": Hai inserito una nota alle singole voci\")) document."+form+".submit();"+
		" else 	return false;"+
	" }");
 }
 
var nome = ['formB1','formB2', 'formB3', 'formB4'];// 
var scheda =['schedeB1','schedeB2', 'schedeB3', 'schedeB4'];// 
for (x=0; x<nome.length;x++){
 	var nome_form = scheda[x]+"_form9";
 	var form = nome[x]+"_9";
 	
  	eval("function "+nome_form+"(cod) {"+
  	"	var tr = $('tr_'+cod); "+
  	"	document."+form+".cod_nota.value = tr.getElement('select[name=parametro_sing]').value ;"+
  	"   document."+form+".cod_nota_old.value = cod ; "+
	"   document."+form+".nota.value = tr.getElement('input[name=nota_sing]').value; "+
  	"   if( confirm(\"Vuoi modificare questa nota alle singole voci?\"+cod)) document."+form+".submit();"+
  	" else 	return false;"+
  	"}" );
}	
// ---------------------------------------------------------
// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++
// ---------------------------------------------------------
window.addEvent('domready', function(){
//    creata funzione per arrotondare un numero alla prima cifra decimale
	function roundTo(number, to) {
	    return Math.round(number * to) / to;
	}
  
//    per bosco.php, alert di conferma prima che vengano eseguite le query di modifica o cancellazione
	$$('.actions').each( function(a){
		a.addEvent('click',function(e){
			var ttl = a.get('title') ;
			var msg = '' ;
			
			if( $('delete') ) 	msg = 'sei sicuro di voler cancellare '+ttl+'?' ;
			else if( $('modify') ) 	msg = 'sei sicuro di voler modificare '+ttl+'?' ;
			if( !confirm(msg) ) e.stop() ;
		});
	});
	
// per selezionare una nuova particella in tavole.php
	if( $('tavole_select') ) {
		var sel = $('tavole_select') ;
		sel.addEvent('change',function(e){
			var id = sel.get('value') ;
			if( id == '-1' ) e.stop() ;
			else if( id == '-2' ) {
				var query = new Element('input') ;
				    query.set('id','tavole_input') ;
				    query.set('name','tavola') ;
				    query.setStyle('width',sel.getStyle('width'));
				var hid = new Element('input') ;
				    hid.set('type','hidden') ;
				    hid.set('name','new') ;
				var ret = new Element('a') ;
				    ret.setStyle('display','inline') ;
				    ret.set('html','ritorna') ;
				    ret.addEvent('click',function(e){
					  sel.setStyle('display','inline') ;
					  sel.set('disabled',false) ;
					  query.destroy();
					  ret.destroy();
					  hid.destroy();
				    });
				query.inject(sel,'after');
				ret.inject(query,'after');
				hid.inject(query,'after');
				sel.setStyle('display','none') ;
				sel.set('disabled',true) ;
			}
		});
	}

// serve per rendere disabilitato un input tipo CHECKBOX quando non ha valora
//ma con un click sul div superiore diventa selezionabile	
	if( $$('.checkbox_dis') ) {
	// necessario un blocco (div,td) superiore
		$$('.checkbox_dis').each(function(el,i){
			el.disabled = true;
			el.getParent().addEvent('click',function(e){
				el.disabled = false;
			});
		});
	}
// serve per rendere disabilitato un input tipo RADIO quando non ha valore, cioè non è selezionato (è null, nè true nè false)
//ma con un click sul div superiore diventa selezionabile
	if( $$('.radio_dis') ) {
	// necessario un blocco (div) superiore
		var groups 		= new Array();
		var groups_to_dis 	= new Array();
		
		$$('.radio_dis').each(function(el,i){
			groups.include(el.get('name'));
		});
		
		groups.each(function(name,i){
			var to_dis = true;
			$$('input[name='+name+']').each(function(rad,i){
				if( rad.checked == true ) to_dis = false;
			});
			if( to_dis == true ) {
				groups_to_dis.include(name);
			}
		});
		
		
		groups_to_dis.each(function(name_to_dis,i2){
			$$('input[name='+name_to_dis+']').each(function(el,i){
				el.disabled = true;
				groups.include(el.get('name'));
				el.getParent('div').addEvent('click',function(e){
					var name = el.get('name');
					$$('input[name='+name+']').each(function(rad,i){
						rad.disabled = false;
					});
				});
			});
		});
	}
//serve per le checkbox per simulare il funzionamento del RADIO
	if( $$('.checkbox_escl') ) {
	// la prima checkbox deve avere classe checkbox_escl ed una classe radio_pippo
	// le altre solo radio_pippo
		$$('.checkbox_escl').each(function(el,i){
			var classes = el.get('class').split(' '); // classes = array (checkbox_escl,radio_pippo)
			var group = $$( '.'+classes[1]); // group = array (input_1, input_2, input_3)
			group.each(function(el2,i2){
				el2.addEvent('change',function(e){
					if(e) e.stop() ;
					group.each(function(el3,i3){
						if(i2!=i3) 	el3.checked=false;
						else 		el3.checked=true;
					});
				});
			});
		});
	}

//input con classe = 'check_nessuno (check_nessuno_capo O check_nessuno_group_*nome_tabella*)'
// questa funzione serve per modificare il comportamente dei checkbox: 
// 1. quando il primo (con classe check_nessuno_capo) è selezionato, allora tutti gli altri (con classe check_nessuno_group_*nome_tabella*) sono non checked.
// 2. quando il primo (con classe check_nessuno_capo) è NON selezionato, allora gli altri (con classe check_nessuno_group_*nome_tabella*) sono selezionabili.
	if( $$('.check_nessuno') ) {
/*
input a) check_nessuno check_nessuno_group_pascoli check_nessuno_capo
input b) check_nessuno check_nessuno_group_pascoli
input c) check_nessuno check_nessuno_group_pascoli
...
*/
		var groups =  new Array();
		$$('.check_nessuno').each(function(el,i){	
			el.get('class').split(' ').each(function(clas,i){
				if(clas.contains('check_nessuno_group_'))
					groups.include(clas);
			});
		});
		groups.each( function(group_name, k){
			
			var capo 	= $(document.body).getElement('.'+group_name + ', input.check_nessuno_capo');
			var group 	= $$('.'+group_name);
			group.each(function(el1,i1){
				el1.addEvent('change',function(e){
					if(e) e.stop() ;
					if( el1 == capo && capo.checked ) {
						var deps = group.erase(capo);
						deps.each(function(el2,i2){
							el2.checked= !el1.checked;
						});
					}
					else
						if( el1.checked) 	capo.checked = false;
				});
			});
		});
	}

//input con classe = 'depends_on (depends_capo o depends_group_*nome_tabella*)'
// questa funzione serve per modificare il comportamente dei radio interni ad una checkbox: 
// 1. quando il checkbox esterno (con classe depends_capo) è selezionato, allora i radio da lui dipendenti (con classe depends_group_*nome_tabella*) sono attivi;
// 2. quando il checkbox esterno (con classe depends_capo) è NON selezionato,allora i radio da lui dipendenti (con classe depends_group_*nome_tabella*) sono disattivi.
	if( $$('.depends_on') ) {
/*
depends_on depends_group_pascoli depends_capo
depends_on depends_group_pascoli
depends_on depends_group_alberi depends_capo
depends_on depends_group_alberi
*/
		var groups 		= new Array();
		$$('.depends_on').each(function(el,i){
			el.get('class').split(' ').each(function(clas,i){
				if(clas.contains('depends_group_'))
					groups.include(clas);
			});
		});
		
		groups.each(function(group_name,i){
			var capo 	= $(document.body).getElement('.'+group_name + ', input.depends_capo');
			var dipendenti 	= $$('.'+group_name).erase(capo);
			capo.addEvent('change',function(e){
				if(e) e.stop() ;
				dipendenti.each(function(dep,i){
					if (!capo.checked) dep.checked = false;
					dep.disabled = !capo.checked;
				});
			});
 			if (capo.checked == false)  {
				dipendenti.each(function(dep,i){
					dep.checked = false;
					dep.disabled = !capo.checked;
				});
 			}
//			capo.fireEvent('change');
		});
	}
// controllo che il formato della data sia adeguato aaaa-mm-gg o con /
	if ( $$('.controllo_data') ) {
		$$('.controllo_data').each(function(d,i){
			d.addEvent('change',function(e){	  
				var data = d.get('value');
				var patt1 = /^(19|20)\d\d[- /.](0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])$/ ;
				
				if(!data.match(patt1)){
					msg = 'Errore inserimento data. Unico formato ammesso aaaa/mm/gg oppure aaaa-mm-gg.' ;
					alert(msg);
					e.stop() ;
				}
			});
		});
	}

// controllo che il valore sia numerico
	if ( $$('.num') ) {
		$$('.num').each(function(d,i){
			d.addEvent('change',function(e){	  
				var num = d.get('value');
				var patt1 = /^\b[0-9]{1,5}\b$/ ;
				
				if(!num.match(patt1)){
					msg = 'Errore inserimento dato. Unico formato ammesso è numerico.'  ;
					alert(msg);
					e.stop() ;
				}
			});
		});
	}

	// controllo che il formato come una percentuale con un decimale
	if ( $$('.perc') ) {
		$$('.perc').each(function(d,i){
			d.addEvent('change',function(e){	  
				var perc = d.get('value');
				var patt1 = /^100$|^[0-9]{0,2}(\,[0-9]{1})?$/ ;
// 				/^100$|^\s*(\d{0,2})((\.|\,)(\d*))?\s*\%?\s*$/
				
				if(!perc.match(patt1)){
					msg = 'Errore inserimento dato. Unico formato ammesso è percentuale con una cifra decimale (xx,x).' ;
					alert(msg);
					e.stop() ;
				}
			});
		});
	}
// controllo che il formato come una percentuale con un decimale con il punto
	if ( $$('.perc2') ) {
		$$('.perc2').each(function(d,i){
			d.addEvent('change',function(e){	  
				var perc = d.get('value');
				var patt1 = /^100$|^[0-9]{0,2}(\.[0-9]{1})?$/ ;				
				if(!perc.match(patt1)){
					msg = 'Errore inserimento dato. Unico formato ammesso è percentuale con una cifra decimale (xx.x).' ;
					alert(msg);
					e.stop() ;
				}
			});
		});
	}
// controllo che il formato come un decimale con un decimale	
		if ( $$('.num_dec1') ) {
		$$('.num_dec1').each(function(d,i){
// 		  if ( !isNaN( d.get('value') ) ){
			d.addEvent('change',function(e){	  
				var num = d.get('value');
				var patt1 = /^\d+(\,\d{1,2})?$/  ;
				
				if(!num.match(patt1)){
					msg = 'Errore inserimento dato. Unici formati ammessi sono intero o decimale (xxx,xx).'  ;
					alert(msg);
					e.stop() ;
				}
			});
// 		  }
		});
	}
	// controllo che il formato come un decimale con un decimale	
		if ( $$('.num_dec2') ) {
		$$('.num_dec2').each(function(d,i){
			d.addEvent('change',function(e){	  
				var num = d.get('value');
				var patt1 = /^\d+(\.\d{1,2})?$/  ;
				
				if(!num.match(patt1)){
					msg = 'Errore inserimento dato. Unici formati ammessi sono intero o decimale (xxx.xx).'  ;
					alert(msg);
					e.stop() ;
				}
			});
// 		  }
		});
	}
	// controllo che il formato come anno	
		if ( $$('.anno') ) {
		$$('.anno').each(function(d,i){
// 		  if ( !isNaN( d.get('value') ) ){
			d.addEvent('change',function(e){	  
				var num = d.get('value');
				var patt1 = /^(19|20)\d\d$/  ;
				
				if(!num.match(patt1)){
					msg = 'Errore inserimento dato. Unico formato ammesso è del tipo anno (dal 1900 al 2099).'  ;
					alert(msg);
					e.stop() ;
				}
			});
// 		  }
		});
	}
//	-------------------------------------------
// 	in descrp.php
// 	-------------------------------------------
// creo l'opzione di poter inserire una nuova particella in descrp.php e di fare il submit outomatico
//della select "$('descrp_select')" solo nei casi in cui non ci sia da creare una nuova scheda.
	if( $('descrp_select') ) {
		var sel = $('descrp_select') ;
		sel.addEvent('change',function(e){
			var id = sel.get('value') ;
			//if( id == '-1' ) e.stop() ;
			if( id == '-2' ) {
				var query = new Element('input') ;
				    query.set('id','descrp_input') ;
				    query.set('name','particella') ;
				    query.setStyle('width',sel.getStyle('width'));
				var hid = new Element('input') ;
				    hid.set('type','hidden') ;
				    hid.set('name','new') ;
				var ret = new Element('a') ;
				    ret.setStyle('display','inline') ;
				    ret.set('html','ritorna') ;
				    ret.addEvent('click',function(e){
					  sel.setStyle('display','inline') ;
					  sel.set('disabled',false) ;
					  /*
					  query.setStyle('display','none') ;
					  query.set('disabled',true) ;
					  ret.setStyle('display','none') ;
					  hid.set('disabled',true);
					  */
					  query.destroy();
					  ret.destroy();
					  hid.destroy();
				    });
				query.inject(sel,'after');
				ret.inject(query,'after');
				hid.inject(query,'after');
				sel.setStyle('display','none') ;
				sel.set('disabled',true) ;
			}
			else 	$('particelle_form').submit();
		});
	}
// funzione per allineare il codice della particella nella descrizione forestale, quando si inserisce una nuova particella
	
if ($('particelle_form')) {
$('particelle_form').addEvent('submit',function(e){
	if ($('descrp_input')){
		var a = $('descrp_input');
		a.set('value',a.get('value').replace(/\s+/g,''));
		var cod_part = a.get('value'); // ES: 13_R
		
		var valid = /^[0-9a-zA-Z]{0,5}$/;
		if( !cod_part.match(valid) ) {
			msg = 'Errore inserimento particella. Unico formato ammesso quattro numeri e (opzionale) un carattere (es: 1111a).' ;
			alert(msg);
			e.stop();
		}
		else {
			var patt1 = /^[0-9a-zA-Z]{0,4}[a-zA-Z]{0,1}$/ ; // 4 valori di cifre e caratteri, l'ultimo solo carattere 	
			if(cod_part.match(patt1)){
				var lunghezza = cod_part.length;  //lunghezza totale della stringa senza spazzi ES: length(13R)=3
				var ultimo = cod_part.charAt(lunghezza-1);  //l'ultimo carattere o numero della stringa ES: ultimo(13R)=R	
				if ( ultimo.match(/^\d$/)){ // se è un numero voglio la stringa da 4 posti + 1 spazio
					var spazi = "    "; // 4 spazi
					var spazi_new = spazi.slice(lunghezza); // Es: slice(2) = "  "
					var cod_part_temp = spazi_new.concat(cod_part," ");
				} else {
					var  spazi = "     ";//ES: R --> 5 posti
					var spazi_new = spazi.slice(lunghezza); // Es: slice(2) = "  "
					var cod_part_temp = spazi_new.concat(cod_part); // ES: 5-3 = 2
				}
				a.set('value', cod_part_temp ) ;
			}
			else {
				msg = 'Errore inserimento particella. Non posso riordinare il valore.' ;
				alert(msg);
				e.stop();
			}		
		}
	}	
});
}

	// questa classe permette di chiedere la conferma della creazione della SCHEDA A
	$$('.conferma').each( function(a){
		a.addEvent('click',function(e){
			var ttl = a.get('title') ;
			var msg = '' ;
			
			// funzione per fare l'alert quando si sceglie di visualizzare una scheda B che non è quella giusta.		
			if( a.hasClass('schedaA') ) {
				//var particella = $('descrp_select').getElements(':enabled') ;
				if( !$('proprieta_select').disabled ) {
				var proprieta = $('proprieta_select').get('value');
				if(proprieta == '-1'){
						msg = 'Non è stato selezionato nessun bosco.' ;
						alert(msg);
						e.stop() ;
					}
				}
				if( !$('descrp_select').disabled ) {
				var particella = $('descrp_select').get('value') ;
					if(particella == '-1'){
						msg = 'Non è stata selezionata alcuna particella per la '+ttl+'!' ;
						alert(msg);
						e.stop() ;
					}
				}
			}	
		});
	});

//    per descrp_schedeA.php, alert di conferma prima che vengano eseguite le query di Modifica o Cancellazione
	$$('.ModDell').each( function(a){
		a.addEvent('click',function(e){
			var ttl = a.get('title') ;
			var msg = '' ;
			
			if( a.hasClass('confermaDELL') ) 	msg = 'sei sicuro di voler cancellare '+ttl+'?' ;
			else if( a.hasClass('confermaMOD') ) 	msg = 'sei sicuro di voler modificare '+ttl+'?' ;
			
			if( !confirm(msg) ) e.stop() ;
		});
	});
	
//	-------------------------------------------
// 	in descrp_schedeA.php
// 	-------------------------------------------

	// 	controllo prima di aver inserito la superficie totale della particella, e poi assegno i valori a 
// 	bosc = sup_tot-improd-p_n_bosc
// 	improd =  i1, oppure = i22*sup_tot/100
// 	p_n_bosc = i21, oppure = i22*sup_tot/100
	if (  $('sup_tot') && $('sup_tot').get('value')  != ''){
		$('sup_tot').addEvent('change',function(e){
			var sup_tot =  $('sup_tot').get('value');
			if ( $('i1') && !isNaN( $('i1').get('value') ) ) {
				var i1 = $('i1').get('value');
				$('improd').set('value', i1 ) ;
			}
			if ( $('i21') && !isNaN( $('i21').get('value') ) ) {
				var i21 = $('i21').get('value');
				$('p_n_bosc').set('value', i21 ) ;
			}
			var improd = $('improd').get('value');
			var p_n_bosc = $('p_n_bosc').get('value');
			var bosc = sup_tot - improd - p_n_bosc;
			$('bosc').set('value', bosc ) ;	
		});
	} 
	

// 	controllo che i valori di ACCESSIBILITà, v3 e v1, (che sono delle percentuali) siano complementari a cento
	if ( $('v1') && !isNaN($('v1').get('value')) ){ // se esiste v1 ed è un numero, allora...
		$('v1').addEvent('change',function(e){
			var v1 = $('v1').get('value');
			var v3 = 100 - v1;
			$('v3').set('value', v3) ;
		});
	}
	if ( $('v3') && !isNaN( $('v3').get('value') ) ){
		$('v3').addEvent('change',function(e){
			var v3 = $('v3').get('value');
			var v1 = 100 - v3;
			$('v1').set('value', v1) ;
		});
	}
	
// 	controllo prima di aver inserito la superficie totale della particella, e poi che i valori di IMPRODUTTIVO INCLUSO IN CARTOGRAFIA, i1 e i2 (che è una percentuale), siano corrispondenti l'uno all'altro (uno in valore ha e l'altro in % sul totale)
	if ( $('sup_tot') && !isNaN($('sup_tot').get('value')) ){
		if ( ( $('i1') && !isNaN($('i1').get('value')) ) || ( $('i2') && !isNaN($('i2').get('value')) ) ){
			$('i1').addEvent('change',function(e){
				var i1 = $('i1').get('value');
				var sup_tot =  $('sup_tot').get('value');
				var i2 = i1 / sup_tot * 100;
				$('i2').set('value', ( roundTo(i2, 2) ) ) ;
			});
			$('i2').addEvent('change',function(e){
				var i2 = $('i2').get('value');
				var sup_tot =  $('sup_tot').get('value');
				var i1 = i2 * sup_tot / 100;
				$('i1').set('value', ( Math.round(i1) ) ) ;
			});
		} else { 
			$('i1').set('value', 0) ;
			$('i2').set('value', 0) ;	
		}
	} 
// 	controllo prima di aver inserito la superficie totale della particella, e poi che i valori dei PRODUTTIVI NON BOSCATI INCLUSI NON CARTOGRAFATI, i21 e i22 (che è una percentuale), siano corrispondenti l'uno all'altro (uno in valore ha e l'altro in % sul totale)
	if ( $('sup_tot') && !isNaN($('sup_tot').get('value')) ){
		if ( ( ('i21') && !isNaN($('i21').get('value')) ) || ( $('i22') && !isNaN($('i22').get('value')) ) ){
			$('i21').addEvent('change',function(e){
				var i21 = $('i21').get('value');
				var sup_tot =  $('sup_tot').get('value');
				var i22 = i21 / sup_tot * 100;
				$('i22').set('value', ( roundTo(i22, 2) ) ) ;
			});
			$('i22').addEvent('change',function(e){
				var i22 = $('i22').get('value');
				var sup_tot =  $('sup_tot').get('value');
				var i21 = i22 * sup_tot / 100;
				$('i21').set('value', ( Math.round(i21) ) ) ;
			});
		}else { 
			$('i21').set('value', 0) ;
			$('i22').set('value', 0) ;
		}
	} 
	
	$$('.delete_noteA').each( function(a){
		a.addEvent('click',function(e){
			var ttl = a.get('title') ;
			var msg = '' ;
			
			msg = 'sei sicuro di voler eliminare la nota '+ttl+'?' ;
			
			if( !confirm(msg) ) e.stop() ;
		});
	});

//	-------------------------------------------
// 	in per tutte le descrp_schedeXX.php
// 	-------------------------------------------

// delete_arboreeB1, delete_arbuB1, delete_erbaB1, delete_specieB1
// delete_arboreeB2, delete_arbuB2, delete_erbaB2
//
	$$('.delete_confirm').each( function(a){
		a.addEvent('click',function(e){
			var ttl = a.get('title') ;
			var msg = '' ;
			
			msg = 'Sei sicuro di voler eliminare la specie '+ttl+'?' ;
			
			if( !confirm(msg) ) e.stop() ;
		});
	});

	
	//	-------------------------------------------
// 	in descrp_schedeB2.php
// 	-------------------------------------------

//  Per rendere editabile solo il blocco di dati relativi al tipo: 1)arboricoltura, 2)impianti, 3)castagno, 4)sugherete;
	var opt_disabler = function( pos ){
		var value=['10', '2', '11', '12' ];
	    for (i in value) {
			var state = true ; // disabled
			if(value[i] == pos ) state = false ; // enabled
			var div = $('opt'+value[i]+'_fields');			
			div.getElements('select , input').each(function(el,j){
			    el.disabled = state ;
			});
// 		if (state)	div.getElement('div').setStyle('background', 'grey');
	    }
	};

	  if($('opt10'))
	      $('opt10').addEvent('click',function(e){
		  opt_disabler('10');
	      });

	  if($('opt2'))
	      $('opt2').addEvent('click',function(e){
		  opt_disabler('2');
	      });
	  if($('opt11'))
	      $('opt11').addEvent('click',function(e){
		  opt_disabler('11');
	      });

	  if($('opt12'))
	      $('opt12').addEvent('click',function(e){
		  opt_disabler('12');
	      });

	  
	  
/*$$('*:enabled'); //all the enabled inputs

$(document.body).getElements(':enabled');

$('myElement').getElements(':enabled'); //only the enabled inputs inside #myElement */	
});


