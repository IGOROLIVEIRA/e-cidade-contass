<?
//MODULO: sicom
//CLASSE DA ENTIDADE lao202017
class cl_lao202017
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
  var $si36_sequencial = 0;
  var $si36_tiporegistro = 0;
  var $si36_codorgao = null;
  var $si36_nroleialterorcam = null;
  var $si36_dataleialterorcam_dia = null;
  var $si36_dataleialterorcam_mes = null;
  var $si36_dataleialterorcam_ano = null;
  var $si36_dataleialterorcam = null;
  var $si36_mes = 0;
  var $si36_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si36_sequencial = int8 = sequencial 
                 si36_tiporegistro = int8 = Tipo do registro 
                 si36_codorgao = varchar(2) = Código do órgão 
                 si36_nroleialterorcam = varchar(6) = Número da Lei 
                 si36_dataleialterorcam = date = Data da Lei 
                 si36_mes = int8 = Mês 
                 si36_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_lao202017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("lao202017");
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
      $this->si36_sequencial = ($this->si36_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_sequencial"] : $this->si36_sequencial);
      $this->si36_tiporegistro = ($this->si36_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_tiporegistro"] : $this->si36_tiporegistro);
      $this->si36_codorgao = ($this->si36_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_codorgao"] : $this->si36_codorgao);
      $this->si36_nroleialterorcam = ($this->si36_nroleialterorcam == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_nroleialterorcam"] : $this->si36_nroleialterorcam);
      if ($this->si36_dataleialterorcam == "") {
        $this->si36_dataleialterorcam_dia = ($this->si36_dataleialterorcam_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_dataleialterorcam_dia"] : $this->si36_dataleialterorcam_dia);
        $this->si36_dataleialterorcam_mes = ($this->si36_dataleialterorcam_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_dataleialterorcam_mes"] : $this->si36_dataleialterorcam_mes);
        $this->si36_dataleialterorcam_ano = ($this->si36_dataleialterorcam_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_dataleialterorcam_ano"] : $this->si36_dataleialterorcam_ano);
        if ($this->si36_dataleialterorcam_dia != "") {
          $this->si36_dataleialterorcam = $this->si36_dataleialterorcam_ano . "-" . $this->si36_dataleialterorcam_mes . "-" . $this->si36_dataleialterorcam_dia;
        }
      }
      $this->si36_mes = ($this->si36_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_mes"] : $this->si36_mes);
      $this->si36_instit = ($this->si36_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_instit"] : $this->si36_instit);
    } else {
      $this->si36_sequencial = ($this->si36_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si36_sequencial"] : $this->si36_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si36_sequencial)
  {
    $this->atualizacampos();
    if ($this->si36_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si36_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si36_dataleialterorcam == null) {
      $this->si36_dataleialterorcam = "null";
    }
    if ($this->si36_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si36_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si36_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si36_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si36_sequencial == "" || $si36_sequencial == null) {
      $result = db_query("select nextval('lao202017_si36_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: lao202017_si36_sequencial_seq do campo: si36_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si36_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from lao202017_si36_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si36_sequencial)) {
        $this->erro_sql = " Campo si36_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si36_sequencial = $si36_sequencial;
      }
    }
    if (($this->si36_sequencial == null) || ($this->si36_sequencial == "")) {
      $this->erro_sql = " Campo si36_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into lao202017(
                                       si36_sequencial 
                                      ,si36_tiporegistro 
                                      ,si36_codorgao 
                                      ,si36_nroleialterorcam 
                                      ,si36_dataleialterorcam 
                                      ,si36_mes 
                                      ,si36_instit 
                       )
                values (
                                $this->si36_sequencial 
                               ,$this->si36_tiporegistro 
                               ,'$this->si36_codorgao' 
                               ,'$this->si36_nroleialterorcam' 
                               ," . ($this->si36_dataleialterorcam == "null" || $this->si36_dataleialterorcam == "" ? "null" : "'" . $this->si36_dataleialterorcam . "'") . "
                               ,$this->si36_mes 
                               ,$this->si36_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "lao202017 ($this->si36_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "lao202017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "lao202017 ($this->si36_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si36_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si36_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009764,'$this->si36_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010264,2009764,'','" . AddSlashes(pg_result($resaco, 0, 'si36_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010264,2009765,'','" . AddSlashes(pg_result($resaco, 0, 'si36_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010264,2009766,'','" . AddSlashes(pg_result($resaco, 0, 'si36_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010264,2009767,'','" . AddSlashes(pg_result($resaco, 0, 'si36_nroleialterorcam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010264,2009768,'','" . AddSlashes(pg_result($resaco, 0, 'si36_dataleialterorcam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010264,2009769,'','" . AddSlashes(pg_result($resaco, 0, 'si36_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010264,2011550,'','" . AddSlashes(pg_result($resaco, 0, 'si36_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si36_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update lao202017 set ";
    $virgula = "";
    if (trim($this->si36_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si36_sequencial"])) {
      if (trim($this->si36_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si36_sequencial"])) {
        $this->si36_sequencial = "0";
      }
      $sql .= $virgula . " si36_sequencial = $this->si36_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si36_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si36_tiporegistro"])) {
      $sql .= $virgula . " si36_tiporegistro = $this->si36_tiporegistro ";
      $virgula = ",";
      if (trim($this->si36_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si36_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si36_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si36_codorgao"])) {
      $sql .= $virgula . " si36_codorgao = '$this->si36_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si36_nroleialterorcam) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si36_nroleialterorcam"])) {
      $sql .= $virgula . " si36_nroleialterorcam = '$this->si36_nroleialterorcam' ";
      $virgula = ",";
    }
    if (trim($this->si36_dataleialterorcam) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si36_dataleialterorcam_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si36_dataleialterorcam_dia"] != "")) {
      $sql .= $virgula . " si36_dataleialterorcam = '$this->si36_dataleialterorcam' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si36_dataleialterorcam_dia"])) {
        $sql .= $virgula . " si36_dataleialterorcam = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si36_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si36_mes"])) {
      $sql .= $virgula . " si36_mes = $this->si36_mes ";
      $virgula = ",";
      if (trim($this->si36_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si36_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si36_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si36_instit"])) {
      $sql .= $virgula . " si36_instit = $this->si36_instit ";
      $virgula = ",";
      if (trim($this->si36_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si36_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si36_sequencial != null) {
      $sql .= " si36_sequencial = $this->si36_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si36_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009764,'$this->si36_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si36_sequencial"]) || $this->si36_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010264,2009764,'" . AddSlashes(pg_result($resaco, $conresaco, 'si36_sequencial')) . "','$this->si36_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si36_tiporegistro"]) || $this->si36_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010264,2009765,'" . AddSlashes(pg_result($resaco, $conresaco, 'si36_tiporegistro')) . "','$this->si36_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si36_codorgao"]) || $this->si36_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010264,2009766,'" . AddSlashes(pg_result($resaco, $conresaco, 'si36_codorgao')) . "','$this->si36_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si36_nroleialterorcam"]) || $this->si36_nroleialterorcam != "")
          $resac = db_query("insert into db_acount values($acount,2010264,2009767,'" . AddSlashes(pg_result($resaco, $conresaco, 'si36_nroleialterorcam')) . "','$this->si36_nroleialterorcam'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si36_dataleialterorcam"]) || $this->si36_dataleialterorcam != "")
          $resac = db_query("insert into db_acount values($acount,2010264,2009768,'" . AddSlashes(pg_result($resaco, $conresaco, 'si36_dataleialterorcam')) . "','$this->si36_dataleialterorcam'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si36_mes"]) || $this->si36_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010264,2009769,'" . AddSlashes(pg_result($resaco, $conresaco, 'si36_mes')) . "','$this->si36_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si36_instit"]) || $this->si36_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010264,2011550,'" . AddSlashes(pg_result($resaco, $conresaco, 'si36_instit')) . "','$this->si36_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "lao202017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si36_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lao202017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si36_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si36_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si36_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si36_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009764,'$si36_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010264,2009764,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si36_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010264,2009765,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si36_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010264,2009766,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si36_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010264,2009767,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si36_nroleialterorcam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010264,2009768,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si36_dataleialterorcam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010264,2009769,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si36_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010264,2011550,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si36_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from lao202017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si36_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si36_sequencial = $si36_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "lao202017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si36_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lao202017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si36_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si36_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:lao202017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si36_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lao202017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si36_sequencial != null) {
        $sql2 .= " where lao202017.si36_sequencial = $si36_sequencial ";
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
  function sql_query_file($si36_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lao202017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si36_sequencial != null) {
        $sql2 .= " where lao202017.si36_sequencial = $si36_sequencial ";
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
