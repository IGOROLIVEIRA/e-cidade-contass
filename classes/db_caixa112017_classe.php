<?
//MODULO: sicom
//CLASSE DA ENTIDADE caixa112017
class cl_caixa112017
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
  var $si166_sequencial = 0;
  var $si166_tiporegistro = 0;
  var $si166_codfontecaixa = null;
  var $si166_vlsaldoinicialfonte = 0;
  var $si166_vlsaldofinalfonte = 0;
  var $si166_mes = 0;
  var $si166_reg10 = 0;
  var $si166_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si166_sequencial = int8 = sequencial 
                 si166_tiporegistro = int8 = Tipo do  registro 
                 si166_codfontecaixa = varchar(2) = Código do órgão 
                 si166_vlsaldoinicialfonte = float8 = Valor do saldo no  início do mês 
                 si166_vlsaldofinalfonte = float8 = Valor do Saldo do  Final do Mês 
                 si166_mes = int8 = Mês 
                 si166_reg10 = int8 = reg10 
                 si166_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_caixa112017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("caixa112017");
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
      $this->si166_sequencial = ($this->si166_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_sequencial"] : $this->si166_sequencial);
      $this->si166_tiporegistro = ($this->si166_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_tiporegistro"] : $this->si166_tiporegistro);
      $this->si166_codfontecaixa = ($this->si166_codfontecaixa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_codfontecaixa"] : $this->si166_codfontecaixa);
      $this->si166_vlsaldoinicialfonte = ($this->si166_vlsaldoinicialfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_vlsaldoinicialfonte"] : $this->si166_vlsaldoinicialfonte);
      $this->si166_vlsaldofinalfonte = ($this->si166_vlsaldofinalfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_vlsaldofinalfonte"] : $this->si166_vlsaldofinalfonte);
      $this->si166_mes = ($this->si166_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_mes"] : $this->si166_mes);
      $this->si166_instit = ($this->si166_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_instit"] : $this->si166_instit);
    } else {
      $this->si166_sequencial = ($this->si166_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si166_sequencial"] : $this->si166_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si166_sequencial)
  {
    $this->atualizacampos();
    if ($this->si166_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si166_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si166_vlsaldoinicialfonte == null) {
      $this->si166_vlsaldoinicialfonte = "0";
    }
    if ($this->si166_vlsaldofinalfonte == null) {
      $this->si166_vlsaldofinalfonte = "0";
    }
    if ($this->si166_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si166_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si166_reg10 == null) {
      $this->si166_reg10 = "0";
    }
    if ($this->si166_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si166_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si166_sequencial == "" || $si166_sequencial == null) {
      $result = db_query("select nextval('caixa112017_si166_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: caixa112017_si166_sequencial_seq do campo: si166_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si166_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from caixa112017_si166_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si166_sequencial)) {
        $this->erro_sql = " Campo si166_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si166_sequencial = $si166_sequencial;
      }
    }
    if (($this->si166_sequencial == null) || ($this->si166_sequencial == "")) {
      $this->erro_sql = " Campo si166_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into caixa112017(
                                       si166_sequencial 
                                      ,si166_tiporegistro 
                                      ,si166_codfontecaixa 
                                      ,si166_vlsaldoinicialfonte 
                                      ,si166_vlsaldofinalfonte 
                                      ,si166_mes 
                                      ,si166_reg10
                                      ,si166_instit 
                       )
                values (
                                $this->si166_sequencial 
                               ,$this->si166_tiporegistro 
                               ,'$this->si166_codfontecaixa' 
                               ,$this->si166_vlsaldoinicialfonte 
                               ,$this->si166_vlsaldofinalfonte 
                               ,$this->si166_mes 
                               ,$this->si166_reg10 
                               ,$this->si166_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "caixa112017 ($this->si166_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "caixa112017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "caixa112017 ($this->si166_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si166_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si166_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010621,'$this->si166_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010332,2010621,'','" . AddSlashes(pg_result($resaco, 0, 'si166_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010616,'','" . AddSlashes(pg_result($resaco, 0, 'si166_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010617,'','" . AddSlashes(pg_result($resaco, 0, 'si166_codfontecaixa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010618,'','" . AddSlashes(pg_result($resaco, 0, 'si166_vlsaldoinicialfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010619,'','" . AddSlashes(pg_result($resaco, 0, 'si166_vlsaldofinalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2010620,'','" . AddSlashes(pg_result($resaco, 0, 'si166_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010332,2011616,'','" . AddSlashes(pg_result($resaco, 0, 'si166_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si166_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update caixa112017 set ";
    $virgula = "";
    if (trim($this->si166_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si166_sequencial"])) {
      if (trim($this->si166_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si166_sequencial"])) {
        $this->si166_sequencial = "0";
      }
      $sql .= $virgula . " si166_sequencial = $this->si166_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si166_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si166_tiporegistro"])) {
      $sql .= $virgula . " si166_tiporegistro = $this->si166_tiporegistro ";
      $virgula = ",";
      if (trim($this->si166_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si166_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si166_codfontecaixa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si166_codfontecaixa"])) {
      $sql .= $virgula . " si166_codfontecaixa = '$this->si166_codfontecaixa' ";
      $virgula = ",";
    }
    if (trim($this->si166_vlsaldoinicialfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si166_vlsaldoinicialfonte"])) {
      if (trim($this->si166_vlsaldoinicialfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si166_vlsaldoinicialfonte"])) {
        $this->si166_vlsaldoinicialfonte = "0";
      }
      $sql .= $virgula . " si166_vlsaldoinicialfonte = $this->si166_vlsaldoinicialfonte ";
      $virgula = ",";
    }
    if (trim($this->si166_vlsaldofinalfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si166_vlsaldofinalfonte"])) {
      if (trim($this->si166_vlsaldofinalfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si166_vlsaldofinalfonte"])) {
        $this->si166_vlsaldofinalfonte = "0";
      }
      $sql .= $virgula . " si166_vlsaldofinalfonte = $this->si166_vlsaldofinalfonte ";
      $virgula = ",";
    }
    if (trim($this->si166_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si166_mes"])) {
      $sql .= $virgula . " si166_mes = $this->si166_mes ";
      $virgula = ",";
      if (trim($this->si166_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si166_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si166_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si166_instit"])) {
      $sql .= $virgula . " si166_instit = $this->si166_instit ";
      $virgula = ",";
      if (trim($this->si166_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si166_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si166_sequencial != null) {
      $sql .= " si166_sequencial = $this->si166_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si166_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010621,'$this->si166_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si166_sequencial"]) || $this->si166_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010621,'" . AddSlashes(pg_result($resaco, $conresaco, 'si166_sequencial')) . "','$this->si166_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si166_tiporegistro"]) || $this->si166_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010616,'" . AddSlashes(pg_result($resaco, $conresaco, 'si166_tiporegistro')) . "','$this->si166_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si166_codfontecaixa"]) || $this->si166_codfontecaixa != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010617,'" . AddSlashes(pg_result($resaco, $conresaco, 'si166_codfontecaixa')) . "','$this->si166_codfontecaixa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si166_vlsaldoinicialfonte"]) || $this->si166_vlsaldoinicialfonte != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010618,'" . AddSlashes(pg_result($resaco, $conresaco, 'si166_vlsaldoinicialfonte')) . "','$this->si166_vlsaldoinicialfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si166_vlsaldofinalfonte"]) || $this->si166_vlsaldofinalfonte != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010619,'" . AddSlashes(pg_result($resaco, $conresaco, 'si166_vlsaldofinalfonte')) . "','$this->si166_vlsaldofinalfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si166_mes"]) || $this->si166_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2010620,'" . AddSlashes(pg_result($resaco, $conresaco, 'si166_mes')) . "','$this->si166_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si166_instit"]) || $this->si166_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010332,2011616,'" . AddSlashes(pg_result($resaco, $conresaco, 'si166_instit')) . "','$this->si166_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "caixa112017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si166_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa112017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si166_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si166_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si166_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si166_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010621,'$si166_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010332,2010621,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si166_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010616,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si166_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010617,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si166_codfontecaixa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010618,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si166_vlsaldoinicialfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010619,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si166_vlsaldofinalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2010620,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si166_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010332,2011616,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si166_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from caixa112017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si166_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si166_sequencial = $si166_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "caixa112017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si166_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "caixa112017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si166_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si166_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:caixa112017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si166_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa112017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si166_sequencial != null) {
        $sql2 .= " where caixa112017.si166_sequencial = $si166_sequencial ";
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
  function sql_query_file($si166_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from caixa112017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si166_sequencial != null) {
        $sql2 .= " where caixa112017.si166_sequencial = $si166_sequencial ";
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
