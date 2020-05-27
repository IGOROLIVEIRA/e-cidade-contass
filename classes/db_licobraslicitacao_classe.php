<?php
//MODULO: Obras
//CLASSE DA ENTIDADE licobraslicitacao
class cl_licobraslicitacao { 
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
  public $obr07_sequencial = 0; 
  public $obr07_processo = 0; 
  public $obr07_exercicio = 0; 
  public $obr07_objeto = null; 
  public $obr07_tipoprocesso = 0; 
  public $obr07_instit = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 obr07_sequencial = int8 = Cód. Sequencial 
                 obr07_processo = int8 = Processo Licitatório 
                 obr07_exercicio = int8 = Exercicio 
                 obr07_objeto = text = Objeto 
                 obr07_tipoprocesso = int8 = Tipo Processo 
                 obr07_instit = int8 = instit 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("licobraslicitacao"); 
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
       $this->obr07_sequencial = ($this->obr07_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["obr07_sequencial"]:$this->obr07_sequencial);
       $this->obr07_processo = ($this->obr07_processo == ""?@$GLOBALS["HTTP_POST_VARS"]["obr07_processo"]:$this->obr07_processo);
       $this->obr07_exercicio = ($this->obr07_exercicio == ""?@$GLOBALS["HTTP_POST_VARS"]["obr07_exercicio"]:$this->obr07_exercicio);
       $this->obr07_objeto = ($this->obr07_objeto == ""?@$GLOBALS["HTTP_POST_VARS"]["obr07_objeto"]:$this->obr07_objeto);
       $this->obr07_tipoprocesso = ($this->obr07_tipoprocesso == ""?@$GLOBALS["HTTP_POST_VARS"]["obr07_tipoprocesso"]:$this->obr07_tipoprocesso);
       $this->obr07_instit = ($this->obr07_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["obr07_instit"]:$this->obr07_instit);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () { 
      $this->atualizacampos();
     if ($this->obr07_sequencial == null ) { 
       $this->erro_sql = " Campo Cód. Sequencial não informado.";
       $this->erro_campo = "obr07_sequencial";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr07_processo == null ) { 
       $this->erro_sql = " Campo Processo Licitatório não informado.";
       $this->erro_campo = "obr07_processo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr07_exercicio == null ) { 
       $this->erro_sql = " Campo Exercicio não informado.";
       $this->erro_campo = "obr07_exercicio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr07_objeto == null ) { 
       $this->erro_sql = " Campo Objeto não informado.";
       $this->erro_campo = "obr07_objeto";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr07_tipoprocesso == null ) { 
       $this->erro_sql = " Campo Tipo Processo não informado.";
       $this->erro_campo = "obr07_tipoprocesso";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->obr07_instit == null ) { 
       $this->erro_sql = " Campo instit não informado.";
       $this->erro_campo = "obr07_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into licobraslicitacao(
                                       obr07_sequencial 
                                      ,obr07_processo 
                                      ,obr07_exercicio 
                                      ,obr07_objeto 
                                      ,obr07_tipoprocesso 
                                      ,obr07_instit 
                       )
                values (
                                $this->obr07_sequencial 
                               ,$this->obr07_processo 
                               ,$this->obr07_exercicio 
                               ,'$this->obr07_objeto' 
                               ,$this->obr07_tipoprocesso 
                               ,$this->obr07_instit 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "cadastro de licitacao obras () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "cadastro de licitacao obras já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "cadastro de licitacao obras () nao Incluído. Inclusao Abortada.";
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
     $sql = " update licobraslicitacao set ";
     $virgula = "";
     if (trim($this->obr07_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr07_sequencial"])) { 
       $sql  .= $virgula." obr07_sequencial = $this->obr07_sequencial ";
       $virgula = ",";
       if (trim($this->obr07_sequencial) == null ) { 
         $this->erro_sql = " Campo Cód. Sequencial não informado.";
         $this->erro_campo = "obr07_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr07_processo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr07_processo"])) { 
       $sql  .= $virgula." obr07_processo = $this->obr07_processo ";
       $virgula = ",";
       if (trim($this->obr07_processo) == null ) { 
         $this->erro_sql = " Campo Processo Licitatório não informado.";
         $this->erro_campo = "obr07_processo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr07_exercicio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr07_exercicio"])) { 
       $sql  .= $virgula." obr07_exercicio = $this->obr07_exercicio ";
       $virgula = ",";
       if (trim($this->obr07_exercicio) == null ) { 
         $this->erro_sql = " Campo Exercicio não informado.";
         $this->erro_campo = "obr07_exercicio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr07_objeto)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr07_objeto"])) { 
       $sql  .= $virgula." obr07_objeto = '$this->obr07_objeto' ";
       $virgula = ",";
       if (trim($this->obr07_objeto) == null ) { 
         $this->erro_sql = " Campo Objeto não informado.";
         $this->erro_campo = "obr07_objeto";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr07_tipoprocesso)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr07_tipoprocesso"])) { 
       $sql  .= $virgula." obr07_tipoprocesso = $this->obr07_tipoprocesso ";
       $virgula = ",";
       if (trim($this->obr07_tipoprocesso) == null ) { 
         $this->erro_sql = " Campo Tipo Processo não informado.";
         $this->erro_campo = "obr07_tipoprocesso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->obr07_instit)!="" || isset($GLOBALS["HTTP_POST_VARS"]["obr07_instit"])) { 
       $sql  .= $virgula." obr07_instit = $this->obr07_instit ";
       $virgula = ",";
       if (trim($this->obr07_instit) == null ) { 
         $this->erro_sql = " Campo instit não informado.";
         $this->erro_campo = "obr07_instit";
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
       $this->erro_sql   = "cadastro de licitacao obras nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "cadastro de licitacao obras nao foi Alterado. Alteracao Executada.\\n";
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

     $sql = " delete from licobraslicitacao
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
       $this->erro_sql   = "cadastro de licitacao obras nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "cadastro de licitacao obras nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:licobraslicitacao";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $oid = null,$campos="licobraslicitacao.oid,*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from licobraslicitacao ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where licobraslicitacao.oid = '$oid'";
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
     $sql .= " from licobraslicitacao ";
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
