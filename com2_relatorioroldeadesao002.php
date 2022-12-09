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
$sWhere = "";
$sAnd = "";
if ($cgms) {
  $sWhere .= $sAnd . " cgmfornecedor.z01_numcgm in (" . $cgms . ") ";
  $sAnd = " and ";
}

if ($si06_anocadastro) {
  $sWhere .= $sAnd . " si06_anocadastro =".$si06_anocadastro;
  $sAnd = " and ";
}

if ($si06_modalidade) {
  $sWhere .= $sAnd . " si06_modalidade =".$si06_modalidade;
  $sAnd = " and ";
}


if($si06_sequencial != "" && $si06_sequencial != null){
  $rsAdesao = db_query("select * from adesaoregprecos where si06_sequencial =".$si06_sequencial);
  
}else{
  $rsAdesao = db_query("select * from adesaoregprecos where ".$sWhere);
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

    $rsCgm = db_query("select * from cgm where z01_numcgm= ".$si06_cgm);
    if(pg_numrows($rsCgm)>0){
      db_fieldsmemory($rsCgm,0);
    }
    $rsAcordo = db_query("select * from acordo where ac16_adesaoregpreco = ".$si06_sequencial);
    if(pg_numrows($rsAcordo)>0){
      db_fieldsmemory($rsAcordo,0);
    }
    if ($pdf->getY() >= 250) {
      $pdf->Ln(100);
    }
    
    $pdf->setfont('arial','b',4);
    $pdf->cell(5,$alt,"Seq",1,0,"C",1);
    $pdf->cell(35,$alt,"Número do Processo de Adesão/ Exercício",1,0,"C",1);
    $pdf->cell(80,$alt,"Objeto",1,0,"C",1);
    $pdf->cell(25,$alt,"Fornecedor Ganhador",1,0,"C",1);
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
  
  $pdf->cell(5, ($alt*$alt_novo), $si06_sequencial,1,0,"C",0);
  $pdf->cell(35, ($alt*$alt_novo), $si06_numeroadm, 1, 0, "C", 0);
  //$pdf->cell(80, ($alt*$alt_novo), $asi06_objetoadesao, 1, 0, "C", 0);
  $altatual = $alt;
  $pos_x = $pdf->x;
    $pos_y = $pdf->y;
  if (strlen($si06_objetoadesao) > 55) {
    
    foreach ($asi06_objetoadesao as $si06_objetoadesao_nova) {
            $pdf->cell(80,$alt+0.5,substr($si06_objetoadesao_nova,0,70),"R",1,"L",0);
            $pdf->x=$pos_x;
            $i++;
            $altatual = $altatual + 0.5;
            if($i == $alt_novo){
              $pdf->cell('','','','B');
            }      
    }
    $pdf->x = $pdf->x+80;
  } else {
      $pdf->cell(80,($alt*$alt_novo),$si06_objetoadesao,"R",1,"L",0);
      $pdf->x = $pdf->x+120;
  }
  //$pdf->MultiCell(80,2,$si06_objetoadesao,1,0,"L",0);
  
  $pdf->y = $pos_y;
  
  /*if (pg_numrows($rsCgm) > 0) {
    $pdf->cell(25, ($alt*$alt_novo), $z01_nome,1,0,"C",0);
  }else{
    
    $pdf->cell(25, ($alt*$alt_novo), "",1,0,"C",0);
  }*/
  $pos_x = $pdf->x;
  $pos_y = $pdf->y;
  if (strlen($z01_nome) > 20) {               
    $az01_nome = quebrar_texto($z01_nome,70);              
  } 

  if (strlen($z01_nome) > 20) {
    
    foreach ($az01_nome as $z01_nome_nova) {
            $pdf->cell(25,$alt+0.5,substr($z01_nome_nova,0,20),"",1,"L",0);
            $pdf->x=$pos_x;
            $i++;
            if($i == $alt_novo){
              $pdf->cell('','','','B');
            }      
    }
    $pdf->x = $pdf->x+25;
  } else {
      $pdf->cell(25,($alt*$alt_novo),$z01_nome,1,1,"L",0);
      $pdf->x = $pdf->x+145;
  }
  $pdf->y = $pos_y;
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
    $pdf->cell(25, ($alt*$alt_novo), $ac16_numero."/".$ac16_anousu, 1, 0, "C", 0);
    $pdf->cell(32.5, ($alt*$alt_novo), $ac16_datainicio,1,0,"C",0);
    $pdf->cell(32.5, ($alt*$alt_novo), $ac16_datafim,1,0,"C",0);
    $pdf->cell(25, ($alt*$alt_novo), 'R$' . number_format($ac16_valor, 2, ',', '.'),1,0,"C",0);
  }else{
    $pdf->cell(25, ($alt*$alt_novo), "", 1, 0, "C", 0);
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
