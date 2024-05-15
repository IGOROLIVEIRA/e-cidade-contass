<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_linhafrequencia_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_app.utils.php");
include("fpdf151/pdf.php");

$Total = 0;
$borda = "B"; 
$bordat = 1;
$preenc = 0;
$TPagina = 45;

$oGet            = db_utils::postMemory($_GET);

db_postmemory($HTTP_POST_VARS);

$cllinhafrequencia = new cl_linhafrequencia;

$dataini =  implode("-", array_reverse(explode("/", $dtDataInicial)));
$datafim =  implode("-", array_reverse(explode("/", $dtDataFinal)));

if($sFiltro == 1){
  $orderby = '';
  
  if($sQuebra == 2)
    $orderby = "order by 5";
  
  $rsLinhafrequencia = $cllinhafrequencia->sql_record($cllinhafrequencia->sql_query_linhas("tre06_abreviatura,tre13_linhatransporte,tre06_kmidaevolta,tre06_valorkm,tre06_numcgm,z01_nome,z01_cgccpf,count(tre13_linhatransporte) as totaldias,ROUND(sum(tre06_kmidaevolta), 2) as totalkmidaevolta,ROUND(sum(tre06_valorkm), 2) as valortotalkm","","tre13_data between '$dataini' and '$datafim' group by 1,2,3,4,5,6,7 $orderby"));

  $aLinhafrequencia = pg_fetch_all($rsLinhafrequencia);
}else{
  $orderby = 'order by 1,4';
  
  if($sQuebra == 2)
    $orderby = "order by 5,3,4";

  $rsLinhafrequencia = $cllinhafrequencia->sql_record($cllinhafrequencia->sql_query_linhas("tre06_abreviatura,tre13_linhatransporte,tre06_nome,tre13_data,tre06_numcgm,z01_nome,z01_cgccpf","","tre13_data between '$dataini' and '$datafim' $orderby"));

  $aLinhafrequencia = pg_fetch_all($rsLinhafrequencia);
}

$instits = str_replace('-', ', ', db_getsession("DB_instit"));

$aInstits = explode(",", $instits);

if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}

$head3 = "Relatório Faturamentos Das Linhas";
if($sFiltro == 2)
  $head3 = "Relatório Frequência Das Linhas";
$head4 = "Tipo: Faturamento";
if($sFiltro == 2)
    $head4 = "Tipo: Frequência";
$head5 = "Exercício: ".db_getsession("DB_anousu");
$head6 = "Período: ".$dtDataInicial . " á " .$dtDataFinal;
$pdf = new PDF(); // abre a classe
$pdf->Open(); // abre o relatorio
$pdf->AliasNbPages(); // gera alias para as paginas
$pdf->SetFont('Courier','',7);
$pdf->SetTextColor(0,0,0);
$pdf->setfillcolor(235);

$linha = 0;
$TPagina = 27;
$preenc = 0;
$iCont = 0;
$totalkmperco = 0;
$totalvalor = 0;
$totalkmpercocredor = 0;
$totalvalorcredor = 0;
$numcgm = 0;
if($sFiltro == 1){
  
        if($pdf->gety() > $pdf->h - 30 || $linha == 0){
            $preenc = 1;
                $linha = 1;
                $pdf->AddPage();
                $pdf->SetY(38);
                $pdf->SetFont('Arial','B',8);
                $pdf->SetFont('Arial','B',7);
                $pdf->Cell(32,5,"LINHA",$bordat,0,"C",$preenc);
                $pdf->Cell(32,5,"KM POR DIA",$bordat,0,"C",$preenc);
                $pdf->Cell(32,5,"VALOR DO KM ",$bordat,0,"C",$preenc);
                $pdf->Cell(32,5,"QUANTIDADE DE DIAS",$bordat,0,"C",$preenc);
                $pdf->Cell(32,5,"TOTAL KM PERCORRIDO ",$bordat,0,"C",$preenc);
                $pdf->Cell(32,5,"VALOR TOTAL",$bordat,1,"C",$preenc);
                $pdf->SetFont('Courier','B',7);
                $pdf->SetTextColor(0,0,0);
        }

        
            if ( $preenc == 0 ) {
            $preenc = 1; 
            
            } else {
            $preenc = 0;
            }
            
            
            for ($cont = 0; $cont < count($aLinhafrequencia); $cont++) {
                
                $oLinhas      = db_utils::FieldsMemory($rsLinhafrequencia, $cont);  

                if($sQuebra == 2 && $numcgm != '' && ($oLinhas->tre06_numcgm == ''  || $oLinhas->tre06_numcgm == null)){
                  if($cont != 0 ){
                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(128,5,"Total Credor",$bordat,0,"C",$preenc);
                    $pdf->Cell(32,5,db_formatar($totalkmpercocredor,"f"),1,0,"C",$preenc);
                    $pdf->Cell(32,5,"R$".db_formatar($totalvalorcredor,"f"),1,1,"C",$preenc);  
                    $totalkmpercocredor = 0;
                    $totalvalorcredor = 0;
                  }
                  $pdf->SetFont('Arial','B',7);
                  $pdf->Cell(192,5,"SEM CREDOR",$bordat,1,"L",$preenc);
                  $numaux = 1;
                }

                if($sQuebra == 2 && $numcgm != $oLinhas->tre06_numcgm && $numaux != 1){
                  if($cont != 0){
                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(128,5,"Total Credor",$bordat,0,"C",$preenc);
                    $pdf->Cell(32,5,db_formatar($totalkmpercocredor,"f"),1,0,"C",$preenc);
                    $pdf->Cell(32,5,"R$".db_formatar($totalvalorcredor,"f"),1,1,"C",$preenc);
                    $totalkmpercocredor = 0;
                    $totalvalorcredor = 0;  
                  }
                  $pdf->SetFont('Arial','B',7);
                  $pdf->Cell(192,5,"CGM : ".$oLinhas->tre06_numcgm." - ".$oLinhas->z01_nome." - ".db_formatar($oLinhas->z01_cgccpf,"cnpj"),$bordat,1,"L",$preenc);
                  
                }

                $pdf->SetFont('Courier','',7);
                $pdf->Cell(32,5,$oLinhas->tre06_abreviatura,1,0,"C",$preenc);
                $pdf->Cell(32,5,$oLinhas->tre06_kmidaevolta,1,0,"C",$preenc);
                $pdf->Cell(32,5,"R$".db_formatar($oLinhas->tre06_valorkm,"f"),1,0,"C",$preenc);
                $pdf->Cell(32,5,$oLinhas->totaldias ,1,0,"C",$preenc);
                $pdf->Cell(32,5,db_formatar($oLinhas->totalkmidaevolta,"f"),1,0,"C",$preenc);
                $pdf->Cell(32,5,"R$".db_formatar($oLinhas->tre06_valorkm * $oLinhas->totalkmidaevolta,"f"),1,1,"C",$preenc);
                $totalkmpercocredor += $oLinhas->totalkmidaevolta;
                $totalvalorcredor += $oLinhas->tre06_valorkm * $oLinhas->totalkmidaevolta;  
                $totalkmperco += $oLinhas->totalkmidaevolta;
                $totalvalor += $oLinhas->tre06_valorkm * $oLinhas->totalkmidaevolta;
                if($iCont == 40){
                  $preenc = 1;
                  $linha = 1;
                  $pdf->AddPage();
                  $pdf->SetY(38);
                  $pdf->SetFont('Arial','B',8);
                  $pdf->SetFont('Arial','B',7);
                  $pdf->Cell(32,5,"LINHA",$bordat,0,"C",$preenc);
                  $pdf->Cell(32,5,"KM POR DIA",$bordat,0,"C",$preenc);
                  $pdf->Cell(32,5,"VALOR DO KM ",$bordat,0,"C",$preenc);
                  $pdf->Cell(32,5,"QUANTIDADE DE DIAS",$bordat,0,"C",$preenc);
                  $pdf->Cell(32,5,"TOTAL KM PERCORRIDO ",$bordat,0,"C",$preenc);
                  $pdf->Cell(32,5,"VALOR TOTAL",$bordat,1,"C",$preenc);
                  $pdf->SetFont('Courier','B',7);
                  $pdf->SetTextColor(0,0,0);
                    $iCont = 0;
                    if ( $preenc == 0 ) {
                        $preenc = 1; 
                        
                        } else {
                        $preenc = 0;
                        }
                }
                if($cont + 1 == count($aLinhafrequencia)){
                  if($sQuebra == 2){
                    $pdf->SetFont('Arial','B',7);
                    $pdf->Cell(128,5,"Total Credor",$bordat,0,"C",$preenc);
                    $pdf->Cell(32,5,db_formatar($totalkmpercocredor,"f"),1,0,"C",$preenc);
                    $pdf->Cell(32,5,"R$".db_formatar($totalvalorcredor,"f"),1,1,"C",$preenc); 
                  }
                                   
                  $pdf->SetFont('Arial','B',7);
                  $pdf->Cell(128,5,"Total",$bordat,0,"C",$preenc);
                  $pdf->Cell(32,5,db_formatar($totalkmperco,"f"),1,0,"C",$preenc);
                  $pdf->Cell(32,5,"R$".db_formatar($totalvalor,"f"),1,1,"C",$preenc);  
                }
                $iCont++;
                $numcgm = $oLinhas->tre06_numcgm;
            }

    }else{
      if($sQuebra == 2){
        if($pdf->gety() > $pdf->h - 30 || $linha == 0){
          $preenc = 1;
              $linha = 1;
              $pdf->AddPage();
              $pdf->SetY(38);
              $pdf->SetFont('Arial','B',8);
              $pdf->SetFont('Arial','B',7);
              $pdf->Cell(195,5,"FREQUÊNCIA DAS LINHAS",$bordat,1,"C",$preenc);
              $pdf->SetFont('Courier','B',7);
              $pdf->SetTextColor(0,0,0);
         }
          if ( $preenc == 0 ) {
          $preenc = 1; 
          
          } else {
          $preenc = 0;
          }
          $iCont = 0;
          $condição = 0;
          $condição2 = 0;
          $contDia = 0;
          $numaux = 0;
          for ($cont = 0; $cont < count($aLinhafrequencia); $cont++) {
              
              $oLinhas      = db_utils::FieldsMemory($rsLinhafrequencia, $cont);  
              
              if($oLinhas->tre06_numcgm  != ''  and $oLinhas->tre06_numcgm != $condição || $condição == 0){
                $contDia = 0;
                $pdf->SetFont('Courier','B',8);
                $pdf->Cell(195,5,"Credor  -  CGM : ".$oLinhas->tre06_numcgm." - ".$oLinhas->z01_nome." - ".db_formatar($oLinhas->z01_cgccpf,"cnpj"),1,1,"L",$preenc);
                
                $numaux = 0;
              }
              if(($oLinhas->tre06_numcgm == '' || $oLinhas->tre06_numcgm == null) && $numaux != 1){
                $contDia = 0;
                $pdf->SetFont('Courier','B',8);
                $pdf->Cell(195,5,"SEM CREDOR: ",1,1,"L",$preenc);
                
                $numaux = 1;
              }

              if($oLinhas->tre13_linhatransporte != $condição2 || $condição2 == 0){
                $contDia = 0;
                $pdf->SetFont('Courier','B',8);
                $pdf->Cell(195,5,$oLinhas->tre06_abreviatura."/".substr($oLinhas->tre06_nome,0,100),1,1,"L",$preenc);
              }
             
              // if($oLinhas->tre13_linhatransporte != $condição2 && ($oLinhas->tre06_numcgm == '' || $oLinhas->tre06_numcgm == null)){
              //   $contDia = 0;
              //   $pdf->SetFont('Courier','B',8);
              //   $pdf->Cell(195,5,"SEM CREDOR: ",1,1,"L",$preenc);
              //   $pdf->Cell(195,5,$oLinhas->tre06_abreviatura."/".substr($oLinhas->tre06_nome,0,100),1,1,"L",$preenc);
              //   $numaux = 1;
              // }
              
              $contDia ++;
              $pdf->SetFont('Courier','I',8);
              $pdf->Cell(195,5,$contDia."º Dia - ".db_formatar($oLinhas->tre13_data,"d"),$bordat,1,"L",$preenc);
               
              $condição = $oLinhas->tre06_numcgm;
              $condição2 = $oLinhas->tre13_linhatransporte; 
             
              if($iCont == 38){
                // echo $iCont." == ".$decremento;exit;
                  $linha = 1;
                  $pdf->AddPage();
                  $pdf->SetY(38);
                  $pdf->SetFont('Arial','B',8);
                  $pdf->SetFont('Arial','B',7);
                  $pdf->Cell(195,5,"FREQUÊNCIA DAS LINHAS",$bordat,1,"C",1);
                  $pdf->SetFont('Courier','B',7);
                  $pdf->SetTextColor(0,0,0);
                  $iCont = 0;
              }
              $iCont++;
          }

      }else{
      if($pdf->gety() > $pdf->h - 30 || $linha == 0){
        $preenc = 1;
            $linha = 1;
            $pdf->AddPage();
            $pdf->SetY(38);
            $pdf->SetFont('Arial','B',8);
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(195,5,"FREQUÊNCIA DAS LINHAS",$bordat,1,"C",$preenc);
            $pdf->SetFont('Courier','B',7);
            $pdf->SetTextColor(0,0,0);
       }
        if ( $preenc == 0 ) {
        $preenc = 1; 
        
        } else {
        $preenc = 0;
        }
        $iCont = 0;
        $condição = 0;
        $contDia = 0;
        for ($cont = 0; $cont < count($aLinhafrequencia); $cont++) {
            
            $oLinhas      = db_utils::FieldsMemory($rsLinhafrequencia, $cont);  
            
            if($oLinhas->tre13_linhatransporte != $condição || $condição == 0){
              $contDia = 0;
              $pdf->SetFont('Courier','B',8);
              $pdf->Cell(195,5,$oLinhas->tre06_abreviatura."/".substr($oLinhas->tre06_nome,0,100),1,1,"L",$preenc);
            }
            $contDia ++;
            $pdf->SetFont('Courier','I',8);
            $pdf->Cell(195,5,$contDia."º Dia - ".db_formatar($oLinhas->tre13_data,"d"),$bordat,1,"L",$preenc);
             
            $condição = $oLinhas->tre13_linhatransporte;
             
            if($iCont == 40){
                $linha = 1;
                $pdf->AddPage();
                $pdf->SetY(38);
                $pdf->SetFont('Arial','B',8);
                $pdf->SetFont('Arial','B',7);
                $pdf->Cell(195,5,"FREQUÊNCIA DAS LINHAS",$bordat,1,"C",1);
                $pdf->SetFont('Courier','B',7);
                $pdf->SetTextColor(0,0,0);
                $iCont = 0;
            }
            $iCont++;
        }

    }
  }

   $pdf->Output();
   ?>