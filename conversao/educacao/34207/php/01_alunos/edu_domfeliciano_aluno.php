<?

// Seta Nome do Script
$sNomeScript = basename(__FILE__);

require (__DIR__ . "/../../libs/db_conecta.php");

db_log("\n ", $sArquivoLog, 0, true, true);
db_log("Conectando", $sArquivoLog, 0, true, true);
db_log("\n ", $sArquivoLog, 0, true, true);
pg_query($pConexaoDestino1,"select fc_startsession()");
pg_query($pConexaoDestino1,"begin");

system("clear");
set_time_limit(0);

$naotem = false;
for($dd=51;$dd<=59;$dd++){

  $verif_escola = pg_query("SELECT ed18_i_codigo from escola WHERE ed18_i_codigo = $dd");
  if(pg_num_rows($verif_escola)==0){

    $naotem = true;
    break;

  }

}
if($naotem==true){

  db_log("\n ", $sArquivoLog, 0, true, true);
  db_log("Escolas 51,52,53,54,55,56,57,58,59 devem estar previamente cadastradas no sistema para proseeguir a migração dos dados. Migração abortada!", $sArquivoLog, 0, true, true);
  db_log("\n ", $sArquivoLog, 0, true, true);
  pg_exec("rollback");
  exit;

}

$tmp_aluno = "CREATE TABLE tmp_aluno (id_infotec integer,id_dbportal integer,codarquivo integer) ";
$query = pg_query($tmp_aluno);

$dir = "Alunos/";
db_log("Iniciando inclusao de alunos!", $sArquivoLog, 0, true, true);
// Abre um diretorio conhecido, e faz a leitura de seu conteudo
if(is_dir($dir)){
  if($dh = opendir($dir)){

    while((($file = readdir($dh)) !== false)){

      $extension = explode( ".", $file );
      if($file != "." && $file != ".." && @$extension[1] == "txt" ){

        $filename=$dir.$file;
        insere_aluno( $filename, $sArquivoLog );

      }

    }
    closedir($dh);
  }

}else{

  echo "\n\n  DiretÃ³rio invÃ¡lido \n\n ";
  exit;

}

function maiusculo(&$string){

  $string = strtoupper($string);
  $string = str_replace("Ã¡","Ã",$string);
  $string = str_replace("Ã©","Ã",$string);
  $string = str_replace("Ã­","Ã",$string);
  $string = str_replace("Ã³","Ã",$string);
  $string = str_replace("Ãº","Ã",$string);
  $string = str_replace("Ã¢","Ã",$string);
  $string = str_replace("Ãª","Ã",$string);
  $string = str_replace("Ã´","Ã",$string);
  $string = str_replace("Ã®","Ã",$string);
  $string = str_replace("Ã»","Ã",$string);
  $string = str_replace("Ã£","Ã",$string);
  $string = str_replace("Ãµ","Ã",$string);
  $string = str_replace("Ã§","Ã",$string);
  $string = str_replace("Ã ","Ã",$string);
  $string = str_replace("Ã¨","Ã",$string);
  return $string;

}
function tiratracos(&$string){

  $string = str_replace("[","",$string);
  $string = str_replace("]","",$string);
  $string = str_replace("(","",$string);
  $string = str_replace(")","",$string);
  $string = str_replace("_","",$string);
  $string = str_replace("-","",$string);
  $string = str_replace(".","",$string);
  return $string;

}
function TiraAcento($string){

  set_time_limit(240);
  $acentos = 'áéíóúÁÉÍÓÚàÀÂâÊêôÔüÜïÏöÖñÑãÃõÕçÇªºäÄ\'';
  $letras  = 'AEIOUAEIOUAAAAEEOOUUIIOONNAAOOCCAOAA ';
  $new_string = '';
  for($x=0; $x<strlen($string); $x++){
  
    $let = substr($string, $x, 1);
    for($y=0; $y<strlen($acentos); $y++){
 
      if($let==substr($acentos, $y, 1)){
   
        $let=substr($letras, $y, 1);
        break;
    
      }
    }
     $new_string = $new_string . $let;
  }
  return $new_string;

}

// Tabela de Cod Infotec equivalente DB Portal 
function inclusao($id_infotec,$id_dbportal,$cod_arquivo){

  $tmp_aluno = "INSERT INTO tmp_aluno VALUES($id_infotec,$id_dbportal,$cod_arquivo)";
  $query = pg_query($tmp_aluno);

}

function insere_aluno( $filename, $sArquivoLog ){

  $cod_arquivo = substr($filename,7,2);
  
  $ponteiro = fopen($filename,"r");
  while (!feof($ponteiro)){
     
    $linha = fgets($ponteiro,500);
    if($linha == "" ){

       continue;

    }
    $array_linha = explode("|",$linha);
    $array_linha[0] = trim($array_linha[0]);
    $array_linha[1] = trim(strtoupper(maiusculo(TiraAcento($array_linha[1]))));
    $array_linha[2] = trim(strtoupper(maiusculo(TiraAcento($array_linha[2]))));
    $array_linha[3] = trim(strtoupper(maiusculo(TiraAcento($array_linha[3]))));
    $array_linha[4] = trim(strtoupper(maiusculo(TiraAcento($array_linha[4]))));
    $array_linha[5] = trim($array_linha[5]);
    $array_linha[6] = trim(strtoupper(maiusculo(TiraAcento($array_linha[6]))));
    $array_linha[7] = trim(substr($array_linha[7],0,14));
    $array_linha[8] = trim(substr($array_linha[8],0,10));
    $array_linha[9] = trim(substr($array_linha[9],0,10));
    $array_linha[10] = trim(strtoupper(maiusculo(TiraAcento($array_linha[10]))));
    $array_linha[11] = trim(strtoupper(maiusculo(TiraAcento($array_linha[11]))));
    $array_linha[12] = trim(strtoupper(maiusculo(TiraAcento($array_linha[12]))));
    $array_linha[13] = trim(strtoupper(maiusculo(TiraAcento($array_linha[13]))));
    $array_linha[14] = trim(strtoupper(maiusculo(TiraAcento($array_linha[14]))));
    $array_linha[15] = trim(strtoupper(maiusculo(TiraAcento($array_linha[15]))));
    $array_linha[16] = trim(strtoupper(maiusculo(TiraAcento($array_linha[16]))));
    $array_linha[17] = trim(strtoupper(maiusculo(TiraAcento($array_linha[17]))));
    $array_linha[18] = trim(strtoupper(maiusculo(TiraAcento($array_linha[18]))));
    $array_linha[19] = trim(strtoupper(maiusculo(TiraAcento($array_linha[19]))));
    $array_linha[20] = trim(strtoupper(maiusculo(TiraAcento($array_linha[20]))));
    $array_linha[21] = trim(strtoupper(maiusculo(TiraAcento($array_linha[21]))));
    $array_linha[22] = trim(strtoupper(maiusculo(TiraAcento($array_linha[22]))));
    $array_linha[23] = trim(strtoupper(maiusculo(TiraAcento($array_linha[23]))));
    $array_linha[24] = trim(strtoupper(maiusculo(TiraAcento($array_linha[24]))));
    $array_linha[25] = trim(strtoupper(maiusculo(TiraAcento($array_linha[25]))));
    $array_linha[26] = trim(strtoupper(maiusculo(TiraAcento($array_linha[26]))));
    $array_linha[27] = trim(strtoupper(maiusculo(TiraAcento($array_linha[27]))));
    $array_linha[28] = trim(strtoupper(maiusculo(TiraAcento($array_linha[28]))));
    $array_linha[29] = trim(strtoupper(maiusculo(TiraAcento(substr($array_linha[29],0,4)))));
    $array_linha[30] = trim(strtoupper(maiusculo(TiraAcento($array_linha[30]))));
    $array_linha[31] = trim(strtoupper(maiusculo(TiraAcento($array_linha[31]))));
    $array_linha[32] = trim(strtoupper(maiusculo(TiraAcento($array_linha[32]))));
    $array_linha[33] = trim($array_linha[33]);
    $array_linha[34] = trim($array_linha[34]);
    $array_linha[35] = trim(strtoupper(maiusculo(TiraAcento($array_linha[35]))));
    $array_linha[36] = trim(strtoupper(maiusculo(TiraAcento($array_linha[36]))));
    $array_linha[37] = trim(strtoupper(maiusculo(TiraAcento($array_linha[37]))));
    $array_linha[38] = trim(strtoupper(maiusculo(TiraAcento($array_linha[38]))));
    $array_linha[39] = trim(strtoupper(maiusculo(TiraAcento($array_linha[39]))));
    $array_linha[40] = trim(strtoupper(maiusculo(TiraAcento($array_linha[40]))));
    $array_linha[41] = trim(strtoupper(maiusculo(TiraAcento($array_linha[41]))));
    $array_linha[42] = trim(strtoupper(maiusculo(TiraAcento($array_linha[42]))));
    $array_linha[43] = trim(strtoupper(maiusculo(TiraAcento($array_linha[43]))));
    $array_linha[44] = trim(strtoupper(maiusculo(TiraAcento($array_linha[44]))));
    $array_linha[45] = trim(strtoupper(maiusculo(TiraAcento($array_linha[45]))));
    $array_linha[46] = trim(strtoupper(maiusculo(TiraAcento($array_linha[46]))));
    if($filename == "Alunos/51_CAlves_54_OAranha_55_PVieira_58_SValentim.txt"){
          
      $array_linha[49] = "";
      $array_linha[52] = trim(strtoupper(maiusculo(TiraAcento($array_linha[50]))));
               
    }else{
      $array_linha[47] = trim(strtoupper(maiusculo(TiraAcento($array_linha[47]))));
      $array_linha[48] = trim(strtoupper(maiusculo(TiraAcento($array_linha[48]))));
      $array_linha[49] = trim(strtoupper(maiusculo(TiraAcento($array_linha[49]))));
      $array_linha[50] = trim(strtoupper(maiusculo(TiraAcento($array_linha[50]))));
      $array_linha[51] = trim(strtoupper(maiusculo(TiraAcento($array_linha[51]))));
      $array_linha[52] = trim(strtoupper(maiusculo(TiraAcento($array_linha[52]))));
    }
    // array_ [3] ed47_v_bairro
    if($array_linha[3] == "INTERIOR"){

      $sZonaAluno = "RURAL" ;

    }else{

      $sZonaAluno = "URBANO" ;

    }
    // array_ [4] ed47_i_censomunicend
    $w = $array_linha[4];
    $aCidadeAluno = "$w";
    $aCidadeAluno = array(
                          "DOM FELICIANO"=>"4306502",
                          ""=>"4306502",
                          "CENTRO"=>"4306502",
                          "DDDOM FELICIANO"=>"4306502",
                          "DOM FELCIANO"=>"4306502",
                          "DOM FELICANO"=>"4306502",
                          "DOM FELICIAN"=>"4306502",
                          "DOM  FELICIANO"=>"4306502",
                          "DOMM FELICIANO"=>"4306502",
                          "SAO JERONIMO"=>"4318408"
                         );
    // array_ [6] ed47_i_censoufend
    if($array_linha[6] == "RS"){

      $nEstadoAluno = 43;

    }else{

      $nEstadoAluno = 'null';

    }
    // array_ [7] ed47_v_telefone
    $array_linha[7] = tiratracos($array_linha[7]);
    // array_ [8] ed47_d_dataBCG
    if($array_linha[8] != ""){

      $dataBCG = explode("-", $array_linha[8]);
      $dataBCG = "Data BCG ".$dataBCG[2]."/".$dataBCG[1]."/".$dataBCG[0];

    }else{

      $dataBCG = "";

    }
    // array_ [9] ed47_d_cadast
    $array_linha[9] = date("Y-m-d");
    // array_ [10] ed47_d_nasc
    if($array_linha[10] !=""){

      $array_linha[10] = substr($array_linha[10],0,10);
    }else{

      $array_linha[10] = date("d-m-Y");

    }
    // array_ [14] ed47_t_obs tel_trabalho
    $array_linha[14] = tiratracos($array_linha[14]);
    // array_ [19] ed47_v_contato tel_pai
    $array_linha[19] = tiratracos($array_linha[19]);
    // array_ [15 e 20] ed47_i_filiacao
    if($array_linha[15] != "" or $array_linha[20] != "" ){

      $nFiliacaoAluno = '1' ;

    }else{

      $nFiliacaoAluno = '0';

    }
    // array_ [24] ed47_t_obs tel_mae
    $array_linha[24] = tiratracos($array_linha[24]);
    // array_ [27] ed47_t_obs tel_responsavel
    $array_linha[27] = tiratracos($array_linha[27]);
    // array_ [28] ed47_c_certidaonum
    $array_linha[28] = substr(tiratracos($array_linha[28]),0,8);
    // array_ [34] ed47_v_cpf
    $array_linha[34] = substr(tiratracos($array_linha[34]),0,11);
    // array_ [44] ed47_i_censomunicnat
    $array_linha[44] = tiratracos($array_linha[44]);
    $x = $array_linha[44];
    $aCidadeNatural = "$x";
    $aCidadeNatural = array(
                             ""=>"4306502",
                             "BRASILEIRA"=>"4306502",
                             "CAMAQUA"=>"4303509",
                             "DOM FELICIANO"=>"4306502",
                             "DOM  FELICIANO"=>"4306502",
                             "ENCRUZILHADA DO SUL"=>"4306908",
                             "GUAIBA"=>"4309308",
                             "PELOTAS"=>"4314407",
                             "PORTO ALEGRE"=>"4314902",
                             "CANOAS"=>"4304606",
                             "PORTO ALEGRE  CANOAS"=>"4304606",
                             "RIO PARDO"=>"4315701",
                             "SANTA CRUZ DO SUL"=>"4316808",
                             "TAPES"=>"4321105",
                             "ARROIO DOS RATOS"=>"4301107",
                             "BRASILEIRO"=>"4306502",
                             "BUTIA"=>"4302709",
                             "CAMPO BOM"=>"4303905",
                             "CANDELARIA"=>"4304200",
                             "ELDORADO DO SUL"=>"4306767",
                             "ESTEIO"=>"4307708",
                             "GRAVATAI"=>"4309209",
                             "MINA DO LEAO"=>"4312252",
                             "OLIDIO ALMEIDA"=>"4306502",
                             "SANTA MARIA"=>"4316907",
                             "SANTA CRUZ"=>"4316808",
                             "SANTA VITORIA DO PALMAR"=>"4317301",
                             "SAO JERONIMO"=>"4318408",
                             "SAO LOURENCO DO SUL"=>"4318804",
                             "SAPUCAIA DO SUL"=>"4320008",
                             "SOLEDADE"=>"4320800",
                             "ALVORADA"=>"4300604",
                             "AMARAL FERRADOR"=>"4300638",
                             "BAGE"=>"4301602",
                             "BARAO DO TRIUNFO"=>"4301750",
                             "CAXIAS DO SUL"=>"4305108",
                             "CERRO LARGO URUGUAI"=>"null",
                             "CHARQUEADAS"=>"4305355",
                             "CURITIBA"=>"4106902",
                             "DISTRITO DE SINIMBU"=>"4320677",
                             "DOM EFLICANO"=>"4306502",
                             "DOM FELICANO"=>"4306502",
                             "DOM ELICIANO"=>"4306502",
                             "DOM FEICIANO"=>"4306502",
                             "DOM EFLICIANO"=>"4306502",
                             "DOM FELCIANO"=>"4306502",
                             "DOM FELICIAO"=>"4306502",
                             "FAXINAL"=>"4107603",
                             "HUMAITA"=>"4309704",
                             "PARANA"=>"2408607",
                             "SAO JOSE DO NORTE"=>"4318507",
                             "VIAMAO"=>"4323002",
                             "CACHOEIRA DO SUL"=>"4303004",
                             "CACHOEIRINHA"=>"4303103",
                             "CAMAQA"=>"4303509",
                             "CANARANA"=>"5102702",
                             "CANGUCU"=>"4304507",
                             "CHUVISCA"=>"4305447",
                             "DOM FELIANO"=>"4306502",
                             "ENCRUZILHADA"=>"2910404",
                             "FOZ DO IGUACU"=>"4108304",
                             "MINAS DO LEAO"=>"4312252",
                             "NOVO HAMBURGO"=>"4313409",
                             "PALMARES DO SUL"=>"4313656",
                             "TRIUNFO"=>"4322004",
                             "DOIM FELICIANO"=>"4306502",
                             "DOMFELICIANO"=>"4306502",
                             "ARROIO DO RATOS"=>"4301107",
                             "BARSILEIRO"=>"4306502",
                             "BRAILEIRO"=>"4306502",
                             "BRASAILEIRA"=>"4306502",
                             "BRASIELIRO"=>"4306502",
                             "BRASILERIA"=>"4306502",
                             "BRASILERIO"=>"4306502",
                             "BRASILERO"=>"4306502",
                             "CAPAO DA CANOA"=>"4304630",
                             "CERRO GRANDE DO SUL"=>"4305173",
                             "CIDREIRA"=>"4305454",
                             "CRUZ ALTA"=>"4306106",
                             "DOM FELICIANIO"=>"4306502",
                             "DOMM FELICIANO"=>"4306502",
                             "ENCRUZILHA DO SUL"=>"4306908",
                             "ESTANCIA VELHA"=>"4307609",
                             "NATURAL"=>"4306502",
                             "IRATI"=>"4207858",
                             "ITAPEVA"=>"3522406",
                             "MATUPA"=>"5105606",
                             "PANTANO GRANDE"=>"4313953",
                             "PARIQUERAACU"=>"3536208",
                             "PARIQUEIRA ACU"=>"3536208",
                             "RASILEIRO"=>"4306502",
                             "RIO GRANDE"=>"4315602",
                             "SAO LEOPOLDO"=>"4318705",
                             "SAO LEOPOLDP"=>"4318705",
                             "SAO LUIZ GONZAGA"=>"4318903",
                             "SAO PAULO"=>"3550308",
                             "SAPIRANGA"=>"4319901",
                             "SAPUCAI DO SUL"=>"4320008",
                             "UBERLANDIA"=>"3170206",
                             "URUGUAI"=>"null"
                            );
    // array_ [45] ed47_i_censoufnat
    $array_linha[45] = tiratracos($array_linha[45]);
    $y = $array_linha[45];
    $aEstadoNatural = "$y";
    $aEstadoNatural = array(
                            "RS"=>"43",
                            ""=>"null",
                            "PR"=>"41",
                            "MT"=>"51",
                            "SP"=>"35",
                            "MG"=>"31",
                            "SC"=>"42",
                            "BA"=>"29",
                            "RN"=>"24"
                           );

    if($array_linha[45] != ""){

      $iNacionalidade = '1' ;

    }else{

      $iNacionalidade = '3' ;

    }
    // ed47_i_pais nacionalidade
    if($iNacionalidade =='1'){

      $iPaisNacion = '10';

    }else{

      $iPaisNacion = '25';

    }
    // array_ [46] ed47_c_passivo
    if($array_linha[46] == "P"){

      $sSituPassivo = "S";

    }elseif($array_linha[46] == "A"){

      $sSituPassivo = "N";

    }else{

      $sSituPassivo = "" ;

    }
    // array_ [52] ed47_c_raca
    if($array_linha[52] == "PRETO" or $array_linha[52] == "PRETA"){

      $sRacaAluno = "PRETA" ;

    }elseif($array_linha[52] == "BRANCO" or $array_linha[52] == "BRANCA"){

      $sRacaAluno = "BRANCA" ;

    }elseif($array_linha[52] == "PARDO" or $array_linha[52] == "PARDA"){

      $sRacaAluno = "PARDA" ;

    }elseif($array_linha[52] == "AMARELO" or $array_linha[52] == "AMARELA"){

      $sRacaAluno = "AMARELA" ;

    }else{

      $sRacaAluno = "NAO DECLARADA";

    }
    $sql2  ="select ed47_i_codigo
                   ,ed47_v_nome
                   ,ed47_d_nasc
                   ,ed47_v_mae
                   from aluno where ed47_v_nome='$array_linha[1]'";
    $result2 = pg_query($sql2) or die("erro");
    $linhas = pg_num_rows($result2);
    if($array_linha[0]!=""){

      $erro_compara = false;
      if($linhas > 0 ){

        for($tt=0;$tt<$linhas;$tt++){

          $Nasc_banco = trim(pg_result($result2,$tt,'ed47_d_nasc'));
          $Mae_banco = trim(pg_result($result2,$tt,'ed47_v_mae'));
          $Aluno_banco = trim(pg_result($result2,$tt,'ed47_i_codigo'));
          $nome_banco = trim(pg_result($result2,$tt,'ed47_v_nome'));
          if($array_linha[10] == $Nasc_banco){

            $erro_compara = true;
            inclusao($array_linha[0],$Aluno_banco,$cod_arquivo);
            db_log("Aluno já existente: ".$nome_banco." - ".$array_linha[10], $sArquivoLog, 0, true, true);
            break;

          }
          if($array_linha[20] == trim($Mae_banco)){

            $erro_compara = true;
            inclusao($array_linha[0],$Aluno_banco,$cod_arquivo);
            db_log("Aluno já existente: ".$nome_banco." - ".$array_linha[20], $sArquivoLog, 0, true, true);
            break;

          }
        }
      }
      if($linhas == 0 ){

         $erro_compara = false;

      }
      if($erro_compara == false ){

        $sql4 = "INSERT INTO aluno (ed47_i_codigo
                                    ,ed47_v_nome
                                    ,ed47_v_ender
                                    ,ed47_v_bairro
                                    ,ed47_i_censomunicend
                                    ,ed47_v_cep
                                    ,ed47_i_censoufend
                                    ,ed47_v_telef
                                    ,ed47_t_obs
                                    ,ed47_d_cadast
                                    ,ed47_d_nasc
                                    ,ed47_v_profis
                                    ,ed47_v_pai
                                    ,ed47_v_contato
                                    ,ed47_v_mae
                                    ,ed47_c_nomeresp
                                    ,ed47_c_certidaonum
                                    ,ed47_c_certidaofolha
                                    ,ed47_c_certidaolivro
                                    ,ed47_v_ident
                                    ,ed47_v_cpf
                                    ,ed47_v_sexo
                                    ,ed47_i_censomunicnat
                                    ,ed47_i_censoufnat
                                    ,ed47_c_passivo
                                    ,ed47_c_raca
                                    ,ed47_i_pais
                                    ,ed47_i_filiacao
                                    ,ed47_i_transpublico
                                    ,ed47_i_nacion
                                    ,ed47_i_estciv
                                    ,ed47_d_ultalt
                                    ,ed47_c_bolsafamilia
                                    ,ed47_c_atenddifer
                                    ,ed47_c_zona
                                   )
                                   VALUES
                                   (nextval('aluno_ed47_i_codigo_seq')
                                    ,'$array_linha[1]'
                                    ,'$array_linha[2]'
                                    ,'$array_linha[3]'
                                    ,$aCidadeAluno[$w]
                                    ,'$array_linha[5]'
                                    ,$nEstadoAluno
                                    ,'$array_linha[7]'
                                    ,'$dataBCG - $array_linha[11] - $array_linha[13] - $array_linha[14] - $array_linha[31]                                                           - $array_linha[32] - $array_linha[35] - $array_linha[36] - $array_linha[37]                                                           - $array_linha[38] - $array_linha[39] - $array_linha[40] - $array_linha[41]                                                           - $array_linha[42] - $array_linha[49]'
                                    ,'$array_linha[9]'
                                    ,'$array_linha[10]'
                                    ,'$array_linha[12]'
                                    ,'$array_linha[15]'
                                    ,'$array_linha[15] - $array_linha[16] - $array_linha[17] - $array_linha[18]                                                                              - $array_linha[19] - $array_linha[20] - $array_linha[21]
                                                       - $array_linha[22] - $array_linha[23] - $array_linha[24]                                                                              - $array_linha[26] - $array_linha[27]'
                                    ,'$array_linha[20]'
                                    ,'$array_linha[25]'
                                    ,'$array_linha[28]'
                                    ,'$array_linha[29]'
                                    ,'$array_linha[30]'
                                    ,'$array_linha[33]'
                                    ,'$array_linha[34]'
                                    ,'$array_linha[43]'
                                    ,$aCidadeNatural[$x]
                                    ,$aEstadoNatural[$y]
                                    ,'$sSituPassivo'
                                    ,'$sRacaAluno'
                                    ,$iPaisNacion
                                    ,$nFiliacaoAluno
                                    ,0
                                    ,$iNacionalidade
                                    ,1
                                    ,'$array_linha[9]'
                                    ,'N'
                                    ,3
                                    ,'$sZonaAluno'
                                   )";
        $result4 = pg_query($sql4) or die("\n !Erro = ".pg_errormessage()." \n >>> SQL:".$sql4);
        if($result4 == true){

          $result = pg_query("select last_value from aluno_ed47_i_codigo_seq");
          $codAluno = pg_result($result,0,0);
          inclusao($array_linha[0],$codAluno,$cod_arquivo);

        }

      }

    }

  }
  fclose($ponteiro);

}
pg_exec("commit;");

// Final do Script
db_log("Processo inclusao de alunos encerrado!", $sArquivoLog, 0, true, true);
db_log("\n ", $sArquivoLog, 0, true, true);
include(__DIR__ . "/../../libs/db_final_script.php");
?>