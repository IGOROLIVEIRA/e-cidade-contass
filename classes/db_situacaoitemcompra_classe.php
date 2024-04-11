<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE situacaoitemcompra
class cl_situacaoitemcompra
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
  public $l218_codigo = null;
  public $l218_codigolicitacao = 0;
  public $l218_pcorcamitemlic = 0;
  public $l218_liclicitem = 0;
  public $l218_pcmater = 0;
  public $l218_motivoanulacao = null;
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 l218_codigo = int8 = l218_codigo 
                 l218_codigolicitacao = int8 = l218_codigolicitacao 
                 l218_pcorcamitemlic = int8 = l218_pcorcamitemlic 
                 l218_liclicitem = int8 = l218_liclicitem 
                 l218_pcmater = int8 = l218_pcmater 
                 l218_motivoanulacao = varchar(255) = l218_motivoanulacao 
                 ";

  //funcao construtor da classe 
  function __construct()
  {

    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("situacaoitemcompra");

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
      $this->l218_codigo = ($this->l218_codigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_codigo"] : $this->l218_codigo);
      $this->l218_codigolicitacao = ($this->l218_codigolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_codigolicitacao"] : $this->l218_codigolicitacao);
      $this->l218_pcorcamitemlic = ($this->l218_pcorcamitemlic == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_pcorcamitemlic"] : $this->l218_pcorcamitemlic);
      $this->l218_liclicitem = ($this->l218_liclicitem == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_liclicitem"] : $this->l218_liclicitem);
      $this->l218_pcmater = ($this->l218_pcmater == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_pcmater"] : $this->l218_pcmater);
      $this->l218_motivoanulacao = ($this->l218_motivoanulacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["l218_motivoanulacao"] : $this->l218_motivoanulacao);
    } else {
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if ($this->l218_codigo == "" || $this->l218_codigo == null) {
      $result = db_query("select nextval('situacaoitemcompra_l218_codigo_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: situacaoitemcompra_l218_codigo_seq do campo: l218_codigo";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->l218_codigo = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from situacaoitemcompra_l218_codigo_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $this->l218_codigo)) {
        $this->erro_sql = " Campo l218_codigo maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->l218_codigo = $this->l218_codigo;
      }
    }
    if ($this->l218_pcorcamitemlic == null) {
      $this->erro_sql = " Campo l218_pcorcamitemlic não informado.";
      $this->erro_campo = "l218_pcorcamitemlic";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into situacaoitemcompra(
                                       l218_codigo 
                                      ,l218_codigolicitacao 
                                      ,l218_pcorcamitemlic 
                                      ,l218_liclicitem 
                                      ,l218_pcmater 
                                      ,l218_motivoanulacao 
                       )
                values (
                                $this->l218_codigo 
                               ,$this->l218_codigolicitacao 
                               ,$this->l218_pcorcamitemlic 
                               ,$this->l218_liclicitem 
                               ,0
                               ,'$this->l218_motivoanulacao' 
                      )";

    $result = db_query($sql);

    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "situacaoitemcompra () nao IncluÃ­do. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "situacaoitemcompra jÃ¡ Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "situacaoitemcompra () nao IncluÃ­do. Inclusao Abortada.";
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
    $sql = " update situacaoitemcompra set ";
    $virgula = "";
    if (trim($this->l218_codigo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_codigo"])) {
      $sql  .= $virgula . " l218_codigo = $this->l218_codigo ";
      $virgula = ",";
      if (trim($this->l218_codigo) == null) {
        $this->erro_sql = " Campo l218_codigo não informado.";
        $this->erro_campo = "l218_codigo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l218_codigolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_codigolicitacao"])) {
      $sql  .= $virgula . " l218_codigolicitacao = $this->l218_codigolicitacao ";
      $virgula = ",";
      if (trim($this->l218_codigolicitacao) == null) {
        $this->erro_sql = " Campo l218_codigolicitacao não informado.";
        $this->erro_campo = "l218_codigolicitacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l218_pcorcamitemlic) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_pcorcamitemlic"])) {
      $sql  .= $virgula . " l218_pcorcamitemlic = $this->l218_pcorcamitemlic ";
      $virgula = ",";
      if (trim($this->l218_pcorcamitemlic) == null) {
        $this->erro_sql = " Campo l218_pcorcamitemlic não informado.";
        $this->erro_campo = "l218_pcorcamitemlic";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l218_liclicitem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_liclicitem"])) {
      $sql  .= $virgula . " l218_liclicitem = $this->l218_liclicitem ";
      $virgula = ",";
      if (trim($this->l218_liclicitem) == null) {
        $this->erro_sql = " Campo l218_liclicitem não informado.";
        $this->erro_campo = "l218_liclicitem";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l218_pcmater) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_pcmater"])) {
      $sql  .= $virgula . " l218_pcmater = $this->l218_pcmater ";
      $virgula = ",";
      if (trim($this->l218_pcmater) == null) {
        $this->erro_sql = " Campo l218_pcmater não informado.";
        $this->erro_campo = "l218_pcmater";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l218_motivoanulacao) == "0") {
      $sql  .= $virgula . " l218_motivoanulacao = '' ";
      $virgula = ",";
    } else if (trim($this->l218_motivoanulacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l218_motivoanulacao"])) {
      $sql  .= $virgula . " l218_motivoanulacao = '$this->l218_motivoanulacao' ";
      $virgula = ",";
      if (trim($this->l218_motivoanulacao) == null) {
        $this->erro_sql = " Campo l218_motivoanulacao não informado.";
        $this->erro_campo = "l218_motivoanulacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    $sql .= " where ";
    $sql .= "l218_pcorcamitemlic = '$oid'";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "situacaoitemcompra nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "situacaoitemcompra nao foi Alterado. Alteracao Executada.\\n";
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

    $sql = " delete from situacaoitemcompra
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
      $this->erro_sql   = "situacaoitemcompra nao ExcluÃ­do. ExclusÃ£o Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "situacaoitemcompra nao Encontrado. ExclusÃ£o não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:situacaoitemcompra";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql 
  function sql_query($oid = null, $campos = "situacaoitemcompra.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from situacaoitemcompra ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where situacaoitemcompra.oid = '$oid'";
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
    $sql .= " from situacaoitemcompra ";
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
