<?
//MODULO: sicom
//CLASSE DA ENTIDADE aoc122019
class cl_aoc122019
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
  var $si40_sequencial = 0;
  var $si40_tiporegistro = 0;
  var $si40_codreduzidodecreto = 0;
  var $si40_nroleialteracao = null;
  var $si40_dataleialteracao_dia = null;
  var $si40_dataleialteracao_mes = null;
  var $si40_dataleialteracao_ano = null;
  var $si40_dataleialteracao = null;
  var $si40_tpleiorigdecreto = null;
  var $si40_tipoleialteracao = null;
  var $si40_valorabertolei = null;
  var $si40_mes = 0;
  var $si40_reg10 = 0;
  var $si40_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si40_sequencial = int8 = sequencial 
                 si40_tiporegistro = int8 = Tipo do registro 
                 si40_codreduzidodecreto = int8 = Código do decreto 
                 si40_nroleialteracao = varchar(6) = Número da Lei 
                 si40_dataleialteracao = date = Data da lei
                 si40_tpleiorigdecreto = varchar(6) = Tipo Lei Origem Decreto
                 si40_tipoleialteracao = int8 = Tipo Lei Alteração
                 si40_valorabertolei = float8 = Valor Aberto
                 si40_mes = int8 = Mês 
                 si40_reg10 = int8 = reg10 
                 si40_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_aoc122019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("aoc122019");
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
      $this->si40_sequencial = ($this->si40_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_sequencial"] : $this->si40_sequencial);
      $this->si40_tiporegistro = ($this->si40_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_tiporegistro"] : $this->si40_tiporegistro);
      $this->si40_codreduzidodecreto = ($this->si40_codreduzidodecreto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_codreduzidodecreto"] : $this->si40_codreduzidodecreto);
      $this->si40_nroleialteracao = ($this->si40_nroleialteracao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_nroleialteracao"] : $this->si40_nroleialteracao);
      if ($this->si40_dataleialteracao == "") {
        $this->si40_dataleialteracao_dia = ($this->si40_dataleialteracao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_dataleialteracao_dia"] : $this->si40_dataleialteracao_dia);
        $this->si40_dataleialteracao_mes = ($this->si40_dataleialteracao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_dataleialteracao_mes"] : $this->si40_dataleialteracao_mes);
        $this->si40_dataleialteracao_ano = ($this->si40_dataleialteracao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_dataleialteracao_ano"] : $this->si40_dataleialteracao_ano);
        if ($this->si40_dataleialteracao_dia != "") {
          $this->si40_dataleialteracao = $this->si40_dataleialteracao_ano . "-" . $this->si40_dataleialteracao_mes . "-" . $this->si40_dataleialteracao_dia;
        }
      }
      $this->si40_tpleiorigdecreto = ($this->si40_tpleiorigdecreto == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_tpleiorigdecreto"] : $this->si40_tpleiorigdecreto);
      $this->si40_tipoleialteracao = ($this->si40_tipoleialteracao === "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_tipoleialteracao"] : $this->si40_tipoleialteracao);
      $this->si40_mes = ($this->si40_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_mes"] : $this->si40_mes);
      $this->si40_reg10 = ($this->si40_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_reg10"] : $this->si40_reg10);
      $this->si40_instit = ($this->si40_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_instit"] : $this->si40_instit);
    } else {
      $this->si40_sequencial = ($this->si40_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si40_sequencial"] : $this->si40_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si40_sequencial)
  {
    $this->atualizacampos();
    if ($this->si40_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si40_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si40_codreduzidodecreto == null) {
      $this->si40_codreduzidodecreto = "0";
    }
    if ($this->si40_dataleialteracao == null) {
      $this->si40_dataleialteracao = "null";
    }
    if ($this->si40_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si40_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si40_reg10 == null) {
      $this->si40_reg10 = "0";
    }
    if ($this->si40_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si40_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si40_sequencial == "" || $si40_sequencial == null) {
      $result = db_query("select nextval('aoc122019_si40_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: aoc122019_si40_sequencial_seq do campo: si40_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si40_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from aoc122019_si40_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si40_sequencial)) {
        $this->erro_sql = " Campo si40_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si40_sequencial = $si40_sequencial;
      }
    }
    if (($this->si40_sequencial == null) || ($this->si40_sequencial == "")) {
      $this->erro_sql = " Campo si40_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into aoc122019(
                                       si40_sequencial 
                                      ,si40_tiporegistro 
                                      ,si40_codreduzidodecreto 
                                      ,si40_nroleialteracao 
                                      ,si40_dataleialteracao 
                                      ,si40_tpleiorigdecreto
                                      ,si40_tipoleialteracao
                                      ,si40_mes 
                                      ,si40_reg10 
                                      ,si40_instit 
                                      ,si40_valorabertolei
                       )
                values (
                                $this->si40_sequencial 
                               ,$this->si40_tiporegistro 
                               ,$this->si40_codreduzidodecreto 
                               ,'$this->si40_nroleialteracao' 
                               ," . ($this->si40_dataleialteracao == "null" || $this->si40_dataleialteracao == "" ? "null" : "'" . $this->si40_dataleialteracao . "'") . "
                               ,'$this->si40_tpleiorigdecreto'
                               ,$this->si40_tipoleialteracao
                               ,$this->si40_mes 
                               ,$this->si40_reg10 
                               ,$this->si40_instit 
                               ,$this->si40_valorabertolei
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "aoc122019 ($this->si40_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "aoc122019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "aoc122019 ($this->si40_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si40_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si40_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009793,'$this->si40_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010269,2009793,'','" . AddSlashes(pg_result($resaco, 0, 'si40_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010269,2009795,'','" . AddSlashes(pg_result($resaco, 0, 'si40_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010269,2009796,'','" . AddSlashes(pg_result($resaco, 0, 'si40_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010269,2009797,'','" . AddSlashes(pg_result($resaco, 0, 'si40_nroleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010269,2009798,'','" . AddSlashes(pg_result($resaco, 0, 'si40_dataleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010269,2009799,'','" . AddSlashes(pg_result($resaco, 0, 'si40_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010269,2009829,'','" . AddSlashes(pg_result($resaco, 0, 'si40_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010269,2011554,'','" . AddSlashes(pg_result($resaco, 0, 'si40_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si40_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update aoc122019 set ";
    $virgula = "";
    if (trim($this->si40_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_sequencial"])) {
      if (trim($this->si40_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si40_sequencial"])) {
        $this->si40_sequencial = "0";
      }
      $sql .= $virgula . " si40_sequencial = $this->si40_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si40_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_tiporegistro"])) {
      $sql .= $virgula . " si40_tiporegistro = $this->si40_tiporegistro ";
      $virgula = ",";
      if (trim($this->si40_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si40_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si40_codreduzidodecreto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_codreduzidodecreto"])) {
      if (trim($this->si40_codreduzidodecreto) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si40_codreduzidodecreto"])) {
        $this->si40_codreduzidodecreto = "0";
      }
      $sql .= $virgula . " si40_codreduzidodecreto = $this->si40_codreduzidodecreto ";
      $virgula = ",";
    }
    if (trim($this->si40_nroleialteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_nroleialteracao"])) {
      $sql .= $virgula . " si40_nroleialteracao = '$this->si40_nroleialteracao' ";
      $virgula = ",";
    }
    if (trim($this->si40_dataleialteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_dataleialteracao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si40_dataleialteracao_dia"] != "")) {
      $sql .= $virgula . " si40_dataleialteracao = '$this->si40_dataleialteracao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si40_dataleialteracao_dia"])) {
        $sql .= $virgula . " si40_dataleialteracao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si40_tpleiorigdecreto) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_tpleiorigdecreto"])) {
      $sql .= $virgula . " si40_tpleiorigdecreto = '$this->si40_tpleiorigdecreto' ";
      $virgula = ",";
    }
    if (trim($this->si40_tipoleialteracao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_tipoleialteracao"])) {
      if (trim($this->si40_tipoleialteracao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si40_tipoleialteracao"])) {
        $this->si40_tipoleialteracao = "0";
      }
      $sql .= $virgula . " si40_tipoleialteracao = $this->si40_tipoleialteracao ";
      $virgula = ",";
    }
    if (trim($this->si40_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_mes"])) {
      $sql .= $virgula . " si40_mes = $this->si40_mes ";
      $virgula = ",";
      if (trim($this->si40_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si40_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si40_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_reg10"])) {
      if (trim($this->si40_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si40_reg10"])) {
        $this->si40_reg10 = "0";
      }
      $sql .= $virgula . " si40_reg10 = $this->si40_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si40_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_instit"])) {
      $sql .= $virgula . " si40_instit = $this->si40_instit ";
      $virgula = ",";
      if (trim($this->si40_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si40_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si40_valorabertolei) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si40_valorabertolei"])) {
      $sql .= $virgula . " si40_valorabertolei = '$this->si40_valorabertolei' ";
      $virgula = ",";
    }
    $sql .= " where ";
    if ($si40_sequencial != null) {
      $sql .= " si40_sequencial = $this->si40_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si40_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009793,'$this->si40_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_sequencial"]) || $this->si40_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2009793,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_sequencial')) . "','$this->si40_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_tiporegistro"]) || $this->si40_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2009795,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_tiporegistro')) . "','$this->si40_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_codreduzidodecreto"]) || $this->si40_codreduzidodecreto != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2009796,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_codreduzidodecreto')) . "','$this->si40_codreduzidodecreto'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_nroleialteracao"]) || $this->si40_nroleialteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2009797,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_nroleialteracao')) . "','$this->si40_nroleialteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_dataleialteracao"]) || $this->si40_dataleialteracao != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2009798,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_dataleialteracao')) . "','$this->si40_dataleialteracao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_mes"]) || $this->si40_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2009799,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_mes')) . "','$this->si40_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_reg10"]) || $this->si40_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2009829,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_reg10')) . "','$this->si40_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si40_instit"]) || $this->si40_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010269,2011554,'" . AddSlashes(pg_result($resaco, $conresaco, 'si40_instit')) . "','$this->si40_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc122019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si40_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc122019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si40_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si40_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si40_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si40_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009793,'$si40_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010269,2009793,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010269,2009795,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010269,2009796,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_codreduzidodecreto')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010269,2009797,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_nroleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010269,2009798,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_dataleialteracao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010269,2009799,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010269,2009829,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010269,2011554,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si40_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from aoc122019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si40_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si40_sequencial = $si40_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "aoc122019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si40_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "aoc122019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si40_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si40_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:aoc122019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si40_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc122019 ";
    $sql .= "      left  join aoc102019  on  aoc102019.si38_sequencial = aoc122019.si40_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si40_sequencial != null) {
        $sql2 .= " where aoc122019.si40_sequencial = $si40_sequencial ";
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
  function sql_query_file($si40_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from aoc122019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si40_sequencial != null) {
        $sql2 .= " where aoc122019.si40_sequencial = $si40_sequencial ";
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
