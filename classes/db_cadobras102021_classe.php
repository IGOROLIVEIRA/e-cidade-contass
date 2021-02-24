<?php
//MODULO: sicom
//CLASSE DA ENTIDADE cadobras102021
class cl_cadobras102021 {
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
  public $si198_sequencial = 0;
  public $si198_tiporegistro = 0;
  public $si198_codorgaoresp = null;
  public $si198_codobra = 0;
  public $si198_tiporesponsavel = 0;
  public $si198_nrodocumento = null;
  public $si198_tiporegistroconselho = 0;
  public $si198_nroregistroconseprof = null;
  public $si198_numrt = null;
  public $si198_dtinicioatividadeseng_dia = null;
  public $si198_dtinicioatividadeseng_mes = null;
  public $si198_dtinicioatividadeseng_ano = null;
  public $si198_dtinicioatividadeseng = null;
  public $si198_tipovinculo = 0;
  public $si198_mes = 0;
  public $si198_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si198_sequencial = int8 = Sequencial
                 si198_tiporegistro = int8 = Tiporegistro
                 si198_codorgaoresp = text = codorgaoresp
                 si198_codobra = int8 = codigoobra
                 si198_tiporesponsavel = int8 = Tipo responsavel
                 si198_nrodocumento = text = Numero Documento
                 si198_tiporegistroconselho = int8 = tipoRegistroConselho
                 si198_nroregistroconseprof = text = nroregistroconseprof
                 si198_numrt = int8 = numRT
                 si198_dtinicioatividadeseng = date = dtinicioatividadeseng
                 si198_tipovinculo = int8 = Tipovinculo
                 si198_mes = int4 = Mes
                 si198_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cadobras102021");
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
      $this->si198_sequencial = ($this->si198_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_sequencial"]:$this->si198_sequencial);
      $this->si198_tiporegistro = ($this->si198_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_tiporegistro"]:$this->si198_tiporegistro);
      $this->si198_codorgaoresp = ($this->si198_codorgaoresp == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_codorgaoresp"]:$this->si198_codorgaoresp);
      $this->si198_codobra = ($this->si198_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_codobra"]:$this->si198_codobra);
      $this->si198_tiporesponsavel = ($this->si198_tiporesponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_tiporesponsavel"]:$this->si198_tiporesponsavel);
      $this->si198_nrodocumento = ($this->si198_nrodocumento == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_nrodocumento"]:$this->si198_nrodocumento);
      $this->si198_tiporegistroconselho = ($this->si198_tiporegistroconselho == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_tiporegistroconselho"]:$this->si198_tiporegistroconselho);
      $this->si198_nroregistroconseprof = ($this->si198_nroregistroconseprof == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_nroregistroconseprof"]:$this->si198_nroregistroconseprof);
      $this->si198_numrt = ($this->si198_numrt == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_numrt"]:$this->si198_numrt);
      if ($this->si198_dtinicioatividadeseng == "") {
        $this->si198_dtinicioatividadeseng_dia = ($this->si198_dtinicioatividadeseng_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_dtinicioatividadeseng_dia"]:$this->si198_dtinicioatividadeseng_dia);
        $this->si198_dtinicioatividadeseng_mes = ($this->si198_dtinicioatividadeseng_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_dtinicioatividadeseng_mes"]:$this->si198_dtinicioatividadeseng_mes);
        $this->si198_dtinicioatividadeseng_ano = ($this->si198_dtinicioatividadeseng_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_dtinicioatividadeseng_ano"]:$this->si198_dtinicioatividadeseng_ano);
        if ($this->si198_dtinicioatividadeseng_dia != "") {
          $this->si198_dtinicioatividadeseng = $this->si198_dtinicioatividadeseng_ano."-".$this->si198_dtinicioatividadeseng_mes."-".$this->si198_dtinicioatividadeseng_dia;
        }
      }
      $this->si198_tipovinculo = ($this->si198_tipovinculo == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_tipovinculo"]:$this->si198_tipovinculo);
      $this->si198_mes = ($this->si198_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_mes"]:$this->si198_mes);
      $this->si198_instit = ($this->si198_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si198_instit"]:$this->si198_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si198_sequencial == null ) {
      $result = db_query("select nextval('cadobras102021_si198_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: cadobras102021_si198_sequencial_seq do campo: si198_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si198_sequencial = pg_result($result,0,0);
    }
    if ($this->si198_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si198_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_codorgaoresp == null ) {
      $this->erro_sql = " Campo codorgaoresp não informado.";
      $this->erro_campo = "si198_codorgaoresp";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_codobra == null ) {
      $this->erro_sql = " Campo codigoobra não informado.";
      $this->erro_campo = "si198_codobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_tiporesponsavel == null ) {
      $this->erro_sql = " Campo Tipo responsavel não informado.";
      $this->erro_campo = "si198_tiporesponsavel";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_nrodocumento == null ) {
      $this->erro_sql = " Campo Numero Documento não informado.";
      $this->erro_campo = "si198_nrodocumento";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_tiporegistroconselho == null ) {
      $this->erro_sql = " Campo tipoRegistroConselho não informado.";
      $this->erro_campo = "si198_tiporegistroconselho";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_nroregistroconseprof == null ) {
      $this->erro_sql = " Campo nroregistroconseprof não informado.";
      $this->erro_campo = "si198_nroregistroconseprof";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_numrt == null ) {
      $this->si198_numrt = "0";
    }
    if ($this->si198_dtinicioatividadeseng == null ) {
      $this->erro_sql = " Campo dtinicioatividadeseng não informado.";
      $this->erro_campo = "si198_dtinicioatividadeseng_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_tipovinculo == null ) {
      $this->erro_sql = " Campo Tipovinculo não informado.";
      $this->erro_campo = "si198_tipovinculo";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si198_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si198_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si198_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into cadobras102021(
                                       si198_sequencial
                                      ,si198_tiporegistro
                                      ,si198_codorgaoresp
                                      ,si198_codobra
                                      ,si198_tiporesponsavel
                                      ,si198_nrodocumento
                                      ,si198_tiporegistroconselho
                                      ,si198_nroregistroconseprof
                                      ,si198_numrt
                                      ,si198_dtinicioatividadeseng
                                      ,si198_tipovinculo
                                      ,si198_mes
                                      ,si198_instit
                       )
                values (
                                $this->si198_sequencial
                               ,$this->si198_tiporegistro
                               ,'$this->si198_codorgaoresp'
                               ,$this->si198_codobra
                               ,$this->si198_tiporesponsavel
                               ,'$this->si198_nrodocumento'
                               ,$this->si198_tiporegistroconselho
                               ,'$this->si198_nroregistroconseprof'
                               ,$this->si198_numrt
                               ,".($this->si198_dtinicioatividadeseng == "null" || $this->si198_dtinicioatividadeseng == ""?"null":"'".$this->si198_dtinicioatividadeseng."'")."
                               ,$this->si198_tipovinculo
                               ,$this->si198_mes
                               ,$this->si198_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "detalhamento dos responsaveis () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "detalhamento dos responsaveis já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "detalhamento dos responsaveis () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $si198_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update cadobras102021 set ";
    $virgula = "";
    if (trim($this->si198_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_sequencial"])) {
      $sql  .= $virgula." si198_sequencial = $this->si198_sequencial ";
      $virgula = ",";
      if (trim($this->si198_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si198_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_tiporegistro"])) {
      $sql  .= $virgula." si198_tiporegistro = $this->si198_tiporegistro ";
      $virgula = ",";
      if (trim($this->si198_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si198_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_codorgaoresp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_codorgaoresp"])) {
      $sql  .= $virgula." si198_codorgaoresp = '$this->si198_codorgaoresp' ";
      $virgula = ",";
      if (trim($this->si198_codorgaoresp) == null ) {
        $this->erro_sql = " Campo codorgaoresp não informado.";
        $this->erro_campo = "si198_codorgaoresp";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_codobra"])) {
      $sql  .= $virgula." si198_codobra = $this->si198_codobra ";
      $virgula = ",";
      if (trim($this->si198_codobra) == null ) {
        $this->erro_sql = " Campo codigoobra não informado.";
        $this->erro_campo = "si198_codobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_tiporesponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_tiporesponsavel"])) {
      $sql  .= $virgula." si198_tiporesponsavel = $this->si198_tiporesponsavel ";
      $virgula = ",";
      if (trim($this->si198_tiporesponsavel) == null ) {
        $this->erro_sql = " Campo Tipo responsavel não informado.";
        $this->erro_campo = "si198_tiporesponsavel";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_nrodocumento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_nrodocumento"])) {
      $sql  .= $virgula." si198_nrodocumento = '$this->si198_nrodocumento' ";
      $virgula = ",";
      if (trim($this->si198_nrodocumento) == null ) {
        $this->erro_sql = " Campo Numero Documento não informado.";
        $this->erro_campo = "si198_nrodocumento";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_tiporegistroconselho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_tiporegistroconselho"])) {
      $sql  .= $virgula." si198_tiporegistroconselho = $this->si198_tiporegistroconselho ";
      $virgula = ",";
      if (trim($this->si198_tiporegistroconselho) == null ) {
        $this->erro_sql = " Campo tipoRegistroConselho não informado.";
        $this->erro_campo = "si198_tiporegistroconselho";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_nroregistroconseprof)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_nroregistroconseprof"])) {
      $sql  .= $virgula." si198_nroregistroconseprof = '$this->si198_nroregistroconseprof' ";
      $virgula = ",";
      if (trim($this->si198_nroregistroconseprof) == null ) {
        $this->erro_sql = " Campo nroregistroconseprof não informado.";
        $this->erro_campo = "si198_nroregistroconseprof";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_numrt)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_numrt"])) {
      $sql  .= $virgula." si198_numrt = $this->si198_numrt ";
      $virgula = ",";
      if (trim($this->si198_numrt) == null ) {
        $this->erro_sql = " Campo numRT não informado.";
        $this->erro_campo = "si198_numrt";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_dtinicioatividadeseng)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_dtinicioatividadeseng_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si198_dtinicioatividadeseng_dia"] !="") ) {
      $sql  .= $virgula." si198_dtinicioatividadeseng = '$this->si198_dtinicioatividadeseng' ";
      $virgula = ",";
      if (trim($this->si198_dtinicioatividadeseng) == null ) {
        $this->erro_sql = " Campo dtinicioatividadeseng não informado.";
        $this->erro_campo = "si198_dtinicioatividadeseng_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si198_dtinicioatividadeseng_dia"])) {
        $sql  .= $virgula." si198_dtinicioatividadeseng = null ";
        $virgula = ",";
        if (trim($this->si198_dtinicioatividadeseng) == null ) {
          $this->erro_sql = " Campo dtinicioatividadeseng não informado.";
          $this->erro_campo = "si198_dtinicioatividadeseng_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si198_tipovinculo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_tipovinculo"])) {
      $sql  .= $virgula." si198_tipovinculo = $this->si198_tipovinculo ";
      $virgula = ",";
      if (trim($this->si198_tipovinculo) == null ) {
        $this->erro_sql = " Campo Tipovinculo não informado.";
        $this->erro_campo = "si198_tipovinculo";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_mes"])) {
      $sql  .= $virgula." si198_mes = $this->si198_mes ";
      $virgula = ",";
      if (trim($this->si198_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si198_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si198_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si198_instit"])) {
      $sql  .= $virgula." si198_instit = $this->si198_instit ";
      $virgula = ",";
      if (trim($this->si198_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si198_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si198_sequencial = '$si198_sequencial'";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "detalhamento dos responsaveis nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "detalhamento dos responsaveis nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $si198_sequencial=null ,$dbwhere=null) {

    $sql = " delete from cadobras102021
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si198_sequencial = '$si198_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "detalhamento dos responsaveis nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "detalhamento dos responsaveis nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:cadobras102021";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si198_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras102021 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si198_sequencial != "" && $si198_sequencial != null) {
        $sql2 = " where cadobras102021.si198_sequencial = '$si198_sequencial'";
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
  function sql_query_file ( $si198_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras102021 ";
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
