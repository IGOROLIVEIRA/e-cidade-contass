<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE licataregitem
class cl_licataregitem
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
  public $l222_licatareg = 0;
  public $l222_ordem = 0;
  public $l222_item = 0;
  public $l222_descricao = null;
  public $l222_unidade = null;
  public $l222_quantidade = 0;
  public $l222_valorunit = 0;
  public $l222_valortot = 0;
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 l222_licatareg = int8 = l222_licatareg 
                 l222_ordem = int4 = l222_ordem 
                 l222_item = int8 = l222_item 
                 l222_descricao = varchar(255) = l222_descricao 
                 l222_unidade = varchar(255) = l222_unidade 
                 l222_quantidade = float8 = l222_quantidade 
                 l222_valorunit = float8 = l222_valorunit 
                 l222_valortot = float8 = l222_valortot 
                 ";

  //funcao construtor da classe 
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licataregitem");
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
      $this->l222_licatareg = ($this->l222_licatareg == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_licatareg"] : $this->l222_licatareg);
      $this->l222_ordem = ($this->l222_ordem == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_ordem"] : $this->l222_ordem);
      $this->l222_item = ($this->l222_item == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_item"] : $this->l222_item);
      $this->l222_descricao = ($this->l222_descricao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_descricao"] : $this->l222_descricao);
      $this->l222_unidade = ($this->l222_unidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_unidade"] : $this->l222_unidade);
      $this->l222_quantidade = ($this->l222_quantidade == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_quantidade"] : $this->l222_quantidade);
      $this->l222_valorunit = ($this->l222_valorunit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_valorunit"] : $this->l222_valorunit);
      $this->l222_valortot = ($this->l222_valortot == "" ? @$GLOBALS["HTTP_POST_VARS"]["l222_valortot"] : $this->l222_valortot);
    } else {
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if ($this->l222_licatareg == null) {
      $this->erro_sql = " Campo l222_licatareg não informado.";
      $this->erro_campo = "l222_licatareg";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l222_ordem == null) {
      $this->erro_sql = " Campo l222_ordem não informado.";
      $this->erro_campo = "l222_ordem";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l222_item == null) {
      $this->erro_sql = " Campo l222_item não informado.";
      $this->erro_campo = "l222_item";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l222_descricao == null) {
      $this->erro_sql = " Campo l222_descricao não informado.";
      $this->erro_campo = "l222_descricao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l222_unidade == null) {
      $this->erro_sql = " Campo l222_unidade não informado.";
      $this->erro_campo = "l222_unidade";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l222_quantidade == null) {
      $this->erro_sql = " Campo l222_quantidade não informado.";
      $this->erro_campo = "l222_quantidade";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l222_valorunit == null) {
      $this->erro_sql = " Campo l222_valorunit não informado.";
      $this->erro_campo = "l222_valorunit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l222_valortot == null) {
      $this->erro_sql = " Campo l222_valortot não informado.";
      $this->erro_campo = "l222_valortot";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into licataregitem(
                                       l222_licatareg 
                                      ,l222_ordem 
                                      ,l222_item 
                                      ,l222_descricao 
                                      ,l222_unidade 
                                      ,l222_quantidade 
                                      ,l222_valorunit 
                                      ,l222_valortot 
                       )
                values (
                                $this->l222_licatareg 
                               ,$this->l222_ordem 
                               ,$this->l222_item 
                               ,'$this->l222_descricao' 
                               ,'$this->l222_unidade' 
                               ,$this->l222_quantidade 
                               ,$this->l222_valorunit 
                               ,$this->l222_valortot 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "licataregitem () nao IncluÃ­do. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "licataregitem jÃ¡ Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "licataregitem () nao IncluÃ­do. Inclusao Abortada.";
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
    $sql = " update licataregitem set ";
    $virgula = "";
    if (trim($this->l222_licatareg) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_licatareg"])) {
      $sql  .= $virgula . " l222_licatareg = $this->l222_licatareg ";
      $virgula = ",";
      if (trim($this->l222_licatareg) == null) {
        $this->erro_sql = " Campo l222_licatareg não informado.";
        $this->erro_campo = "l222_licatareg";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l222_ordem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_ordem"])) {
      $sql  .= $virgula . " l222_ordem = $this->l222_ordem ";
      $virgula = ",";
      if (trim($this->l222_ordem) == null) {
        $this->erro_sql = " Campo l222_ordem não informado.";
        $this->erro_campo = "l222_ordem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l222_item) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_item"])) {
      $sql  .= $virgula . " l222_item = $this->l222_item ";
      $virgula = ",";
      if (trim($this->l222_item) == null) {
        $this->erro_sql = " Campo l222_item não informado.";
        $this->erro_campo = "l222_item";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l222_descricao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_descricao"])) {
      $sql  .= $virgula . " l222_descricao = '$this->l222_descricao' ";
      $virgula = ",";
      if (trim($this->l222_descricao) == null) {
        $this->erro_sql = " Campo l222_descricao não informado.";
        $this->erro_campo = "l222_descricao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l222_unidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_unidade"])) {
      $sql  .= $virgula . " l222_unidade = '$this->l222_unidade' ";
      $virgula = ",";
      if (trim($this->l222_unidade) == null) {
        $this->erro_sql = " Campo l222_unidade não informado.";
        $this->erro_campo = "l222_unidade";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l222_quantidade) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_quantidade"])) {
      $sql  .= $virgula . " l222_quantidade = $this->l222_quantidade ";
      $virgula = ",";
      if (trim($this->l222_quantidade) == null) {
        $this->erro_sql = " Campo l222_quantidade não informado.";
        $this->erro_campo = "l222_quantidade";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l222_valorunit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_valorunit"])) {
      $sql  .= $virgula . " l222_valorunit = $this->l222_valorunit ";
      $virgula = ",";
      if (trim($this->l222_valorunit) == null) {
        $this->erro_sql = " Campo l222_valorunit não informado.";
        $this->erro_campo = "l222_valorunit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l222_valortot) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l222_valortot"])) {
      $sql  .= $virgula . " l222_valortot = $this->l222_valortot ";
      $virgula = ",";
      if (trim($this->l222_valortot) == null) {
        $this->erro_sql = " Campo l222_valortot não informado.";
        $this->erro_campo = "l222_valortot";
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
      $this->erro_sql   = "licataregitem nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "licataregitem nao foi Alterado. Alteracao Executada.\\n";
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

    $sql = " delete from licataregitem
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
      $this->erro_sql   = "licataregitem nao ExcluÃ­do. ExclusÃ£o Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "licataregitem nao Encontrado. ExclusÃ£o não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:licataregitem";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql 
  function sql_query($oid = null, $campos = "licataregitem.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from licataregitem ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where licataregitem.oid = '$oid'";
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
    $sql .= " from licataregitem ";
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
