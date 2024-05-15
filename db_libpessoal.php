<?
// trocar
// .or.
// .and.
// .t.
// .f.
// skip
// loop
function int($valor){
  return round($valor);

}

function db_retorno_variaveis($ano, $mes, $registro){
  /*
  global $f001, $f002,   $f003, $f004, $f005, 
         $f006, $f006_c, $f007, $f008, $f009, 
	 $f010, $f011,   $f012, $f013, $f014, 
	 $f015, $f022,   $f024, $f025, $padrao;
  */
  $sqlvar = '
             select 0||substr(db_fxxx,1,11)::float8   as f001,
                    0||substr(db_fxxx,12,11)::float8  as f002,
                       substr(db_fxxx,23,11)          as f003,
                    0||substr(db_fxxx,34,11)::float8  as f004,
                    0||substr(db_fxxx,45,11)::float8  as f005,
                    0||substr(db_fxxx,56,11)::float8  as f006,
                    0||substr(db_fxxx,67,11)::float8  as f006_clt,
                    0||substr(db_fxxx,78,11)::float8  as f007,
                    0||substr(db_fxxx,89,11)::float8  as f008,
                    0||substr(db_fxxx,100,11)::float8 as f009,
                    0||substr(db_fxxx,111,11)::float8 as f010,
                    0||substr(db_fxxx,122,11)::float8 as f011,
                    0||substr(db_fxxx,133,11)::float8 as f012,
                    0||substr(db_fxxx,144,11)::float8 as f013,
                    0||substr(db_fxxx,155,11)::float8 as f014,
                    0||substr(db_fxxx,166,11)::float8 as f015,
                    0||substr(db_fxxx,177,11)::float8 as f022,
                    0||substr(db_fxxx,188,11)::float8 as f024,
                    0||substr(db_fxxx,199,11)::float8 as f025,
                       substr(db_fxxx,210,15)         as padrao
             from (
	           select db_fxxx(rh02_regist,rh02_anousu,rh02_mesusu)
                   from   rhpessoalmov
                   where     rh02_anousu = '.$ano.'
       		         and rh02_mesusu = '.$mes.'
                         and rh02_regist = '.$registro.'
		  ) as x';
  $resultvar = pg_query($sqlvar);

  if($resultvar == false){
    return false;
  }else{
    $num_cols = pg_numfields($resultvar);
    $num_rows = pg_numrows($resultvar);
    for($index=0; $index<$num_cols; $index++){
      $nam_campo = pg_fieldname($resultvar, $index);
      global $$nam_campo;
      $$nam_campo = pg_result($resultvar, 0, $nam_campo);
    }
  }

  return pg_numrows($resultvar);
}

//Cria variaveis globais para o ano e mes passados
//Se ano e mes não forem passados, buscará dados do ano e mes correntes da folha
//Retorna false se tiver problemas na execução do sql e numrows caso sql esteja correto (0 se não encontrar registros e 1 caso encontre)
function db_sel_cfpess($anofolha=null, $mesfolha=null, $campos=" * "){
  if($anofolha == null || trim($anofolha) == ""){
    $anofolha = db_anofolha();
  }
  if($mesfolha == null || trim($mesfolha) == ""){
    $mesfolha = db_mesfolha();
  }
  if(trim($campos) == ""){
    $campos = " * ";
  }
  $record_cfpess = pg_exec("select ".$campos." from cfpess where r11_anousu = ".$anofolha." and r11_mesusu = ".$mesfolha);
  if($record_cfpess == false){
    return false;
  }else{
    $num_cols = pg_numfields($record_cfpess);
    $num_rows = pg_numrows($record_cfpess);
    for($index=0; $index<$num_cols; $index++){
      $nam_campo = pg_fieldname($record_cfpess, $index);
      global $$nam_campo;
      $$nam_campo = pg_result($record_cfpess, 0, $nam_campo);
    }
    return $num_rows;
  }
}
function db_foto($numcgm,$db_opcao = 3,$javascript = "",$width="95",$height="120"){

  global $oid;

  if(trim($numcgm) != "" && $numcgm != null){
	  $result_foto = pg_exec("select rh50_oid as oid from rhfotos where rh50_numcgm = $numcgm");
	  if(pg_numrows($result_foto) > 0){
	 	  db_fieldsmemory($result_foto, 0);
	  }
  }

  $mostrarimagem = "imagens/none1.jpeg";
  if(isset($oid)){
  	$mostrarimagem = "func_mostrarimagem.php?oid=".$oid;
  }
  $href = "<img src='".$mostrarimagem."' border=0 width='".$width."' height='".$height."'>";
  db_ancora("$href","$javascript","$db_opcao");

}

function db_empty($string){

  if($string == '  /  /    ' || $string == '  -  -    '   || 
     $string == '    /  /  ' || $string == '    -  -  ' ) {
    return true;
  }
  if($string == "R985") {
  }
  $string = trim($string);
  if(empty($string)){
    return true;
  }else{
    return false;
  }


}
function db_emptydata($string){

  $string = trim($string);
  if(empty($string)){
    return true;
  }else{
    return false;
  }

}
function db_dtos($string=null){
  
  // Obs : mantem o formato banco(Postgres) mas sem os caracters separadores de dia , mes e ano 
  // 2006-12-01 transforma em 20061201
  
  return db_strtran(db_strtran($string,'-',''), '/','');
}
function db_dtoc($string=null){
  
  // obs : transforma formato banco (Postgres) em caracter
  // 0123456789                0123456789
  // 2006-12-01 transforma em  01-12-2006
  
  return substr($string,8,2)."-".substr($string,5,2)."-".substr($string,0,4);
}

function db_dow($string=null){
 
 // Representação numérica do dia da semana 
 
  $retorna = date("w",db_mktime($string));
  return ($retorna==0?7:$retorna);
}






function db_ctod($string=null){
  
 // Obs : transforma caracter em formato banco(Postgres) 
 // 0123456789               0123456789
 // 01-12-2006 transforma em 2006-12-01
 
  return substr($string,6,4)."-".substr($string,3,2)."-".substr($string,0,2);
}
function db_mktime($string=null){
  
  // Obs : transforma formato banco (Postgres) em formato time para calculo de data
  // a funcao mktime exige a ordem mm,dd,aaaa
  // 0123456789                       
  // 2006-12-01 
  
  if(trim(substr($string,5,2)) != ""){
    return  mktime(0,0,0,substr($string,5,2),substr($string,8,2),substr($string,0,4));
  }else{
    return 0;
  }
}
function db_year($string=null){
  return substr($string,0,4)+0;
}

function db_month($string=null){
  return substr($string,5,2)+0;
}

function db_day($string=null){
  return substr($string,8,2)+0;
}

function db_datedif($pmktime=null,$smktime=null, $tipo='d'){
  if($tipo == 'd'){
    return ceil((( mktime(0,0,0,substr($pmktime,5,2),substr($pmktime,8,2),substr($pmktime,0,4)) -
                    mktime(0,0,0,substr($smktime,5,2),substr($smktime,8,2),substr($smktime,0,4)))/86400));
  }else if($tipo == 'm'){
    return 0;
  }else if($tipo == 'y'){
    return 0;
  }else{
    return ceil((( mktime(0,0,0,substr($pmktime,5,2),substr($pmktime,8,2),substr($pmktime,0,4)) -
                    mktime(0,0,0,substr($smktime,5,2),substr($smktime,8,2),substr($smktime,0,4)))/86400));
  }

}



function db_val($string=0){
  if(!db_empty($string) && $string != null ){
    return $string+0;
  }else{
    return 0;
  }
}
function db_str($string=null,$tam=null,$digitos=0,$preenche= ' '){
  return db_formatar($string,'s',$preenche,$tam);
}

function db_strtran($string=null,$quem_sai=null,$quem_entra=null){
  return str_replace($quem_sai,$quem_entra,$string);
}


function db_substr($string=null,$posini=null,$quant=null){
  if($posini<0)
    return substr("#".$string,$posini);
  else
    return substr("#".$string,$posini,$quant);
}

function db_at($string_a_pesquisar=null,$string_pesquisa=null){

   if(!db_empty($string_a_pesquisar)){
     return strpos(strtoupper("#".$string_pesquisa),strtoupper($string_a_pesquisar))+0 ;
   }else{
     return 0;
   }
}

function db_sqlformat($variavel=null){
   if((is_string($variavel) && $variavel <> 'null') || trim($variavel) == ''){
       return "'".$variavel."'";
    }else if( is_bool($variavel)){
       if( $variavel == true ) {
           return "'t'";
       }else if( $variavel == false ) {
           return "'f'";
       }
    }else{
       return $variavel;
    }
}

function bb_round($valor=0,$dig=2){
  return round($valor,$dig);
}

function bb_condicaosubpes($prefixo=null){
  global $subpes;
//  $retorno  = " where "+$prefixo+ "anousu = "+db_anofolha();
//  $retorno .= "  and  "+$prefixo+ "mesusu = "+db_mesfolha();
  $retorno  = " where ".$prefixo."anousu = ".db_substr($subpes,1,4);
  $retorno .= "  and  ".$prefixo."mesusu = ".db_substr($subpes,6,2);
  return $retorno;
  

}
function bb_condicaosubpesproc($prefixo=null,$subpes_procesamento=null){

//  $retorno  = " where "+$prefixo+ "anousu = "+db_anofolha();
//  $retorno .= "  and  "+$prefixo+ "mesusu = "+db_mesfolha();
  
  $retorno  = " where ".$prefixo."anousu = '".substr($subpes_procesamento,0,4)."'";
  $retorno .= "  and  ".$prefixo."mesusu = '".substr($subpes_procesamento,5,2)."'";
  return $retorno;
  

}
function bb_condicaosubpesanterior($prefixo=null){
 $submes = db_anofolha()-1;
 $subano = db_mesfolha();

// $submes = 1-1;
// $subano = 2006;


 if($submes < 1){
   $submes = 12;
   $subano -= 1;
 }
 $retorno = " where ".$prefixo."anousu = ".$subano." and ".$prefixo."mesusu = ".$submes;
 return $retorno;
       

}
function db_selectmax($matriz=null,$query=null){

  //echo "Select $matriz  - $query\n";
// system("echo psql -h 192.168.0.37 -U postgres auto_sap_2605 -c explain \"$query;\" >>/tmp/reis"); 
  $result = @pg_exec($query);
  //db_criatabela($result);
  global $$matriz;
  if($result!=false && pg_numrows($result)>0){
    
   // echo $matriz."[0]["";
    
    $$matriz = pg_fetch_all($result);

    //print_r($$matriz);
    
    return true;
  }else{
    if($result==false){
      echo "Erro no query:  $query ";
      exit;
    }else{
      $$matriz = null;
      return false;
    }
  }
}

function db_boolean($variavel=null){

  if($variavel=='f')
    return false;
  else
    return true;
  
}

function db_criatemp($nome_tab,$mat_campos,$mat_tipos,$mat_tamanho,$mat_deci, $qual_alias){

//$private nome_tab,mat_campos,mat_tipos,mat_tamanho,mat_deci, retorno;

   $monta_string = "";
   $string_campos = "";
   $retorno = true;

   $monta_string = 'create temporary table '.$nome_tab.' (';
   $virgula = "";
   for( $i = 1;$i <= count($mat_campos);$i++){
       if( $mat_tipos[$i] == "c"){
          $tipo_campo = "char(".$mat_tamanho[$i].")";
       }elseif( $mat_tipos[$i] == "n" && $mat_deci[$i] > 0){
          $tipo_campo = "float8 default 0";
       }elseif( $mat_tipos[$i] == "n" && $mat_deci[$i] == 0){
          $tipo_campo = "integer default 0 ";
       }elseif( $mat_tipos[$i] == "d"){
          $tipo_campo = "date";
       }elseif( $mat_tipos[$i] == "l"){
          $tipo_campo = "boolean";
       }elseif( $mat_tipos[$i] == "m"){
          $tipo_campo = "text";
       }
       $string_campos = $string_campos.$virgula.$mat_campos[$i]." ".$tipo_campo." ";
       
       $virgula = ",";
   }
   $string_campos = $string_campos.")";

   $retorno = pg_query($monta_string.$string_campos);
   
return $retorno;
}

function db_update($tabela,$mat_campos,$mat_valores,$condicao_a){
  $linha1 = "";
  $linha2 = "";

  $linha1 = "update ".$tabela." set ";
  $virgula = "";
  for($i=1;$i <= count($mat_campos);$i++){

    // if( type($mat_valores[$i]) == "c"  && strtoupper(db_substr($mat_valores[$i],1,8)) == "DB_OID: "){
    //    $mat_valores[$i] = "lo_import(".db_sqlformat(db_substr($mat_valores[$i],9)).")";
    // }else{
        $mat_valores[$i] = db_sqlformat($mat_valores[$i]);
    // }
     $linha2 .=  $virgula.$mat_campos[$i]." = ".$mat_valores[$i];
     $virgula = ",";
  }

//  $linha2 .=  $mat_campos[$i]."=" .$mat_valores[$i];

//  echo "<BR><BR><BR>".$linha1." ".$linha2." ".$condicao_a.";<BR><BR>";
  $db_sql = pg_query($linha1." ".$linha2." ".$condicao_a);

  if($db_sql == null){
    echo ("erro ".$linha1." ".$linha2." ".$condicao_a);
    exit;
  }
  return $db_sql;
}

function db_delete($tabela=null,$condicao_deleta=null,$sem_condicao=null){

  if( $condicao_deleta == null && $sem_condicao == null ){
     echo ("execucao de exclusao nao permitida. contate cpd!") ;
     exit;
  }

//  echo "<BR><BR><BR>"."delete from ".$tabela." ".$condicao_deleta.";<BR><BR>";

  $db_sql = pg_query("delete from ".$tabela." ".$condicao_deleta);

  if($db_sql == false){
    echo ("delete from ".$tabela." ".$condicao_deleta);
    pg_query("rollback");
    exit;
  }
  return $db_sql;
}

function db_insert($tabela,$mat_campos,$mat_valores,$execdie=true){
  $linha2  = "";
  $linha3  = "";
  $linha4  = "";
  
  //if($tabela=="gerfsal")
  //  $tabela="gerfsal_calc";
    
  $linha1  = "insert into ".$tabela."(";
  $virgula = "";
  for( $ii = 1;$ii <= count($mat_campos);$ii++){
     $linha2 .=  $virgula.$mat_campos[$ii];
     $virgula = ",";
  }
  // echo "<BR><BR> $tabela -*- ".$linha2;
  $linha2 .= ")";
  $linha3 = " values (";
  $virgula = "";
  for($ii = 1;$ii <= count($mat_valores);$ii++){
     if( $ii+1 > count($mat_valores)){
       // if (type( $mat_valores[$ii] ) == "c" && strtoupper(db_substr($mat_valores[$ii],1,8)) == "DB_OID: "){
       //    $mat_valores[$ii] = "lo_import(".db_sqlformat(db_substr($mat_valores[$ii],9)).")";
       // }else{
           $mat_valores[$ii] = db_sqlformat($mat_valores[$ii]);
       // }
        $linha4 .=  $mat_valores[$ii].")";
     }else{
       // if ( type( $mat_valores[$ii] ) == "c" && strtoupper(db_substr($mat_valores[$ii],1,8)) == "DB_OID: "){
       //    $mat_valores[$ii] = "lo_import(".db_sqlformat(db_substr($mat_valores[$ii],9)).")";
       // }else{
	 
           $mat_valores[$ii] = db_sqlformat($mat_valores[$ii]);
       // }
        $linha4 .=  $mat_valores[$ii].",";
     }
  }
  
  // echo "<BR><BR><BR>".($linha1.$linha2.$linha3.$linha4).";<BR><BR>";
  $db_sql = pg_query($linha1.$linha2.$linha3.$linha4);
  if( $db_sql == false ){
  	if($execdie == true){
      echo ("erro ao tentar gravar em ".$tabela);
      echo "<br>".$linha1.$linha2.$linha3.$linha4;
      exit;
  	}
  }
  return $db_sql;
}

function ndias ($pmesano){
  $mmes = db_val(db_substr($pmesano,1,2));
  $mano = db_val(db_substr($pmesano,4,4));
  //echo "<BR> mmes --> $mmes";
  //echo "<BR> mano --> $mano";
  
  if( $mmes == 1 || $mmes == 3 || $mmes == 5 || $mmes == 7 || $mmes == 8 || $mmes == 10 || $mmes == 12 ){
    $dias = 31;
  //echo "<BR> 1 dias --> $dias";
  }else if( $mmes == 2 ){
    if( $mano%4 == 0){  
       $dias = 29;
  //echo "<BR> 2 dias --> $dias";
    }else{
       $dias = 28;
  //echo "<BR> 3 dias --> $dias";
    }
  }else{
    $dias = 30;
  //echo "<BR> 4 dias --> $dias";
  }
  return $dias;
}

function per_fpagto ($tipo=null){
  global $subpes;
  $retmesano = db_substr($subpes,6,2)."/".db_substr($subpes,1,4);
  return $retmesano;
}

function bb_space($numero){
  return str_pad(" ",$numero);
}


function situacao_funcionario ($registro=null){
  // variaveis publicas
  echo $registro;exit;
  global $dias_pagamento, $data_afastamento, $dias_pagamento_sf, $dtfim,$subpes,$pessoal,$Ipessoal;
  
  //echo "<BR 1.10 - ndias --> ";
  $dias_mes = ndias(db_substr($subpes,-2)."/".db_substr($subpes,1,4));
  //echo "<BR 1.10 - saiu ndias --> ";
  $dtini = db_ctod("01/".db_substr($subpes,-2)."/".db_substr($subpes,1,4));
  $dtfim = db_ctod(db_str($dias_mes,2,0,"0")."/".db_substr($subpes,-2)."/".db_substr($subpes,1,4));
  $dias_pagamento = 30;
  $dias_pagamento_sf = 30;
  $afastado = 1;
  $data_afastamento = date("Y-m-d",db_getsession("DB_datausu"));
  $condicaoaux = " and r45_regist =". db_sqlformat( $registro )." order by r45_regist, r45_dtafas desc"  ;
  global $afasta;
  if( db_selectmax( "afasta", "select * from afasta ".bb_condicaosubpes( "r45_").$condicaoaux )){
     if( db_mktime($afasta[0]["r45_dtreto"]) >= db_mktime($dtini) || db_empty($afasta[0]["r45_dtreto"])){
	$afastado = $afasta[0]["r45_situac"];
	if( !db_empty($afasta[0]["r45_dtreto"]) ){
	   if( db_mktime($afasta[0]["r45_dtafas"]) > db_mktime($dtfim) ){
	      $afastado = 1;
	   }
	}
	if( $afastado != 1){
	   if( ( db_mktime($afasta[0]["r45_dtreto"])==0 || db_mktime($afasta[0]["r45_dtreto"]) > db_mktime($dtfim)  ) && db_mktime($afasta[0]["r45_dtafas"]) >= db_mktime($dtini) ){
	      $dias_pagamento = db_datedif($afasta[0]["r45_dtafas"],$dtini);
	   }else if( ( db_empty( $afasta[0]["r45_dtreto"]) || db_mktime($afasta[0]["r45_dtreto"]) > db_mktime($dtfim)  ) && db_mktime($afasta[0]["r45_dtafas"]) < db_mktime($dtini) ){ 
 	      $dias_pagamento = 0;
	   }else if( db_mktime($afasta[0]["r45_dtafas"]) < db_mktime($dtini) && db_mktime($afasta[0]["r45_dtreto"]) <= db_mktime($dtfim) ){ 
	      $dias_pagamento = db_datedif($dtfim,$afasta[0]["r45_dtreto"]);
	      if( $dias_pagamento > 0 ){
		 if( $dias_mes > 30){
		     $dias_pagamento -= 1;
		 }else if( $dias_mes == 29){ 
		     $dias_pagamento = (30 - db_day($afasta[0]["r45_dtreto"]));
		 }
	      }
	   }else if( db_mktime($afasta[0]["r45_dtafas"]) >= db_mktime($dtini) && db_mktime($afasta[0]["r45_dtreto"]) <= db_mktime($dtfim)){ 
	      $dias_pagamento = ceil(((db_mktime($dtfim) - db_mktime($afasta[0]["r45_dtreto"]) + db_mktime($afasta[0]["r45_dtafas"]) - db_mktime($dtini))/86400));
	      if( !db_empty($dias_pagamento)){
		 if( $dias_mes > 30){
		    $dias_pagamento -= 1;
		 }else if( $dias_mes < 30){ 
		    $dias_pagamento += (30 - $dias_mes);
		 }
	      }
	   }
	   $data_afastamento = $afasta[0]["r45_dtafas"];
	}
     }
  }else{
     if( db_year($pessoal[$Ipessoal]["r01_admiss"]) == db_val(db_substr($subpes,1,4)) 
	   && db_month($pessoal[$Ipessoal]["r01_admiss"]) == db_val(db_substr($subpes,-2)) ){
	if( $dias_mes > 30){
	   $dias_pagamento_sf = $dias_mes - ( db_day($pessoal[$Ipessoal]["r01_admiss"]));
	   $dias_pagamento = $dias_mes - ( db_day($pessoal[$Ipessoal]["r01_admiss"]));
	}else if( $dias_mes = 30){ 
	   $dias_pagamento_sf = $dias_mes - ( db_day($pessoal[$Ipessoal]["r01_admiss"]) - 1);
	   $dias_pagamento = $dias_mes - ( db_day($pessoal[$Ipessoal]["r01_admiss"]) - 1);
	}else{
	   $dias_pagamento_sf = 30 - ( db_day($pessoal[$Ipessoal]["r01_admiss"]) - 1);
	   $dias_pagamento    = 30 - ( db_day($pessoal[$Ipessoal]["r01_admiss"]) - 1);
	}
     }
  }
  return $afastado;

}

function ver_idade($dhoje,$dnasc){

$idade = db_substr($dhoje,7,4)-db_substr($dnasc,7,4);

if(db_substr($dhoje,4,2) < db_substr($dnasc,4,2)){
   $idade -= 1;
}

return $idade;
   
}

function ferias($registro,$cfuncao = ""){

  //echo "<BR> 1.11 - entrou na funcao ferias --> ";
  global $subpes,$cadferia, $F016 ,$F017 ,$F018 ,$F019 , $F020 ,$F021 , $F023,$cfpess;
  
  $F016 = 0;
  $F017 = 0;
  $F018 = 0;
  $F019 = 0;
  $F020 = 0;
  $F021 = 0;
  $F023 = 0;
  $anomes = db_substr($subpes,1,4).db_substr($subpes,6,2);

  $condicaoaux  =  " and r30_regist = ".db_sqlformat($registro);
  $condicaoaux .= " order by r30_perai desc limit 1";
  if( db_selectmax( "cadferia", "select * from cadferia ".bb_condicaosubpes("r30_").$condicaoaux )){
  //echo "<BR> 1.11 - acho o registro no cadferias --> ";

    
     if( db_substr($cadferia[0]["r30_proc1"],1,4).db_substr($cadferia[0]["r30_proc1"],6,2)  > $anomes || 
	db_substr($cadferia[0]["r30_proc2"],1,4).db_substr($cadferia[0]["r30_proc2"],6,2)  > $anomes ){
	return;
     }
     if( db_empty($cadferia[0]["r30_proc1d"]) || $cadferia[0]["r30_proc1d"] == $subpes){
	$F019 = $cadferia[0]["r30_dias1"];
  //echo "<BR> 1.11 - F019 --> $F019";
	$F020 = $cadferia[0]["r30_abono"];
	$F020 = $cadferia[0]["r30_abono"];
  //echo "<BR> 1.11 - r30_perli --> ".$cadferia[0]["r30_per1i"];
  //echo "<BR> 1.12 - r30_perli --> ".db_substr(db_dtoc($cadferia[0]["r30_per1i"]),4,7);
        $dias_ = ndias(db_substr(db_dtoc($cadferia[0]["r30_per1i"]),4,7));
	$maxdiac = db_str($dias_,2,0,"0")         ;
  //echo "<BR> 1.11 - maxdiac --> $maxdiac";
	if(     db_substr(db_dtos($cadferia[0]["r30_per1i"]),1,6) == $anomes && 
	       db_substr(db_dtos($cadferia[0]["r30_per1f"]),1,6) == $anomes){
	       $F021 = $F019;
	}else if( db_substr(db_dtos($cadferia[0]["r30_per1i"]),1,6) < $anomes && 
	       db_substr(db_dtos($cadferia[0]["r30_per1f"]),1,6) == $anomes){
	  //echo "<BR> r30_perif --> ".db_ctod("01/".db_substr(db_dtoc($cadferia[0]["r30_per1f"]),4,7) ) ;
	       $F019 = db_datedif( $cadferia[0]["r30_per1f"] , db_ctod("01/".db_substr(db_dtoc($cadferia[0]["r30_per1f"]),4,7)) ) + 1 ;
  //echo "<BR> 1.12 - F019 --> $F019";
	       $F020 = 0 ;
	       $F021 = $F019;
	       if( strtolower($cfpess[0]["r11_fersal"]) == 's' && !db_boolean( $cfpess[0]["r11_recalc"] )){
		   $F019 = 0;
		   $F021 = 0;
	       }
	}else if( db_substr(db_dtos($cadferia[0]["r30_per1i"]),1,6) == $anomes && 
	       db_substr(db_dtos($cadferia[0]["r30_per1f"]),1,6) > $anomes ){
	  //echo "<BR> 1.12 r30_perif --> ".db_ctod($maxdiac."/".db_substr(db_dtoc($cadferia[0]["r30_per1i"]),4,7));
	       $F019 = db_datedif(db_ctod($maxdiac."/".db_substr(db_dtoc($cadferia[0]["r30_per1i"]),4,7)),$cadferia[0]["r30_per1i"] ) + 1 ;
  //echo "<BR> 1.12 - F019 --> $F019";
	       $F020 = $cadferia[0]["r30_abono"];
	       $F021 = $F019;
	       if( strtolower($cfpess[0]["r11_fersal"]) == 's' && !db_boolean( $cfpess[0]["r11_recalc"] ) 
				  && db_month( $cadferia[0]["r30_per1i"] ) == 2 && $F019 == ndias($dias_)){
		  $F019 = 30;
		  $F021 = 30;
	       }
	       $F023 = $cadferia[0]["r30_dias1"] - $F019;
	}else if( db_substr(db_dtos($cadferia[0]["r30_per1i"]),1,6) > $anomes &&  
	       db_substr(db_dtos($cadferia[0]["r30_per1f"]),1,6) > $anomes){
	       $F023 = $F019;
	       $F019 = 0 ;
	       $F021 = 0  ;
	}else if( db_substr(db_dtos($cadferia[0]["r30_per1i"]),1,6) < $anomes ){ 
	       $F019 = 0;
	       $F020 = 0;
	       $F021 = 0 ;
	}
	if( $cadferia[0]["r30_tip1"] == "11"){
	   $F020 = 0;
	}
	if( db_empty($cadferia[0]["r30_proc2d"]) || $cadferia[0]["r30_proc2d"] == $subpes){ 
	   if( $cadferia[0]["r30_tip2"] == "10"){
	      $F019 = 0;
	      $F020 = $cadferia[0]["r30_abono"];
	      $F021 = 0;
	   }else if( $cadferia[0]["r30_tip2"] == "09"){ 
	      if(  db_substr(db_dtos($cadferia[0]["r30_per2i"]),1,6) == $anomes && 
		  db_substr(db_dtos($cadferia[0]["r30_per2f"]),1,6) == $anomes ){
		  $F019 = db_datedif($cadferia[0]["r30_per2f"],$cadferia[0]["r30_per2i"]) + 1;
		  $F020 = 0;
		  $F021 = $F019;
	      }else if( db_substr(db_dtos($cadferia[0]["r30_per2i"]),1,6) < $anomes &&  
		  db_substr(db_dtos($cadferia[0]["r30_per2f"]),1,6) == $anomes ){
		  $F019 = db_datedif($cadferia[0]["r30_per2f"] , db_ctod("01/".db_substr(db_dtoc($cadferia[0]["r30_per2f"]),4))) + 1 ;
  //echo "<BR> 1.13 - F019 --> $F019";
		  $F020 = 0;
		  $F021 = $F019;
	      }else if( db_substr(db_dtos($cadferia[0]["r30_per2i"]),1,6) > $anomes && 
		  db_substr(db_dtos($cadferia[0]["r30_per2f"]),1,6) > $anomes ){
		  $F019 = 0 ;
		  $F020 = 0 ;
		  $F021 = 0 ;
	      }else{
		  $F019 = 0;
		  $F020 = 0;
		  $F021 = 0;
	      }
	   }
	   if( db_at($cfuncao , "fecha_folha")>0 && db_empty($cadferia[0]["r30_proc2d"])){
	      if( $F019 != 0 || $F020 != 0){
		 $perai = $cadferia[0]["r30_perai"];
		 $condicaoaux  = " and r30_regist = ".db_sqlformat( $registro );
		 $condicaoaux .= " and r30_perai = ".db_sqlformat( $perai );
		 $matriz1 = array();
		 $matriz2 = array();
		 $matriz1[1] = "r30_proc2d";
		 $matriz2[1] = $subpes;
		 db_update( "cadferia", $matriz1,$matriz2, bb_condicaosubpes( "r30_" ).$condicaoaux )                 ;
	      }
	   }
	}
     }

  }
  return true;
}

function db_condicaoaux($opcao_filtro,$opcao_gml,$siglag,$r110_regisi=null,$r110_regisf=null,$r110_lotaci=null,
                           $r110_lotacf=null,$faixa_regis=null,$faixa_lotac=null,$sigla2=null){

if($sigla2 == null){
    $sigla2 = $siglag;
}

$condicaoaux = "";
        if( $opcao_filtro == "i"){
           if(       $opcao_gml == "m"){
              $condicaoaux  = " and ".$siglag."regist between ".db_sqlformat($r110_regisi);
              $condicaoaux .= " and ".db_sqlformat($r110_regisf);
           }else if( $opcao_gml == "l"){
              $condicaoaux  = " and to_number(".$siglag."lotac,'9999') between ".db_sqlformat($r110_lotaci);
              $condicaoaux .= " and ".db_sqlformat($r110_lotacf);
           }
        }else{
           if(     $opcao_gml == "m" && !db_empty($faixa_regis)){
              $condicaoaux  = " and ".$siglag."regist in (".$faixa_regis.")";

           }elseif($opcao_gml == "l" && !db_empty($faixa_lotac)){
              $condicaoaux  = " and to_number(".$siglag."lotac,'9999') in (".$faixa_lotac.")";
           }
        }
 return $condicaoaux;
}




function db_debug($string,$tempo=null){
  global $db_debug;
  if($db_debug==true){
//    echo $string."\n";
 //   if($tempo!=null)
  //   sleep($tempo);
  }
  
}

function db_debug1($string,$tempo=null){
  global $db_debug;
  if($db_debug==true){
    //echo $string."<br>";
    //if($tempo!=null)
    //  sleep($tempo);
  }
  flush();
  
}

function numero_faltas($registro, $data_inicio, $data_final ){
  global $protelac,$Iprotelac,$assenta;
  
 db_debug1("entrou na funcao numero_faltas"); 
  $num_faltas = 0;
  db_selectmax( "protelac", "select * from protelac " );
  for($Iprotelac=0;$Iprotelac<count($protelac);$Iprotelac++){
   if( $protelac[$Iprotelac]["h19_tipo"] == "f"){
      $condicaoaux  = " where h16_assent = ".db_sqlformat( $protelac[$Iprotelac]["h19_assent"] );
      $condicaoaux .= " and h16_regist = ".db_sqlformat( $registro );
      if( db_selectmax( "assenta", "select * from assenta ".$condicaoaux ) ){
         for($Iassenta=0;$Iassenta<count($assenta);$Iassenta++) 
            if( db_mktime($assenta[$Iassenta]["h16_dtterm"]) < db_mktime($data_inicio) ){
               $data_ini = db_ctod("");
               $data_fim = db_ctod("");
            }else if( db_mktime($assenta[$Iassenta]["h16_dtconc"]) > db_mktime($data_final)){ 
               $data_ini = db_ctod("");
               $data_fim = db_ctod("");
            }else if( db_mktime($assenta[$Iassenta]["h16_dtconc"]) <= db_mktime($data_inicio) && db_mktime($assenta[$Iassenta]["h16_dtterm"]) >= db_mktime($data_final)){ 
               $data_ini = $data_inicio;
               $data_fim = $data_final;
            }else if( db_mktime($assenta[$Iassenta]["h16_dtconc"]) >= db_mktime($data_inicio) && db_mktime($assenta[$Iasseta]["h16_dtterm"]) <= db_mktime($data_final)){ 
               $data_ini = $assenta[$Iassenta]["h16_dtconc"];
               $data_fim = $assenta[$Iassenta]["h16_dtterm"];
            }else if( db_mktime($assenta[$Iassenta]["h16_dtconc"]) >= db_mktime($data_inicio) && db_mktime($assenta[$Iassenta]["h16_dtterm"]) >= db_mktime($data_final)){ 
               $data_ini = $assenta[$Iassenta]["h16_dtconc"];
               $data_fim = $data_final;
            }else if( db_mktime($assenta[$Iassenta]["h16_dtconc"]) >= db_mktime($data_inicio) && db_mktime($assenta[$Iassenta]["h16_dtterm"]) >= db_mktime($data_final)){ 
               $data_ini = $assenta[$Iassenta]["h16_dtconc"];
               $data_fim = $data_final;
            }
            $num_faltas += db_datedif($data_fim,$data_ini) - 1;
         }
      }
   }
 return $num_faltas;
}


function retorna_avos($r30_perai,$r30_peraf_ant,$r30_peraf){


 if( db_mktime($r30_peraf) < db_mktime($r30_peraf_ant) ){
 
    $navos = 0;
    if( ndia($r30_peraf) == ndia($r30_perai) ) {
       // no mesmo ano so ver a diferenca de meses
       $navos = db_month($r30_peraf) - db_month($r30_perai); 
    }else{
    
       // meses restante do ano anterior mais meses do ano posterior
       // (12 - mes) = quantidade de meses a contar como periodo aquisitivo no ano
       
       $novos = (12 - db_month($r30_perai) )  +db_month($r30_peraf);
    }
    
    if( (ndia($r30_peraf) - ndia($r30_perai)) > 14 ) {
       // a fração superior a 14 dias - 1/12 avo. , conta como um mes a mais
       $navos++;
    }
 }else{
 
    $navos = db_datedif($r30_peraf_ant,$r30_perai) / 30;
    
    if( $navos < 0 ){
       $navos = $navos * (-1);
    }
 
    // observacao : o periodo aquisitivo nao pode ser maior que um ano ou seja 12 meses
    if( $navos > 12){
       $navos = 12;
    }
 }
	 
 return $navos;
}


function dias_gozo($opcao,$mtipo,$r30_ndias=0) {

$nsaldo = 0;

if($opcao == "S") {

   if($mtipo == "09"){
      $nsaldo = $cadferia[0]["r30_ndias"] - $cadferia[0]["r30_dias1"] + $cadferia[0]["r30_dias2"] + $cadferia[0]["r30_abono"];
      
   }else{
      $nsaldo = 0;
   }
   
}else{

   if($mtipo >= "01" && $mtipo <= "04"){
      
      // mtipo de 02, 03 , 04 vai sobrar saldo
      
      if($mtipo == "01"){
         $nsaldo = $r30_ndias;
      }else if($mtipo == "02"){
         $nsaldo = 20;
      }else if($mtipo == "03"){
         $nsaldo = 15;
      }else if($mtipo == "04"){
         $nsaldo = 10;
      }
   }else if(db_at($mtipo,"05 ,06, 07, 08, 99") > 0){  // quando forma de pgto tiver abono
      // 20 dias de ferias e 10 dias de abono
      }else if($mtipo == "05"){
         $nsaldo = 20;
      }else if($mtipo == "06"){
         $nsaldo = 15;
      }else if($mtipo == "07"){
         $nsaldo = 10;
      }else if($mtipo == "08"){
         $nsaldo = 0;
      } 
   }
   
 return $nsaldo; 

}


function tabela_gozo($nfaltas,$navos) { 

   if($nfaltas <= 05) {
        $k = 2.5; 
   }else if( $nfaltas <= 14) {
        $k = 2.0;
   }else if( $nfaltas <= 23) {
        $k = 1.5;
   }else if( $nfaltas <= 32) {
        $k = 1;
   }else{
        $k = 0;
   }

  return ($k * $navos);
}

function verificaseexisteafastamentonoperiodo($registro, $inicio, $fim){

  global $subpes;

  $cond  = "select r01_regist,r45_regist,r69_regist ";
  $cond .= " from pessoal ";
  $cond .= " left outer join afastamento ";
  $cond .= "    on r69_anousu = ".db_sqlformat( db_substr($subpes,1,4) )  ;
  $cond .= "   and r69_mesusu = ".db_sqlformat( db_substr($subpes,6,2) )  ;
  $cond .= "   and r69_regist = ".db_sqlformat( $registro );
  $cond .= "   and (   ( r69_dtafast <= ".db_sqlformat( $fim ) ;
  $cond .= "             and r69_dtretorno is null ) ";
  $cond .= "        or ( r69_dtafast >= ".db_sqlformat( $inicio );
  $cond .= "             and r69_dtretorno <= ".db_sqlformat( $fim ).")";
  $cond .= "        or ( r69_dtretorno > ".db_sqlformat( $fim ) ;
  $cond .= "             and r69_dtafast >= ".db_sqlformat ($inicio) ;
  $cond .= "             and r69_dtafast <= ".db_sqlformat(  $fim ) .")";
  $cond .= "        or ( r69_dtafast < ".db_sqlformat($inicio ) ;
  $cond .= "             and r69_dtretorno >= ".db_sqlformat($inicio ).")";
  $cond .= "        or ( r69_dtretorno >  ".db_sqlformat($fim );
  $cond .= "             and r69_dtafast < ".db_sqlformat($inicio )."))";
  $cond .= " left outer join afasta ";
  $cond .= "    on r45_anousu = ".db_sqlformat( db_substr($subpes,1,4) )  ;
  $cond .= "   and r45_mesusu = ".db_sqlformat( db_substr($subpes,6,2) )  ;
  $cond .= "   and r45_regist = ".db_sqlformat( $registro );
  $cond .= "   and (   ( r45_dtafas <= ".db_sqlformat( $fim ) ;
  $cond .= "             and r45_dtreto is null ) ";
  $cond .= "        or ( r45_dtafas >= ".db_sqlformat( $inicio );
  $cond .= "             and r45_dtreto <= ".db_sqlformat( $fim ).")";
  $cond .= "        or ( r45_dtreto > ".db_sqlformat( $fim ) ;
  $cond .= "             and r45_dtafas >= ".db_sqlformat ($inicio) ;
  $cond .= "             and r45_dtafas <= ".db_sqlformat(  $fim ) .")";
  $cond .= "        or ( r45_dtafas < ".db_sqlformat($inicio ) ;
  $cond .= "             and r45_dtreto >= ".db_sqlformat($inicio ).")";
  $cond .= "        or ( r45_dtreto >  ".db_sqlformat($fim );
  $cond .= "             and r45_dtafas < ".db_sqlformat($inicio )."))";
  $cond .= " where r01_anousu = ".db_sqlformat( db_substr($subpes,1,4) )  ;
  $cond .= "   and r01_mesusu = ".db_sqlformat( db_substr($subpes,6,2) )  ;
  $cond .= "   and r01_regist = ".db_sqlformat( $registro );
  $cond .= "   and ( r45_regist is not null or r69_regist is not null ) ";

  $retornos = false;
  global $afastamentos;
  db_selectmax( "afastamentos" , $cond ) ;
  if( count($afastamentos) > 0){
     $retornos = true ;
  }
  return $retornos;
}

function afas_periodo_aquisitivo ($periodoi, $periodof ){

  global $pessoal, $Ipessoal,$cfpess,$afasta;

  $desconta_dias = 0;
  if( $pessoal[0]["r01_tbprev"] == $cfpess[0]["r11_tbprev"]){
     $desconta_dias = 15;
  }
  $periodo_afastado = 0;
  $condicaoaux = " and r45_regist =". db_sqlformat( $pessoal[0]["r01_regist"] )." order by r45_regist, r45_dtafas desc ";
  if( db_selectmax( "afasta", "select * from afasta ".bb_condicaosubpes( "r45_").$condicaoaux )){
     for($Iafasta=0;$Iafasta< count($afasta);$Iafasta++){
        if( db_at(db_str($afasta[$Iafasta]["r45_situac"],1),"5-2-4-7")>0){
           continue;
        }
        if(  db_at(db_str( $afasta[$Iafasta]["r45_situac"],1 ) , "3-6")>0 ){
           if( !db_empty($afasta[$Iafasta]["r45_dtreto"]) && (db_mktime($afasta[$Iafasta]["r45_dtreto"]) < db_mktime($periodoi))){
               continue;
           }
           if( (db_mktime($afasta[$Iafasta]["r45_dtafas"]) - (15*86400)) > db_mktime($periodof)){
              continue;
           }
           if( !db_empty($afasta[$Iafasta]["r45_dtreto"]) && (db_mktime($afasta[$Iafasta]["r45_dtreto"]) > db_mktime($periodoi)) ){
              if( (db_mktime($afasta[$Iafasta]["r45_dtafas"])-db_mktime($desconta_dias)) > db_mktime($periodoi)){
                 if(db_mktime($afasta[$Iafasta]["r45_dtreto"]) > db_mktime($periodof)) {
		    $periodo_afastado += ceil(((db_mktime($periodof) - db_mktime($afasta[$Iafasta]["r45_dtafas"]) - db_mktime($desconta_dias))/86400));
		 }else{
                    $periodo_afastado += ceil(((db_mktime($afasta[$Iafasta]["r45_dtreto"]) - db_mktime($afasta[$Iafasta]["r45_dtafas"]) - db_mktime($desconta_dias))/86400));
		 }
              }else{
                 $periodo_afastado += db_datedif($afasta[$Iafasta]["r45_dtreto"],$periodoi);
              }
              continue;
           }
           if( !db_empty($afasta[$Iafasta]["r45_dtreto"])
              && (db_mktime($afasta[$Iafasta]["r45_dtreto"]) > db_mktime($periodof))
              && (db_mktime($afasta[$Iafasta]["r45_dtafas"])-db_mktime($desconta_dias) ) < db_mktime($periodof) ){
              if( (db_mktime($afasta[$Iafasta]["r45_dtafas"])-db_mktime($desconta_dias)) > db_mktime($periodoi)){
                 $periodo_afastado += ceil(((db_mktime($periodof) - db_mktime($afasta[$Iafasta]["r45_dtafas"]) - db_mktime($desconta_dias))/86400));
              }else{
                 $periodo_afastado += db_datedif($periodof,$periodoi);
              }
           }
           if( db_empty( $afasta[$Iafasta]["r45_dtreto"] ) && (db_mktime($afasta[$Iafasta]["r45_dtafas"]) - db_mktime($desconta_dias) ) < db_mktime($periodof) ) {
              if( (db_mktime($afasta[$Iafasta]["r45_dtafas"])-db_mktime($desconta_dias)) < db_mktime($periodoi)){
                 $periodo_afastado += db_datedif($periodof,$periodoi);
              }else{
                 $periodo_afastado += ceil(((db_mktime($periodof) - db_mktime($afasta[$Iafasta]["r45_dtafas"]) - db_mktime($desconta_dias))/86400));
              }
           }
        }
     }
  }

  return $periodo_afastado;

}

function db_nulldata($string){

  $string = trim($string);
  if(empty($string) || trim($string) == "--"){
    return 'null';
  }else{
    return $string;
  }

}

function db_ascan($the_array,$search_value) {
   if( ($i = array_search($search_value, $the_array)) !== FALSE)  {
       return $i;
   }else{
       return 0;
   }
}


function db_int($value) {
$value = (int)$value;
return $value;
}


/// salario_base ///

function salario_base($pessoal,$Ipessoal,$cfuncao = ""){
  global $subpes,$d08_carnes,$cfpess,$diversos;

  global $F001, $F002, $F004, $F005, $F006,
         $F007, $F008, $F009, $F010, $F011,
         $F012, $F013, $F014, $F015, $F016,
         $F017, $F018, $F019, $F020, $F021,
         $F022, $F023, $F006_clt, $F024, $F003, $F025, $F026, $F027, $F028;
 
  global $quais_diversos;
  eval($quais_diversos);

			       
  global $padroes;
  
  $F007 = 0;
  $F010 = 0;
  $diversominimo = "    ";
  if( !db_empty($pessoal[$Ipessoal]["r01_salari"])){
     $F007 = $pessoal[$Ipessoal]["r01_salari"];
     
     $F010 = $pessoal[$Ipessoal]["r01_salari"];
//echo "<BR> 1 F010 --> $F010";		
 }else{
     $condicaoaux  = " and r02_regime = ".db_sqlformat( $pessoal[$Ipessoal]["r01_regime"] );
     $condicaoaux .= " and r02_codigo = ".db_sqlformat( $pessoal[$Ipessoal]["r01_padrao"]);
     global $padroes;
     if( db_selectmax( "padroes", "select * from padroes ".bb_condicaosubpes( "r02_" ).$condicaoaux )){
	if( strtolower($padroes[0]["r02_tipo"]) == "h"){
	   $valor_padrao = bb_round($padroes[0]["r02_valor"]*$F008,2);
	}else{
	   $valor_padrao = $padroes[0]["r02_valor"];
	}
	if( !db_empty($pessoal[$Ipessoal]["r01_hrssem"]) && $padroes[0]["r02_hrssem"] > 0){
	   $F007 = $valor_padrao/$padroes[0]["r02_hrssem"]*$pessoal[$Ipessoal]["r01_hrssem"] ; 
	   $F010 = $valor_padrao/$padroes[0]["r02_hrssem"]*$pessoal[$Ipessoal]["r01_hrssem"] ; 
//echo "<BR> 2 F010 --> $F010";		
	}else{
	   $F007 = $valor_padrao;
	   $F010 = $valor_padrao;
//echo "<BR> 3 F010 --> $F010";		
	}
	$diversominimo = $padroes[0]["r02_minimo"];
     }else{
	$F007 = 0;
	$F010 = 0;
     }
  }
  if( strtolower($pessoal[$Ipessoal]["r01_progr"]) == "s"  && db_empty($pessoal[$Ipessoal]["r01_salari"])){
     $condicaoaux  = " and r24_regime = ".db_sqlformat( $pessoal[$Ipessoal]["r01_regime"] );
     $condicaoaux .= " and r24_padrao = ".db_sqlformat( $pessoal[$Ipessoal]["r01_padrao"] );
     $condicaoaux .= " order by r24_meses ";
     global $progress;
     if( db_selectmax( "progress", "select * from progress ".bb_condicaosubpes( "r24_" ).$condicaoaux )){
	$valor_progress = 0;
	if( $cfuncao == "gerfres" && strtolower($pessoal[$Ipessoal]["r01_tpvinc"]) == "a"){
	    $data_base = $pessoal[$Ipessoal]["r01_recis"];
	}else{
	    $data_base = (strtolower($pessoal[$Ipessoal]["r01_tpvinc"]) == "a" ? $cfpess[0]["r11_dataf"] : $pessoal[$Ipessoal]["r01_admiss"]);
	}
	$data_progr = (db_empty($pessoal[$Ipessoal]["r01_anter"]) ? $pessoal[$Ipessoal]["r01_admiss"] : $pessoal[$Ipessoal]["r01_anter"]);
	if( $cfuncao == "gerfres" && strtolower($pessoal[$Ipessoal]["r01_tpvinc"]) == "a"){
	  $anos = bb_round( ( db_year($data_base) - db_year($data_progr) ) * 12,2);
	}else{
	  $anos = $F024;
	}
	$perc = 0;
	for($Iprogress=0;$Iprogress<count($progress);$Iprogress++){
	  if($progress[$Iprogress]["r24_meses"] > $anos){
	    break;
	  }
	  $perc = $progress[$Iprogress]["r24_perc"];
	  $valor_progress = $progress[$Iprogress]["r24_valor"];
	}
	if( $valor_progress > 0){
	   $F010 = $valor_progress;
//echo "<BR> 2 F010 --> $F010";		
	   if( strtolower($padroes[0]["r02_tipo"]) == "h"){
	      $F010 = $F010 * $F008;
//echo "<BR> 3 F010 --> $F010";		
	   }
	}else{
	   $F010 += bb_round(($F007*bb_round($perc/100,2)),2);
//echo "<BR> 4 F010 --> $F010";		
	}
     }
  }

  if( !db_empty( $diversominimo )){
     $condicaoaux = " and r07_codigo = ".db_sqlformat($diversominimo);
     global $diversos_;
     db_selectmax( "diversos_", "select * from pesdiver ".bb_condicaosubpes( "r07_" ).$condicaoaux );
     $valormin = $diversos_[0]["r07_valor"];
     if( $F010 < $valormin){
	$F010 = $valormin ;
//echo "<BR> 5 F010 --> $F010";		
     }
  }

}





?>
