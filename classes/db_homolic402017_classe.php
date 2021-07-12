<?
//MODULO: sicom
//CLASSE DA ENTIDADE homolic402017
class cl_homolic402017
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
  var $si65_sequencial = 0;
  var $si65_tiporegistro = 0;
  var $si65_codorgao = null;
  var $si65_codunidadesub = null;
  var $si65_exerciciolicitacao = 0;
  var $si65_nroprocessolicitatorio = null;
  var $si65_dthomologacao_dia = null;
  var $si65_dthomologacao_mes = null;
  var $si65_dthomologacao_ano = null;
  var $si65_dthomologacao = null;
  var $si65_dtadjudicacao_dia = null;
  var $si65_dtadjudicacao_mes = null;
  var $si65_dtadjudicacao_ano = null;
  var $si65_dtadjudicacao = null;
  var $si65_mes = 0;
  var $si65_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si65_sequencial = int8 = sequencial 
                 si65_tiporegistro = int8 = Tipo do  registro 
                 si65_codorgao = varchar(2) = Código do órgão 
                 si65_codunidadesub = varchar(8) = Código da unidade 
                 si65_exerciciolicitacao = int8 = Exercício em que  foi instaurado 
                 si65_nroprocessolicitatorio = varchar(12) = Número sequencial  do processo 
                 si65_dthomologacao = date = Data de  homologação 
                 si65_dtadjudicacao = date = Data de  adjudicação 
                 si65_mes = int8 = Mês 
                 si65_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_homolic402017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("homolic402017");
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
      $this->si65_sequencial = ($this->si65_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_sequencial"] : $this->si65_sequencial);
      $this->si65_tiporegistro = ($this->si65_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_tiporegistro"] : $this->si65_tiporegistro);
      $this->si65_codorgao = ($this->si65_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_codorgao"] : $this->si65_codorgao);
      $this->si65_codunidadesub = ($this->si65_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_codunidadesub"] : $this->si65_codunidadesub);
      $this->si65_exerciciolicitacao = ($this->si65_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"] : $this->si65_exerciciolicitacao);
      $this->si65_nroprocessolicitatorio = ($this->si65_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_nroprocessolicitatorio"] : $this->si65_nroprocessolicitatorio);
      if ($this->si65_dthomologacao == "") {
        $this->si65_dthomologacao_dia = ($this->si65_dthomologacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_dthomologacao_dia"] : $this->si65_dthomologacao_dia);
        $this->si65_dthomologacao_mes = ($this->si65_dthomologacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_dthomologacao_mes"] : $this->si65_dthomologacao_mes);
        $this->si65_dthomologacao_ano = ($this->si65_dthomologacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_dthomologacao_ano"] : $this->si65_dthomologacao_ano);
        if ($this->si65_dthomologacao_dia != "") {
          $this->si65_dthomologacao = $this->si65_dthomologacao_ano . "-" . $this->si65_dthomologacao_mes . "-" . $this->si65_dthomologacao_dia;
        }
      }
      if ($this->si65_dtadjudicacao == "") {
        $this->si65_dtadjudicacao_dia = ($this->si65_dtadjudicacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_dtadjudicacao_dia"] : $this->si65_dtadjudicacao_dia);
        $this->si65_dtadjudicacao_mes = ($this->si65_dtadjudicacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_dtadjudicacao_mes"] : $this->si65_dtadjudicacao_mes);
        $this->si65_dtadjudicacao_ano = ($this->si65_dtadjudicacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_dtadjudicacao_ano"] : $this->si65_dtadjudicacao_ano);
        if ($this->si65_dtadjudicacao_dia != "") {
          $this->si65_dtadjudicacao = $this->si65_dtadjudicacao_ano . "-" . $this->si65_dtadjudicacao_mes . "-" . $this->si65_dtadjudicacao_dia;
        }
      }
      $this->si65_mes = ($this->si65_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_mes"] : $this->si65_mes);
      $this->si65_instit = ($this->si65_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_instit"] : $this->si65_instit);
    } else {
      $this->si65_sequencial = ($this->si65_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si65_sequencial"] : $this->si65_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si65_sequencial)
  {
    $this->atualizacampos();
    if ($this->si65_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si65_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si65_exerciciolicitacao == null) {
      $this->si65_exerciciolicitacao = "0";
    }
    if ($this->si65_dthomologacao == null) {
      $this->si65_dthomologacao = "null";
    }
    if ($this->si65_dtadjudicacao == null) {
      $this->si65_dtadjudicacao = "null";
    }
    if ($this->si65_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si65_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si65_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si65_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si65_sequencial == "" || $si65_sequencial == null) {
      $result = db_query("select nextval('homolic402017_si65_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: homolic402017_si65_sequencial_seq do campo: si65_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si65_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from homolic402017_si65_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si65_sequencial)) {
        $this->erro_sql = " Campo si65_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si65_sequencial = $si65_sequencial;
      }
    }
    if (($this->si65_sequencial == null) || ($this->si65_sequencial == "")) {
      $this->erro_sql = " Campo si65_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into homolic402017(
                                       si65_sequencial 
                                      ,si65_tiporegistro 
                                      ,si65_codorgao 
                                      ,si65_codunidadesub 
                                      ,si65_exerciciolicitacao 
                                      ,si65_nroprocessolicitatorio 
                                      ,si65_dthomologacao 
                                      ,si65_dtadjudicacao 
                                      ,si65_mes 
                                      ,si65_instit 
                       )
                values (
                                $this->si65_sequencial 
                               ,$this->si65_tiporegistro 
                               ,'$this->si65_codorgao' 
                               ,'$this->si65_codunidadesub' 
                               ,$this->si65_exerciciolicitacao 
                               ,'$this->si65_nroprocessolicitatorio' 
                               ," . ($this->si65_dthomologacao == "null" || $this->si65_dthomologacao == "" ? "null" : "'" . $this->si65_dthomologacao . "'") . "
                               ," . ($this->si65_dtadjudicacao == "null" || $this->si65_dtadjudicacao == "" ? "null" : "'" . $this->si65_dtadjudicacao . "'") . "
                               ,$this->si65_mes 
                               ,$this->si65_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "homolic402017 ($this->si65_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "homolic402017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "homolic402017 ($this->si65_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si65_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si65_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010144,'$this->si65_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010294,2010144,'','" . AddSlashes(pg_result($resaco, 0, 'si65_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010145,'','" . AddSlashes(pg_result($resaco, 0, 'si65_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010146,'','" . AddSlashes(pg_result($resaco, 0, 'si65_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010147,'','" . AddSlashes(pg_result($resaco, 0, 'si65_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010148,'','" . AddSlashes(pg_result($resaco, 0, 'si65_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010149,'','" . AddSlashes(pg_result($resaco, 0, 'si65_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010150,'','" . AddSlashes(pg_result($resaco, 0, 'si65_dthomologacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010151,'','" . AddSlashes(pg_result($resaco, 0, 'si65_dtadjudicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2010152,'','" . AddSlashes(pg_result($resaco, 0, 'si65_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010294,2011577,'','" . AddSlashes(pg_result($resaco, 0, 'si65_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si65_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update homolic402017 set ";
    $virgula = "";
    if (trim($this->si65_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_sequencial"])) {
      if (trim($this->si65_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si65_sequencial"])) {
        $this->si65_sequencial = "0";
      }
      $sql .= $virgula . " si65_sequencial = $this->si65_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si65_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_tiporegistro"])) {
      $sql .= $virgula . " si65_tiporegistro = $this->si65_tiporegistro ";
      $virgula = ",";
      if (trim($this->si65_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si65_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si65_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_codorgao"])) {
      $sql .= $virgula . " si65_codorgao = '$this->si65_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si65_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_codunidadesub"])) {
      $sql .= $virgula . " si65_codunidadesub = '$this->si65_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si65_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"])) {
      if (trim($this->si65_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"])) {
        $this->si65_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si65_exerciciolicitacao = $this->si65_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si65_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si65_nroprocessolicitatorio = '$this->si65_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si65_dthomologacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_dthomologacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si65_dthomologacao_dia"] != "")) {
      $sql .= $virgula . " si65_dthomologacao = '$this->si65_dthomologacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si65_dthomologacao_dia"])) {
        $sql .= $virgula . " si65_dthomologacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si65_dtadjudicacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_dtadjudicacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si65_dtadjudicacao_dia"] != "")) {
      $sql .= $virgula . " si65_dtadjudicacao = '$this->si65_dtadjudicacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si65_dtadjudicacao_dia"])) {
        $sql .= $virgula . " si65_dtadjudicacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si65_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_mes"])) {
      $sql .= $virgula . " si65_mes = $this->si65_mes ";
      $virgula = ",";
      if (trim($this->si65_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si65_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si65_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si65_instit"])) {
      $sql .= $virgula . " si65_instit = $this->si65_instit ";
      $virgula = ",";
      if (trim($this->si65_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si65_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si65_sequencial != null) {
      $sql .= " si65_sequencial = $this->si65_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si65_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010144,'$this->si65_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_sequencial"]) || $this->si65_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010144,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_sequencial')) . "','$this->si65_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_tiporegistro"]) || $this->si65_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010145,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_tiporegistro')) . "','$this->si65_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_codorgao"]) || $this->si65_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010146,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_codorgao')) . "','$this->si65_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_codunidadesub"]) || $this->si65_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010147,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_codunidadesub')) . "','$this->si65_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_exerciciolicitacao"]) || $this->si65_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010148,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_exerciciolicitacao')) . "','$this->si65_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_nroprocessolicitatorio"]) || $this->si65_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010149,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_nroprocessolicitatorio')) . "','$this->si65_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_dthomologacao"]) || $this->si65_dthomologacao != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010150,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_dthomologacao')) . "','$this->si65_dthomologacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_dtadjudicacao"]) || $this->si65_dtadjudicacao != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010151,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_dtadjudicacao')) . "','$this->si65_dtadjudicacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_mes"]) || $this->si65_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2010152,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_mes')) . "','$this->si65_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si65_instit"]) || $this->si65_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010294,2011577,'" . AddSlashes(pg_result($resaco, $conresaco, 'si65_instit')) . "','$this->si65_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "homolic402017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si65_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "homolic402017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si65_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si65_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si65_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si65_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010144,'$si65_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010294,2010144,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010145,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010146,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010147,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010148,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010149,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010150,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_dthomologacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010151,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_dtadjudicacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2010152,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010294,2011577,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si65_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from homolic402017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si65_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si65_sequencial = $si65_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "homolic402017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si65_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "homolic402017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si65_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si65_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
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
      $this->erro_sql = "Record Vazio na Tabela:homolic402017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si65_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from homolic402017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si65_sequencial != null) {
        $sql2 .= " where homolic402017.si65_sequencial = $si65_sequencial ";
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
  function sql_query_file($si65_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from homolic402017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si65_sequencial != null) {
        $sql2 .= " where homolic402017.si65_sequencial = $si65_sequencial ";
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
