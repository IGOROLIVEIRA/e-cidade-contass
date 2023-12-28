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

use App\Models\Acordo;
use App\Models\AcordoItemDotacao;
use App\Models\OrcDotacao;
use Illuminate\Database\Capsule\Manager as DB;

require_once("libs/db_stdlib.php");
require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("std/db_stdClass.php");
require_once("std/DBDate.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");
require_once("libs/db_stdlibwebseller.php");
db_app::import("exceptions.*");

$oRetorno = new stdClass();
$oRetorno->status = 1;
$oRetorno->materiaisSemDotacoes = false;
$oRetorno->todosItensSemDotacoes = false;

$oJson = new services_json();

$oParam = $oJson->decode(str_replace('\\', '', $_POST['json']));

$anoOrigem = (int) $oParam->anoOrigem;

$anoDestino = (int) $oParam->anoDestino;

$acordos = new Acordo();

$orcamentosDotacoes = new OrcDotacao();

$acordoItemDotacao = new AcordoItemDotacao();

if (!isset($oParam->somenteConsulta) && !$oParam->somenteConsulta) {
    $acordosDotacoesAnoOrigem = $acordos
        ->getAcordosDotacoesComPosicoes()
        ->where('orcdotacao.o58_anousu', $anoOrigem)
        ->get();

    $orcamentosDotacoesAnoDestino = $orcamentosDotacoes
        ->getOrcamentosDotacoesAnoDestino($anoOrigem, $anoDestino)
        ->get();

    $resultadoDotacoesAcordosOrcamentos = $acordosDotacoesAnoOrigem
        ->whereIn('estrutural', $orcamentosDotacoesAnoDestino->pluck('estrutural'))->take(3);

    $dotacoesAcordosOrcamentosNaoInseridas = $acordosDotacoesAnoOrigem
        ->whereNotIn('estrutural', $orcamentosDotacoesAnoDestino->pluck('estrutural'));

    $naoEncontrado = $resultadoDotacoesAcordosOrcamentos->isEmpty();

    $oRetorno->message = $naoEncontrado
        ? urlencode('Dotações de contratos alteradas com sucesso!')
        : urlencode("<strong>Usuário:</strong> Foram realizadas as alterações de dotação dos contratos para o ano {$anoDestino}, porém, o estrutural das dotações dos itens dos contratos demonstrados no relatório não foram encontradas em {$anoDestino}. Será necessário realizar a alteração dessas dotações pela rotina:
    <br><strong><em>Módulo Contratos > Procedimentos -> Acordo -> Alteração de Dotação</em></strong>
    <br><strong>O relatório será emitido em instantes. Por favor aguarde!</strong>");

    $oRetorno->naoEncontrado = $naoEncontrado;

    try {
        $tamanhoChunk = 100;
        $resultadoDotacoesArray = $resultadoDotacoesAcordosOrcamentos->toArray();
        $resultadoChunks = array_chunk($resultadoDotacoesArray, $tamanhoChunk);

        DB::beginTransaction();

        foreach ($resultadoChunks as $chunk) {
            $dadosParaInserir = [];

            foreach ($chunk as $dotacao) {
                $duplicados = AcordoItemDotacao::procuraPorCodigoDotacao($dotacao['dotacao'])
                    ->procuraPorAno($oParam->anoDestino)
                    ->procuraPorAcordoItem($dotacao['acordoitem'])
                    ->procuraPorValor($dotacao['valor'])
                    ->procuraPorQuantidade($dotacao['quantidade'])
                    ->get();

                 // Inibir a inserção de dados duplicados no banco.
                if ($duplicados->isEmpty()) {
                    $dadosParaInserir[] = [
                        'ac22_sequencial' => $acordoItemDotacao->getProximoSequencial(),
                        'ac22_coddot' => $dotacao['dotacao'],
                        'ac22_anousu' => (int) $oParam->anoDestino,
                        'ac22_acordoitem' => $dotacao['acordoitem'],
                        'ac22_valor' => $dotacao['valor'],
                        'ac22_quantidade' => $dotacao['quantidade'],
                    ];
                }
            }

            AcordoItemDotacao::insert($dadosParaInserir);
        }

        DB::commit();
    } catch (\Exception $e) {
        DB::rollBack();
        $oRetorno->exception_message = urlencode($e->getMessage());
        $oRetorno->message = urlencode('Erro ao alterar dados das dotações de contratos!');
        $oRetorno->status = 2;
    }
} else {
    $acordosDotacoesBuscaSemPosicoes = $acordos
        ->getItensAcordosDotacoesSemPosicoes()
        ->where('ac16_sequencial', '=', (int) $oParam->codigoAcordo)
        ->get();

    // Verifica se o acordo tem itens cadastrados.
    if ($acordosDotacoesBuscaSemPosicoes->isNotEmpty()) {
        $acordosDotacoes = $acordos
            ->getAcordosDotacoesComPosicoes()
            ->where('ac16_sequencial', '=', (int) $oParam->codigoAcordo)
            ->get();

        $acordosDotacoesAnoOrigem = $acordos
            ->getAcordosDotacoesComPosicoes()
            ->where('ac16_sequencial', '=', (int) $oParam->codigoAcordo)
            ->where('orcdotacao.o58_anousu', $anoOrigem)
            ->get();

        $acordoItensPorAnoOrigem = $acordosDotacoesAnoOrigem
            ->map
            ->only('acordoitem')
            ->pluck('acordoitem')
            ->toArray();

        $acordosComItensComDotacoesRemovidos = $acordosDotacoes
            ->reject(function ($item) use ($acordoItensPorAnoOrigem) {
                return in_array($item['acordoitem'], $acordoItensPorAnoOrigem);
            });

        $itensPorCodigoMaterial = $acordosComItensComDotacoesRemovidos
            ->map
            ->only('codigomaterial')
            ->unique()
            ->pluck('codigomaterial');

        if ($acordosDotacoesAnoOrigem->isEmpty() || $acordosComItensComDotacoesRemovidos->isNotEmpty()) {
            $oRetorno->materiaisSemDotacoes = true;

            if ($acordosDotacoesAnoOrigem->count() > 0 && $acordosDotacoesAnoOrigem->count() < $acordosComItensComDotacoesRemovidos->count()) {
                $somenteItensFormatados = implode(", ", $itensPorCodigoMaterial->toArray());

                $oRetorno->itens = $somenteItensFormatados;
            } else {
                $oRetorno->todosItensSemDotacoes = true;
            }
        }
    }
}

echo $oJson->encode($oRetorno);
