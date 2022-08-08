<?

set_time_limit(0);

require(__DIR__ . "/../db_fieldsmemory.php");
require(__DIR__ . "/../db_conn.php");

if(!($conn = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
//if(!($conn = pg_connect("dbname=$DB_BASE port=$DB_PORTA user=$DB_USUARIO password=$DB_SENHA"))) {
  echo "erro ao conectar...\n";
  exit;
}
system("clear");

$dir = "bage20070927/";

// Abre um diretorio conhecido, e faz a leitura de seu conteudo
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while ( (($file = readdir($dh)) !== false)  ) {
           $extension = explode( ".", $file );
           if($file != "." && $file != ".." && $extension[1] == "pac" ){
               Insere_Aluno($dir.$file);
           }
        }
        closedir($dh);
    }
}





function Insere_Aluno( $arquivo ){

     system("> txt/".$arquivo.".txt");
     echo "\n Arquivo: $arquivo \n";
     $ponteiro = fopen($arquivo, "r" );
     $x=0;
     $_erro = false;
     pg_exec("begin");
     while (!feof($ponteiro)) {
       $linha = fgets($ponteiro,600);
       $x++;
       if(empty($linha)){
        break;
       }

       $mtz_dados = explode( "|", $linha );

       if( ((int)$mtz_dados[0] != 21) or ($mtz_dados[3] != "I")){
          continue;
       }

       // não sei pq arquivos pac são dif. de Guaíba e Bagé
       // indice para Guaíba 0
       // indice para Bage 5
       $indice     = 5;

       $nome       = nome40( $mtz_dados[$indice+3], $arquivo );

       $dtnasc     = $mtz_dados[$indice+6];
       $dtnasc_ano = trim(substr($dtnasc,4,4));
       $dtnasc_mes = trim(substr($dtnasc,2,2));
       $dtnasc_dia = trim(substr($dtnasc,0,2));

       if((int)$dtnasc == 0 || !checkdate((int) $dtnasc_mes,(int) $dtnasc_dia,(int) $dtnasc_ano)){
         $dtnasc   = 'null';
       }else{
         $dtnasc   = "'".$dtnasc_ano."-".$dtnasc_mes."-".$dtnasc_dia."'";
       }
       $sexo       = (int)$mtz_dados[$indice+7]==1 ? "M":"F";
       $mae        = nome40( $mtz_dados[$indice+9], $arquivo );
       $pai        = nome40( $mtz_dados[$indice+10], $arquivo );
       $endereco   = str_replace( "'", "'||chr(39)||'", $mtz_dados[$indice+24] );
       $numero     = (int)$mtz_dados[$indice+25];
       $bairro     = str_replace( "'", "'||chr(39)||'", $mtz_dados[$indice+27] );
       $cep        = $mtz_dados[$indice+30];
       $cidade     = 'BAGÉ';

       $ncertidao  = $mtz_dados[$indice+38];
       $nlivro     = $mtz_dados[$indice+40];
       $folha      = $mtz_dados[$indice+39];
       $cartorio   = $mtz_dados[$indice+43];
       $dtemissao  = $mtz_dados[$indice+41];
       $dtems_ano = trim(substr($dtemissao,4,4));
       $dtems_mes = trim(substr($dtemissao,2,2));
       $dtems_dia = trim(substr($dtemissao,0,2));

       if((int)$dtemissao == 0 || !checkdate((int) $dtems_mes,(int) $dtems_dia,(int) $dtems_ano)){
         $dtems   = 'null';
       }else{
         $dtems   = "'".$dtems_ano."-".$dtems_mes."-".$dtems_dia."'";
       }
       $natural   = 'BAGÉ';
       $necessidade = 1;



       $sql = "select * from aluno where ed47_v_nome = '$nome'";
       $result = pg_exec( $sql );
       if( pg_numrows( $result ) != 0 ){
          echo $erro="Aluno ja cadastrado [$nome]\n";
          system( "echo \"$erro\">> txt/".$arquivo );
          continue;
       }

       $sql1 = "INSERT INTO aluno (ed47_i_codigo,
                                   ed47_v_nome, ed47_v_ender, ed47_i_numero, ed47_v_bairro, ed47_v_munic, ed47_v_uf,
                          ed47_v_cep, ed47_d_nasc, ed47_v_sexo,
                          ed47_v_pai, ed47_v_mae, ed47_i_necessidade,
                          ed47_c_certidaonum, ed47_c_certidaolivro, ed47_c_certidaofolha, ed47_c_certidaocart,
                          ed47_c_certidaodata, ed47_c_naturalidade
                                  )
                           values (nextval('aluno_ed47_i_codigo_seq'),
                             '$nome', '$endereco', $numero, '$bairro', '$cidade', 'RS',
                          '$cep', $dtnasc, '$sexo',
                          '$pai', '$mae', $necessidade,
                          '$ncertidao','$nlivro','$folha','$cartorio',
                          $dtems, '$natural'
                          ) ";
       $result1 = pg_exec($sql1) or die( " >>>> $x <<<< $sql1  - \n".pg_errormessage()."\n" ) ;
       if ($result1 == false) {
          echo $sql1."\n >>> $x <<<".$linha."\n ".pg_errormessage();
          $_erro = true;
          break;
       }
       echo".";
     }
     if( $_erro == true ){
        pg_exec("rollback");
        exit;
     }else{
        pg_exec("commit");
     }

}


function nome40( $nome, $arq ,$indice=2){
   if( strlen( $nome ) > 40 ){
     $mtz_nome = explode( " ", $nome );
     $nome40 = $nome;
     $nome = "";
     if($mtz_nome[count($mtz_nome)-2]=="DOS" || $mtz_nome[count($mtz_nome)-2]=="DE" || $mtz_nome[count($mtz_nome)-2]=="DA")
      $indice +=1;
     $mtz_nome[count($mtz_nome)-$indice] = substr($mtz_nome[count($mtz_nome)-$indice],0,1);
     for($x=0; $x < count( $mtz_nome ); $x++ ){
      $nome .= $mtz_nome[$x]." ";
     }
     $nome = trim($nome);
     if( strlen( $nome ) > 40 ){
      $nome = nome40($nome,$arq,$indice+1);
     }
     echo $erro="Nome maior q 40 caracteres [$nome40] -> [$nome]";
     system( "echo \"$erro\">> txt/".$arq );
  }
  $nome =  str_replace( "'", "'||chr(39)||'", $nome );
  return $nome;
}

?>

