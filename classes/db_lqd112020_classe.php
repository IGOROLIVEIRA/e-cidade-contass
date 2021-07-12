<?
//MODULO: sicom
//CLASSE DA ENTIDADE lqd112020
class cl_lqd112020
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
  var $si119_sequencial = 0;
  var $si119_tiporegistro = 0;
  var $si119_codreduzido = 0;
  var $si119_codfontrecursos = 0;
  var $si119_valorfonte = 0;
  var $si119_mes = 0;
  var $si119_reg10 = 0;
  var $si119_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si119_sequencial = int8 = sequencial 
                 si119_tiporegistro = int8 = Tipo do  registro 
                 si119_codreduzido = int8 = Código Identificador do registro 
                 si119_codfontrecursos = int8 = Código da fonte de recursos 
                 si119_valorfonte = float8 = Valor liquidado 
                 si119_mes = int8 = Mês 
                 si119_reg10 = int8 = reg10 
                 si119_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_lqd112020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("lqd112020");
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
      $this->si119_sequencial = ($this->si119_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_sequencial"] : $this->si119_sequencial);
      $this->si119_tiporegistro = ($this->si119_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_tiporegistro"] : $this->si119_tiporegistro);
      $this->si119_codreduzido = ($this->si119_codreduzido == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_codreduzido"] : $this->si119_codreduzido);
      $this->si119_codfontrecursos = ($this->si119_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_codfontrecursos"] : $this->si119_codfontrecursos);
      $this->si119_valorfonte = ($this->si119_valorfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_valorfonte"] : $this->si119_valorfonte);
      $this->si119_mes = ($this->si119_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_mes"] : $this->si119_mes);
      $this->si119_reg10 = ($this->si119_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_reg10"] : $this->si119_reg10);
      $this->si119_instit = ($this->si119_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_instit"] : $this->si119_instit);
    } else {
      $this->si119_sequencial = ($this->si119_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si119_sequencial"] : $this->si119_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si119_sequencial)
  {
    $this->atualizacampos();
    if ($this->si119_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si119_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si119_codreduzido == null) {
      $this->si119_codreduzido = "0";
    }
    if ($this->si119_codfontrecursos == null) {
      $this->si119_codfontrecursos = "0";
    }
    if ($this->si119_valorfonte == null) {
      $this->si119_valorfonte = "0";
    }
    if ($this->si119_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si119_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si119_reg10 == null) {
      $this->si119_reg10 = "0";
    }
    if ($this->si119_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si119_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si119_sequencial == "" || $si119_sequencial == null) {
      $result = db_query("select nextval('lqd112020_si119_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: lqd112020_si119_sequencial_seq do campo: si119_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si119_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from lqd112020_si119_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si119_sequencial)) {
        $this->erro_sql = " Campo si119_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si119_sequencial = $si119_sequencial;
      }
    }
    if (($this->si119_sequencial == null) || ($this->si119_sequencial == "")) {
      $this->erro_sql = " Campo si119_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into lqd112020(
                                       si119_sequencial 
                                      ,si119_tiporegistro 
                                      ,si119_codreduzido 
                                      ,si119_codfontrecursos 
                                      ,si119_valorfonte 
                                      ,si119_mes 
                                      ,si119_reg10 
                                      ,si119_instit 
                       )
                values (
                                $this->si119_sequencial 
                               ,$this->si119_tiporegistro 
                               ,$this->si119_codreduzido 
                               ,$this->si119_codfontrecursos 
                               ,$this->si119_valorfonte 
                               ,$this->si119_mes 
                               ,$this->si119_reg10 
                               ,$this->si119_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "lqd112020 ($this->si119_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "lqd112020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "lqd112020 ($this->si119_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si119_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si119_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010799,'$this->si119_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010348,2010799,'','" . AddSlashes(pg_result($resaco, 0, 'si119_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010348,2010800,'','" . AddSlashes(pg_result($resaco, 0, 'si119_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010348,2010801,'','" . AddSlashes(pg_result($resaco, 0, 'si119_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010348,2010802,'','" . AddSlashes(pg_result($resaco, 0, 'si119_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010348,2010803,'','" . AddSlashes(pg_result($resaco, 0, 'si119_valorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010348,2010804,'','" . AddSlashes(pg_result($resaco, 0, 'si119_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010348,2010805,'','" . AddSlashes(pg_result($resaco, 0, 'si119_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010348,2011632,'','" . AddSlashes(pg_result($resaco, 0, 'si119_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si119_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update lqd112020 set ";
    $virgula = "";
    if (trim($this->si119_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_sequencial"])) {
      if (trim($this->si119_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si119_sequencial"])) {
        $this->si119_sequencial = "0";
      }
      $sql .= $virgula . " si119_sequencial = $this->si119_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si119_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_tiporegistro"])) {
      $sql .= $virgula . " si119_tiporegistro = $this->si119_tiporegistro ";
      $virgula = ",";
      if (trim($this->si119_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si119_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si119_codreduzido) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_codreduzido"])) {
      if (trim($this->si119_codreduzido) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si119_codreduzido"])) {
        $this->si119_codreduzido = "0";
      }
      $sql .= $virgula . " si119_codreduzido = $this->si119_codreduzido ";
      $virgula = ",";
    }
    if (trim($this->si119_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_codfontrecursos"])) {
      if (trim($this->si119_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si119_codfontrecursos"])) {
        $this->si119_codfontrecursos = "0";
      }
      $sql .= $virgula . " si119_codfontrecursos = $this->si119_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si119_valorfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_valorfonte"])) {
      if (trim($this->si119_valorfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si119_valorfonte"])) {
        $this->si119_valorfonte = "0";
      }
      $sql .= $virgula . " si119_valorfonte = $this->si119_valorfonte ";
      $virgula = ",";
    }
    if (trim($this->si119_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_mes"])) {
      $sql .= $virgula . " si119_mes = $this->si119_mes ";
      $virgula = ",";
      if (trim($this->si119_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si119_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si119_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_reg10"])) {
      if (trim($this->si119_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si119_reg10"])) {
        $this->si119_reg10 = "0";
      }
      $sql .= $virgula . " si119_reg10 = $this->si119_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si119_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si119_instit"])) {
      $sql .= $virgula . " si119_instit = $this->si119_instit ";
      $virgula = ",";
      if (trim($this->si119_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si119_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si119_sequencial != null) {
      $sql .= " si119_sequencial = $this->si119_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si119_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010799,'$this->si119_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_sequencial"]) || $this->si119_sequencial != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2010799,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_sequencial')) . "','$this->si119_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_tiporegistro"]) || $this->si119_tiporegistro != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2010800,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_tiporegistro')) . "','$this->si119_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_codreduzido"]) || $this->si119_codreduzido != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2010801,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_codreduzido')) . "','$this->si119_codreduzido'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_codfontrecursos"]) || $this->si119_codfontrecursos != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2010802,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_codfontrecursos')) . "','$this->si119_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_valorfonte"]) || $this->si119_valorfonte != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2010803,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_valorfonte')) . "','$this->si119_valorfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_mes"]) || $this->si119_mes != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2010804,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_mes')) . "','$this->si119_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_reg10"]) || $this->si119_reg10 != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2010805,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_reg10')) . "','$this->si119_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si119_instit"]) || $this->si119_instit != "") {
          $resac = db_query("insert into db_acount values($acount,2010348,2011632,'" . AddSlashes(pg_result($resaco, $conresaco, 'si119_instit')) . "','$this->si119_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "lqd112020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si119_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lqd112020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si119_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si119_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si119_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si119_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010799,'$si119_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010348,2010799,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010348,2010800,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010348,2010801,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_codreduzido')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010348,2010802,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010348,2010803,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_valorfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010348,2010804,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010348,2010805,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010348,2011632,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si119_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from lqd112020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si119_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si119_sequencial = $si119_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "lqd112020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si119_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "lqd112020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si119_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si119_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:lqd112020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si119_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lqd112020 ";
    $sql .= "      left  join lqd102020  on  lqd102020.si118_sequencial = lqd112020.si119_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si119_sequencial != null) {
        $sql2 .= " where lqd112020.si119_sequencial = $si119_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
  function sql_query_file($si119_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from lqd112020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si119_sequencial != null) {
        $sql2 .= " where lqd112020.si119_sequencial = $si119_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
