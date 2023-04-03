<?

set_time_limit(0);

include(__DIR__ . "/../libs/db_conn.php");

$conn = pg_connect("dbname=$DB_BASE user=postgres host=$DB_SERVIDOR port=$DB_PORTA") or die('ERRO AO CONECTAR NA BASE DE DADOS !!');

@$isTeste = (strtoupper($argv[1])=="TESTE");

echo "Conectado a base $DB_BASE\n";

$erro = true;

// Inicia Transacao
pg_query($conn, "begin");

$sql_tipodoc   = "select db61_texto, db60_tipodoc ";
$sql_tipodoc  .= "from db_documentopadrao";
$sql_tipodoc  .= "     inner join db_docparagpadrao  on db62_coddoc   = db60_coddoc";
$sql_tipodoc  .= "     inner join db_paragrafopadrao on db61_codparag = db62_codparag "; 
$sql_tipodoc  .= "where db60_tipodoc = 1503"; 

$res_db_documentopadrao     = @pg_query($conn,$sql_tipodoc);
$numrows_db_documentopadrao = pg_numrows($res_db_documentopadrao);
if ($numrows_db_documentopadrao > 0){
     $db61_texto     = pg_result($res_db_documentopadrao,0,"db61_texto");
     $db60_tipodoc   = pg_result($res_db_documentopadrao,0,"db60_tipodoc");

     $sql_db_config  = "select codigo ";
     $sql_db_config .= "from db_config";

     $res_db_config = @pg_query($conn,$sql_db_config);  // Pega as demais instituicoes e cria documento particular
                                                        // a partir do documento padrao alterado na atualizacao de versao
     $numrows_db_config = pg_numrows($res_db_config);                                                        
     if ($numrows_db_config > 0){
          for($i = 0; $i < $numrows_db_config; $i++){
                $codigo = pg_result($res_db_config,$i,"codigo");

                $res_db_documento  = pg_query("select nextval('db_documento_db03_docum_seq')") or die("Erro ao buscar sequence db_documento_db03_docum_seq");
                $novo_documento    = pg_result($res_db_documento,0,0) or die("Erro ao buscar novo codigo da documento");

                $ins_db_documento  = "insert into db_documento (db03_docum, db03_descr, db03_tipodoc, db03_instit) ";
                $ins_db_documento .= "values ($novo_documento,'ASS. AUTORIZACAO',$db60_tipodoc,$codigo)";

                $erro              = pg_query($ins_db_documento) or die("Erro ao inserir novo documento $novo_documento");

                echo "> Novo documento criado $novo_documento (Instituicao $codigo)\n";

                if ($erro == false){ 
                     break;
                } else {
                     $res_db_paragrafo  = pg_query("select nextval('db_paragrafo_db02_idparag_seq')") or die("Erro ao buscar sequence db_paragrafo_db02_idparag_seq");
                     $novo_paragrafo    = pg_result($res_db_paragrafo,0,0) or die("Erro ao buscar novo codigo do paragrafo");

                     $ins_db_paragrafo  = "insert into db_paragrafo (db02_idparag, db02_descr, db02_texto, db02_alinha, db02_inicia, db02_espaca) ";
                     $ins_db_paragrafo .= "values($novo_paragrafo,'PARAG. AUTORIZACAO','".addslashes($db61_texto)."',0,0,0)"; 

                     $erro              = pg_query($ins_db_paragrafo) or die("Erro ao inserir novo paragrafo $novo_paragrafo");

                     echo "> Novo paragrafo criado $novo_paragrafo (Instituicao $codigo)\n";

                     if ($erro == false){
                          break;
                     } else{
                          $ins_db_docparag  = "insert into db_docparag (db04_docum, db04_idparag, db04_ordem) ";
                          $ins_db_docparag .= "values ($novo_documento,$novo_paragrafo,1)";

                          $erro             = pg_query($ins_db_docparag) or die("Erro ao inserir novo documento $novo_documento e novo paragrafo $novo_paragrafo na tabela db_docparag");
                          
                          if ($erro == false){
                               break;
                          }
                     }
                }
          }
     } else {
          $erro = false;
     }
} else {
     $erro = false;
}
if ($erro == false || $isTeste == true){
     if($isTeste == true) {
         echo "\nExecutando em modo de teste. Executando Rollback!!\n\n";
     }

     pg_query($conn, "rollback");
} else {
     pg_query($conn, "commit");

     echo "\nProcesso executado com sucesso\n\n";
}

?>
