<?

function pes4_geracalculo003($calcula_parcial=null,$calcula_pensao=null) {

 global $diversos, $chamada_geral_arquivo,$minha_calcula_pensao;
 global $carregarubricas_geral,$carregarubricas,$chamada_geral;
 
 global $quais_diversos;

 global $db_debug,$d08_carnes,$cfpess;

 $d08_carnes = strtolower(trim($d08_carnes));
 $db_debug = true;
 
 global $subpes,$cfpess,$r110_regisi,$r110_regisf;

 $pcount = func_get_args();

 
 global $opcao_filtro, $faixa_lotac, $faixa_regis,$r110_lotaci,$r110_lotacf,$opcao_gml,$opcao_geral,$opcao_tipo;
 global $lotacao_faixa;
 
 if($opcao_gml == 'g'){
//    $opcao_gml = "m";
    $opcao_tipo = 2; // tipo geral
    $r110_regisi = 1;
    $r110_regisf = 999999;
    $r110_lotaci = "0000";
    $r110_lotacf = "0000";
 }else{
    $opcao_tipo = 1; // tipo parcial
 }
 
 if(isset($lotacao_faixa) && trim($lotacao_faixa) <> ""){
    global $rhlota;
    $faixa_lotacao = "";
    $faixa_lotac = str_replace("\\","",$lotacao_faixa);
    $condicaoaux = " where r70_estrut in (".$faixa_lotac.")" ;
    db_selectmax( "rhlota", "select r70_codigo from rhlota $condicaoaux ");
    $separa = " "; 
    for($Irhlota=0;$Irhlota < count($rhlota);$Irhlota++){
       $faixa_lotacao .= $separa.$rhlota[$Irhlota]["r70_codigo"];
       $separa = ",";
    }
    $faixa_lotac = $faixa_lotacao;
 } 
 
 if( count($pcount) == 0){
   //echo "<BR> --------------------------------------------Primeira vez-------------------------------------";
   $chamada_geral = "n";
   $chamada_geral_arquivo = "";
   $calcula_pensao = "n";
   //$r110_lotaci = '    ';
   //$r110_lotacf = '    ';
   //$r110_regisi = 0;
   //$r110_regisf = 0;
 }else{
     if( $calcula_pensao == "n"){
	if( $calcula_parcial != " "){
           //echo "<BR> calculo_parcial -> $calcula_parcial";
           //echo "<BR>  calculo_pensao -> $calcula_pensao";
           //echo "<BR> --------------------------------------------Segunda vez 1-----------------------------------";
	   $r110_regisi = db_val(db_substr($calcula_parcial,1,6));
	   $r110_regisf = db_val(db_substr($calcula_parcial,-6));
	   $r110_lotaci = db_substr($calcula_parcial,7,4);
	   $r110_lotacf = db_substr($calcula_parcial,11,4);
	   $chamada_geral = "a";
	   //echo "<BR> 1 i $r110_regisi f $r110_regisf li $r110_lotaci lf $r110_lotacf";
	}else{
           //echo "<BR> ------------------------------------------Segunda vez 2-----------------------------------";
	   $opcao_filtro = "i";
	   if($opcao_gml == "m"){
	      $r110_regisi = 1;
	      $r110_regisf = 999999;
	      $r110_lotaci = "0000";
	      $r110_lotacf = "0000";
	   }else if($opcao_gml == "l"){
	      $r110_regisi = 0;
	      $r110_regisf = 0;
	      $r110_lotaci = "0000";
	      $r110_lotacf = "9999";
	   } 
	   $chamada_geral = "s";
	   //echo "<BR> 2 i $r110_regisi f $r110_regisf li $r110_lotaci lf $r110_lotacf";
	}
     }else{
        //echo "<BR> --------------------------------------------Segunda vez 3-----------------------------------";
	$chamada_geral = "p";
     }
  }
  global $valor_salario_familia, $xvalor_salario_familia,$campos_pessoal,$siglap,$siglag,$quant_formq;

  global $sigla_ajuste;

  
  $campos_pessoal  = "r01_anousu, r01_mesusu,r01_regist,r01_numcgm, r01_lotac,";
  $campos_pessoal .= "r01_admiss, r01_recis, r01_tbprev,r01_regime, r01_tpvinc,";
  $campos_pessoal .= "r01_salari, r01_padrao,r01_hrssem,r01_hrsmen, r01_nasc,";
  $campos_pessoal .= "r01_rubric, r01_arredn,r01_equip, r01_cc,";
  $campos_pessoal .= "r01_anter,  r01_trien, r01_progr, r01_prores, r01_fgts,";
  $campos_pessoal .= "r01_causa,  r01_caub,  r01_mremun,";
  $campos_pessoal .= "r01_rnd1,   r01_rnd2,  r01_funcao,r01_clas1,r01_clas2,r01_tpcont,";
  $campos_pessoal .= "r01_ocorre, r01_b13fo, r01_basefo,r01_descfo, r01_d13fo,r01_tipsal,";
  $campos_pessoal .= "r01_propi , r01_depirf, r01_depsf ";

  global $dias_do_mes,$naoencontroupontosalario,$rubrica_licenca_saude,$rubrica_acidente,$situacao_funcionario,
         $dias_pagamento,$rubrica_maternidade,$valor_salario_familia,$xvalor_salario_familia,$inssirf_base_ferias,
	 $inssirf_base_ferias_total;
  
  //echo "<BR> 1.13 ndias --> ";
  $dias_do_mes = ndias( db_substr( $subpes,6,2)."/".db_substr( $subpes,1,4) );
  //echo "<BR> 1.13 saiu ndias --> ";
  $naoencontroupontosalario = false;
  $rubrica_licenca_saude = bb_space(4);
  $rubrica_acidente = bb_space(4);

  $situacao_funcionario = 1;
  $dias_pagamento = 30;
  $rubrica_maternidade = "xxxx";
  $valor_salario_familia = 0;
  $xvalor_salario_familia = 0;
  $inssirf_base_ferias = "B002";
  $inssirf_base_ferias_total = "B977";

  global $r06_form, $F006_clt,$dtot_vpass,$dperc_pass,$dquant_pass,$dias_pagamento_sf,$ultdat;
  $F006_clt = 0;
  $dtot_vpass = 0;
  $dperc_pass = 0;
  $dquant_pass = 0;
  $dias_pagamento_sf=0;
  //echo "<BR> 1.14 ndias --> ";
  $ultdat = db_ctod(db_str(ndias(per_fpagto(1)),2,0,'0')."/".per_fpagto(1));
  //echo "<BR> 1.14 saiu ndias --> ";
  
     if( $opcao_geral == 1){
	$sigla = "r10_";
	$sigla1 = "r14_";
	$qual_ponto = "pontofs";
	$chamada_geral_arquivo = "gerfsal";
     }else if( $opcao_geral == 8){ 
	$sigla = "r47_";
	$sigla1 = "r48_";
	$qual_ponto = "pontocom";
	$chamada_geral_arquivo = "gerfcom";
     }else if( $opcao_geral == 2){ 
	$sigla = "r21_";
	$sigla1 = "r22_";
	$qual_ponto = "pontofa";
	$chamada_geral_arquivo = "gerfadi";
     }else if( $opcao_geral == 3){ 
	$sigla = "r29_";
	$sigla1 = "r31_";
	$qual_ponto = "pontofe";
	$chamada_geral_arquivo = "gerffer";
     }else if( $opcao_geral == 4){ 
	$sigla = "r19_";
	$sigla1 = "r20_";
	$qual_ponto = "pontofr";
	$chamada_geral_arquivo = "gerfres";
     }else if( $opcao_geral == 5){ 
	$sigla = "r34_";
	$sigla1 = "r35_";
	$qual_ponto = "pontof13";
	$chamada_geral_arquivo = "gerfs13";
     }else if( $opcao_geral == 10){ 
	$sigla = "r90_";
	$sigla1 = "r53_";
	$qual_ponto = "pontofx";
	$chamada_geral_arquivo = "gerffx";
     }
     $siglap = $sigla;
     $siglag = $sigla1;
     
     global $mes,$ano;
     $mes = db_month( $cfpess[0]["r11_datai"]);
     $ano = db_year( $cfpess[0]["r11_datai"]);
     
     global $func_em_ferias;

     $func_em_ferias = false;
     if( $chamada_geral == "n"){
        //echo "<BR> foi chamado pelo programa";
	global $ajusta;
	$ajusta = false ;
	if(  $opcao_geral == 1 
	   || $opcao_geral == 8 
	   || $opcao_geral == 4 
	   || $opcao_geral == 3 
	   || $opcao_geral == 5  ){
	   $ajusta = true ;
	}
	if( $opcao_tipo == 2 || $opcao_tipo == 1 ){
	   if( $opcao_tipo == 2 ){
	      if( $opcao_geral == 1){
//echo "deletando gerfsal ";
		 db_delete( "gerfsal", bb_condicaosubpes("r14_") );

		 $stringferias  = "('".$cfpess[0]["r11_ferias"]."','".$cfpess[0]["r11_fer13o"]."','";
		 $stringferias .= $cfpess[0]["r11_fer13a"]."','".$cfpess[0]["r11_ferabo"]."','";
		 $stringferias .= $cfpess[0]["r11_feradi"]."','".$cfpess[0]["r11_ferant"]."','";
		 $stringferias .= $cfpess[0]["r11_feabot"]."','".$cfpess[0]["r11_fadiab"]."')";
		 $condicaoaux = " and ( r10_rubric in  " . $stringferias;
		 if( strtolower( $d08_carnes ) == "saocarlos"){
		     $condicaoaux .= " or r10_rubric in ('0270') ";
		 }
		 $condicaoaux .= "  or r10_rubric between 2000 and 3999 )";

		 db_delete( "pontofs", bb_condicaosubpes("r10_").$condicaoaux );

		 deleta_ajustes_calculogeral("s");
	      }else if( $opcao_geral == 2){ 
		 db_delete( "gerfadi", bb_condicaosubpes("r22_") ) ;
	      }else if( $opcao_geral == 8){ 
		 db_delete( "gerfcom", bb_condicaosubpes("r48_") )  ;
		 $stringferias  = "('".$cfpess[0]["r11_ferias"]."','".$cfpess[0]["r11_fer13o"]."','";
		 $stringferias .= $cfpess[0]["r11_fer13a"]."','".$cfpess[0]["r11_ferabo"]."','";
		 $stringferias .= $cfpess[0]["r11_feradi"]."','".$cfpess[0]["r11_ferant"]."','";
		 $stringferias .= $cfpess[0]["r11_feabot"]."','".$cfpess[0]["r11_fadiab"]."')";
		 $condicaoaux = " and ( r47_rubric in ".$stringferias;
		 if( strtolower(trim($d08_carnes))  == "saocarlos"){
		     $condicaoaux .= " or r47_rubric in ('0270') ";
		 }
		 $condicaoaux .= "  or r47_rubric between 2000 and 3999 )";

		 db_delete( "pontocom", bb_condicaosubpes("r47_").$condicaoaux );

		 deleta_ajustes_calculogeral("c");
	      }else if( $opcao_geral == 3){ 
		 db_delete( "gerffer", bb_condicaosubpes("r31_")  ) ;
	      }else if( $opcao_geral == 5){ 
		 db_delete( "gerfs13", bb_condicaosubpes("r35_") ) ;
		 deleta_ajustes_calculogeral("3");
	      }else if( $opcao_geral == 4){ 
		 db_delete( "gerfres", bb_condicaosubpes("r20_") )  ;
		 deleta_ajustes_calculogeral("r");
	      }else if( $opcao_geral == 10){ 
		 db_delete( "gerffx", bb_condicaosubpes("r53_") )  ;
	      }
	      $calcula_pensao = "n"  ;
	   }

	   $matriz1 = array();
	   $matriz2 = array();
	   $matriz1[ 1 ] = "r60_altera";
	   $matriz2[ 1 ] = 'f';
	   db_update("previden", $matriz1, $matriz2, bb_condicaosubpes("r60_") );
	   
	   $matriz1 = array();
	   $matriz2 = array();
	   $matriz1[ 1 ] = "r61_altera";
	   $matriz2[ 1 ] = 'f';


	   db_update("ajusteir", $matriz1, $matriz2, bb_condicaosubpes("r61_") );
            
	   $minha_calcula_pensao = false;
	   for($icalc=1; $icalc < 3; $icalc++){
	      if( $icalc == 1){
		 if( $qual_ponto == "pontof13"){
		     $condicaoaux = " and ".$siglap."rubric = ".db_sqlformat( db_str( db_val( $cfpess[0]["r11_palime"] )+4000, 4,0) );
		 }else{
		     $condicaoaux  = " and ( ".$siglap."rubric = ".db_sqlformat( $cfpess[0]["r11_palime"] );
		     $condicaoaux .= "   or ".$siglap."rubric = ".db_sqlformat( db_str( db_val( $cfpess[0]["r11_palime"] )+2000, 4,0) ).")";
		 }
		 db_delete( $qual_ponto, bb_condicaosubpes( $siglap ) . $condicaoaux );
	      }
	      
              if( $icalc == 2  && $opcao_geral != 10 ){
                 calc_pensao($icalc, $opcao_geral, $opcao_tipo, $chamada_geral_arquivo);
	         $calcula_pensao = "s";
	      }
		//echo "<BR> pensao 9 ->  $chamada_geral_arquivo     volta --> $icalc";
	      
	      if( $opcao_tipo == 2 ){ // tipo Geral
		 if( ( $opcao_geral != 10 || ( $opcao_geral == 10 && $icalc == 1)) ){
		       $calcula_parcial = " ";
		       //echo "<BR> entrou pes4_geracalculo003";
  	               pes4_geracalculo003($calcula_parcial,$calcula_pensao);
		       
		 }
	      }else{ // Tipo Parcial

		 if($icalc ==1 || ($icalc == 2 && $minha_calcula_pensao)){
		   
	            $calcula_parcial = db_str($r110_regisi,6,0,"0").$r110_lotaci.$r110_lotacf.db_str($r110_regisf,6,0,"0");
		   
		    pes4_geracalculo003($calcula_parcial,"n");
                 }
	     }
	     if( $ajusta){
	       //echo "<BR> entrou ajuste ";
	       
		 if( $opcao_geral != 3){
		    for($y1=1;$y1 < 4;$y1++){
		       $rubrica1 = ( $y1 == 1 ? "R985": ( $y1 == 2 ? "R986": "R987" ) );
		    //echo "<BR> entrando no ajusta_previdencia() --> $rubrica1";
		       ajusta_previdencia( $chamada_geral_arquivo, $rubrica1, $y1, $sigla1);
		     //echo "<BR> saiu do ajusta_previdencia()";
		    }
		    for($y1=1;$y1< 4;$y1++){
		       $rubrica = ( $y1 == 1? "R981": ( $y1 == 2 ? "R982" : "R983" ) );
		    //echo "<BR> entrando no ajusta_irrf() --> $rubrica";
		       ajusta_irrf($chamada_geral_arquivo, $rubrica,$y1 ,$sigla1);
		    //echo "<BR> saiu do ajusta_irrf()";
		    }
		 }else{
		    ajusta_previdencia( $chamada_geral_arquivo, "R977", 1, $sigla1);
		 }

		 if( ( $icalc == 2 ) && $opcao_geral == 1 ){
		    if(strtolower(trim($d08_carnes)) == "itaqui"){

		       if( $opcao_tipo == 1 ){
			   $condicaoaux   = "select r01_regist,r01_lotac,r01_recis from pessoal ";
			   $condicaoaux  .= bb_condicaosubpes( "r01_" );
			   $condicaoaux  .= " and r01_regist = ".db_sqlformat( $r110_regisi );
		       }else{

			  $condicaoaux  = "select distinct(r01_regist),r01_regist,r01_lotac,r01_recis,r10_regist from pessoal";
			  $condicaoaux .=" left outer join pontofs ";
			  $condicaoaux .="   on r01_regist = r10_regist "                        ;
			  $condicaoaux .="  and r10_anousu= ".db_sqlformat(db_substr($subpes,1,4));
			  $condicaoaux .="  and r10_mesusu= ".db_sqlformat(db_substr($subpes,6,2));
			  $condicaoaux .="  and r10_rubric in ('0053','0055','0067') ";
			  $condicaoaux .=" where r01_anousu= ".db_sqlformat(db_substr($subpes,1,4));
			  $condicaoaux .="   and r01_mesusu= ".db_sqlformat(db_substr($subpes,6,2));
			  $condicaoaux .="   and r10_regist is not null ";

		       }

		       $condicaoaux .= " and ( r01_recis is null or r01_recis >= ".db_sqlformat( db_ctod("01/".db_substr($subpes,6,2)."/".db_substr($subpes,1,4))).")";
		       $condicaoaux .= " order by r01_regist ";
		       global $pessoal_;
		       db_selectmax( "pessoal_", $condicaoaux );
		       for($Ipes=0;$Ipes<count($pessoal_);$Ipes++){
			  
			  calculos_especificos_itaqui_ajuste( $pessoal_[$Ipes]["r01_regist"], $pessoal_[$Ipes]["r01_lotac"] );
		       }
		    }
		    $tira_branco = trim($cfpess[0]["r11_desliq"]);
		    if( !db_empty( $tira_branco )){
		       global $rubricas_in; 
		       $rubricas_in = "(";
		       for($ix=0;$ix < strlen( trim($cfpess[0]["r11_desliq"]) );$ix+=4){
			  $rubrica_desconto = db_substr( trim($cfpess[0]["r11_desliq"]), $ix+1, 4 ) ;
			  
			  $calcula_valor = "calcula_valor_".$rubrica_desconto ;
			  global $$calcula_valor;
			  $$calcula_valor = false;
			  
			  $rubricas_in .= "'".$rubrica_desconto."',";
			  
		       }
		       $rubricas_in = db_substr($rubricas_in,1,strlen($rubricas_in)-1 ).")";
		 //echo "<BR> 3 rubricas_in --> $rubricas_in";exit;

		       $condicaoaux  = "select distinct(r01_regist),r01_regist,r01_lotac,r01_recis,r10_regist from pessoal";
		       $condicaoaux .=" left outer join pontofs ";
		       $condicaoaux .="   on r01_regist = r10_regist "                        ;
		       $condicaoaux .="  and r10_anousu= ".db_sqlformat(db_substr($subpes,1,4));
		       $condicaoaux .="  and r10_mesusu= ".db_sqlformat(db_substr($subpes,6,2));
		       $condicaoaux .="  and r10_rubric in ".$rubricas_in;
		       $condicaoaux .=" where r01_anousu= ".db_sqlformat(db_substr($subpes,1,4));
		       $condicaoaux .="   and r01_mesusu= ".db_sqlformat(db_substr($subpes,6,2));
		       $condicaoaux .="   and r10_regist is not null ";
		       if( $opcao_tipo == 1 ){
		         $condicaoaux  .= " and r01_regist = ".db_sqlformat( $r110_regisi );
		       }
		       $condicaoaux .= " and ( r01_recis is null or r01_recis >= ".db_sqlformat( db_ctod("01/".db_substr($subpes,6,2)."/".db_substr($subpes,1,4))).")";
		       $condicaoaux .= " order by r01_regist ";
		       global $pessoal_;
		       db_selectmax( "pessoal_", $condicaoaux );
		       for($Ipes=0;$Ipes<count($pessoal_);$Ipes++){
		          //echo "<BR> entrando calculos_desconto_liquido_generico_ajuste()";
			  calculos_desconto_liquido_generico_ajuste( $pessoal_[$Ipes]["r01_regist"], $pessoal_[$Ipes]["r01_lotac"] );
		          //echo "<BR> saiu do calculos_desconto_liquido_generico_ajuste()";
		       }
		    }
		 }
	      }
	      if( $opcao_geral == 2 ){
		 break;
	      }

	   }
	   return;
	}
     }
     
     if($opcao_geral == 1 || $opcao_geral == 8 ){
  //      echo "<BR> 1 - foi chamado pelo programa";
	   gerfsal($opcao_geral,$opcao_tipo);
  //      echo "<BR> 1 - sai do gerfsal";
     }else if ($opcao_geral == 2 ){
	   gerfadi($opcao_geral,$opcao_tipo);
     }else if($opcao_geral == 3 ){
	   gerffer($opcao_geral,$opcao_tipo);
     }else if($opcao_geral == 4 ){
	   gerfres($opcao_geral,$opcao_tipo);
     }else if($opcao_geral == 5 ){
	   gerfs13($opcao_geral,$opcao_tipo);
     }else if($opcao_geral == 10 ){
	   gerffx($opcao_geral,$opcao_tipo);
     }
//     echo "<BR> 1 - vai para o proximo loop";
					
//  echo "<BR> 1 - retornado para o pes4_gerafolha002.php";
}

?>
