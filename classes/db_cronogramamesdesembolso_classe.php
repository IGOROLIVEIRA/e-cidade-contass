<?php
//MODULO: orcamento
//CLASSE DA ENTIDADE cronogramamesdesembolso
class cl_cronogramamesdesembolso {
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
  public $o202_sequencial = 0;
  public $o202_unidade = 0;
  public $o202_orgao = 0;
  public $o202_anousu = 0;
  public $o202_elemento = null;
  public $o202_janeiro = 0;
  public $o202_fevereiro = 0;
  public $o202_marco = 0;
  public $o202_abril = 0;
  public $o202_maio = 0;
  public $o202_junho = 0;
  public $o202_julho = 0;
  public $o202_agosto = 0;
  public $o202_setembro = 0;
  public $o202_outubro = 0;
  public $o202_novembro = 0;
  public $o202_dezembro = 0;
  public $o202_instit = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 o202_sequencial = int8 = Código Sequencial
                 o202_unidade = int8 = Unidade
                 o202_orgao = int8 = Orgão
                 o202_anousu = int8 = Ano
                 o202_elemento = varchar = Elemento
                 o202_janeiro = float8 = Janeiro
                 o202_fevereiro = float8 = Fevereiro
                 o202_marco = float8 = Março
                 o202_abril = float8 = Abril
                 o202_maio = float8 = Maio
                 o202_junho = float8 = Junho
                 o202_julho = float8 = Julho
                 o202_agosto = float8 = Agosto
                 o202_setembro = float8 = Setembro
                 o202_outubro = float8 = Outubro
                 o202_novembro = float8 = Novembro
                 o202_dezembro = float8 = Dezembro
                 o202_instit = int8 = Instituição
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("cronogramamesdesembolso");
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
       $this->o202_sequencial = ($this->o202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_sequencial"]:$this->o202_sequencial);
       $this->o202_unidade = ($this->o202_unidade == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_unidade"]:$this->o202_unidade);
       $this->o202_orgao = ($this->o202_orgao == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_orgao"]:$this->o202_orgao);
       $this->o202_anousu = ($this->o202_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_anousu"]:$this->o202_anousu);
       $this->o202_elemento = ($this->o202_elemento == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_elemento"]:$this->o202_elemento);
       $this->o202_janeiro = ($this->o202_janeiro == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_janeiro"]:$this->o202_janeiro);
       $this->o202_fevereiro = ($this->o202_fevereiro == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_fevereiro"]:$this->o202_fevereiro);
       $this->o202_marco = ($this->o202_marco == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_marco"]:$this->o202_marco);
       $this->o202_abril = ($this->o202_abril == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_abril"]:$this->o202_abril);
       $this->o202_maio = ($this->o202_maio == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_maio"]:$this->o202_maio);
       $this->o202_junho = ($this->o202_junho == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_junho"]:$this->o202_junho);
       $this->o202_julho = ($this->o202_julho == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_julho"]:$this->o202_julho);
       $this->o202_agosto = ($this->o202_agosto == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_agosto"]:$this->o202_agosto);
       $this->o202_setembro = ($this->o202_setembro == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_setembro"]:$this->o202_setembro);
       $this->o202_outubro = ($this->o202_outubro == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_outubro"]:$this->o202_outubro);
       $this->o202_novembro = ($this->o202_novembro == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_novembro"]:$this->o202_novembro);
       $this->o202_dezembro = ($this->o202_dezembro == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_dezembro"]:$this->o202_dezembro);
       $this->o202_instit = ($this->o202_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_instit"]:$this->o202_instit);
     } else {
       $this->o202_sequencial = ($this->o202_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["o202_sequencial"]:$this->o202_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($o202_sequencial) {
      $this->atualizacampos();
     if ($this->o202_unidade == null ) {
       $this->erro_sql = " Campo Unidade não informado.";
       $this->erro_campo = "o202_unidade";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_orgao == null ) {
       $this->erro_sql = " Campo Orgão não informado.";
       $this->erro_campo = "o202_orgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_anousu == null ) {
       $this->erro_sql = " Campo Ano não informado.";
       $this->erro_campo = "o202_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_elemento == null ) {
       $this->erro_sql = " Campo Elemento não informado.";
       $this->erro_campo = "o202_elemento";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_janeiro == null ) {
       $this->erro_sql = " Campo Janeiro não informado.";
       $this->erro_campo = "o202_janeiro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_fevereiro == null ) {
       $this->erro_sql = " Campo Fevereiro não informado.";
       $this->erro_campo = "o202_fevereiro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_marco == null ) {
       $this->erro_sql = " Campo Março não informado.";
       $this->erro_campo = "o202_marco";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_abril == null ) {
       $this->erro_sql = " Campo Abril não informado.";
       $this->erro_campo = "o202_abril";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_maio == null ) {
       $this->erro_sql = " Campo Maio não informado.";
       $this->erro_campo = "o202_maio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_junho == null ) {
       $this->erro_sql = " Campo Junho não informado.";
       $this->erro_campo = "o202_junho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_julho == null ) {
       $this->erro_sql = " Campo Julho não informado.";
       $this->erro_campo = "o202_julho";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_agosto == null ) {
       $this->erro_sql = " Campo Agosto não informado.";
       $this->erro_campo = "o202_agosto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_setembro == null ) {
       $this->erro_sql = " Campo Setembro não informado.";
       $this->erro_campo = "o202_setembro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_outubro == null ) {
       $this->erro_sql = " Campo Outubro não informado.";
       $this->erro_campo = "o202_outubro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_novembro == null ) {
       $this->erro_sql = " Campo Novembro não informado.";
       $this->erro_campo = "o202_novembro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_dezembro == null ) {
       $this->erro_sql = " Campo Dezembro não informado.";
       $this->erro_campo = "o202_dezembro";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->o202_instit == null ) {
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "o202_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($o202_sequencial == "" || $o202_sequencial == null ) {
       $result = db_query("select nextval('cronogramamesdesembolso_o202_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: cronogramamesdesembolso_o202_sequencial_seq do campo: o202_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->o202_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from cronogramamesdesembolso_o202_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $o202_sequencial)) {
         $this->erro_sql = " Campo o202_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->o202_sequencial = $o202_sequencial;
       }
     }
     if (($this->o202_sequencial == null) || ($this->o202_sequencial == "") ) {
       $this->erro_sql = " Campo o202_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into cronogramamesdesembolso(
                                       o202_sequencial
                                      ,o202_unidade
                                      ,o202_orgao
                                      ,o202_anousu
                                      ,o202_elemento
                                      ,o202_janeiro
                                      ,o202_fevereiro
                                      ,o202_marco
                                      ,o202_abril
                                      ,o202_maio
                                      ,o202_junho
                                      ,o202_julho
                                      ,o202_agosto
                                      ,o202_setembro
                                      ,o202_outubro
                                      ,o202_novembro
                                      ,o202_dezembro
                                      ,o202_instit
                       )
                values (
                                $this->o202_sequencial
                               ,$this->o202_unidade
                               ,$this->o202_orgao
                               ,$this->o202_anousu
                               ,$this->o202_elemento
                               ,$this->o202_janeiro
                               ,$this->o202_fevereiro
                               ,$this->o202_marco
                               ,$this->o202_abril
                               ,$this->o202_maio
                               ,$this->o202_junho
                               ,$this->o202_julho
                               ,$this->o202_agosto
                               ,$this->o202_setembro
                               ,$this->o202_outubro
                               ,$this->o202_novembro
                               ,$this->o202_dezembro
                               ,$this->o202_instit
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Cronograma Mensal de Desembolso ($this->o202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Cronograma Mensal de Desembolso já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Cronograma Mensal de Desembolso ($this->o202_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o202_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
/*     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->o202_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009301,'$this->o202_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010202,1009301,'','".AddSlashes(pg_result($resaco,0,'o202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009302,'','".AddSlashes(pg_result($resaco,0,'o202_unidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009303,'','".AddSlashes(pg_result($resaco,0,'o202_orgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009304,'','".AddSlashes(pg_result($resaco,0,'o202_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009305,'','".AddSlashes(pg_result($resaco,0,'o202_janeiro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009306,'','".AddSlashes(pg_result($resaco,0,'o202_fevereiro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009307,'','".AddSlashes(pg_result($resaco,0,'o202_marco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009308,'','".AddSlashes(pg_result($resaco,0,'o202_abril'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009309,'','".AddSlashes(pg_result($resaco,0,'o202_maio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009310,'','".AddSlashes(pg_result($resaco,0,'o202_junho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009311,'','".AddSlashes(pg_result($resaco,0,'o202_julho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009312,'','".AddSlashes(pg_result($resaco,0,'o202_agosto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009313,'','".AddSlashes(pg_result($resaco,0,'o202_setembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009314,'','".AddSlashes(pg_result($resaco,0,'o202_outubro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009315,'','".AddSlashes(pg_result($resaco,0,'o202_novembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009316,'','".AddSlashes(pg_result($resaco,0,'o202_dezembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010202,1009317,'','".AddSlashes(pg_result($resaco,0,'o202_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($o202_sequencial=null) {
      $this->atualizacampos();
     $sql = " update cronogramamesdesembolso set ";
     $virgula = "";
     if (trim($this->o202_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_sequencial"])) {
       $sql  .= $virgula." o202_sequencial = $this->o202_sequencial ";
       $virgula = ",";
       if (trim($this->o202_sequencial) == null ) {
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "o202_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_unidade)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_unidade"])) {
       $sql  .= $virgula." o202_unidade = $this->o202_unidade ";
       $virgula = ",";
       if (trim($this->o202_unidade) == null ) {
         $this->erro_sql = " Campo Unidade não informado.";
         $this->erro_campo = "o202_unidade";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_orgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_orgao"])) {
       $sql  .= $virgula." o202_orgao = $this->o202_orgao ";
       $virgula = ",";
       if (trim($this->o202_orgao) == null ) {
         $this->erro_sql = " Campo Orgão não informado.";
         $this->erro_campo = "o202_orgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_anousu"])) {
       $sql  .= $virgula." o202_anousu = $this->o202_anousu ";
       $virgula = ",";
       if (trim($this->o202_anousu) == null ) {
         $this->erro_sql = " Campo Ano não informado.";
         $this->erro_campo = "o202_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_elemento)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_elemento"])) {
       $sql  .= $virgula." o202_elemento = $this->o202_elemento ";
       $virgula = ",";
       if (trim($this->o202_elemento) == null ) {
         $this->erro_sql = " Campo Elemento não informado.";
         $this->erro_campo = "o202_elemento";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_janeiro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_janeiro"])) {
       $sql  .= $virgula." o202_janeiro = $this->o202_janeiro ";
       $virgula = ",";
       if (trim($this->o202_janeiro) == null ) {
         $this->erro_sql = " Campo Janeiro não informado.";
         $this->erro_campo = "o202_janeiro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_fevereiro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_fevereiro"])) {
       $sql  .= $virgula." o202_fevereiro = $this->o202_fevereiro ";
       $virgula = ",";
       if (trim($this->o202_fevereiro) == null ) {
         $this->erro_sql = " Campo Fevereiro não informado.";
         $this->erro_campo = "o202_fevereiro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_marco)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_marco"])) {
       $sql  .= $virgula." o202_marco = $this->o202_marco ";
       $virgula = ",";
       if (trim($this->o202_marco) == null ) {
         $this->erro_sql = " Campo Março não informado.";
         $this->erro_campo = "o202_marco";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_abril)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_abril"])) {
       $sql  .= $virgula." o202_abril = $this->o202_abril ";
       $virgula = ",";
       if (trim($this->o202_abril) == null ) {
         $this->erro_sql = " Campo Abril não informado.";
         $this->erro_campo = "o202_abril";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_maio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_maio"])) {
       $sql  .= $virgula." o202_maio = $this->o202_maio ";
       $virgula = ",";
       if (trim($this->o202_maio) == null ) {
         $this->erro_sql = " Campo Maio não informado.";
         $this->erro_campo = "o202_maio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_junho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_junho"])) {
       $sql  .= $virgula." o202_junho = $this->o202_junho ";
       $virgula = ",";
       if (trim($this->o202_junho) == null ) {
         $this->erro_sql = " Campo Junho não informado.";
         $this->erro_campo = "o202_junho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_julho)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_julho"])) {
       $sql  .= $virgula." o202_julho = $this->o202_julho ";
       $virgula = ",";
       if (trim($this->o202_julho) == null ) {
         $this->erro_sql = " Campo Julho não informado.";
         $this->erro_campo = "o202_julho";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_agosto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_agosto"])) {
       $sql  .= $virgula." o202_agosto = $this->o202_agosto ";
       $virgula = ",";
       if (trim($this->o202_agosto) == null ) {
         $this->erro_sql = " Campo Agosto não informado.";
         $this->erro_campo = "o202_agosto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_setembro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_setembro"])) {
       $sql  .= $virgula." o202_setembro = $this->o202_setembro ";
       $virgula = ",";
       if (trim($this->o202_setembro) == null ) {
         $this->erro_sql = " Campo Setembro não informado.";
         $this->erro_campo = "o202_setembro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_outubro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_outubro"])) {
       $sql  .= $virgula." o202_outubro = $this->o202_outubro ";
       $virgula = ",";
       if (trim($this->o202_outubro) == null ) {
         $this->erro_sql = " Campo Outubro não informado.";
         $this->erro_campo = "o202_outubro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_novembro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_novembro"])) {
       $sql  .= $virgula." o202_novembro = $this->o202_novembro ";
       $virgula = ",";
       if (trim($this->o202_novembro) == null ) {
         $this->erro_sql = " Campo Novembro não informado.";
         $this->erro_campo = "o202_novembro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_dezembro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_dezembro"])) {
       $sql  .= $virgula." o202_dezembro = $this->o202_dezembro ";
       $virgula = ",";
       if (trim($this->o202_dezembro) == null ) {
         $this->erro_sql = " Campo Dezembro não informado.";
         $this->erro_campo = "o202_dezembro";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->o202_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["o202_instit"])) {
       $sql  .= $virgula." o202_instit = $this->o202_instit ";
       $virgula = ",";
       if (trim($this->o202_instit) == null ) {
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "o202_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($o202_sequencial!=null) {
       $sql .= " o202_sequencial = $this->o202_sequencial";
     }
/*     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->o202_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009301,'$this->o202_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_sequencial"]) || $this->o202_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009301,'".AddSlashes(pg_result($resaco,$conresaco,'o202_sequencial'))."','$this->o202_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_unidade"]) || $this->o202_unidade != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009302,'".AddSlashes(pg_result($resaco,$conresaco,'o202_unidade'))."','$this->o202_unidade',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_orgao"]) || $this->o202_orgao != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009303,'".AddSlashes(pg_result($resaco,$conresaco,'o202_orgao'))."','$this->o202_orgao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_anousu"]) || $this->o202_anousu != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009304,'".AddSlashes(pg_result($resaco,$conresaco,'o202_anousu'))."','$this->o202_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_janeiro"]) || $this->o202_janeiro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009305,'".AddSlashes(pg_result($resaco,$conresaco,'o202_janeiro'))."','$this->o202_janeiro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_fevereiro"]) || $this->o202_fevereiro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009306,'".AddSlashes(pg_result($resaco,$conresaco,'o202_fevereiro'))."','$this->o202_fevereiro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_marco"]) || $this->o202_marco != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009307,'".AddSlashes(pg_result($resaco,$conresaco,'o202_marco'))."','$this->o202_marco',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_abril"]) || $this->o202_abril != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009308,'".AddSlashes(pg_result($resaco,$conresaco,'o202_abril'))."','$this->o202_abril',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_maio"]) || $this->o202_maio != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009309,'".AddSlashes(pg_result($resaco,$conresaco,'o202_maio'))."','$this->o202_maio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_junho"]) || $this->o202_junho != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009310,'".AddSlashes(pg_result($resaco,$conresaco,'o202_junho'))."','$this->o202_junho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_julho"]) || $this->o202_julho != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009311,'".AddSlashes(pg_result($resaco,$conresaco,'o202_julho'))."','$this->o202_julho',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_agosto"]) || $this->o202_agosto != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009312,'".AddSlashes(pg_result($resaco,$conresaco,'o202_agosto'))."','$this->o202_agosto',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_setembro"]) || $this->o202_setembro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009313,'".AddSlashes(pg_result($resaco,$conresaco,'o202_setembro'))."','$this->o202_setembro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_outubro"]) || $this->o202_outubro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009314,'".AddSlashes(pg_result($resaco,$conresaco,'o202_outubro'))."','$this->o202_outubro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_novembro"]) || $this->o202_novembro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009315,'".AddSlashes(pg_result($resaco,$conresaco,'o202_novembro'))."','$this->o202_novembro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_dezembro"]) || $this->o202_dezembro != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009316,'".AddSlashes(pg_result($resaco,$conresaco,'o202_dezembro'))."','$this->o202_dezembro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["o202_instit"]) || $this->o202_instit != "")
             $resac = db_query("insert into db_acount values($acount,1010202,1009317,'".AddSlashes(pg_result($resaco,$conresaco,'o202_instit'))."','$this->o202_instit',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cronograma Mensal de Desembolso nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->o202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cronograma Mensal de Desembolso nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->o202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->o202_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($o202_sequencial=null,$dbwhere=null) {
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);

     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {
         $resaco = $this->sql_record($this->sql_query_file($o202_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));

       }
    //    if (($resaco != false) || ($this->numrows!=0)) {
    //      for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

    //        $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
    //        $acount = pg_result($resac,0,0);
    //        $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
    //        $resac  = db_query("insert into db_acountkey values($acount,1009301,'$o202_sequencial','E')");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009301,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009302,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_unidade'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009303,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_orgao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009304,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009305,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_janeiro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009306,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_fevereiro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009307,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_marco'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009308,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_abril'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009309,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_maio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009310,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_junho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009311,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_julho'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009312,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_agosto'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009313,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_setembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009314,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_outubro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009315,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_novembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009316,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_dezembro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //        $resac  = db_query("insert into db_acount values($acount,1010202,1009317,'','".AddSlashes(pg_result($resaco,$iresaco,'o202_instit'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
    //      }
    //    }
     }

     $sql = " delete from cronogramamesdesembolso
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($o202_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " o202_sequencial = $o202_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Cronograma Mensal de Desembolso nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$o202_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Cronograma Mensal de Desembolso nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$o202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$o202_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = pg_affected_rows($result);
         return true;
      }
    }
    die('aqui');
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
        $this->erro_sql   = "Record Vazio na Tabela:cronogramamesdesembolso";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $o202_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from cronogramamesdesembolso ";
     $sql .= "      inner join orcorgao  on  orcorgao.o40_anousu = cronogramamesdesembolso.o202_anousu and  orcorgao.o40_orgao = cronogramamesdesembolso.o202_orgao";
     $sql .= "      inner join orcunidade  on  orcunidade.o41_anousu = cronogramamesdesembolso.o202_anousu and  orcunidade.o41_orgao = cronogramamesdesembolso.o202_orgao and  orcunidade.o41_unidade = cronogramamesdesembolso.o202_unidade";
     $sql .= "      inner join db_config  on  db_config.codigo = orcorgao.o40_instit";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($o202_sequencial!=null ) {
         $sql2 .= " where cronogramamesdesembolso.o202_sequencial = $o202_sequencial ";
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
  function sql_query_file ( $o202_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from cronogramamesdesembolso ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($o202_sequencial!=null ) {
         $sql2 .= " where cronogramamesdesembolso.o202_sequencial = $o202_sequencial ";
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

  public function getSomaValores() {
    return ($this->o202_janeiro+$this->o202_fevereiro+$this->o202_marco+$this->o202_abril+$this->o202_maio+$this->o202_junho+$this->o202_julho+$this->o202_agosto+$this->o202_setembro+$this->o202_outubro+$this->o202_novembro+$this->o202_dezembro);
  }

  public function verificaResult($iInstit, $iAnousu, $iOrgao, $iUnidade) {
    $sWhere = "o202_instit = {$iInstit} and o202_anousu = {$iAnousu} and o202_orgao = {$iOrgao} and o202_unidade = $iUnidade";
    $sSql = $this->sql_query_file(null,"*",null,$sWhere);
    $rsResult = db_query($sSql);
    if (pg_num_rows($rsResult) > 0) {
      return true;
    }
    return false;
  }

  public function getValores($iInstit, $iAnousu, $iOrgao, $iUnidade, $sNivel) {
    $sCampos  = " o202_janeiro as o202_janeiro{$sNivel}, o202_fevereiro as o202_fevereiro{$sNivel}, ";
    $sCampos .= " o202_marco as o202_marco{$sNivel}, o202_abril as o202_abril{$sNivel}, o202_maio as o202_maio{$sNivel}, ";
    $sCampos .= " o202_junho as o202_junho{$sNivel}, o202_julho as o202_julho{$sNivel}, o202_agosto as o202_agosto{$sNivel}, ";
    $sCampos .= " o202_setembro as o202_setembro{$sNivel}, o202_outubro as o202_outubro{$sNivel}, ";
    $sCampos .= " o202_novembro as o202_novembro{$sNivel}, o202_dezembro as o202_dezembro{$sNivel}, ";
    $sCampos .= " (o202_janeiro+o202_fevereiro+o202_marco+o202_abril+o202_maio+o202_junho+o202_julho+o202_agosto+
        o202_setembro+o202_outubro+o202_novembro+o202_dezembro) as totalProgramado{$sNivel} ";

    $sWhere  = "o202_instit = {$iInstit} and o202_anousu = {$iAnousu} and o202_orgao = {$iOrgao} and o202_unidade = $iUnidade";
    $sWhere .= " and o202_elemento = '".str_pad($sNivel, 13, "0", STR_PAD_RIGHT)."'";
    $sSql = $this->sql_query_file(null,$sCampos,null,$sWhere);
    return db_query($sSql);
  }


  public function removeCronograma($iInstit, $iAnousu, $iOrgao, $iUnidade) {
    $sWhere = "o202_instit = {$iInstit} and o202_anousu = {$iAnousu} and o202_orgao = {$iOrgao} and o202_unidade = $iUnidade";
    $this->excluir(null,$sWhere);
  }

}
?>
