<?
//MODULO: sicom
//CLASSE DA ENTIDADE aop132024
class cl_aop132024
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
  var $si140_sequencial = 0;
  var $si140_tiporegistro = 0;
  var $si140_codreduzidoop = 0;
  var $si140_tiporetencao = null;
  var $si140_descricaoretencao = null;
  var $si140_vlretencao = 0;
  var $si140_vlantecipado = 0;
  var $si140_mes = 0;
  var $si140_reg10 = 0;
  var $si140_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si140_sequencial = int8 = sequencial
                 si140_tiporegistro = int8 = Tipo do registro
                 si140_codreduzidoop = int8 = Código Identificador da Ordem
                 si140_tiporetencao = varchar(4) = Tipo de Retenção
                 si140_descricaoretencao = varchar(50) = Descrição da  Retenção
                 si140_vlretencao = float8 = Valor da retenção
                 si140_vlantecipado = float8 = Valor extraorçamentário
                 si140_mes = int8 = Mês
                 si140_reg10 = int8 = reg10
                 si140_instit = int8 = Instituição
                 ";
  //funcao construtor da classe
  function cl_aop132024()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aop132024");
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
      $this->si140_sequencial = ($this->si140_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_sequencial"] : $this->si140_sequencial);
      $this->si140_tiporegistro = ($this->si140_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_tiporegistro"] : $this->si140_tiporegistro);
      $this->si140_codreduzidoop = ($this->si140_codreduzidoop == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_codreduzidoop"] : $this->si140_codreduzidoop);
      $this->si140_tiporetencao = ($this->si140_tiporetencao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_tiporetencao"] : $this->si140_tiporetencao);
      $this->si140_descricaoretencao = ($this->si140_descricaoretencao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_descricaoretencao"] : $this->si140_descricaoretencao);
      $this->si140_vlretencao = ($this->si140_vlretencao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_vlretencao"] : $this->si140_vlretencao);
      $this->si140_vlantecipado = ($this->si140_vlantecipado == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_vlantecipado"] : $this->si140_vlantecipado);
      $this->si140_mes = ($this->si140_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_mes"] : $this->si140_mes);
      $this->si140_reg10 = ($this->si140_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_reg10"] : $this->si140_reg10);
      $this->si140_instit = ($this->si140_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_instit"] : $this->si140_instit);
    } else {
      $this->si140_sequencial = ($this->si140_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si140_sequencial"] : $this->si140_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si140_sequencial)
  {
    $this->atualizacampos();
    if ($this->si140_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si140_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si140_codreduzidoop == null) {
      $this->si140_codreduzidoop = "0";
    }
    if ($this->si140_vlretencao == null) {
      $this->si140_vlretencao = "0";
    }
    if ($this->si140_vlantecipado == null) {
      $this->si140_vlantecipado = "0";
    }
    if ($this->si140_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si140_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si140_reg10 == null) {
      $this->si140_reg10 = "0";
    }
    if ($this->si140_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si140_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si140_sequencial == "" || $si140_sequencial == null) {
      $result = db_query("select nextval('aop132024_si140_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aop132024_si140_sequencial_seq do campo: si140_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si140_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aop132024_si140_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si140_sequencial)) {
        $this->erro_sql = " Campo si140_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si140_sequencial = $si140_sequencial;
      }
    }
    if (($this->si140_sequencial == null) || ($this->si140_sequencial == "")) {
      $this->erro_sql = " Campo si140_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aop132024(
                                       si140_sequencial
                                      ,si140_tiporegistro
                                      ,si140_codreduzidoop
                                      ,si140_tiporetencao
                                      ,si140_descricaoretencao
                                      ,si140_vlretencao
                                      ,si140_vlantecipado
                                      ,si140_mes
                                      ,si140_reg10
                                      ,si140_instit
                       )
                values (
                                $this->si140_sequencial
                               ,$this->si140_tiporegistro
                               ,$this->si140_codreduzidoop
                               ,'$this->si140_tiporetencao'
                               ,'$this->si140_descricaoretencao'
                               ,$this->si140_vlretencao
                               ,$this->si140_vlantecipado
                               ,$this->si140_mes
                               ,$this->si140_reg10
                               ,$this->si140_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aop132024 ($this->si140_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aop132024 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aop132024 ($this->si140_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si140_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    return true;
  }

  // funcao para alteracao
  function alterar($si140_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aop132024 set ";
    $virgula = "";
    if (trim($this->si140_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_sequencial"])) {
      if (trim($this->si140_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si140_sequencial"])) {
        $this->si140_sequencial = "0";
      }
      $sql .= $virgula . " si140_sequencial = $this->si140_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si140_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_tiporegistro"])) {
      $sql .= $virgula . " si140_tiporegistro = $this->si140_tiporegistro ";
      $virgula = ",";
      if (trim($this->si140_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si140_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si140_codreduzidoop) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_codreduzidoop"])) {
      if (trim($this->si140_codreduzidoop) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si140_codreduzidoop"])) {
        $this->si140_codreduzidoop = "0";
      }
      $sql .= $virgula . " si140_codreduzidoop = $this->si140_codreduzidoop ";
      $virgula = ",";
    }
    if (trim($this->si140_tiporetencao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_tiporetencao"])) {
      $sql .= $virgula . " si140_tiporetencao = '$this->si140_tiporetencao' ";
      $virgula = ",";
    }
    if (trim($this->si140_descricaoretencao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_descricaoretencao"])) {
      $sql .= $virgula . " si140_descricaoretencao = '$this->si140_descricaoretencao' ";
      $virgula = ",";
    }
    if (trim($this->si140_vlretencao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_vlretencao"])) {
      if (trim($this->si140_vlretencao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si140_vlretencao"])) {
        $this->si140_vlretencao = "0";
      }
      $sql .= $virgula . " si140_vlretencao = $this->si140_vlretencao ";
      $virgula = ",";
    }
    if (trim($this->si140_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_mes"])) {
      $sql .= $virgula . " si140_mes = $this->si140_mes ";
      $virgula = ",";
      if (trim($this->si140_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si140_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si140_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_reg10"])) {
      if (trim($this->si140_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si140_reg10"])) {
        $this->si140_reg10 = "0";
      }
      $sql .= $virgula . " si140_reg10 = $this->si140_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si140_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si140_instit"])) {
      $sql .= $virgula . " si140_instit = $this->si140_instit ";
      $virgula = ",";
      if (trim($this->si140_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si140_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    if ($si140_sequencial != null) {
      $sql .= " si140_sequencial = $this->si140_sequencial";
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "aop132024 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si140_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aop132024 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si140_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si140_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si140_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from aop132024
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si140_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si140_sequencial = $si140_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "aop132024 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si140_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aop132024 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si140_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si140_sequencial;
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
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "Erro ao selecionar os registros.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql = "Record Vazio na Tabela:aop132024";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si140_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aop132024 ";
    $sql .= " left join aop102024  on  aop102024.si140_sequencial = aop132024.si140_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si140_sequencial != null) {
        $sql2 .= " where aop132024.si140_sequencial = $si140_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
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
  function sql_query_file($si140_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aop132024 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si140_sequencial != null) {
        $sql2 .= " where aop132024.si140_sequencial = $si140_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
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
