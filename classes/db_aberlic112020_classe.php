<?
//MODULO: sicom
//CLASSE DA ENTIDADE aberlic112020
class cl_aberlic112020
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
  var $si47_sequencial = 0;
  var $si47_tiporegistro = 0;
  var $si47_codorgaoresp = null;
  var $si47_codunidadesubresp = null;
  var $si47_exerciciolicitacao = 0;
  var $si47_nroprocessolicitatorio = null;
  var $si47_nrolote = 0;
  var $si47_dsclote = null;
  var $si47_mes = 0;
  var $si47_reg10 = 0;
  var $si47_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si47_sequencial = int8 = sequencial 
                 si47_tiporegistro = int8 = Tipo do  registro 
                 si47_codorgaoresp = varchar(2) = Código do órgão 
                 si47_codunidadesubresp = varchar(8) = Código da unidade 
                 si47_exerciciolicitacao = int8 = Exercício em que   foi instaurado 
                 si47_nroprocessolicitatorio = varchar(12) = Número sequencial do processo 
                 si47_nrolote = int8 = Número do Lote 
                 si47_dsclote = varchar(250) = Descrição do Lote 
                 si47_mes = int8 = Mês 
                 si47_reg10 = int8 = reg10 
                 si47_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aberlic112020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aberlic112020");
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
      $this->si47_sequencial = ($this->si47_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_sequencial"] : $this->si47_sequencial);
      $this->si47_tiporegistro = ($this->si47_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_tiporegistro"] : $this->si47_tiporegistro);
      $this->si47_codorgaoresp = ($this->si47_codorgaoresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_codorgaoresp"] : $this->si47_codorgaoresp);
      $this->si47_codunidadesubresp = ($this->si47_codunidadesubresp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_codunidadesubresp"] : $this->si47_codunidadesubresp);
      $this->si47_exerciciolicitacao = ($this->si47_exerciciolicitacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_exerciciolicitacao"] : $this->si47_exerciciolicitacao);
      $this->si47_nroprocessolicitatorio = ($this->si47_nroprocessolicitatorio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_nroprocessolicitatorio"] : $this->si47_nroprocessolicitatorio);
      $this->si47_nrolote = ($this->si47_nrolote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_nrolote"] : $this->si47_nrolote);
      $this->si47_dsclote = ($this->si47_dsclote == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_dsclote"] : $this->si47_dsclote);
      $this->si47_mes = ($this->si47_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_mes"] : $this->si47_mes);
      $this->si47_reg10 = ($this->si47_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_reg10"] : $this->si47_reg10);
      $this->si47_instit = ($this->si47_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_instit"] : $this->si47_instit);
    } else {
      $this->si47_sequencial = ($this->si47_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si47_sequencial"] : $this->si47_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si47_sequencial)
  {
    $this->atualizacampos();
    if ($this->si47_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si47_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si47_exerciciolicitacao == null) {
      $this->si47_exerciciolicitacao = "0";
    }
    if ($this->si47_nrolote == null) {
      $this->si47_nrolote = "0";
    }
    if ($this->si47_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si47_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si47_reg10 == null) {
      $this->si47_reg10 = "0";
    }
    if ($this->si47_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si47_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si47_sequencial == "" || $si47_sequencial == null) {
      $result = db_query("select nextval('aberlic112020_si47_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aberlic112020_si47_sequencial_seq do campo: si47_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si47_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aberlic112020_si47_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si47_sequencial)) {
        $this->erro_sql = " Campo si47_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si47_sequencial = $si47_sequencial;
      }
    }
    if (($this->si47_sequencial == null) || ($this->si47_sequencial == "")) {
      $this->erro_sql = " Campo si47_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aberlic112020(
                                       si47_sequencial 
                                      ,si47_tiporegistro 
                                      ,si47_codorgaoresp 
                                      ,si47_codunidadesubresp 
                                      ,si47_exerciciolicitacao 
                                      ,si47_nroprocessolicitatorio 
                                      ,si47_nrolote 
                                      ,si47_dsclote 
                                      ,si47_mes 
                                      ,si47_reg10 
                                      ,si47_instit 
                       )
                values (
                                $this->si47_sequencial 
                               ,$this->si47_tiporegistro 
                               ,'$this->si47_codorgaoresp' 
                               ,'$this->si47_codunidadesubresp' 
                               ,$this->si47_exerciciolicitacao 
                               ,'$this->si47_nroprocessolicitatorio' 
                               ,$this->si47_nrolote 
                               ,'$this->si47_dsclote' 
                               ,$this->si47_mes 
                               ,$this->si47_reg10 
                               ,$this->si47_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aberlic112020 ($this->si47_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aberlic112020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aberlic112020 ($this->si47_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si47_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si47_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009899,'$this->si47_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010276,2009899,'','" . AddSlashes(pg_result($resaco, 0, 'si47_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009900,'','" . AddSlashes(pg_result($resaco, 0, 'si47_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009901,'','" . AddSlashes(pg_result($resaco, 0, 'si47_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009902,'','" . AddSlashes(pg_result($resaco, 0, 'si47_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009903,'','" . AddSlashes(pg_result($resaco, 0, 'si47_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009904,'','" . AddSlashes(pg_result($resaco, 0, 'si47_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009905,'','" . AddSlashes(pg_result($resaco, 0, 'si47_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009906,'','" . AddSlashes(pg_result($resaco, 0, 'si47_dsclote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009907,'','" . AddSlashes(pg_result($resaco, 0, 'si47_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2009908,'','" . AddSlashes(pg_result($resaco, 0, 'si47_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010276,2011561,'','" . AddSlashes(pg_result($resaco, 0, 'si47_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si47_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aberlic112020 set ";
    $virgula = "";
    if (trim($this->si47_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_sequencial"])) {
      if (trim($this->si47_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si47_sequencial"])) {
        $this->si47_sequencial = "0";
      }
      $sql .= $virgula . " si47_sequencial = $this->si47_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si47_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_tiporegistro"])) {
      $sql .= $virgula . " si47_tiporegistro = $this->si47_tiporegistro ";
      $virgula = ",";
      if (trim($this->si47_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si47_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si47_codorgaoresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_codorgaoresp"])) {
      $sql .= $virgula . " si47_codorgaoresp = '$this->si47_codorgaoresp' ";
      $virgula = ",";
    }
    if (trim($this->si47_codunidadesubresp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_codunidadesubresp"])) {
      $sql .= $virgula . " si47_codunidadesubresp = '$this->si47_codunidadesubresp' ";
      $virgula = ",";
    }
    if (trim($this->si47_exerciciolicitacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_exerciciolicitacao"])) {
      if (trim($this->si47_exerciciolicitacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si47_exerciciolicitacao"])) {
        $this->si47_exerciciolicitacao = "0";
      }
      $sql .= $virgula . " si47_exerciciolicitacao = $this->si47_exerciciolicitacao ";
      $virgula = ",";
    }
    if (trim($this->si47_nroprocessolicitatorio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_nroprocessolicitatorio"])) {
      $sql .= $virgula . " si47_nroprocessolicitatorio = '$this->si47_nroprocessolicitatorio' ";
      $virgula = ",";
    }
    if (trim($this->si47_nrolote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_nrolote"])) {
      if (trim($this->si47_nrolote) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si47_nrolote"])) {
        $this->si47_nrolote = "0";
      }
      $sql .= $virgula . " si47_nrolote = $this->si47_nrolote ";
      $virgula = ",";
    }
    if (trim($this->si47_dsclote) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_dsclote"])) {
      $sql .= $virgula . " si47_dsclote = '$this->si47_dsclote' ";
      $virgula = ",";
    }
    if (trim($this->si47_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_mes"])) {
      $sql .= $virgula . " si47_mes = $this->si47_mes ";
      $virgula = ",";
      if (trim($this->si47_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si47_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si47_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_reg10"])) {
      if (trim($this->si47_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si47_reg10"])) {
        $this->si47_reg10 = "0";
      }
      $sql .= $virgula . " si47_reg10 = $this->si47_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si47_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si47_instit"])) {
      $sql .= $virgula . " si47_instit = $this->si47_instit ";
      $virgula = ",";
      if (trim($this->si47_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si47_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si47_sequencial != null) {
      $sql .= " si47_sequencial = $this->si47_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si47_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009899,'$this->si47_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_sequencial"]) || $this->si47_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009899,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_sequencial')) . "','$this->si47_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_tiporegistro"]) || $this->si47_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009900,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_tiporegistro')) . "','$this->si47_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_codorgaoresp"]) || $this->si47_codorgaoresp != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009901,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_codorgaoresp')) . "','$this->si47_codorgaoresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_codunidadesubresp"]) || $this->si47_codunidadesubresp != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009902,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_codunidadesubresp')) . "','$this->si47_codunidadesubresp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_exerciciolicitacao"]) || $this->si47_exerciciolicitacao != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009903,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_exerciciolicitacao')) . "','$this->si47_exerciciolicitacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_nroprocessolicitatorio"]) || $this->si47_nroprocessolicitatorio != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009904,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_nroprocessolicitatorio')) . "','$this->si47_nroprocessolicitatorio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_nrolote"]) || $this->si47_nrolote != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009905,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_nrolote')) . "','$this->si47_nrolote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_dsclote"]) || $this->si47_dsclote != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009906,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_dsclote')) . "','$this->si47_dsclote'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_mes"]) || $this->si47_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009907,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_mes')) . "','$this->si47_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_reg10"]) || $this->si47_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2009908,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_reg10')) . "','$this->si47_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si47_instit"]) || $this->si47_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010276,2011561,'" . AddSlashes(pg_result($resaco, $conresaco, 'si47_instit')) . "','$this->si47_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aberlic112020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si47_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic112020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si47_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si47_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si47_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si47_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009899,'$si47_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010276,2009899,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009900,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009901,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_codorgaoresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009902,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_codunidadesubresp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009903,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_exerciciolicitacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009904,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_nroprocessolicitatorio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009905,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_nrolote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009906,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_dsclote')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009907,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2009908,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010276,2011561,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si47_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aberlic112020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si47_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si47_sequencial = $si47_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("", "", @pg_last_error());
      $this->erro_sql = "aberlic112020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si47_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aberlic112020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si47_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si47_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aberlic112020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si47_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aberlic112020 ";
    $sql .= "      left  join aberlic102020  on  aberlic102020.si46_sequencial = aberlic112020.si47_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si47_sequencial != null) {
        $sql2 .= " where aberlic112020.si47_sequencial = $si47_sequencial ";
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
  function sql_query_file($si47_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aberlic112020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si47_sequencial != null) {
        $sql2 .= " where aberlic112020.si47_sequencial = $si47_sequencial ";
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
