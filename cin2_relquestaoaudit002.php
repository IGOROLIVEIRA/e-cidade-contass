<?
// ini_set('display_errors', 'On');
// error_reporting(E_ALL);
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
include("vendor/mpdf/mpdf/mpdf.php");
include("libs/db_sql.php");
include("classes/db_questaoaudit_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clquestaoaudit = new cl_questaoaudit;
$iInstit        = db_getsession('DB_instit');
$oInstit        = new Instituicao($iInstit);

if (isset($iCodTipo) && $iCodTipo != null) {
    $sSqlQuestoes = $clquestaoaudit->sql_query(null, "*", "ci02_numquestao", "ci02_codtipo = {$iCodTipo} AND ci02_instit = {$iInstit}");
} else {
    $sSqlQuestoes = $clquestaoaudit->sql_query(null, "*", "ci02_codtipo, ci02_numquestao", "ci02_instit = {$iInstit}");
}

$rsQuestoes = $clquestaoaudit->sql_record($sSqlQuestoes);

if ($clquestaoaudit->numrows == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não há questões para esse tipo.');
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

$mPDF = new mpdf('', 'A4-L', 0, '', 10, 10, 30, 10, 5, 5);

if(file_exists("imagens/files/{$oInstit->getImagemLogo()}")) {
  $sLogo = "<img src='imagens/files/{$oInstit->getImagemLogo()}' width='70px' >";
} else {
  $sLogo = "";
}

$sComplento = substr( trim($oInstit->getComplemento()), 0, 20);

if (!empty($sComplento)) {
  $sComplento = ", " . substr( trim($oInstit->getComplemento()), 0, 20);
}

$sEndCompleto = trim($oInstit->getLogradouro()) . ", " . trim($oInstit->getNumero()) . $sComplento;
$sMunicipio   = trim($oInstit->getMunicipio()) . " - " . trim($oInstit->getUF());
$sTelCnpj     = trim($oInstit->getTelefone()) . "   -    CNPJ : " . db_formatar($oInstit->getCNPJ(), "cnpj");
$sEmail       = trim($oInstit->getEmail());
$sSite        = $oInstit->getSite();

/*<table style="width:100%; border-bottom:1px solid #000; font-family:sans-serif; border-collapse: inherit; table-layout: fixed;">    
    <tbody>
      <tr>        
        <td style="width: 80px; height: 80px;">      
          {$sLogo}
        </td>        
        <td style="font-size: 8pt; font-style: italic; padding-left: 10px" >
          <span style="font-weight: bold;">{$oInstit->getDescricao()}</span><br>
          <span>{$sEndCompleto}</span><br>
          <span>{$sMunicipio}</span><br>
          <span>{$sTelCnpj}</span><br>
          <span>{$sEmail}</span><br>
          <span>{$sSite}</span><br>
        </td>        
        <td>&nbsp;</td>
        <td>&nbsp;</td>        
        <td style="text-align:center; font-size: 8pt; border: 1px solid #000; border-radius: 10px; border-collapse: separate; background-color: #ccc;">
          <div>Relatório das Questões Cadastradas</div>
        </td>
      </tr>
      </tbody>
  </table>*/

$header = <<<HEADER
<header>
  <div style="width: 100%; border-bottom: 1px solid #000; border-collapse: inherit; table-layout: fixed; font-family:sans-serif;">
    <div style="border: 0px solid #000; float: left; width: 80px;">
      <div style="width: 80px; height: 80px">
        {$sLogo}
      </div>
    </div>
    <div style="float: left; width: 394px; font-size: 8pt; font-style: italic; padding-left: 10px">
      <span style="font-weight: bold;">{$oInstit->getDescricao()}</span><br>
      <span>{$sEndCompleto}</span><br>
      <span>{$sMunicipio}</span><br>
      <span>{$sTelCnpj}</span><br>
      <span>{$sEmail}</span><br>
      <span>{$sSite}</span><br>
    </div>
    <div style="float: left; width: 160px;">&nbsp;</div>
    <div style="border: 1px solid #000; float: left; width: 400px; height: 90px; text-align: center; border-radius: 10px 10px 10px 0px; background-color: #eee;">
      <div style="padding-top: 35px; font-size: 8pt;">
        Relatório das Questões Cadastradas
      </div>
    </div>
  </div>
</header>
HEADER;

$footer = <<<FOOTER
<div style='border-top:1px solid #000;width:100%;text-align:right;font-family:sans-serif;font-size:10px;height:10px;'>
  {PAGENO}/{nb}
</div>
FOOTER;


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);

ob_start();

?>

<html>
    <head>
        <style type="text/css">
            .ritz .waffle a { color: inherit; }
            .ritz .waffle .s0 {background-color: #d8d8d8; border: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 10pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: center; }
            .ritz .waffle .s1 { background-color: #ffffff; border: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 10pt; padding: 0px 3px 0px 3px; text-align: center; vertical-align: center; }
            .ritz .waffle .s2 {background-color: #ffffff; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: center; vertical-align: center; }
            .ritz .waffle .s9 { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom;
            .column-headers-background { background-color: #d8d8d8; }
        </style>
    </head>

    <body>
        <div class="ritz">
          <table class="waffle">
            <tr style='height: 40px;'><td colspan="7" class="s2"><?= db_utils::fieldsMemory($rsQuestoes,0)->ci01_tipoaudit ?></td></tr>
          </table>
        </div>
        <div class="ritz grid-container" dir="ltr">
            <table class="waffle" cellspacing="0" cellpadding="0">
              <thead>
              <tr>
                  <th class="s0" style="width:10px">Nº QUESTÃO</th>
                  <th class="s0" style="width:180px">QUESTÃO DE AUDITORIA</th>
                  <th class="s0" style="width:180px">INFORMAÇÕES REQUERIDAS</th>
                  <th class="s0" style="width:180px">FONTE DAS INFORMAÇÕES</th>
                  <th class="s0" style="width:180px">PROCEDIMENTO DETALHADO</th>
                  <th class="s0" style="width:180px">OBJETOS</th>
                  <th class="s0" style="width:180px">POSSÍVEIS ACHADOS NEGATIVOS</th>
                </tr>
                </thead>

                <tbody>
              
                <? for ($i = 0; $i < $clquestaoaudit->numrows; $i++) {
                
                    db_fieldsmemory($rsQuestoes,$i); ?>

                    <? if($repete != $ci01_codtipo && $i > 0) {  ?>
                  
                      <tr><td>&nbsp;</td></tr>
                      <tr style='height: 40px;'><td colspan="7" class="s2"><?= $ci01_tipoaudit ?></td></tr>          
                  
                    <? } ?>       

                    <tr>
                        <td class="s1"><?= $ci02_numquestao ?></td>
                        <td class="s1"><?= $ci02_questao ?></td>
                        <td class="s1"><?= $ci02_inforeq ?></td>
                        <td class="s1"><?= $ci02_fonteinfo ?></td>
                        <td class="s1"><?= $ci02_procdetal ?></td>
                        <td class="s1"><?= $ci02_objeto ?></td>
                        <td class="s1"><?= $ci02_possivachadneg ?></td>
                    </tr>
                  
                    <?             
                    $repete = $ci01_codtipo;
              
                }         
                ?>
                  
                </tbody>

            </table>

        </div>
    </body>
</html>

<?php

$html = ob_get_contents();
echo $html;
// die();
$mPDF->WriteHTML(utf8_encode($html));
ob_end_clean();
$mPDF->Output();

?>