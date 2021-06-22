<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("fpdf151/pdf5.php");

db_postmemory($HTTP_POST_VARS);


$oGet = db_utils::postMemory($_GET);
//echo '<pre>';var_dump($oGet);exit;
if($oGet->tiporegistro == "3"){
    $matricula = $oGet->iRegistros;
    $tiporelatorio = 'matricula';
}else{
    $matricula = $oGet->matricula;
    $tiporelatorio = 'matricula';
}

if ($oGet->tiporegistro == "5"){
    $cargos = $oGet->tiporegistro;
    $tiporelatorio = 'cargos';
}
$dtInicio = (implode("/",(array_reverse(explode("-",$oGet->dtinicio)))));
$dtFim = (implode("/",(array_reverse(explode("-",$oGet->dtfim)))));
$dtNotificaca = (implode("/",(array_reverse(explode("-",$oGet->dtnotificacao)))));

switch($tiporelatorio) {
    case 'matricula':

        $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');
        $sCampos = "*";
        $sSqlDadosServidor = $oDaoRhPessoalmov->sql_queryDadosServidoresCgm(
            db_anofolha(),
            db_mesfolha(),
            db_getsession('DB_instit'),
            $matricula,
            $sCampos
        );

        $rsDadosServidor = db_query($sSqlDadosServidor);
        $pdf = new pdf5();
        $pdf->Open();
        $pdf->AliasNbPages();
        for ($iCont = 0; $iCont < pg_num_rows($rsDadosServidor); $iCont++) {
            $oDadosServidor = db_utils::fieldsMemory($rsDadosServidor, $iCont);

            $pdf->AddPage();
            $pdf->setfillcolor(235);
            $pdf->setfont('arial','b',10);
            $w = 0; //Largura da célula. Se 0, a célula se extende até a margem direita.
            $alt = 6; //Altura da célula. Valor padrão: 0.
            $pdf->cell($w,$alt,"NOTIFICAÇÃO DE FÉRIAS", 0,1,"C",0);
            $pdf->ln($alt+3);
            $pdf->setfont('arial','',10);
            $pdf->cell(16,$alt,"Matricula:",         0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->rh01_regist,0,1,"L",0);
            $pdf->cell(16,$alt,"Nome:",                 0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->z01_nome,   0,1,"L",0);
            $pdf->cell(16,$alt,"Cargo:",                0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->rh37_descr, 0,1,"L",0);
            $pdf->cell(16,$alt,"Lotação:",           0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->r70_descr,  0,1,"L",0);
            $pdf->ln($alt+3);

            $oDaoFerias = db_utils::getDao('cadferia');
            $sSqlFerias = $oDaoFerias->sql_query_file(null,"r30_perai,r30_peraf","r30_perai desc limit 1","r30_numcgm = $oDadosServidor->z01_numcgm and r30_mesusu=".db_mesfolha()." and r30_anousu = ".db_anofolha());
            $rsDadosFerias = db_query($sSqlFerias);

            if(pg_num_rows($rsDadosFerias) == 0 ){
                $dtAdmissao = (implode("-",(array_reverse(explode("-",$oDadosServidor->rh01_admiss)))));
                $dtInicioFeriasPeriodo = (implode("/",(array_reverse(explode("-",$oDadosServidor->rh01_admiss)))));
                $dtFimFeriasPeriodo = date('d/m/Y', strtotime('+364 days', strtotime($dtAdmissao)));
            }else{
                $oDadosFerias = db_utils::fieldsMemory($rsDadosFerias, 0);

                $dtInicioFerias = (implode("-",(array_reverse(explode("-",$oDadosFerias->r30_perai)))));
                $dtInicioFeriasPeriodo = date('d/m/Y', strtotime('+365 days', strtotime($dtInicioFerias)));
                $dtFimFerias = (implode("-",(array_reverse(explode("-",$oDadosFerias->r30_peraf)))));
                $dtFimFeriasPeriodo = date('d/m/Y', strtotime('+364 days', strtotime($dtFimFerias)));
            }
            $date = (implode("-",(array_reverse(explode("/",$oGet->dtfim)))));
            $dtRetorno = date('d/m/Y', strtotime('+1 days', strtotime($date)));

            $pdf->MultiCell($w,$alt,"Comunicamos, que a partir de $dtInicio até $dtFim, o servidor(a) $oDadosServidor->z01_nome estará de férias regulamentares, referente ao período aquisitivo de $dtInicioFeriasPeriodo até $dtFimFeriasPeriodo, devendo retornar aos trabalhos a partir de $dtRetorno.",0,"J",0,0);
            $pdf->ln($alt+3);

            $pdf->cell(10,$alt,"Data:",  0,0,"L",0);
            $pdf->cell($w,$alt,$dtNotificaca,  0,1,"L",0);
            $pdf->ln($alt+3);
            $pdf->cell($w,$alt,"_______________________________________",  0,1,"C",0);
            $pdf->cell($w,$alt,"$oDadosServidor->z01_nome",  0,1,"C",0);
        }

        break;

    case 'cargos':

        $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');
        $sCampos = "*";
        $sSqlDadosServidor = $oDaoRhPessoalmov->sql_queryDadosServidoresCargo(
            db_anofolha(),
            db_mesfolha(),
            db_getsession('DB_instit'),
            $cargos,
            $sCampos
        );
        $rsDadosServidor = db_query($sSqlDadosServidor);
        $pdf = new pdf5();
        $pdf->Open();
        $pdf->AliasNbPages();
        for ($iCont = 0; $iCont < pg_num_rows($rsDadosServidor); $iCont++) {
            $oDadosServidor = db_utils::fieldsMemory($rsDadosServidor, $iCont);

            $pdf->AddPage();
            $pdf->setfillcolor(235);
            $pdf->setfont('arial','b',10);
            $w = 0; //Largura da célula. Se 0, a célula se extende até a margem direita.
            $alt = 6; //Altura da célula. Valor padrão: 0.
            $pdf->cell($w,$alt,"NOTIFICAÇÃO DE FÉRIAS", 0,1,"C",0);
            $pdf->ln($alt+3);
            $pdf->setfont('arial','',10);
            $pdf->cell(16,$alt,"Matricula:",         0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->rh01_regist,0,1,"L",0);
            $pdf->cell(16,$alt,"Nome:",                 0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->z01_nome,   0,1,"L",0);
            $pdf->cell(16,$alt,"Cargo:",                0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->rh37_descr, 0,1,"L",0);
            $pdf->cell(16,$alt,"Lotação:",           0,0,"L",0);
            $pdf->cell($w,$alt,$oDadosServidor->r70_descr,  0,1,"L",0);
            $pdf->ln($alt+3);

            $oDaoFerias = db_utils::getDao('cadferia');
            $sSqlFerias = $oDaoFerias->sql_query_file(null,"r30_perai,r30_peraf","r30_perai desc limit 1","r30_numcgm = $oDadosServidor->z01_numcgm and r30_mesusu=".db_mesfolha()." and r30_anousu = ".db_anofolha());
            $rsDadosFerias = db_query($sSqlFerias);

            if(pg_num_rows($rsDadosFerias) == 0 ){
                $dtAdmissao = (implode("-",(array_reverse(explode("-",$oDadosServidor->rh01_admiss)))));
                $dtInicioFeriasPeriodo = (implode("/",(array_reverse(explode("-",$oDadosServidor->rh01_admiss)))));
                $dtFimFeriasPeriodo = date('d/m/Y', strtotime('+364 days', strtotime($dtAdmissao)));
            }else{
                $oDadosFerias = db_utils::fieldsMemory($rsDadosFerias, 0);

                $dtInicioFerias = (implode("-",(array_reverse(explode("-",$oDadosFerias->r30_perai)))));
                $dtInicioFeriasPeriodo = date('d/m/Y', strtotime('+365 days', strtotime($dtInicioFerias)));
                $dtFimFerias = (implode("-",(array_reverse(explode("-",$oDadosFerias->r30_peraf)))));
                $dtFimFeriasPeriodo = date('d/m/Y', strtotime('+364 days', strtotime($dtFimFerias)));
            }
            $date = (implode("-",(array_reverse(explode("/",$oGet->dtfim)))));
            $dtRetorno = date('d/m/Y', strtotime('+1 days', strtotime($date)));

            $pdf->MultiCell($w,$alt,"Comunicamos, que a partir de $dtInicio até $dtFim, o servidor(a) $oDadosServidor->z01_nome estará de férias regulamentares, referente ao período aquisitivo de $dtInicioFeriasPeriodo até $dtFimFeriasPeriodo, devendo retornar aos trabalhos a partir de $dtRetorno.",0,"J",0,0);
            $pdf->ln($alt+3);

            $pdf->cell(10,$alt,"Data:",  0,0,"L",0);
            $pdf->cell($w,$alt,$dtNotificaca,  0,1,"L",0);
            $pdf->ln($alt+3);
            $pdf->cell($w,$alt,"_______________________________________",  0,1,"C",0);
            $pdf->cell($w,$alt,"$oDadosServidor->z01_nome",  0,1,"C",0);
        }

        break;
}
$pdf->Output();