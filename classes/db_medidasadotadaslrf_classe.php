<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE medidasadotadaslrf
class cl_medidasadotadaslrf { 
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
  public $c225_sequencial = 0; 
  public $c225_anousu = 0; 
  public $c225_mesusu = 0; 
  public $c225_orgao = 0; 
  public $c225_metasadotadas = 0; 
  public $c225_dadoscomplementareslrf = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 c225_sequencial = int8 = c225_sequencial 
                 c225_anousu = int4 = c225_anousu 
                 c225_mesusu = int4 = c225_mesusu 
                 c225_orgao = int4 = c225_orgao 
                 c225_metasadotadas = int4 = c225_metasadotadas 
                 c225_dadoscomplementareslrf = int8 = c225_dadoscomplementareslrf 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("medidasadotadaslrf"); 
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
       $this->c225_sequencial = ($this->c225_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["c225_sequencial"]:$this->c225_sequencial);
       $this->c225_anousu = ($this->c225_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c225_anousu"]:$this->c225_anousu);
       $this->c225_mesusu = ($this->c225_mesusu == ""?@$GLOBALS["HTTP_POST_VARS"]["c225_mesusu"]:$this->c225_mesusu);
       $this->c225_orgao = ($this->c225_orgao == ""?@$GLOBALS["HTTP_POST_VARS"]["c225_orgao"]:$this->c225_orgao);
       $this->c225_metasadotadas = ($this->c225_metasadotadas == ""?@$GLOBALS["HTTP_POST_VARS"]["c225_metasadotadas"]:$this->c225_metasadotadas);
       $this->c225_dadoscomplementareslrf = ($this->c225_dadoscomplementareslrf == ""?@$GLOBALS["HTTP_POST_VARS"]["c225_dadoscomplementareslrf"]:$this->c225_dadoscomplementareslrf);
     } else {
     }
   }

  // funcao para inclusao
  function incluir () { 
      $this->atualizacampos();
//     if ($this->c225_sequencial == null ) {
//       $this->erro_sql = " Campo c225_sequencial não informado.";
//       $this->erro_campo = "c225_sequencial";
//       $this->erro_banco = "";
//       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
//       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
//       $this->erro_status = "0";
//       return false;
//     }
     if ($this->c225_anousu == null ) { 
       $this->erro_sql = " Campo c225_anousu não informado.";
       $this->erro_campo = "c225_anousu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c225_mesusu == null ) { 
       $this->erro_sql = " Campo c225_mesusu não informado.";
       $this->erro_campo = "c225_mesusu";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c225_orgao == null ) { 
       $this->erro_sql = " Campo c225_orgao não informado.";
       $this->erro_campo = "c225_orgao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c225_metasadotadas == null ) { 
       $this->erro_sql = " Campo c225_metasadotadas não informado.";
       $this->erro_campo = "c225_metasadotadas";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->c225_dadoscomplementareslrf == null ) { 
       $this->erro_sql = " Campo c225_dadoscomplementareslrf não informado.";
       $this->erro_campo = "c225_dadoscomplementareslrf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into medidasadotadaslrf(
                                       c225_sequencial 
                                      ,c225_anousu 
                                      ,c225_mesusu 
                                      ,c225_orgao 
                                      ,c225_metasadotadas 
                                      ,c225_dadoscomplementareslrf 
                       )
                values (
                                (SELECT nextval('medidasadotadaslrf_c225_sequencial_seq')) 
                               ,$this->c225_anousu 
                               ,$this->c225_mesusu 
                               ,$this->c225_orgao 
                               ,$this->c225_metasadotadas 
                               ,$this->c225_dadoscomplementareslrf 
                      )";
     $result = db_query($sql);
//     die($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "medidasadotadaslrf () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "medidasadotadaslrf já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "medidasadotadaslrf () nao Incluído. Inclusao Abortada.";
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
     $sql = " update medidasadotadaslrf set ";
     $virgula = "";
     if (trim($this->c225_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c225_sequencial"])) { 
       $sql  .= $virgula." c225_sequencial = $this->c225_sequencial ";
       $virgula = ",";
       if (trim($this->c225_sequencial) == null ) { 
         $this->erro_sql = " Campo c225_sequencial não informado.";
         $this->erro_campo = "c225_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c225_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c225_anousu"])) { 
       $sql  .= $virgula." c225_anousu = $this->c225_anousu ";
       $virgula = ",";
       if (trim($this->c225_anousu) == null ) { 
         $this->erro_sql = " Campo c225_anousu não informado.";
         $this->erro_campo = "c225_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c225_mesusu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c225_mesusu"])) { 
       $sql  .= $virgula." c225_mesusu = $this->c225_mesusu ";
       $virgula = ",";
       if (trim($this->c225_mesusu) == null ) { 
         $this->erro_sql = " Campo c225_mesusu não informado.";
         $this->erro_campo = "c225_mesusu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c225_orgao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c225_orgao"])) { 
       $sql  .= $virgula." c225_orgao = $this->c225_orgao ";
       $virgula = ",";
       if (trim($this->c225_orgao) == null ) { 
         $this->erro_sql = " Campo c225_orgao não informado.";
         $this->erro_campo = "c225_orgao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c225_metasadotadas)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c225_metasadotadas"])) { 
       $sql  .= $virgula." c225_metasadotadas = $this->c225_metasadotadas ";
       $virgula = ",";
       if (trim($this->c225_metasadotadas) == null ) { 
         $this->erro_sql = " Campo c225_metasadotadas não informado.";
         $this->erro_campo = "c225_metasadotadas";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c225_dadoscomplementareslrf)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c225_dadoscomplementareslrf"])) { 
       $sql  .= $virgula." c225_dadoscomplementareslrf = $this->c225_dadoscomplementareslrf ";
       $virgula = ",";
       if (trim($this->c225_dadoscomplementareslrf) == null ) { 
         $this->erro_sql = " Campo c225_dadoscomplementareslrf não informado.";
         $this->erro_campo = "c225_dadoscomplementareslrf";
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
       $this->erro_sql   = "medidasadotadaslrf nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "medidasadotadaslrf nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ( $c225_dadoscomplementareslrf=null ,$dbwhere=null) {

     $sql = " delete from medidasadotadaslrf
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
       $sql2 = " c225_dadoscomplementareslrf = $c225_dadoscomplementareslrf";
     } else {
       $sql2 = $dbwhere;
     }
//echo $sql.$sql2;die();
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "medidasadotadaslrf nao Excluído. Exclusão Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "medidasadotadaslrf nao Encontrado. Exclusão não Efetuada.\\n";
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
        $this->erro_sql   = "Record Vazio na Tabela:medidasadotadaslrf";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $oid = null,$campos="medidasadotadaslrf.oid,*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from medidasadotadaslrf ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where medidasadotadaslrf.oid = '$oid'";
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
     $sql .= " from medidasadotadaslrf ";
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
