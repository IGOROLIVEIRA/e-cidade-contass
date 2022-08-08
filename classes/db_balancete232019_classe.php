<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete232019
class cl_balancete232019
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
  var $si190_sequencial = 0;
  var $si190_tiporegistro = 0;
  var $si190_contacontabil = 0;
  var $si190_codfundo = null;
  var $si190_naturezareceita = 0;
  var $si190_saldoinicialnatreceita = 0;
  var $si190_naturezasaldoinicialnatreceita = null;
  var $si190_totaldebitosnatreceita = 0;
  var $si190_totalcreditosnatreceita = 0;
  var $si190_saldofinalnatreceita = 0;
  var $si190_naturezasaldofinalnatreceita = null;
  var $si190_mes = 0;
  var $si190_instit = 0;
  var $si190_reg10 = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si190_sequencial = int8 = si190_sequencial 
                 si190_tiporegistro = int8 = si190_tiporegistro 
                 si190_contacontabil = int8 = si190_contacontabil 
                 si190_codfundo = varchar(8) = si190_codfundo 
                 si190_naturezareceita = int8 = si190_naturezareceita 
                 si190_saldoinicialnatreceita = float8 = si190_saldoinicialnatreceita 
                 si190_naturezasaldoinicialnatreceita = varchar(1) = si190_naturezasaldoinicialnatreceita 
                 si190_totaldebitosnatreceita = float8 = si190_totaldebitosnatreceita 
                 si190_totalcreditosnatreceita = float8 = si190_totalcreditosnatreceita 
                 si190_saldofinalnatreceita = float8 = si190_saldofinalnatreceita 
                 si190_naturezasaldofinalnatreceita = varchar(1) = si190_naturezasaldofinalnatreceita 
                 si190_mes = int8 = si190_mes 
                 si190_instit = int8 = si190_instit 
                 si190_reg10 = int8 = si190_reg10 
                 ";
  
  //funcao construtor da classe
  function cl_balancete232019()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete232019");
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
      $this->si190_sequencial = ($this->si190_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_sequencial"] : $this->si190_sequencial);
      $this->si190_tiporegistro = ($this->si190_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"] : $this->si190_tiporegistro);
      $this->si190_contacontabil = ($this->si190_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_contacontabil"] : $this->si190_contacontabil);
      $this->si190_codfundo = ($this->si190_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_codfundo"] : $this->si190_codfundo);
      $this->si190_naturezareceita = ($this->si190_naturezareceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_naturezareceita"] : $this->si190_naturezareceita);
      $this->si190_saldoinicialnatreceita = ($this->si190_saldoinicialnatreceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_saldoinicialnatreceita"] : $this->si190_saldoinicialnatreceita);
      $this->si190_naturezasaldoinicialnatreceita = ($this->si190_naturezasaldoinicialnatreceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_naturezasaldoinicialnatreceita"] : $this->si190_naturezasaldoinicialnatreceita);
      $this->si190_totaldebitosnatreceita = ($this->si190_totaldebitosnatreceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_totaldebitosnatreceita"] : $this->si190_totaldebitosnatreceita);
      $this->si190_totalcreditosnatreceita = ($this->si190_totalcreditosnatreceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_totalcreditosnatreceita"] : $this->si190_totalcreditosnatreceita);
      $this->si190_saldofinalnatreceita = ($this->si190_saldofinalnatreceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_saldofinalnatreceita"] : $this->si190_saldofinalnatreceita);
      $this->si190_naturezasaldofinalnatreceita = ($this->si190_naturezasaldofinalnatreceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_naturezasaldofinalnatreceita"] : $this->si190_naturezasaldofinalnatreceita);
      $this->si190_mes = ($this->si190_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_mes"] : $this->si190_mes);
      $this->si190_instit = ($this->si190_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_instit"] : $this->si190_instit);
      $this->si190_reg10 = ($this->si190_reg10 == "" ? @$GLOBALS["HTTP_POST_VARS"]["si190_reg10"] : $this->si190_reg10);
    } else {
    }
  }
  
  // funcao para inclusao
  function incluir()
  {
    $this->atualizacampos();
    if ($this->si190_tiporegistro == null) {
      $this->erro_sql = " Campo si190_tiporegistro nao Informado.";
      $this->erro_campo = "si190_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_contacontabil == null) {
      $this->erro_sql = " Campo si190_contacontabil nao Informado.";
      $this->erro_campo = "si190_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_naturezareceita == null) {
      $this->erro_sql = " Campo si190_naturezareceita nao Informado.";
      $this->erro_campo = "si190_naturezareceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_saldoinicialnatreceita == null) {
      $this->erro_sql = " Campo si190_saldoinicialnatreceita nao Informado.";
      $this->erro_campo = "si190_saldoinicialnatreceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_naturezasaldoinicialnatreceita == null) {
      $this->erro_sql = " Campo si190_naturezasaldoinicialnatreceita nao Informado.";
      $this->erro_campo = "si190_naturezasaldoinicialnatreceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_totaldebitosnatreceita == null) {
      $this->erro_sql = " Campo si190_totaldebitosnatreceita nao Informado.";
      $this->erro_campo = "si190_totaldebitosnatreceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_totalcreditosnatreceita == null) {
      $this->erro_sql = " Campo si190_totalcreditosnatreceita nao Informado.";
      $this->erro_campo = "si190_totalcreditosnatreceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_saldofinalnatreceita == null) {
      $this->erro_sql = " Campo si190_saldofinalnatreceita nao Informado.";
      $this->erro_campo = "si190_saldofinalnatreceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_naturezasaldofinalnatreceita == null) {
      $this->erro_sql = " Campo si190_naturezasaldofinalnatreceita nao Informado.";
      $this->erro_campo = "si190_naturezasaldofinalnatreceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_mes == null) {
      $this->erro_sql = " Campo si190_mes nao Informado.";
      $this->erro_campo = "si190_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_instit == null) {
      $this->erro_sql = " Campo si190_instit nao Informado.";
      $this->erro_campo = "si190_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si190_reg10 == null) {
      $this->erro_sql = " Campo si190_reg10 nao Informado.";
      $this->erro_campo = "si190_reg10";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete232019(
                                       si190_sequencial 
                                      ,si190_tiporegistro 
                                      ,si190_contacontabil 
                                      ,si190_codfundo 
                                      ,si190_naturezareceita 
                                      ,si190_saldoinicialnatreceita 
                                      ,si190_naturezasaldoinicialnatreceita 
                                      ,si190_totaldebitosnatreceita 
                                      ,si190_totalcreditosnatreceita 
                                      ,si190_saldofinalnatreceita 
                                      ,si190_naturezasaldofinalnatreceita 
                                      ,si190_mes 
                                      ,si190_instit 
                                      ,si190_reg10 
                       )
                values (
                                nextval('balancete232019_si190_sequencial_seq')
                               ,$this->si190_tiporegistro 
                               ,$this->si190_contacontabil 
                               ,'$this->si190_codfundo'
                               ,$this->si190_naturezareceita 
                               ,$this->si190_saldoinicialnatreceita 
                               ,'$this->si190_naturezasaldoinicialnatreceita' 
                               ,$this->si190_totaldebitosnatreceita 
                               ,$this->si190_totalcreditosnatreceita 
                               ,$this->si190_saldofinalnatreceita 
                               ,'$this->si190_naturezasaldofinalnatreceita' 
                               ,$this->si190_mes 
                               ,$this->si190_instit 
                               ,$this->si190_reg10 
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete232019 () nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete232019 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete232019 () nao Incluído. Inclusao Abortada.";
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
    $sql = " update balancete232019 set ";
    $virgula = "";
    if (trim($this->si190_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_sequencial"])) {
      if (trim($this->si190_sequencial) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_sequencial"])) {
        $this->si190_sequencial = "0";
      }
      $sql .= $virgula . " si190_sequencial = $this->si190_sequencial ";
      $virgula = ",";
      if (trim($this->si190_sequencial) == null) {
        $this->erro_sql = " Campo si190_sequencial nao Informado.";
        $this->erro_campo = "si190_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"])) {
      if (trim($this->si190_tiporegistro) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_tiporegistro"])) {
        $this->si190_tiporegistro = "0";
      }
      $sql .= $virgula . " si190_tiporegistro = $this->si190_tiporegistro ";
      $virgula = ",";
      if (trim($this->si190_tiporegistro) == null) {
        $this->erro_sql = " Campo si190_tiporegistro nao Informado.";
        $this->erro_campo = "si190_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_contacontabil"])) {
      if (trim($this->si190_contacontabil) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_contacontabil"])) {
        $this->si190_contacontabil = "0";
      }
      $sql .= $virgula . " si190_contacontabil = $this->si190_contacontabil ";
      $virgula = ",";
      if (trim($this->si190_contacontabil) == null) {
        $this->erro_sql = " Campo si190_contacontabil nao Informado.";
        $this->erro_campo = "si190_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_codfundo"])) {
      if (trim($this->si190_codfundo) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_codfundo"])) {
        $this->si190_codfundo = "0";
      }
      $sql .= $virgula . " si190_codfundo = $this->si190_codfundo ";
      $virgula = ",";
      if (trim($this->si190_codfundo) == null) {
        $this->erro_sql = " Campo si190_codfundo nao Informado.";
        $this->erro_campo = "si190_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_naturezareceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_naturezareceita"])) {
      if (trim($this->si190_naturezareceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_naturezareceita"])) {
        $this->si190_naturezareceita = "0";
      }
      $sql .= $virgula . " si190_naturezareceita = $this->si190_naturezareceita ";
      $virgula = ",";
      if (trim($this->si190_naturezareceita) == null) {
        $this->erro_sql = " Campo si190_naturezareceita nao Informado.";
        $this->erro_campo = "si190_naturezareceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_saldoinicialnatreceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_saldoinicialnatreceita"])) {
      if (trim($this->si190_saldoinicialnatreceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_saldoinicialnatreceita"])) {
        $this->si190_saldoinicialnatreceita = "0";
      }
      $sql .= $virgula . " si190_saldoinicialnatreceita = $this->si190_saldoinicialnatreceita ";
      $virgula = ",";
      if (trim($this->si190_saldoinicialnatreceita) == null) {
        $this->erro_sql = " Campo si190_saldoinicialnatreceita nao Informado.";
        $this->erro_campo = "si190_saldoinicialnatreceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_naturezasaldoinicialnatreceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_naturezasaldoinicialnatreceita"])) {
      $sql .= $virgula . " si190_naturezasaldoinicialnatreceita = '$this->si190_naturezasaldoinicialnatreceita' ";
      $virgula = ",";
      if (trim($this->si190_naturezasaldoinicialnatreceita) == null) {
        $this->erro_sql = " Campo si190_naturezasaldoinicialnatreceita nao Informado.";
        $this->erro_campo = "si190_naturezasaldoinicialnatreceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_totaldebitosnatreceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_totaldebitosnatreceita"])) {
      if (trim($this->si190_totaldebitosnatreceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_totaldebitosnatreceita"])) {
        $this->si190_totaldebitosnatreceita = "0";
      }
      $sql .= $virgula . " si190_totaldebitosnatreceita = $this->si190_totaldebitosnatreceita ";
      $virgula = ",";
      if (trim($this->si190_totaldebitosnatreceita) == null) {
        $this->erro_sql = " Campo si190_totaldebitosnatreceita nao Informado.";
        $this->erro_campo = "si190_totaldebitosnatreceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_totalcreditosnatreceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_totalcreditosnatreceita"])) {
      if (trim($this->si190_totalcreditosnatreceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_totalcreditosnatreceita"])) {
        $this->si190_totalcreditosnatreceita = "0";
      }
      $sql .= $virgula . " si190_totalcreditosnatreceita = $this->si190_totalcreditosnatreceita ";
      $virgula = ",";
      if (trim($this->si190_totalcreditosnatreceita) == null) {
        $this->erro_sql = " Campo si190_totalcreditosnatreceita nao Informado.";
        $this->erro_campo = "si190_totalcreditosnatreceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_saldofinalnatreceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_saldofinalnatreceita"])) {
      if (trim($this->si190_saldofinalnatreceita) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_saldofinalnatreceita"])) {
        $this->si190_saldofinalnatreceita = "0";
      }
      $sql .= $virgula . " si190_saldofinalnatreceita = $this->si190_saldofinalnatreceita ";
      $virgula = ",";
      if (trim($this->si190_saldofinalnatreceita) == null) {
        $this->erro_sql = " Campo si190_saldofinalnatreceita nao Informado.";
        $this->erro_campo = "si190_saldofinalnatreceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_naturezasaldofinalnatreceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_naturezasaldofinalnatreceita"])) {
      $sql .= $virgula . " si190_naturezasaldofinalnatreceita = '$this->si190_naturezasaldofinalnatreceita' ";
      $virgula = ",";
      if (trim($this->si190_naturezasaldofinalnatreceita) == null) {
        $this->erro_sql = " Campo si190_naturezasaldofinalnatreceita nao Informado.";
        $this->erro_campo = "si190_naturezasaldofinalnatreceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_mes"])) {
      if (trim($this->si190_mes) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_mes"])) {
        $this->si190_mes = "0";
      }
      $sql .= $virgula . " si190_mes = $this->si190_mes ";
      $virgula = ",";
      if (trim($this->si190_mes) == null) {
        $this->erro_sql = " Campo si190_mes nao Informado.";
        $this->erro_campo = "si190_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_instit"])) {
      if (trim($this->si190_instit) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_instit"])) {
        $this->si190_instit = "0";
      }
      $sql .= $virgula . " si190_instit = $this->si190_instit ";
      $virgula = ",";
      if (trim($this->si190_instit) == null) {
        $this->erro_sql = " Campo si190_instit nao Informado.";
        $this->erro_campo = "si190_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si190_reg10) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si190_reg10"])) {
      if (trim($this->si190_reg10) == "" && isset($GLOBALS["HTTP_POST_VARS"]["si190_reg10"])) {
        $this->si190_reg10 = "0";
      }
      $sql .= $virgula . " si190_reg10 = $this->si190_reg10 ";
      $virgula = ",";
      if (trim($this->si190_reg10) == null) {
        $this->erro_sql = " Campo si190_reg10 nao Informado.";
        $this->erro_campo = "si190_reg10";
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
      $this->erro_sql = "balancete232019 nao Alterado. Alteracao Abortada.\n";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete232019 nao foi Alterado. Alteracao Executada.\n";
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
  function excluir($si190_sequencial = null, $dbwhere = null)
  {
    $this->atualizacampos(true);
    $sql = " delete from balancete232019
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si190_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si190_sequencial = $si190_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete232019 nao Excluído. Exclusão Abortada.\n";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete232019 nao Encontrado. Exclusão não Efetuada.\n";
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
  function sql_query($oid = null, $campos = "balancete232019.oid,*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete232019 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($oid != "" && $oid != null) {
        $sql2 = " where balancete232019.oid = $oid";
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
    $sql .= " from balancete232019 ";
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
