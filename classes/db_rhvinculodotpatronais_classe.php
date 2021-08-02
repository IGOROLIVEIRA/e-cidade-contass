<?php
//MODULO: pessoal
//CLASSE DA ENTIDADE rhvinculodotpatronais
class cl_rhvinculodotpatronais { 
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
  public $rh171_sequencial = 0; 
  public $rh171_orgaoorig = 0; 
  public $rh171_orgaonov = 0; 
  public $rh171_unidadeorig = 0; 
  public $rh171_unidadenov = 0; 
  public $rh171_projativorig = 0; 
  public $rh171_projativnov = 0; 
  public $rh171_recursoorig = 0; 
  public $rh171_recursonov = 0; 
  public $rh171_mes = 0; 
  public $rh171_anousu = 0; 
  public $rh171_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh171_sequencial = int8 = Código Sequencial 
                 rh171_orgaoorig = int8 = Órgão 
                 rh171_orgaonov = int8 = Órgão 
                 rh171_unidadeorig = int8 = Unidade 
                 rh171_unidadenov = int8 = Unidade 
                 rh171_projativorig = int8 = Projetos/Atividades 
                 rh171_projativnov = int8 = Projetos/Atividades 
                 rh171_recursoorig = int8 = Recurso 
                 rh171_recursonov = int8 = Recurso 
                 rh171_mes = int8 = Mês 
                 rh171_anousu = int8 = Ano 
                 rh171_instit = int8 = Instituição 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("rhvinculodotpatronais"); 
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
       $this->rh171_sequencial = ($this->rh171_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_sequencial"]:$this->rh171_sequencial);
       $this->rh171_orgaoorig = ($this->rh171_orgaoorig == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_orgaoorig"]:$this->rh171_orgaoorig);
       $this->rh171_orgaonov = ($this->rh171_orgaonov == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_orgaonov"]:$this->rh171_orgaonov);
       $this->rh171_unidadeorig = ($this->rh171_unidadeorig == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_unidadeorig"]:$this->rh171_unidadeorig);
       $this->rh171_unidadenov = ($this->rh171_unidadenov == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_unidadenov"]:$this->rh171_unidadenov);
       $this->rh171_projativorig = ($this->rh171_projativorig == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_projativorig"]:$this->rh171_projativorig);
       $this->rh171_projativnov = ($this->rh171_projativnov == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_projativnov"]:$this->rh171_projativnov);
       $this->rh171_recursoorig = ($this->rh171_recursoorig == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_recursoorig"]:$this->rh171_recursoorig);
       $this->rh171_recursonov = ($this->rh171_recursonov == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_recursonov"]:$this->rh171_recursonov);
       $this->rh171_mes = ($this->rh171_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_mes"]:$this->rh171_mes);
       $this->rh171_anousu = ($this->rh171_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_anousu"]:$this->rh171_anousu);
       $this->rh171_instit = ($this->rh171_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["rh171_instit"]:$this->rh171_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () { 
      $this->atualizacampos();
     if ($this->rh171_orgaoorig == null ) { 
       $this->erro_sql = " Campo Órgão não informado.";
       $this->erro_campo = "rh171_orgaoorig";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_orgaonov == null ) { 
       $this->erro_sql = " Campo Órgão não informado.";
       $this->erro_campo = "rh171_orgaonov";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_unidadeorig == null ) { 
       $this->erro_sql = " Campo Unidade não informado.";
       $this->erro_campo = "rh171_unidadeorig";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_unidadenov == null ) { 
       $this->erro_sql = " Campo Unidade não informado.";
       $this->erro_campo = "rh171_unidadenov";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_projativorig == null ) { 
       $this->erro_sql = " Campo Projetos/Atividades não informado.";
       $this->erro_campo = "rh171_projativorig";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_projativnov == null ) { 
       $this->erro_sql = " Campo Projetos/Atividades não informado.";
       $this->erro_campo = "rh171_projativnov";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_recursoorig == null ) { 
       $this->erro_sql = " Campo Recurso não informado.";
       $this->erro_campo = "rh171_recursoorig";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_recursonov == null ) { 
       $this->erro_sql = " Campo Recurso não informado.";
       $this->erro_campo = "rh171_recursonov";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_mes == null ) { 
       $this->erro_sql = " Campo Mês não informado.";
       $this->erro_campo = "rh171_mes";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_anousu == null ) { 
       $this->erro_sql = " Campo Ano não informado.";
       $this->erro_campo = "rh171_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh171_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "rh171_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh171_sequencial == "" || $rh171_sequencial == null ) {
       $result = db_query("select nextval('rhvinculodotpatronais_rh171_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: rhvinculodotpatronais_rh171_sequencial_seq do campo: rh171_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh171_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from rhvinculodotpatronais_rh171_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh171_sequencial)) {
         $this->erro_sql = " Campo rh171_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh171_sequencial = $rh171_sequencial; 
       }
     }
     $sql = "insert into rhvinculodotpatronais(
                                       rh171_sequencial 
                                      ,rh171_orgaoorig 
                                      ,rh171_orgaonov 
                                      ,rh171_unidadeorig 
                                      ,rh171_unidadenov 
                                      ,rh171_projativorig 
                                      ,rh171_projativnov 
                                      ,rh171_recursoorig 
                                      ,rh171_recursonov 
                                      ,rh171_mes 
                                      ,rh171_anousu 
                                      ,rh171_instit 
                       )
                values (
                                $this->rh171_sequencial 
                               ,$this->rh171_orgaoorig 
                               ,$this->rh171_orgaonov 
                               ,$this->rh171_unidadeorig 
                               ,$this->rh171_unidadenov 
                               ,$this->rh171_projativorig 
                               ,$this->rh171_projativnov 
                               ,$this->rh171_recursoorig 
                               ,$this->rh171_recursonov 
                               ,$this->rh171_mes 
                               ,$this->rh171_anousu 
                               ,$this->rh171_instit 
                      )";

     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "De/Para Dotações Patronais () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "De/Para Dotações Patronais já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "De/Para Dotações Patronais () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $rh171_sequencial=null, $rh171_orgaoorig=null, $rh171_unidadeorig=null, $rh171_projativorig=null, $rh171_recursoorig=null,
                    $rh171_mes=null, $rh171_anousu=null, $rh171_instit=null ) { 
      $this->atualizacampos();

      $sql = " update rhvinculodotpatronais set ";
     $virgula = "";
     if ($rh171_sequencial != null && (trim($this->rh171_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_sequencial"]))) { 
       $sql  .= $virgula." rh171_sequencial = $this->rh171_sequencial ";
       $virgula = ",";
     }
     if (trim($this->rh171_orgaoorig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_orgaoorig"])) { 
       $sql  .= $virgula." rh171_orgaoorig = $this->rh171_orgaoorig ";
       $virgula = ",";
       if (trim($this->rh171_orgaoorig) == null ) { 
         $this->erro_sql = " Campo Órgão não informado.";
         $this->erro_campo = "rh171_orgaoorig";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_orgaonov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_orgaonov"])) { 
       $sql  .= $virgula." rh171_orgaonov = $this->rh171_orgaonov ";
       $virgula = ",";
       if (trim($this->rh171_orgaonov) == null ) { 
         $this->erro_sql = " Campo Órgão não informado.";
         $this->erro_campo = "rh171_orgaonov";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_unidadeorig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_unidadeorig"])) { 
       $sql  .= $virgula." rh171_unidadeorig = $this->rh171_unidadeorig ";
       $virgula = ",";
       if (trim($this->rh171_unidadeorig) == null ) { 
         $this->erro_sql = " Campo Unidade não informado.";
         $this->erro_campo = "rh171_unidadeorig";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_unidadenov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_unidadenov"])) { 
       $sql  .= $virgula." rh171_unidadenov = $this->rh171_unidadenov ";
       $virgula = ",";
       if (trim($this->rh171_unidadenov) == null ) { 
         $this->erro_sql = " Campo Unidade não informado.";
         $this->erro_campo = "rh171_unidadenov";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_projativorig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_projativorig"])) { 
       $sql  .= $virgula." rh171_projativorig = $this->rh171_projativorig ";
       $virgula = ",";
       if (trim($this->rh171_projativorig) == null ) { 
         $this->erro_sql = " Campo Projetos/Atividades não informado.";
         $this->erro_campo = "rh171_projativorig";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_projativnov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_projativnov"])) { 
       $sql  .= $virgula." rh171_projativnov = $this->rh171_projativnov ";
       $virgula = ",";
       if (trim($this->rh171_projativnov) == null ) { 
         $this->erro_sql = " Campo Projetos/Atividades não informado.";
         $this->erro_campo = "rh171_projativnov";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_recursoorig)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_recursoorig"])) { 
       $sql  .= $virgula." rh171_recursoorig = $this->rh171_recursoorig ";
       $virgula = ",";
       if (trim($this->rh171_recursoorig) == null ) { 
         $this->erro_sql = " Campo Recurso não informado.";
         $this->erro_campo = "rh171_recursoorig";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_recursonov)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_recursonov"])) { 
       $sql  .= $virgula." rh171_recursonov = $this->rh171_recursonov ";
       $virgula = ",";
       if (trim($this->rh171_recursonov) == null ) { 
         $this->erro_sql = " Campo Recurso não informado.";
         $this->erro_campo = "rh171_recursonov";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if ($rh171_mes != null) {
        $sql  .= $virgula." rh171_mes = $rh171_mes ";
     } else if (trim($this->rh171_mes)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_mes"])) { 
       $sql  .= $virgula." rh171_mes = $this->rh171_mes ";
       $virgula = ",";
       if (trim($this->rh171_mes) == null ) { 
         $this->erro_sql = " Campo Mês não informado.";
         $this->erro_campo = "rh171_mes";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_anousu"])) { 
       $sql  .= $virgula." rh171_anousu = $this->rh171_anousu ";
       $virgula = ",";
       if (trim($this->rh171_anousu) == null ) { 
         $this->erro_sql = " Campo Ano não informado.";
         $this->erro_campo = "rh171_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh171_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh171_instit"])) { 
       $sql  .= $virgula." rh171_instit = $this->rh171_instit ";
       $virgula = ",";
       if (trim($this->rh171_instit) == null ) { 
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "rh171_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";     

     if($rh171_sequencial!=null){
        $sql .= " rh171_sequencial = $this->rh171_sequencial";
     } else {
        if($rh171_orgaoorig!=null){
            $sql .= " rh171_orgaoorig = $this->rh171_orgaoorig";
        }
        if($rh171_unidadeorig!=null){
            $sql .= " and  rh171_unidadeorig = $this->rh171_unidadeorig";
        }
        if($rh171_projativorig!=null){
            $sql .= " and  rh171_projativorig = $this->rh171_projativorig";
        }
        if($rh171_recursoorig!=null){
            $sql .= " and  rh171_recursoorig = $this->rh171_recursoorig";
        }
        if($rh171_mes!=null){
            $sql .= " and  rh171_mes = $rh171_mes";
        }
        if($rh171_anousu!=null){
            $sql .= " and  rh171_anousu = $rh171_anousu";
        }
        if($rh171_instit!=null){
            $sql .= " and  rh171_instit = $rh171_instit";
        }
     }

    // echo $sql.'<br><br>';

     $result = db_query($sql);

     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "De/Para Dotações Patronais nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "De/Para Dotações Patronais nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $rh171_sequencial=null, $rh171_orgaoorig=null, $rh171_unidadeorig=null, $rh171_projativorig=null, $rh171_recursoorig=null,
                    $rh171_mes=null, $rh171_anousu=null, $rh171_instit=null ,$dbwhere=null) { 

     $sql = " delete from rhvinculodotpatronais
                    where ";
     $sql2 = "";
     if($rh171_sequencial != null || $rh171_sequencial != '') {
         $sql2 .= " rh171_sequencial = $rh171_sequencial ";
     } elseif($dbwhere==null || $dbwhere ==""){
        if($rh171_orgaoorig != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh171_orgaoorig = $rh171_orgaoorig ";
        }
        if($rh171_unidadeorig != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh171_unidadeorig = $rh171_unidadeorig ";
        }
        if($rh171_projativorig != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh171_projativorig = $rh171_projativorig ";
        }
        if($rh171_recursoorig != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh171_recursoorig = $rh171_recursoorig ";
        }
        if($rh171_mes != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh171_mes = $rh171_mes ";
        }
        if($rh171_anousu != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh171_anousu = $rh171_anousu ";
        }
        if($rh171_instit != ""){
          if($sql2!=""){
            $sql2 .= " and ";
          }
          $sql2 .= " rh171_instit = $rh171_instit ";
        }
     }else{
       $sql2 = $dbwhere;
     }
     
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "De/Para Dotações Patronais nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "De/Para Dotações Patronais nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:rhvinculodotpatronais";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh171_sequencial = null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhvinculodotpatronais ";
     $sql .= "      join orcorgao orgaoorig             on  orgaoorig.o40_orgao             = rh171_orgaoorig       ";
     $sql .= "                                          and orgaoorig.o40_anousu            = rh171_anousu          ";
     $sql .= "      join orcorgao orgaonov              on  orgaonov.o40_orgao              = rh171_orgaonov        ";
     $sql .= "                                          and orgaonov.o40_anousu             = rh171_anousu          ";
     $sql .= "      join orcunidade unidadeorig         on  unidadeorig.o41_unidade         = rh171_unidadeorig     ";
     $sql .= "                                          and unidadeorig.o41_anousu          = rh171_anousu          ";
     $sql .= "                                          and unidadeorig.o41_orgao           = orgaoorig.o40_orgao   ";
     $sql .= "      join orcunidade unidadenov          on  unidadenov.o41_unidade          = rh171_unidadenov      ";
     $sql .= "                                          and unidadenov.o41_anousu           = rh171_anousu          ";
     $sql .= "                                          and unidadenov.o41_orgao            = orgaonov.o40_orgao    ";
     $sql .= "      join orcprojativ orcprojativorig    on  orcprojativorig.o55_projativ    = rh171_projativorig    ";
     $sql .= "                                          and orcprojativorig.o55_anousu      = rh171_anousu          ";
     $sql .= "      join orcprojativ orcprojativnov     on  orcprojativnov.o55_projativ     = rh171_projativnov     ";
     $sql .= "                                          and orcprojativnov.o55_anousu       = rh171_anousu          ";
     $sql .= "      join orctiporec orctiporecorig      on  orctiporecorig.o15_codigo       = rh171_recursoorig     ";
     $sql .= "      join orctiporec orctiporecnov       on  orctiporecnov.o15_codigo        = rh171_recursonov      ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $rh171_sequencial != "" && $rh171_sequencial != null) {
          $sql2 = " where rhvinculodotpatronais.rh171_sequencial = $rh171_sequencial";
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
  function sql_query_file ( $rh171_sequencial = null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from rhvinculodotpatronais ";
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
