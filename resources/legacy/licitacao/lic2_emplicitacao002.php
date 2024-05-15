<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("model/licitacao.model.php");

$clliclicita         = new cl_liclicita;
$clliclicitasituacao = new cl_liclicitasituacao;
$clliclicitem        = new cl_liclicitem;
$clempautitem        = new cl_empautitem;
$clpcorcamjulg       = new cl_pcorcamjulg;
$clpcprocitem       = new cl_pcprocitem;
$clrotulo            = new rotulocampo;

$clrotulo->label('');
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);
$sWhere = "";
$sAnd   = "";
if (($data != "--") && ($data1 != "--")) {

  $sWhere .= $sAnd." l20_datacria  between '$data' and '$data1' ";
  $data = db_formatar($data, "d");
  $data1 = db_formatar($data1, "d");
  $info = "De $data até $data1.";
  $sAnd = " and ";
} else if ($data != "--") {

  $sWhere .= $sAnd." l20_datacria >= '$data'  ";
  $data = db_formatar($data, "d");
  $info = "Apartir de $data.";
  $sAnd = " and ";
} else if ($data1 != "--") {

  $sWhere .= $sAnd." l20_datacria <= '$data1'   ";
  $data1 = db_formatar($data1, "d");
  $info = "Até $data1.";
  $sAnd = " and ";
}
if ($l20_codigo != "") {

  $sWhere .= $sAnd." l20_codigo=$l20_codigo ";
  $sAnd = " and ";
}
if ($l20_numero!="") {

  $sWhere .= $sAnd." l20_numero=$l20_numero ";
  $sAnd = " and ";
  $info1 = "Numero:".$l20_numero;
}
if ($l03_codigo != "") {

  $sWhere .= $sAnd." l20_codtipocom=$l03_codigo ";
  $sAnd = " and ";
  if ($l03_descr!="") {
    $info2 = "Modalidade:".$l03_codigo."-".$l03_descr;
  }
}

$sWhere        .= $sAnd." l20_licsituacao = 10 and l20_instit = ".db_getsession("DB_instit");
$sSqlLicLicita  = $clliclicita->sql_query(null,"*","l20_codtipocom,l20_numero,l20_anousu",$sWhere);
$result         = $clliclicita->sql_record($sSqlLicLicita);
$numrows        = $clliclicita->numrows;

if ($numrows == 0) {

  db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
  exit;
}

$head2 = "Empenhos da Licitação";
$head3 = @$info;
$head4 = @$info1;
$head5 = @$info2;
$pdf   = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca       = 1;
$alt         = 4;
$total       = 0;
$p           = 0;
$valortot    = 0;
$muda        = 0;
$mostraAndam = $mostramov;
$oInfoLog    = array();
for ($i = 0; $i < $numrows; $i++) {

  db_fieldsmemory($result,$i);
  
  if ($mostra == 'n') {

    if ($pdf->gety() > $pdf->h - 30 || $muda == 0) {

      $pdf->addpage();
      $muda = 1;
    }
  } else {
    $pdf->addpage();
  }
  $pdf->setfont('arial','b',8);
  $pdf->cell(30,$alt,'Código Sequencial:',0,0,"R",0);
  $pdf->setfont('arial','',7);
  $pdf->cell(60,$alt,$l20_codigo,0,1,"L",0);

  $pdf->setfont('arial','b',8);
  $pdf->cell(30,$alt,'Processo :',0,0,"R",0);
  $pdf->setfont('arial','',7);
  $pdf->cell(30,$alt,$l20_edital,0,0,"L",0);


  $pdf->setfont('arial','b',8);
  $pdf->cell(30,$alt,'Modalidade :',0,0,"R",0);
  $pdf->setfont('arial','',7);
  $pdf->cell(60,$alt,$l20_codtipocom.' - '.$l03_descr,0,1,"L",0);

  $pdf->setfont('arial','b',8); 
  $pdf->cell(30,$alt,'Data Abertura :',0,0,"R",0); 
  $pdf->setfont('arial','',7);
  $pdf->cell(30,$alt,db_formatar($l20_dataaber,'d'),0,0,"L",0);
  
  $pdf->setfont('arial','b',8);
  $pdf->cell(30,$alt,'Número :',0,0,"R",0);
  $pdf->setfont('arial','',7);
  $pdf->cell(30,$alt,$l20_numero,0,1,"L",0);

  $pdf->setfont('arial','b',8);
  $pdf->cell(30,$alt,'Objeto :',0,0,"R",0);
  $pdf->setfont('arial','b',8);
  $pdf->multicell(150,$alt,$l20_objeto,0,"L",0);

  $pdf->cell(190,$alt,'','T',1,"L",0); 

    $troca        = 1;
    
    $sCampos = "distinct pc10_numero";
    $sOrder  = "pc10_numero";
    $sWhere  = "l20_codigo = {$l20_codigo} and pc24_pontuacao = 1 and pc10_instit = ".db_getsession("DB_instit");

    $sSqlPcOrcamJulg = $clpcorcamjulg->sql_query_gerautlic(null, null, $sCampos, $sOrder, $sWhere);
    $rsPcOrcamJulg   = db_query($sSqlPcOrcamJulg);
    $aPcOrcamJulg = array();
    for ($j = 0; $j < pg_num_rows($rsPcOrcamJulg); $j++) {
    	$aPcOrcamJulg[] = db_utils::fieldsMemory($rsPcOrcamJulg, $j)->pc10_numero;
    }
    $sPcOrcamJulg = implode(",", $aPcOrcamJulg);
    $campos  = " pc10_numero::varchar,e54_autori,";
    $campos .= " case when e60_codemp is not null then e60_codemp || '/' || e60_anousu else 'Sem empenho' end as e60_codemp,";
    $campos .= " e60_vlremp,z01_nome";
    $sSqlEmpSolicita  = $clpcprocitem->sql_query_pcmater(null,$campos,null,"pc10_numero in ($sPcOrcamJulg)");
    $sSqlEmpSolicita .= " UNION
    SELECT 'Sem solicitação' AS pc10_numero,e54_autori,
                                            CASE
                                                WHEN e60_codemp IS NOT NULL THEN e60_codemp || '/' || e60_anousu
                                                ELSE 'Sem empenho'
                                            END AS e60_codemp, e60_vlremp,
                                                                   z01_nome
    FROM liclicita
		LEFT JOIN empautoriza ON empautoriza.e54_numerl = liclicita.l20_numero::varchar
		AND empautoriza.e54_anousu = liclicita.l20_anousu
		AND
		  (SELECT pc50_pctipocompratribunal
		   FROM pctipocompra
		   WHERE pctipocompra.pc50_codcom = empautoriza.e54_codcom LIMIT 1) =
		  (SELECT pc50_pctipocompratribunal
		   FROM pctipocompra
		   JOIN cflicita ON cflicita.l03_codcom = pctipocompra.pc50_codcom
		   WHERE cflicita.l03_codigo = liclicita.l20_codtipocom LIMIT 1)
		LEFT JOIN cgm ON empautoriza.e54_numcgm = cgm.z01_numcgm
		LEFT JOIN empempaut ON empempaut.e61_autori = empautoriza.e54_autori
		LEFT JOIN empempenho ON empempenho.e60_numemp = empempaut.e61_numemp
		WHERE liclicita.l20_codigo = $l20_codigo ORDER BY z01_nome,pc10_numero,e60_codemp ";
    $result_processos = $clpcprocitem->sql_record($sSqlEmpSolicita);
    
    if (pg_num_rows($result_processos) > 0) {
    	
      for ($w = 0; $w < pg_num_rows($result_processos); $w++) {

        db_fieldsmemory($result_processos,$w);
          
        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {

          if ($pdf->gety() > $pdf->h - 30) {
            $pdf->addpage();
          }
          $pdf->setfont('arial','b',8); 
          $pdf->cell(20,$alt,"Solicitação",1,0,"C",1);
          $pdf->cell(20,$alt,'Autorização',1,0,"C",1);
          $pdf->cell(100,$alt,'Fornecedor',1,0,"C",1);
          $pdf->cell(20,$alt,'Empenho',1,0,"C",1);
          $pdf->cell(30,$alt,'Vl. Empenho',1,1,"C",1);
          $p     = 0;
          $troca = 0;
        }
        $pdf->setfont('arial','',7);  		
        $pdf->cell(20,$alt,$pc10_numero,1,0,"C",$p);
        $pdf->cell(20,$alt,$e54_autori,1,0,"C",$p);
        $pdf->cell(100,$alt,$z01_nome,1,0,"L",$p);
        $pdf->cell(20,$alt,$e60_codemp,1,0,"C",$p);
        $pdf->cell(30,$alt,db_formatar($e60_vlremp,"f"),1,1,"C",$p);

                
      }
      
    }
  
}
$pdf->Output();
?>
