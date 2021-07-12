<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete152019
class cl_balancete152019
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
  var $si182_sequencial = 0;
  var $si182_tiporegistro = 0;
  var $si182_contacontabil = 0;
  var $si182_codfundo = null;
  var $si182_atributosf = null;
  var $si182_saldoinicialsf = 0;
  var $si182_naturezasaldoinicialsf = null;
  var $si182_totaldebitossf = 0;
  var $si182_totalcreditossf = 0;
  var $si182_saldofinalsf = 0;
  var $si182_naturezasaldofinalsf = null;
  var $si182_mes = 0;
  var $si182_instit = 0;
  var $si182_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si182_sequencial = int8 = si182_sequencial 
                 si182_tiporegistro = int8 = si182_tiporegistro 
                 si182_contacontabil = int8 = si182_contacontabil 
                 si182_codfundo = varchar(8) = si182_codfundo 
                 si182_atributosf = varchar(1) = si182_atributosf 
                 si182_saldoinicialsf = float8 = si182_saldoinicialsf 
                 si182_naturezasaldoinicialsf = varchar(1) = si182_naturezasaldoinicialsf 
                 si182_totaldebitossf = float8 = si182_totaldebitossf 
                 si182_totalcreditossf = float8 = si182_totalcreditossf 
                 si182_saldofinalsf = float8 = si182_saldofinalsf 
                 si182_naturezasaldofinalsf = varchar(1) = si182_naturezasaldofinalsf 
                 si182_mes = int8 = si182_mes 
                 si182_instit = int8 = si182_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete152019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete152019");
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
      $this->si182_sequencial = ($this->si182_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_sequencial"] : $this->si182_sequencial);
      $this->si182_tiporegistro = ($this->si182_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"] : $this->si182_tiporegistro);
      $this->si182_contacontabil = ($this->si182_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_contacontabil"] : $this->si182_contacontabil);
      $this->si182_codfundo = ($this->si182_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_codfundo"] : $this->si182_codfundo);
      $this->si182_atributosf = ($this->si182_atributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_atributosf"] : $this->si182_atributosf);
      $this->si182_saldoinicialsf = ($this->si182_saldoinicialsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_saldoinicialsf"] : $this->si182_saldoinicialsf);
      $this->si182_naturezasaldoinicialsf = ($this->si182_naturezasaldoinicialsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_naturezasaldoinicialsf"] : $this->si182_naturezasaldoinicialsf);
      $this->si182_totaldebitossf = ($this->si182_totaldebitossf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_totaldebitossf"] : $this->si182_totaldebitossf);
      $this->si182_totalcreditossf = ($this->si182_totalcreditossf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_totalcreditossf"] : $this->si182_totalcreditossf);
      $this->si182_saldofinalsf = ($this->si182_saldofinalsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_saldofinalsf"] : $this->si182_saldofinalsf);
      $this->si182_naturezasaldofinalsf = ($this->si182_naturezasaldofinalsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_naturezasaldofinalsf"] : $this->si182_naturezasaldofinalsf);
      $this->si182_mes = ($this->si182_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_mes"] : $this->si182_mes);
      $this->si182_instit = ($this->si182_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_instit"] : $this->si182_instit);
    } else {
      $this->si182_sequencial = ($this->si182_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si182_sequencial"] : $this->si182_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si182_sequencial)
  {
    $this->atualizacampos();
    if ($this->si182_tiporegistro == null) {
      $this->erro_sql = " Campo si182_tiporegistro não informado.";
      $this->erro_campo = "si182_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_contacontabil == null) {
      $this->erro_sql = " Campo si182_contacontabil não informado.";
      $this->erro_campo = "si182_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    if ($this->si182_atributosf == null) {
      $this->erro_sql = " Campo si182_atributosf não informado.";
      $this->erro_campo = "si182_atributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    if ($this->si182_saldoinicialsf == null) {
      $this->erro_sql = " Campo si182_saldoinicialsf não informado.";
      $this->erro_campo = "si182_saldoinicialsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_naturezasaldoinicialsf == null) {
      $this->erro_sql = " Campo si182_naturezasaldoinicialsf não informado.";
      $this->erro_campo = "si182_naturezasaldoinicialsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_totaldebitossf == null) {
      $this->erro_sql = " Campo si182_totaldebitossf não informado.";
      $this->erro_campo = "si182_totaldebitossf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_totalcreditossf == null) {
      $this->erro_sql = " Campo si182_totalcreditossf não informado.";
      $this->erro_campo = "si182_totalcreditossf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_saldofinalsf == null) {
      $this->erro_sql = " Campo si182_saldofinalsf não informado.";
      $this->erro_campo = "si182_saldofinalsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_naturezasaldofinalsf == null) {
      $this->erro_sql = " Campo si182_naturezasaldofinalsf não informado.";
      $this->erro_campo = "si182_naturezasaldofinalsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_mes == null) {
      $this->erro_sql = " Campo si182_mes não informado.";
      $this->erro_campo = "si182_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si182_instit == null) {
      $this->erro_sql = " Campo si182_instit não informado.";
      $this->erro_campo = "si182_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    if ($si182_sequencial == "" || $si182_sequencial == null) {
      $result = db_query("select nextval('balancete152019_si182_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete152019_si182_sequencial_seq do campo: si182_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si182_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete152019_si182_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si182_sequencial)) {
        $this->erro_sql = " Campo si182_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si182_sequencial = $si182_sequencial;
      }
    }
    if (($this->si182_sequencial == null) || ($this->si182_sequencial == "")) {
      $this->erro_sql = " Campo si182_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete152019(
                                       si182_sequencial 
                                      ,si182_tiporegistro 
                                      ,si182_contacontabil 
                                      ,si182_codfundo
                                      ,si182_atributosf 
                                      ,si182_saldoinicialsf 
                                      ,si182_naturezasaldoinicialsf 
                                      ,si182_totaldebitossf 
                                      ,si182_totalcreditossf 
                                      ,si182_saldofinalsf 
                                      ,si182_naturezasaldofinalsf 
                                      ,si182_mes 
                                      ,si182_instit
                                      ,si182_reg10
                       )
                values (
                                $this->si182_sequencial 
                               ,$this->si182_tiporegistro 
                               ,$this->si182_contacontabil 
                               ,'$this->si182_codfundo'
                               ,'$this->si182_atributosf' 
                               ,$this->si182_saldoinicialsf 
                               ,'$this->si182_naturezasaldoinicialsf' 
                               ,$this->si182_totaldebitossf 
                               ,$this->si182_totalcreditossf 
                               ,$this->si182_saldofinalsf 
                               ,'$this->si182_naturezasaldofinalsf' 
                               ,$this->si182_mes 
                               ,$this->si182_instit
                               ,$this->si182_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete152019 ($this->si182_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete152019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete152019 ($this->si182_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si182_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si182_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si182_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010197,2011784,'','".AddSlashes(pg_result($resaco,0,'si182_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011785,'','".AddSlashes(pg_result($resaco,0,'si182_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011786,'','".AddSlashes(pg_result($resaco,0,'si182_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011787,'','".AddSlashes(pg_result($resaco,0,'si182_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011788,'','".AddSlashes(pg_result($resaco,0,'si182_saldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011789,'','".AddSlashes(pg_result($resaco,0,'si182_naturezasaldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011790,'','".AddSlashes(pg_result($resaco,0,'si182_totaldebitossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011791,'','".AddSlashes(pg_result($resaco,0,'si182_totalcreditossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011792,'','".AddSlashes(pg_result($resaco,0,'si182_saldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011793,'','".AddSlashes(pg_result($resaco,0,'si182_naturezasaldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011794,'','".AddSlashes(pg_result($resaco,0,'si182_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010197,2011795,'','".AddSlashes(pg_result($resaco,0,'si182_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si182_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete152019 set ";
    $virgula = "";
    if (trim($this->si182_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_sequencial"])) {
      $sql .= $virgula . " si182_sequencial = $this->si182_sequencial ";
      $virgula = ",";
      if (trim($this->si182_sequencial) == null) {
        $this->erro_sql = " Campo si182_sequencial não informado.";
        $this->erro_campo = "si182_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"])) {
      $sql .= $virgula . " si182_tiporegistro = $this->si182_tiporegistro ";
      $virgula = ",";
      if (trim($this->si182_tiporegistro) == null) {
        $this->erro_sql = " Campo si182_tiporegistro não informado.";
        $this->erro_campo = "si182_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_contacontabil"])) {
      $sql .= $virgula . " si182_contacontabil = $this->si182_contacontabil ";
      $virgula = ",";
      if (trim($this->si182_contacontabil) == null) {
        $this->erro_sql = " Campo si182_contacontabil não informado.";
        $this->erro_campo = "si182_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_codfundo"])) {
      $sql .= $virgula . " si182_codfundo = '$this->si182_codfundo' ";
      $virgula = ",";
      if (trim($this->si182_codfundo) == null) {
        $this->erro_sql = " Campo si182_codfundo não informado.";
        $this->erro_campo = "si182_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_atributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_atributosf"])) {
      $sql .= $virgula . " si182_atributosf = '$this->si182_atributosf' ";
      $virgula = ",";
      if (trim($this->si182_atributosf) == null) {
        $this->erro_sql = " Campo si182_atributosf não informado.";
        $this->erro_campo = "si182_atributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_saldoinicialsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_saldoinicialsf"])) {
      $sql .= $virgula . " si182_saldoinicialsf = $this->si182_saldoinicialsf ";
      $virgula = ",";
      if (trim($this->si182_saldoinicialsf) == null) {
        $this->erro_sql = " Campo si182_saldoinicialsf não informado.";
        $this->erro_campo = "si182_saldoinicialsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_naturezasaldoinicialsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_naturezasaldoinicialsf"])) {
      $sql .= $virgula . " si182_naturezasaldoinicialsf = '$this->si182_naturezasaldoinicialsf' ";
      $virgula = ",";
      if (trim($this->si182_naturezasaldoinicialsf) == null) {
        $this->erro_sql = " Campo si182_naturezasaldoinicialsf não informado.";
        $this->erro_campo = "si182_naturezasaldoinicialsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_totaldebitossf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_totaldebitossf"])) {
      $sql .= $virgula . " si182_totaldebitossf = $this->si182_totaldebitossf ";
      $virgula = ",";
      if (trim($this->si182_totaldebitossf) == null) {
        $this->erro_sql = " Campo si182_totaldebitossf não informado.";
        $this->erro_campo = "si182_totaldebitossf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_totalcreditossf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_totalcreditossf"])) {
      $sql .= $virgula . " si182_totalcreditossf = $this->si182_totalcreditossf ";
      $virgula = ",";
      if (trim($this->si182_totalcreditossf) == null) {
        $this->erro_sql = " Campo si182_totalcreditossf não informado.";
        $this->erro_campo = "si182_totalcreditossf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_saldofinalsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_saldofinalsf"])) {
      $sql .= $virgula . " si182_saldofinalsf = $this->si182_saldofinalsf ";
      $virgula = ",";
      if (trim($this->si182_saldofinalsf) == null) {
        $this->erro_sql = " Campo si182_saldofinalsf não informado.";
        $this->erro_campo = "si182_saldofinalsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_naturezasaldofinalsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_naturezasaldofinalsf"])) {
      $sql .= $virgula . " si182_naturezasaldofinalsf = '$this->si182_naturezasaldofinalsf' ";
      $virgula = ",";
      if (trim($this->si182_naturezasaldofinalsf) == null) {
        $this->erro_sql = " Campo si182_naturezasaldofinalsf não informado.";
        $this->erro_campo = "si182_naturezasaldofinalsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_mes"])) {
      $sql .= $virgula . " si182_mes = $this->si182_mes ";
      $virgula = ",";
      if (trim($this->si182_mes) == null) {
        $this->erro_sql = " Campo si182_mes não informado.";
        $this->erro_campo = "si182_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si182_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si182_instit"])) {
      $sql .= $virgula . " si182_instit = $this->si182_instit ";
      $virgula = ",";
      if (trim($this->si182_instit) == null) {
        $this->erro_sql = " Campo si182_instit não informado.";
        $this->erro_campo = "si182_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si182_sequencial != null) {
      $sql .= " si182_sequencial = $this->si182_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si182_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,2011784,'$this->si182_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_sequencial"]) || $this->si182_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011784,'".AddSlashes(pg_result($resaco,$conresaco,'si182_sequencial'))."','$this->si182_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_tiporegistro"]) || $this->si182_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011785,'".AddSlashes(pg_result($resaco,$conresaco,'si182_tiporegistro'))."','$this->si182_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_contacontabil"]) || $this->si182_contacontabil != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011786,'".AddSlashes(pg_result($resaco,$conresaco,'si182_contacontabil'))."','$this->si182_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_atributosf"]) || $this->si182_atributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011787,'".AddSlashes(pg_result($resaco,$conresaco,'si182_atributosf'))."','$this->si182_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_saldoinicialsf"]) || $this->si182_saldoinicialsf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011788,'".AddSlashes(pg_result($resaco,$conresaco,'si182_saldoinicialsf'))."','$this->si182_saldoinicialsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_naturezasaldoinicialsf"]) || $this->si182_naturezasaldoinicialsf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011789,'".AddSlashes(pg_result($resaco,$conresaco,'si182_naturezasaldoinicialsf'))."','$this->si182_naturezasaldoinicialsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_totaldebitossf"]) || $this->si182_totaldebitossf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011790,'".AddSlashes(pg_result($resaco,$conresaco,'si182_totaldebitossf'))."','$this->si182_totaldebitossf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_totalcreditossf"]) || $this->si182_totalcreditossf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011791,'".AddSlashes(pg_result($resaco,$conresaco,'si182_totalcreditossf'))."','$this->si182_totalcreditossf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_saldofinalsf"]) || $this->si182_saldofinalsf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011792,'".AddSlashes(pg_result($resaco,$conresaco,'si182_saldofinalsf'))."','$this->si182_saldofinalsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_naturezasaldofinalsf"]) || $this->si182_naturezasaldofinalsf != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011793,'".AddSlashes(pg_result($resaco,$conresaco,'si182_naturezasaldofinalsf'))."','$this->si182_naturezasaldofinalsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_mes"]) || $this->si182_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011794,'".AddSlashes(pg_result($resaco,$conresaco,'si182_mes'))."','$this->si182_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si182_instit"]) || $this->si182_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010197,2011795,'".AddSlashes(pg_result($resaco,$conresaco,'si182_instit'))."','$this->si182_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete152019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si182_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete152019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si182_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si182_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si182_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si182_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011784,'$si182_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011784,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011785,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011786,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011787,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011788,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_saldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011789,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_naturezasaldoinicialsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011790,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_totaldebitossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011791,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_totalcreditossf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011792,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_saldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011793,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_naturezasaldofinalsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011794,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010197,2011795,'','".AddSlashes(pg_result($resaco,$iresaco,'si182_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from balancete152019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si182_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si182_sequencial = $si182_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete152019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si182_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete152019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si182_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si182_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete152019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si182_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete152019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si182_sequencial != null) {
        $sql2 .= " where balancete152019.si182_sequencial = $si182_sequencial ";
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
  function sql_query_file($si182_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete152019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si182_sequencial != null) {
        $sql2 .= " where balancete152019.si182_sequencial = $si182_sequencial ";
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
