<?
//MODULO: sicom
//CLASSE DA ENTIDADE emp122017
class cl_emp122017
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
  var $si108_sequencial = 0;
  var $si108_tiporegistro = 0;
  var $si108_codunidadesub = null;
  var $si108_nroempenho = 0;
  var $si108_tipodocumento = 0;
  var $si108_nrodocumento = null;
  var $si108_mes = 0;
  var $si108_reg10 = 0;
  var $si108_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si108_sequencial = int8 = sequencial 
                 si108_tiporegistro = int8 = Tipo do  registro 
                 si108_codunidadesub = varchar(8) = Código da unidade 
                 si108_nroempenho = int8 = Número do  empenho 
                 si108_tipodocumento = int8 = Tipo de  Documento do  credor 
                 si108_nrodocumento = varchar(14) = Número do documento do credor 
                 si108_mes = int8 = Mês 
                 si108_reg10 = int8 = reg10 
                 si108_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_emp122017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("emp122017");
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
      $this->si108_sequencial = ($this->si108_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_sequencial"] : $this->si108_sequencial);
      $this->si108_tiporegistro = ($this->si108_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_tiporegistro"] : $this->si108_tiporegistro);
      $this->si108_codunidadesub = ($this->si108_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_codunidadesub"] : $this->si108_codunidadesub);
      $this->si108_nroempenho = ($this->si108_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_nroempenho"] : $this->si108_nroempenho);
      $this->si108_tipodocumento = ($this->si108_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_tipodocumento"] : $this->si108_tipodocumento);
      $this->si108_nrodocumento = ($this->si108_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_nrodocumento"] : $this->si108_nrodocumento);
      $this->si108_mes = ($this->si108_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_mes"] : $this->si108_mes);
      $this->si108_reg10 = ($this->si108_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_reg10"] : $this->si108_reg10);
      $this->si108_instit = ($this->si108_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_instit"] : $this->si108_instit);
    } else {
      $this->si108_sequencial = ($this->si108_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si108_sequencial"] : $this->si108_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si108_sequencial)
  {
    $this->atualizacampos();
    if ($this->si108_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si108_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si108_nroempenho == null) {
      $this->si108_nroempenho = "0";
    }
    if ($this->si108_tipodocumento == null) {
      $this->si108_tipodocumento = "0";
    }
    if ($this->si108_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si108_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si108_reg10 == null) {
      $this->si108_reg10 = "0";
    }
    if ($this->si108_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si108_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si108_sequencial == "" || $si108_sequencial == null) {
      $result = db_query("select nextval('emp122017_si108_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: emp122017_si108_sequencial_seq do campo: si108_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si108_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from emp122017_si108_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si108_sequencial)) {
        $this->erro_sql = " Campo si108_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si108_sequencial = $si108_sequencial;
      }
    }
    if (($this->si108_sequencial == null) || ($this->si108_sequencial == "")) {
      $this->erro_sql = " Campo si108_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into emp122017(
                                       si108_sequencial 
                                      ,si108_tiporegistro 
                                      ,si108_codunidadesub 
                                      ,si108_nroempenho 
                                      ,si108_tipodocumento 
                                      ,si108_nrodocumento 
                                      ,si108_mes 
                                      ,si108_reg10 
                                      ,si108_instit 
                       )
                values (
                                $this->si108_sequencial 
                               ,$this->si108_tiporegistro 
                               ,'$this->si108_codunidadesub' 
                               ,$this->si108_nroempenho 
                               ,$this->si108_tipodocumento 
                               ,'$this->si108_nrodocumento' 
                               ,$this->si108_mes 
                               ,$this->si108_reg10 
                               ,$this->si108_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "emp122017 ($this->si108_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "emp122017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "emp122017 ($this->si108_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si108_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si108_sequencial));


    return true;
  }

  // funcao para alteracao
  function alterar($si108_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update emp122017 set ";
    $virgula = "";
    if (trim($this->si108_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_sequencial"])) {
      if (trim($this->si108_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si108_sequencial"])) {
        $this->si108_sequencial = "0";
      }
      $sql .= $virgula . " si108_sequencial = $this->si108_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si108_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_tiporegistro"])) {
      $sql .= $virgula . " si108_tiporegistro = $this->si108_tiporegistro ";
      $virgula = ",";
      if (trim($this->si108_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si108_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si108_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_codunidadesub"])) {
      $sql .= $virgula . " si108_codunidadesub = '$this->si108_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si108_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_nroempenho"])) {
      if (trim($this->si108_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si108_nroempenho"])) {
        $this->si108_nroempenho = "0";
      }
      $sql .= $virgula . " si108_nroempenho = $this->si108_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si108_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_tipodocumento"])) {
      if (trim($this->si108_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si108_tipodocumento"])) {
        $this->si108_tipodocumento = "0";
      }
      $sql .= $virgula . " si108_tipodocumento = $this->si108_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si108_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_nrodocumento"])) {
      $sql .= $virgula . " si108_nrodocumento = '$this->si108_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si108_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_mes"])) {
      $sql .= $virgula . " si108_mes = $this->si108_mes ";
      $virgula = ",";
      if (trim($this->si108_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si108_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si108_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_reg10"])) {
      if (trim($this->si108_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si108_reg10"])) {
        $this->si108_reg10 = "0";
      }
      $sql .= $virgula . " si108_reg10 = $this->si108_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si108_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si108_instit"])) {
      $sql .= $virgula . " si108_instit = $this->si108_instit ";
      $virgula = ",";
      if (trim($this->si108_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si108_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si108_sequencial != null) {
      $sql .= " si108_sequencial = $this->si108_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "emp122017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si108_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "emp122017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si108_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si108_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si108_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si108_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }

    $sql = " delete from emp122017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si108_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si108_sequencial = $si108_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "emp122017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si108_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "emp122017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si108_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si108_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:emp122017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si108_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from emp122017 ";
    $sql .= "      left  join emp102017  on  emp102017.si106_sequencial = emp122017.si108_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si108_sequencial != null) {
        $sql2 .= " where emp122017.si108_sequencial = $si108_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si108_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from emp122017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si108_sequencial != null) {
        $sql2 .= " where emp122017.si108_sequencial = $si108_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
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
