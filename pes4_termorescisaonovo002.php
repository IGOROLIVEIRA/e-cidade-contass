<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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

require_once("fpdf151/fpdf.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once('libs/db_libpessoal.php');

$oGet = db_utils::postMemory($_GET);

if ($tipo == "m") {
    // Se for escolhida alguma matrícula

    $orderBY = " rh01_regist,r14_rubric";

    if (isset($rei) && trim($rei) != "" && isset($ref) && trim($ref) != "") {
        // Se for por intervalos e vier matrícula inicial e final

        $aWhere[] = " rh01_regist between " . $rei . " and " . $ref;
    } else if (isset($rei) && trim($rei) != "") {
        // Se for por intervalos e vier somente matrícula inicial
        $aWhere[] = " rh01_regist >= " . $rei;
    } else if (isset($ref) && trim($ref) != "") {
        // Se for por intervalos e vier somente matrícula final
        $aWhere[] = " rh01_regist <= " . $ref;
    } else if (isset($fre) && trim($fre) != "") {
        // Se for por selecionados
        $aWhere[] = " rh01_regist in (" . $fre . ") ";
    }
} else if ($tipo == "l") {
    // Se for escolhida alguma lotação

    $orderBY = " r70_estrut,z01_nome,rh01_regist,r14_rubric";

    if (isset($lti) && trim($lti) != "" && isset($ltf) && trim($ltf) != "") {
        // Se for por intervalos e vier lotação inicial e final
        $aWhere[] = " r70_estrut between '" . $lti . "' and '" . $ltf . "' ";
    } else if (isset($lti) && trim($lti) != "") {
        // Se for por intervalos e vier somente lotação inicial
        $aWhere[] = " r70_estrut >= '" . $lti . "' ";
    } else if (isset($ltf) && trim($ltf) != "") {
        // Se for por intervalos e vier somente lotação final
        $aWhere[] = " r70_estrut <= '" . $ltf . "' ";
    } else if (isset($flt) && trim($flt) != "") {
        // Se for por selecionados
        $aWhere[] = " r70_estrut in ('" . str_replace(",", "','", $flt) . "') ";
    }
} else if ($tipo == "t") {
    // Se for escolhido algum local de trabalho

    $orderBY = " rh55_estrut,z01_nome,rh01_regist,r14_rubric";

    if (isset($lci) && trim($lci) != "" && isset($lcf) && trim($lcf) != "") {
        // Se for por intervalos e vier local inicial e final
        $aWhere[]   = " rh55_estrut between '" . $lci . "' and '" . $lcf . "' ";
    } else if (isset($lci) && trim($lci) != "") {
        // Se for por intervalos e vier somente local inicial
        $aWhere[] = " rh55_estrut >= '" . $lci . "' ";
    } else if (isset($lcf) && trim($lcf) != "") {
        // Se for por intervalos e vier somente local final
        $aWhere[] = " rh55_estrut <= '" . $lcf . "' ";
    } else if (isset($flc) && trim($flc) != "") {
        // Se for por selecionados
        $aWhere[] = " rh55_estrut in ('" . str_replace(",", "','", $flc) . "') ";
    }
} else if ($tipo == "o") {
    // Se for escolhido algum órgão

    $orderBY = " o40_orgao,z01_nome,rh01_regist,r14_rubric";

    if (isset($ori) && trim($ori) != "" && isset($orf) && trim($orf) != "") {
        // Se for por intervalos e vier órgão inicial e final
        $aWhere[] = " o40_orgao between " . $ori . " and " . $orf;
    } else if (isset($ori) && trim($ori) != "") {
        // Se for por intervalos e vier somente órgão inicial
        $aWhere[] = " o40_orgao >= " . $ori;
    } else if (isset($orf) && trim($orf) != "") {
        // Se for por intervalos e vier somente órgão final
        $aWhere[] = " o40_orgao <= " . $orf;
    } else if (isset($for) && trim($for) != "") {
        // Se for por selecionados
        $aWhere[] = " o40_orgao in (" . $for . ") ";
    }
} else if ($tipo == "s") {
    // Se for escolhido algum Recurso

    $orderBY = " o15_codigo,o15_descr";

    if (isset($rci) && trim($rci) != "" && isset($rcf) && trim($rcf) != "") {
        // Se for por intervalos e vier recurso inicial e final
        $aWhere[] = " o15_codigo between " . $rci . " and " . $rcf;
    } else if (isset($rci) && trim($rci) != "") {
        // Se for por intervalos e vier somente recurso inicial
        $aWhere[] = " o15_codigo >= " . $rci;
    } else if (isset($rcf) && trim($rcf) != "") {
        // Se for por intervalos e vier somente recurso final
        $aWhere[] = " o15_codigo <= " . $rcf;
    } else if (isset($frc) && trim($frc) != "") {
        // Se for por selecionados
        $aWhere[] = " o15_codigo in (" . $frc . ") ";
    }
}

if (trim($sel) != "") {

    $oDaoSelecao = db_utils::getDao('selecao');
    $result_selecao = $oDaoSelecao->sql_record($oDaoSelecao->sql_query_file($sel, db_getsession("DB_instit"), " r44_descr, r44_where "));
    if ($oDaoSelecao->numrows > 0) {
        db_fieldsmemory($result_selecao, 0);
        $aWhere[] = $r44_where;
    }
}

$oDaoRhpesrescisao = db_utils::getDao('rhpesrescisao');
$sCampos  = "DISTINCT rh16_pis,rh01_admiss,h13_tpcont,z01_nome,z01_ender,z01_bairro,z01_munic,z01_uf,z01_mae,rh16_ctps_n,rh16_ctps_s,rh16_ctps_uf,";
$sCampos .= "rh01_sexo,rh01_instru,rh01_nasc,rh02_hrssem,rh37_cbo,rh30_regime,rh30_descr,rh116_codigo,rh116_cnpj,rh116_descricao,";
$sCampos .= "rh15_data,r59_movsef,rh05_recis,rh05_taviso,rh05_aviso,z01_cgccpf,rh115_descricao,rh115_sigla,h13_descr,h13_codigo,rh01_regist";
$sOrdem = "rh16_pis,rh01_admiss,h13_tpcont";

$sDataCompIni = "{$ano}-{$mes}-01";
$lBisexto = verifica_bissexto($sDataCompIni);
if ($lBisexto) {
    $iFev = 29;
} else {
    $iFev = 28;
}
$aUltimoDia = array(
    "01" => "31",
    "02" => $iFev,
    "03" => "31",
    "04" => "30",
    "05" => "31",
    "06" => "30",
    "07" => "31",
    "08" => "31",
    "09" => "30",
    "10" => "31",
    "11" => "30",
    "12" => "31"
);
$sDataCompFim = "{$ano}-{$mes}-" . $aUltimoDia[$mes];
$sWhere  = "rh05_recis between '{$sDataCompIni}' AND '{$sDataCompFim}' AND rh02_instit = " . db_getsession("DB_instit");
if (count($aWhere)) {
    $sWhere .= " AND " . implode(" AND ", $aWhere);
}

$rsResult = $oDaoRhpesrescisao->sql_record($oDaoRhpesrescisao->sql_relatorios_termo_rescisao(null, $sCampos, $sOrdem, $sWhere));

if ($oDaoRhpesrescisao->numrows == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não foram encontrados servidores com rescisão em ' . $mes . ' / ' . $ano);
}

$oDaoDbConfig = db_utils::getDao("db_config");
$rsDBConfig   = $oDaoDbConfig->sql_record($oDaoDbConfig->sql_query(db_getsession("DB_instit")));
$oConfig = db_utils::fieldsMemory($rsDBConfig, 0);

$oDaoCfpess = db_utils::getDao('cfpess');
$rsCfpess = $oDaoCfpess->sql_record($oDaoCfpess->sql_query_file($ano, $mes, db_getsession("DB_instit"), "r11_codaec,r11_avisoprevioferias
,r11_avisoprevio13ferias"));
$oCfpess = db_utils::fieldsMemory($rsCfpess, 0);


$oPdf = new FPDF();
$oPdf->open();
$oPdf->SetFillColor(190);
$oPdf->SetAutoPageBreak('on', 0);
$altTotal = 10;
$altLabel = 4;
$altField = 5;

for ($iCont = 0; $iCont < $oDaoRhpesrescisao->numrows; $iCont++) {

    $oResult = db_utils::fieldsMemory($rsResult, $iCont);
    $oDaoRhPessoalMov = db_utils::getDao('rhpessoalmov');
    $rsSalMesAnterior = db_query($oDaoRhPessoalMov->sql_valores_servidor($oResult->rh01_regist, $ano, $mes - 1, 'R991'));

    $oPdf->AddPage();
    $oPdf->SetFont('arial', 'b', 9);
    $oPdf->cell(192, 5, "TERMO DE RESCISÃO DO CONTRATO DE TRABALHO", 0, 1, "C", 1);
    $oPdf->cell(192, 2, "", 0, 1, "C", 0);

    //CABECALHO
    addHeader($oPdf, "IIDENTIFICAÇÃO DO EMPREGADOR");

    // LINHA
    $oDados = new stdClass();
    $oDados->label = "01 CNPJ/CEI";
    $oDados->value = db_formatar($oConfig->cgc, 'cnpj');
    $oDados->size = 50;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "02 Razão Social/Nome";
    $oDados->value = $oConfig->nomeinst;
    $oDados->size = 142;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "03 Endereço (logradouro, no, andar, apartamento)";
    $oDados->value = $oConfig->z01_ender;
    $oDados->size = 140;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "04 Bairro";
    $oDados->value = $oConfig->z01_bairro;
    $oDados->size = 52;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "05 Município";
    $oDados->value = $oConfig->z01_munic;
    $oDados->size = 75;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "06 UF";
    $oDados->value = $oConfig->z01_uf;
    $oDados->size = 15;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "07 CEP";
    $oDados->value = empty($oConfig->z01_cep) ? '' : db_formatar($oConfig->z01_cep, 'cep');
    $oDados->size = 25;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "08 CNAE";
    $oDados->value = $oCfpess->r11_codaec;
    $oDados->size = 25;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "09 CNPJ/CEI Tomador/Obra";
    $oDados->value = db_formatar($oConfig->cgc, 'cnpj');
    $oDados->size = 52;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    // CABECALHO
    addHeader($oPdf, "IDENTIFICAÇÃO DO TRABALHADOR");

    //LINHA
    $oDados->label = "10 PIS/PASEP";
    $oDados->value = $oResult->rh16_pis;
    $oDados->size = 48;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "11 Nome";
    $oDados->value = $oResult->z01_nome;
    $oDados->size = 144;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "12 Endereço (logradouro, no, andar, apartamento)";
    $oDados->value = $oResult->z01_ender;
    $oDados->size = 140;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "13 Bairro";
    $oDados->value = $oResult->z01_bairro;
    $oDados->size = 52;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "14 Município";
    $oDados->value = $oResult->z01_munic;
    $oDados->size = 75;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "15 UF";
    $oDados->value = $oResult->z01_uf;
    $oDados->size = 15;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "16 CEP";
    $oDados->value = empty($oResult->z01_cep) ? '' : db_formatar($oResult->z01_cep, 'cep');
    $oDados->size = 25;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "17 CTPS (no, série, UF)";
    $oDados->value = "$oResult->rh16_ctps_n, $oResult->rh16_ctps_s, $oResult->rh16_ctps_uf";
    $oDados->size = 45;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "18 CPF";
    $oDados->value = db_formatar($oResult->z01_cgccpf, 'cpf');
    $oDados->size = 32;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "19 Data de Nascimento";
    $oDados->value = db_formatar($oResult->rh01_nasc, 'd');
    $oDados->size = 48;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "20 Nome da Mãe";
    $oDados->value = $oResult->z01_mae;
    $oDados->size = 144;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    // CABECALHO
    addHeader($oPdf, "DADOS DO CONTRATO");

    //LINHA
    $oDados->label = "21 Tipo de Contrato";
    $oDados->value = "$oResult->rh30_regime - $oResult->rh30_descr";
    $oDados->size = 192;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "22 Causa do Afastamento";
    $oDados->value = $oResult->rh115_descricao;
    $oDados->size = 192;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "23 Remuneração Mês Ant.";
    $oDados->value = db_formatar(db_utils::fieldsMemory($rsSalMesAnterior, 0)->salario, 'f');
    $oDados->size = 40;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "24 Data de Admissão";
    $oDados->value = db_formatar($oResult->rh01_admiss, 'd');
    $oDados->size = 38;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "25 Data do Aviso Prévio";
    $oDados->value = db_formatar($oResult->rh05_aviso, 'd');
    $oDados->size = 38;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "26 Data de Afastamento";
    $oDados->value = db_formatar($oResult->rh05_recis, 'd');
    $oDados->size = 38;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "27 Cód. Afastamento";
    $oDados->value = $oResult->rh115_sigla;
    $oDados->size = 38;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "28 Pensão Alim. (%) (TRCT)";
    $oDados->value = "";
    $oDados->size = 40;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "29 Pensão Alim. (%) (FGTS)";
    $oDados->value = "";
    $oDados->size = 38;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "30 Categoria do Trabalhador";
    $oDados->value = "$oResult->h13_tpcont - $oResult->h13_descr";
    $oDados->size = 114;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    //LINHA
    $oDados->label = "31 Código Sindical";
    $oDados->value = $oResult->rh116_codigo;
    $oDados->size = 40;
    $oDados->ln = false;
    addField($oPdf, $oDados);

    $oDados->label = "32 CNPJ e Nome da Entidade Sindical Laboral";
    $oDados->value = db_formatar($oResult->rh116_cnpj, 'cnpj') . " - $oResult->rh116_descricao";
    $oDados->size = 152;
    $oDados->ln = true;
    addField($oPdf, $oDados);

    // CABECALHO
    addHeader($oPdf, "DISCRIMINAÇÃO DAS VERBAS RESCISÓRIAS");

    $aValoresRescisao = getValoresRescisao($oResult->rh01_regist, $ano, $mes, array($oCfpess->r11_avisoprevioferias, $oCfpess->r11_avisoprevio13ferias));
    //TABELA
    $oPdf->SetFont('arial', 'b', 7);
    $oPdf->cell(192, 4, "VERBAS RESCISÓRIAS", 1, 1, "L", 0);
    $oPdf->cell(34, 4, "Rubrica", 1, 0, "L", 0);
    $oPdf->cell(30, 4, "Valor", 1, 0, "L", 0);
    $oPdf->cell(34, 4, "Rubrica", 1, 0, "L", 0);
    $oPdf->cell(30, 4, "Valor", 1, 0, "L", 0);
    $oPdf->cell(34, 4, "Rubrica", 1, 0, "L", 0);
    $oPdf->cell(30, 4, "Valor", 1, 1, "L", 0);

    $alt = 8;
    $oPdf->SetFont('arial', '', 7);
    addText($oPdf, "Saldo de dias Salário(líquido de faltas e DSR)");
    if (isset($aValoresRescisao['6000']->provento))
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['6000']->provento, 'f'), 1, 0, "L", 0);
    else
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1000']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Comissões                             ");
    $oPdf->cell(30, $alt, db_formatar(0, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Gratificação                          ");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1212']->provento + $aValoresRescisao['1213']->provento, 'f'), 1, 1, "L", 0);
    unset($aValoresRescisao['1000']);
    unset($aValoresRescisao['6000']);
    unset($aValoresRescisao['1212']);
    unset($aValoresRescisao['1213']);

    addText($oPdf, "Adic. de Insalubridade          %");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1202']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Adic. de Periculosidade         %");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1203']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Adic. Noturno                Horas a %");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1205']->provento, 'f'), 1, 1, "L", 0);
    unset($aValoresRescisao['1202']);
    unset($aValoresRescisao['1203']);
    unset($aValoresRescisao['1205']);

    addText($oPdf, "Horas Extras          horas a %");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1003']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Gorjetas                      %");
    $oPdf->cell(30, $alt, db_formatar(0, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Descanso Semanal       Remunerado (DSR)");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1002']->provento, 'f'), 1, 1, "L", 0);
    unset($aValoresRescisao['1003']);
    unset($aValoresRescisao['1002']);

    addText($oPdf, "Reflexo do DSR sobre Salário Variável");
    $oPdf->cell(30, $alt, db_formatar(0, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Multa Art. 477, §               8°/CLT");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['6106']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Salário-Família                       ");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1409']->provento, 'f'), 1, 1, "L", 0);
    unset($aValoresRescisao['6106']);
    unset($aValoresRescisao['1409']);

    addText($oPdf, "13° Salário Proporcional       /12 avos");
    if (isset($aValoresRescisao['6002']->provento))
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['6002']->provento, 'f'), 1, 0, "L", 0);
    else
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['5001']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "13° Salário-Exerc.          -  /12 avos");
    $oPdf->cell(30, $alt, db_formatar(0, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Férias Proporc                 /12 avos");

    if (isset($aValoresRescisao['6006']->provento))
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['6006']->provento, 'f'), 1, 1, "L", 0);
    else
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1020']->provento, 'f'), 1, 1, "L", 0);

    unset($aValoresRescisao['5001']);
    unset($aValoresRescisao['1020']);
    unset($aValoresRescisao['6002']);
    unset($aValoresRescisao['6006']);

    addText($oPdf, "Férias Venc. Per. Aquisitivo          a");
    if (isset($aValoresRescisao['6007']->provento))
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['6007']->provento, 'f'), 1, 0, "L", 0);
    else
        $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['1020']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Terço Constituc. de              Férias");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['R931']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Aviso Prévio                 Indenizado");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['6003']->provento, 'f'), 1, 1, "L", 0);

    unset($aValoresRescisao['1020']);
    unset($aValoresRescisao['6007']);
    unset($aValoresRescisao['R931']);
    unset($aValoresRescisao['6003']);

    addText($oPdf, "13° Salário   (Aviso Prévio Indenizado)");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['6001']->provento, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Férias   (Aviso Prévio Indenizado)     ");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['feriasAvisoPrevio'], 'f'), 1, 0, "L", 0);
    unset($aValoresRescisao['6001']);
    unset($aValoresRescisao['feriasAvisoPrevio']);

    foreach ($aValoresRescisao as $oValores) {
        if (!isset($oValores->e990_descricao) || $oValores->provento == 0) {
            continue;
        }
        addText($oPdf, $oValores->e990_descricao);
        $oPdf->cell(30, $alt, db_formatar($oValores->provento, 'f'), 1, ($oPdf->x > 138 ? 1 : 0), "L", 0);
    }

    if ($oPdf->x > 138) {
        addText($oPdf, "                                      ");
        $oPdf->cell(30, $alt, "", 1, 1, "L", 0);
    }
    if ($oPdf->x < 74) {
        addText($oPdf, "                                      ");
        $oPdf->cell(30, $alt, "", 1, 0, "L", 0);
    }
    addText($oPdf, "Ajuste do saldo devedor               ");
    $oPdf->cell(30, $alt, db_formatar(0, 'f'), 1, 0, "L", 0);
    $oPdf->cell(34, $alt, "TOTAL BRUTO", 1, 0, "L", 1);
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['totalProventos'], 'f'), 1, 1, "R", 1);

    //TABELA
    $oPdf->SetFont('arial', 'b', 7);
    $oPdf->cell(192, 4, "DEDUÇÕES", 1, 1, "L", 0);
    $oPdf->cell(34, 4, "Rubrica", 1, 0, "L", 0);
    $oPdf->cell(30, 4, "Valor", 1, 0, "L", 0);
    $oPdf->cell(34, 4, "Rubrica", 1, 0, "L", 0);
    $oPdf->cell(30, 4, "Valor", 1, 0, "L", 0);
    $oPdf->cell(34, 4, "Rubrica", 1, 0, "L", 0);
    $oPdf->cell(30, 4, "Valor", 1, 1, "L", 0);

    $oPdf->SetFont('arial', '', 7);
    addText($oPdf, "Pensão Alimentícia                    ");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['9213']->desconto, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Adiantamento Salarial                 ");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['9200']->desconto, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Adiantamento 13°                Salário");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['9214']->desconto, 'f'), 1, 1, "L", 0);
    unset($aValoresRescisao['9213']);
    unset($aValoresRescisao['9200']);
    unset($aValoresRescisao['9214']);

    $oPdf->SetFont('arial', '', 7);
    addText($oPdf, "Aviso Prévio Indenizado            dias");
    $oPdf->cell(30, $alt, db_formatar(0, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Previdência Social                     ");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['R903']->desconto + $aValoresRescisao['R901']->desconto, 'f'), 1, 0, "L", 0);
    addText($oPdf, "Previdência Social        - 13° Salário");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['R902']->desconto + $aValoresRescisao['R905']->desconto, 'f'), 1, 1, "L", 0);
    unset($aValoresRescisao['R903']);
    unset($aValoresRescisao['R901']);
    unset($aValoresRescisao['R902']);
    unset($aValoresRescisao['R905']);

    $oPdf->SetFont('arial', '', 7);
    addText($oPdf, "IRRF                                   ");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['R913']->desconto + $aValoresRescisao['R915']->desconto, 'f'), 1, 0, "L", 0);
    addText($oPdf, "IRRF sobre                  13° Salário");
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['R914']->desconto, 'f'), 1, 0, "L", 0);
    unset($aValoresRescisao['R913']);
    unset($aValoresRescisao['R915']);
    unset($aValoresRescisao['R914']);

    foreach ($aValoresRescisao as $oValores) {
        if (!isset($oValores->e990_descricao) || $oValores->desconto == 0) {
            continue;
        }
        addText($oPdf, $oValores->e990_descricao);
        $oPdf->cell(30, $alt, db_formatar($oValores->desconto, 'f'), 1, ($oPdf->x > 138 ? 1 : 0), "L", 0);
    }

    if ($oPdf->x > 74 && $oPdf->x < 138) {
        addText($oPdf, "                                      ");
        $oPdf->cell(30, $alt, "", 1, 0, "L", 0);
    }
    if ($oPdf->x > 138) {
        addText($oPdf, "                                      ");
        $oPdf->cell(30, $alt, "", 1, 1, "L", 0);
    }

    $oPdf->cell(34, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(30, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(34, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(30, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(34, $alt, "TOTAL DEDUÇÕES", 1, 0, "L", 1);
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['totalDescontos'], 'f'), 1, 1, "R", 1);
    $oPdf->cell(34, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(30, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(34, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(30, $alt, "", 1, 0, "L", 0);
    $oPdf->cell(34, $alt, "VALOR LÍQUIDO", 1, 0, "L", 1);
    $oPdf->cell(30, $alt, db_formatar($aValoresRescisao['totalProventos'] - $aValoresRescisao['totalDescontos'], 'f'), 1, 1, "R", 1);

    addFooter($oPdf);
}

$oPdf->Output();

function addField($oPdf, $oDados)
{
    $iPosX = $oPdf->GetX();
    $iPosY = $oPdf->GetY();
    $oPdf->cell($oDados->size, 4, $oDados->label, "LTR", 1, "L", 0);
    $oPdf->SetX($iPosX);
    $oPdf->cell($oDados->size, 5, $oDados->value, "LBR", 1, "L", 0);
    if (!$oDados->ln) {
        $oPdf->SetY($iPosY);
        $oPdf->SetX($oDados->size + $iPosX);
    }
}

function addHeader($oPdf, $text)
{
    $oPdf->SetFont('arial', 'b', 7);
    $oPdf->cell(192, 4, $text, 1, 1, "C", 1);
    $oPdf->SetFont('arial', '', 7);
}

function addFooter($oPdf)
{
    $oPdf->Ln();
    $oPdf->SetFont('arial', 'b', 7);
    $oPdf->cell(80, 4, "", "B", 0, "C", 0);
    $oPdf->cell(20, 4, "", 0, 0, "C", 0);
    $oPdf->cell(80, 4, "", "B", 1, "C", 0);

    $oPdf->cell(80, 4, "Assinatura Empregado", 0, 0, "C", 0);
    $oPdf->cell(20, 4, "", 0, 0, "C", 0);
    $oPdf->cell(80, 4, "Assinatura Empregador/Preposto", 0, 1, "C", 0);
    $oPdf->SetFont('arial', '', 7);
}

function addText($oPdf, $text)
{
    $aText = splitText($text, 30);
    multiCell($oPdf, $aText, 4, 34, 1);
}

function splitText($texto, $tamanho)
{

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {
        $string_ant = $string_atual;
        $string_atual .= " " . $word;
        if (strlen($string_atual) > $tamanho) {
            $aTextoNovo[] = $string_ant;
            $string_ant   = "";
            $string_atual = $word;
        }
    }
    $aTextoNovo[] = $string_atual;
    return $aTextoNovo;
}

function multiCell($oPdf, $aTexto, $iTamFixo, $iTamCampo, $iBorda = 1)
{

    $pos_x = $oPdf->x;
    $pos_y = $oPdf->y;
    $oPdf->cell($iTamCampo, 8, "", $iBorda, 0, 'L');
    $oPdf->x = $pos_x;
    $oPdf->y = $pos_y;
    foreach ($aTexto as $key => $sProcedimento) {
        $sProcedimento = ltrim($sProcedimento);
        $oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L');
        $oPdf->x = $pos_x;
        if ($key == 1) {
            break;
        }
    }
    $oPdf->x = $pos_x + $iTamCampo;
    $oPdf->y = $pos_y;
}

function getValoresRescisao($matricula, $ano, $mes, $aFeriasAvisoPrevio)
{

    $sql = "  select '1' as ordem ,
                   r20_rubric as rubrica,
                   (select e991_rubricasesocial from baserubricasesocial where e991_rubricas = r20_rubric) as rubricaesocial,
                   case
                     when rh27_pd = 3 then 0
                     else case
                            when r20_pd = 1 then r20_valor
                            else 0
                          end
                   end as Provento,
                   case
                     when rh27_pd = 3 then 0
                     else case
                            when r20_pd = 2 then r20_valor
                            else 0
                          end
                   end as Desconto,
                   r20_quant as quant,
                   rh27_descr,
                   r20_tpp as tipo ,
                   case
                     when rh27_pd = 3 then 'Base'
                     else case
                            when r20_pd = 1 then 'Provento'
                            else 'Desconto'
                          end
                   end as provdesc
              from gerfres
                   inner join rhrubricas on rh27_rubric = r20_rubric
                                        and rh27_instit = " . db_getsession("DB_instit") . "
              " . bb_condicaosubpesproc("r20_", $ano . "/" . $mes) . "
               and r20_regist = $matricula
               and r20_pd != 3
               order by r20_pd,r20_rubric";
    $result = db_query($sql);
    $aDados = array();
    $totalProventos = 0;
    $totalDescontos = 0;
    $aDados['feriasAvisoPrevio'] = 0;
    for ($x = 0; $x < pg_numrows($result); $x++) {

        $oBaseRubrica = db_utils::fieldsMemory($result, $x);
        $sWhereBase = '';

        if ((intval($oBaseRubrica->rubrica) >= 0001 && intval($oBaseRubrica->rubrica) <= 3999) && (intval($oBaseRubrica->rubricaesocial) == '1020' or intval($oBaseRubrica->rubricaesocial) == '6006')) {
            if ($oBaseRubrica->tipo == 'P') {
                $sWhereBase = "AND (e990_sequencial = '6006' or e990_sequencial = '1020' )";
            } else if ($oBaseRubrica->tipo == 'V') {
                $sWhereBase = "AND (e990_sequencial = '6007' or e990_sequencial = '1020' )";
            }
        } else if (intval($oBaseRubrica->rubrica) >= 4000 && intval($oBaseRubrica->rubrica) <= 5999 && (intval($oBaseRubrica->rubricaesocial) == '6002' or intval($oBaseRubrica->rubricaesocial) == '5001')) {
            $sWhereBase = "AND (e990_sequencial = '6002' or e990_sequencial = '5001' )";
        } else if (intval($oBaseRubrica->rubrica) >= 0001 && intval($oBaseRubrica->rubrica) <= 1999 && (intval($oBaseRubrica->rubricaesocial) == '1000')) {
            $sWhereBase = "AND e990_sequencial = '1000'";
        } else if (intval($oBaseRubrica->rubrica) >= 0001 && intval($oBaseRubrica->rubrica) <= 1999 && (intval($oBaseRubrica->rubricaesocial) == '1205')) {
            $sWhereBase = "AND e990_sequencial = '1205'";
        } else {
            $sWhereBase = "AND e990_sequencial != '1000'";
        }
        $sql = "SELECT e990_sequencial,e990_descricao FROM rubricasesocial
        JOIN baserubricasesocial ON rubricasesocial.e990_sequencial = baserubricasesocial.e991_rubricasesocial
        WHERE baserubricasesocial.e991_rubricas = '{$oBaseRubrica->rubrica}' {$sWhereBase}";
        $rsResult = db_query($sql);
        $oResult = db_utils::fieldsMemory($rsResult);

        if ($oBaseRubrica->rubrica == 'R931') {
            $aDados['R931']->provento = $oBaseRubrica->provento;
        } else if (in_array($oBaseRubrica->rubrica, array('R902', 'R905', 'R901', 'R903', 'R914', 'R913', 'R915'))) {
            $aDados[$oBaseRubrica->rubrica]->desconto = $oBaseRubrica->desconto;
        } else
        if (!isset($aDados[$oResult->e990_sequencial])) {
            $oDados = $oResult;
            $oDados->provento = $oBaseRubrica->provento;
            $oDados->desconto = $oBaseRubrica->desconto;
            $aDados[$oResult->e990_sequencial] = $oDados;
        } else {
            $aDados[$oResult->e990_sequencial]->provento += $oBaseRubrica->provento;
            $aDados[$oResult->e990_sequencial]->desconto += $oBaseRubrica->desconto;
        }
        if (in_array($oBaseRubrica->rubrica, $aFeriasAvisoPrevio)) {
            $aDados['feriasAvisoPrevio'] += $oBaseRubrica->provento;
        }
        $totalProventos += $oBaseRubrica->provento;
        $totalDescontos += $oBaseRubrica->desconto;
    }
    if (isset($aDados['6003'])) {
        $aDados['6003']->provento -= $aDados['feriasAvisoPrevio'];
    }
    $aDados['totalProventos'] = $totalProventos;
    $aDados['totalDescontos'] = $totalDescontos;
    // echo '<pre>';
    // print_r($aDados);
    // exit;
    return $aDados;
}
