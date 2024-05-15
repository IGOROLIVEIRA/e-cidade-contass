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
//ini_set('display_errors','on');
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");
require_once("dbforms/db_funcoes.php");
require_once("model/ProcessodeComprasAnexo.model.php");
require_once("model/ProcessoComprasDocumento.model.php");
require_once("classes/db_licacontrolenexospncp_classe.php");

define("URL_MENSAGEM_LIC1ANEXOSPNCP", "patrimonial.licitacao.lic1_anexospncp.");

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


        case "salvarDocumento":

            $oProcessoAnexo = new AnexoComprasPNCP($oParam->iCodigoProcesso);
            $oProcessoAnexo->setPcproc($oParam->iCodigoProcesso);
            $oProcessoAnexo->salvar();

            $oProcessocomprasDocumento = new ProcessoComprasDocumento();
            $oProcessocomprasDocumento->setProcessoProtocolo($oProcessoAnexo);
            $oProcessocomprasDocumento->setTipoanexo($oParam->iCodigoDocumento);

            if (!empty($oParam->sCaminhoArquivo)) {
                $oProcessocomprasDocumento->setCaminhoArquivo($oParam->sCaminhoArquivo);
            }

            $oRetorno->sMensagem = urlencode($oProcessocomprasDocumento->salvar());
            break;

        case "carregarDocumentos":

            $oProcessoProtocolo    = new AnexoComprasPNCP($oParam->iCodigoProcesso);
            $aDocumentosVinculados = $oProcessoProtocolo->getDocumentos();
            $aDocumentosRetorno    = array();
            foreach ($aDocumentosVinculados as $oProcesso) {

                $oStdDocumento = new stdClass();
                $oStdDocumento->iCodigoDocumento    = $oProcesso->getCodigo();
                $oStdDocumento->sDescricaoDocumento = urlencode(utf8_decode($oProcesso->getDescricaoTipo()));

                $aDocumentosRetorno[] = $oStdDocumento;
            }
            $oRetorno->aDocumentosVinculados = $aDocumentosRetorno;

            break;

        case "download":

            $oProcessoDocumento                = new ProcessoComprasDocumento($oParam->iCodigoDocumento);
            $oRetorno->sCaminhoDownloadArquivo = $oProcessoDocumento->download();
            $oRetorno->sTituloArquivo          = urlencode($oProcessoDocumento->getNomeDocumento());

            break;

        case "ziparAnexos":
            $nomeDoZip = '/tmp/anexos-' . time() . '.zip';
            $zip = new ZipArchive();
            if ($zip->open($nomeDoZip, ZipArchive::CREATE) === true) {
                foreach ($oParam->arquivos as $oArquivo) {
                    $zip->addFile($oArquivo->sCaminhoDownloadArquivo, $oArquivo->sTituloArquivo);
                }
                $zip->close();
            }

            $oRetorno->nomeDoZip = $nomeDoZip;
            break;

        case "excluir":
            $clliccontroleanexopncp = new cl_liccontroleanexopncp();
            $rsAnexos = $clliccontroleanexopncp->sql_record($clliccontroleanexopncp->sql_query_file(null, " * ", null, "l218_processodecompras = $oParam->iCodigoProcesso and l218_sequencialarquivo = " . $oParam->iCodigoDocumento));

            if(pg_num_rows($rsAnexos)){
                $oRetorno->sMensagem = urlencode('Anexo já enviado ao PNCP, para excluí-lo é necessário que seja primeiro EXCLUÍDO no PNCP.');
            }else{
                $oProcessoDocumento = new ProcessoComprasDocumento($oParam->iCodigoDocumento);
                $oProcessoDocumento->excluir();
                $oRetorno->sMensagem = urlencode('Exclusão realizada com sucesso!');
            }

            break;

        case "alterardocumento":
            $oProcessoDocumento = new ProcessoComprasDocumento();
            $oProcessoDocumento->alterartipo($oParam->iCodigoDocumento, $oParam->itipoanexo);
            $oRetorno->sMensagm = urlencode('Alteração realizada com sucesso!');
            break;

        case "excluirDocumento":
            $aDocumentosNaoExcluidos = array();
            $clliccontroleanexopncp = new cl_liccontroleanexopncp();
            foreach ($oParam->aDocumentosExclusao as $iCodigoDocumento) {
                $rsAnexos = $clliccontroleanexopncp->sql_record($clliccontroleanexopncp->sql_query_file(null, " * ", null, "l218_processodecompras = $oParam->iCodigoProcesso and l218_sequencialarquivo = " . $oParam->iCodigoDocumento));
                if(pg_num_rows($rsAnexos)){
                    $oRetorno->sMensagem = urlencode('Anexo já enviado ao PNCP, para excluí-lo é necessário que seja primeiro EXCLUÍDO no PNCP.');
                }else {
                    $oProcessoDocumento = new ProcessoComprasDocumento($iCodigoDocumento);
                    $oProcessoDocumento->excluir();
                }
            }
            $oRetorno->sMensagem = urlencode('Exclusão realizada com sucesso!');
            break;

        case "buscardocumento":
            $oProcessoDocumento = new ProcessoComprasDocumento($oParam->iCodigoDocumento);
            $oRetorno->idtipo = $oProcessoDocumento->buscartipo();
            break;

        case "verifica":
            $oProcessoDocumento = new ProcessoComprasDocumento();
            $oRetorno->idtipo = $oProcessoDocumento->verificavinculo($oParam->iCodigoDocumento);
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
