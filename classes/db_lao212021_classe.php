<?
//MODULO: sicom
//CLASSE DA ENTIDADE lao212021
class cl_lao212021
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
  var $si37_sequencial = 0;
  var $si37_tiporegistro = 0;
  var $si37_nroleialterorcam = null;
  var $si37_tipoautorizacao = 0;
  var $si37_artigoleialterorcamento = null;
  var $si37_descricaoartigo = null;
  var $si37_novopercentual = 0;
  var $si37_mes = 0;
  var $si37_reg20 = 0;
  var $si37_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si37_sequencial = int8 = sequencial 
                 si37_tiporegistro = int8 = Tipo do registro 
                 si37_nroleialterorcam = int8 = Número da Lei
                 si37_tipoautorizacao = int8 = Tipo de autorização 
                 si37_artigoleialterorcamento = varchar(6) = Artigo da Lei 
                 si37_descricaoartigo = varchar(512) = Descrição do artigo 
                 si37_novopercentual = float8 = Novo percentual 
                 si37_mes = int8 = Mês 
                 si37_reg20 = int8 = reg20 
                 si37_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_lao212021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("lao212021");
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
      $this->si37_sequencial = ($this->si37_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_sequencial"] : $this->si37_sequencial);
      $this->si37_tiporegistro = ($this->si37_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_tiporegistro"] : $this->si37_tiporegistro);
      $this->si37_nroleialterorcam = ($this->si37_nroleialterorcam == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_nroleialterorcam"] : $this->si37_nroleialterorcam);
      $this->si37_tipoautorizacao = ($this->si37_tipoautorizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_tipoautorizacao"] : $this->si37_tipoautorizacao);
      $this->si37_artigoleialterorcamento = ($this->si37_artigoleialterorcamento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_artigoleialterorcamento"] : $this->si37_artigoleialterorcamento);
      $this->si37_descricaoartigo = ($this->si37_descricaoartigo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_descricaoartigo"] : $this->si37_descricaoartigo);
      $this->si37_novopercentual = ($this->si37_novopercentual == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_novopercentual"] : $this->si37_novopercentual);
      $this->si37_mes = ($this->si37_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_mes"] : $this->si37_mes);
      $this->si37_reg20 = ($this->si37_reg20 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_reg20"] : $this->si37_reg20);
      $this->si37_instit = ($this->si37_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_instit"] : $this->si37_instit);
    } else {
      $this->si37_sequencial = ($this->si37_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si37_sequencial"] : $this->si37_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si37_sequencial)
  {
    $this->atualizacampos();
    if ($this->si37_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si37_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si37_tipoautorizacao == null) {
      $this->si37_tipoautorizacao = "0";
    }
    if ($this->si37_novopercentual == null) {
      $this->si37_novopercentual = "0";
    }
    if ($this->si37_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si37_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si37_reg20 == null) {
      $this->si37_reg20 = "0";
    }
    if ($this->si37_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si37_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si37_sequencial == "" || $si37_sequencial == null) {
      $result = db_query("select nextval('lao212021_si37_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: lao212021_si37_sequencial_seq do campo: si37_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si37_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from lao212021_si37_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si37_sequencial)) {
        $this->erro_sql = " Campo si37_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si37_sequencial = $si37_sequencial;
      }
    }
    if (($this->si37_sequencial == null) || ($this->si37_sequencial == "")) {
      $this->erro_sql = " Campo si37_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into lao212021(
                                       si37_sequencial 
                                      ,si37_tiporegistro 
                                      ,si37_nroleialterorcam 
                                      ,si37_tipoautorizacao 
                                      ,si37_artigoleialterorcamento 
                                      ,si37_descricaoartigo 
                                      ,si37_novopercentual 
                                      ,si37_mes 
                                      ,si37_reg20 
                                      ,si37_instit 
                       )
                values (
                                $this->si37_sequencial 
                               ,$this->si37_tiporegistro 
                               ,'$this->si37_nroleialterorcam' 
                               ,$this->si37_tipoautorizacao 
                               ,'$this->si37_artigoleialterorcamento' 
                               ,'$this->si37_descricaoartigo' 
                               ,$this->si37_novopercentual 
                               ,$this->si37_mes 
                               ,$this->si37_reg20 
                               ,$this->si37_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "lao212021 ($this->si37_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "lao212021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "lao212021 ($this->si37_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si37_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si37_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009770,'$this->si37_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010265,2009770,'','" . AddSlashes(pg_result($resaco, 0, 'si37_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009771,'','" . AddSlashes(pg_result($resaco, 0, 'si37_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009772,'','" . AddSlashes(pg_result($resaco, 0, 'si37_nroleialterorcam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009773,'','" . AddSlashes(pg_result($resaco, 0, 'si37_tipoautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009774,'','" . AddSlashes(pg_result($resaco, 0, 'si37_artigoleialterorcamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009775,'','" . AddSlashes(pg_result($resaco, 0, 'si37_descricaoartigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009776,'','" . AddSlashes(pg_result($resaco, 0, 'si37_novopercentual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009777,'','" . AddSlashes(pg_result($resaco, 0, 'si37_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2009778,'','" . AddSlashes(pg_result($resaco, 0, 'si37_reg20')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010265,2011551,'','" . AddSlashes(pg_result($resaco, 0, 'si37_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si37_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update lao212021 set ";
    $virgula = "";
    if (trim($this->si37_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_sequencial"])) {
      if (trim($this->si37_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si37_sequencial"])) {
        $this->si37_sequencial = "0";
      }
      $sql .= $virgula . " si37_sequencial = $this->si37_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si37_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_tiporegistro"])) {
      $sql .= $virgula . " si37_tiporegistro = $this->si37_tiporegistro ";
      $virgula = ",";
      if (trim($this->si37_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si37_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si37_nroleialterorcam) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_nroleialterorcam"])) {
      $sql .= $virgula . " si37_nroleialterorcam = '$this->si37_nroleialterorcam' ";
      $virgula = ",";
    }
    if (trim($this->si37_tipoautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_tipoautorizacao"])) {
      if (trim($this->si37_tipoautorizacao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si37_tipoautorizacao"])) {
        $this->si37_tipoautorizacao = "0";
      }
      $sql .= $virgula . " si37_tipoautorizacao = $this->si37_tipoautorizacao ";
      $virgula = ",";
    }
    if (trim($this->si37_artigoleialterorcamento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_artigoleialterorcamento"])) {
      $sql .= $virgula . " si37_artigoleialterorcamento = '$this->si37_artigoleialterorcamento' ";
      $virgula = ",";
    }
    if (trim($this->si37_descricaoartigo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_descricaoartigo"])) {
      $sql .= $virgula . " si37_descricaoartigo = '$this->si37_descricaoartigo' ";
      $virgula = ",";
    }
    if (trim($this->si37_novopercentual) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_novopercentual"])) {
      if (trim($this->si37_novopercentual) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si37_novopercentual"])) {
        $this->si37_novopercentual = "0";
      }
      $sql .= $virgula . " si37_novopercentual = $this->si37_novopercentual ";
      $virgula = ",";
    }
    if (trim($this->si37_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_mes"])) {
      $sql .= $virgula . " si37_mes = $this->si37_mes ";
      $virgula = ",";
      if (trim($this->si37_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si37_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si37_reg20) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_reg20"])) {
      if (trim($this->si37_reg20) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si37_reg20"])) {
        $this->si37_reg20 = "0";
      }
      $sql .= $virgula . " si37_reg20 = $this->si37_reg20 ";
      $virgula = ",";
    }
    if (trim($this->si37_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si37_instit"])) {
      $sql .= $virgula . " si37_instit = $this->si37_instit ";
      $virgula = ",";
      if (trim($this->si37_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si37_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si37_sequencial != null) {
      $sql .= " si37_sequencial = $this->si37_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si37_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009770,'$this->si37_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_sequencial"]) || $this->si37_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009770,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_sequencial')) . "','$this->si37_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_tiporegistro"]) || $this->si37_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009771,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_tiporegistro')) . "','$this->si37_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_nroleialterorcam"]) || $this->si37_nroleialterorcam != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009772,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_nroleialterorcam')) . "','$this->si37_nroleialterorcam'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_tipoautorizacao"]) || $this->si37_tipoautorizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009773,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_tipoautorizacao')) . "','$this->si37_tipoautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_artigoleialterorcamento"]) || $this->si37_artigoleialterorcamento != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009774,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_artigoleialterorcamento')) . "','$this->si37_artigoleialterorcamento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_descricaoartigo"]) || $this->si37_descricaoartigo != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009775,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_descricaoartigo')) . "','$this->si37_descricaoartigo'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_novopercentual"]) || $this->si37_novopercentual != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009776,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_novopercentual')) . "','$this->si37_novopercentual'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_mes"]) || $this->si37_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009777,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_mes')) . "','$this->si37_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_reg20"]) || $this->si37_reg20 != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2009778,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_reg20')) . "','$this->si37_reg20'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si37_instit"]) || $this->si37_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010265,2011551,'" . AddSlashes(pg_result($resaco, $conresaco, 'si37_instit')) . "','$this->si37_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "lao212021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si37_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lao212021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si37_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si37_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si37_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si37_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009770,'$si37_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010265,2009770,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009771,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009772,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_nroleialterorcam')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009773,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_tipoautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009774,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_artigoleialterorcamento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009775,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_descricaoartigo')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009776,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_novopercentual')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009777,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2009778,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_reg20')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010265,2011551,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si37_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from lao212021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si37_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si37_sequencial = $si37_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "lao212021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si37_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lao212021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si37_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si37_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:lao212021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si37_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lao212021 ";
    $sql .= "      left  join lao202020  on  lao202020.si36_sequencial = lao212021.si37_reg20";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si37_sequencial != null) {
        $sql2 .= " where lao212021.si37_sequencial = $si37_sequencial ";
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
  function sql_query_file($si37_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lao212021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si37_sequencial != null) {
        $sql2 .= " where lao212021.si37_sequencial = $si37_sequencial ";
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
