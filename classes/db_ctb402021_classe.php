<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb402021
class cl_ctb402021
{
  // cria variaveis de erro
  var $rotulo = null;
  var $query_sql = null;
  var $numrows = 0;
  var $numrows_incluir = 0;
  var $numrows_alterar = 0;
  var $numrows_excluir = 0;
  var $erro_status = null;
  var $erro_sql = null;
  var $erro_banco = null;
  var $erro_msg = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo
  var $si101_sequencial = 0;
  var $si101_tiporegistro = 0;
  var $si101_codorgao = null;
  var $si101_codctb = 0;
  var $si101_desccontabancaria = null;
  var $si101_nroconvenio = null;
  var $si101_dataassinaturaconvenio = null;
  var $si101_mes = 0;
  var $si101_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si101_sequencial = int8 = sequencial 
                 si101_tiporegistro = int8 = Tipo do registro 
                 si101_codorgao = varchar(2) = Código do órgão 
                 si101_codctb = int8 = Código Identificador da Conta Bancária
                 si101_desccontabancaria = varchar(50) = Nome da Conta  Bancária 
                 si101_nroconvenio = varchar(30) = Número do convênio
                 si101_dataassinaturaconvenio = date = Data da assinatura do convênio
                 si101_mes = int8 = Mês 
                 si101_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_ctb402021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ctb402021");
    $this->pagina_retorno = basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }
  
  //funcao erro
  function erro($mostra, $retorna)
  {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null)) {
      echo "<script>alert(\"" . $this->erro_msg . "\");</script>";
      if ($retorna == true) {
        echo "<script>location.href='" . $this->pagina_retorno . "'</script>";
      }
    }
  }
  
  // funcao para atualizar campos
  function atualizacampos($exclusao = false)
  {
    if ($exclusao == false) {
      $this->si101_sequencial = ($this->si101_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_sequencial"] : $this->si101_sequencial);
      $this->si101_tiporegistro = ($this->si101_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_tiporegistro"] : $this->si101_tiporegistro);
      $this->si101_codorgao = ($this->si101_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_codorgao"] : $this->si101_codorgao);
      $this->si101_codctb = ($this->si101_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_codctb"] : $this->si101_codctb);
      $this->si101_desccontabancaria = ($this->si101_desccontabancaria == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_desccontabancaria"] : $this->si101_desccontabancaria);
      $this->si101_nroconvenio = ($this->si101_nroconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_nroconvenio"] : $this->si101_nroconvenio);
      $this->si101_dataassinaturaconvenio = ($this->si101_dataassinaturaconvenio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_dataassinaturaconvenio"] : $this->si101_dataassinaturaconvenio);
      $this->si101_mes = ($this->si101_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_mes"] : $this->si101_mes);
      $this->si101_instit = ($this->si101_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_instit"] : $this->si101_instit);
    } else {
      $this->si101_sequencial = ($this->si101_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_sequencial"] : $this->si101_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si101_sequencial)
  {
    $this->atualizacampos();
    if ($this->si101_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si101_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si101_codctb == null) {
      $this->si101_codctb = "0";
    }
    if ($this->si101_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si101_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si101_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si101_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si101_sequencial == "" || $si101_sequencial == null) {
      $result = db_query("select nextval('ctb402021_si101_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ctb402021_si101_sequencial_seq do campo: si101_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si101_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ctb402021_si101_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si101_sequencial)) {
        $this->erro_sql = " Campo si101_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si101_sequencial = $si101_sequencial;
      }
    }
    if (($this->si101_sequencial == null) || ($this->si101_sequencial == "")) {
      $this->erro_sql = " Campo si101_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into ctb402021(
                                       si101_sequencial 
                                      ,si101_tiporegistro 
                                      ,si101_codorgao 
                                      ,si101_codctb 
                                      ,si101_desccontabancaria 
                                      ,si101_nroconvenio
                                      ,si101_dataassinaturaconvenio
                                      ,si101_mes 
                                      ,si101_instit 
                       )
                values (
                                $this->si101_sequencial 
                               ,$this->si101_tiporegistro 
                               ,'$this->si101_codorgao' 
                               ,$this->si101_codctb
                               ,'$this->si101_desccontabancaria' 
                               ,'$this->si101_nroconvenio'
                               ,'$this->si101_dataassinaturaconvenio' 
                               ,$this->si101_mes 
                               ,$this->si101_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ctb402021 ($this->si101_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ctb402021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ctb402021 ($this->si101_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si101_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si101_sequencial));
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si101_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ctb402021 set ";
    $virgula = "";
    if (trim($this->si101_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_sequencial"])) {
      if (trim($this->si101_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si101_sequencial"])) {
        $this->si101_sequencial = "0";
      }
      $sql .= $virgula . " si101_sequencial = $this->si101_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si101_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_tiporegistro"])) {
      $sql .= $virgula . " si101_tiporegistro = $this->si101_tiporegistro ";
      $virgula = ",";
      if (trim($this->si101_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si101_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si101_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_codorgao"])) {
      $sql .= $virgula . " si101_codorgao = '$this->si101_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si101_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_codctb"])) {
      if (trim($this->si101_codctb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si101_codctb"])) {
        $this->si101_codctb = "0";
      }
      $sql .= $virgula . " si101_codctb = $this->si101_codctb ";
      $virgula = ",";
    }
    if (trim($this->si101_desccontabancaria) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_desccontabancaria"])) {
      $sql .= $virgula . " si101_desccontabancaria = '$this->si101_desccontabancaria' ";
      $virgula = ",";
    }
    if (trim($this->si101_nroconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_nroconvenio"])) {
      $sql .= $virgula . " si101_nroconvenio = '$this->si101_nroconvenio' ";
      $virgula = ",";
    }
    if (trim($this->si101_dataassinaturaconvenio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_dataassinaturaconvenio"])) {
      $sql .= $virgula . " si101_dataassinaturaconvenio = '$this->si101_dataassinaturaconvenio' ";
      $virgula = ",";
    }
    if (trim($this->si101_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_mes"])) {
      $sql .= $virgula . " si101_mes = $this->si101_mes ";
      $virgula = ",";
      if (trim($this->si101_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si101_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si101_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_instit"])) {
      $sql .= $virgula . " si101_instit = $this->si101_instit ";
      $virgula = ",";
      if (trim($this->si101_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si101_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si101_sequencial != null) {
      $sql .= " si101_sequencial = $this->si101_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si101_sequencial));

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ctb402021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si101_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ctb402021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si101_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si101_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si101_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si101_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }

    $sql = " delete from ctb402021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si101_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si101_sequencial = $si101_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ctb402021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si101_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ctb402021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si101_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si101_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao do recordset
  function sql_record($sql)
  {
    $result = db_query($sql);
    if ($result == false) {
      $this->numrows = 0;
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:ctb402021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si101_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from ctb402021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si101_sequencial != null) {
        $sql2 .= " where ctb402021.si101_sequencial = $si101_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    
    return $sql;
  }
  
  // funcao do sql
  function sql_query_file($si101_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from ctb402021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si101_sequencial != null) {
        $sql2 .= " where ctb402021.si101_sequencial = $si101_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }
    
    return $sql;
  }
}

?>
