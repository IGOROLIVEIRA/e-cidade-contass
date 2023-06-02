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
include("classes/db_processoauditdepart_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$clquestaoaudit = new cl_questaoaudit;
$iInstit        = db_getsession('DB_instit');
$oInstit        = new Instituicao($iInstit);

$sWhere = "ci02_instit = {$iInstit} AND ci06_seq IS NOT NULL AND ci05_atendquestaudit = 'f' ";

if (isset($iCodProc) && $iCodProc != null) {
	$sWhere .= "AND ci03_codproc = {$iCodProc}";
}

$sSqlMatriz = $clquestaoaudit->sql_questao_matriz(null, "*", "ci03_codproc, ci02_numquestao", $sWhere);

$rsMatriz   = $clquestaoaudit->sql_record($sSqlMatriz);

if ($clquestaoaudit->numrows == 0) {
  	db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum lançamento encontrado.');
}

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
        		Relatório de Matriz de Achados
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
            .ritz .waffle .s0 { background-color: #d8d8d8; border: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 10pt; font-weight: bold; padding: 0px 3px 0px 3px; text-align: center; }
            .ritz .waffle .s1 { background-color: #ffffff; border: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 10pt; padding: 0px 3px 0px 3px; text-align: center; }
            .ritz .waffle .s2 { background-color: #ffffff; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; vertical-align: middle; vertical-align: middle; }
            .ritz .waffle .s9 { background-color: #ffffff; border-bottom: 1px SOLID #000000; border-right: 1px SOLID #000000; color: #000000; direction: ltr; font-family: 'Calibri', Arial; font-size: 11pt; padding: 0px 3px 0px 3px; text-align: left; vertical-align: bottom;
            .column-headers-background { background-color: #d8d8d8; }
        </style>
    </head>

    <body>
        <div class="ritz">
          	<table class="waffle">
				<? $oLancamento = db_utils::fieldsMemory($rsMatriz,0); ?>
            	<tr>
					<td colspan="7" class="s2"><b>Processo: </b><?= $oLancamento->ci03_numproc.'/'.$oLancamento->ci03_anoproc ?></td>
				</tr>
				<tr>
					<td colspan="7" class="s2"><b>Unidades(s) Auditada(s): </b><?= buscaDepartamentos($oLancamento->ci03_codproc) ?></td>
				</tr>
				<tr>
					<td colspan="7" class="s2"><b>Objetivos:</b> <?= $oLancamento->ci03_objaudit ?></td>
				</tr>
          	</table>
        </div>
        <div class="ritz grid-container" dir="ltr">
            <table class="waffle" cellspacing="0" cellpadding="0">
              	<thead>
					<tr>
						<th class="s0" style="width:10px">Nº QUESTÃO</th>
						<th class="s0" style="width:115px">QUESTÃO DE AUDITORIA</th>
						<th class="s0" style="width:115px">ACHADOS</th>
						<th class="s0" style="width:115px">SITUAÇÃO ENCONTRADA</th>
						<th class="s0" style="width:115px">OBJETOS</th>
						<th class="s0" style="width:115px">CRITÉRIO</th>
						<th class="s0" style="width:115px">EVIDÊNCIA</th>
						<th class="s0" style="width:115px">CAUSA</th>
						<th class="s0" style="width:115px">EFEITO</th>
						<th class="s0" style="width:115px">RECOMENDAÇÕES</th>
					</tr>
				</thead>

                <tbody>
              
                <? for ($i = 0; $i < $clquestaoaudit->numrows; $i++) {
                
                    db_fieldsmemory($rsMatriz,$i); ?>      

                    <tr>
                        <td class="s1"><?= $ci02_numquestao ?></td>
                        <td class="s1"><?= $ci02_questao ?></td>
                        <td class="s1"><?= $ci05_achados ?></td>
                        <td class="s1"><?= $ci06_situencont ?></td>
                        <td class="s1"><?= $ci06_objetos ?></td>
                        <td class="s1"><?= $ci06_criterio ?></td>
                        <td class="s1"><?= $ci06_evidencia ?></td>
                        <td class="s1"><?= $ci06_causa ?></td>
                        <td class="s1"><?= $ci06_efeito ?></td>
                        <td class="s1"><?= $ci06_recomendacoes ?></td>
                    </tr>
                  
                    
                <? } ?>
                  
                </tbody>

            </table>

        </div>
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

?>