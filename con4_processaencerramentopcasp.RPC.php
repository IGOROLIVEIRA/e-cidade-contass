<?php
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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "libs/db_libcontabilidade.php";
require_once "dbforms/db_funcoes.php";
require_once "classes/lancamentoContabil.model.php";

$oParam                 = json_decode(str_replace("\\", "", $_POST["json"]));
$oRetorno               = new stdClass();
$oRetorno->erro         = false;
$oRetorno->sMessage     = '';

$sMensagens = "patrimonial.compras.com4_manifestarinteresseregistroprecoporvalor.";

$aTiposEncerramento = array(
    'rp' => EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR,
    'vp' => EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS,
    'no' => EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE
  );

try {

  db_inicio_transacao();

  switch ($oParam->sExecucao) {

    case "encerramentosRealizados":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
                                                           db_getsession("DB_anousu") );

      $aEncerramentos = $oEncerramentoExercicio->getEncerramentosRealizados();

      $aTiposEncerramentoValor  = array_flip($aTiposEncerramento);
      $oRetorno->aEncerramentos = array(
          $aTiposEncerramentoValor[EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR] => in_array(EncerramentoExercicio::ENCERRAR_RESTOS_A_PAGAR, $aEncerramentos),
          $aTiposEncerramentoValor[EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS] => in_array(EncerramentoExercicio::ENCERRAR_VARIACOES_PATRIMONIAIS, $aEncerramentos),
          $aTiposEncerramentoValor[EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE] => in_array(EncerramentoExercicio::ENCERRAR_SISTEMA_ORCAMENTARIO_CONTROLE, $aEncerramentos)
        );

      break;

    case "processarEncerramento":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
                                                           db_getsession("DB_anousu") );

      if (empty($oParam->sTipo)) {
        throw new Exception("Tipo de encerramento não informado.");
      }

      if (!in_array($oParam->sTipo, array_keys($aTiposEncerramento))) {
        throw new Exception("O Tipo de encerramento informado é inválido.");
      }

      if (empty($oParam->sData)) {
        throw new Exception("Data dos lançamentos não informada.");
      }

      $oDataLancamentos  = new DBDate($oParam->sData);
      $oDataEncerramento = new DBDate( date("d/m/Y", db_getsession("DB_datausu")) );

      $oEncerramentoExercicio->setDataEncerramento($oDataEncerramento);
      $oEncerramentoExercicio->setDataLancamento($oDataLancamentos);

      $oEncerramentoExercicio->encerrar($aTiposEncerramento[$oParam->sTipo]);

      break;

    case "desprocessarEncerramento":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
                                                           db_getsession("DB_anousu") );

      if (empty($oParam->sTipo)) {
        throw new Exception("Tipo de encerramento não informado.");
      }

      if (!in_array($oParam->sTipo, array_keys($aTiposEncerramento))) {
        throw new Exception("O Tipo de encerramento informado é inválido.");
      }

      $oEncerramentoExercicio->cancelar($aTiposEncerramento[$oParam->sTipo]);

      break;

    case "buscarRegras":

      $oEncerramentoExercicio = new EncerramentoExercicio( new Instituicao(db_getsession("DB_instit")),
                                                           db_getsession("DB_anousu") );

      $oRetorno->aRegras = $oEncerramentoExercicio->getRegrasNaturezaOrcamentaria();

      break;

    case "salvarRegra":

      if (empty($oParam->contadevedora)) {
        throw new Exception("Conta Devedora não informada.");
      }

      if (empty($oParam->contacredora)) {
        throw new Exception("Conta Credora não informada.");
      }

      $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();

      $oDaoRegrasEncerramento->c117_sequencial    = null;
      $oDaoRegrasEncerramento->c117_anousu        = db_getsession("DB_anousu");
      $oDaoRegrasEncerramento->c117_instit        = db_getsession("DB_instit");
      $oDaoRegrasEncerramento->c117_contadevedora = $oParam->contadevedora;
      $oDaoRegrasEncerramento->c117_contacredora  = $oParam->contacredora;

      $oDaoRegrasEncerramento->incluir(null);

      if ($oDaoRegrasEncerramento->erro_status == 0) {
        throw new Exception($oDaoRegrasEncerramento->erro_msg);
      }

      break;

    case "removerRegra":

      if (empty($oParam->iCodigoRegra)) {
        throw new Exception("Código da Regra não informado.");
      }

      $oDaoRegrasEncerramento = new cl_regraencerramentonaturezaorcamentaria();

      $oDaoRegrasEncerramento->excluir( null,
                                        "c117_sequencial = {$oParam->iCodigoRegra} "
                                        . "and c117_anousu = " . db_getsession("DB_anousu")
                                        . " and c117_instit = " . db_getsession("DB_instit") );

      if ($oDaoRegrasEncerramento->erro_status == 0) {
        throw new Exception($oDaoRegrasEncerramento->erro_msg);
      }

      break;
  }

  db_fim_transacao(false);

} catch (Exception $eErro){

  db_fim_transacao(true);

  $oRetorno->erro     = true;
  $oRetorno->sMessage = urlencode($eErro->getMessage());
}

echo json_encode($oRetorno);
?>