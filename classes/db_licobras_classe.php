<?php
//MODULO: Obras
//CLASSE DA ENTIDADE licobras
class cl_licobras {
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
  public $obr01_sequencial = 0;
  public $obr01_licitacao = 0;
  public $obr01_dtlancamento_dia = null;
  public $obr01_dtlancamento_mes = null;
  public $obr01_dtlancamento_ano = null;
  public $obr01_dtlancamento = null;
  public $obr01_numeroobra = 0;
  public $obr01_linkobra = null;
  public $obr01_tiporesponsavel = 0;
  public $obr01_responsavel = 0;
  public $obr01_tiporegistro = 0;
  public $obr01_numregistro = null;
  public $obr01_numartourrt = 0;
  public $obr01_dtinicioatividades_dia = null;
  public $obr01_dtinicioatividades_mes = null;
  public $obr01_dtinicioatividades_ano = null;
  public $obr01_dtinicioatividades = null;
  public $obr01_vinculoprofissional = 0;
  public $obr01_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 obr01_sequencial = int4 = Sequencial
                 obr01_licitacao = int4 = Processo Licitatório
                 obr01_dtlancamento = date = Data Lançamento
                 obr01_numeroobra = int4 = Nº Obra
                 obr01_linkobra = text = Link da Obra
                 obr01_tiporesponsavel = int4 = Tipo Responsável
                 obr01_responsavel = int4 = Responsável
                 obr01_tiporegistro = int4 = Tipo Registro
                 obr01_numregistro = text = Numero Registro
                 obr01_numartourrt = int4 = Numero da ART ou RRT
                 obr01_dtinicioatividades = date = Data Inicio das Ativ. do Eng na Obra
                 obr01_vinculoprofissional = int4 = Vinculo do Prof. com a Adm. Pública
                 obr01_instit = int4 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licobras");
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
       $this->obr01_sequencial = ($this->obr01_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_sequencial"]:$this->obr01_sequencial);
       $this->obr01_licitacao = ($this->obr01_licitacao == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_licitacao"]:$this->obr01_licitacao);
       if ($this->obr01_dtlancamento == "") {
         $this->obr01_dtlancamento_dia = ($this->obr01_dtlancamento_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"]:$this->obr01_dtlancamento_dia);
         $this->obr01_dtlancamento_mes = ($this->obr01_dtlancamento_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_mes"]:$this->obr01_dtlancamento_mes);
         $this->obr01_dtlancamento_ano = ($this->obr01_dtlancamento_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_ano"]:$this->obr01_dtlancamento_ano);
         if ($this->obr01_dtlancamento_dia != "") {
            $this->obr01_dtlancamento = $this->obr01_dtlancamento_ano."-".$this->obr01_dtlancamento_mes."-".$this->obr01_dtlancamento_dia;
         }
       }
       $this->obr01_numeroobra = ($this->obr01_numeroobra == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_numeroobra"]:$this->obr01_numeroobra);
       $this->obr01_linkobra = ($this->obr01_linkobra == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_linkobra"]:$this->obr01_linkobra);
       $this->obr01_tiporesponsavel = ($this->obr01_tiporesponsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_tiporesponsavel"]:$this->obr01_tiporesponsavel);
       $this->obr01_responsavel = ($this->obr01_responsavel == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_responsavel"]:$this->obr01_responsavel);
       $this->obr01_tiporegistro = ($this->obr01_tiporegistro == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_tiporegistro"]:$this->obr01_tiporegistro);
       $this->obr01_numregistro = ($this->obr01_numregistro == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_numregistro"]:$this->obr01_numregistro);
       $this->obr01_numartourrt = ($this->obr01_numartourrt == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_numartourrt"]:$this->obr01_numartourrt);
       if ($this->obr01_dtinicioatividades == "") {
         $this->obr01_dtinicioatividades_dia = ($this->obr01_dtinicioatividades_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_dtinicioatividades_dia"]:$this->obr01_dtinicioatividades_dia);
         $this->obr01_dtinicioatividades_mes = ($this->obr01_dtinicioatividades_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_dtinicioatividades_mes"]:$this->obr01_dtinicioatividades_mes);
         $this->obr01_dtinicioatividades_ano = ($this->obr01_dtinicioatividades_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_dtinicioatividades_ano"]:$this->obr01_dtinicioatividades_ano);
         if ($this->obr01_dtinicioatividades_dia != "") {
            $this->obr01_dtinicioatividades = $this->obr01_dtinicioatividades_ano."-".$this->obr01_dtinicioatividades_mes."-".$this->obr01_dtinicioatividades_dia;
         }
       }
       $this->obr01_vinculoprofissional = ($this->obr01_vinculoprofissional == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_vinculoprofissional"]:$this->obr01_vinculoprofissional);
       $this->obr01_instit = ($this->obr01_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["obr01_instit"]:$this->obr01_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () {
      $this->atualizacampos();
     if ($this->obr01_sequencial == null ) {

       $result = db_query("select nextval('licobras_obr01_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: licobras_obr01_sequencial_seq do campo: obr01_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->obr01_sequencial = pg_result($result,0,0);
     }
     if ($this->obr01_licitacao == null ) {
       $this->erro_sql = " Campo Processo Licitatório não informado.";
       $this->erro_campo = "obr01_licitacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_dtlancamento == null ) {
       $this->erro_sql = " Campo Data Lançamento não informado.";
       $this->erro_campo = "obr01_dtlancamento_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_numeroobra == null ) {
       $this->erro_sql = " Campo Nº Obra não informado.";
       $this->erro_campo = "obr01_numeroobra";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_linkobra == null ) {
       $this->erro_sql = " Campo Link da Obra não informado.";
       $this->erro_campo = "obr01_linkobra";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_tiporesponsavel == null ) {
       $this->erro_sql = " Campo Tipo Responsável não informado.";
       $this->erro_campo = "obr01_tiporesponsavel";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_responsavel == null ) {
       $this->erro_sql = " Campo Responsável não informado.";
       $this->erro_campo = "obr01_responsavel";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_tiporegistro == null ) {
       $this->erro_sql = " Campo Tipo Registro não informado.";
       $this->erro_campo = "obr01_tiporegistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_numregistro == null ) {
       $this->erro_sql = " Campo Numero Registro não informado.";
       $this->erro_campo = "obr01_numregistro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_numartourrt == null ) {
       $this->erro_sql = " Campo Numero da ART ou RRT não informado.";
       $this->erro_campo = "obr01_numartourrt";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_dtinicioatividades == null ) {
       $this->erro_sql = " Campo Data Inicio das Ativ. do Eng na Obra não informado.";
       $this->erro_campo = "obr01_dtinicioatividades_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_vinculoprofissional == null ) {
       $this->erro_sql = " Campo Vinculo do Prof. com a Adm. Pública não informado.";
       $this->erro_campo = "obr01_vinculoprofissional";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr01_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "obr01_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into licobras(
                                       obr01_sequencial
                                      ,obr01_licitacao
                                      ,obr01_dtlancamento
                                      ,obr01_numeroobra
                                      ,obr01_linkobra
                                      ,obr01_tiporesponsavel
                                      ,obr01_responsavel
                                      ,obr01_tiporegistro
                                      ,obr01_numregistro
                                      ,obr01_numartourrt
                                      ,obr01_dtinicioatividades
                                      ,obr01_vinculoprofissional
                                      ,obr01_instit
                       )
                values (
                                $this->obr01_sequencial
                               ,$this->obr01_licitacao
                               ,".($this->obr01_dtlancamento == "null" || $this->obr01_dtlancamento == ""?"null":"'".$this->obr01_dtlancamento."'")."
                               ,$this->obr01_numeroobra
                               ,'$this->obr01_linkobra'
                               ,$this->obr01_tiporesponsavel
                               ,$this->obr01_responsavel
                               ,$this->obr01_tiporegistro
                               ,'$this->obr01_numregistro'
                               ,$this->obr01_numartourrt
                               ,".($this->obr01_dtinicioatividades == "null" || $this->obr01_dtinicioatividades == ""?"null":"'".$this->obr01_dtinicioatividades."'")."
                               ,$this->obr01_vinculoprofissional
                               ,$this->obr01_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "licobras () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "licobras já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "licobras () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $oid=null ) {
      $this->atualizacampos();
     $sql = " update licobras set ";
     $virgula = "";
     if (trim($this->obr01_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_sequencial"])) {
       $sql  .= $virgula." obr01_sequencial = $this->obr01_sequencial ";
       $virgula = ",";
       if (trim($this->obr01_sequencial) == null ) {
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "obr01_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_licitacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_licitacao"])) {
       $sql  .= $virgula." obr01_licitacao = $this->obr01_licitacao ";
       $virgula = ",";
       if (trim($this->obr01_licitacao) == null ) {
         $this->erro_sql = " Campo Processo Licitatório não informado.";
         $this->erro_campo = "obr01_licitacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_dtlancamento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"] !="") ) {
       $sql  .= $virgula." obr01_dtlancamento = '$this->obr01_dtlancamento' ";
       $virgula = ",";
       if (trim($this->obr01_dtlancamento) == null ) {
         $this->erro_sql = " Campo Data Lançamento não informado.";
         $this->erro_campo = "obr01_dtlancamento_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["obr01_dtlancamento_dia"])) {
         $sql  .= $virgula." obr01_dtlancamento = null ";
         $virgula = ",";
         if (trim($this->obr01_dtlancamento) == null ) {
           $this->erro_sql = " Campo Data Lançamento não informado.";
           $this->erro_campo = "obr01_dtlancamento_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->obr01_numeroobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_numeroobra"])) {
       $sql  .= $virgula." obr01_numeroobra = $this->obr01_numeroobra ";
       $virgula = ",";
       if (trim($this->obr01_numeroobra) == null ) {
         $this->erro_sql = " Campo Nº Obra não informado.";
         $this->erro_campo = "obr01_numeroobra";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_linkobra)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_linkobra"])) {
       $sql  .= $virgula." obr01_linkobra = '$this->obr01_linkobra' ";
       $virgula = ",";
       if (trim($this->obr01_linkobra) == null ) {
         $this->erro_sql = " Campo Link da Obra não informado.";
         $this->erro_campo = "obr01_linkobra";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_tiporesponsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_tiporesponsavel"])) {
       $sql  .= $virgula." obr01_tiporesponsavel = $this->obr01_tiporesponsavel ";
       $virgula = ",";
       if (trim($this->obr01_tiporesponsavel) == null ) {
         $this->erro_sql = " Campo Tipo Responsável não informado.";
         $this->erro_campo = "obr01_tiporesponsavel";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_responsavel)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_responsavel"])) {
       $sql  .= $virgula." obr01_responsavel = $this->obr01_responsavel ";
       $virgula = ",";
       if (trim($this->obr01_responsavel) == null ) {
         $this->erro_sql = " Campo Responsável não informado.";
         $this->erro_campo = "obr01_responsavel";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_tiporegistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_tiporegistro"])) {
       $sql  .= $virgula." obr01_tiporegistro = $this->obr01_tiporegistro ";
       $virgula = ",";
       if (trim($this->obr01_tiporegistro) == null ) {
         $this->erro_sql = " Campo Tipo Registro não informado.";
         $this->erro_campo = "obr01_tiporegistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_numregistro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_numregistro"])) {
       $sql  .= $virgula." obr01_numregistro = '$this->obr01_numregistro' ";
       $virgula = ",";
       if (trim($this->obr01_numregistro) == null ) {
         $this->erro_sql = " Campo Numero Registro não informado.";
         $this->erro_campo = "obr01_numregistro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_numartourrt)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_numartourrt"])) {
       $sql  .= $virgula." obr01_numartourrt = $this->obr01_numartourrt ";
       $virgula = ",";
       if (trim($this->obr01_numartourrt) == null ) {
         $this->erro_sql = " Campo Numero da ART ou RRT não informado.";
         $this->erro_campo = "obr01_numartourrt";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_dtinicioatividades)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_dtinicioatividades_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["obr01_dtinicioatividades_dia"] !="") ) {
       $sql  .= $virgula." obr01_dtinicioatividades = '$this->obr01_dtinicioatividades' ";
       $virgula = ",";
       if (trim($this->obr01_dtinicioatividades) == null ) {
         $this->erro_sql = " Campo Data Inicio das Ativ. do Eng na Obra não informado.";
         $this->erro_campo = "obr01_dtinicioatividades_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["obr01_dtinicioatividades_dia"])) {
         $sql  .= $virgula." obr01_dtinicioatividades = null ";
         $virgula = ",";
         if (trim($this->obr01_dtinicioatividades) == null ) {
           $this->erro_sql = " Campo Data Inicio das Ativ. do Eng na Obra não informado.";
           $this->erro_campo = "obr01_dtinicioatividades_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if (trim($this->obr01_vinculoprofissional)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_vinculoprofissional"])) {
       $sql  .= $virgula." obr01_vinculoprofissional = $this->obr01_vinculoprofissional ";
       $virgula = ",";
       if (trim($this->obr01_vinculoprofissional) == null ) {
         $this->erro_sql = " Campo Vinculo do Prof. com a Adm. Pública não informado.";
         $this->erro_campo = "obr01_vinculoprofissional";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr01_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr01_instit"])) {
       $sql  .= $virgula." obr01_instit = $this->obr01_instit ";
       $virgula = ",";
       if (trim($this->obr01_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "obr01_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licobras nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "licobras nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $oid=null ,$dbwhere=null) {

     $sql = " delete from licobras
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "oid = '$oid'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "licobras nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "licobras nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:licobras";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from licobras ";
     $sql .= " inner join liclicita on liclicita.l20_codigo = licobras.obr01_licitacao ";
     $sql .= " inner join cflicita on cflicita.l03_codigo = liclicita.l20_codtipocom ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where obr01_sequencial = $oid";
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
  function sql_query_file ( $oid = null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from licobras ";
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
