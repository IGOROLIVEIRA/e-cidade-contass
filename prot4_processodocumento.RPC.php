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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");

define("URL_MENSAGEM_PROT4PROCESSODOCUMENTO", "patrimonial.protocolo.prot4_processodocumento.");
$oJson               = new services_json();
$oParam              = $oJson->decode(str_replace("\\", "", $_POST["json"]));
$oRetorno            = new stdClass();
$oRetorno->iStatus   = 1;
$oRetorno->sMensagem = '';
try {

  /*
   * Início Transação
   */
  db_inicio_transacao();

  switch ($oParam->exec) {

    case "carregarDocumentos":
      $usuario = db_getsession('DB_id_usuario');
      $protocolosigiloso = db_query("select * from protparam");
      $protocolosigiloso = db_utils::fieldsMemory($protocolosigiloso, 0);

      $oProcessoProtocolo    = new processoProtocolo($oParam->iCodigoProcesso);

      $aDocumentosVinculados = $oProcessoProtocolo->getDocumentos();
      $aDocumentosRetorno    = array();
      foreach ($aDocumentosVinculados as $oProcessoDocumento) {

        $oStdDocumento = new stdClass();
        $oStdDocumento->nivelacesso = $oProcessoDocumento->getNivelAcesso();
        if ($oStdDocumento->nivelacesso == null) {
          $oStdDocumento->nivelacesso = "null";
        }
        $oStdDocumento->iCodigoDocumento    = $oProcessoDocumento->getCodigo();
        $oStdDocumento->sDescricaoDocumento = urlencode($oProcessoDocumento->getDescricao());
        $oStdDocumento->iDepart             = $oProcessoDocumento->getDepart();
        $oDepartamento = new DBDepartamento($oProcessoDocumento->getDepart());
        $oStdDocumento->sDepartamento = urlencode($oDepartamento->getNomeDepartamento());
        $oStdDocumento->iDepartUsuario      = db_getsession("DB_coddepto");

        if ($protocolosigiloso->p90_protocolosigiloso == "t") {
          $result = db_query("select * from perfispermanexo
          inner join db_permherda p203_perfil on p203_perfil = id_perfil
          where id_usuario = $usuario and p203_permanexo = $oStdDocumento->nivelacesso;
          ");
          $permissao = pg_num_rows($result);
          if ($permissao == 0) {
            $oStdDocumento->permissao = false;
          } else {
            $oStdDocumento->permissao = true;
          }
        }

        if ($oStdDocumento->nivelacesso == "null") {
          $oStdDocumento->nivelacesso = "";
        }


        $aDocumentosRetorno[] = $oStdDocumento;
      }
      $oRetorno->aDocumentosVinculados = $aDocumentosRetorno;

      $oRetorno->andamento = $oProcessoProtocolo->getHaTramiteInicial($oProcessoProtocolo->getNumeroProcesso(), $oProcessoProtocolo->getAnoProcesso());
      break;

    case "salvarDocumento":

      $erro = false;

      $protocolosigiloso = db_query("select * from protparam");
      $protocolosigiloso = db_utils::fieldsMemory($protocolosigiloso, 0);

      $oProcessoProtocolo = new processoProtocolo($oParam->iCodigoProcesso);
      $oDepartamentoAtual = $oProcessoProtocolo->getDepartamentoAtual();

      if ($oDepartamentoAtual->getCodigo() != db_getsession("DB_coddepto")) {

        $oStdErro = (object)array("sDepartamento" => "{$oDepartamentoAtual->getCodigo()} - {$oDepartamentoAtual->getNomeDepartamento()}");
        if ($protocolosigiloso->p90_protocolosigiloso == "t") {
          $oRetorno->sMensagem = "So o departamento {$oDepartamentoAtual->getCodigo()} - {$oDepartamentoAtual->getNomeDepartamento()} em que o processo se encontra atualmente pode vincular documento.";
          $oRetorno->iStatus   = 2;
          break;
        } else {
          throw new BusinessException(_M(URL_MENSAGEM_PROT4PROCESSODOCUMENTO . "departamento_diferente_vinculo_documento", $oStdErro));
        }
      }
      $oProcessoDocumento = new ProcessoDocumento($oParam->iCodigoDocumento);
      $oProcessoDocumento->setDescricao(db_stdClass::normalizeStringJsonEscapeString($oParam->sDescricaoDocumento));
      $oProcessoDocumento->setProcessoProtocolo($oProcessoProtocolo);
      $oProcessoDocumento->setNivelAcesso($oParam->iNivelAcesso);


      if (!empty($oParam->sCaminhoArquivo)) {
        $oProcessoDocumento->setCaminhoArquivo($oParam->sCaminhoArquivo);
      }

      $oRetorno->sMensagem = urlencode($oProcessoDocumento->salvar());

      break;

    case "excluirDocumento":

      $aDocumentosNaoExcluidos = array();

      foreach ($oParam->aDocumentosExclusao as $iCodigoDocumento) {

        $oProcessoDocumento = new ProcessoDocumento($iCodigoDocumento);

        if ($oProcessoDocumento->getDepart() === db_getsession("DB_coddepto")) {
          $oProcessoDocumento->excluir();
          continue;
        }
        $aDocumentosNaoExcluidos[] = $oProcessoDocumento->getDescricao();
      }

      $sMensagemDeNaoExclusao = "Alguns documentos não foram excluídos pois não" .
        " pertencem ao departamento atual.\n\nDocumentos não excluídos:";
      $sDocumentosNaoExcluidos = '';
      foreach ($aDocumentosNaoExcluidos as $sDocumentoNaoExcluido) {
        $sDocumentosNaoExcluidos .= "\n- $sDocumentoNaoExcluido";
      }

      if (count($aDocumentosNaoExcluidos) === 1) {
        $sMensagemDeNaoExclusao = "Um documento não foi excluído pois não" .
          " pertence ao departamento atual.\n\nDocumento não excluído:";
      }

      if (!empty($aDocumentosNaoExcluidos)) {
        $oRetorno->sMensagem = urlencode($sMensagemDeNaoExclusao . $sDocumentosNaoExcluidos);
      } else {
        $oRetorno->sMensagem = urlencode('Exclusão realizada com sucesso!');
      }

      break;

    case "download":

      $oProcessoDocumento                = new ProcessoDocumento($oParam->iCodigoDocumento);
      $oRetorno->sCaminhoDownloadArquivo = $oProcessoDocumento->download();
      $oRetorno->sTituloArquivo          = urlencode($oProcessoDocumento->getNomeDocumento());

      break;

    case "ziparAnexos":
      $nomeDoZip = 'tmp/anexos-' . time() . '.zip';
      $zip = new ZipArchive();
      if ($zip->open($nomeDoZip, ZipArchive::CREATE) === true) {

        foreach ($oParam->arquivos as $oArquivo) {
          $zip->addFile($oArquivo->sCaminhoDownloadArquivo, $oArquivo->sTituloArquivo);
        }

        $zip->close();
      }

      $oRetorno->nomeDoZip = $nomeDoZip;
      break;

    case "apagarZip":
      if (file_exists($oParam->nomeDoZip) && unlink($oParam->nomeDoZip)) {
        $oRetorno->zipApagado = 1;
      } else {
        $oRetorno->zipApagado = 0;
      }
      break;
  }

  /**
   * Fim Transação
   */
  db_fim_transacao(false);
} catch (Exception $eErro) {

  db_fim_transacao(true);
  $oRetorno->iStatus   = 2;
  $oRetorno->sMensagem = urlencode($eErro->getMessage());
}

echo $oJson->encode($oRetorno);
