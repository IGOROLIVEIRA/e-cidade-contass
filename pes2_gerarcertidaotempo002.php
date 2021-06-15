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

if($oGet->diasfalta == ""){
    $diasfalta = 0;
}else{
    $diasfalta = $oGet->diasfalta;
}
if($oGet->datacert == ""){
    $oGet->datacert = db_getsession('DB_datausu');
}

function getTotaldeDiasTrabalhadosCGM($regist,$oGet){
    $sCampos  = "rh01_regist";

    $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');

    $sSqlRhPessoalmovCGM = $oDaoRhPessoalmov->sql_getDadosServidoresTempoServicoCGM( $sCampos,
        db_anofolha(),
        db_mesfolha(),
        $regist
    );
    $rsRhPessoalmovCGM = db_query($sSqlRhPessoalmovCGM);

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

        $oDadosPessoal = db_utils::fieldsMemory($rsRhPessoalmov, 0);
        //formato a data
        $dtadmiss = (implode("/",(array_reverse(explode("-",$oDadosPessoal->rh01_admiss)))));
        if($oDadosPessoal->rh05_recis == ""){
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

        return $periodo;
    }
}

function getDtAdmissao($regist){
    $sCampos  = "rh01_admiss";

    $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');

    $sSqlRhPessoalmov = $oDaoRhPessoalmov->sql_getDadosServidoresTempoServicoCGM( $sCampos,
        db_anofolha(),
        db_mesfolha(),
        $regist
    );
    $rsRhPessoalmovCGM = db_query($sSqlRhPessoalmov);
    $oDadosPessoal = db_utils::fieldsMemory($rsRhPessoalmovCGM, 0);
    $rh01_admiss = (implode("/",(array_reverse(explode("-",$oDadosPessoal->rh01_admiss)))));

    return $rh01_admiss;
}

function getDadosNumCGM($cgm){
    $sCampos  = "z01_nome,z01_cgccpf";

    $oDaoDadosCGM = db_utils::getDao('cgm');
    $sSqlDadosCGM = $oDaoDadosCGM->sql_query_file($cgm,$sCampos);
    $rsDadosCGM = db_query($sSqlDadosCGM);
    $oDadosCgm = db_utils::fieldsMemory($rsDadosCGM, 0);

    return $oDadosCgm;
}

$Totaldias = getTotaldeDiasTrabalhadosCGM($regist,$oGet);

switch($tiporelatorio) {
    case 'cgm':
        $dadosMatricula = getDadosNumCGM($regist);
        $sCampos  = "rh01_regist";

        $oDaoRhPessoalmov = db_utils::getDao('rhpessoalmov');

        $sSqlRhPessoalmovCGM = $oDaoRhPessoalmov->sql_getDadosServidoresTempoServicoCGM( $sCampos,
            db_anofolha(),
            db_mesfolha(),
            $regist
        );
        $rsRhPessoalmovCGM = db_query($sSqlRhPessoalmovCGM);
        //inicio do PDF
        $pdf = new PDF1();
        $pdf->Open();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->setfillcolor(235);
        $pdf->setfont('arial','b',10);
        $w = 0; //Largura da célula. Se 0, a célula se extende até a margem direita.
        $alt = 7; //Altura da célula. Valor padrão: 0.
        $pdf->cell($w,$alt,"Certidão de Contagem de Tempo de Serviço",0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->cell($w,$alt,"Certidão Nº: ".$ncertidao,0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->setfont('arial','',10);
        $pdf->MultiCell($w,$alt,"           Certificamos, para os devidos fins, que o(a) Sr(a) ".$dadosMatricula->z01_nome.", inscrito no CPF sob o nº ".$dadosMatricula->z01_cgccpf.", foi servidor(a) deste Órgão, conforme discriminação abaixo, contando no período um total de $Totaldias->days dias.",0,"J",0,0);
        $pdf->setfont('arial','b',10);
        $pdf->ln($alt+4);
        $alt = 5;

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
            $oDadosPessoal = db_utils::fieldsMemory($rsRhPessoalmov, 0);

            //formato a data
            $dtadmiss = (implode("/",(array_reverse(explode("-",$oDadosPessoal->rh01_admiss)))));
            if($oDadosPessoal->rh05_recis == null || $oDadosPessoal->rh05_recis == ""){
                $date = (implode("-",(array_reverse(explode("-",$oGet->datacert)))));
            }else{
                $date = (implode("-",(array_reverse(explode("-",$oDadosPessoal->rh05_recis)))));
            }
            $finalPeriodo = (implode("/",(explode("-",$date))));

            $pdf->cell($w+25,$alt,"Matrícula"             ,1,0,"C",1);
            $pdf->cell($w+50,$alt,"Período"               ,1,0,"C",1);
            $pdf->cell($w+60,$alt,"Previdência"           ,1,0,"C",1);
            $pdf->cell($w+50,$alt,"Cargo"                 ,1,1,"C",1);
            $pdf->setfont('arial','',10);
            $pdf->ln($alt);
            $pdf->cell($w+25,$alt,$oDadosPessoal->rh01_regist ,0,0,"C",0);
            $pdf->cell($w+50,$alt,$dtadmiss." a ".$finalPeriodo,0,0,"C",0);
            $pdf->cell($w+60,$alt,$oDadosPessoal->rh02_tbprev ,0,0,"C",0);
            $pdf->setfont('arial','b',7);
            $pdf->cell($w+50,$alt,$oDadosPessoal->rh37_descr  ,0,1,"C",0);
            $pdf->setfont('arial','b',10);
            $pdf->ln($alt);
            $pdf->cell($w+190,$alt,"Dias de Licenças:"     ,0,1,"L",0);
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
        END AS descrAfastamento","r45_dtafas","r45_anousu = ".db_anofolha()."
        AND r45_mesusu = ".db_mesfolha()."
        AND r45_regist = $oDadosPessoal->rh01_regist and r45_situac in ($oGet->vinculoselecionados)");

            $rsAfastamentos = $oDaoAtastamentoMatricula->sql_record($sqlAfastamento);
            //Inicio da tabela
            $pdf->setfont('arial','b',10);
            $pdf->cell($w+80,$alt,"Tipo Afastamento"    ,0,0,"C",1);
            $pdf->cell($w+40,$alt,"Data Saida"          ,0,0,"C",1);
            $pdf->cell($w+40,$alt,"Data Retorno"        ,0,0,"C",1);
            $pdf->cell($w+30,$alt,"Dias Afastado"       ,0,1,"C",1);
            $diasAfastado = 0;
            for ($iCont = 0; $iCont < pg_num_rows($rsAfastamentos); $iCont++) {
                $oDadosResponsavel = db_utils::fieldsMemory($rsAfastamentos, $iCont);

                $dtafas = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtafas)))));
                $dtreto = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtreto)))));

                $dtAfastamento = DateTime::createFromFormat('d/m/Y', $dtafas);
                $dtRetorno = DateTime::createFromFormat('d/m/Y', $dtreto);
                $oPeriodoAfastamento = date_diff($dtAfastamento , $dtRetorno);
                $diasAfastado += $oPeriodoAfastamento->days;

                $pdf->setfont('arial','',10);
                $pdf->cell($w+80,$alt+2,$oDadosResponsavel->descrafastamento,0,0,"C",0);
                $pdf->cell($w+40,$alt+2,$dtafas                             ,0,0,"C",0);
                $pdf->cell($w+40,$alt+2,$dtreto                             ,0,0,"C",0);
                $pdf->cell($w+30,$alt+2,$oPeriodoAfastamento->days          ,0,1,"C",0);
            }

            //subitraindo dias de falta do periodo
            $dataRecisaocomafasta= date('d/m/Y', strtotime('-'.$diasAfastado.'days', strtotime($date)));
            $dtcertidao = (implode("/",(array_reverse(explode("-",$oGet->datacert)))));
            //criacao do timesteamp
            $dataAdmissao = DateTime::createFromFormat('d/m/Y', $dtadmiss);
            $dataRecisao = DateTime::createFromFormat('d/m/Y', $dataRecisaocomafasta);

            //Periodo total
            $periodo = date_diff($dataAdmissao , $dataRecisao);
            //total de anos
            $anosTrabalhados += $periodo->y;
            //total de anos
            $mesesTrabalhados += $periodo->m;
            //total de dias
            $diasTrabalhados += $periodo->days;

            $pdf->ln($alt+3);
            $pdf->setfont('arial','b',10);
            if(pg_num_rows($rsAfastamentos) > 0) {
                $pdf->cell($w + 50, $alt, "Total de Dias Afastado: ", 0, 0, "L", 0);
                $pdf->setfont('arial', '', 10);
                if ($diasAfastado == null) {
                    $pdf->cell($w + 32, $alt, "Nenhum dia afastado.", 0, 0, "L", 0);
                } else {
                    $pdf->cell($w + 32, $alt, "$diasAfastado dias.", 0, 0, "L", 0);
                }
            }
                $pdf->ln($alt+4);
                $pdf->setfont('arial','b',10);
                $pdf->cell($w+33,$alt,"Tempo de Serviço: "           ,0,0,"L",0);
                $pdf->setfont('arial','',10);
                $pdf->cell($w+190,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias." ,0,1,"L",0);
                $pdf->setfont('arial','b',10);
                $pdf->ln($alt+10);

        }
        $diasTrabalhados = $diasTrabalhados - $oGet->diasfalta;
        $anos = explode('.',$diasTrabalhados / 365);
        $mesesRestantes = abs(($anos[0] * 365) - $diasTrabalhados);
        $meses = explode('.',$mesesRestantes / 30);
        $diasRestantes = abs(($meses[0] * 30) - $mesesRestantes);

        $pdf->cell($w+190,$alt,"________________________________________________________________________________",0,1,"C",0);
        $pdf->ln($alt+3);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+30,$alt+1,"Dias de Faltas:"                                          ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+30,$alt+1,$oGet->diasfalta                                           ,0,1,"L",0);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+41,$alt+1,"Tempo total de Serviço:"                                  ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+140,$alt+1,$anos[0]." anos ". $meses[0]." meses e ".$diasRestantes." dias" ,0,1,"L",0);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+10,$alt+1,"Data:"                                                    ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+165,$alt+1,$dtcertidao                                               ,0,1,"L",0);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+25,$alt+1,"Visado por:"                                              ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+165,$alt,$oDadosEmissor->z01_nome                                    ,0,1,"L",0);
        $pdf->ln($alt);
        $pdf->cell($w+190,$alt,"Assinatura Emissor:________________________________________________________________",0,0,"L",0);
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

        //inicio do PDF
        $pdf = new PDF1();
        $pdf->Open();
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->setfillcolor(235);
        $pdf->setfont('arial','b',10);
        $w = 0; //Largura da célula. Se 0, a célula se extende até a margem direita.
        $alt = 7; //Altura da célula. Valor padrão: 0.
        $pdf->cell($w,$alt,"Certidão de Contagem de Tempo de Serviço",0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->cell($w,$alt,"Certidão Nº: ".$ncertidao,0,1,"C",0);
        $pdf->ln($alt+4);
        $pdf->setfont('arial','',10);
        $pdf->MultiCell($w,$alt,"           Certificamos, para os devidos fins, que o(a) Sr(a) ".$oDadosPessoal->z01_nome.", inscrito no CPF sob o nº ".$oDadosPessoal->z01_cgccpf.", foi servidor(a) deste Órgão, conforme discriminação abaixo, contando no período um total de $periodo->days dias.",0,"J",0,0);
        $pdf->setfont('arial','b',10);
        $pdf->ln($alt+4);
        $alt = 5;

        $pdf->cell($w+25,$alt,"Matrícula"             ,1,0,"C",1);
        $pdf->cell($w+50,$alt,"Período"               ,1,0,"C",1);
        $pdf->cell($w+60,$alt,"Previdência"           ,1,0,"C",1);
        $pdf->cell($w+50,$alt,"Cargo"                 ,1,1,"C",1);
        $pdf->setfont('arial','',10);
        $pdf->ln($alt);
        $pdf->cell($w+25,$alt,$oDadosPessoal->rh01_regist ,0,0,"C",0);
        $pdf->cell($w+50,$alt,$dtadmiss." a ".implode("/",(explode("-",$date))),0,0,"C",0);
        $pdf->cell($w+60,$alt,$oDadosPessoal->rh02_tbprev ,0,0,"C",0);
        $pdf->setfont('arial','b',7);
        $pdf->cell($w+50,$alt,$oDadosPessoal->rh37_descr  ,0,1,"C",0);
        $pdf->setfont('arial','b',10);
        $pdf->ln($alt);
        $pdf->cell($w+190,$alt,"Dias de Licenças:"     ,0,1,"L",0);
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
        END AS descrAfastamento","r45_dtafas","r45_anousu = ".db_anofolha()."
        AND r45_mesusu = ".db_mesfolha()."
        AND r45_regist = $oDadosPessoal->rh01_regist and r45_situac in ($oGet->vinculoselecionados)");

        $rsAfastamentos = $oDaoAtastamentoMatricula->sql_record($sqlAfastamento);
        //Inicio da tabela
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+80,$alt,"Tipo Afastamento"    ,0,0,"C",1);
        $pdf->cell($w+40,$alt,"Data Saida"          ,0,0,"C",1);
        $pdf->cell($w+40,$alt,"Data Retorno"        ,0,0,"C",1);
        $pdf->cell($w+30,$alt,"Dias Afastado"       ,0,1,"C",1);

        for ($iCont = 0; $iCont < pg_num_rows($rsAfastamentos); $iCont++) {
            $oDadosResponsavel = db_utils::fieldsMemory($rsAfastamentos, $iCont);

            $dtafas = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtafas)))));
            $dtreto = (implode("/",(array_reverse(explode("-",$oDadosResponsavel->r45_dtreto)))));

            $dtAfastamento = DateTime::createFromFormat('d/m/Y', $dtafas);
            $dtRetorno = DateTime::createFromFormat('d/m/Y', $dtreto);
            $oPeriodoAfastamento = date_diff($dtAfastamento , $dtRetorno);
            $diasAfastado += $oPeriodoAfastamento->days;

            $pdf->setfont('arial','',10);
            $pdf->cell($w+80,$alt+2,$oDadosResponsavel->descrafastamento,0,0,"C",0);
            $pdf->cell($w+40,$alt+2,$dtafas                             ,0,0,"C",0);
            $pdf->cell($w+40,$alt+2,$dtreto                             ,0,0,"C",0);
            $pdf->cell($w+30,$alt+2,$oPeriodoAfastamento->days          ,0,1,"C",0);
        }
        $pdf->ln($alt+3);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+50,$alt,"Total de Dias Afastado: "                ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        if($diasAfastado == null){
            $pdf->cell($w+32,$alt,"Nenhum dia afastado."                ,0,0,"L",0);
        }else{
            $pdf->cell($w+32,$alt,"$diasAfastado dias."                 ,0,0,"L",0);
        }

        $diasAfastado = $diasAfastado + $oGet->diasfalta;
        //subitraindo dias de falta do periodo
        $dataRecisao= date('d/m/Y', strtotime('-'.$diasAfastado.'days', strtotime($date)));
        $dtcertidao = (implode("/",(array_reverse(explode("-",$oGet->datacert)))));
        //criacao do timesteamp
        $dataAdmissao = DateTime::createFromFormat('d/m/Y', $dtadmiss);
        $dataRecisao = DateTime::createFromFormat('d/m/Y', $dataRecisao);

        //Periodo total
        $periodo = date_diff($dataAdmissao , $dataRecisao);

        $pdf->ln($alt+3);
        $pdf->cell($w+190,$alt,"________________________________________________________________________________",0,1,"C",0);
        $pdf->ln($alt+3);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+32,$alt+1,"Dias de Faltas:"                                          ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+30,$alt+1,$oGet->diasfalta                                           ,0,1,"L",0);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+50,$alt+1,"Tempo total de Serviço:"                                  ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+190,$alt,$periodo->y." anos ".$periodo->m." meses e ".$periodo->d." dias." ,0,1,"L",0);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+10,$alt+1,"Data:"                                                    ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+165,$alt+1,$dtcertidao                                               ,0,1,"L",0);
        $pdf->setfont('arial','b',10);
        $pdf->cell($w+25,$alt+1,"Visado por:"                                              ,0,0,"L",0);
        $pdf->setfont('arial','',10);
        $pdf->cell($w+165,$alt,$oDadosEmissor->z01_nome                                    ,0,1,"L",0);
        $pdf->ln($alt);
        $pdf->cell($w+190,$alt,"Assinatura Emissor:________________________________________________________________",0,0,"L",0);
        break;

}
$pdf->Output();