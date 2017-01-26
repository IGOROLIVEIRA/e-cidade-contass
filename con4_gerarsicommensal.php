<?php
/**
 *
 * @author I
 * @revision $Author: dbrobson $
 * @version $Revision: 1.10 $
 */
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("o124_descricao");
$clrotulo->label("o124_sequencial");
$clrotulo->label("o15_descr");
$clrotulo->label("o15_codigo");
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript"
  src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/strings.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript"
  src="scripts/widgets/dbmessageBoard.widget.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="#cccccc" style="margin-top: 25px;">
  <center>


    <form name="form1" method="post" action="">
      <div style="display: table">
        <fieldset>
          <legend>
            <b>Gerar SICOM - Arquivos de Acompanhamento Mensal</b>
          </legend>
          <table style='empty-cells: show; border-collapse: collapse;'>
          <tr>
          <td colspan="4">
          	<fieldset>
          	<table>
          	<tr>
          	 <td>M�s Refer�ncia: 
          	 <select id="MesReferencia" class="MesReferencia" onchange="js_mostrameta(this.value)">
          	  <option value="01">Janeiro</option>
          	  <option value="02">Fevereiro</option>
          	  <option value="03">Mar�o</option>
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
            <tr id="meta" style="display: none">
              <td><?
              db_ancora("<b>Perspectiva PPA:</b>","js_pesquisa_ppa(true);", 1);
              ?>
              </td>
              <td><?
              db_input('o119_sequencial',10,$Io124_sequencial,true,'text',
              1," onchange='js_pesquisa_ppa(false);'");
              db_input('o119_descricao',40,$Io124_descricao,true,'text',3,'')
               ?>
              </td>
            </tr>
          	</table>
          	</fieldset>
          	</td>
          	</tr>
            <tr>
              <td colspan="2" align="center">Dados Mensais</td>
              <td>Inclus�o de Programas</td>
              <td>Arquivos Gerados</td>
            </tr>
            <tr>
              <td style="border: 2px groove white;" valign="top">
              <input type="checkbox" value="IdentificacaoRemessa" id="IdenficacaoRemessa" /> 
              <label for="IdenficacaoRemessa">Identifica��o da Remessa</label><br>
                
              <? if (db_getsession("DB_anousu") >= 2014) {?>
              <input type="checkbox" value="Pessoa" id="Pessoa" /> 
              <label for="Pessoa">Pessoas F�sicas e Jur�dicas</label><br>
              <? } ?>
              
                <input type="checkbox" value="AmOrgao" id="AmOrgao" /> 
                <label for="AmOrgao">Org�os</label><br>
                
                <? if (db_getsession("DB_anousu") >= 2014) {?>
                <input type="checkbox" value="ConsConsorcios" id="ConsConsorcios" /> 
                <label for="ConsConsorcios">Cons�rcios</label><br>
                <? } ?> 
                
                <input type="checkbox" value="PrevisaoAtualizadaReceita" id="PrevisaoAtualizadaReceita" /> 
                <label for="PrevisaoAtualizadaReceita">Previs�o Atualizada da Receita</label><br>
                
                <input type="checkbox" value="DetalhamentoReceitasMes" id="DetalhamentoReceitasMes" /> 
                <label for="DetalhamentoReceitasMes">Detalhamento das Receitas do M�s</label><br>
                  
                <input type="checkbox" value="DetalhamentoCorrecoesReceitas" id="DetalhamentoCorrecoesReceitas" /> 
                <label for="DetalhamentoCorrecoesReceitas">Detalhamento das Corre��es de Receitas</label><br>
                
                <input type="checkbox" value="LeiAlteracaoOrcamentaria" id="LeiAlteracaoOrcamentaria" />
                <label for="LeiAlteracaoOrcamentaria">Lei de Altera��o Or�ament�ria</label><br>
                
                <? if (db_getsession("DB_anousu") < 2014) {?>
                
                <input type="checkbox" value="DecretoMunicipal" id="DecretoMunicipal" />
                <label for="DecretoMunicipal">Decreto Municipal Regulamentador do Preg�o</label><br>
                
                <? } ?>
                
                <input type="checkbox" value="AlteracoesOrcamentarias" id="AlteracoesOrcamentarias" />
                <label for="AlteracoesOrcamentarias">Altera��es Or�ament�rias</label><br> 
                  
                  <input type="checkbox" value="AberturaLicitacao" id="AberturaLicitacao" /> 
                  <label for="AberturaLicitacao">Abertura da Licita��o</label><br>
                  
                  <input type="checkbox" value="ResponsaveisLicitacao" id="ResponsaveisLicitacao" /> 
                  <label for="ResponsaveisLicitacao">Respons�veis pela Licita��o</label><br>
                  
                  <input type="checkbox" value="HabilitacaoLicitacao" id="HabilitacaoLicitacao" /> 
                  <label for="HabilitacaoLicitacao">Habilita��o da Licita��o</label><br>
                  
                  <input type="checkbox" value="JulgamentoLicitacao" id="JulgamentoLicitacao" /> 
                  <label for="JulgamentoLicitacao">Julgamento da Licita��o</label><br>
                  
                  <input type="checkbox" value="HomologacaoLicitacao" id="HomologacaoLicitacao" /> 
                  <label for="HomologacaoLicitacao">Homologa��o da Licita��o</label><br>
                  
                  <input type="checkbox" value="ParecerLicitacao" id="ParecerLicitacao" /> 
                  <label for="ParecerLicitacao">Parecer da Licita��o</label><br>
                  
                  <input type="checkbox" value="AdesaoRegistroPrecos" id="AdesaoRegistroPrecos" /> 
                  <label for="AdesaoRegistroPrecos">Ades�o a Registro de Pre�os</label><br>
                  
                  <input type="checkbox" value="DispensaInexigibilidade" id="DispensaInexigibilidade" /> 
                  <label for="DispensaInexigibilidade">Dispensa ou Inexigibilidade</label><br>
                  
                <input type="checkbox" value="Contratos" id="Contratos" /> 
                <label for="Contratos">Contratos</label><br>
                <? if (db_getsession("DB_anousu") >= 2014) {?>
                <input type="checkbox" value="Convenios" id="Convenios" />
                <label for="Convenios">Convenios</label><br>
                <? } ?>
                
              </td>
              <td style="border: 2px groove white;" valign="top">
                 
                <input type="checkbox" value="ContasBancarias" id="ContasBancarias" /> 
                <label for="ContasBancarias">Contas Banc�rias</label><br>
                 
                <input type="checkbox" value="Caixa" id="Caixa" /> 
                <label for="Caixa">Caixa</label><br>
              
              	<input type="checkbox" value="DetalhamentoEmpenhosMes" id="DetalhamentoEmpenhosMes" /> 
              	<label for="DetalhamentoEmpenhosMes">Detalhamento dos Empenhos do M�s</label><br>
                
                <input type="checkbox" value="EmpenhosAnuladosMes" id="EmpenhosAnuladosMes" /> 
                <label for="EmpenhosAnuladosMes">Empenhos Anulados no m�s</label><br>
                              
                <input type="checkbox" value="RestosPagar" id="RestosPagar" /> 
                <label for="RestosPagar">Restos a Pagar de Exerc�cios Anteriores</label><br>
                
                <input type="checkbox" value="DetalhamentoLiquidacaoDespesa" id="DetalhamentoLiquidacaoDespesa" /> 
                <label for="DetalhamentoLiquidacaoDespesa">Detalhamento da liquida��o da despesa</label><br>
                
                <input type="checkbox" value="DetalhamentoAnulacao" id="DetalhamentoAnulacao" /> 
                <label for="DetalhamentoAnulacao">Detalhamento da Anula��o da liquida��o da despesa</label><br>
                
                <input type="checkbox" value="DetalhamentoExtraOrcamentarias" id="DetalhamentoExtraOrcamentarias" /> 
                <label for="DetalhamentoExtraOrcamentarias">Detalhamento das Extra-Or�ament�rias</label><br>
                
                <input type="checkbox" value="AnulacaoExtraOrcamentaria" id="AnulacaoExtraOrcamentaria" /> 
                <label for="AnulacaoExtraOrcamentaria">Anula��o das Extra-Or�ament�rias</label><br>
                
                <input type="checkbox" value="PagamentosDespesas" id="PagamentosDespesas" /> 
                <label for="PagamentosDespesas">Pagamentos das Despesas</label><br>
                
                <input type="checkbox" value="AnulacoesOrdensPagamento" id="AnulacoesOrdensPagamento" /> 
                <label for="AnulacoesOrdensPagamento">Anula��es das Ordens de Pagamento</label><br>
                
                <input type="checkbox" value="OutrasBaixasEmpenhos" id="OutrasBaixasEmpenhos" /> 
                <label for="OutrasBaixasEmpenhos">Outras Baixas de Empenhos por Lan�amento Cont�bil</label><br>
                
                <input type="checkbox" value="AnulacoesOutrasBaixasEmpenhos" id="AnulacoesOutrasBaixasEmpenhos" /> 
                <label for="AnulacoesOutrasBaixasEmpenhos">Anula��es de Outras Baixas de Empenhos por Lan�amento Cont�bil</label><br>
                
                <input type="checkbox" value="NotasFiscais" id="NotasFiscais" /> 
                <label for="NotasFiscais">Notas Fiscais</label><br>
                
                <input type="checkbox" value="CadastroVeiculos" id="CadastroVeiculos" /> 
                <label for="CadastroVeiculos">Cadastro de Ve�culos ou Equipamentos</label><br>
                
                <input type="checkbox" value="DividaConsolidada" id="DividaConsolidada" /> 
                <label for="DividaConsolidada">D�vida Consolidada</label><br>
                
                <input type="checkbox" value="ProjecaoAtuarial" id="ProjecaoAtuarial" /> 
                <label for="ProjecaoAtuarial">Proje��o Atuarial do RPPS</label><br>
                
                <input type="checkbox" value="DadosComplementares" id="DadosComplementares" /> 
                <label for="DadosComplementares">Dados Complementares � LRF</label><br>
                
                <? if (db_getsession("DB_anousu") >= 2014) {?>
                <input type="checkbox" value="Item" id="Item" /> 
                <label for="Item">Item</label><br>
                <? } ?>
                
                <? if (db_getsession("DB_anousu") >= 2014) {?>
                <input type="checkbox" value="LegislacaoMunicipalLicitacao" id="LegislacaoMunicipalLicitacao" /> 
                <label for="LegislacaoMunicipalLicitacao">Legisla��o Municipal para Licita��o</label><br>
                <? } ?>
                
                <? if (db_getsession("DB_anousu") >= 2014) {?>
                <input type="checkbox" value="Consideracoes" id="Consideracoes" />
                <label for="Consideracoes">Considera��es</label><br>
                <? } ?>
                
                <? if (db_getsession("DB_anousu") >= 2015) {?>
                <input type="checkbox" value="SuperavitFinanceiro" id="SuperavitFinanceiro" />
                <label for="Consideracoes">Superavit Financeiro</label><br>
                <? } ?>

                <? if (db_getsession("DB_anousu") >= 2016) {?>
                  <input type="checkbox" value="CronogramaExecucao" id="CronogramaExecucao" />
                  <label for="CronogramaExecucao">Cronograma de Execucao</label><br>
                <? } ?>

                <? if (db_getsession("DB_anousu") >= 2016) {?>
                  <input type="checkbox" value="MetasFisicasRealizadas" id="MetasFisicasRealizadas" />
                  <label for="MetasFisicasRealizadas">Metas Fisicas Realizadas</label><br>
                <? } ?>
                
              </td>
              
			<td style="border: 2px groove white;" valign="top">
			
				<input type="checkbox" value="IdentificacaoRemessa" id="IdentificacaoRemessa" /> 
                <label for="IdentificacaoRemessa">Identifica��o da Remessa</label><br>
                
                <input type="checkbox" value="ProgramasAnuais" id="ProgramasAnuais" /> 
                <label for="ProgramasAnuais">Programas Anuais</label><br>
                
                <input type="checkbox" value="AcoesMetasAnuais" id="AcoesMetasAnuais" /> 
                <label for="AcoesMetasAnuais">A��es e Metas Anuais</label><br>
			
			</td>

              <td style="border: 2px groove white;" valign="top">
                <div id='retorno'
                  style="width: 200px; height: 250px; overflow: scroll;">
                </div>
              </td>
            </tr>
          </table>
        </fieldset>
        <div style="text-align: center;">
          <input type="button" id="btnMarcarTodos" value="Marcar Todos" onclick="js_marcaTodos();" />
          <input type="button" id="btnLimparTodos" value="Limpar Todos" onclick="js_limpa();"/>
          <input type="button" id="btnProcessar" value="Processar"
            onclick="js_processar();" />
        </div>
      </div>
    </form>

  </center>
</body>
</html>
<? db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>
<script type="text/javascript">
function js_processar() {

  if ($F('o119_sequencial') == '' && $("MesReferencia") == 12) {

    alert("Favor informar a Pespectiva do PPA");
    js_pesquisa_ppa(true);
    return false;    
  }
  
  var aArquivosSelecionados = new Array();
  var aArquivos             = $$("input[type='checkbox']");
  var iMesReferencia        = $("MesReferencia");

  /*
   * iterando sobre o array de arquivos com uma fun��o an�nima para pegar os arquivos selecionados pelo usu�rio
   */ 
  aArquivos.each(function (oElemento, iIndice) {
    
    if (oElemento.checked) {
        aArquivosSelecionados.push(oElemento.value);
    }
  });  
  if (aArquivosSelecionados.length == 0) {
    
    alert("Nenhum arquivo foi selecionado para ser gerado");
    return false;
  }
  js_divCarregando('Aguarde, processando arquivos','msgBox');
  var oParam           = new Object();
  oParam.exec          = "processarSicomMensal";
  oParam.arquivos      = aArquivosSelecionados;
  oParam.pespectivappa = $F('o119_sequencial');
  oParam.mesReferencia = iMesReferencia.value;
  var oAjax = new Ajax.Request("con4_processarpad.RPC.php",
		                            {
                                  method:'post',
                                  parameters:'json='+Object.toJSON(oParam),
                                  onComplete:js_retornoProcessamento
		                            }
	      );
  
}

function js_retornoProcessamento(oAjax) {

	 js_removeObj('msgBox');
	 $('debug').innerHTML = oAjax.responseText;
	  var oRetorno = eval("("+oAjax.responseText+")");
	  if (oRetorno.status == 1) {

		  alert("Processo conclu�do com sucesso!");  
	    var sRetorno = "<b>Arquivos Gerados:</b><br>";
	    for (var i = 0; i < oRetorno.itens.length; i++) {

	      with (oRetorno.itens[i]) {
	            
	        sRetorno += "<a  href='db_download.php?arquivo="+caminho+"'>"+nome+"</a><br>";
	      }
	    }
	    
	    $('retorno').innerHTML = sRetorno;
	  } else {
	    
	    $('retorno').innerHTML = '';
	    alert("Houve um erro no processamento!" + oRetorno.message.urlDecode());
	    //alert(oRetorno.message.urlDecode());
	    return false;
	  }
	} 
function js_pesquisao125_cronogramaperspectiva(mostra) {

    if (mostra==true){
        /*
         *passa o nome dos campos do banco para pesquisar pela fun��o js_mostracronogramaperspectiva1
         *a variavel funcao_js � uma vari�vel global
         *db_lovrot recebe par�metros separados por |
         */ 
      js_OpenJanelaIframe('top.corpo',
                          'db_iframe_cronogramaperspectiva',
                          'func_cronogramaperspectiva.php?funcao_js='+
                          'parent.js_mostracronogramaperspectiva1|o124_sequencial|o124_descricao|o124_ano',
                          'Perspectivas do Cronograma',true);
    }else{
       if ($F('o124_sequencial') != ''){ 
          js_OpenJanelaIframe('top.corpo',
                              'db_iframe_cronogramaperspectiva',
                              'func_cronogramaperspectiva.php?pesquisa_chave='+
                              $F('o124_sequencial')+
                              '&funcao_js=parent.js_mostracronogramaperspectiva',
                              'Perspectivas do Cronograma',
                              false);
       }else{
         $('o124_sequencial').value = '';
       }
    }
  }
  //para retornar sem mostrar a tela de pesquisa. ao digitar o codigo retorna direto para o campo
  function js_mostracronogramaperspectiva(chave,erro, ano) {
    $('o124_descricao').value = chave; 
    if(erro==true) { 
      
      $('o124_sequencial').focus(); 
      $('o124_sequencial').value = '';
        
    }
  }
  //preenche os campos do frame onde foi chamada com os valores do banco
  function js_mostracronogramaperspectiva1(chave1,chave2,chave3) {

    $('o124_sequencial').value = chave1;
    $('o124_descricao').value  = chave2;
    db_iframe_cronogramaperspectiva.hide();
  }

  function js_pesquisa_ppa(mostra) {

    if(mostra==true){
      js_OpenJanelaIframe('top.corpo',
                          'db_iframe_ppa',
                          'func_ppaversaosigap.php?funcao_js='+
                          'parent.js_mostrappa1|o119_sequencial|o01_descricao',
                          'Perspectivas do Cronograma',true);
    }else{
       if( $F('o119_sequencial') != ''){ 
          js_OpenJanelaIframe('top.corpo',
                              'db_iframe_ppa',
                              'func_ppaversaosigap.php?pesquisa_chave='+
                              $F('o119_sequencial')+
                              '&funcao_js=parent.js_mostrappa',
                              'Perspectivas do Cronograma',
                              false);
       }else{
       
         document.form1.o124_descricao.value = '';
         document.form1.ano.value             = ''
          
       }
    }
  }

  function js_mostrappa(chave,erro, ano) {
    $('o119_descricao').value = chave; 
    if(erro==true) { 
      
      $('o119_sequencial').focus(); 
      $('o119_sequencial').value = '';
        
    }
  }

  function js_mostrappa1(chave1,chave2,chave3) {

    $('o119_sequencial').value = chave1;
    $('o119_descricao').value  = chave2;
    db_iframe_ppa.hide();
  }

  function js_marcaTodos() {

	  var aCheckboxes = $$('input[type=checkbox]');
	  aCheckboxes.each(function(oCheckbox) {
	    oCheckbox.checked = true;
	  }); 
	}

  function js_limpa() {
	   
	  var aCheckboxes = $$('input[type=checkbox]');
	  aCheckboxes.each(function (oCheckbox) {
	    oCheckbox.checked = false;
	  }); 
	}
  function js_mostrameta(mes){
    if(mes == 12){
      $("meta").style.display = "block";
    }else{
      $("meta").style.display = "none";
    }
  }
</script>
<div id='debug'>
</div>
