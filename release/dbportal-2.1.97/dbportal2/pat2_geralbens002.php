<?
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("classes/db_bens_classe.php");
include("classes/db_bensbaix_classe.php");
include("classes/db_cfpatriplaca_classe.php");

$clbens         = new cl_bens;
$clbensbaix     = new cl_bensbaix;
$clcfpatriplaca = new cl_cfpatriplaca;

$clbens->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label('z01_nome');
$clrotulo->label('descrdepto');
$clrotulo->label('t64_descr');
$clrotulo->label('t64_class');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

$res_cfpatriplaca = $clcfpatriplaca->sql_record($clcfpatriplaca->sql_query_file(db_getsession("DB_instit")));
if ($clcfpatriplaca->numrows > 0){
  db_fieldsmemory($res_cfpatriplaca,0);
} else {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Parâmetros de Placa para esta instituição.');
  exit;
}

$where_instit = "";
$ordem        = "";
$info         = "Ordenado por ";
if ($ordenar == "depart"){
  $ordem = "t52_depart";
  $info  .= "Departamento";
}else if ($ordenar == "placa"){
  if($t07_confplaca==1 or $t07_confplaca==4) {
    $ordem = "cast(coalesce(nullif(t52_ident,''),'0') as numeric)";
  } else {
    $ordem = "t52_ident";
  }
  $info  .= "Placa";
}else if ($ordenar == "bem"){
  $ordem = "t52_bem";
  $info  .= "Bem";
}else if ($ordenar == "classi"){
  $ordem = "t64_class";
  $info  .= "Classificação";
}else if ($ordenar == "data"){
  $ordem = "t52_dtaqu";
  $info  .= "Data de Aquisição";

}
if (isset($coddepart) and $coddepart!=0){
  $where_instit.="t52_depart=$coddepart and ";
}


$flag_datas = 0;
if (isset($data_inicial) && trim(@$data_inicial) != "" && isset($data_final) && trim(@$data_final) != ""){
  $flag_datas = 1;
} else if (isset($data_inicial) && trim(@$data_inicial) != ""){
  $flag_datas = 2;
} else if (isset($data_final) && trim(@$data_final) != ""){
  $flag_datas = 3;
}

if ($flag_datas == 1){
  $where_instit.= "t52_dtaqu between '$data_inicial' and '$data_final' and ";
  $info        .= "\nPeriodo de ".db_formatar($data_inicial,"d")." a ".db_formatar($data_final,"d");
}

if ($flag_datas == 2){
  $where_instit.= "t52_dtaqu >= '$data_inicial' and ";
  $info        .= "\nAquisição a partir de ".db_formatar($data_inicial,"d");
}

if ($flag_datas == 3){
  $where_instit.= "t52_dtaqu <= '$data_final' and ";
  $info        .= "\nAquisição até ".db_formatar($data_final,"d");
}


$flag_forn   = false;
$flag_classi = false;

if ($imp_forn == "S"){
  $flag_forn = true;
}

if ($imp_classi == "S"){
  $flag_classi = true;
}


$head3  = "RELATÓRIO GERAL DE BENS";
$head4  = $info;

$where_instit .= "t52_instit = ".db_getsession("DB_instit");

if($t07_confplaca==1 or $t07_confplaca==4) {
  $campos = "t52_bem, t52_descr, t52_valaqu, t52_dtaqu, cast(coalesce(nullif(t52_ident,''),'0') as numeric) as t52_ident, t52_depart, descrdepto, t52_numcgm, z01_nome, t52_obs, t64_class, t64_descr"; 
} else {
  $campos = "t52_bem, t52_descr, t52_valaqu, t52_dtaqu, t52_ident, t52_depart, descrdepto, t52_numcgm, z01_nome, t52_obs, t64_class, t64_descr"; 
}
$campos = "distinct ".$campos;

$sqlrelatorio = $clbens->sql_query(null,"$campos",$ordem,"$where_instit");

$result = $clbens->sql_record($sqlrelatorio);
if ($clbens->numrows == 0){
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
  exit;
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca   = 1;
$alt     = 4;
$p       = 0;
$total   = 0;
$totalvalor = 0;
$numrows = $clbens->numrows;

//quebra de página
$valortotal=0;
$ident=0;
$contaregistro=0;
$passa=0;



for($x = 0; $x < $numrows; $x++){
  db_fieldsmemory($result,$x);

  $result_bensbaix = $clbensbaix->sql_record($clbensbaix->sql_query_file($t52_bem));
  if ($clbensbaix->numrows>0) {
    continue;
  }

  //quebrar página 
  if ($q_pagina=="S"){



    //quebra por departamento
    if ($ordenar=="depart"){

      if ($ident==0){
        $passa=1;
      }else{
        $passa=2;
      }

      if (isset($identifica)){
        if ($passa==2 and $identifica!=$t52_depart){
          $pdf->cell(135,$alt,'VALOR TOTAL:  '.$valortotal,"T",0,"R",0);
          $pdf->cell(130,$alt,'TOTAL DE REGISTROS  :  '.$contaregistro,"T",1,"R",0);
          $pdf->addpage("L");
          $imprime_total_parcial=true;
          $contaregistro=0;
          $valortotal=0;

        }
      }

      if ($ident==0){
        $valortotal+=$t52_valaqu;
        $contaregistro++;

      } else{
        if ($ident==$t52_depart ){
          $contaregistro++;
          $valortotal+=$t52_valaqu;
        }else{
          $valortotal+=$t52_valaqu;
          $contaregistro++;

        }
      }

      $identifica=$t52_depart;
      $ident=2;
    }//fim quebra por departamento





    //quebra por placa
    if ($ordenar=="placa"){

      if ($ident==0){
        $passa=1;
      }else{
        $passa=2;
      }

      if (isset($identifica)){
        if ($passa==2 and $identifica!=$t52_ident){
          $pdf->cell(135,$alt,'VALOR TOTAL:  '.$valortotal,"T",0,"R",0);
          $pdf->cell(130,$alt,'TOTAL DE REGISTROS  :  '.$contaregistro,"T",1,"R",0);
          $pdf->addpage("L");
          $imprime_total_parcial=true;
          $contaregistro=0;
          $valortotal=0;

        }
      }

      if ($ident==0){
        $valortotal+=$t52_valaqu;
        $contaregistro++;

      } else{
        if ($ident==$t52_ident ){
          $contaregistro++;
          $valortotal+=$t52_valaqu;
        }else{
          $valortotal+=$t52_valaqu;
          $contaregistro++;

        }
      }

      $identifica=$t52_ident;
      $ident=2; 
    }//fim quebra por placa


    //quebra por bem
    if ($ordenar=="bem"){

      if ($ident==0){
        $passa=1;
      }else{
        $passa=2;
      }

      if (isset($identifica)){
        if ($passa==2 and $identifica!=$t52_bem){
          $pdf->cell(135,$alt,'VALOR TOTAL:  '.$valortotal,"T",0,"R",0);
          $pdf->cell(130,$alt,'TOTAL DE REGISTROS  :  '.$contaregistro,"T",1,"R",0);
          $pdf->addpage("L");
          $imprime_total_parcial=true;
          $contaregistro=0;
          $valortotal=0;

        }
      }

      if ($ident==0){
        $valortotal+=$t52_valaqu;
        $contaregistro++;

      } else{
        if ($ident==$t52_bem ){
          $contaregistro++;
          $valortotal+=$t52_valaqu;
        }else{
          $valortotal+=$t52_valaqu;
          $contaregistro++;

        }
      }

      $identifica=$t52_bem;
      $ident=2;
    }//fim quebra por bem


    //quebra por classificação
    if ($ordenar=="classi"){

      if ($ident==0){
        $passa=1;
      }else{
        $passa=2;
      }

      if (isset($identifica)){
        if ($passa==2 and $identifica!=$t64_class){
          $pdf->cell(135,$alt,'VALOR TOTAL:  '.$valortotal,"T",0,"R",0);
          $pdf->cell(130,$alt,'TOTAL DE REGISTROS  :  '.$contaregistro,"T",1,"R",0);
          $pdf->addpage("L");
          $imprime_total_parcial=true;
          $contaregistro=0;
          $valortotal=0;

        }
      }

      if ($ident==0){
        $valortotal+=$t52_valaqu;
        $contaregistro++;

      } else{
        if ($ident==$t64_class ){
          $contaregistro++;
          $valortotal+=$t52_valaqu;
        }else{
          $valortotal+=$t52_valaqu;
          $contaregistro++;

        }
      }

      $identifica=$t64_class;
      $ident=2;
    }//fim quebra por classificação


    //quebra por data aquisição
    if ($ordenar=="data"){

      if ($ident==0){
        $passa=1;
      }else{
        $passa=2;
      }

      if (isset($identifica)){
        if ($passa==2 and $identifica!=$t52_dtaqu){
          $pdf->cell(135,$alt,'VALOR TOTAL:  '.$valortotal,"T",0,"R",0);
          $pdf->cell(130,$alt,'TOTAL DE REGISTROS  :  '.$contaregistro,"T",1,"R",0);
          $pdf->addpage("L");
          $imprime_total_parcial=true;
          $quebra_pagina=false;
          $contaregistro=0;
          $valortotal=0;

        }
      }

      if ($ident==0){
        $valortotal+=$t52_valaqu;
        $contaregistro++;

      } else{
        if ($ident==$t52_dtaqu ){
          $contaregistro++;
          $valortotal+=$t52_valaqu;
        }else{
          $valortotal+=$t52_valaqu;
          $contaregistro++;

        }
      }

      $identifica=$t52_dtaqu;
      $ident=2;
    }//fim quebra por data aquisição


  }

  if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
    $pdf->addpage("L");

    $pdf->setfont('arial','b',8);
    $pdf->cell(15,$alt,"Código",1,0,"C",1);
    $pdf->cell(100,$alt,$RLt52_descr,1,0,"C",1);
    $pdf->cell(20,$alt,"Vlr Aquisição",1,0,"C",1);
    $pdf->cell(25,$alt,"Data Aquisição",1,0,"C",1);
    $pdf->cell(30,$alt,$RLt52_ident,1,0,"C",1);
    $pdf->cell(80,$alt,$RLt52_depart,1,1,"C",1);

    if ($flag_forn == true){
      $pdf->cell(20,$alt,$RLt52_numcgm,1,0,"C",1);
      $pdf->cell(100,$alt,$RLz01_nome,1,0,"C",1);   
      $pdf->cell(150,$alt,$RLt52_obs,1,1,"C",1);
    }

    if ($flag_classi == true){
      $pdf->cell(20,$alt,$RLt64_class,1,0,"C",1);
      $pdf->cell(250,$alt,$RLt64_descr,1,1,"C",1);   
    }

    $troca = 0;
  }




  if (strlen(trim($t52_ident)) > 0){
    if ($t07_confplaca == 4){
      $t52_ident = db_formatar($t52_ident,"s","0",$t07_digseqplaca,"e",0);
    }
  }        

  $pdf->setfont('arial','',7);
  $pdf->cell(15,$alt,$t52_bem,0,0,"C",$p);
  $pdf->cell(100,$alt,substr($t52_descr,0,62),0,0,"L",$p);
  $pdf->cell(20,$alt,db_formatar($t52_valaqu,"f"),0,0,"R",$p);
  $pdf->cell(25,$alt,db_formatar($t52_dtaqu,"d"),0,0,"C",$p);
  $pdf->cell(30,$alt,$t52_ident,0,0,"C",$p);
  $pdf->cell(80,$alt,$t52_depart."-".$descrdepto,0,1,"L",$p);

  if ($flag_forn == true){
    $pdf->cell(20,$alt,$t52_numcgm,0,0,"C",$p);
    $pdf->cell(100,$alt,$z01_nome,0,0,"L",$p);   		     		
    $pdf->multicell(150,$alt,$t52_obs,0,"L",$p);
  }

  if ($flag_classi == true){
    $pdf->cell(20,$alt,$t64_class,0,0,"R",$p);
    $pdf->cell(250,$alt,$t64_descr,0,1,"L",$p);  			
  }


  if ($p==0){
    $p=1;
  }else{
    $p=0;
  }

  $total++;
  $totalvalor += $t52_valaqu;

} 
if (isset($imprime_total_parcial)){

  $pdf->cell(135,$alt,'VALOR TOTAL:  '.$valortotal,"T",0,"R",0);
  $pdf->cell(130,$alt,'TOTAL DE REGISTROS  :  '.$contaregistro,"T",1,"R",0);
}
$pdf->setfont('arial','b',8);
$pdf->cell(135,$alt,'VALOR TOTAL:'.db_formatar($totalvalor,"f"),"T",0,"R",0);
$pdf->cell(130,$alt,'TOTAL GERAL DE REGISTROS  :  '.$total,"T",1,"R",0);

$pdf->Output();
?>
