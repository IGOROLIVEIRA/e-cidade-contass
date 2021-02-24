<?php
//MODULO: sicom
//CLASSE DA ENTIDADE exeobras102021
class cl_exeobras102021 {
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
  public $si197_sequencial = 0;
  public $si197_tiporegistro = 0;
  public $si197_codorgao = null;
  public $si197_codunidadesub = null;
  public $si197_nrocontrato = 0;
  public $si197_exerciciolicitacao = 0;
  public $si197_codobra = 0;
  public $si197_objeto = null;
  public $si197_linkobra = null;
  public $si197_mes = 0;
  public $si197_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si197_sequencial = int8 = Sequencial
                 si197_tiporegistro = int8 = Tiporegistro
                 si197_codorgao = text = codorgaoresp
                 si197_codunidadesub = text = codUnidadeSubRespEstadual
                 si197_nrocontrato = int8 = nroContrato
                 si197_exerciciolicitacao = int4 = exercicioLicitacao
                 si197_codobra = int8 = codigoobra
                 si197_objeto = text = objeto
                 si197_linkobra = text = linkobra
                 si197_mes = int4 = Mes
                 si197_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("exeobras102021");
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
      $this->si197_sequencial = ($this->si197_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_sequencial"]:$this->si197_sequencial);
      $this->si197_tiporegistro = ($this->si197_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_tiporegistro"]:$this->si197_tiporegistro);
      $this->si197_codorgao = ($this->si197_codorgao == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_codorgao"]:$this->si197_codorgao);
      $this->si197_codunidadesub = ($this->si197_codunidadesub == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_codunidadesub"]:$this->si197_codunidadesub);
      $this->si197_nrocontrato = ($this->si197_nrocontrato == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_nrocontrato"]:$this->si197_nrocontrato);
      $this->si197_exerciciolicitacao = ($this->si197_exerciciolicitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_exerciciolicitacao"]:$this->si197_exerciciolicitacao);
      $this->si197_codobra = ($this->si197_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_codobra"]:$this->si197_codobra);
      $this->si197_objeto = ($this->si197_objeto == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_objeto"]:$this->si197_objeto);
      $this->si197_linkobra = ($this->si197_linkobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_linkobra"]:$this->si197_linkobra);
      $this->si197_mes = ($this->si197_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_mes"]:$this->si197_mes);
      $this->si197_instit = ($this->si197_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si197_instit"]:$this->si197_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si197_sequencial == null ) {
      $result = db_query("select nextval('exeobras102021_si197_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: exeobras102021_si197_sequencial_seq do campo: si197_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si197_sequencial = pg_result($result,0,0);
    }
    if ($this->si197_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si197_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_codorgao == null ) {
      $this->erro_sql = " Campo codorgaoresp não informado.";
      $this->erro_campo = "si197_codorgao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_codunidadesub == null ) {
      $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
      $this->erro_campo = "si197_codunidadesub";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_nrocontrato == null ) {
      $this->erro_sql = " Campo nroContrato não informado.";
      $this->erro_campo = "si197_nrocontrato";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_exerciciolicitacao == null ) {
      $this->erro_sql = " Campo exercicioLicitacao não informado.";
      $this->erro_campo = "si197_exerciciolicitacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_codobra == null ) {
      $this->erro_sql = " Campo codigoobra não informado.";
      $this->erro_campo = "si197_codobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_objeto == null ) {
      $this->erro_sql = " Campo objeto não informado.";
      $this->erro_campo = "si197_objeto";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_linkobra == null ) {
      $this->erro_sql = " Campo linkobra não informado.";
      $this->erro_campo = "si197_linkobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si197_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si197_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si197_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into exeobras102021(
                                       si197_sequencial
                                      ,si197_tiporegistro
                                      ,si197_codorgao
                                      ,si197_codunidadesub
                                      ,si197_nrocontrato
                                      ,si197_exerciciolicitacao
                                      ,si197_codobra
                                      ,si197_objeto
                                      ,si197_linkobra
                                      ,si197_mes
                                      ,si197_instit
                       )
                values (
                                $this->si197_sequencial
                               ,$this->si197_tiporegistro
                               ,'$this->si197_codorgao'
                               ,'$this->si197_codunidadesub'
                               ,$this->si197_nrocontrato
                               ,$this->si197_exerciciolicitacao
                               ,$this->si197_codobra
                               ,'$this->si197_objeto'
                               ,'$this->si197_linkobra'
                               ,$this->si197_mes
                               ,$this->si197_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "execucao de obras () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "execucao de obras já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "execucao de obras () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $si197_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update exeobras102021 set ";
    $virgula = "";
    if (trim($this->si197_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_sequencial"])) {
      $sql  .= $virgula." si197_sequencial = $this->si197_sequencial ";
      $virgula = ",";
      if (trim($this->si197_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si197_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_tiporegistro"])) {
      $sql  .= $virgula." si197_tiporegistro = $this->si197_tiporegistro ";
      $virgula = ",";
      if (trim($this->si197_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si197_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_codorgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_codorgao"])) {
      $sql  .= $virgula." si197_codorgao = '$this->si197_codorgao' ";
      $virgula = ",";
      if (trim($this->si197_codorgao) == null ) {
        $this->erro_sql = " Campo codorgaoresp não informado.";
        $this->erro_campo = "si197_codorgao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_codunidadesub)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_codunidadesub"])) {
      $sql  .= $virgula." si197_codunidadesub = '$this->si197_codunidadesub' ";
      $virgula = ",";
      if (trim($this->si197_codunidadesub) == null ) {
        $this->erro_sql = " Campo codUnidadeSubRespEstadual não informado.";
        $this->erro_campo = "si197_codunidadesub";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_nrocontrato)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_nrocontrato"])) {
      $sql  .= $virgula." si197_nrocontrato = $this->si197_nrocontrato ";
      $virgula = ",";
      if (trim($this->si197_nrocontrato) == null ) {
        $this->erro_sql = " Campo nroContrato não informado.";
        $this->erro_campo = "si197_nrocontrato";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_exerciciolicitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_exerciciolicitacao"])) {
      $sql  .= $virgula." si197_exerciciolicitacao = $this->si197_exerciciolicitacao ";
      $virgula = ",";
      if (trim($this->si197_exerciciolicitacao) == null ) {
        $this->erro_sql = " Campo exercicioLicitacao não informado.";
        $this->erro_campo = "si197_exerciciolicitacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_codobra"])) {
      $sql  .= $virgula." si197_codobra = $this->si197_codobra ";
      $virgula = ",";
      if (trim($this->si197_codobra) == null ) {
        $this->erro_sql = " Campo codigoobra não informado.";
        $this->erro_campo = "si197_codobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_objeto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_objeto"])) {
      $sql  .= $virgula." si197_objeto = '$this->si197_objeto' ";
      $virgula = ",";
      if (trim($this->si197_objeto) == null ) {
        $this->erro_sql = " Campo objeto não informado.";
        $this->erro_campo = "si197_objeto";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_linkobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_linkobra"])) {
      $sql  .= $virgula." si197_linkobra = '$this->si197_linkobra' ";
      $virgula = ",";
      if (trim($this->si197_linkobra) == null ) {
        $this->erro_sql = " Campo linkobra não informado.";
        $this->erro_campo = "si197_linkobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_mes"])) {
      $sql  .= $virgula." si197_mes = $this->si197_mes ";
      $virgula = ",";
      if (trim($this->si197_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si197_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si197_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si197_instit"])) {
      $sql  .= $virgula." si197_instit = $this->si197_instit ";
      $virgula = ",";
      if (trim($this->si197_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si197_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si197_sequencial = '$si197_sequencial'";     $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "execucao de obras nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "execucao de obras nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $si197_sequencial=null ,$dbwhere=null) {

    $sql = " delete from exeobras102021
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si197_sequencial = '$si197_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "execucao de obras nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "execucao de obras nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:exeobras102021";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si197_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from exeobras102021 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si197_sequencial != "" && $si197_sequencial != null) {
        $sql2 = " where exeobras102021.si197_sequencial = '$si197_sequencial'";
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
  function sql_query_file ( $si197_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from exeobras102021 ";
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
