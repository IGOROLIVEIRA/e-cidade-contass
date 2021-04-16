<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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


require_once ("libs/db_stdlib.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("std/DBDate.php");
require_once 'libs/db_liborcamento.php';
require_once 'model/contabilidade/planoconta/ContaPlano.model.php';
require_once 'model/contabilidade/planoconta/ContaOrcamento.model.php';
require_once 'model/contabilidade/planoconta/ClassificacaoConta.model.php';
require_once 'model/contabilidade/planoconta/SistemaConta.model.php';
require_once 'model/contabilidade/planoconta/SubSistemaConta.model.php';
require_once 'model/CgmFactory.model.php';
require_once 'model/slip.model.php';
require_once 'model/caixa/AutenticacaoArrecadacao.model.php';
require_once 'model/caixa/LancamentoContabilAjusteBaixaBanco.model.php';
require_once 'model/caixa/AutenticacaoPlanilha.model.php';
require_once 'model/caixa/PlanilhaArrecadacao.model.php';
require_once 'model/caixa/slip/Transferencia.model.php';

db_app::import("exceptions.*");
db_app::import("configuracao.Instituicao");
db_app::import("configuracao.DBEstrutura");
db_app::import("CgmFactory");
db_app::import("contaTesouraria");
db_app::import("contabilidade.*");
db_app::import("caixa.*");
db_app::import("caixa.slip.*");
db_app::import("orcamento.*");
db_app::import("configuracao.*");
db_app::import("contabilidade.lancamento.*");
db_app::import("contabilidade.planoconta.*");
db_app::import("financeiro.*");
db_app::import("contabilidade.contacorrente.*");
db_app::import("exceptions.*");

$iAno = db_getsession("DB_anousu");

if (!USE_PCASP) {

  echo "<h1> Cliente nao utiliza pcasp</h1>";
  exit;

}
if (isset($_POST["processar"])) {

  $_SESSION["DB_desativar_account"] = true;
  $oData   = new DBDate($_POST["sData"]);
  $sData   = $oData->convertTo(DBDate::DATA_EN);

  $oDataFinal = new DBDate($_POST["sDataFinal"]);
  $sDataFinal = $oDataFinal->convertTo(DBDate::DATA_EN);

  $rsErros = fopen('tmp/erros_correcao_lancamentos.txt', 'w');

  try {

    db_inicio_transacao();

    echo "Limpando lançamentos contabeis de Slip<br>";
    flush();

    echo "Iniciando Reprocessando da arrecadacao de Slip<br>";
    flush();
    db_inicio_transacao();

    $sSqlReceita = "SELECT DISTINCT corrente.k12_conta,
                                    corrente.k12_valor,
                                    slip.k17_codigo AS slip,
                                    k153_slipoperacaotipo AS slipoperacaotipo,
                                    corrente.k12_id AS id,
                                    corrente.k12_autent AS codautent,
                                    corrente.k12_data AS DATA,
                                    corrente.k12_estorn AS estorno,
                                    cardeb.k131_concarpeculiar AS cpdebito,
                                    carcre.k131_concarpeculiar AS cpcredito,
                                    k153_slipoperacaotipo AS tipooperacaonovo,
                                    cls.c84_conlancam AS lancam
                    FROM corrente
                    INNER JOIN corlanc ON corlanc.k12_id = corrente.k12_id
                    AND corlanc.k12_data = corrente.k12_data
                    AND corlanc.k12_autent = corrente.k12_autent
                    INNER JOIN slip ON slip.k17_codigo = corlanc.k12_codigo
                    INNER JOIN conplanoreduz ON slip.k17_debito = conplanoreduz.c61_reduz
                    AND conplanoreduz.c61_anousu = {$iAno}
                    INNER JOIN conplano ON conplanoreduz.c61_anousu = conplano.c60_anousu
                    AND conplanoreduz.c61_codcon = conplano.c60_codcon
                    LEFT JOIN sliptipooperacaovinculo ON sliptipooperacaovinculo.k153_slip = corlanc.k12_codigo
                    LEFT JOIN conlancamcorrente ON (c86_id,c86_data,c86_autent) = (corrente.k12_id, corrente.k12_data, corrente.k12_autent)
                    LEFT JOIN conlancamslip cls ON cls.c84_conlancam = conlancamcorrente.c86_conlancam
                    LEFT JOIN slipconcarpeculiar cardeb ON cardeb.k131_slip = slip.k17_codigo AND cardeb.k131_tipo = 1
                    LEFT JOIN slipconcarpeculiar carcre ON carcre.k131_slip = slip.k17_codigo AND carcre.k131_tipo = 2
                    WHERE corrente.k12_data BETWEEN '{$sData}' AND '{$sDataFinal}'
                      AND corrente.k12_instit = ".db_getsession("DB_instit")."
                      AND slip.k17_debito<>slip.k17_credito
                      AND cls.c84_conlancam IS NOT NULL
                    ORDER BY corrente.k12_data, corrente.k12_id, corrente.k12_autent";

    //die($sSqlReceita);
    $rsReceitas   = db_query($sSqlReceita);
    //db_criatabela($rsReceitas);exit;
    $iTotalLinhas = pg_num_rows($rsReceitas);

    echo "<pre>";
    $aSlipIncluidosTipo = array();
    $aSlipConcar        = array();
    $aSlipOperacao      = array();
    for ($i = 0; $i < $iTotalLinhas; $i++) {

        $oDadosAutenticacao = db_utils::fieldsMemory($rsReceitas, $i);

        $sSqlDelLancSlip  = "drop table if EXISTS  w_lancamentos; ";
        $sSqlDelLancSlip .= "create temporary table w_lancamentos on commit drop as ";
        $sSqlDelLancSlip .= "SELECT c84_conlancam AS lancam, c69_sequen AS seqlan FROM conlancamslip INNER JOIN conlancamval on c84_conlancam = c69_codlan WHERE c84_conlancam IN ($oDadosAutenticacao->lancam);";
        $sSqlDelLancSlip .= "DELETE FROM conlancamemp WHERE c75_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancambol WHERE c77_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamcgm WHERE c76_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamdig WHERE c78_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamdoc WHERE c71_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamdot WHERE c73_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamord WHERE c80_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamrec WHERE c74_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM contacorrentedetalheconlancamval WHERE c28_conlancamval IN (SELECT seqlan FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM contacorrentedetalhe WHERE c19_sequencial IN (SELECT c28_contacorrentedetalhe FROM contacorrentedetalheconlancamval WHERE c28_conlancamval IN (SELECT seqlan FROM w_lancamentos)); ";        
        $sSqlDelLancSlip .= "DELETE FROM conlancamval WHERE c69_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamcompl WHERE c72_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancampag WHERE c82_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamslip WHERE c84_conlancam IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancaminstit WHERE c02_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamordem WHERE c03_codlan IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancamcorrente WHERE c86_conlancam IN (SELECT lancam FROM w_lancamentos); ";
        $sSqlDelLancSlip .= "DELETE FROM conlancam WHERE c70_codlan IN (SELECT lancam FROM w_lancamentos); ";

         $rsDelLancSlip   = db_query($sSqlDelLancSlip);
         if ( ! $rsDelLancSlip) {
             throw new Exception("Erro ao excluir os dados nas tabelas para o Slip {$oDadosAutenticacao->slip} tipoOP: {$oDadosAutenticacao->tipooperacaonovo}".pg_last_error());
         }

       $lEstorno           = $oDadosAutenticacao->estorno == 't' ? true : false;

       echo "Slip {$oDadosAutenticacao->slip} processando {$oDadosAutenticacao->data} - AUT:{$oDadosAutenticacao->codautent} ID:{$oDadosAutenticacao->id}\n";
       flush();

       if ($oDadosAutenticacao->slipoperacaotipo == '' && !in_array($oDadosAutenticacao->slip, $aSlipIncluidosTipo)) {

         $sSqlInsertSlip = "insert into sliptipooperacaovinculo (k153_slip, k153_slipoperacaotipo) values ({$oDadosAutenticacao->slip}, {$oDadosAutenticacao->tipooperacaonovo}) ";
         $rsInsertSlip   = db_query($sSqlInsertSlip);
         if ( ! $rsInsertSlip) {
           throw new Exception("Erro ao ao inserir os dados na tabela para o slip {$oDadosAutenticacao->slip} tipoOP: {$oDadosAutenticacao->tipooperacaonovo}");
         }
         $aSlipIncluidosTipo[] = $oDadosAutenticacao->slip;
         $oDadosAutenticacao->slipoperacaotipo = $oDadosAutenticacao->tipooperacaonovo;

       }
       $aSlipOperacao[$oDadosAutenticacao->slip] = $oDadosAutenticacao->tipooperacaonovo;
       $iTipoVerificar = $aSlipOperacao[$oDadosAutenticacao->slip];
       if ($lEstorno) {

         switch ($aSlipOperacao[$oDadosAutenticacao->slip]) {

           case 1:
             $iTipoVerificar = 2;
           break;

           case 3:
             $iTipoVerificar = 4;
             break;

           case 5:
             $iTipoVerificar = 6;
             break;

           case 7:

             $iTipoVerificar = 8;
             break;

           case 9:
             $iTipoVerificar = 10;
             break;


           case 11:

             $iTipoVerificar = 12;
             break;

            case 13:

              $iTipoVerificar = 14;
              break;

            case 15:
              $iTipoVerificar = 16;
              break;
         }
       }

       echo "Valor : {$oDadosAutenticacao->k12_valor} -- {$iTipoVerificar} <br>";

       if (!in_array($oDadosAutenticacao->slip, $aSlipConcar)) {

         if ($oDadosAutenticacao->cpdebito == "") {

           $sSqlInsertCPDebito = "insert into slipconcarpeculiar (k131_sequencial, k131_slip,k131_tipo, k131_concarpeculiar)
                                       values (nextval('slipconcarpeculiar_k131_sequencial_seq'),
                                              {$oDadosAutenticacao->slip},
                                              1,
                                             '000')";

           $rsInsertDebito = db_query($sSqlInsertCPDebito);
           if ( ! $rsInsertDebito) {
             throw new Exception("Erro ao ao inserir os dados na tabela slipconcarpeculiar a debito para o slip {$oDadosAutenticacao->slip} ");
           }
           $aSlipConcar[] = $oDadosAutenticacao->slip;
         }

         if ($oDadosAutenticacao->cpcredito == "") {

           $sSqlInsertCPCredito = "insert into slipconcarpeculiar (k131_sequencial, k131_slip,k131_tipo, k131_concarpeculiar)
                                         values (nextval('slipconcarpeculiar_k131_sequencial_seq'),
                                         {$oDadosAutenticacao->slip},
                                         2,
                                         '000')";

           $rsInsertCredito = db_query($sSqlInsertCPCredito);
           if ( ! $rsInsertCredito) {
             throw new Exception("Erro ao ao inserir os dados na tabela slipconcarpeculiar a credito para o slip {$oDadosAutenticacao->slip} ");
           }
           $aSlipConcar[] = $oDadosAutenticacao->slip;
         }
       }
       $oTransferencia = TransferenciaFactory::getInstance($iTipoVerificar, $oDadosAutenticacao->slip);
       $oTransferencia->setIDTerminal($oDadosAutenticacao->id);
       $oTransferencia->setDataAutenticacao($oDadosAutenticacao->data);
       $oTransferencia->setNumeroAutenticacao($oDadosAutenticacao->codautent);
       $oTransferencia->executarLancamentoContabil($oDadosAutenticacao->data,$lEstorno);

//       var_dump($oTransferencia);

       //fputs($rsErros, "Arrecadacao {$oDadosAutenticacao->k12_numpre} - {$oDadosAutenticacao->data} - AUT:{$oDadosAutenticacao->codautent} ID:{$oDadosAutenticacao->id} não foi efetuado lançamento contábil.\n");

    }

      db_fim_transacao(false);
      echo "Fim do Reprocessamento de Slip <br>";
    flush();

  } catch (Exception $eErro) {

    $sMsg = @str_replace("\n", "\\n", $eErro->getMessage())." ID:{$oDadosAutenticacao->id} AUT:{$oDadosAutenticacao->codautent} Data:{$oDadosAutenticacao->data} Classificacao: {$oDadosAutenticacao->k12_codcla}";
    db_msgbox($sMsg);
    db_fim_transacao(true);
  }
  unset($_SESSION["DB_desativar_account"]);
} else {


}
echo "</pre>";
?>
<html>
<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body style="margin-top: 25px; background-color: #cccccc" >
  <center>
  <div style="display: table">
    <form action="" method="post">
    <fieldset>
      <legend>
        <b>Reprocessamento dos lançamentos Slip do PCASP</b>
      </legend>
      <table>
         <tr>
            <td><b>Data para inicio do processamento:</b></td>
            <td>
              <?php
               db_inputdata('sData', null, null. null, null,true, 'text', 1);
              ?>
              <b>à</b>
              <?php
               db_inputdata('sDataFinal', null, null. null, null,true, 'text', 1);
              ?>

            </td>
         </tr>
      </table>
    </fieldset>
    <p align="center">
    <input type="submit" value='Processar' name='processar' onclick='return confirm("Confirma o processamento dos dados a partir data informada?")'>
    <input type="button" id='btnSlipComCheque' value="Slips com Cheque"/>
    </p>
  </form>
  </div>
  </center>
</body>
<?php
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</html>

<script>
  $('btnSlipComCheque').observe('click',
    function () {
      location.href = "con4_reprocessa_lancamento_slip001.php";
    }
  );
</script>
