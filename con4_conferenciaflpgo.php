<?php
/**
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
require_once 'fpdf151/pdf.php';
require_once 'libs/db_sql.php';
require_once 'libs/db_libpessoal.php';
require_once ('classes/db_rhpessoal_classe.php');

$rhpessoal = new cl_rhpessoal();
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$head2 = "CONFERENCIA (".$mes." / ".$ano.")";



$sSql = "
select distinct * from flpgo10". db_getsession('DB_anousu') ." where si195_mes = $mes";
$result_dados = db_query($sSql);
$numrows_dados = pg_numrows($result_dados);

if($numrows_dados == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados no período de '.$mes.' / '.$ano);
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$alt   = 4;
// Inicia da geracao do relatorio

for($x = 0;$x < pg_numrows($result_dados);$x++) {
    db_fieldsmemory($result_dados,$x);

    $cor = 0;

    $result_cgm = db_query($rhpessoal->sql_query('','rh01_regist, z01_nome','',"z01_cgccpf = '$si195_numcpf'"));
    db_fieldsmemory($result_cgm,0);

    $pdf->setfont('arial','b',7);

    $pdf->ln(6);

    $pdf->cell(40,$alt,"Matrícula: ".$rh01_regist,0,0,"L",$cor);
    $pdf->cell(40,$alt,"CPF: ".$si195_numcpf,0,0,"L",$cor);
    $pdf->cell(40,$alt,"Regime: ".$si195_regime,0,0,"L",$cor);
    $pdf->cell(60,$alt,"Nome: ".$z01_nome,0,1,"L",$cor);
    $pdf->cell(40,$alt,"Tipo pag: ".$si195_indtipopagamento,0,0,"L",$cor);
    $pdf->cell(40,$alt,"Situação: ".$si195_indsituacaoservidorpensionista,0,0,"L",$cor);
    $pdf->cell(40,$alt,"Dt concessão: ".$si195_datconcessaoaposentadoriapensao,0,0,"L",$cor);
    $pdf->cell(40,$alt,"Cargo: ".$si195_dsccargo,0,0,"L",$cor);
    $pdf->cell(40,$alt,"Sigla: ".$si195_sglcargo,0,1,"L",$cor);
    $pdf->cell(40,$alt,"Requisito do Cargo: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Servidor Cedido: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Descrição da lotação: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Valor da carga horaria: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Data de exercício no cargo: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Data de exclusão: ",0,1,"L",$cor);
    $pdf->cell(40,$alt,"Natureza do saldo bruto: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Valor total dos rendimentos: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Natureza do saldo líquido: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Valor total dos rendimentos: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"Valor das deduções: ",0,0,"L",$cor);
    $pdf->cell(40,$alt,"vlrAbateTeto: ",0,1,"L",$cor);

    $pdf->ln(6);



}

$pdf->Output();