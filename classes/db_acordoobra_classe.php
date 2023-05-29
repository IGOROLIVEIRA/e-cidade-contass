<?php
//MODULO: acordos
//CLASSE DA ENTIDADE acordoobra
class cl_acordoobra { 
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
  public $obr08_sequencial = 0; 
  public $obr08_acordo = 0; 
  public $obr08_acordoitem = 0; 
  public $obr08_licobras = 0; 
  public $obr08_liclicitemlote = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 obr08_sequencial = int8 = obr08_sequencial 
                 obr08_acordo = int8 = obr08_acordo 
                 obr08_acordoitem = int8 = obr08_acordoitem 
                 obr08_licobras = int8 = obr08_licobras 
                 obr08_liclicitemlote = int8 = obr08_liclicitemlote 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("acordoobra"); 
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
       $this->obr08_sequencial = ($this->obr08_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["obr08_sequencial"]:$this->obr08_sequencial);
       $this->obr08_acordo = ($this->obr08_acordo == ""?@$GLOBALS["HTTP_POST_VARS"]["obr08_acordo"]:$this->obr08_acordo);
       $this->obr08_acordoitem = ($this->obr08_acordoitem == ""?@$GLOBALS["HTTP_POST_VARS"]["obr08_acordoitem"]:$this->obr08_acordoitem);
       $this->obr08_licobras = ($this->obr08_licobras == ""?@$GLOBALS["HTTP_POST_VARS"]["obr08_licobras"]:$this->obr08_licobras);
       $this->obr08_liclicitemlote = ($this->obr08_liclicitemlote == ""?@$GLOBALS["HTTP_POST_VARS"]["obr08_liclicitemlote"]:$this->obr08_liclicitemlote);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () { 
      $this->atualizacampos();
     if($this->obr08_sequencial == "" || $this->obr08_sequencial == null ){
       $result = db_query("select nextval('acordoobra_obr08_sequencial_seq')");
       if($result==false){
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: acordoobra_obr08_sequencial_seq do campo: obr08_sequencial";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->obr08_sequencial = pg_result($result,0,0);
     }else{
       $result = db_query("select last_value from acordoobra_obr08_sequencial_seq");
       if(($result != false) && (pg_result($result,0,0) < $this->obr08_sequencial)){
         $this->erro_sql = " Campo obr08_sequencial maior que ltimo nmero da sequencia.";
         $this->erro_banco = "Sequencia menor que este nmero.";
         $this->erro_msg   = "Usurio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }else{
         $this->obr08_sequencial = $this->obr08_sequencial;
       }
     }
     if ($this->obr08_acordo == null ) { 
       $this->erro_sql = " Campo obr08_acordo não informado.";
       $this->erro_campo = "obr08_acordo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr08_acordoitem == null ) { 
       $this->erro_sql = " Campo obr08_acordoitem não informado.";
       $this->erro_campo = "obr08_acordoitem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr08_licobras == null ) { 
       $this->erro_sql = " Campo obr08_licobras não informado.";
       $this->erro_campo = "obr08_licobras";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr08_liclicitemlote == null ) { 
       $this->erro_sql = " Campo obr08_liclicitemlote não informado.";
       $this->erro_campo = "obr08_liclicitemlote";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into acordoobra(
                                       obr08_sequencial 
                                      ,obr08_acordo 
                                      ,obr08_acordoitem 
                                      ,obr08_licobras 
                                      ,obr08_liclicitemlote 
                       )
                values (
                                $this->obr08_sequencial 
                               ,$this->obr08_acordo 
                               ,$this->obr08_acordoitem 
                               ,$this->obr08_licobras 
                               ,$this->obr08_liclicitemlote 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "acordoobra () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "acordoobra já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "acordoobra () nao Incluído. Inclusao Abortada.";
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
     $sql = " update acordoobra set ";
     $virgula = "";
     if (trim($this->obr08_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr08_sequencial"])) { 
       $sql  .= $virgula." obr08_sequencial = $this->obr08_sequencial ";
       $virgula = ",";
       if (trim($this->obr08_sequencial) == null ) { 
         $this->erro_sql = " Campo obr08_sequencial não informado.";
         $this->erro_campo = "obr08_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr08_acordo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr08_acordo"])) { 
       $sql  .= $virgula." obr08_acordo = $this->obr08_acordo ";
       $virgula = ",";
       if (trim($this->obr08_acordo) == null ) { 
         $this->erro_sql = " Campo obr08_acordo não informado.";
         $this->erro_campo = "obr08_acordo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr08_acordoitem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr08_acordoitem"])) { 
       $sql  .= $virgula." obr08_acordoitem = $this->obr08_acordoitem ";
       $virgula = ",";
       if (trim($this->obr08_acordoitem) == null ) { 
         $this->erro_sql = " Campo obr08_acordoitem não informado.";
         $this->erro_campo = "obr08_acordoitem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr08_licobras)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr08_licobras"])) { 
       $sql  .= $virgula." obr08_licobras = $this->obr08_licobras ";
       $virgula = ",";
       if (trim($this->obr08_licobras) == null ) { 
         $this->erro_sql = " Campo obr08_licobras não informado.";
         $this->erro_campo = "obr08_licobras";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr08_liclicitemlote)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr08_liclicitemlote"])) { 
       $sql  .= $virgula." obr08_liclicitemlote = $this->obr08_liclicitemlote ";
       $virgula = ",";
       if (trim($this->obr08_liclicitemlote) == null ) { 
         $this->erro_sql = " Campo obr08_liclicitemlote não informado.";
         $this->erro_campo = "obr08_liclicitemlote";
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
       $this->erro_sql   = "acordoobra nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "acordoobra nao foi Alterado. Alteracao Executada.\\n";
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

     $sql = " delete from acordoobra
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
       $this->erro_sql   = "acordoobra nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "acordoobra nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:acordoobra";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $obr08_sequencial = null,$campos="acordoobra.obr08_sequencial,*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from acordoobra ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $obr08_sequencial != "" && $obr08_sequencial != null) {
          $sql2 = " where acordoobra.obr08_sequencial = '$obr08_sequencial'";
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
     $sql .= " from acordoobra ";
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
