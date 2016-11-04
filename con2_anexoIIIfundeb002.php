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

include("fpdf151/pdf.php");
include("libs/db_liborcamento.php");
include("libs/db_libcontabilidade.php");
include("libs/db_sql.php");
include("fpdf151/assinatura.php");
require("vendor/mpdf/mpdf/mpdf.php");

db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));
$oDataFim = new DBDate($dtfim);
$oDataIni = new DBDate($dtini);

$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",",$instits);
/*$sWhereDespesa      = " o58_instit in({$instits})";
$rsBalanceteDespesa = db_dotacaosaldo( 8,2,2, true, $sWhereDespesa,
    $anousu,
    $dtini,
    $datafin);
if (pg_num_rows($rsBalanceteDespesa) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum registro encontrado, verifique as datas e tente novamente');
}
db_query("drop table if exists anexoivgastopessoaldespesa; create table anexoivgastopessoaldespesa as select * from work_dotacao") or die(pg_last_error());
db_query("drop table if exists work_dotacao");*/

$sWhereReceita      = "o70_instit in ({$instits})";
$rsBalanceteReceita = db_receitasaldo( 3, 1, 3, true,
    $sWhereReceita, $anousu,
    $dtini,
    $datafin );

db_query("drop table if exists anexoivgastopessoalreceita; create table anexoivgastopessoalreceita as select * from work_receita") or die(pg_last_error());
db_query("drop table if exists work_receita");
//db_criatabela(db_query("select * from anexoivgastopessoalreceita"));
//exit;


$html = <<<HTML

<html>
<head>
  <style type='text/css'>.ritz .waffle a { color: inherit; }.ritz .waffle .s18{border-bottom:1px SOLID #000000;border-right:2px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s15{border-bottom:2px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s6{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s8{border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s20{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s24{border-bottom:2px SOLID #000000;border-right:2px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s9{border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s2{border-bottom:2px SOLID #000000;border-right:1px SOLID transparent;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s10{background-color:#ffffff;text-align:left;font-style:italic;color:#000000;font-family:'Calibri',Arial;font-size:8pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s3{border-bottom:2px SOLID #000000;border-right:2px SOLID #000000;background-color:#d8d8d8;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s0{border-bottom:1px SOLID transparent;border-right:2px SOLID #000000;background-color:#d8d8d8;text-align:center;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s11{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s13{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s4{border-bottom:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s23{border-bottom:2px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s12{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s21{border-bottom:1px SOLID #000000;border-right:2px SOLID #000000;background-color:#d8d8d8;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s14{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s17{border-bottom:2px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s22{border-bottom:2px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s7{background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s5{border-bottom:1px SOLID #000000;border-right:1px SOLID transparent;background-color:#d8d8d8;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s16{border-bottom:2px SOLID #000000;border-right:1px SOLID #000000;background-color:#ffffff;text-align:right;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s1{background-color:#ffffff;text-align:left;color:#000000;font-family:'Calibri',Arial;font-size:10pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}.ritz .waffle .s19{border-bottom:1px SOLID #000000;border-right:1px SOLID #000000;background-color:#d8d8d8;text-align:left;font-weight:bold;color:#000000;font-family:'Calibri',Arial;font-size:11pt;vertical-align:bottom;white-space:nowrap;direction:ltr;padding:2px 3px 2px 3px;}</style>
</head>
<body>
<div class='ritz grid-container' dir='ltr'>
    <table class='waffle' cellspacing='0' cellpadding='0'>
        <tbody>
        <tr style='height:20px;'>
            <td class='s0' colspan='8'>PREFEITURA MUNICIPAL DE BOTUMIRIM</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s1' colspan='8'>ANEXO III</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s3'></td>
            <td class='s4' colspan='7'>Período: De 01/01/2016 a 30/06/2016</td>
        </tr>
        <tr style='height:20px;'>
            <th id='0R4' style='height: 20px;' class='row-headers-background'>
            <td class='s5' colspan='8'>FUNDO DE MANUTENÇÃO E DESENVOLVIMENTO DA EDUCAÇÃO BÁSICA E DE VALORIZAÇÃO</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s5' colspan='8'>DOS PROFISSIONAIS DA EDUCAÇÃO ? FUNDEB</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s6' colspan='8'>DEMONSTRATIVO DOS RECURSOS RECEBIDOS E SUA APLICAÇÃO</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s7 softmerge'>
                <div class='softmerge-inner' style='width: 198px; left: -1px;'>01 - RECURSOS:</div>
            </td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s10'>R$</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s11 softmerge'>
                <div class='softmerge-inner' style='width: 298px; left: -1px;'>A - Transferências Multigovernamentais:
                </div>
            </td>
            <td class='s12'></td>
            <td class='s13'></td>
            <td class='s13'></td>
            <td class='s14'></td>
            <td class='s14'></td>
            <td class='s14'></td>
            <td class='s15'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 698px; left: -1px;'>1724.01.00 - Transferências de Recursos
                    do Fundo de Manuteção e Desenvolv. Da
                </div>
            </td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s8'></td>
            <td class='s8'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 598px; left: -1px;'>Educação Básica e de Valorização dos
                    Profissionais da Educação - FUNDEB
                </div>
            </td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s18'>846.744,70</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s11 softmerge'>
                <div class='softmerge-inner' style='width: 598px; left: -1px;'>1724.02.00 - Transf.de Recursos da
                    Complementação da União ao FUNDEB
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
            <td class='s13'></td>
            <td class='s19'>0,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 598px; left: -1px;'>B - Receitas de Aplicações Financeiras
                    (art. 20, § único, Lei Federal 11494/2007
                </div>
            </td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s20'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s11 softmerge'>
                <div class='softmerge-inner' style='width: 698px; left: -1px;'>1325.01.02- Receita de Remuneração de
                    Depósitos Bancários de Rec.Vinc.FUNDEB
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
            <td class='s21'>5.551,63</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s22' colspan='2'>TOTAL DO ITEM 01:</td>
            <td class='s23'>852.296,33</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s24'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s7 softmerge'>
                <div class='softmerge-inner' style='width: 498px; left: -1px;'>02 - APLICAÇÃO NA EDUCAÇÃO BÁSICA
                    PÚBLICA:
                </div>
            </td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s17'></td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s9'></td>
            <td class='s25'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s5'>Função</td>
            <td class='s5'>Subfunções</td>
            <td class='s5'>Programas</td>
            <td class='s5' colspan='3'>Especificação</td>
            <td class='s26' colspan='2'>DESPESA</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s24'></td>
            <td class='s24'></td>
            <td class='s24'></td>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s24'></td>
            <td class='s26'>Parcial</td>
            <td class='s26'>Total</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s26'>12</td>
            <td class='s24'></td>
            <td class='s24'></td>
            <td class='s27'>EDUCAÇÃO</td>
            <td class='s3'></td>
            <td class='s24'></td>
            <td class='s24'></td>
            <td class='s24'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s20'></td>
            <td class='s28'>122</td>
            <td class='s28'>...</td>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 198px; left: -1px;'>Administração Geral</div>
            </td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s29'>100.000,00</td>
            <td class='s29'>100.000,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s14'></td>
            <td class='s14'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s20'></td>
            <td class='s28'>272</td>
            <td class='s28'>...</td>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 298px; left: -1px;'>Previdência do Regime Estatutário</div>
            </td>
            <td class='s17'></td>
            <td class='s8'></td>
            <td class='s30'>100.000,00</td>
            <td class='s29'>100.000,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s14'></td>
            <td class='s14'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s20'></td>
            <td class='s28'>361</td>
            <td class='s28'>...</td>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 198px; left: -1px;'>Ensino Fundamental</div>
            </td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s29'>100.000,00</td>
            <td class='s29'>100.000,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s14'></td>
            <td class='s14'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s20'></td>
            <td class='s28'>365</td>
            <td class='s28'>...</td>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 198px; left: -1px;'>Educação Infantil</div>
            </td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s29'>100.000,00</td>
            <td class='s29'>100.000,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s14'></td>
            <td class='s14'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s20'></td>
            <td class='s28'>366</td>
            <td class='s28'>...</td>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 298px; left: -1px;'>Educação de Jovens e Adultos</div>
            </td>
            <td class='s17'></td>
            <td class='s8'></td>
            <td class='s30'>100.000,00</td>
            <td class='s29'>100.000,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s14'></td>
            <td class='s14'></td>
            <td class='s15'></td>
            <td class='s15'></td>
            <td class='s15'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s20'></td>
            <td class='s28'>367</td>
            <td class='s28'>...</td>
            <td class='s16 softmerge'>
                <div class='softmerge-inner' style='width: 198px; left: -1px;'>Educação Especial</div>
            </td>
            <td class='s8'></td>
            <td class='s8'></td>
            <td class='s29'>100.000,00</td>
            <td class='s29'>100.000,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s24'></td>
            <td class='s24'></td>
            <td class='s24'></td>
            <td class='s3'></td>
            <td class='s3'></td>
            <td class='s24'></td>
            <td class='s24'></td>
            <td class='s24'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s9'></td>
            <td class='s31'>TOTAL</td>
            <td class='s32'>600.000,00</td>
            <td class='s32'>600.000,00</td>
        </tr>
        <tr style='height:20px;'>
            <td class='s11 softmerge'>
                <div class='softmerge-inner' style='width: 598px; left: -1px;'>GASTOS COM PROFISSIONAIS DO MAGISTÉRIO DA
                    EDUCAÇÃO BÁSICA:
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
            <td class='s13'></td>
            <td class='s33'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s11 softmerge'>
                <div class='softmerge-inner' style='width: 398px; left: -1px;'>Receita Total do Fundo (Anexo III, Item
                    01) ....... =
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
            <td class='s34'>852.296,33</td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s33'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s11 softmerge'>
                <div class='softmerge-inner' style='width: 398px; left: -1px;'>Valor Legal Mínimo
                    ................................... 60 % =
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
            <td class='s34'>511.377,80</td>
            <td class='s3'></td>
            <td class='s2'></td>
            <td class='s33'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s11 softmerge'>
                <div class='softmerge-inner' style='width: 398px; left: -1px;'>Valor aplicado
                    ...................................................
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
            <td class='s34'>600.000,00</td>
            <td class='s32'>70,40%</td>
            <td class='s2'></td>
            <td class='s33'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s2'></td>
            <td class='s33'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s35 softmerge'>
                <div class='softmerge-inner' style='width: 798px; left: -1px;'>(O Valor Aplicado é composto pelas
                    despesas com os profissionais do magistério da educação básica, em efetivo exercício de
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
        </tr>
        <tr style='height:20px;'>
            <td class='s35 softmerge'>
                <div class='softmerge-inner' style='width: 798px; left: -1px;'>suas atividades na rede pública e
                    corresp. aos comprovantes de despesas organizados de acordo c/a alínea a, artigo 15 desta IN).
                </div>
            </td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s12'></td>
            <td class='s13'></td>
        </tr>
        </tbody>
    </table>
    </div>
</body>
</html>
HTML;

$mpdf = new mPDF();
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output();
exit;

?>



<?php

/**
 * Busca o saldo da despesa
 * @param $sEstrut
 * @param $iInstit
 * @param $sCampo [liquidado, empenhado, pago, anulado, ver a tabela anexoivgastopessoaldespesa]
 * @return array|stdClass[]
 */
function getSaldoDespesa($sEstrut, $iInstit,$sCampo = 'liquidado'){
    $sSqlDespesas = "select o58_elemento, o56_descr,sum({$sCampo}) as liquidado from anexoivgastopessoaldespesa inner join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu where o58_elemento like '{$sEstrut}%' and o58_instit = {$iInstit} group by 1,2";
    return db_utils::getColectionByRecord(db_query($sSqlDespesas));
}

/**
 * Busca o saldo da receita
 * @param $sEstrut
 * @param string $sCampo
 * @return array|stdClass[]
 */
function getSaldoReceita($sEstrut, $sCampo = 'liquidado'){
    $sSqlDespesas = "select o58_elemento, o56_descr,sum({$sCampo}) as liquidado from anexoivgastopessoalreceita inner join orcelemento on o58_codele = o56_codele and o58_anousu = o56_anousu where o58_elemento like '{$sEstrut}%' group by 1,2";
    return db_utils::getColectionByRecord(db_query($sSqlDespesas));
}

/**
 * Função que retorna a RCL no periodo indicado
 * @param DBDate $oDataFim
 * @return int|number
 * @throws BusinessException
 * @throws ParameterException
 */
function getRCL(DBDate $oDataFim){
    $oPeriodo = new Periodo;
    $oNovaDataFim = clone $oDataFim;
    $oDataFim->modificarIntervalo('-11 month');
    $aPeriodoCalculo = DBDate::getMesesNoIntervalo($oDataFim,$oNovaDataFim);

    $aCalculos = array();

    foreach($aPeriodoCalculo as $ano => $mes){
        $aCalculos[] = calcula_rcl2($ano, $ano. "-" . min(array_keys($aPeriodoCalculo[$ano])) . "-1", $ano."-".max(array_keys($aPeriodoCalculo[$ano]))."-".$oPeriodo->getPeriodoByMes(max(array_keys($aPeriodoCalculo[$ano])))->getDiaFinal(), $instits, true, 81);
    }
    $fSoma = 0;
    foreach($aCalculos as $aCalculo){
        $fSoma += array_sum($aCalculo);
    }
    return $fSoma;
}

?>