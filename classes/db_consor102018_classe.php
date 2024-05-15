<?
//MODULO: sicom
//CLASSE DA ENTIDADE consor102018
class cl_consor102018
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
  var $si16_sequencial = 0;
  var $si16_tiporegistro = 0;
  var $si16_codorgao = null;
  var $si16_cnpjconsorcio = null;
  var $si16_areaatuacao = null;
  var $si16_descareaatuacao = null;
  var $si16_mes = 0;
  var $si16_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si16_sequencial = int8 = sequencial 
                 si16_tiporegistro = int8 = Tipo do  registro 
                 si16_codorgao = varchar(2) = Código do órgão 
                 si16_cnpjconsorcio = varchar(14) = Número do CNPJ  do Consórcio 
                 si16_areaatuacao = varchar(2) = Área de atuação 
                 si16_descareaatuacao = varchar(150) = Descrição da área 
                 si16_mes = int8 = Mês 
                 si16_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_consor102018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("consor102018");
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
      $this->si16_sequencial = ($this->si16_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_sequencial"] : $this->si16_sequencial);
      $this->si16_tiporegistro = ($this->si16_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_tiporegistro"] : $this->si16_tiporegistro);
      $this->si16_codorgao = ($this->si16_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_codorgao"] : $this->si16_codorgao);
      $this->si16_cnpjconsorcio = ($this->si16_cnpjconsorcio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_cnpjconsorcio"] : $this->si16_cnpjconsorcio);
      $this->si16_areaatuacao = ($this->si16_areaatuacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_areaatuacao"] : $this->si16_areaatuacao);
      $this->si16_descareaatuacao = ($this->si16_descareaatuacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_descareaatuacao"] : $this->si16_descareaatuacao);
      $this->si16_mes = ($this->si16_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_mes"] : $this->si16_mes);
      $this->si16_instit = ($this->si16_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_instit"] : $this->si16_instit);
    } else {
      $this->si16_sequencial = ($this->si16_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si16_sequencial"] : $this->si16_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si16_sequencial)
  {
    $this->atualizacampos();
    if ($this->si16_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si16_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si16_cnpjconsorcio == null) {
      $this->si16_cnpjconsorcio = "0";
    }
    if ($this->si16_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si16_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si16_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si16_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si16_sequencial == "" || $si16_sequencial == null) {
      $result = db_query("select nextval('consor102018_si16_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: consor102018_si16_sequencial_seq do campo: si16_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si16_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from consor102018_si16_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si16_sequencial)) {
        $this->erro_sql = " Campo si16_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si16_sequencial = $si16_sequencial;
      }
    }
    if (($this->si16_sequencial == null) || ($this->si16_sequencial == "")) {
      $this->erro_sql = " Campo si16_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into consor102018(
                                       si16_sequencial 
                                      ,si16_tiporegistro 
                                      ,si16_codorgao 
                                      ,si16_cnpjconsorcio 
                                      ,si16_areaatuacao 
                                      ,si16_descareaatuacao 
                                      ,si16_mes 
                                      ,si16_instit 
                       )
                values (
                                $this->si16_sequencial 
                               ,$this->si16_tiporegistro 
                               ,'$this->si16_codorgao' 
                               ,'$this->si16_cnpjconsorcio' 
                               ,'$this->si16_areaatuacao' 
                               ,'$this->si16_descareaatuacao' 
                               ,$this->si16_mes 
                               ,$this->si16_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "consor102018 ($this->si16_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "consor102018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "consor102018 ($this->si16_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si16_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si16_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009618,'$this->si16_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010244,2009618,'','" . AddSlashes(pg_result($resaco, 0, 'si16_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010244,2009619,'','" . AddSlashes(pg_result($resaco, 0, 'si16_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010244,2009620,'','" . AddSlashes(pg_result($resaco, 0, 'si16_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010244,2009621,'','" . AddSlashes(pg_result($resaco, 0, 'si16_cnpjconsorcio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010244,2009623,'','" . AddSlashes(pg_result($resaco, 0, 'si16_areaatuacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010244,2009624,'','" . AddSlashes(pg_result($resaco, 0, 'si16_descareaatuacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010244,2009736,'','" . AddSlashes(pg_result($resaco, 0, 'si16_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010244,2011534,'','" . AddSlashes(pg_result($resaco, 0, 'si16_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si16_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update consor102018 set ";
    $virgula = "";
    if (trim($this->si16_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_sequencial"])) {
      if (trim($this->si16_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si16_sequencial"])) {
        $this->si16_sequencial = "0";
      }
      $sql .= $virgula . " si16_sequencial = $this->si16_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si16_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_tiporegistro"])) {
      $sql .= $virgula . " si16_tiporegistro = $this->si16_tiporegistro ";
      $virgula = ",";
      if (trim($this->si16_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si16_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si16_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_codorgao"])) {
      $sql .= $virgula . " si16_codorgao = '$this->si16_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si16_cnpjconsorcio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_cnpjconsorcio"])) {
      $sql .= $virgula . " si16_cnpjconsorcio = '$this->si16_cnpjconsorcio' ";
      $virgula = ",";
    }
    if (trim($this->si16_areaatuacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_areaatuacao"])) {
      $sql .= $virgula . " si16_areaatuacao = '$this->si16_areaatuacao' ";
      $virgula = ",";
    }
    if (trim($this->si16_descareaatuacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_descareaatuacao"])) {
      $sql .= $virgula . " si16_descareaatuacao = '$this->si16_descareaatuacao' ";
      $virgula = ",";
    }
    if (trim($this->si16_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_mes"])) {
      $sql .= $virgula . " si16_mes = $this->si16_mes ";
      $virgula = ",";
      if (trim($this->si16_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si16_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si16_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si16_instit"])) {
      $sql .= $virgula . " si16_instit = $this->si16_instit ";
      $virgula = ",";
      if (trim($this->si16_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si16_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si16_sequencial != null) {
      $sql .= " si16_sequencial = $this->si16_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si16_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009618,'$this->si16_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_sequencial"]) || $this->si16_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2009618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_sequencial')) . "','$this->si16_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_tiporegistro"]) || $this->si16_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2009619,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_tiporegistro')) . "','$this->si16_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_codorgao"]) || $this->si16_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2009620,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_codorgao')) . "','$this->si16_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_cnpjconsorcio"]) || $this->si16_cnpjconsorcio != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2009621,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_cnpjconsorcio')) . "','$this->si16_cnpjconsorcio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_areaatuacao"]) || $this->si16_areaatuacao != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2009623,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_areaatuacao')) . "','$this->si16_areaatuacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_descareaatuacao"]) || $this->si16_descareaatuacao != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2009624,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_descareaatuacao')) . "','$this->si16_descareaatuacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_mes"]) || $this->si16_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2009736,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_mes')) . "','$this->si16_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si16_instit"]) || $this->si16_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010244,2011534,'" . AddSlashes(pg_result($resaco, $conresaco, 'si16_instit')) . "','$this->si16_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "consor102018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si16_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "consor102018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si16_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si16_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si16_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si16_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009618,'$si16_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010244,2009618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010244,2009619,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010244,2009620,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010244,2009621,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_cnpjconsorcio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010244,2009623,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_areaatuacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010244,2009624,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_descareaatuacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010244,2009736,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010244,2011534,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si16_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from consor102018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si16_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si16_sequencial = $si16_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "consor102018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si16_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "consor102018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si16_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si16_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:consor102018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si16_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from consor102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si16_sequencial != null) {
        $sql2 .= " where consor102018.si16_sequencial = $si16_sequencial ";
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
  function sql_query_file($si16_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from consor102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si16_sequencial != null) {
        $sql2 .= " where consor102018.si16_sequencial = $si16_sequencial ";
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
