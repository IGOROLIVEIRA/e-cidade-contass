<?

// Salva o conteudo da sessao no banco de dados
function db_savesession($_conn, $_session) {
  
  // Cria tabela temporaria para a conexao corrente
  $sql  = "SELECT fc_startsession();";
  
  $result = pg_query($_conn, $sql) or die("Não foi possível criar sessão no banco de dados (Sql: $sql)!");
  
  if (pg_num_rows($result)==0) {
    return false;
  }

  // Verifica se conseguiu iniciar nova sessao ou se ja existia no banco de dados
  $lInsert = (pg_result($result, 0, 0) == "t");

  // Nome da Sessao
  $sql = "SELECT fc_sessionname()";
  $result = pg_query($_conn, $sql) or die("Não foi possível definir sessão no banco de dados (Sql: $sql)!");
  
  if (pg_num_rows($result)==0) {
    return false;
  }

  // Pega nome da sessao
  $sNomeSessao = pg_result($result, 0, 0);

  // Insere as variaveis da sessao na tabela
  $sql   = $lInsert?"INSERT INTO {$sNomeSessao}(variavel, conteudo) ":"";
  $union = "";
  
  foreach($_session as $key=>$val) {
    
    switch (strtoupper($key)) {
    case "DB_DATAUSU":
      $val = date("Y-m-d", $val);
      break; 
    }
    if (substr($key,0,2) == "DB"){ 
      $val = addslashes($val);

      if ($lInsert) {
        $sql .= $union . "SELECT '".strtoupper($key)."', '$val'";
      } else {
        $sql .= $union . "SELECT fc_putsession('$key', '$val')";
      }
      $union = " UNION ALL ";
    }
  } 
  
  pg_query($_conn, $sql) or die("Não foi possível criar sessão no banco de dados (Sql: $sql)!");
  
  return true;
} 


?>
