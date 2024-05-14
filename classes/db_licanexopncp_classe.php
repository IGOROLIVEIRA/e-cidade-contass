<?php
//MODULO: licitacao
//CLASSE DA ENTIDADE licanexopncp
class cl_licanexopncp
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
  public $l215_sequencial = 0;
  public $l215_liclicita = 0;
  public $l215_dataanexo_dia = null;
  public $l215_dataanexo_mes = null;
  public $l215_dataanexo_ano = null;
  public $l215_dataanexo = null;
  public $l215_id_usuario = 0;
  public $l215_hora = null;
  public $l215_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 l215_sequencial = int8 = l215_sequencial
                 l215_liclicita = int8 = l215_liclicita
                 l215_dataanexo = date = l215_dataanexo
                 l215_id_usuario = int8 = l215_id_usuario
                 l215_hora = varchar(5) = l215_hora
                 l215_instit = int8 = l215_instit
                 ";

  //funcao construtor da classe
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licanexopncp");
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
      $this->l215_sequencial = ($this->l215_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_sequencial"] : $this->l215_sequencial);
      $this->l215_liclicita = ($this->l215_liclicita == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_liclicita"] : $this->l215_liclicita);
      if ($this->l215_dataanexo == "") {
        $this->l215_dataanexo_dia = ($this->l215_dataanexo_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_dataanexo_dia"] : $this->l215_dataanexo_dia);
        $this->l215_dataanexo_mes = ($this->l215_dataanexo_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_dataanexo_mes"] : $this->l215_dataanexo_mes);
        $this->l215_dataanexo_ano = ($this->l215_dataanexo_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_dataanexo_ano"] : $this->l215_dataanexo_ano);
        if ($this->l215_dataanexo_dia != "") {
          $this->l215_dataanexo = $this->l215_dataanexo_ano . "-" . $this->l215_dataanexo_mes . "-" . $this->l215_dataanexo_dia;
        }
      }
      $this->l215_id_usuario = ($this->l215_id_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_id_usuario"] : $this->l215_id_usuario);
      $this->l215_hora = ($this->l215_hora == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_hora"] : $this->l215_hora);
      $this->l215_instit = ($this->l215_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["l215_instit"] : $this->l215_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();

    if ($this->l215_liclicita == null) {
      $this->erro_sql = " Campo l215_liclicita não informado.";
      $this->erro_campo = "l215_liclicita";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l215_dataanexo == null) {
      $this->erro_sql = " Campo l215_dataanexo não informado.";
      $this->erro_campo = "l215_dataanexo_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l215_id_usuario == null) {
      $this->erro_sql = " Campo l215_id_usuario não informado.";
      $this->erro_campo = "l215_id_usuario";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l215_hora == null) {
      $this->erro_sql = " Campo l215_hora não informado.";
      $this->erro_campo = "l215_hora";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l215_instit == null) {
      $this->erro_sql = " Campo l215_instit não informado.";
      $this->erro_campo = "l215_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->l215_sequencial == "" || $this->l215_sequencial == null) {
      $result = db_query("select nextval('licanexopncp_l215_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: licanexopncp_l215_sequencial_seq do campo: l215_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->l215_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from licanexopncp_l215_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $this->l215_sequencial)) {
        $this->erro_sql = " Campo l215_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->l215_sequencial = $this->l215_sequencial;
      }
    }
    if (($this->l215_sequencial == null) || ($this->l215_sequencial == "")) {
      $this->erro_sql = " Campo l215_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into licanexopncp(
                                       l215_sequencial
                                      ,l215_liclicita
                                      ,l215_dataanexo
                                      ,l215_id_usuario
                                      ,l215_hora
                                      ,l215_instit
                       )
                values (
                                $this->l215_sequencial
                               ,$this->l215_liclicita
                               ," . ($this->l215_dataanexo == "null" || $this->l215_dataanexo == "" ? "null" : "'" . $this->l215_dataanexo . "'") . "
                               ,$this->l215_id_usuario
                               ,'$this->l215_hora'
                               ,$this->l215_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "licanexopncp () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "licanexopncp já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "licanexopncp () nao Incluído. Inclusao Abortada.";
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
    $sql = " update licanexopncp set ";
    $virgula = "";
    if (trim($this->l215_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_sequencial"])) {
      $sql  .= $virgula . " l215_sequencial = $this->l215_sequencial ";
      $virgula = ",";
      if (trim($this->l215_sequencial) == null) {
        $this->erro_sql = " Campo l215_sequencial não informado.";
        $this->erro_campo = "l215_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l215_liclicita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_liclicita"])) {
      $sql  .= $virgula . " l215_liclicita = $this->l215_liclicita ";
      $virgula = ",";
      if (trim($this->l215_liclicita) == null) {
        $this->erro_sql = " Campo l215_liclicita não informado.";
        $this->erro_campo = "l215_liclicita";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l215_dataanexo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_dataanexo_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["l215_dataanexo_dia"] != "")) {
      $sql  .= $virgula . " l215_dataanexo = '$this->l215_dataanexo' ";
      $virgula = ",";
      if (trim($this->l215_dataanexo) == null) {
        $this->erro_sql = " Campo l215_dataanexo não informado.";
        $this->erro_campo = "l215_dataanexo_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["l215_dataanexo_dia"])) {
        $sql  .= $virgula . " l215_dataanexo = null ";
        $virgula = ",";
        if (trim($this->l215_dataanexo) == null) {
          $this->erro_sql = " Campo l215_dataanexo não informado.";
          $this->erro_campo = "l215_dataanexo_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->l215_id_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_id_usuario"])) {
      $sql  .= $virgula . " l215_id_usuario = $this->l215_id_usuario ";
      $virgula = ",";
      if (trim($this->l215_id_usuario) == null) {
        $this->erro_sql = " Campo l215_id_usuario não informado.";
        $this->erro_campo = "l215_id_usuario";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l215_hora) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_hora"])) {
      $sql  .= $virgula . " l215_hora = '$this->l215_hora' ";
      $virgula = ",";
      if (trim($this->l215_hora) == null) {
        $this->erro_sql = " Campo l215_hora não informado.";
        $this->erro_campo = "l215_hora";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->l215_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["l215_instit"])) {
      $sql  .= $virgula . " l215_instit = $this->l215_instit ";
      $virgula = ",";
      if (trim($this->l215_instit) == null) {
        $this->erro_sql = " Campo l215_instit não informado.";
        $this->erro_campo = "l215_instit";
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
      $this->erro_sql   = "licanexopncp nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "licanexopncp nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($l215_sequencial = null, $dbwhere = null)
  {

    $sql = " delete from licanexopncp
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "l215_sequencial = $l215_sequencial";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "licanexopncp nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "licanexopncp nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:licanexopncp";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query($oid = null, $campos = "licanexopncp.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from licanexopncp ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where licanexopncp.oid = '$oid'";
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
    die($sql);
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
    $sql .= " from licanexopncp ";
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

  public function sql_anexos_licitacao_aviso($l20_codigo)
  {
    $sql = "
            SELECT l216_nomedocumento,
            l213_sequencial,
            l213_descricao,
            l216_sequencial
        FROM licanexopncp
        INNER JOIN licanexopncpdocumento ON l215_sequencial = l216_licanexospncp
        INNER JOIN tipoanexo ON l213_sequencial = l216_tipoanexo
        WHERE l215_liclicita = {$l20_codigo} ORDER BY l213_sequencial limit 1;
    ";
    return $sql;
  }

  public function sql_anexos_licitacao_aviso_todos($l20_codigo)
  {
    $sql = "
          SELECT l216_nomedocumento,
          l213_sequencial,
          l213_descricao,
          l216_sequencial
      FROM licanexopncp
      INNER JOIN licanexopncpdocumento ON l215_sequencial = l216_licanexospncp
      INNER JOIN tipoanexo ON l213_sequencial = l216_tipoanexo
      WHERE l215_liclicita = {$l20_codigo} ORDER BY l213_sequencial OFFSET  1;
    ";
    return $sql;
  }

  public function sql_anexos_licitacao($l20_codigo, $l216_sequencial)
  {
    $sql = "
       SELECT l216_nomedocumento,l216_tipoanexo,l213_descricao
        FROM licanexopncp
        INNER JOIN licanexopncpdocumento ON l215_sequencial = l216_licanexospncp
        INNER JOIN tipoanexo ON l213_sequencial = l216_tipoanexo
        where l215_liclicita = {$l20_codigo} and l216_sequencial = $l216_sequencial
    ";
    return $sql;
  }

  public function sql_anexos_licitacao_exclusao($l20_codigo)
  {
      $sql = "
       SELECT l216_nomedocumento,l216_tipoanexo,l213_descricao
        FROM licanexopncp
        INNER JOIN licanexopncpdocumento ON l215_sequencial = l216_licanexospncp
        INNER JOIN tipoanexo ON l213_sequencial = l216_tipoanexo
        where l215_liclicita = {$l20_codigo}
    ";
      return $sql;
  }
}
