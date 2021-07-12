<?
//MODULO: sicom
//CLASSE DA ENTIDADE rsp122021
class cl_rsp122021
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
  var $si114_sequencial = 0;
  var $si114_tiporegistro = 0;
  var $si114_codreduzidorsp = 0;
  var $si114_tipodocumento = 0;
  var $si114_nrodocumento = null;
  var $si114_mes = 0;
  var $si114_reg10 = 0;
  var $si114_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si114_sequencial = int8 = sequencial 
                 si114_tiporegistro = int8 = Tipo do  registro 
                 si114_codreduzidorsp = int8 = Código Identificador do resto a pagar 
                 si114_tipodocumento = int8 = Tipo de  Documento do  credor 
                 si114_nrodocumento = varchar(14) = Número do documento do credor 
                 si114_mes = int8 = Mês 
                 si114_reg10 = int8 = reg10 
                 si114_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_rsp122021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rsp122021");
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
      $this->si114_sequencial = ($this->si114_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_sequencial"] : $this->si114_sequencial);
      $this->si114_tiporegistro = ($this->si114_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_tiporegistro"] : $this->si114_tiporegistro);
      $this->si114_codreduzidorsp = ($this->si114_codreduzidorsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_codreduzidorsp"] : $this->si114_codreduzidorsp);
      $this->si114_tipodocumento = ($this->si114_tipodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_tipodocumento"] : $this->si114_tipodocumento);
      $this->si114_nrodocumento = ($this->si114_nrodocumento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_nrodocumento"] : $this->si114_nrodocumento);
      $this->si114_mes = ($this->si114_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_mes"] : $this->si114_mes);
      $this->si114_reg10 = ($this->si114_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_reg10"] : $this->si114_reg10);
      $this->si114_instit = ($this->si114_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_instit"] : $this->si114_instit);
    } else {
      $this->si114_sequencial = ($this->si114_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si114_sequencial"] : $this->si114_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si114_sequencial)
  {
    $this->atualizacampos();
    if ($this->si114_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si114_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si114_codreduzidorsp == null) {
      $this->si114_codreduzidorsp = "0";
    }
    if ($this->si114_tipodocumento == null) {
      $this->si114_tipodocumento = "0";
    }
    if ($this->si114_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si114_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si114_reg10 == null) {
      $this->si114_reg10 = "0";
    }
    if ($this->si114_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si114_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si114_sequencial == "" || $si114_sequencial == null) {
      $result = db_query("select nextval('rsp122021_si114_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: rsp122021_si114_sequencial_seq do campo: si114_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si114_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from rsp122021_si114_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si114_sequencial)) {
        $this->erro_sql = " Campo si114_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si114_sequencial = $si114_sequencial;
      }
    }
    if (($this->si114_sequencial == null) || ($this->si114_sequencial == "")) {
      $this->erro_sql = " Campo si114_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into rsp122021(
                                       si114_sequencial 
                                      ,si114_tiporegistro 
                                      ,si114_codreduzidorsp 
                                      ,si114_tipodocumento 
                                      ,si114_nrodocumento 
                                      ,si114_mes 
                                      ,si114_reg10 
                                      ,si114_instit 
                       )
                values (
                                $this->si114_sequencial 
                               ,$this->si114_tiporegistro 
                               ,$this->si114_codreduzidorsp 
                               ,$this->si114_tipodocumento 
                               ,'$this->si114_nrodocumento' 
                               ,$this->si114_mes 
                               ,$this->si114_reg10 
                               ,$this->si114_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "rsp122021 ($this->si114_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "rsp122021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "rsp122021 ($this->si114_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si114_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si114_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010744,'$this->si114_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010343,2010744,'','" . AddSlashes(pg_result($resaco, 0, 'si114_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010343,2010745,'','" . AddSlashes(pg_result($resaco, 0, 'si114_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010343,2010746,'','" . AddSlashes(pg_result($resaco, 0, 'si114_codreduzidorsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010343,2010747,'','" . AddSlashes(pg_result($resaco, 0, 'si114_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010343,2010748,'','" . AddSlashes(pg_result($resaco, 0, 'si114_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010343,2010749,'','" . AddSlashes(pg_result($resaco, 0, 'si114_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010343,2010750,'','" . AddSlashes(pg_result($resaco, 0, 'si114_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010343,2011627,'','" . AddSlashes(pg_result($resaco, 0, 'si114_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si114_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update rsp122021 set ";
    $virgula = "";
    if (trim($this->si114_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_sequencial"])) {
      if (trim($this->si114_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si114_sequencial"])) {
        $this->si114_sequencial = "0";
      }
      $sql .= $virgula . " si114_sequencial = $this->si114_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si114_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_tiporegistro"])) {
      $sql .= $virgula . " si114_tiporegistro = $this->si114_tiporegistro ";
      $virgula = ",";
      if (trim($this->si114_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si114_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si114_codreduzidorsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_codreduzidorsp"])) {
      if (trim($this->si114_codreduzidorsp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si114_codreduzidorsp"])) {
        $this->si114_codreduzidorsp = "0";
      }
      $sql .= $virgula . " si114_codreduzidorsp = $this->si114_codreduzidorsp ";
      $virgula = ",";
    }
    if (trim($this->si114_tipodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_tipodocumento"])) {
      if (trim($this->si114_tipodocumento) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si114_tipodocumento"])) {
        $this->si114_tipodocumento = "0";
      }
      $sql .= $virgula . " si114_tipodocumento = $this->si114_tipodocumento ";
      $virgula = ",";
    }
    if (trim($this->si114_nrodocumento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_nrodocumento"])) {
      $sql .= $virgula . " si114_nrodocumento = '$this->si114_nrodocumento' ";
      $virgula = ",";
    }
    if (trim($this->si114_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_mes"])) {
      $sql .= $virgula . " si114_mes = $this->si114_mes ";
      $virgula = ",";
      if (trim($this->si114_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si114_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si114_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_reg10"])) {
      if (trim($this->si114_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si114_reg10"])) {
        $this->si114_reg10 = "0";
      }
      $sql .= $virgula . " si114_reg10 = $this->si114_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si114_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si114_instit"])) {
      $sql .= $virgula . " si114_instit = $this->si114_instit ";
      $virgula = ",";
      if (trim($this->si114_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si114_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si114_sequencial != null) {
      $sql .= " si114_sequencial = $this->si114_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si114_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010744,'$this->si114_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_sequencial"]) || $this->si114_sequencial != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2010744,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_sequencial')) . "','$this->si114_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_tiporegistro"]) || $this->si114_tiporegistro != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2010745,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_tiporegistro')) . "','$this->si114_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_codreduzidorsp"]) || $this->si114_codreduzidorsp != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2010746,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_codreduzidorsp')) . "','$this->si114_codreduzidorsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_tipodocumento"]) || $this->si114_tipodocumento != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2010747,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_tipodocumento')) . "','$this->si114_tipodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_nrodocumento"]) || $this->si114_nrodocumento != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2010748,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_nrodocumento')) . "','$this->si114_nrodocumento'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_mes"]) || $this->si114_mes != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2010749,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_mes')) . "','$this->si114_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_reg10"]) || $this->si114_reg10 != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2010750,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_reg10')) . "','$this->si114_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si114_instit"]) || $this->si114_instit != "") {
          $resac = db_query("insert into db_acount values($acount,2010343,2011627,'" . AddSlashes(pg_result($resaco, $conresaco, 'si114_instit')) . "','$this->si114_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "rsp122021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si114_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp122021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si114_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si114_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si114_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si114_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010744,'$si114_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010343,2010744,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010343,2010745,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010343,2010746,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_codreduzidorsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010343,2010747,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_tipodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010343,2010748,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_nrodocumento')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010343,2010749,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010343,2010750,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010343,2011627,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si114_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from rsp122021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si114_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si114_sequencial = $si114_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "rsp122021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si114_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp122021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si114_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si114_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:rsp122021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si114_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from rsp122021 ";
    $sql .= "      left  join rsp102020  on  rsp102020.si112_sequencial = rsp122021.si114_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si114_sequencial != null) {
        $sql2 .= " where rsp122021.si114_sequencial = $si114_sequencial ";
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
  function sql_query_file($si114_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from rsp122021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si114_sequencial != null) {
        $sql2 .= " where rsp122021.si114_sequencial = $si114_sequencial ";
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
