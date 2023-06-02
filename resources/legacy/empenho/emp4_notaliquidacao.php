<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_libcontabilidade.php");

require_once ("libs/db_app.utils.php");
db_app::import("exceptions.*");
db_app::import("configuracao.*");
require_once ("model/CgmFactory.model.php");
require_once ("model/CgmBase.model.php");
require_once ("model/CgmJuridico.model.php");
require_once ("model/CgmFisico.model.php");
require_once ("model/Dotacao.model.php");

require_once('model/empenho/EmpenhoFinanceiro.model.php');
require_once(Modification::getFile("classes/ordemPagamento.model.php"));

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->status  = 1;
$oRetorno->message = '';
$oRetorno->erro    = false;

switch ($oParam->exec) {

  case "desconto":

    $iTotNotas = count($oParam->aNotas);

    try {

      if ( $iTotNotas == 0 ) {
        throw new Exception('Erro - Nenhuma nota selecionada');
      }

      db_inicio_transacao();
      $lDesconto = true;

      for ($i = 0; $i < $iTotNotas; $i++) {

        $oNotaLiquidacao = new ordemPagamento($oParam->aNotas[$i]->e50_codord);

        $dtAto = '';

        if (isset($oParam->dtAto) && $oParam->dtAto != '') {
            $dtAto = implode("-", array_reverse(explode("/", $oParam->dtAto)));
        }

        /* #1 - modification: ContratosPADRS */

        $lDesconto = $oNotaLiquidacao->desconto(
          $oParam->aNotas[$i],
          $oParam->aNotas[$i]->nValorDesconto,
          db_stdClass::db_stripTagsJson(utf8_decode($oParam->sMotivo)),
          $oParam->sAto,
          $dtAto
        );

        if ( !$lDesconto ) {
          throw new Exception('Erro ao gerar desconto');
        }
      }

      db_fim_transacao(false);

      $oRetorno->message = "Desconto efetuado com sucesso";

    } catch (Exception $eErro)  {

       db_fim_transacao(true);
       $oRetorno->message = urlencode($eErro->getMessage());
       $oRetorno->status  = 2;

    }
    break;


  case 'verificarPagamento':

    $oEmpenhoFinanceiro = new EmpenhoFinanceiro($oParam->codigo_empenho);
    $oRetorno->possuiPagamento = false;
    if ($oEmpenhoFinanceiro->getValorPago() > 0) {
      $oRetorno->possuiPagamento = true;
    }
    break;


}
echo $oJson->encode($oRetorno);
?>
