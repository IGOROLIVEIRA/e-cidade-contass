<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete192020
class cl_balancete192020
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
  var $si186_sequencial = 0;
  var $si186_tiporegistro = 0;
  var $si186_contacontabil = 0;
  var $si186_codfundo = null;
  var $si186_cnpjconsorcio = 0;
  var $si186_saldoinicialconsor = 0;
  var $si186_naturezasaldoinicialconsor = null;
  var $si186_totaldebitosconsor = 0;
  var $si186_totalcreditosconsor = 0;
  var $si186_saldofinalconsor = 0;
  var $si186_naturezasaldofinalconsor = null;
  var $si186_mes = 0;
  var $si186_instit = 0;
  var $si186_reg10;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si186_sequencial = int8 = si186_sequencial 
                 si186_tiporegistro = int8 = si186_tiporegistro 
                 si186_contacontabil = int8 = si186_contacontabil 
                 si186_codfundo = varchar(8) = si186_codfundo 
                 si186_cnpjconsorcio = int8 = si186_cnpjconsorcio 
                 si186_saldoinicialconsor = float8 = si186_saldoinicialconsor 
                 si186_naturezasaldoinicialconsor = varchar(1) = si186_naturezasaldoinicialconsor 
                 si186_totaldebitosconsor = float8 = si186_totaldebitosconsor 
                 si186_totalcreditosconsor = float8 = si186_totalcreditosconsor 
                 si186_saldofinalconsor = float8 = si186_saldofinalconsor 
                 si186_naturezasaldofinalconsor = varchar(1) = si186_naturezasaldofinalconsor 
                 si186_mes = int8 = si186_mes 
                 si186_instit = int8 = si185_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete192020()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete192020");
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
      $this->si186_sequencial = ($this->si186_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_sequencial"] : $this->si186_sequencial);
      $this->si186_tiporegistro = ($this->si186_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_tiporegistro"] : $this->si186_tiporegistro);
      $this->si186_contacontabil = ($this->si186_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_contacontabil"] : $this->si186_contacontabil);
      $this->si186_codfundo = ($this->si186_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_codfundo"] : $this->si186_codfundo);
      $this->si186_cnpjconsorcio = ($this->si186_cnpjconsorcio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_cnpjconsorcio"] : $this->si186_cnpjconsorcio);
      $this->si186_saldoinicialconsor = ($this->si186_saldoinicialconsor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_saldoinicialconsor"] : $this->si186_saldoinicialconsor);
      $this->si186_naturezasaldoinicialconsor = ($this->si186_naturezasaldoinicialconsor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_naturezasaldoinicialconsor"] : $this->si186_naturezasaldoinicialconsor);
      $this->si186_totaldebitosconsor = ($this->si186_totaldebitosconsor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_totaldebitosconsor"] : $this->si186_totaldebitosconsor);
      $this->si186_totalcreditosconsor = ($this->si186_totalcreditosconsor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_totalcreditosconsor"] : $this->si186_totalcreditosconsor);
      $this->si186_saldofinalconsor = ($this->si186_saldofinalconsor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_saldofinalconsor"] : $this->si186_saldofinalconsor);
      $this->si186_naturezasaldofinalconsor = ($this->si186_naturezasaldofinalconsor == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_naturezasaldofinalconsor"] : $this->si186_naturezasaldofinalconsor);
      $this->si186_mes = ($this->si186_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_mes"] : $this->si186_mes);
      $this->si186_instit = ($this->si186_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_instit"] : $this->si186_instit);
    } else {
      $this->si186_sequencial = ($this->si186_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si186_sequencial"] : $this->si186_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si186_sequencial)
  {
    $this->atualizacampos();
    if ($this->si186_tiporegistro == null) {
      $this->erro_sql = " Campo si186_tiporegistro não informado.";
      $this->erro_campo = "si186_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_contacontabil == null) {
      $this->erro_sql = " Campo si186_contacontabil não informado.";
      $this->erro_campo = "si186_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_cnpjconsorcio == null) {
      $this->erro_sql = " Campo si186_cnpjconsorcio não informado.";
      $this->erro_campo = "si186_cnpjconsorcio";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_saldoinicialconsor == null) {
      $this->erro_sql = " Campo si186_saldoinicialconsor não informado.";
      $this->erro_campo = "si186_saldoinicialconsor";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_naturezasaldoinicialconsor == null) {
      $this->erro_sql = " Campo si186_naturezasaldoinicialconsor não informado.";
      $this->erro_campo = "si186_naturezasaldoinicialconsor";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_totaldebitosconsor == null) {
      $this->erro_sql = " Campo si186_totaldebitosconsor não informado.";
      $this->erro_campo = "si186_totaldebitosconsor";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_totalcreditosconsor == null) {
      $this->erro_sql = " Campo si186_totalcreditosconsor não informado.";
      $this->erro_campo = "si186_totalcreditosconsor";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_saldofinalconsor == null) {
      $this->erro_sql = " Campo si186_saldofinalconsor não informado.";
      $this->erro_campo = "si186_saldofinalconsor";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_naturezasaldofinalconsor == null) {
      $this->erro_sql = " Campo si186_naturezasaldofinalconsor não informado.";
      $this->erro_campo = "si186_naturezasaldofinalconsor";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_mes == null) {
      $this->erro_sql = " Campo si186_mes não informado.";
      $this->erro_campo = "si186_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si186_instit == null) {
      $this->erro_sql = " Campo si185_instit não informado.";
      $this->erro_campo = "si186_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $this->si186_sequencial = $si186_sequencial;
    if (($this->si186_sequencial == null) || ($this->si186_sequencial == "")) {
      $this->erro_sql = " Campo si186_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete192020(
                                       si186_sequencial 
                                      ,si186_tiporegistro 
                                      ,si186_contacontabil 
                                      ,si186_codfundo 
                                      ,si186_cnpjconsorcio 
                                      ,si186_saldoinicialconsor 
                                      ,si186_naturezasaldoinicialconsor 
                                      ,si186_totaldebitosconsor 
                                      ,si186_totalcreditosconsor 
                                      ,si186_saldofinalconsor 
                                      ,si186_naturezasaldofinalconsor 
                                      ,si186_mes 
                                      ,si186_instit
                                      ,si186_reg10
                       )
                values (
                                $this->si186_sequencial 
                               ,$this->si186_tiporegistro 
                               ,$this->si186_contacontabil 
                               ,'$this->si186_codfundo' 
                               ,$this->si186_cnpjconsorcio 
                               ,$this->si186_saldoinicialconsor 
                               ,'$this->si186_naturezasaldoinicialconsor' 
                               ,$this->si186_totaldebitosconsor 
                               ,$this->si186_totalcreditosconsor 
                               ,$this->si186_saldofinalconsor 
                               ,'$this->si186_naturezasaldofinalconsor' 
                               ,$this->si186_mes 
                               ,$this->si186_instit
                               ,$this->si186_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete192020 ($this->si186_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete192020 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete192020 ($this->si186_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si186_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si186_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        /* $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011835,'$this->si186_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010203,2011835,'','".AddSlashes(pg_result($resaco,0,'si186_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011836,'','".AddSlashes(pg_result($resaco,0,'si186_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011837,'','".AddSlashes(pg_result($resaco,0,'si186_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011838,'','".AddSlashes(pg_result($resaco,0,'si186_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011839,'','".AddSlashes(pg_result($resaco,0,'si186_saldoinicialconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011840,'','".AddSlashes(pg_result($resaco,0,'si186_naturezasaldoinicialconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011841,'','".AddSlashes(pg_result($resaco,0,'si186_totaldebitosconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011842,'','".AddSlashes(pg_result($resaco,0,'si186_totalcreditosconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011843,'','".AddSlashes(pg_result($resaco,0,'si186_saldofinalconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011844,'','".AddSlashes(pg_result($resaco,0,'si186_naturezasaldofinalconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011845,'','".AddSlashes(pg_result($resaco,0,'si186_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,2011846,'','".AddSlashes(pg_result($resaco,0,'si186_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si186_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete192020 set ";
    $virgula = "";
    if (trim($this->si186_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_sequencial"])) {
      $sql .= $virgula . " si186_sequencial = $this->si186_sequencial ";
      $virgula = ",";
      if (trim($this->si186_sequencial) == null) {
        $this->erro_sql = " Campo si186_sequencial não informado.";
        $this->erro_campo = "si186_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_tiporegistro"])) {
      $sql .= $virgula . " si186_tiporegistro = $this->si186_tiporegistro ";
      $virgula = ",";
      if (trim($this->si186_tiporegistro) == null) {
        $this->erro_sql = " Campo si186_tiporegistro não informado.";
        $this->erro_campo = "si186_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_contacontabil"])) {
      $sql .= $virgula . " si186_contacontabil = $this->si186_contacontabil ";
      $virgula = ",";
      if (trim($this->si186_contacontabil) == null) {
        $this->erro_sql = " Campo si186_contacontabil não informado.";
        $this->erro_campo = "si186_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_codfundo"])) {
      $sql .= $virgula . " si186_codfundo = '$this->si186_codfundo' ";
      $virgula = ",";
      if (trim($this->si186_codfundo) == null) {
        $this->erro_sql = " Campo si186_codfundo não informado.";
        $this->erro_campo = "si186_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_cnpjconsorcio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_cnpjconsorcio"])) {
      $sql .= $virgula . " si186_cnpjconsorcio = $this->si186_cnpjconsorcio ";
      $virgula = ",";
      if (trim($this->si186_cnpjconsorcio) == null) {
        $this->erro_sql = " Campo si186_cnpjconsorcio não informado.";
        $this->erro_campo = "si186_cnpjconsorcio";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_saldoinicialconsor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_saldoinicialconsor"])) {
      $sql .= $virgula . " si186_saldoinicialconsor = $this->si186_saldoinicialconsor ";
      $virgula = ",";
      if (trim($this->si186_saldoinicialconsor) == null) {
        $this->erro_sql = " Campo si186_saldoinicialconsor não informado.";
        $this->erro_campo = "si186_saldoinicialconsor";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_naturezasaldoinicialconsor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_naturezasaldoinicialconsor"])) {
      $sql .= $virgula . " si186_naturezasaldoinicialconsor = '$this->si186_naturezasaldoinicialconsor' ";
      $virgula = ",";
      if (trim($this->si186_naturezasaldoinicialconsor) == null) {
        $this->erro_sql = " Campo si186_naturezasaldoinicialconsor não informado.";
        $this->erro_campo = "si186_naturezasaldoinicialconsor";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_totaldebitosconsor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_totaldebitosconsor"])) {
      $sql .= $virgula . " si186_totaldebitosconsor = $this->si186_totaldebitosconsor ";
      $virgula = ",";
      if (trim($this->si186_totaldebitosconsor) == null) {
        $this->erro_sql = " Campo si186_totaldebitosconsor não informado.";
        $this->erro_campo = "si186_totaldebitosconsor";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_totalcreditosconsor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_totalcreditosconsor"])) {
      $sql .= $virgula . " si186_totalcreditosconsor = $this->si186_totalcreditosconsor ";
      $virgula = ",";
      if (trim($this->si186_totalcreditosconsor) == null) {
        $this->erro_sql = " Campo si186_totalcreditosconsor não informado.";
        $this->erro_campo = "si186_totalcreditosconsor";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_saldofinalconsor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_saldofinalconsor"])) {
      $sql .= $virgula . " si186_saldofinalconsor = $this->si186_saldofinalconsor ";
      $virgula = ",";
      if (trim($this->si186_saldofinalconsor) == null) {
        $this->erro_sql = " Campo si186_saldofinalconsor não informado.";
        $this->erro_campo = "si186_saldofinalconsor";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_naturezasaldofinalconsor) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_naturezasaldofinalconsor"])) {
      $sql .= $virgula . " si186_naturezasaldofinalconsor = '$this->si186_naturezasaldofinalconsor' ";
      $virgula = ",";
      if (trim($this->si186_naturezasaldofinalconsor) == null) {
        $this->erro_sql = " Campo si186_naturezasaldofinalconsor não informado.";
        $this->erro_campo = "si186_naturezasaldofinalconsor";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_mes"])) {
      $sql .= $virgula . " si186_mes = $this->si186_mes ";
      $virgula = ",";
      if (trim($this->si186_mes) == null) {
        $this->erro_sql = " Campo si186_mes não informado.";
        $this->erro_campo = "si186_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si186_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si186_instit"])) {
      $sql .= $virgula . " si186_instit = $this->si186_instit ";
      $virgula = ",";
      if (trim($this->si186_instit) == null) {
        $this->erro_sql = " Campo si185_instit não informado.";
        $this->erro_campo = "si186_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si186_sequencial != null) {
      $sql .= " si186_sequencial = $this->si186_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si186_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,2011835,'$this->si186_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_sequencial"]) || $this->si186_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011835,'".AddSlashes(pg_result($resaco,$conresaco,'si186_sequencial'))."','$this->si186_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_tiporegistro"]) || $this->si186_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011836,'".AddSlashes(pg_result($resaco,$conresaco,'si186_tiporegistro'))."','$this->si186_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_contacontabil"]) || $this->si186_contacontabil != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011837,'".AddSlashes(pg_result($resaco,$conresaco,'si186_contacontabil'))."','$this->si186_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_cnpjconsorcio"]) || $this->si186_cnpjconsorcio != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011838,'".AddSlashes(pg_result($resaco,$conresaco,'si186_cnpjconsorcio'))."','$this->si186_cnpjconsorcio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_saldoinicialconsor"]) || $this->si186_saldoinicialconsor != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011839,'".AddSlashes(pg_result($resaco,$conresaco,'si186_saldoinicialconsor'))."','$this->si186_saldoinicialconsor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_naturezasaldoinicialconsor"]) || $this->si186_naturezasaldoinicialconsor != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011840,'".AddSlashes(pg_result($resaco,$conresaco,'si186_naturezasaldoinicialconsor'))."','$this->si186_naturezasaldoinicialconsor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_totaldebitosconsor"]) || $this->si186_totaldebitosconsor != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011841,'".AddSlashes(pg_result($resaco,$conresaco,'si186_totaldebitosconsor'))."','$this->si186_totaldebitosconsor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_totalcreditosconsor"]) || $this->si186_totalcreditosconsor != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011842,'".AddSlashes(pg_result($resaco,$conresaco,'si186_totalcreditosconsor'))."','$this->si186_totalcreditosconsor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_saldofinalconsor"]) || $this->si186_saldofinalconsor != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011843,'".AddSlashes(pg_result($resaco,$conresaco,'si186_saldofinalconsor'))."','$this->si186_saldofinalconsor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_naturezasaldofinalconsor"]) || $this->si186_naturezasaldofinalconsor != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011844,'".AddSlashes(pg_result($resaco,$conresaco,'si186_naturezasaldofinalconsor'))."','$this->si186_naturezasaldofinalconsor',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_mes"]) || $this->si186_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011845,'".AddSlashes(pg_result($resaco,$conresaco,'si186_mes'))."','$this->si186_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si186_instit"]) || $this->si186_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010203,2011846,'".AddSlashes(pg_result($resaco,$conresaco,'si186_instit'))."','$this->si186_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete192020 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si186_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete192020 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si186_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si186_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si186_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si186_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011835,'$si186_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011835,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011836,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011837,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011838,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011839,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_saldoinicialconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011840,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_naturezasaldoinicialconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011841,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_totaldebitosconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011842,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_totalcreditosconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011843,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_saldofinalconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011844,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_naturezasaldofinalconsor'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011845,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010203,2011846,'','".AddSlashes(pg_result($resaco,$iresaco,'si186_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from balancete192020
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si186_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si186_sequencial = $si186_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete192020 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si186_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete192020 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si186_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si186_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete192020";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si186_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete192020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si186_sequencial != null) {
        $sql2 .= " where balancete192020.si186_sequencial = $si186_sequencial ";
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
  function sql_query_file($si186_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete192020 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si186_sequencial != null) {
        $sql2 .= " where balancete192020.si186_sequencial = $si186_sequencial ";
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
