<?
//MODULO: sicom
//CLASSE DA ENTIDADE emp112021
class cl_emp112021
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
  var $si107_sequencial = 0;
  var $si107_tiporegistro = 0;
  var $si107_codunidadesub = null;
  var $si107_nroempenho = 0;
  var $si107_codfontrecursos = 0;
  var $si107_valorfonte = 0;
  var $si107_mes = 0;
  var $si107_reg10 = 0;
  var $si107_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si107_sequencial = int8 = sequencial 
                 si107_tiporegistro = int8 = Tipo do  registro 
                 si107_codunidadesub = varchar(8) = Código da unidade 
                 si107_nroempenho = int8 = Número do  empenho 
                 si107_codfontrecursos = int8 = Código da fonte de  recursos 
                 si107_valorfonte = float8 = Valor empenhado  na fonte 
                 si107_mes = int8 = Mês 
                 si107_reg10 = int8 = reg10 
                 si107_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe
  function cl_emp112021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("emp112021");
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
      $this->si107_sequencial = ($this->si107_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_sequencial"] : $this->si107_sequencial);
      $this->si107_tiporegistro = ($this->si107_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_tiporegistro"] : $this->si107_tiporegistro);
      $this->si107_codunidadesub = ($this->si107_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_codunidadesub"] : $this->si107_codunidadesub);
      $this->si107_nroempenho = ($this->si107_nroempenho == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_nroempenho"] : $this->si107_nroempenho);
      $this->si107_codfontrecursos = ($this->si107_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_codfontrecursos"] : $this->si107_codfontrecursos);
      $this->si107_valorfonte = ($this->si107_valorfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_valorfonte"] : $this->si107_valorfonte);
      $this->si107_mes = ($this->si107_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_mes"] : $this->si107_mes);
      $this->si107_reg10 = ($this->si107_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_reg10"] : $this->si107_reg10);
      $this->si107_instit = ($this->si107_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_instit"] : $this->si107_instit);
    } else {
      $this->si107_sequencial = ($this->si107_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si107_sequencial"] : $this->si107_sequencial);
    }
  }

  // funcao para inclusao
  function incluir($si107_sequencial)
  {
    $this->atualizacampos();
    if ($this->si107_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si107_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si107_nroempenho == null) {
      $this->si107_nroempenho = "0";
    }
    if ($this->si107_codfontrecursos == null) {
      $this->si107_codfontrecursos = "0";
    }
    if ($this->si107_valorfonte == null) {
      $this->si107_valorfonte = "0";
    }
    if ($this->si107_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si107_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($this->si107_reg10 == null) {
      $this->si107_reg10 = "0";
    }
    if ($this->si107_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si107_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    if ($si107_sequencial == "" || $si107_sequencial == null) {
      $result = db_query("select nextval('emp112021_si107_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: emp112021_si107_sequencial_seq do campo: si107_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
      $this->si107_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from emp112021_si107_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si107_sequencial)) {
        $this->erro_sql = " Campo si107_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      } else {
        $this->si107_sequencial = $si107_sequencial;
      }
    }
    if (($this->si107_sequencial == null) || ($this->si107_sequencial == "")) {
      $this->erro_sql = " Campo si107_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }
    $sql = "insert into emp112021(
                                       si107_sequencial 
                                      ,si107_tiporegistro 
                                      ,si107_codunidadesub 
                                      ,si107_nroempenho 
                                      ,si107_codfontrecursos 
                                      ,si107_valorfonte 
                                      ,si107_mes 
                                      ,si107_reg10 
                                      ,si107_instit 
                       )
                values (
                                $this->si107_sequencial 
                               ,$this->si107_tiporegistro 
                               ,'$this->si107_codunidadesub' 
                               ,$this->si107_nroempenho 
                               ,$this->si107_codfontrecursos 
                               ,$this->si107_valorfonte 
                               ,$this->si107_mes 
                               ,$this->si107_reg10 
                               ,$this->si107_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "emp112021 ($this->si107_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "emp112021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "emp112021 ($this->si107_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;

      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si107_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si107_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010674,'$this->si107_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010336,2010674,'','" . AddSlashes(pg_result($resaco, 0, 'si107_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2010675,'','" . AddSlashes(pg_result($resaco, 0, 'si107_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2010676,'','" . AddSlashes(pg_result($resaco, 0, 'si107_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2010677,'','" . AddSlashes(pg_result($resaco, 0, 'si107_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2010678,'','" . AddSlashes(pg_result($resaco, 0, 'si107_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2010679,'','" . AddSlashes(pg_result($resaco, 0, 'si107_valorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2010680,'','" . AddSlashes(pg_result($resaco, 0, 'si107_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2010681,'','" . AddSlashes(pg_result($resaco, 0, 'si107_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010336,2011620,'','" . AddSlashes(pg_result($resaco, 0, 'si107_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }

    return true;
  }

  // funcao para alteracao
  function alterar($si107_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update emp112021 set ";
    $virgula = "";
    if (trim($this->si107_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_sequencial"])) {
      if (trim($this->si107_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si107_sequencial"])) {
        $this->si107_sequencial = "0";
      }
      $sql .= $virgula . " si107_sequencial = $this->si107_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si107_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_tiporegistro"])) {
      $sql .= $virgula . " si107_tiporegistro = $this->si107_tiporegistro ";
      $virgula = ",";
      if (trim($this->si107_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si107_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si107_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_codunidadesub"])) {
      $sql .= $virgula . " si107_codunidadesub = '$this->si107_codunidadesub' ";
      $virgula = ",";
    }
    if (trim($this->si107_nroempenho) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_nroempenho"])) {
      if (trim($this->si107_nroempenho) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si107_nroempenho"])) {
        $this->si107_nroempenho = "0";
      }
      $sql .= $virgula . " si107_nroempenho = $this->si107_nroempenho ";
      $virgula = ",";
    }
    if (trim($this->si107_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_codfontrecursos"])) {
      if (trim($this->si107_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si107_codfontrecursos"])) {
        $this->si107_codfontrecursos = "0";
      }
      $sql .= $virgula . " si107_codfontrecursos = $this->si107_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si107_valorfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_valorfonte"])) {
      if (trim($this->si107_valorfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si107_valorfonte"])) {
        $this->si107_valorfonte = "0";
      }
      $sql .= $virgula . " si107_valorfonte = $this->si107_valorfonte ";
      $virgula = ",";
    }
    if (trim($this->si107_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_mes"])) {
      $sql .= $virgula . " si107_mes = $this->si107_mes ";
      $virgula = ",";
      if (trim($this->si107_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si107_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    if (trim($this->si107_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_reg10"])) {
      if (trim($this->si107_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si107_reg10"])) {
        $this->si107_reg10 = "0";
      }
      $sql .= $virgula . " si107_reg10 = $this->si107_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si107_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si107_instit"])) {
      $sql .= $virgula . " si107_instit = $this->si107_instit ";
      $virgula = ",";
      if (trim($this->si107_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si107_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";

        return false;
      }
    }
    $sql .= " where ";
    if ($si107_sequencial != null) {
      $sql .= " si107_sequencial = $this->si107_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si107_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010674,'$this->si107_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_sequencial"]) || $this->si107_sequencial != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010674,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_sequencial')) . "','$this->si107_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_tiporegistro"]) || $this->si107_tiporegistro != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010675,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_tiporegistro')) . "','$this->si107_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_codunidadesub"]) || $this->si107_codunidadesub != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010676,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_codunidadesub')) . "','$this->si107_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_nroempenho"]) || $this->si107_nroempenho != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010677,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_nroempenho')) . "','$this->si107_nroempenho'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_codfontrecursos"]) || $this->si107_codfontrecursos != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010678,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_codfontrecursos')) . "','$this->si107_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_valorfonte"]) || $this->si107_valorfonte != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010679,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_valorfonte')) . "','$this->si107_valorfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_mes"]) || $this->si107_mes != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010680,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_mes')) . "','$this->si107_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_reg10"]) || $this->si107_reg10 != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2010681,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_reg10')) . "','$this->si107_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si107_instit"]) || $this->si107_instit != "")
          $resac = db_query("insert into db_acount values($acount,2010336,2011620,'" . AddSlashes(pg_result($resaco, $conresaco, 'si107_instit')) . "','$this->si107_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "emp112021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si107_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "emp112021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si107_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si107_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);

        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir($si107_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si107_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010674,'$si107_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010336,2010674,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2010675,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2010676,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2010677,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_nroempenho')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2010678,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2010679,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_valorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2010680,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2010681,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010336,2011620,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si107_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from emp112021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si107_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si107_sequencial = $si107_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "emp112021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si107_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;

      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "emp112021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si107_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;

        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si107_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:emp112021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";

      return false;
    }

    return $result;
  }

  // funcao do sql
  function sql_query($si107_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from emp112021 ";
    $sql .= "      left  join emp102020  on  emp102020.si106_sequencial = emp112021.si107_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si107_sequencial != null) {
        $sql2 .= " where emp112021.si107_sequencial = $si107_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    }

    return $sql;
  }

  // funcao do sql
  function sql_query_file($si107_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
  {
    $sql = "select ";
    if ($campos != "*") {
      $campos_sql = split("#", $campos);
      $virgula = "";
      for ($i = 0; $i < sizeof($campos_sql); $i++) {
        $sql .= $virgula . $campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from emp112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si107_sequencial != null) {
        $sql2 .= " where emp112021.si107_sequencial = $si107_sequencial ";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null) {
      $sql .= " order by ";
      $campos_sql = split("#", $ordem);
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
