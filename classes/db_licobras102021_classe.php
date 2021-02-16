<?php
//MODULO: sicom
//CLASSE DA ENTIDADE licobras102021
class cl_licobras102021 {
  // cria variaveis de erro
  public $rotulo     = null;
  public $query_sql  = null;
  public $numrows    = 0;
  public $numrows_incluir = 0;
  public $numrows_alterar = 0;
  public $numrows_excluir = 0;
  public $erro_status= null;
  public $erro_sql   = null;
  public $erro_banco = null;
  public $erro_msg   = null;
  public $erro_campo = null;
  public $pagina_retorno = null;
  // cria variaveis do arquivo
  public $si195_sequencial = 0;
  public $si195_tiporegistro = 0;
  public $si195_codorgaoresp = null;
  public $si195_codunidadesubrespestadual = null;
  public $si195_exerciciolicitacao = 0;
  public $si195_nroprocessolicitatorio = null;
  public $si195_objeto = null;
  public $si195_codobra = 0;
  public $si195_linkobra = null;
  public $si195_mes = 0;
  public $si195_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si195_sequencial = int8 = Sequencial
                 si195_tiporegistro = int8 = Tiporegistro
                 si195_codorgaoresp = text = codorgaoresp
                 si195_codunidadesubrespestadual = text = codUnidadeSubRespEstadual
                 si195_exerciciolicitacao = int4 = exercicioLicitacao
                 si195_nroprocessolicitatorio = text = nroProcessoLicitatorio
                 si195_objeto = text = objeto
                 si195_codobra = int8 = codigoobra
                 si195_linkobra = text = linkobra
                 si195_mes = int4 = Mes
                 si195_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licobras102021");
    $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
  }

  //funcao erro
  function erro($mostra,$retorna) {
    if (($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )) {
      echo "<script>alert(\"".$this->erro_msg."\");</script>";
      if ($retorna==true) {
        echo "<script>location.href='".$this->pagina_retorno."'</script>";
      }
    }
  }

  // funcao para atualizar campos
  function atualizacampos($exclusao=false) {
    if ($exclusao==false) {
      $this->si195_sequencial = ($this->si195_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_sequencial"]:$this->si195_sequencial);
      $this->si195_tiporegistro = ($this->si195_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"]:$this->si195_tiporegistro);
      $this->si195_codorgaoresp = ($this->si195_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_codorgaoresp"]:$this->si195_codorgaoresp);
      $this->si195_codunidadesubrespestadual = ($this->si195_codunidadesubrespestadual == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_codunidadesubrespestadual"]:$this->si195_codunidadesubrespestadual);
      $this->si195_exerciciolicitacao = ($this->si195_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_exerciciolicitacao"]:$this->si195_exerciciolicitacao);
      $this->si195_nroprocessolicitatorio = ($this->si195_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_nroprocessolicitatorio"]:$this->si195_nroprocessolicitatorio);
      $this->si195_codobra = ($this->si195_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_codobra"]:$this->si195_codobra);
      $this->si195_linkobra = ($this->si195_linkobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_linkobra"]:$this->si195_linkobra);
      $this->si195_mes = ($this->si195_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_mes"]:$this->si195_mes);
      $this->si195_instit = ($this->si195_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si195_instit"]:$this->si195_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si195_sequencial == null ) {
      $result = db_query("select nextval('licobras102021_si195_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: licobras102021_si195_sequencial_seq do campo: si195_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si195_sequencial = pg_result($result,0,0);
    }
    if ($this->si195_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si195_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_codorgaoresp == null ) {
      $this->erro_sql = " Campo codorgaoresp não informado.";
      $this->erro_campo = "si195_codorgaoresp";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_codunidadesubrespestadual == null ) {
      $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
      $this->erro_campo = "si195_codunidadesubrespestadual";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_exerciciolicitacao == null ) {
      $this->erro_sql = " Campo exercicioLicitacao não informado.";
      $this->erro_campo = "si195_exerciciolicitacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_nroprocessolicitatorio == null ) {
      $this->erro_sql = " Campo nroProcessoLicitatorio não informado.";
      $this->erro_campo = "si195_nroprocessolicitatorio";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_codobra == null ) {
      $this->erro_sql = " Campo codigoobra não informado.";
      $this->erro_campo = "si195_codobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_linkobra == null ) {
      $this->erro_sql = " Campo linkobra não informado.";
      $this->erro_campo = "si195_linkobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si195_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si195_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si195_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into licobras102021(
                                       si195_sequencial
                                      ,si195_tiporegistro
                                      ,si195_codorgaoresp
                                      ,si195_codunidadesubrespestadual
                                      ,si195_exerciciolicitacao
                                      ,si195_nroprocessolicitatorio
                                      ,si195_codobra
                                      ,si195_objeto
                                      ,si195_linkobra
                                      ,si195_mes
                                      ,si195_instit
                       )
                values (
                                $this->si195_sequencial
                               ,$this->si195_tiporegistro
                               ,'$this->si195_codorgaoresp'
                               ,'$this->si195_codunidadesubrespestadual'
                               ,$this->si195_exerciciolicitacao
                               ,'$this->si195_nroprocessolicitatorio'
                               ,$this->si195_codobra
                               ,'$this->si195_objeto'
                               ,'$this->si195_linkobra'
                               ,$this->si195_mes
                               ,$this->si195_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "cadastro de obras () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "cadastro de obras já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "cadastro de obras () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      }
      $this->erro_status = "0";
      $this->numrows_incluir= 0;
      return false;
    }
    $this->erro_banco = "";
    $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
    $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
    $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
    $this->erro_status = "1";
    $this->numrows_incluir= pg_affected_rows($result);
    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
        && ($lSessaoDesativarAccount === false))) {

    }
    return true;
  }

  // funcao para alteracao
  function alterar ( $si195_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update licobras102021 set ";
    $virgula = "";
    if (trim($this->si195_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_sequencial"])) {
      $sql  .= $virgula." si195_sequencial = $this->si195_sequencial ";
      $virgula = ",";
      if (trim($this->si195_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si195_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_tiporegistro"])) {
      $sql  .= $virgula." si195_tiporegistro = $this->si195_tiporegistro ";
      $virgula = ",";
      if (trim($this->si195_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si195_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_codorgaoresp"])) {
      $sql  .= $virgula." si195_codorgaoresp = '$this->si195_codorgaoresp' ";
      $virgula = ",";
      if (trim($this->si195_codorgaoresp) == null ) {
        $this->erro_sql = " Campo codorgaoresp não informado.";
        $this->erro_campo = "si195_codorgaoresp";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_codunidadesubrespestadual)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_codunidadesubrespestadual"])) {
      $sql  .= $virgula." si195_codunidadesubrespestadual = '$this->si195_codunidadesubrespestadual' ";
      $virgula = ",";
      if (trim($this->si195_codunidadesubrespestadual) == null ) {
        $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
        $this->erro_campo = "si195_codunidadesubrespestadual";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_exerciciolicitacao"])) {
      $sql  .= $virgula." si195_exerciciolicitacao = $this->si195_exerciciolicitacao ";
      $virgula = ",";
      if (trim($this->si195_exerciciolicitacao) == null ) {
        $this->erro_sql = " Campo exercicioLicitacao não informado.";
        $this->erro_campo = "si195_exerciciolicitacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_nroprocessolicitatorio"])) {
      $sql  .= $virgula." si195_nroprocessolicitatorio = '$this->si195_nroprocessolicitatorio' ";
      $virgula = ",";
      if (trim($this->si195_nroprocessolicitatorio) == null ) {
        $this->erro_sql = " Campo nroProcessoLicitatorio não informado.";
        $this->erro_campo = "si195_nroprocessolicitatorio";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_codobra"])) {
      $sql  .= $virgula." si195_codobra = $this->si195_codobra ";
      $virgula = ",";
      if (trim($this->si195_codobra) == null ) {
        $this->erro_sql = " Campo codigoobra não informado.";
        $this->erro_campo = "si195_codobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_linkobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_linkobra"])) {
      $sql  .= $virgula." si195_linkobra = '$this->si195_linkobra' ";
      $virgula = ",";
      if (trim($this->si195_linkobra) == null ) {
        $this->erro_sql = " Campo linkobra não informado.";
        $this->erro_campo = "si195_linkobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_mes"])) {
      $sql  .= $virgula." si195_mes = $this->si195_mes ";
      $virgula = ",";
      if (trim($this->si195_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si195_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si195_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si195_instit"])) {
      $sql  .= $virgula." si195_instit = $this->si195_instit ";
      $virgula = ",";
      if (trim($this->si195_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si195_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si195_sequencial = '$si195_sequencial'";     $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro de obras nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro de obras nao foi Alterado. Alteracao Executada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Alteração efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ( $si195_sequencial=null ,$dbwhere=null) {

    $sql = " delete from licobras102021
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si195_sequencial = '$si195_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro de obras nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro de obras nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao do recordset
  function sql_record($sql) {
    $result = db_query($sql);
    if ($result==false) {
      $this->numrows    = 0;
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "Erro ao selecionar os registros.";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $this->numrows = pg_numrows($result);
    if ($this->numrows==0) {
      $this->erro_banco = "";
      $this->erro_sql   = "Record Vazio na Tabela:licobras102021";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si195_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
    $sql = "select ";
    if ($campos != "*" ) {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from licobras102021 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si195_sequencial != "" && $si195_sequencial != null) {
        $sql2 = " where licobras102021.si195_sequencial = '$si195_sequencial'";
      }
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null ) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }

  // funcao do sql
  function sql_query_file ( $si195_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
    $sql = "select ";
    if ($campos != "*" ) {
      $campos_sql = explode("#", $campos);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    } else {
      $sql .= $campos;
    }
    $sql .= " from licobras102021 ";
    $sql2 = "";
    if ($dbwhere=="") {
    } else if ($dbwhere != "") {
      $sql2 = " where $dbwhere";
    }
    $sql .= $sql2;
    if ($ordem != null ) {
      $sql .= " order by ";
      $campos_sql = explode("#", $ordem);
      $virgula = "";
      for($i=0;$i<sizeof($campos_sql);$i++) {
        $sql .= $virgula.$campos_sql[$i];
        $virgula = ",";
      }
    }
    return $sql;
  }
}
?>
