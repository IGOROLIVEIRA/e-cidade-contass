<?
//MODULO: configurações
//CLASSE DA ENTIDADE manutencaolicitacao
class cl_manutencaolicitacao
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
  var $manutlic_sequencial = 0;
  var $manutlic_codunidsubanterior = null;
  var $manutlic_licitacao = 0;

  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 manutlic_sequencial = int8 = Sequencial
                 manutlic_codunidsubanterior = int4 = Cod unid sub anterior
                 manutlic_licitacao = int8 = Numeração
                 ";

  //funcao construtor da classe
  function cl_manutencaolicitacao()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("manutencaolicitacao");
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
  function atualizacampos()
  {
    $this->manutlic_sequencial = ($this->manutlic_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["manutlic_sequencial"] : $this->manutlic_sequencial);
    $this->manutlic_codunidsubanterior = ($this->manutlic_codunidsubanterior == "" ? @$GLOBALS["HTTP_POST_VARS"]["manutlic_codunidsubanterior"] : $this->manutlic_codunidsubanterior);
    $this->manutlic_licitacao = ($this->manutlic_licitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["manutlic_licitacao"] : $this->manutlic_licitacao);
  }

  // funcao para inclusao aqui
  function incluir($manutlic_sequencial = null)
  {
    $this->atualizacampos();

    if ($manutlic_sequencial == "" || $manutlic_sequencial == null) {
      $result = db_query("select nextval('manutencaolicitacao_manutlic_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: manutencaolicitacao_manutlic_sequencial_seq do campo: manutlic_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->manutlic_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from manutencaolicitacao_manutlic_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $manutlic_sequencial)) {
        $this->erro_sql = " Campo manutlic_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->manutlic_sequencial = $manutlic_sequencial;
      }
    }

    $sql = "insert into manutencaolicitacao(
                                 manutlic_sequencial
                ,manutlic_codunidsubanterior
                ,manutlic_licitacao
                       )
                values (
                         $this->manutlic_sequencial
                ,'$this->manutlic_codunidsubanterior'
                ,$this->manutlic_licitacao
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "manutencaolicitacao ($this->manutlic_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "manutencaolicitacao já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "manutencaolicitacao ($this->manutlic_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->manutlic_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    return true;
  }

  // funcao para alteracao
  function alterar($manutlic_sequencial = null)
  {
    $this->atualizacampos();

    $sql = " update manutencaolicitacao set ";
    $virgula = "";

    $sql .= " where ";
    if ($manutlic_sequencial != null) {
      $sql .= " manutlic_sequencial = $this->manutlic_sequencial";
    }

    $result = db_query($sql);

    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "manutencaolicitacao nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->manutlic_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "manutencaolicitacao nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->manutlic_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->manutlic_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  public function excluir($manutlic_sequencial = null, $dbwhere = null)
  {
    $sql = " delete from manutencaolicitacao
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($manutlic_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " manutlic_sequencial = $manutlic_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "manutencaolicitacao nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $manutlic_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "manutencaolicitacao nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $manutlic_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $manutlic_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao do recordset
  public function sql_record($sql)
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
      $this->erro_sql = "Record Vazio na Tabela:manutencaolicitacao";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql

  function sql_query($manutlic_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "", $groupby = null)
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
    $sql .= " from manutencaolicitacao ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($manutlic_sequencial != null) {
        $sql2 .= " where manutencaolicitacao.manutlic_sequencial = $manutlic_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($groupby != null) {
      $sql .= " group by ";
      $campos_sql = split("#", $groupby);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $groupby;
    }
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
  function sql_query_file($manutlic_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from manutencaolicitacao ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($manutlic_sequencial != null) {
        $sql2 .= " where manutencaolicitacao.manutlic_sequencial = $manutlic_sequencial ";
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
