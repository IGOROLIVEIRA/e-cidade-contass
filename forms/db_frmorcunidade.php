<?
//MODULO: orcamento
$clorcunidade->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o40_descr");
$clrotulo->label("o40_descr");
$clrotulo->label("o40_descr");
$clrotulo->label("o40_descr");

/*$z01_nomeorddespesa = '';
$z01_nomeordliquidacao = '';
$z01_nomeordpagamento = '';
*/
//echo $z01_nomeorddespesa."<br>".$z01_nome;exit;

$db_opcaoinstit = $db_opcao;

?>
<form name="form1" method="post" action="">
<center>
<table>
<tr>
<td>
<fieldset><legend><b>Cadastro de Unidades</b></legend>
<table border="0">
  <tr>
    <td nowrap >
     <?=$Lo41_anousu?>
    </td>
    <td>
<?
  if (!isset($o41_anousu)) {
    $o41_anousu = db_getsession('DB_anousu');
	}
  db_input('o41_anousu',5,$Io41_anousu,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_orgao?>">
       <?
       db_ancora(@$Lo41_orgao,"js_pesquisao41_orgao(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('o41_orgao',5,$Io41_orgao,true,'text',$db_opcao," onchange='js_pesquisao41_orgao(false);'")
?>
       <?
db_input('o40_descr',50,$Io40_descr,true,'text',3,'');
       ?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$To41_unidade?>">
       <?=@$Lo41_unidade?>
    </td>
    <td>
    <?
      db_input('o41_unidade',5,$Io41_unidade,true,'text',$db_opcao,"")
    ?>
    </td>
  </tr>

  <tr>
    <td nowrap title="Instituição ">
		  <b>Instituição:</b>
    </td>
    <td>
    <?
		 // busca a instituicao da prefeitura
		 $rsI = pg_query(" select codigo as iprefeitura from db_config where prefeitura is true ");
		 db_fieldsmemory($rsI,0);

     if(isset($o41_instit) && $o41_instit != ''){
	     $o41_institant = $o41_instit;
		 }
		 $sqlInstit       = "select codigo,nomeinst from db_config ";
     $rsInstit        = pg_query($sqlInstit);
     $intInstit       = pg_numrows($rsInstit);
     $arraycadtipo[0] = 'Selecione a Instituição';
     for($i = 0; $i < $intInstit; $i++){
       db_fieldsmemory($rsInstit,$i);
       $arraycadtipo[$codigo] = $nomeinst;
     }

     if(isset($o41_institant) && $o41_institant != ''){ // se ja existe a instituicao para o registro
	     $o41_instit = $o41_institant;
		 }else if ((int)$iprefeitura == (int)db_getsession('DB_instit') ) { // se nao existe e a instituicao e prefeitura
  		 $o41_instit = $iprefeitura;
		 }else{                                            // se nao existe para o registro, nao esta logado na prefeitura, desabilida e deixa selecionado a instituicao atual
  		 $o41_instit = db_getsession('DB_instit');
			 $db_opcaoinstit = 3;
		 }

     db_select("o41_instit",$arraycadtipo,true,$db_opcaoinstit,"");

    ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_codtri?>">
       <?=@$Lo41_codtri?>
    </td>
    <td>
<?
db_input('o41_codtri',5,$Io41_codtri,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_descr?>">
       <?=@$Lo41_descr?>
    </td>
    <td>
<?
db_input('o41_descr',50,$Io41_descr,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_indent?>">
       <?=@$Lo41_indent?>
    </td>
    <td>
<?
db_input('o41_indent',15,$Io41_indent,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_cnpj?>">
       <?=@$Lo41_cnpj?>
    </td>
    <td>
<?
db_input('o41_cnpj',15,$Io41_cnpj,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_ident?>">
       <?=@$Lo41_ident?>
    </td>
    <td>
<?
$x = array('01'=>'Prefeitura Municipal','02'=>'Câmara Municipal','03'=>'Secretaria da Educação','04'=>'Secretaria da Saúde','05'=>'RPPS (Exceto Autarquia)','06'=>'Autarquia (Exceto RPPS)','07'=>'Autarquia (RPPS)','08'=>'Fundação','09'=>'Empresa Estatal Dependente','10'=>'Empresa Estatal não Dependente','11'=>'Consórcio','12'=>'Outras',
'901'=>'MG - FUNDEB','902'=>'MG - FMS - Fundo Municipal de Saúde','903'=>'MG - FMAS - Fundo Municipal de Assistência Social','904'=>'MG - FMCA - Fundo Municipal da Criança e do Adolescente','999'=>'MG - Outros Fundos');
db_select('o41_ident',$x,true,$db_opcao,"");
?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$To41_orddespesa?>">
       <?
       db_ancora(@$Lo41_orddespesa,"js_pesquisao41_orddespesa(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('o41_orddespesa',11,$Io41_orddespesa,true,'text',$db_opcao," onchange='js_pesquisao41_orddespesa(false);'")
?>
       <?
db_input('z01_nomeorddespesa',40,$Iz01_nomeorddespesa,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_ordliquidacao?>">
       <?
       db_ancora(@$Lo41_ordliquidacao,"js_pesquisao41_ordliquidacao(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('o41_ordliquidacao',11,$Io41_ordliquidacao,true,'text',$db_opcao," onchange='js_pesquisao41_ordliquidacao(false);'")
?>
       <?
db_input('z01_nomeordliquidacao',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To41_ordpagamento?>">
       <?
       db_ancora(@$Lo41_ordpagamento,"js_pesquisao41_ordpagamento(true);",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('o41_ordpagamento',11,$Io41_ordpagamento,true,'text',$db_opcao," onchange='js_pesquisao41_ordpagamento(false);'")
?>
       <?
db_input('z01_nomeordpagamento',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$To41_subunidade?>">
       <?=@$Lo41_subunidade?>
    </td>
    <td>
<?
db_input('o41_subunidade',11,$Io41_subunidade,true,'text',$db_opcao,"")
?>
    </td>
  </tr>

  </table>
    </fieldset>
  </td>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisao41_anousu(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_anousu|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o41_anousu.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o41_anousu.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o41_anousu.focus();
    document.form1.o41_anousu.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o41_anousu.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisao41_anousu(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_orgao|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o41_anousu.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o41_anousu.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o41_anousu.focus();
    document.form1.o41_anousu.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o41_anousu.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisao41_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_anousu|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o41_orgao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o41_orgao.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o41_orgao.focus();
    document.form1.o41_orgao.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o41_orgao.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisao41_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_orgao|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o41_orgao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o41_orgao.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o41_orgao.focus();
    document.form1.o41_orgao.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o41_orgao.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_preenchepesquisa|o41_anousu|o41_orgao|o41_unidade','Pesquisa',true);
}
function js_preenchepesquisa(chave,chave1,chave2){
  db_iframe_orcunidade.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave+'&chavepesquisa1='+chave1+'&chavepesquisa2='+chave2";
  }
  ?>
}

function js_pesquisao41_orddespesa(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm_orddespesa','func_cgm.php?funcao_js=parent.js_mostracgmorddespesa1|z01_numcgm|z01_nome','Pesquisa',true);
	  }else{
	     if(document.form1.o41_orddespesa.value != ''){
	        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm_orddespesa','func_cgm.php?pesquisa_chave='+document.form1.o41_orddespesa.value+'&funcao_js=parent.js_mostracgmorddespesa','Pesquisa',false);
	     }else{
	       document.form1.z01_nomeorddespesa.value = '';
	     }
	  }
	}
	function js_mostracgmorddespesa(erro,chave){
	  document.form1.z01_nomeorddespesa.value = chave;
	  if(erro==true){
	    document.form1.o41_orddespesa.focus();
	    document.form1.o41_orddespesa.value = '';
	  }
	}
	function js_mostracgmorddespesa1(chave1,chave2){
	  document.form1.o41_orddespesa.value = chave1;
	  document.form1.z01_nomeorddespesa.value = chave2;
	  db_iframe_cgm.hide();
	}

	function js_pesquisao41_ordliquidacao(mostra){
		  if(mostra==true){
		    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm_ordliquidacao','func_cgm.php?funcao_js=parent.js_mostracgmordliquidacao1|z01_numcgm|z01_nome','Pesquisa',true);
		  }else{
		     if(document.form1.o41_ordliquidacao.value != ''){
		        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm_ordliquidacao','func_cgm.php?pesquisa_chave='+document.form1.o41_ordliquidacao.value+'&funcao_js=parent.js_mostracgmordliquidacao','Pesquisa',false);
		     }else{
		       document.form1.z01_nomeordliquidacao.value = '';
		     }
		  }
		}
		function js_mostracgmordliquidacao(erro,chave){
		  document.form1.z01_nomeordliquidacao.value = chave;
		  if(erro==true){
		    document.form1.o41_ordliquidacao.focus();
		    document.form1.o41_ordliquidacao.value = '';
		  }
		}
		function js_mostracgmordliquidacao1(chave1,chave2){
		  document.form1.o41_ordliquidacao.value = chave1;
		  document.form1.z01_nomeordliquidacao.value = chave2;
		  db_iframe_cgm.hide();
		}

		function js_pesquisao41_ordpagamento(mostra){
			  if(mostra==true){
			    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm_ordpagamento','func_cgm.php?funcao_js=parent.js_mostracgmordpagamento1|z01_numcgm|z01_nome','Pesquisa',true);
			  }else{
			     if(document.form1.o41_ordpagamento.value != ''){
			        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm_ordpagamento','func_cgm.php?pesquisa_chave='+document.form1.o41_ordpagamento.value+'&funcao_js=parent.js_mostracgmordpagamento','Pesquisa',false);
			     }else{
			       document.form1.z01_nomeordpagamento.value = '';
			     }
			  }
			}
			function js_mostracgmordpagamento(erro,chave){
			  document.form1.z01_nomeordpagamento.value = chave;
			  if(erro==true){
			    document.form1.o41_ordpagamento.focus();
			    document.form1.o41_ordpagamento.value = '';
			  }
			}
			function js_mostracgmordpagamento1(chave1,chave2){
			  document.form1.o41_ordpagamento.value = chave1;
			  document.form1.z01_nomeordpagamento.value = chave2;
			  db_iframe_cgm.hide();
			}
			js_pesquisao41_orddespesa();
			js_pesquisao41_ordliquidacao();
			js_pesquisao41_ordpagamento();
</script>
