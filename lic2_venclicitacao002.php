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

$head2 = "Vencedores da Licitação";
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
  
  if ($l20_licsituacao == 3) {
    $oInfoLog = $oLicitacao->getInfoLog();
  }
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
    
      $sSql = "select
                 liclicitem.l21_ordem,
                 pcmater.pc01_codmater,
                 pcmater.pc01_descrmater,
                 pcorcamval.pc23_vlrun as pc11_vlrun,
                 pcorcamval.pc23_quant as pc11_quant,
                 pcorcamval.pc23_valor,
                 solicitem.pc11_resum,
                 matunid.m61_descr,
                 matunid.m61_usaquant,
                 solicitemunid.pc17_unid,
                 solicitemunid.pc17_quant,
                 cgm.z01_numcgm,
                 cgm.z01_nome as fornecedor
                 from liclicita
                      inner join liclicitem       on liclicita.l20_codigo           = liclicitem.l21_codliclicita
                      inner join pcorcamitemlic   on liclicitem.l21_codigo          = pcorcamitemlic.pc26_liclicitem
                      inner join pcorcamval       on pcorcamitemlic.pc26_orcamitem  = pcorcamval.pc23_orcamitem
                      inner join pcorcamforne     on pcorcamval.pc23_orcamforne     = pcorcamforne.pc21_orcamforne
                      inner join pcorcamjulg      on pcorcamitemlic.pc26_orcamitem  = pcorcamjulg.pc24_orcamitem
                                                 and pcorcamforne.pc21_orcamforne   = pcorcamjulg.pc24_orcamforne
                      inner join pcprocitem       on liclicitem.l21_codpcprocitem   = pcprocitem.pc81_codprocitem
                      inner join solicitem        on pcprocitem.pc81_solicitem      = solicitem.pc11_codigo
                      inner join solicitempcmater on solicitem.pc11_codigo          = solicitempcmater.pc16_solicitem
                      inner join pcmater          on solicitempcmater.pc16_codmater = pcmater.pc01_codmater
                      left  join solicitemunid    on solicitem.pc11_codigo          = solicitemunid.pc17_codigo
                      left  join matunid          on solicitemunid.pc17_unid        = matunid.m61_codmatunid
                      inner join cgm              on pcorcamforne.pc21_numcgm       = cgm.z01_numcgm
                 where liclicita.l20_codigo = {$l20_codigo} and pc24_pontuacao = 1 
                 order by cgm.z01_numcgm,liclicitem.l21_ordem";
      
    $result_itens = $clliclicitem->sql_record($sSql);
    //db_criatabela($result_itens);exit;
    if ($l20_licsituacao == 3) {
      $clliclicitem->numrows = count($oInfoLog->item); 
    }
    if ($clliclicitem->numrows > 0) {
    	$muda_fornecedor = '';
      for ($w = 0; $w < $clliclicitem->numrows; $w++) {

        db_fieldsmemory($result_itens,$w);
        
        if ($muda_fornecedor != $fornecedor) {
        	$troca = 1;
          if ($muda_fornecedor != '') {
            $pdf->cell(130,$alt,'Total: ','T',0,"L",0);
            $pdf->cell(20,$alt,'','T',0,"C",0);
            $pdf->cell(20,$alt,'','T',0,"C",0);
            $pdf->cell(20,$alt,db_formatar($valortot,"f"),'T',1,"C",0);
            
            $total = 0;
            $quantotal = 0; 
            $valorunitot = 0;
            $valortot = 0;
          }
        	$muda_fornecedor = $fornecedor;
        }
          
        if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ) {

          if ($pdf->gety() > $pdf->h - 30) {
            $pdf->addpage();
          }
          $pdf->setfont('arial','b',8);
          $pdf->cell(190,$alt,"",0,1,"L",0);
          $pdf->cell(190,$alt,"Fornecedor: $fornecedor",0,1,"L",0); 
          $pdf->cell(10,$alt,"Item",1,0,"C",1);
          $pdf->cell(90,$alt,'Descrição Material',1,0,"C",1);
          $pdf->cell(30,$alt,'Unidade',1,0,"C",1);
          $pdf->cell(20,$alt,'Quant.',1,0,"C",1);
          $pdf->cell(20,$alt,'Valor Unit.',1,0,"C",1);
          $pdf->cell(20,$alt,'Valor Total',1,1,"C",1);
          $troca = 0;
          $p     = 0;
        }
        $pdf->setfont('arial','',7);  		
        $pdf->cell(10,$alt,$l21_ordem,0,0,"C",$p);
        $pdf->cell(90,$alt,ucfirst(strtolower(substr($pc01_descrmater,0,70))),0,0,"L",$p);
        $pdf->cell(30,$alt,$m61_descr,0,0,"L",$p);
        $pdf->cell(20,$alt,$pc11_quant,0,0,"C",$p);
        $pdf->cell(20,$alt,db_formatar($pc11_vlrun,"f"),0,0,"C",$p);
        $pdf->cell(20,$alt,db_formatar(($pc11_quant*$pc11_vlrun),"f"),0,1,"C",$p);
       
        $total++;
        //$quantotal += $pc11_quant; 
        //$valorunitot += $pc11_vlrun;
        $valortot += $pc11_vlrun * $pc11_quant;
                
      }
      $pdf->cell(130,$alt,'Total: ','T',0,"L",0);
      $pdf->cell(20,$alt,'','T',0,"C",0);
      $pdf->cell(20,$alt,'','T',0,"C",0);
      $pdf->cell(20,$alt,db_formatar($valortot, "f"),'T',1,"C",0);
      
    }
    $total = 0;
    $quantotal = 0; 
    $valorunitot = 0;
    $valortot = 0;
  
}
$pdf->Output();
?>
