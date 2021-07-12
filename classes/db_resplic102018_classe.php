<?
//MODULO: sicom
//CLASSE DA ENTIDADE resplic102018
class cl_resplic102018
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
  var $si55_sequencial = 0;
  var $si55_tiporegistro = 0;
  var $si55_codorgao = null;
  var $si55_codunidadesub = null;
  var $si55_exerciciolicitacao = 0;
  var $si55_nroprocessolicitatorio = null;
  var $si55_tiporesp = 0;
  var $si55_nrocpfresp = null;
  var $si55_mes = 0;
  var $si55_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si55_sequencial = int8 = sequencial 
                 si55_tiporegistro = int8 = Tipo do registro 
                 si55_codorgao = varchar(2) = Código do órgão 
                 si55_codunidadesub = varchar(8) = Código da unidade 
                 si55_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si55_nroprocessolicitatorio = varchar(12) = Número sequencial  do processo 
                 si55_tiporesp = int8 = Tipo de  responsabilidade 
                 si55_nrocpfresp = varchar(11) = Número do CPF do  responsável 
                 si55_mes = int8 = Mês 
                 si55_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_resplic102018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("resplic102018");
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
      $this->si55_sequencial = ($this->si55_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_sequencial"] : $this->si55_sequencial);
      $this->si55_tiporegistro = ($this->si55_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_tiporegistro"] : $this->si55_tiporegistro);
      $this->si55_codorgao = ($this->si55_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_codorgao"] : $this->si55_codorgao);
      $this->si55_codunidadesub = ($this->si55_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_codunidadesub"] : $this->si55_codunidadesub);
      $this->si55_exerciciolicitacao = ($this->si55_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_exerciciolicitacao"] : $this->si55_exerciciolicitacao);
      $this->si55_nroprocessolicitatorio = ($this->si55_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_nroprocessolicitatorio"] : $this->si55_nroprocessolicitatorio);
      $this->si55_tiporesp = ($this->si55_tiporesp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_tiporesp"] : $this->si55_tiporesp);
      $this->si55_nrocpfresp = ($this->si55_nrocpfresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_nrocpfresp"] : $this->si55_nrocpfresp);
      $this->si55_mes = ($this->si55_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_mes"] : $this->si55_mes);
      $this->si55_instit = ($this->si55_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_instit"] : $this->si55_instit);
    } else {
      $this->si55_sequencial = ($this->si55_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si55_sequencial"] : $this->si55_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si55_sequencial)
  {
    $this->atualizacampos();
    if (strlen($this->si55_nrocpfresp) > 11) {
      $this->erro_sql = " Responsável não pode ser Cnpj. Favor conferir Processo Licitatório: $this->si55_nroprocessolicitatorio/$this->si55_exerciciolicitacao,
       responsável tipo $this->si55_tiporesp";
      $this->erro_campo = "si55_nrocpfresp";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si55_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si55_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si55_exerciciolicitacao == null) {
      $this->si55_exerciciolicitacao = "0";
    }
    if ($this->si55_tiporesp == null) {
      $this->si55_tiporesp = "0";
    }
    if ($this->si55_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si55_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si55_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si55_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si55_sequencial == "" || $si55_sequencial == null) {
      $result = db_query("select nextval('resplic102018_si55_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: resplic102018_si55_sequencial_seq do campo: si55_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si55_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from resplic102018_si55_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si55_sequencial)) {
        $this->erro_sql = " Campo si55_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si55_sequencial = $si55_sequencial;
      }
    }
    if (($this->si55_sequencial == null) || ($this->si55_sequencial == "")) {
      $this->erro_sql = " Campo si55_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into resplic102018(
                                       si55_sequencial 
                                      ,si55_tiporegistro 
                                      ,si55_codorgao 
                                      ,si55_codunidadesub 
                                      ,si55_exerciciolicitacao 
                                      ,si55_nroprocessolicitatorio 
                                      ,si55_tiporesp 
                                      ,si55_nrocpfresp 
                                      ,si55_mes 
                                      ,si55_instit 
                       )
                values (
                                $this->si55_sequencial 
                               ,$this->si55_tiporegistro 
                               ,'$this->si55_codorgao' 
                               ,'$this->si55_codunidadesub' 
                               ,$this->si55_exerciciolicitacao 
                               ,'$this->si55_nroprocessolicitatorio' 
                               ,$this->si55_tiporesp 
                               ,'$this->si55_nrocpfresp' 
                               ,$this->si55_mes 
                               ,$this->si55_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "resplic102018 ($this->si55_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "resplic102018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "resplic102018 ($this->si55_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si55_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si55_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009985,'$this->si55_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010284,2009985,'','" . AddSlashes(pg_result($resaco, 0, 'si55_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009986,'','" . AddSlashes(pg_result($resaco, 0, 'si55_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009987,'','" . AddSlashes(pg_result($resaco, 0, 'si55_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009988,'','" . AddSlashes(pg_result($resaco, 0, 'si55_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009989,'','" . AddSlashes(pg_result($resaco, 0, 'si55_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009990,'','" . AddSlashes(pg_result($resaco, 0, 'si55_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009991,'','" . AddSlashes(pg_result($resaco, 0, 'si55_tiporesp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009992,'','" . AddSlashes(pg_result($resaco, 0, 'si55_nrocpfresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2009993,'','" . AddSlashes(pg_result($resaco, 0, 'si55_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010284,2011567,'','" . AddSlashes(pg_result($resaco, 0, 'si55_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si55_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update resplic102018 set ";
    $virgula = "";
    if (trim($this->si55_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_sequencial"])) {
      if (trim($this->si55_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si55_sequencial"])) {
        $this->si55_sequencial = "0";
      }
      $sql .= $virgula . " si55_sequencial = $this->si55_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si55_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_tiporegistro"])) {
      $sql .= $virgula . " si55_tiporegistro = $this->si55_tiporegistro ";
      $virgula = ",";
      if (trim($this->si55_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si55_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si55_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_codorgao"])) {
      $sql .= $virgula . " si55_codorgao = '$this->si55_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si55_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_codunidadesub"])) {
      $sql .= $virgula . " si55_codunidadesub = '$this->si55_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si55_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_exerciciolicitacao"])) {
      if (trim($this->si55_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si55_exerciciolicitacao"])) {
        $this->si55_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si55_exerciciolicitacao = $this->si55_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si55_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si55_nroprocessolicitatorio = '$this->si55_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si55_tiporesp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_tiporesp"])) {
      if (trim($this->si55_tiporesp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si55_tiporesp"])) {
        $this->si55_tiporesp = "0";
      }
      $sql .= $virgula . " si55_tiporesp = $this->si55_tiporesp ";
      $virgula = ",";
    }
    if (trim($this->si55_nrocpfresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_nrocpfresp"])) {
      $sql .= $virgula . " si55_nrocpfresp = '$this->si55_nrocpfresp' ";
      $virgula = ",";
    }
    if (trim($this->si55_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_mes"])) {
      $sql .= $virgula . " si55_mes = $this->si55_mes ";
      $virgula = ",";
      if (trim($this->si55_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si55_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si55_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si55_instit"])) {
      $sql .= $virgula . " si55_instit = $this->si55_instit ";
      $virgula = ",";
      if (trim($this->si55_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si55_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si55_sequencial != null) {
      $sql .= " si55_sequencial = $this->si55_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si55_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009985,'$this->si55_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_sequencial"]) || $this->si55_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009985,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_sequencial')) . "','$this->si55_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_tiporegistro"]) || $this->si55_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009986,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_tiporegistro')) . "','$this->si55_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_codorgao"]) || $this->si55_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009987,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_codorgao')) . "','$this->si55_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_codunidadesub"]) || $this->si55_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009988,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_codunidadesub')) . "','$this->si55_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_exerciciolicitacao"]) || $this->si55_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009989,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_exerciciolicitacao')) . "','$this->si55_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_nroprocessolicitatorio"]) || $this->si55_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009990,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_nroprocessolicitatorio')) . "','$this->si55_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_tiporesp"]) || $this->si55_tiporesp != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009991,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_tiporesp')) . "','$this->si55_tiporesp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_nrocpfresp"]) || $this->si55_nrocpfresp != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009992,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_nrocpfresp')) . "','$this->si55_nrocpfresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_mes"]) || $this->si55_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2009993,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_mes')) . "','$this->si55_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si55_instit"]) || $this->si55_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010284,2011567,'" . AddSlashes(pg_result($resaco, $conresaco, 'si55_instit')) . "','$this->si55_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "resplic102018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si55_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "resplic102018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si55_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si55_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si55_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si55_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009985,'$si55_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010284,2009985,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009986,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009987,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009988,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009989,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009990,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009991,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_tiporesp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009992,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_nrocpfresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2009993,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010284,2011567,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si55_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from resplic102018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si55_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si55_sequencial = $si55_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "resplic102018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si55_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "resplic102018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si55_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si55_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:resplic102018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si55_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from resplic102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si55_sequencial != null) {
        $sql2 .= " where resplic102018.si55_sequencial = $si55_sequencial ";
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
  function sql_query_file($si55_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from resplic102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si55_sequencial != null) {
        $sql2 .= " where resplic102018.si55_sequencial = $si55_sequencial ";
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
