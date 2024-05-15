<?php
require_once 'model/relatorios/Relatorio.php';
include("classes/db_db_docparag_classe.php");

// include("fpdf151/pdf.php");
require("libs/db_utils.php");
$oGet = db_utils::postMemory($_GET);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_POST_VARS);

switch ($oGet->tipoprecoreferencia) {
    case '2':
        $tipoReferencia = " MAX(pc23_vlrun) ";
        break;

    case '3':
        $tipoReferencia = " MIN(pc23_vlrun) ";
        break;

    default:
        $tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";
        break;
}

$rsResultado = db_query("select pc80_criterioadjudicacao from pcproc where pc80_codproc = {$codigo_preco}");
$criterio    = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
$sCondCrit   = ($criterio == 3 || empty($criterio)) ? " AND pc23_valor <> 0 " : "";

$rsLotes = db_query("select distinct  pc68_sequencial,pc68_nome
                        from
                            pcproc
                        join pcprocitem on
                            pc80_codproc = pc81_codproc
                        left join processocompraloteitem on
                            pc69_pcprocitem = pcprocitem.pc81_codprocitem
                        left join processocompralote on
                            pc68_sequencial = pc69_processocompralote
                        where
                            pc80_codproc = {$codigo_preco}
                            and pc68_sequencial is not null
                            order by pc68_sequencial asc");

$sSqlCasas = "select si01_casasdecimais from precoreferencia where si01_processocompra = {$codigo_preco}";
$result_casaspreco = db_query($sSqlCasas) or die(pg_last_error());;
                        
$si01_casasdecimais = db_utils::fieldsMemory($result_casaspreco, 0)->si01_casasdecimais;

if (pg_num_rows($rsLotes) == 0) {

    
    $sSql = "select si01_datacotacao FROM pcproc
JOIN pcprocitem ON pc80_codproc = pc81_codproc
JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
JOIN solicitem ON pc81_solicitem = pc11_codigo
JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
JOIN pcmater ON pc16_codmater = pc01_codmater
JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0";

    $rsResultData = db_query($sSql) or die(pg_last_error());

    $sSql = "select
            *
        from
            itemprecoreferencia
        where
            si02_precoreferencia = (
            select
                si01_sequencial
            from
                precoreferencia
            where
                si01_processocompra = {$codigo_preco}) order by si02_sequencial;";
            $rsResult = db_query($sSql) or die(pg_last_error());

            $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResultado, 0)->pc80_criterioadjudicacao;
            $codigoItem = db_utils::fieldsMemory($rsResult, 0)->si02_coditem;
            //$itemnumero = db_utils::fieldsMemory($rsResult, 0)->si02_itemproccompra;

            $sqlV = "select pc11_numero,
                            pc11_reservado,
                            pc11_quant,
                            pc16_codmater
                    from
                        pcproc
                    join pcprocitem on
                        pc80_codproc = pc81_codproc
                    join solicitem on
                        pc81_solicitem = pc11_codigo
                    join solicitempcmater on
                        pc11_codigo = pc16_solicitem
                    join pcmater on
                        pc16_codmater = pc01_codmater
                    where
                        pc80_codproc = {$codigo_preco}
                        and pc11_reservado = true;";
            
            $rsResultV = db_query($sqlV) or die(pg_last_error());
            $arrayValores = array();

            for($j=0;$j<pg_num_rows($rsResultV);$j++){
                $valores = db_utils::fieldsMemory($rsResultV, $j);
                $arrayValores[$j][0]=$valores->pc16_codmater;
                $arrayValores[$j][1]=$valores->pc11_quant;
            }
            $quantLinhas = count($arrayValores);
            
                
            if($codigoItem==""){
                
                for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {
                    $oResult = db_utils::fieldsMemory($rsResult, $iCont); 
                            $sSql = "select
                            pc23_quant,
                            pc11_reservado,
                            pc01_codmater,
                            pc01_tabela,
                            pc01_taxa,
                            m61_codmatunid,
                            pc80_criterioadjudicacao
                        from
                            pcproc
                        join pcprocitem on
                            pc80_codproc = pc81_codproc
                        join solicitem on
                            pc81_solicitem = pc11_codigo
                        join solicitempcmater on
                            pc11_codigo = pc16_solicitem
                        join pcmater on
                            pc16_codmater = pc01_codmater
                        join solicitemunid on
                            pc11_codigo = pc17_codigo
                        join matunid on
                            pc17_unid = m61_codmatunid
                        join pcorcamitemproc on
                            pc81_codprocitem = pc31_pcprocitem
                        join pcorcamitem on
                            pc31_orcamitem = pc22_orcamitem
                        join pcorcamval on
                            pc22_orcamitem = pc23_orcamitem
                        where
                            pc23_orcamitem = $oResult->si02_itemproccompra
                            and (pc23_vlrun <> 0 or  pc23_percentualdesconto <> 0)
                        group by
                            pc23_quant,
                            pc31_pcprocitem,
                            pc11_reservado,
                            pc11_seq,
                            pc01_codmater,
                            pc01_tabela,
                            pc01_taxa,
                            m61_codmatunid,
                            pc80_criterioadjudicacao;
                            ";

                    $rsResultee = db_query($sSql);  
                    $resultado = db_utils::fieldsMemory($rsResultee, 0); 

                    if($resultado->pc11_reservado==""){
                        $valor = "f";
                    }else{
                        $valor = $resultado->pc11_reservado;
                    }

                    $sql = " update itemprecoreferencia set ";
                    $sql .= "si02_coditem = ".$resultado->pc01_codmater;
                    $sql .= ",si02_qtditem = ".$resultado->pc23_quant;
                    $sql .= ",si02_codunidadeitem = ".$resultado->m61_codmatunid;
                    $sql .= ",si02_reservado = '".$valor."'";
                    $sql .= ",si02_tabela = '".$resultado->pc01_tabela."'";
                    $sql .= ",si02_taxa = '".$resultado->pc01_taxa."'";
                    $sql .= ",si02_criterioadjudicacao = ".$resultado->pc80_criterioadjudicacao;
                    $sql .= " where si02_sequencial = ".$oResult->si02_sequencial;

                    $rsResultado = db_query($sql);

                }
                    $sSql = "select
                        *
                    from
                        itemprecoreferencia
                    where
                        si02_precoreferencia = (
                        select
                            si01_sequencial
                        from
                            precoreferencia
                        where
                            si01_processocompra = {$codigo_preco}) order by si02_sequencial;";
                    $rsResult = db_query($sSql) or die(pg_last_error());

            }
    $oLinha = null;

    $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSVEL PELA DECLARAO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $cl_docparag = new cl_db_docparag;

    $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rs = $cl_docparag->sql_record($sAssinatura);
    $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


    $sWhere  = " db02_descr like 'RESPONSVEL PELA COTAO' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSVEL PELA DECLARAO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
    $sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;

    //echo $sSql; db_criatabela($rsResult);exit;
    $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->si02_criterioadjudicacao;

    $data = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResultData, 0)->si01_datacotacao)));

    $mPDF = new Relatorio('', 'A4-L', 0, "", 7, 7, 50);

    $mPDF
        ->addInfo($head3, 2)
        ->addInfo($head5, 4)
        ->addInfo($head8, 7);

    ob_start();

?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">

    <head>
        <title>Relatrio</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <style>
        div {
            font-size: 14px;
            text-align: center;
            border: 1px solid black;
        }

        table {
            font-size: 12px;
            border: 1px solid black;
        }
    </style>

    <body>
        <center>
            <div>
                <strong>Preo de Referncia</strong>
            </div>
            <div>
                <p>Processo de Compras: <?= $codigo_preco ?></p>
            </div>
            <div>
                <p>Data: <?= $data ?></p>
            </div>
            <?php
            if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
                echo <<<HTML
        <table>
            <tr>
                <td><strong>SEQ</strong></td>
                <td><strong>ITEM</strong></td>
                <td><strong>DESCRIO DO ITEM</strong></td>
                <td><strong>TAXA/TABELA</strong></td>
                <td><strong>VALOR UN</strong></td>
                <td><strong>QUANT</strong></td>
                <td><strong>UN</strong></td>
                <td><strong>TOTAL/VLR ESTIMADO</strong></td>
            </tr>

HTML;
            } else {
                echo <<<HTML
        <table>
            <tr>
                <td><strong>SEQ</strong></td>
                <td><strong>ITEM</strong></td>
                <td><strong>DESCRIO DO ITEM</strong></td>
                <td><strong>VALOR UN</strong></td>
                <td><strong>QUANT</strong></td>
                <td><strong>UN</strong></td>
                <td><strong>TOTAL</strong></td>
            </tr>
HTML;
            }

            $nTotalItens = 0;
            $sqencia = 0;
            for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                $oResult = db_utils::fieldsMemory($rsResult, $iCont);
                $sSql1 = "select
                            m61_abrev
                        from
                            matunid
                        where m61_codmatunid = $oResult->si02_codunidadeitem";
                $rsResult1 = db_query($sSql1) or die(pg_last_error());
                $oResult1 = db_utils::fieldsMemory($rsResult1,0);

                $sSql2 = "select
                case when pc01_descrmater=pc01_complmater or pc01_complmater is null then pc01_descrmater
else pc01_descrmater||'. '||pc01_complmater end as pc01_descrmater
            from
                pcmater
            where
                pc01_codmater = $oResult->si02_coditem";
                
                $rsResult2 = db_query($sSql2) or die(pg_last_error());
                $oResult2 = db_utils::fieldsMemory($rsResult2,0);
                $lTotal = $oResult->si02_vltotalprecoreferencia;

                $nTotalItens += $lTotal;
                $oDadosDaLinha = new stdClass();
                $oDadosDaLinha->pc80_codproc = $oResult->pc80_codproc;
                $op = 1;
                
                for($i=0;$i<$quantLinhas;$i++){
                    
                    if($arrayValores[$i][0]==$oResult->si02_coditem){
                      $valorqtd = $arrayValores[$i][1];
                      $op=2;  
                    }
                }
               if($op==1){
                   $fazerloop = 1;
               }else{
                   $fazerloop = 2;
               }
               $controle = 0;
               while($controle!=$fazerloop){ 
                $oDadosDaLinha->seq = $sqencia + 1;
                $oDadosDaLinha->item = $oResult->si02_coditem;
                if ($controle == 1) {
                    $oDadosDaLinha->descricao = '<span style="font-weight: bold;">[ME/EPP]</span> - '.$oResult2->pc01_descrmater ;
                } else {
                    $oDadosDaLinha->descricao = $oResult2->pc01_descrmater;
                }
                if ($oResult->si02_tabela == "t" || $oResult->si02_taxa == "t") {
                    $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $si01_casasdecimais, ",", ".");
                    if($controle == 0 && $fazerloop==2){
                        $oDadosDaLinha->quantidade = $oResult->si02_qtditem - $valorqtd;
                    }else if($controle == 1 && $fazerloop==2){
                        $oDadosDaLinha->quantidade = $valorqtd;
                    }else{
                        $oDadosDaLinha->quantidade = $oResult->si02_qtditem;
                    }
                    $oDadosDaLinha->mediapercentual = number_format($oResult->si02_mediapercentual, 2) . "%";
                    $oDadosDaLinha->unidadeDeMedida = $oResult1->m61_abrev;
                    if($controle==1){
                        $lTotal = $oResult->si02_vltotalprecoreferencia;
                    }
                    $lTotal = $oResult->si02_vlprecoreferencia * $oDadosDaLinha->quantidade;
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                } else {
                    $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $si01_casasdecimais, ",", ".");
                    if($controle == 0 && $fazerloop==2){
                        $oDadosDaLinha->quantidade = $oResult->si02_qtditem - $valorqtd;
                    }else if($controle == 1 && $fazerloop==2){
                        $oDadosDaLinha->quantidade = $valorqtd;
                    }else{
                        $oDadosDaLinha->quantidade = $oResult->si02_qtditem;
                    }
                    
                    
                        $oDadosDaLinha->mediapercentual = "-";
                    
                    $oDadosDaLinha->unidadeDeMedida = $oResult1->m61_abrev;
                    
                    $lTotal = $oResult->si02_vlprecoreferencia * $oDadosDaLinha->quantidade;
                    $oDadosDaLinha->total = number_format($lTotal, 2, ",", "."); 
                }
            
                $controle++;
                $sqencia++;

                if($pc80_criterioadjudicacao == 1 && $oResult->si02_tabela == "t"){
                    $oDadosDaLinha->valorUnitario = 0;
                }
                if($pc80_criterioadjudicacao == 1 && $oResult->si02_tabela == "f"){
                    $oDadosDaLinha->mediapercentual = "-";
                }
                if($pc80_criterioadjudicacao == 2 && $oResult->si02_taxa == "t"){
                    $oDadosDaLinha->valorUnitario = 0;
                }
                if($pc80_criterioadjudicacao == 2 && $oResult->si02_taxa == "f"){
                    $oDadosDaLinha->mediapercentual = "-";
                }

                $oDadosDaLinha->valorUnitario = $oDadosDaLinha->valorUnitario > 0 ? "R$ $oDadosDaLinha->valorUnitario" : "-";

                if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                    echo <<<HTML
        <tr>
          <td>{$oDadosDaLinha->seq}</td>
          <td>{$oDadosDaLinha->item}</td>
          <td>{$oDadosDaLinha->descricao}</td>
          <td>{$oDadosDaLinha->mediapercentual}</td>
          <td>{$oDadosDaLinha->valorUnitario}</td>
          <td>{$oDadosDaLinha->quantidade}</td>
          <td>{$oDadosDaLinha->unidadeDeMedida}</td>
          <td>{$oDadosDaLinha->total}</td>
        </tr>
        
HTML;
                } else {
                    echo <<<HTML
        <tr>
            <td> {$oDadosDaLinha->seq}</td>
            <td> {$oDadosDaLinha->item}            </td>
            <td> {$oDadosDaLinha->descricao}       </td>
            <td> {$oDadosDaLinha->valorUnitario}   </td>
            <td> {$oDadosDaLinha->quantidade}      </td>
            <td> {$oDadosDaLinha->unidadeDeMedida} </td>
            <td> {$oDadosDaLinha->total}           </td>
        </tr>

HTML;
                }
            }
        }
            ?>
            </table>
        </center>
    </body>

    </html>
 
<?php
} else {

    $sSql = "select si01_datacotacao FROM pcproc
    JOIN pcprocitem ON pc80_codproc = pc81_codproc
    JOIN pcorcamitemproc ON pc81_codprocitem = pc31_pcprocitem
    JOIN pcorcamitem ON pc31_orcamitem = pc22_orcamitem
    JOIN pcorcamval ON pc22_orcamitem = pc23_orcamitem
    JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
    JOIN solicitem ON pc81_solicitem = pc11_codigo
    JOIN solicitempcmater ON pc11_codigo = pc16_solicitem
    JOIN pcmater ON pc16_codmater = pc01_codmater
    JOIN itemprecoreferencia ON pc23_orcamitem = si02_itemproccompra
    JOIN precoreferencia ON itemprecoreferencia.si02_precoreferencia = precoreferencia.si01_sequencial
    WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0";

    $rsResultData = db_query($sSql) or die(pg_last_error());

    $oLinha = null;

    $sWhere  = " db02_descr like 'ASS. RESP. DEC. DE RECURSOS FINANCEIROS' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSVEL PELA DECLARAO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $cl_docparag = new cl_db_docparag;

    $sAssinatura = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rs = $cl_docparag->sql_record($sAssinatura);
    $oLinha = db_utils::fieldsMemory($rs, 0)->db02_texto;


    $sWhere  = " db02_descr like 'RESPONSVEL PELA COTAO' ";
    //$sWhere .= " AND db03_descr like 'ASSINATURA DO RESPONSVEL PELA DECLARAO DE RECURSOS FINANCEIROS' ";
    $sWhere .= " AND db03_instit = db02_instit ";
    $sWhere .= " AND db02_instit = " . db_getsession('DB_instit');

    $sSqlCotacao = $cl_docparag->sql_query_doc('', '', 'db02_texto', '', $sWhere);
    $rsCotacao = $cl_docparag->sql_record($sSqlCotacao);
    $sAssinaturaCotacao = db_utils::fieldsMemory($rsCotacao, 0)->db02_texto;


    $data = "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResultData, 0)->si01_datacotacao)));

    $mPDF = new Relatorio('', 'A4-L', 0, "", 7, 7, 50);

    $mPDF
        ->addInfo($head3, 2)
        ->addInfo($head5, 4)
        ->addInfo($head8, 7);

    ob_start();

?>

    <!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/html">

    <head>
        <title>Relatrio</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    </head>
    <style>
        div {
            font-size: 14px;
            text-align: center;
            border: 1px solid black;
        }

        table {
            font-size: 12px;
            border: 1px solid black;
        }
    </style>

    <body>
        <center>
            <div>
                <strong>Preo de Referncia</strong>
            </div>
            <div>
                <p>Processo de Compras: <?= $codigo_preco ?></p>
            </div>
            <div>
                <p>Data: <?= $data ?></p>
            </div>
            <?php


            for ($i = 0; $i < pg_num_rows($rsLotes); $i++) {
                $oLotes = db_utils::fieldsMemory($rsLotes, $i);


                

                $sSql = "SELECT DISTINCT pc01_servico,
                pc11_codigo,
                pc11_seq,
                pc11_quant,
                pc11_prazo,
                pc11_pgto,
                pc11_resum,
                pc11_just,
                m61_abrev,
                m61_descr,
                pc17_quant,
                pc01_codmater,
                CASE
                    WHEN pc01_complmater IS NOT NULL
                        AND pc01_complmater != pc01_descrmater THEN pc01_descrmater ||'. '|| pc01_complmater
                    ELSE pc01_descrmater
                END AS pc01_descrmater,
                pc01_complmater,
                pc10_numero,
                pc90_numeroprocesso AS processo_administrativo,
                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                m61_usaquant,
                pc69_seq,
                pc11_reservado,
                si02_vlprecoreferencia,
                si02_vltotalprecoreferencia,
                si02_tabela,
                si02_taxa,
                si02_mediapercentual,
                si01_justificativa
                FROM pcprocitem
                JOIN solicitem ON pc11_codigo=pc81_solicitem
                JOIN solicita ON pc10_numero = pc11_numero
                JOIN solicitempcmater ON pc16_solicitem=pc11_codigo
                JOIN solicitemunid ON pc17_codigo = pc11_codigo
                JOIN matunid ON pc17_unid = m61_codmatunid
                JOIN pcmater ON pc01_codmater = pc16_codmater
                JOIN pcorcamitemproc ON pc31_pcprocitem=pc81_codprocitem
                JOIN pcorcamitem ON pc22_orcamitem=pc31_orcamitem
                JOIN itemprecoreferencia ON si02_itemproccompra = pc22_orcamitem
                JOIN precoreferencia ON si02_precoreferencia = si01_sequencial
                JOIN pcorcamval ON pc23_orcamitem=pc22_orcamitem
                JOIN pcorcamforne ON pc21_orcamforne=pc23_orcamforne
                JOIN pcorcamjulg ON pc24_orcamforne=pc21_orcamforne
                LEFT JOIN solicitaprotprocesso ON pc90_solicita = pc10_numero
                LEFT JOIN processocompraloteitem ON pc69_pcprocitem = pcprocitem.pc81_codprocitem
                WHERE pc81_codproc={$codigo_preco} and pc69_processocompralote = $oLotes->pc68_sequencial
                    AND pc24_pontuacao=1 order by pc11_seq";
                //die($sSql);

                $rsResult = db_query($sSql) or die(pg_last_error());

                $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->pc80_criterioadjudicacao;
                $oLotes->pc68_nome = strtoupper($oLotes->pc68_nome);
                if(pg_num_rows($rsResult) > 0){
                    if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
                        echo <<<HTML
            <table>

                <tr>
                    <th colspan="7"><strong>{$oLotes->pc68_nome}</strong></th>
                </tr>
                <tr>
                    <td align= "left"><strong>ITEM LOTE</strong></td>
                    <td align= "left"><strong>CODIGO</strong></td>
                    <td align= "left"><strong>DESCRIO DO ITEM</strong></td>
                    <td align= "left"><strong>TAXA/TABELA</strong></td>
                    <td align= "left"><strong>VALOR UN</strong></td>
                    <td align= "left"><strong>QUANT</strong></td>
                    <td align= "left"><strong>UN</strong></td>
                    <td align= "left"><strong>TOTAL/VLR ESTIMADO</strong></td>
                </tr>
    HTML;
                    } else {
                        echo <<<HTML
            <table>
                <tr>
                <th colspan="7"><strong>{$oLotes->pc68_nome}</strong></th>
                </tr>
                <tr>
                    <td align= "left"><strong>ITEM LOTE</strong></td>
                    <td align= "left"><strong>CODIGO</strong></td>
                    <td align= "left"><strong>DESCRIO DO ITEM</strong></td>
                    <td align= "left"><strong>VALOR UN</strong></td>
                    <td align= "left"><strong>QUANT</strong></td>
                    <td align= "left"><strong>UN</strong></td>
                    <td align= "left"><strong>TOTAL</strong></td>
                </tr>
    HTML;
                    }
                }
                $nTotalItens = 0;

                for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

                    $oResult = db_utils::fieldsMemory($rsResult, $iCont);
                    $lTotal = $oResult->si02_vltotalprecoreferencia;

                    $nTotalItens += $lTotal;
                    $oDadosDaLinha = new stdClass();
                    $oDadosDaLinha->seq = $iCont + 1;
                    $oDadosDaLinha->item = $oResult->pc01_codmater; //$oResult->pc11_seq;
                    $oDadosDaLinha->pc80_codproc = $oResult->pc80_codproc;
                    if ($oResult->pc11_reservado == 't') {
                        $oDadosDaLinha->descricao = '[ME/EPP] - ' . str_replace(';', "", $oResult->pc01_descrmater);
                    } else {
                        $oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
                    }
                    //$oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
                    if ($oResult->si02_tabela == "t" || $oResult->si02_taxa == "t") {
                        $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $si01_casasdecimais, ",", ".");
                        $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                        if ($oResult->mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                        $lTotal = $oResult->si02_vlprecoreferencia * $oDadosDaLinha->quantidade;
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    } else {
                        $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $si01_casasdecimais, ",", ".");
                        $oDadosDaLinha->quantidade = $oResult->pc11_quant;
                        if ($oResult->mediapercentual == 0) {
                            $oDadosDaLinha->mediapercentual = "-";
                        } else {
                            $oDadosDaLinha->mediapercentual = number_format($oResult->mediapercentual, 2) . "%";
                        }
                        $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
                        $lTotal = $oResult->si02_vlprecoreferencia * $oDadosDaLinha->quantidade;
                        $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");
                    }
                    
                    if($pc80_criterioadjudicacao == 1 && $oResult->si02_tabela == "t"){
                        $oDadosDaLinha->valorUnitario = 0;
                    }
                    if($pc80_criterioadjudicacao == 1 && $oResult->si02_tabela == "f"){
                        $oDadosDaLinha->mediapercentual = "-";
                    }
                    if($pc80_criterioadjudicacao == 2 && $oResult->si02_taxa == "t"){
                        $oDadosDaLinha->valorUnitario = 0;
                    }
                    if($pc80_criterioadjudicacao == 2 && $oResult->si02_taxa == "f"){
                        $oDadosDaLinha->mediapercentual = "-";
                    }
                    
                    $oDadosDaLinha->valorUnitario = $oDadosDaLinha->valorUnitario > 0 ? "R$ $oDadosDaLinha->valorUnitario" : "-";

                    if ($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                        echo <<<HTML
        <tr>
          <td>{$oDadosDaLinha->seq}</td>
          <td>{$oDadosDaLinha->item}</td>
          <td>{$oDadosDaLinha->descricao}</td>
          <td>{$oDadosDaLinha->mediapercentual}</td>
          <td>{$oDadosDaLinha->valorUnitario}</td>
          <td>{$oDadosDaLinha->quantidade}</td>
          <td>{$oDadosDaLinha->unidadeDeMedida}</td>
          <td>{$oDadosDaLinha->total}</td> 
        </tr>


HTML;
                    } else {
                        echo <<<HTML
        <tr>
            <td> $oDadosDaLinha->seq               </td>
            <td> {$oDadosDaLinha->item}            </td>
            <td> {$oDadosDaLinha->descricao}       </td>
            <td> {$oDadosDaLinha->valorUnitario}   </td>
            <td> {$oDadosDaLinha->quantidade}      </td>
            <td> {$oDadosDaLinha->unidadeDeMedida} </td>
            <td> {$oDadosDaLinha->total}           </td>
        </tr>
        
HTML;
                    }
                }
                echo <<<HTML
                    </table>
                HTML;
            }

            ?>
            </table>
        </center>
    </body>

    </html>
<?php
}

header("Content-type: application/vnd.ms-word; charset=UTF-8");
header("Content-Disposition: attachment; Filename=Preco_de_Referencia_PRC_" . $codigo_preco . ".doc");
?>
