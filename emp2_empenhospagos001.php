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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");

$cliframe_seleciona = new cl_iframe_seleciona;
$oRotuloSaltes = new rotulo('saltes');
$oRotuloSaltes->label();

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
    <style>
      #ctnEmpenhosPagos select {
        width: 150px;

      }

      #fieldset_credor, #fieldset_saltes, #fieldset_recursos {
        width: 500px;
        text-align: center;
      }

      #fieldset_credor table, #fieldset_saltes table, #fieldset_recursos table {
          margin: 0 auto;
      }

      #o15_codtri{
        width:94px;
      }
      #z01_numcgm{
        width:92px;
      }

      #fieldset_acordos, #fieldset_saltes, #fieldset_acordos {
        width: 500px;
        text-align: center;
      }

      #fieldset_acordos table, #fieldset_saltes table, #fieldset_acordos table {
        margin: 0 auto;
      }

      #ac16_sequencial{
        width:94px;
      }
      #ac16_resumoobjeto{
        width:92px;
      }


    </style>
  </head>
  <body style="margin-top: 25px; background-color: #cccccc;z-index: 99">
  <div id="ctnEmpenhosPagos">
  <form name="form1" id="form1" method="POST">
    <center>
      <fieldset style="margin:25px auto 0 auto; width: 500px;">
        <legend><b>Empenhos Pagos</b></legend>
        <table>
          <tr id="trFieldsetCredor">
            <td >
              <?php
                /*
                 * Seleção de Credor
                 */
                $oFiltroCredor                 = new cl_arquivo_auxiliar();
                $oFiltroCredor->cabecalho      = "<strong>Credor</strong>";
                $oFiltroCredor->codigo         = "z01_numcgm"; //chave de retorno da func
                $oFiltroCredor->descr          = "z01_nome";   //chave de retorno
                $oFiltroCredor->nomeobjeto     = 'credor';
                $oFiltroCredor->funcao_js      = 'js_pesquisaCredor';
                $oFiltroCredor->funcao_js_hide = 'js_pesquisaCredor1';
                $oFiltroCredor->sql_exec       = "";
                $oFiltroCredor->func_arquivo   = "func_movimentacaoempenhopago.php";  //func a executar
                $oFiltroCredor->nomeiframe     = "db_iframe_cgm";
                $oFiltroCredor->localjan       = "";
                $oFiltroCredor->db_opcao       = 2;
                $oFiltroCredor->tipo           = 2;
                $oFiltroCredor->top            = 1;
                $oFiltroCredor->linhas         = 5;
                $oFiltroCredor->vwidth         = 400;
                $oFiltroCredor->nome_botao     = 'db_lanca';
                $oFiltroCredor->fieldset       = false;
                $oFiltroCredor->Labelancora    = "Numcgm:";
                $oFiltroCredor->funcao_gera_formulario();
              ?>
            </td>
          </tr>

          <tr>
            <td>
              <?
                $oFiltroConta                       = new cl_arquivo_auxiliar;
                $oFiltroConta->cabecalho            = "<strong>Conta</strong>";
                $oFiltroConta->codigo               = "k13_conta";
                $oFiltroConta->descr                = "k13_descr";
                $oFiltroConta->nomeobjeto           = 'saltes';
                $oFiltroConta->funcao_js            = 'js_mostraconta';
                $oFiltroConta->funcao_js_hide       = 'js_mostraconta1';
                $oFiltroConta->sql_exec             = "";
                $oFiltroConta->func_arquivo         = "func_saltes.php";
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
                <?
                $oFiltroRecursos = new cl_arquivo_auxiliar;
                $oFiltroRecursos->cabecalho            = "<strong>Recurso</strong>";
                $oFiltroRecursos->codigo               = "o15_codtri";
                $oFiltroRecursos->descr                = "o15_descr";
                $oFiltroRecursos->nomeobjeto           = 'recursos';
                $oFiltroRecursos->funcao_js            = 'js_mostrarecurso';
                $oFiltroRecursos->funcao_js_hide       = 'js_mostrarecursoHide';
                $oFiltroRecursos->func_arquivo         = "func_orctiporec.php";
                $oFiltroRecursos->nomeiframe           = "db_iframe_orctiporec";
                $oFiltroRecursos->vwidth               = '400';
                $oFiltroRecursos->db_opcao             = 2;
                $oFiltroRecursos->tipo                 = 2;
                $oFiltroRecursos->top                  = 0;
                $oFiltroRecursos->linhas               = 5;
                $oFiltroRecursos->nome_botao           = 'lancarRecurso';
                $oFiltroRecursos->lFuncaoPersonalizada = true;
                $oFiltroRecursos->obrigarselecao       = false;
                $oFiltroRecursos->Labelancora          = "Recurso:";
                $oFiltroRecursos->localjan       = '';
                $oFiltroRecursos->funcao_gera_formulario();
              ?>
            </td>
          </tr>

          <tr>
            <td>

              <?
              $oFiltroAcordo = new cl_arquivo_auxiliar;
              $oFiltroAcordo->cabecalho = "<strong> Contrato </strong>";
              $oFiltroAcordo->codigo = "ac16_sequencial"; //chave de retorno da func
              $oFiltroAcordo->descr  = "ac16_resumoobjeto";   //chave de retorno
              $oFiltroAcordo->nomeobjeto = 'acordos';
              $oFiltroAcordo->funcao_js = 'js_mostraacordos';
              $oFiltroAcordo->funcao_js_hide       = 'js_mostraacordosHide';
              $oFiltroAcordo->func_arquivo         = "func_acordoinstit.php";
              $oFiltroAcordo->nomeiframe           = "db_iframe_acordos";
              $oFiltroAcordo->vwidth               = '400';
              $oFiltroAcordo->db_opcao             = 2;
              $oFiltroAcordo->tipo                 = 2;
              $oFiltroAcordo->top                  = 0;
              $oFiltroAcordo->linhas               = 5;
              $oFiltroAcordo->nome_botao           = 'lancarAcordo';
              $oFiltroAcordo->lFuncaoPersonalizada = true;
              $oFiltroAcordo->obrigarselecao       = false;
              $oFiltroAcordo->Labelancora          = "Acordo:";
              $oFiltroAcordo->localjan       = '';
              $oFiltroAcordo->funcao_gera_formulario();
              ?>
            </td>
          </tr>

           <tr>
              <td>
               <fieldset style="margin:0 auto 0 auto; width: 500px;">
                <legend><b>Filtros</b></legend>
                  <table>
                   <tr>
                          <td><b>Período:</b></td>
                          <td>
                            <?php
                              $aPeriodoDatas = explode('-', date('Y-m-d', db_getsession('DB_datausu')));
                              list($iAnoInicial, $iMesInicial, $iDiaInicial) = $aPeriodoDatas;
                              echo "<b>De:   </b>";
                              db_inputdata("dtDataInicial", $iDiaInicial, $iMesInicial, $iAnoInicial, true, 'text', 1);
                              echo "<b> até </b>";
                              db_inputdata("dtDataFinal", $iDiaInicial, $iMesInicial, $iAnoInicial, true, 'text', 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Ordem:</b></td>
                          <td>
                            <?php
                              $aOrdem = array("empenho" => "Empenho", "autenticacao" => "Autenticação");
                              db_select("sTipoOrdem", $aOrdem, true, 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Quebra por Conta:</b></td>
                          <td>
                            <?php
                              $aQuebraConta = array("f" => "Não", "t" => "Sim");
                              db_select("lQuebraConta", $aQuebraConta, true, 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Quebra por Credor:</b></td>
                          <td>
                            <?php
                              $aQuebraCredor = array("f" => "Não", "t" => "Sim");
                              db_select("lQuebraCredor", $aQuebraCredor, true, 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Quebra por Recurso:</b></td>
                          <td>
                            <?php
                              $aQuebraRecurso = array("f" => "Não", "t" => "Sim");
                              db_select("lQuebraRecurso", $aQuebraRecurso, true, 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Quebra por Contrato:</b></td>
                          <td>
                            <?php
                            $aQuebraAcordo = array("f" => "Não", "t" => "Sim");
                            db_select("lQuebraAcordo", $aQuebraAcordo, true, 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Lista:</b></td>
                          <td>
                            <?php
                              $aListaEmpenho = array(0 => "Geral", 1 => "Exercício", 2 => "Restos à Pagar", 3 => "Extra Orçamentária");
                              db_select("iListaEmpenho", $aListaEmpenho, true, 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Baixa:</b></td>
                          <td>
                            <?php
                              $aTipoBaixa = array(1 => "Todas", 2 => "Valor Líquido Pago", 3 => "Valor Retido");
                              db_select("iTipoBaixa", $aTipoBaixa, true, 1);
                            ?>
                          </td>
                        </tr>
                        <tr>
                          <td><b>Prestação de Contas:</b></td>
                          <td>
                            <?php
                            $aPrestacaoConta = array(1 => "Não", 2 => "Sim");
                            db_select("iPrestacaoConta", $aPrestacaoConta, true, 1);
                            ?>
                          </td>
                        </tr>
                      </table>
                    </fieldset>
                  </td>
                </tr>
          </table>
      </fieldset>
      <br />
      <input type="button" id="btnImprimir" value="Imprimir" />
    </center>
  </form>
 </div>
</body>

<script>
  oDBToogleCredores = new DBToogle('fieldset_credor', false);
  oDBToogleCredores = new DBToogle('fieldset_saltes', false);
  oDBToogleCredores = new DBToogle('fieldset_recursos', false);
  oDBToogleCredores = new DBToogle('fieldset_acordos', false);

  $('btnImprimir').observe('click', function() {

    var iTotalCredores        = $('credor').length;
    var aCredoresSelecionados = $('credor');
    var sCredoresSelecionados = "";
    var sVirgula              = "";


    for (var iRowCredor = 0; iRowCredor < iTotalCredores; iRowCredor++) {
      var oDadosCredor = aCredoresSelecionados[iRowCredor];
      sCredoresSelecionados += sVirgula+oDadosCredor.value;
      sVirgula               = ", ";
    }

    var aContasSelecionadas = $('saltes');
    var sContasSelecionadas = "";
    sVirgula = "";

    for(var iRowConta = 0; iRowConta < $('saltes').length; iRowConta++){
      var oDadosConta = aContasSelecionadas[iRowConta];
      sContasSelecionadas += sVirgula+oDadosConta.value;
      sVirgula = ", ";
    }

    var aRecursosSelecionados = $('recursos');
    var sRecursosSelecionados = "";
    sVirgula = "";


    for(var iRowRecursos = 0; iRowRecursos < $('recursos').length; iRowRecursos++){
      var oDadosRecursos = aRecursosSelecionados[iRowRecursos];
      sRecursosSelecionados += sVirgula+oDadosRecursos.value;
      sVirgula = ", ";
    }

    var aAcordosSelecionados = $('acordos');
    var sAcordosSelecionados = "";
    sVirgula = "";

    for(var iRowAcordos = 0; iRowAcordos < $('acordos').length; iRowAcordos++){
      var oDadosAcordos = aAcordosSelecionados[iRowAcordos];
      sAcordosSelecionados += sVirgula+oDadosAcordos.value;
      sVirgula = ", ";
    }
    var sDataInicialBanco = js_formatar($F('dtDataInicial'), 'd');
    var sDataFinalBanco   = js_formatar($F('dtDataFinal'), 'd');


    if (sDataInicialBanco > sDataFinalBanco) {
      alert("A data inicial é maior que a data final. Verifique!");
      return false;
    }

    function OpenWithPost(dados, name){

      var mapForm = document.createElement("form");
      mapForm.target = name;
      mapForm.method = "POST";
      mapForm.action = "emp2_empenhospagos002.php";
      document.body.appendChild(mapForm);

      for(var key in dados){
        var input   = document.createElement("input");
        input.type  = 'hidden';
        input.name  = key;
        input.value = dados[key];
        mapForm.appendChild(input);
      }

      windowfeature = 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0';
      var map = window.open("", name, windowfeature);
      if (map) {
          mapForm.submit();
      }
    }

    filtra_despesa = parent.iframe_filtro.js_atualiza_variavel_retorno();

    var dados = [];
    dados['sCredoresSelecionados']       = sCredoresSelecionados;
    dados['sContasSelecionadas']         = sContasSelecionadas;
    dados['sRecursosSelecionados']       = sRecursosSelecionados;
    dados['sAcordosSelecionados']        = sAcordosSelecionados;
    dados['dtDataInicial']               = $F('dtDataInicial');
    dados['dtDataFinal']                 = $F('dtDataFinal');
    dados['sTipoOrdem']                  = $F('sTipoOrdem');
    dados['lQuebraConta']                = $F('lQuebraConta');
    dados['lQuebraCredor']               = $F('lQuebraCredor');
    dados['lQuebraRecurso']              = $F('lQuebraRecurso');
    dados['lQuebraAcordo']               = $F('lQuebraAcordo');
    dados['iListaEmpenho']               = $F('iListaEmpenho');
    dados['iTipoBaixa']                  = $F('iTipoBaixa');
    dados['iPrestacaoConta']             = $F('iPrestacaoConta');
    dados['filtra_despesa']              = filtra_despesa;

    var name = new Date().getTime();
    OpenWithPost(dados, name);

  });


</script>
</html>
