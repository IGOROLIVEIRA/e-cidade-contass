<?php
//MODULO: sicom
//CLASSE DA ENTIDADE cadobras302020
class cl_cadobras302020 {
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
  public $si201_sequencial = 0;
  public $si201_tiporegistro = 0;
  public $si201_codorgaoresp = null;
  public $si201_codobra = 0;
  public $si201_tipomedicao = 0;
  public $si201_descoutrostiposmed = null;
  public $si201_nummedicao = null;
  public $si201_descmedicao = null;
  public $si201_dtiniciomedicao_dia = null;
  public $si201_dtiniciomedicao_mes = null;
  public $si201_dtiniciomedicao_ano = null;
  public $si201_dtiniciomedicao = null;
  public $si201_dtfimmedicao_dia = null;
  public $si201_dtfimmedicao_mes = null;
  public $si201_dtfimmedicao_ano = null;
  public $si201_dtfimmedicao = null;
  public $si201_dtmedicao_dia = null;
  public $si201_dtmedicao_mes = null;
  public $si201_dtmedicao_ano = null;
  public $si201_dtmedicao = null;
  public $si201_valormedicao = 0;
  public $si201_mes = 0;
  public $si201_pdf = null;
  public $si201_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 si201_sequencial = int8 = Sequencial
                 si201_tiporegistro = int8 = Tiporegistro
                 si201_codorgaoresp = text = codorgaoresp
                 si201_codobra = int8 = codigoobra
                 si201_tipomedicao = int8 = tipo medicao
                 si201_descoutrostiposmed = text = desc outros tipos medicao
                 si201_nummedicao = text = numero medicao
                 si201_descmedicao = text = desc medicao
                 si201_dtiniciomedicao = date = data incio
                 si201_dtfimmedicao = date = data fim
                 si201_dtmedicao = date = data medicao
                 si201_valormedicao = float = valor medicao
                 si201_mes = int4 = Mes
                 si201_pdf = text = pdf
                 si201_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cadobras302020");
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
      $this->si201_sequencial = ($this->si201_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_sequencial"]:$this->si201_sequencial);
      $this->si201_tiporegistro = ($this->si201_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"]:$this->si201_tiporegistro);
      $this->si201_codobra = ($this->si201_codobra == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_codobra"]:$this->si201_codobra);
      $this->si201_tipomedicao = ($this->si201_tipomedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_tipomedicao"]:$this->si201_tipomedicao);
      $this->si201_descoutrostiposmed = ($this->si201_descoutrostiposmed == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_descoutrostiposmed"]:$this->si201_descoutrostiposmed);
      $this->si201_nummedicao = ($this->si201_nummedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_nummedicao"]:$this->si201_nummedicao);
      $this->si201_descmedicao = ($this->si201_descmedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_descmedicao"]:$this->si201_descmedicao);
      if ($this->si201_dtiniciomedicao == "") {
        $this->si201_dtiniciomedicao_dia = ($this->si201_dtiniciomedicao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtiniciomedicao_dia"]:$this->si201_dtiniciomedicao_dia);
        $this->si201_dtiniciomedicao_mes = ($this->si201_dtiniciomedicao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtiniciomedicao_mes"]:$this->si201_dtiniciomedicao_mes);
        $this->si201_dtiniciomedicao_ano = ($this->si201_dtiniciomedicao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtiniciomedicao_ano"]:$this->si201_dtiniciomedicao_ano);
        if ($this->si201_dtiniciomedicao_dia != "") {
          $this->si201_dtiniciomedicao = $this->si201_dtiniciomedicao_ano."-".$this->si201_dtiniciomedicao_mes."-".$this->si201_dtiniciomedicao_dia;
        }
      }
      if ($this->si201_dtfimmedicao == "") {
        $this->si201_dtfimmedicao_dia = ($this->si201_dtfimmedicao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtfimmedicao_dia"]:$this->si201_dtfimmedicao_dia);
        $this->si201_dtfimmedicao_mes = ($this->si201_dtfimmedicao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtfimmedicao_mes"]:$this->si201_dtfimmedicao_mes);
        $this->si201_dtfimmedicao_ano = ($this->si201_dtfimmedicao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtfimmedicao_ano"]:$this->si201_dtfimmedicao_ano);
        if ($this->si201_dtfimmedicao_dia != "") {
          $this->si201_dtfimmedicao = $this->si201_dtfimmedicao_ano."-".$this->si201_dtfimmedicao_mes."-".$this->si201_dtfimmedicao_dia;
        }
      }
      if ($this->si201_dtmedicao == "") {
        $this->si201_dtmedicao_dia = ($this->si201_dtmedicao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtmedicao_dia"]:$this->si201_dtmedicao_dia);
        $this->si201_dtmedicao_mes = ($this->si201_dtmedicao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtmedicao_mes"]:$this->si201_dtmedicao_mes);
        $this->si201_dtmedicao_ano = ($this->si201_dtmedicao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_dtmedicao_ano"]:$this->si201_dtmedicao_ano);
        if ($this->si201_dtmedicao_dia != "") {
          $this->si201_dtmedicao = $this->si201_dtmedicao_ano."-".$this->si201_dtmedicao_mes."-".$this->si201_dtmedicao_dia;
        }
      }
      $this->si201_valormedicao = ($this->si201_valormedicao == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_valormedicao"]:$this->si201_valormedicao);
      $this->si201_mes = ($this->si201_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_mes"]:$this->si201_mes);
      $this->si201_pdf = ($this->si201_pdf == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_pdf"]:$this->si201_pdf);
      $this->si201_instit = ($this->si201_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["si201_instit"]:$this->si201_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->si201_sequencial == null ) {
      $result = db_query("select nextval('cadobras302020_si201_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: cadobras302020_si201_sequencial_seq do campo: si201_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si201_sequencial = pg_result($result,0,0);
    }
    if ($this->si201_tiporegistro == null ) {
      $this->erro_sql = " Campo Tiporegistro não informado.";
      $this->erro_campo = "si201_tiporegistro";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si201_codobra == null ) {
      $this->erro_sql = " Campo codigoobra não informado.";
      $this->erro_campo = "si201_codobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si201_tipomedicao == null ) {
      $this->erro_sql = " Campo tipo medicao não informado.";
      $this->erro_campo = "si201_tipomedicao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
//    if ($this->si201_descoutrostiposmed == null ) {
//      $this->erro_sql = " Campo desc outros tipos medicao não informado.";
//      $this->erro_campo = "si201_descoutrostiposmed";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//      $this->erro_status = "0";
//      return false;
//    }
    if ($this->si201_nummedicao == null ) {
      $this->erro_sql = " Campo numero medicao não informado.";
      $this->erro_campo = "si201_nummedicao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
//    if ($this->si201_descmedicao == null ) {
//      $this->erro_sql = " Campo desc medicao não informado.";
//      $this->erro_campo = "si201_descmedicao";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//      $this->erro_status = "0";
//      return false;
//    }
    if ($this->si201_dtiniciomedicao == null ) {
      $this->erro_sql = " Campo data incio não informado.";
      $this->erro_campo = "si201_dtiniciomedicao_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si201_dtfimmedicao == null ) {
      $this->erro_sql = " Campo data fim não informado.";
      $this->erro_campo = "si201_dtfimmedicao_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si201_dtmedicao == null ) {
      $this->erro_sql = " Campo data medicao não informado.";
      $this->erro_campo = "si201_dtmedicao_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si201_valormedicao == null ) {
      $this->erro_sql = " Campo valor medicao não informado.";
      $this->erro_campo = "si201_valormedicao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si201_mes == null ) {
      $this->erro_sql = " Campo Mes não informado.";
      $this->erro_campo = "si201_mes";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->si201_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "si201_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into cadobras302020(
                                       si201_sequencial
                                      ,si201_tiporegistro
                                      ,si201_codorgaoresp
                                      ,si201_codobra
                                      ,si201_tipomedicao
                                      ,si201_descoutrostiposmed
                                      ,si201_nummedicao
                                      ,si201_descmedicao
                                      ,si201_dtiniciomedicao
                                      ,si201_dtfimmedicao
                                      ,si201_dtmedicao
                                      ,si201_valormedicao
                                      ,si201_mes
                                      ,si201_pdf
                                      ,si201_instit
                       )
                values (
                                $this->si201_sequencial
                               ,$this->si201_tiporegistro
                               ,$this->si201_codorgaoresp
                               ,$this->si201_codobra
                               ,$this->si201_tipomedicao
                               ,'$this->si201_descoutrostiposmed'
                               ,'$this->si201_nummedicao'
                               ,'$this->si201_descmedicao'
                               ,".($this->si201_dtiniciomedicao == "null" || $this->si201_dtiniciomedicao == ""?"null":"'".$this->si201_dtiniciomedicao."'")."
                               ,".($this->si201_dtfimmedicao == "null" || $this->si201_dtfimmedicao == ""?"null":"'".$this->si201_dtfimmedicao."'")."
                               ,".($this->si201_dtmedicao == "null" || $this->si201_dtmedicao == ""?"null":"'".$this->si201_dtmedicao."'")."
                               ,$this->si201_valormedicao
                               ,$this->si201_mes
                               ,'$this->si201_pdf'
                               ,$this->si201_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "detalhamento da medicao () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "detalhamento da medicao já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "detalhamento da medicao () nao Incluído. Inclusao Abortada.";
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
//    $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
//    if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
//        && ($lSessaoDesativarAccount === false))) {
//
//    }
    return true;
  }

  // funcao para alteracao
  function alterar ( $si201_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update cadobras302020 set ";
    $virgula = "";
    if (trim($this->si201_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_sequencial"])) {
      $sql  .= $virgula." si201_sequencial = $this->si201_sequencial ";
      $virgula = ",";
      if (trim($this->si201_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "si201_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_tiporegistro"])) {
      $sql  .= $virgula." si201_tiporegistro = $this->si201_tiporegistro ";
      $virgula = ",";
      if (trim($this->si201_tiporegistro) == null ) {
        $this->erro_sql = " Campo Tiporegistro não informado.";
        $this->erro_campo = "si201_tiporegistro";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_codobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_codobra"])) {
      $sql  .= $virgula." si201_codobra = $this->si201_codobra ";
      $virgula = ",";
      if (trim($this->si201_codobra) == null ) {
        $this->erro_sql = " Campo codigoobra não informado.";
        $this->erro_campo = "si201_codobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_tipomedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_tipomedicao"])) {
      $sql  .= $virgula." si201_tipomedicao = $this->si201_tipomedicao ";
      $virgula = ",";
      if (trim($this->si201_tipomedicao) == null ) {
        $this->erro_sql = " Campo tipo medicao não informado.";
        $this->erro_campo = "si201_tipomedicao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_descoutrostiposmed)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_descoutrostiposmed"])) {
      $sql  .= $virgula." si201_descoutrostiposmed = '$this->si201_descoutrostiposmed' ";
      $virgula = ",";
      if (trim($this->si201_descoutrostiposmed) == null ) {
        $this->erro_sql = " Campo desc outros tipos medicao não informado.";
        $this->erro_campo = "si201_descoutrostiposmed";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_nummedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_nummedicao"])) {
      $sql  .= $virgula." si201_nummedicao = '$this->si201_nummedicao' ";
      $virgula = ",";
      if (trim($this->si201_nummedicao) == null ) {
        $this->erro_sql = " Campo numero medicao não informado.";
        $this->erro_campo = "si201_nummedicao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_descmedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_descmedicao"])) {
      $sql  .= $virgula." si201_descmedicao = '$this->si201_descmedicao' ";
      $virgula = ",";
      if (trim($this->si201_descmedicao) == null ) {
        $this->erro_sql = " Campo desc medicao não informado.";
        $this->erro_campo = "si201_descmedicao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_dtiniciomedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_dtiniciomedicao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si201_dtiniciomedicao_dia"] !="") ) {
      $sql  .= $virgula." si201_dtiniciomedicao = '$this->si201_dtiniciomedicao' ";
      $virgula = ",";
      if (trim($this->si201_dtiniciomedicao) == null ) {
        $this->erro_sql = " Campo data incio não informado.";
        $this->erro_campo = "si201_dtiniciomedicao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si201_dtiniciomedicao_dia"])) {
        $sql  .= $virgula." si201_dtiniciomedicao = null ";
        $virgula = ",";
        if (trim($this->si201_dtiniciomedicao) == null ) {
          $this->erro_sql = " Campo data incio não informado.";
          $this->erro_campo = "si201_dtiniciomedicao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si201_dtfimmedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_dtfimmedicao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si201_dtfimmedicao_dia"] !="") ) {
      $sql  .= $virgula." si201_dtfimmedicao = '$this->si201_dtfimmedicao' ";
      $virgula = ",";
      if (trim($this->si201_dtfimmedicao) == null ) {
        $this->erro_sql = " Campo data fim não informado.";
        $this->erro_campo = "si201_dtfimmedicao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si201_dtfimmedicao_dia"])) {
        $sql  .= $virgula." si201_dtfimmedicao = null ";
        $virgula = ",";
        if (trim($this->si201_dtfimmedicao) == null ) {
          $this->erro_sql = " Campo data fim não informado.";
          $this->erro_campo = "si201_dtfimmedicao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si201_dtmedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_dtmedicao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["si201_dtmedicao_dia"] !="") ) {
      $sql  .= $virgula." si201_dtmedicao = '$this->si201_dtmedicao' ";
      $virgula = ",";
      if (trim($this->si201_dtmedicao) == null ) {
        $this->erro_sql = " Campo data medicao não informado.";
        $this->erro_campo = "si201_dtmedicao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["si201_dtmedicao_dia"])) {
        $sql  .= $virgula." si201_dtmedicao = null ";
        $virgula = ",";
        if (trim($this->si201_dtmedicao) == null ) {
          $this->erro_sql = " Campo data medicao não informado.";
          $this->erro_campo = "si201_dtmedicao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->si201_valormedicao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_valormedicao"])) {
      $sql  .= $virgula." si201_valormedicao = $this->si201_valormedicao ";
      $virgula = ",";
      if (trim($this->si201_valormedicao) == null ) {
        $this->erro_sql = " Campo valor medicao não informado.";
        $this->erro_campo = "si201_valormedicao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_mes"])) {
      $sql  .= $virgula." si201_mes = $this->si201_mes ";
      $virgula = ",";
      if (trim($this->si201_mes) == null ) {
        $this->erro_sql = " Campo Mes não informado.";
        $this->erro_campo = "si201_mes";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->si201_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si201_instit"])) {
      $sql  .= $virgula." si201_instit = $this->si201_instit ";
      $virgula = ",";
      if (trim($this->si201_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "si201_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "si201_sequencial = '$si201_sequencial'";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "detalhamento da medicao nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "detalhamento da medicao nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $si201_sequencial=null ,$dbwhere=null) {

    $sql = " delete from cadobras302020
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "si201_sequencial = '$si201_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "detalhamento da medicao nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "detalhamento da medicao nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:cadobras302020";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $si201_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras302020 ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $si201_sequencial != "" && $si201_sequencial != null) {
        $sql2 = " where cadobras302020.si201_sequencial = '$si201_sequencial'";
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
  function sql_query_file ( $si201_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from cadobras302020 ";
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
