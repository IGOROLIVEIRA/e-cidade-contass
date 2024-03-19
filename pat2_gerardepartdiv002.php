<?

include ("fpdf151/pdf.php");
include ("libs/db_sql.php");
include ("classes/db_matestoque_classe.php");
include ("classes/db_matestoqueitem_classe.php");
include ("classes/db_db_almox_classe.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);

$clmatestoque     = new cl_matestoque;
$clmatestoqueitem = new cl_matestoqueitem;
$cldb_almox       = new cl_db_almox;

$clrotulo = new rotulocampo;
$clrotulo->label('m60_descr');
$clrotulo->label('descrdepto');


$txt_where = "";
$dbwhere = "";
$info = "";
$txt_where_atend = "1=1";



if ($listadepart != "") {
		$txt_where_atend  .= " and coddepto  in ($listadepart)";
} 


$head3 = "Relatório de Departamento/Divisão";
$head4 = "";
$head5 = "$info";
$head7 = "$info_listar_serv";

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca =  1;
$tam   = 200;
$alt   =  4;
$borda =  0;
$total =  0;
$p     =  0;
$valor_depto = 0;
$total_depto = 0;
$quant_depto = 0;
$valor_usu   = 0;
$total_usu   = 0;
$quant_usu   = 0;
$q_est       = 0;
$v_est       = 0;
$depto_ant   = "";
$usua_ant    = "";
$imp=0;

$sql1 = "
SELECT descrdepto as departament,nomeresponsavel as responsaveldiv, coddepto
FROM db_depart
WHERE {$txt_where_atend} {$txt_where}
AND limite is null 
ORDER BY descrdepto ASC
";
// LEFT JOIN cgm on numcgm = z01_numcgm
// echo $sql1;exit;
$res1 = @pg_query($sql1);
$numrows_1   = @pg_numrows($res1);

for ($x1 = 0; $x1 < $numrows_1; $x1++) {
  db_fieldsmemory($res1, $x1);

  $pdf->SetX("10");
  if ($pdf->gety() > $pdf->h - 30 || $troca != 0 || $imp==1) {
    if ($imp==0) {
         $pdf->addpage('L');
         $imp=1;
    }

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(140, $alt, 'Departamento', 1, 0, "C", 1);
    $pdf->cell(140, $alt,'Responsável', 1, 1, "C", 1);

    $pdf->setfont('arial', 'b', 6);
    $pdf->cell(140, $alt,$departament, $borda, 0, "L", $p);
    $pdf->cell(140, $alt,$responsaveldiv, $borda, 1, "L", $p); 


    $sql2 = "
    SELECT
    t30_descr as divisao, z01_nome as responsaveldiv
    FROM departdiv 
    LEFT JOIN cgm on cgm.z01_numcgm = departdiv.t30_numcgm
    WHERE departdiv.t30_depto = {$coddepto}
    ";
    
    // print_r( $sql2);die();
    $res2 = @pg_query($sql2);
    $numrows_2   = @pg_numrows($res2);

    if($numrows_2 > 0){
      $pdf->SetX("30");
      $pdf->setfont('arial', 'b', 7);
      $pdf->cell(120, $alt, 'Divisões', 1, 0, "C", 1);
      $pdf->cell(140, $alt, 'Responsável', 1, 1, "C", 1);

      for ($x2 = 0; $x2 < $numrows_2; $x2++) {
      	db_fieldsmemory($res2, $x2);
        $pdf->SetX("30");
      	$pdf->setfont('arial', '', 6);
      	$pdf->cell(120, $alt,$divisao, $borda, 0, "L", $p);
      	$pdf->cell(140, $alt,$responsaveldiv, $borda, 1, "L", $p);

      }

    }

  }

}

if ($numrows_1 == 0) {
    // echo $numrows_atend . " " . $numrows_manual; exit;
     if ($numrows_manual > 0) {
          // NDA
     } else {
          db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros  cadastrados.');
     }	  
}

// die('Stoping');
$pdf->Output();
