<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete102021
class cl_balancete102021
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
  var $si177_sequencial = 0;
  var $si177_tiporegistro = 0;
  var $si177_contacontaabil = 0;
  var $si177_codfundo = null;
  var $si177_saldoinicial = 0;
  var $si177_naturezasaldoinicial = null;
  var $si177_totaldebitos = 0;
  var $si177_totalcreditos = 0;
  var $si177_saldofinal = 0;
  var $si177_naturezasaldofinal = null;
  var $si177_mes = 0;
  var $si177_instit = 0;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si177_sequencial = int8 = si177_sequencial 
                 si177_tiporegistro = int8 = si177_tiporegistro 
                 si177_contacontaabil = int8 = si177_contacontaabil 
                 si177_codfundo = varchar(8) = si177_codfundo 
                 si177_saldoinicial = float8 = si177_saldoinicial 
                 si177_naturezasaldoinicial = varchar(1) = si177_naturezasaldoinicial 
                 si177_totaldebitos = float8 = si177_totaldebitos 
                 si177_totalcreditos = float8 = si177_totalcreditos 
                 si177_saldofinal = float8 = si177_saldofinal 
                 si177_naturezasaldofinal = varchar(1) = si177_naturezasaldofinal 
                 si177_mes = int8 = si177_mes 
                 si177_instit = int8 = si177_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete102021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete102021");
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
      $this->si177_sequencial = ($this->si177_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_sequencial"] : $this->si177_sequencial);
      $this->si177_tiporegistro = ($this->si177_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_tiporegistro"] : $this->si177_tiporegistro);
      $this->si177_contacontaabil = ($this->si177_contacontaabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_contacontaabil"] : $this->si177_contacontaabil);
      $this->si177_codfundo = ($this->si177_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_codfundo"] : $this->si177_codfundo);
      $this->si177_saldoinicial = ($this->si177_saldoinicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_saldoinicial"] : $this->si177_saldoinicial);
      $this->si177_naturezasaldoinicial = ($this->si177_naturezasaldoinicial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldoinicial"] : $this->si177_naturezasaldoinicial);
      $this->si177_totaldebitos = ($this->si177_totaldebitos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_totaldebitos"] : $this->si177_totaldebitos);
      $this->si177_totalcreditos = ($this->si177_totalcreditos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_totalcreditos"] : $this->si177_totalcreditos);
      $this->si177_saldofinal = ($this->si177_saldofinal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_saldofinal"] : $this->si177_saldofinal);
      $this->si177_naturezasaldofinal = ($this->si177_naturezasaldofinal == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldofinal"] : $this->si177_naturezasaldofinal);
      $this->si177_mes = ($this->si177_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_mes"] : $this->si177_mes);
      $this->si177_instit = ($this->si177_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_instit"] : $this->si177_instit);
    } else {
      $this->si177_sequencial = ($this->si177_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si177_sequencial"] : $this->si177_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si177_sequencial)
  {
    $this->atualizacampos();
    if ($this->si177_tiporegistro == null) {
      $this->erro_sql = " Campo si177_tiporegistro não informado.";
      $this->erro_campo = "si177_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_contacontaabil == null) {
      $this->erro_sql = " Campo si177_contacontaabil não informado.";
      $this->erro_campo = "si177_contacontaabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_saldoinicial == null) {
      $this->erro_sql = " Campo si177_saldoinicial não informado.";
      $this->erro_campo = "si177_saldoinicial";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_naturezasaldoinicial == null) {
      $this->erro_sql = " Campo si177_naturezasaldoinicial não informado.";
      $this->erro_campo = "si177_naturezasaldoinicial";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_totaldebitos == null) {
      $this->erro_sql = " Campo si177_totaldebitos não informado.";
      $this->erro_campo = "si177_totaldebitos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_totalcreditos == null) {
      $this->erro_sql = " Campo si177_totalcreditos não informado.";
      $this->erro_campo = "si177_totalcreditos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_saldofinal == null) {
      $this->erro_sql = " Campo si177_saldofinal não informado.";
      $this->erro_campo = "si177_saldofinal";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_naturezasaldofinal == null) {
      $this->erro_sql = " Campo si177_naturezasaldofinal não informado.";
      $this->erro_campo = "si177_naturezasaldofinal";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_mes == null) {
      $this->erro_sql = " Campo si177_mes não informado.";
      $this->erro_campo = "si177_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si177_instit == null) {
      $this->erro_sql = " Campo si177_instit não informado.";
      $this->erro_campo = "si177_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si177_sequencial == "" || $si177_sequencial == null) {
      $result = db_query("select nextval('balancete102021_si177_sequencial_seq')");
      
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete102021_si177_sequencial_seq do campo: si177_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si177_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete102021_si177_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si177_sequencial)) {
        $this->erro_sql = " Campo si177_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si177_sequencial = $si177_sequencial;
      }
    }
    if (($this->si177_sequencial == null) || ($this->si177_sequencial == "")) {
      $this->erro_sql = " Campo si177_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete102021(
                                       si177_sequencial 
                                      ,si177_tiporegistro 
                                      ,si177_contacontaabil 
                                      ,si177_codfundo 
                                      ,si177_saldoinicial 
                                      ,si177_naturezasaldoinicial 
                                      ,si177_totaldebitos 
                                      ,si177_totalcreditos 
                                      ,si177_saldofinal 
                                      ,si177_naturezasaldofinal 
                                      ,si177_mes 
                                      ,si177_instit 
                       )
                values (
                                $this->si177_sequencial 
                               ,$this->si177_tiporegistro 
                               ,$this->si177_contacontaabil 
                               ,'$this->si177_codfundo'
                               ,$this->si177_saldoinicial 
                               ,'$this->si177_naturezasaldoinicial' 
                               ,$this->si177_totaldebitos 
                               ,$this->si177_totalcreditos 
                               ,$this->si177_saldofinal 
                               ,'$this->si177_naturezasaldofinal' 
                               ,$this->si177_mes 
                               ,$this->si177_instit 
                      )";
    
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete102021 ($this->si177_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete102021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete102021 ($this->si177_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si177_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si177_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        /*
                 $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
                 $acount = pg_result($resac,0,0);
                 $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
                 $resac = db_query("insert into db_acountkey values($acount,2011701,'$this->si177_sequencial','I')");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011701,'','".AddSlashes(pg_result($resaco,0,'si177_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")"); echo pg_last_error();
                 $resac = db_query("insert into db_acount values($acount,1010192,2011712,'','".AddSlashes(pg_result($resaco,0,'si177_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011702,'','".AddSlashes(pg_result($resaco,0,'si177_contacontaabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011703,'','".AddSlashes(pg_result($resaco,0,'si177_saldoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011704,'','".AddSlashes(pg_result($resaco,0,'si177_naturezasaldoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011705,'','".AddSlashes(pg_result($resaco,0,'si177_totaldebitos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011706,'','".AddSlashes(pg_result($resaco,0,'si177_totalcreditos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011707,'','".AddSlashes(pg_result($resaco,0,'si177_saldofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011708,'','".AddSlashes(pg_result($resaco,0,'si177_naturezasaldofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011709,'','".AddSlashes(pg_result($resaco,0,'si177_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
                 $resac = db_query("insert into db_acount values($acount,1010192,2011710,'','".AddSlashes(pg_result($resaco,0,'si177_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
               */
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si177_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete102021 set ";
    $virgula = "";
    if (trim($this->si177_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_sequencial"])) {
      $sql .= $virgula . " si177_sequencial = $this->si177_sequencial ";
      $virgula = ",";
      if (trim($this->si177_sequencial) == null) {
        $this->erro_sql = " Campo si177_sequencial não informado.";
        $this->erro_campo = "si177_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_tiporegistro"])) {
      $sql .= $virgula . " si177_tiporegistro = $this->si177_tiporegistro ";
      $virgula = ",";
      if (trim($this->si177_tiporegistro) == null) {
        $this->erro_sql = " Campo si177_tiporegistro não informado.";
        $this->erro_campo = "si177_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_contacontaabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_contacontaabil"])) {
      $sql .= $virgula . " si177_contacontaabil = $this->si177_contacontaabil ";
      $virgula = ",";
      if (trim($this->si177_contacontaabil) == null) {
        $this->erro_sql = " Campo si177_contacontaabil não informado.";
        $this->erro_campo = "si177_contacontaabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_codfundo"])) {
      $sql .= $virgula . " si177_codfundo = '$this->si177_codfundo' ";
      $virgula = ",";
      if (trim($this->si177_codfundo) == null) {
        $this->erro_sql = " Campo si177_codfundo não informado.";
        $this->erro_campo = "si177_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_saldoinicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_saldoinicial"])) {
      $sql .= $virgula . " si177_saldoinicial = $this->si177_saldoinicial ";
      $virgula = ",";
      if (trim($this->si177_saldoinicial) == null) {
        $this->erro_sql = " Campo si177_saldoinicial não informado.";
        $this->erro_campo = "si177_saldoinicial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_naturezasaldoinicial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldoinicial"])) {
      $sql .= $virgula . " si177_naturezasaldoinicial = '$this->si177_naturezasaldoinicial' ";
      $virgula = ",";
      if (trim($this->si177_naturezasaldoinicial) == null) {
        $this->erro_sql = " Campo si177_naturezasaldoinicial não informado.";
        $this->erro_campo = "si177_naturezasaldoinicial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_totaldebitos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_totaldebitos"])) {
      $sql .= $virgula . " si177_totaldebitos = $this->si177_totaldebitos ";
      $virgula = ",";
      if (trim($this->si177_totaldebitos) == null) {
        $this->erro_sql = " Campo si177_totaldebitos não informado.";
        $this->erro_campo = "si177_totaldebitos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_totalcreditos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_totalcreditos"])) {
      $sql .= $virgula . " si177_totalcreditos = $this->si177_totalcreditos ";
      $virgula = ",";
      if (trim($this->si177_totalcreditos) == null) {
        $this->erro_sql = " Campo si177_totalcreditos não informado.";
        $this->erro_campo = "si177_totalcreditos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_saldofinal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_saldofinal"])) {
      $sql .= $virgula . " si177_saldofinal = $this->si177_saldofinal ";
      $virgula = ",";
      if (trim($this->si177_saldofinal) == null) {
        $this->erro_sql = " Campo si177_saldofinal não informado.";
        $this->erro_campo = "si177_saldofinal";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_naturezasaldofinal) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldofinal"])) {
      $sql .= $virgula . " si177_naturezasaldofinal = '$this->si177_naturezasaldofinal' ";
      $virgula = ",";
      if (trim($this->si177_naturezasaldofinal) == null) {
        $this->erro_sql = " Campo si177_naturezasaldofinal não informado.";
        $this->erro_campo = "si177_naturezasaldofinal";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_mes"])) {
      $sql .= $virgula . " si177_mes = $this->si177_mes ";
      $virgula = ",";
      if (trim($this->si177_mes) == null) {
        $this->erro_sql = " Campo si177_mes não informado.";
        $this->erro_campo = "si177_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si177_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si177_instit"])) {
      $sql .= $virgula . " si177_instit = $this->si177_instit ";
      $virgula = ",";
      if (trim($this->si177_instit) == null) {
        $this->erro_sql = " Campo si177_instit não informado.";
        $this->erro_campo = "si177_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si177_sequencial != null) {
      $sql .= " si177_sequencial = $this->si177_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si177_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          /*
          $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,2011701,'$this->si177_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_sequencial"]) || $this->si177_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011701,'".AddSlashes(pg_result($resaco,$conresaco,'si177_sequencial'))."','$this->si177_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_tiporegistro"]) || $this->si177_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011712,'".AddSlashes(pg_result($resaco,$conresaco,'si177_tiporegistro'))."','$this->si177_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_contacontaabil"]) || $this->si177_contacontaabil != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011702,'".AddSlashes(pg_result($resaco,$conresaco,'si177_contacontaabil'))."','$this->si177_contacontaabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_saldoinicial"]) || $this->si177_saldoinicial != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011703,'".AddSlashes(pg_result($resaco,$conresaco,'si177_saldoinicial'))."','$this->si177_saldoinicial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldoinicial"]) || $this->si177_naturezasaldoinicial != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011704,'".AddSlashes(pg_result($resaco,$conresaco,'si177_naturezasaldoinicial'))."','$this->si177_naturezasaldoinicial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_totaldebitos"]) || $this->si177_totaldebitos != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011705,'".AddSlashes(pg_result($resaco,$conresaco,'si177_totaldebitos'))."','$this->si177_totaldebitos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_totalcreditos"]) || $this->si177_totalcreditos != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011706,'".AddSlashes(pg_result($resaco,$conresaco,'si177_totalcreditos'))."','$this->si177_totalcreditos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_saldofinal"]) || $this->si177_saldofinal != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011707,'".AddSlashes(pg_result($resaco,$conresaco,'si177_saldofinal'))."','$this->si177_saldofinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_naturezasaldofinal"]) || $this->si177_naturezasaldofinal != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011708,'".AddSlashes(pg_result($resaco,$conresaco,'si177_naturezasaldofinal'))."','$this->si177_naturezasaldofinal',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_mes"]) || $this->si177_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011709,'".AddSlashes(pg_result($resaco,$conresaco,'si177_mes'))."','$this->si177_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si177_instit"]) || $this->si177_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010192,2011710,'".AddSlashes(pg_result($resaco,$conresaco,'si177_instit'))."','$this->si177_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete102021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si177_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete102021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si177_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si177_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si177_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si177_sequencial));
      } else {
        
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
        
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011701,'$si177_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011701,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")"); echo pg_last_error();
          $resac  = db_query("insert into db_acount values($acount,1010192,2011712,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011702,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_contacontaabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011703,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_saldoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011704,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_naturezasaldoinicial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011705,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_totaldebitos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011706,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_totalcreditos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011707,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_saldofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011708,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_naturezasaldofinal'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011709,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010192,2011710,'','".AddSlashes(pg_result($resaco,$iresaco,'si177_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    
    
    $sql = " delete from balancete102021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si177_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si177_sequencial = $si177_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete102021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si177_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete102021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si177_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si177_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete102021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si177_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si177_sequencial != null) {
        $sql2 .= " where balancete102021.si177_sequencial = $si177_sequencial ";
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
  function sql_query_file($si177_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete102021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si177_sequencial != null) {
        $sql2 .= " where balancete102021.si177_sequencial = $si177_sequencial ";
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
