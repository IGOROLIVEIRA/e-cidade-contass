<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete242019
class cl_balancete242019
{
  // cria variaveis de erro
  var $rotulo = null;
  var $query_sql = null;
  var $numrows = 0;
  var $erro_status = null;
  var $erro_sql = null;
  var $erro_banco = null;
  var $erro_msg = null;
  var $erro_campo = null;
  var $pagina_retorno = null;
  // cria variaveis do arquivo
  var $si191_sequencial = 0;
  var $si191_tiporegistro = 0;
  var $si191_contacontabil = 0;
  var $si191_codfundo = null;
  var $si191_codorgao = null;
  var $si191_codunidadesub = null;
  var $si191_saldoinicialorgao = 0;
  var $si191_naturezasaldoinicialorgao = null;
  var $si191_totaldebitosorgao = 0;
  var $si191_totalcreditosorgao = 0;
  var $si191_saldofinalorgao = 0;
  var $si191_naturezasaldofinalorgao = null;
  var $si191_mes = 0;
  var $si191_instit = 0;
  var $si191_reg10 = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si191_sequencial = int8 = si191_sequencial 
                 si191_tiporegistro = int8 = si191_tiporegistro 
                 si191_contacontabil = int8 = si191_contacontabil 
                 si191_codfundo = varchar(8) = si191_codfundo 
                 si191_codorgao = varchar(2) = si191_codorgao 
                 si191_codunidadesub = varchar(8) = si191_codunidadesub 
                 si191_saldoinicialorgao = float8 = si191_saldoinicialorgao 
                 si191_naturezasaldoinicialorgao = varchar(1) = si191_naturezasaldoinicialorgao 
                 si191_totaldebitosorgao = float8 = si191_totaldebitosorgao 
                 si191_totalcreditosorgao = float8 = si191_totalcreditosorgao 
                 si191_saldofinalorgao = float8 = si191_saldofinalorgao 
                 si191_naturezasaldofinalorgao = varchar(1) = si191_naturezasaldofinalorgao 
                 si191_mes = int8 = si191_mes 
                 si191_instit = int8 = si191_instit 
                 si191_reg10 = int8 = si191_reg10
                 ";
  
  //funcao construtor da classe
  function cl_balancete242019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete242019");
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
      $this->si191_sequencial = ($this->si191_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_sequencial"] : $this->si191_sequencial);
      $this->si191_tiporegistro = ($this->si191_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_tiporegistro"] : $this->si191_tiporegistro);
      $this->si191_contacontabil = ($this->si191_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_contacontabil"] : $this->si191_contacontabil);
      $this->si191_codfundo = ($this->si191_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_codfundo"] : $this->si191_codfundo);
      $this->si191_codorgao = ($this->si191_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_codorgao"] : $this->si191_codorgao);
      $this->si191_codunidadesub = ($this->si191_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_codunidadesub"] : $this->si191_codunidadesub);
      $this->si191_saldoinicialorgao = ($this->si191_saldoinicialorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_saldoinicialorgao"] : $this->si191_saldoinicialorgao);
      $this->si191_naturezasaldoinicialorgao = ($this->si191_naturezasaldoinicialorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_naturezasaldoinicialorgao"] : $this->si191_naturezasaldoinicialorgao);
      $this->si191_totaldebitosorgao = ($this->si191_totaldebitosorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_totaldebitosorgao"] : $this->si191_totaldebitosorgao);
      $this->si191_totalcreditosorgao = ($this->si191_totalcreditosorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_totalcreditosorgao"] : $this->si191_totalcreditosorgao);
      $this->si191_saldofinalorgao = ($this->si191_saldofinalorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_saldofinalorgao"] : $this->si191_saldofinalorgao);
      $this->si191_naturezasaldofinalorgao = ($this->si191_naturezasaldofinalorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_naturezasaldofinalorgao"] : $this->si191_naturezasaldofinalorgao);
      $this->si191_mes = ($this->si191_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_mes"] : $this->si191_mes);
      $this->si191_instit = ($this->si191_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_instit"] : $this->si191_instit);
      $this->si191_reg10 = ($this->si191_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si191_reg10"] : $this->si191_reg10);
    } else {
    }
  }
  
  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    
    if ($this->si191_tiporegistro == null) {
      $this->erro_sql = " Campo si191_tiporegistro nao Informado.";
      $this->erro_campo = "si191_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_contacontabil == null) {
      $this->erro_sql = " Campo si191_contacontabil nao Informado.";
      $this->erro_campo = "si191_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_codorgao == null) {
      $this->erro_sql = " Campo si191_codorgao nao Informado.";
      $this->erro_campo = "si191_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_saldoinicialorgao == null) {
      $this->erro_sql = " Campo si191_saldoinicialorgao nao Informado.";
      $this->erro_campo = "si191_saldoinicialorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_naturezasaldoinicialorgao == null) {
      $this->erro_sql = " Campo si191_naturezasaldoinicialorgao nao Informado.";
      $this->erro_campo = "si191_naturezasaldoinicialorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_totaldebitosorgao == null) {
      $this->erro_sql = " Campo si191_totaldebitosorgao nao Informado.";
      $this->erro_campo = "si191_totaldebitosorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_totalcreditosorgao == null) {
      $this->erro_sql = " Campo si191_totalcreditosorgao nao Informado.";
      $this->erro_campo = "si191_totalcreditosorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_saldofinalorgao == null) {
      $this->erro_sql = " Campo si191_saldofinalorgao nao Informado.";
      $this->erro_campo = "si191_saldofinalorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_naturezasaldofinalorgao == null) {
      $this->erro_sql = " Campo si191_naturezasaldofinalorgao nao Informado.";
      $this->erro_campo = "si191_naturezasaldofinalorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_mes == null) {
      $this->erro_sql = " Campo si191_mes nao Informado.";
      $this->erro_campo = "si191_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si191_instit == null) {
      $this->erro_sql = " Campo si191_instit nao Informado.";
      $this->erro_campo = "si191_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    if ($this->si191_reg10 == null) {
      $this->erro_sql = " Campo si191_reg10 nao Informado.";
      $this->erro_campo = "si191_reg10";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    $sql = "insert into balancete242019(
                                       si191_sequencial 
                                      ,si191_tiporegistro 
                                      ,si191_contacontabil 
                                      ,si191_codfundo 
                                      ,si191_codorgao 
                                      ,si191_codunidadesub 
                                      ,si191_saldoinicialorgao 
                                      ,si191_naturezasaldoinicialorgao 
                                      ,si191_totaldebitosorgao 
                                      ,si191_totalcreditosorgao 
                                      ,si191_saldofinalorgao 
                                      ,si191_naturezasaldofinalorgao 
                                      ,si191_mes 
                                      ,si191_instit 
                                      ,si191_reg10
                       )
                values (
                                nextval('balancete242019_si191_sequencial_seq')
                               ,$this->si191_tiporegistro 
                               ,$this->si191_contacontabil 
                               ,'$this->si191_codfundo'
                               ,$this->si191_codorgao 
                               ,'$this->si191_codunidadesub' 
                               ,$this->si191_saldoinicialorgao 
                               ,'$this->si191_naturezasaldoinicialorgao' 
                               ,$this->si191_totaldebitosorgao 
                               ,$this->si191_totalcreditosorgao 
                               ,$this->si191_saldofinalorgao 
                               ,'$this->si191_naturezasaldofinalorgao' 
                               ,$this->si191_mes 
                               ,$this->si191_instit 
                               ,$this->si191_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete242019 () nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete242019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete242019 () nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($oid = null)
  {
    $this->atualizacampos();
    $sql = " update balancete242019 set ";
    $virgula = "";
    if (trim($this->si191_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_sequencial"])) {
      if (trim($this->si191_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_sequencial"])) {
        $this->si191_sequencial = "0";
      }
      $sql .= $virgula . " si191_sequencial = $this->si191_sequencial ";
      $virgula = ",";
      if (trim($this->si191_sequencial) == null) {
        $this->erro_sql = " Campo si191_sequencial nao Informado.";
        $this->erro_campo = "si191_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporegistro"])) {
      if (trim($this->si191_tiporegistro) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_tiporegistro"])) {
        $this->si191_tiporegistro = "0";
      }
      $sql .= $virgula . " si191_tiporegistro = $this->si191_tiporegistro ";
      $virgula = ",";
      if (trim($this->si191_tiporegistro) == null) {
        $this->erro_sql = " Campo si191_tiporegistro nao Informado.";
        $this->erro_campo = "si191_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_contacontabil"])) {
      if (trim($this->si191_contacontabil) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_contacontabil"])) {
        $this->si191_contacontabil = "0";
      }
      $sql .= $virgula . " si191_contacontabil = $this->si191_contacontabil ";
      $virgula = ",";
      if (trim($this->si191_contacontabil) == null) {
        $this->erro_sql = " Campo si191_contacontabil nao Informado.";
        $this->erro_campo = "si191_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_codfundo"])) {
      if (trim($this->si191_codfundo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_codfundo"])) {
        $this->si191_codfundo = "0";
      }
      $sql .= $virgula . " si191_codfundo = $this->si191_codfundo ";
      $virgula = ",";
      if (trim($this->si191_codfundo) == null) {
        $this->erro_sql = " Campo si191_codfundo nao Informado.";
        $this->erro_campo = "si191_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_codorgao"])) {
      if (trim($this->si191_codorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_codorgao"])) {
        $this->si191_codorgao = "0";
      }
      $sql .= $virgula . " si191_codorgao = $this->si191_codorgao ";
      $virgula = ",";
      if (trim($this->si191_codorgao) == null) {
        $this->erro_sql = " Campo si191_codorgao nao Informado.";
        $this->erro_campo = "si191_codorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_codunidadesub"])) {
      if (trim($this->si191_codunidadesub) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_codunidadesub"])) {
        $this->si191_codunidadesub = "0";
      }
      $sql .= $virgula . " si191_codunidadesub = $this->si191_codunidadesub ";
      $virgula = ",";
      if (trim($this->si191_codunidadesub) == null) {
        $this->erro_sql = " Campo si191_codunidadesub nao Informado.";
        $this->erro_campo = "si191_codunidadesub";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_saldoinicialorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_saldoinicialorgao"])) {
      if (trim($this->si191_saldoinicialorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_saldoinicialorgao"])) {
        $this->si191_saldoinicialorgao = "0";
      }
      $sql .= $virgula . " si191_saldoinicialorgao = $this->si191_saldoinicialorgao ";
      $virgula = ",";
      if (trim($this->si191_saldoinicialorgao) == null) {
        $this->erro_sql = " Campo si191_saldoinicialorgao nao Informado.";
        $this->erro_campo = "si191_saldoinicialorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_naturezasaldoinicialorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_naturezasaldoinicialorgao"])) {
      $sql .= $virgula . " si191_naturezasaldoinicialorgao = '$this->si191_naturezasaldoinicialorgao' ";
      $virgula = ",";
      if (trim($this->si191_naturezasaldoinicialorgao) == null) {
        $this->erro_sql = " Campo si191_naturezasaldoinicialorgao nao Informado.";
        $this->erro_campo = "si191_naturezasaldoinicialorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_totaldebitosorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_totaldebitosorgao"])) {
      if (trim($this->si191_totaldebitosorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_totaldebitosorgao"])) {
        $this->si191_totaldebitosorgao = "0";
      }
      $sql .= $virgula . " si191_totaldebitosorgao = $this->si191_totaldebitosorgao ";
      $virgula = ",";
      if (trim($this->si191_totaldebitosorgao) == null) {
        $this->erro_sql = " Campo si191_totaldebitosorgao nao Informado.";
        $this->erro_campo = "si191_totaldebitosorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_totalcreditosorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_totalcreditosorgao"])) {
      if (trim($this->si191_totalcreditosorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_totalcreditosorgao"])) {
        $this->si191_totalcreditosorgao = "0";
      }
      $sql .= $virgula . " si191_totalcreditosorgao = $this->si191_totalcreditosorgao ";
      $virgula = ",";
      if (trim($this->si191_totalcreditosorgao) == null) {
        $this->erro_sql = " Campo si191_totalcreditosorgao nao Informado.";
        $this->erro_campo = "si191_totalcreditosorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_saldofinalorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_saldofinalorgao"])) {
      if (trim($this->si191_saldofinalorgao) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_saldofinalorgao"])) {
        $this->si191_saldofinalorgao = "0";
      }
      $sql .= $virgula . " si191_saldofinalorgao = $this->si191_saldofinalorgao ";
      $virgula = ",";
      if (trim($this->si191_saldofinalorgao) == null) {
        $this->erro_sql = " Campo si191_saldofinalorgao nao Informado.";
        $this->erro_campo = "si191_saldofinalorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_naturezasaldofinalorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_naturezasaldofinalorgao"])) {
      $sql .= $virgula . " si191_naturezasaldofinalorgao = '$this->si191_naturezasaldofinalorgao' ";
      $virgula = ",";
      if (trim($this->si191_naturezasaldofinalorgao) == null) {
        $this->erro_sql = " Campo si191_naturezasaldofinalorgao nao Informado.";
        $this->erro_campo = "si191_naturezasaldofinalorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_mes"])) {
      if (trim($this->si191_mes) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_mes"])) {
        $this->si191_mes = "0";
      }
      $sql .= $virgula . " si191_mes = $this->si191_mes ";
      $virgula = ",";
      if (trim($this->si191_mes) == null) {
        $this->erro_sql = " Campo si191_mes nao Informado.";
        $this->erro_campo = "si191_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si191_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_instit"])) {
      if (trim($this->si191_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_instit"])) {
        $this->si191_instit = "0";
      }
      $sql .= $virgula . " si191_instit = $this->si191_instit ";
      $virgula = ",";
      if (trim($this->si191_instit) == null) {
        $this->erro_sql = " Campo si191_instit nao Informado.";
        $this->erro_campo = "si191_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    
    if (trim($this->si191_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si191_reg10"])) {
      if (trim($this->si191_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si191_reg10"])) {
        $this->si191_reg10 = "0";
      }
      $sql .= $virgula . " si191_reg10 = $this->si191_reg10 ";
      $virgula = ",";
      if (trim($this->si191_reg10) == null) {
        $this->erro_sql = " Campo si191_reg10 nao Informado.";
        $this->erro_campo = "si191_reg10";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where oid = $oid ";
    $result = @pg_exec($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete242019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete242019 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si191_sequencial = null, $dbwhere = null)
  {
    $this->atualizacampos(true);
    $sql = " delete from balancete242019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si191_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si191_sequencial = $si191_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete242019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete242019 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        
        return true;
      }
    }
  }
  
  // funcao do recordset
  function sql_record($sql)
  {
    $result = @pg_query($sql);
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
      $this->erro_sql = "Dados do Grupo nao Encontrado";
      $this->erro_msg = "Usuário: 

 " . $this->erro_sql . " 

";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($oid = null, $campos = "balancete242019.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete242019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where balancete242019.oid = $oid";
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
  function sql_query_file($oid = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete242019 ";
    $sql2 = "";
    if ($dbwhere == "") {
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
