<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconsexecucaoorc->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o58_funcao");
$clrotulo->label("o58_subfuncao");
if(isset($db_opcaoal) && !isset($opcao) && !isset($excluir)){
   $db_opcao=33;
   $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else if (!isset($excluir)) {
	if (isset($alterar) && $sqlerro==true) {  
    $db_opcao = 2;
	} else {
		$db_opcao = 1;
	}
    $db_botao=true;
    if(isset($novo) || (isset($alterar) && $sqlerro==false) || (isset($incluir) && $sqlerro==false ) ){
     $c202_sequencial = "";
     //$c202_consconsorcios = "";
     $c202_mescompetencia = "";
     $c202_funcao = "";
     $c202_subfuncao = "";
     $c202_codfontrecursos = "";
     $c202_elemento = "";
     $c202_valorempenhado = "";
     $c202_valorempenhadoanu = "";
     $c202_valorliquidado = "";
     $c202_valorliquidadoanu = "";
     $c202_valorpago = "";
     $c202_valorpagoanu = "";
     $o52_descr = "";
     $o53_descr = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Execução Orçamentária da Despesa</legend>
<table border="0">
  <tr>
    <td nowrap title="<?//=@$Tc202_sequencial?>">
       <?//=@$Lc202_sequencial?>
    </td>
    <td> 
<?
db_input('c202_sequencial',10,$Ic202_sequencial,true,'hidden',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_consconsorcios?>">
       <?=@$Lc202_consconsorcios?>
    </td>
    <td> 
<?
db_input('c202_consconsorcios',10,$Ic202_consconsorcios,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_mescompetencia?>">
       <?=@$Lc202_mescompetencia?>
    </td>
    <td> 
<?
$x = array("1"=>"JANEIRO","2"=>"FEVEREIRO","3"=>"MARÇO","4"=>"ABRIL","5"=>"MAIO","6"=>"JUNHO","7"=>"JULHO","8"=>"AGOSTO","9"=>"SETRMBRO","10"=>"OUTUBRO","11"=>"NOVEMBRO","12"=>"DEZEMBRO");
db_select('c202_mescompetencia',$x,true,$db_opcao,"");
//db_input('c202_mescompetencia',10,$Ic202_mescompetencia,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
<tr>
    <td nowrap title="<?=@$To58_funcao?>">
       <?
       db_ancora(@$Lo58_funcao,"js_pesquisao58_funcao(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('c202_funcao',11,$Ic202_funcao,true,'text',$db_opcao," onchange='js_pesquisao58_funcao(false);'")
?>
       <?
db_input('o52_descr',55,$Io52_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
<tr>
    <td nowrap title="<?=@$To58_subfuncao?>">
       <?
       db_ancora(@$Lo58_subfuncao,"js_pesquisao58_subfuncao(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('c202_subfuncao',11,$Ic202_subfuncao,true,'text',$db_opcao," onchange='js_pesquisao58_subfuncao(false);'")
?>
       <?
db_input('o53_descr',55,$Io53_descr,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="Código da fonte de recursos">
       <b>Fonte de Recursos: </b>
    </td>
    <td> 
<?
db_input('c202_codfontrecursos',10,$Ic202_codfontrecursos,true,'text',$db_opcao,"","","","",3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_elemento?>">
       <?=@$Lc202_elemento?>
    </td>
    <td> 
<?
db_input('c202_elemento',10,$Ic202_elemento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_valorempenhado?>">
       <?=@$Lc202_valorempenhado?>
    </td>
    <td> 
<?
db_input('c202_valorempenhado',11,$Ic202_valorempenhado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_valorempenhadoanu?>">
       <?=@$Lc202_valorempenhadoanu?>
    </td>
    <td> 
<?
db_input('c202_valorempenhadoanu',11,$Ic202_valorempenhadoanu,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_valorliquidado?>">
       <?=@$Lc202_valorliquidado?>
    </td>
    <td> 
<?
db_input('c202_valorliquidado',11,$Ic202_valorliquidado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_valorliquidadoanu?>">
       <?=@$Lc202_valorliquidadoanu?>
    </td>
    <td> 
<?
db_input('c202_valorliquidadoanu',11,$Ic202_valorliquidadoanu,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_valorpago?>">
       <?=@$Lc202_valorpago?>
    </td>
    <td> 
<?
db_input('c202_valorpago',11,$Ic202_valorpago,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc202_valorpagoanu?>">
       <?=@$Lc202_valorpagoanu?>
    </td>
    <td> 
<?
db_input('c202_valorpagoanu',11,$Ic202_valorpagoanu,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">  
    <?
	 $chavepri= array("c202_sequencial"=>@$c202_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clconsexecucaoorc->sql_query_file(null,"*","c202_mescompetencia,c202_funcao,c202_subfuncao,c202_elemento","c202_consconsorcios=$c202_consconsorcios and c202_anousu = ".db_getsession("DB_anousu"));
	 $cliframe_alterar_excluir->campos  ="c202_sequencial,c202_consconsorcios,c202_mescompetencia,c202_funcao,c202_subfuncao,c202_elemento,c202_valorempenhado,c202_valorempenhadoanu,c202_valorliquidado,c202_valorpago,c202_valorpagoanu";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir(1);
    ?>
    </td>
   </tr>
 </table>
 </fieldset>
  </center>
</form>
<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.c202_codfontrecursos.value = null;
  document.form1.appendChild(opcao);
  document.form1.submit();
}

function js_pesquisao58_funcao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_orcfuncao','func_orcfuncao.php?funcao_js=parent.js_mostraorcfuncao1|o52_funcao|o52_descr','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_orcfuncao','func_orcfuncao.php?pesquisa_chave='+document.form1.c202_funcao.value+'&funcao_js=parent.js_mostraorcfuncao','Pesquisa',false);
  }
}
function js_mostraorcfuncao(chave,erro){
  document.form1.o52_descr.value = chave; 
  if(erro==true){ 
    document.form1.c202_funcao.focus(); 
    document.form1.c202_funcao.value = ''; 
  }
}
function js_mostraorcfuncao1(chave1,chave2){
  document.form1.c202_funcao.value = chave1;
  document.form1.o52_descr.value = chave2;
  db_iframe_orcfuncao.hide();
}

function js_pesquisao58_subfuncao(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_orcsubfuncao','func_orcsubfuncao.php?funcao_js=parent.js_mostraorcsubfuncao1|o53_subfuncao|o53_descr','Pesquisa',true);
	  }else{
	    js_OpenJanelaIframe('','db_iframe_orcsubfuncao','func_orcsubfuncao.php?pesquisa_chave='+document.form1.c202_subfuncao.value+'&funcao_js=parent.js_mostraorcsubfuncao','Pesquisa',false);
	  }
	}
	function js_mostraorcsubfuncao(chave,erro){
	  document.form1.o53_descr.value = chave; 
	  if(erro==true){ 
	    document.form1.c202_subfuncao.focus(); 
				document.form1.c202_subfuncao.value = ''; 
	  }
	}
	function js_mostraorcsubfuncao1(chave1,chave2){
	  document.form1.c202_subfuncao.value = chave1;
	  document.form1.o53_descr.value = chave2;
	  db_iframe_orcsubfuncao.hide();
	}

</script>
