<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE situacaoitemlic
class cl_situacaoitemlic
{
  // cria variaveis de erro 
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status = null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo 
  public $l219_codigo = 0;
  public $l219_situacao = 0;
  public $l219_data_dia = null;
  public $l219_data_mes = null;
  public $l219_data_ano = null;
  public $l219_data = null;
  public $l219_id_usuario = 0;
  public $l219_hora = null;
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 l219_codigo = int8 = l219_codigo 
                 l219_situacao = int8 = l219_situacao 
                 l219_data = date = l219_data 
                 l219_id_usuario = int8 = l219_id_usuario 
                 l219_hora = varchar(5) = l219_hora 
                 ";

  //funcao construtor da classe 
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("situacaoitemlic");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
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
      $this->l219_codigo = ($this->l219_codigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l219_codigo"] : $this->l219_codigo);
      $this->l219_situacao = ($this->l219_situacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l219_situacao"] : $this->l219_situacao);
      if ($this->l219_data == "") {
        $this->l219_data_dia = ($this->l219_data_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l219_data_dia"] : $this->l219_data_dia);
        $this->l219_data_mes = ($this->l219_data_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l219_data_mes"] : $this->l219_data_mes);
        $this->l219_data_ano = ($this->l219_data_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l219_data_ano"] : $this->l219_data_ano);
        if ($this->l219_data_dia != "") {
          $this->l219_data = $this->l219_data_ano . "-" . $this->l219_data_mes . "-" . $this->l219_data_dia;
        }
      }
      $this->l219_id_usuario = ($this->l219_id_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["l219_id_usuario"] : $this->l219_id_usuario);
      $this->l219_hora = ($this->l219_hora == "" ? @$GLOBALS["HTTP_POST_VARS"]["l219_hora"] : $this->l219_hora);
    } else {
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if ($this->l219_codigo == null) {
      $this->erro_sql = " Campo l219_codigo não informado.";
      $this->erro_campo = "l219_codigo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l219_situacao == null) {
      $this->erro_sql = " Campo l219_situacao não informado.";
      $this->erro_campo = "l219_situacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l219_data == null) {
      $this->erro_sql = " Campo l219_data não informado.";
      $this->erro_campo = "l219_data_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l219_id_usuario == null) {
      $this->erro_sql = " Campo l219_id_usuario não informado.";
      $this->erro_campo = "l219_id_usuario";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l219_hora == null) {
      $this->erro_sql = " Campo l219_hora não informado.";
      $this->erro_campo = "l219_hora";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into situacaoitemlic(
                                       l219_codigo 
                                      ,l219_situacao 
                                      ,l219_data 
                                      ,l219_id_usuario 
                                      ,l219_hora 
                       )
                values (
                                $this->l219_codigo 
                               ,$this->l219_situacao 
                               ," . ($this->l219_data == "null" || $this->l219_data == "" ? "null" : "'" . $this->l219_data . "'") . " 
                               ,$this->l219_id_usuario 
                               ,'$this->l219_hora' 
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "situacaoitemlic () nao IncluÃ­do. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "situacaoitemlic jÃ¡ Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "situacaoitemlic () nao IncluÃ­do. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
      && ($lSessaoDesativarAccount === false))) {
    }
    return true;
  }

  // funcao para alteracao
  function alterar($oid = null)
  {
    $this->atualizacampos();
    $sql = " update situacaoitemlic set ";
    $virgula = "";
    if (trim($this->l219_codigo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l219_codigo"])) {
      $sql  .= $virgula . " l219_codigo = $this->l219_codigo ";
      $virgula = ",";
      if (trim($this->l219_codigo) == null) {
        $this->erro_sql = " Campo l219_codigo não informado.";
        $this->erro_campo = "l219_codigo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l219_situacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l219_situacao"])) {
      $sql  .= $virgula . " l219_situacao = $this->l219_situacao ";
      $virgula = ",";
      if (trim($this->l219_situacao) == null) {
        $this->erro_sql = " Campo l219_situacao não informado.";
        $this->erro_campo = "l219_situacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l219_data) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l219_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l219_data_dia"] != "")) {
      $sql  .= $virgula . " l219_data = '$this->l219_data' ";
      $virgula = ",";
      if (trim($this->l219_data) == null) {
        $this->erro_sql = " Campo l219_data não informado.";
        $this->erro_campo = "l219_data_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["l219_data_dia"])) {
        $sql  .= $virgula . " l219_data = null ";
        $virgula = ",";
        if (trim($this->l219_data) == null) {
          $this->erro_sql = " Campo l219_data não informado.";
          $this->erro_campo = "l219_data_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->l219_id_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l219_id_usuario"])) {
      $sql  .= $virgula . " l219_id_usuario = $this->l219_id_usuario ";
      $virgula = ",";
      if (trim($this->l219_id_usuario) == null) {
        $this->erro_sql = " Campo l219_id_usuario não informado.";
        $this->erro_campo = "l219_id_usuario";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l219_hora) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l219_hora"])) {
      $sql  .= $virgula . " l219_hora = '$this->l219_hora' ";
      $virgula = ",";
      if (trim($this->l219_hora) == null) {
        $this->erro_sql = " Campo l219_hora não informado.";
        $this->erro_campo = "l219_hora";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "oid = '$oid'";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "situacaoitemlic nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "situacaoitemlic nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "AlteraÃ§Ã£o efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir($oid = null, $dbwhere = null)
  {

    $sql = " delete from situacaoitemlic
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "oid = '$oid'";
    } else {
      $sql2 = $dbwhere;
    }

    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "situacaoitemlic nao ExcluÃ­do. ExclusÃ£o Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "situacaoitemlic nao Encontrado. ExclusÃ£o não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "ExclusÃ£o efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
      $this->numrows    = 0;
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows == 0) {
      $this->erro_banco = "";
      $this->erro_sql   = "Record Vazio na Tabela:situacaoitemlic";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql 
  function sql_query($oid = null, $campos = "situacaoitemlic.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from situacaoitemlic ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where situacaoitemlic.oid = '$oid'";
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
  function sql_query_file($oid = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from situacaoitemlic ";
    $sql2 = "";
    if ($dbwhere == "") {
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
