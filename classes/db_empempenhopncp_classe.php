<?php
//MODULO: empenho
//CLASSE DA ENTIDADE empempenhopncp
class cl_empempenhopncp
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
  public $e213_sequencial = 0;
  public $e213_contrato = 0;
  public $e213_usuario = 0;
  public $e213_dtlancamento_dia = null;
  public $e213_dtlancamento_mes = null;
  public $e213_dtlancamento_ano = null;
  public $e213_dtlancamento = null;
  public $e213_numerocontrolepncp = null;
  public $e213_situacao = 0;
  public $e213_instit = 0;
  public $e213_ano = 0;
  public $e213_sequencialpncp = 0;
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 e213_sequencial = int8 = Sequencial Empenho 
                 e213_contrato = int8 = Contrato PNCP 
                 e213_usuario = int8 = Usuário PNCP 
                 e213_dtlancamento = date = Data Lançamento 
                 e213_numerocontrolepncp = varchar(250) = Número de Controle PNCP 
                 e213_situacao = int8 = Situação PNCP 
                 e213_instit = int8 = Instituição PNCP 
                 e213_ano = int8 = Ano Empenho PNCP 
                 e213_sequencialpncp = int8 = Sequencial PNCP 
                 ";

  //funcao construtor da classe 
  function __construct()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("empempenhopncp");
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
      $this->e213_sequencial = ($this->e213_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_sequencial"] : $this->e213_sequencial);
      $this->e213_contrato = ($this->e213_contrato == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_contrato"] : $this->e213_contrato);
      $this->e213_usuario = ($this->e213_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_usuario"] : $this->e213_usuario);
      if ($this->e213_dtlancamento == "") {
        $this->e213_dtlancamento_dia = ($this->e213_dtlancamento_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_dtlancamento_dia"] : $this->e213_dtlancamento_dia);
        $this->e213_dtlancamento_mes = ($this->e213_dtlancamento_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_dtlancamento_mes"] : $this->e213_dtlancamento_mes);
        $this->e213_dtlancamento_ano = ($this->e213_dtlancamento_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_dtlancamento_ano"] : $this->e213_dtlancamento_ano);
        if ($this->e213_dtlancamento_dia != "") {
          $this->e213_dtlancamento = $this->e213_dtlancamento_ano . "-" . $this->e213_dtlancamento_mes . "-" . $this->e213_dtlancamento_dia;
        }
      }
      $this->e213_numerocontrolepncp = ($this->e213_numerocontrolepncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_numerocontrolepncp"] : $this->e213_numerocontrolepncp);
      $this->e213_situacao = ($this->e213_situacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_situacao"] : $this->e213_situacao);
      $this->e213_instit = ($this->e213_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_instit"] : $this->e213_instit);
      $this->e213_ano = ($this->e213_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_ano"] : $this->e213_ano);
      $this->e213_sequencialpncp = ($this->e213_sequencialpncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["e213_sequencialpncp"] : $this->e213_sequencialpncp);
    } else {
    }
  }

  // funcao para inclusao
  function incluir()
  {

    $this->atualizacampos();

    if ($this->e213_contrato == null) {
      $this->erro_sql = " Campo Contrato PNCP não informado.";
      $this->erro_campo = "e213_contrato";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_usuario == null) {
      $this->erro_sql = " Campo Usuário PNCP não informado.";
      $this->erro_campo = "e213_usuario";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_dtlancamento == null) {
      $this->erro_sql = " Campo Data Lançamento não informado.";
      $this->erro_campo = "e213_dtlancamento_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_numerocontrolepncp == null) {
      $this->erro_sql = " Campo Número de Controle PNCP não informado.";
      $this->erro_campo = "e213_numerocontrolepncp";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_situacao == null) {
      $this->erro_sql = " Campo Situação PNCP não informado.";
      $this->erro_campo = "e213_situacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_instit == null) {
      $this->erro_sql = " Campo Instituição PNCP não informado.";
      $this->erro_campo = "e213_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_ano == null) {
      $this->erro_sql = " Campo Ano Empenho PNCP não informado.";
      $this->erro_campo = "e213_ano";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_sequencialpncp == null) {
      $this->erro_sql = " Campo Sequencial PNCP não informado.";
      $this->erro_campo = "e213_sequencialpncp";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->e213_sequencial == "" || $this->e213_sequencial == null) {
      $result = db_query("select nextval('empempenhopncp_e213_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: empempenhopncp_e213_sequencial_seq do campo: ac213_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->e213_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from empempenhopncp_e213_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $this->e213_sequencial)) {
        $this->erro_sql = " Campo e213_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->e213_sequencial = $this->e213_sequencial;
      }
    }
    if (($this->e213_sequencial == null) || ($this->e213_sequencial == "")) {
      $this->erro_sql = " Campo e213_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into empempenhopncp(
                                       e213_sequencial 
                                      ,e213_contrato 
                                      ,e213_usuario 
                                      ,e213_dtlancamento 
                                      ,e213_numerocontrolepncp 
                                      ,e213_situacao 
                                      ,e213_instit 
                                      ,e213_ano 
                                      ,e213_sequencialpncp 
                       )
                values (
                                $this->e213_sequencial 
                               ,$this->e213_contrato 
                               ,$this->e213_usuario 
                               ," . ($this->e213_dtlancamento == "null" || $this->e213_dtlancamento == "" ? "null" : "'" . $this->e213_dtlancamento . "'") . " 
                               ,'$this->e213_numerocontrolepncp' 
                               ,$this->e213_situacao 
                               ,$this->e213_instit 
                               ,$this->e213_ano 
                               ,$this->e213_sequencialpncp 
                      )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = "Empenho PNCP () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "Empenho PNCP já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = "Empenho PNCP () nao Incluído. Inclusao Abortada.";
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
    $sql = " update empempenhopncp set ";
    $virgula = "";
    if (trim($this->e213_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_sequencial"])) {
      $sql  .= $virgula . " e213_sequencial = $this->e213_sequencial ";
      $virgula = ",";
      if (trim($this->e213_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial Empenho não informado.";
        $this->erro_campo = "e213_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e213_contrato) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_contrato"])) {
      $sql  .= $virgula . " e213_contrato = $this->e213_contrato ";
      $virgula = ",";
      if (trim($this->e213_contrato) == null) {
        $this->erro_sql = " Campo Contrato PNCP não informado.";
        $this->erro_campo = "e213_contrato";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e213_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_usuario"])) {
      $sql  .= $virgula . " e213_usuario = $this->e213_usuario ";
      $virgula = ",";
      if (trim($this->e213_usuario) == null) {
        $this->erro_sql = " Campo Usuário PNCP não informado.";
        $this->erro_campo = "e213_usuario";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e213_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["e213_dtlancamento_dia"] != "")) {
      $sql  .= $virgula . " e213_dtlancamento = '$this->e213_dtlancamento' ";
      $virgula = ",";
      if (trim($this->e213_dtlancamento) == null) {
        $this->erro_sql = " Campo Data Lançamento não informado.";
        $this->erro_campo = "e213_dtlancamento_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["e213_dtlancamento_dia"])) {
        $sql  .= $virgula . " e213_dtlancamento = null ";
        $virgula = ",";
        if (trim($this->e213_dtlancamento) == null) {
          $this->erro_sql = " Campo Data Lançamento não informado.";
          $this->erro_campo = "e213_dtlancamento_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->e213_numerocontrolepncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_numerocontrolepncp"])) {
      $sql  .= $virgula . " e213_numerocontrolepncp = '$this->e213_numerocontrolepncp' ";
      $virgula = ",";
      if (trim($this->e213_numerocontrolepncp) == null) {
        $this->erro_sql = " Campo Número de Controle PNCP não informado.";
        $this->erro_campo = "e213_numerocontrolepncp";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e213_situacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_situacao"])) {
      $sql  .= $virgula . " e213_situacao = $this->e213_situacao ";
      $virgula = ",";
      if (trim($this->e213_situacao) == null) {
        $this->erro_sql = " Campo Situação PNCP não informado.";
        $this->erro_campo = "e213_situacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e213_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_instit"])) {
      $sql  .= $virgula . " e213_instit = $this->e213_instit ";
      $virgula = ",";
      if (trim($this->e213_instit) == null) {
        $this->erro_sql = " Campo Instituição PNCP não informado.";
        $this->erro_campo = "e213_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e213_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_ano"])) {
      $sql  .= $virgula . " e213_ano = $this->e213_ano ";
      $virgula = ",";
      if (trim($this->e213_ano) == null) {
        $this->erro_sql = " Campo Ano Empenho PNCP não informado.";
        $this->erro_campo = "e213_ano";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->e213_sequencialpncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["e213_sequencialpncp"])) {
      $sql  .= $virgula . " e213_sequencialpncp = $this->e213_sequencialpncp ";
      $virgula = ",";
      if (trim($this->e213_sequencialpncp) == null) {
        $this->erro_sql = " Campo Sequencial PNCP não informado.";
        $this->erro_campo = "e213_sequencialpncp";
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
      $this->erro_sql   = "Empenho PNCP nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Empenho PNCP nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir($oid = null, $dbwhere = null)
  {

    $sql = " delete from empempenhopncp
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
      $this->erro_sql   = "Empenho PNCP nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "Empenho PNCP nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:empempenhopncp";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql 
  function sql_query($oid = null, $campos = "empempenhopncp.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from empempenhopncp ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where empempenhopncp.oid = '$oid'";
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
    $sql .= " from empempenhopncp ";
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
