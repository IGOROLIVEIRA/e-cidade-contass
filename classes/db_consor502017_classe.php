<?
//MODULO: sicom
//CLASSE DA ENTIDADE consor502017
class cl_consor502017
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
  var $si20_sequencial = 0;
  var $si20_codorgao = 0;
  var $si20_cnpjconsorcio = 0;
  var $si20_tiporegistro = 0;
  var $si20_tipoencerramento = 0;
  var $si20_dtencerramento = null;
  var $si20_mes = 0;
  var $si20_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si20_sequencial = int8 = sequencial 
                 si20_tiporegistro = int8 = Tipo do  registro 
                 si20_codorgao = varchar(2) = Código do órgão
                 si20_cnpjconsorcio = varchar(14) = CNPJ do Consórcio
                 si20_tipoencerramento = int8 = Tipo de  Encerramento
                 si20_dtencerramento = date = Data do  encerramento 
                 si20_mes = int8 = Mês 
                 si20_instit = int8 = Instit
                 ";

  //funcao construtor da classe
  function cl_consor502017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("consor502017");
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
      $this->si20_sequencial = ($this->si20_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_sequencial"] : $this->si20_sequencial);
      $this->si20_codorgao = ($this->si20_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_codorgao"] : $this->si20_codorgao);
      $this->si20_cnpjconsorcio = ($this->si20_cnpjconsorcio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_cnpjconsorcio"] : $this->si20_cnpjconsorcio);
      $this->si20_tiporegistro = ($this->si20_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_tiporegistro"] : $this->si20_tiporegistro);
      $this->si20_tipoencerramento = ($this->si20_tipoencerramento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_tipoencerramento"] : $this->si20_tipoencerramento);
      $this->si20_dtencerramento = ($this->si20_dtencerramento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_dtencerramento"] : $this->si20_dtencerramento);
      $this->si20_mes = ($this->si20_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_mes"] : $this->si20_mes);
      $this->si20_instit = ($this->si20_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_instit"] : $this->si20_instit);
    } else {
      $this->si20_sequencial = ($this->si20_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si20_sequencial"] : $this->si20_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si20_sequencial)
  {
    $this->atualizacampos();
    if ($this->si20_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si20_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si20_tipoencerramento == null) {
      $this->erro_sql = " Campo Tipo de  Encerramento nao Informado.";
      $this->erro_campo = "si20_tipoencerramento";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si20_dtencerramento == null) {
      $this->erro_sql = " Campo Data do  encerramento nao Informado.";
      $this->erro_campo = "si20_dtencerramento";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si20_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si20_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si20_instit == null) {
      $this->erro_sql = " Campo Instit nao Informado.";
      $this->erro_campo = "si20_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si20_codorgao == null) {
      $this->erro_sql = " Campo Código do Orgao nao Informado.";
      $this->erro_campo = "si20_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    if ($this->si20_codorgao == null) {
      $this->erro_sql = " Campo CNPJ nao Informado.";
      $this->erro_campo = "si20_cnpjconsorcio";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    if ($si20_sequencial == "" || $si20_sequencial == null) {
      $result = db_query("select nextval('consor502017_si20_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: consor502017_si20_sequencial_seq do campo: si20_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si20_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from consor502017_si20_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si20_sequencial)) {
        $this->erro_sql = " Campo si20_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si20_sequencial = $si20_sequencial;
      }
    }
    if (($this->si20_sequencial == null) || ($this->si20_sequencial == "")) {
      $this->erro_sql = " Campo si20_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into consor502017(
                                       si20_sequencial 
                                      ,si20_tiporegistro 
                                      ,si20_codorgao
                                      ,si20_cnpjconsorcio
                                      ,si20_tipoencerramento
                                      ,si20_dtencerramento 
                                      ,si20_mes
                                      ,si20_instit
                       )
                values (
                                $this->si20_sequencial 
                               ,$this->si20_tiporegistro 
                               ,'$this->si20_codorgao'
                               ,'$this->si20_cnpjconsorcio'
                               ,$this->si20_tipoencerramento
                               ,'$this->si20_dtencerramento'
                               ,$this->si20_mes 
                               ,$this->si20_instit
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "consor502017 ($this->si20_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "consor502017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "consor502017 ($this->si20_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si20_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si20_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009647,'$this->si20_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010248,2009647,'','" . AddSlashes(pg_result($resaco, 0, 'si20_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010248,2009648,'','" . AddSlashes(pg_result($resaco, 0, 'si20_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010248,2009649,'','" . AddSlashes(pg_result($resaco, 0, 'si20_codconsorcio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010248,2009650,'','" . AddSlashes(pg_result($resaco, 0, 'si20_tipoencerramento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010248,2009651,'','" . AddSlashes(pg_result($resaco, 0, 'si20_dtencerramento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010248,2009740,'','" . AddSlashes(pg_result($resaco, 0, 'si20_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010248,2009741,'','" . AddSlashes(pg_result($resaco, 0, 'si20_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si20_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update consor502017 set ";
    $virgula = "";
    if (trim($this->si20_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si20_sequencial"])) {
      $sql .= $virgula . " si20_sequencial = $this->si20_sequencial ";
      $virgula = ",";
      if (trim($this->si20_sequencial) == null) {
        $this->erro_sql = " Campo sequencial nao Informado.";
        $this->erro_campo = "si20_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si20_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si20_tiporegistro"])) {
      $sql .= $virgula . " si20_tiporegistro = $this->si20_tiporegistro ";
      $virgula = ",";
      if (trim($this->si20_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si20_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si20_codconsorcio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si20_codconsorcio"])) {
      $sql .= $virgula . " si20_codconsorcio = '$this->si20_codconsorcio' ";
      $virgula = ",";
      if (trim($this->si20_codconsorcio) == null) {
        $this->erro_sql = " Campo Código do  Consórcio nao Informado.";
        $this->erro_campo = "si20_codconsorcio";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si20_tipoencerramento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si20_tipoencerramento"])) {
      $sql .= $virgula . " si20_tipoencerramento = $this->si20_tipoencerramento ";
      $virgula = ",";
      if (trim($this->si20_tipoencerramento) == null) {
        $this->erro_sql = " Campo Tipo de  Encerramento nao Informado.";
        $this->erro_campo = "si20_tipoencerramento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si20_dtencerramento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si20_dtencerramento_dia"]) && ($GLOBALS["HTTP_POST_VARS"]["si20_dtencerramento_dia"] != "")) {
      $sql .= $virgula . " si20_dtencerramento = '$this->si20_dtencerramento' ";
      $virgula = ",";
      if (trim($this->si20_dtencerramento) == null) {
        $this->erro_sql = " Campo Data do  encerramento nao Informado.";
        $this->erro_campo = "si20_dtencerramento_dia";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    } else {
      if (isset($GLOBALS["HTTP_POST_VARS"]["si20_dtencerramento_dia"])) {
        $sql .= $virgula . " si20_dtencerramento = null ";
        $virgula = ",";
        if (trim($this->si20_dtencerramento) == null) {
          $this->erro_sql = " Campo Data do  encerramento nao Informado.";
          $this->erro_campo = "si20_dtencerramento_dia";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
          $this->erro_status = "0";

          return false;
        }
      }
    }
    if (trim($this->si20_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si20_mes"])) {
      $sql .= $virgula . " si20_mes = $this->si20_mes ";
      $virgula = ",";
      if (trim($this->si20_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si20_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si20_sequencial != null) {
      $sql .= " si20_sequencial = $this->si20_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si20_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009647,'$this->si20_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si20_sequencial"]) || $this->si20_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010248,2009647,'" . AddSlashes(pg_result($resaco, $conresaco, 'si20_sequencial')) . "','$this->si20_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si20_tiporegistro"]) || $this->si20_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010248,2009648,'" . AddSlashes(pg_result($resaco, $conresaco, 'si20_tiporegistro')) . "','$this->si20_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si20_codconsorcio"]) || $this->si20_codconsorcio != "")
          $resac = db_query("insert into db_acount values($acount,2010248,2009649,'" . AddSlashes(pg_result($resaco, $conresaco, 'si20_codconsorcio')) . "','$this->si20_codconsorcio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si20_tipoencerramento"]) || $this->si20_tipoencerramento != "")
          $resac = db_query("insert into db_acount values($acount,2010248,2009650,'" . AddSlashes(pg_result($resaco, $conresaco, 'si20_tipoencerramento')) . "','$this->si20_tipoencerramento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si20_dtencerramento"]) || $this->si20_dtencerramento != "")
          $resac = db_query("insert into db_acount values($acount,2010248,2009651,'" . AddSlashes(pg_result($resaco, $conresaco, 'si20_dtencerramento')) . "','$this->si20_dtencerramento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si20_mes"]) || $this->si20_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010248,2009740,'" . AddSlashes(pg_result($resaco, $conresaco, 'si20_mes')) . "','$this->si20_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "consor502017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si20_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "consor502017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si20_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si20_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si20_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si20_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009647,'$si20_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010248,2009647,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si20_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010248,2009648,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si20_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010248,2009649,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si20_codconsorcio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010248,2009650,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si20_tipoencerramento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010248,2009651,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si20_dtencerramento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010248,2009740,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si20_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from consor502017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si20_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si20_sequencial = $si20_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "consor502017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si20_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "consor502017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si20_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si20_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:consor502017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si20_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from consor502017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si20_sequencial != null) {
        $sql2 .= " where consor502017.si20_sequencial = $si20_sequencial ";
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
  function sql_query_file($si20_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from consor502017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si20_sequencial != null) {
        $sql2 .= " where consor502017.si20_sequencial = $si20_sequencial ";
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
