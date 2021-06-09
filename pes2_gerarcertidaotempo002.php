<?php
/**
 * Created by PhpStorm.
 * User: contass
 * Date: 03/06/21
 * Time: 08:44
 */

require_once("fpdf151/pdf1.php");
require_once("libs/db_utils.php");
require_once("libs/db_sql.php");
require_once("libs/db_libpessoal.php");
require_once("classes/db_cgm_classe.php");
require_once("classes/db_afasta_classe.php");

db_postmemory($HTTP_GET_VARS);

$oGet = db_utils::postMemory($_GET);

if($oGet->regist == ""){
    $regist = $oGet->numcgm;
    $tiporelatorio = "cgm";
}else{
    $regist = $oGet->regist;
    $tiporelatorio = "matricula";
}

if($oGet->numcert == ""){
    $ncertidao= "0000";
}else{
    $ncertidao = $oGet->numcert;
}

switch($tiporelatorio) {
    case 'cgm':
        $sCampos  = "rh01_regist";

        $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');

        $sSqlRhPessoalmovCGM = $oDaoRhPessoalmov->sql_getDadosServidoresTempoServicoCGM( $sCampos,
            db_anofolha(),
            db_mesfolha(),
            $regist
        );

        $rsRhPessoalmovCGM = db_query($sSqlRhPessoalmovCGM);
        if (pg_numrows($rsRhPessoalmovCGM) == 0) {

            $sErro = _M(MENSAGEM . 'nenhum_dado_servidor');
            db_redireciona('db_erros.php?fechar=true&db_erro='.$sErro);
            exit;
        }
        //inicio do PDF
        $pdf = new PDF1();
        $pdf->Open();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->setfillcolor(235);
        $pdf->setfont('arial','b',12);
        $w = 0; //Largura da célula. Se 0, a célula se extende até a margem direita.
        $alt = 4; //Altura da célula. Valor padrão: 0.
        $pdf->cell($w,$alt,"Certidão de Contagem de Tempo de Serviço",0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->cell($w,$alt,"Certidão Nº: ".$ncertidao,0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->setfont('arial','',12);
        $pdf->MultiCell($w,$alt,"           Certificamos, para os devidos fins, que o(a) Sr(a) ".$oDadosPessoal->z01_nome.", inscrito no CPF sob o nº ".$oDadosPessoal->z01_cgccpf.", foi servidor(a) deste Órgão, conforme discriminação abaixo, contando no período um total de $periodo->days dias.",0,"J",0,0);
        $pdf->setfont('arial','b',12);
        $pdf->ln($alt+4);
//db_criatabela($rsRhPessoalmovCGM);exit;
        for ($iContCGM = 0; $iContCGM < pg_num_rows($rsRhPessoalmovCGM); $iContCGM++) {
            $oDadosResponsavelCGM = db_utils::fieldsMemory($rsRhPessoalmovCGM, $iContCGM);

            $sCampos  = "cgm.z01_nome,cgm.z01_cgccpf,rhpessoal.rh01_admiss,rhpesrescisao.rh05_recis,
                        CASE
                           WHEN rh02_tbprev = 2 THEN 'FUNDO PREV.MUN'
                           WHEN rh02_tbprev = 1 THEN 'INSS'
                           WHEN rh02_tbprev = 3 THEN 'AUTONOMOS INSS'
                           WHEN rh02_tbprev = 0 THEN 'Nenhum'
                       END AS rh02_tbprev,
                       rh37_descr,
                       rh01_regist";

            $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');

            $sSqlRhPessoalmov = $oDaoRhPessoalmov->sql_getDadosServidoresTempoServico( $sCampos,
                db_anofolha(),
                db_mesfolha(),
                $oDadosResponsavelCGM->rh01_regist
            );

            $rsRhPessoalmov = db_query($sSqlRhPessoalmov);
            if (pg_numrows($rsRhPessoalmov) == 0) {

                $sErro = _M(MENSAGEM . 'nenhum_dado_servidor');
                db_redireciona('db_erros.php?fechar=true&db_erro='.$sErro);
                exit;
            }
//            db_criatabela($rsRhPessoalmov);
            $oDadosPessoal = db_utils::fieldsMemory($rsRhPessoalmov, 0);

            //formato a data
            $dtadmiss = (implode("/",(array_reverse(explode("-",$oDadosPessoal->rh01_admiss)))));
            if($oDadosPessoal->rh05_recis == null || $oDadosPessoal->rh05_recis == ""){
                $date = (implode("-",(array_reverse(explode("-",$oGet->datacert)))));
            }else{
                $date = (implode("-",(array_reverse(explode("-",$oDadosPessoal->rh05_recis)))));
            }
            //subitraindo dias de falta do periodo
            $dataRecisao= date('d/m/Y', strtotime('-'.$oGet->diasfalta.'days', strtotime($date)));
            $dtcertidao = (implode("/",(array_reverse(explode("-",$oGet->datacert)))));
            //criacao do timesteamp
            $dataAdmissao = DateTime::createFromFormat('d/m/Y', $dtadmiss);
            $dataRecisao = DateTime::createFromFormat('d/m/Y', $dataRecisao);

            //Periodo total
            $periodo = date_diff($dataAdmissao , $dataRecisao);

            $pdf->cell($w+20,$alt,"Matrícula"             ,0,0,"C",0);
            $pdf->cell($w+80,$alt,"Período"               ,0,0,"C",0);
            $pdf->cell($w+50,$alt,"Previdência"           ,0,0,"C",0);
            $pdf->cell($w+40,$alt,"Cargo"                 ,0,1,"C",0);
            $pdf->setfont('arial','',12);
            $pdf->ln($alt);
            $pdf->cell($w+20,$alt,$oDadosPessoal->rh01_regist ,0,0,"C",0);
            $pdf->cell($w+80,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias" ,0,0,"C",0);
            $pdf->cell($w+50,$alt,$oDadosPessoal->rh02_tbprev ,0,0,"C",0);
            $pdf->cell($w+40,$alt,$oDadosPessoal->rh37_descr ,0,1,"C",0);
            $pdf->setfont('arial','b',12);
            $pdf->ln($alt);
            $pdf->cell($w+190,$alt,"Dias de Licenças"     ,0,1,"C",0);
            $pdf->ln($alt+3);

            //busco dados do cgm emissor
            $oDaoCgmEmissor = new cl_cgm();
            $sqlEmissor = $oDaoCgmEmissor->sql_query($oGet->emissor,"z01_nome",null,null);
            $rsNomeEmissor = $oDaoCgmEmissor->sql_record($sqlEmissor);
            $oDadosEmissor = db_utils::fieldsMemory($rsNomeEmissor, 0);

            //busco afastamento
            $oDaoAtastamentoMatricula = new cl_afasta();
            $sqlAfastamento = $oDaoAtastamentoMatricula->sql_query(null,"r45_dtafas,r45_dtreto,
        CASE
           WHEN r45_situac = 2 THEN 'Afastado sem remuneração'
           WHEN r45_situac = 3 THEN 'Afastado acidente de trabalho +15 dias'
           WHEN r45_situac = 4 THEN 'Afastado serviço militar'
           WHEN r45_situac = 5 THEN 'Afastado licença gestante'
           WHEN r45_situac = 6 THEN 'Afastado doença +15 dias'
           WHEN r45_situac = 7 THEN 'Licença sem vencimento, cessão sem ônus'
           WHEN r45_situac = 8 THEN 'Afastado doença +30 dias'
           WHEN r45_situac = 9 THEN 'Licença por Motivo de Afastamento do Cônjuge'
        END AS descrAfastamento","","r45_regist = $oDadosPessoal->rh01_regist and r45_situac in ($oGet->vinculoselecionados)");

            $rsAfastamentos = $oDaoAtastamentoMatricula->sql_record($sqlAfastamento);
            //Inicio da tabela
            $pdf->setfont('arial','b',11);
            $pdf->cell($w+60,$alt,"Tipo Afastamento",1,0,"C",1);
            $pdf->cell($w+50,$alt,"Data Saida",1,0,"C",1);
            $pdf->cell($w+80,$alt,"Data Retorno",1,1,"C",1);

            for ($iCont = 0; $iCont < pg_num_rows($rsAfastamentos); $iCont++) {
                $oDadosResponsavel = db_utils::fieldsMemory($rsAfastamentos, $iCont);

                $dtafas = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtafas)))));
                $dtreto = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtreto)))));

                $dtAfastamento = DateTime::createFromFormat('d/m/Y', $dtafas);
                $dtRetorno = DateTime::createFromFormat('d/m/Y', $dtreto);
                $oPeriodoAfastamento = date_diff($dtAfastamento , $dtRetorno);
                $diasAfastado += $oPeriodoAfastamento->d;

                $pdf->setfont('arial','',11);
                $pdf->cell($w+60,$alt+2,$oDadosResponsavel->descrafastamento,1,0,"C",0);
                $pdf->cell($w+50,$alt+2,$dtafas,1,0,"C",0);
                $pdf->cell($w+80,$alt+2,$dtreto,1,1,"C",0);
            }

            $pdf->ln($alt+30);

            $pdf->setfont('arial','b',12);
            $pdf->cell($w+30,$alt,"Dias de Faltas:  "        ,0,0,"L",0);
            $pdf->setfont('arial','',12);
            $pdf->cell($w+30,$alt,$oGet->diasfalta              ,0,0,"L",0);
            $pdf->setfont('arial','b',12);
            $pdf->ln($alt+4);
            $pdf->cell($w+190,$alt,"Tempo de Serviço"       ,0,1,"L",0);
            $pdf->ln($alt);
            $pdf->setfont('arial','',12);
            $pdf->cell($w+190,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias." ,0,1,"L",0);
            $pdf->ln($alt+3);
            $pdf->setfont('arial','b',12);
            $pdf->cell($w+50,$alt,"Tempo total de Serviço:",0,0,"L",0);
            $pdf->setfont('arial','',12);
            $pdf->cell($w+140,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias." ,0,1,"L",0);
            $pdf->ln($alt+3);
            $pdf->setfont('arial','b',12);


        }
        $pdf->setfont('arial','',12);
        $pdf->ln($alt+6);
        $pdf->cell($w+25,$alt,"Data:"                 ,0,0,"L",0);
        $pdf->cell($w+165,$alt,$dtcertidao                ,0,0,"L",0);
        $pdf->ln($alt+3);
        $pdf->cell($w+25,$alt,"Visado por:"           ,0,0,"L",0);
        $pdf->cell($w+165,$alt,$oDadosEmissor->z01_nome   ,0,1,"L",0);
        $pdf->ln($alt);
        $pdf->cell($w+155,$alt,"Assinatura Emissor:__________________________________________"           ,0,0,"L",0);
        break;

    case 'matricula':
        $sCampos  = "cgm.z01_nome,cgm.z01_cgccpf,rhpessoal.rh01_admiss,rhpesrescisao.rh05_recis,
        CASE
           WHEN rh02_tbprev = 2 THEN 'FUNDO PREV.MUN'
           WHEN rh02_tbprev = 1 THEN 'INSS'
           WHEN rh02_tbprev = 3 THEN 'AUTONOMOS INSS'
           WHEN rh02_tbprev = 0 THEN 'Nenhum'
       END AS rh02_tbprev,
       rh37_descr,
       rh01_regist";

        $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');

        $sSqlRhPessoalmov = $oDaoRhPessoalmov->sql_getDadosServidoresTempoServico( $sCampos,
            db_anofolha(),
            db_mesfolha(),
            $regist
        );
        $rsRhPessoalmov = db_query($sSqlRhPessoalmov);
        if (pg_numrows($rsRhPessoalmov) == 0) {
            $sErro = _M(MENSAGEM . 'nenhum_dado_servidor');
            db_redireciona('db_erros.php?fechar=true&db_erro='.$sErro);
            exit;
        }
        $oDadosPessoal = db_utils::fieldsMemory($rsRhPessoalmov, 0);

        //formato a data
        $dtadmiss = (implode("/",(array_reverse(explode("-",$oDadosPessoal->rh01_admiss)))));
        if($oDadosPessoal->rh05_recis == null || $oDadosPessoal->rh05_recis == ""){
            $date = (implode("-",(array_reverse(explode("-",$oGet->datacert)))));
        }else{
            $date = (implode("-",(array_reverse(explode("-",$oDadosPessoal->rh05_recis)))));
        }
        //subitraindo dias de falta do periodo
        $dataRecisao= date('d/m/Y', strtotime('-'.$oGet->diasfalta.'days', strtotime($date)));
        $dtcertidao = (implode("/",(array_reverse(explode("-",$oGet->datacert)))));
        //criacao do timesteamp
        $dataAdmissao = DateTime::createFromFormat('d/m/Y', $dtadmiss);
        $dataRecisao = DateTime::createFromFormat('d/m/Y', $dataRecisao);

        //Periodo total
        $periodo = date_diff($dataAdmissao , $dataRecisao);

        //inicio do PDF
        $pdf = new PDF1();
        $pdf->Open();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->setfillcolor(235);
        $pdf->setfont('arial','b',12);
        $w = 0; //Largura da célula. Se 0, a célula se extende até a margem direita.
        $alt = 4; //Altura da célula. Valor padrão: 0.
        $pdf->cell($w,$alt,"Certidão de Contagem de Tempo de Serviço",0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->cell($w,$alt,"Certidão Nº: ".$ncertidao,0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->setfont('arial','',12);
        $pdf->MultiCell($w,$alt,"           Certificamos, para os devidos fins, que o(a) Sr(a) ".$oDadosPessoal->z01_nome.", inscrito no CPF sob o nº ".$oDadosPessoal->z01_cgccpf.", foi servidor(a) deste Órgão, conforme discriminação abaixo, contando no período um total de $periodo->days dias.",0,"J",0,0);
        $pdf->setfont('arial','b',12);
        $pdf->ln($alt+4);

        $pdf->cell($w+20,$alt,"Matrícula"             ,0,0,"C",0);
        $pdf->cell($w+80,$alt,"Período"               ,0,0,"C",0);
        $pdf->cell($w+50,$alt,"Previdência"           ,0,0,"C",0);
        $pdf->cell($w+40,$alt,"Cargo"                 ,0,1,"C",0);
        $pdf->setfont('arial','',12);
        $pdf->ln($alt);
        $pdf->cell($w+20,$alt,$oDadosPessoal->rh01_regist ,0,0,"C",0);
        $pdf->cell($w+80,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias" ,0,0,"C",0);
        $pdf->cell($w+50,$alt,$oDadosPessoal->rh02_tbprev ,0,0,"C",0);
        $pdf->cell($w+40,$alt,$oDadosPessoal->rh37_descr ,0,1,"C",0);
        $pdf->setfont('arial','b',12);
        $pdf->ln($alt);
        $pdf->cell($w+190,$alt,"Dias de Licenças"     ,0,1,"C",0);
        $pdf->ln($alt+3);

        //busco dados do cgm emissor
        $oDaoCgmEmissor = new cl_cgm();
        $sqlEmissor = $oDaoCgmEmissor->sql_query($oGet->emissor,"z01_nome",null,null);
        $rsNomeEmissor = $oDaoCgmEmissor->sql_record($sqlEmissor);
        $oDadosEmissor = db_utils::fieldsMemory($rsNomeEmissor, 0);

        //busco afastamento
        $oDaoAtastamentoMatricula = new cl_afasta();
        $sqlAfastamento = $oDaoAtastamentoMatricula->sql_query(null,"r45_dtafas,r45_dtreto,
        CASE
           WHEN r45_situac = 2 THEN 'Afastado sem remuneração'
           WHEN r45_situac = 3 THEN 'Afastado acidente de trabalho +15 dias'
           WHEN r45_situac = 4 THEN 'Afastado serviço militar'
           WHEN r45_situac = 5 THEN 'Afastado licença gestante'
           WHEN r45_situac = 6 THEN 'Afastado doença +15 dias'
           WHEN r45_situac = 7 THEN 'Licença sem vencimento, cessão sem ônus'
           WHEN r45_situac = 8 THEN 'Afastado doença +30 dias'
           WHEN r45_situac = 9 THEN 'Licença por Motivo de Afastamento do Cônjuge'
        END AS descrAfastamento","","r45_regist = $oGet->regist and r45_situac in ($oGet->vinculoselecionados)");

        $rsAfastamentos = $oDaoAtastamentoMatricula->sql_record($sqlAfastamento);
        //Inicio da tabela
        $pdf->setfont('arial','b',11);
        $pdf->cell($w+60,$alt,"Tipo Afastamento",1,0,"C",1);
        $pdf->cell($w+50,$alt,"Data Saida",1,0,"C",1);
        $pdf->cell($w+80,$alt,"Data Retorno",1,1,"C",1);

        for ($iCont = 0; $iCont < pg_num_rows($rsAfastamentos); $iCont++) {
            $oDadosResponsavel = db_utils::fieldsMemory($rsAfastamentos, $iCont);

            $dtafas = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtafas)))));
            $dtreto = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtreto)))));

            $dtAfastamento = DateTime::createFromFormat('d/m/Y', $dtafas);
            $dtRetorno = DateTime::createFromFormat('d/m/Y', $dtreto);
            $oPeriodoAfastamento = date_diff($dtAfastamento , $dtRetorno);
            $diasAfastado += $oPeriodoAfastamento->d;

            $pdf->setfont('arial','',11);
            $pdf->cell($w+60,$alt+2,$oDadosResponsavel->descrafastamento,1,0,"C",0);
            $pdf->cell($w+50,$alt+2,$dtafas,1,0,"C",0);
            $pdf->cell($w+80,$alt+2,$dtreto,1,1,"C",0);
        }

        $pdf->ln($alt+30);

        $pdf->setfont('arial','b',12);
        $pdf->cell($w+30,$alt,"Dias de Faltas:  "        ,0,0,"L",0);
        $pdf->setfont('arial','',12);
        $pdf->cell($w+30,$alt,$oGet->diasfalta              ,0,0,"L",0);
        $pdf->setfont('arial','b',12);
        $pdf->ln($alt+4);
        $pdf->cell($w+190,$alt,"Tempo de Serviço"       ,0,1,"L",0);
        $pdf->ln($alt);
        $pdf->setfont('arial','',12);
        $pdf->cell($w+190,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias." ,0,1,"L",0);
        $pdf->ln($alt+3);
        $pdf->setfont('arial','b',12);
        $pdf->cell($w+50,$alt,"Tempo total de Serviço:",0,0,"L",0);
        $pdf->setfont('arial','',12);
        $pdf->cell($w+140,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias." ,0,0,"L",0);
        $pdf->setfont('arial','',12);
        $pdf->ln($alt+6);
        $pdf->cell($w+25,$alt,"Data:"                 ,0,0,"L",0);
        $pdf->cell($w+165,$alt,$dtcertidao                ,0,0,"L",0);
        $pdf->ln($alt+3);
        $pdf->cell($w+25,$alt,"Visado por:"           ,0,0,"L",0);
        $pdf->cell($w+165,$alt,$oDadosEmissor->z01_nome   ,0,1,"L",0);
        $pdf->ln($alt);
        $pdf->cell($w+155,$alt,"Assinatura Emissor:__________________________________________"           ,0,0,"L",0);
        break;

}
$pdf->Output();