<?
//MODULO: sicom
$clidentificacaoresponsaveis->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
$clrotulo->label("o40_descr");
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Identificação dos Resposáveis</legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi166_sequencial?>">
       <?=@$Lsi166_sequencial?>
    </td>
    <td> 
<?
db_input('si166_sequencial',11,$Isi166_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi166_numcgm?>">
       <?
       db_ancora(@$Lsi166_numcgm,"js_pesquisasi166_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('si166_numcgm',11,$Isi166_numcgm,true,'text',$db_opcao," onchange='js_pesquisasi166_numcgm(false);'")
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi166_tiporesponsavel?>">
       <?=@$Lsi166_tiporesponsavel?>
    </td>
    <td> 
<?
if(db_getsession("DB_modulo") != 952) {
    $x = array('1' => 'Gestor', '2' => 'Contador', '3' => 'Controle Interno', '4' => 'Ordenador de Despesa por Delegação');
}else{
    $x = array('5' => 'Responsável pelo envio');
}
db_select("si166_tiporesponsavel",$x,true,$db_opcao,"onchange='mostrar_campos()'");
//db_input('si166_tiporesponsavel',11,$Isi166_tiporesponsavel,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr id="orgao" style="visibility: hidden;">
    <td nowrap title="<?=@$Tsi166_orgao?>">
       <? db_ancora("<b>Orgão</b>","js_pesquisao41_orgao(true);", $db_opcao); ?>
    </td>
    <td> 
<?
db_input('si166_orgao',11,$Isi166_orgao,true,'text',$db_opcao,"onchange='js_pesquisao41_orgao(false)'");
db_input('o40_descr',40,$Io40_descr,true,'text',3,"");
?>
    </td>
  </tr>
  <tr id="cargoorddespesa" style="visibility: hidden;">
    <td nowrap title="<?=@$Tsi166_cargoorddespesa?>">
       <?=@$Lsi166_cargoorddespesa?>
    </td>
    <td> 
<?
db_input('si166_cargoorddespesa',50,$Isi166_cargoorddespesa,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr id="crccontador" style="visibility: hidden;">
    <td nowrap title="<?=@$Tsi166_crccontador?>">
       <?=@$Lsi166_crccontador?>
    </td>
    <td> 
<?
db_input('si166_crccontador',11,$Isi166_crccontador,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr id="ufcrccontador" style="visibility: hidden;">
    <td nowrap title="<?=@$Tsi166_ufcrccontador?>">
       <?=@$Lsi166_ufcrccontador?>
    </td>
    <td> 
<?
db_input('si166_ufcrccontador',2,$Isi166_ufcrccontador,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  
  <tr>
    <td nowrap title="<?=@$Tsi166_dataini?>">
       <?=@$Lsi166_dataini?>
    </td>
    <td> 
<?
db_inputdata('si166_dataini',@$si166_dataini_dia,@$si166_dataini_mes,@$si166_dataini_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi166_datafim?>">
       <?=@$Lsi166_datafim?>
    </td>
    <td> 
<?
db_inputdata('si166_datafim',@$si166_datafim_dia,@$si166_datafim_mes,@$si166_datafim_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>
  </fieldset>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>")?>
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisasi166_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.si166_numcgm.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.si166_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.si166_numcgm.focus(); 
    document.form1.si166_numcgm.value = ''; 
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.si166_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_identificacaoresponsaveis','func_identificacaoresponsaveis.php?funcao_js=parent.js_preenchepesquisa|si166_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_identificacaoresponsaveis.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_pesquisao41_orgao(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_orgao|o40_descr','Pesquisa',true,'0','1');
	  }else{
	     if(document.form1.si166_orgao.value != ''){
	        js_OpenJanelaIframe('','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.si166_orgao.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
	     }else{
	       document.form1.o40_descr.value = ''; 
	     }
	  }
	}
	function js_mostraorcorgao(chave,erro){
	  document.form1.o40_descr.value = chave; 
	  if(erro==true){ 
	    document.form1.si166_orgao.focus(); 
	    document.form1.si166_orgao.value = ''; 
	  }
	}
	function js_mostraorcorgao1(chave1,chave2){
	  document.form1.si166_orgao.value = chave1;
	  document.form1.o40_descr.value = chave2;
	  db_iframe_orcorgao.hide();
	}

	function mostrar_campos(){
	
		if (document.form1.si166_tiporesponsavel.value == 4) {	
			document.getElementById('orgao').style.visibility = "visible";
			document.getElementById('cargoorddespesa').style.visibility = "visible";	
		} else {

			document.getElementById('orgao').style.visibility = "hidden";
			document.getElementById('cargoorddespesa').style.visibility = "hidden";
		  document.form1.si166_orgao.value = "";
		  document.form1.o40_descr.value = "";
		  document.form1.si166_cargoorddespesa.value = "";   
			
		}
		
		if (document.form1.si166_tiporesponsavel.value == 2) {
			document.getElementById('crccontador').style.visibility = "visible";	
			document.getElementById('ufcrccontador').style.visibility = "visible";	
		} else {

			document.getElementById('crccontador').style.visibility = "hidden";	
			document.getElementById('ufcrccontador').style.visibility = "hidden";
		  document.form1.si166_crccontador.value = "";
		  document.form1.si166_ufcrccontador.value = "";   
			
		}
		
	}
	mostrar_campos();
	if (document.form1.si166_tiporesponsavel.value == 4) {
	  js_pesquisao41_orgao(false);
	}
</script>
