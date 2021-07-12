<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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

include("fpdf151/pdf.php");
include("libs/db_sql.php");

$oInstituicao = new Instituicao(db_getsession("DB_instit"));

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$sWhere = " WHERE e81_cancelado IS NULL AND e60_instit = {$oInstituicao->getCodigo()} ";

if (isset($aCredor) && $aCredor != '') {
    $sWhere .= " AND z01_numcgm IN ({$aCredor}) ";
}

if (isset($e50_codord) && $e50_codord != '') {
    $sWhere .= " AND e50_codord = {$e50_codord} ";
}

if (isset($e81_codmov) && $e81_codmov != '') {
    $sWhere .= " AND e81_codmov = {$e81_codmov} ";
}

$sWhereData = " WHERE 1 = 1 ";

if (isset($dtini) && $dtini != '' && isset($dtfim) && $dtfim != ''){

    $dtini = str_replace("X","-",$dtini);
    $dtfim = str_replace("X","-",$dtfim);

    $sWhereData .= " AND k12_data BETWEEN '{$dtini}' AND '{$dtfim}' ";

} else {
    
    if (isset($dtini) && $dtini != ''){

        $dtini = str_replace("X","-",$dtini);
        $sWhereData .= " AND k12_data >= '{$dtini}'";

    }

    if (isset($dtfim) && $dtfim != ''){

        $dtfim = str_replace("X","-",$dtfim);
        $sWhereData .= " AND k12_data <= '{$dtfim}'";

    }

}

if (isset($e60_codemp) && $e60_codemp != '') {

    $aCodEmp = explode("/",$e60_codemp);

    if (count($aCodEmp) == 2  && isset($aCodEmp[1]) && $aCodEmp[1] != '' ) {
        $sWhereAno = " AND e60_anousu = ".$aCodEmp[1];
    } elseif (count($aCodEmp) == 1) {
        $sWhereAno = " AND e60_anousu = ".db_getsession("DB_anousu");
    } else {
        $sWhereAno = "";
    }

    $sWhere .= " AND e60_codemp = '{$aCodEmp[0]}' {$sWhereAno} ";

}

if (isset($e60_numemp) && $e60_numemp != '') {
    $sWhere .= " AND e60_numemp = {$e60_numemp} ";
}

$sSqlMovimentos = " SELECT * FROM
                        (SELECT DISTINCT e81_codmov,
                            e81_valor,
                            k12_data,
                            e50_codord,
                            z01_numcgm,
                            z01_cgccpf,
                            z01_nome,
                            z01_ender,
                            z01_numero,
                            z01_compl,
                            z01_uf,
                            z01_cep,
                            z01_bairro,
                            z01_munic,
                            z01_cep,
                            e60_codemp,
                            e60_anousu,
                            c72_complem 
                        FROM empagemov
                            INNER JOIN corempagemov ON corempagemov.k12_codmov = empagemov.e81_codmov
                            INNER JOIN empage ON empage.e80_codage = empagemov.e81_codage
                            INNER JOIN empagepag ON empagemov.e81_codmov = empagepag.e85_codmov
                            LEFT JOIN empageconf ON empageconf.e86_codmov = empagemov.e81_codmov
                            LEFT JOIN empageconfgera ON empageconfgera.e90_codmov = empagemov.e81_codmov AND empageconfgera.e90_cancelado IS FALSE
                            LEFT JOIN empagegera ON empagegera.e87_codgera = empageconfgera.e90_codgera
                            INNER JOIN empempenho ON empempenho.e60_numemp = empagemov.e81_numemp
                            INNER JOIN pagordem ON empempenho.e60_numemp = pagordem.e50_numemp
                            INNER JOIN cgm ON cgm.z01_numcgm = empempenho.e60_numcgm
                            INNER JOIN conlancamord ON e50_codord = c80_codord 
                            INNER JOIN conlancamdoc on c80_codlan = c71_codlan AND c71_coddoc = 3 AND e80_data = c71_data
                            INNER JOIN conlancamcompl on c80_codlan = c72_codlan
                        {$sWhere} ORDER BY k12_data) AS X {$sWhereData}";

$rsMovimentos   = db_query($sSqlMovimentos);

$head3 = "RECIBO DE PAGAMENTO";

if (pg_num_rows($rsMovimentos) == 0){
   db_redireciona('db_erros.php?fechar=true&db_erro=Nenhum recibo encontrado.');
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$total = 0;

for ($iCont = 0; $iCont < pg_num_rows($rsMovimentos); $iCont++) {    
    
    db_fieldsmemory($rsMovimentos,$iCont);

    $pdf->addpage();
    $pdf->cell(17,$alt+8,"RECIBO Nº: ",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(65,$alt+8,$e81_codmov,0,0,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(23,$alt+8,"VALOR BRUTO: ",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(57,$alt+8,trim(db_formatar($e81_valor,'f')),0,0,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(10,$alt+8,"DATA: ",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(35,$alt+8,db_formatar($k12_data,'d'),0,1,"L",0);

    $pdf->setfont('arial','b',8);
    $pdf->cell(192,$alt+8,"DADOS DO CREDOR","T",1,"C",0);

    $pdf->cell(18,$alt,"CGM:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(160,$alt,$z01_numcgm,0,1,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(18,$alt,"NOME:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(160,$alt,$z01_nome,0,1,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(18,$alt,"CPF/CNPJ:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    
    if (strlen(trim($z01_cgccpf)) == 14) {
        $z01_cgccpf = db_formatar($z01_cgccpf,'cnpj');
    } elseif (strlen(trim($z01_cgccpf)) == 11) {
        $z01_cgccpf = db_formatar($z01_cgccpf,'cpf');
    }

    $pdf->cell(160,$alt,$z01_cgccpf,0,1,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(18,$alt,"ENDEREÇO:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    
    $sEndereco = trim($z01_ender).", ".trim($z01_numero)." ".trim($z01_compl);
    if (strlen($sEndereco) > 55) {
        $sEndereco = substr($sEndereco,0,56)."...";
    }
    $pdf->cell(85,$alt,$sEndereco,0,0,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(13,$alt,"BAIRRO:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(75,$alt,$z01_bairro,0,1,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(18,$alt,"MUNICÍPIO:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $sMunicipio = ($z01_munic.$z01_uf) != "" ? $z01_munic."/".$z01_uf : "";
    $pdf->cell(85,$alt,$sMunicipio,0,0,"L",0);
    $pdf->setfont('arial','b',8);
    $pdf->cell(13,$alt,"CEP:",0,0,"L",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(75,$alt,db_formatar($z01_cep, 'cep'),0,1,"L",0);
    
    $pdf->SetY(85);
    
    $pdf->setfont('arial','b',8);
    $pdf->cell(192,$alt+8,"DISCRIMINAÇÃO DO RECIBO","T",1,"C",0);

    $pdf->cell(100,$alt,"VALOR BRUTO:",0,0,"R",0);
    $pdf->SetFont('Arial','',8);
    $pdf->cell(22,$alt,trim(db_formatar($e81_valor,'f')),0,1,"R",0);
    
    $rsRetencoes = getRetencoes($e50_codord, $e81_codmov);
    
    for ($iRet = 0; $iRet < pg_num_rows($rsRetencoes); $iRet++) {

        db_fieldsmemory($rsRetencoes,$iRet);

        $e81_valor -= $e23_valorretencao;

        $pdf->SetFont('Arial','',8);
        $pdf->cell(100,$alt,$e21_descricao.":",0,0,"R",0);
        $pdf->cell(22,$alt,trim(db_formatar($e23_valorretencao,'f')),0,1,"R",0);

    }

    $pdf->setfont('arial','b',8);
    $pdf->cell(100,$alt,"VALOR LÍQUIDO:",0,0,"R",0);
    $pdf->SetFont('Arial','',8);
    
    $valorLiquido = trim(db_formatar($e81_valor,'f'));
    $pdf->cell(22,$alt,$valorLiquido,"T",1,"R",0);

    $posicaoY = $pdf->gety();
    $pdf->SetY($posicaoY+5);
    
    $sValorExtenso = db_extenso($e81_valor, true);

    $pdf->SetFont('Arial','',8);
    $sRecibo = "Recebi da {$oInstituicao->getDescricao()} a quantia de R$ {$valorLiquido}, {$sValorExtenso}. ";
    $pdf->MultiCell(192, 4, $sRecibo, 0, "L", 0, 0); 

    $posicaoY = $pdf->gety();
    $pdf->SetY($posicaoY+5);

    $sCorrespondente = "Correspondente a: {$c72_complem}. Empenho {$e60_codemp}/{$e60_anousu}. Ordem de Pagamento Nº {$e50_codord}.";
    $pdf->MultiCell(192, 4, $sCorrespondente, 0, "J", 0, 0);    

    $posicaoY = $pdf->gety();
    $pdf->SetY($posicaoY+8);

    $pdf->SetFont('Arial','b',8);
    $pdf->cell(192,$alt+8,"RECIBO","T",1,"C",0);

    $sDeclado = "Declaro que recebi deste órgão o valor líquido supracitado o qual dou plena quitação.";
    $pdf->SetFont('Arial','',8);
    $pdf->MultiCell(165, 6, $sDeclado, 0, "L", 0, 0);  
    
    $posicaoY = $pdf->gety();
    $pdf->SetXY(55,$posicaoY+10);

    $pdf->cell(32,4,$oInstituicao->getMunicipio().", ",0,0,"L",0);
    $pdf->cell(13,3,"","B",0,"L",0);
    $pdf->cell(5,4,"de",0,0,"L",0);
    $pdf->cell(35,3,"","B",0,"L",0);
    $pdf->cell(9,4,"de 20",0,0,"L",0);
    $pdf->cell(10,3,"","B",1,"L",0);

    $posicaoY = $pdf->gety();
    $pdf->SetXY(45,$posicaoY+15);
    $pdf->cell(120,$alt,"CREDOR","T",1,"C",0);

    $pdf->SetFont('Arial','b',8);
    
    $posicaoY = $pdf->gety();
    $pdf->SetY($posicaoY+15);

    $pdf->SetFont('Arial','b',8);
    $pdf->cell(13,4,"BANCO:",0,0,"L",0);
    $pdf->cell(47,3,"","B",0,"L",0);
    $pdf->cell(13,4,"CONTA:",0,0,"L",0);
    $pdf->cell(48,3,"","B",0,"L",0);
    $pdf->cell(15,4,"CHEQUE:",0,0,"L",0);
    $pdf->cell(48,3,"","B",1,"L",0);

    

}

$pdf->Output();

function getRetencoes($iPagOrd = null, $iCodMov = null) {
    
    if ($iPagOrd != null && $iCodMov != null) {
    
        $sSqlRetencoes = " SELECT   e21_descricao, 
                                sum(e23_valorretencao) AS e23_valorretencao
                            FROM retencaopagordem
                                JOIN retencaoreceitas ON e23_retencaopagordem = e20_sequencial
                                JOIN retencaotiporec ON e23_retencaotiporec = e21_sequencial
                                JOIN retencaoempagemov on e27_retencaoreceitas = e23_sequencial
                                WHERE e23_recolhido = TRUE 
                                    AND e20_pagordem = {$iPagOrd} and e27_empagemov = ($iCodMov) GROUP BY 1";

        return db_query($sSqlRetencoes);                            
    
    }

}
   
?>