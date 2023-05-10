<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
require_once ("libs/db_sessoes.php");
require_once ("dbforms/db_funcoes.php");
require_once ("libs/JSON.php");

$oJson                  = new services_json();
$oParametros            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno               = new stdClass();
$oRetorno->erro         = false;
$oRetorno->sMessage     = '';

define("MENSAGENS", "tributario.meioambiente.db_frmcondicionante.");

try {

  db_inicio_transacao();

  $iSequencial = null;

  /**
   * Se houver sequencial, a transação será uma alteração
   */
  if (isset($oParametros->iSequencial)) {
    $iSequencial = $oParametros->iSequencial;
  }
  $oCondicionante = new Condicionante($iSequencial);

  switch ($oParametros->sExecucao) {

    case "inserirCondicionanteLicenca":

      $oTipoLicenca   = new TipoLicenca($oParametros->sTipoLicenca);

      $oCondicionante->setTipoLicenca($oTipoLicenca);
      $oCondicionante->setDescricao( db_stdClass::normalizeStringJsonEscapeString( $oParametros->sDescricao ) );
      $oCondicionante->setPadrao($oParametros->lPadrao);

      if (empty($oParametros->iSequencial)) {

        $oCondicionante->incluir(false);
        $oRetorno->sMessage = urlencode(_M( MENSAGENS . 'inclusao_sucesso' ));
      } else {

        $oCondicionante->alterar(false);
        $oRetorno->sMessage = urlencode(_M( MENSAGENS . 'alteracao_sucesso' ));
      }

      break;

    case "inserirCondicionanteAtividade":

      $oCondicionante->setDescricao( db_stdClass::normalizeStringJsonEscapeString( $oParametros->sDescricao ) );
      $oCondicionante->setPadrao("false");

      if (empty($oParametros->iSequencial)) {

        $oCondicionante->incluir(true);
        $sMessage = urlencode(_M( MENSAGENS . 'inclusao_sucesso' ));
      } else {

        CondicionanteAtividadeImpacto::excluir($oParametros->iSequencial);
        $oCondicionante->alterar(true);
        $sMessage = urlencode(_M( MENSAGENS . 'alteracao_sucesso' ));
      }

      foreach ($oParametros->aAtividades as $iChave => $oAtividade) {

        $oCondicionanteAtividadeImpacto = new CondicionanteAtividadeImpacto();
        $oCondicionanteAtividadeImpacto->setAtividadeImpacto(new AtividadeImpacto($oAtividade->sCodigo));
        $oCondicionanteAtividadeImpacto->setCondicionante($oCondicionante);
        $oCondicionanteAtividadeImpacto->incluir();
      }

      $oRetorno->sMessage = $sMessage;
      break;

    case "excluirCondicionante":

      $oCondicionante = new Condicionante($oParametros->iSequencial);
      $oCondicionante->excluir();

      $oRetorno->sMessage = urlencode(_M( MENSAGENS . 'exclusao_sucesso' ));

      break;

    case "pesquisarCondicionanteAtividade":

      $iCodigoCondicionante = $oParametros->iCodigoCondicionante;

      /**
       * Busca as atividades vinculadas a condicionante
       */
      $oCondicionanteAtividadeImpacto = new CondicionanteAtividadeImpacto();
      $aAtividadesLancadas            = $oCondicionanteAtividadeImpacto->getAtividades( $iCodigoCondicionante );

      $oRetorno->aAtividadesLancadas  = $aAtividadesLancadas;
      break;
  }

  db_fim_transacao(false);

} catch (Exception $eErro){

  db_fim_transacao(true);
  $oRetorno->erro     = true;
  $oRetorno->sMessage = urlencode($eErro->getMessage());
}
echo $oJson->encode($oRetorno);