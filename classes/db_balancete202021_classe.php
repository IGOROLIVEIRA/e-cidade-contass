<?
//MODULO: sicom
//CLASSE DA ENTIDADE balancete202021
class cl_balancete202021
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
  var $si187_sequencial = 0;
  var $si187_tiporegistro = 0;
  var $si187_contacontabil = 0;
  var $si187_codfundo = null;
  var $si187_cnpjconsorcio = 0;
  var $si187_tiporecurso = 0;
  var $si187_codfuncao = null;
  var $si187_codsubfuncao = null;
  var $si187_naturezadespesa = 0;
  var $si187_subelemento = null;
  var $si187_codfontrecursos = 0;
  var $si187_saldoinicialconscf = 0;
  var $si187_naturezasaldoinicialconscf = null;
  var $si187_totaldebitosconscf = 0;
  var $si187_totalcreditosconscf = 0;
  var $si187_saldofinalconscf = 0;
  var $si187_naturezasaldofinalconscf = null;
  var $si187_mes = 0;
  var $si187_instit = 0;
  var $si187_reg10;
  // cria propriedade com as variaveis do arquivo
  var $campos = "
                 si187_sequencial = int8 = si187_sequencial 
                 si187_tiporegistro = int8 = si187_tiporegistro 
                 si187_contacontabil = int8 = si187_contacontabil 
                 si187_codfundo = varchar(8) = si187_codfundo 
                 si187_cnpjconsorcio = int8 = si187_cnpjconsorcio 
                 si187_tiporecurso = int4 = si187_tiporecurso 
                 si187_codfuncao = varchar(2) = si187_codfuncao 
                 si187_codsubfuncao = varchar(3) = si187_codsubfuncao 
                 si187_naturezadespesa = int8 = si187_naturezadespesa 
                 si187_subelemento = varchar(2) = si187_subelemento 
                 si187_codfontrecursos = int8 = si187_codfontrecursos 
                 si187_saldoinicialconscf = float8 = si187_saldoinicialconscf 
                 si187_naturezasaldoinicialconscf = varchar(1) = si187_naturezasaldoinicialconscf 
                 si187_totaldebitosconscf = float8 = si187_totaldebitosconscf 
                 si187_totalcreditosconscf = float8 = si187_totalcreditosconscf 
                 si187_saldofinalconscf = float8 = si187_saldofinalconscf 
                 si187_naturezasaldofinalconscf = varchar(1) = si187_naturezasaldofinalconscf 
                 si187_mes = int8 = si187_mes 
                 si187_instit = int8 = si187_instit 
                 ";
  
  //funcao construtor da classe
  function cl_balancete202021()
  {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("balancete202021");
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
      $this->si187_sequencial = ($this->si187_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_sequencial"] : $this->si187_sequencial);
      $this->si187_tiporegistro = ($this->si187_tiporegistro == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_tiporegistro"] : $this->si187_tiporegistro);
      $this->si187_contacontabil = ($this->si187_contacontabil == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_contacontabil"] : $this->si187_contacontabil);
      $this->si187_codfundo = ($this->si187_codfundo == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_codfundo"] : $this->si187_codfundo);
      $this->si187_cnpjconsorcio = ($this->si187_cnpjconsorcio == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_cnpjconsorcio"] : $this->si187_cnpjconsorcio);
      $this->si187_tiporecurso = ($this->si187_tiporecurso == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_tiporecurso"] : $this->si187_tiporecurso);
      $this->si187_codfuncao = ($this->si187_codfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_codfuncao"] : $this->si187_codfuncao);
      $this->si187_codsubfuncao = ($this->si187_codsubfuncao == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_codsubfuncao"] : $this->si187_codsubfuncao);
      $this->si187_naturezadespesa = ($this->si187_naturezadespesa == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_naturezadespesa"] : $this->si187_naturezadespesa);
      $this->si187_subelemento = ($this->si187_subelemento == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_subelemento"] : $this->si187_subelemento);
      $this->si187_codfontrecursos = ($this->si187_codfontrecursos == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_codfontrecursos"] : $this->si187_codfontrecursos);
      $this->si187_saldoinicialconscf = ($this->si187_saldoinicialconscf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_saldoinicialconscf"] : $this->si187_saldoinicialconscf);
      $this->si187_naturezasaldoinicialconscf = ($this->si187_naturezasaldoinicialconscf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_naturezasaldoinicialconscf"] : $this->si187_naturezasaldoinicialconscf);
      $this->si187_totaldebitosconscf = ($this->si187_totaldebitosconscf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_totaldebitosconscf"] : $this->si187_totaldebitosconscf);
      $this->si187_totalcreditosconscf = ($this->si187_totalcreditosconscf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_totalcreditosconscf"] : $this->si187_totalcreditosconscf);
      $this->si187_saldofinalconscf = ($this->si187_saldofinalconscf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_saldofinalconscf"] : $this->si187_saldofinalconscf);
      $this->si187_naturezasaldofinalconscf = ($this->si187_naturezasaldofinalconscf == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_naturezasaldofinalconscf"] : $this->si187_naturezasaldofinalconscf);
      $this->si187_mes = ($this->si187_mes == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_mes"] : $this->si187_mes);
      $this->si187_instit = ($this->si187_instit == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_instit"] : $this->si187_instit);
    } else {
      $this->si187_sequencial = ($this->si187_sequencial == "" ? @$GLOBALS["HTTP_POST_VARS"]["si187_sequencial"] : $this->si187_sequencial);
    }
  }
  
  // funcao para inclusao
  function incluir($si187_sequencial)
  {
    $this->atualizacampos();
    if ($this->si187_tiporegistro == null) {
      $this->erro_sql = " Campo si187_tiporegistro não informado.";
      $this->erro_campo = "si187_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_contacontabil == null) {
      $this->erro_sql = " Campo si187_contacontabil não informado.";
      $this->erro_campo = "si187_contacontabil";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_cnpjconsorcio == null) {
      $this->erro_sql = " Campo si187_cnpjconsorcio não informado.";
      $this->erro_campo = "si187_cnpjconsorcio";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_tiporecurso == null) {
      $this->erro_sql = " Campo si187_tiporecurso não informado.";
      $this->erro_campo = "si187_tiporecurso";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_codfuncao == null) {
      $this->erro_sql = " Campo si187_codfuncao não informado.";
      $this->erro_campo = "si187_codfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_codsubfuncao == null) {
      $this->erro_sql = " Campo si187_codsubfuncao não informado.";
      $this->erro_campo = "si187_codsubfuncao";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_naturezadespesa == null) {
      $this->erro_sql = " Campo si187_naturezadespesa não informado.";
      $this->erro_campo = "si187_naturezadespesa";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_subelemento == null) {
      $this->erro_sql = " Campo si187_subelemento não informado.";
      $this->erro_campo = "si187_subelemento";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_codfontrecursos == null) {
      $this->erro_sql = " Campo si187_codfontrecursos não informado.";
      $this->erro_campo = "si187_codfontrecursos";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_saldoinicialconscf == null) {
      $this->erro_sql = " Campo si187_saldoinicialconscf não informado.";
      $this->erro_campo = "si187_saldoinicialconscf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_naturezasaldoinicialconscf == null) {
      $this->erro_sql = " Campo si187_naturezasaldoinicialconscf não informado.";
      $this->erro_campo = "si187_naturezasaldoinicialconscf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_totaldebitosconscf == null) {
      $this->erro_sql = " Campo si187_totaldebitosconscf não informado.";
      $this->erro_campo = "si187_totaldebitosconscf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_totalcreditosconscf == null) {
      $this->erro_sql = " Campo si187_totalcreditosconscf não informado.";
      $this->erro_campo = "si187_totalcreditosconscf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_saldofinalconscf == null) {
      $this->erro_sql = " Campo si187_saldofinalconscf não informado.";
      $this->erro_campo = "si187_saldofinalconscf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_naturezasaldofinalconscf == null) {
      $this->erro_sql = " Campo si187_naturezasaldofinalconscf não informado.";
      $this->erro_campo = "si187_naturezasaldofinalconscf";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_mes == null) {
      $this->erro_sql = " Campo si187_mes não informado.";
      $this->erro_campo = "si187_mes";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if ($this->si187_instit == null) {
      $this->erro_sql = " Campo si187_instit não informado.";
      $this->erro_campo = "si187_instit";
      $this->erro_banco = "";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    if($si187_sequencial == "" || $si187_sequencial == null ){
      $result = db_query("select nextval('balancete202021_si187_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("
","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: balancete202021_si187_sequencial_seq do campo: si187_sequencial";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si187_sequencial = pg_result($result,0,0);
    }else{
      $result = db_query("select last_value from balancete202021_si187_sequencial_seq");
      if(($result != false) && (pg_result($result,0,0) < $si187_sequencial)){
        $this->erro_sql = " Campo si187_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \n\n ".$this->erro_banco." \n"));
        $this->erro_status = "0";
        return false;
      }else{
        $this->si187_sequencial = $si187_sequencial;
      }
    }
    $sql = "insert into balancete202021(
                                       si187_sequencial 
                                      ,si187_tiporegistro 
                                      ,si187_contacontabil 
                                      ,si187_codfundo
                                      ,si187_cnpjconsorcio 
                                      ,si187_tiporecurso 
                                      ,si187_codfuncao 
                                      ,si187_codsubfuncao 
                                      ,si187_naturezadespesa 
                                      ,si187_subelemento 
                                      ,si187_codfontrecursos 
                                      ,si187_saldoinicialconscf 
                                      ,si187_naturezasaldoinicialconscf 
                                      ,si187_totaldebitosconscf 
                                      ,si187_totalcreditosconscf 
                                      ,si187_saldofinalconscf 
                                      ,si187_naturezasaldofinalconscf 
                                      ,si187_mes 
                                      ,si187_instit
                                      ,si187_reg10
                       )
                values (
                                $this->si187_sequencial 
                               ,$this->si187_tiporegistro 
                               ,$this->si187_contacontabil 
                               ,'$this->si187_codfundo' 
                               ,$this->si187_cnpjconsorcio 
                               ,$this->si187_tiporecurso 
                               ,'$this->si187_codfuncao' 
                               ,'$this->si187_codsubfuncao' 
                               ,$this->si187_naturezadespesa 
                               ,'$this->si187_subelemento' 
                               ,$this->si187_codfontrecursos 
                               ,$this->si187_saldoinicialconscf 
                               ,'$this->si187_naturezasaldoinicialconscf' 
                               ,$this->si187_totaldebitosconscf 
                               ,$this->si187_totalcreditosconscf 
                               ,$this->si187_saldofinalconscf 
                               ,'$this->si187_naturezasaldofinalconscf' 
                               ,$this->si187_mes 
                               ,$this->si187_instit
                               ,$this->si187_reg10
                      )";
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      if (strpos(strtolower($this->erro_banco), "duplicate key") != 0) {
        $this->erro_sql = "balancete202021 ($this->si187_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_banco = "balancete202021 já Cadastrado";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      } else {
        $this->erro_sql = "balancete202021 ($this->si187_sequencial) nao Incluído. Inclusao Abortada.";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir = 0;
      
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\n";
    $this->erro_sql .= "Valores : " . $this->si187_sequencial;
    $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
    $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
    $this->erro_status = "1";
    $this->numrows_incluir = pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si187_sequencial));
      if (($resaco != false) || ($this->numrows != 0)) {
        
        /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
        $acount = pg_result($resac,0,0);
        $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
        $resac = db_query("insert into db_acountkey values($acount,2011847,'$this->si187_sequencial','I')");
        $resac = db_query("insert into db_acount values($acount,1010204,2011847,'','".AddSlashes(pg_result($resaco,0,'si187_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011848,'','".AddSlashes(pg_result($resaco,0,'si187_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011849,'','".AddSlashes(pg_result($resaco,0,'si187_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011850,'','".AddSlashes(pg_result($resaco,0,'si187_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011851,'','".AddSlashes(pg_result($resaco,0,'si187_tiporecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011852,'','".AddSlashes(pg_result($resaco,0,'si187_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011853,'','".AddSlashes(pg_result($resaco,0,'si187_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011854,'','".AddSlashes(pg_result($resaco,0,'si187_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011855,'','".AddSlashes(pg_result($resaco,0,'si187_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011856,'','".AddSlashes(pg_result($resaco,0,'si187_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011857,'','".AddSlashes(pg_result($resaco,0,'si187_saldoinicialconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011858,'','".AddSlashes(pg_result($resaco,0,'si187_naturezasaldoinicialconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011859,'','".AddSlashes(pg_result($resaco,0,'si187_totaldebitosconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011860,'','".AddSlashes(pg_result($resaco,0,'si187_totalcreditosconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011861,'','".AddSlashes(pg_result($resaco,0,'si187_saldofinalconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011862,'','".AddSlashes(pg_result($resaco,0,'si187_naturezasaldofinalconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011863,'','".AddSlashes(pg_result($resaco,0,'si187_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
        $resac = db_query("insert into db_acount values($acount,1010204,2011864,'','".AddSlashes(pg_result($resaco,0,'si187_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
      }
    }
    
    return true;
  }
  
  // funcao para alteracao
  function alterar($si187_sequencial = null)
  {
    $this->atualizacampos();
    $sql = " update balancete202021 set ";
    $virgula = "";
    if (trim($this->si187_sequencial) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_sequencial"])) {
      $sql .= $virgula . " si187_sequencial = $this->si187_sequencial ";
      $virgula = ",";
      if (trim($this->si187_sequencial) == null) {
        $this->erro_sql = " Campo si187_sequencial não informado.";
        $this->erro_campo = "si187_sequencial";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_tiporegistro) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_tiporegistro"])) {
      $sql .= $virgula . " si187_tiporegistro = $this->si187_tiporegistro ";
      $virgula = ",";
      if (trim($this->si187_tiporegistro) == null) {
        $this->erro_sql = " Campo si187_tiporegistro não informado.";
        $this->erro_campo = "si187_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_contacontabil) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_contacontabil"])) {
      $sql .= $virgula . " si187_contacontabil = $this->si187_contacontabil ";
      $virgula = ",";
      if (trim($this->si187_contacontabil) == null) {
        $this->erro_sql = " Campo si187_contacontabil não informado.";
        $this->erro_campo = "si187_contacontabil";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_codfundo) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_codfundo"])) {
      $sql .= $virgula . " si187_codfundo = '$this->si187_codfundo' ";
      $virgula = ",";
      if (trim($this->si187_codfundo) == null) {
        $this->erro_sql = " Campo si187_codfundo não informado.";
        $this->erro_campo = "si187_codfundo";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_cnpjconsorcio) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_cnpjconsorcio"])) {
      $sql .= $virgula . " si187_cnpjconsorcio = $this->si187_cnpjconsorcio ";
      $virgula = ",";
      if (trim($this->si187_cnpjconsorcio) == null) {
        $this->erro_sql = " Campo si187_cnpjconsorcio não informado.";
        $this->erro_campo = "si187_cnpjconsorcio";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_tiporecurso) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_tiporecurso"])) {
      $sql .= $virgula . " si187_tiporecurso = $this->si187_tiporecurso ";
      $virgula = ",";
      if (trim($this->si187_tiporecurso) == null) {
        $this->erro_sql = " Campo si187_tiporecurso não informado.";
        $this->erro_campo = "si187_tiporecurso";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_codfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_codfuncao"])) {
      $sql .= $virgula . " si187_codfuncao = '$this->si187_codfuncao' ";
      $virgula = ",";
      if (trim($this->si187_codfuncao) == null) {
        $this->erro_sql = " Campo si187_codfuncao não informado.";
        $this->erro_campo = "si187_codfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_codsubfuncao) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_codsubfuncao"])) {
      $sql .= $virgula . " si187_codsubfuncao = '$this->si187_codsubfuncao' ";
      $virgula = ",";
      if (trim($this->si187_codsubfuncao) == null) {
        $this->erro_sql = " Campo si187_codsubfuncao não informado.";
        $this->erro_campo = "si187_codsubfuncao";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_naturezadespesa) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_naturezadespesa"])) {
      $sql .= $virgula . " si187_naturezadespesa = $this->si187_naturezadespesa ";
      $virgula = ",";
      if (trim($this->si187_naturezadespesa) == null) {
        $this->erro_sql = " Campo si187_naturezadespesa não informado.";
        $this->erro_campo = "si187_naturezadespesa";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_subelemento) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_subelemento"])) {
      $sql .= $virgula . " si187_subelemento = '$this->si187_subelemento' ";
      $virgula = ",";
      if (trim($this->si187_subelemento) == null) {
        $this->erro_sql = " Campo si187_subelemento não informado.";
        $this->erro_campo = "si187_subelemento";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_codfontrecursos) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_codfontrecursos"])) {
      $sql .= $virgula . " si187_codfontrecursos = $this->si187_codfontrecursos ";
      $virgula = ",";
      if (trim($this->si187_codfontrecursos) == null) {
        $this->erro_sql = " Campo si187_codfontrecursos não informado.";
        $this->erro_campo = "si187_codfontrecursos";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_saldoinicialconscf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_saldoinicialconscf"])) {
      $sql .= $virgula . " si187_saldoinicialconscf = $this->si187_saldoinicialconscf ";
      $virgula = ",";
      if (trim($this->si187_saldoinicialconscf) == null) {
        $this->erro_sql = " Campo si187_saldoinicialconscf não informado.";
        $this->erro_campo = "si187_saldoinicialconscf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_naturezasaldoinicialconscf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_naturezasaldoinicialconscf"])) {
      $sql .= $virgula . " si187_naturezasaldoinicialconscf = '$this->si187_naturezasaldoinicialconscf' ";
      $virgula = ",";
      if (trim($this->si187_naturezasaldoinicialconscf) == null) {
        $this->erro_sql = " Campo si187_naturezasaldoinicialconscf não informado.";
        $this->erro_campo = "si187_naturezasaldoinicialconscf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_totaldebitosconscf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_totaldebitosconscf"])) {
      $sql .= $virgula . " si187_totaldebitosconscf = $this->si187_totaldebitosconscf ";
      $virgula = ",";
      if (trim($this->si187_totaldebitosconscf) == null) {
        $this->erro_sql = " Campo si187_totaldebitosconscf não informado.";
        $this->erro_campo = "si187_totaldebitosconscf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_totalcreditosconscf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_totalcreditosconscf"])) {
      $sql .= $virgula . " si187_totalcreditosconscf = $this->si187_totalcreditosconscf ";
      $virgula = ",";
      if (trim($this->si187_totalcreditosconscf) == null) {
        $this->erro_sql = " Campo si187_totalcreditosconscf não informado.";
        $this->erro_campo = "si187_totalcreditosconscf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_saldofinalconscf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_saldofinalconscf"])) {
      $sql .= $virgula . " si187_saldofinalconscf = $this->si187_saldofinalconscf ";
      $virgula = ",";
      if (trim($this->si187_saldofinalconscf) == null) {
        $this->erro_sql = " Campo si187_saldofinalconscf não informado.";
        $this->erro_campo = "si187_saldofinalconscf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_naturezasaldofinalconscf) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_naturezasaldofinalconscf"])) {
      $sql .= $virgula . " si187_naturezasaldofinalconscf = '$this->si187_naturezasaldofinalconscf' ";
      $virgula = ",";
      if (trim($this->si187_naturezasaldofinalconscf) == null) {
        $this->erro_sql = " Campo si187_naturezasaldofinalconscf não informado.";
        $this->erro_campo = "si187_naturezasaldofinalconscf";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_mes) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_mes"])) {
      $sql .= $virgula . " si187_mes = $this->si187_mes ";
      $virgula = ",";
      if (trim($this->si187_mes) == null) {
        $this->erro_sql = " Campo si187_mes não informado.";
        $this->erro_campo = "si187_mes";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    if (trim($this->si187_instit) != "" || isset($GLOBALS["HTTP_POST_VARS"]["si187_instit"])) {
      $sql .= $virgula . " si187_instit = $this->si187_instit ";
      $virgula = ",";
      if (trim($this->si187_instit) == null) {
        $this->erro_sql = " Campo si187_instit não informado.";
        $this->erro_campo = "si187_instit";
        $this->erro_banco = "";
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "0";
        
        return false;
      }
    }
    $sql .= " where ";
    if ($si187_sequencial != null) {
      $sql .= " si187_sequencial = $this->si187_sequencial";
    }
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      $resaco = $this->sql_record($this->sql_query_file($this->si187_sequencial));
      if ($this->numrows > 0) {
        
        for ($conresaco = 0; $conresaco < $this->numrows; $conresaco++) {
          
          /*$resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac = db_query("insert into db_acountkey values($acount,2011847,'$this->si187_sequencial','A')");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_sequencial"]) || $this->si187_sequencial != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011847,'".AddSlashes(pg_result($resaco,$conresaco,'si187_sequencial'))."','$this->si187_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_tiporegistro"]) || $this->si187_tiporegistro != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011848,'".AddSlashes(pg_result($resaco,$conresaco,'si187_tiporegistro'))."','$this->si187_tiporegistro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_contacontabil"]) || $this->si187_contacontabil != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011849,'".AddSlashes(pg_result($resaco,$conresaco,'si187_contacontabil'))."','$this->si187_contacontabil',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_cnpjconsorcio"]) || $this->si187_cnpjconsorcio != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011850,'".AddSlashes(pg_result($resaco,$conresaco,'si187_cnpjconsorcio'))."','$this->si187_cnpjconsorcio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_tiporecurso"]) || $this->si187_tiporecurso != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011851,'".AddSlashes(pg_result($resaco,$conresaco,'si187_tiporecurso'))."','$this->si187_tiporecurso',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_codfuncao"]) || $this->si187_codfuncao != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011852,'".AddSlashes(pg_result($resaco,$conresaco,'si187_codfuncao'))."','$this->si187_codfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_codsubfuncao"]) || $this->si187_codsubfuncao != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011853,'".AddSlashes(pg_result($resaco,$conresaco,'si187_codsubfuncao'))."','$this->si187_codsubfuncao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_naturezadespesa"]) || $this->si187_naturezadespesa != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011854,'".AddSlashes(pg_result($resaco,$conresaco,'si187_naturezadespesa'))."','$this->si187_naturezadespesa',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_subelemento"]) || $this->si187_subelemento != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011855,'".AddSlashes(pg_result($resaco,$conresaco,'si187_subelemento'))."','$this->si187_subelemento',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_codfontrecursos"]) || $this->si187_codfontrecursos != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011856,'".AddSlashes(pg_result($resaco,$conresaco,'si187_codfontrecursos'))."','$this->si187_codfontrecursos',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_saldoinicialconscf"]) || $this->si187_saldoinicialconscf != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011857,'".AddSlashes(pg_result($resaco,$conresaco,'si187_saldoinicialconscf'))."','$this->si187_saldoinicialconscf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_naturezasaldoinicialconscf"]) || $this->si187_naturezasaldoinicialconscf != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011858,'".AddSlashes(pg_result($resaco,$conresaco,'si187_naturezasaldoinicialconscf'))."','$this->si187_naturezasaldoinicialconscf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_totaldebitosconscf"]) || $this->si187_totaldebitosconscf != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011859,'".AddSlashes(pg_result($resaco,$conresaco,'si187_totaldebitosconscf'))."','$this->si187_totaldebitosconscf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_totalcreditosconscf"]) || $this->si187_totalcreditosconscf != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011860,'".AddSlashes(pg_result($resaco,$conresaco,'si187_totalcreditosconscf'))."','$this->si187_totalcreditosconscf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_saldofinalconscf"]) || $this->si187_saldofinalconscf != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011861,'".AddSlashes(pg_result($resaco,$conresaco,'si187_saldofinalconscf'))."','$this->si187_saldofinalconscf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_naturezasaldofinalconscf"]) || $this->si187_naturezasaldofinalconscf != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011862,'".AddSlashes(pg_result($resaco,$conresaco,'si187_naturezasaldofinalconscf'))."','$this->si187_naturezasaldofinalconscf',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_mes"]) || $this->si187_mes != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011863,'".AddSlashes(pg_result($resaco,$conresaco,'si187_mes'))."','$this->si187_mes',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          if(isset($GLOBALS["HTTP_POST_VARS"]["si187_instit"]) || $this->si187_instit != "")
            $resac = db_query("insert into db_acount values($acount,1010204,2011864,'".AddSlashes(pg_result($resaco,$conresaco,'si187_instit'))."','$this->si187_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $result = db_query($sql);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete202021 nao Alterado. Alteracao Abortada.\n";
      $this->erro_sql .= "Valores : " . $this->si187_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete202021 nao foi Alterado. Alteracao Executada.\n";
        $this->erro_sql .= "Valores : " . $this->si187_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $this->si187_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        
        return true;
      }
    }
  }
  
  // funcao para exclusao
  function excluir($si187_sequencial = null, $dbwhere = null)
  {
    
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount) && ($lSessaoDesativarAccount === false))) {
      
      if ($dbwhere == null || $dbwhere == "") {
        
        $resaco = $this->sql_record($this->sql_query_file($si187_sequencial));
      } else {
        $resaco = $this->sql_record($this->sql_query_file(null, "*", null, $dbwhere));
      }
      if (($resaco != false) || ($this->numrows != 0)) {
        
        for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {
          
          /*$resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
          $acount = pg_result($resac,0,0);
          $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
          $resac  = db_query("insert into db_acountkey values($acount,2011847,'$si187_sequencial','E')");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011847,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011848,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_tiporegistro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011849,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_contacontabil'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011850,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_cnpjconsorcio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011851,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_tiporecurso'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011852,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_codfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011853,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_codsubfuncao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011854,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_naturezadespesa'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011855,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_subelemento'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011856,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_codfontrecursos'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011857,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_saldoinicialconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011858,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_naturezasaldoinicialconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011859,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_totaldebitosconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011860,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_totalcreditosconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011861,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_saldofinalconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011862,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_naturezasaldofinalconscf'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011863,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_mes'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
          $resac  = db_query("insert into db_acount values($acount,1010204,2011864,'','".AddSlashes(pg_result($resaco,$iresaco,'si187_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");*/
        }
      }
    }
    $sql = " delete from balancete202021
                    where ";
    $sql2 = "";
    if ($dbwhere == null || $dbwhere == "") {
      if ($si187_sequencial != "") {
        if ($sql2 != "") {
          $sql2 .= " and ";
        }
        $sql2 .= " si187_sequencial = $si187_sequencial ";
      }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql . $sql2);
    if ($result == false) {
      $this->erro_banco = str_replace("
", "", @pg_last_error());
      $this->erro_sql = "balancete202021 nao Excluído. Exclusão Abortada.\n";
      $this->erro_sql .= "Valores : " . $si187_sequencial;
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      
      return false;
    } else {
      if (pg_affected_rows($result) == 0) {
        $this->erro_banco = "";
        $this->erro_sql = "balancete202021 nao Encontrado. Exclusão não Efetuada.\n";
        $this->erro_sql .= "Valores : " . $si187_sequencial;
        $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
        $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\n";
        $this->erro_sql .= "Valores : " . $si187_sequencial;
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
      $this->erro_sql = "Record Vazio na Tabela:balancete202021";
      $this->erro_msg = "Usuário: \n\n " . $this->erro_sql . " \n\n";
      $this->erro_msg .= str_replace('"', "", str_replace("'", "", "Administrador: \n\n " . $this->erro_banco . " \n"));
      $this->erro_status = "0";
      
      return false;
    }
    
    return $result;
  }
  
  // funcao do sql
  function sql_query($si187_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si187_sequencial != null) {
        $sql2 .= " where balancete202021.si187_sequencial = $si187_sequencial ";
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
  function sql_query_file($si187_sequencial = null, $campos = "*", $ordem = null, $dbwhere = "")
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
    $sql .= " from balancete202021 ";
    $sql2 = "";
    if ($dbwhere == "") {
      if ($si187_sequencial != null) {
        $sql2 .= " where balancete202021.si187_sequencial = $si187_sequencial ";
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
