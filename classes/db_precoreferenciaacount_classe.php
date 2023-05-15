<?php
//MODULO: compras
//CLASSE DA ENTIDADE precoreferenciaacount
class cl_precoreferenciaacount { 
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
  public $si233_sequencial = null; 
  public $si233_precoreferencia = 0; 
  public $si233_acao = null; 
  public $si233_idusuario = 0; 
  public $si233_datahr = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 si233_sequencial = int8 = si233_sequencial 
                 si233_precoreferencia = int8 = si233_precoreferencia 
                 si233_acao = varchar(50) = si233_acao 
                 si233_idusuario = float8 = si233_idusuario 
                 si233_datahr = float8 = si233_datahr 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("precoreferenciaacount"); 
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
       $this->si233_sequencial = ($this->si233_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["si233_sequencial"]:$this->si233_sequencial);
       $this->si233_precoreferencia = ($this->si233_precoreferencia == ""?@$GLOBALS["HTTP_POST_VARS"]["si233_precoreferencia"]:$this->si233_precoreferencia);
       $this->si233_acao = ($this->si233_acao == ""?@$GLOBALS["HTTP_POST_VARS"]["si233_acao"]:$this->si233_acao);
       $this->si233_idusuario = ($this->si233_idusuario == ""?@$GLOBALS["HTTP_POST_VARS"]["si233_idusuario"]:$this->si233_idusuario);
       $this->si233_datahr = ($this->si233_datahr == ""?@$GLOBALS["HTTP_POST_VARS"]["si233_datahr"]:$this->si233_datahr);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () { 
      $this->atualizacampos();
     if ($this->si233_sequencial == "" || $this->si233_sequencial == null) {
      $result = db_query("select nextval('precoreferenciaacount_si233_sequencial_seq')");
      if ($result == false) {
        $this->erro_banco = str_replace("\n", "", @pg_last_error());
        $this->erro_sql   = "Verifique o cadastro da sequencia: precoreferenciaacount_si233_sequencial_seq do campo: si233_sequencial";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      }
      $this->si233_sequencial = pg_result($result, 0, 0);
    } else {
      $result = db_query("select last_value from precoreferenciaacount_si233_sequencial_seq");
      if (($result != false) && (pg_result($result, 0, 0) <$this->si233_sequencial)) {
        $this->erro_sql = " Campo si233_sequencial maior que último número da sequencia.";
        $this->erro_banco = "Sequencia menor que este número.";
        $this->erro_msg   = "Usuário: \\n\\n " . $this->erro_sql . " \\n\\n";
        $this->erro_msg   .=  str_replace('"', "", str_replace("'", "",  "Administrador: \\n\\n " . $this->erro_banco . " \\n"));
        $this->erro_status = "0";
        return false;
      } else {
        $this->si233_sequencial = pg_result($result, 0, 0);
      }
    }
     if ($this->si233_precoreferencia == null ) { 
       $this->si233_precoreferencia = "0";
     }
     if ($this->si233_acao == null ) { 
       $this->erro_sql = " Campo si233_acao não informado.";
       $this->erro_campo = "si233_acao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->si233_idusuario == null ) { 
       $this->si233_idusuario = "0";
     }
     if ($this->si233_datahr == null ) { 
       $this->si233_datahr = "0";
     }
     $sql = "insert into precoreferenciaacount(
                                       si233_sequencial 
                                      ,si233_precoreferencia 
                                      ,si233_acao 
                                      ,si233_idusuario 
                                      ,si233_datahr 
                       )
                values (
                                $this->si233_sequencial 
                               ,$this->si233_precoreferencia 
                               ,'$this->si233_acao' 
                               ,$this->si233_idusuario 
                               ,'$this->si233_datahr' 
                      )";
    

     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "precoreferenciaacount () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "precoreferenciaacount já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "precoreferenciaacount () nao Incluído. Inclusao Abortada.";
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
     $sql = " update precoreferenciaacount set ";
     $virgula = "";
     if (trim($this->si233_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si233_sequencial"])) { 
        if (trim($this->si233_sequencial)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si233_sequencial"])) { 
           $this->si233_sequencial = "0" ; 
        } 
       $sql  .= $virgula." si233_sequencial = $this->si233_sequencial ";
       $virgula = ",";
     }
     if (trim($this->si233_precoreferencia)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si233_precoreferencia"])) { 
        if (trim($this->si233_precoreferencia)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si233_precoreferencia"])) { 
           $this->si233_precoreferencia = "0" ; 
        } 
       $sql  .= $virgula." si233_precoreferencia = $this->si233_precoreferencia ";
       $virgula = ",";
     }
     if (trim($this->si233_acao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si233_acao"])) { 
       $sql  .= $virgula." si233_acao = '$this->si233_acao' ";
       $virgula = ",";
       if (trim($this->si233_acao) == null ) { 
         $this->erro_sql = " Campo si233_acao não informado.";
         $this->erro_campo = "si233_acao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->si233_idusuario)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si233_idusuario"])) { 
        if (trim($this->si233_idusuario)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si233_idusuario"])) { 
           $this->si233_idusuario = "0" ; 
        } 
       $sql  .= $virgula." si233_idusuario = $this->si233_idusuario ";
       $virgula = ",";
     }
     if (trim($this->si233_datahr)!="" || isset($GLOBALS["HTTP_POST_VARS"]["si233_datahr"])) { 
        if (trim($this->si233_datahr)=="" && isset($GLOBALS["HTTP_POST_VARS"]["si233_datahr"])) { 
           $this->si233_datahr = "0" ; 
        } 
       $sql  .= $virgula." si233_datahr = $this->si233_datahr ";
       $virgula = ",";
     }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "precoreferenciaacount nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "precoreferenciaacount nao foi Alterado. Alteracao Executada.\\n";
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

     $sql = " delete from precoreferenciaacount
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
       $this->erro_sql   = "precoreferenciaacount nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "precoreferenciaacount nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:precoreferenciaacount";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $oid = null,$campos="precoreferenciaacount.oid,*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from precoreferenciaacount ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where precoreferenciaacount.oid = '$oid'";
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
     $sql .= " from precoreferenciaacount ";
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
