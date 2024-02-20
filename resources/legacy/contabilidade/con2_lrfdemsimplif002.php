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

use Psr\Log\NullLogger;

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
require_once("classes/db_consexecucaoorc_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");

db_postmemory($HTTP_POST_VARS);
$oPeriodo = new Periodo($o116_periodo);
$clinfocomplementaresinstit = new cl_infocomplementaresinstit();

function mesInicial($o116_periodo){
    if ($o116_periodo == 12) {
        return 7;
    }
    if ($o116_periodo == 13 || $o116_periodo == 16) {
        return 1;
    }
    if ($o116_periodo == 14) {
        return 5;
    }
    if ($o116_periodo == 15) {
        return 9;
    }
}
function mesFinal($o116_periodo){
    if ($o116_periodo == 12) {
        return 6;
    }
    if ($o116_periodo == 13 || $o116_periodo == 16) {
        return 12;
    }
    if ($o116_periodo == 14) {
        return 4;
    }
    if ($o116_periodo == 15) {
        return 8;
    }
}
function diaFinal($o116_periodo){
    if ($o116_periodo == 12 || $o116_periodo == 14) {
        return 30;
    }
    return 31;
}
function anoInicial($o116_periodo, $anoAtual){
    if ($o116_periodo == 12 || $o116_periodo == 14 || $o116_periodo == 15) {
        return $anoAtual - 1;
    }
    return $anoAtual;
}

$mesInicial = mesInicial($o116_periodo);
$mesFinal = mesFinal($o116_periodo);
$diaInicial = 1;
$diaFinal = diaFinal($o116_periodo);
$anoInicial = anoInicial($o116_periodo, $anousu);

$oDataFim = new DBDate("{$anousu}-{$mesFinal}-{$diaFinal}");
$oDataIni = new DBDate("{$anousu}-{$mesInicial}-{$diaInicial}");
$oDataIni = new DBDate($anoInicial . "-" . $mesInicial . "-1"); //Aqui pego o primeiro dia do mes para montar a nova data de inicio
$dtini = $oDataIni->getDate();
$dtfim = $oDataFim->getDate();

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",", $instits);
$soma = 0;
if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}

$iRpps = 0;
foreach ($aInstits as $iInstit) {
    $instit = new Instituicao($iInstit);
    if ($instit->getTipoInstit() == Instituicao::TIPO_INSTIT_RPPS)
        $iRpps = 1;
}

/**
 * pego todas as instituições OC10823;
 */
$rsInstits = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_instit,si09_tipoinstit", null, null));

$ainstitunticoes = array();
for ($i = 0; $i < pg_num_rows($rsInstits); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsInstits, $i);
    $ainstitunticoes[] = $odadosInstint->si09_instit;
}
$iInstituicoes = implode(',', $ainstitunticoes);

$rsTipoinstit = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_sequencial,si09_tipoinstit", null, "si09_instit in( {$instits})"));

/**
 * busco o tipo de instituicao
 */
$ainstitunticoes = array();
$aTipoistituicao = array();

for ($i = 0; $i < pg_num_rows($rsTipoinstit); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsTipoinstit, $i);
    $aTipoistituicao[] = $odadosInstint->si09_tipoinstit;
    $iCont = pg_num_rows($rsTipoinstit);
}

/**
 * Verifico institu para retornar o percentual Permitido pela Lei Complementar
 */
$iVerifica = null;

if ($iCont == 1 && in_array("1", $aTipoistituicao)) {
    $iVerifica = 1;
} elseif ($iCont >= 1 && !(in_array("1", $aTipoistituicao))) {
    $iVerifica = 2;
} else {
    $iVerifica = 3;
}

/**
 * Adição de filtro no relatório para buscar valor empenhado líquido
 * Além do liquidado que já buscava anteriormente
 * */
$valoresperado = $tipoCalculo == 1 ? "empenhado" : "liquidado";
$valorcalculoManual = $tipoCalculo == 1 ? "sum(c233_valorempenhado) as {$valoresperado}" : "sum(c233_valorliquidado) as {$valoresperado}";
$valorcalculo = $tipoCalculo == 1 ? "sum(empenhado) - sum(anulado) as {$valoresperado}" : "sum(liquidado) as {$valoresperado}";

db_inicio_transacao();
function getDespesasReceitas($iInstituicoes, $dtini, $dtfim, $iRpps)
{
    $fTotalarrecadado = 0;
    $fCSACRPPS = 0; //412102907
    $fCSICRPPS = 0; //412102909
    $fCPRPPS = 0; //412102911
    $fRRCSACOPSJ = 0; //412102917
    $fRRCSICOPSJ = 0; //412102918
    $fRRCPPSJ = 0; //412102919
    $fCFRP = 0; //4192210
    $fRARP = 0;
    $fOPCIE = 0;

    $db_filtro = " o70_instit in({$iInstituicoes}) ";
    $anousu = db_getsession("DB_anousu");
    $anousu_aux = $anousu - 1;
    $dtfim_aux  = $anousu_aux . '-12-31';

    // DADOS DA RECEITA NO ANO ANTERIOR
    if (temDataImplantacao($dtini)) {
        $oUltimoano = db_utils::getColectionByRecord(db_receitasaldo(11, 1, 3, true, $db_filtro, $anousu - 1, buscarDataImplantacao(), $dtfim_aux, false, ' * ', true, 0));
    } else {
        $oUltimoano = db_receitasaldo(11, 1, 3, true, $db_filtro, $anousu - 1, $dtini, $dtfim_aux, false, ' * ', true, 0);
        $oUltimoano = db_utils::getColectionByRecord($oUltimoano);
    }

    foreach ($oUltimoano as $oDados) {
        if ($oDados->o57_fonte == "410000000000000") {
            $fTotalarrecadado += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "491000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "495000000000000") {
            $fCSICRPPS += $oDados->saldo_arrecadado;

        }


        if ($oDados->o57_fonte == "419900300000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180311000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180321000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412102919000000") {
            $fRRCPPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "417180800000000") {
            $fCFRP += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "492000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "493000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "496000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "498000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "499000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180100000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180200000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100421000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100422000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100423000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100424000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100431000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100432000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100433000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100434000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100441000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100442000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100443000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100444000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100461000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100462000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100463000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100464000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100471000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100472000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100473000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100474000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100481000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100482000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100483000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100484000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100481000000") {
            $fRRCPPSJ += $oDados->saldo_arrecadado;

        }
    }

    db_query("drop table if exists work_receita");

    // DADOS DA RECEITA NO ANO ATUAL
    if (temDataImplantacao($dtini)) {
        $oAnoatual = getValorReceitaInformado($dtini, buscarDataImplantacao(), $iInstituicoes);

        foreach ($oAnoatual as $oDados) {
            if (substr($oDados->o57_fonte, 0, 2) == "41") {
                $fTotalarrecadado += $oDados->saldo_arrecadado;
            }


            if (substr($oDados->o57_fonte, 0, 3) == "491") {
                $fCSACRPPS += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 3) == "492") {
                $fCSACRPPS += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 3) == "493") {
                $fCSACRPPS += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 3) == "496") {
                $fCSACRPPS += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 3) == "498") {
                $fCSACRPPS += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 3) == "499") {
                $fCSACRPPS += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 3) == "495") {
                $fCSICRPPS += $oDados->saldo_arrecadado;
            }


            if ($oDados->o57_fonte == "412180100000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            // 17051
            if ($oDados->o57_fonte == "412150100000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412150300000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }
            // 17051 **Fim
            if ($oDados->o57_fonte == "412180200000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100421000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100422000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100423000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100424000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100431000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100432000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100433000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100434000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100441000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100442000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100443000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100444000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100461000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100462000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100463000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100464000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100471000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100472000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100473000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100474000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100481000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100482000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100483000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if ($oDados->o57_fonte == "412100484000000") {
                $fRRCSACOPSJ += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 9) == "412100481") {
                $fRRCPPSJ += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 9) == "412180161") {
                $fRRCPPSJ += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 9) == "412180261") {
                $fRRCPPSJ += $oDados->saldo_arrecadado;
            }

            if (substr($oDados->o57_fonte, 0, 7) == "4171808") {
                $fCFRP += $oDados->saldo_arrecadado;
            }
        }

        $oAnoatual = db_utils::getColectionByRecord(db_receitasaldo(11, 1, 3, true, $db_filtro, $anousu, buscarDataImplantacao(), $dtfim, false, ' * ', true, 0));

    } else {
        $dtini_aux = $anousu . '-01-01';
        $oAnoatual = db_receitasaldo(11, 1, 3, true, $db_filtro, $anousu, $dtini_aux, $dtfim, false, ' * ', true, 0);
        $oAnoatual = db_utils::getColectionByRecord($oAnoatual);
    }

    foreach ($oAnoatual as $oDados) {

        if ($oDados->o57_fonte == "410000000000000") {
            $fTotalarrecadado += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "491000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "492000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "493000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "496000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "498000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "499000000000000") {
            $fCSACRPPS += $oDados->saldo_arrecadado;

        }

        // 17051
        if ($oDados->o57_fonte == "412150100000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412150300000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }
        // 17051 **Fim

        if ($oDados->o57_fonte == "495000000000000") {
            $fCSICRPPS += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180100000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180200000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100421000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100422000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100423000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100424000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100431000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100432000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100433000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100434000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100441000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100442000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }


        if ($oDados->o57_fonte == "412100443000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100444000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100461000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100462000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100463000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100464000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100471000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100472000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100473000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100474000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100481000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

          // 17051
          if ($oDados->o57_fonte == "419990300000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412150211000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412155011000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }
        // 17051 *Fim

        if ($oDados->o57_fonte == "412100482000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100483000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100484000000") {
            $fRRCSACOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "419900300000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180311000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180321000000") {
            $fRRCSICOPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "413210400000000") {
            $fRARP += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412100481000000") {
            $fRRCPPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180161000000") {
            $fRRCPPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "412180261000000") {
            $fRRCPPSJ += $oDados->saldo_arrecadado;

        }

        if ($oDados->o57_fonte == "417180800000000") {
            $fCFRP += $oDados->saldo_arrecadado;

        }

    }


    db_query("drop table if exists work_receita");

    return array(
        'fTotalReceitasArrecadadas' => $fTotalarrecadado,
        'fCSACRPPS' => $fCSACRPPS,
        'fCSICRPPS' => $fCSICRPPS,
        'fCPRPPS' => $fCPRPPS,
        'fRRCSACOPSJ' => $fRRCSACOPSJ,
        'fRRCSICOPSJ' => $fRRCSICOPSJ,
        'fRRCPPSJ' => $fRRCPPSJ,
        'fCFRP' => $fCFRP,
        'fRARP' => $fRARP,
        'fOPCIE' =>$fOPCIE
    );
}

$aDespesasReceitas = getDespesasReceitas($iInstituicoes, $dtini, $dtfim, $iRpps);

$fTotalReceitasArrecadadas = $aDespesasReceitas['fTotalReceitasArrecadadas'];
$fCSACRPPS = $aDespesasReceitas['fCSACRPPS'];
$fCSICRPPS = $aDespesasReceitas['fCSICRPPS'];
$fCPRPPS = $aDespesasReceitas['fCPRPPS'];
$fRRCSACOPSJ = $aDespesasReceitas['fRRCSACOPSJ'];
$fRRCSICOPSJ = $aDespesasReceitas['fRRCSICOPSJ'];
$fRRCPPSJ = $aDespesasReceitas['fRRCPPSJ'];
$fRARP = $aDespesasReceitas['fRARP'];
$fCFRP = 0;
$fCFRPB = 0;
$fOPCIE = $aDespesasReceitas['fOPCIE'];

$sWhereDespesa = " o58_instit in({$instits})";
$sWhereReceita = "o70_instit in ({$iInstituicoes})";
//Aqui passo o(s) exercicio(s) e a funcao faz o sql para cada exercicio
if (temDataImplantacao($dtini)) {
    $oNovaData = new DBDate(buscarDataImplantacao());
    criaWorkDotacao($sWhereDespesa, array_keys(DBDate::getMesesNoIntervalo($oNovaData, $oDataFim)), buscarDataImplantacao(), $dtfim);
    //Aqui passo o(s) exercicio(s) e a funcao faz o sql para cada exercicio
    criarWorkReceita($sWhereReceita, array_keys(DBDate::getMesesNoIntervalo($oNovaData, $oDataFim)), buscarDataImplantacao(), $dtfim);
} else {
    criaWorkDotacao($sWhereDespesa, array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $dtini, $dtfim);
    criarWorkReceita($sWhereReceita, array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $dtini, $dtfim);
}

/**
 * mPDF
 * @param string $mode | padrão: BLANK
 * @param mixed $format | padrão: A4
 * @param float $default_font_size | padrão: 0
 * @param string $default_font | padrão: ''
 * @param float $margin_left | padrão: 15
 * @param float $margin_right | padrão: 15
 * @param float $margin_top | padrão: 16
 * @param float $margin_bottom | padrão: 16
 * @param float $margin_header | padrão: 9
 * @param float $margin_footer | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */
$xinstit = split("-",$db_selinstit);
$resultinst = pg_exec("select codigo,nomeinst,nomeinstabrev from db_config where codigo in (".str_replace('-',', ',$db_selinstit).") ");
$descr_inst = '';
$xvirg = '';
$flag_abrev = false;
for($xins = 0; $xins < pg_numrows($resultinst); $xins++){
  db_fieldsmemory($resultinst,$xins);
  if (strlen(trim($nomeinstabrev)) > 0){
       $descr_inst .= $xvirg.$nomeinstabrev;
       $flag_abrev  = true;
  } else {
       $descr_inst .= $xvirg.$nomeinst;
  }

  $xvirg = ', ';
}

if ($flag_abrev == false){
     if (strlen($descr_inst) > 42){
          $descr_inst = substr($descr_inst,0,100);
     }
}

$mPDF = new \Mpdf\Mpdf([
    'mode' => '',
    'format' => 'A4',
    'orientation' => 'L',
    'margin_left' => 15,
    'margin_right' => 15,
    'margin_top' => 23.5,
    'margin_bottom' => 15,
    'margin_header' => 5,
    'margin_footer' => 11,
]);
    $header = "
    <header>
    <div style=\"font-family:Arial\">
        <div style=\"width:33%;float:left;padding:5px;font-size:10px;\">
            <b><i>{$oInstit->getDescricao()}</i></b>
            <br/>
            <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i>
            <br/>
            <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i>
            <br/>
            <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i>
            <br/>
            <i>{$oInstit->getSite()}</i>
        </div>
        <div style=\"width:30%;float:right\" class=\"box\">
        <b>RELATÓRIO DE GESTÃO FISCAL DEMONSTRATIVO SIMPLIFICADO RELATÓRIO DE  GESTÃO FISCAL
        ORCAMENTOS FISCAL E DA SEGURIDADE SOCIAL</b>
        <br/>
    <b>INSTITUIÇÕES:</b> ";
    foreach ($aInstits as $iInstit) {
        $oInstituicao = new Instituicao($iInstit);
        $header .= "(" . trim($oInstituicao->getCodigo()) . ") " . $oInstituicao->getDescricao() . " ";
    }
    $header .= "
                <br/>
                <b>PERÍODO:</b> {$oDataIni->getDate("d/m/Y")} A {$oDataFim->getDate("d/m/Y")}
                <br/>

          </div>
    </header>";


$valorEsperadoUC = ucfirst($valoresperado) . "s";
$footer = "<footer>
<div style='border-top:1px solid #000;width:100%;font-family:sans-serif;font-size:10px;height:10px;'>
    <div style='text-align:left;font-style:italic;width:90%;float:left;'>
        Financeiro>Contabilidade>Demonstrativos Fiscais (LRF)>RGF>Anexo VI - Dem. Simplif. do Relatório de Gestão Fiscal (E, DF, M)
        Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu"))  . "
        </div>

    <div style='text-align:right;float:right;width:10%;'>
        {PAGENO}
    </div>

</div></footer>";


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();
?>

<html>

<head>
    <style type="text/css">
        .ritz .waffle a {
            color: inherit;
        }

        .ritz .waffle .s1 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 0px 3px 0px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s2 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 0px 3px 0px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s4 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 0px 3px 0px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s3 {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 0px 3px 0px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s10 {
            background-color: #d8d8d8;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 0px 3px 0px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s6 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 0px 3px 0px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s7 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 0px 3px 0px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s8 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 0px 3px 0px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s5 {
            background-color: #ffffff;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 0px 3px 0px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s0 {
            background-color: #d8d8d8;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            font-weight: bold;
            padding: 0px 3px 0px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .s9 {
            background-color: #ffffff;
            border-bottom: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            color: #000000;
            direction: ltr;
            font-family: 'Calibri', Arial;
            font-size: 11pt;
            padding: 0px 3px 0px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .column-headers-background {
            background-color: #d8d8d8;
        }
    </style>
</head>

<body>
    <div class="ritz grid-container" dir="ltr">
        <br />
        <table class="waffle" cellspacing="0" cellpadding="0" style="border-top: 1px #000">
            <tbody>
                <?php
                /**
                 * Para cada instit do sql
                 */
                $i = 1;
                $fTotalDespesas = 0;
                foreach ($aInstits as $iInstit) :
                    $oInstit = new Instituicao($iInstit);
                    $fSubTotal = 0;
                    $aDespesas = array();
                    $aDespesas2 = array();
                    if ($tipoEmissao == 1) {
                        if (temDataImplantacao($dtini)) {
                            foreach (getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331', $valorcalculoManual, $oInstit) as $oDespesa) {

                                $chave = substr($oDespesa->o58_elemento, 0, 7);
                                if ($oDespesa->$valoresperado <> 0) {
                                    if (array_key_exists($chave, $aDespesas)) {
                                        $aDespesas[$chave]->$valoresperado += $oDespesa->$valoresperado;
                                    } else {
                                        $aDespesas[$chave] = $oDespesa;
                                    }
                                }
                            }

                            foreach (getSaldoDespesa(null, "o58_elemento, o56_descr, {$valorcalculo}", null, "o58_elemento like '331%' and o58_instit = {$oInstit->getCodigo()} group by 1,2") as $oDespesa) {
                                $chave = substr($oDespesa->o58_elemento, 0, 7);
                                if ($oDespesa->$valoresperado <> 0) {
                                    if (array_key_exists($chave, $aDespesas)) {
                                        $aDespesas[$chave]->$valoresperado += $oDespesa->$valoresperado;
                                    } else {
                                        $aDespesas[$chave] = $oDespesa;
                                    }
                                }
                            }
                        } else {
                            foreach (getSaldoDespesa(null, "o58_elemento, o56_descr, o58_anousu, SUM(empenhado) empenhado, SUM(liquidado) liquidado", null, "o58_elemento like '331%' and o58_instit = {$oInstit->getCodigo()} group by 1,2,3") as $oDespesa) {
                                $chave = $oDespesa->o58_elemento;
                                if ($oDespesa->$valoresperado <> 0) {
                                    if (array_key_exists($chave, $aDespesas)) {
                                        $aDespesas[$chave]->$valoresperado += $oDespesa->$valoresperado;
                                    } else {
                                        $aDespesas[$chave] = $oDespesa;
                                    }
                                }
                            }
                        }

                        // Tratando o acumulado do ano anterior

                        if ($valoresperado == 'liquidado') {
                            foreach (getDespesaMensal("01-01-" . date("Y", strtotime($dtini)), "31-12-" . date("Y", strtotime($dtini)), array($oInstit->getCodigo())) as $data) {
                                $chave = str_pad(substr($data->o58_elemento, 0, 7), 13, "0");
                                if (substr($chave, 1, 2) == "31") {
                                    if ($data->empenhado - $data->liquidado <> 0) {
                                        $aDespesas[$chave]->liquidado += $data->empenhado - $data->liquidado;
                                        $aDespesas[$chave]->o56_descr = $data->o56_descr;
                                    }
                                }
                            }
                        }

                        if ($iRpps) {
                            foreach (getDespesaMensalExclusaoSaldoIntaivosPensionistasProprioDeduzir("01-01-" . date("Y", strtotime($dtini)), "31-12-" . date("Y", strtotime($dtini)), $aInstits) as $data) {
                                $chave = str_pad(substr($data->o58_elemento, 0, 7), 13, "0");
                                if (substr($chave, 1, 2) == "31") {
                                    if ($data->empenhado - $data->liquidado <> 0) {
                                        $aDespesas[$chave]->liquidado -= $data->empenhado - $data->liquidado;
                                        $aDespesas[$chave]->o56_descr = $data->o56_descr;
                                    }
                                }
                            }

                            foreach (getDespesaMensalExclusaoSaldoIntaivosPensionistasProprioDeduzir($dtini, "31-12-" . date("Y", strtotime($dtini)), $aInstits) as $data) {
                                $chave = str_pad(substr($data->o58_elemento, 0, 7), 13, "0");
                                if (substr($chave, 1, 2) == "31") {
                                    if ($data->empenhado - $data->liquidado <> 0) {
                                        if ($valoresperado == 'liquidado')
                                            $aDespesas[$chave]->liquidado -= $data->empenhado - $data->liquidado;
                                        $aDespesas[$chave]->$valoresperado -= $data->$valoresperado;
                                        $aDespesas[$chave]->o56_descr = $data->o56_descr;
                                    }
                                }
                            }

                            foreach (getDespesaMensalExclusaoSaldoIntaivosPensionistasProprioDeduzir("01-01-" . date("Y", strtotime($dtfim)), $dtfim, $aInstits) as $data) {
                                $chave = str_pad(substr($data->o58_elemento, 0, 7), 13, "0");
                                if (substr($chave, 1, 2) == "31") {
                                    if ($data->empenhado - $data->liquidado <> 0) {
                                        if ($valoresperado == 'liquidado')
                                            $aDespesas[$chave]->liquidado -= $data->empenhado - $data->liquidado;
                                        $aDespesas[$chave]->$valoresperado -= $data->$valoresperado;
                                        $aDespesas[$chave]->o56_descr = $data->o56_descr;
                                    }
                                }
                            }
                        }

                        ksort($aDespesas);

                        foreach ($aDespesas as $oDespesa) :
                            if ($oDespesa->o58_elemento == '3317170000000') {
                                $oDespesa->liquidado = $oDespesa->liquidado;
                            }
                            $fSubTotal += $oDespesa->$valoresperado;
                        ?>
                        <?php endforeach;

                        ?>
                        <?php
                        if (temDataImplantacao($dtini)) {
                            foreach (getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3339034', $valorcalculoManual, $oInstit) as $oDespesa) {
                                $chave = $oDespesa->o58_elemento;
                                if (array_key_exists($chave, $aDespesas)) {
                                    $aDespesas2[$chave]->$valoresperado += $oDespesa->$valoresperado;
                                } else {
                                    $aDespesas2[$chave] = $oDespesa;
                                }
                            }
                            foreach (getSaldoDespesa(null, "o58_elemento, o56_descr, SUM({$valoresperado}) {$valoresperado} ", null, "o58_elemento like '3339034%' and o58_instit = {$oInstit->getCodigo()} group by 1,2") as $oDespesa) {
                                $chave = $oDespesa->o58_elemento;
                                if (array_key_exists($chave, $aDespesas)) {
                                    $aDespesas2[$chave]->$valoresperado += $oDespesa->$valoresperado;
                                } else {
                                    $aDespesas2[$chave] = $oDespesa;
                                }
                            }
                        } else {
                            foreach (getSaldoDespesa(null, "o58_elemento, o56_descr, SUM({$valoresperado}) {$valoresperado} ", null, "o58_elemento like '3339034%' and o58_instit = {$oInstit->getCodigo()} group by 1,2") as $oDespesa) {
                                $chave = $oDespesa->o58_elemento;

                                if ($oDespesa->$valoresperado <> 0) {
                                    if (array_key_exists($chave, $oDespesa)) {
                                        $aDespesas2[$chave]->$valoresperado += $oDespesa->$valoresperado;
                                    } else {
                                        $aDespesas2[$chave] = $oDespesa;
                                    }
                                }
                            }
                        }

                        if ($valoresperado == 'liquidado') {
                            foreach (getDespesaMensal("01-01-" . date("Y", strtotime($dtini)), "31-12-" . date("Y", strtotime($dtini)), array($oInstit->getCodigo())) as $data) {
                                $chave = str_pad(substr($data->o58_elemento, 0, 7), 13, "0");
                                if (substr($chave, 0, 7) == "3339034") {
                                    if ($data->empenhado - $data->liquidado <> 0) {
                                        $aDespesas2[$chave]->liquidado += $data->empenhado - $data->liquidado;
                                        $aDespesas2[$chave]->o56_descr = $data->o56_descr;
                                    }
                                }
                            }
                        }

                        foreach ($aDespesas2 as $oDespesa) :
                            $fSubTotal += $oDespesa->$valoresperado;
                        ?>

                    <?php endforeach;
                    } else {
                    }
                        $fTotalDespesas += $fSubTotal;?>
                <?php endforeach; ?>
                            <?php
                            $fSaldoIntaivosPensionistasProprio = 0;
                            foreach ($aInstits as $iInstit) {
                                $oInstit = new Instituicao($iInstit);
                                if ($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_RPPS) {
                                    if (temDataImplantacao($dtini)) {
                                        $aSaldoEstrut1 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331900101', $valorcalculoManual, $oInstit);
                                        $aSaldoEstrut2 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331900301', $valorcalculoManual, $oInstit);
                                        $aSaldoEstrut3 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331900501', $valorcalculoManual, $oInstit);
                                        $aSaldoEstrut4 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331900502', $valorcalculoManual, $oInstit);

                                        $fSaldoIntaivosPensionistasProprio += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado + $aSaldoEstrut4[0]->$valoresperado;

                                        $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331900101%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                        $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331900301%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                        $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331900501%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                        $aSaldoEstrut4 = getSaldoDesdobramento("c60_estrut LIKE '331900502%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                    } else {
                                        $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331900101%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                        $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331900301%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                        $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331900501%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                        $aSaldoEstrut4 = getSaldoDesdobramento("c60_estrut LIKE '331900502%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "103, 203", "");
                                    }
                                    $fSaldoIntaivosPensionistasProprio += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado + $aSaldoEstrut4[0]->$valoresperado;
                                }
                            }
                            ?>
                        <?php
                        $fSaldoSentencasJudAnt = 0;
                        foreach ($aInstits as $iInstit) {
                            $oInstit    = new Instituicao($iInstit);
                            $sCampos    = " e60_numemp,
                                    o58_elemento,
                                    o56_descr,
                                    COALESCE(SUM(CASE
                                        WHEN C53_TIPO = 20 THEN ROUND(C70_VALOR,2)::FLOAT8
                                        WHEN C53_TIPO = 21 THEN ROUND(C70_VALOR*-1,2)::FLOAT8
                                        ELSE 0::FLOAT8
                                    END),0) AS liquidado,
                                    COALESCE(SUM(CASE
                                        WHEN c53_tipo = 10 THEN ROUND(c70_valor, 2)
                                        WHEN c53_tipo = 11 THEN ROUND(c70_valor * -(1::FLOAT8),2)
                                        ELSE 0::FLOAT8
                                    END),0) AS empenhado";

                            if (temDataImplantacao($dtini)) {
                                $aSaldoEstrut1 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319091', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut2 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319191', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut3 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319691', $valorcalculoManual, $oInstit);

                                for ($i = 1; $i <= 3; $i++) {
                                    $aSaldoEstrut   = 'aSaldoEstrut' . $i;
                                    $oSaldEstrut    = 'oSaldEstrut' . $i;

                                    foreach ($$aSaldoEstrut as $$oSaldEstrut) {
                                        $fSaldoSentencasJudAnt += $$oSaldEstrut->$valoresperado;
                                    }
                                }

                                $aSaldoEstrut1 = getSaldoDespesaSentenca(null, $sCampos, null, "o58_elemento like '3319091%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' and c75_data BETWEEN '{$dtini}' AND '{$dtfim}' group by 1,2,3");
                                $aSaldoEstrut2 = getSaldoDespesaSentenca(null, $sCampos, null, "o58_elemento like '3319191%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' and c75_data BETWEEN '{$dtini}' AND '{$dtfim}' group by 1,2,3");
                                $aSaldoEstrut3 = getSaldoDespesaSentenca(null, $sCampos, null, "o58_elemento like '3319691%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' and c75_data BETWEEN '{$dtini}' AND '{$dtfim}' group by 1,2,3");
                            } else {
                                $aSaldoEstrut1 = getSaldoDespesaSentenca(null, $sCampos, null, "o58_elemento like '3319091%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' and c75_data BETWEEN '{$dtini}' AND '{$dtfim}'  group by 1,2,3");
                                $aSaldoEstrut2 = getSaldoDespesaSentenca(null, $sCampos, null, "o58_elemento like '3319191%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' and c75_data BETWEEN '{$dtini}' AND '{$dtfim}' group by 1,2,3");
                                $aSaldoEstrut3 = getSaldoDespesaSentenca(null, $sCampos, null, "o58_elemento like '3319691%' and o58_instit = {$oInstit->getCodigo()} and e60_datasentenca < '{$dtini}' and c75_data BETWEEN '{$dtini}' AND '{$dtfim}' group by 1,2,3");
                            }

                            for ($i = 1; $i <= 3; $i++) {

                                $aSaldoEstrut   = 'aSaldoEstrut' . $i;
                                $oSaldEstrut    = 'oSaldEstrut' . $i;

                                foreach ($$aSaldoEstrut as $$oSaldEstrut) {
                                    $fSaldoSentencasJudAnt += $$oSaldEstrut->$valoresperado;
                                }
                            }
                        }

                        ?>
                        <?php
                        $fSaldoDespesasAnteriores = 0;

                        foreach ($aInstits as $iInstit) {
                            $oInstit = new Instituicao($iInstit);
                            if (temDataImplantacao($dtini)) {
                                $aSaldoEstrut1 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319092', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut2 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319192', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut3 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319692', $valorcalculoManual, $oInstit);

                                $fSaldoDespesasAnteriores += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado;

                                $aSaldoEstrut1 = getDespesaExercAnterior(buscarDataImplantacao(), $oInstit->getCodigo(), "3319092%");
                                $aSaldoEstrut2 = getDespesaExercAnterior(buscarDataImplantacao(), $oInstit->getCodigo(), "3319192%");
                                $aSaldoEstrut3 = getDespesaExercAnterior(buscarDataImplantacao(), $oInstit->getCodigo(), "3319692%");
                            } else {
                                $aSaldoEstrut1 = getDespesaMensalSaldoDespesasAnteriores($dtini, $dtini, $oInstit->getCodigo(), $dtini, "3319092%");
                                $aSaldoEstrut2 = getDespesaMensalSaldoDespesasAnteriores($dtini, $dtini, $oInstit->getCodigo(), $dtini, "3319192%");
                                $aSaldoEstrut3 = getDespesaMensalSaldoDespesasAnteriores($dtini, $dtini, $oInstit->getCodigo(), $dtini, "3319692%");
                                }
                            $fSaldoDespesasAnteriores += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado;
                        }
                        ?>

            <? if ($anousu <= 2018) { ?>
                            <?php
                            $fSaldoAposentadoriaPensoesTesouro = 0;
                            foreach ($aInstits as $iInstit) {
                                $oInstit = new Instituicao($iInstit);
                                if ($oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_PREFEITURA || $oInstit->getTipoInstit() == Instituicao::TIPO_INSTIT_CAMARA) {
                                    if (temDataImplantacao($dtini)) {
                                        $aSaldoEstrut1 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319692', $valorcalculoManual, $oInstit);
                                        $aSaldoEstrut2 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319692', $valorcalculoManual, $oInstit);
                                        $aSaldoEstrut3 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '3319692', $valorcalculoManual, $oInstit);

                                        $fSaldo1 = ($aSaldoEstrut1[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut1[0]->o58_anousu <= 2018) ? $aSaldoEstrut1[0]->$valoresperado : 0;
                                        $fSaldo2 = ($aSaldoEstrut2[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut2[0]->o58_anousu <= 2018) ? $aSaldoEstrut2[0]->$valoresperado : 0;
                                        $fSaldo3 = ($aSaldoEstrut3[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut3[0]->o58_anousu <= 2018) ? $aSaldoEstrut3[0]->$valoresperado : 0;
                                        $fSaldoAposentadoriaPensoesTesouro += $fSaldo1 + $fSaldo2 + $fSaldo3;

                                        $aSaldoEstrut1 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr,{$valorcalculo}", null, "o58_elemento like '3319001%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                                        $aSaldoEstrut2 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr, {$valorcalculo}", null, "o58_elemento like '3319003%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                                        $aSaldoEstrut3 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr, {$valorcalculo}", null, "o58_elemento like '3319005%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                                    } else {

                                        $aSaldoEstrut1 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr,{$valorcalculo}", null, "o58_elemento like '3319001%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                                        $aSaldoEstrut2 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr, {$valorcalculo}", null, "o58_elemento like '3319003%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                                        $aSaldoEstrut3 = getSaldoDespesa(null, "o58_anousu, o58_elemento, o56_descr, {$valorcalculo}", null, "o58_elemento like '3319005%' and o58_instit = {$oInstit->getCodigo()} and o58_codigo not in (103, 203) group by 1,2,3");
                                    }
                                    $fSaldo1 = ($aSaldoEstrut1[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut1[0]->o58_anousu <= 2018) ? $aSaldoEstrut1[0]->$valoresperado : 0;
                                    $fSaldo2 = ($aSaldoEstrut2[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut2[0]->o58_anousu <= 2018) ? $aSaldoEstrut2[0]->$valoresperado : 0;
                                    $fSaldo3 = ($aSaldoEstrut3[0]->o58_anousu == substr($dtini, 0, 4) && $aSaldoEstrut3[0]->o58_anousu <= 2018) ? $aSaldoEstrut3[0]->$valoresperado : 0;
                                    $fSaldoAposentadoriaPensoesTesouro += $fSaldo1 + $fSaldo2 + $fSaldo3;
                                }
                            }
                            ?>
            <? } ?>

                        <?php
                        $fSaldoIndenizacaoDemissaoServidores = 0;
                        foreach ($aInstits as $iInstit) {
                            $oInstit = new Instituicao($iInstit);
                            if (temDataImplantacao($dtini)) {
                                $aSaldoEstrut1 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331909401', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut2 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331909403', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut3 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331919401', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut4 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331919403', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut5 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331969401', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut6 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331969403', $valorcalculoManual, $oInstit);

                                $fSaldoIndenizacaoDemissaoServidores += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado + $aSaldoEstrut4[0]->$valoresperado + $aSaldoEstrut5[0]->$valoresperado + $aSaldoEstrut6[0]->$valoresperado;

                                $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331909401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331909403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331919401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                $aSaldoEstrut4 = getSaldoDesdobramento("c60_estrut LIKE '331919403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                $aSaldoEstrut5 = getSaldoDesdobramento("c60_estrut LIKE '331969401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                $aSaldoEstrut6 = getSaldoDesdobramento("c60_estrut LIKE '331969403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                // $fSaldoIndenizacaoDemissaoServidores += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado + $aSaldoEstrut4[0]->$valoresperado + $aSaldoEstrut5[0]->$valoresperado + $aSaldoEstrut6[0]->$valoresperado;

                            } else {
                                if ($valoresperado == 'liquidado') {
                                    $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331909401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataIni)), $oInstit->getCodigo(), "01-01-" . date("Y", strtotime($dtini)), $dtini, "", "");
                                    $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331909403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataIni)), $oInstit->getCodigo(), "01-01-" . date("Y", strtotime($dtini)), $dtini, "", "");
                                    $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331919401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataIni)), $oInstit->getCodigo(), "01-01-" . date("Y", strtotime($dtini)), $dtini, "", "");
                                    $aSaldoEstrut4 = getSaldoDesdobramento("c60_estrut LIKE '331919403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataIni)), $oInstit->getCodigo(), "01-01-" . date("Y", strtotime($dtini)), $dtini, "", "");
                                    $aSaldoEstrut5 = getSaldoDesdobramento("c60_estrut LIKE '331969401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataIni)), $oInstit->getCodigo(), "01-01-" . date("Y", strtotime($dtini)), $dtini, "", "");
                                    $aSaldoEstrut6 = getSaldoDesdobramento("c60_estrut LIKE '331969403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataIni)), $oInstit->getCodigo(), "01-01-" . date("Y", strtotime($dtini)), $dtini, "", "");

                                    $fSaldoIndenizacaoDemissaoServidores += ($aSaldoEstrut1[0]->empenhado - $aSaldoEstrut1[0]->liquidado)
                                        + ($aSaldoEstrut2[0]->empenhado - $aSaldoEstrut2[0]->liquidado)
                                        + ($aSaldoEstrut3[0]->empenhado - $aSaldoEstrut3[0]->liquidado)
                                        + ($aSaldoEstrut4[0]->empenhado - $aSaldoEstrut4[0]->liquidado)
                                        + ($aSaldoEstrut5[0]->empenhado - $aSaldoEstrut5[0]->liquidado)
                                        + ($aSaldoEstrut6[0]->empenhado - $aSaldoEstrut6[0]->liquidado);
                                }

                                $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331909401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                                $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331909403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                                $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331919401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                                $aSaldoEstrut4 = getSaldoDesdobramento("c60_estrut LIKE '331919403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                                $aSaldoEstrut5 = getSaldoDesdobramento("c60_estrut LIKE '331969401%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                                $aSaldoEstrut6 = getSaldoDesdobramento("c60_estrut LIKE '331969403%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                            }
                            $fSaldoIndenizacaoDemissaoServidores += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado + $aSaldoEstrut4[0]->$valoresperado + $aSaldoEstrut5[0]->$valoresperado + $aSaldoEstrut6[0]->$valoresperado;
                        }
                        ?>
                        <?php
                        $fSaldoIncentivosDemissaoVoluntaria = 0;
                        foreach ($aInstits as $iInstit) {
                            $oInstit = new Instituicao($iInstit);
                            if (temDataImplantacao($dtini)) {
                                $aSaldoEstrut1 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331909402', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut2 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331919402', $valorcalculoManual, $oInstit);
                                $aSaldoEstrut3 = getValorDespesaInformado($oDataIni->getDate("Y-m-d"), buscarDataImplantacao(), '331969402', $valorcalculoManual, $oInstit);

                                $fSaldoIncentivosDemissaoVoluntaria += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado;

                                $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331909402%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331919402%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                                $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331969402%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), buscarDataImplantacao(), $dtfim, "", "");
                            } else {
                                $aSaldoEstrut1 = getSaldoDesdobramento("c60_estrut LIKE '331909402%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                                $aSaldoEstrut2 = getSaldoDesdobramento("c60_estrut LIKE '331919402%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                                $aSaldoEstrut3 = getSaldoDesdobramento("c60_estrut LIKE '331969402%'", array_keys(DBDate::getMesesNoIntervalo($oDataIni, $oDataFim)), $oInstit->getCodigo(), $dtini, $dtfim, "", "");
                            }
                            $fSaldoIncentivosDemissaoVoluntaria += $aSaldoEstrut1[0]->$valoresperado + $aSaldoEstrut2[0]->$valoresperado + $aSaldoEstrut3[0]->$valoresperado;
                        }
                        ?>

                        <?php
                        $fTotalDespesaPessoal = $fTotalDespesas - ($fSaldoIntaivosPensionistasProprio + $fSaldoSentencasJudAnt + $fSaldoAposentadoriaPensoesTesouro + $fSaldoDespesasAnteriores + $fSaldoIndenizacaoDemissaoServidores + $fSaldoIncentivosDemissaoVoluntaria);
                        ?>

             <!-- Receitas            -->
            <tr>
                    <td class="" colspan="3">&nbsp;</td>
            </tr>
            <tr>
                <td>
            LRF, art. 48 -Anexo 6
                </td>
            </tr>
            <tr style='height:19px;'>
                    <td class="s1 bdleft bdtop" colspan="1">RECEITA CORRENTE LÍQUIDA</td>
                    <td class="s1 bdleft bdtop" colspan="2">VALOR ATÉ O QUADRIMESTRE/SEMESTRE</td>
            </tr>
            <tr style='height:19px;'>
            <td class="s3 bdleft bdright">Receita Corrente Líquida</td>
            <td class="s5" colspan="2">
                    <?php
                    $fValorManualRCL = getValorManual($codigorelatorio, 1, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                    $fRecCorrLiq = $fTotalReceitasArrecadadas - abs($fCSACRPPS) - abs($fCSICRPPS) - $fCPRPPS - $fRRCSACOPSJ - $fRRCSICOPSJ - $fRARP;
                    $fRCL += $fValorManualRCL == NULL ? $fRecCorrLiq : $fValorManualRCL;
                    echo db_formatar($fRCL, "f");
                    ?>
            </td>
            </tr>
            <tr style='height:19px;'>
                <td class="s3 bdleft bdright">Receita Corrente Líquida Ajustada para Cálculo dos Limites de Endividamento</td>
                <td class="s5" colspan="2">
                <?php
                    if ($oDataFim->getAno() >= 2020) {
                        if (temDataImplantacao($dtini)) {
                            $aSaldoArrecadadoEmenda = getValorReceitaEmendaInformado($dtini, buscarDataImplantacao(), $iInstituicoes, array(1, 4));
                            $fCFRP += $aSaldoArrecadadoEmenda[0]->arrecadado_emenda_parlamentar;
                            $aSaldoArrecadadoEmenda = getSaldoArrecadadoEmendaParlamentar(buscarDataImplantacao(), $dtfim, array(1, 4));
                            $fCFRP += $aSaldoArrecadadoEmenda[0]->arrecadado_emenda_parlamentar;
                        } else {
                            $aSaldoArrecadadoEmenda = getSaldoArrecadadoEmendaParlamentar($dtini, $dtfim, array(1, 4));
                            $fCFRP += $aSaldoArrecadadoEmenda[0]->arrecadado_emenda_parlamentar;
                        }
                    }
                    $fValorManualRCL = getValorManual($codigorelatorio, 2, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                    $fRCLA += $fValorManualRCL == NULL ? ($fRecCorrLiq-$fCFRP) : $fValorManualRCL;
                    echo db_formatar($fRCLA, "f");
                    ?>
                </td>
            </tr>
            <tr style='height:19px;'>
                    <td class="s3 bdleft bdright">Receita Corrente Líquida Ajustada para Cálculo dos Limites da Despesa com Pessoal</td>
                    <td class="s5" colspan="2">
                    <?php
                    if ($oDataFim->getAno() >= 2020) {
                        if (temDataImplantacao($dtini)) {
                            $aSaldoArrecadadoEmenda = getValorReceitaEmendaInformado($dtini, buscarDataImplantacao(), $iInstituicoes, array(2));
                            $fCFRPB += $aSaldoArrecadadoEmenda[0]->arrecadado_emenda_parlamentar;
                            $aSaldoArrecadadoEmenda = getSaldoArrecadadoEmendaParlamentar(buscarDataImplantacao(), $dtfim, array(2));
                            $fCFRPB += $aSaldoArrecadadoEmenda[0]->arrecadado_emenda_parlamentar;
                        } else {
                            $aSaldoArrecadadoEmenda = getSaldoArrecadadoEmendaParlamentar($dtini, $dtfim, array(2));
                            $fCFRPB += $aSaldoArrecadadoEmenda[0]->arrecadado_emenda_parlamentar;
                        }
                    }
                    $fValorManualRCL = getValorManual($codigorelatorio, 3, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                    $fRCLADP += $fValorManualRCL == NULL ? ($fRecCorrLiq-$fCFRPB) : $fValorManualRCL;
                    echo db_formatar($fRCLADP, "f");
                    ?>
                    </td>
            </tr>
            <tr>
                    <td class="s8 bdleft bdtop" colspan="3">&nbsp;</td>
            </tr>
            <tr style='height:19px;'>
                    <td class="s1 bdleft" colspan="1">DESPESA COM PESSOAL</td>
                    <td class="s1 bdleft" colspan="1">VALOR</td>
                    <td class="s1 bdleft" colspan="1">% SOBRE A RCL AJUSTADA</td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Despesa Total com Pessoal - DTP</td>
                        <td class="s5" colspan="1"><?= db_formatar($fTotalDespesaPessoal, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fTotalDespesaPessoal/$fRCLADP)*100, "f")." %"?></td>
            </tr>
            <?
            $fRCLBase = $fRecCorrLiq - $fCFRP - $fCFRPB;
            if ($iVerifica == 1) :
            ?>
                <tr style='height:20px;'>
                    <td class="s3 bdleft bdright">Limite Máximo (incisios I, II e III, art.20 da LRF) - <%></td>
                    <td class="s5"><?php echo db_formatar($fRCLADP * 0.06, "f") ?></td>
                    <td class="s5"><?php echo db_formatar((($fRCLADP * 0.06)/($fRCLADP))*100, "f")." %" ?></td>
                </tr>
                <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite Prudencial (parágrado único, art 22 da LRF) - <%></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRCLADP * 0.06)*0.95, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRCLADP * 0.06)*0.95)/$fRCLADP)*100, "f")." %" ?></td>
                </tr>
                <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite de Alerta (inciso II do §1º do art.59 da LRF) - <%></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRCLADP * 0.06)*0.90, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRCLADP * 0.06)*0.90)/$fRCLADP)*100, "f")." %" ?></td>
                </tr>
            <?
            elseif ($iVerifica == 2) :
            ?>
                <tr style='height:20px;'>
                    <td class="s3 bdleft bdright">Limite Máximo (incisios I, II e III, art.20 da LRF) - <%></td>
                    <td class="s5"><?php echo db_formatar($fRCLADP * 0.54, "f") ?></td>
                    <td class="s5"><?php echo db_formatar((($fRCLADP * 0.54)/($fRCLADP))*100, "f")." %" ?></td>
                </tr>
                <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite Prudencial (parágrado único, art 22 da LRF) - <%></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRCLADP * 0.54)*0.95, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRCLADP * 0.54)*0.95)/$fRCLADP)*100, "f")." %" ?></td>
                </tr>
                <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite de Alerta (inciso II do §1º do art.59 da LRF) - <%></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRCLADP * 0.54)*0.90, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRCLADP * 0.54)*0.90)/$fRCLADP)*100, "f")." %" ?></td>
                </tr>
            <?
            else :
            ?>
                <tr style='height:20px;'>
                    <td class="s3 bdleft bdright">Limite Máximo (incisios I, II e III, art.20 da LRF) - <%></td>
                    <td class="s5"><?php echo db_formatar($fRCLADP * 0.6, "f") ?></td>
                    <td class="s5"><?php echo db_formatar((($fRCLADP * 0.6)/($fRCLADP))*100, "f")." %" ?></td>
                </tr>
                <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite Prudencial (parágrado único, art 22 da LRF) - <%></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRCLADP * 0.6)*0.95, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRCLADP * 0.6)*0.95)/$fRCLADP)*100, "f")." %" ?></td>
                </tr>
                <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite de Alerta (inciso II do §1º do art.59 da LRF) - <%></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRCLADP * 0.6)*0.90, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRCLADP * 0.6)*0.90)/$fRCLADP)*100, "f")." %" ?></td>
                </tr>
            <?
            endif;
            ?>
            <tr>
                    <td class="s8 bdleft bdtop" colspan="3">&nbsp;</td>
            </tr>
            <tr style='height:19px;'>
                    <td class="s1 bdleft" colspan="1">DÍVIDA CONSOLIDADA</td>
                    <td class="s1 bdleft" colspan="1">VALOR ATÉ O QUADRIMESTRE DE REFERÊNCIA</td>
                    <td class="s1 bdleft" colspan="1">% SOBRE A RCL AJUSTADA</td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Dívida Consolidada Líquida</td>
                        <?
                        $fValorManualRCL = getValorManual($codigorelatorio, 4, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                        $fDCL += $fValorManualRCL == NULL ? 0 : $fValorManualRCL;
                        ?>
                        <td class="s5" colspan="1"><?= db_formatar($fDCL, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fDCL/($fRecCorrLiq-$fCFRP))*100, "f")." %" ?></td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite Definido por Resolução do Senado Federal</td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRecCorrLiq-$fCFRP)*1.2, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRecCorrLiq-$fCFRP)*1.2)/($fRecCorrLiq-$fCFRP))*100, "f")." %" ?></td>
            </tr>

            <tr>
                    <td class="s8 bdleft bdtop" colspan="3">&nbsp;</td>
            </tr>
            <tr style='height:19px;'>
                    <td class="s1 bdleft" colspan="1">GARANTIAS DE VALORES</td>
                    <td class="s1 bdleft" colspan="1">VALOR ATÉ O QUADRIMESTRE DE REFERÊNCIA</td>
                    <td class="s1 bdleft" colspan="1">% SOBRE A RCL AJUSTADA</td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Total de Garantias Concedidas</td>
                        <?
                        $fValorManualRCL = getValorManual($codigorelatorio, 5, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                        $fTGC += $fValorManualRCL == NULL ? 0 : $fValorManualRCL;
                        ?>
                        <td class="s5" colspan="1"><?= db_formatar($fTGC, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fTGC/($fRecCorrLiq-$fCFRP))*100, "f")." %" ?></td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite Definido por Resolução do Senado Federal</td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRecCorrLiq-$fCFRP)*0.22, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRecCorrLiq-$fCFRP)*0.22)/($fRecCorrLiq-$fCFRP))*100, "f")." %" ?></td>
            </tr>

            <tr>
                    <td class="s8 bdleft bdtop" colspan="3">&nbsp;</td>
            </tr>
            <tr style='height:19px;'>
                    <td class="s1 bdleft" colspan="1">OPERAÇÕES DE CRÉDITO</td>
                    <td class="s1 bdleft" colspan="1">VALOR</td>
                    <td class="s1 bdleft" colspan="1">% SOBRE A RCL AJUSTADA</td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Operações de Crédito Internas e Externas</td>
                        <?php
                        $fValorManualRCL = getValorManual($codigorelatorio, 6, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                        $fOPCIE += $fValorManualRCL == NULL ? $fOPCIE : $fValorManualRCL;
                        ?>
                        <td class="s5" colspan="1"><?= db_formatar($fOPCIE, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fOPCIE/$fRCLA)*100, "f")." %" ?></td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite Definido pelo Senado Federal para Operações de Crédito Externas e Internas</td>
                        <td class="s5" colspan="1"><?= db_formatar(($fRCLA)*0.16, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(((($fRCLA*0.16)/$fRCLA)*100), "f")." %" ?></td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Operações de Crédito por Antecipação de Receita</td>
                        <?
                        $fValorManualRCL = getValorManual($codigorelatorio, 7, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                        $fOPCAR += $fValorManualRCL == NULL ? 0 : $fValorManualRCL;
                        ?>
                        <td class="s5" colspan="1"><?= db_formatar($fOPCAR, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar(($fOPCAR/($fRecCorrLiq-$fCFRP))*100, "f")." %" ?></td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright" colspan="1">Limite Definido pela Senado Federal para Operações de Crédito por Antecipação de Receitas</td>
                        <td class="s5" colspan="1"><?= db_formatar($fRCLA * 0.07, "f") ?></td>
                        <td class="s5" colspan="1"><?= db_formatar((($fRCLA*0.07)/$fRCLA)*100, "f")." %" ?></td>
            </tr>
            <tr>
                    <td class="s8 bdleft bdtop" colspan="3">&nbsp;</td>
            </tr>
            <tr style='height:19px;'>
                    <td class="s1 bdleft" >RESTOS A PAGAR</td>
                    <td class="s1 bdleft" >RESTOS A PAGAR <br/>EMPENHADOS E NÃO LIQUIDADOS DO <br/>EXERCÍCIO</td>
                    <td class="s1 bdleft" >DISPONIBILIDADE DE CAIXA <br/>LÍQUIDA (APÓS A INSCRIÇÃO <br/>EM RESTOS A PAGAR NÃO <br/>PROCESSADOS DO <br/>EM RESTOS A PAGAR NÃO <br/>PROCESSADOS<br/></td>
            </tr>
            <tr style='height:19px;'>
                        <td class="s3 bdleft bdright bdtop" colspan="1">Valor Total</td>
                        <?
                        $totalRestos = 0;

                        if($o116_periodo == 13 || $o116_periodo == 16) {
                            $sele_work = ' w.o58_instit in ('.str_replace('-',', ',$db_selinstit).') ';
                            $sqlprinc = db_dotacaosaldo(2,2,4,true,$sele_work,$anousu,$dtini,$dtfim, 8, 0, true,1,true, 'nao');
                            $orguniant = db_formatar($o58_orgao,'orgao').db_formatar($o58_unidade,'unidade');
                            $sqltot = db_resto_a_pagar($sqlprinc);

                            $resulttot = pg_exec($sqltot) or die($sqltot);
                            db_fieldsmemory($resulttot, 0);
                            $totalRestos = $totempenhado - $totanulado - $totliquidado;

                            $where = " c61_instit in ({$instits})" ;
                            $agrupa_estrutural = 1;
                            $result = db_planocontassaldo_matriz($anousu,$dtini,$dtfim,false,$where,'',$agrupa_estrutural);

                            $saldoFinal = 0;
                            for($x = 0; $x < pg_numrows($result);$x++){
                                db_fieldsmemory($result,$x);

                                if($estrutural == 111110000000000 || $estrutural == 111210000000000 || $estrutural == 111310000000000 ||
                                   $estrutural == 111330000000000 || $estrutural == 111340000000000 || $estrutural == 111350000000000 ){
                                    $saldoFinal += $saldo_final;

                                }
                                if($estrutural == 832100000000000 || $estrutural == 218800000000000 || $estrutural == 228800000000000 ||
                                   $estrutural == 853500000000000 ){
                                    $saldoFinal -= $saldo_final;

                                }
                                if($estrutural == 821120100000000 || $estrutural == 821120200000000 || $estrutural == 821130100000000){
                                    $saldoFinal -= $saldo_final;

                                }
                            }
                            $fValorManualRCL = getValorManual($codigorelatorio, 8, $oInstit->getCodigo(), $o116_periodo, $iAnousu);
                            $saldoFinal = $fValorManualRCL == NULL ? $saldoFinal : $fValorManualRCL;

                        }
                        ?>
                        <td class="s3 bdleft bdright bdtop" colspan="1"><?= db_formatar($totalRestos, "f") ?></td>
                        <td class="s3 bdleft bdright bdtop" colspan="1"><?= db_formatar($saldoFinal, "f") ?></td>

            </tr>
            <tr>
                    <td class="s3 bdtop" colspan="3">&nbsp;</td>
            </tr>
            </tr>
        </table>
    </div>
</body>

</html>

<?php
$html = ob_get_contents();
ob_end_clean();
//echo $html;

$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

/* ---- */

db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");

db_fim_transacao();

/**
 * Busca os valores informados na consolidação de consórcios (Contabilidade->Procedimentos->Consolidação de Consórcios)
 * @param DBDate $oDataIni
 * @param DBDate $oDataFim
 * @return int
 * @throws ParameterException
 */
function getConsolidacaoConsorcios(DBDate $oDataIni, DBDate $oDataFim)
{
    $oConsexecucaoorc = new cl_consexecucaoorc();
    $aPeriodo = DBDate::getMesesNoIntervalo($oDataIni, $oDataFim);
    $fTotal = 0;
    foreach ($aPeriodo as $ano => $mes) {
        $sSql = $oConsexecucaoorc->sql_query_file(null, "sum(coalesce(c202_valorliquidado,0)) as c202_valorliquidado", null, "c202_anousu = " . $ano . " and c202_mescompetencia in (" . implode(',', array_keys($mes)) . ")");
        $fTotal += db_utils::fieldsMemory(db_query($sSql), 0)->c202_valorliquidado;
    }

    return $fTotal;
}

/**
 * Busca os valores informados manualmente na aba 'parametros' do relatório
 * @param $iCodRelatorio
 * @param $iLinha
 * @param $iInstit
 * @param $iCodPeriodo
 * @param $iAnousu
 * @return array
 */
function getValorManual($iCodRelatorio, $iLinha, $iInstit, $iCodPeriodo, $iAnousu)
{
    $oLinha = new linhaRelatorioContabil($iCodRelatorio, $iLinha, $iInstit);
    $oLinha->setPeriodo($iCodPeriodo);
    $oLinha->setEncode(true);
    $aValores = $oLinha->getValoresColunas(null, null, null, $iAnousu);
    return $aValores[0]->colunas[0]->o117_valor;
}

function getValorDespesaInformado($inicio, $fim, $elemento, $valorcalculo, $oInstit)
{
    $where = " AND ((c233_mes >= " . date('m', strtotime($inicio)) . " AND c233_ano = " . date('Y', strtotime($inicio)) . ") OR (c233_mes <= " . date('m', strtotime($fim)) . " AND c233_ano = " . date('Y', strtotime($fim)) . "))";
    $whereCompetencia = " AND ((c233_competencia IS NOT NULL AND c233_competencia < '{$inicio}') OR (c233_competencia IS NULL)) ";
    $sql = "SELECT o56_elemento as o58_elemento, o56_descr, c233_ano as o58_anousu, {$valorcalculo} FROM despesaexercicioanterior left join orcelemento on substring(c233_elemento::text, 1, 13) = o56_elemento and c233_ano = o56_anousu WHERE c233_elemento like '{$elemento}%' and c233_orgao = {$oInstit->getCodigo()} {$where} {$whereCompetencia} group by 1,2,3";

    return db_utils::getColectionByRecord(db_query($sql));
}

function getValorReceitaInformado($inicio, $fim, $oInstit)
{
    $where = " AND ((c234_mes >= " . date('m', strtotime($inicio)) . " AND c234_ano = " . date('Y', strtotime($inicio)) . ") OR (c234_mes <= " . date('m', strtotime($fim)) . " AND c234_ano = " . date('Y', strtotime($fim)) . "))";
    $sql = "SELECT c234_receita as o57_fonte, c234_valorarrecadado as saldo_arrecadado FROM receitaexercicioanterior WHERE c234_orgao in ({$oInstit})  {$where}";

    return db_utils::getColectionByRecord(db_query($sql));
}


function getValorReceitaEmendaInformado($inicio, $fim, $oInstit, $emenda)
{
    $where = " AND ((c234_mes >= " . date('m', strtotime($inicio)) . " AND c234_ano = " . date('Y', strtotime($inicio)) . ") OR (c234_mes <= " . date('m', strtotime($fim)) . " AND c234_ano = " . date('Y', strtotime($fim)) . "))";
    $where .= " AND c234_tipoemenda IN (" . implode(",", $emenda) . ") ";
    $sql = "SELECT c234_receita as o57_fonte, c234_valorarrecadado as arrecadado_emenda_parlamentar FROM receitaexercicioanterior WHERE c234_orgao in ({$oInstit})  {$where}";

    return db_utils::getColectionByRecord(db_query($sql));
}

// retorna data da implantacao
function buscarDataImplantacao()
{
    $sSQL = "SELECT c90_dataimplantacao FROM conparametro";
    $rsResult = db_query($sSQL);
    return db_utils::fieldsMemory($rsResult, 0)->c90_dataimplantacao;
}

function temDataImplantacao($dtini)
{
    if (buscarDataImplantacao() AND buscarDataImplantacao() > $dtini) {
        return true;
    }
    return false;
}

function getDespesaMensal($inicio, $fim, $instituicao)
{
    $ano = date("Y", strtotime($inicio));
    $instituicao = implode(",", $instituicao);

    $sql = "SELECT * FROM (SELECT *
    FROM
        (
            SELECT
                o56_elemento AS o58_elemento,
                o56_descr AS o56_descr,
                substr(fc_dotacaosaldo, 29, 12) :: float8 - substr(fc_dotacaosaldo,42,12)::float8 AS empenhado,
                substr(fc_dotacaosaldo, 55, 12) :: float8 AS liquidado
            from
                (
                    SELECT
                        *,
                        fc_dotacaosaldo({$ano}, o58_coddot, 2, '{$inicio}', '{$fim}')
                    FROM
                        orcdotacao w
                        INNER JOIN orcelemento e ON w.o58_codele = e.o56_codele
                        AND e.o56_anousu = w.o58_anousu
                        AND e.o56_orcado IS TRUE
                        INNER JOIN orcprojativ ope ON w.o58_projativ = ope.o55_projativ
                        AND ope.o55_anousu = w.o58_anousu
                        INNER JOIN orctiporec ON orctiporec.o15_codigo = w.o58_codigo
                    WHERE
                        o58_anousu = {$ano}
                        AND o58_instit in ({$instituicao})
                    ORDER BY
                        o56_elemento
                ) AS x
        ) AS xxx
    WHERE
        empenhado + liquidado <> 0 ) as x ";

    return db_utils::getColectionByRecord(db_query($sql));
}

function getDespesaMensalExclusaoSaldoIntaivosPensionistasProprio($inicio, $fim, $instituicao, $iRpps)
{
    $ano = date("Y", strtotime($inicio));
    $instituicao = implode(",", $instituicao);

    $sql = "SELECT * FROM (SELECT
                c60_estrut o58_elemento,
                c60_descr o56_descr,
                COALESCE(
                    SUM(
                        CASE
                            WHEN c53_tipo = 20 THEN ROUND(c70_valor, 2)
                            WHEN c53_tipo = 21 THEN ROUND(c70_valor * -(1 :: FLOAT8), 2)
                            ELSE 0 :: FLOAT8
                        END
                    ),
                    0
                ) AS liquidado,
                COALESCE(
                    SUM(
                        CASE
                            WHEN c53_tipo = 10 THEN ROUND(c70_valor, 2)
                            WHEN c53_tipo = 11 THEN ROUND(c70_valor * -(1 :: FLOAT8), 2)
                            ELSE 0 :: FLOAT8
                        END
                    ),
                    0
                ) AS empenhado
            FROM
                (
                    SELECT
                        DISTINCT ON (c70_codlan) c53_tipo,
                        c60_estrut,
                        c60_descr,
                        c70_valor
                    FROM
                        conlancamele
                        INNER JOIN conlancam ON c70_codlan = c67_codlan
                        INNER JOIN conlancamdoc ON c70_codlan = c71_codlan
                        INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
                        INNER JOIN conplanoorcamentoanalitica ON c61_codcon = c67_codele
                        AND c61_anousu = c70_anousu
                        INNER JOIN conplanoorcamento ON c61_codcon = c60_codcon
                        AND c61_anousu = c60_anousu
                        INNER JOIN conlancamemp ON c70_codlan = c75_codlan
                        INNER JOIN empempenho ON e60_numemp = c75_numemp
                        INNER JOIN orcdotacao ON e60_coddot = o58_coddot
                        AND e60_anousu = o58_anousu
                        INNER JOIN infocomplementaresinstit ON e60_instit = si09_instit
                    WHERE
                        c70_anousu = {$ano}
                        AND e60_instit in ({$instituicao})
                        AND c61_instit in ({$instituicao})
                        AND c53_tipo IN (10, 11, 20, 21)
                        AND c70_data BETWEEN '{$inicio}' AND '{$fim}'
                        AND o58_codigo IN (103, 203)
                    ";
    if ($iRpps) {
        $sql .= getCondicaoTipoDespesa($instituicao);
        $sql .= " ) AND (
                        c60_estrut LIKE '331900101%'
                        OR c60_estrut LIKE '331900301%'
                    )) OR ( c60_estrut LIKE '331900501%' OR c60_estrut LIKE '331900502%') )) as w
                GROUP BY c60_estrut, c60_descr";
    } else {
        $sql .= "
                    AND ( c60_estrut LIKE '331900501%' OR c60_estrut LIKE '331900502%') ) as w
                    GROUP BY c60_estrut, c60_descr";
    }
    $sql .= " ) as x";

    return db_utils::getColectionByRecord(db_query($sql));
}

function getDespesaMensalExclusaoSaldoIntaivosPensionistasProprioDeduzir($inicio, $fim, $instituicao)
{
    $ano = date("Y", strtotime($inicio));
    $instituicao = implode(",", $instituicao);

    $sql = "SELECT * FROM (SELECT
                c60_estrut o58_elemento,
                c60_descr o56_descr,
                COALESCE(
                    SUM(
                        CASE
                            WHEN c53_tipo = 20 THEN ROUND(c70_valor, 2)
                            WHEN c53_tipo = 21 THEN ROUND(c70_valor * -(1 :: FLOAT8), 2)
                            ELSE 0 :: FLOAT8
                        END
                    ),
                    0
                ) AS liquidado,
                COALESCE(
                    SUM(
                        CASE
                            WHEN c53_tipo = 10 THEN ROUND(c70_valor, 2)
                            WHEN c53_tipo = 11 THEN ROUND(c70_valor * -(1 :: FLOAT8), 2)
                            ELSE 0 :: FLOAT8
                        END
                    ),
                    0
                ) AS empenhado
            FROM
                (
                    SELECT
                        DISTINCT ON (c70_codlan) c53_tipo,
                        c60_estrut,
                        c60_descr,
                        c70_valor
                    FROM
                        conlancamele
                        INNER JOIN conlancam ON c70_codlan = c67_codlan
                        INNER JOIN conlancamdoc ON c70_codlan = c71_codlan
                        INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
                        INNER JOIN conplanoorcamentoanalitica ON c61_codcon = c67_codele
                        AND c61_anousu = c70_anousu
                        INNER JOIN conplanoorcamento ON c61_codcon = c60_codcon
                        AND c61_anousu = c60_anousu
                        INNER JOIN conlancamemp ON c70_codlan = c75_codlan
                        INNER JOIN empempenho ON e60_numemp = c75_numemp
                        INNER JOIN orcdotacao ON e60_coddot = o58_coddot
                        AND e60_anousu = o58_anousu
                        INNER JOIN infocomplementaresinstit ON e60_instit = si09_instit
                    WHERE
                        c70_anousu = {$ano}
                        AND e60_instit in ({$instituicao})
                        AND c61_instit in ({$instituicao})
                        AND c53_tipo IN (10, 11, 20, 21)
                        AND c70_data BETWEEN '{$inicio}' AND '{$fim}'
                        AND o58_codigo IN (103, 203)
                    ";
    $sql .= getCondicaoTipoDespesaInvertido($instituicao);
    $sql .= " ) AND (
                c60_estrut LIKE '331900101%'
               OR c60_estrut LIKE '331900301%'
            )) as w
            GROUP BY c60_estrut, c60_descr";
    $sql .= " ) as x";

    return db_utils::getColectionByRecord(db_query($sql));

}


function getDespesaMensalSaldoIndenizacaoDemissaoServidores($inicio, $fim, $instituicao)
{
    $ano = date("Y", strtotime($inicio));
    $instituicao = implode(",", $instituicao);

    $sql = "SELECT * FROM (SELECT
                c60_estrut o58_elemento,
                c60_descr o56_descr,
                COALESCE(
        SUM(
            CASE
                WHEN c53_tipo = 20 THEN ROUND(c70_valor, 2)
                WHEN c53_tipo = 21 THEN ROUND(c70_valor * -(1 :: FLOAT8), 2)
                ELSE 0 :: FLOAT8
            END
        ),
        0
    ) AS liquidado,
    COALESCE(
        SUM(
            CASE
                WHEN c53_tipo = 10 THEN ROUND(c70_valor, 2)
                WHEN c53_tipo = 11 THEN ROUND(c70_valor * -(1 :: FLOAT8), 2)
                ELSE 0 :: FLOAT8
            END
        ),
        0
    ) AS empenhado
FROM
    (
        SELECT
                        DISTINCT ON (c70_codlan) c53_tipo,
                        c60_estrut,
                        c60_descr,
                        c70_valor
        FROM
            conlancamele
            INNER JOIN conlancam ON c70_codlan = c67_codlan
            INNER JOIN conlancamdoc ON c70_codlan = c71_codlan
            INNER JOIN conhistdoc ON c53_coddoc = c71_coddoc
            INNER JOIN conplanoorcamentoanalitica ON c61_codcon = c67_codele
            AND c61_anousu = c70_anousu
            INNER JOIN conplanoorcamento ON c61_codcon = c60_codcon
            AND c61_anousu = c60_anousu
            INNER JOIN conlancamemp ON c70_codlan = c75_codlan
            INNER JOIN empempenho ON e60_numemp = c75_numemp
                    WHERE
                        c70_anousu = {$ano}
                        AND e60_instit in ({$instituicao})
                        AND c61_instit in ({$instituicao})
                        AND c53_tipo IN (10, 11, 20, 21)
                        AND c70_data BETWEEN '{$inicio}' AND '{$fim}'
                        AND (
                            c60_estrut LIKE '331909401%'
                            OR c60_estrut LIKE '331909403%'
                            OR c60_estrut LIKE '331919401%'
                            OR c60_estrut LIKE '331919403%'
                            OR c60_estrut LIKE '331969403%'
                            OR c60_estrut LIKE '331919403%') ) as w
             GROUP BY c60_estrut, c60_descr";
    $sql .= " ) as x";

    return db_utils::getColectionByRecord(db_query($sql));
}

function getDespesaMensalExclusaoSaldoSentencasJudAnt($inicial, $inicio, $fim, $instituicao)
{
    $ano = date("Y", strtotime($inicio));
    $instituicao = implode(",", $instituicao);

    $sql = "SELECT * FROM (";
    $sql .= "select
            e60_numemp,
            o58_elemento,
            o56_descr,
            COALESCE(
                SUM(
                    CASE
                        WHEN C53_TIPO = 20 THEN ROUND(C70_VALOR, 2) :: FLOAT8
                        WHEN C53_TIPO = 21 THEN ROUND(C70_VALOR * -1, 2) :: FLOAT8
                        ELSE 0 :: FLOAT8
                    END
                ),
                0
            ) AS liquidado,
            COALESCE(
                SUM(
                    CASE
                        WHEN c53_tipo = 10 THEN ROUND(c70_valor, 2)
                        WHEN c53_tipo = 11 THEN ROUND(c70_valor * -(1 :: FLOAT8), 2)
                        ELSE 0 :: FLOAT8
                    END
                ),
                0
            ) AS empenhado
        from
            work_dotacao
            inner join orcelemento on o58_codele = o56_codele
            and o58_anousu = o56_anousu
            inner join empempenho on o58_coddot = e60_coddot
            and o58_anousu = e60_anousu
            inner join conlancamemp on e60_numemp = c75_numemp
            inner join conlancam on c75_codlan = c70_codlan
            inner join conlancamdoc on c71_codlan = c70_codlan
            inner join conhistdoc on c53_coddoc = c71_coddoc
        where
            (o58_elemento like '3319091%' OR
            o58_elemento like '3319191%' OR
            o58_elemento like '3319691%')
            and o58_instit IN ({$instituicao})
            and e60_datasentenca < '{$inicial}'
            and e60_emiss BETWEEN '{$inicio}' AND '{$fim}'
        group by
            1,
            2,
            3";
    $sql .= " ) as x";

    return db_utils::getColectionByRecord(db_query($sql));
}

function getDespesaMensalSaldoDespesasAnteriores($inicio, $fim, $instituicao, $anterior, $elemento = NULL)
{
    if (is_array($instituicao))
        $instituicao = implode(",", $instituicao);

    $sql = "SELECT
                    o58_elemento,
                    o56_descr,
                    SUM (liquidado) AS liquidado,
                    SUM (empenhado) AS empenhado
                FROM (
                    SELECT o58_elemento,
                        o56_descr,
                        e60_numemp,
                        liquidado,
                        empenhado,
                        e50_compdesp,
                        e50_codord
                    FROM work_dotacao
                    INNER JOIN orcelemento ON o58_codele = o56_codele AND o58_anousu = o56_anousu
                    INNER JOIN empempenho ON o58_coddot = e60_coddot AND o58_anousu = e60_anousu
                    INNER JOIN pagordem ON e50_numemp = e60_numemp ";

    /* Condição para não usar a função da db_libcontabilidade, pois ocorre erro em alguns clientes */
    /* Essa função é a base da getDespesaExercAnterior contida db_libcontabilidade */
    if ($elemento)
        $sql .= " WHERE o58_elemento LIKE '{$elemento}' ";
    else
        $sql .= " WHERE (o58_elemento LIKE '3319092%' OR o58_elemento LIKE '3319192%' OR o58_elemento LIKE '3319692%') AND e60_emiss BETWEEN '{$inicio}' AND '{$fim}' ";

    $sql .= " AND o58_instit IN ({$instituicao}) AND (e60_datasentenca < '{$anterior}' OR e50_compdesp < '{$anterior}')) AS x GROUP BY 1, 2";

    return db_utils::getColectionByRecord(db_query($sql));
}

function getDespesaMensalInformada($inicio, $fim, $instituicao, $competencia)
{
    $ano = date("Y", strtotime($inicio));
    $instituicao = implode(",", $instituicao);

    $where = " AND (c233_mes = " . date('m', strtotime($inicio)) . " AND c233_ano = {$ano}) ";
    $whereCompetencia = " AND ((c233_competencia IS NOT NULL AND c233_competencia < '{$competencia}') OR (c233_competencia IS NULL)) ";
    $sql = "SELECT o56_descr, c233_elemento as o58_elemento, c233_valorempenhado as empenhado, c233_valorliquidado as liquidado FROM despesaexercicioanterior left join orcelemento on substring(c233_elemento::text, 1, 13) = o56_elemento and c233_ano = o56_anousu WHERE c233_orgao IN ({$instituicao}) {$where} {$whereCompetencia}";

    return db_utils::getColectionByRecord(db_query($sql));
}


function getCondicaoTipoDespesa($aInstituicoes)
{
    $sql = " AND ((( si09_tipoinstit = " . Instituicao::TIPO_INSTIT_RPPS . " ) AND ( ";
    $or = 0;
    foreach (explode(",", $aInstituicoes) as $iChave => $iInstituicao) {
        $sqlComplementar = "SELECT * FROM infocomplementaresinstit WHERE si09_instit = {$iInstituicao}";
        $qQuery = pg_query($sqlComplementar);

        while ($oRow = pg_fetch_object($qQuery)) {
            if ($oRow->si09_tipoinstit == Instituicao::TIPO_INSTIT_CAMARA) {
                $sql .= $or ? " OR e60_tipodespesa = 2 " : " e60_tipodespesa = 2 ";
                $or = 1;
            }

            if ($oRow->si09_tipoinstit == Instituicao::TIPO_INSTIT_PREFEITURA) {
                $sql .= $or ? " OR e60_tipodespesa = 1 " : " e60_tipodespesa = 1 ";
                $or = 1;
            }
        }
    }
    return $sql;
}

function getCondicaoTipoDespesaInvertido($aInstituicoes)
{
    $sql = " AND (( si09_tipoinstit = " . Instituicao::TIPO_INSTIT_RPPS . " ) ";
    $aCondicao = array(Instituicao::TIPO_INSTIT_CAMARA => " e60_tipodespesa = 2 ", Instituicao::TIPO_INSTIT_PREFEITURA => " e60_tipodespesa = 1 ");

    foreach (explode(",", $aInstituicoes) as $iChave => $iInstituicao) {
        $sqlComplementar = "SELECT * FROM infocomplementaresinstit WHERE si09_instit = {$iInstituicao}";
        $qQuery = pg_query($sqlComplementar);

        while ($oRow = pg_fetch_object($qQuery)) {

            if ($oRow->si09_tipoinstit == Instituicao::TIPO_INSTIT_CAMARA) {

                unset($aCondicao[Instituicao::TIPO_INSTIT_CAMARA]);
            }

            if ($oRow->si09_tipoinstit == Instituicao::TIPO_INSTIT_PREFEITURA) {

                unset($aCondicao[Instituicao::TIPO_INSTIT_PREFEITURA]);
            }


        }
    }
            $sql .= " AND ( " . implode(" OR ", $aCondicao) . ") ";


    return $sql;
}
?>
