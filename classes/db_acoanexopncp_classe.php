<?
//MODULO: acordos
//CLASSE DA ENTIDADE acoanexopncp
class cl_acoanexopncp
{
  // cria variaveis de erro
  var $rotulo     = null;
  var $query_sql  = null;
  var $numrows    = 0;
  var $erro_status = null;
  var $erro_sql   = null;
  var $erro_banco = null;
  var $erro_msg   = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo
  var $ac214_sequencial = 0;
  var $ac214_acordo = 0;
  var $ac214_usuario = 0;
  var $ac214_dtlancamento_dia = null;
  var $ac214_dtlancamento_mes = null;
  var $ac214_dtlancamento_ano = null;
  var $ac214_dtlancamento = null;
  var $ac214_numerocontrolepncp = null;
  var $ac214_tipoanexo = null;
  var $ac214_instit = 0;
  var $ac214_ano = 0;
  var $ac214_sequencialpncp = 0;
  var $ac214_sequencialarquivo = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 ac214_sequencial = int8 = Sequencial Anexos
                 ac214_acordo = int8 = Código do Acordo
                 ac214_usuario = int8 = Código do Usuário
                 ac214_dtlancamento = date = Data Lançamento
                 ac214_numerocontrolepncp = varchar(250) = Número de Controle Anexo PNCP
                 ac214_tipoanexo = varchar(30) = Tipo de Anexo
                 ac214_instit = int8 = Tipo de Instituição
                 ac214_ano = int8 = Ano Empenho PNCP
                 ac214_sequencialpncp = int8 = Sequencial PNCP
                 ac214_sequencialarquivo = int8 = Sequencial Anexos PNCP
                 ";
  //funcao construtor da classe
  function cl_acoanexopncp()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("acoanexopncp");
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
      $this->ac214_sequencial = ($this->ac214_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_sequencial"] : $this->ac214_sequencial);
      $this->ac214_acordo = ($this->ac214_acordo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_acordo"] : $this->ac214_acordo);
      $this->ac214_usuario = ($this->ac214_usuario == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_usuario"] : $this->ac214_usuario);
      if ($this->ac214_dtlancamento == "") {
        $this->ac214_dtlancamento_dia = @$GLOBALS["HTTP_POST_VARS"]["ac214_dtlancamento_dia"];
        $this->ac214_dtlancamento_mes = @$GLOBALS["HTTP_POST_VARS"]["ac214_dtlancamento_mes"];
        $this->ac214_dtlancamento_ano = @$GLOBALS["HTTP_POST_VARS"]["ac214_dtlancamento_ano"];
        if ($this->ac214_dtlancamento_dia != "") {
          $this->ac214_dtlancamento = $this->ac214_dtlancamento_ano . "-" . $this->ac214_dtlancamento_mes . "-" . $this->ac214_dtlancamento_dia;
        }
      }
      $this->ac214_numerocontrolepncp = ($this->ac214_numerocontrolepncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_numerocontrolepncp"] : $this->ac214_numerocontrolepncp);
      $this->ac214_tipoanexo = ($this->ac214_tipoanexo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_tipoanexo"] : $this->ac214_tipoanexo);
      $this->ac214_instit = ($this->ac214_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_instit"] : $this->ac214_instit);
      $this->ac214_ano = ($this->ac214_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_ano"] : $this->ac214_ano);
      $this->ac214_sequencialpncp = ($this->ac214_sequencialpncp == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_sequencialpncp"] : $this->ac214_sequencialpncp);
      $this->ac214_sequencialarquivo = ($this->ac214_sequencialarquivo == "" ? @$GLOBALS["HTTP_POST_VARS"]["ac214_sequencialarquivo"] : $this->ac214_sequencialarquivo);
    } else {
    }
  }
  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if ($this->ac214_acordo == null) {
      $this->erro_sql = " Campo Código do Acordo nao Informado.";
      $this->erro_campo = "ac214_acordo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_usuario == null) {
      $this->erro_sql = " Campo Código do Usuário nao Informado.";
      $this->erro_campo = "ac214_usuario";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_dtlancamento == null) {
      $this->erro_sql = " Campo Data Lançamento nao Informado.";
      $this->erro_campo = "ac214_dtlancamento_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_numerocontrolepncp == null) {
      $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
      $this->erro_campo = "ac214_numerocontrolepncp";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_tipoanexo == null) {
      $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
      $this->erro_campo = "ac214_tipoanexo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_instit == null) {
      $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
      $this->erro_campo = "ac214_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_ano == null) {
      $this->erro_sql = " Campo Ano Empenho PNCP nao Informado.";
      $this->erro_campo = "ac214_ano";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_sequencialpncp == null) {
      $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
      $this->erro_campo = "ac214_sequencialpncp";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_sequencialarquivo == null) {
      $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
      $this->erro_campo = "ac214_sequencialarquivo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->ac214_sequencial == "" || $this->ac214_sequencial == null) {
      $result = db_query("select nextval('acoanexopncp_ac214_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: acoanexopncp_ac214_sequencial_seq do campo: ac214_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->ac214_sequencial = pg_result($result, 0, 0);
    }
    $sql = "insert into acoanexopncp(
                                       ac214_sequencial
                                      ,ac214_acordo
                                      ,ac214_usuario
                                      ,ac214_dtlancamento
                                      ,ac214_numerocontrolepncp
                                      ,ac214_tipoanexo
                                      ,ac214_instit
                                      ,ac214_ano
                                      ,ac214_sequencialpncp
                                      ,ac214_sequencialarquivo
                       )
                values (
                                $this->ac214_sequencial
                               ,$this->ac214_acordo
                               ,$this->ac214_usuario
                               ," . ($this->ac214_dtlancamento == "null" || $this->ac214_dtlancamento == "" ? "null" : "'" . $this->ac214_dtlancamento . "'") . "
                               ,'$this->ac214_numerocontrolepncp'
                               ,'$this->ac214_tipoanexo'
                               ,$this->ac214_instit
                               ,$this->ac214_ano
                               ,$this->ac214_sequencialpncp
                               ,$this->ac214_sequencialarquivo

                               )";

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql   = " () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = " já Cadastrado";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql   = " () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    return true;
  }
  // funcao para alteracao
  function alterar($oid = null)
  {
    $this->atualizacampos();
    $sql = " update acoanexopncp set ";
    $virgula = "";
    if (trim($this->ac214_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_sequencial"])) {
      if (trim($this->ac214_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac214_sequencial"])) {
        $this->ac214_sequencial = "0";
      }
      $sql  .= $virgula . " ac214_sequencial = $this->ac214_sequencial ";
      $virgula = ",";
      if (trim($this->ac214_sequencial) == null) {
        $this->erro_sql = " Campo Sequencial Anexos nao Informado.";
        $this->erro_campo = "ac214_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_acordo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_acordo"])) {
      if (trim($this->ac214_acordo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac214_acordo"])) {
        $this->ac214_acordo = "0";
      }
      $sql  .= $virgula . " ac214_acordo = $this->ac214_acordo ";
      $virgula = ",";
      if (trim($this->ac214_acordo) == null) {
        $this->erro_sql = " Campo Código do Acordo nao Informado.";
        $this->erro_campo = "ac214_acordo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_usuario) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_usuario"])) {
      if (trim($this->ac214_usuario) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac214_usuario"])) {
        $this->ac214_usuario = "0";
      }
      $sql  .= $virgula . " ac214_usuario = $this->ac214_usuario ";
      $virgula = ",";
      if (trim($this->ac214_usuario) == null) {
        $this->erro_sql = " Campo Código do Usuário nao Informado.";
        $this->erro_campo = "ac214_usuario";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_dtlancamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ac214_dtlancamento_dia"] != "")) {
      $sql  .= $virgula . " ac214_dtlancamento = '$this->ac214_dtlancamento' ";
      $virgula = ",";
      if (trim($this->ac214_dtlancamento) == null) {
        $this->erro_sql = " Campo Data Lançamento nao Informado.";
        $this->erro_campo = "ac214_dtlancamento_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["ac214_dtlancamento_dia"])) {
        $sql  .= $virgula . " ac214_dtlancamento = null ";
        $virgula = ",";
        if (trim($this->ac214_dtlancamento) == null) {
          $this->erro_sql = " Campo Data Lançamento nao Informado.";
          $this->erro_campo = "ac214_dtlancamento_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->ac214_numerocontrolepncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_numerocontrolepncp"])) {
      $sql  .= $virgula . " ac214_numerocontrolepncp = '$this->ac214_numerocontrolepncp' ";
      $virgula = ",";
      if (trim($this->ac214_numerocontrolepncp) == null) {
        $this->erro_sql = " Campo Número de Controle Anexo PNCP nao Informado.";
        $this->erro_campo = "ac214_numerocontrolepncp";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_tipoanexo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_tipoanexo"])) {
      $sql  .= $virgula . " ac214_tipoanexo = '$this->ac214_tipoanexo' ";
      $virgula = ",";
      if (trim($this->ac214_tipoanexo) == null) {
        $this->erro_sql = " Campo Tipo de Anexo nao Informado.";
        $this->erro_campo = "ac214_tipoanexo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_instit"])) {
      if (trim($this->ac214_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac214_instit"])) {
        $this->ac214_instit = "0";
      }
      $sql  .= $virgula . " ac214_instit = $this->ac214_instit ";
      $virgula = ",";
      if (trim($this->ac214_instit) == null) {
        $this->erro_sql = " Campo Tipo de Instituição nao Informado.";
        $this->erro_campo = "ac214_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_ano) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_ano"])) {
      if (trim($this->ac214_ano) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac214_ano"])) {
        $this->ac214_ano = "0";
      }
      $sql  .= $virgula . " ac214_ano = $this->ac214_ano ";
      $virgula = ",";
      if (trim($this->ac214_ano) == null) {
        $this->erro_sql = " Campo Ano Empenho PNCP nao Informado.";
        $this->erro_campo = "ac214_ano";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_sequencialpncp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_sequencialpncp"])) {
      if (trim($this->ac214_sequencialpncp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac214_sequencialpncp"])) {
        $this->ac214_sequencialpncp = "0";
      }
      $sql  .= $virgula . " ac214_sequencialpncp = $this->ac214_sequencialpncp ";
      $virgula = ",";
      if (trim($this->ac214_sequencialpncp) == null) {
        $this->erro_sql = " Campo Sequencial PNCP nao Informado.";
        $this->erro_campo = "ac214_sequencialpncp";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->ac214_sequencialarquivo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["ac214_sequencialarquivo"])) {
      if (trim($this->ac214_sequencialarquivo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["ac214_sequencialarquivo"])) {
        $this->ac214_sequencialarquivo = "0";
      }
      $sql  .= $virgula . " ac214_sequencialarquivo = $this->ac214_sequencialarquivo ";
      $virgula = ",";
      if (trim($this->ac214_sequencialarquivo) == null) {
        $this->erro_sql = " Campo Sequencial Anexos PNCP nao Informado.";
        $this->erro_campo = "ac214_sequencialarquivo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where oid = $oid ";
    $result = @pg_exec($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      }
    }
  }
  // funcao para exclusao
  function excluir($oid = null)
  {
    $this->atualizacampos(true);
    $sql = " delete from acoanexopncp
                    where ";
    $sql2 = "";
    $sql2 = "ac214_acordo = $oid";
    //  echo $sql.$sql2;
    $result = @pg_exec($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql   = " nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = " nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        return true;
      }
    }
  }
  // funcao do recordset
  function sql_record($sql)
  {
    $result = @pg_query($sql);
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
      $this->erro_sql   = "Dados do Grupo nao Encontrado";
      $this->erro_msg   = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }
  // funcao do sql
  function sql_query($oid = null, $campos = "acoanexopncp.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from acoanexopncp ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where acoanexopncp.oid = $oid";
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
    $sql .= " from acoanexopncp ";
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
