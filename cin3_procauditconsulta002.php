<?
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
require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
include_once "libs/db_sessoes.php";
include_once "libs/db_usuariosonline.php";
include("vendor/mpdf/mpdf/mpdf.php");
include("libs/db_sql.php");
include("classes/db_questaoaudit_classe.php");
include("classes/db_processoaudit_classe.php");
include("classes/db_processoauditdepart_classe.php");

$iInstit        = db_getsession('DB_instit');
$oInstit        = new Instituicao($iInstit);

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clprocessoaudit    = new cl_processoaudit;
$clquestaoaudit     = new cl_questaoaudit;

$clprocessoaudit->rotulo->label();

$sSqlProcesso   = $clquestaoaudit->sql_questao_matriz(null, "*", "ci02_numquestao", "ci03_codproc = {$ci03_codproc}");
$rsProcesso     = $clquestaoaudit->sql_record($sSqlProcesso);


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
        		Consulta Processo de Auditoria
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
            .ritz .waffle .s0 { background-color: #ffffff; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; vertical-align: middle; vertical-align: middle; height: 50px; }
            .ritz .waffle .s1 { background-color: #ffffff; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; vertical-align: middle; vertical-align: middle; text-align: left; height: 20px; }
            .ritz .waffle .s2 { background-color: #d8d8d8; border: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 10pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: center; }
            .ritz .waffle .s3 { background-color: #ffffff; border: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 10pt; padding: 0px 3px 0px 3px; text-align: center; }
            .column-headers-background { background-color: #d8d8d8; }
        </style>
    </head>

    <body>
        <? $oProcesso = db_utils::fieldsMemory($rsProcesso, 0); ?>             
        <div class="ritz">                    
            <table class="waffle" cellspacing="0" cellpadding="0">
                <tr>
                    <th class="s0">Dados do Processo de Auditoria</th>
                </tr>
                <tr>
                    <td class="s1"><?= @$Lci03_codproc ?> <?= $oProcesso->ci03_codproc ?> </td>
                </tr>
                <tr>
                    <td class="s1"><?= $Lci03_numproc ?> <?= $oProcesso->ci03_numproc ?> </td>
                </tr>
                <tr>
                    <td class="s1"><?= @$Lci03_dataini ?> <?= db_formatar($oProcesso->ci03_dataini, 'd') ?> </td>
                </tr>
                <tr>
                    <td class="s1"><?=@$Lci03_datafim?> <?= db_formatar($oProcesso->ci03_datafim, 'd') ?> </td>
                </tr>
                <tr>
                    <td class="s1"><?=@$Lci03_anoproc?> <?= $oProcesso->ci03_anoproc ?> </td>
                </tr>
                <tr>
                    <td class="s1">                            
                        <? $aGrupo = array(1 => "Auditoria de Regularidade", 2 => "Auditoria Operacional", 3 => "Demanda Extraordinária"); ?>
                        <?=@$Lci03_grupoaudit?> <?= $aGrupo[$oProcesso->ci03_grupoaudit]; ?>
                    </td>
                </tr>
                <tr>
                    <td class="s1"><?=@$Lci03_objaudit?> <?= $oProcesso->ci03_objaudit ?> </td>
                </tr>
                <tr>
                    <td class="s1"><b>Setor(es):</b> <?= buscaDepartamentos($oProcesso->ci03_codproc) ?> </td>
                </tr>
                <tr>
                    <td class="s1"><?=@$Lci03_protprocesso?> <?= $oProcesso->ci03_protprocesso != '' ? $oProcesso->p58_numero.'/'.$oProcesso->p58_ano : '' ?> </td>
                </tr>
                
            </table>
            <hr>
        </div>

        <? if (isset($sVerificacoes) && $sVerificacoes == 1) { ?>

            <div class="ritz grid-container" dir="ltr">
                <table class="waffle" cellspacing="0" cellpadding="0">
                    
                    <? for ($i = 0; $i < $clquestaoaudit->numrows; $i++) { ?>  

                        <? db_fieldsmemory($rsProcesso,$i); ?>

                        <? if (isset($ci05_codlan) && $ci05_codlan != '') { ?>
                            
                            <? if ($repeteProcLan != $ci03_codproc) { ?>
                                
                                <tr>
                                    <th class="s0" colspan="10">Lançamentos de Verificação</th>
                                </tr>
                                <tr>
                                    <th class="s2" style="width:10px">Nº QUESTÃO</th>
                                    <th class="s2" style="width:120px">QUESTÃO DE AUDITORIA</th>
                                    <th class="s2" style="width:120px">INFORMAÇÕES REQUERIDAS</th>
                                    <th class="s2" style="width:120px">FONTE DAS INFORMAÇÕES</th>
                                    <th class="s2" style="width:120px">PROCEDIMENTO DETALHADO</th>
                                    <th class="s2" style="width:120px">OBJETOS</th>
                                    <th class="s2" style="width:120px">POSSÍVEIS ACHADOS NEGATIVOS</th>
                                    <th class="s2" style="width:70px">INÍCIO DA ANÁLISE</th>
                                    <th class="s2" style="width:120px">ATENDE À QUESTÃO DE AUDITORIA</th>
                                    <th class="s2" style="width:120px">ACHADOS</th>
                                </tr>
                                    
                            <? } ?>

                            <tr>
                                <td class="s3" style="width:10px"><?= $ci02_numquestao ?></td> 
                                <td class="s3" style="width:120px"><?= $ci02_questao ?></td>
                                <td class="s3"><?= $ci02_inforeq ?></td>
                                <td class="s3"><?= $ci02_fonteinfo ?></td>
                                <td class="s3"><?= $ci02_procdetal ?></td>
                                <td class="s3"><?= $ci02_objeto ?></td>
                                <td class="s3"><?= $ci02_possivachadneg ?></td>
                                <td class="s3"><?= db_formatar($ci05_inianalise, "d") ?></td>
                                <td class="s3"><?= $ci05_atendquestaudit == "t" ? "SIM" : ($ci05_atendquestaudit == "f" ? "NÃO" : '') ?></td>
                                <td class="s3"><?= $ci05_achados != 'null' ? $ci05_achados : '' ?></td>
                            </tr>
                                    
                            <? $repeteProcLan = $ci03_codproc; ?>
                        <? } ?>
                    <? } ?>

                </table>
            </div>
            
        <? } ?>

        <? if (isset($sMatriz) && $sMatriz == 1) { ?>

            <div class="ritz grid-container" dir="ltr">
                <table class="waffle" cellspacing="0" cellpadding="0">
                    
                    <? for ($i = 0; $i < $clquestaoaudit->numrows; $i++) { ?>  

                        <? db_fieldsmemory($rsProcesso,$i); ?>

                        <? if (isset($ci06_seq) && $ci06_seq != '') { ?>
                            
                            <? if ($repeteProcMat != $ci03_codproc) { ?>
                                
                                <tr>
                                    <th class="s0" colspan="10">Matriz de Achados</th>
                                </tr>
                                <tr>
                                    <th class="s2" style="width:10px">Nº QUESTÃO</th>
                                    <th class="s2" style="width:115px">QUESTÃO DE AUDITORIA</th>
                                    <th class="s2" style="width:115px">ACHADOS</th>
                                    <th class="s2" style="width:115px">SITUAÇÃO ENCONTRADA</th>
                                    <th class="s2" style="width:115px">OBJETOS</th>
                                    <th class="s2" style="width:115px">CRITÉRIO</th>
                                    <th class="s2" style="width:115px">EVIDÊNCIA</th>
                                    <th class="s2" style="width:115px">CAUSA</th>
                                    <th class="s2" style="width:115px">EFEITO</th>
                                    <th class="s2" style="width:115px">ENCAMINHAMENTO</th>
                                </tr>
                                    
                            <? } ?>

                            <tr>
                                <td class="s3"><?= $ci02_numquestao ?></td>
                                <td class="s3"><?= $ci02_questao ?></td>
                                <td class="s3"><?= $ci05_achados ?></td>
                                <td class="s3"><?= $ci06_situencont ?></td>
                                <td class="s3"><?= $ci06_objetos ?></td>
                                <td class="s3"><?= $ci06_criterio ?></td>
                                <td class="s3"><?= $ci06_evidencia ?></td>
                                <td class="s3"><?= $ci06_causa ?></td>
                                <td class="s3"><?= $ci06_efeito ?></td>
                                <td class="s3"><?= $ci06_recomendacoes ?></td>
                            </tr>
                                    
                            <? $repeteProcMat = $ci03_codproc; ?>
                        <? } ?>
                    <? } ?>

                </table>
            </div>

        <? } ?>
    </body>
</html>

<?php

$html = ob_get_contents();
echo $html;

$mPDF->WriteHTML(utf8_encode($html));
ob_end_clean();
$mPDF->Output();
            
function buscaDepartamentos($iCodProc) {
	
	$sDeptos = '';

	$clprocessoauditdepart = new cl_processoauditdepart;
	$sSql = $clprocessoauditdepart->sql_query($iCodProc);
	$rsResult = $clprocessoauditdepart->sql_record($sSql);

	for ($i = 0; $i < pg_num_rows($rsResult); $i++) {

		$sDeptos .= db_utils::fieldsMemory($rsResult, $i)->descrdepto;

		if ($i < pg_num_rows($rsResult)-1) {
			$sDeptos .= ', ';
		}

	}

    return $sDeptos;
    
}