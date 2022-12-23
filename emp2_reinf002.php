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
require("vendor/mpdf/mpdf/mpdf.php");

require_once("libs/db_utils.php");

require_once("libs/JSON.php");

require_once("dbforms/db_funcoes.php");
require_once("classes/db_empnota_classe.php");
require_once("classes/db_empnotaitem_classe.php");

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

if (isset($dtDataInicial)) {
  
  $sSqlNota  = "select distinct e50_codord,";
  $sSqlNota .= " e60_codemp,";
  $sSqlNota .= " cgm.z01_nome,";
  $sSqlNota .= " cgm.z01_cgccpf,";
  $sSqlNota .= " e60_numcgm ,";
  $sSqlNota .= " e69_numero,";
  $sSqlNota .= " e69_dtnota,";
  $sSqlNota .= " e50_data,";
  $sSqlNota .= " e70_vlrliq,";
  $sSqlNota .= " e60_anousu,";
  $sSqlNota .= " case when retencaotiporec.e21_retencaotipocalc in (3,4,7) then (coalesce(e23_valorretencao, 0))
                    else 0  end as valor_inss, ";
  $sSqlNota .= " case when retencaotiporec.e21_retencaotipocalc in (1,2) then (coalesce(e23_valorretencao, 0))
                    else 0 end as valor_irrf,";
  $sSqlNota .= " case when retencaotiporec.e21_retencaotipocalc in (5,6) then (coalesce(e23_valorretencao, 0))
		            else 0 end as outrasretencoes, ";
  $sSqlNota .= " case when c71_coddoc = 904 then c71_data end as c71_data, ";
  $sSqlNota .= " e69_nfserie, e21_descricao, e23_ativo,e71_anulado, o58_codigo,o58_projativ,o55_descr,o15_descr ";                                  
  $sSqlNota .= "       from empnota ";
  $sSqlNota .= "          inner join empempenho   on e69_numemp  = e60_numemp";
  $sSqlNota .= "          inner join orcdotacao on  (o58_coddot,o58_anousu) = (e60_coddot,e60_anousu)";	
  $sSqlNota .= "          inner join orcprojativ on (o55_projativ,o55_anousu) = (o58_projativ,o58_anousu)";
  $sSqlNota .= "          inner join orctiporec on o15_codigo = o58_codigo";
  $sSqlNota .= "          inner join cgm as cgm   on e60_numcgm  = cgm.z01_numcgm";
  $sSqlNota .= "          inner join empnotaele   on e69_codnota = e70_codnota";
  $sSqlNota .= "          inner join orcelemento  on empnotaele.e70_codele = orcelemento.o56_codele";
  $sSqlNota .= "          left join conlancamemp on c75_numemp = e60_numemp ";
  $sSqlNota .= "          left join conlancamdoc on c71_codlan = c75_codlan and c71_coddoc = 904 ";
  $sSqlNota .= "          left  join pagordemnota on e71_codnota = e69_codnota";
  $sSqlNota .= "                                 and e71_anulado is false";
  $sSqlNota .= "          left  join pagordem    on  e71_codord = e50_codord";
  $sSqlNota .= "          left  join pagordemele  on e53_codord = e50_codord";
  $sSqlNota .= "          left join retencaopagordem on pagordem.e50_codord = retencaopagordem.e20_pagordem";
  $sSqlNota .= "          left join retencaoreceitas on retencaoreceitas.e23_retencaopagordem = retencaopagordem.e20_sequencial";
  $sSqlNota .= "          left join retencaotiporec on retencaotiporec.e21_sequencial = retencaoreceitas.e23_retencaotiporec"; 

  $dtDataInicial = implode("-", array_reverse(explode("/", $dtDataInicial)));
  $dtDataFinal = implode("-", array_reverse(explode("/", $dtDataFinal)));
   
  if($sReferencia == 1)
    $sSqlNota .= "  where (e50_data BETWEEN '$dtDataInicial' AND '$dtDataFinal' ) ";
  if($sReferencia == 2)  
    $sSqlNota .= "  where (e69_dtnota BETWEEN '$dtDataInicial' AND '$dtDataFinal' ) ";

  if($sCredoresSelecionados){
    if($sTipoSelecao == 1)
            $sSqlNota .= "   and  e60_numcgm in ({$sCredoresSelecionados}) and Length(cgm.z01_cgccpf) = 14 and e60_instit = $instits";
    if($sTipoSelecao == 2)
        $sSqlNota .= "   and  e60_numcgm not in ({$sCredoresSelecionados}) and Length(cgm.z01_cgccpf) = 14 and e60_instit = $instits";
  }else 
    $sSqlNota .= "  and Length(cgm.z01_cgccpf) = 14 and e60_instit = $instits ";
 
 if($sTipo == '1')
    $sSqlNota .= "  and ( retencaotiporec.e21_retencaotipocalc in (1,2,3,4,5,6,7) and e23_ativo = true ) ";
  elseif($sTipo == '2')   
    $sSqlNota .= " and ( retencaotiporec.e21_retencaotipocalc is null or ( retencaotiporec.e21_retencaotipocalc is null and e23_ativo = false ) or (  retencaotiporec.e21_retencaotipocalc is not null
    and e23_ativo = false) ) ";

 if ($sQuebra == 2){
    $sSqlNota .= " and  c71_data is null  ";
 }   
 
  $sSqlNota .= "  group by     1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22";

  if($sQuebra == 1)
        $sSqlNota .= "  order by     3,1 ";
  if($sQuebra == 2)
        $sSqlNota .= " order by o58_projativ,o58_codigo";  

  $rsNota    = $oDaoEmpNota->sql_record($sSqlNota);
//   echo $oDaoEmpNota->numrows ;
//   db_criatabela($rsNota);exit;
// echo $sSqlNota;exit;
$aFornecedores = pg_fetch_all($rsNota);
  
  if ($oDaoEmpNota->numrows > 0 ) {
    $oNotas      = db_utils::FieldsMemory($rsNota, 0);
  }
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

$mPDF = new mpdf('', 'A4-L', 0, '', 15, 15, 20, 15, 5, 11, 'L');

/*Nome do relatório.*/
$header = " <header>
                <div style=\" height: 120px; font-family:Arial\">
                    <div style=\"width:38%; float:left; padding:5px; font-size:10px;\">
                        <b><i>{$oInstit->getDescricao()}</i></b><br/>
                        <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
                        <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
                        <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
                        <i>{$oInstit->getSite()}</i>
                    </div>
                    <div style=\"width:40%; float:right\" class=\"box\">
                    <b>Retenções Pessoa Jurídica</b><br/>  ";
foreach ($aInstits as $iInstit) {
    $oInstituicao = new Instituicao($iInstit);
    $header .= "<b>Instituição: </b>".trim($oInstituicao->getCodigo()) . " - " . $oInstituicao->getDescricao();
}

/*Período do relatório.*/
$header .= "<br/><b>Período:</b> {$dtDataInicial} <b>A</b> {$dtDataFinal}
                    </div>
                </div>
            </header>";


$footer  = "<footer style='padding-top: 150px;'>";
$footer .= "   <div style='border-top:1px solid #000; width:100%; font-family:sans-serif; font-size:7px; height:5px;padding-bottom: -12px;'>";
$footer .= "    <div style='text-align:left;font-style:italic;width:90%;float:left;padding-bottom: -82px;'>";
$footer .= "       Financeiro>Empenho>Relatorios de Conferencia>Retenções Pessoa Jurídica";
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
                <font size="-1">Retenções Pessoa Jurídica</font>
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
                <? if($sQuebra == 2) {?>
                    <td class="s0" dir="ltr" ><font size="-1"> Credor </font></td> 
                <? } ?>    
                <td class="s0" dir="ltr" ><font size="-1"> Empenho </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> OP </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Data OP </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Série da NF </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Numero da NF</font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Data Emissão NF </font></td>                
                <td class="s0" dir="ltr" ><font size="-1"> Valor Liquidado </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Valor INSS </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Valor IRRF </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Outras Retenções </font></td>
                <td class="s0" dir="ltr" ><font size="-1"> Detalhamento das Outras Retenções </font></td>
                

            </tr>
            <?php

            $pagina = 0;
            $contador = 1;
            $control = 0;
            $totale70_vlrliq = 0;
            $totalvalor_inss = 0;
            $totalvalor_irrf = 0;
            $totaloutrasretencoes = 0;
            $totale50_valorremuneracao = 0;
            $totale50_valordesconto = 0;
            $Geraltotale70_vlrliq = 0;
            $Geraltotalvalor_inss = 0;
            $Geraltotalvalor_irrf = 0;
            $Geraltotaloutrasretencoes = 0;
            $Geraltotale50_valorremuneracao = 0;
            $Geraltotale50_valordesconto = 0;
            $auxRetencoes = 0;
            $auxInss = 0;
            $auxIrrf = 0;
            $quebradelinha = 0;
               
            for ($cont = 0; $cont < count($aFornecedores); $cont++) {
                $oFornecedores = $oNotas      = db_utils::FieldsMemory($rsNota, $cont);  
                $oFornecedores1 = $oNotas2      = db_utils::FieldsMemory($rsNota, $cont+1);  

                // ordenar datas
                $oNotas->e50_data = implode("-", array_reverse(explode("-", $oNotas->e50_data)));
                $oNotas->c71_data = implode("-", array_reverse(explode("-", $oNotas->c71_data)));
                $oNotas->k12_data = implode("-", array_reverse(explode("-", $oNotas->k12_data)));
                $oNotas->e69_dtnota = implode("-", array_reverse(explode("-", $oNotas->e69_dtnota)));
                
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
                            <td class="s1" colspan="20"><b>$oNotas->e60_numcgm - CNPJ - $oNotas->z01_cgccpf - $oNotas->z01_nome</b></td>
                        </tr>
HTML;
                    $auxe60_numcgm = $oNotas->e60_numcgm;
                    }
                   
                    if($oNotas->e50_codord == $oNotas2->e50_codord){
                        if($oNotas->e21_descricao != $oNotas2->e21_descricao){
                            $auxRetencoes += $oNotas->outrasretencoes;
                            $auxInss += $oNotas->valor_inss;
                            $auxIrrf +=$oNotas->valor_irrf;
                        }
                        $auxe50_codord = $oNotas->e50_codord;
                        
                        if($oNotas->e71_anulado == 't'){
                            $dataestorno = $oNotas->c71_data;
                        }
                                             
                        if($oNotas->outrasretencoes == 0)
                            $descricao .= '';
                        else{
                            if($oNotas->e21_descricao != $oNotas2->e21_descricao){
                                $quebradelinha ++;
                                $descricao .= " R$ ".db_formatar($oNotas->outrasretencoes, "f")." - ".$oNotas->e21_descricao;
                            }
                            if($quebradelinha == 1){
                                $descricao .= "<br/>";
                                $quebradelinha = 0;
                            }
                        }
                    }else{   
                        $auxRetencoes += $oNotas->outrasretencoes;
                        $auxInss += $oNotas->valor_inss;
                        $auxIrrf +=$oNotas->valor_irrf;

                        $auxe50_codord = $oNotas->e50_codord;
                        
                        $totale70_vlrliq += $oNotas->e70_vlrliq;
                        $totalvalor_inss += $auxInss;
                        $totalvalor_irrf += $auxIrrf;
                        $totaloutrasretencoes += $auxRetencoes;

                        $Geraltotale70_vlrliq += $oNotas->e70_vlrliq;
                        $Geraltotalvalor_inss += $auxInss;
                        $Geraltotalvalor_irrf += $auxIrrf;
                        $Geraltotaloutrasretencoes += $auxRetencoes;
                        
                        $auxRetencoes = db_formatar($auxRetencoes, "f");
                        $auxInss = db_formatar($auxInss, "f");
                        $auxIrrf = db_formatar($auxIrrf, "f");
                        $oNotas->e70_vlrliq = db_formatar($oNotas->e70_vlrliq, "f");
                        $totale70_vlrliq1 = db_formatar($totale70_vlrliq, "f");
                        $totalvalor_inss1 = db_formatar($totalvalor_inss, "f");
                        $totalvalor_irrf1 = db_formatar($totalvalor_irrf, "f");
                        $totaloutrasretencoes1 = db_formatar($totaloutrasretencoes, "f");
                       
                        if($oNotas->e71_anulado == 'f'){
                            $dataestorno = $oNotas->c71_data;
                        }
                                          
                        if($oNotas->outrasretencoes == 0)
                            $descricao .= '';
                        else
                            $descricao .= "R$ ".db_formatar($oNotas->outrasretencoes, "f")." - ".$oNotas->e21_descricao; 
                                                                        
                        echo <<<HTML
                        <tr style="height: 20px">
                            <th id="0R{$or}" style="height: 20px;" class="row-headers-background">
                            <div class="row-header-wrapper" style="line-height: 20px">
                            </th>

                            <td class="s1" dir="ltr">$oNotas->e60_codemp/$oNotas->e60_anousu</td>
                            <td class="s1" dir="ltr">$oNotas->e50_codord</td>
                            <td class="s1" dir="ltr">$oNotas->e50_data</td>
                            <td class="s1" dir="ltr">$oNotas->e69_nfserie</td>
                            <td class="s1" dir="ltr">$oNotas->e69_numero</td>
                            <td class="s1" dir="ltr">$oNotas->e69_dtnota</td>
                            <td class="s1" dir="ltr">R$ $oNotas->e70_vlrliq</td>
                            <td class="s1" dir="ltr">R$ $auxInss</td>
                            <td class="s1" dir="ltr">R$ $auxIrrf</td>
                            <td class="s1" dir="ltr">R$ $auxRetencoes</td>
                            <td class="s1" dir="ltr">$descricao</td>
                        </tr> </br>                    
HTML;
                        
                        if($oNotas2->e60_numcgm != $oNotas->e60_numcgm){
                            echo <<<HTML
                       
                            <tr>
                                <td class="s0" colspan="7"><b>Total Fornecedor: </b></td>
                                <td class="s0" ><b>R$ $totale70_vlrliq1</b></td>
                                <td class="s0" ><b>R$ $totalvalor_inss1</b></td>
                                <td class="s0" ><b>R$ $totalvalor_irrf1</b></td>
                                <td class="s0" ><b>R$ $totaloutrasretencoes1</b></td>
                                <td class="s0" ><b></b></td>
                               
                                
                            </tr>
HTML;
                        
                        $totale70_vlrliq = 0;
                        $totalvalor_inss = 0;
                        $totalvalor_irrf = 0;
                        $totaloutrasretencoes = 0;
                        $totale50_valorremuneracao = 0;
                        $totale50_valordesconto = 0;
                        
                        }
                        $auxRetencoes = 0;
                        $auxInss = 0;
                        $auxIrrf = 0; 
                        $descricao = '';
                        $quebradelinha = 0;
                        if(($cont+1) == count($aFornecedores)){
                            $Geraltotale70_vlrliq = db_formatar($Geraltotale70_vlrliq, "f");
                            $Geraltotalvalor_inss = db_formatar($Geraltotalvalor_inss, "f");
                            $Geraltotalvalor_irrf = db_formatar($Geraltotalvalor_irrf, "f");
                            $Geraltotaloutrasretencoes = db_formatar($Geraltotaloutrasretencoes, "f");
                            $Geraltotale50_valorremuneracao = db_formatar($Geraltotale50_valorremuneracao, "f");
                            $Geraltotale50_valordesconto = db_formatar($Geraltotale50_valordesconto, "f");
                            echo <<<HTML
                            <tr>
                                <td class="s0" colspan="7"><b>Total Geral: </b></td>
                                <td class="s0" ><b>R$ $Geraltotale70_vlrliq</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalor_inss</b></td>
                                <td class="s0" ><b>R$ $Geraltotalvalor_irrf</b></td>
                                <td class="s0" ><b>R$ $Geraltotaloutrasretencoes</b></td>
                                <td class="s0" ><b></b></td>
                                
                            </tr>
HTML;
      
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
                    if($oNotas->e50_codord == $oNotas2->e50_codord){
                        $auxRetencoes += $oNotas->outrasretencoes;
                        $auxInss += $oNotas->valor_inss;
                        $auxIrrf += $oNotas->valor_irrf;  
                        
                        if($oNotas->outrasretencoes == 0)
                            $descricao .= '';
                        else{
                            if($oNotas->e21_descricao != $oNotas2->e21_descricao){
                                $quebradelinha ++;
                                $descricao .= " R$ ".db_formatar($oNotas->outrasretencoes, "f")." - ".$oNotas->e21_descricao;
                            }
                            if($quebradelinha == 1){
                                $descricao .= "<br/>";
                                $quebradelinha = 0;
                            }
                        }   
                      
                    }else{ 
                        $auxRetencoes += $oNotas->outrasretencoes;
                        $auxInss += $oNotas->valor_inss;
                        $auxIrrf +=$oNotas->valor_irrf;
                        
                        $totale50_valorremuneracao += $oNotas->e50_valorremuneracao;
                        
                        
                        $totale70_vlrliq += $oNotas->e70_vlrliq;
                        $totalvalor_inss += $auxInss;
                        $totalvalor_irrf += $auxIrrf;
                        $totaloutrasretencoes += $auxRetencoes;
                        
                        $Geraltotale70_vlrliq += $oNotas->e70_vlrliq;
                        $Geraltotalvalor_inss += $auxInss;
                        $Geraltotalvalor_irrf += $auxIrrf;
                        $Geraltotaloutrasretencoes += $auxRetencoes;
                        
                        $oNotas->e70_vlrliq = db_formatar($oNotas->e70_vlrliq, "f");
                        $totale70_vlrliq1 = db_formatar($totale70_vlrliq, "f");
                        $totalvalor_inss1 = db_formatar($totalvalor_inss, "f");
                        $totalvalor_irrf1 = db_formatar($totalvalor_irrf, "f");
                        $totaloutrasretencoes1 = db_formatar($totaloutrasretencoes, "f");
                        $auxRetencoes = db_formatar($auxRetencoes, "f");
                        $auxInss = db_formatar($auxInss, "f");
                        $auxIrrf = db_formatar($auxIrrf, "f");
                        $oe70_vlrliq = db_formatar($oNotas->e70_vlrliq, "f");
                        $oNotas->e50_valorremuneracao = db_formatar($oNotas->e50_valorremuneracao, "f");
                        $totaloutrasretencoes1 = db_formatar($totaloutrasretencoes, "f");
                        
                        
                        if($oNotas->outrasretencoes == 0 || $oNotas->outrasretencoes == '')
                            $descricao .= '';
                        else
                            $descricao .= "R$ ".db_formatar($oNotas->outrasretencoes, "f")." - ".$oNotas->e21_descricao;
                                
                        echo <<<HTML
                       <tr style="height: 20px">
                            <th id="0R{$or}" style="height: 20px;" class="row-headers-background">
                            <div class="row-header-wrapper" style="line-height: 20px">
                            </th>
                            <td class="s1" dir="ltr">$oNotas->e60_numcgm - $oNotas->z01_cgccpf - $oNotas->z01_nome</td>
                            <td class="s1" dir="ltr">$oNotas->e60_codemp/$oNotas->e60_anousu</td>
                            <td class="s1" dir="ltr">$oNotas->e50_codord</td>
                            <td class="s1" dir="ltr">$oNotas->e50_data</td>
                            <td class="s1" dir="ltr">$oNotas->e69_nfserie</td>
                            <td class="s1" dir="ltr">$oNotas->e69_numero</td>
                            <td class="s1" dir="ltr">$oNotas->e69_dtnota</td>
                            <td class="s1" dir="ltr">R$ $oNotas->e70_vlrliq</td>
                            <td class="s1" dir="ltr">R$ $auxInss</td>
                            <td class="s1" dir="ltr">R$ $auxIrrf</td>
                            <td class="s1" dir="ltr">R$ $auxRetencoes</td>
                            <td class="s1" dir="ltr">$descricao</td>
                        </tr> </br>                 
HTML;

                        if($oNotas->o58_codigo != $oNotas2->o58_codigo || $oNotas->o58_projativ != $oNotas2->o58_projativ){
                            echo <<<HTML

                            <tr>
                                <td class="s0" colspan="8"><b>Total Fonte: </b></td>
                                <td class="s0" ><b>R$ $totale70_vlrliq1</b></td>
                                <td class="s0" ><b>R$ $totalvalor_inss1</b></td>
                                <td class="s0" ><b>R$ $totalvalor_irrf1</b></td>
                                <td class="s0" ><b>R$ $totaloutrasretencoes1</b></td>
                                <td class="s0" ><b></b></td>
                            
                                
                            </tr>
HTML;

                            $totale70_vlrliq = 0;
                            $totalvalor_inss = 0;
                            $totalvalor_irrf = 0;
                            $totaloutrasretencoes = 0;
                            $totale50_valorremuneracao = 0;
                            $totale50_valordesconto = 0;

                            }
                            $auxRetencoes = 0;
                            $auxInss = 0;
                            $auxIrrf = 0; 
                            $descricao = '';
                            $quebradelinha = 0;
                            if(($cont+1) == count($aFornecedores)){
                                $Geraltotale70_vlrliq = db_formatar($Geraltotale70_vlrliq, "f");
                                $Geraltotalvalor_inss = db_formatar($Geraltotalvalor_inss, "f");
                                $Geraltotalvalor_irrf = db_formatar($Geraltotalvalor_irrf, "f");
                                $Geraltotaloutrasretencoes = db_formatar($Geraltotaloutrasretencoes, "f");
                                $Geraltotale50_valorremuneracao = db_formatar($Geraltotale50_valorremuneracao, "f");
                                $Geraltotale50_valordesconto = db_formatar($Geraltotale50_valordesconto, "f");
                                echo <<<HTML
                                <tr>
                                    <td class="s0" colspan="8"><b>Total Geral: </b></td>
                                    <td class="s0" ><b>R$ $Geraltotale70_vlrliq</b></td>
                                    <td class="s0" ><b>R$ $Geraltotalvalor_inss</b></td>
                                    <td class="s0" ><b>R$ $Geraltotalvalor_irrf</b></td>
                                    <td class="s0" ><b>R$ $Geraltotaloutrasretencoes</b></td>
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

db_fim_transacao();

?>