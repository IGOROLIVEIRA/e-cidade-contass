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

for($x = 0;$x < pg_numrows($result_dados);$x++){
    db_fieldsmemory($result_dados,$x);

    $cor = 1;

    $pdf->setfont('arial','b',7);
    $pdf->cell(15,$alt,"Matrícula",1,0,"L",1);
    $pdf->cell(60,$alt,"Nome",1,0,"C",1);
    $pdf->cell(20,$alt,"cpf",1,0,"C",1);
    $pdf->cell(10,$alt,"Regime",1,0,"C",1);
    $pdf->cell(15,$alt,"Tipo pag",1,0,"C",1);
    $pdf->cell(15,$alt,"Situação",1,0,"C",1);
    $pdf->cell(15,$alt,"Dt concessão",1,0,"C",1);
    $pdf->cell(15,$alt,"Nome cargo",1,0,"C",1);
    $pdf->cell(15,$alt,"Sigla Cargo",1,1,"C",1);

    $cor = 0;

    $result_cgm = db_query($rhpessoal->sql_query('','rh01_regist, z01_nome','',"z01_cgccpf = '$si195_numcpf'"));
    db_fieldsmemory($result_cgm,0);

    $pdf->cell(15,$alt,$rh01_regist,1,0,"C",$cor);
    $pdf->cell(60,$alt,$z01_nome,1,0,"L",$cor);
    $pdf->cell(20,$alt,$si195_numcpf,1,0,"C",$cor);
    $pdf->cell(10,$alt,$si195_regime,1,0,"C",$cor);
    $pdf->cell(15,$alt,$si195_indtipopagamento,1,0,"C",$cor);
    $pdf->cell(15,$alt,$si195_indsituacaoservidorpensionista,1,0,"C",$cor);
    $pdf->cell(15,$alt,$si195_datconcessaoaposentadoriapensao,1,0,"C",$cor);
    $pdf->cell(15,$alt,$si195_dsccargo,1,0,"C",$cor);
    $pdf->cell(15,$alt,$si195_sglcargo,1,1,"C",$cor);

        $pdf->cell(15,$alt,"Requisito do Cargo",1,0,"C",1);
        $pdf->cell(15,$alt,"Servidor Cedido",1,0,"C",1);
        $pdf->cell(15,$alt,"Descrição da lotação",1,0,"C",1);
        $pdf->cell(15,$alt,"Valor da carga horaria",1,0,"C",1);
        $pdf->cell(15,$alt,"Data de exercício no cargo",1,0,"C",1);
        $pdf->cell(15,$alt,"Data de exclusão",1,0,"C",1);
        $pdf->cell(15,$alt,"Natureza do saldo bruto",1,0,"C",1);
        $pdf->cell(15,$alt,"Valor total dos rendimentos",1,0,"C",1);
        $pdf->cell(15,$alt,"Natureza do saldo líquido.",1,0,"C",1);
        $pdf->cell(15,$alt,"Valor total dos rendimentos",1,0,"C",1);
        $pdf->cell(15,$alt,"Valor das deduções",1,0,"C",1);
        $pdf->cell(15,$alt,"vlrAbateTeto",1,1,"C",1);

}

$pdf->Output();