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
include("classes/db_requisitantes_transparencia_classe.php");
$clrotulo = new rotulocampo;
$clrequisitantes_transparencia = new cl_requisitantes_transparencia;
$clrotulo->label('db149_matricula');
$clrotulo->label('db149_cpf');
$clrotulo->label('db149_nome');
$clrotulo->label('db149_data');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);


$head3 = "Consultas Folha de Pagamento";
$head4 = "Portal da Transparência";

$where = " 1=1 ";
if(isset($db149_matricula) && (trim($db149_matricula)!="") ){
  $head6 = "Matrícula {$db149_matricula}";
  $where .= " and db149_matricula = {$db149_matricula} ";
}
if((isset($chave_data1) && (trim($chave_data1)!="")) && (isset($chave_data2) && (trim($chave_data2)!="")) ){
  $head7 = "Data Consulta {$chave_data1} à {$chave_data2}";
  $where .= " and db149_data between '{$chave_data1}' and '{$chave_data2}'";
}
$sql = $clrequisitantes_transparencia->sql_query("","requisitantes_transparencia.*","",$where);
$result =$clrequisitantes_transparencia->sql_record($sql);

if (pg_numrows($result) == 0) {
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
for ($x = 0; $x < pg_numrows($result); $x++) {
  
  $oRequisitantes = db_utils::fieldsMemory($result,$x);
  if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ) {
    $pdf->addpage();
    $pdf->setfont('arial','b',8);
    $pdf->cell(30,$alt,"Matrícula Consultada",1,0,"C",1);
    $pdf->cell(20,$alt,"CPF",1,0,"C",1);
    $pdf->cell(110,$alt,"Nome",1,0,"C",1);
    $pdf->cell(30,$alt,"Data da Consulta",1,1,"C",1);
    $troca = 0;
  }
  $pdf->setfont('arial','',7);

  $aDataHora = explode(" ", $oRequisitantes->db149_data);
  $sData = explode( "-", $aDataHora[0] );
  $sDataHora    = $sData[2] . "/" . $sData[1] . "/" . $sData[0]. " " .$aDataHora[1];
  
  $pdf->cell(30, $alt, $oRequisitantes->db149_matricula,1,0,"C",0);
  $pdf->cell(20, $alt, $oRequisitantes->db149_cpf, 1, 0, "C", 0);
  $pdf->cell(110, $alt, $oRequisitantes->db149_nome,1,0,"L",0);
  $pdf->cell(30,$alt,$sDataHora,1,1,"C");
  $total ++;
}
$pdf->setfont('arial','b',8);
$pdf->cell(0,$alt,"TOTAL DE REGISTROS  :  $total",'T',0,"L",0);
$pdf->output();

?>
