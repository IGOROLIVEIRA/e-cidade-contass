<? 

$str_arquivo = $_SERVER['PHP_SELF'];
set_time_limit(0);

require(__DIR__ . "/../libs/db_stdlib.php");
//require (__DIR__ . "/../libs/db_conn.php");
echo "Conectando...\n";


//
// VARIAVEIS DE CONFIGURACAO DA CONEXAO COM O BANCO DE DADOS
//
$DB_USUARIO  = "postgres";
$DB_SERVIDOR = "192.168.78.7";
$DB_BASE     = "bage";
//----------------------------------------------------------------//


//VARIAVEIS USADAS QUANDO NÃO EXISTIR ARREHIST PARA O REGISTRO
$dt_migracao = '2008-06-28';
$usu_migracao = 1;
$hrs_migracao = db_hora();
$desc_migracao = "Migracao";

if(!($conn1 = pg_connect("host=$DB_SERVIDOR dbname=$DB_BASE user=$DB_USUARIO "))) {
  echo "erro ao conectar...\n";
  exit;
}

echo $str_hora = date( "h:m:s" );

system( "clear" );

$erro = false;
pg_query($conn1, "begin;");

//
// Cria tabela com os registros a gerar cancelamento
//
$sSqlCreateTable  = " create table w_arrecad_valor_zerado as             ";
$sSqlCreateTable .= "    select arrecad.k00_numpre,                      ";
$sSqlCreateTable .= "           arrecad.k00_numpar,                      ";
$sSqlCreateTable .= "           arrecad.k00_receit,                      ";
$sSqlCreateTable .= "           arreinstit.k00_instit,                   ";
$sSqlCreateTable .= "           max(arrehist.k00_idhist) as k00_idhist,  ";
$sSqlCreateTable .= "           sum(arrecad.k00_valor) as k00_valor      ";
$sSqlCreateTable .= "      from arrecad                                  ";
$sSqlCreateTable .= "           inner join arretipo   on arretipo.k00_tipo     = arrecad.k00_tipo   ";
$sSqlCreateTable .= "           left  join arreinstit on arreinstit.k00_numpre = arrecad.k00_numpre ";
$sSqlCreateTable .= "           left  join arrehist   on arrehist.k00_numpre   = arrecad.k00_numpre ";
$sSqlCreateTable .= "                                and arrehist.k00_numpar   = arrecad.k00_numpar ";
$sSqlCreateTable .= "     where arretipo.k03_tipo <> 3                                              ";
$sSqlCreateTable .= "     group by arrecad.k00_numpre,       ";
$sSqlCreateTable .= "              arrecad.k00_numpar,       ";
$sSqlCreateTable .= "              arrecad.k00_receit,       ";
$sSqlCreateTable .= "              arreinstit.k00_instit     ";
$sSqlCreateTable .= "     having sum(arrecad.k00_valor) <= 0 ";

echo "Criando tabela auxiliar w_arrecad_valor_zerado ... \n";
pg_query($conn1, $sSqlCreateTable);

//
// Desabilitando a trigger do cancdebitos que controla a instituicao da sessao
//
echo "Desabilitando trigger da cancdebitos ... \n";
pg_query($conn1, "ALTER TABLE cancdebitos disable trigger tg_cancdebitos_inc");

//
// Iniciando as sessoes no banco de dados
//
echo "Iniciando as sessoes no banco de dados ... \n";
pg_query($conn1, "select fc_startsession()");
pg_query($conn1, "select fc_putsession('DB_instit','4')");

//
// Corrigindo o historico do arrecad do daeb
//
echo "Corrigindo historico de desconto do arrecad do daeb ... \n";
$sSqlUpdateDaeb  = " UPDATE arrecad SET k00_hist = 918 "; 
$sSqlUpdateDaeb .= "   from arreinstit                 ";
$sSqlUpdateDaeb .= "  where arrecad.k00_numpre = arreinstit.k00_numpre  ";
$sSqlUpdateDaeb .= "    and arreinstit.k00_instit = 4 ";
$sSqlUpdateDaeb .= "    and k00_hist = 2918           "; 
pg_query($conn1, $sSqlUpdateDaeb) or die ($sSqlUpdateDaeb);

//
// Setando a instituicao para prefeitura de bage
//
pg_query($conn1, "select fc_putsession('DB_instit','1')");
//
// Corrigindo o historico do arrecad da prefeitura
//
echo "Corrigindo historico de desconto do arrecad da prefeitura ... \n";
$sSqlUpdateArrecadBage  = " UPDATE arrecad SET k00_hist = 918  ";
$sSqlUpdateArrecadBage .= "   from arreinstit     ";
$sSqlUpdateArrecadBage .= "  where arrecad.k00_numpre = arreinstit.k00_numpre ";
$sSqlUpdateArrecadBage .= "    and arreinstit.k00_instit = 1 ";
$sSqlUpdateArrecadBage .= "    and k00_hist = 2918 "; 
pg_query($conn1, $sSqlUpdateArrecadBage) or die ($sSqlUpdateArrecadBage);

//
// Setando a instituicao para daeb
//
pg_query($conn1, "select fc_putsession('DB_instit','4')");

$str_sql  = " select distinct  ";
$str_sql .= "        arrecad.k00_valor, ";
$str_sql .= "        arrecad.k00_receit, ";
$str_sql .= "        arrecad.k00_numpar, ";
$str_sql .= "        arrecad.k00_numpre, ";
$str_sql .= "        arrehist.k00_id_usuario, ";
$str_sql .= "        arrehist.k00_hora, ";
$str_sql .= "        arrehist.k00_histtxt, ";
$str_sql .= "        arreinstit.k00_instit as instit, ";
$str_sql .= "        arrehist.k00_dtoper as dthist  ";
$str_sql .= "   from w_arrecad_valor_zerado  ";
$str_sql .= "        inner join arrecad    on arrecad.k00_numpre    = w_arrecad_valor_zerado.k00_numpre  ";
$str_sql .= "                             and arrecad.k00_numpar    = w_arrecad_valor_zerado.k00_numpar  ";
$str_sql .= "                             and arrecad.k00_receit    = w_arrecad_valor_zerado.k00_receit  ";
$str_sql .= "        inner join arreinstit on arreinstit.k00_numpre = w_arrecad_valor_zerado.k00_numpre ";
$str_sql .= "        left  join arrehist   on arrehist.k00_idhist  = w_arrecad_valor_zerado.k00_idhist ";

echo "Selecionandos registros ...\n";

$res_select = pg_query( $conn1, $str_sql );
$int_linhas = pg_num_rows( $res_select );    
$numpre_ant = "";

//
// For percorrendo os registros a cancelar
//
for( $i=0; $i<$int_linhas; $i++ ) {

  db_fieldsmemory( $res_select, $i );

  echo "Processando ... ".round( ( ( ($i+1) * 100 ) / $int_linhas ),2)." % ".($i+1)." de {$int_linhas} Registros. \r ";
 
  $sSqlInstit = "select k00_instit as instit from arreinstit where k00_numpre = {$k00_numpre} ";
  $rsInstit   = pg_query($sSqlInstit) or die ($sSqlInstit);
  db_fieldsmemory($rsInstit,0);
  pg_query($conn1, "select fc_putsession('DB_instit','{$instit}')");

  if ($numpre_ant != $k00_numpre){
    if ($dthist!=""){
      $dt_inc    = $dthist;
      $usu_inc   = $k00_id_usuario;
      $hrs_inc   = $k00_hora;
      $descr_inc = substr($k00_histtxt,0,50)."";
    }else{
      $dt_inc    = $dt_migracao;
      $usu_inc   = $usu_migracao;
      $hrs_inc   = $hrs_migracao;
      $descr_inc = "$desc_migracao";
    }
    $seq_cancdebitos = pg_query($conn1,"select nextval('cancdebitos_k20_codigo_seq')");
    $cod_cancdebitos = pg_result($seq_cancdebitos,0,0);
    $insert_cancdebitos = "insert into  cancdebitos (k20_codigo,k20_descr,k20_hora,k20_data,k20_usuario,k20_instit) values ($cod_cancdebitos,'$descr_inc','$hrs_inc','$dt_inc',$usu_inc,$instit)";
    $result_cancdebitos = pg_query( $conn1, $insert_cancdebitos ) or die ($insert_cancdebitos);
    if( $result_cancdebitos == false ){          
      $erro = true;
      $erromsg = pg_last_error();
      break;
    }    
    $seq_cancdebitosproc    = pg_query($conn1,"select nextval('cancdebitosproc_k23_codigo_seq')");
    $cod_cancdebitosproc    = pg_result($seq_cancdebitosproc,0,0);
    $insert_cancdebitosproc = "insert into cancdebitosproc (k23_codigo,k23_hora,k23_data,k23_usuario,k23_obs) values ($cod_cancdebitosproc,'$hrs_inc','$dt_inc',$usu_inc,'$descr_inc')";
    $result_cancdebitosproc = pg_query( $conn1, $insert_cancdebitosproc ) or die ($insert_cancdebitosproc);
    //echo $insert_cancdebitosproc.";\n";
    if( $result_cancdebitosproc == false ){          
      $erro = true;
      $erromsg = pg_last_error();
      break;
    }    

    $numpre_ant = $k00_numpre;
  }else{
    if ($dthist!=""){
      $dt_inc    = $dthist;
      $usu_inc   = $k00_id_usuario;
      $hrs_inc   = $k00_hora;
      $descr_inc = substr($k00_histtxt,0,50)."";
    }else{
      $dt_inc    = $dt_migracao;
      $usu_inc   = $usu_migracao;
      $hrs_inc   = $hrs_migracao;
      $descr_inc = "$desc_migracao";
    }
  }

  //
  // Inserindo na cancdebitosreg
  //
  $seq_cancdebitosreg    = pg_query($conn1,"select nextval('cancdebitosreg_k21_sequencia_seq')");
  $cod_cancdebitosreg    = pg_result($seq_cancdebitosreg,0,0);
  $insert_cancdebitosreg = "insert into cancdebitosreg values ($cod_cancdebitosreg,$cod_cancdebitos,$k00_numpre,$k00_numpar,$k00_receit,'$dt_inc','$hrs_inc','$descr_inc')";
  $result_cancdebitosreg = pg_query( $conn1, $insert_cancdebitosreg ) or die ($insert_cancdebitosreg);
  if( $result_cancdebitosreg == false ){          
    $erro = true;
    $erromsg = pg_last_error();
    break;
  }    
  //
  // Inserindo na cancdebitosprocreg
  //
  $seq_cancdebitosprocreg    = pg_query($conn1,"select nextval('cancdebitosprocreg_k24_sequencia_seq')");
  $cod_cancdebitosprocreg    = pg_result($seq_cancdebitosprocreg,0,0);
  $insert_cancdebitosprocreg = "insert into cancdebitosprocreg values ($cod_cancdebitosprocreg,$cod_cancdebitosproc,$cod_cancdebitosreg,'$k00_valor','$k00_valor','0','0','0')";
  $result_cancdebitosprocreg = pg_query( $conn1, $insert_cancdebitosprocreg ) or die ($insert_cancdebitosprocreg);
  if( $result_cancdebitosprocreg == false ){          
    $erro = true;				
    $erromsg = pg_last_error();
    break;
  }  

  //
  // Inserindo no arrecant
  //
  $sSqlInsertArrecant  = " insert into arrecant (k00_numpre,k00_numpar,k00_numcgm,k00_dtoper,k00_receit,k00_hist,k00_valor,k00_dtvenc,k00_numtot,k00_numdig,k00_tipo,k00_tipojm) ";
  $sSqlInsertArrecant .= " select k00_numpre, ";
  $sSqlInsertArrecant .= "        k00_numpar, ";
  $sSqlInsertArrecant .= "        k00_numcgm, ";
  $sSqlInsertArrecant .= "        k00_dtoper, ";
  $sSqlInsertArrecant .= "        k00_receit, ";
  $sSqlInsertArrecant .= "        k00_hist,   ";
  $sSqlInsertArrecant .= "        k00_valor,  ";
  $sSqlInsertArrecant .= "        k00_dtvenc, ";
  $sSqlInsertArrecant .= "        k00_numtot, ";
  $sSqlInsertArrecant .= "        k00_numdig, ";
  $sSqlInsertArrecant .= "        k00_tipo,   ";
  $sSqlInsertArrecant .= "        k00_tipojm  ";
  $sSqlInsertArrecant .= "   from arrecad     ";
  $sSqlInsertArrecant .= "  where k00_numpre = {$k00_numpre} ";
  $sSqlInsertArrecant .= "    and k00_numpar = {$k00_numpar} ";
  $sSqlInsertArrecant .= "    and k00_receit = {$k00_receit} ";
  $sSqlInsertArrecant .= "    and k00_valor > 0              "; 
  pg_query($sSqlInsertArrecant) or die ($sSqlInsertArrecant);
  if (pg_last_error() != '' ) {
    $erro = true;
    $erromsg = pg_last_error();
    break;
  }
  //
  // Deletando os registros do arrecad
  //
  $sSqlDeleteArrecad = "delete from arrecad where k00_numpre = {$k00_numpre} and k00_numpar = {$k00_numpar} and k00_receit = {$k00_receit} ";
  pg_query($sSqlDeleteArrecad) or die ($sSqlDeleteArrecad);
  if (pg_last_error() != '' ) {
    $erro = true;
    $erromsg = pg_last_error();
    break;
  }

}  

echo "\n \n";

//$erro = true;				

pg_query($conn1, "ALTER TABLE cancdebitos enable trigger tg_cancdebitos_inc");

if ($erro == false) {
  pg_query($conn1, "commit;");
  echo "processamento ok...\n";
} else {
  pg_query($conn1, "rollback;");			
  echo "erro durante o processamento...\n $erromsg";
  exit;
}
echo "\n --------------------";
echo "\n Inicio: $str_hora";
echo "\n Fina..: ".date( "h:m:s" );
?>
