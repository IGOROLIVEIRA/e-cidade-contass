<?
//MODULO: sicom
//CLASSE DA ENTIDADE rsp112020
class cl_rsp112020
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
  var $si113_sequencial = 0;
  var $si113_tiporegistro = 0;
  var $si113_codreduzidorsp = 0;
  var $si113_codfontrecursos = 0;
  var $si113_vloriginalfonte = 0;
  var $si113_vlsaldoantprocefonte = 0;
  var $si113_vlsaldoantnaoprocfonte = 0;
  var $si113_mes = 0;
  var $si113_reg10 = 0;
  var $si113_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si113_sequencial = int8 = sequencial 
                 si113_tiporegistro = int8 = Tipo do  registro 
                 si113_codreduzidorsp = int8 = Código Identificador do resto a pagar 
                 si113_codfontrecursos = int8 = Código da fonte de  recursos 
                 si113_vloriginalfonte = float8 = Valor original do  empenho 
                 si113_vlsaldoantprocefonte = float8 = Valor do Saldo do  empenho 
                 si113_vlsaldoantnaoprocfonte = float8 = Valor do Saldo do  empenho 
                 si113_mes = int8 = Mês 
                 si113_reg10 = int8 = reg10 
                 si113_instit = int8 = Instituição 
                 ";
  
  //funcao construtor da classe
  function cl_rsp112020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rsp112020");
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
      $this->si113_sequencial = ($this->si113_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_sequencial"] : $this->si113_sequencial);
      $this->si113_tiporegistro = ($this->si113_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_tiporegistro"] : $this->si113_tiporegistro);
      $this->si113_codreduzidorsp = ($this->si113_codreduzidorsp == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_codreduzidorsp"] : $this->si113_codreduzidorsp);
      $this->si113_codfontrecursos = ($this->si113_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_codfontrecursos"] : $this->si113_codfontrecursos);
      $this->si113_vloriginalfonte = ($this->si113_vloriginalfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_vloriginalfonte"] : $this->si113_vloriginalfonte);
      $this->si113_vlsaldoantprocefonte = ($this->si113_vlsaldoantprocefonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantprocefonte"] : $this->si113_vlsaldoantprocefonte);
      $this->si113_vlsaldoantnaoprocfonte = ($this->si113_vlsaldoantnaoprocfonte == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantnaoprocfonte"] : $this->si113_vlsaldoantnaoprocfonte);
      $this->si113_mes = ($this->si113_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_mes"] : $this->si113_mes);
      $this->si113_reg10 = ($this->si113_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_reg10"] : $this->si113_reg10);
      $this->si113_instit = ($this->si113_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_instit"] : $this->si113_instit);
    } else {
      $this->si113_sequencial = ($this->si113_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si113_sequencial"] : $this->si113_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si113_sequencial)
  {
    $this->atualizacampos();
    if ($this->si113_tiporegistro == null) {
      $this->erro_sql = " Campo Tipo do  registro nao Informado.";
      $this->erro_campo = "si113_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si113_codreduzidorsp == null) {
      $this->si113_codreduzidorsp = "0";
    }
    if ($this->si113_codfontrecursos == null) {
      $this->si113_codfontrecursos = "0";
    }
    if ($this->si113_vloriginalfonte == null) {
      $this->si113_vloriginalfonte = "0";
    }
    if ($this->si113_vlsaldoantprocefonte == null) {
      $this->si113_vlsaldoantprocefonte = "0";
    }
    if ($this->si113_vlsaldoantnaoprocfonte == null) {
      $this->si113_vlsaldoantnaoprocfonte = "0";
    }
    if ($this->si113_mes == null) {
      $this->erro_sql = " Campo Mês nao Informado.";
      $this->erro_campo = "si113_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si113_reg10 == null) {
      $this->si113_reg10 = "0";
    }
    if ($this->si113_instit == null) {
      $this->erro_sql = " Campo Instituição nao Informado.";
      $this->erro_campo = "si113_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si113_sequencial == "" || $si113_sequencial == null) {
      $result = db_query("select nextval('rsp112020_si113_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: rsp112020_si113_sequencial_seq do campo: si113_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si113_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from rsp112020_si113_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si113_sequencial)) {
        $this->erro_sql = " Campo si113_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si113_sequencial = $si113_sequencial;
      }
    }
    if (($this->si113_sequencial == null) || ($this->si113_sequencial == "")) {
      $this->erro_sql = " Campo si113_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into rsp112020(
                                       si113_sequencial 
                                      ,si113_tiporegistro 
                                      ,si113_codreduzidorsp 
                                      ,si113_codfontrecursos 
                                      ,si113_vloriginalfonte 
                                      ,si113_vlsaldoantprocefonte 
                                      ,si113_vlsaldoantnaoprocfonte 
                                      ,si113_mes 
                                      ,si113_reg10 
                                      ,si113_instit 
                       )
                values (
                                $this->si113_sequencial 
                               ,$this->si113_tiporegistro 
                               ,$this->si113_codreduzidorsp 
                               ,$this->si113_codfontrecursos 
                               ,$this->si113_vloriginalfonte 
                               ,$this->si113_vlsaldoantprocefonte 
                               ,$this->si113_vlsaldoantnaoprocfonte 
                               ,$this->si113_mes 
                               ,$this->si113_reg10 
                               ,$this->si113_instit 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "rsp112020 ($this->si113_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "rsp112020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "rsp112020 ($this->si113_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si113_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $resaco = $this->sql_record($this->sql_query_file($this->si113_sequencial));
    if (($resaco != false) || ($this->numrows != 0)) {
      $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
      $acount = pg_result($resac, 0, 0);
      $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
      $resac = db_query("insert into db_acountkey values($acount,2010735,'$this->si113_sequencial','I')");
      $resac = db_query("insert into db_acount values($acount,2010342,2010735,'','" . AddSlashes(pg_result($resaco, 0, 'si113_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010736,'','" . AddSlashes(pg_result($resaco, 0, 'si113_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010737,'','" . AddSlashes(pg_result($resaco, 0, 'si113_codreduzidorsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010738,'','" . AddSlashes(pg_result($resaco, 0, 'si113_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010739,'','" . AddSlashes(pg_result($resaco, 0, 'si113_vloriginalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010740,'','" . AddSlashes(pg_result($resaco, 0, 'si113_vlsaldoantprocefonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010741,'','" . AddSlashes(pg_result($resaco, 0, 'si113_vlsaldoantnaoprocfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010742,'','" . AddSlashes(pg_result($resaco, 0, 'si113_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2010743,'','" . AddSlashes(pg_result($resaco, 0, 'si113_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      $resac = db_query("insert into db_acount values($acount,2010342,2011626,'','" . AddSlashes(pg_result($resaco, 0, 'si113_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si113_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update rsp112020 set ";
    $virgula = "";
    if (trim($this->si113_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_sequencial"])) {
      if (trim($this->si113_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si113_sequencial"])) {
        $this->si113_sequencial = "0";
      }
      $sql .= $virgula . " si113_sequencial = $this->si113_sequencial ";
      $virgula = ",";
    }
    if (trim($this->si113_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_tiporegistro"])) {
      $sql .= $virgula . " si113_tiporegistro = $this->si113_tiporegistro ";
      $virgula = ",";
      if (trim($this->si113_tiporegistro) == null) {
        $this->erro_sql = " Campo Tipo do  registro nao Informado.";
        $this->erro_campo = "si113_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si113_codreduzidorsp) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_codreduzidorsp"])) {
      if (trim($this->si113_codreduzidorsp) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si113_codreduzidorsp"])) {
        $this->si113_codreduzidorsp = "0";
      }
      $sql .= $virgula . " si113_codreduzidorsp = $this->si113_codreduzidorsp ";
      $virgula = ",";
    }
    if (trim($this->si113_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_codfontrecursos"])) {
      if (trim($this->si113_codfontrecursos) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si113_codfontrecursos"])) {
        $this->si113_codfontrecursos = "0";
      }
      $sql .= $virgula . " si113_codfontrecursos = $this->si113_codfontrecursos ";
      $virgula = ",";
    }
    if (trim($this->si113_vloriginalfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_vloriginalfonte"])) {
      if (trim($this->si113_vloriginalfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si113_vloriginalfonte"])) {
        $this->si113_vloriginalfonte = "0";
      }
      $sql .= $virgula . " si113_vloriginalfonte = $this->si113_vloriginalfonte ";
      $virgula = ",";
    }
    if (trim($this->si113_vlsaldoantprocefonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantprocefonte"])) {
      if (trim($this->si113_vlsaldoantprocefonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantprocefonte"])) {
        $this->si113_vlsaldoantprocefonte = "0";
      }
      $sql .= $virgula . " si113_vlsaldoantprocefonte = $this->si113_vlsaldoantprocefonte ";
      $virgula = ",";
    }
    if (trim($this->si113_vlsaldoantnaoprocfonte) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantnaoprocfonte"])) {
      if (trim($this->si113_vlsaldoantnaoprocfonte) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantnaoprocfonte"])) {
        $this->si113_vlsaldoantnaoprocfonte = "0";
      }
      $sql .= $virgula . " si113_vlsaldoantnaoprocfonte = $this->si113_vlsaldoantnaoprocfonte ";
      $virgula = ",";
    }
    if (trim($this->si113_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_mes"])) {
      $sql .= $virgula . " si113_mes = $this->si113_mes ";
      $virgula = ",";
      if (trim($this->si113_mes) == null) {
        $this->erro_sql = " Campo Mês nao Informado.";
        $this->erro_campo = "si113_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si113_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_reg10"])) {
      if (trim($this->si113_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si113_reg10"])) {
        $this->si113_reg10 = "0";
      }
      $sql .= $virgula . " si113_reg10 = $this->si113_reg10 ";
      $virgula = ",";
    }
    if (trim($this->si113_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si113_instit"])) {
      $sql .= $virgula . " si113_instit = $this->si113_instit ";
      $virgula = ",";
      if (trim($this->si113_instit) == null) {
        $this->erro_sql = " Campo Instituição nao Informado.";
        $this->erro_campo = "si113_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si113_sequencial != null) {
      $sql .= " si113_sequencial = $this->si113_sequencial";
    }
    $resaco = $this->sql_record($this->sql_query_file($this->si113_sequencial));
    if ($this->numrows > 0) {
      for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010735,'$this->si113_sequencial','A')");
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_sequencial"]) || $this->si113_sequencial != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010735,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_sequencial')) . "','$this->si113_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_tiporegistro"]) || $this->si113_tiporegistro != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010736,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_tiporegistro')) . "','$this->si113_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_codreduzidorsp"]) || $this->si113_codreduzidorsp != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010737,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_codreduzidorsp')) . "','$this->si113_codreduzidorsp'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_codfontrecursos"]) || $this->si113_codfontrecursos != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010738,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_codfontrecursos')) . "','$this->si113_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_vloriginalfonte"]) || $this->si113_vloriginalfonte != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010739,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_vloriginalfonte')) . "','$this->si113_vloriginalfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantprocefonte"]) || $this->si113_vlsaldoantprocefonte != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010740,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_vlsaldoantprocefonte')) . "','$this->si113_vlsaldoantprocefonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_vlsaldoantnaoprocfonte"]) || $this->si113_vlsaldoantnaoprocfonte != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010741,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_vlsaldoantnaoprocfonte')) . "','$this->si113_vlsaldoantnaoprocfonte'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_mes"]) || $this->si113_mes != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010742,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_mes')) . "','$this->si113_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_reg10"]) || $this->si113_reg10 != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2010743,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_reg10')) . "','$this->si113_reg10'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
        if (isset($GLOBALS["HTTP_POST_VARS"]["si113_instit"]) || $this->si113_instit != "") {
          $resac = db_query("insert into db_acount values($acount,2010342,2011626,'" . AddSlashes(pg_result($resaco, $conresaco, 'si113_instit')) . "','$this->si113_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "rsp112020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si113_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp112020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si113_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si113_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si113_sequencial = null, $dbwhere = null)
  {
    if ($dbwhere == null || $dbwhere == "") {
      $resaco = $this->sql_record($this->sql_query_file($si113_sequencial));
    } else {
      $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
    }
    if (($resaco != false) || ($this->numrows != 0)) {
      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2010735,'$si113_sequencial','E')");
        $resac = db_query("insert into db_acount values($acount,2010342,2010735,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010736,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010737,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_codreduzidorsp')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010738,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010739,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_vloriginalfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010740,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_vlsaldoantprocefonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010741,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_vlsaldoantnaoprocfonte')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010742,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2010743,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_reg10')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,2010342,2011626,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si113_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      }
    }
    $sql = " delete from rsp112020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si113_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si113_sequencial = $si113_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "rsp112020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si113_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "rsp112020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si113_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si113_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:rsp112020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si113_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from rsp112020 ";
    $sql .= "      left  join rsp102020  on  rsp102020.si112_sequencial = rsp112020.si113_reg10";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si113_sequencial != null) {
        $sql2 .= " where rsp112020.si113_sequencial = $si113_sequencial ";
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
  function sql_query_file($si113_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from rsp112020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si113_sequencial != null) {
        $sql2 .= " where rsp112020.si113_sequencial = $si113_sequencial ";
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
