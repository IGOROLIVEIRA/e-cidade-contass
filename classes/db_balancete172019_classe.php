<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete172019
class cl_balancete172019
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
  var $si184_sequencial = 0;
  var $si184_tiporegistro = 0;
  var $si184_contacontabil = 0;
  var $si184_codfundo = null;
  var $si184_atributosf = null;
  var $si184_codctb = 0;
  var $si184_codfontrecursos = 0;
  var $si184_saldoinicialctb = 0;
  var $si184_naturezasaldoinicialctb = null;
  var $si184_totaldebitosctb = 0;
  var $si184_totalcreditosctb = 0;
  var $si184_saldofinalctb = 0;
  var $si184_naturezasaldofinalctb = null;
  var $si184_mes = 0;
  var $si184_instit = 0;
  var $si184_reg10;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si184_sequencial = int8 = si184_sequencial 
                 si184_tiporegistro = int8 = si184_tiporegistro 
                 si184_contacontabil = int8 = si184_contacontabil 
                 si184_codfundo = varchar(8) = si184_codfundo 
                 si184_atributosf = varchar(1) = si184_atributosf 
                 si184_codctb = int8 = si184_codctb 
                 si184_codfontrecursos = int8 = si184_codfontrecursos 
                 si184_saldoinicialctb = float8 = si184_saldoinicialctb 
                 si184_naturezasaldoinicialctb = varchar(1) = si184_naturezasaldoinicialctb 
                 si184_totaldebitosctb = float8 = si184_totaldebitosctb 
                 si184_totalcreditosctb = float8 = si184_totalcreditosctb 
                 si184_saldofinalctb = float8 = si184_saldofinalctb 
                 si184_naturezasaldofinalctb = varchar(1) = si184_naturezasaldofinalctb 
                 si184_mes = int8 = si184_mes 
                 si184_instit = int8 = si184_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete172019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete172019");
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
      $this->si184_sequencial = ($this->si184_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_sequencial"] : $this->si184_sequencial);
      $this->si184_tiporegistro = ($this->si184_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"] : $this->si184_tiporegistro);
      $this->si184_contacontabil = ($this->si184_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_contacontabil"] : $this->si184_contacontabil);
      $this->si184_codfundo = ($this->si184_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_codfundo"] : $this->si184_codfundo);
      $this->si184_atributosf = ($this->si184_atributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_atributosf"] : $this->si184_atributosf);
      $this->si184_codctb = ($this->si184_codctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_codctb"] : $this->si184_codctb);
      $this->si184_codfontrecursos = ($this->si184_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_codfontrecursos"] : $this->si184_codfontrecursos);
      $this->si184_saldoinicialctb = ($this->si184_saldoinicialctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_saldoinicialctb"] : $this->si184_saldoinicialctb);
      $this->si184_naturezasaldoinicialctb = ($this->si184_naturezasaldoinicialctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_naturezasaldoinicialctb"] : $this->si184_naturezasaldoinicialctb);
      $this->si184_totaldebitosctb = ($this->si184_totaldebitosctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_totaldebitosctb"] : $this->si184_totaldebitosctb);
      $this->si184_totalcreditosctb = ($this->si184_totalcreditosctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_totalcreditosctb"] : $this->si184_totalcreditosctb);
      $this->si184_saldofinalctb = ($this->si184_saldofinalctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_saldofinalctb"] : $this->si184_saldofinalctb);
      $this->si184_naturezasaldofinalctb = ($this->si184_naturezasaldofinalctb == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_naturezasaldofinalctb"] : $this->si184_naturezasaldofinalctb);
      $this->si184_mes = ($this->si184_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_mes"] : $this->si184_mes);
      $this->si184_instit = ($this->si184_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_instit"] : $this->si184_instit);
    } else {
      $this->si184_sequencial = ($this->si184_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si184_sequencial"] : $this->si184_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si184_sequencial)
  {
    $this->atualizacampos();
    if ($this->si184_tiporegistro == null) {
      $this->erro_sql = " Campo si184_tiporegistro não informado.";
      $this->erro_campo = "si184_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_contacontabil == null) {
      $this->erro_sql = " Campo si184_contacontabil não informado.";
      $this->erro_campo = "si184_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_atributosf == null) {
      $this->erro_sql = " Campo si184_atributosf não informado.";
      $this->erro_campo = "si184_atributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_codctb == null) {
      $this->erro_sql = " Campo si184_codctb não informado.";
      $this->erro_campo = "si184_codctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_codfontrecursos == null) {
      $this->erro_sql = " Campo si184_codfontrecursos não informado.";
      $this->erro_campo = "si184_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_saldoinicialctb == null) {
      $this->erro_sql = " Campo si184_saldoinicialctb não informado.";
      $this->erro_campo = "si184_saldoinicialctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_naturezasaldoinicialctb == null) {
      $this->erro_sql = " Campo si184_naturezasaldoinicialctb não informado.";
      $this->erro_campo = "si184_naturezasaldoinicialctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_totaldebitosctb == null) {
      $this->erro_sql = " Campo si184_totaldebitosctb não informado.";
      $this->erro_campo = "si184_totaldebitosctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_totalcreditosctb == null) {
      $this->erro_sql = " Campo si184_totalcreditosctb não informado.";
      $this->erro_campo = "si184_totalcreditosctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_saldofinalctb == null) {
      $this->erro_sql = " Campo si184_saldofinalctb não informado.";
      $this->erro_campo = "si184_saldofinalctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_naturezasaldofinalctb == null) {
      $this->erro_sql = " Campo si184_naturezasaldofinalctb não informado.";
      $this->erro_campo = "si184_naturezasaldofinalctb";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_mes == null) {
      $this->erro_sql = " Campo si184_mes não informado.";
      $this->erro_campo = "si184_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si184_instit == null) {
      $this->erro_sql = " Campo si184_instit não informado.";
      $this->erro_campo = "si184_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si184_sequencial == "" || $si184_sequencial == null) {
      $result = db_query("select nextval('balancete172019_si184_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete172019_si184_sequencial_seq do campo: si184_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si184_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete172019_si184_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si184_sequencial)) {
        $this->erro_sql = " Campo si184_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si184_sequencial = $si184_sequencial;
      }
    }
    if (($this->si184_sequencial == null) || ($this->si184_sequencial == "")) {
      $this->erro_sql = " Campo si184_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete172019(
                                       si184_sequencial 
                                      ,si184_tiporegistro 
                                      ,si184_contacontabil 
                                      ,si184_codfundo 
                                      ,si184_atributosf 
                                      ,si184_codctb 
                                      ,si184_codfontrecursos 
                                      ,si184_saldoinicialctb 
                                      ,si184_naturezasaldoinicialctb 
                                      ,si184_totaldebitosctb 
                                      ,si184_totalcreditosctb 
                                      ,si184_saldofinalctb 
                                      ,si184_naturezasaldofinalctb 
                                      ,si184_mes 
                                      ,si184_instit
                                      ,si184_reg10
                       )
                values (
                                $this->si184_sequencial 
                               ,$this->si184_tiporegistro 
                               ,$this->si184_contacontabil 
                               ,'$this->si184_codfundo' 
                               ,'$this->si184_atributosf' 
                               ,$this->si184_codctb 
                               ,$this->si184_codfontrecursos 
                               ,$this->si184_saldoinicialctb 
                               ,'$this->si184_naturezasaldoinicialctb' 
                               ,$this->si184_totaldebitosctb 
                               ,$this->si184_totalcreditosctb 
                               ,$this->si184_saldofinalctb 
                               ,'$this->si184_naturezasaldofinalctb' 
                               ,$this->si184_mes 
                               ,$this->si184_instit
                               ,$this->si184_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete172019 ($this->si184_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete172019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete172019 ($this->si184_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si184_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si184_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,2011809,'$this->si184_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010201,2011809,'','".AddSlashes(pg_result($resaco,0,'si184_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011810,'','".AddSlashes(pg_result($resaco,0,'si184_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011811,'','".AddSlashes(pg_result($resaco,0,'si184_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011812,'','".AddSlashes(pg_result($resaco,0,'si184_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011813,'','".AddSlashes(pg_result($resaco,0,'si184_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011814,'','".AddSlashes(pg_result($resaco,0,'si184_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011815,'','".AddSlashes(pg_result($resaco,0,'si184_saldoinicialctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011816,'','".AddSlashes(pg_result($resaco,0,'si184_naturezasaldoinicialctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011817,'','".AddSlashes(pg_result($resaco,0,'si184_totaldebitosctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011818,'','".AddSlashes(pg_result($resaco,0,'si184_totalcreditosctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011819,'','".AddSlashes(pg_result($resaco,0,'si184_saldofinalctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011820,'','".AddSlashes(pg_result($resaco,0,'si184_naturezasaldofinalctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011821,'','".AddSlashes(pg_result($resaco,0,'si184_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010201,2011822,'','".AddSlashes(pg_result($resaco,0,'si184_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si184_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete172019 set ";
    $virgula = "";
    if (trim($this->si184_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_sequencial"])) {
      $sql .= $virgula . " si184_sequencial = $this->si184_sequencial ";
      $virgula = ",";
      if (trim($this->si184_sequencial) == null) {
        $this->erro_sql = " Campo si184_sequencial não informado.";
        $this->erro_campo = "si184_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"])) {
      $sql .= $virgula . " si184_tiporegistro = $this->si184_tiporegistro ";
      $virgula = ",";
      if (trim($this->si184_tiporegistro) == null) {
        $this->erro_sql = " Campo si184_tiporegistro não informado.";
        $this->erro_campo = "si184_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_contacontabil"])) {
      $sql .= $virgula . " si184_contacontabil = $this->si184_contacontabil ";
      $virgula = ",";
      if (trim($this->si184_contacontabil) == null) {
        $this->erro_sql = " Campo si184_contacontabil não informado.";
        $this->erro_campo = "si184_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_codfundo"])) {
      $sql .= $virgula . " si184_codfundo = '$this->si184_codfundo' ";
      $virgula = ",";
      if (trim($this->si184_codfundo) == null) {
        $this->erro_sql = " Campo si184_codfundo não informado.";
        $this->erro_campo = "si184_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_atributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_atributosf"])) {
      $sql .= $virgula . " si184_atributosf = '$this->si184_atributosf' ";
      $virgula = ",";
      if (trim($this->si184_atributosf) == null) {
        $this->erro_sql = " Campo si184_atributosf não informado.";
        $this->erro_campo = "si184_atributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_codctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_codctb"])) {
      $sql .= $virgula . " si184_codctb = $this->si184_codctb ";
      $virgula = ",";
      if (trim($this->si184_codctb) == null) {
        $this->erro_sql = " Campo si184_codctb não informado.";
        $this->erro_campo = "si184_codctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_codfontrecursos"])) {
      $sql .= $virgula . " si184_codfontrecursos = $this->si184_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si184_codfontrecursos) == null) {
        $this->erro_sql = " Campo si184_codfontrecursos não informado.";
        $this->erro_campo = "si184_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_saldoinicialctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_saldoinicialctb"])) {
      $sql .= $virgula . " si184_saldoinicialctb = $this->si184_saldoinicialctb ";
      $virgula = ",";
      if (trim($this->si184_saldoinicialctb) == null) {
        $this->erro_sql = " Campo si184_saldoinicialctb não informado.";
        $this->erro_campo = "si184_saldoinicialctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_naturezasaldoinicialctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_naturezasaldoinicialctb"])) {
      $sql .= $virgula . " si184_naturezasaldoinicialctb = '$this->si184_naturezasaldoinicialctb' ";
      $virgula = ",";
      if (trim($this->si184_naturezasaldoinicialctb) == null) {
        $this->erro_sql = " Campo si184_naturezasaldoinicialctb não informado.";
        $this->erro_campo = "si184_naturezasaldoinicialctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_totaldebitosctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_totaldebitosctb"])) {
      $sql .= $virgula . " si184_totaldebitosctb = $this->si184_totaldebitosctb ";
      $virgula = ",";
      if (trim($this->si184_totaldebitosctb) == null) {
        $this->erro_sql = " Campo si184_totaldebitosctb não informado.";
        $this->erro_campo = "si184_totaldebitosctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_totalcreditosctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_totalcreditosctb"])) {
      $sql .= $virgula . " si184_totalcreditosctb = $this->si184_totalcreditosctb ";
      $virgula = ",";
      if (trim($this->si184_totalcreditosctb) == null) {
        $this->erro_sql = " Campo si184_totalcreditosctb não informado.";
        $this->erro_campo = "si184_totalcreditosctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_saldofinalctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_saldofinalctb"])) {
      $sql .= $virgula . " si184_saldofinalctb = $this->si184_saldofinalctb ";
      $virgula = ",";
      if (trim($this->si184_saldofinalctb) == null) {
        $this->erro_sql = " Campo si184_saldofinalctb não informado.";
        $this->erro_campo = "si184_saldofinalctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_naturezasaldofinalctb) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_naturezasaldofinalctb"])) {
      $sql .= $virgula . " si184_naturezasaldofinalctb = '$this->si184_naturezasaldofinalctb' ";
      $virgula = ",";
      if (trim($this->si184_naturezasaldofinalctb) == null) {
        $this->erro_sql = " Campo si184_naturezasaldofinalctb não informado.";
        $this->erro_campo = "si184_naturezasaldofinalctb";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_mes"])) {
      $sql .= $virgula . " si184_mes = $this->si184_mes ";
      $virgula = ",";
      if (trim($this->si184_mes) == null) {
        $this->erro_sql = " Campo si184_mes não informado.";
        $this->erro_campo = "si184_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si184_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si184_instit"])) {
      $sql .= $virgula . " si184_instit = $this->si184_instit ";
      $virgula = ",";
      if (trim($this->si184_instit) == null) {
        $this->erro_sql = " Campo si184_instit não informado.";
        $this->erro_campo = "si184_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si184_sequencial != null) {
      $sql .= " si184_sequencial = $this->si184_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si184_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          /* $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011809,'$this->si184_sequencial','A')");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_sequencial"]) || $this->si184_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011809,'".AddSlashes(pg_result($resaco,$conresaco,'si184_sequencial'))."','$this->si184_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_tiporegistro"]) || $this->si184_tiporegistro != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011810,'".AddSlashes(pg_result($resaco,$conresaco,'si184_tiporegistro'))."','$this->si184_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_contacontabil"]) || $this->si184_contacontabil != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011811,'".AddSlashes(pg_result($resaco,$conresaco,'si184_contacontabil'))."','$this->si184_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_atributosf"]) || $this->si184_atributosf != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011812,'".AddSlashes(pg_result($resaco,$conresaco,'si184_atributosf'))."','$this->si184_atributosf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_codctb"]) || $this->si184_codctb != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011813,'".AddSlashes(pg_result($resaco,$conresaco,'si184_codctb'))."','$this->si184_codctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_codfontrecursos"]) || $this->si184_codfontrecursos != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011814,'".AddSlashes(pg_result($resaco,$conresaco,'si184_codfontrecursos'))."','$this->si184_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_saldoinicialctb"]) || $this->si184_saldoinicialctb != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011815,'".AddSlashes(pg_result($resaco,$conresaco,'si184_saldoinicialctb'))."','$this->si184_saldoinicialctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_naturezasaldoinicialctb"]) || $this->si184_naturezasaldoinicialctb != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011816,'".AddSlashes(pg_result($resaco,$conresaco,'si184_naturezasaldoinicialctb'))."','$this->si184_naturezasaldoinicialctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_totaldebitosctb"]) || $this->si184_totaldebitosctb != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011817,'".AddSlashes(pg_result($resaco,$conresaco,'si184_totaldebitosctb'))."','$this->si184_totaldebitosctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_totalcreditosctb"]) || $this->si184_totalcreditosctb != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011818,'".AddSlashes(pg_result($resaco,$conresaco,'si184_totalcreditosctb'))."','$this->si184_totalcreditosctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_saldofinalctb"]) || $this->si184_saldofinalctb != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011819,'".AddSlashes(pg_result($resaco,$conresaco,'si184_saldofinalctb'))."','$this->si184_saldofinalctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_naturezasaldofinalctb"]) || $this->si184_naturezasaldofinalctb != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011820,'".AddSlashes(pg_result($resaco,$conresaco,'si184_naturezasaldofinalctb'))."','$this->si184_naturezasaldofinalctb',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_mes"]) || $this->si184_mes != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011821,'".AddSlashes(pg_result($resaco,$conresaco,'si184_mes'))."','$this->si184_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if(isset($GLOBALS["HTTP_POST_VARS"]["si184_instit"]) || $this->si184_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010201,2011822,'".AddSlashes(pg_result($resaco,$conresaco,'si184_instit'))."','$this->si184_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete172019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si184_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete172019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si184_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si184_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si184_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si184_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011809,'$si184_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011809,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011810,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011811,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011812,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_atributosf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011813,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_codctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011814,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011815,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_saldoinicialctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011816,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_naturezasaldoinicialctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011817,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_totaldebitosctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011818,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_totalcreditosctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011819,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_saldofinalctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011820,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_naturezasaldofinalctb'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011821,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010201,2011822,'','".AddSlashes(pg_result($resaco,$iresaco,'si184_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from balancete172019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si184_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si184_sequencial = $si184_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete172019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si184_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete172019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si184_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si184_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete172019";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si184_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete172019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si184_sequencial != null) {
        $sql2 .= " where balancete172019.si184_sequencial = $si184_sequencial ";
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
  function sql_query_file($si184_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete172019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si184_sequencial != null) {
        $sql2 .= " where balancete172019.si184_sequencial = $si184_sequencial ";
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
