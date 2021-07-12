<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete292021
class cl_balancete292021
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
  var $si241_sequencial = 0;
  var $si241_tiporegistro = 0;
  var $si241_contacontabil = 0;
  var $si241_codfundo = null;
  var $si241_atributosf = null;
  var $si241_codfontrecursos = 0;
  var $si241_dividaconsolidada = 0;
  var $si241_saldoinicialfontsf = 0;
  var $si241_naturezasaldoinicialfontsf = null;
  var $si241_totaldebitosfontsf = 0;
  var $si241_totalcreditosfontsf = 0;
  var $si241_saldofinalfontsf = 0;
  var $si241_naturezasaldofinalfontsf = null;
  var $si241_mes = 0;
  var $si241_instit = 0;
  var $si241_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si241_sequencial = int8 = si241_sequencial 
                 si241_tiporegistro = int8 = si241_tiporegistro 
                 si241_contacontabil = int8 = si241_contacontabil 
                 si241_codfundo = varchar(8) = si241_codfundo 
                 si241_atributosf = varchar(1) = si241_atributosf 
                 si241_codfontrecursos = int8 = si241_codfontrecursos 
                 si241_dividaconsolidada = int4 = si241_dividaconsolidada
                 si241_saldoinicialfontsf = float8 = si241_saldoinicialfontsf 
                 si241_naturezasaldoinicialfontsf = varchar(1) = si241_naturezasaldoinicialfontsf 
                 si241_totaldebitosfontsf = float8 = si241_totaldebitosfontsf 
                 si241_totalcreditosfontsf = float8 = si241_totalcreditosfontsf 
                 si241_saldofinalfontsf = float8 = si241_saldofinalfontsf 
                 si241_naturezasaldofinalfontsf = varchar(1) = si241_naturezasaldofinalfontsf 
                 si241_mes = int8 = si241_mes 
                 si241_instit = int8 = si241_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete292021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete292021");
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
      $this->si241_sequencial = ($this->si241_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_sequencial"] : $this->si241_sequencial);
      $this->si241_tiporegistro = ($this->si241_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_tiporegistro"] : $this->si241_tiporegistro);
      $this->si241_contacontabil = ($this->si241_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_contacontabil"] : $this->si241_contacontabil);
      $this->si241_codfundo = ($this->si241_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_codfundo"] : $this->si241_codfundo);
      $this->si241_atributosf = ($this->si241_atributosf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_atributosf"] : $this->si241_atributosf);
      $this->si241_codfontrecursos = ($this->si241_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_codfontrecursos"] : $this->si241_codfontrecursos);
      $this->si241_dividaconsolidada = ($this->si241_dividaconsolidada == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_dividaconsolidada"] : $this->si241_dividaconsolidada);
      $this->si241_saldoinicialfontsf = ($this->si241_saldoinicialfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_saldoinicialfontsf"] : $this->si241_saldoinicialfontsf);
      $this->si241_naturezasaldoinicialfontsf = ($this->si241_naturezasaldoinicialfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_naturezasaldoinicialfontsf"] : $this->si241_naturezasaldoinicialfontsf);
      $this->si241_totaldebitosfontsf = ($this->si241_totaldebitosfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_totaldebitosfontsf"] : $this->si241_totaldebitosfontsf);
      $this->si241_totalcreditosfontsf = ($this->si241_totalcreditosfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_totalcreditosfontsf"] : $this->si241_totalcreditosfontsf);
      $this->si241_saldofinalfontsf = ($this->si241_saldofinalfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_saldofinalfontsf"] : $this->si241_saldofinalfontsf);
      $this->si241_naturezasaldofinalfontsf = ($this->si241_naturezasaldofinalfontsf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_naturezasaldofinalfontsf"] : $this->si241_naturezasaldofinalfontsf);
      $this->si241_mes = ($this->si241_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_mes"] : $this->si241_mes);
      $this->si241_instit = ($this->si241_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_instit"] : $this->si241_instit);
    } else {
      $this->si241_sequencial = ($this->si241_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si241_sequencial"] : $this->si241_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si241_sequencial)
  {
    $this->atualizacampos();
    if ($this->si241_tiporegistro == null) {
      $this->erro_sql = " Campo si241_tiporegistro não informado.";
      $this->erro_campo = "si241_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_contacontabil == null) {
      $this->erro_sql = " Campo si241_contacontabil não informado.";
      $this->erro_campo = "si241_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_atributosf == null) {
      $this->erro_sql = " Campo si241_atributosf não informado.";
      $this->erro_campo = "si241_atributosf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_codfontrecursos == null) {
      $this->erro_sql = " Campo si241_codfontrecursos não informado.";
      $this->erro_campo = "si241_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_dividaconsolidada == null) {
        $this->erro_sql = " Campo si241_dividaconsolidada não informado.";
        $this->erro_campo = "si241_dividaconsolidada";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    if ($this->si241_saldoinicialfontsf == null) {
      $this->erro_sql = " Campo si241_saldoinicialfontsf não informado.";
      $this->erro_campo = "si241_saldoinicialfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_naturezasaldoinicialfontsf == null) {
      $this->erro_sql = " Campo si241_naturezasaldoinicialfontsf não informado.";
      $this->erro_campo = "si241_naturezasaldoinicialfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_totaldebitosfontsf == null) {
      $this->erro_sql = " Campo si241_totaldebitosfontsf não informado.";
      $this->erro_campo = "si241_totaldebitosfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_totalcreditosfontsf == null) {
      $this->erro_sql = " Campo si241_totalcreditosfontsf não informado.";
      $this->erro_campo = "si241_totalcreditosfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_saldofinalfontsf == null) {
      $this->erro_sql = " Campo si241_saldofinalfontsf não informado.";
      $this->erro_campo = "si241_saldofinalfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_naturezasaldofinalfontsf == null) {
      $this->erro_sql = " Campo si241_naturezasaldofinalfontsf não informado.";
      $this->erro_campo = "si241_naturezasaldofinalfontsf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_mes == null) {
      $this->erro_sql = " Campo si241_mes não informado.";
      $this->erro_campo = "si241_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si241_instit == null) {
      $this->erro_sql = " Campo si241_instit não informado.";
      $this->erro_campo = "si241_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si241_sequencial == "" || $si241_sequencial == null) {
      $result = db_query("select nextval('balancete292021_si241_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete292021_si241_sequencial_seq do campo: si241_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si241_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete292021_si241_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si241_sequencial)) {
        $this->erro_sql = " Campo si241_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si241_sequencial = $si241_sequencial;
      }
    }
    if (($this->si241_sequencial == null) || ($this->si241_sequencial == "")) {
      $this->erro_sql = " Campo si241_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete292021(
                                       si241_sequencial 
                                      ,si241_tiporegistro 
                                      ,si241_contacontabil 
                                      ,si241_codfundo 
                                      ,si241_atributosf 
                                      ,si241_codfontrecursos 
                                      ,si241_dividaconsolidada
                                      ,si241_saldoinicialfontsf 
                                      ,si241_naturezasaldoinicialfontsf 
                                      ,si241_totaldebitosfontsf 
                                      ,si241_totalcreditosfontsf 
                                      ,si241_saldofinalfontsf 
                                      ,si241_naturezasaldofinalfontsf 
                                      ,si241_mes 
                                      ,si241_instit
                                      ,si241_reg10
                       )
                values (
                                $this->si241_sequencial 
                               ,$this->si241_tiporegistro 
                               ,$this->si241_contacontabil 
                               ,'$this->si241_codfundo' 
                               ,'$this->si241_atributosf' 
                               ,$this->si241_codfontrecursos 
                               ,$this->si241_dividaconsolidada
                               ,$this->si241_saldoinicialfontsf 
                               ,'$this->si241_naturezasaldoinicialfontsf' 
                               ,$this->si241_totaldebitosfontsf 
                               ,$this->si241_totalcreditosfontsf 
                               ,$this->si241_saldofinalfontsf 
                               ,'$this->si241_naturezasaldofinalfontsf' 
                               ,$this->si241_mes 
                               ,$this->si241_instit
                               ,$this->si241_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete292021 ($this->si241_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete292021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete292021 ($this->si241_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si241_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si241_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete292021 set ";
    $virgula = "";
    if (trim($this->si241_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_sequencial"])) {
      $sql .= $virgula . " si241_sequencial = $this->si241_sequencial ";
      $virgula = ",";
      if (trim($this->si241_sequencial) == null) {
        $this->erro_sql = " Campo si241_sequencial não informado.";
        $this->erro_campo = "si241_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_tiporegistro"])) {
      $sql .= $virgula . " si241_tiporegistro = $this->si241_tiporegistro ";
      $virgula = ",";
      if (trim($this->si241_tiporegistro) == null) {
        $this->erro_sql = " Campo si241_tiporegistro não informado.";
        $this->erro_campo = "si241_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_contacontabil"])) {
      $sql .= $virgula . " si241_contacontabil = $this->si241_contacontabil ";
      $virgula = ",";
      if (trim($this->si241_contacontabil) == null) {
        $this->erro_sql = " Campo si241_contacontabil não informado.";
        $this->erro_campo = "si241_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_codfundo"])) {
      $sql .= $virgula . " si241_codfundo = '$this->si241_codfundo' ";
      $virgula = ",";
      if (trim($this->si241_codfundo) == null) {
        $this->erro_sql = " Campo si241_codfundo não informado.";
        $this->erro_campo = "si241_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_atributosf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_atributosf"])) {
      $sql .= $virgula . " si241_atributosf = '$this->si241_atributosf' ";
      $virgula = ",";
      if (trim($this->si241_atributosf) == null) {
        $this->erro_sql = " Campo si241_atributosf não informado.";
        $this->erro_campo = "si241_atributosf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_codfontrecursos"])) {
      $sql .= $virgula . " si241_codfontrecursos = $this->si241_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si241_codfontrecursos) == null) {
        $this->erro_sql = " Campo si241_codfontrecursos não informado.";
        $this->erro_campo = "si241_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_dividaconsolidada) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_dividaconsolidada"])) {
        $sql .= $virgula . " si241_dividaconsolidada = $this->si241_dividaconsolidada ";
        $virgula = ",";
        if (trim($this->si241_dividaconsolidada) == null) {
          $this->erro_sql = " Campo si241_dividaconsolidada não informado.";
          $this->erro_campo = "si241_dividaconsolidada";
          $this->erro_banco = "";
          $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
          $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
          $this->erro_status = "0";
          
          return false;
        }
      }
    if (trim($this->si241_saldoinicialfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_saldoinicialfontsf"])) {
      $sql .= $virgula . " si241_saldoinicialfontsf = $this->si241_saldoinicialfontsf ";
      $virgula = ",";
      if (trim($this->si241_saldoinicialfontsf) == null) {
        $this->erro_sql = " Campo si241_saldoinicialfontsf não informado.";
        $this->erro_campo = "si241_saldoinicialfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_naturezasaldoinicialfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_naturezasaldoinicialfontsf"])) {
      $sql .= $virgula . " si241_naturezasaldoinicialfontsf = '$this->si241_naturezasaldoinicialfontsf' ";
      $virgula = ",";
      if (trim($this->si241_naturezasaldoinicialfontsf) == null) {
        $this->erro_sql = " Campo si241_naturezasaldoinicialfontsf não informado.";
        $this->erro_campo = "si241_naturezasaldoinicialfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_totaldebitosfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_totaldebitosfontsf"])) {
      $sql .= $virgula . " si241_totaldebitosfontsf = $this->si241_totaldebitosfontsf ";
      $virgula = ",";
      if (trim($this->si241_totaldebitosfontsf) == null) {
        $this->erro_sql = " Campo si241_totaldebitosfontsf não informado.";
        $this->erro_campo = "si241_totaldebitosfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_totalcreditosfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_totalcreditosfontsf"])) {
      $sql .= $virgula . " si241_totalcreditosfontsf = $this->si241_totalcreditosfontsf ";
      $virgula = ",";
      if (trim($this->si241_totalcreditosfontsf) == null) {
        $this->erro_sql = " Campo si241_totalcreditosfontsf não informado.";
        $this->erro_campo = "si241_totalcreditosfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_saldofinalfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_saldofinalfontsf"])) {
      $sql .= $virgula . " si241_saldofinalfontsf = $this->si241_saldofinalfontsf ";
      $virgula = ",";
      if (trim($this->si241_saldofinalfontsf) == null) {
        $this->erro_sql = " Campo si241_saldofinalfontsf não informado.";
        $this->erro_campo = "si241_saldofinalfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_naturezasaldofinalfontsf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_naturezasaldofinalfontsf"])) {
      $sql .= $virgula . " si241_naturezasaldofinalfontsf = '$this->si241_naturezasaldofinalfontsf' ";
      $virgula = ",";
      if (trim($this->si241_naturezasaldofinalfontsf) == null) {
        $this->erro_sql = " Campo si241_naturezasaldofinalfontsf não informado.";
        $this->erro_campo = "si241_naturezasaldofinalfontsf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_mes"])) {
      $sql .= $virgula . " si241_mes = $this->si241_mes ";
      $virgula = ",";
      if (trim($this->si241_mes) == null) {
        $this->erro_sql = " Campo si241_mes não informado.";
        $this->erro_campo = "si241_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si241_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si241_instit"])) {
      $sql .= $virgula . " si241_instit = $this->si241_instit ";
      $virgula = ",";
      if (trim($this->si241_instit) == null) {
        $this->erro_sql = " Campo si241_instit não informado.";
        $this->erro_campo = "si241_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si241_sequencial != null) {
      $sql .= " si241_sequencial = $this->si241_sequencial";
    }

    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete292021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si241_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete292021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si241_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si241_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si241_sequencial = null, $dbwhere = null)
  {

    $sql = " delete from balancete292021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si241_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si241_sequencial = $si241_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete292021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si241_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete292021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si241_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si241_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete292021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si241_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete292021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si241_sequencial != null) {
        $sql2 .= " where balancete292021.si241_sequencial = $si241_sequencial ";
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
  function sql_query_file($si241_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete292021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si241_sequencial != null) {
        $sql2 .= " where balancete292021.si241_sequencial = $si241_sequencial ";
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
