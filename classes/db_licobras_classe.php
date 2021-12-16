<?php
//MODULO: Obras
//CLASSE DA ENTIDADE licobras
class cl_licobras
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
  public $obr01_sequencial = 0;
  public $obr01_licitacao = 0;
  public $obr01_dtlancamento_dia = null;
  public $obr01_dtlancamento_mes = null;
  public $obr01_dtlancamento_ano = null;
  public $obr01_dtlancamento = null;
  public $obr01_numeroobra = 0;
  public $obr01_linkobra = null;
  public $obr01_instit = 0;
  public $obr01_licitacaosistema = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 obr01_sequencial = int4 = Sequencial
                 obr01_licitacao = int4 = Processo Licitatório
                 obr01_dtlancamento = date = Data Lançamento
                 obr01_numeroobra = int4 = Nº Obra
                 obr01_linkobra = text = Link da Obra
                 obr01_dtinicioatividades = date = Data Inicio das Ativ. do Eng na Obra
                 obr01_instit = int4 = Instituição
                 obr01_licitacaosistema = int4 = Tipo de licitacao
                 ";

  //funcao construtor da classe
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licobras");
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
      $this->obr01_sequencial = ($this->obr01_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_sequencial"] : $this->obr01_sequencial);
      $this->obr01_licitacao = ($this->obr01_licitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_licitacao"] : $this->obr01_licitacao);
      if ($this->obr01_dtlancamento == "") {
        $this->obr01_dtlancamento_dia = ($this->obr01_dtlancamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"] : $this->obr01_dtlancamento_dia);
        $this->obr01_dtlancamento_mes = ($this->obr01_dtlancamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_mes"] : $this->obr01_dtlancamento_mes);
        $this->obr01_dtlancamento_ano = ($this->obr01_dtlancamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_ano"] : $this->obr01_dtlancamento_ano);
        if ($this->obr01_dtlancamento_dia != "") {
          $this->obr01_dtlancamento = $this->obr01_dtlancamento_ano . "-" . $this->obr01_dtlancamento_mes . "-" . $this->obr01_dtlancamento_dia;
        }
      }
      $this->obr01_numeroobra = ($this->obr01_numeroobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_numeroobra"] : $this->obr01_numeroobra);
      $this->obr01_linkobra = ($this->obr01_linkobra == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_linkobra"] : $this->obr01_linkobra);
      $this->obr01_instit = ($this->obr01_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_instit"] : $this->obr01_instit);
      $this->obr01_licitacaosistema = ($this->obr01_licitacaosistema == "" ? @$GLOBALS["HTTP_POST_VARS"]["obr01_licitacaosistema"] : $this->obr01_licitacaosistema);
    }
  }

  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if ($this->obr01_sequencial == null) {

      $result = db_query("select nextval('licobras_obr01_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: licobras_obr01_sequencial_seq do campo: obr01_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->obr01_sequencial = pg_result($result, 0, 0);
    }
    if ($this->obr01_licitacao == null) {
      $this->erro_sql = " Campo Processo Licitatório não informado.";
      $this->erro_campo = "obr01_licitacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr01_dtlancamento == null) {
      $this->erro_sql = " Campo Data Lançamento não informado.";
      $this->erro_campo = "obr01_dtlancamento_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr01_numeroobra == null) {
      $this->erro_sql = " Campo Nº Obra não informado.";
      $this->erro_campo = "obr01_numeroobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr01_linkobra == null) {
      $this->erro_sql = " Campo Link da Obra não informado.";
      $this->erro_campo = "obr01_linkobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr01_instit == null) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "obr01_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->obr01_licitacaosistema == null) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "obr01_licitacaosistema";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into licobras(
                                       obr01_sequencial
                                      ,obr01_licitacao
                                      ,obr01_dtlancamento
                                      ,obr01_numeroobra
                                      ,obr01_linkobra
                                      ,obr01_dtinicioatividades
                                      ,obr01_instit
                                      ,obr01_licitacaosistema
                       )
                values (
                                $this->obr01_sequencial
                               ,$this->obr01_licitacao
                               ," . ($this->obr01_dtlancamento == "null" || $this->obr01_dtlancamento == "" ? "null" : "'" . $this->obr01_dtlancamento . "'") . "
                               ,$this->obr01_numeroobra
                               ,'$this->obr01_linkobra'
                               ," . ($this->obr01_dtinicioatividades == "null" || $this->obr01_dtinicioatividades == "" ? "null" : "'" . $this->obr01_dtinicioatividades . "'") . "
                               ,$this->obr01_instit
                               ,$this->obr01_licitacaosistema
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "licobras () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "licobras já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "licobras () nao Incluído. Inclusao Abortada.";
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
  function alterar($obr01_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update licobras set ";
    $virgula = "";
    if (trim($this->obr01_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_sequencial"])) {
      $sql  .= $virgula . " obr01_sequencial = $this->obr01_sequencial ";
      $virgula = ",";
      if (trim($this->obr01_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "obr01_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr01_licitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_licitacao"])) {
      $sql  .= $virgula . " obr01_licitacao = $this->obr01_licitacao ";
      $virgula = ",";
      if (trim($this->obr01_licitacao) == null) {
        $this->erro_sql = " Campo Processo Licitatório não informado.";
        $this->erro_campo = "obr01_licitacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr01_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"] != "")) {
      $sql  .= $virgula . " obr01_dtlancamento = '$this->obr01_dtlancamento' ";
      $virgula = ",";
      if (trim($this->obr01_dtlancamento) == null) {
        $this->erro_sql = " Campo Data Lançamento não informado.";
        $this->erro_campo = "obr01_dtlancamento_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"])) {
        $sql  .= $virgula . " obr01_dtlancamento = null ";
        $virgula = ",";
        if (trim($this->obr01_dtlancamento) == null) {
          $this->erro_sql = " Campo Data Lançamento não informado.";
          $this->erro_campo = "obr01_dtlancamento_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->obr01_numeroobra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_numeroobra"])) {
      $sql  .= $virgula . " obr01_numeroobra = $this->obr01_numeroobra ";
      $virgula = ",";
      if (trim($this->obr01_numeroobra) == null) {
        $this->erro_sql = " Campo Nº Obra não informado.";
        $this->erro_campo = "obr01_numeroobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr01_linkobra) != "" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_linkobra"])) {
      $sql  .= $virgula . " obr01_linkobra = '$this->obr01_linkobra' ";
      $virgula = ",";
      if (trim($this->obr01_linkobra) == null) {
        $this->erro_sql = " Campo Link da Obra não informado.";
        $this->erro_campo = "obr01_linkobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr01_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_instit"])) {
      $sql  .= $virgula . " obr01_instit = $this->obr01_instit ";
      $virgula = ",";
      if (trim($this->obr01_instit) == null) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "obr01_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "obr01_sequencial = $obr01_sequencial";
    $result = db_query($sql); //die($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "licobras nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "licobras nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir($obr01_sequencial = null, $dbwhere = null)
  {

    $sql = " delete from licobras
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      $sql2 = "obr01_sequencial = $obr01_sequencial";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = "licobras nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "licobras nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:licobras";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query($obr01_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from licobras ";
    $sql .= " left  join liclicita on liclicita.l20_codigo = licobras.obr01_licitacao ";
    $sql .= " left  join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom ";
    $sql .= " left  join licobraslicitacao ON obr07_sequencial = obr01_licitacao ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($obr01_sequencial != "" && $obr01_sequencial != null) {
        $sql2 = " where obr01_sequencial = $obr01_sequencial";
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

  function sql_query_pesquisa($obr01_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from licobras ";
    $sql .= " inner join liclicita on liclicita.l20_codigo = licobras.obr01_licitacao ";
    $sql .= " inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom ";
    $sql .= " left join acordo on ac16_licitacao = l20_codigo";
    if ($dbwhere == "") {
      if ($obr01_sequencial != "" && $obr01_sequencial != null) {
        $sql .= " where obr01_sequencial = $obr01_sequencial";
      }
    } else if ($dbwhere != "") {
      $sql .= " where $dbwhere";
    }
    $sql .= "UNION ";
    $sql .= "select ";
    $sql .= "obr01_sequencial,
              obr01_numeroobra,
              obr01_licitacao,
              l20_edital,
              l03_descr,
              l20_numero,
              ac16_sequencial,
              l20_objeto,
              obr01_dtlancamento,
              obr01_licitacaosistema,
              obr01_linkobra";
    $sql .= " from licobras ";
    $sql .= " inner join licobraslicitacao on obr07_sequencial = obr01_licitacao ";
    $sql .= " left join liclicita on l20_codigo = obr01_licitacao ";
    $sql .= " left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom ";
    $sql .= " inner join pctipocompratribunal on obr07_tipoprocesso = l44_sequencial";
    $sql .= " left join acordo on ac16_licitacao = l20_codigo";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($obr01_sequencial != "" && $obr01_sequencial != null) {
        $sql2 = " where obr01_sequencial = $obr01_sequencial";
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
  function sql_query_file($obr01_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from licobras ";
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
