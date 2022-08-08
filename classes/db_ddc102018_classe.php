<?
//MODULO: sicom
//CLASSE DA ENTIDADE ddc102018
class cl_ddc102018
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
  var $si150_sequencial = 0;
  var $si150_tiporegistro = 0;
  var $si150_codorgao = null;
  var $si150_nroleiautorizacao = null;
  var $si150_dtleiautorizacao_dia = null;
  var $si150_dtleiautorizacao_mes = null;
  var $si150_dtleiautorizacao_ano = null;
  var $si150_dtleiautorizacao = null;
  var $si150_dtpublicacaoleiautorizacao_dia = null;
  var $si150_dtpublicacaoleiautorizacao_mes = null;
  var $si150_dtpublicacaoleiautorizacao_ano = null;
  var $si150_dtpublicacaoleiautorizacao = null;
  var $si150_mes = 0;
  var $si150_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si150_sequencial = int8 = sequencial 
                 si150_tiporegistro = int8 = Tipo do  registro 
                 si150_codorgao = varchar(2) = Código do órgão 
                 si150_nroleiautorizacao = varchar(6) = Número da Lei de Autorização 
                 si150_dtleiautorizacao = date = Data da Lei de  Autorização 
                 si150_dtpublicacaoleiautorizacao = date = Data de  Publicação da Lei 
                 si150_mes = int8 = Mês 
                 si150_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_ddc102018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ddc102018");
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
      $this->si150_sequencial = ($this->si150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_sequencial"] : $this->si150_sequencial);
      $this->si150_tiporegistro = ($this->si150_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_tiporegistro"] : $this->si150_tiporegistro);
      $this->si150_codorgao = ($this->si150_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_codorgao"] : $this->si150_codorgao);
      $this->si150_nroleiautorizacao = ($this->si150_nroleiautorizacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_nroleiautorizacao"] : $this->si150_nroleiautorizacao);
      if ($this->si150_dtleiautorizacao == "") {
        $this->si150_dtleiautorizacao_dia = ($this->si150_dtleiautorizacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_dtleiautorizacao_dia"] : $this->si150_dtleiautorizacao_dia);
        $this->si150_dtleiautorizacao_mes = ($this->si150_dtleiautorizacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_dtleiautorizacao_mes"] : $this->si150_dtleiautorizacao_mes);
        $this->si150_dtleiautorizacao_ano = ($this->si150_dtleiautorizacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_dtleiautorizacao_ano"] : $this->si150_dtleiautorizacao_ano);
        if ($this->si150_dtleiautorizacao_dia != "") {
          $this->si150_dtleiautorizacao = $this->si150_dtleiautorizacao_ano . "-" . $this->si150_dtleiautorizacao_mes . "-" . $this->si150_dtleiautorizacao_dia;
        }
      }
      if ($this->si150_dtpublicacaoleiautorizacao == "") {
        $this->si150_dtpublicacaoleiautorizacao_dia = ($this->si150_dtpublicacaoleiautorizacao_dia == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_dtpublicacaoleiautorizacao_dia"] : $this->si150_dtpublicacaoleiautorizacao_dia);
        $this->si150_dtpublicacaoleiautorizacao_mes = ($this->si150_dtpublicacaoleiautorizacao_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_dtpublicacaoleiautorizacao_mes"] : $this->si150_dtpublicacaoleiautorizacao_mes);
        $this->si150_dtpublicacaoleiautorizacao_ano = ($this->si150_dtpublicacaoleiautorizacao_ano == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_dtpublicacaoleiautorizacao_ano"] : $this->si150_dtpublicacaoleiautorizacao_ano);
        if ($this->si150_dtpublicacaoleiautorizacao_dia != "") {
          $this->si150_dtpublicacaoleiautorizacao = $this->si150_dtpublicacaoleiautorizacao_ano . "-" . $this->si150_dtpublicacaoleiautorizacao_mes . "-" . $this->si150_dtpublicacaoleiautorizacao_dia;
        }
      }
      $this->si150_mes = ($this->si150_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_mes"] : $this->si150_mes);
      $this->si150_instit = ($this->si150_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_instit"] : $this->si150_instit);
    } else {
      $this->si150_sequencial = ($this->si150_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si150_sequencial"] : $this->si150_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si150_sequencial)
  {
    $this->atualizacampos();
    if ($this->si150_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si150_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si150_nroleiautorizacao == null) {
      $this->si150_nroleiautorizacao = "0";
    }
    if ($this->si150_dtleiautorizacao == null) {
      $this->si150_dtleiautorizacao = "null";
    }
    if ($this->si150_dtpublicacaoleiautorizacao == null) {
      $this->si150_dtpublicacaoleiautorizacao = "null";
    }
    if ($this->si150_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si150_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si150_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si150_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si150_sequencial == "" || $si150_sequencial == null) {
      $result = db_query("select nextval('ddc102018_si150_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ddc102018_si150_sequencial_seq do campo: si150_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si150_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ddc102018_si150_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si150_sequencial)) {
        $this->erro_sql = " Campo si150_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si150_sequencial = $si150_sequencial;
      }
    }
    if (($this->si150_sequencial == null) || ($this->si150_sequencial == "")) {
      $this->erro_sql = " Campo si150_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into ddc102018(
                                       si150_sequencial 
                                      ,si150_tiporegistro 
                                      ,si150_codorgao 
                                      ,si150_nroleiautorizacao 
                                      ,si150_dtleiautorizacao 
                                      ,si150_dtpublicacaoleiautorizacao 
                                      ,si150_mes 
                                      ,si150_instit 
                       )
                values (
                                $this->si150_sequencial 
                               ,$this->si150_tiporegistro 
                               ,'$this->si150_codorgao' 
                               ,'$this->si150_nroleiautorizacao' 
                               ," . ($this->si150_dtleiautorizacao == "null" || $this->si150_dtleiautorizacao == "" ? "null" : "'" . $this->si150_dtleiautorizacao . "'") . "
                               ," . ($this->si150_dtpublicacaoleiautorizacao == "null" || $this->si150_dtpublicacaoleiautorizacao == "" ? "null" : "'" . $this->si150_dtpublicacaoleiautorizacao . "'") . "
                               ,$this->si150_mes 
                               ,$this->si150_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ddc102018 ($this->si150_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "ddc102018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "ddc102018 ($this->si150_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si150_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si150_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2011145,'$this->si150_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010379,2011145,'','" . AddSlashes(pg_result($resaco, 0, 'si150_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010379,2011146,'','" . AddSlashes(pg_result($resaco, 0, 'si150_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010379,2011147,'','" . AddSlashes(pg_result($resaco, 0, 'si150_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010379,2011148,'','" . AddSlashes(pg_result($resaco, 0, 'si150_nroleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010379,2011363,'','" . AddSlashes(pg_result($resaco, 0, 'si150_dtleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010379,2011149,'','" . AddSlashes(pg_result($resaco, 0, 'si150_dtpublicacaoleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010379,2011150,'','" . AddSlashes(pg_result($resaco, 0, 'si150_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010379,2011663,'','" . AddSlashes(pg_result($resaco, 0, 'si150_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si150_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ddc102018 set ";
    $virgula = "";
    if (trim($this->si150_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_sequencial"])) {
      if (trim($this->si150_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si150_sequencial"])) {
        $this->si150_sequencial = "0";
      }
      $sql .= $virgula . " si150_sequencial = $this->si150_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si150_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_tiporegistro"])) {
      $sql .= $virgula . " si150_tiporegistro = $this->si150_tiporegistro ";
      $virgula = ",";
      if (trim($this->si150_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si150_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si150_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_codorgao"])) {
      $sql .= $virgula . " si150_codorgao = '$this->si150_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si150_nroleiautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_nroleiautorizacao"])) {
      $sql .= $virgula . " si150_nroleiautorizacao = '$this->si150_nroleiautorizacao' ";
      $virgula = ",";
    }
    if (trim($this->si150_dtleiautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_dtleiautorizacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si150_dtleiautorizacao_dia"] != "")) {
      $sql .= $virgula . " si150_dtleiautorizacao = '$this->si150_dtleiautorizacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si150_dtleiautorizacao_dia"])) {
        $sql .= $virgula . " si150_dtleiautorizacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si150_dtpublicacaoleiautorizacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_dtpublicacaoleiautorizacao_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si150_dtpublicacaoleiautorizacao_dia"] != "")) {
      $sql .= $virgula . " si150_dtpublicacaoleiautorizacao = '$this->si150_dtpublicacaoleiautorizacao' ";
      $virgula = ",";
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si150_dtpublicacaoleiautorizacao_dia"])) {
        $sql .= $virgula . " si150_dtpublicacaoleiautorizacao = null ";
        $virgula = ",";
      }
    }
    if (trim($this->si150_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_mes"])) {
      $sql .= $virgula . " si150_mes = $this->si150_mes ";
      $virgula = ",";
      if (trim($this->si150_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si150_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si150_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si150_instit"])) {
      $sql .= $virgula . " si150_instit = $this->si150_instit ";
      $virgula = ",";
      if (trim($this->si150_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si150_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si150_sequencial != null) {
      $sql .= " si150_sequencial = $this->si150_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si150_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011145,'$this->si150_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_sequencial"]) || $this->si150_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011145,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_sequencial')) . "','$this->si150_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_tiporegistro"]) || $this->si150_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011146,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_tiporegistro')) . "','$this->si150_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_codorgao"]) || $this->si150_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011147,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_codorgao')) . "','$this->si150_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_nroleiautorizacao"]) || $this->si150_nroleiautorizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011148,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_nroleiautorizacao')) . "','$this->si150_nroleiautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_dtleiautorizacao"]) || $this->si150_dtleiautorizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011363,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_dtleiautorizacao')) . "','$this->si150_dtleiautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_dtpublicacaoleiautorizacao"]) || $this->si150_dtpublicacaoleiautorizacao != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011149,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_dtpublicacaoleiautorizacao')) . "','$this->si150_dtpublicacaoleiautorizacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_mes"]) || $this->si150_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011150,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_mes')) . "','$this->si150_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si150_instit"]) || $this->si150_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010379,2011663,'" . AddSlashes(pg_result($resaco, $conresaco, 'si150_instit')) . "','$this->si150_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ddc102018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si150_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ddc102018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si150_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si150_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si150_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si150_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011145,'$si150_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010379,2011145,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010379,2011146,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010379,2011147,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010379,2011148,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_nroleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010379,2011363,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_dtleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010379,2011149,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_dtpublicacaoleiautorizacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010379,2011150,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010379,2011663,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si150_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from ddc102018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si150_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si150_sequencial = $si150_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "ddc102018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si150_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ddc102018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si150_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si150_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ddc102018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ddc102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si150_sequencial != null) {
        $sql2 .= " where ddc102018.si150_sequencial = $si150_sequencial ";
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
  function sql_query_file($si150_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ddc102018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si150_sequencial != null) {
        $sql2 .= " where ddc102018.si150_sequencial = $si150_sequencial ";
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
