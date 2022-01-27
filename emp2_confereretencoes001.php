<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
require("libs/db_utils.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label("e80_data");
$clrotulo->label("e83_codtipo");
$clrotulo->label("e80_codage");
$clrotulo->label("e50_codord");
$clrotulo->label("e50_numemp");
$clrotulo->label("e60_numemp");
$clrotulo->label("e60_codemp");
$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("e60_emiss");
$clrotulo->label("e82_codord");
$clrotulo->label("e87_descgera");
$clrotulo->label("o15_descr");
$clrotulo->label("o15_codigo");
$clrotulo->label("e21_sequencial");
$clrotulo->label("e21_descricao");
$db_opcao = 1;
?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">

    <style type="text/css">
    #fieldset_credores, #fieldset_saltes, #fieldset_retencoes, #fieldset_recursos {
    	width: 500px;
    	text-align: center;
    }
    #fieldset_credores table, #fieldset_saltes table, #fieldset_retencoes table, #fieldset_recursos table {
      margin: 0 auto;
    }
    </style>
  </head>
  <body bgcolor=#CCCCCC >
    <form name='form1' id="form1">
			<fieldset style="margin:25px auto 0 auto; width: 500px;">
				<legend>
					<strong>Relatório</strong>
				</legend>
				<table border="0" align="center">
          <tr>
            <td title="<?=@$Te82_codord?>">
               <? db_ancora(@$Le82_codord,"js_pesquisae82_codord(true);",$db_opcao);  ?>
            </td>
            <td>
              <? db_input('e82_codord',10,$Ie82_codord,true,'text',$db_opcao," onchange='js_pesquisae82_codord(false);'")  ?>
              <? db_ancora("<b>até:</b>","js_pesquisae82_codord02(true);",$db_opcao);  ?>
              <? db_input('e82_codord2',10,$Ie82_codord,true,'text',$db_opcao, "onchange='js_pesquisae82_codord02(false);'","e82_codord02")?>
            </td>
          </tr>

          <tr>
            <td>
              <b>Data Inicial:</b>
            </td>
            <td>
              <?
               db_inputdata("datainicial",null,null,null,true,"text", 1);
              ?>
            	<b>Data Final:</b>
              <?
                db_inputdata("datafinal",null,null,null,true,"text", 1);
              ?>
            </td>
          </tr>
        </table>
        <table>
          <tr>
						<td>
				    <?
					    $oFiltroCredor = new cl_arquivo_auxiliar;
						  $oFiltroCredor->cabecalho            = "<strong>Credores</strong>";
						  $oFiltroCredor->codigo               = "z01_numcgm";
						  $oFiltroCredor->descr                = "z01_nome";
						  $oFiltroCredor->isfuncnome           = true;
						  $oFiltroCredor->nomeobjeto           = 'credores';
						  $oFiltroCredor->funcao_js            = 'js_mostraCredor';
						  $oFiltroCredor->funcao_js_hide       = 'js_mostraCredorHide';
						  $oFiltroCredor->func_arquivo         = "func_nome.php";
						  $oFiltroCredor->nomeiframe           = "db_iframe_nomes";
						  $oFiltroCredor->vwidth               = '400';
						  $oFiltroCredor->db_opcao             = 2;
						  $oFiltroCredor->tipo                 = 2;
						  $oFiltroCredor->top 				         = 0;
						  $oFiltroCredor->linhas 				       = 5;
						  $oFiltroCredor->nome_botao           = 'lancarCredor';
						  $oFiltroCredor->lFuncaoPersonalizada = true;
						  $oFiltroCredor->obrigarselecao 			 = false;
						  $oFiltroCredor->funcao_gera_formulario();
				    ?>
				  	</td>
					</tr>

					<tr>
						<td>
				    <?
					    $oFiltroRetencao = new cl_arquivo_auxiliar;
						  $oFiltroRetencao->cabecalho            = "<strong>Retenções</strong>";
						  $oFiltroRetencao->codigo               = "e21_sequencial";
						  $oFiltroRetencao->descr                = "e21_descricao";
						  $oFiltroRetencao->nomeobjeto           = 'retencoes';
						  $oFiltroRetencao->funcao_js            = 'js_mostraRetencao';
						  $oFiltroRetencao->funcao_js_hide       = 'js_mostraRetencaoHide';
						  $oFiltroRetencao->func_arquivo         = "func_retencaotiporec.php";
						  $oFiltroRetencao->nomeiframe           = "db_iframe_retencao";
						  $oFiltroRetencao->vwidth               = '400';
						  $oFiltroRetencao->db_opcao             = 2;
						  $oFiltroRetencao->tipo                 = 2;
						  $oFiltroRetencao->top 				         = 0;
						  $oFiltroRetencao->linhas 				       = 5;
						  $oFiltroRetencao->nome_botao           = 'lancarRetencao';
						  $oFiltroRetencao->lFuncaoPersonalizada = true;
						  $oFiltroRetencao->obrigarselecao       = false;
						  $oFiltroRetencao->funcao_gera_formulario();
				    ?>
				  	</td>
					</tr>

					<tr>
						<td>
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
						  $oFiltroRecursos->vwidth 				       = '400';
						  $oFiltroRecursos->db_opcao             = 2;
						  $oFiltroRecursos->tipo                 = 2;
						  $oFiltroRecursos->top 				         = 0;
						  $oFiltroRecursos->linhas 				       = 5;
						  $oFiltroRecursos->nome_botao           = 'lancarRecurso';
						  $oFiltroRecursos->lFuncaoPersonalizada = true;
						  $oFiltroRecursos->obrigarselecao       = false;
						  $oFiltroRecursos->funcao_gera_formulario();
				    ?>
				  	</td>
					</tr>

					<tr>
						<td>
					    <?
						    $oFiltroConta = new cl_arquivo_auxiliar;
							  $oFiltroConta->cabecalho            = "<strong>Contas</strong>";
							  $oFiltroConta->codigo               = "k13_conta";
							  $oFiltroConta->descr                = "k13_descr";
							  $oFiltroConta->nomeobjeto           = 'saltes';
							  $oFiltroConta->funcao_js            = 'js_mostraconta';
							  $oFiltroConta->funcao_js_hide       = 'js_mostraconta1';
							  $oFiltroConta->sql_exec  						= "";
							  $oFiltroConta->func_arquivo 			  = "func_saltes.php";
							  $oFiltroConta->nomeiframe           = "db_iframe_saltes";
							  $oFiltroConta->vwidth               = '400';
							  $oFiltroConta->localjan             = "";
							  $oFiltroConta->db_opcao             = 2;
							  $oFiltroConta->tipo                 = 2;
							  $oFiltroConta->top                  = 0;
							  $oFiltroConta->linhas               = 5;
							  $oFiltroConta->nome_botao           = 'lancarConta';
							  $oFiltroConta->lFuncaoPersonalizada = true;
							  $oFiltroConta->obrigarselecao       = false;
							  $oFiltroConta->funcao_gera_formulario();
					    ?>
				  	</td>
					</tr>

          <tr>
						<td>
              <fieldset style="margin:0 auto 0 auto; width: 500px;">
                <legend>
                   <strong>Filtros</strong>
                </legend>
                <table align="center">
                  <tr>
                    <td>
                       <b>Credores:</b>
                    </td>
                    <td>
                      <?
                        $aSemCredores  = array(1 => "Com os Credores Selecionados",
                                               2 => "Sem os Credores Selecionados");
                       db_select("credorsim", $aSemCredores,true,1,"style='width:10em'");
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                       <b>Quebra:</b>
                    </td>
                    <td>
                      <?
                        $aQuebras = array(1 => "Nenhuma",
                                          2 => "Conta",
                                          3 => "Credor",
                                          4 => "Ano");
                       db_select("group", $aQuebras,true,1,"style='width:10em'");
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                       <b>Ordem:</b>
                    </td>
                    <td>
                      <?
                        $aOrdem  = array(1 => "Númerica",
                                         2 => "Descrição");
                       db_select("order", $aOrdem,true,1,"style='width:10em'");
                      ?>
                    </td>
                  </tr>
                  <tr>
                    <td>
                       <b>Tipo:</b>
                    </td>
                    <td>
                      <?
                        $aPagamento  = array("p" => "Pagamento",
                                             "l" => "Liquidacao",
                                            "nf" => "Competência NF");
                       db_select("pagamento", $aPagamento,true,1,"style='width:10em'");
                      ?>
                    </td>
                  </tr>
                  <tr>  
                    <td>
                       <b>OP's:</b>
                    </td>
                    <td>
                      <?
                        $aOps  = array("t"  => "Todas",
                                       "p"  => "Pagas",
                                       "np" => "Não Pagas");
                        db_select("ops", $aOps, true, 1, "style='width:10em'");
                      ?>
                    </td>
                  </tr>
                  <!--OC4581-->
                  <tr>
                    <td nowrap="nowrap">
                        <b>Tipo Lançamento</b>
                    </td>
                    <td>
                      <?php
                        $aTipoLancamento = array("" => "",
                            1 => "01 - Depósitos e Consignações",
                            2 => "02 - Débitos de Tesouraria",
                            3 => "03 - Ativo Realizável",
                            4 => "04 - Transferências Financeiras",
                            9999 => "99-Outros");
                        db_select("iTipoLancamento", $aTipoLancamento , true, $db_opcao,"onchange='js_getSubtipo();'style=width:10em");
                      ?>
                    </td>
                  </tr>


                  <tr id="trsubtipo">
                      <td nowrap="nowrap">
                          <b>SubTipo</b>
                      </td>
                      <td>
                          <?php
                          $asubTipo = array();
                          db_select("isubtipo", $asubTipo , true, $db_opcao,"onchange='js_novo_subtipo();js_getDesdobraSubtipo();'style=width:10em");
                          db_input("isubtipo_hidden", 5, 1, 3, "hidden", $db_opcao, "","","","",4);
                          ?>
                      </td>
                  </tr>

                  <tr id="trsubtipoNovo" style="display:none;">
                      <td nowrap="nowrap" colspan="2">
                          <fieldset><legend>Incluir SubTipo</legend>
                          <b>SubTipo</b><?php db_input("c200_subtipo", 5, 1, 3, "text", $db_opcao, "","","","",4); ?>
                          <b>Descrição</b><?php db_input("c200_descsubtipo", 35, 0, 3, "text", $db_opcao, "","","","text-transform: uppercase;",100); ?>
                          <input type="button" name="btnIncluirSubtipo" id="btnIncluirSubtipo" value="Adicionar"  />
                          </fieldset>
                      </td>
                  </tr>

                  <tr id="trdesdobramento" >
                    <td nowrap="nowrap">
                        <b>Desdobramento Subtipo:</b>
                    </td>
                    <td>
                      <?php
                        $adesdobramento = array();
                        db_select("idesdobramento", $adesdobramento , true, $db_opcao,"onchange='js_novo_desdobrasubtipo();'style=width:10em");
                        db_input("idesdobramento_hidden", 5, 1, 3, "hidden", $db_opcao, "","","","",4);
                      ?>
                    </td>
                  </tr>
                  <tr id="trdesdobramentoNovo" style="display:none;">
                      <td nowrap="nowrap" colspan="2">
                          <fieldset><legend>Incluir SubTipo</legend>
                              <b>Desdobra SubTipo</b><?php db_input("c201_desdobrasubtipo", 5, 1, 3, "text", $db_opcao, "","","","",4); ?>
                              <b>Descrição</b><?php db_input("c201_descdesdobrasubtipo", 35, 0, 3, "text", $db_opcao, "","","","text-transform: uppercase;",100); ?>
                              <input type="button" name="btnIncluirDesdobraSubtipo" id="btnIncluirDesdobraSubtipo" value="Adicionar"  />
                          </fieldset>
                      </td>
                  </tr>

                </table>
            </fieldset>
					</td>
				</tr>

				<tr>
				  <td style='text-align:center'>
				    <input type='button' value='Emitir' onclick='js_emitir()'>
				  </td>
				</tr>

			</table>
		</fieldset>
    </form>
  </body>
</html>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>
/*OC4581*/
$("btnIncluirSubtipo").observe("click", function() {
//alert($("c200_subtipo").value);
     js_divCarregando("Cadastrando SubTipo, aguarde...", "msgBox");
     var oParam               = new Object();
     oParam.exec              = "salvarSubTipo";
     oParam.c200_tipo         = $("iTipoLancamento").value;
     oParam.c200_subtipo      = $("c200_subtipo").value;
     oParam.c200_descsubtipo  = encodeURIComponent(tagString($("c200_descsubtipo").value));

     var oAjax                   = new Ajax.Request(sUrlRPC,
         {method:'post',
             parameters:'json='+Object.toJSON(oParam),
             onComplete: js_retornosalvarSubTipo
         }
     );

 });
 function js_retornosalvarSubTipo(oAjax) {

     js_removeObj("msgBox");
     var oRetorno = eval("("+oAjax.responseText+")");
     alert(oRetorno.message.urlDecode().replace('\\n',' '));

     if (oRetorno.status == 1) {
         js_getSubtipo();
     }
 }
function js_getSubtipo() {
     var oParam        = new Object();
     oParam.exec       = 'getSubTipo';
     oParam.c200_tipo  = $("iTipoLancamento").value;
     var oAjax         = new Ajax.Request(sUrlRPC,
         {method:'post',
             parameters:'json='+Object.toJSON(oParam),
             onComplete: js_retornogetSubtipo
         }
     );
 }
function js_retornogetSubtipo(oAjax) {
     var oRetorno = eval("("+oAjax.responseText+")");
     if (oRetorno.status == 2) {
         alert(oRetorno.message.urlDecode().replace('\\n',' '));
     } else {
         for (var i = $("isubtipo").options.length-1; i >= 0; i--) {
             $("isubtipo").remove(i);
         }
         var subtipo = document.getElementById("isubtipo");
         var option = document.createElement("option");
         option.text  = '';
         option.value = '';
         subtipo.add(option, subtipo[0]);
         for (var i = 0; i < oRetorno.aSubTipos.length; i++) {
             var subtipo = document.getElementById("isubtipo");
             var option = document.createElement("option");
             option.text  = oRetorno.aSubTipos[i].c200_descsubtipo;
             option.value = oRetorno.aSubTipos[i].c200_subtipo;
             subtipo.add(option, subtipo[i+1]);
         }
         /*var subtipo = document.getElementById("isubtipo");
         var option = document.createElement("option");
         option.text  = 'Novo';
         option.value = 'novo';
         subtipo.add(option, subtipo[oRetorno.aSubTipos.length+1]);

         $("isubtipo").value = $("c200_descsubtipo").value == '' ? '' : $("c200_subtipo").value;
         if($("isubtipo_hidden").value != '') {
             $("isubtipo").value = $("isubtipo_hidden").value;
             $("isubtipo_hidden").value = '';
         }
         $("c200_subtipo").value = oRetorno.aSubTipos.length == 0 ? 1 : Number(oRetorno.aSubTipos[oRetorno.aSubTipos.length-1].c200_subtipo)+1;
         $("c200_descsubtipo").value = '';
         js_novo_subtipo();*/
     }
 }
 function js_novo_subtipo() {
     if ($("isubtipo").value == 'novo') {
         $("trsubtipoNovo").style.display = '';
     } else {
         $("trsubtipoNovo").style.display = 'none';
     }
 }

/**
  * Função adicionada para incluir o desdobrasubtipo conforme layout do sicom
  */
 $("btnIncluirDesdobraSubtipo").observe("click", function() {
     js_divCarregando("Cadastrando DesdobraSubTipo, aguarde...", "msgBox");
     var oParam               = new Object();
     oParam.exec              = "salvarDesdobraSubTipo";
     oParam.c201_tipo         = $("iTipoLancamento").value;
     oParam.c201_subtipo      = $("isubtipo").value;
     oParam.c201_desdobrasubtipo = $("c201_desdobrasubtipo").value;
     oParam.c201_descdesdobrasubtipo  = encodeURIComponent(tagString($("c201_descdesdobrasubtipo").value));

     var oAjax                   = new Ajax.Request(sUrlRPC,
         {method:'post',
             parameters:'json='+Object.toJSON(oParam),
             onComplete: js_retornosalvarDesdobraSubTipo
         }
     );

 });
 function js_retornosalvarDesdobraSubTipo(oAjax) {

     js_removeObj("msgBox");
     var oRetorno = eval("("+oAjax.responseText+")");
     alert(oRetorno.message.urlDecode().replace('\\n',' '));

     if (oRetorno.status == 1) {
         js_getDesdobraSubtipo();
     }
 }

 function js_getDesdobraSubtipo(isubtipo_inicial) {
     var subtipo1 = [0,1,2,3,4];// a funcao IN do javascript procura pelo numero da posicao, e nao pelo conteudo, por isso precisa do zero
     var subtipo2 = [0,1,2];// a funcao IN do javascript procura pelo numero da posicao, e nao pelo conteudo, por isso precisa do zero
     var subtipo = isubtipo_inicial > 0 ? isubtipo_inicial : $("isubtipo").value;

     if ( ($("iTipoLancamento").value == 1 && subtipo in subtipo1) || ($("iTipoLancamento").value == 4 && subtipo in subtipo2) || ($("iTipoLancamento").value == 9999)) {
         var oParam = new Object();
         oParam.exec = 'getDesdobraSubTipo';
         oParam.c201_tipo = $("iTipoLancamento").value;
         oParam.c201_subtipo = subtipo;
         var oAjax = new Ajax.Request(sUrlRPC,
             {
                 method: 'post',
                 parameters: 'json=' + Object.toJSON(oParam),
                 onComplete: js_retornogetDesdobraSubtipo
             }
         );
     } else {
         for (var i = $("idesdobramento").options.length-1; i >= 0; i--) {
             $("idesdobramento").remove(i);
         }
         js_novo_desdobrasubtipo();
     }
 }
 function js_retornogetDesdobraSubtipo(oAjax) {
     var oRetorno = eval("("+oAjax.responseText+")");
     if (oRetorno.status == 2) {
         alert(oRetorno.message.urlDecode().replace('\\n',' '));
     } else {
         for (var i = $("idesdobramento").options.length-1; i >= 0; i--) {
             $("idesdobramento").remove(i);
         }
         var desdobrasubtipo = document.getElementById("idesdobramento");
         var option = document.createElement("option");
         option.text  = '';
         option.value = '';
         desdobrasubtipo.add(option, desdobrasubtipo[0]);
         for (var i = 0; i < oRetorno.aDesdobraSubTipos.length; i++) {
             var desdobrasubtipo = document.getElementById("idesdobramento");
             var option = document.createElement("option");
             option.text  = oRetorno.aDesdobraSubTipos[i].c201_descdesdobrasubtipo;
             option.value = oRetorno.aDesdobraSubTipos[i].c201_desdobrasubtipo;
             desdobrasubtipo.add(option, desdobrasubtipo[i+1]);
         }
         /*var desdobrasubtipo = document.getElementById("idesdobramento");
         var option = document.createElement("option");
         option.text  = 'Novo';
         option.value = 'novo';
         desdobrasubtipo.add(option, desdobrasubtipo[oRetorno.aDesdobraSubTipos.length+1]);

         $("idesdobramento").value = $("c201_descdesdobrasubtipo").value == '' ? '' : $("c201_desdobrasubtipo").value;
         if($("idesdobramento_hidden").value != '') {
             $("idesdobramento").value = $("idesdobramento_hidden").value;
             $("idesdobramento_hidden").value = '';
         }
         $("c201_desdobrasubtipo").value = oRetorno.aDesdobraSubTipos.length == 0 ? 1 : Number(oRetorno.aDesdobraSubTipos[oRetorno.aDesdobraSubTipos.length-1].c201_desdobrasubtipo)+1;
         $("c201_descdesdobrasubtipo").value = '';
         js_novo_desdobrasubtipo();*/
     }
 }
 function js_novo_desdobrasubtipo() {
     if ($("idesdobramento").value == 'novo') {
         $("trdesdobramentoNovo").style.display = '';
     } else {
         $("trdesdobramentoNovo").style.display = 'none';
     }
 }

var sUrlRPC = "con4_conplanoPCASP.RPC.php";
/*FIM OC4581*/

oDBToogleCredores = new DBToogle('fieldset_credores', false);
oDBToogleCredores = new DBToogle('fieldset_retencoes', false);
oDBToogleCredores = new DBToogle('fieldset_recursos', false);
oDBToogleCredores = new DBToogle('fieldset_saltes', false);

function js_emitir() {


  if ($F('datainicial') == "") {

    alert('A Data do Inicial do período deve ser informada!');
    return false;

  }

  var oParametro         = new Object();
  oParametro.datainicial = $F('datainicial');
  oParametro.datafinal   = $F('datafinal');
  oParametro.iPagamento  = $F('pagamento');
  oParametro.sOps        = $F('ops');
  oParametro.iOrdemIni   = $F('e82_codord');
  oParametro.iOrdemFim   = $F('e82_codord02');
  oParametro.order       = $F('order');
  oParametro.group       = $F('group');
  oParametro.credorsim   = $F('credorsim');

  /*OC4581*/
  oParametro.iTipoLancamento = $F('iTipoLancamento');
  oParametro.isubtipo = $F('isubtipo');
  oParametro.idesdobramento = $F('idesdobramento');

  oParametro.sContas     = js_campo_recebe_valores_saltes ();
  oParametro.sCredores   = js_campo_recebe_valores_credores ();
  oParametro.sRecursos   = js_campo_recebe_valores_recursos ();
  oParametro.sRetencoes  = js_campo_recebe_valores_retencoes();

  var sFiltros = oParametro.toSource();
  sFiltros     = sFiltros.replace("(","");
  sFiltros     = sFiltros.replace(")","");

  var sUrlRelatorio = "emp2_confereretencoes002.php?sFiltros="+sFiltros;
  var jan           = window.open(sUrlRelatorio,
                                  '',
                                  'width='+(screen.availWidth-5)+
                                  ',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
  jan.moveTo(0,0);
}

function js_pesquisae82_codord(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_pagordem','func_pagordem.php?funcao_js=parent.js_mostrapagordem1|e50_codord','Pesquisa',true);
  }else{
    ord01 = new Number(document.form1.e82_codord.value);
    ord02 = new Number(document.form1.e82_codord02.value);
    if(ord01 > ord02 && ord01 != "" && ord02 != ""){
      alert("Selecione uma ordem menor que a segunda!");
      document.form1.e82_codord.focus();
      document.form1.e82_codord.value = '';
    }
  }
}
function js_mostrapagordem1(chave1){
  document.form1.e82_codord.value = chave1;
  db_iframe_pagordem.hide();
}
//-----------------------------------------------------------
//---ordem 02
function js_pesquisae82_codord02(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_pagordem','func_pagordem.php?funcao_js=parent.js_mostrapagordem102|e50_codord','Pesquisa',true);
  }else{
    ord01 = new Number(document.form1.e82_codord.value);
    ord02 = new Number(document.form1.e82_codord02.value);
    if(ord01 > ord02 && ord02 != ""  && ord01 != ""){
      alert("Selecione uma ordem maior que a primeira");
      document.form1.e82_codord02.focus();
      document.form1.e82_codord02.value = '';
    }
  }
}
function js_mostrapagordem102(chave1,chave2){
  document.form1.e82_codord02.value = chave1;
  db_iframe_pagordem.hide();
}
function js_pesquisae60_codemp(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_mostraempempenho2|e60_codemp','Pesquisa',true);
  }else{
   // js_OpenJanelaIframe('top.corpo','db_iframe_empempenho02','func_empempenho.php?pesquisa_chave='+document.form1.e60_numemp.value+'&funcao_js=parent.js_mostraempempenho','Pesquisa',false);
  }
}
</script>
