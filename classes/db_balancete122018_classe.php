<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete122018
class cl_balancete122018
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
  var $si179_sequencial = 0;
  var $si179_tiporegistro = 0;
  var $si179_contacontabil = 0;
  var $si179_codfundo = 0;
  var $si179_naturezareceita = 0;
  var $si179_codfontrecursos = 0;
  var $si179_saldoinicialcr = 0;
  var $si179_naturezasaldoinicialcr = null;
  var $si179_totaldebitoscr = 0;
  var $si179_totalcreditoscr = 0;
  var $si179_saldofinalcr = 0;
  var $si179_naturezasaldofinalcr = null;
  var $si179_mes = 0;
  var $si179_instit = 0;
  var $si179_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si179_sequencial = int8 = si179_sequencial 
                 si179_tiporegistro = int8 = si179_tiporegistro 
                 si179_contacontabil = int8 = si179_contacontabil 
                 si179_codfundo = int8 = si179_codfundo 
                 si179_naturezareceita = int8 = si179_naturezareceita 
                 si179_codfontrecursos = int8 = si179_codfontrecursos 
                 si179_saldoinicialcr = float8 = si179_saldoinicialcr 
                 si179_naturezasaldoinicialcr = varchar(1) = si179_naturezasaldoinicialcr 
                 si179_totaldebitoscr = float8 = si179_totaldebitoscr 
                 si179_totalcreditoscr = float8 = si179_totalcreditoscr 
                 si179_saldofinalcr = float8 = si179_saldofinalcr 
                 si179_naturezasaldofinalcr = varchar(1) = si179_naturezasaldofinalcr 
                 si179_mes = int8 = si179_mes 
                 si179_instit = int8 = si179_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete122018()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete122018");
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
      $this->si179_sequencial = ($this->si179_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_sequencial"] : $this->si179_sequencial);
      $this->si179_tiporegistro = ($this->si179_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_tiporegistro"] : $this->si179_tiporegistro);
      $this->si179_contacontabil = ($this->si179_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_contacontabil"] : $this->si179_contacontabil);
      $this->si179_codfundo = ($this->si179_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_codfundo"] : $this->si179_codfundo);
      $this->si179_naturezareceita = ($this->si179_naturezareceita == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_naturezareceita"] : $this->si179_naturezareceita);
      $this->si179_codfontrecursos = ($this->si179_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_codfontrecursos"] : $this->si179_codfontrecursos);
      $this->si179_saldoinicialcr = ($this->si179_saldoinicialcr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_saldoinicialcr"] : $this->si179_saldoinicialcr);
      $this->si179_naturezasaldoinicialcr = ($this->si179_naturezasaldoinicialcr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_naturezasaldoinicialcr"] : $this->si179_naturezasaldoinicialcr);
      $this->si179_totaldebitoscr = ($this->si179_totaldebitoscr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_totaldebitoscr"] : $this->si179_totaldebitoscr);
      $this->si179_totalcreditoscr = ($this->si179_totalcreditoscr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_totalcreditoscr"] : $this->si179_totalcreditoscr);
      $this->si179_saldofinalcr = ($this->si179_saldofinalcr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_saldofinalcr"] : $this->si179_saldofinalcr);
      $this->si179_naturezasaldofinalcr = ($this->si179_naturezasaldofinalcr == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_naturezasaldofinalcr"] : $this->si179_naturezasaldofinalcr);
      $this->si179_mes = ($this->si179_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_mes"] : $this->si179_mes);
      $this->si179_instit = ($this->si179_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_instit"] : $this->si179_instit);
    } else {
      $this->si179_sequencial = ($this->si179_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si179_sequencial"] : $this->si179_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si179_sequencial)
  {
    $this->atualizacampos();
    if ($this->si179_tiporegistro == null) {
      $this->erro_sql = " Campo si179_tiporegistro não informado.";
      $this->erro_campo = "si179_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_contacontabil == null) {
      $this->erro_sql = " Campo si179_contacontabil não informado.";
      $this->erro_campo = "si179_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_naturezareceita == null) {
      $this->erro_sql = " Campo si179_naturezareceita não informado.";
      $this->erro_campo = "si179_naturezareceita";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_codfontrecursos == null) {
      $this->erro_sql = " Campo si179_codfontrecursos não informado.";
      $this->erro_campo = "si179_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_saldoinicialcr == null) {
      $this->erro_sql = " Campo si179_saldoinicialcr não informado.";
      $this->erro_campo = "si179_saldoinicialcr";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_naturezasaldoinicialcr == null) {
      $this->erro_sql = " Campo si179_naturezasaldoinicialcr não informado.";
      $this->erro_campo = "si179_naturezasaldoinicialcr";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_totaldebitoscr == null) {
      $this->erro_sql = " Campo si179_totaldebitoscr não informado.";
      $this->erro_campo = "si179_totaldebitoscr";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_totalcreditoscr == null) {
      $this->erro_sql = " Campo si179_totalcreditoscr não informado.";
      $this->erro_campo = "si179_totalcreditoscr";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_saldofinalcr == null) {
      $this->erro_sql = " Campo si179_saldofinalcr não informado.";
      $this->erro_campo = "si179_saldofinalcr";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_naturezasaldofinalcr == null) {
      $this->erro_sql = " Campo si179_naturezasaldofinalcr não informado.";
      $this->erro_campo = "si179_naturezasaldofinalcr";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_mes == null) {
      $this->erro_sql = " Campo si179_mes não informado.";
      $this->erro_campo = "si179_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si179_instit == null) {
      $this->erro_sql = " Campo si179_instit não informado.";
      $this->erro_campo = "si179_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($si179_sequencial == "" || $si179_sequencial == null) {
      $result = db_query("select nextval('balancete122018_si179_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete122018_si179_sequencial_seq do campo: si179_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si179_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete122018_si179_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si179_sequencial)) {
        $this->erro_sql = " Campo si179_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si179_sequencial = $si179_sequencial;
      }
    }
    if (($this->si179_sequencial == null) || ($this->si179_sequencial == "")) {
      $this->erro_sql = " Campo si179_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete122018(
                                       si179_sequencial 
                                      ,si179_tiporegistro 
                                      ,si179_contacontabil 
                                      ,si179_codfundo 
                                      ,si179_naturezareceita 
                                      ,si179_codfontrecursos 
                                      ,si179_saldoinicialcr 
                                      ,si179_naturezasaldoinicialcr 
                                      ,si179_totaldebitoscr 
                                      ,si179_totalcreditoscr 
                                      ,si179_saldofinalcr 
                                      ,si179_naturezasaldofinalcr 
                                      ,si179_mes 
                                      ,si179_instit
                                      ,si179_reg10
                       )
                values (
                                $this->si179_sequencial 
                               ,$this->si179_tiporegistro 
                               ,$this->si179_contacontabil 
                               ,'$this->si179_codfundo' 
                               ,$this->si179_naturezareceita 
                               ,$this->si179_codfontrecursos 
                               ,$this->si179_saldoinicialcr 
                               ,'$this->si179_naturezasaldoinicialcr' 
                               ,$this->si179_totaldebitoscr 
                               ,$this->si179_totalcreditoscr 
                               ,$this->si179_saldofinalcr 
                               ,'$this->si179_naturezasaldofinalcr' 
                               ,$this->si179_mes 
                               ,$this->si179_instit
                               ,$this->si179_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete122018 ($this->si179_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete122018 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete122018 ($this->si179_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si179_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si179_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        /*$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011732,'$this->si179_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010194,2011732,'','" . AddSlashes(pg_result($resaco, 0, 'si179_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011734,'','" . AddSlashes(pg_result($resaco, 0, 'si179_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011735,'','" . AddSlashes(pg_result($resaco, 0, 'si179_contacontabil')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011736,'','" . AddSlashes(pg_result($resaco, 0, 'si179_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011737,'','" . AddSlashes(pg_result($resaco, 0, 'si179_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011738,'','" . AddSlashes(pg_result($resaco, 0, 'si179_saldoinicialcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011739,'','" . AddSlashes(pg_result($resaco, 0, 'si179_naturezasaldoinicialcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011740,'','" . AddSlashes(pg_result($resaco, 0, 'si179_totaldebitoscr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011741,'','" . AddSlashes(pg_result($resaco, 0, 'si179_totalcreditoscr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011742,'','" . AddSlashes(pg_result($resaco, 0, 'si179_saldofinalcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011743,'','" . AddSlashes(pg_result($resaco, 0, 'si179_naturezasaldofinalcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011744,'','" . AddSlashes(pg_result($resaco, 0, 'si179_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010194,2011745,'','" . AddSlashes(pg_result($resaco, 0, 'si179_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si179_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete122018 set ";
    $virgula = "";
    if (trim($this->si179_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_sequencial"])) {
      $sql .= $virgula . " si179_sequencial = $this->si179_sequencial ";
      $virgula = ",";
      if (trim($this->si179_sequencial) == null) {
        $this->erro_sql = " Campo si179_sequencial não informado.";
        $this->erro_campo = "si179_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_tiporegistro"])) {
      $sql .= $virgula . " si179_tiporegistro = $this->si179_tiporegistro ";
      $virgula = ",";
      if (trim($this->si179_tiporegistro) == null) {
        $this->erro_sql = " Campo si179_tiporegistro não informado.";
        $this->erro_campo = "si179_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_contacontabil"])) {
      $sql .= $virgula . " si179_contacontabil = $this->si179_contacontabil ";
      $virgula = ",";
      if (trim($this->si179_contacontabil) == null) {
        $this->erro_sql = " Campo si179_contacontabil não informado.";
        $this->erro_campo = "si179_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_codfundo"])) {
      $sql .= $virgula . " si179_codfundo = '$this->si179_codfundo' ";
      $virgula = ",";
      if (trim($this->si179_codfundo) == null) {
        $this->erro_sql = " Campo si179_codfundo não informado.";
        $this->erro_campo = "si179_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_naturezareceita) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_naturezareceita"])) {
      $sql .= $virgula . " si179_naturezareceita = $this->si179_naturezareceita ";
      $virgula = ",";
      if (trim($this->si179_naturezareceita) == null) {
        $this->erro_sql = " Campo si179_naturezareceita não informado.";
        $this->erro_campo = "si179_naturezareceita";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_codfontrecursos"])) {
      $sql .= $virgula . " si179_codfontrecursos = $this->si179_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si179_codfontrecursos) == null) {
        $this->erro_sql = " Campo si179_codfontrecursos não informado.";
        $this->erro_campo = "si179_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_saldoinicialcr) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_saldoinicialcr"])) {
      $sql .= $virgula . " si179_saldoinicialcr = $this->si179_saldoinicialcr ";
      $virgula = ",";
      if (trim($this->si179_saldoinicialcr) == null) {
        $this->erro_sql = " Campo si179_saldoinicialcr não informado.";
        $this->erro_campo = "si179_saldoinicialcr";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_naturezasaldoinicialcr) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_naturezasaldoinicialcr"])) {
      $sql .= $virgula . " si179_naturezasaldoinicialcr = '$this->si179_naturezasaldoinicialcr' ";
      $virgula = ",";
      if (trim($this->si179_naturezasaldoinicialcr) == null) {
        $this->erro_sql = " Campo si179_naturezasaldoinicialcr não informado.";
        $this->erro_campo = "si179_naturezasaldoinicialcr";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_totaldebitoscr) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_totaldebitoscr"])) {
      $sql .= $virgula . " si179_totaldebitoscr = $this->si179_totaldebitoscr ";
      $virgula = ",";
      if (trim($this->si179_totaldebitoscr) == null) {
        $this->erro_sql = " Campo si179_totaldebitoscr não informado.";
        $this->erro_campo = "si179_totaldebitoscr";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_totalcreditoscr) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_totalcreditoscr"])) {
      $sql .= $virgula . " si179_totalcreditoscr = $this->si179_totalcreditoscr ";
      $virgula = ",";
      if (trim($this->si179_totalcreditoscr) == null) {
        $this->erro_sql = " Campo si179_totalcreditoscr não informado.";
        $this->erro_campo = "si179_totalcreditoscr";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_saldofinalcr) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_saldofinalcr"])) {
      $sql .= $virgula . " si179_saldofinalcr = $this->si179_saldofinalcr ";
      $virgula = ",";
      if (trim($this->si179_saldofinalcr) == null) {
        $this->erro_sql = " Campo si179_saldofinalcr não informado.";
        $this->erro_campo = "si179_saldofinalcr";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_naturezasaldofinalcr) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_naturezasaldofinalcr"])) {
      $sql .= $virgula . " si179_naturezasaldofinalcr = '$this->si179_naturezasaldofinalcr' ";
      $virgula = ",";
      if (trim($this->si179_naturezasaldofinalcr) == null) {
        $this->erro_sql = " Campo si179_naturezasaldofinalcr não informado.";
        $this->erro_campo = "si179_naturezasaldofinalcr";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_mes"])) {
      $sql .= $virgula . " si179_mes = $this->si179_mes ";
      $virgula = ",";
      if (trim($this->si179_mes) == null) {
        $this->erro_sql = " Campo si179_mes não informado.";
        $this->erro_campo = "si179_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si179_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si179_instit"])) {
      $sql .= $virgula . " si179_instit = $this->si179_instit ";
      $virgula = ",";
      if (trim($this->si179_instit) == null) {
        $this->erro_sql = " Campo si179_instit não informado.";
        $this->erro_campo = "si179_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si179_sequencial != null) {
      $sql .= " si179_sequencial = $this->si179_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si179_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          /*$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac = db_query("insert into db_acountkey values($acount,2011732,'$this->si179_sequencial','A')");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_sequencial"]) || $this->si179_sequencial != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011732,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_sequencial')) . "','$this->si179_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_tiporegistro"]) || $this->si179_tiporegistro != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011734,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_tiporegistro')) . "','$this->si179_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_contacontabil"]) || $this->si179_contacontabil != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011735,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_contacontabil')) . "','$this->si179_contacontabil'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_naturezareceita"]) || $this->si179_naturezareceita != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011736,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_naturezareceita')) . "','$this->si179_naturezareceita'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_codfontrecursos"]) || $this->si179_codfontrecursos != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011737,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_codfontrecursos')) . "','$this->si179_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_saldoinicialcr"]) || $this->si179_saldoinicialcr != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011738,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_saldoinicialcr')) . "','$this->si179_saldoinicialcr'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_naturezasaldoinicialcr"]) || $this->si179_naturezasaldoinicialcr != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011739,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_naturezasaldoinicialcr')) . "','$this->si179_naturezasaldoinicialcr'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_totaldebitoscr"]) || $this->si179_totaldebitoscr != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011740,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_totaldebitoscr')) . "','$this->si179_totaldebitoscr'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_totalcreditoscr"]) || $this->si179_totalcreditoscr != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011741,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_totalcreditoscr')) . "','$this->si179_totalcreditoscr'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_saldofinalcr"]) || $this->si179_saldofinalcr != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011742,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_saldofinalcr')) . "','$this->si179_saldofinalcr'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_naturezasaldofinalcr"]) || $this->si179_naturezasaldofinalcr != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011743,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_naturezasaldofinalcr')) . "','$this->si179_naturezasaldofinalcr'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_mes"]) || $this->si179_mes != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011744,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_mes')) . "','$this->si179_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si179_instit"]) || $this->si179_instit != "")
              $resac = db_query("insert into db_acount values($acount,1010194,2011745,'" . AddSlashes(pg_result($resaco, $conresaco, 'si179_instit')) . "','$this->si179_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete122018 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si179_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete122018 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si179_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si179_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si179_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si179_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          $resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac = db_query("insert into db_acountkey values($acount,2011732,'$si179_sequencial','E')");
          $resac = db_query("insert into db_acount values($acount,1010194,2011732,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011734,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011735,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_contacontabil')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011736,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_naturezareceita')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011737,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011738,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_saldoinicialcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011739,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_naturezasaldoinicialcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011740,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_totaldebitoscr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011741,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_totalcreditoscr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011742,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_saldofinalcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011743,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_naturezasaldofinalcr')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011744,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010194,2011745,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si179_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
        }
      }
    }
    $sql = " delete from balancete122018
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si179_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si179_sequencial = $si179_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete122018 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si179_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete122018 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si179_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si179_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete122018";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si179_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete122018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si179_sequencial != null) {
        $sql2 .= " where balancete122018.si179_sequencial = $si179_sequencial ";
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
  function sql_query_file($si179_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete122018 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si179_sequencial != null) {
        $sql2 .= " where balancete122018.si179_sequencial = $si179_sequencial ";
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
