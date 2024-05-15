<?php
//MODULO: sicom
//CLASSE DA ENTIDADE cadobras212020
class cl_cadobras212020 {
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
  public $si200_sequencial = 0;
  public $si200_tiporegistro = 0;
  public $si200_codorgaoresp = null;
  public $si200_codobra = 0;
  public $si200_dtparalisacao_dia = null;
  public $si200_dtparalisacao_mes = null;
  public $si200_dtparalisacao_ano = null;
  public $si200_dtparalisacao = null;
  public $si200_motivoparalisacap = 0;
  public $si200_descoutrosparalisacao = null;
  public $si200_dtretomada_dia = null;
  public $si200_dtretomada_mes = null;
  public $si200_dtretomada_ano = null;
  public $si200_dtretomada = null;
  public $si200_mes = 0;
  public $si200_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si200_sequencial = int8 = Sequencial
                 si200_tiporegistro = int8 = Tiporegistro
                 si200_codorgaoresp = text = codorgaoresp
                 si200_codobra = int8 = codigoobra
                 si200_dtparalisacao = date = dtparalisacao
                 si200_motivoparalisacap = int8 = motivo paralisacao
                 si200_descoutrosparalisacao = text = desc outros paralisacao
                 si200_dtretomada = date = dtretomada
                 si200_mes = int4 = Mes
                 si200_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cadobras212020");
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
      $this->si200_sequencial = ($this->si200_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_sequencial"]:$this->si200_sequencial);
      $this->si200_tiporegistro = ($this->si200_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_tiporegistro"]:$this->si200_tiporegistro);
      $this->si200_codobra = ($this->si200_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_codobra"]:$this->si200_codobra);
      if ($this->si200_dtparalisacao == "") {
        $this->si200_dtparalisacao_dia = ($this->si200_dtparalisacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_dtparalisacao_dia"]:$this->si200_dtparalisacao_dia);
        $this->si200_dtparalisacao_mes = ($this->si200_dtparalisacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_dtparalisacao_mes"]:$this->si200_dtparalisacao_mes);
        $this->si200_dtparalisacao_ano = ($this->si200_dtparalisacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_dtparalisacao_ano"]:$this->si200_dtparalisacao_ano);
        if ($this->si200_dtparalisacao_dia != "") {
          $this->si200_dtparalisacao = $this->si200_dtparalisacao_ano."-".$this->si200_dtparalisacao_mes."-".$this->si200_dtparalisacao_dia;
        }
      }
      $this->si200_motivoparalisacap = ($this->si200_motivoparalisacap == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_motivoparalisacap"]:$this->si200_motivoparalisacap);
      $this->si200_descoutrosparalisacao = ($this->si200_descoutrosparalisacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_descoutrosparalisacao"]:$this->si200_descoutrosparalisacao);
      if ($this->si200_dtretomada == "") {
        $this->si200_dtretomada_dia = ($this->si200_dtretomada_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_dtretomada_dia"]:$this->si200_dtretomada_dia);
        $this->si200_dtretomada_mes = ($this->si200_dtretomada_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_dtretomada_mes"]:$this->si200_dtretomada_mes);
        $this->si200_dtretomada_ano = ($this->si200_dtretomada_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_dtretomada_ano"]:$this->si200_dtretomada_ano);
        if ($this->si200_dtretomada_dia != "") {
          $this->si200_dtretomada = $this->si200_dtretomada_ano."-".$this->si200_dtretomada_mes."-".$this->si200_dtretomada_dia;
        }
      }
      $this->si200_mes = ($this->si200_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_mes"]:$this->si200_mes);
      $this->si200_instit = ($this->si200_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si200_instit"]:$this->si200_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si200_sequencial == null ) {
      $result = db_query("select nextval('cadobras212020_si200_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: cadobras212020_si200_sequencial_seq do campo: si200_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si200_sequencial = pg_result($result,0,0);
    }
    if ($this->si200_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si200_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si200_codobra == null ) {
      $this->erro_sql = " Campo codigoobra não informado.";
      $this->erro_campo = "si200_codobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si200_dtparalisacao == null ) {
      $this->erro_sql = " Campo dtparalisacao não informado.";
      $this->erro_campo = "si200_dtparalisacao_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si200_motivoparalisacap == null ) {
      $this->erro_sql = " Campo motivo paralisacao não informado.";
      $this->erro_campo = "si200_motivoparalisacap";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->si200_motivoparalisacap == "99"){
        if ($this->si200_descoutrosparalisacao == null ) {
            $this->erro_sql = " Campo desc outros paralisacao não informado.";
            $this->erro_campo = "si200_descoutrosparalisacao";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
        }
    }
//    if ($this->si200_dtretomada == null ) {
//      $this->erro_sql = " Campo dtretomada não informado.";
//      $this->erro_campo = "si200_dtretomada_dia";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//      $this->erro_status = "0";
//      return false;
//    }
    if ($this->si200_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si200_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si200_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si200_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into cadobras212020(
                                       si200_sequencial
                                      ,si200_tiporegistro
                                      ,si200_codorgaoresp
                                      ,si200_codobra
                                      ,si200_dtparalisacao
                                      ,si200_motivoparalisacap
                                      ,si200_descoutrosparalisacao
                                      ,si200_dtretomada
                                      ,si200_mes
                                      ,si200_instit
                       )
                values (
                                $this->si200_sequencial
                               ,$this->si200_tiporegistro
                               ,".($this->si200_codorgaoresp == "null" || $this->si200_codorgaoresp == ""?"null":"'".$this->si200_codorgaoresp."'")."
                               ,$this->si200_codobra
                               ,".($this->si200_dtparalisacao == "null" || $this->si200_dtparalisacao == ""?"null":"'".$this->si200_dtparalisacao."'")."
                               ,$this->si200_motivoparalisacap
                               ,'$this->si200_descoutrosparalisacao'
                               ,".($this->si200_dtretomada == "null" || $this->si200_dtretomada == ""?"null":"'".$this->si200_dtretomada."'")."
                               ,$this->si200_mes
                               ,$this->si200_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "detalhamento da paralisacao () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "detalhamento da paralisacao já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "detalhamento da paralisacao () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $si200_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update cadobras212020 set ";
    $virgula = "";
    if (trim($this->si200_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_sequencial"])) {
      $sql  .= $virgula." si200_sequencial = $this->si200_sequencial ";
      $virgula = ",";
      if (trim($this->si200_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si200_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si200_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_tiporegistro"])) {
      $sql  .= $virgula." si200_tiporegistro = $this->si200_tiporegistro ";
      $virgula = ",";
      if (trim($this->si200_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si200_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si200_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_codobra"])) {
      $sql  .= $virgula." si200_codobra = $this->si200_codobra ";
      $virgula = ",";
      if (trim($this->si200_codobra) == null ) {
        $this->erro_sql = " Campo codigoobra não informado.";
        $this->erro_campo = "si200_codobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si200_dtparalisacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_dtparalisacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si200_dtparalisacao_dia"] !="") ) {
      $sql  .= $virgula." si200_dtparalisacao = '$this->si200_dtparalisacao' ";
      $virgula = ",";
      if (trim($this->si200_dtparalisacao) == null ) {
        $this->erro_sql = " Campo dtparalisacao não informado.";
        $this->erro_campo = "si200_dtparalisacao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si200_dtparalisacao_dia"])) {
        $sql  .= $virgula." si200_dtparalisacao = null ";
        $virgula = ",";
        if (trim($this->si200_dtparalisacao) == null ) {
          $this->erro_sql = " Campo dtparalisacao não informado.";
          $this->erro_campo = "si200_dtparalisacao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si200_motivoparalisacap)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_motivoparalisacap"])) {
      $sql  .= $virgula." si200_motivoparalisacap = $this->si200_motivoparalisacap ";
      $virgula = ",";
      if (trim($this->si200_motivoparalisacap) == null ) {
        $this->erro_sql = " Campo motivo paralisacao não informado.";
        $this->erro_campo = "si200_motivoparalisacap";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si200_descoutrosparalisacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_descoutrosparalisacao"])) {
      $sql  .= $virgula." si200_descoutrosparalisacao = '$this->si200_descoutrosparalisacao' ";
      $virgula = ",";
      if (trim($this->si200_descoutrosparalisacao) == null ) {
        $this->erro_sql = " Campo desc outros paralisacao não informado.";
        $this->erro_campo = "si200_descoutrosparalisacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si200_dtretomada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_dtretomada_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si200_dtretomada_dia"] !="") ) {
      $sql  .= $virgula." si200_dtretomada = '$this->si200_dtretomada' ";
      $virgula = ",";
      if (trim($this->si200_dtretomada) == null ) {
        $this->erro_sql = " Campo dtretomada não informado.";
        $this->erro_campo = "si200_dtretomada_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si200_dtretomada_dia"])) {
        $sql  .= $virgula." si200_dtretomada = null ";
        $virgula = ",";
        if (trim($this->si200_dtretomada) == null ) {
          $this->erro_sql = " Campo dtretomada não informado.";
          $this->erro_campo = "si200_dtretomada_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si200_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_mes"])) {
      $sql  .= $virgula." si200_mes = $this->si200_mes ";
      $virgula = ",";
      if (trim($this->si200_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si200_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si200_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si200_instit"])) {
      $sql  .= $virgula." si200_instit = $this->si200_instit ";
      $virgula = ",";
      if (trim($this->si200_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si200_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si200_sequencial = '$si200_sequencial'";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "detalhamento da paralisacao nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "detalhamento da paralisacao nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $si200_sequencial=null ,$dbwhere=null) {

    $sql = " delete from cadobras212020
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si200_sequencial = '$si200_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "detalhamento da paralisacao nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "detalhamento da paralisacao nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:cadobras212020";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si200_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras212020 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si200_sequencial != "" && $si200_sequencial != null) {
        $sql2 = " where cadobras212020.si200_sequencial = '$si200_sequencial'";
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
  function sql_query_file ( $si200_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras212020 ";
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
