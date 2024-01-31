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

require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("classes/db_bens_classe.php");
require_once("classes/db_bensbaix_classe.php");
require_once("classes/db_cfpatriplaca_classe.php");
require_once("classes/db_benscadcedente_classe.php");

$clbenscadcedente = new cl_benscadcedente();
$clbens = new cl_bens;
$clbensbaix = new cl_bensbaix;
$clcfpatriplaca = new cl_cfpatriplaca;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$campos = 't52_ident AS placa,
    t52_descr AS descricao,
    t52_obs AS observacao,
    t70_descr AS conservacao,
    t52_dtaqu AS dataaquisicao,
    t52_valaqu AS vlraquisicao,
    t44_valoratual AS vlratual,
    descrdepto AS local,
    nomeresponsavel AS responsavel,
    t30_descr AS divisao,
    cgm.z01_nome AS respdivisao,
    t64_descr AS classificacao,
    t53_ntfisc AS nf,
    t53_empen AS empenho,
    t24_descricao AS tipobem';

$where = " ";

$orderBy = "";

$info = "\nDepartamento: ";

if (isset($codigoDepartamento) && $codigoDepartamento !== '0') {
    $where .= " AND t52_depart={$codigoDepartamento} ";
    $info .= "{$descricaoDepartamento}";
} else {
    $info .= 'Todos';
}

$where .= (isset($codigoDivisao) && $codigoDivisao !== '0')
    ? " AND t33_divisao = {$codigoDivisao} "
    : "";

$where .= (isset($codigoConvenio) && $codigoConvenio !== '0')
    ? " AND t04_sequencial = {$codigoConvenio} "
    : "";


$determinaClassificacao = 0;

if (isset($classificacao)) {
    $determinaClassificacao = 1;
}

if ($determinaClassificacao && !empty($where)) {
        $where .= " AND ";
}

$head5 = 'Classificação: ';

switch ($determinaClassificacao) {
    case 1:
        $head5 .= utf8_decode($descricaoClassificacao);
        $where .= "t64_codcla = '{$codigoClassificacao}'";
        break;
    default:
        $head5 .= 'Todas';
}

$determinaCodigoBem = 0;

if (isset($codigoBemInicial) && isset($codigoBemFinal)) {
    $determinaCodigoBem = 1;
} elseif (isset($codigoBemInicial)) {
    $determinaCodigoBem = 2;
} elseif (isset($codigoBemFinal)) {
    $determinaCodigoBem = 3;
}

if ($determinaCodigoBem && !empty($where)) {
        $where .= " AND ";
}

if ($determinaCodigoBem === 1) {
    $where .= "t52_bem BETWEEN '{$codigoBemInicial}' AND '{$codigoBemFinal}'";
} elseif ($determinaCodigoBem === 2) {
    $where .= "t52_bem >= '{$codigoBemInicial}'";
} elseif ($determinaCodigoBem === 3) {
    $where .= "t52_bem <= '{$codigoBemFinal}'";
}

$determinaCodigoPlaca = 0;

if (isset($codigoPlacaInicial) && isset($codigoPlacaFinal)) {
    $determinaCodigoPlaca = 1;
} elseif (isset($codigoPlacaInicial)) {
    $determinaCodigoPlaca = 2;
} elseif (isset($codigoPlacaFinal)) {
    $determinaCodigoPlaca = 3;
}

if ($determinaCodigoPlaca && !empty($where)) {
        $where .= " AND ";
}

if ($determinaCodigoPlaca === 1) {
    $where .= "t52_ident BETWEEN '{$codigoPlacaInicial}' AND '{$codigoPlacaFinal}'";
} elseif ($determinaCodigoPlaca === 2) {
    $where .= "t52_ident >= '{$codigoPlacaInicial}'";
} elseif ($determinaCodigoPlaca === 3) {
    $where .= "t52_ident <= '{$codigoPlacaFinal}'";
}

$determinaIntervaloValor = 0;

if (isset($intervalorValorInicial) && isset($intervalorValorFinal)) {
    $determinaIntervaloValor = 1;
} elseif (isset($intervalorValorInicial)) {
    $determinaIntervaloValor = 2;
} elseif (isset($intervalorValorFinal)) {
    $determinaIntervaloValor = 3;
}

if ($determinaIntervaloValor && !empty($where)) {
        $where .= " AND ";
}

if ($determinaIntervaloValor === 1) {
    $where .= "t44_valoratual BETWEEN '{$intervalorValorInicial}' AND '{$intervalorValorFinal}'";
} elseif ($determinaIntervaloValor === 2) {
    $where .= "t44_valoratual >= '{$intervalorValorInicial}'";
} elseif ($determinaIntervaloValor === 3) {
    $where .= "t44_valoratual <= '{$intervalorValorFinal}'";
}

$determinaPeriodo = 0;

if (isset($dataAquisicaoInicial) && isset($dataAquisicaoFinal)) {
    $determinaPeriodo = 1;
} elseif (isset($dataAquisicaoInicial)) {
    $determinaPeriodo = 2;
} elseif (isset($dataAquisicaoFinal)) {
    $determinaPeriodo = 3;
}

if ($determinaPeriodo && !empty($where)) {
        $where .= " AND ";
}

if ($determinaPeriodo === 1) {
    $where .= "t52_dtaqu BETWEEN '{$dataAquisicaoInicial}' AND '{$dataAquisicaoFinal}'";
    $info .= "\nPeriodo de " . db_formatar($dataAquisicaoInicial, "d") . " a " . db_formatar($dataAquisicaoFinal, "d");
} elseif ($determinaPeriodo === 2) {
    $where .= "t52_dtaqu >= '{$dataAquisicaoInicial}'";
    $info .= "\nAquisição a partir de " . db_formatar($dataAquisicaoInicial, "d");
} elseif ($determinaPeriodo === 3) {
    $where .= "t52_dtaqu <= '{$dataAquisicaoFinal}'";
    $info .= "\nAquisição até " . db_formatar($dataAquisicaoFinal, "d");
}

$head6 = 'Tipo: ';

if ($tipoBem !== '0' && !empty($where)) {
    $where .= " AND ";
}

switch ($tipoBem) {
    case '1':
        $head6 .= 'Móveis';
        $where .= "t24_sequencial = '{$tipoBem}' ";
        break;
    case '2':
        $head6 .= 'Imóveis';
        $where .= "t24_sequencial = '{$tipoBem}' ";
        break;
    case '3':
        $head6 .= 'Semoventes';
        $where .= "t24_sequencial = '{$tipoBem}' ";
        break;
    default:
        $head6 .= 'Todos';
}

$agrupados = array(
    $agrupaTipoBem,
    $agrupaClassificacao,
    $agrupaLocalizacao,
    $agrupaResponsavelDepto,
    $agrupaDivisao,
    $agrupaResponsavelDivisao
);

$agrupadosMarcados = array_filter($agrupados);

if (!empty($agrupadosMarcados)) {
    if (isset($agrupadosMarcados[0])) {
        $orderBy .= "tipobem ";
    }

    if (isset($agrupadosMarcados[1])) {
        $orderBy .= "classificacao ";
    }

    if (isset($agrupadosMarcados[2])) {
        $orderBy .= "local ";
    }

    if (isset($agrupadosMarcados[3])) {
        $orderBy .= "responsavel ";
    }

    if (isset($agrupadosMarcados[4])) {
        $orderBy .= "divisao ";
    }

    if (isset($agrupadosMarcados[5])) {
        $orderBy .= "respdivisao ";
    }
}

if ($situacaoBem && !empty($where)) {
    $where .= " AND t70_situac = '{$situacaoBem}' ";
}

$head3 = "RELATÓRIO INVENTÁRIO DE BENS";
$head4 = $info;

$sqlrelatorio = $clbens->sql_inventario_bens($campos, $where, $orderBy);

$result = $clbens->sql_record($sqlrelatorio);

$aResultado = pg_fetch_all($result);

if (!isset($aResultado)) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Não existem bens cadastrados para os filtros selecionados.");
}

$pdf = new PDF("L");
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$pdf->AddPage("L");
$alt = 5;
$total = 0;
$totalvalor = 0;
$numrows = $clbens->numrows;

$pdf->cell(22, $alt, "Placa", "RBLT", 0, "C", 0);
$pdf->cell(89, $alt, "Especificação", "RBLT", 0, "C", 0);
$pdf->cell(89, $alt, "Observação", "RBLT", 0, "C", 0);
$pdf->cell(16, $alt, "Estado", "RBLT", 0, "C", 0);
$pdf->cell(20, $alt, "Dt Aquisição", "RBLT", 0, "C", 0);
$pdf->cell(22, $alt, "Vlr Aquisição", "RBLT", 0, "C", 0);
$pdf->cell(22, $alt, "Valor Atual", "RBLT", 0, "C", 0);

$pdf->Ln();

$tipo_bem_duplicado = '';
$localizacao_duplicada = '';
$responsavel_duplicado = '';
$divisao_duplicada = '';
$resp_divisao_duplicado = '';
$classificacao_duplicada = '';
$identificador = '';
$placa = '';

foreach ($aResultado as $resultado) {
    if (isset($agrupadosMarcados[0])) {
        if ($tipo_bem_duplicado !== $resultado['tipobem']) {
            $pdf->cell(22, 4, "Tipo do Bem", "RBLT", 0, "L", 1);
            $pdf->cell(258, 4, $resultado['tipobem'], "RBLT", 0, "L", 1);
            $pdf->Ln();

            $tipo_bem_duplicado = $resultado['tipobem'];
        }
    }

    if (isset($agrupadosMarcados[2])) {
        if ($localizacao_duplicada !== $resultado['localizacao']) {
            $pdf->cell(22, 4, "Localização", "RBLT", 0, "L", 1);
            $pdf->cell(258, 4, $resultado['local'], "RBLT", 0, "L", 1);
            $pdf->Ln();

            $localizacao_duplicada = $resultado['localizacao'];
        }
    }

    if (isset($agrupadosMarcados[3])) {
        if ($responsavel_duplicado !== $resultado['responsavel']) {
            $pdf->cell(22, 4, "Responsável", "RBLT", 0, "L", 1);
            $pdf->cell(258, 4, $resultado['responsavel'], "RBLT", 0, "L", 1);
            $pdf->Ln();

            $responsavel_duplicado = $resultado['responsavel'];
        }
    }

    if (isset($agrupadosMarcados[4])) {
        if ($divisao_duplicada !== $resultado['divisao']) {
            $pdf->cell(22, 4, "Divisão", "RBLT", 0, "L", 1);
            $pdf->cell(258, 4, $resultado['divisao'], "RBLT", 0, "L", 1);
            $pdf->Ln();

            $divisao_duplicada = $resultado['divisao'];
        }
    }

    if (isset($agrupadosMarcados[5])) {
        if ($resp_divisao_duplicado !== $resultado['respdivisao']) {
            $pdf->cell(22, 4, "Respo. Divisão", "RBLT", 0, "L", 1);
            $pdf->cell(258, 4, $resultado['respdivisao'], "RBLT", 0, "L", 1);
            $pdf->Ln();

            $resp_divisao_duplicado = $resultado['respdivisao'];
        }

    }

    if (isset($agrupadosMarcados[1])) {
        if ($classificacao_duplicada !== $resultado['classificacao']) {
            $pdf->cell(22, 4, "Classificação", "RBLT", 0, "L", 1);
            $pdf->cell(258, 4, $resultado['classificacao'], "RBLT", 0, "L", 1);

            $pdf->Ln();

            $classificacao_duplicada = $resultado['classificacao'];
        }
    }

    $data_formatada = isset($resultado["dataaquisicao"])
        ? DateTime::createFromFormat('Y-m-d', $resultado["dataaquisicao"])->format('d/m/Y')
        : '';

    // O campo observação não tem limite de caracteres, esse recurso define até onde o texto será mostrado dentro
    // da célula. 300 é um tamanho aceitável.
    $observacaoFormatada = strlen($resultado['observacao']) > 300
        ? substr($resultado['observacao'], 0, 297) . "..."
        : $resultado['observacao'];

    $tamanhoDescricao = strlen($resultado['descricao']);
    $tamanhoObservacao = strlen($observacaoFormatada);

    if ($tamanhoDescricao > $tamanhoObservacao) {
        $altura = $pdf->CalculateCellHeight($tamanhoDescricao, 89);
    } else {
        $altura = $pdf->CalculateCellHeight($tamanhoObservacao, 89);
    }

    $pdf->cell(22, $altura, $resultado["placa"], "RBLT", 0, "L", 0);

    if ($tamanhoDescricao > 50) {
        $pdf->MultiAlignCell(89, $alt, $resultado['descricao'], 'RLT');
    } else {
        $pdf->cell(89, $altura, $resultado['descricao'], "RBLT", 0, "L", 0);
    }

    if ($tamanhoObservacao > 50) {
        $pdf->MultiAlignCell(89, $alt, $observacaoFormatada, 'RLT');
    } else {
        $pdf->cell(89, $altura, $observacaoFormatada, "RBLT", 0, "L", 0);
    }

    $pdf->cell(16, $altura, $resultado["conservacao"], "RBLT", 0, "C", 0);
    $pdf->cell(20, $altura, $data_formatada, "RBLT", 0, "C", 0);
    $pdf->cell(22, $altura, db_formatar($resultado["vlraquisicao"], 'f'), "RBLT", 0, "C", 0);
    $pdf->cell(22, $altura, db_formatar($resultado["vlratual"], 'f'), "RBLT", 0, "C", 0);

    $placa = $resultado['placa'];
    $identificador = $resultado['identificador'];

    $total++;
    $totalvalor += $resultado["vlratual"];
    $totalvalor_aquisicao += $resultado["vlraquisicao"];

    $pdf->Ln();

    $pdf->Line(10, $pdf->getY(), 280, $pdf->getY());
}

$pdf->setfont('arial', 'b', 8);
$pdf->Ln(1);
$pdf->cell(22, $alt, 'TOTAL GERAL DE REGISTROS  :  ' . $total, 0, 0, "L", 0);
$pdf->cell(258, $alt, 'VLR TOTAL AQUISIÇÃO:' . db_formatar($totalvalor_aquisicao, "f"), 0, 0, "R", 0);
$pdf->Ln();
$pdf->cell(280, $alt, 'VALOR TOTAL ATUAL:' . db_formatar($totalvalor, "f"), 0, 0, "R", 0);

$pdf->Output();
