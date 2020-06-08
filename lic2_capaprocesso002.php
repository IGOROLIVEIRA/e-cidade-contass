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

include("fpdf151/scpdf.php");
db_postmemory($HTTP_SERVER_VARS);
$oLicitacao = new licitacao($l20_codigo);

$sql = "select uf, db12_extenso, logo, munic, cgc, ender, bairro, numero, codigo, nomeinst
			from db_config  
				inner join db_uf on db12_uf = uf
			where codigo = ".db_getsession("DB_instit");

$result = pg_query($sql);
db_fieldsmemory($result,0);

$pdf = new SCPDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image("imagens/files/".$logo,90,7,30);
//$this->Image('imagens/files/'.$logo,2,3,30);
$pdf->Ln(30);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,4,$db12_extenso,0,"C",0);
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(0,6,strtoupper($nomeinst),0,"C",0);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,4,'CNPJ: '.db_formatar($cgc,'cnpj'),0,"C",0);
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(0,4,"{$ender} No {$numero} {$bairro}",0,"C",0);
$pdf->Ln(32);
$pdf->SetFont('Arial','B',14);
$pdf->SetFillColor(235);
$pdf->Cell(190,10,"Processo Licitatório: {$oLicitacao->getNumeroLicitacao()}/{$oLicitacao->getAno()}",1,1,"C",0);
$pdf->Ln();
$pdf->MultiCell(0,4,"{$oLicitacao->getModalidade()->getDescricao()} No:{$oLicitacao->getEdital()}/{$oLicitacao->getAno()}",0,"C",0);
$pdf->Ln(12);
$pdf->SetFont('Arial','',12);
$pdf->MultiCell(0,4,"Objeto: {$oLicitacao->getObjeto()}",0,"C",0);
$pdf->Ln(7);
$arrayDispensa = array(100,101,102);
if(!in_array($oLicitacao->iTipoCompraTribunal, $arrayDispensa)){
    $pdf->MultiCell(0,4,"Comissão:",0,"C",0);
    $pdf->Ln();
    $pdf->SetFont('Arial','',8);
    foreach($oLicitacao->getComissao() as $oMembro) {
        $pdf->MultiCell(0, 4, "{$oMembro->z01_nome} - {$oMembro->l46_tipo}", 0, "C", 0);
    }
}
$pdf->Output();
?>