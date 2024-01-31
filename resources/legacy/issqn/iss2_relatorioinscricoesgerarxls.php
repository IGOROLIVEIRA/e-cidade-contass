<?php
    require_once("libs/db_stdlib.php");
    require_once("libs/db_utils.php");
    require_once("libs/db_conecta.php");
    require_once("libs/db_sessoes.php");
    require_once("libs/db_usuariosonline.php");
    require_once("libs/db_libsys.php");
    require_once("std/db_stdClass.php");
    include("libs/PHPExcel/Classes/PHPExcel.php");

    $oDaoIssBase = new cl_issbase;
    $oGet        = db_utils::postMemory($_GET);
    $objPHPExcel = new PHPExcel;
    $iInstit     = db_getsession('DB_instit');

    /**
     * matriz de entrada
     */
    $what = array(
        'ä', 'ã', 'à', 'á', 'â', 'ê', 'ë', 'è', 'é', 'ï', 'ì', 'í', 'ö', 'õ', 'ò', 'ó', 'ô', 'ü', 'ù', 'ú', 'û',
        'Ä', 'Ã', 'À', 'Á', 'Â', 'Ê', 'Ë', 'È', 'É', 'Ï', 'Ì', 'Í', 'Ö', 'Õ', 'Ò', 'Ó', 'Ô', 'Ü', 'Ù', 'Ú', 'Û',
        'ñ', 'Ñ', 'ç', 'Ç', '(', ')', ';', ':', '|', '!', '"', '#', '$', '%', '&', '=', '?', '~', '^', '>', '<', 'ª', '°', "°", chr(13), chr(10), "'"
    );

    /**
     * matriz de saida
     */
    $by = array(
        'a', 'a', 'a', 'a', 'a', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u',
        'A', 'A', 'A', 'A', 'A', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U',
        'n', 'N', 'c', 'C', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', " ", " ", " ", " "
    );

    $sSqlInstit =  " select nomeinst FROM db_config WHERE codigo = {$iInstit}";
    $rsInstit   = db_query($sSqlInstit);
    $oInstit    = db_utils::fieldsMemory($rsInstit, $i);

    $sWhere = null;

    // Tratamento de dados para pessoa
    switch ($oGet->pessoa) {

        case "f":
            $sPessoa = "Física";
            $sWhere  = "length(z01_cgccpf) = 11 ";
        break;

        case "j":
            $sPessoa = "Jurídica";
            $sWhere  = "length(z01_cgccpf) = 14 ";
        break;

        case "t":
            $sPessoa = "Todas";
        break;
    }

    // adiciona o AND no SQL quando necessário
    $and = null;
    if ($sWhere !== null) {
        $and = "and";
    }

    // Tratamento de dados para Baixa
    switch ($oGet->baixa) {

        case "n":
            $sBaixa = "Não";
            $sWhere .= "{$and} (q02_dtbaix is null or q02_dtbaix >= now())";
        break;

        case "s":
            $sBaixa = "Sim";
            $sWhere .= " {$and} (q02_dtbaix is not null and q02_dtbaix < now())";
        break;

        case "t":
            $sBaixa = "Todas";
        break;
    }

    $and = null;
    if ($sWhere !== null) {
        $and = "and";
    }

    // Tratamento de dados para Atividade
    switch ($oGet->atividade) {

        case "p":
            $sAtividade = "Somente Principal";
            $sWhere .= " {$and} q07_seq = q88_seq";
        break;

        case "t":
            $sAtividade = "Todas";
        break;
    }

    $and = null;
    if ($sWhere !== null) {
        $and = "and";
    }

    if ($oGet->datainicioatividade != "--") {
        $sWhere .= " {$and} tabativ.q07_datain > '{$oGet->datainicioatividade}'";
    }

    $and = null;
    if ($sWhere !== null) {
        $and = "and";
    }


    if ($oGet->datafinalatividade != "--") {
        $sWhere .= " {$and} tabativ.q07_datafi < '{$oGet->datafinalatividade}'";
    }

    $and = null;
    if ($sWhere !== null) {
        $and = "and";
    }

    $descricaoregime = "Todos";
    if ($oGet->regime !== "0") {
        $sWhere .= " {$and} q138_caracteristica = {$oGet->regime}";
    }

    // Tratamento de dados para Ordem
    switch ($oGet->ordem) {

    case "i":
        $sOrdem   = "Inscrição";
        $sOrderBy = "issbase.q02_inscr asc";
        break;

        case "n":
        $sOrdem   = "Nome";
            $sOrderBy = "z01_nome asc";
        break;

    case "a":
        $sOrdem   = "Atividade";
            $sOrderBy = "q03_descr asc";
        break;

    }

    $sSql  = $oDaoIssBase->sql_queryExportacaoExcelInscricao();
    $sSql .= $oDaoIssBase->sql_queryFromRelatorioExportacaoInscricao();
    $sSql .= " where {$sWhere}                                                                                                                     ";
    $sSql .= " order by {$sOrderBy}                                                                                                                ";

    $rsInscricao = db_query($sSql);
    $iInscricao = pg_num_rows($rsInscricao);

    if ($iInscricao == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não há registro(s) de Inscrição(ões) Municipal(is) com os parâmetros informados.');
    }

    //Inicio
    $styleCabecalhoCenter = array(
        'font' => array(
            'size' => 10,
            'bold' => true,
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
    );

    $styleDetalheLeft = array(
        'font' => array(
            'size' => 10,
            'bold' => false,
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        ),
    );

    $styleDetalheRight = array(
        'font' => array(
            'size' => 10,
            'bold' => false,
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        ),
    );

    $styleDetalheCenter = array(
        'font' => array(
            'size' => 10,
            'bold' => false,
        ),
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        ),
    );

    //Iniciando planilha
    $objWorkSheet = $objPHPExcel->getActiveSheet();
    $objWorkSheet = $objPHPExcel->getActiveSheet()->setAutoFilter('A1:M1');

    $objWorkSheet->setCellValue('A1', 'Inscricao');
    $objWorkSheet->setCellValue('B1', 'CGM');
    $objWorkSheet->setCellValue('C1', 'Nome / Razao Social');
    $objWorkSheet->setCellValue('D1', 'CPF / CNPJ');
    $objWorkSheet->setCellValue('E1', 'Endereco');
    $objWorkSheet->setCellValue('F1', 'Regime Tributario');
    $objWorkSheet->setCellValue('G1', 'Classe');
    $objWorkSheet->setCellValue('H1', 'Data de Inicio');
    $objWorkSheet->setCellValue('I1', 'Data da Baixa');
    $objWorkSheet->setCellValue('J1', 'Atividade');
    $objWorkSheet->setCellValue('K1', 'Descricao da Atividade');
    $objWorkSheet->setCellValue('L1', 'CNAE');
    $objWorkSheet->setCellValue('M1', 'Descricao do CNAE');

    $objWorkSheet->getStyle('A1:M1')->applyFromArray($styleCabecalhoCenter);

    for ($i = 0; $i < $iInscricao; $i++) {
        $oInscricao  = db_utils::fieldsMemory($rsInscricao, $i);
        $numrow = $i + 2;
        $collA = 'A' . $numrow;
        $collB = 'B' . $numrow;
        $collC = 'C' . $numrow;
        $collD = 'D' . $numrow;
        $collE = 'E' . $numrow;
        $collF = 'F' . $numrow;
        $collG = 'G' . $numrow;
        $collH = 'H' . $numrow;
        $collI = 'I' . $numrow;
        $collJ = 'J' . $numrow;
        $collK = 'K' . $numrow;
        $collL = 'L' . $numrow;
        $collM = 'M' . $numrow;   

        $tpLogrodouro = null;
        if ($oInscricao->j88_sigla !== null) {
            $tpLogrodouro = $oInscricao->j88_sigla . " ";
        }
        
        $Logrodouro = null;
        if ($oInscricao->j14_nome !== null) {
            $Logrodouro = $oInscricao->j14_nome;
        } 

        $endNr = null;
        if ($oInscricao->q02_numero !== null) { 
            $endNr = ", " . $oInscricao->q02_numero;
        } 

        $endCompl = null;
        if ($oInscricao->q02_compl != null) {
            $endCompl = " " . $oInscricao->q02_compl;
        }

        $endBairro = null;
        if ($oInscricao->j13_descr != null) {
            $endBairro = ", " . $oInscricao->j13_descr;
        }

        $endCxPost = null;
        if ($oInscricao->q02_cxpost != null) {
            $endCxPost = ", Caixa Postal:" . $oInscricao->q02_cxpost;
        }

        $endCep = null;
        if ($oInscricao->q02_cep != null) {
            $endCep = ", CEP:" . $oInscricao->q02_cep;
        } 
        
        $endereco = $tpLogrodouro . $Logrodouro . $endNr . $endCompl . $endBairro . $endCxPost . $endCep; 

        $objWorkSheet->setCellValue($collA, $oInscricao->q02_inscr);    
        $objWorkSheet->setCellValue($collB, $oInscricao->z01_numcgm);
        $objWorkSheet->setCellValue($collC, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oInscricao->z01_nome)));
        $objWorkSheet->setCellValue($collD, $oInscricao->z01_cgccpf);    
        $objWorkSheet->setCellValue($collE, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $endereco)));
        $objWorkSheet->setCellValue($collF, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oInscricao->db140_descricao)));
        $objWorkSheet->setCellValue($collG, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oInscricao->q12_descr)));
        $objWorkSheet->setCellValue($collH, $oInscricao->q02_dtinic);
        $objWorkSheet->setCellValue($collI, $oInscricao->q02_dtbaix);
        $objWorkSheet->setCellValue($collJ, $oInscricao->q07_ativ);
        $objWorkSheet->setCellValue($collK, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oInscricao->q03_descr)));
        $objWorkSheet->setCellValue($collL, $oInscricao->q71_estrutural);
        $objWorkSheet->setCellValue($collM, iconv('UTF-8', 'ISO-8859-1//IGNORE', str_replace($what, $by, $oInscricao->q71_descr)));
        
        $objWorkSheet->getStyle($collA.':'.$collB)->applyFromArray($styleDetalheCenter);
        $objWorkSheet->getStyle($collC)->applyFromArray($styleDetalheLeft);
        $objWorkSheet->getStyle($collD)->applyFromArray($styleDetalheCenter);
        $objWorkSheet->getStyle($collE.':'.$collG)->applyFromArray($styleDetalheLeft);
        $objWorkSheet->getStyle($collH.':'.$collJ)->applyFromArray($styleDetalheCenter);
        $objWorkSheet->getStyle($collK)->applyFromArray($styleDetalheLeft);
        $objWorkSheet->getStyle($collL)->applyFromArray($styleDetalheCenter);
        $objWorkSheet->getStyle($collM)->applyFromArray($styleDetalheLeft);
    }

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(80);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(80);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(100);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(100);

    $nomefile = "Relatório Inscrição Municipal" . ' - ' . $oInstit->nomeinst . ".xlsx";

    header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    header("Content-Disposition: attachment; filename=$nomefile");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
