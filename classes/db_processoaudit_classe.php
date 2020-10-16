<?php
//MODULO: Controle Interno
//CLASSE DA ENTIDADE processoaudit
class cl_processoaudit { 
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
  public $ci03_codproc = 0; 
  public $ci03_numproc = 0; 
  public $ci03_anoproc = 0; 
  public $ci03_grupoaudit = 0; 
  public $ci03_objaudit = null; 
  public $ci03_dataini_dia = null; 
  public $ci03_dataini_mes = null; 
  public $ci03_dataini_ano = null; 
  public $ci03_dataini = null; 
  public $ci03_datafim_dia = null; 
  public $ci03_datafim_mes = null; 
  public $ci03_datafim_ano = null; 
  public $ci03_datafim = null; 
  public $ci03_codtipoquest = 0; 
  public $ci03_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 ci03_codproc = int4 = Código 
                 ci03_numproc = int4 = Número do Processo 
                 ci03_anoproc = int4 = Ano do Processo 
                 ci03_grupoaudit = int4 = Grupo de Auditoria 
                 ci03_objaudit = varchar(500) = Objetivo da Auditoria 
                 ci03_dataini = date = Data Inicial 
                 ci03_datafim = date = Data Final 
                 ci03_codtipoquest = int4 = Tipo de Auditoria 
                 ci03_instit = int4 = Instituição 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("processoaudit"); 
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
       $this->ci03_codproc = ($this->ci03_codproc == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_codproc"]:$this->ci03_codproc);
       $this->ci03_numproc = ($this->ci03_numproc == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_numproc"]:$this->ci03_numproc);
       $this->ci03_anoproc = ($this->ci03_anoproc == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_anoproc"]:$this->ci03_anoproc);
       $this->ci03_grupoaudit = ($this->ci03_grupoaudit == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_grupoaudit"]:$this->ci03_grupoaudit);
       $this->ci03_objaudit = ($this->ci03_objaudit == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_objaudit"]:$this->ci03_objaudit);
       if ($this->ci03_dataini == "") {
         $this->ci03_dataini_dia = ($this->ci03_dataini_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_dataini_dia"]:$this->ci03_dataini_dia);
         $this->ci03_dataini_mes = ($this->ci03_dataini_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_dataini_mes"]:$this->ci03_dataini_mes);
         $this->ci03_dataini_ano = ($this->ci03_dataini_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_dataini_ano"]:$this->ci03_dataini_ano);
         if ($this->ci03_dataini_dia != "") {
            $this->ci03_dataini = $this->ci03_dataini_ano."-".$this->ci03_dataini_mes."-".$this->ci03_dataini_dia;
         }
       }
       if ($this->ci03_datafim == "") {
         $this->ci03_datafim_dia = ($this->ci03_datafim_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_datafim_dia"]:$this->ci03_datafim_dia);
         $this->ci03_datafim_mes = ($this->ci03_datafim_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_datafim_mes"]:$this->ci03_datafim_mes);
         $this->ci03_datafim_ano = ($this->ci03_datafim_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_datafim_ano"]:$this->ci03_datafim_ano);
         if ($this->ci03_datafim_dia != "") {
            $this->ci03_datafim = $this->ci03_datafim_ano."-".$this->ci03_datafim_mes."-".$this->ci03_datafim_dia;
         }
       }
       $this->ci03_codtipoquest = ($this->ci03_codtipoquest == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_codtipoquest"]:$this->ci03_codtipoquest);
       $this->ci03_instit = ($this->ci03_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["ci03_instit"]:$this->ci03_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir ($ci03_codproc) { 
      $this->atualizacampos();
      if($ci03_codproc == null || $ci03_codproc == ""){ 
        $result = db_query("select nextval('contint_ci03_codproc_seq')");
        if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: contint_ci03_codproc_seq do campo: ci03_codproc"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->ci03_codproc = pg_result($result,0,0); 
      }else{
       $result = db_query("select last_value from contint_ci03_codproc_seq");
       if(($result != false) && (pg_result($result,0,0) < $ci03_codproc)){
         $this->erro_sql = " Campo ci03_codproc maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->ci03_codproc = $ci03_codproc; 
       }
     }
     if ($this->ci03_numproc == null ) { 
       $this->erro_sql = " Campo Número do Processo não informado.";
       $this->erro_campo = "ci03_numproc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci03_dataini == null ) { 
      $this->erro_sql = " Campo Data Inicial não informado.";
      $this->erro_campo = "ci03_dataini_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     if ($this->ci03_anoproc == null ) { 
       $this->erro_sql = " Campo Ano do Processo não informado.";
       $this->erro_campo = "ci03_anoproc";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci03_datafim == null ) { 
      $this->erro_sql = " Campo Data Final não informado.";
      $this->erro_campo = "ci03_datafim_dia";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     if ($this->ci03_grupoaudit == null ) { 
       $this->erro_sql = " Campo Grupo de Auditoria não informado.";
       $this->erro_campo = "ci03_grupoaudit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci03_objaudit == null ) { 
       $this->erro_sql = " Campo Objetivo da Auditoria não informado.";
       $this->erro_campo = "ci03_objaudit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->ci03_instit == null ) { 
       $this->erro_sql = " Campo Instituição não informado.";
       $this->erro_campo = "ci03_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into processoaudit(
                                       ci03_codproc 
                                      ,ci03_numproc 
                                      ,ci03_anoproc 
                                      ,ci03_grupoaudit 
                                      ,ci03_objaudit 
                                      ,ci03_dataini 
                                      ,ci03_datafim 
                                      ,ci03_codtipoquest 
                                      ,ci03_instit 
                       )
                values (
                                $this->ci03_codproc 
                               ,$this->ci03_numproc 
                               ,$this->ci03_anoproc 
                               ,$this->ci03_grupoaudit 
                               ,'$this->ci03_objaudit' 
                               ,".($this->ci03_dataini == "null" || $this->ci03_dataini == ""?"null":"'".$this->ci03_dataini."'")." 
                               ,".($this->ci03_datafim == "null" || $this->ci03_datafim == ""?"null":"'".$this->ci03_datafim."'")." 
                               ,null 
                               ,$this->ci03_instit 
                      )";

     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Processo de Auditoria () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Processo de Auditoria já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Processo de Auditoria () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $ci03_codproc=null ) { 
      $this->atualizacampos();
     $sql = " update processoaudit set ";
     $virgula = "";
     if (trim($this->ci03_codproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_codproc"])) { 
       $sql  .= $virgula." ci03_codproc = $this->ci03_codproc ";
       $virgula = ",";
       if (trim($this->ci03_codproc) == null ) { 
         $this->erro_sql = " Campo Código não informado.";
         $this->erro_campo = "ci03_codproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci03_numproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_numproc"])) { 
       $sql  .= $virgula." ci03_numproc = $this->ci03_numproc ";
       $virgula = ",";
       if (trim($this->ci03_numproc) == null ) { 
         $this->erro_sql = " Campo Número do Processo não informado.";
         $this->erro_campo = "ci03_numproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci03_dataini)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_dataini_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ci03_dataini_dia"] !="") ) { 
      $sql  .= $virgula." ci03_dataini = '$this->ci03_dataini' ";
      $virgula = ",";
      if (trim($this->ci03_dataini) == null ) { 
        $this->erro_sql = " Campo Data Inicial não informado.";
        $this->erro_campo = "ci03_dataini_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{ 
      if (isset($GLOBALS["HTTP_POST_VARS"]["ci03_dataini_dia"])) { 
        $sql  .= $virgula." ci03_dataini = null ";
        $virgula = ",";
        if (trim($this->ci03_dataini) == null ) { 
          $this->erro_sql = " Campo Data Inicial não informado.";
          $this->erro_campo = "ci03_dataini_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
     if (trim($this->ci03_anoproc)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_anoproc"])) { 
       $sql  .= $virgula." ci03_anoproc = $this->ci03_anoproc ";
       $virgula = ",";
       if (trim($this->ci03_anoproc) == null ) { 
         $this->erro_sql = " Campo Ano do Processo não informado.";
         $this->erro_campo = "ci03_anoproc";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci03_datafim)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_datafim_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["ci03_datafim_dia"] !="") ) { 
      $sql  .= $virgula." ci03_datafim = '$this->ci03_datafim' ";
      $virgula = ",";
      if (trim($this->ci03_datafim) == null ) { 
        $this->erro_sql = " Campo Data Final não informado.";
        $this->erro_campo = "ci03_datafim_dia";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }     else{ 
      if (isset($GLOBALS["HTTP_POST_VARS"]["ci03_datafim_dia"])) { 
        $sql  .= $virgula." ci03_datafim = null ";
        $virgula = ",";
        if (trim($this->ci03_datafim) == null ) { 
          $this->erro_sql = " Campo Data Final não informado.";
          $this->erro_campo = "ci03_datafim_dia";
          $this->erro_banco = "";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
      }
    }
     if (trim($this->ci03_grupoaudit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_grupoaudit"])) { 
       $sql  .= $virgula." ci03_grupoaudit = $this->ci03_grupoaudit ";
       $virgula = ",";
       if (trim($this->ci03_grupoaudit) == null ) { 
         $this->erro_sql = " Campo Grupo de Auditoria não informado.";
         $this->erro_campo = "ci03_grupoaudit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci03_objaudit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_objaudit"])) { 
       $sql  .= $virgula." ci03_objaudit = '$this->ci03_objaudit' ";
       $virgula = ",";
       if (trim($this->ci03_objaudit) == null ) { 
         $this->erro_sql = " Campo Objetivo da Auditoria não informado.";
         $this->erro_campo = "ci03_objaudit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->ci03_codtipoquest)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_codtipoquest"])) { 
        if (trim($this->ci03_codtipoquest)=="" && isset($GLOBALS["HTTP_POST_VARS"]["ci03_codtipoquest"])) { 
           $this->ci03_codtipoquest = "0" ; 
        } 
       $sql  .= $virgula." ci03_codtipoquest = $this->ci03_codtipoquest ";
       $virgula = ",";
     }
     if (trim($this->ci03_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["ci03_instit"])) { 
       $sql  .= $virgula." ci03_instit = $this->ci03_instit ";
       $virgula = ",";
       if (trim($this->ci03_instit) == null ) { 
         $this->erro_sql = " Campo Instituição não informado.";
         $this->erro_campo = "ci03_instit";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     $sql .= "ci03_codproc = '$ci03_codproc'";     
     
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Processo de Auditoria nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Processo de Auditoria nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $ci03_codproc=null ,$dbwhere=null) { 

     $sql = " delete from processoaudit
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "ci03_codproc = '$ci03_codproc'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Processo de Auditoria nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Processo de Auditoria nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:processoaudit";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $ci03_codproc = null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from processoaudit ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $ci03_codproc != "" && $ci03_codproc != null) {
          $sql2 = " where processoaudit.ci03_codproc = '$ci03_codproc'";
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
  function sql_query_file ( $ci03_codproc = null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from processoaudit ";
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
