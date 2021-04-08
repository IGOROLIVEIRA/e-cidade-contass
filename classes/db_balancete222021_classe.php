<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete222021
class cl_balancete222021
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
  var $si189_sequencial = 0;
  var $si189_tiporegistro = 0;
  var $si189_contacontabil = 0;
  var $si189_codfundo = null;
  var $si189_atributosf = null;
  var $si189_codctb = 0;
  var $si189_saldoInicialctbsf = 0;
  var $si189_naturezasaldoinicialctbsf = null;
  var $si189_totaldebitosctbsf = 0;
  var $si189_totalcreditosctbsf = 0;
  var $si189_saldofinalctbsf = 0;
  var $si189_naturezasaldofinalctbsf = null;
  var $si189_mes = 0;
  var $si189_instit = 0;
  var $si189_reg10;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si189_sequencial = int8 = si189_sequencial 
                 si189_tiporegistro = int8 = si189_tiporegistro 
                 si189_contacontabil = int8 = si189_contacontabil 
                 si189_codfundo = varchar(8) = si189_codfundo 
                 si189_atributosf = varchar(1) = si189_atributosf 
                 si189_codctb = int8 = si189_codctb 
                 si189_saldoInicialctbsf = float8 = si189_saldoInicialctbsf 
                 si189_naturezasaldoinicialctbsf = varchar(1) = si189_naturezasaldoinicialctbsf 
                 si189_totaldebitosctbsf = float8 = si189_totaldebitosctbsf 
                 si189_totalcreditosctbsf = float8 = si189_totalcreditosctbsf 
                 si189_saldofinalctbsf = float8 = si189_saldofinalctbsf 
                 si189_naturezasaldofinalctbsf = varchar(1) = si189_naturezasaldofinalctbsf 
                 si189_mes = int8 = si189_mes 
                 si189_instit = int8 = si189_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete222021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete222021");
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
      $this->si189_sequencial = ($this->si189_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_sequencial"] : $this->si189_sequencial);
      $this->si189_tiporegistro = ($this->si189_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_tiporegistro"] : $this->si189_tiporegistro);
      $this->si189_contacontabil = ($this->si189_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_contacontabil"] : $this->si189_contacontabil);
      $this->si189_codfundo = ($this->si189_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_codfundo"] : $this->si189_codfundo);
      $this->si189_atributosf = ($this->si189_atributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_atributosf"] : $this->si189_atributosf);
      $this->si189_codctb = ($this->si189_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_codctb"] : $this->si189_codctb);
      $this->si189_saldoInicialctbsf = ($this->si189_saldoInicialctbsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_saldoInicialctbsf"] : $this->si189_saldoInicialctbsf);
      $this->si189_naturezasaldoinicialctbsf = ($this->si189_naturezasaldoinicialctbsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_naturezasaldoinicialctbsf"] : $this->si189_naturezasaldoinicialctbsf);
      $this->si189_totaldebitosctbsf = ($this->si189_totaldebitosctbsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_totaldebitosctbsf"] : $this->si189_totaldebitosctbsf);
      $this->si189_totalcreditosctbsf = ($this->si189_totalcreditosctbsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_totalcreditosctbsf"] : $this->si189_totalcreditosctbsf);
      $this->si189_saldofinalctbsf = ($this->si189_saldofinalctbsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_saldofinalctbsf"] : $this->si189_saldofinalctbsf);
      $this->si189_naturezasaldofinalctbsf = ($this->si189_naturezasaldofinalctbsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_naturezasaldofinalctbsf"] : $this->si189_naturezasaldofinalctbsf);
      $this->si189_mes = ($this->si189_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_mes"] : $this->si189_mes);
      $this->si189_instit = ($this->si189_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_instit"] : $this->si189_instit);
    } else {
      $this->si189_sequencial = ($this->si189_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si189_sequencial"] : $this->si189_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si189_sequencial)
  {
    $this->atualizacampos();
    if ($this->si189_tiporegistro == null) {
      $this->erro_sql = " Campo si189_tiporegistro não informado.";
      $this->erro_campo = "si189_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_contacontabil == null) {
      $this->erro_sql = " Campo si189_contacontabil não informado.";
      $this->erro_campo = "si189_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_atributosf == null) {
      $this->erro_sql = " Campo si189_atributosf não informado.";
      $this->erro_campo = "si189_atributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_codctb == null) {
      $this->erro_sql = " Campo si189_codctb não informado.";
      $this->erro_campo = "si189_codctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_saldoInicialctbsf == null) {
      $this->erro_sql = " Campo si189_saldoInicialctbsf não informado.";
      $this->erro_campo = "si189_saldoInicialctbsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_naturezasaldoinicialctbsf == null) {
      $this->erro_sql = " Campo si189_naturezasaldoinicialctbsf não informado.";
      $this->erro_campo = "si189_naturezasaldoinicialctbsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_totaldebitosctbsf == null) {
      $this->erro_sql = " Campo si189_totaldebitosctbsf não informado.";
      $this->erro_campo = "si189_totaldebitosctbsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_totalcreditosctbsf == null) {
      $this->erro_sql = " Campo si189_totalcreditosctbsf não informado.";
      $this->erro_campo = "si189_totalcreditosctbsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_saldofinalctbsf == null) {
      $this->erro_sql = " Campo si189_saldofinalctbsf não informado.";
      $this->erro_campo = "si189_saldofinalctbsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_naturezasaldofinalctbsf == null) {
      $this->erro_sql = " Campo si189_naturezasaldofinalctbsf não informado.";
      $this->erro_campo = "si189_naturezasaldofinalctbsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_mes == null) {
      $this->erro_sql = " Campo si189_mes não informado.";
      $this->erro_campo = "si189_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si189_instit == null) {
      $this->erro_sql = " Campo si189_instit não informado.";
      $this->erro_campo = "si189_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $this->si189_sequencial = $si189_sequencial;
    if (($this->si189_sequencial == null) || ($this->si189_sequencial == "")) {
      $this->erro_sql = " Campo si189_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete222021(
                                       si189_sequencial 
                                      ,si189_tiporegistro 
                                      ,si189_contacontabil 
                                      ,si189_codfundo 
                                      ,si189_atributosf 
                                      ,si189_codctb 
                                      ,si189_saldoInicialctbsf 
                                      ,si189_naturezasaldoinicialctbsf 
                                      ,si189_totaldebitosctbsf 
                                      ,si189_totalcreditosctbsf 
                                      ,si189_saldofinalctbsf 
                                      ,si189_naturezasaldofinalctbsf 
                                      ,si189_mes 
                                      ,si189_instit
                                      ,si189_reg10
                       )
                values (
                                $this->si189_sequencial 
                               ,$this->si189_tiporegistro 
                               ,$this->si189_contacontabil 
                               ,'$this->si189_codfundo'
                               ,'$this->si189_atributosf' 
                               ,$this->si189_codctb 
                               ,$this->si189_saldoInicialctbsf 
                               ,'$this->si189_naturezasaldoinicialctbsf' 
                               ,$this->si189_totaldebitosctbsf 
                               ,$this->si189_totalcreditosctbsf 
                               ,$this->si189_saldofinalctbsf 
                               ,'$this->si189_naturezasaldofinalctbsf' 
                               ,$this->si189_mes 
                               ,$this->si189_instit
                               ,$this->si189_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete222021 ($this->si189_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete222021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete222021 ($this->si189_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si189_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si189_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        /* $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011878,'$this->si189_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010207,2011878,'','".AddSlashes(pg_result($resaco,0,'si189_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011879,'','".AddSlashes(pg_result($resaco,0,'si189_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011880,'','".AddSlashes(pg_result($resaco,0,'si189_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011881,'','".AddSlashes(pg_result($resaco,0,'si189_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011882,'','".AddSlashes(pg_result($resaco,0,'si189_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011883,'','".AddSlashes(pg_result($resaco,0,'si189_saldoInicialctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011884,'','".AddSlashes(pg_result($resaco,0,'si189_naturezasaldoinicialctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011885,'','".AddSlashes(pg_result($resaco,0,'si189_totaldebitosctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011886,'','".AddSlashes(pg_result($resaco,0,'si189_totalcreditosctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011887,'','".AddSlashes(pg_result($resaco,0,'si189_saldofinalctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011888,'','".AddSlashes(pg_result($resaco,0,'si189_naturezasaldofinalctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011889,'','".AddSlashes(pg_result($resaco,0,'si189_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010207,2011890,'','".AddSlashes(pg_result($resaco,0,'si189_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si189_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete222021 set ";
    $virgula = "";
    if (trim($this->si189_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_sequencial"])) {
      $sql .= $virgula . " si189_sequencial = $this->si189_sequencial ";
      $virgula = ",";
      if (trim($this->si189_sequencial) == null) {
        $this->erro_sql = " Campo si189_sequencial não informado.";
        $this->erro_campo = "si189_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_tiporegistro"])) {
      $sql .= $virgula . " si189_tiporegistro = $this->si189_tiporegistro ";
      $virgula = ",";
      if (trim($this->si189_tiporegistro) == null) {
        $this->erro_sql = " Campo si189_tiporegistro não informado.";
        $this->erro_campo = "si189_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_contacontabil"])) {
      $sql .= $virgula . " si189_contacontabil = $this->si189_contacontabil ";
      $virgula = ",";
      if (trim($this->si189_contacontabil) == null) {
        $this->erro_sql = " Campo si189_contacontabil não informado.";
        $this->erro_campo = "si189_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_codfundo"])) {
      $sql .= $virgula . " si189_codfundo = '$this->si189_codfundo' ";
      $virgula = ",";
      if (trim($this->si189_codfundo) == null) {
        $this->erro_sql = " Campo si189_codfundo não informado.";
        $this->erro_campo = "si189_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_atributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_atributosf"])) {
      $sql .= $virgula . " si189_atributosf = '$this->si189_atributosf' ";
      $virgula = ",";
      if (trim($this->si189_atributosf) == null) {
        $this->erro_sql = " Campo si189_atributosf não informado.";
        $this->erro_campo = "si189_atributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_codctb"])) {
      $sql .= $virgula . " si189_codctb = $this->si189_codctb ";
      $virgula = ",";
      if (trim($this->si189_codctb) == null) {
        $this->erro_sql = " Campo si189_codctb não informado.";
        $this->erro_campo = "si189_codctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_saldoInicialctbsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_saldoInicialctbsf"])) {
      $sql .= $virgula . " si189_saldoInicialctbsf = $this->si189_saldoInicialctbsf ";
      $virgula = ",";
      if (trim($this->si189_saldoInicialctbsf) == null) {
        $this->erro_sql = " Campo si189_saldoInicialctbsf não informado.";
        $this->erro_campo = "si189_saldoInicialctbsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_naturezasaldoinicialctbsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_naturezasaldoinicialctbsf"])) {
      $sql .= $virgula . " si189_naturezasaldoinicialctbsf = '$this->si189_naturezasaldoinicialctbsf' ";
      $virgula = ",";
      if (trim($this->si189_naturezasaldoinicialctbsf) == null) {
        $this->erro_sql = " Campo si189_naturezasaldoinicialctbsf não informado.";
        $this->erro_campo = "si189_naturezasaldoinicialctbsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_totaldebitosctbsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_totaldebitosctbsf"])) {
      $sql .= $virgula . " si189_totaldebitosctbsf = $this->si189_totaldebitosctbsf ";
      $virgula = ",";
      if (trim($this->si189_totaldebitosctbsf) == null) {
        $this->erro_sql = " Campo si189_totaldebitosctbsf não informado.";
        $this->erro_campo = "si189_totaldebitosctbsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_totalcreditosctbsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_totalcreditosctbsf"])) {
      $sql .= $virgula . " si189_totalcreditosctbsf = $this->si189_totalcreditosctbsf ";
      $virgula = ",";
      if (trim($this->si189_totalcreditosctbsf) == null) {
        $this->erro_sql = " Campo si189_totalcreditosctbsf não informado.";
        $this->erro_campo = "si189_totalcreditosctbsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_saldofinalctbsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_saldofinalctbsf"])) {
      $sql .= $virgula . " si189_saldofinalctbsf = $this->si189_saldofinalctbsf ";
      $virgula = ",";
      if (trim($this->si189_saldofinalctbsf) == null) {
        $this->erro_sql = " Campo si189_saldofinalctbsf não informado.";
        $this->erro_campo = "si189_saldofinalctbsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_naturezasaldofinalctbsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_naturezasaldofinalctbsf"])) {
      $sql .= $virgula . " si189_naturezasaldofinalctbsf = '$this->si189_naturezasaldofinalctbsf' ";
      $virgula = ",";
      if (trim($this->si189_naturezasaldofinalctbsf) == null) {
        $this->erro_sql = " Campo si189_naturezasaldofinalctbsf não informado.";
        $this->erro_campo = "si189_naturezasaldofinalctbsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_mes"])) {
      $sql .= $virgula . " si189_mes = $this->si189_mes ";
      $virgula = ",";
      if (trim($this->si189_mes) == null) {
        $this->erro_sql = " Campo si189_mes não informado.";
        $this->erro_campo = "si189_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si189_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si189_instit"])) {
      $sql .= $virgula . " si189_instit = $this->si189_instit ";
      $virgula = ",";
      if (trim($this->si189_instit) == null) {
        $this->erro_sql = " Campo si189_instit não informado.";
        $this->erro_campo = "si189_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si189_sequencial != null) {
      $sql .= " si189_sequencial = $this->si189_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si189_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,2011878,'$this->si189_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_sequencial"]) || $this->si189_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011878,'".AddSlashes(pg_result($resaco,$conresaco,'si189_sequencial'))."','$this->si189_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_tiporegistro"]) || $this->si189_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011879,'".AddSlashes(pg_result($resaco,$conresaco,'si189_tiporegistro'))."','$this->si189_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_contacontabil"]) || $this->si189_contacontabil != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011880,'".AddSlashes(pg_result($resaco,$conresaco,'si189_contacontabil'))."','$this->si189_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_atributosf"]) || $this->si189_atributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011881,'".AddSlashes(pg_result($resaco,$conresaco,'si189_atributosf'))."','$this->si189_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_codctb"]) || $this->si189_codctb != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011882,'".AddSlashes(pg_result($resaco,$conresaco,'si189_codctb'))."','$this->si189_codctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_saldoInicialctbsf"]) || $this->si189_saldoInicialctbsf != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011883,'".AddSlashes(pg_result($resaco,$conresaco,'si189_saldoInicialctbsf'))."','$this->si189_saldoInicialctbsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_naturezasaldoinicialctbsf"]) || $this->si189_naturezasaldoinicialctbsf != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011884,'".AddSlashes(pg_result($resaco,$conresaco,'si189_naturezasaldoinicialctbsf'))."','$this->si189_naturezasaldoinicialctbsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_totaldebitosctbsf"]) || $this->si189_totaldebitosctbsf != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011885,'".AddSlashes(pg_result($resaco,$conresaco,'si189_totaldebitosctbsf'))."','$this->si189_totaldebitosctbsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_totalcreditosctbsf"]) || $this->si189_totalcreditosctbsf != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011886,'".AddSlashes(pg_result($resaco,$conresaco,'si189_totalcreditosctbsf'))."','$this->si189_totalcreditosctbsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_saldofinalctbsf"]) || $this->si189_saldofinalctbsf != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011887,'".AddSlashes(pg_result($resaco,$conresaco,'si189_saldofinalctbsf'))."','$this->si189_saldofinalctbsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_naturezasaldofinalctbsf"]) || $this->si189_naturezasaldofinalctbsf != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011888,'".AddSlashes(pg_result($resaco,$conresaco,'si189_naturezasaldofinalctbsf'))."','$this->si189_naturezasaldofinalctbsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_mes"]) || $this->si189_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011889,'".AddSlashes(pg_result($resaco,$conresaco,'si189_mes'))."','$this->si189_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si189_instit"]) || $this->si189_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010207,2011890,'".AddSlashes(pg_result($resaco,$conresaco,'si189_instit'))."','$this->si189_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete222021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si189_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete222021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si189_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si189_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si189_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si189_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011878,'$si189_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011878,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011879,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011880,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011881,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011882,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011883,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_saldoInicialctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011884,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_naturezasaldoinicialctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011885,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_totaldebitosctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011886,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_totalcreditosctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011887,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_saldofinalctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011888,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_naturezasaldofinalctbsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011889,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010207,2011890,'','".AddSlashes(pg_result($resaco,$iresaco,'si189_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from balancete222021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si189_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si189_sequencial = $si189_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete222021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si189_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete222021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si189_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si189_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete222021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si189_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete222021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si189_sequencial != null) {
        $sql2 .= " where balancete222021.si189_sequencial = $si189_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
  function sql_query_file($si189_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete222021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si189_sequencial != null) {
        $sql2 .= " where balancete222021.si189_sequencial = $si189_sequencial ";
      }
    } else {
      if ($dbwhere != "") {
        $sql2 = " where $dbwhere";
      }
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
