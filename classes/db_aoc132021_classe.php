<?
//MODULO: sicom
//CLASSE DA ENTIDADE aoc132021
class cl_aoc132021
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
  var $si41_sequencial = 0;
  var $si41_tiporegistro = 0;
  var $si41_codreduzidodecreto = 0;
  var $si41_origemrecalteracao = null;
  var $si41_valorabertoorigem = 0;
  var $si41_mes = 0;
  var $si41_reg10 = 0;
  var $si41_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si41_sequencial = int8 = sequencial 
                 si41_tiporegistro = int8 = Tipo do registro 
                 si41_codreduzidodecreto = int8 = Código do decreto 
                 si41_origemrecalteracao = varchar(2) = Origem do recurso 
                 si41_valorabertoorigem = float8 = Valor aberto 
                 si41_mes = int8 = Mês 
                 si41_reg10 = int8 = reg10 
                 si41_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aoc132021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aoc132021");
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
      $this->si41_sequencial = ($this->si41_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_sequencial"] : $this->si41_sequencial);
      $this->si41_tiporegistro = ($this->si41_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_tiporegistro"] : $this->si41_tiporegistro);
      $this->si41_codreduzidodecreto = ($this->si41_codreduzidodecreto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_codreduzidodecreto"] : $this->si41_codreduzidodecreto);
      $this->si41_origemrecalteracao = ($this->si41_origemrecalteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_origemrecalteracao"] : $this->si41_origemrecalteracao);
      $this->si41_valorabertoorigem = ($this->si41_valorabertoorigem == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_valorabertoorigem"] : $this->si41_valorabertoorigem);
      $this->si41_mes = ($this->si41_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_mes"] : $this->si41_mes);
      $this->si41_reg10 = ($this->si41_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_reg10"] : $this->si41_reg10);
      $this->si41_instit = ($this->si41_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_instit"] : $this->si41_instit);
    } else {
      $this->si41_sequencial = ($this->si41_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si41_sequencial"] : $this->si41_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si41_sequencial)
  {
    $this->atualizacampos();
    if ($this->si41_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si41_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si41_codreduzidodecreto == null) {
      $this->si41_codreduzidodecreto = "0";
    }
    if ($this->si41_valorabertoorigem == null) {
      $this->si41_valorabertoorigem = "0";
    }
    if ($this->si41_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si41_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si41_reg10 == null) {
      $this->si41_reg10 = "0";
    }
    if ($this->si41_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si41_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si41_sequencial == "" || $si41_sequencial == null) {
      $result = db_query("select nextval('aoc132021_si41_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aoc132021_si41_sequencial_seq do campo: si41_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si41_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aoc132021_si41_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si41_sequencial)) {
        $this->erro_sql = " Campo si41_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si41_sequencial = $si41_sequencial;
      }
    }
    if (($this->si41_sequencial == null) || ($this->si41_sequencial == "")) {
      $this->erro_sql = " Campo si41_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aoc132021(
                                       si41_sequencial 
                                      ,si41_tiporegistro 
                                      ,si41_codreduzidodecreto 
                                      ,si41_origemrecalteracao 
                                      ,si41_valorabertoorigem 
                                      ,si41_mes 
                                      ,si41_reg10 
                                      ,si41_instit 
                       )
                values (
                                $this->si41_sequencial 
                               ,$this->si41_tiporegistro 
                               ,$this->si41_codreduzidodecreto 
                               ,'$this->si41_origemrecalteracao' 
                               ,$this->si41_valorabertoorigem 
                               ,$this->si41_mes 
                               ,$this->si41_reg10 
                               ,$this->si41_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aoc132021 ($this->si41_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aoc132021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aoc132021 ($this->si41_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si41_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si41_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009800,'$this->si41_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010270,2009800,'','" . AddSlashes(pg_result($resaco, 0, 'si41_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010270,2009801,'','" . AddSlashes(pg_result($resaco, 0, 'si41_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010270,2009802,'','" . AddSlashes(pg_result($resaco, 0, 'si41_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010270,2009803,'','" . AddSlashes(pg_result($resaco, 0, 'si41_origemrecalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010270,2009804,'','" . AddSlashes(pg_result($resaco, 0, 'si41_valorabertoorigem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010270,2009806,'','" . AddSlashes(pg_result($resaco, 0, 'si41_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010270,2009830,'','" . AddSlashes(pg_result($resaco, 0, 'si41_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010270,2011555,'','" . AddSlashes(pg_result($resaco, 0, 'si41_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si41_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aoc132021 set ";
    $virgula = "";
    if (trim($this->si41_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_sequencial"])) {
      if (trim($this->si41_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si41_sequencial"])) {
        $this->si41_sequencial = "0";
      }
      $sql .= $virgula . " si41_sequencial = $this->si41_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si41_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_tiporegistro"])) {
      $sql .= $virgula . " si41_tiporegistro = $this->si41_tiporegistro ";
      $virgula = ",";
      if (trim($this->si41_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si41_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si41_codreduzidodecreto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_codreduzidodecreto"])) {
      if (trim($this->si41_codreduzidodecreto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si41_codreduzidodecreto"])) {
        $this->si41_codreduzidodecreto = "0";
      }
      $sql .= $virgula . " si41_codreduzidodecreto = $this->si41_codreduzidodecreto ";
      $virgula = ",";
    }
    if (trim($this->si41_origemrecalteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_origemrecalteracao"])) {
      $sql .= $virgula . " si41_origemrecalteracao = '$this->si41_origemrecalteracao' ";
      $virgula = ",";
    }
    if (trim($this->si41_valorabertoorigem) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_valorabertoorigem"])) {
      if (trim($this->si41_valorabertoorigem) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si41_valorabertoorigem"])) {
        $this->si41_valorabertoorigem = "0";
      }
      $sql .= $virgula . " si41_valorabertoorigem = $this->si41_valorabertoorigem ";
      $virgula = ",";
    }
    if (trim($this->si41_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_mes"])) {
      $sql .= $virgula . " si41_mes = $this->si41_mes ";
      $virgula = ",";
      if (trim($this->si41_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si41_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si41_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_reg10"])) {
      if (trim($this->si41_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si41_reg10"])) {
        $this->si41_reg10 = "0";
      }
      $sql .= $virgula . " si41_reg10 = $this->si41_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si41_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si41_instit"])) {
      $sql .= $virgula . " si41_instit = $this->si41_instit ";
      $virgula = ",";
      if (trim($this->si41_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si41_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si41_sequencial != null) {
      $sql .= " si41_sequencial = $this->si41_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si41_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009800,'$this->si41_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_sequencial"]) || $this->si41_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2009800,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_sequencial')) . "','$this->si41_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_tiporegistro"]) || $this->si41_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2009801,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_tiporegistro')) . "','$this->si41_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_codreduzidodecreto"]) || $this->si41_codreduzidodecreto != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2009802,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_codreduzidodecreto')) . "','$this->si41_codreduzidodecreto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_origemrecalteracao"]) || $this->si41_origemrecalteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2009803,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_origemrecalteracao')) . "','$this->si41_origemrecalteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_valorabertoorigem"]) || $this->si41_valorabertoorigem != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2009804,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_valorabertoorigem')) . "','$this->si41_valorabertoorigem'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_mes"]) || $this->si41_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2009806,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_mes')) . "','$this->si41_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_reg10"]) || $this->si41_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2009830,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_reg10')) . "','$this->si41_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si41_instit"]) || $this->si41_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010270,2011555,'" . AddSlashes(pg_result($resaco, $conresaco, 'si41_instit')) . "','$this->si41_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc132021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si41_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc132021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si41_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si41_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si41_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si41_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009800,'$si41_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010270,2009800,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010270,2009801,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010270,2009802,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010270,2009803,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_origemrecalteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010270,2009804,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_valorabertoorigem')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010270,2009806,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010270,2009830,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010270,2011555,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si41_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aoc132021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si41_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si41_sequencial = $si41_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc132021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si41_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc132021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si41_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si41_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aoc132021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si41_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc132021 ";
    $sql .= "      left  join aoc102020  on  aoc102020.si38_sequencial = aoc132021.si41_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si41_sequencial != null) {
        $sql2 .= " where aoc132021.si41_sequencial = $si41_sequencial ";
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
  function sql_query_file($si41_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc132021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si41_sequencial != null) {
        $sql2 .= " where aoc132021.si41_sequencial = $si41_sequencial ";
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
