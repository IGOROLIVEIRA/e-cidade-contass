<?php
//MODULO: Obras
//CLASSE DA ENTIDADE licitemobra
class cl_licitemobra {
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
  public $obr06_sequencial = 0;
  public $obr06_pcmater = 0;
  public $obr06_tabela = 0;
  public $obr06_descricaotabela = null;
  public $obr06_codigotabela = null;
  public $obr06_versaotabela = null;
  public $obr06_dtregistro_dia = null;
  public $obr06_dtregistro_mes = null;
  public $obr06_dtregistro_ano = null;
  public $obr06_dtregistro = null;
  public $obr06_dtcadastro_dia = null;
  public $obr06_dtcadastro_mes = null;
  public $obr06_dtcadastro_ano = null;
  public $obr06_dtcadastro = null;
  public $obr06_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 obr06_sequencial = int8 = Cód. Sequencial
                 obr06_pcmater = int8 = Material
                 obr06_tabela = int4 = Tabela
                 obr06_descricaotabela = text = Descrição da Tabela
                 obr06_codigotabela = text = Código da Tabela
                 obr06_versaotabela = text = Versão da Tabela
                 obr06_dtregistro = date = Data do Registro
                 obr06_dtcadastro = date = Data do Cadastro
                 obr06_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licitemobra");
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
      $this->obr06_sequencial = ($this->obr06_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_sequencial"]:$this->obr06_sequencial);
      $this->obr06_pcmater = ($this->obr06_pcmater == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_pcmater"]:$this->obr06_pcmater);
      $this->obr06_tabela = ($this->obr06_tabela == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_tabela"]:$this->obr06_tabela);
      $this->obr06_descricaotabela = ($this->obr06_descricaotabela == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_descricaotabela"]:$this->obr06_descricaotabela);
      $this->obr06_codigotabela = ($this->obr06_codigotabela == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_codigotabela"]:$this->obr06_codigotabela);
      $this->obr06_versaotabela = ($this->obr06_versaotabela == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_versaotabela"]:$this->obr06_versaotabela);
      if ($this->obr06_dtregistro == "") {
        $this->obr06_dtregistro_dia = ($this->obr06_dtregistro_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_dtregistro_dia"]:$this->obr06_dtregistro_dia);
        $this->obr06_dtregistro_mes = ($this->obr06_dtregistro_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_dtregistro_mes"]:$this->obr06_dtregistro_mes);
        $this->obr06_dtregistro_ano = ($this->obr06_dtregistro_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_dtregistro_ano"]:$this->obr06_dtregistro_ano);
        if ($this->obr06_dtregistro_dia != "") {
          $this->obr06_dtregistro = $this->obr06_dtregistro_ano."-".$this->obr06_dtregistro_mes."-".$this->obr06_dtregistro_dia;
        }
      }
      if ($this->obr06_dtcadastro == "") {
        $this->obr06_dtcadastro_dia = ($this->obr06_dtcadastro_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_dtcadastro_dia"]:$this->obr06_dtcadastro_dia);
        $this->obr06_dtcadastro_mes = ($this->obr06_dtcadastro_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_dtcadastro_mes"]:$this->obr06_dtcadastro_mes);
        $this->obr06_dtcadastro_ano = ($this->obr06_dtcadastro_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_dtcadastro_ano"]:$this->obr06_dtcadastro_ano);
        if ($this->obr06_dtcadastro_dia != "") {
          $this->obr06_dtcadastro = $this->obr06_dtcadastro_ano."-".$this->obr06_dtcadastro_mes."-".$this->obr06_dtcadastro_dia;
        }
      }
      $this->obr06_instit = ($this->obr06_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["obr06_instit"]:$this->obr06_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->obr06_sequencial == null ) {
      $result = db_query("select nextval('licitemobra_obr06_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: licitemobra_obr06_sequencial_seq do campo: obr06_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->obr06_sequencial = pg_result($result,0,0);
    }
    if ($this->obr06_pcmater == null ) {
      $this->erro_sql = " Campo Material não informado.";
      $this->erro_campo = "obr06_pcmater";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr06_tabela == null || $this->obr06_tabela == "0") {
      $this->erro_sql = " Campo Tabela não informado.";
      $this->erro_campo = "obr06_tabela";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if($this->obr06_tabela == "3"){
      if ($this->obr06_descricaotabela == null ) {
        $this->erro_sql = " Campo Descrição da Tabela não informado.";
        $this->erro_campo = "obr06_descricaotabela";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }else{
      $this->obr06_descricaotabela == "";
    }
    if ($this->obr06_codigotabela == null ) {
      $this->erro_sql = " Campo Código da Tabela não informado.";
      $this->erro_campo = "obr06_codigotabela";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr06_versaotabela == null ) {
      $this->erro_sql = " Campo Versão da Tabela não informado.";
      $this->erro_campo = "obr06_versaotabela";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr06_dtregistro == null ) {
      $this->erro_sql = " Campo Data do Registro não informado.";
      $this->erro_campo = "obr06_dtregistro_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr06_dtcadastro == null ) {
      $this->erro_sql = " Campo Data do Registro não informado.";
      $this->erro_campo = "obr06_dtcadastro_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr06_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "obr06_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into licitemobra(
                                       obr06_sequencial
                                      ,obr06_pcmater
                                      ,obr06_tabela
                                      ,obr06_descricaotabela
                                      ,obr06_codigotabela
                                      ,obr06_versaotabela
                                      ,obr06_dtregistro
                                      ,obr06_dtcadastro
                                      ,obr06_instit
                       )
                values (
                                $this->obr06_sequencial
                               ,$this->obr06_pcmater
                               ,$this->obr06_tabela
                               ,'$this->obr06_descricaotabela'
                               ,'$this->obr06_codigotabela'
                               ,'$this->obr06_versaotabela'
                               ,".($this->obr06_dtregistro == "null" || $this->obr06_dtregistro == ""?"null":"'".$this->obr06_dtregistro."'")."
                               ,".($this->obr06_dtcadastro == "null" || $this->obr06_dtcadastro == ""?"null":"'".$this->obr06_dtcadastro."'")."
                               ,$this->obr06_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "cadastro itens da obra () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "cadastro itens da obra já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "cadastro itens da obra () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $obr06_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update licitemobra set ";
    $virgula = "";
    if (trim($this->obr06_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_sequencial"])) {
      $sql  .= $virgula." obr06_sequencial = $this->obr06_sequencial ";
      $virgula = ",";
      if (trim($this->obr06_sequencial) == null ) {
        $this->erro_sql = " Campo Cód. Sequencial não informado.";
        $this->erro_campo = "obr06_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr06_pcmater)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_pcmater"])) {
      $sql  .= $virgula." obr06_pcmater = $this->obr06_pcmater ";
      $virgula = ",";
      if (trim($this->obr06_pcmater) == null ) {
        $this->erro_sql = " Campo Material não informado.";
        $this->erro_campo = "obr06_pcmater";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr06_tabela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_tabela"])) {
      $sql  .= $virgula." obr06_tabela = $this->obr06_tabela ";
      $virgula = ",";
      if (trim($this->obr06_tabela) == null ) {
        $this->erro_sql = " Campo Tabela não informado.";
        $this->erro_campo = "obr06_tabela";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr06_descricaotabela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_descricaotabela"])) {
      $sql  .= $virgula." obr06_descricaotabela = '$this->obr06_descricaotabela' ";
      $virgula = ",";
      if (trim($this->obr06_descricaotabela) == null ) {
        $this->erro_sql = " Campo Descrição da Tabela não informado.";
        $this->erro_campo = "obr06_descricaotabela";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr06_codigotabela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_codigotabela"])) {
      $sql  .= $virgula." obr06_codigotabela = '$this->obr06_codigotabela' ";
      $virgula = ",";
      if (trim($this->obr06_codigotabela) == null ) {
        $this->erro_sql = " Campo Código da Tabela não informado.";
        $this->erro_campo = "obr06_codigotabela";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr06_versaotabela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_versaotabela"])) {
      $sql  .= $virgula." obr06_versaotabela = '$this->obr06_versaotabela' ";
      $virgula = ",";
      if (trim($this->obr06_versaotabela) == null ) {
        $this->erro_sql = " Campo Versão da Tabela não informado.";
        $this->erro_campo = "obr06_versaotabela";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr06_dtregistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_dtregistro_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr06_dtregistro_dia"] !="") ) {
      $sql  .= $virgula." obr06_dtregistro = '$this->obr06_dtregistro' ";
      $virgula = ",";
      if (trim($this->obr06_dtregistro) == null ) {
        $this->erro_sql = " Campo Data do Registro não informado.";
        $this->erro_campo = "obr06_dtregistro_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["obr06_dtregistro_dia"])) {
        $sql  .= $virgula." obr06_dtregistro = null ";
        $virgula = ",";
        if (trim($this->obr06_dtregistro) == null ) {
          $this->erro_sql = " Campo Data do Registro não informado.";
          $this->erro_campo = "obr06_dtregistro_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->obr06_dtcadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_dtcadastro_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr06_dtcadastro_dia"] !="") ) {
      $sql  .= $virgula." obr06_dtcadastro = '$this->obr06_dtcadastro' ";
      $virgula = ",";
      if (trim($this->obr06_dtcadastro) == null ) {
        $this->erro_sql = " Campo Data do Registro não informado.";
        $this->erro_campo = "obr06_dtcadastro_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["obr06_dtcadastro_dia"])) {
        $sql  .= $virgula." obr06_dtcadastro = null ";
        $virgula = ",";
        if (trim($this->obr06_dtcadastro) == null ) {
          $this->erro_sql = " Campo Data do Registro não informado.";
          $this->erro_campo = "obr06_dtcadastro_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->obr06_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr06_instit"])) {
      $sql  .= $virgula." obr06_instit = $this->obr06_instit ";
      $virgula = ",";
      if (trim($this->obr06_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "obr06_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "obr06_sequencial = '$obr06_sequencial'";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro itens da obra nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro itens da obra nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $obr06_sequencial=null ,$dbwhere=null) {

    $sql = " delete from licitemobra
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "obr06_sequencial = $obr06_sequencial";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro itens da obra nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro itens da obra nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:licitemobra";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $obr06_sequencial = null,$campos="licitemobra.obr06_sequencial,*",$ordem=null,$dbwhere="") {
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
    $sql .= " from licitemobra ";
    $sql .= " inner join pcmater on pc01_codmater = obr06_pcmater ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $obr06_sequencial != "" && $obr06_sequencial != null) {
        $sql2 = " where licitemobra.obr06_sequencial = '$obr06_sequencial'";
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
  function sql_query_file ( $obr06_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from licitemobra ";
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

    // funcao do sql
    function sql_query_itens_obras_licitacao ( $l20_codigo = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from liclicitem ";
        $sql .= " INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem ";
        $sql .= " INNER JOIN pcorcamitemproc ON pc31_pcprocitem = pc81_codprocitem ";
        $sql .= " INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc ";
        $sql .= " LEFT JOIN itemprecoreferencia ON si02_itemproccompra = pcorcamitemproc.pc31_orcamitem ";
        $sql .= " INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem ";
        $sql .= " INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero ";
        $sql .= " LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo ";
        $sql .= " LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater ";
        $sql .= " LEFT JOIN licitemobra ON obr06_pcmater = pc01_codmater ";
        $sql2 = "";
        if ($dbwhere=="") {
          $sql2 = "where l20_codigo = $l20_codigo";
        } else if ($dbwhere != "") {
            $sql2 = "AND pc01_obras = 't' where $dbwhere";
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
    function sql_query_itens_obras_processodecompras ( $pc80_codproc = null,$campos="*",$ordem=null,$dbwhere="") {
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
        $sql .= " from pcproc ";
        $sql .= " INNER JOIN pcprocitem ON pc81_codproc = pc80_codproc ";
        $sql .= " INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem ";
        $sql .= " INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero ";
        $sql .= " LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo ";
        $sql .= " LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater ";
        $sql .= " LEFT JOIN licitemobra ON obr06_pcmater = pc01_codmater ";
        $sql2 = "";
        if ($dbwhere=="") {
            $sql2 = "where pc80_codproc = $pc80_codproc";
        } else if ($dbwhere != "") {
            $sql2 = "AND pc01_obras = 't' where $dbwhere";
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
