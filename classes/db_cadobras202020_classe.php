<?php
//MODULO: sicom
//CLASSE DA ENTIDADE cadobras202020
class cl_cadobras202020 {
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
  public $si199_sequencial = 0;
  public $si199_tiporegistro = 0;
  public $si199_codorgaoresp = 0;
  public $si199_codobra = null;
  public $si199_situacaodaobra = 0;
  public $si199_dtsituacao_dia = null;
  public $si199_dtsituacao_mes = null;
  public $si199_dtsituacao_ano = null;
  public $si199_dtsituacao = null;
  public $si199_veiculopublicacao = null;
  public $si199_dtpublicacao_dia = null;
  public $si199_dtpublicacao_mes = null;
  public $si199_dtpublicacao_ano = null;
  public $si199_dtpublicacao = null;
  public $si199_descsituacao = null;
  public $si199_mes = 0;
  public $si199_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si199_sequencial = int8 = Sequencial
                 si199_tiporegistro = int8 = Tiporegistro
                 si199_codorgaoresp = int8 = codigoorgaoresp
                 si199_codobra = int8 = codigoobra
                 si199_situacaodaobra = int8 = situacao da obra
                 si199_dtsituacao = date = dtsituacao
                 si199_veiculopublicacao = text = viculo publicacao
                 si199_dtpublicacao = date = dtpublicacao
                 si199_descsituacao = text = desc situacao obra
                 si199_mes = int4 = Mes
                 si199_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cadobras202020");
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
      $this->si199_sequencial = ($this->si199_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_sequencial"]:$this->si199_sequencial);
      $this->si199_tiporegistro = ($this->si199_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"]:$this->si199_tiporegistro);
      $this->si199_codobra = ($this->si199_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_codobra"]:$this->si199_codobra);
      $this->si199_situacaodaobra = ($this->si199_situacaodaobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_situacaodaobra"]:$this->si199_situacaodaobra);
      if ($this->si199_dtsituacao == "") {
        $this->si199_dtsituacao_dia = ($this->si199_dtsituacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtsituacao_dia"]:$this->si199_dtsituacao_dia);
        $this->si199_dtsituacao_mes = ($this->si199_dtsituacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtsituacao_mes"]:$this->si199_dtsituacao_mes);
        $this->si199_dtsituacao_ano = ($this->si199_dtsituacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtsituacao_ano"]:$this->si199_dtsituacao_ano);
        if ($this->si199_dtsituacao_dia != "") {
          $this->si199_dtsituacao = $this->si199_dtsituacao_ano."-".$this->si199_dtsituacao_mes."-".$this->si199_dtsituacao_dia;
        }
      }
      $this->si199_veiculopublicacao = ($this->si199_veiculopublicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_veiculopublicacao"]:$this->si199_veiculopublicacao);
      if ($this->si199_dtpublicacao == "") {
        $this->si199_dtpublicacao_dia = ($this->si199_dtpublicacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtpublicacao_dia"]:$this->si199_dtpublicacao_dia);
        $this->si199_dtpublicacao_mes = ($this->si199_dtpublicacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtpublicacao_mes"]:$this->si199_dtpublicacao_mes);
        $this->si199_dtpublicacao_ano = ($this->si199_dtpublicacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_dtpublicacao_ano"]:$this->si199_dtpublicacao_ano);
        if ($this->si199_dtpublicacao_dia != "") {
          $this->si199_dtpublicacao = $this->si199_dtpublicacao_ano."-".$this->si199_dtpublicacao_mes."-".$this->si199_dtpublicacao_dia;
        }
      }
      $this->si199_descsituacao = ($this->si199_descsituacao == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_descsituacao"]:$this->si199_descsituacao);
      $this->si199_mes = ($this->si199_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_mes"]:$this->si199_mes);
      $this->si199_instit = ($this->si199_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si199_instit"]:$this->si199_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si199_sequencial == null ) {
      $result = db_query("select nextval('cadobras202020_si199_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: cadobras202020_si199_sequencial_seq do campo: si199_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si199_sequencial = pg_result($result,0,0);
    }
    if ($this->si199_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si199_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si199_codobra == null ) {
      $this->erro_sql = " Campo codigoobra não informado.";
      $this->erro_campo = "si199_codobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si199_situacaodaobra == null ) {
      $this->erro_sql = " Campo situacao da obra não informado.";
      $this->erro_campo = "si199_situacaodaobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si199_dtsituacao == null ) {
      $this->erro_sql = " Campo dtsituacao não informado.";
      $this->erro_campo = "si199_dtsituacao_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si199_veiculopublicacao == null ) {
      $this->erro_sql = " Campo viculo publicacao não informado.";
      $this->erro_campo = "si199_veiculopublicacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si199_dtpublicacao == null ) {
      $this->erro_sql = " Campo dtpublicacao não informado.";
      $this->erro_campo = "si199_dtpublicacao_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
//    if ($this->si199_descsituacao == null ) {
//      $this->erro_sql = " Campo desc situacao obra não informado.";
//      $this->erro_campo = "si199_descsituacao";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//      $this->erro_status = "0";
//      return false;
//    }
    if ($this->si199_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si199_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si199_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si199_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into cadobras202020(
                                       si199_sequencial
                                      ,si199_tiporegistro
                                      ,si199_codorgaoresp
                                      ,si199_codobra
                                      ,si199_situacaodaobra
                                      ,si199_dtsituacao
                                      ,si199_veiculopublicacao
                                      ,si199_dtpublicacao
                                      ,si199_descsituacao
                                      ,si199_mes
                                      ,si199_instit
                       )
                values (
                                $this->si199_sequencial
                               ,$this->si199_tiporegistro
                               ,$this->si199_codorgaoresp
                               ,$this->si199_codobra
                               ,$this->si199_situacaodaobra
                               ,".($this->si199_dtsituacao == "null" || $this->si199_dtsituacao == ""?"null":"'".$this->si199_dtsituacao."'")."
                               ,'$this->si199_veiculopublicacao'
                               ,".($this->si199_dtpublicacao == "null" || $this->si199_dtpublicacao == ""?"null":"'".$this->si199_dtpublicacao."'")."
                               ,'$this->si199_descsituacao'
                               ,$this->si199_mes
                               ,$this->si199_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "execucao do objeto () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "execucao do objeto já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "execucao do objeto () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $si199_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update cadobras202020 set ";
    $virgula = "";
    if (trim($this->si199_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_sequencial"])) {
      $sql  .= $virgula." si199_sequencial = $this->si199_sequencial ";
      $virgula = ",";
      if (trim($this->si199_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si199_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si199_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_tiporegistro"])) {
      $sql  .= $virgula." si199_tiporegistro = $this->si199_tiporegistro ";
      $virgula = ",";
      if (trim($this->si199_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si199_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si199_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_codobra"])) {
      $sql  .= $virgula." si199_codobra = $this->si199_codobra ";
      $virgula = ",";
      if (trim($this->si199_codobra) == null ) {
        $this->erro_sql = " Campo codigoobra não informado.";
        $this->erro_campo = "si199_codobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si199_situacaodaobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_situacaodaobra"])) {
      $sql  .= $virgula." si199_situacaodaobra = $this->si199_situacaodaobra ";
      $virgula = ",";
      if (trim($this->si199_situacaodaobra) == null ) {
        $this->erro_sql = " Campo situacao da obra não informado.";
        $this->erro_campo = "si199_situacaodaobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si199_dtsituacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_dtsituacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si199_dtsituacao_dia"] !="") ) {
      $sql  .= $virgula." si199_dtsituacao = '$this->si199_dtsituacao' ";
      $virgula = ",";
      if (trim($this->si199_dtsituacao) == null ) {
        $this->erro_sql = " Campo dtsituacao não informado.";
        $this->erro_campo = "si199_dtsituacao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si199_dtsituacao_dia"])) {
        $sql  .= $virgula." si199_dtsituacao = null ";
        $virgula = ",";
        if (trim($this->si199_dtsituacao) == null ) {
          $this->erro_sql = " Campo dtsituacao não informado.";
          $this->erro_campo = "si199_dtsituacao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si199_veiculopublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_veiculopublicacao"])) {
      $sql  .= $virgula." si199_veiculopublicacao = '$this->si199_veiculopublicacao' ";
      $virgula = ",";
      if (trim($this->si199_veiculopublicacao) == null ) {
        $this->erro_sql = " Campo viculo publicacao não informado.";
        $this->erro_campo = "si199_veiculopublicacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si199_dtpublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_dtpublicacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si199_dtpublicacao_dia"] !="") ) {
      $sql  .= $virgula." si199_dtpublicacao = '$this->si199_dtpublicacao' ";
      $virgula = ",";
      if (trim($this->si199_dtpublicacao) == null ) {
        $this->erro_sql = " Campo dtpublicacao não informado.";
        $this->erro_campo = "si199_dtpublicacao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si199_dtpublicacao_dia"])) {
        $sql  .= $virgula." si199_dtpublicacao = null ";
        $virgula = ",";
        if (trim($this->si199_dtpublicacao) == null ) {
          $this->erro_sql = " Campo dtpublicacao não informado.";
          $this->erro_campo = "si199_dtpublicacao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si199_descsituacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_descsituacao"])) {
      $sql  .= $virgula." si199_descsituacao = '$this->si199_descsituacao' ";
      $virgula = ",";
      if (trim($this->si199_descsituacao) == null ) {
        $this->erro_sql = " Campo desc situacao obra não informado.";
        $this->erro_campo = "si199_descsituacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si199_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_mes"])) {
      $sql  .= $virgula." si199_mes = $this->si199_mes ";
      $virgula = ",";
      if (trim($this->si199_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si199_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si199_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si199_instit"])) {
      $sql  .= $virgula." si199_instit = $this->si199_instit ";
      $virgula = ",";
      if (trim($this->si199_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si199_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si199_sequencial = '$si199_sequencial'";     $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "execucao do objeto nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "execucao do objeto nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $si199_sequencial=null ,$dbwhere=null) {

    $sql = " delete from cadobras202020
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si199_sequencial = '$si199_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "execucao do objeto nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "execucao do objeto nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:cadobras202020";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si199_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras202020 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si199_sequencial != "" && $si199_sequencial != null) {
        $sql2 = " where cadobras202020.si199_sequencial = '$si199_sequencial'";
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
  function sql_query_file ( $si199_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras202020 ";
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
