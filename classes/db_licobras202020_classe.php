<?php
//MODULO: sicom
//CLASSE DA ENTIDADE licobras202020
class cl_licobras202020 {
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
  public $si196_sequencial = 0;
  public $si196_tiporegistro = 0;
  public $si196_codorgaoresp = null;
  public $si196_codunidadesubrespestadual = null;
  public $si196_exerciciolicitacao = 0;
  public $si196_nroprocessolicitatorio = null;
  public $si196_codobra = 0;
  public $si196_objeto = null;
  public $si196_linkobra = null;
  public $si196_mes = 0;
  public $si196_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si196_sequencial = int8 = Sequencial
                 si196_tiporegistro = int8 = Tiporegistro
                 si196_codorgaoresp = text = codorgaoresp
                 si196_codunidadesubrespestadual = text = codUnidadeSubRespEstadual
                 si196_exerciciolicitacao = int4 = exercicioLicitacao
                 si196_nroprocessolicitatorio = text = nroProcessoLicitatorio
                 si196_codobra = int8 = codigoobra
                 si196_objeto = text = objeto
                 si196_linkobra = text = linkobra
                 si196_mes = int4 = Mes
                 si196_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licobras202020");
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
      $this->si196_sequencial = ($this->si196_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_sequencial"]:$this->si196_sequencial);
      $this->si196_tiporegistro = ($this->si196_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"]:$this->si196_tiporegistro);
      $this->si196_codorgaoresp = ($this->si196_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_codorgaoresp"]:$this->si196_codorgaoresp);
      $this->si196_codunidadesubrespestadual = ($this->si196_codunidadesubrespestadual == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_codunidadesubrespestadual"]:$this->si196_codunidadesubrespestadual);
      $this->si196_exerciciolicitacao = ($this->si196_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_exerciciolicitacao"]:$this->si196_exerciciolicitacao);
      $this->si196_nroprocessolicitatorio = ($this->si196_nroprocessolicitatorio == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_nroprocessolicitatorio"]:$this->si196_nroprocessolicitatorio);
      $this->si196_codobra = ($this->si196_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_codobra"]:$this->si196_codobra);
      $this->si196_objeto = ($this->si196_objeto == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_objeto"]:$this->si196_objeto);
      $this->si196_linkobra = ($this->si196_linkobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_linkobra"]:$this->si196_linkobra);
      $this->si196_mes = ($this->si196_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_mes"]:$this->si196_mes);
      $this->si196_instit = ($this->si196_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si196_instit"]:$this->si196_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si196_sequencial == null ) {
      $result = db_query("select nextval('licobras202020_si196_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: licobras202020_si196_sequencial_seq do campo: si196_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si196_sequencial = pg_result($result,0,0);
    }
    if ($this->si196_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si196_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_codorgaoresp == null ) {
      $this->erro_sql = " Campo codorgaoresp não informado.";
      $this->erro_campo = "si196_codorgaoresp";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_codunidadesubrespestadual == null ) {
      $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
      $this->erro_campo = "si196_codunidadesubrespestadual";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_exerciciolicitacao == null ) {
      $this->erro_sql = " Campo exercicioLicitacao não informado.";
      $this->erro_campo = "si196_exerciciolicitacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_nroprocessolicitatorio == null ) {
      $this->erro_sql = " Campo nroProcessoLicitatorio não informado.";
      $this->erro_campo = "si196_nroprocessolicitatorio";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_codobra == null ) {
      $this->erro_sql = " Campo codigoobra não informado.";
      $this->erro_campo = "si196_codobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_objeto == null ) {
      $this->erro_sql = " Campo objeto não informado.";
      $this->erro_campo = "si196_objeto";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_linkobra == null ) {
      $this->erro_sql = " Campo linkobra não informado.";
      $this->erro_campo = "si196_linkobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si196_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si196_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si196_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into licobras202020(
                                       si196_sequencial
                                      ,si196_tiporegistro
                                      ,si196_codorgaoresp
                                      ,si196_codunidadesubrespestadual
                                      ,si196_exerciciolicitacao
                                      ,si196_nroprocessolicitatorio
                                      ,si196_codobra
                                      ,si196_objeto
                                      ,si196_linkobra
                                      ,si196_mes
                                      ,si196_instit
                       )
                values (
                                $this->si196_sequencial
                               ,$this->si196_tiporegistro
                               ,'$this->si196_codorgaoresp'
                               ,'$this->si196_codunidadesubrespestadual'
                               ,$this->si196_exerciciolicitacao
                               ,'$this->si196_nroprocessolicitatorio'
                               ,$this->si196_codobra
                               ,'$this->si196_objeto'
                               ,'$this->si196_linkobra'
                               ,$this->si196_mes
                               ,$this->si196_instit
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
  function alterar ( $si196_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update licobras202020 set ";
    $virgula = "";
    if (trim($this->si196_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_sequencial"])) {
      $sql  .= $virgula." si196_sequencial = $this->si196_sequencial ";
      $virgula = ",";
      if (trim($this->si196_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si196_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_tiporegistro"])) {
      $sql  .= $virgula." si196_tiporegistro = $this->si196_tiporegistro ";
      $virgula = ",";
      if (trim($this->si196_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si196_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_codorgaoresp"])) {
      $sql  .= $virgula." si196_codorgaoresp = '$this->si196_codorgaoresp' ";
      $virgula = ",";
      if (trim($this->si196_codorgaoresp) == null ) {
        $this->erro_sql = " Campo codorgaoresp não informado.";
        $this->erro_campo = "si196_codorgaoresp";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_codunidadesubrespestadual)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_codunidadesubrespestadual"])) {
      $sql  .= $virgula." si196_codunidadesubrespestadual = '$this->si196_codunidadesubrespestadual' ";
      $virgula = ",";
      if (trim($this->si196_codunidadesubrespestadual) == null ) {
        $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
        $this->erro_campo = "si196_codunidadesubrespestadual";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_exerciciolicitacao"])) {
      $sql  .= $virgula." si196_exerciciolicitacao = $this->si196_exerciciolicitacao ";
      $virgula = ",";
      if (trim($this->si196_exerciciolicitacao) == null ) {
        $this->erro_sql = " Campo exercicioLicitacao não informado.";
        $this->erro_campo = "si196_exerciciolicitacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_nroprocessolicitatorio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_nroprocessolicitatorio"])) {
      $sql  .= $virgula." si196_nroprocessolicitatorio = '$this->si196_nroprocessolicitatorio' ";
      $virgula = ",";
      if (trim($this->si196_nroprocessolicitatorio) == null ) {
        $this->erro_sql = " Campo nroProcessoLicitatorio não informado.";
        $this->erro_campo = "si196_nroprocessolicitatorio";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_codobra"])) {
      $sql  .= $virgula." si196_codobra = $this->si196_codobra ";
      $virgula = ",";
      if (trim($this->si196_codobra) == null ) {
        $this->erro_sql = " Campo codigoobra não informado.";
        $this->erro_campo = "si196_codobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_objeto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_objeto"])) {
      $sql  .= $virgula." si196_objeto = '$this->si196_objeto' ";
      $virgula = ",";
      if (trim($this->si196_objeto) == null ) {
        $this->erro_sql = " Campo objeto não informado.";
        $this->erro_campo = "si196_objeto";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_linkobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_linkobra"])) {
      $sql  .= $virgula." si196_linkobra = '$this->si196_linkobra' ";
      $virgula = ",";
      if (trim($this->si196_linkobra) == null ) {
        $this->erro_sql = " Campo linkobra não informado.";
        $this->erro_campo = "si196_linkobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_mes"])) {
      $sql  .= $virgula." si196_mes = $this->si196_mes ";
      $virgula = ",";
      if (trim($this->si196_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si196_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si196_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si196_instit"])) {
      $sql  .= $virgula." si196_instit = $this->si196_instit ";
      $virgula = ",";
      if (trim($this->si196_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si196_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si196_sequencial = '$si196_sequencial'";
    $result = db_query($sql);
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
  function excluir ( $si196_sequencial=null ,$dbwhere=null) {

    $sql = " delete from licobras202020
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si196_sequencial = '$si196_sequencial'";
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
      $this->erro_sql   = "Record Vazio na Tabela:licobras202020";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si196_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from licobras202020 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si196_sequencial != "" && $si196_sequencial != null) {
        $sql2 = " where licobras202020.si196_sequencial = '$si196_sequencial'";
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
  function sql_query_file ( $si196_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from licobras202020 ";
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
