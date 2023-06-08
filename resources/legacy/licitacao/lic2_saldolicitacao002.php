<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("model/licitacao.model.php");

$clliclicita         = new cl_liclicita;
$clliclicitasituacao = new cl_liclicitasituacao;
$clliclicitem        = new cl_liclicitem;
$clempautitem        = new cl_empautitem;
$clpcorcamjulg       = new cl_pcorcamjulg;
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

$head2 = "Saldo da Licitação";
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
  
  if (empty($l20_procadmin)) {
  
    $oDAOLiclicitaproc    = db_utils::getDao("liclicitaproc");
    $sSqlProcessoSistema  = $oDAOLiclicitaproc->sql_query(null,"*", null, "l34_liclicita = {$l20_codigo}");
    $rsProcessoSistema    = $oDAOLiclicitaproc->sql_record($sSqlProcessoSistema);
    
    if ($oDAOLiclicitaproc->numrows == 1) {
  
      $oLiclicitaproc = db_utils::fieldsMemory($rsProcessoSistema, 0);
      $l20_procadmin  = substr($oLiclicitaproc->p58_numero ."/". $oLiclicitaproc->p58_ano . " - " . $oLiclicitaproc->p51_descr , 0, 120);
    }
  }
  
  $oLicitacao = new licitacao($l20_codigo);
  /**
   * itens da autorização para pegar fornecedor e saldo dos itens
   */
  $aItensAutoriza = $oLicitacao->getItensParaAutorizacao();
  
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
  
  $result_sec=$clliclicitem->sql_record($clliclicitem->sql_query_orc(null,"distinct o40_descr",null,"l21_codliclicita = $l20_codigo"));

  $pdf->cell(190,$alt,'','T',1,"L",0); 
  $result_dataaut=$clempautitem->sql_record($clempautitem->sql_query_lic(null,null,"distinct e54_emiss,e54_autori","e54_autori","l20_codigo=$l20_codigo"));  

  $result_orcam     = $clpcorcamjulg->sql_record($clpcorcamjulg->sql_query_gerautlic(null, null, "distinct z01_numcgm,z01_nome,pcorcam.pc20_dtate,pcorcam.pc20_hrate", "z01_nome", "l20_codigo=$l20_codigo and pc24_pontuacao=1 and pc10_instit=".db_getsession("DB_instit")));
  $numrows_orcam    = $clpcorcamjulg->numrows;  	
  $result_valorcam  = $clpcorcamjulg->sql_record($clpcorcamjulg->sql_query_gerautlic(null, null, "sum(pc23_valor)as valor_adj", "", "l20_codigo=$l20_codigo and pc24_pontuacao=1 and pc10_instit=".db_getsession("DB_instit")));
  $numrows_valorcam = $clpcorcamjulg->numrows;
  
    $troca        = 1;
    $campos = "distinct l21_ordem,l21_codigo,pc11_numero,pc11_codigo,pc11_quant,pc11_seq, pc11_vlrun, 
    pc11_resum,pc01_codmater,pc01_descrmater,pc01_servico,pc17_unid,pc17_quant,m61_descr,m61_usaquant,z01_nome";
    $sSql = $clliclicitem->sql_query_inf(null,$campos,"z01_nome,l21_ordem","l21_codliclicita=$l20_codigo and pc21_orcamforne = pc24_orcamforne");
    
    $result_itens = $clliclicitem->sql_record($sSql);
  
    $fornecedor       = db_utils::fieldsMemory($result_itens, 0)->z01_nome;
    $quant_autorizado = 0;
    $saldo_atual      = 0;
    $dotacao          = 0;
    for ($w = 0; $w < $clliclicitem->numrows; $w++) {

      db_fieldsmemory($result_itens,$w);
        
      if ($pdf->gety() > $pdf->h - 30 || $troca != 0 || $fornecedor != $z01_nome) {

        if ($pdf->gety() > $pdf->h - 30) {
          $pdf->addpage();
        } else {
        	$pdf->Ln();
        }
        
        $pdf->setfont('arial','b',8);
        $pdf->cell(190,$alt,$z01_nome,1,1,"L",1);
        
        $pdf->cell(10,$alt,"Item",1,0,"C",1);
        $pdf->cell(135,$alt,'Descrição Material',1,0,"C",1);
        $pdf->cell(15,$alt,'Qtd.Total',1,0,"C",1);
        $pdf->cell(15,$alt,'Qtd.Autori',1,0,"C",1);
        $pdf->cell(15,$alt,'Saldo',1,1,"C",1);
        $p     = 0; 
        $troca = 0;
        
        $fornecedor       = $z01_nome;
      }
      
      $quant_autorizado = 0;
      $saldo_atual      = 0;
      foreach ($aItensAutoriza as $oItensAutoriza) {

        if ($oItensAutoriza->l21_ordem == $l21_ordem) {
          $quant_autorizado += $oItensAutoriza->quantidadeautorizada;
          $saldo_atual      += $oItensAutoriza->saldoquantidade;
        }
      }
      
      
      $pdf->setfont('arial','',7);  		
      $pdf->cell(10,$alt,$l21_ordem,1,0,"C",$p);
      $pdf->cell(135,$alt,ucfirst(strtolower(substr($pc01_descrmater,0,100))),1,0,"L",$p);
      $pdf->cell(15,$alt,$pc11_quant,1,0,"C",$p);
      $pdf->cell(15,$alt,($quant_autorizado == 0 ? '0' : $quant_autorizado),1,0,"C",$p);
      $pdf->cell(15,$alt,($saldo_atual == 0 ? '0' : $saldo_atual),1,1,"C",$p);
       
      $total++;
      $valortot += $pc11_vlrun * $pc11_quant;
    }
    $pdf->cell(190,$alt,'Total de Registros: '.$total,'T',1,"R",0);
//echo "<pre>";print_r($aItensAutoriza);exit;
    $aDotacao = array();
    foreach ($aItensAutoriza as $oItensAutoriza) {

      if (!$oItensAutoriza->servico || ($oItensAutoriza->servico && $oItensAutoriza->servicoquantidade == "t")) {
          $nValorTotal  = $oItensAutoriza->saldoquantidade * $oItensAutoriza->valorunitariofornecedor;
      } else {
        	$nValorTotal  = $oItensAutoriza->saldovalor;
      }
        
      if (!isset($aDotacao[$oItensAutoriza->codigodotacao])) {
      	$oDotacao   = new stdClass();
        $oDotacao->codigoDotacao = $oItensAutoriza->codigodotacao;
        $oDotacao->valorDotacao  = $oItensAutoriza->quantidadeautorizada*$oItensAutoriza->valorunitariofornecedor;
        $oDotacao->totalDotacao  = $nValorTotal;//$oItensAutoriza->quanttotalitem*$oItensAutoriza->valorunitariofornecedor;
        $aDotacao[$oItensAutoriza->codigodotacao] = $oDotacao;
      } else {
      	$aDotacao[$oItensAutoriza->codigodotacao]->valorDotacao += $oItensAutoriza->quantidadeautorizada*$oItensAutoriza->valorunitariofornecedor;
      	$aDotacao[$oItensAutoriza->codigodotacao]->totalDotacao += $nValorTotal;//$oItensAutoriza->quanttotalitem*$oItensAutoriza->valorunitariofornecedor;
      }
    }
    
    $troca = 1;
    $pdf->Ln();
    $total = 0;
    foreach ($aDotacao as $oDotacao) {
        
      if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ) {

        if ($pdf->gety() > $pdf->h - 30) {
          $pdf->addpage();
        } 
        
        $pdf->setfont('arial','b',8);        
        $pdf->cell(30,$alt,"Dotação",1,0,"C",1);
        $pdf->cell(30,$alt,'Valor Total',1,0,"C",1);
        $pdf->cell(30,$alt,'Valor Gasto',1,0,"C",1);
        $pdf->cell(30,$alt,'Saldo',1,1,"C",1);
        $p     = 0; 
        $troca = 0;
        
      }
      
      $pdf->setfont('arial','',7);  		
      $pdf->cell(30,$alt,$oDotacao->codigoDotacao,1,0,"C",$p);
      $pdf->cell(30,$alt,"R$ ".db_formatar($oDotacao->totalDotacao,'f'),1,0,"L",$p);
      $pdf->cell(30,$alt,"R$ ".db_formatar($oDotacao->valorDotacao,'f'),1,0,"C",$p);
      $pdf->cell(30,$alt,"R$ ".db_formatar($oDotacao->totalDotacao-$oDotacao->valorDotacao,'f'),1,1,"C",$p);
       
      $total++;
    }
    
    $total = 0;
    $troca = 1;
  
}
$pdf->Output();
?>
