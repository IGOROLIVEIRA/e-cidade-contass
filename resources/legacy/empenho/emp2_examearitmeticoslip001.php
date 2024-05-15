<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_orctiporec_classe.php");
include("dbforms/db_classesgenericas.php");
$aux_conta	 = new cl_arquivo_auxiliar;
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

<style type="text/css">
    #MesReferencia, #ExibirHistoricoDoEmpenho, #ordenar, #iTipo, #iRestosPagar {
        width: 100px;
    }
</style>
<link href="estilos.css" rel="stylesheet" type="text/css">

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="adiciona_recurso()">
<table valign="top" marginwidth="0" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td align="center" valign="top"> 
      <form name='form1'>
        <fieldset>
          <legend><b>Exame Aritmético</b></legend>
          <table>
           	<tr>
          	 <td><b>Mês Referência: </b></td>
          	 <td>
          	 <select id="MesReferencia" name="MesReferencia" >
          	  <option value="01">Janeiro</option>
          	  <option value="02">Fevereiro</option>
          	  <option value="03">Março</option>
          	  <option value="04">Abril</option>
          	  <option value="05">Maio</option>
          	  <option value="06">Junho</option>
          	  <option value="07">Julho</option>
          	  <option value="08">Agosto</option>
          	  <option value="09">Setembro</option>
          	  <option value="10">Outubro</option>
          	  <option value="11">Novembro</option>
          	  <option value="12">Dezembro</option>
          	 </select>
          	 </td>
          	</tr>
          	
          	<tr>
             <td><strong>Filtrar por:</strong></td>
             <td>
             <select name="ordenar" id="ordenar" onchange="mostra_campo()" >
  	          <option value="1" id="1" >Conta</option>
  	          <option value="2" id="2" >Recurso</option>
             </select>
             </td>
            </tr>
			<tr>
                <td>
                    <strong>Tipo:</strong>
                </td>
                <td>
					<select name="iTipo" id="iTipo">
                        <option value="">Todos</option>
                        <option value="1">Saúde 15%</option>
                        <option value="9">Vinculados à Saúde</option>
                        <option value="2">Educação 25%</option>
                        <option value="11">Vinculados à Educação</option>                        
                        <option value="5">Fundeb 70%</option>
                        <option value="6">Fundeb 30%</option>
                        <option value="8">Cide</option>
                        <option value="7">Multas de Transito</option>
                        <option value="10">Vinculados à Assistencia</option>
                        <option value="4">Geral</option>
                    </select>
                </td>
            </tr>
            
            <tr id="tb_recurso" style="visibility: hidden;">
								
								<td align="left" nowrap>	
								<?
								      $oFiltroRecursos = new cl_arquivo_auxiliar;
									  $oFiltroRecursos->cabecalho            = "<strong>Recursos</strong>";
									  $oFiltroRecursos->codigo               = "o15_codigo";
									  $oFiltroRecursos->descr                = "o15_descr";
									  $oFiltroRecursos->nomeobjeto           = 'recursos';
									  $oFiltroRecursos->funcao_js            = 'js_mostraRecurso';
									  $oFiltroRecursos->funcao_js_hide       = 'js_mostraRecursoHide';
									  $oFiltroRecursos->func_arquivo         = "func_orctiporec.php";
									  $oFiltroRecursos->nomeiframe           = "db_iframe_orctiporec";
									  $oFiltroRecursos->vwidth 				 = 400;
									  $oFiltroRecursos->db_opcao             = 2;
									  $oFiltroRecursos->tipo                 = 2;
									  $oFiltroRecursos->top 				 = 0;
									  $oFiltroRecursos->linhas 				 = 5;
									  $oFiltroRecursos->nome_botao           = 'lancarRecurso';
									  $oFiltroRecursos->lFuncaoPersonalizada = true;
									  $oFiltroRecursos->obrigarselecao       = false;
									  $oFiltroRecursos->localjan			 = '';
									  $oFiltroRecursos->funcao_gera_formulario();
									  echo "<script> document.getElementById(\"fieldset_recursos\").style.display = \"none\"; </script>";
							    ?>
								<!--   align="left" nowrap><?
								/*$dbwhere = " o15_datalimite is null or o15_datalimite > '".date('Y-m-d',db_getsession('DB_datausu'))."'";
								$clorctiporec = new cl_orctiporec;
								$result = $clorctiporec->sql_record($clorctiporec->sql_query(null,"*","o15_codigo",$dbwhere));
								db_selectrecord("o15_codigo",$result,true,2,"","","");
								*/?>-->
								
								</td>
						</tr>
            
						<tr id="tb_conta" style="visibility: hidden;">
									<td colspan=2><?
									// $aux = new cl_arquivo_auxiliar;
									$aux_conta->cabecalho = "<strong>Contas</strong>";
									$aux_conta->codigo = "k13_conta"; //chave de retorno da func
									$aux_conta->descr  = "k13_descr";   //chave de retorno
									$aux_conta->nomeobjeto = 'contas';
									$aux_conta->funcao_js = 'js_mostra_contas';
									$aux_conta->funcao_js_hide = 'js_mostra_contas1';
									$aux_conta->sql_exec  = "";
									$aux_conta->func_arquivo = "func_saltes.php";  //func a executar
									$aux_conta->nomeiframe = "db_iframe_saltes";
									$aux_conta->localjan = "";
									$aux_conta->onclick = "";
									$aux_conta->db_opcao = 2;
									$aux_conta->tipo = 2;
									$aux_conta->top = 0;
									$aux_conta->linhas = 5;
									$aux_conta->vwhidth = 400;
									$aux_conta->nome_botao = 'db_lanca_conta';
									$aux_conta->funcao_gera_formulario();
									?>
									</td>
						</tr>
        
             
            
            
          	
          </table>
        </fieldset>
      </form>
    </td>
  </tr>
  <tr>
    <td align='center'>
      <input name='pesquisar' type='button' value='Consultar' onclick='js_abre();'>      
    </td>
  </tr>
</table>

</body>
</html>
<script>

function js_abre(){

	   obj = document.form1;
	   var query = "";
	   
	   if(document.getElementById('contas')){
			//Le os itens lançados na combo da conta
				vir="";
				listacontas="";
				 
				for(x=0;x<document.form1.contas.length;x++){
					listacontas+=vir+document.form1.contas.options[x].value;
				  vir=",";
				}
				if(listacontas!=""){ 	
					query +='conta=('+listacontas+')';
				} else {
					query +='conta=';
				}
			}
	   
	   query += "&MesReferencia="+obj.MesReferencia.value;
	   query += "&ordenar="+obj.ordenar.value;
	   query += "&iTipo="+obj.iTipo.value;
			
	   query += "&recursos="+js_campo_recebe_valores_recursos ();
	   
	   jan = window.open('emp2_examearitmeticoslip002.php?'+query,
	                 '',
	                   'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	   jan.moveTo(0,0);
	  
	}

function adiciona_recurso() {

	document.getElementById("o15_codigo").options[document.getElementById("o15_codigo").options.length] = new Option("0", "0");
	document.getElementById("o15_codigodescr").options[document.getElementById("o15_codigodescr").options.length] = new Option("TODOS", "0");
	document.getElementById("o15_codigo").options[document.getElementById("o15_codigo").options.length].selected = "true";
	document.getElementById("o15_codigodescr").options[document.getElementById("o15_codigodescr").options.length].selected = "true";
	
}
function mostra_campo() {
  
  if (document.getElementById("ordenar").selectedIndex == 0) {
	  
	  document.getElementById("fieldset_recursos").style.display = "none";
	  document.getElementById("fieldset_contas").style.display = "inline";
	 
	} else {

	  document.getElementById("fieldset_recursos").style.display = "inline";
	  document.getElementById("fieldset_contas").style.display	 = "none";
  }


}

function js_pesquisak13_conta(mostra){
	  if(mostra==true){
	    js_OpenJanelaIframe('','db_iframe_saltes','func_saltes.php?funcao_js=parent.js_mostrasaltes1|k13_conta|k13_descr','Pesquisa',true);
	  }else{
	     if(document.form1.k13_conta.value != ''){ 
	       js_OpenJanelaIframe('','db_iframe_saltes','func_saltes.php?pesquisa_chave='+document.form1.k13_conta.value+'&funcao_js=parent.js_mostrasaltes','Pesquisa',false);
	     }else{
	       document.form1.k13_conta.value = ''; 
	     }
	  }
	}
	function js_mostrasaltes(chave,erro){
	  document.form1.k13_descr.value = chave; 
	  if(erro==true){ 
	    document.form1.k13_conta.focus(); 
	    document.form1.k13_conta = ''; 
	  }
	}
	function js_mostrasaltes1(chave1,chave2){
	  document.form1.k13_conta.value = chave1;
	  document.form1.k13_descr.value = chave2;
	  db_iframe_saltes.hide();
	}

</script>