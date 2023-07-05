<?php
//MODULO: compras
//CLASSE DA ENTIDADE empordemtabela
class cl_empordemtabela { 
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
  public $l223_sequencial = 0; 
  public $l223_pcmaterordem = 0; 
  public $l223_pcmatertabela = 0; 
  public $l223_quant = 0; 
  public $l223_vlrn = 0; 
  public $l223_total = 0; 
  public $l223_numemp = 0; 
  public $l223_codordem = NULL;
  public $l223_descr = NULL;  
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 l223_sequencial = int8 = l223_sequencial 
                 l223_pcmaterordem = int8 = l223_pcmaterordem 
                 l223_pcmatertabela = int8 = l223_pcmatertabela 
                 l223_quant = float8 = l223_quant 
                 l223_vlrn = float8 = l223_vlrn 
                 l223_total = float8 = l223_total 
                 l223_numemp = int8 = l223_numemp 
                 l223_codordem = int8 = l223_codordem 
                 l223_descr = varchar = l223_descr
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("empordemtabela"); 
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
       $this->l223_sequencial = ($this->l223_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_sequencial"]:$this->l223_sequencial);
       $this->l223_pcmaterordem = ($this->l223_pcmaterordem == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_pcmaterordem"]:$this->l223_pcmaterordem);
       $this->l223_pcmatertabela = ($this->l223_pcmatertabela == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_pcmatertabela"]:$this->l223_pcmatertabela);
       $this->l223_quant = ($this->l223_quant == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_quant"]:$this->l223_quant);
       $this->l223_vlrn = ($this->l223_vlrn == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_vlrn"]:$this->l223_vlrn);
       $this->l223_total = ($this->l223_total == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_total"]:$this->l223_total);
       $this->l223_numemp = ($this->l223_numemp == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_numemp"]:$this->l223_numemp);
       $this->l223_codordem = ($this->l223_codordem == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_codordem"]:$this->l223_codordem);
       $this->l223_descr = ($this->l223_descr == ""?@$GLOBALS["HTTP_POST_VARS"]["l223_descr"]:$this->l223_descr);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () { 
      $this->atualizacampos();
     if($this->l223_sequencial == "" || $this->l223_sequencial == null ){
       $result = db_query("select nextval('empordemtabela_l223_sequencial_seq')"); 
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: empordemtabela_l223_sequencial_seq do campo: l223_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->l223_sequencial = pg_result($result,0,0); 
     }
     if ($this->l223_pcmaterordem == null ) { 
       $this->erro_sql = " Campo l223_pcmaterordem não informado.";
       $this->erro_campo = "l223_pcmaterordem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l223_pcmatertabela == null || $this->l223_pcmatertabela == "") { 
      $result = db_query("select count(l223_pcmatertabela)+1 as l223_pcmatertabela from empordemtabela where l223_pcmaterordem  = $this->l223_pcmaterordem and l223_numemp = $this->l223_numemp and l223_codordem = 0"); 
      if($result==false){
        $this->erro_banco = str_replace("\n","",@pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: empordemtabela_l223_sequencial_seq do campo: l223_sequencial"; 
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false; 
      }
      $this->l223_pcmatertabela = pg_result($result,0,0); 
     }
     if ($this->l223_quant == null ) { 
       $this->erro_sql = " Campo l223_quant não informado.";
       $this->erro_campo = "l223_quant";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l223_vlrn == null ) { 
       $this->erro_sql = " Campo l223_vlrn não informado.";
       $this->erro_campo = "l223_vlrn";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l223_total == null ) { 
       $this->erro_sql = " Campo l223_total não informado.";
       $this->erro_campo = "l223_total";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l223_numemp == null ) { 
       $this->erro_sql = " Campo l223_numemp não informado.";
       $this->erro_campo = "l223_numemp";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->l223_descr == null ) { 
      $this->erro_sql = " Campo l223_descr não informado.";
      $this->erro_campo = "l223_descr";
      $this->erro_banco = "";
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      return false;
    }
     if ($this->l223_codordem == null ) { 
       $this->l223_codordem = "0";
     }
     $sql = "insert into empordemtabela(
                                       l223_sequencial 
                                      ,l223_pcmaterordem 
                                      ,l223_pcmatertabela 
                                      ,l223_quant 
                                      ,l223_vlrn 
                                      ,l223_total 
                                      ,l223_numemp 
                                      ,l223_codordem 
                                      ,l223_descr 
                       )
                values (
                                $this->l223_sequencial 
                               ,$this->l223_pcmaterordem 
                               ,$this->l223_pcmatertabela 
                               ,$this->l223_quant 
                               ,$this->l223_vlrn 
                               ,$this->l223_total 
                               ,$this->l223_numemp 
                               ,$this->l223_codordem 
                               ,'$this->l223_descr'
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "empordemtabela () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "empordemtabela já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "empordemtabela () nao Incluído. Inclusao Abortada.";
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
  function alterar ( $l223_sequencial=null ) { 
      $this->atualizacampos();
     $sql = " update empordemtabela set ";
     $virgula = "";
     if (trim($this->l223_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_sequencial"])) { 
       $sql  .= $virgula." l223_sequencial = $this->l223_sequencial ";
       $virgula = ",";
       if (trim($this->l223_sequencial) == null ) { 
         $this->erro_sql = " Campo l223_sequencial não informado.";
         $this->erro_campo = "l223_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l223_pcmaterordem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_pcmaterordem"])) { 
       $sql  .= $virgula." l223_pcmaterordem = $this->l223_pcmaterordem ";
       $virgula = ",";
       if (trim($this->l223_pcmaterordem) == null ) { 
         $this->erro_sql = " Campo l223_pcmaterordem não informado.";
         $this->erro_campo = "l223_pcmaterordem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l223_pcmatertabela)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_pcmatertabela"])) { 
       $sql  .= $virgula." l223_pcmatertabela = $this->l223_pcmatertabela ";
       $virgula = ",";
       if (trim($this->l223_pcmatertabela) == null ) { 
         $this->erro_sql = " Campo l223_pcmatertabela não informado.";
         $this->erro_campo = "l223_pcmatertabela";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l223_quant)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_quant"])) { 
       $sql  .= $virgula." l223_quant = $this->l223_quant ";
       $virgula = ",";
       if (trim($this->l223_quant) == null ) { 
         $this->erro_sql = " Campo l223_quant não informado.";
         $this->erro_campo = "l223_quant";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l223_vlrn)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_vlrn"])) { 
       $sql  .= $virgula." l223_vlrn = $this->l223_vlrn ";
       $virgula = ",";
       if (trim($this->l223_vlrn) == null ) { 
         $this->erro_sql = " Campo l223_vlrn não informado.";
         $this->erro_campo = "l223_vlrn";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l223_total)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_total"])) { 
       $sql  .= $virgula." l223_total = $this->l223_total ";
       $virgula = ",";
       if (trim($this->l223_total) == null ) { 
         $this->erro_sql = " Campo l223_total não informado.";
         $this->erro_campo = "l223_total";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l223_numemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_numemp"])) { 
       $sql  .= $virgula." l223_numemp = $this->l223_numemp ";
       $virgula = ",";
       if (trim($this->l223_numemp) == null ) { 
         $this->erro_sql = " Campo l223_numemp não informado.";
         $this->erro_campo = "l223_numemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->l223_descr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_descr"])) { 
      $sql  .= $virgula." l223_descr = '$this->l223_descr' ";
      $virgula = ",";
      if (trim($this->l223_descr) == null ) { 
        $this->erro_sql = " Campo l223_descr não informado.";
        $this->erro_campo = "l223_descr";
        $this->erro_banco = "";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    }
     if (trim($this->l223_codordem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["l223_codordem"])) { 
        if (trim($this->l223_codordem)=="" && isset($GLOBALS["HTTP_POST_VARS"]["l223_codordem"])) { 
           $this->l223_codordem = "0" ; 
        } 
       $sql  .= $virgula." l223_codordem = $this->l223_codordem ";
       $virgula = ",";
     }
     $sql .= " where ";
$sql .= "l223_sequencial = '$l223_sequencial'";     
$result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "empordemtabela nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "empordemtabela nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $l223_sequencial=null ,$dbwhere=null) { 

     $sql = " delete from empordemtabela
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = "l223_sequencial = '$l223_sequencial'";
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "empordemtabela nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "empordemtabela nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:empordemtabela";
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
     $sql .= " from empordemtabela ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where empordemtabela.oid = '$oid'";
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
     $sql .= " from empordemtabela ";
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
