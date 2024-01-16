<?
//MODULO: sicom
//CLASSE DA ENTIDADE cvc402024
class cl_cvc402024
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
  var $si150_sequencial = 0;
  var $si150_tiporegistro = 0;
  var $si150_codorgao = 0;
  var $si150_codveiculo = null;
  var $si150_placaatual = null;
  var $si150_mes = 0;
  var $si150_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si150_sequencial = int8 = sequencial
                 si150_tiporegistro = int8 = Tipo do registro
                 si150_codorgao = int8 = codigo orgao
                 si150_codveiculo = int8 = Código do veiculo
                 si150_placaatual = varchar(8) = placa atual
                 si150_mes = varchar(10) = mes
                 si150_instit = varchar(2) = instituicao
                 ";

  //funcao construtor da classe
  function cl_cvc402024()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cvc402024");
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
      $this->si150_sequencial = ($this->si150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_sequencial"] : $this->si150_sequencial);
      $this->si150_tiporegistro = ($this->si150_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_tiporegistro"] : $this->si150_tiporegistro);
      $this->si150_codorgao = ($this->si150_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_codorgao"] : $this->si150_codorgao);
      $this->si150_codveiculo = ($this->si150_codveiculo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_codveiculo"] : $this->si150_codveiculo);
      $this->si150_placaatual = ($this->si150_placaatual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_placaatual"] : $this->si150_placaatual);
      $this->si150_mes = ($this->si150_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_mes"] : $this->si150_mes);
      $this->si150_instit = ($this->si150_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_instit"] : $this->si150_instit);
    } else {
      $this->si150_sequencial = ($this->si150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_sequencial"] : $this->si150_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si150_sequencial)
  {
    $this->atualizacampos();

    if ($this->si150_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si150_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    if ($si150_sequencial == "" || $si150_sequencial == null) {
      $result = db_query("select nextval('cvc402024_si150_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: cvc402024_si150_sequencial_seq do campo: si150_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si150_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from cvc402024_si150_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si150_sequencial)) {
        $this->erro_sql = " Campo si150_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si150_sequencial = $si150_sequencial;
      }
    }
    if (($this->si150_sequencial == null) || ($this->si150_sequencial == "")) {
      $this->erro_sql = " Campo si150_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into cvc402024(
                                       si150_sequencial
                                      ,si150_tiporegistro
                                      ,si150_codorgao
                                      ,si150_codveiculo
                                      ,si150_placaatual
                                      ,si150_mes
                                      ,si150_instit
                       )
                values (
                                $this->si150_sequencial
                               ,$this->si150_tiporegistro
                               ,$this->si150_codorgao
                               ,$this->si150_codveiculo
                               ,'$this->si150_placaatual'
                               ,$this->si150_mes
                               ,$this->si150_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "cvc402024 ($this->si150_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "cvc402024 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "cvc402024 ($this->si150_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si150_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si150_sequencial));

    return true;
  }

  // funcao para alteracao
  function alterar($si150_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update cvc402024 set ";
    $virgula = "";
    if (trim($this->si150_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_sequencial"])) {
      if (trim($this->si150_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si150_sequencial"])) {
        $this->si150_sequencial = "0";
      }
      $sql .= $virgula . " si150_sequencial = $this->si150_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si150_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_tiporegistro"])) {
      $sql .= $virgula . " si150_tiporegistro = $this->si150_tiporegistro ";
      $virgula = ",";
      if (trim($this->si150_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si150_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si150_codveiculo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_codveiculo"])) {
      $sql .= $virgula . " si150_codveiculo = '$this->si150_codveiculo' ";
      $virgula = ",";
    }
    if (trim($this->si150_placaatual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_placaatual"])) {
      $sql .= $virgula . " si150_placaatual = '$this->si150_placaatual' ";
      $virgula = ",";
    }
    if (trim($this->si150_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_mes"])) {
      $sql .= $virgula . " si150_mes = '$this->si150_mes' ";
      $virgula = ",";
    }
    if (trim($this->si150_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_instit"])) {
      $sql .= $virgula . " si150_instit = '$this->si150_instit' ";
      $virgula = ",";
    }
    if (trim($this->si149_descbaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_descbaixa"])) {
      $sql .= $virgula . " si149_descbaixa = '$this->si149_descbaixa' ";
      $virgula = ",";
    }
    if (trim($this->si149_dtbaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_dia"] != "")) {
      $sql .= $virgula . " si149_dtbaixa = '$this->si149_dtbaixa' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si149_dtbaixa_dia"])) {
        $sql .= $virgula . " si149_dtbaixa = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si149_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_mes"])) {
      $sql .= $virgula . " si149_mes = $this->si149_mes ";
      $virgula = ",";
      if (trim($this->si149_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si149_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si149_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si149_instit"])) {
      $sql .= $virgula . " si149_instit = $this->si149_instit ";
      $virgula = ",";
      if (trim($this->si149_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si149_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si150_sequencial != null) {
      $sql .= " si150_sequencial = $this->si150_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "cvc402024 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si150_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "cvc402024 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si150_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si150_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si150_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from cvc402024
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si150_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si150_sequencial = $si150_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "cvc402024 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si150_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "cvc402024 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si150_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si150_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:cvc402024";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from cvc402024 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si150_sequencial != null) {
        $sql2 .= " where cvc402024.si150_sequencial = $si150_sequencial ";
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
  function sql_query_file($si150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from cvc402024 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si150_sequencial != null) {
        $sql2 .= " where cvc402024.si150_sequencial = $si150_sequencial ";
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
