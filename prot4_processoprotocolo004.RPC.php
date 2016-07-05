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
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("libs/JSON.php");
require_once("std/db_stdClass.php");

$oJson = new services_json();
$oParametro = $oJson->decode(str_replace("\\", "", $_POST['json']));

$oRetorno = new stdClass();
$oRetorno->lErro = false;
$oRetorno->sMensagem = "";

try {

    switch ($oParametro->exec) {

        /**
         * Salva os dados da regra em um documento
         */
        case "getDadosProcessoProtocolo":

            $iAnoSessao = db_getsession("DB_anousu");
            $aDadosProcesso = explode("/", $oParametro->sNumeroProcesso);

            if (count($aDadosProcesso) == 2) {
                $iAnoSessao = $aDadosProcesso[1];
            }
            $oInstituicao = InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit'));
            $oProcessoProtocolo = processoProtocolo::getInstanciaPorNumeroEAno($aDadosProcesso[0], $iAnoSessao, $oInstituicao);

            if (!$oProcessoProtocolo) {
                throw new Exception("Processo de protocolo ({$aDadosProcesso[0]}/{$iAnoSessao}) não encontrado.");
            }

            $oRetorno->iSequencialProcesso = $oProcessoProtocolo->getCodProcesso();
            $oRetorno->iNumeroProcesso = $aDadosProcesso[0];
            $oRetorno->iAnoProcesso = $iAnoSessao;
            $oRetorno->sRequerenteProcesso = urlencode($oProcessoProtocolo->getRequerente());

            break;

        case 'getMovimentacoesProcesso' :

            require_once 'model/protocolo/RefactorConsultaProcessoProtocolo.model.php';
            $aDadposApensado = apensado($oParametro->iCodigoProcesso);
            $aCodigosProcessos = array($oParametro->iCodigoProcesso, $aDadposApensado[0]['p30_procprincipal']);
            $aMovimentacoes = array();
            if (count($aCodigosProcessos) > 1) {
                foreach ($aCodigosProcessos as $codigo) {
                    $oRefactorProcessoProtocolo = new RefactorConsultaProcessoProtocolo($codigo);
                    array_push($aMovimentacoes, $oRefactorProcessoProtocolo->getMovimentacoes());
                }
            } else {
                $oRefactorProcessoProtocolo = new RefactorConsultaProcessoProtocolo($oParametro->iCodigoProcesso);
                $aMovimentacoes = $oRefactorProcessoProtocolo->getMovimentacoes();
            }
            $oRetorno->aMovimentacoes = array();

            /**
             * Passa urlEncode() em todas as propriedades dos movimentos
             */
            if (count($aMovimentacoes) > 0) {
                for ($i = 0; $i < count($aMovimentacoes); $i++) {
                    foreach ($aMovimentacoes[$i] as $oDadosMovimentacao) {
                        if ($i > 0) {
                            if(date("Y-m-d",strtotime(implode('-', array_reverse(explode('/', $oDadosMovimentacao->sData))))) < date("Y-m-d",strtotime($aDadposApensado[0]['data_processo']))){
                                continue;
                            }
                        }
                        foreach ($oDadosMovimentacao as $sPropridade => $sValor) {
                            $oDadosMovimentacao->$sPropridade = urlEncode($sValor);
                        }
                        $oRetorno->aMovimentacoes[] = $oDadosMovimentacao;
                    }
                }
            }

            break;

        default :
            throw new Exception("Parâmetro inválido");
            break;

    }

} catch (Exception $oErro) {

    db_fim_transacao(true);
    $oRetorno->lErro = true;
    $oRetorno->sMensagem = $oErro->getMessage();
}

$oRetorno->sMensagem = urlencode($oRetorno->sMensagem);
echo $oJson->encode($oRetorno);

/**
 * Verifica se o processo está apensado em outro.
 * @param $processo
 * @return bool
 */

function apensado($processo)
{
    $oDaoProcessosApensados = db_utils::getDao('processosapensados');
    $sCampos = "p30_procprincipal,p58_dtproc as data_processo, cast(p58_numero||'/'||p58_ano as varchar) as codigo_processo, z01_nome as titular,";
    $sCampos .= 'p51_descr as tipo_processo';
    $sWhere = "p30_procapensado = {$processo}";
    $sSqlProcessosApensados = $oDaoProcessosApensados->sql_query_processo_apensado(null, $sCampos, "p58_codproc", $sWhere);
    $rsProcessosApensados = $oDaoProcessosApensados->sql_record($sSqlProcessosApensados);
    return pg_fetch_all($rsProcessosApensados);
}