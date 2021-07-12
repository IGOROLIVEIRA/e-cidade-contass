<?
//MODULO: sicom
//CLASSE DA ENTIDADE ctb402017
class cl_ctb402017
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
  var $si101_sequencial = 0;
  var $si101_tiporegistro = 0;
  var $si101_codorgao = null;
  var $si101_codctb = 0;
  var $si101_desccontabancaria = null;
  var $si101_mes = 0;
  var $si101_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si101_sequencial = int8 = sequencial 
                 si101_tiporegistro = int8 = Tipo do registro 
                 si101_codorgao = varchar(2) = Código do órgão 
                 si101_codctb = int8 = Código Identificador da Conta Bancária 
                 si101_desccontabancaria = varchar(50) = Nome da Conta  Bancária 
                 si101_mes = int8 = Mês 
                 si101_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_ctb402017()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("ctb402017");
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
      $this->si101_sequencial = ($this->si101_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_sequencial"] : $this->si101_sequencial);
      $this->si101_tiporegistro = ($this->si101_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_tiporegistro"] : $this->si101_tiporegistro);
      $this->si101_codorgao = ($this->si101_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_codorgao"] : $this->si101_codorgao);
      $this->si101_codctb = ($this->si101_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_codctb"] : $this->si101_codctb);
      $this->si101_desccontabancaria = ($this->si101_desccontabancaria == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_desccontabancaria"] : $this->si101_desccontabancaria);
      $this->si101_mes = ($this->si101_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_mes"] : $this->si101_mes);
      $this->si101_instit = ($this->si101_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_instit"] : $this->si101_instit);
    } else {
      $this->si101_sequencial = ($this->si101_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si101_sequencial"] : $this->si101_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si101_sequencial)
  {
    $this->atualizacampos();
    if ($this->si101_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do registro nao Informado.";
      $this->erro_campo = "si101_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si101_codctb == null) {
      $this->si101_codctb = "0";
    }
    if ($this->si101_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si101_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si101_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si101_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si101_sequencial == "" || $si101_sequencial == null) {
      $result = db_query("select nextval('ctb402017_si101_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: ctb402017_si101_sequencial_seq do campo: si101_sequencial";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si101_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from ctb402017_si101_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si101_sequencial)) {
        $this->erro_sql = " Campo si101_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si101_sequencial = $si101_sequencial;
      }
    }
    if (($this->si101_sequencial == null) || ($this->si101_sequencial == "")) {
      $this->erro_sql = " Campo si101_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into ctb402017(
                                       si101_sequencial 
                                      ,si101_tiporegistro 
                                      ,si101_codorgao 
                                      ,si101_codctb 
                                      ,si101_desccontabancaria 
                                      ,si101_mes 
                                      ,si101_instit 
                       )
                values (
                                $this->si101_sequencial 
                               ,$this->si101_tiporegistro 
                               ,'$this->si101_codorgao' 
                               ,$this->si101_codctb 
                               ,'$this->si101_desccontabancaria' 
                               ,$this->si101_mes 
                               ,$this->si101_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "ctb402017 ($this->si101_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_banco = "ctb402017 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      } else {
        $this->erro_sql = "ctb402017 ($this->si101_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_sql .= "Valores : " . $this->si101_sequencial;
    $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si101_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010606,'$this->si101_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010330,2010606,'','" . AddSlashes(pg_result($resaco, 0, 'si101_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010330,2010607,'','" . AddSlashes(pg_result($resaco, 0, 'si101_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010330,2011325,'','" . AddSlashes(pg_result($resaco, 0, 'si101_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010330,2010608,'','" . AddSlashes(pg_result($resaco, 0, 'si101_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010330,2010609,'','" . AddSlashes(pg_result($resaco, 0, 'si101_desccontabancaria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010330,2010610,'','" . AddSlashes(pg_result($resaco, 0, 'si101_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010330,2011614,'','" . AddSlashes(pg_result($resaco, 0, 'si101_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si101_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update ctb402017 set ";
    $virgula = "";
    if (trim($this->si101_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_sequencial"])) {
      if (trim($this->si101_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si101_sequencial"])) {
        $this->si101_sequencial = "0";
      }
      $sql .= $virgula . " si101_sequencial = $this->si101_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si101_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_tiporegistro"])) {
      $sql .= $virgula . " si101_tiporegistro = $this->si101_tiporegistro ";
      $virgula = ",";
      if (trim($this->si101_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do registro nao Informado.";
        $this->erro_campo = "si101_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si101_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_codorgao"])) {
      $sql .= $virgula . " si101_codorgao = '$this->si101_codorgao' ";
      $virgula = ",";
    }
    if (trim($this->si101_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_codctb"])) {
      if (trim($this->si101_codctb) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si101_codctb"])) {
        $this->si101_codctb = "0";
      }
      $sql .= $virgula . " si101_codctb = $this->si101_codctb ";
      $virgula = ",";
    }
    if (trim($this->si101_desccontabancaria) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_desccontabancaria"])) {
      $sql .= $virgula . " si101_desccontabancaria = '$this->si101_desccontabancaria' ";
      $virgula = ",";
    }
    if (trim($this->si101_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_mes"])) {
      $sql .= $virgula . " si101_mes = $this->si101_mes ";
      $virgula = ",";
      if (trim($this->si101_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si101_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si101_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si101_instit"])) {
      $sql .= $virgula . " si101_instit = $this->si101_instit ";
      $virgula = ",";
      if (trim($this->si101_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si101_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si101_sequencial != null) {
      $sql .= " si101_sequencial = $this->si101_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si101_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010606,'$this->si101_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si101_sequencial"]) || $this->si101_sequencial != "") {
          $resac = db_query("insert into db_acount values($acount,2010330,2010606,'" . AddSlashes(pg_result($resaco, $conresaco, 'si101_sequencial')) . "','$this->si101_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si101_tiporegistro"]) || $this->si101_tiporegistro != "") {
          $resac = db_query("insert into db_acount values($acount,2010330,2010607,'" . AddSlashes(pg_result($resaco, $conresaco, 'si101_tiporegistro')) . "','$this->si101_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si101_codorgao"]) || $this->si101_codorgao != "") {
          $resac = db_query("insert into db_acount values($acount,2010330,2011325,'" . AddSlashes(pg_result($resaco, $conresaco, 'si101_codorgao')) . "','$this->si101_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si101_codctb"]) || $this->si101_codctb != "") {
          $resac = db_query("insert into db_acount values($acount,2010330,2010608,'" . AddSlashes(pg_result($resaco, $conresaco, 'si101_codctb')) . "','$this->si101_codctb'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si101_desccontabancaria"]) || $this->si101_desccontabancaria != "") {
          $resac = db_query("insert into db_acount values($acount,2010330,2010609,'" . AddSlashes(pg_result($resaco, $conresaco, 'si101_desccontabancaria')) . "','$this->si101_desccontabancaria'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si101_mes"]) || $this->si101_mes != "") {
          $resac = db_query("insert into db_acount values($acount,2010330,2010610,'" . AddSlashes(pg_result($resaco, $conresaco, 'si101_mes')) . "','$this->si101_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si101_instit"]) || $this->si101_instit != "") {
          $resac = db_query("insert into db_acount values($acount,2010330,2011614,'" . AddSlashes(pg_result($resaco, $conresaco, 'si101_instit')) . "','$this->si101_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "ctb402017 nao Alterado. Alteracao Abortada.\\n";
      $this->erro_sql .= "Valores : " . $this->si101_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ctb402017 nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_sql .= "Valores : " . $this->si101_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $this->si101_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si101_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si101_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010606,'$si101_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010330,2010606,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si101_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010330,2010607,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si101_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010330,2011325,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si101_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010330,2010608,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si101_codctb')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010330,2010609,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si101_desccontabancaria')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010330,2010610,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si101_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010330,2011614,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si101_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from ctb402017
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si101_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si101_sequencial = $si101_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("\n", "", @pg_last_error());
      $this->erro_sql = "ctb402017 nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : " . $si101_sequencial;
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "ctb402017 nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : " . $si101_sequencial;
        $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : " . $si101_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:ctb402017";
      $this->erro_msg = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si101_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ctb402017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si101_sequencial != null) {
        $sql2 .= " where ctb402017.si101_sequencial = $si101_sequencial ";
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
  function sql_query_file($si101_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from ctb402017 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si101_sequencial != null) {
        $sql2 .= " where ctb402017.si101_sequencial = $si101_sequencial ";
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
