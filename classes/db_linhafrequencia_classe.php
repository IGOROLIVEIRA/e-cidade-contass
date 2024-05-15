<?php
//MODULO: transporteescolar
//CLASSE DA ENTIDADE linhafrequencia
class cl_linhafrequencia { 
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
  public $tre13_sequencial = 0; 
  public $tre13_linhatransporte = 0; 
  public $tre13_data_dia = null; 
  public $tre13_data_mes = null; 
  public $tre13_data_ano = null; 
  public $tre13_data = null; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 tre13_sequencial = int8 = Sequencial 
                 tre13_linhatransporte = int8 = linha transporte 
                 tre13_data = date = Data 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("linhafrequencia"); 
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
       $this->tre13_sequencial = ($this->tre13_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["tre13_sequencial"]:$this->tre13_sequencial);
       $this->tre13_linhatransporte = ($this->tre13_linhatransporte == ""?@$GLOBALS["HTTP_POST_VARS"]["tre13_linhatransporte"]:$this->tre13_linhatransporte);
       if ($this->tre13_data == "") {
         $this->tre13_data_dia = ($this->tre13_data_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["tre13_data_dia"]:$this->tre13_data_dia);
         $this->tre13_data_mes = ($this->tre13_data_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["tre13_data_mes"]:$this->tre13_data_mes);
         $this->tre13_data_ano = ($this->tre13_data_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["tre13_data_ano"]:$this->tre13_data_ano);
         if ($this->tre13_data_dia != "") {
            $this->tre13_data = $this->tre13_data_ano."-".$this->tre13_data_mes."-".$this->tre13_data_dia;
         }
       }
     } else {
     }
   }

  // funcao para inclusao
  function incluir () { 
      $this->atualizacampos();

      if($this->tre13_sequencial == "" || $this->tre13_sequencial == null ){
        $result = db_query("select nextval('linhafrequencia_tre13_sequencial_seq')");
        if($result==false){
          $this->erro_banco = str_replace("\n","",@pg_last_error());
          $this->erro_sql   = "Verifique o cadastro da sequencia: linhafrequencia_tre13_sequencial_seq do campo: tre13_sequencial";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }
        $this->tre13_sequencial = pg_result($result,0,0);
      }else{
        $result = db_query("select last_value from linhafrequencia_tre13_sequencial_seq");
        if(($result != false) && (pg_result($result,0,0) < $this->tre13_sequencial)){
          $this->erro_sql = " Campo tre13_sequencial maior que último número da sequencia.";
          $this->erro_banco = "Sequencia menor que este número.";
          $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
          $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
          $this->erro_status = "0";
          return false;
        }else{
          $this->tre13_sequencial = $this->tre13_sequencial;
        }
      } 
     if ($this->tre13_sequencial == null ) { 
       $this->erro_sql = " Campo Sequencial não informado.";
       $this->erro_campo = "tre13_sequencial";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->tre13_linhatransporte == null ) { 
       $this->erro_sql = " Campo linha transporte não informado.";
       $this->erro_campo = "tre13_linhatransporte";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->tre13_data == null ) { 
       $this->erro_sql = " Campo Data não informado.";
       $this->erro_campo = "tre13_data";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into linhafrequencia(
                                       tre13_sequencial 
                                      ,tre13_linhatransporte 
                                      ,tre13_data 
                       )
                values (
                                $this->tre13_sequencial 
                               ,$this->tre13_linhatransporte 
                               ,".($this->tre13_data == "null" || $this->tre13_data == ""?"null":"'".$this->tre13_data."'")." 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "linhafrequencia () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "linhafrequencia já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "linhafrequencia () nao Incluído. Inclusao Abortada.";
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
     $sql = " update linhafrequencia set ";
     $virgula = "";
     if (trim($this->tre13_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tre13_sequencial"])) { 
       $sql  .= $virgula." tre13_sequencial = $this->tre13_sequencial ";
       $virgula = ",";
       if (trim($this->tre13_sequencial) == null ) { 
         $this->erro_sql = " Campo Sequencial não informado.";
         $this->erro_campo = "tre13_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->tre13_linhatransporte)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tre13_linhatransporte"])) { 
       $sql  .= $virgula." tre13_linhatransporte = $this->tre13_linhatransporte ";
       $virgula = ",";
       if (trim($this->tre13_linhatransporte) == null ) { 
         $this->erro_sql = " Campo linha transporte não informado.";
         $this->erro_campo = "tre13_linhatransporte";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->tre13_data)!="" || isset($GLOBALS["HTTP_POST_VARS"]["tre13_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["tre13_data_dia"] !="") ) { 
       $sql  .= $virgula." tre13_data = '$this->tre13_data' ";
       $virgula = ",";
       if (trim($this->tre13_data) == null ) { 
         $this->erro_sql = " Campo Data não informado.";
         $this->erro_campo = "tre13_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["tre13_data_dia"])) { 
         $sql  .= $virgula." tre13_data = null ";
         $virgula = ",";
         if (trim($this->tre13_data) == null ) { 
           $this->erro_sql = " Campo Data não informado.";
           $this->erro_campo = "tre13_data_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
$sql .= "oid = '$oid'";     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "linhafrequencia nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "linhafrequencia nao foi Alterado. Alteracao Executada.\\n";
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

     $sql = " delete from linhafrequencia
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
       $this->erro_sql   = "linhafrequencia nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "linhafrequencia nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:linhafrequencia";
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
     $sql .= " from linhafrequencia ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where linhafrequencia.oid = '$oid'";
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
     $sql .= " from linhafrequencia ";
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

  function sql_query_linhas($campos="*",$ordem=null,$dbwhere=""){
   
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
    $sql .= " from linhafrequencia ";
    $sql .= " inner join linhatransporte on tre06_sequencial = tre13_linhatransporte";
    $sql .= " left join cgm on z01_numcgm = tre06_numcgm";
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
