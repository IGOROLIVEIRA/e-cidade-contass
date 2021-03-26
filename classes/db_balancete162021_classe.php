<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete162021
class cl_balancete162021
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
  var $si183_sequencial = 0;
  var $si183_tiporegistro = 0;
  var $si183_contacontabil = 0;
  var $si183_codfundo = null;
  var $si183_atributosf = null;
  var $si183_codfontrecursos = 0;
  var $si183_saldoinicialfontsf = 0;
  var $si183_naturezasaldoinicialfontsf = null;
  var $si183_totaldebitosfontsf = 0;
  var $si183_totalcreditosfontsf = 0;
  var $si183_saldofinalfontsf = 0;
  var $si183_naturezasaldofinalfontsf = null;
  var $si183_mes = 0;
  var $si183_instit = 0;
  var $si183_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si183_sequencial = int8 = si183_sequencial 
                 si183_tiporegistro = int8 = si183_tiporegistro 
                 si183_contacontabil = int8 = si183_contacontabil 
                 si183_codfundo = varchar(8) = si183_codfundo 
                 si183_atributosf = varchar(1) = si183_atributosf 
                 si183_codfontrecursos = int8 = si183_codfontrecursos 
                 si183_saldoinicialfontsf = float8 = si183_saldoinicialfontsf 
                 si183_naturezasaldoinicialfontsf = varchar(1) = si183_naturezasaldoinicialfontsf 
                 si183_totaldebitosfontsf = float8 = si183_totaldebitosfontsf 
                 si183_totalcreditosfontsf = float8 = si183_totalcreditosfontsf 
                 si183_saldofinalfontsf = float8 = si183_saldofinalfontsf 
                 si183_naturezasaldofinalfontsf = varchar(1) = si183_naturezasaldofinalfontsf 
                 si183_mes = int8 = si183_mes 
                 si183_instit = int8 = si183_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete162021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete162021");
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
      $this->si183_sequencial = ($this->si183_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_sequencial"] : $this->si183_sequencial);
      $this->si183_tiporegistro = ($this->si183_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_tiporegistro"] : $this->si183_tiporegistro);
      $this->si183_contacontabil = ($this->si183_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_contacontabil"] : $this->si183_contacontabil);
      $this->si183_codfundo = ($this->si183_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_codfundo"] : $this->si183_codfundo);
      $this->si183_atributosf = ($this->si183_atributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_atributosf"] : $this->si183_atributosf);
      $this->si183_codfontrecursos = ($this->si183_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_codfontrecursos"] : $this->si183_codfontrecursos);
      $this->si183_saldoinicialfontsf = ($this->si183_saldoinicialfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_saldoinicialfontsf"] : $this->si183_saldoinicialfontsf);
      $this->si183_naturezasaldoinicialfontsf = ($this->si183_naturezasaldoinicialfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_naturezasaldoinicialfontsf"] : $this->si183_naturezasaldoinicialfontsf);
      $this->si183_totaldebitosfontsf = ($this->si183_totaldebitosfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_totaldebitosfontsf"] : $this->si183_totaldebitosfontsf);
      $this->si183_totalcreditosfontsf = ($this->si183_totalcreditosfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_totalcreditosfontsf"] : $this->si183_totalcreditosfontsf);
      $this->si183_saldofinalfontsf = ($this->si183_saldofinalfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_saldofinalfontsf"] : $this->si183_saldofinalfontsf);
      $this->si183_naturezasaldofinalfontsf = ($this->si183_naturezasaldofinalfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_naturezasaldofinalfontsf"] : $this->si183_naturezasaldofinalfontsf);
      $this->si183_mes = ($this->si183_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_mes"] : $this->si183_mes);
      $this->si183_instit = ($this->si183_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_instit"] : $this->si183_instit);
    } else {
      $this->si183_sequencial = ($this->si183_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si183_sequencial"] : $this->si183_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si183_sequencial)
  {
    $this->atualizacampos();
    if ($this->si183_tiporegistro == null) {
      $this->erro_sql = " Campo si183_tiporegistro não informado.";
      $this->erro_campo = "si183_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_contacontabil == null) {
      $this->erro_sql = " Campo si183_contacontabil não informado.";
      $this->erro_campo = "si183_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_atributosf == null) {
      $this->erro_sql = " Campo si183_atributosf não informado.";
      $this->erro_campo = "si183_atributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_codfontrecursos == null) {
      $this->erro_sql = " Campo si183_codfontrecursos não informado.";
      $this->erro_campo = "si183_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_saldoinicialfontsf == null) {
      $this->erro_sql = " Campo si183_saldoinicialfontsf não informado.";
      $this->erro_campo = "si183_saldoinicialfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_naturezasaldoinicialfontsf == null) {
      $this->erro_sql = " Campo si183_naturezasaldoinicialfontsf não informado.";
      $this->erro_campo = "si183_naturezasaldoinicialfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_totaldebitosfontsf == null) {
      $this->erro_sql = " Campo si183_totaldebitosfontsf não informado.";
      $this->erro_campo = "si183_totaldebitosfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_totalcreditosfontsf == null) {
      $this->erro_sql = " Campo si183_totalcreditosfontsf não informado.";
      $this->erro_campo = "si183_totalcreditosfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_saldofinalfontsf == null) {
      $this->erro_sql = " Campo si183_saldofinalfontsf não informado.";
      $this->erro_campo = "si183_saldofinalfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_naturezasaldofinalfontsf == null) {
      $this->erro_sql = " Campo si183_naturezasaldofinalfontsf não informado.";
      $this->erro_campo = "si183_naturezasaldofinalfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_mes == null) {
      $this->erro_sql = " Campo si183_mes não informado.";
      $this->erro_campo = "si183_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si183_instit == null) {
      $this->erro_sql = " Campo si183_instit não informado.";
      $this->erro_campo = "si183_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si183_sequencial == "" || $si183_sequencial == null) {
      $result = db_query("select nextval('balancete162021_si183_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete162021_si183_sequencial_seq do campo: si183_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si183_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete162021_si183_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si183_sequencial)) {
        $this->erro_sql = " Campo si183_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si183_sequencial = $si183_sequencial;
      }
    }
    if (($this->si183_sequencial == null) || ($this->si183_sequencial == "")) {
      $this->erro_sql = " Campo si183_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete162021(
                                       si183_sequencial 
                                      ,si183_tiporegistro 
                                      ,si183_contacontabil 
                                      ,si183_codfundo 
                                      ,si183_atributosf 
                                      ,si183_codfontrecursos 
                                      ,si183_saldoinicialfontsf 
                                      ,si183_naturezasaldoinicialfontsf 
                                      ,si183_totaldebitosfontsf 
                                      ,si183_totalcreditosfontsf 
                                      ,si183_saldofinalfontsf 
                                      ,si183_naturezasaldofinalfontsf 
                                      ,si183_mes 
                                      ,si183_instit
                                      ,si183_reg10
                       )
                values (
                                $this->si183_sequencial 
                               ,$this->si183_tiporegistro 
                               ,$this->si183_contacontabil 
                               ,'$this->si183_codfundo' 
                               ,'$this->si183_atributosf' 
                               ,$this->si183_codfontrecursos 
                               ,$this->si183_saldoinicialfontsf 
                               ,'$this->si183_naturezasaldoinicialfontsf' 
                               ,$this->si183_totaldebitosfontsf 
                               ,$this->si183_totalcreditosfontsf 
                               ,$this->si183_saldofinalfontsf 
                               ,'$this->si183_naturezasaldofinalfontsf' 
                               ,$this->si183_mes 
                               ,$this->si183_instit
                               ,$this->si183_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete162021 ($this->si183_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete162021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete162021 ($this->si183_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si183_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si183_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,2011796,'$this->si183_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010198,2011796,'','".AddSlashes(pg_result($resaco,0,'si183_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011797,'','".AddSlashes(pg_result($resaco,0,'si183_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011798,'','".AddSlashes(pg_result($resaco,0,'si183_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011799,'','".AddSlashes(pg_result($resaco,0,'si183_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011800,'','".AddSlashes(pg_result($resaco,0,'si183_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011801,'','".AddSlashes(pg_result($resaco,0,'si183_saldoinicialfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011802,'','".AddSlashes(pg_result($resaco,0,'si183_naturezasaldoinicialfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011803,'','".AddSlashes(pg_result($resaco,0,'si183_totaldebitosfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011804,'','".AddSlashes(pg_result($resaco,0,'si183_totalcreditosfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011805,'','".AddSlashes(pg_result($resaco,0,'si183_saldofinalfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011806,'','".AddSlashes(pg_result($resaco,0,'si183_naturezasaldofinalfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011807,'','".AddSlashes(pg_result($resaco,0,'si183_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010198,2011808,'','".AddSlashes(pg_result($resaco,0,'si183_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si183_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete162021 set ";
    $virgula = "";
    if (trim($this->si183_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_sequencial"])) {
      $sql .= $virgula . " si183_sequencial = $this->si183_sequencial ";
      $virgula = ",";
      if (trim($this->si183_sequencial) == null) {
        $this->erro_sql = " Campo si183_sequencial não informado.";
        $this->erro_campo = "si183_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_tiporegistro"])) {
      $sql .= $virgula . " si183_tiporegistro = $this->si183_tiporegistro ";
      $virgula = ",";
      if (trim($this->si183_tiporegistro) == null) {
        $this->erro_sql = " Campo si183_tiporegistro não informado.";
        $this->erro_campo = "si183_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_contacontabil"])) {
      $sql .= $virgula . " si183_contacontabil = $this->si183_contacontabil ";
      $virgula = ",";
      if (trim($this->si183_contacontabil) == null) {
        $this->erro_sql = " Campo si183_contacontabil não informado.";
        $this->erro_campo = "si183_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_codfundo"])) {
      $sql .= $virgula . " si183_codfundo = '$this->si183_codfundo' ";
      $virgula = ",";
      if (trim($this->si183_codfundo) == null) {
        $this->erro_sql = " Campo si183_codfundo não informado.";
        $this->erro_campo = "si183_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_atributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_atributosf"])) {
      $sql .= $virgula . " si183_atributosf = '$this->si183_atributosf' ";
      $virgula = ",";
      if (trim($this->si183_atributosf) == null) {
        $this->erro_sql = " Campo si183_atributosf não informado.";
        $this->erro_campo = "si183_atributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_codfontrecursos"])) {
      $sql .= $virgula . " si183_codfontrecursos = $this->si183_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si183_codfontrecursos) == null) {
        $this->erro_sql = " Campo si183_codfontrecursos não informado.";
        $this->erro_campo = "si183_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_saldoinicialfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_saldoinicialfontsf"])) {
      $sql .= $virgula . " si183_saldoinicialfontsf = $this->si183_saldoinicialfontsf ";
      $virgula = ",";
      if (trim($this->si183_saldoinicialfontsf) == null) {
        $this->erro_sql = " Campo si183_saldoinicialfontsf não informado.";
        $this->erro_campo = "si183_saldoinicialfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_naturezasaldoinicialfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_naturezasaldoinicialfontsf"])) {
      $sql .= $virgula . " si183_naturezasaldoinicialfontsf = '$this->si183_naturezasaldoinicialfontsf' ";
      $virgula = ",";
      if (trim($this->si183_naturezasaldoinicialfontsf) == null) {
        $this->erro_sql = " Campo si183_naturezasaldoinicialfontsf não informado.";
        $this->erro_campo = "si183_naturezasaldoinicialfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_totaldebitosfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_totaldebitosfontsf"])) {
      $sql .= $virgula . " si183_totaldebitosfontsf = $this->si183_totaldebitosfontsf ";
      $virgula = ",";
      if (trim($this->si183_totaldebitosfontsf) == null) {
        $this->erro_sql = " Campo si183_totaldebitosfontsf não informado.";
        $this->erro_campo = "si183_totaldebitosfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_totalcreditosfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_totalcreditosfontsf"])) {
      $sql .= $virgula . " si183_totalcreditosfontsf = $this->si183_totalcreditosfontsf ";
      $virgula = ",";
      if (trim($this->si183_totalcreditosfontsf) == null) {
        $this->erro_sql = " Campo si183_totalcreditosfontsf não informado.";
        $this->erro_campo = "si183_totalcreditosfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_saldofinalfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_saldofinalfontsf"])) {
      $sql .= $virgula . " si183_saldofinalfontsf = $this->si183_saldofinalfontsf ";
      $virgula = ",";
      if (trim($this->si183_saldofinalfontsf) == null) {
        $this->erro_sql = " Campo si183_saldofinalfontsf não informado.";
        $this->erro_campo = "si183_saldofinalfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_naturezasaldofinalfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_naturezasaldofinalfontsf"])) {
      $sql .= $virgula . " si183_naturezasaldofinalfontsf = '$this->si183_naturezasaldofinalfontsf' ";
      $virgula = ",";
      if (trim($this->si183_naturezasaldofinalfontsf) == null) {
        $this->erro_sql = " Campo si183_naturezasaldofinalfontsf não informado.";
        $this->erro_campo = "si183_naturezasaldofinalfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_mes"])) {
      $sql .= $virgula . " si183_mes = $this->si183_mes ";
      $virgula = ",";
      if (trim($this->si183_mes) == null) {
        $this->erro_sql = " Campo si183_mes não informado.";
        $this->erro_campo = "si183_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si183_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si183_instit"])) {
      $sql .= $virgula . " si183_instit = $this->si183_instit ";
      $virgula = ",";
      if (trim($this->si183_instit) == null) {
        $this->erro_sql = " Campo si183_instit não informado.";
        $this->erro_campo = "si183_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si183_sequencial != null) {
      $sql .= " si183_sequencial = $this->si183_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si183_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,2011796,'$this->si183_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_sequencial"]) || $this->si183_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011796,'".AddSlashes(pg_result($resaco,$conresaco,'si183_sequencial'))."','$this->si183_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_tiporegistro"]) || $this->si183_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011797,'".AddSlashes(pg_result($resaco,$conresaco,'si183_tiporegistro'))."','$this->si183_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_contacontabil"]) || $this->si183_contacontabil != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011798,'".AddSlashes(pg_result($resaco,$conresaco,'si183_contacontabil'))."','$this->si183_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_atributosf"]) || $this->si183_atributosf != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011799,'".AddSlashes(pg_result($resaco,$conresaco,'si183_atributosf'))."','$this->si183_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_codfontrecursos"]) || $this->si183_codfontrecursos != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011800,'".AddSlashes(pg_result($resaco,$conresaco,'si183_codfontrecursos'))."','$this->si183_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_saldoinicialfontsf"]) || $this->si183_saldoinicialfontsf != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011801,'".AddSlashes(pg_result($resaco,$conresaco,'si183_saldoinicialfontsf'))."','$this->si183_saldoinicialfontsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_naturezasaldoinicialfontsf"]) || $this->si183_naturezasaldoinicialfontsf != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011802,'".AddSlashes(pg_result($resaco,$conresaco,'si183_naturezasaldoinicialfontsf'))."','$this->si183_naturezasaldoinicialfontsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_totaldebitosfontsf"]) || $this->si183_totaldebitosfontsf != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011803,'".AddSlashes(pg_result($resaco,$conresaco,'si183_totaldebitosfontsf'))."','$this->si183_totaldebitosfontsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_totalcreditosfontsf"]) || $this->si183_totalcreditosfontsf != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011804,'".AddSlashes(pg_result($resaco,$conresaco,'si183_totalcreditosfontsf'))."','$this->si183_totalcreditosfontsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_saldofinalfontsf"]) || $this->si183_saldofinalfontsf != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011805,'".AddSlashes(pg_result($resaco,$conresaco,'si183_saldofinalfontsf'))."','$this->si183_saldofinalfontsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_naturezasaldofinalfontsf"]) || $this->si183_naturezasaldofinalfontsf != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011806,'".AddSlashes(pg_result($resaco,$conresaco,'si183_naturezasaldofinalfontsf'))."','$this->si183_naturezasaldofinalfontsf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_mes"]) || $this->si183_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011807,'".AddSlashes(pg_result($resaco,$conresaco,'si183_mes'))."','$this->si183_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si183_instit"]) || $this->si183_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010198,2011808,'".AddSlashes(pg_result($resaco,$conresaco,'si183_instit'))."','$this->si183_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete162021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si183_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete162021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si183_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si183_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si183_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si183_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011796,'$si183_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011796,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011797,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011798,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011799,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011800,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011801,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_saldoinicialfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011802,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_naturezasaldoinicialfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011803,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_totaldebitosfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011804,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_totalcreditosfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011805,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_saldofinalfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011806,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_naturezasaldofinalfontsf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011807,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010198,2011808,'','".AddSlashes(pg_result($resaco,$iresaco,'si183_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from balancete162021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si183_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si183_sequencial = $si183_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete162021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si183_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete162021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si183_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si183_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete162021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si183_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete162021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si183_sequencial != null) {
        $sql2 .= " where balancete162021.si183_sequencial = $si183_sequencial ";
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
  function sql_query_file($si183_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete162021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si183_sequencial != null) {
        $sql2 .= " where balancete162021.si183_sequencial = $si183_sequencial ";
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
