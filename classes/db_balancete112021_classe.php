<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete112021
class cl_balancete112021
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
  var $si178_sequencial = 0;
  var $si178_tiporegistro = 0;
  var $si178_contacontaabil = 0;
  var $si178_codfundo = null;
  var $si178_codorgao = null;
  var $si178_codunidadesub = null;
  var $si178_codfuncao = null;
  var $si178_codsubfuncao = null;
  var $si178_codprograma = null;
  var $si178_idacao = null;
  var $si178_idsubacao = null;
  var $si178_naturezadespesa = 0;
  var $si178_codfontrecursos = 0;
  var $si178_saldoinicialcd = 0;
  var $si178_naturezasaldoinicialcd = null;
  var $si178_totaldebitoscd = 0;
  var $si178_totalcreditoscd = 0;
  var $si178_saldofinalcd = 0;
  var $si178_naturezasaldofinalcd = null;
  var $si178_mes = 0;
  var $si178_instit = 0;
  var $si178_reg10 = null;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si178_sequencial = int8 = si178_sequencial 
                 si178_tiporegistro = int8 = si178_tiporegistro 
                 si178_contacontaabil = int8 = si178_contacontaabil 
                 si178_codfundo = varchar(8) = si178_codfundo 
                 si178_codorgao = varchar(2) = si178_codorgao 
                 si178_codunidadesub = varchar(8) = si178_codunidadesub 
                 si178_codfuncao = varchar(2) = si178_codfuncao 
                 si178_codsubfuncao = varchar(3) = si178_codsubfuncao 
                 si178_codprograma = text = si178_codprograma 
                 si178_idacao = varchar(4) = si178_idacao 
                 si178_idsubacao = varchar(4) = si178_idsubacao 
                 si178_naturezadespesa = int8 = si178_naturezadespesa 
                 si178_codfontrecursos = int8 = si178_codfontrecursos 
                 si178_saldoinicialcd = float8 = si178_saldoinicialcd 
                 si178_naturezasaldoinicialcd = varchar(1) = si178_naturezasaldoinicialcd 
                 si178_totaldebitoscd = float8 = si178_totaldebitoscd 
                 si178_totalcreditoscd = float8 = si178_totalcreditoscd 
                 si178_saldofinalcd = float8 = si178_saldofinalcd 
                 si178_naturezasaldofinalcd = varchar(1) = si178_naturezasaldofinalcd 
                 si178_mes = int8 = si178_mes 
                 si178_instit = int8 = si178_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete112021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete112021");
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
      $this->si178_sequencial = ($this->si178_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_sequencial"] : $this->si178_sequencial);
      $this->si178_tiporegistro = ($this->si178_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"] : $this->si178_tiporegistro);
      $this->si178_contacontaabil = ($this->si178_contacontaabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_contacontaabil"] : $this->si178_contacontaabil);
      $this->si178_codfundo = ($this->si178_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codfundo"] : $this->si178_codfundo);
      $this->si178_codorgao = ($this->si178_codorgao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codorgao"] : $this->si178_codorgao);
      $this->si178_codunidadesub = ($this->si178_codunidadesub == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codunidadesub"] : $this->si178_codunidadesub);
      $this->si178_codfuncao = ($this->si178_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codfuncao"] : $this->si178_codfuncao);
      $this->si178_codsubfuncao = ($this->si178_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codsubfuncao"] : $this->si178_codsubfuncao);
      $this->si178_codprograma = ($this->si178_codprograma == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codprograma"] : $this->si178_codprograma);
      $this->si178_idacao = ($this->si178_idacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_idacao"] : $this->si178_idacao);
      $this->si178_idsubacao = ($this->si178_idsubacao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_idsubacao"] : $this->si178_idsubacao);
      $this->si178_naturezadespesa = ($this->si178_naturezadespesa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_naturezadespesa"] : $this->si178_naturezadespesa);
      $this->si178_codfontrecursos = ($this->si178_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_codfontrecursos"] : $this->si178_codfontrecursos);
      $this->si178_saldoinicialcd = ($this->si178_saldoinicialcd == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_saldoinicialcd"] : $this->si178_saldoinicialcd);
      $this->si178_naturezasaldoinicialcd = ($this->si178_naturezasaldoinicialcd == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_naturezasaldoinicialcd"] : $this->si178_naturezasaldoinicialcd);
      $this->si178_totaldebitoscd = ($this->si178_totaldebitoscd == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_totaldebitoscd"] : $this->si178_totaldebitoscd);
      $this->si178_totalcreditoscd = ($this->si178_totalcreditoscd == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_totalcreditoscd"] : $this->si178_totalcreditoscd);
      $this->si178_saldofinalcd = ($this->si178_saldofinalcd == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_saldofinalcd"] : $this->si178_saldofinalcd);
      $this->si178_naturezasaldofinalcd = ($this->si178_naturezasaldofinalcd == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_naturezasaldofinalcd"] : $this->si178_naturezasaldofinalcd);
      $this->si178_mes = ($this->si178_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_mes"] : $this->si178_mes);
      $this->si178_instit = ($this->si178_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_instit"] : $this->si178_instit);
    } else {
      $this->si178_sequencial = ($this->si178_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si178_sequencial"] : $this->si178_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si178_sequencial)
  {
    $this->atualizacampos();
    if ($this->si178_tiporegistro == null) {
      $this->erro_sql = " Campo si178_tiporegistro não informado.";
      $this->erro_campo = "si178_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_contacontaabil == null) {
      $this->erro_sql = " Campo si178_contacontaabil não informado.";
      $this->erro_campo = "si178_contacontaabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_codorgao == null) {
      $this->erro_sql = " Campo si178_codorgao não informado.";
      $this->erro_campo = "si178_codorgao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_codunidadesub == null) {
      $this->erro_sql = " Campo si178_codunidadesub não informado.";
      $this->erro_campo = "si178_codunidadesub";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_codfuncao == null) {
      $this->erro_sql = " Campo si178_codfuncao não informado.";
      $this->erro_campo = "si178_codfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_codsubfuncao == null) {
      $this->erro_sql = " Campo si178_codsubfuncao não informado.";
      $this->erro_campo = "si178_codsubfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_codprograma == null) {
      $this->erro_sql = " Campo si178_codprograma não informado.";
      $this->erro_campo = "si178_codprograma";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_idacao == null) {
      $this->erro_sql = " Campo si178_idacao não informado.";
      $this->erro_campo = "si178_idacao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_idsubacao == null) {
      $this->si178_idsubacao = " ";
    }
    if ($this->si178_naturezadespesa == null) {
      $this->erro_sql = " Campo si178_naturezadespesa não informado.";
      $this->erro_campo = "si178_naturezadespesa";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_codfontrecursos == null) {
      $this->erro_sql = " Campo si178_codfontrecursos não informado.";
      $this->erro_campo = "si178_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_saldoinicialcd == null) {
      $this->erro_sql = " Campo si178_saldoinicialcd não informado.";
      $this->erro_campo = "si178_saldoinicialcd";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_naturezasaldoinicialcd == null) {
      $this->erro_sql = " Campo si178_naturezasaldoinicialcd não informado.";
      $this->erro_campo = "si178_naturezasaldoinicialcd";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_totaldebitoscd == null) {
      $this->erro_sql = " Campo si178_totaldebitoscd não informado.";
      $this->erro_campo = "si178_totaldebitoscd";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_totalcreditoscd == null) {
      $this->erro_sql = " Campo si178_totalcreditoscd não informado.";
      $this->erro_campo = "si178_totalcreditoscd";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_saldofinalcd == null) {
      $this->erro_sql = " Campo si178_saldofinalcd não informado.";
      $this->erro_campo = "si178_saldofinalcd";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_naturezasaldofinalcd == null) {
      $this->erro_sql = " Campo si178_naturezasaldofinalcd não informado.";
      $this->erro_campo = "si178_naturezasaldofinalcd";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_mes == null) {
      $this->erro_sql = " Campo si178_mes não informado.";
      $this->erro_campo = "si178_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si178_instit == null) {
      $this->erro_sql = " Campo si178_instit não informado.";
      $this->erro_campo = "si178_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    if ($si178_sequencial == "" || $si178_sequencial == null) {
      $result = db_query("select nextval('balancete112021_si178_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("
", "", @pg_last_error());
        $this->erro_sql = "Verifique o cadastro da sequencia: balancete112021_si178_sequencial_seq do campo: si178_sequencial";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
      $this->si178_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from balancete112021_si178_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) < $si178_sequencial)) {
        $this->erro_sql = " Campo si178_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      } else {
        $this->si178_sequencial = $si178_sequencial;
      }
    }
    if (($this->si178_sequencial == null) || ($this->si178_sequencial == "")) {
      $this->erro_sql = " Campo si178_sequencial nao declarado.";
      $this->erro_banco = "Chave Primaria zerada.";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    $sql = "insert into balancete112021(
                                       si178_sequencial 
                                      ,si178_tiporegistro 
                                      ,si178_contacontaabil 
                                      ,si178_codfundo
                                      ,si178_codorgao 
                                      ,si178_codunidadesub 
                                      ,si178_codfuncao 
                                      ,si178_codsubfuncao 
                                      ,si178_codprograma 
                                      ,si178_idacao 
                                      ,si178_idsubacao 
                                      ,si178_naturezadespesa 
                                      ,si178_codfontrecursos 
                                      ,si178_saldoinicialcd 
                                      ,si178_naturezasaldoinicialcd 
                                      ,si178_totaldebitoscd 
                                      ,si178_totalcreditoscd 
                                      ,si178_saldofinalcd 
                                      ,si178_naturezasaldofinalcd 
                                      ,si178_mes 
                                      ,si178_instit
                                      ,si178_reg10
                       )
                values (
                                $this->si178_sequencial 
                               ,$this->si178_tiporegistro 
                               ,$this->si178_contacontaabil 
                               ,'$this->si178_codfundo'
                               ,'$this->si178_codorgao' 
                               ,'$this->si178_codunidadesub' 
                               ,'$this->si178_codfuncao' 
                               ,'$this->si178_codsubfuncao' 
                               ,'$this->si178_codprograma' 
                               ,'$this->si178_idacao' 
                               ,'$this->si178_idsubacao' 
                               ,$this->si178_naturezadespesa 
                               ,$this->si178_codfontrecursos 
                               ,$this->si178_saldoinicialcd 
                               ,'$this->si178_naturezasaldoinicialcd' 
                               ,$this->si178_totaldebitoscd 
                               ,$this->si178_totalcreditoscd 
                               ,$this->si178_saldofinalcd 
                               ,'$this->si178_naturezasaldofinalcd' 
                               ,$this->si178_mes 
                               ,$this->si178_instit
                               ,$this->si178_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete112021 ($this->si178_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete112021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete112021 ($this->si178_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si178_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si178_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac, 0, 0);
        /*$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
        $resac = db_query("insert into db_acountkey values($acount,2011711,'$this->si178_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010193,2011711,'','" . AddSlashes(pg_result($resaco, 0, 'si178_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011733,'','" . AddSlashes(pg_result($resaco, 0, 'si178_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011713,'','" . AddSlashes(pg_result($resaco, 0, 'si178_contacontaabil')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011714,'','" . AddSlashes(pg_result($resaco, 0, 'si178_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011715,'','" . AddSlashes(pg_result($resaco, 0, 'si178_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011716,'','" . AddSlashes(pg_result($resaco, 0, 'si178_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011717,'','" . AddSlashes(pg_result($resaco, 0, 'si178_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011718,'','" . AddSlashes(pg_result($resaco, 0, 'si178_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011719,'','" . AddSlashes(pg_result($resaco, 0, 'si178_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011720,'','" . AddSlashes(pg_result($resaco, 0, 'si178_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011721,'','" . AddSlashes(pg_result($resaco, 0, 'si178_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011723,'','" . AddSlashes(pg_result($resaco, 0, 'si178_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011724,'','" . AddSlashes(pg_result($resaco, 0, 'si178_saldoinicialcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011725,'','" . AddSlashes(pg_result($resaco, 0, 'si178_naturezasaldoinicialcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011726,'','" . AddSlashes(pg_result($resaco, 0, 'si178_totaldebitoscd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011727,'','" . AddSlashes(pg_result($resaco, 0, 'si178_totalcreditoscd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011728,'','" . AddSlashes(pg_result($resaco, 0, 'si178_saldofinalcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011729,'','" . AddSlashes(pg_result($resaco, 0, 'si178_naturezasaldofinalcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011730,'','" . AddSlashes(pg_result($resaco, 0, 'si178_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
        $resac = db_query("insert into db_acount values($acount,1010193,2011731,'','" . AddSlashes(pg_result($resaco, 0, 'si178_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si178_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete112021 set ";
    $virgula = "";
    if (trim($this->si178_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_sequencial"])) {
      $sql .= $virgula . " si178_sequencial = $this->si178_sequencial ";
      $virgula = ",";
      if (trim($this->si178_sequencial) == null) {
        $this->erro_sql = " Campo si178_sequencial não informado.";
        $this->erro_campo = "si178_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"])) {
      $sql .= $virgula . " si178_tiporegistro = $this->si178_tiporegistro ";
      $virgula = ",";
      if (trim($this->si178_tiporegistro) == null) {
        $this->erro_sql = " Campo si178_tiporegistro não informado.";
        $this->erro_campo = "si178_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_contacontaabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_contacontaabil"])) {
      $sql .= $virgula . " si178_contacontaabil = $this->si178_contacontaabil ";
      $virgula = ",";
      if (trim($this->si178_contacontaabil) == null) {
        $this->erro_sql = " Campo si178_contacontaabil não informado.";
        $this->erro_campo = "si178_contacontaabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codfundo"])) {
      $sql .= $virgula . " si178_codfundo = '$this->si178_codfundo' ";
      $virgula = ",";
      if (trim($this->si178_codfundo) == null) {
        $this->erro_sql = " Campo si178_codfundo não informado.";
        $this->erro_campo = "si178_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_codorgao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codorgao"])) {
      $sql .= $virgula . " si178_codorgao = '$this->si178_codorgao' ";
      $virgula = ",";
      if (trim($this->si178_codorgao) == null) {
        $this->erro_sql = " Campo si178_codorgao não informado.";
        $this->erro_campo = "si178_codorgao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_codunidadesub) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codunidadesub"])) {
      $sql .= $virgula . " si178_codunidadesub = '$this->si178_codunidadesub' ";
      $virgula = ",";
      if (trim($this->si178_codunidadesub) == null) {
        $this->erro_sql = " Campo si178_codunidadesub não informado.";
        $this->erro_campo = "si178_codunidadesub";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codfuncao"])) {
      $sql .= $virgula . " si178_codfuncao = '$this->si178_codfuncao' ";
      $virgula = ",";
      if (trim($this->si178_codfuncao) == null) {
        $this->erro_sql = " Campo si178_codfuncao não informado.";
        $this->erro_campo = "si178_codfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_codsubfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codsubfuncao"])) {
      $sql .= $virgula . " si178_codsubfuncao = '$this->si178_codsubfuncao' ";
      $virgula = ",";
      if (trim($this->si178_codsubfuncao) == null) {
        $this->erro_sql = " Campo si178_codsubfuncao não informado.";
        $this->erro_campo = "si178_codsubfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_codprograma) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codprograma"])) {
      $sql .= $virgula . " si178_codprograma = '$this->si178_codprograma' ";
      $virgula = ",";
      if (trim($this->si178_codprograma) == null) {
        $this->erro_sql = " Campo si178_codprograma não informado.";
        $this->erro_campo = "si178_codprograma";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_idacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_idacao"])) {
      $sql .= $virgula . " si178_idacao = '$this->si178_idacao' ";
      $virgula = ",";
      if (trim($this->si178_idacao) == null) {
        $this->erro_sql = " Campo si178_idacao não informado.";
        $this->erro_campo = "si178_idacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_idsubacao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_idsubacao"])) {
      $sql .= $virgula . " si178_idsubacao = '$this->si178_idsubacao' ";
      $virgula = ",";
      if (trim($this->si178_idsubacao) == null) {
        $this->erro_sql = " Campo si178_idsubacao não informado.";
        $this->erro_campo = "si178_idsubacao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_naturezadespesa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_naturezadespesa"])) {
      $sql .= $virgula . " si178_naturezadespesa = $this->si178_naturezadespesa ";
      $virgula = ",";
      if (trim($this->si178_naturezadespesa) == null) {
        $this->erro_sql = " Campo si178_naturezadespesa não informado.";
        $this->erro_campo = "si178_naturezadespesa";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_codfontrecursos"])) {
      $sql .= $virgula . " si178_codfontrecursos = $this->si178_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si178_codfontrecursos) == null) {
        $this->erro_sql = " Campo si178_codfontrecursos não informado.";
        $this->erro_campo = "si178_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_saldoinicialcd) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_saldoinicialcd"])) {
      $sql .= $virgula . " si178_saldoinicialcd = $this->si178_saldoinicialcd ";
      $virgula = ",";
      if (trim($this->si178_saldoinicialcd) == null) {
        $this->erro_sql = " Campo si178_saldoinicialcd não informado.";
        $this->erro_campo = "si178_saldoinicialcd";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_naturezasaldoinicialcd) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_naturezasaldoinicialcd"])) {
      $sql .= $virgula . " si178_naturezasaldoinicialcd = '$this->si178_naturezasaldoinicialcd' ";
      $virgula = ",";
      if (trim($this->si178_naturezasaldoinicialcd) == null) {
        $this->erro_sql = " Campo si178_naturezasaldoinicialcd não informado.";
        $this->erro_campo = "si178_naturezasaldoinicialcd";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_totaldebitoscd) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_totaldebitoscd"])) {
      $sql .= $virgula . " si178_totaldebitoscd = $this->si178_totaldebitoscd ";
      $virgula = ",";
      if (trim($this->si178_totaldebitoscd) == null) {
        $this->erro_sql = " Campo si178_totaldebitoscd não informado.";
        $this->erro_campo = "si178_totaldebitoscd";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_totalcreditoscd) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_totalcreditoscd"])) {
      $sql .= $virgula . " si178_totalcreditoscd = $this->si178_totalcreditoscd ";
      $virgula = ",";
      if (trim($this->si178_totalcreditoscd) == null) {
        $this->erro_sql = " Campo si178_totalcreditoscd não informado.";
        $this->erro_campo = "si178_totalcreditoscd";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_saldofinalcd) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_saldofinalcd"])) {
      $sql .= $virgula . " si178_saldofinalcd = $this->si178_saldofinalcd ";
      $virgula = ",";
      if (trim($this->si178_saldofinalcd) == null) {
        $this->erro_sql = " Campo si178_saldofinalcd não informado.";
        $this->erro_campo = "si178_saldofinalcd";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_naturezasaldofinalcd) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_naturezasaldofinalcd"])) {
      $sql .= $virgula . " si178_naturezasaldofinalcd = '$this->si178_naturezasaldofinalcd' ";
      $virgula = ",";
      if (trim($this->si178_naturezasaldofinalcd) == null) {
        $this->erro_sql = " Campo si178_naturezasaldofinalcd não informado.";
        $this->erro_campo = "si178_naturezasaldofinalcd";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_mes"])) {
      $sql .= $virgula . " si178_mes = $this->si178_mes ";
      $virgula = ",";
      if (trim($this->si178_mes) == null) {
        $this->erro_sql = " Campo si178_mes não informado.";
        $this->erro_campo = "si178_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si178_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si178_instit"])) {
      $sql .= $virgula . " si178_instit = $this->si178_instit ";
      $virgula = ",";
      if (trim($this->si178_instit) == null) {
        $this->erro_sql = " Campo si178_instit não informado.";
        $this->erro_campo = "si178_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si178_sequencial != null) {
      $sql .= " si178_sequencial = $this->si178_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si178_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          /*$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac = db_query("insert into db_acountkey values($acount,2011711,'$this->si178_sequencial','A')");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_sequencial"]) || $this->si178_sequencial != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011711,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_sequencial')) . "','$this->si178_sequencial'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_tiporegistro"]) || $this->si178_tiporegistro != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011733,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_tiporegistro')) . "','$this->si178_tiporegistro'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_contacontaabil"]) || $this->si178_contacontaabil != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011713,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_contacontaabil')) . "','$this->si178_contacontaabil'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_codorgao"]) || $this->si178_codorgao != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011714,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_codorgao')) . "','$this->si178_codorgao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_codunidadesub"]) || $this->si178_codunidadesub != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011715,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_codunidadesub')) . "','$this->si178_codunidadesub'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_codfuncao"]) || $this->si178_codfuncao != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011716,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_codfuncao')) . "','$this->si178_codfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_codsubfuncao"]) || $this->si178_codsubfuncao != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011717,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_codsubfuncao')) . "','$this->si178_codsubfuncao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_codprograma"]) || $this->si178_codprograma != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011718,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_codprograma')) . "','$this->si178_codprograma'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_idacao"]) || $this->si178_idacao != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011719,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_idacao')) . "','$this->si178_idacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_idsubacao"]) || $this->si178_idsubacao != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011720,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_idsubacao')) . "','$this->si178_idsubacao'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_naturezadespesa"]) || $this->si178_naturezadespesa != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011721,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_naturezadespesa')) . "','$this->si178_naturezadespesa'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_codfontrecursos"]) || $this->si178_codfontrecursos != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011723,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_codfontrecursos')) . "','$this->si178_codfontrecursos'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_saldoinicialcd"]) || $this->si178_saldoinicialcd != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011724,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_saldoinicialcd')) . "','$this->si178_saldoinicialcd'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_naturezasaldoinicialcd"]) || $this->si178_naturezasaldoinicialcd != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011725,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_naturezasaldoinicialcd')) . "','$this->si178_naturezasaldoinicialcd'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_totaldebitoscd"]) || $this->si178_totaldebitoscd != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011726,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_totaldebitoscd')) . "','$this->si178_totaldebitoscd'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_totalcreditoscd"]) || $this->si178_totalcreditoscd != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011727,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_totalcreditoscd')) . "','$this->si178_totalcreditoscd'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_saldofinalcd"]) || $this->si178_saldofinalcd != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011728,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_saldofinalcd')) . "','$this->si178_saldofinalcd'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_naturezasaldofinalcd"]) || $this->si178_naturezasaldofinalcd != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011729,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_naturezasaldofinalcd')) . "','$this->si178_naturezasaldofinalcd'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_mes"]) || $this->si178_mes != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011730,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_mes')) . "','$this->si178_mes'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          if (isset($GLOBALS["HTTP_POST_VARS"]["si178_instit"]) || $this->si178_instit != "")
              $resac = db_query("insert into db_acount values($acount,1010193,2011731,'" . AddSlashes(pg_result($resaco, $conresaco, 'si178_instit')) . "','$this->si178_instit'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete112021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si178_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete112021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si178_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si178_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si178_sequencial = null, $dbwhere = null)
  {
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si178_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac, 0, 0);
          /*$resac = db_query("insert into db_acountacesso values($acount," . db_getsession("DB_acessado") . ")");
          $resac = db_query("insert into db_acountkey values($acount,2011711,'$si178_sequencial','E')");
          $resac = db_query("insert into db_acount values($acount,1010193,2011711,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_sequencial')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011733,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_tiporegistro')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011713,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_contacontaabil')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011714,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_codorgao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011715,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_codunidadesub')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011716,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_codfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011717,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_codsubfuncao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011718,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_codprograma')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011719,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_idacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011720,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_idsubacao')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011721,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_naturezadespesa')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011723,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_codfontrecursos')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011724,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_saldoinicialcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011725,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_naturezasaldoinicialcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011726,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_totaldebitoscd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011727,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_totalcreditoscd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011728,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_saldofinalcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011729,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_naturezasaldofinalcd')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011730,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_mes')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
          $resac = db_query("insert into db_acount values($acount,1010193,2011731,'','" . AddSlashes(pg_result($resaco, $iresaco, 'si178_instit')) . "'," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");*/
        }
      }
    }
    $sql = " delete from balancete112021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si178_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si178_sequencial = $si178_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete112021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si178_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete112021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si178_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si178_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete112021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si178_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si178_sequencial != null) {
        $sql2 .= " where balancete112021.si178_sequencial = $si178_sequencial ";
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
  function sql_query_file($si178_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete112021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si178_sequencial != null) {
        $sql2 .= " where balancete112021.si178_sequencial = $si178_sequencial ";
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
