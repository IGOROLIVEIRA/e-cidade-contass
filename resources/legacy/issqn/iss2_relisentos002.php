<?php
include("fpdf151/pdf.php");
$clrotulo = new rotulocampo;
$clrotulo->label('q148_inscricao');
$clrotulo->label('q147_descr');
$clrotulo->label('q148_perc');
$clrotulo->label('q148_hist');

db_postmemory($HTTP_SERVER_VARS);
$head1 = "RELATÓRIO DE ISENÇÕES";
$head4 = "ORDEM: " . ($order == "z01_nome"?"NOME":"INSCRIÇÃO");


if ($datai != "--"){

		if($tipodata == "dtinc"){

		   $xdatas    = " and q148_dtinc between '$datai' and '$dataf' ";
		   $tipodata2 = "DATA DE INCLUSÃO DA ISENÇÃO";
		}else if($tipodata == "dtini"){

		   $xdatas    = " and q148_dtini between '$datai' and '$dataf' ";
		   $tipodata2 ="DATA DE INÍCIO DA ISENÇÃO";
		}else if($tipodata == "dtfim"){

		   $xdatas    = " and q148_dtfim between '$datai' and '$dataf' ";
		   $tipodata2 = "DATA DE FIM DA ISENÇÃO";
		}

   $head5 = "$tipodata2";
   $head6 = "PERÍODO ".db_formatar($datai,'d')." A ".db_formatar($dataf,'d');
} else {

   $xdatas = "";
   $head5  = "SEM FILTRO PARA PERIODO DEFINIDO";
}

$xtipo = '';

if (isset($campo)){
  $xtipo = " and q148_tipo in (".str_replace('-',', ',$campo).")";
}

if(isset($order)){

   if($order == "z01_nome"){
     $order = "z01_nome";
   }elseif($order == "inscricao"){
     $order = "q148_inscr";
   }
}

$sql = "SELECT q148_inscr,
       z01_nome,
       q148_dtini,
       q148_dtfim,
       q148_perc,
       q147_descr,
       db_usuarios.login,
       q148_dtinc
FROM issisen
INNER JOIN issbase ON q02_inscr = q148_inscr
INNER JOIN cgm ON z01_numcgm = q02_numcgm
INNER JOIN db_usuarios ON id_usuario = q148_idusu
INNER JOIN isstipoisen ON q148_tipo = q147_tipo";
$sql .= " where 1=1 $xdatas $xtipo order by $order, q148_dtini";

$result = db_query($sql) or die($sql);
$num    = pg_numrows($result);

if ( $num == 0 ) {

  db_redireciona('db_erros.php?fechar=true&db_erro=Não exitem isenções cadastradas para os parâmetros escolhidos');
  exit;
}

$totalportipo = array();

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(220);
$pdf->SetFont('Arial','',11);

$pdf->SetFont('Arial','B',7);

// títulos das coluna no relatório
$pdf->Cell(15,5,"Inscrição",1,0,"C",1);
$pdf->Cell(63,5,"Nome",1,0,"C",1);
$pdf->Cell(30,5,"Período",1,0,"C",1);
$pdf->Cell(20,5,"Percentual",1,0,"C",1);
$pdf->Cell(20,5,"Inclusão",1,0,"C",1);
$pdf->Cell(20,5,"Tipo",1,0,"C",1);
$pdf->Cell(24,5,"Usuário",1,1,"C",1);

for($i=0;$i<$num;$i++) {

   db_fieldsmemory($result,$i);

   $pdf->SetFont('Arial','',7);

   $pdf->cell(15,6,$q148_inscr,0,0,"C",0);
   $pdf->cell(63,6,$z01_nome,0,0,"L",0);

   $pdf->cell(30,6,db_formatar($q148_dtini,'d') .' à '.db_formatar($q148_dtfim,'d'),0,0,"C",0);

   $pdf->cell(20,6,trim(db_formatar($q148_perc,'f')),0,0,"C",0);
   $pdf->cell(20,6,db_formatar($q148_dtinc,'d'),0,0,"C",0);
   $pdf->cell(20,6,$q147_descr,0,0,"C",0);
   $pdf->cell(24,6,$login,0,1,"C",0);
}

$pdf->Ln(5);
$pdf->Cell(100,6,"Total de Registros: ".$num ,"T",0,"L",0);
$pdf->Cell(90,6,'',"T",1,"R",0);

$pdf->Output();


