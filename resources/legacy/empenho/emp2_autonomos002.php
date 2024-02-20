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


 require_once "libs/db_stdlib.php";
 require_once "libs/db_conecta.php";
 include_once "libs/db_sessoes.php";
 include_once "libs/db_usuariosonline.php";
 include("libs/db_liborcamento.php");
 include("libs/db_libcontabilidade.php");
 require_once "classes/db_fornemensalemp_classe.php";
 require_once("classes/db_cgm_classe.php");
 require_once("classes/db_infocomplementaresinstit_classe.php");
 include("libs/db_sql.php");
 require_once("libs/db_utils.php");
 require_once("libs/JSON.php");
 require_once("dbforms/db_funcoes.php");
 require_once("classes/db_empnota_classe.php");
 require_once("classes/db_empnotaitem_classe.php");
use \Mpdf\Mpdf;
use \Mpdf\MpdfException;

$oGet            = db_utils::postMemory($_GET);
$oDaoEmpNota     = new cl_empnota();
$oDaoEmpNotaItem = new cl_empnotaitem();

$clrotulo        = new rotulocampo;
$clrotulo->label("e69_numero");
$clrotulo->label("e69_codnota");
$clrotulo->label("e50_codord");
$clrotulo->label("e60_codemp");
$clrotulo->label("z01_nome");
$clrotulo->label("e70_valor");
$clrotulo->label("e70_vlrliq");
$clrotulo->label("e70_vlranu");
$clrotulo->label("e53_vlrpag");

$instits = str_replace('-', ', ', db_getsession("DB_instit"));

$aElementosFiltro = array('33903609','33903607','33903608','33903605','33903614','33903639','33903636','33903637','33903638','33903641','33903601','33903602','33903603','33903635','33903640');

function sqlGeral($dtDataInicial){

    if (isset($dtDataInicial)) {
        $sSqlNota  = "select distinct e50_codord,";
        $sSqlNota .= " e60_numcgm,";
        $sSqlNota .= " cgm.z01_nome,";
        $sSqlNota .= " e60_codemp,";
        $sSqlNota .= " e70_vlrliq,";
        $sSqlNota .= " e50_data,";
        $sSqlNota .= " cattrabalhador.ct01_descricaocategoria,";
        $sSqlNota .= " e50_empresadesconto,";
        $sSqlNota .= " e50_cattrabalhador,";
        $sSqlNota .= " e50_contribuicaoprev,";
        $sSqlNota .= " e50_valorremuneracao,";
        $sSqlNota .= " e50_valordesconto,";
        $sSqlNota .= " corrente.k12_data as k12_data, ";
        $sSqlNota .= " e50_cattrabalhadorremurenacao, ";
        $sSqlNota .= " case when retencaotiporec.e21_retencaotipocalc in (3,4,7) then (coalesce(e23_valorretencao, 0))
                          else 0  end as valor_inss, ";
        $sSqlNota .= " case when retencaotiporec.e21_retencaotipocalc in (1,2) then (coalesce(e23_valorretencao, 0))
                          else 0 end as valor_irrf,";
        $sSqlNota .= " case when retencaotiporec.e21_retencaotipocalc in (5,6) then (coalesce(e23_valorretencao, 0))
                          else 0 end as outrasretencoes, ";
        $sSqlNota .= " case when e50_cattrabalhador in (711, 712) then ((e70_vlrliq*0.2)*0.2)
                          else (e70_vlrliq*0.2) end as patronal, ";
        $sSqlNota .= " case when e50_cattrabalhador in (711, 712) then ((e70_vlrliq * 0.2))
                          else e70_vlrliq	end as basepatronal, ";
        $sSqlNota .= " e60_anousu, e69_numero, cgm.z01_cgccpf,rh70_estrutural, corrente.k12_data,e23_ativo,o58_codigo,o58_projativ,o55_descr,o15_descr,cgm.z01_nasc";
        $sSqlNota .= "       from empnota ";
        $sSqlNota .= "          inner join empempenho   on e69_numemp  = e60_numemp";
        $sSqlNota .= "          inner join orcdotacao on  (o58_coddot,o58_anousu) = (e60_coddot,e60_anousu)";
        $sSqlNota .= "          inner join orcprojativ on (o55_projativ,o55_anousu) = (o58_projativ,o58_anousu)";
        $sSqlNota .= "          inner join orctiporec on o15_codigo 								= o58_codigo";
        $sSqlNota .= "          inner join cgm as cgm   on e60_numcgm  = cgm.z01_numcgm";
        $sSqlNota .= "          inner join empnotaele   on e69_codnota = e70_codnota";
        $sSqlNota .= "          inner join orcelemento  on empnotaele.e70_codele = orcelemento.o56_codele";
        $sSqlNota .= "          left join cgmfisico on z04_numcgm = cgm.z01_numcgm";
        $sSqlNota .= "          left join rhcbo on rh70_sequencial = z04_rhcbo";
        $sSqlNota .= "          left join conlancamemp on c75_numemp = e60_numemp ";
        $sSqlNota .= "          left join conlancamdoc on c71_codlan = c75_codlan and c71_coddoc = 904 ";
        $sSqlNota .= "          left  join pagordemnota on e71_codnota = e69_codnota and e71_anulado is false";
        $sSqlNota .= "          left  join pagordem    on  e71_codord = e50_codord";
        $sSqlNota .= "          left  join pagordemele  on e53_codord = e50_codord";
        $sSqlNota .= "          left  join cgm as empresa on empresa.z01_numcgm = e50_empresadesconto";
        $sSqlNota .= "          left join categoriatrabalhador as cattrabalhador on cattrabalhador.ct01_codcategoria = e50_cattrabalhador";
        $sSqlNota .= "          left join categoriatrabalhador as catremuneracao on	catremuneracao.ct01_codcategoria = e50_cattrabalhadorremurenacao";
        $sSqlNota .= "          left join retencaopagordem on pagordem.e50_codord = retencaopagordem.e20_pagordem";
        $sSqlNota .= "          left join retencaoreceitas on retencaoreceitas.e23_retencaopagordem = retencaopagordem.e20_sequencial";
        $sSqlNota .= "          left join retencaotiporec on retencaotiporec.e21_sequencial = retencaoreceitas.e23_retencaotiporec";
        $sSqlNota .= "          left join empord on empord.e82_codord = pagordem.e50_codord";
        $sSqlNota .= "          left join empagemov on empagemov.e81_codmov = empord.e82_codmov";
        $sSqlNota .= "          left join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov";
        $sSqlNota .= "          left join corrente on (
                      corrente.k12_id,
                      corrente.k12_data,
                      corrente.k12_autent
                  ) = (
                      corempagemov.k12_id,
                      corempagemov.k12_data,
                      corempagemov.k12_autent
                  )";

        return $sSqlNota;

    }
}

$dtDataInicial = implode("-", array_reverse(explode("/", $dtDataInicial)));
$dtDataFinal = implode("-", array_reverse(explode("/", $dtDataFinal)));

function filtrarDatas ($sPosicao,$dtDataInicial,$dtDataFinal){
    if($sPosicao == 2){
        $filtroData = " where (corrente.k12_data BETWEEN '$dtDataInicial' AND '$dtDataFinal' ) ";
        return $filtroData;
    }
    $filtroData = " where (e50_data BETWEEN '$dtDataInicial' AND '$dtDataFinal' ) ";
    return $filtroData;
}
function credoresSelecionados ($sCredoresSelecionados,$sTipoSelecao, $sSqlNota,$sPosicao,$dtDataInicial,$dtDataFinal){
    $filtroData = filtrarDatas ($sPosicao,$dtDataInicial,$dtDataFinal);
    if($sCredoresSelecionados && $sTipoSelecao == 1){
        $sSqlNota .= "  $filtroData and  e60_numcgm in ({$sCredoresSelecionados}) and Length(cgm.z01_cgccpf) = 11 ";
        return $sSqlNota;
    }
    if($sCredoresSelecionados && $sTipoSelecao == 2){
        $sSqlNota .= " $filtroData and  e60_numcgm not in ({$sCredoresSelecionados}) and Length(cgm.z01_cgccpf) = 11 ";
        return $sSqlNota;
    }
    $sSqlNota .= "  $filtroData and Length(cgm.z01_cgccpf) = 11 ";
    return $sSqlNota;
}

function tipoIncidencia($sTipo,$sSqlNota,$aElementosFiltro,$instits){
    if($sTipo == '1'){
        $sSqlNota .= "  and e50_cattrabalhador is not null ";
        $sSqlNota .=  " and e60_instit = $instits";
        $sSqlNota .= "  group by     1,3,2,4,6,7,8,9,10,e21_retencaotipocalc,c71_coddoc,e60_anousu,e69_numero,e70_vlrliq,e23_valorretencao, cgm.z01_cgccpf,rh70_estrutural,corrente.k12_data,e23_ativo,o58_codigo,o58_projativ,o55_descr,o15_descr,cgm.z01_nasc";
        return $sSqlNota;
    }
    if($sTipo == '2'){
        $sSqlNota .= "  and e50_cattrabalhador is null ";
        $sSqlNota .= "  and ((substr(orcelemento.o56_elemento,2,8) like '339036%') or (substr(orcelemento.o56_elemento,2,8) like '339035%') ";
        $sSqlNota .= "  and (substr(orcelemento.o56_elemento,2,8) NOT IN ('".implode("','",$aElementosFiltro)."') ))  ";
        $sSqlNota .=  " and e60_instit = $instits";
        $sSqlNota .= "  group by     1,3,2,4,6,7,8,9,10,e21_retencaotipocalc,c71_coddoc,e60_anousu,e69_numero,e70_vlrliq,e23_valorretencao, cgm.z01_cgccpf,rh70_estrutural,corrente.k12_data,e23_ativo,o58_codigo,o58_projativ,o55_descr,o15_descr,cgm.z01_nasc";
        return $sSqlNota;
    }
    if($sTipo == '3'){
        $sSqlNota .= "  and ((substr(orcelemento.o56_elemento,2,8) like '339036%') or (substr(orcelemento.o56_elemento,2,8) like '339035%') ";
        $sSqlNota .= "  and (substr(orcelemento.o56_elemento,2,8) NOT IN ('".implode("','",$aElementosFiltro)."') ))  ";
        $sSqlNota .=  " and e60_instit = $instits";
        $sSqlNota .= "  group by     1,3,2,4,6,7,8,9,10,e21_retencaotipocalc,c71_coddoc,e60_anousu,e69_numero,e70_vlrliq,e23_valorretencao, cgm.z01_cgccpf,rh70_estrutural,corrente.k12_data,e23_ativo,o58_codigo,o58_projativ,o55_descr,o15_descr,cgm.z01_nasc";
        return $sSqlNota;
    }

}
function tipoQuebra($sQuebra,$sSqlNota){
    if($sQuebra == 1){
        $sSqlNota .= "  order by cgm.z01_cgccpf  ";
        return $sSqlNota;
    }
    $sSqlNota .= "  order by o58_projativ,o58_codigo";
    return $sSqlNota;
}

$sSqlNota = sqlGeral($dtDataInicial);

$sSqlNota = credoresSelecionados ($sCredoresSelecionados,$sTipoSelecao, $sSqlNota,$sPosicao,$dtDataInicial,$dtDataFinal);

$sSqlNota = tipoIncidencia($sTipo,$sSqlNota,$aElementosFiltro,$instits);

$sSqlNota = tipoQuebra($sQuebra,$sSqlNota);

$rsNota    = $oDaoEmpNota->sql_record($sSqlNota);


$aFornecedores = pg_fetch_all($rsNota);

  if ($oDaoEmpNota->numrows > 0 ) {
    $oNotas      = db_utils::FieldsMemory($rsNota, 0);
  }


$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
$cldadosexecicioanterior = new cl_dadosexercicioanterior();
db_postmemory($HTTP_POST_VARS);


$aInstits = explode(",", $instits);

if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}

db_inicio_transacao();

/**
 * pego todas as instituições;
 */
$rsInstits = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_instit, si09_tipoinstit", null, null));

$ainstitunticoes = array();
for ($i = 0; $i < pg_num_rows($rsInstits); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsInstits, $i);
    $ainstitunticoes[] = $odadosInstint->si09_instit;
}
$iInstituicoes = implode(',', $ainstitunticoes);

$rsTipoinstit = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_sequencial, si09_tipoinstit", null, "si09_instit in( {$instits})"));

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
 * mPDF
 * @param string $mode              | padrão: BLANK
 * @param mixed $format             | padrão: A4
 * @param float $default_font_size  | padrão: 0
 * @param string $default_font      | padrão: ''
 * @param float $margin_left        | padrão: 15
 * @param float $margin_right       | padrão: 15
 * @param float $margin_top         | padrão: 16
 * @param float $margin_bottom      | padrão: 16
 * @param float $margin_header      | padrão: 9
 * @param float $margin_footer      | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */

try {
    $mPDF = new Mpdf([
        'mode' => '',
        'format' => 'A4-L',
        'orientation' => 'L',
        'margin_left' => 15,
        'margin_right' => 15,
        'margin_top' => 20,
        'margin_bottom' => 10,
        'margin_header' => 5,
        'margin_footer' => 11,
    ]);
/*Nome do relatório.*/
$header = " <header>
                <div style=\" height: 120px; font-family:Arial\">
                    <div style=\"width:50%; float:left; padding:5px; font-size:10px;\">
                        <b><i>{$oInstit->getDescricao()}</i></b><br/>
                        <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
                        <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
                        <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
                        <i>{$oInstit->getSite()}</i>
                    </div>
                    <div style=\"width:40%; float:right\" class=\"box\">
                    <b>Relatório de Autônomos</b><br/>  ";
foreach ($aInstits as $iInstit) {
    $oInstituicao = new Instituicao($iInstit);
    $header .= "<b>Instituição: </b>".trim($oInstituicao->getCodigo()) . " - " . $oInstituicao->getDescricao();
}
$aPosicao = "Pagamento (S-1210)";
if($sPosicao == 1)
    $aPosicao ="Liquidação (S-1200)";
/*Período do relatório.*/
$header .= "<br/><b>Período:</b> {$dtDataInicial} <b>A</b> {$dtDataFinal}
            <b>Posição:</b> {$aPosicao}
                    </div>
                </div>
            </header>";


$footer  = "<footer style='padding-top: 150px;'>";
$footer .= "   <div style='border-top:1px solid #000; width:100%; font-family:sans-serif; font-size:7px; height:5px;padding-bottom: -12px;'>";
$footer .= "    <div style='text-align:left;font-style:italic;width:90%;float:left;padding-bottom: -82px;'>";
$footer .= "       Financeiro>Empenho>Relatorios de Conferencia>Fornecedoers Mensais";
$footer .= "       Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . date("d/m/Y H:i:s", db_getsession("DB_datausu"))  . "";
$footer .= "      <div style='text-align:right;float:right;width:10%;padding-bottom: -122px;'>";
$footer .= "                        {PAGENO}";
$footer .= "      </div>";
$footer .= "    </div>";
$footer .= "   </div>";
$footer .= "</footer>";


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O');

ob_start();

$tipoImpressao = $sTipoImpressao;

$dataInicial = str_replace("/","-",db_formatar($dtDataInicial, "d"));
$dataFinal = str_replace("/","-",db_formatar($dtDataFinal, "d"));

?>

    <html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link type="text/css" rel="stylesheet" href="resources/sheet.css">
        <style type="text/css">
            .ritz .waffle a {
                color: inherit;
            }

            .title-relatorio {
                border-top: 1px SOLID #000000;
                text-align: center;
            }

            .ritz .waffle .s1 {
                border-bottom: 1px SOLID #000000;
                border-right: 1px SOLID #000000;
                border-left: 1px SOLID #000000;
                background-color: #ffffff;
                text-align: left;
                color: #000000;
                font-family: 'Arial';
                font-size: 10pt;
                vertical-align: bottom;
                white-space: nowrap;
                direction: ltr;
                padding: 2px 3px 2px 3px;
            }

            .ritz .waffle .s0 {
                border-bottom: 1px SOLID #000000;
                border-left: 0.5px SOLID #000000;
                border-top: 1px SOLID #000000;
                border-right: 1px solid #000000;
                background-color: #efefef;
                text-align: center;
                font-weight: bold;
                font-family: 'Arial';
                font-size: 10pt;
                vertical-align: middle;
                white-space: nowrap;
                direction: ltr;
                padding: 2px 3px 2px 3px;
            }

            .ritz .waffle .s3 {
                border-bottom: 1px SOLID #000000;
                border-right: 1px SOLID #000000;
                background-color: #ffffff;
                text-align: right;
                color: #000000;
                font-family: 'Arial';
                font-size: 10pt;
                vertical-align: bottom;
                white-space: nowrap;
                direction: ltr;
                padding: 2px 3px 2px 3px;
            }

            .ritz .waffle .s2 {
                border-bottom: 1px SOLID #000000;
                background-color: #ffffff;
                text-align: left;
                color: #000000;
                font-family: 'Arial';
                font-size: 10pt;
                vertical-align: bottom;
                white-space: nowrap;
                direction: ltr;
                padding: 2px 3px 2px 3px;
            }
        </style>
    </head>

    <body>
    <div class="ritz grid-container" dir="ltr">
        <div class="title-relatorio"><br/>
            <strong>
                <font size="-1">Relatório de Autônomos</font>
            </strong><br/><br/>

        </div>
        <table class="waffle" cellspacing="0" cellpadding="0">
            <thead>
            <tr>
                <th class="row-header freezebar-origin-ltr"></th>
                <th id="0C0" style="width:100px;" class="column-headers-background"></th>
                <th id="0C1" style="width:100px;" class="column-headers-background"></th>
                <th id="0C2" style="width:100px;" class="column-headers-background"></th>
            </tr>
            </thead>
            <tbody>
            <tr style="height: 30px">
                <th id="0R0" style="height: 30px;"></th>
                <? if($sQuebra == 2){?>
                    <td class="s0" dir="ltr" ><font size="-1"> CGM - Nome </font></td>
                <?}?>
                <td class="s0" dir="ltr" ><font size="-1"> OP </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Data OP </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Número da NF </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Valor Nota </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Valor INSS </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Valor IRRF </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Outras Retenções </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Base C. Patronal </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Patronal </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Categoria </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Indicador </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Empresa </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Categoria </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Valor Remuneração </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Valor Liquido  </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Data Pagamento  </font></td>



            </tr>
            <?php

            $pagina = 0;
            $contador = 1;
            $control = 0;
            $totale70_vlrliq = 0;
            $totalvalor_inss = 0;
            $totalvalor_irrf = 0;
            $totaloutrasretencoes = 0;
            $totalpatronal = 0;
            $totale50_valorremuneracao = 0;
            $totalbasepatronal = 0;
            $Geraltotale70_vlrliq = 0;
            $Geraltotalvalor_inss = 0;
            $Geraltotalvalor_irrf = 0;
            $Geraltotaloutrasretencoes = 0;
            $Geraltotale50_valorremuneracao = 0;
            $Geraltotalbasepatronal = 0;
            $auxRetencoes = 0;
            $auxInss = 0;
            $auxIrrf = 0;
            $valorliquido = 0;
            $totalvalorliquido = 0;
            $Geraltotalvalorliquido = 0;
            for ($cont = 0; $cont < count($aFornecedores); $cont++) {
                $oFornecedores = $oNotas      = db_utils::FieldsMemory($rsNota, $cont);
                $oFornecedores1 = $oNotas2      = db_utils::FieldsMemory($rsNota, $cont+1);

                // ordenar datas
                $oNotas->k12_data = implode("-", array_reverse(explode("-", $oNotas->k12_data)));
                $oNotas->e50_data = implode("-", array_reverse(explode("-", $oNotas->e50_data)));
                $oNotas->z01_nasc = implode("-", array_reverse(explode("-", $oNotas->z01_nasc)));

            if($sQuebra == 1){

                if (!isset($aFornecedores[$hash]) && $oNotas->e60_numcgm) {
                        if ($cont >= 1) {
                            $or = "OR" . $cont;
                        }
                    if($oNotas->e23_ativo == "f"){
                        $oNotas->outrasretencoes = 0;
                        $oNotas->valor_inss = 0;
                        $oNotas->valor_irrf = 0;
                    }

                    if(!$auxe50_codord)
                        $auxe50_codord = $oNotas->e50_codord;
                        // Lista de Fornecedores

                    if($auxe60_numcgm != $oNotas->e60_numcgm){

                        echo <<<HTML

                        <tr>
                            <td class="s1" colspan="20"><b>$oNotas->e60_numcgm - $oNotas->z01_cgccpf-$oNotas->z01_nome - CBO - $oNotas->rh70_estrutural - Nascimento - $oNotas->z01_nasc</b></td>
                        </tr>
HTML;
                    $auxe60_numcgm = $oNotas->e60_numcgm;
                    }
                    if($oNotas->e50_codord == $oNotas2->e50_codord){
                        if($auxRetencoes != $oNotas->outrasretencoes)
                            $auxRetencoes += $oNotas->outrasretencoes;
                        if($auxInss != $oNotas->valor_inss)
                            $auxInss += $oNotas->valor_inss;
                        if($auxIrrf != $oNotas->valor_irrf)
                            $auxIrrf +=$oNotas->valor_irrf;
                        $auxe50_codord = $oNotas->e50_codord;

                    }else{
                        if($auxRetencoes != $oNotas->outrasretencoes)
                            $auxRetencoes += $oNotas->outrasretencoes;
                        if($auxInss != $oNotas->valor_inss)
                            $auxInss += $oNotas->valor_inss;
                        if($auxIrrf != $oNotas->valor_irrf)
                            $auxIrrf +=$oNotas->valor_irrf;

                        $auxe50_codord = $oNotas->e50_codord;

                        $valorliquido = $oNotas->e70_vlrliq - $auxInss - $auxIrrf - $auxRetencoes;

                        $totale70_vlrliq += $oNotas->e70_vlrliq;
                        $totalvalor_inss += $auxInss;
                        $totalvalor_irrf += $auxIrrf;
                        $totaloutrasretencoes += $auxRetencoes;
                        $totalpatronal += FormatTotalNumberTwoDecimal($oNotas->patronal);
                        $totale50_valorremuneracao += $oNotas->e50_valorremuneracao;
                        $totalbasepatronal += $oNotas->basepatronal;
                        $totalvalorliquido += $valorliquido;

                        $oNotas->patronal = FormatTotalNumberTwoDecimal($oNotas->patronal);

                        $Geraltotale70_vlrliq += $oNotas->e70_vlrliq;
                        $Geraltotalvalor_inss += $auxInss;
                        $Geraltotalvalor_irrf += $auxIrrf;
                        $Geraltotaloutrasretencoes += $auxRetencoes;
                        $Geraltotalpatronal += $oNotas->patronal;
                        $Geraltotale50_valorremuneracao += $oNotas->e50_valorremuneracao;
                        $Geraltotalbasepatronal += $oNotas->basepatronal;
                        $Geraltotalvalorliquido += $valorliquido;

                        $auxRetencoes = db_formatar($auxRetencoes, "f");
                        $auxInss = db_formatar($auxInss, "f");
                        $auxIrrf = db_formatar($auxIrrf, "f");
                        $oNotas->e70_vlrliq = db_formatar($oNotas->e70_vlrliq, "f");
                        $oNotas->basepatronal = db_formatar($oNotas->basepatronal, "f");
                        $valorliquido    = db_formatar($valorliquido, "f");


                        if(!$oNotas->e50_valorremuneracao)
                            $oNotas->e50_valorremuneracao = db_formatar(0, "f");
                        else
                            $oNotas->e50_valorremuneracao = db_formatar($oNotas->e50_valorremuneracao, "f");


                        echo <<<HTML
                        <tr style="height: 20px">
                            <th id="0R{$or}" style="height: 20px;" class="row-headers-background">
                            <div class="row-header-wrapper" style="line-height: 20px">
                            </th>
                            <td class="s1" dir="ltr">$oNotas->e50_codord</td>
                            <td class="s1" dir="ltr">$oNotas->e50_data</td>
                            <td class="s1" dir="ltr">$oNotas->e69_numero</td>
                            <td class="s1" dir="ltr">R$ $oNotas->e70_vlrliq</td>
                            <td class="s1" dir="ltr">R$ $auxInss</td>
                            <td class="s1" dir="ltr">R$ $auxIrrf</td>
                            <td class="s1" dir="ltr">R$ $auxRetencoes</td>
                            <td class="s1" dir="ltr">R$ $oNotas->basepatronal</td>
                            <td class="s3" dir="ltr">R$ $oNotas->patronal</td>
                            <td class="s3" dir="ltr">$oNotas->e50_cattrabalhador</td>
                            <td class="s3" dir="ltr">$oNotas->e50_contribuicaoprev</td>
                            <td class="s3" dir="ltr">$oNotas->e50_empresadesconto</td>
                            <td class="s3" dir="ltr">$oNotas->e50_cattrabalhadorremurenacao</td>
                            <td class="s1" dir="ltr">R$ $oNotas->e50_valorremuneracao</td>
                            <td class="s1" dir="ltr">R$ $valorliquido</td>
                            <td class="s3" dir="ltr">$oNotas->k12_data</td>
                        </tr> </br>
HTML;

                        if($oNotas2->e60_numcgm != $oNotas->e60_numcgm){
                            $totalpatronal        = db_formatar($totalpatronal, "f");
                            $totaloutrasretencoes = db_formatar($totaloutrasretencoes, "f");
                            $totalvalor_inss      = db_formatar($totalvalor_inss, "f");
                            $totale70_vlrliq      = db_formatar($totale70_vlrliq, "f");
                            $totalvalor_irrf      = db_formatar($totalvalor_irrf, "f");
                            $totalbasepatronal    = db_formatar($totalbasepatronal, "f");
                            $totale50_valorremuneracao        = db_formatar($totale50_valorremuneracao, "f");
                            $totalvalorliquido    = db_formatar($totalvalorliquido, "f");

                            echo <<<HTML

                            <tr>
                                <td class="s0" colspan="4"><b>Total Fornecedor: </b></td>
                                <td class="s0" ><b>R$ $totale70_vlrliq</b></td>
                                <td class="s0" ><b>R$ $totalvalor_inss</b></td>
                                <td class="s0" ><b>R$ $totalvalor_irrf</b></td>
                                <td class="s0" ><b>R$ $totaloutrasretencoes</b></td>
                                <td class="s0" ><b>R$ $totalbasepatronal</b></td>
                                <td class="s0" ><b>R$ $totalpatronal</b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b>R$ $totale50_valorremuneracao</b></td>
                                <td class="s0" ><b>R$ $totalvalorliquido</b></td>
                                <td class="s0" ><b></b></td>
                            </tr>
HTML;

                        $totale70_vlrliq = 0;
                        $totalvalor_inss = 0;
                        $totalvalor_irrf = 0;
                        $totaloutrasretencoes = 0;
                        $totalpatronal = 0;
                        $totale50_valorremuneracao = 0;
                        $totalbasepatronal = 0;
                        $totalvalorliquido = 0;

                        }
                        $auxRetencoes = 0;
                        $auxInss = 0;
                        $auxIrrf = 0;

                        if(($cont+1) == count($aFornecedores)){
                            $Geraltotale70_vlrliq   = db_formatar($Geraltotale70_vlrliq, "f");
                            $Geraltotalvalor_inss   = db_formatar($Geraltotalvalor_inss, "f");
                            $Geraltotalvalor_irrf   = db_formatar($Geraltotalvalor_irrf, "f");
                            $Geraltotaloutrasretencoes = db_formatar($Geraltotaloutrasretencoes, "f");
                            $Geraltotalpatronal     = db_formatar($Geraltotalpatronal, "f");
                            $Geraltotale50_valorremuneracao = db_formatar($Geraltotale50_valorremuneracao, "f");
                            $Geraltotalbasepatronal = db_formatar($Geraltotalbasepatronal, "f");
                            $Geraltotalvalorliquido = db_formatar($Geraltotalvalorliquido, "f");
                            echo <<<HTML
                            <tr>
                                <td class="s0" colspan="4"><b>Total Geral: </b></td>
                                <td class="s0" ><b>R$ $Geraltotale70_vlrliq</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalor_inss</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalor_irrf</b></td>
                                <td class="s0" ><b>R$ $Geraltotaloutrasretencoes</b></td>
                                <td class="s0" ><b>R$ $Geraltotalbasepatronal</b></td>
                                <td class="s0" ><b>R$ $Geraltotalpatronal</b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b>R$ $Geraltotale50_valorremuneracao</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalorliquido</b></td>
                                <td class="s0" ><b></b></td>
                            </tr>
HTML;

                        $Geraltotale70_vlrliq = 0;
                        $Geraltotalvalor_inss = 0;
                        $Geraltotalvalor_irrf = 0;
                        $Geraltotaloutrasretencoes = 0;
                        $Geraltotalpatronal = 0;
                        $Geraltotale50_valorremuneracao = 0;
                        $Geraltotalbasepatronal = 0;
                        $Geraltotalvalorliquido = 0;
                        }
                        }

                    }
                }
                if($sQuebra == 2){

                    if($oNotas->e23_ativo == "f"){
                        $oNotas->outrasretencoes = 0;
                        $oNotas->valor_inss = 0;
                        $oNotas->valor_irrf = 0;
                    }

                    if($auxo58_projativ != $oNotas->o58_projativ){

                        echo <<<HTML

                        <tr>
                            <td class="s2" colspan="20"><b>$oNotas->o58_projativ - $oNotas->o55_descr</b></td>
                        </tr>




HTML;
                    if($oNotas->o58_codigo == $auxo58_codigo){
echo <<<HTML

                        <tr>
                             <td class="s1" colspan="20"><b>$oNotas->o58_codigo - $oNotas->o15_descr</b></td>
                        </tr>


HTML;
                        }
                    $auxo58_projativ = $oNotas->o58_projativ;
                    }
                    if($oNotas->o58_codigo != $auxo58_codigo){

                        echo <<<HTML

                        <tr>
                            <td class="s1" colspan="20"><b>$oNotas->o58_codigo - $oNotas->o15_descr</b></td>
                        </tr>



HTML;
                    $auxo58_codigo = $oNotas->o58_codigo;
                    }
                    if($oNotas->e60_codemp == $oNotas2->e60_codemp && $oNotas->e60_numcgm == $oNotas2->e60_numcgm && $oNotas->e50_codord == $oNotas2->e50_codord ){
                        if($auxRetencoes != $oNotas->outrasretencoes)
                            $auxRetencoes += $oNotas->outrasretencoes;
                        if($auxInss != $oNotas->valor_inss)
                            $auxInss += $oNotas->valor_inss;
                        if($auxIrrf != $oNotas->valor_irrf)
                            $auxIrrf +=$oNotas->valor_irrf;

                    }else{
                        if($auxRetencoes != $oNotas->outrasretencoes)
                            $auxRetencoes += $oNotas->outrasretencoes;
                        if($auxInss != $oNotas->valor_inss)
                            $auxInss += $oNotas->valor_inss;
                        if($auxIrrf != $oNotas->valor_irrf)
                            $auxIrrf +=$oNotas->valor_irrf;
                        $valorliquido = $oNotas->e70_vlrliq - $auxInss - $auxIrrf - $auxRetencoes;

                        $totale70_vlrliq += $oNotas->e70_vlrliq;
                        $totalvalor_inss += $auxInss;
                        $totalvalor_irrf += $auxIrrf;
                        $totaloutrasretencoes += $auxRetencoes;
                        $totalpatronal += FormatTotalNumberTwoDecimal($oNotas->patronal);
                        $totale50_valorremuneracao += $oNotas->e50_valorremuneracao;
                        $totalbasepatronal += $oNotas->basepatronal;
                        $totalvalorliquido += $valorliquido;

                        $auxRetencoes = db_formatar($auxRetencoes, "f");
                        $auxInss = db_formatar($auxInss, "f");
                        $auxIrrf = db_formatar($auxIrrf, "f");
                        $oe70_vlrliq = db_formatar($oNotas->e70_vlrliq, "f");
                        $valorliquido = db_formatar($valorliquido, "f");

                        $oNotas->patronal = FormatNumberTwoDecimal($oNotas->patronal);
                        $oNotas->basepatronal = db_formatar($oNotas->basepatronal, "f");
                        $oNotas->e50_valorremuneracao = db_formatar($oNotas->e50_valorremuneracao, "f");

                        echo <<<HTML
                        <tr style="height: 20px">
                            <th id="0R{$or}" style="height: 20px;" class="row-headers-background">
                            <div class="row-header-wrapper" style="line-height: 20px">
                            </th>
                            <td class="s1" dir="ltr">$oNotas->e60_numcgm - $oNotas->z01_nome - Nascimento - $oNotas->z01_nasc</td>
                            <td class="s1" dir="ltr">$oNotas->e50_codord</td>
                            <td class="s1" dir="ltr">$oNotas->e50_data</td>
                            <td class="s1" dir="ltr">$oNotas->e69_numero</td>
                            <td class="s1" dir="ltr">R$ $oe70_vlrliq</td>
                            <td class="s1" dir="ltr">R$ $auxInss</td>
                            <td class="s1" dir="ltr">R$ $auxIrrf</td>
                            <td class="s1" dir="ltr">R$ $auxRetencoes</td>
                            <td class="s1" dir="ltr">R$ $oNotas->basepatronal</td>
                            <td class="s3" dir="ltr">R$ $oNotas->patronal</td>
                            <td class="s3" dir="ltr">$oNotas->e50_cattrabalhador</td>
                            <td class="s3" dir="ltr">$oNotas->e50_contribuicaoprev</td>
                            <td class="s3" dir="ltr">$oNotas->e50_empresadesconto</td>
                            <td class="s3" dir="ltr">$oNotas->e50_cattrabalhadorremurenacao</td>
                            <td class="s1" dir="ltr">R$ $oNotas->e50_valorremuneracao</td>
                            <td class="s1" dir="ltr">R$ $valorliquido</td>
                            <td class="s3" dir="ltr">$oNotas->k12_data</td>
                        </tr> </br>
HTML;

                        if($oNotas->o58_codigo != $oNotas2->o58_codigo || $oNotas->o58_projativ != $oNotas2->o58_projativ){
                            $Geraltotale70_vlrliq += $totale70_vlrliq;
                            $Geraltotalvalor_inss += $totalvalor_inss;
                            $Geraltotalvalor_irrf += $totalvalor_irrf;
                            $Geraltotaloutrasretencoes += $totaloutrasretencoes;
                            $Geraltotalpatronal += $totalpatronal;
                            $Geraltotale50_valorremuneracao += $totale50_valorremuneracao;
                            $Geraltotalbasepatronal += $totalbasepatronal;
                            $Geraltotalvalorliquido += $totalvalorliquido;

                            $totalpatronal           = db_formatar($totalpatronal,"f");
                            $totalbasepatronal       = db_formatar(floor(($totalbasepatronal*100))/100,"f");
                            $totaloutrasretencoes    = db_formatar($totaloutrasretencoes, "f");
                            $totalvalor_inss         = db_formatar($totalvalor_inss, "f");
                            $totale70_vlrliq         = db_formatar($totale70_vlrliq, "f");
                            $totalvalor_irrf         = db_formatar($totalvalor_irrf, "f");
                            $totale50_valorremuneracao = db_formatar($totale50_valorremuneracao, "f");
                            $totalvalorliquido      = db_formatar($totalvalorliquido, "f");

                            echo <<<HTML

                            <tr>
                                <td class="s0" colspan="5"><b>Total Ação: </b></td>
                                <td class="s0" ><b>R$ $totale70_vlrliq</b></td>
                                <td class="s0" ><b>R$ $totalvalor_inss</b></td>
                                <td class="s0" ><b>R$ $totalvalor_irrf</b></td>
                                <td class="s0" ><b>R$ $totaloutrasretencoes</b></td>
                                <td class="s0" ><b>R$ $totalbasepatronal</b></td>
                                <td class="s0" ><b>R$ $totalpatronal</b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b>R$ $totale50_valorremuneracao</b></td>
                                <td class="s0" ><b>R$ $totalvalorliquido</b></td>
                                <td class="s0" ><b></b></td>
                            </tr>
HTML;

                        $totale70_vlrliq = 0;
                        $totalvalor_inss = 0;
                        $totalvalor_irrf = 0;
                        $totaloutrasretencoes = 0;
                        $totalpatronal = 0;
                        $totalvalorliquido = 0;

                        $totale50_valorremuneracao = 0;
                        $totalbasepatronal = 0;

                        }
                        $auxRetencoes = 0;
                        $auxInss = 0;
                        $auxIrrf = 0;

                        if(($cont+1) == count($aFornecedores)){
                            $Geraltotale70_vlrliq = db_formatar($Geraltotale70_vlrliq, "f");
                            $Geraltotalvalor_inss = db_formatar($Geraltotalvalor_inss, "f");
                            $Geraltotalvalor_irrf = db_formatar($Geraltotalvalor_irrf, "f");
                            $Geraltotaloutrasretencoes = db_formatar($Geraltotaloutrasretencoes, "f");
                            $Geraltotalpatronal = db_formatar($Geraltotalpatronal, "f");
                            $Geraltotale50_valorremuneracao = db_formatar($Geraltotale50_valorremuneracao, "f");
                            $Geraltotalbasepatronal = db_formatar($Geraltotalbasepatronal, "f");
                            $Geraltotalvalorliquido = db_formatar($Geraltotalvalorliquido, "f");
                            echo <<<HTML
                            <tr>
                                <td class="s0" colspan="5"><b>Total Geral: </b></td>
                                <td class="s0" ><b>R$ $Geraltotale70_vlrliq</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalor_inss</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalor_irrf</b></td>
                                <td class="s0" ><b>R$ $Geraltotaloutrasretencoes</b></td>
                                <td class="s0" ><b>R$ $Geraltotalbasepatronal</b></td>
                                <td class="s0" ><b>R$ $Geraltotalpatronal</b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b></b></td>
                                <td class="s0" ><b>R$ $Geraltotale50_valorremuneracao</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalorliquido</b></td>
                                <td class="s0" ><b></b></td>
                            </tr>
HTML;

}
                        }
                    }

                    }
            ?>
            </tbody>
        </table>
    </div>
    </body>

    </html>

<?php

$html = ob_get_contents();
ob_end_clean();
$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();
} catch (MpdfException $e) {
    db_redireciona('db_erros.php?fechar=true&db_erro='.$e->getMessage());
}
db_fim_transacao();

function FormatNumberTwoDecimal($value)
    {
        $value    = str_replace(',', '.', $value);
        $value    = floatval($value);
        $number   = number_format($value, 3, ',', '.');
        $number   = explode(',',$number);
        $decimals = $number[0].",".substr($number[1],0,2);
        return $decimals;
    }
function FormatTotalNumberTwoDecimal($value)
    {
        $value    = floatval($value);
        $number   = number_format($value, 3, ',', '.');
        $number   = explode(',',$number);
        $decimals = str_replace('.','',$number[0]).".".substr($number[1],0,2);
        return $decimals;
    }
?>
