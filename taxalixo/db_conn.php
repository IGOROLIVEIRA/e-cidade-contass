<?

$DB_BASE_ORIGEM = "bage";
$DB_IP_ORIGEM = "192.168.78.7";
$DB_PORTA_ORIGEM = "5432";

$DB_BASE_DESTINO = "daeb";
$DB_IP_DESTINO = "192.168.77.2";
$DB_PORTA_DESTINO = "5432";

function conecta($DB_SERVIDOR, $DB_BASE, $DB_PORTA, $log) {
  
  $DB_USUARIO = "postgres";
  $DB_SENHA = "";
  
//  db_msg("conectando a base $DB_BASE do servidor $DB_SERVIDOR na porta $DB_PORTA", $log);
  
  if(!($conexao = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA")) ) {
    echo "erro ao conectar...\n";
    exit;
  }
  
  return $conexao;
  
}

function executa($conexao, $comando, $log) {
  //	db_msg($comando, $log);
  $resultado = pg_exec($conexao, $comando) or die($comando);
  return $resultado;
}

function inicialog($nomearq) {
  $arqgerado=str_replace(".php", "", $nomearq) . "_" . time() . ".log";
  $log=fopen($arqgerado,'w+');
  //fputs($log,"-- INICIO: " . time() . "\n");
  return $log;
}

function fimlog($log) {
//  fputs($log,"-- FIM: " . time() . "\n\n");
  fclose($log);
}

function db_msg($msg, $log, $quebra=true) {
  if ($log == null) {
    die("falta especificar log ao exibir mensagem: $msg\n");
  }
  $msg=$msg . ($quebra==true?"\n":"");
  echo $msg;
  fputs($log,$msg);
}

function db_fieldsmemory($recordset,$indice,$formatar="",$mostravar=false){
  //#00#//db_fieldsmemory
  //#10#//Esta funcao cria as variáveis de uma determinada linha de um record set, sendo o nome da variável
  //#10#//o nome do campo no record set e seu conteúdo o conteúdo da variável
  //#15#//db_fieldsmemory($recordset,$indice,$formatar="",$mostravar=false);
  //#20#//Record Set        : Record set que será pesquisado
  //#20#//Indice            : Número da linha (índice) que será caregada as funções
  //#20#//Formatar          : Se formata as variáveis conforme o tipo no banco de dados
  //#20#//                    true = Formatar      false = Não Formatar (Padrão = false)
  //#20#//Mostrar Variáveis : Mostrar na tela as variáveis que estão sendo geradas
  //#99#//Esta função é bastante utilizada quando se faz um for para percorrer um record set.
  //#99#//Exemplo: 
  //#99#//db_fieldsmemory($result,0);
  //#99#//Cria todas as variáveis com o conteúdo de cada uma sendo o valor do campo
  $fm_numfields = pg_numfields($recordset);
  for ($i = 0;$i < $fm_numfields;$i++){
    $matriz[$i] = pg_fieldname($recordset,$i);
    global $$matriz[$i];
    $aux = trim(pg_result($recordset,$indice,$matriz[$i]));
    if(!empty($formatar)) {
      switch(pg_fieldtype($recordset,$i)) {
        case "float8":
        case "float4":
        case "float":
        $$matriz[$i] = number_format($aux,2,".","");
        if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
        break;
        case "date":
        if($aux!=""){
          $data = explode("-",$aux);
          $$matriz[$i] = $data[2]."/".$data[1]."/".$data[0];
        }else{
          $$matriz[$i] = "";
        }
        if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
        break;
        default:
        $$matriz[$i] = $aux;		  		
        if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
        break;
      }
    } else
    switch(pg_fieldtype($recordset,$i)) {
      case "date":
      $datav = explode("-",$aux);
      $split_data = $matriz[$i]."_dia";
      global $$split_data;
      $$split_data =  @$datav[2];	
      if($mostravar==true) echo $split_data."->".$$split_data."<br";
      $split_data = $matriz[$i]."_mes";
      global $$split_data;
      $$split_data =  @$datav[1];	
      if($mostravar==true) echo $split_data."->".$$split_data."<br>";
      $split_data = $matriz[$i]."_ano";
      global $$split_data;
      $$split_data =  @$datav[0];	 
      if($mostravar==true) echo $split_data."->".$$split_data."<br>";
      $$matriz[$i] = $aux;		  		
      if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
      break;
      default:
      $$matriz[$i] = $aux;		  		
      if($mostravar==true) echo $matriz[$i]."->".$$matriz[$i]."<br>";
      break;
    }
  }
}

function db_endereco($endtrocar) {
  $er = ',[ ][0-9]*[ ]';
  $texto = $endtrocar;
  global $numero;
  global $ender;
  global $compl;
  if(ereg($er,$texto,$matriz)) {
    $numero = trim(substr($matriz[0],2,9));
    $xender = explode($matriz[0],$texto);
    $ender  = $xender[0];
    $compl  = trim(substr($xender[1],1,20));
  } else {
    $ender  = substr($arquivo[$i],135,40);
    $numero = 0;
    $compl  = "";
  }
  
}

function db_testaduplo($nome,$endereco,$numero,$cidade,$uf,$cpf){
  
  // cgc cnpj
  
  $_achou = false;
  
  if (strlen(ltrim($nome)) == 0) return 0;
  
  if (strlen($cpf) > 0) {
    
    $sql6 = "select z01_numcgm from cgm where z01_cgccpf = '$cpf'";
    $result6 = pg_exec($sql6);
    if ($result6 == false) {
      echo "sql executado: $sql6\n";
      return 9999999999;
    }
    
    if ($result6 != false) {
      if (pg_numrows($result6) > 0) {
        $_achou = true;
      }
    }
  }
  
  if ($_achou == false) {
    
    // nome, endereco, numero, cidade, uf...
    
    $sql6 = "select z01_numcgm from cgm where z01_nome = '$nome' and z01_ender = '$endereco' and z01_numero = $numero and z01_munic = '$cidade' and z01_uf = '$uf'";
    $result6 = pg_exec($sql6);
    if ($result6 == false) {
      echo "sql executado: $sql6\n";
      return 9999999999;
    }
    //echo "nome: $nome - " . pg_numrows($result6) . "\n";
    if (pg_numrows($result6) > 0) {
      $_achou = true;
    }
    
  }
  
  if ($_achou == false) {
    return 0;
  } else {
    return pg_result($result6,0);
  }
  
}
function troca_aspas( $string ){
  
  $string   = str_replace( "'", "'||chr(39)||'", $string ); //troca aspas simples por chr(39)
  return $string;
}

function busca_usuario( $conn1, $str_login ) {
  //db_usuarios - login
  
  $str_sql = "select id_usuario from DB_USUARIOS
  where login = '" . trim($str_login) . "'";
  $res_db_usuarios = pg_exec( $conn1, $str_sql ) or die ( "FALHA: $str_sql \n" );
  $int_linhas = pg_num_rows( $res_db_usuarios );
  if( $int_linhas == 0 )
  $id_usuario = 1;
  else{
    $row = pg_fetch_row( $res_db_usuarios );
    $id_usuario = $row[0]; 
  }
  return $id_usuario;
}  

function db_formatar($str, $tipo, $caracter = " ", $quantidade = 0, $TipoDePreenchimento = "e", $casasdecimais = 2) {
		//#00#//db_formatar
		//#10#//Esta funcao coloca a mascara no numpre SEM os pontos entre os número
		//#15#//db_formatar($str,$tipo,$caracter=" ",$quantidade=0,$TipoDePreenchimento="e",$casasdecimais=2) {
		//#20#//Str                   : String que será formatada
		//#20#//Tipo                  : Tipo de formatação que será executada
		//#20#//                        cpf  =  Formata para CPF
		//#20#//                        cnpj =  Formata para CNPJ
		//#20#//                        b    =  Formata falso ou verdadeiro (S = Verdadeiro N = Falso )
		//#20#//                        p    =  Formata ponto flutuante, com PONTO na casa decimal Ex: 1000.55
		//#20#//                        f    =  Formata ponto flutuante, com VIRGULA na casa decimal Ex: 1000,55
		//#20#//                        d    =  Formata data
		//#20#//                        s    =  Formata uma string alinhando conforme Tipo de Preenchimento
		//#20#//                        v    =  Variavel, ou seja, imprime quantas casas decimais o valor tiver, combustivel por exemplo, valor de 1,359
		//#20#//Caracter              : Caracter que será colocado para formatar
		//#20#//Quantidade            : Tamanho da string que será gerada
		//#20#//Tipo de Preenchimento : Se preenche a esquerda, direito ou centro
		//#20#//                        e = Esquerda   d = Direita  a = Centro
		//#20#//Casas Decimais        : Número de casas decimais, para valores flutuantes, que será gerada
		//#40#//String formatada conforme os parâmetros
		//#99#//Exemplo:
		//#99#//db_formatar(100.55,'f','0',15,'e',2)
		//#99#//Retorno será : 000000000100,55
		//#99#//db_formatar(100.55,'f') // formatação padrão de números
		//#99#//Retorno será : "         100,55"
		//#99#//
		//#99#//db_formatar(100.55,'p','0',15,'e',2)
		//#99#//Retorno será : 000000000100.55

		switch ($tipo) {
		  case "sistema" :
		    return substr($str, 0, 1).".".substr($str, 1, 1).".".substr($str, 2, 1).".".substr($str, 3, 1).".".substr($str, 4, 1).".".substr($str, 5, 2).".".substr($str, 7, 2).".".substr($str, 9, 2).".".substr($str, 11, 2);
		  case "receita" :
		    return substr($str, 0, 1).".".substr($str, 1, 1).".".substr($str, 2, 1).".".substr($str, 3, 1).".".substr($str, 4, 1).".".substr($str, 5, 2).".".substr($str, 7, 2).".".substr($str, 9, 2).".".substr($str, 11, 2).".".substr($str, 13, 2);
		  case "receita_int" :
		    return substr($str, 0, 1).".".substr($str, 1, 1).".".substr($str, 2, 1).".".substr($str, 3, 1).".".substr($str, 4, 1).".".substr($str, 5, 2).".".substr($str, 7, 2).".".substr($str, 9, 2).".".substr($str, 11, 2).".".substr($str, 13, 2);
		  case "orgao" :
		    return str_pad($str, 2, "0", STR_PAD_LEFT);
		  case "unidade" :
		    return str_pad($str, 2, "0", STR_PAD_LEFT);
		  case "funcao" :
		    return str_pad($str, 2, "0", STR_PAD_LEFT);
		  case "subfuncao" :
		    return str_pad($str, 3, "0", STR_PAD_LEFT);
		  case "programa" :
		    return str_pad($str, 4, "0", STR_PAD_LEFT);
		  case "projativ" :
		    return str_pad($str, 4, "0", STR_PAD_LEFT);
		  case "elemento_int" :
		    return substr($str, 0, 1).".".substr($str, 1, 1).".".substr($str, 2, 1).".".substr($str, 3, 1).".".substr($str, 4, 1).".".substr($str, 5, 2).".".substr($str, 7, 2).".".substr($str, 9, 2).".".substr($str, 11, 2);
		  case "elemento" :
		    return substr($str, 1, 1).".".substr($str, 2, 1).".".substr($str, 3, 1).".".substr($str, 4, 1).".".substr($str, 5, 2).".".substr($str, 7, 2).".".substr($str, 9, 2).".".substr($str, 11, 2);
		  case "recurso" :
		    return str_pad($str, 4, "0", STR_PAD_LEFT);
		  case "atividade" :
		    return str_pad($str, 4, "0", STR_PAD_LEFT);
		  case "cpf" :
		    return substr($str, 0, 3).".".substr($str, 3, 3).".".substr($str, 6, 3)."/".substr($str, 9, 2);
		  case "cep" :
		    return substr($str, 0, 2).".".substr($str, 2, 3)."-".substr($str, 5, 3);
		  case "cnpj" :
		    return substr($str, 0, 2).".".substr($str, 2, 3).".".substr($str, 5, 3)."/".substr($str, 8, 4)."-".substr($str, 12, 2);
		    //90.832.619/0001-55
		  case "b" :
		    // boolean
		    if ($str == false) {
		      return 'N';
		    } else {
		      return 'S';
		    }
		  case "p" :
		    // ponto decimal com "."
		    /*
		    if (strpos($str,".") != 0) {
		    if (strpos($str,",") == 0) {
		    $casasdecimais = strlen($str) - strpos($str,".") - 1;
		    if ($casasdecimais < 2) {
		    $casasdecimais = 2;
		    }
		    }
		    }
		    */
		    if ($quantidade == 0)
		    return str_pad(number_format($str, $casasdecimais, ".", ""), 15, "$caracter", STR_PAD_LEFT);
		    else
		    return str_pad(number_format($str, $casasdecimais, ".", ""), $quantidade, "$caracter", STR_PAD_LEFT);
		  case "v" :
		    // ponto decimal com virgula
		    if (strpos($str, ".") != 0) {
		      if (strpos($str, ",") == 0) {
		        $casasdecimais = strlen($str) - strpos($str, ".") - 1;
		        if ($casasdecimais < 2) {
		          $casasdecimais = 2;
		        }
		      }
		    }
		    if ($quantidade == 0)
		    if ($str == 0)
		    return "   ".str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else
		    return str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else {
		      //        return str_pad(number_format($str,$casasdecimais,",","."),$quantidade,"$caracter",STR_PAD_LEFT);
		      $vlrreturn = str_pad(number_format($str, $casasdecimais, ",", "."), $quantidade +1, "$caracter", STR_PAD_LEFT);
		      $posponto = strpos($vlrreturn, ",");
		      return substr($vlrreturn, 0, $posponto + $quantidade +1);
		    }
		  case "vdec" :
		    // ponto decimal sem virgula
		    if (strpos($str, ".") != 0) {
		      if (strpos($str, ",") == 0) {
		        $casasdecimais = strlen($str) - strpos($str, ".") - 1;
		        if ($casasdecimais < 2) {
		          $casasdecimais = 2;
		        }
		      }
		    }
		    if ($quantidade == 0)
		    if ($str == 0)
		    return "   ".str_pad(number_format($str, $casasdecimais, ".", ""), 15, "$caracter", STR_PAD_LEFT);
		    else
		    return str_pad(number_format($str, $casasdecimais, ".", ""), 15, "$caracter", STR_PAD_LEFT);
		    else {
		      $vlrreturn = str_pad(number_format($str, $casasdecimais, ".", ""), $quantidade +1, "$caracter", STR_PAD_LEFT);
		      $posponto = strpos($vlrreturn, ".");
		      return substr($vlrreturn, 0, $posponto + $quantidade +1);
		    }
		  case "valsemform" :

		    if ($quantidade == 0)
		    if ($str == 0)
		    $valretornar = "   ".str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else
		    $valretornar = str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else
		    $valretornar = str_pad(number_format($str, $casasdecimais, ",", "."), $quantidade, "$caracter", STR_PAD_LEFT);

		    $valretornar = str_replace(",","",$valretornar);
		    $valretornar = str_replace(".","",$valretornar);
		    return str_pad($valretornar,$quantidade," ",STR_PAD_LEFT);

		  case "f" :
		    // ponto decimal com virgula
		    /*
		    if (strpos($str,".") != 0) {
		    if (strpos($str,",") == 0) {
		    $casasdecimais = strlen($str) - strpos($str,".") - 1;
		    if ($casasdecimais < 2) {
		    $casasdecimais = 2;
		    }
		    }
		    }
		    */
		    if ($quantidade == 0)
		    if ($str == 0)
		    return "   ".str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else
		    return str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else
		    return str_pad(number_format($str, $casasdecimais, ",", "."), $quantidade, "$caracter", STR_PAD_LEFT);
		  case "fff" :
		    // ponto decimal com virgula

		    if ($quantidade == 0)
		    if ($str == 0)
		    return "   ".str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else
		    return str_pad(number_format($str, $casasdecimais, ",", "."), 15, "$caracter", STR_PAD_LEFT);
		    else
		    return str_pad(number_format($str, $casasdecimais, ",", "."), $quantidade, "$caracter", STR_PAD_LEFT);
		  case "d" :

		    if ($str != "") {
		      $data = explode("-", $str);
		      return $data[2]."/".$data[1]."/".$data[0];
		    } else {
		      return $str;
		    }
		  case "s" :
		    if ($TipoDePreenchimento == "e") {
		      return str_pad($str, $quantidade, $caracter, STR_PAD_LEFT);
		    } else
		    if ($TipoDePreenchimento == "d") {
		      return str_pad($str, $quantidade, $caracter, STR_PAD_RIGHT);
		    } else
		    if ($TipoDePreenchimento == "a") {
		      return str_pad($str, $quantidade, $caracter, STR_PAD_BOTH);
		    }
		  case "xxxv" : // antigo "v"
		    if (strpos($str, ",") != "") {
		      $str = str_replace(".", "", $str);
		      $str = str_replace(",", ".", $str);
		      return $str;
		    } else
		    if (strpos($str, "-") != "") {
		      $str = explode("-", $str);
		      return $str[2]."-".$str[1]."-".$str[0];
		    } else
		    if (strpos($str, "/") != "") {
		      $str = explode("/", $str);
		      return $str[2]."-".$str[1]."-".$str[0];
		    }
		    break;
		}
		return false;
}


?>
