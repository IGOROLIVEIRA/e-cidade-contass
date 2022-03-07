<?php
require_once 'model/relatorios/Relatorio.php';
require("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']); //
db_postmemory($HTTP_POST_VARS);
$oGet = db_utils::postmemory($_GET);

switch ($oGet->tipoprecoreferencia) {
    case 2:
        $tipoReferencia = " MAX(pc23_vlrun) ";
        break;

    case 3:
        $tipoReferencia = " MIN(pc23_vlrun) ";
        break;

    default:
        $tipoReferencia = " (sum(pc23_vlrun)/count(pc23_orcamforne)) ";
        break;
}
   

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

if (pg_num_rows($rsLotes) == 0) {

    /*$sSql = "select * from (SELECT
                pc01_codmater,
                case when pc01_complmater is not null and pc01_complmater != pc01_descrmater then pc01_descrmater ||'. '|| pc01_complmater
		     else pc01_descrmater end as pc01_descrmater,
                m61_abrev,
                sum(pc11_quant) as pc11_quant,
                pc69_seq,
                pc11_seq,
                pc11_reservado,
                l21_ordem
from (
SELECT DISTINCT pc01_servico,
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
                pc01_descrmater,pc01_complmater,
                pc10_numero,
                pc90_numeroprocesso AS processo_administrativo,
                (pc11_quant * pc11_vlrun) AS pc11_valtot,
                m61_usaquant,
                pc69_seq,
                pc11_reservado,
                l21_ordem
FROM solicitem
INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
left join processocompraloteitem on
		pc69_pcprocitem = pcprocitem.pc81_codprocitem
left join processocompralote on
			pc68_sequencial = pc69_processocompralote
AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
left join liclicitem on l21_codpcprocitem = pc81_codprocitem
WHERE pc81_codproc = {$codigo_preco}
  AND pc10_instit = " . db_getsession("DB_instit") . "
ORDER BY l21_ordem) as x GROUP BY
                pc01_codmater,
                pc11_seq,
                pc01_descrmater,pc01_complmater,m61_abrev,pc69_seq,pc11_reservado,l21_ordem
                order by
                l21_ordem) as matquan join
(SELECT DISTINCT
                pc11_seq,
                {$tipoReferencia} as si02_vlprecoreferencia,
                                     case when pc80_criterioadjudicacao = 1 then
                     round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
                     when pc80_criterioadjudicacao = 2 then
                     round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
                     end as mediapercentual,
                pc01_codmater,
                si01_datacotacao,
                pc80_criterioadjudicacao,
                pc01_tabela,
                pc01_taxa,
                si01_justificativa 
FROM pcproc
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
WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0
GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa
ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by l21_ordem asc";

    $rsResult = db_query($sSql) or die(pg_last_error());*/ //db_criatabela($rsResult);exit;

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
                si01_processocompra = {$codigo_preco});";
            $rsResult = db_query($sSql) or die(pg_last_error());

            $pc80_criterioadjudicacao = db_utils::fieldsMemory($rsResult, 0)->si02_criterioadjudicacao;
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
                            si01_processocompra = {$codigo_preco});";
                    $rsResult = db_query($sSql) or die(pg_last_error());

            }

    header("Content-type: text/plain");
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=Preco_de_Referencia_PRC_" . $codigo_preco . ".csv");
    header("Pragma: no-cache");

    echo "Preço de Referência \n";
    echo "Processo de Compra: $codigo_preco \n";
    echo "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResultData, 0)->si01_datacotacao))) . " \n";

    echo "SEQ;";
    echo "ITEM;";
    echo "DESCRICAO DO ITEM;";
    echo "VALOR UN;";
    echo "QUANT;";
    echo "UN;";
    echo "TOTAL;\n";


    $nTotalItens = 0;
    $sqencia = 0; 
    for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

        $oResult = db_utils::fieldsMemory($rsResult, $iCont);

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

        //if($quant_casas == 2){
        $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->si02_qtditem;
        //}else $lTotal = round($oResult->si02_vlprecoreferencia,3) * $oResult->pc11_quant;

        $nTotalItens += $lTotal;

        $oDadosDaLinha = new stdClass();
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
                $oDadosDaLinha->descricao = '[ME/EPP] - ' . str_replace(';', "", $oResult2->pc01_descrmater);
            } else {
                $oDadosDaLinha->descricao = str_replace(';', "", $oResult2->pc01_descrmater);
            }
            //$oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
            $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
            if($controle == 0 && $fazerloop==2){
                $oDadosDaLinha->quantidade = $oResult->si02_qtditem - $valorqtd;
            }else if($controle == 1 && $fazerloop==2){
                $oDadosDaLinha->quantidade = $valorqtd;
            }else{
                $oDadosDaLinha->quantidade = $oResult->si02_qtditem;
            }
            $oDadosDaLinha->unidadeDeMedida = $oResult1->m61_abrev;
            if($controle==0 && $fazerloop==2){
                $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * ($oResult->si02_qtditem - $valorqtd);
            }else if($controle==1 && $fazerloop==2){
                $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $valorqtd;
            }
            $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");

            $controle++;
            $sqencia++;

            echo "$oDadosDaLinha->seq;";
            echo "$oDadosDaLinha->item;";
            echo "$oDadosDaLinha->descricao;";
            echo "R$ $oDadosDaLinha->valorUnitario;";
            echo "$oDadosDaLinha->quantidade;";
            echo "$oDadosDaLinha->unidadeDeMedida;";
            echo "R$ $oDadosDaLinha->total;\n";
        }
    }


    //    echo "VALOR TOTAL DOS ITENS;";
    //    echo "R$" . number_format($nTotalItens, 2, ",", ".").";";
    if ($oGet->impjust == 't') {
        echo "JUSTIFICATIVA;\n";
        echo str_replace(array(';', '.', ','), "", db_utils::fieldsMemory($rsResult, 0)->si01_justificativa);
    }
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

    header("Content-type: text/plain");
    header("Content-type: application/csv");
    header("Content-Disposition: attachment; filename=Preco_de_Referencia_PRC_" . $codigo_preco . ".csv");
    header("Pragma: no-cache");

    echo "Preço de Referência \n";
    echo "Processo de Compra: $codigo_preco \n";
    echo "Data: " . implode("/", array_reverse(explode("-", db_utils::fieldsMemory($rsResultData, 0)->si01_datacotacao))) . " \n";

    for ($i = 0; $i < pg_num_rows($rsLotes); $i++) {

        $oLotes = db_utils::fieldsMemory($rsLotes, $i); 

        echo "$oLotes->pc68_nome;\n";
        echo "ITEM LOTE;";
        echo "CODIGO;";
        echo "DESCRICAO DO ITEM;";
        echo "VALOR UN;";
        echo "QUANT;";
        echo "UN;";
        echo "TOTAL;\n";

        $sSql = "select * from (SELECT
        pc01_codmater,
        case when pc01_complmater is not null and pc01_complmater != pc01_descrmater then pc01_descrmater ||'. '|| pc01_complmater
		     else pc01_descrmater end as pc01_descrmater,
        m61_abrev,
        sum(pc11_quant) as pc11_quant,
        pc69_seq,
        pc11_seq
    from (
    SELECT DISTINCT pc01_servico,
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
        pc01_descrmater,pc01_complmater,
        pc10_numero,
        pc90_numeroprocesso AS processo_administrativo,
        (pc11_quant * pc11_vlrun) AS pc11_valtot,
        m61_usaquant,
        pc69_seq
    FROM solicitem
    INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
    LEFT JOIN solicitaprotprocesso ON solicitaprotprocesso.pc90_solicita = solicita.pc10_numero
    LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
    LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
    LEFT JOIN pcprocitem ON pcprocitem.pc81_solicitem = solicitem.pc11_codigo
    LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
    LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
    LEFT JOIN solicitemele ON solicitemele.pc18_solicitem = solicitem.pc11_codigo
    LEFT JOIN orcelemento ON solicitemele.pc18_codele = orcelemento.o56_codele
    left join processocompraloteitem on
    pc69_pcprocitem = pcprocitem.pc81_codprocitem
    left join processocompralote on
    pc68_sequencial = pc69_processocompralote
    AND orcelemento.o56_anousu = " . db_getsession("DB_anousu") . "
    WHERE pc81_codproc = {$codigo_preco}
    AND pc68_sequencial = $oLotes->pc68_sequencial
    AND pc10_instit = " . db_getsession("DB_instit") . "
    ORDER BY pc11_seq) as x GROUP BY
        pc01_codmater,
        pc11_seq,
        pc01_descrmater,pc01_complmater,m61_abrev,pc69_seq ) as matquan join
    (SELECT DISTINCT
        pc11_seq,
        {$tipoReferencia} as si02_vlprecoreferencia,
                             case when pc80_criterioadjudicacao = 1 then
             round((sum(pc23_perctaxadesctabela)/count(pc23_orcamforne)),2)
             when pc80_criterioadjudicacao = 2 then
             round((sum(pc23_percentualdesconto)/count(pc23_orcamforne)),2)
             end as mediapercentual,
        pc01_codmater,
        si01_datacotacao,
        pc80_criterioadjudicacao,
        pc01_tabela,
        pc01_taxa,
        si01_justificativa
    FROM pcproc
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
    WHERE pc80_codproc = {$codigo_preco} {$sCondCrit} and pc23_vlrun <> 0
    GROUP BY pc11_seq, pc01_codmater,si01_datacotacao,si01_justificativa,pc80_criterioadjudicacao,pc01_tabela,pc01_taxa
    ORDER BY pc11_seq) as matpreco on matpreco.pc01_codmater = matquan.pc01_codmater order by matquan.pc11_seq asc";

        $rsResult = db_query($sSql) or die(pg_last_error());

        $nTotalItens = 0;

        for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

            $oResult = db_utils::fieldsMemory($rsResult, $iCont);

            //if($quant_casas == 2){
            $lTotal = round($oResult->si02_vlprecoreferencia, $oGet->quant_casas) * $oResult->pc11_quant;
            //}else $lTotal = round($oResult->si02_vlprecoreferencia,3) * $oResult->pc11_quant;

            $nTotalItens += $lTotal;

            $oDadosDaLinha = new stdClass();
            $oDadosDaLinha->seq = $iCont + 1;
            $oDadosDaLinha->item = $oResult->pc01_codmater; //$oResult->pc11_seq;
            if ($oResult->pc11_reservado == 't') {
                $oDadosDaLinha->descricao = '[ME/EPP] - ' . str_replace(';', "", $oResult->pc01_descrmater);
            } else {
                $oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
            }
            //$oDadosDaLinha->descricao = str_replace(';', "", $oResult->pc01_descrmater);
            $oDadosDaLinha->valorUnitario = number_format($oResult->si02_vlprecoreferencia, $oGet->quant_casas, ",", ".");
            $oDadosDaLinha->quantidade = $oResult->pc11_quant;
            $oDadosDaLinha->unidadeDeMedida = $oResult->m61_abrev;
            $oDadosDaLinha->total = number_format($lTotal, 2, ",", ".");

            echo "$oDadosDaLinha->seq;";
            echo "$oDadosDaLinha->item;";
            echo "$oDadosDaLinha->descricao;";
            echo "R$ $oDadosDaLinha->valorUnitario;";
            echo "$oDadosDaLinha->quantidade;";
            echo "$oDadosDaLinha->unidadeDeMedida;";
            echo "R$ $oDadosDaLinha->total;\n";
        }
    }

    //    echo "VALOR TOTAL DOS ITENS;";
    //    echo "R$" . number_format($nTotalItens, 2, ",", ".").";";
    if ($oGet->impjust == 's') {
        echo "JUSTIFICATIVA;\n";
        echo str_replace(array(';', '.', ','), "", db_utils::fieldsMemory($rsResult, 0)->si01_justificativa);
    }
}
