<?php
//MODULO: Obras
//CLASSE DA ENTIDADE licobrasituacao
class cl_licobrasituacao {
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
  public $obr02_sequencial = 0;
  public $obr02_seqobra = 0;
  public $obr02_dtlancamento_dia = null;
  public $obr02_dtlancamento_mes = null;
  public $obr02_dtlancamento_ano = null;
  public $obr02_dtlancamento = null;
  public $obr02_situacao = 0;
  public $obr02_dtsituacao_dia = null;
  public $obr02_dtsituacao_mes = null;
  public $obr02_dtsituacao_ano = null;
  public $obr02_dtsituacao = null;
  public $obr02_veiculopublicacao = null;
  public $obr02_dtpublicacao_dia = null;
  public $obr02_dtpublicacao_mes = null;
  public $obr02_dtpublicacao_ano = null;
  public $obr02_dtpublicacao = null;
  public $obr02_descrisituacao = null;
  public $obr02_motivoparalisacao = 0;
  public $obr02_dtparalisacao_dia = null;
  public $obr02_dtparalisacao_mes = null;
  public $obr02_dtparalisacao_ano = null;
  public $obr02_dtparalisacao = null;
  public $obr02_outrosmotivos = null;
  public $obr02_dtretomada_dia = null;
  public $obr02_dtretomada_mes = null;
  public $obr02_dtretomada_ano = null;
  public $obr02_dtretomada = null;
  public $obr02_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 obr02_sequencial = int4 = Sequencial
                 obr02_seqobra = int4 = Nº Obra
                 obr02_dtlancamento = date = Data Lançamento
                 obr02_situacao = int4 = Situação
                 obr02_dtsituacao = date = Data Situação
                 obr02_veiculopublicacao = text = Veículo Publicação
                 obr02_dtpublicacao = date = data de publicação
                 obr02_descrisituacao = text = Desc. Situação da Obra
                 obr02_motivoparalisacao = int4 = Motivo Paralização
                 obr02_dtparalisacao = date = Data Paralização
                 obr02_outrosmotivos = text = Outros Motivos
                 obr02_dtretomada = date = Data Retomada
                 obr02_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licobrasituacao");
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
      $this->obr02_sequencial = ($this->obr02_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_sequencial"]:$this->obr02_sequencial);
      $this->obr02_seqobra = ($this->obr02_seqobra == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_seqobra"]:$this->obr02_seqobra);
      if ($this->obr02_dtlancamento == "") {
        $this->obr02_dtlancamento_dia = ($this->obr02_dtlancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtlancamento_dia"]:$this->obr02_dtlancamento_dia);
        $this->obr02_dtlancamento_mes = ($this->obr02_dtlancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtlancamento_mes"]:$this->obr02_dtlancamento_mes);
        $this->obr02_dtlancamento_ano = ($this->obr02_dtlancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtlancamento_ano"]:$this->obr02_dtlancamento_ano);
        if ($this->obr02_dtlancamento_dia != "") {
          $this->obr02_dtlancamento = $this->obr02_dtlancamento_ano."-".$this->obr02_dtlancamento_mes."-".$this->obr02_dtlancamento_dia;
        }
      }
      $this->obr02_situacao = ($this->obr02_situacao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_situacao"]:$this->obr02_situacao);
      if ($this->obr02_dtsituacao == "") {
        $this->obr02_dtsituacao_dia = ($this->obr02_dtsituacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtsituacao_dia"]:$this->obr02_dtsituacao_dia);
        $this->obr02_dtsituacao_mes = ($this->obr02_dtsituacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtsituacao_mes"]:$this->obr02_dtsituacao_mes);
        $this->obr02_dtsituacao_ano = ($this->obr02_dtsituacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtsituacao_ano"]:$this->obr02_dtsituacao_ano);
        if ($this->obr02_dtsituacao_dia != "") {
          $this->obr02_dtsituacao = $this->obr02_dtsituacao_ano."-".$this->obr02_dtsituacao_mes."-".$this->obr02_dtsituacao_dia;
        }
      }
      $this->obr02_veiculopublicacao = ($this->obr02_veiculopublicacao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_veiculopublicacao"]:$this->obr02_veiculopublicacao);

      if ($this->obr02_dtpublicacao == "") {
        $this->obr02_dtpublicacao_dia = ($this->obr02_dtpublicacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtpublicacao_dia"]:$this->obr02_dtpublicacao_dia);
        $this->obr02_dtpublicacao_mes = ($this->obr02_dtpublicacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtpublicacao_mes"]:$this->obr02_dtpublicacao_mes);
        $this->obr02_dtpublicacao_ano = ($this->obr02_dtpublicacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtpublicacao_ano"]:$this->obr02_dtpublicacao_ano);
        if ($this->obr02_dtpublicacao_dia != "") {
          $this->obr02_dtpublicacao = $this->obr02_dtpublicacao_ano."-".$this->obr02_dtpublicacao_mes."-".$this->obr02_dtpublicacao_dia;
        }
      }

      $this->obr02_descrisituacao = ($this->obr02_descrisituacao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_descrisituacao"]:$this->obr02_descrisituacao);
      $this->obr02_motivoparalisacao = ($this->obr02_motivoparalisacao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_motivoparalisacao"]:$this->obr02_motivoparalisacao);
      if ($this->obr02_dtparalisacao == "") {
        $this->obr02_dtparalisacao_dia = ($this->obr02_dtparalisacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtparalisacao_dia"]:$this->obr02_dtparalisacao_dia);
        $this->obr02_dtparalisacao_mes = ($this->obr02_dtparalisacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtparalisacao_mes"]:$this->obr02_dtparalisacao_mes);
        $this->obr02_dtparalisacao_ano = ($this->obr02_dtparalisacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtparalisacao_ano"]:$this->obr02_dtparalisacao_ano);
        if ($this->obr02_dtparalisacao_dia != "") {
          $this->obr02_dtparalisacao = $this->obr02_dtparalisacao_ano."-".$this->obr02_dtparalisacao_mes."-".$this->obr02_dtparalisacao_dia;
        }
      }
      $this->obr02_outrosmotivos = ($this->obr02_outrosmotivos == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_outrosmotivos"]:$this->obr02_outrosmotivos);
      if ($this->obr02_dtretomada == "") {
        $this->obr02_dtretomada_dia = ($this->obr02_dtretomada_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtretomada_dia"]:$this->obr02_dtretomada_dia);
        $this->obr02_dtretomada_mes = ($this->obr02_dtretomada_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtretomada_mes"]:$this->obr02_dtretomada_mes);
        $this->obr02_dtretomada_ano = ($this->obr02_dtretomada_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_dtretomada_ano"]:$this->obr02_dtretomada_ano);
        if ($this->obr02_dtretomada_dia != "") {
          $this->obr02_dtretomada = $this->obr02_dtretomada_ano."-".$this->obr02_dtretomada_mes."-".$this->obr02_dtretomada_dia;
        }
      }
      $this->obr02_instit = ($this->obr02_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["obr02_instit"]:$this->obr02_instit);
    } else {
    }
  }

  // funcao para inclusao
  function incluir () {
    $this->atualizacampos();
    if ($this->obr02_sequencial == null ) {
      $result = db_query("select nextval('licobrasituacao_obr02_sequencial_seq')");
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: licobrasituacao_obr02_sequencial_seq do campo: obr02_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->obr02_sequencial = pg_result($result,0,0);
    }

    if ($this->obr02_seqobra == null ) {
      $this->erro_sql = " Campo Nº Obra não informado.";
      $this->erro_campo = "obr02_seqobra";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr02_dtlancamento == null ) {
      $this->erro_sql = " Campo Data Lançamento não informado.";
      $this->erro_campo = "obr02_dtlancamento_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr02_situacao == null ) {
      $this->erro_sql = " Campo Situação não informado.";
      $this->erro_campo = "obr02_situacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr02_dtsituacao == null ) {
      $this->erro_sql = " Campo Data Situação não informado.";
      $this->erro_campo = "obr02_dtsituacao_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    if ($this->obr02_veiculopublicacao == null ) {
      $this->erro_sql = " Campo Veículo Publicação não informado.";
      $this->erro_campo = "obr02_veiculopublicacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }

    if ($this->obr02_dtpublicacao == null ) {
      $this->erro_sql = " Campo Data Publicação não informado.";
      $this->erro_campo = "obr02_dtpublicacao";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }

//    if ($this->obr02_descrisituacao == null ) {
//      $this->erro_sql = " Campo Desc. Situação da Obra não informado.";
//      $this->erro_campo = "obr02_descrisituacao";
//      $this->erro_banco = "";
//      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//      $this->erro_status = "0";
//      return false;
//    }
    /**
     * VALIDAÇÕES
     *
     */
    if($this->obr02_situacao == "3" || $this->obr02_situacao == "4"){
      if ($this->obr02_motivoparalisacao == null || $this->obr02_motivoparalisacao == "0" ) {
        $this->erro_sql = " Campo Motivo Paralização não informado.";
        $this->erro_campo = "obr02_motivoparalisacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }

      if ($this->obr02_dtparalisacao == null || $this->obr02_dtparalisacao == "0") {
        $this->erro_sql = " Campo Data Paralização não informado.";
        $this->erro_campo = "obr02_dtparalisacao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }

//      if ($this->obr02_dtretomada == null ) {
//        $this->erro_sql = " Campo Data Retomada não informado.";
//        $this->erro_campo = "obr02_dtretomada_dia";
//        $this->erro_banco = "";
//        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//        $this->erro_status = "0";
//        return false;
//      }

      if($this->obr02_motivoparalisacao == "99"){
        if ($this->obr02_outrosmotivos == null ) {
          $this->erro_sql = " Campo Outros Motivos não informado.";
          $this->erro_campo = "obr02_outrosmotivos";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }

    if ($this->obr02_instit == null ) {
      $this->erro_sql = " Campo Instituição não informado.";
      $this->erro_campo = "obr02_instit";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    $sql = "insert into licobrasituacao(
                                       obr02_sequencial
                                      ,obr02_seqobra
                                      ,obr02_dtlancamento
                                      ,obr02_situacao
                                      ,obr02_dtsituacao
                                      ,obr02_veiculopublicacao
                                      ,obr02_dtpublicacao
                                      ,obr02_descrisituacao
                                      ,obr02_motivoparalisacao
                                      ,obr02_dtparalisacao
                                      ,obr02_outrosmotivos
                                      ,obr02_dtretomada
                                      ,obr02_instit
                       )
                values (
                                $this->obr02_sequencial
                               ,$this->obr02_seqobra
                               ,".($this->obr02_dtlancamento == "null" || $this->obr02_dtlancamento == ""?"null":"'".$this->obr02_dtlancamento."'")."
                               ,$this->obr02_situacao
                               ,".($this->obr02_dtsituacao == "null" || $this->obr02_dtsituacao == ""?"null":"'".$this->obr02_dtsituacao."'")."
                               ,'$this->obr02_veiculopublicacao'
                               ,".($this->obr02_dtpublicacao == "null" || $this->obr02_dtpublicacao == ""?"null":"'".$this->obr02_dtpublicacao."'")."
                               ,'$this->obr02_descrisituacao'
                               ,$this->obr02_motivoparalisacao
                               ,".($this->obr02_dtparalisacao == "null" || $this->obr02_dtparalisacao == ""?"null":"'".$this->obr02_dtparalisacao."'")."
                               ,'$this->obr02_outrosmotivos'
                               ,".($this->obr02_dtretomada == "null" || $this->obr02_dtretomada == ""?"null":"'".$this->obr02_dtretomada."'")."
                               ,$this->obr02_instit
                      )";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
        $this->erro_sql   = "cadastro de situacao de obras () nao Incluído. Inclusao Abortada.";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_banco = "cadastro de situacao de obras já Cadastrado";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      } else {
        $this->erro_sql   = "cadastro de situacao de obras () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $obr02_sequencial=null ) {
    $this->atualizacampos();
    $sql = " update licobrasituacao set ";
    $virgula = "";
    if (trim($this->obr02_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_sequencial"])) {
      $sql  .= $virgula." obr02_sequencial = $this->obr02_sequencial ";
      $virgula = ",";
      if (trim($this->obr02_sequencial) == null ) {
        $this->erro_sql = " Campo Sequencial não informado.";
        $this->erro_campo = "obr02_sequencial";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr02_seqobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_seqobra"])) {
      $sql  .= $virgula." obr02_seqobra = $this->obr02_seqobra ";
      $virgula = ",";
      if (trim($this->obr02_seqobra) == null ) {
        $this->erro_sql = " Campo Nº Obra não informado.";
        $this->erro_campo = "obr02_seqobra";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    if (trim($this->obr02_dtlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr02_dtlancamento_dia"] !="") ) {
      $sql  .= $virgula." obr02_dtlancamento = '$this->obr02_dtlancamento' ";
      $virgula = ",";
      if (trim($this->obr02_dtlancamento) == null ) {
        $this->erro_sql = " Campo Data Lançamento não informado.";
        $this->erro_campo = "obr02_dtlancamento_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtlancamento_dia"])) {
        $sql  .= $virgula." obr02_dtlancamento = null ";
        $virgula = ",";
        if (trim($this->obr02_dtlancamento) == null ) {
          $this->erro_sql = " Campo Data Lançamento não informado.";
          $this->erro_campo = "obr02_dtlancamento_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->obr02_situacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_situacao"])) {
      $sql  .= $virgula." obr02_situacao = $this->obr02_situacao ";
      $virgula = ",";
      if (trim($this->obr02_situacao) == null ) {
        $this->erro_sql = " Campo Situação não informado.";
        $this->erro_campo = "obr02_situacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    /**
     * VALIDAÇÕES DA TELA
     */
    if($this->obr02_situacao == "3" || $this->obr02_situacao == "4"){
      if (trim($this->obr02_motivoparalisacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_motivoparalisacao"])) {
        $sql  .= $virgula." obr02_motivoparalisacao = $this->obr02_motivoparalisacao ";
        $virgula = ",";
        if (trim($this->obr02_motivoparalisacao) == null || $this->obr02_motivoparalisacao == "0") {
          $this->erro_sql = " Campo Motivo Paralização não informado.";
          $this->erro_campo = "obr02_motivoparalisacao";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }

      if (trim($this->obr02_dtparalisacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtparalisacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr02_dtparalisacao_dia"] !="") ) {
        $sql  .= $virgula." obr02_dtparalisacao = '$this->obr02_dtparalisacao' ";
        $virgula = ",";
        if (trim($this->obr02_dtparalisacao) == null ) {
          $this->erro_sql = " Campo Data Paralisação não informado.";
          $this->erro_campo = "obr02_dtparalisacao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }     else{
        if (isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtparalisacao_dia"])) {
          $sql  .= $virgula." obr02_dtparalisacao = null ";
          $virgula = ",";
          if (trim($this->obr02_dtparalisacao) == null ) {
            $this->erro_sql = " Campo Data Paralisação não informado.";
            $this->erro_campo = "obr02_dtparalisacao_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
          }
        }
      }

      if($this->obr02_motivoparalisacao == "99"){
        if (trim($this->obr02_outrosmotivos)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_outrosmotivos"])) {
          $sql  .= $virgula." obr02_outrosmotivos = '$this->obr02_outrosmotivos' ";
          $virgula = ",";
          if (trim($this->obr02_outrosmotivos) == null ) {
            $this->erro_sql = " Campo Outros Motivos não informado.";
            $this->erro_campo = "obr02_outrosmotivos";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
          }
        }
      }

      if (trim($this->obr02_dtretomada)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtretomada_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr02_dtretomada_dia"] !="") ) {
        $sql  .= $virgula." obr02_dtretomada = '$this->obr02_dtretomada' ";
        $virgula = ",";
        if (trim($this->obr02_dtretomada) == null ) {
          $this->erro_sql = " Campo Data Retomada não informado.";
          $this->erro_campo = "obr02_dtretomada_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }     else{
        if (isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtretomada_dia"])) {
          $sql  .= $virgula." obr02_dtretomada = null ";
          $virgula = ",";
          if (trim($this->obr02_dtretomada) == null ) {
            $this->erro_sql = " Campo Data Retomada não informado.";
            $this->erro_campo = "obr02_dtretomada_dia";
            $this->erro_banco = "";
            $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
            $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
            $this->erro_status = "0";
            return false;
          }
        }
      }
    }
    if (trim($this->obr02_dtsituacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtsituacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr02_dtsituacao_dia"] !="") ) {
      $sql  .= $virgula." obr02_dtsituacao = '$this->obr02_dtsituacao' ";
      $virgula = ",";
      if (trim($this->obr02_dtsituacao) == null ) {
        $this->erro_sql = " Campo Data Situação não informado.";
        $this->erro_campo = "obr02_dtsituacao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtsituacao_dia"])) {
        $sql  .= $virgula." obr02_dtsituacao = null ";
        $virgula = ",";
        if (trim($this->obr02_dtsituacao) == null ) {
          $this->erro_sql = " Campo Data Situação não informado.";
          $this->erro_campo = "obr02_dtsituacao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
    if (trim($this->obr02_veiculopublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_veiculopublicacao"])) {
      $sql  .= $virgula." obr02_veiculopublicacao = '$this->obr02_veiculopublicacao' ";
      $virgula = ",";
      if (trim($this->obr02_veiculopublicacao) == null ) {
        $this->erro_sql = " Campo Veículo Publicação não informado.";
        $this->erro_campo = "obr02_veiculopublicacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->obr02_dtpublicacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtpublicacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr02_dtpublicacao_dia"] !="") ) {
      $sql  .= $virgula." obr02_dtpublicacao = '$this->obr02_dtpublicacao' ";
      $virgula = ",";
      if (trim($this->obr02_dtpublicacao) == null ) {
        $this->erro_sql = " Campo Data Situação não informado.";
        $this->erro_campo = "obr02_dtpublicacao_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{
      if (isset($GLOBALS["HTTP_POST_VARS"]["obr02_dtpublicacao_dia"])) {
        $sql  .= $virgula." obr02_dtpublicacao = null ";
        $virgula = ",";
        if (trim($this->obr02_dtpublicacao) == null ) {
          $this->erro_sql = " Campo Data Situação não informado.";
          $this->erro_campo = "obr02_dtpublicacao_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }

    if (trim($this->obr02_descrisituacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_descrisituacao"])) {
      $sql  .= $virgula." obr02_descrisituacao = '$this->obr02_descrisituacao' ";
      $virgula = ",";
      if (trim($this->obr02_descrisituacao) == null ) {
        $this->erro_sql = " Campo Desc. Situação da Obra não informado.";
        $this->erro_campo = "obr02_descrisituacao";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }

    if (trim($this->obr02_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr02_instit"])) {
      $sql  .= $virgula." obr02_instit = $this->obr02_instit ";
      $virgula = ",";
      if (trim($this->obr02_instit) == null ) {
        $this->erro_sql = " Campo Instituição não informado.";
        $this->erro_campo = "obr02_instit";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
    $sql .= " where ";
    $sql .= "obr02_sequencial = $obr02_sequencial";
    $result = db_query($sql);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro de situacao de obras nao Alterado. Alteracao Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_alterar = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro de situacao de obras nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $obr02_sequencial=null ,$dbwhere=null) {

    $sql = " delete from licobrasituacao
                    where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
      $sql2 = "obr02_sequencial = '$obr02_sequencial'";
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) {
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "cadastro de situacao de obras nao Excluído. Exclusão Abortada.\\n";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "cadastro de situacao de obras nao Encontrado. Exclusão não Efetuada.\\n";
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
      $this->erro_sql   = "Record Vazio na Tabela:licobrasituacao";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
    return $result;
  }

  // funcao do sql
  function sql_query ( $obr02_sequencial = null,$campos="licobrasituacao.obr02_sequencial,*",$ordem=null,$dbwhere="") {
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
    $sql .= " from licobrasituacao ";
    $sql .= " inner join licobras on licobras.obr01_sequencial = licobrasituacao.obr02_seqobra ";
    $sql .= " left join liclicita on liclicita.l20_codigo = licobras.obr01_licitacao ";
    $sql .= " left join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom ";
    $sql2 = "";
    if ($dbwhere=="") {
      if ( $obr02_sequencial != "" && $obr02_sequencial != null) {
        $sql2 = " where licobrasituacao.obr02_sequencial = $obr02_sequencial";
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
  function sql_query_file ( $obr02_sequencial = null,$campos="*",$ordem=null,$dbwhere="") {
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
    $sql .= " from licobrasituacao ";
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
