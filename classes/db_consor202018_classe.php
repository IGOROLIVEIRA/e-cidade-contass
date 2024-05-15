<?
//MODULO: sicom
//CLASSE DA ENTIDADE consor202018
class cl_consor202018
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
  var $si17_sequencial = 0;
  var $si17_tiporegistro = 0;
  var $si17_codorgao = null;
  var $si17_cnpjconsorcio = null;
  var $si17_codfontrecursos = 0;
  var $si17_vltransfrateio = 0;
  var $si17_prestcontas = 0;
  var $si17_mes = 0;
  var $si17_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si17_sequencial = int8 = sequencial 
                 si17_tiporegistro = int8 = Tipo do registro 
                 si17_codorgao = varchar(2) = Código do órgão 
                 si17_cnpjconsorcio = varchar(14) = Código do  Consórcio 
                 si17_codfontrecursos = int8 = Código da fonte de recursos
                 si17_vltransfrateio = float8 = Valor transferido 
                 si17_prestcontas = int8 = informa encaminhamento 
                 si17_mes = int8 = Mês 
                 si17_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_consor202018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("consor202018");
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
      $this->si17_sequencial = ($this->si17_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_sequencial"] : $this->si17_sequencial);
      $this->si17_tiporegistro = ($this->si17_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_tiporegistro"] : $this->si17_tiporegistro);
      $this->si17_codorgao = ($this->si17_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_codorgao"] : $this->si17_codorgao);
      $this->si17_cnpjconsorcio = ($this->si17_cnpjconsorcio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_cnpjconsorcio"] : $this->si17_cnpjconsorcio);
      $this->si17_codfontrecursos = ($this->si17_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_codfontrecursos"] : $this->si17_codfontrecursos);
      $this->si17_vltransfrateio = ($this->si17_vltransfrateio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_vltransfrateio"] : $this->si17_vltransfrateio);
      $this->si17_prestcontas = ($this->si17_prestcontas == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_prestcontas"] : $this->si17_prestcontas);
      $this->si17_mes = ($this->si17_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_mes"] : $this->si17_mes);
      $this->si17_instit = ($this->si17_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_instit"] : $this->si17_instit);
    } else {
      $this->si17_sequencial = ($this->si17_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si17_sequencial"] : $this->si17_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si17_sequencial)
  {
    $this->atualizacampos();
    if ($this->si17_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si17_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si17_vltransfrateio == null) {
      $this->si17_vltransfrateio = "0";
    }
    if ($this->si17_prestcontas == null) {
      $this->si17_prestcontas = "0";
    }
    if ($this->si17_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si17_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si17_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si17_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si17_sequencial == "" || $si17_sequencial == null) {
      $result = db_query("select nextval('consor202018_si17_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: consor202018_si17_sequencial_seq do campo: si17_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si17_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from consor202018_si17_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si17_sequencial)) {
        $this->erro_sql = " Campo si17_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si17_sequencial = $si17_sequencial;
      }
    }
    if (($this->si17_sequencial == null) || ($this->si17_sequencial == "")) {
      $this->erro_sql = " Campo si17_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into consor202018(
                                       si17_sequencial 
                                      ,si17_tiporegistro 
                                      ,si17_codorgao 
                                      ,si17_cnpjconsorcio 
                                      ,si17_codfontrecursos
                                      ,si17_vltransfrateio 
                                      ,si17_prestcontas 
                                      ,si17_mes 
                                      ,si17_instit 
                       )
                values (
                                $this->si17_sequencial 
                               ,$this->si17_tiporegistro 
                               ,'$this->si17_codorgao' 
                               ,'$this->si17_cnpjconsorcio'
                               ,$this->si17_codfontrecursos
                               ,$this->si17_vltransfrateio 
                               ,$this->si17_prestcontas 
                               ,$this->si17_mes 
                               ,$this->si17_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "consor202018 ($this->si17_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "consor202018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "consor202018 ($this->si17_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si17_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si17_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2009625,'$this->si17_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010245,2009625,'','" . AddSlashes(pg_result($resaco, 0, 'si17_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010245,2009626,'','" . AddSlashes(pg_result($resaco, 0, 'si17_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010245,2011306,'','" . AddSlashes(pg_result($resaco, 0, 'si17_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010245,2009627,'','" . AddSlashes(pg_result($resaco, 0, 'si17_cnpjconsorcio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010245,2009628,'','" . AddSlashes(pg_result($resaco, 0, 'si17_vltransfrateio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010245,2009629,'','" . AddSlashes(pg_result($resaco, 0, 'si17_prestcontas')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010245,2009737,'','" . AddSlashes(pg_result($resaco, 0, 'si17_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010245,2011535,'','" . AddSlashes(pg_result($resaco, 0, 'si17_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si17_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update consor202018 set ";
    $virgula = "";
    if (trim($this->si17_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_sequencial"])) {
      if (trim($this->si17_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si17_sequencial"])) {
        $this->si17_sequencial = "0";
      }
      $sql .= $virgula . " si17_sequencial = $this->si17_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si17_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_tiporegistro"])) {
      $sql .= $virgula . " si17_tiporegistro = $this->si17_tiporegistro ";
      $virgula = ",";
      if (trim($this->si17_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si17_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si17_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_codorgao"])) {
      $sql .= $virgula . " si17_codorgao = '$this->si17_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si17_cnpjconsorcio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_cnpjconsorcio"])) {
      $sql .= $virgula . " si17_cnpjconsorcio = '$this->si17_cnpjconsorcio' ";
      $virgula = ",";
    }
    if (trim($this->si17_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_codfontrecursos"])) {
      $sql .= $virgula . " si17_codfontrecursos = '$this->si17_codfontrecursos' ";
      $virgula = ",";
    }
    if (trim($this->si17_vltransfrateio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_vltransfrateio"])) {
      if (trim($this->si17_vltransfrateio) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si17_vltransfrateio"])) {
        $this->si17_vltransfrateio = "0";
      }
      $sql .= $virgula . " si17_vltransfrateio = $this->si17_vltransfrateio ";
      $virgula = ",";
    }
    if (trim($this->si17_prestcontas) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_prestcontas"])) {
      if (trim($this->si17_prestcontas) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si17_prestcontas"])) {
        $this->si17_prestcontas = "0";
      }
      $sql .= $virgula . " si17_prestcontas = $this->si17_prestcontas ";
      $virgula = ",";
    }
    if (trim($this->si17_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_mes"])) {
      $sql .= $virgula . " si17_mes = $this->si17_mes ";
      $virgula = ",";
      if (trim($this->si17_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si17_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si17_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si17_instit"])) {
      $sql .= $virgula . " si17_instit = $this->si17_instit ";
      $virgula = ",";
      if (trim($this->si17_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si17_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si17_sequencial != null) {
      $sql .= " si17_sequencial = $this->si17_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si17_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009625,'$this->si17_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_sequencial"]) || $this->si17_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2009625,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_sequencial')) . "','$this->si17_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_tiporegistro"]) || $this->si17_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2009626,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_tiporegistro')) . "','$this->si17_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_codorgao"]) || $this->si17_codorgao != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2011306,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_codorgao')) . "','$this->si17_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_cnpjconsorcio"]) || $this->si17_cnpjconsorcio != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2009627,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_cnpjconsorcio')) . "','$this->si17_cnpjconsorcio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_vltransfrateio"]) || $this->si17_vltransfrateio != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2009628,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_vltransfrateio')) . "','$this->si17_vltransfrateio'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_prestcontas"]) || $this->si17_prestcontas != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2009629,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_prestcontas')) . "','$this->si17_prestcontas'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_mes"]) || $this->si17_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2009737,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_mes')) . "','$this->si17_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si17_instit"]) || $this->si17_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010245,2011535,'" . AddSlashes(pg_result($resaco, $conresaco, 'si17_instit')) . "','$this->si17_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "consor202018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si17_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "consor202018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si17_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si17_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si17_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si17_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2009625,'$si17_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010245,2009625,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010245,2009626,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010245,2011306,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010245,2009627,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_cnpjconsorcio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010245,2009628,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_vltransfrateio')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010245,2009629,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_prestcontas')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010245,2009737,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010245,2011535,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si17_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from consor202018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si17_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si17_sequencial = $si17_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "consor202018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si17_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "consor202018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si17_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si17_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:consor202018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si17_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from consor202018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si17_sequencial != null) {
        $sql2 .= " where consor202018.si17_sequencial = $si17_sequencial ";
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
  function sql_query_file($si17_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from consor202018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si17_sequencial != null) {
        $sql2 .= " where consor202018.si17_sequencial = $si17_sequencial ";
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
