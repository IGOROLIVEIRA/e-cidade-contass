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
include("classes/db_matmater_classe.php");
$clrotulo = new rotulocampo;
$clmatmater = new cl_matmater;
$clrotulo->label('m60_codmater');
$clrotulo->label('m60_descr');
$clrotulo->label('m60_quantent');
$clrotulo->label('pc01_codmater');
$clrotulo->label('pc01_descrmater');
//$clrotulo->label('m61_abrev');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;

$xordem  = '';
$dbwhere = "1=1 ";


  if ($si06_sequencial == "" || $si06_sequencial == null) {
    if ($si06_anocadastro != "" && $si06_anocadastro != null) {
      $head5   = " EXERCÍCIO: ".$si06_anocadastro;
    }
    if ($si06_modalidade == 1) {
      $head6   = " MODALIDADE: CONCORRÊNCIA";
    }else{
      $head6   = " MODALIDADE: PREGÃO";
    }
  }

$info_listar_serv = "";

if ($fornecedor == 1) {

  $info_listar_serv .= " LISTAR: TODOS";
  
} else {
  $info_listar_serv = " LISTAR: FORNECEDOR";
}

$head3 = "ROL DE ADESãO A ATA DE REGISTRO DE PREÇO ";
$head7 = "$info_listar_serv";



if($si06_sequencial != "" && $si06_sequencial != null){
  $rsAdesao = db_query("select * from adesaoregprecos where si06_sequencial =".$si06_sequencial);
  
}else{
  $rsAdesao = db_query("select * from adesaoregprecos where si06_modalidade =".$si06_modalidade);
}

//$result =  $clmatmater->sql_record($clmatmater->sql_query_com(null,"*",$xordem,$dbwhere));
//db_criatabela($result);exit;
$xxnum = pg_numrows($rsAdesao);
if ($xxnum == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem unidades cadastrados.');
}
$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 3.5;
$pdf->addpage();
for ($x = 0; $x < pg_numrows($rsAdesao); $x++) {
  db_fieldsmemory($rsAdesao,$x);


    $rsAcordo = db_query("select * from acordo where ac16_adesaoregpreco = ".$si06_sequencial);
    if(pg_numrows($rsAcordo)>0){
      db_fieldsmemory($rsAcordo,0);
    }
    
    
    $pdf->setfont('arial','b',4);
    $pdf->cell(10,$alt,"Seq",1,0,"C",1);
    $pdf->cell(35,$alt,"Número do Processo de Adesão/ Exercício",1,0,"C",1);
    $pdf->cell(80,$alt,"Objeto",1,0,"C",1);
    $pdf->cell(20,$alt,"Fornecedor Ganhador",1,0,"C",1);
    $pdf->cell(15,$alt,"Data de Adesão",1,0,"C",1);
    $pdf->cell(15,$alt,"Data da Ata",1,0,"C",1);
    $pdf->cell(15,$alt,"Órgão Gerenciador",1,1,"C",1);
    //$pdf->cell(20,$alt,$RLm61_abrev,1,1,"R",1);
    
  
  $pdf->setfont('arial','',5);
  $asi06_objetoadesao = $si06_objetoadesao;
  
  if (strlen($si06_objetoadesao) > 70) {               
     $asi06_objetoadesao = quebrar_texto($si06_objetoadesao,70);
     $alt_novo = count($asi06_objetoadesao)+0.9;                  
  } else {
     $alt_novo = 2.5;
  }
  
  $pdf->cell(10, ($alt*$alt_novo), $si06_sequencial,1,0,"C",0);
  $pdf->cell(35, ($alt*$alt_novo), $si06_numeroadm, 1, 0, "C", 0);
  //$pdf->cell(80, ($alt*$alt_novo), $asi06_objetoadesao, 1, 0, "C", 0);
  $altatual = $alt;
  if (strlen($si06_objetoadesao) > 55) {
    $pos_x = $pdf->x;
    $pos_y = $pdf->y;
    foreach ($asi06_objetoadesao as $si06_objetoadesao_nova) {
            $pdf->cell(80,$alt+0.5,substr($si06_objetoadesao_nova,0,70),"",1,"L","");
            $pdf->x=$pos_x;
            $i++;
            $altatual = $altatual + 0.5;
            if($i == $alt_novo){
              $pdf->cell('','','','B');
            }      
    }
    $pdf->x = $pos_x+80;
} else {
    $pdf->cell(80,($alt*$alt_novo),substr($si06_objetoadesao,0,70),1,0,"L",0);
}
  $pdf->cell(20, ($alt*$alt_novo), $si06_cgm,1,0,"C",0);
  $pdf->cell(15, ($alt*$alt_novo), $si06_dataadesao,1,0,"C",0);
  $pdf->cell(15, ($alt*$alt_novo), $si06_dataata,1,0,"C",0);
  $pdf->cell(15, ($alt*$alt_novo), $si06_orgaogerenciador,1,1,"C",0);

  
    $pdf->setfont('arial','b',4);
    $pdf->cell(25,$alt,"Modalidade",1,0,"C",0);
    $pdf->cell(25,$alt,"Numero Modalidade",1,0,"C",0);
    $pdf->cell(25,$alt,"Número do Contrato/Exercício",1,0,"C",0);
    $pdf->cell(65,$alt,"Vigência Contrato",1,0,"C",0);
    $pdf->cell(25,$alt,"Valor Total do Contrato",1,0,"C",0);
    $pdf->cell(25,$alt,"Edital",1,1,"C",0);
    $alt_novo = 2.5;

  $pdf->setfont('arial','',5);
  if ($si06_modalidade == 1) {
    $pdf->cell(25, ($alt*$alt_novo), "CONCORRÊNCIA",1,0,"C",0);
  }else{
    
    $pdf->cell(25, ($alt*$alt_novo),"PREGÃO",1,0,"C",0);
  }
  $pdf->cell(25, ($alt*$alt_novo), $si06_numlicitacao, 1, 0, "C", 0);
  if(pg_numrows($rsAcordo)>0){
    $pdf->cell(12.5, ($alt*$alt_novo), $ac16_numero, 1, 0, "C", 0);
    $pdf->cell(12.5, ($alt*$alt_novo), $ac16_anousu, 1, 0, "C", 0);
    $pdf->cell(32.5, ($alt*$alt_novo), $ac16_datainicio,1,0,"C",0);
    $pdf->cell(32.5, ($alt*$alt_novo), $ac16_datafim,1,0,"C",0);
    $pdf->cell(25, ($alt*$alt_novo), $ac16_valor,1,0,"C",0);
  }else{
    $pdf->cell(12.5, ($alt*$alt_novo), "", 1, 0, "C", 0);
    $pdf->cell(12.5, ($alt*$alt_novo), "", 1, 0, "C", 0);
    $pdf->cell(32.5, ($alt*$alt_novo), "",1,0,"C",0);
    $pdf->cell(32.5, ($alt*$alt_novo), "",1,0,"C",0);
    $pdf->cell(25, ($alt*$alt_novo), "",1,0,"C",0);
  }
  
  $pdf->cell(25, ($alt*$alt_novo), $si06_edital,1,1,"C",0);
  
  $pdf->cell(25, 10, "",0,1,"C",0);
  $total ++;
}

$pdf->output();

function quebrar_texto($texto,$tamanho){

	$aTexto = explode(" ", $texto);
	$string_atual = "";
	foreach ($aTexto as $word) {
		$string_ant = $string_atual;
		$string_atual .= " ".$word;
		if (strlen($string_atual) > $tamanho) {
			$aTextoNovo[] = $string_ant;
			$string_ant   = "";
			$string_atual = $word;
		}
	}
	$aTextoNovo[] = $string_atual;
	return $aTextoNovo;

}
?>
