<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE natdespmsc
class cl_natdespmsc { 
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
  public $c212_natdespestrut = null; 
  public $c212_mscestrut = null; 
  public $c212_anousu = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 c212_natdespestrut = varchar(8) = E-Cidade 
                 c212_mscestrut = varchar(8) = MSC 
                 c212_anousu = int4 = Ano
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("natdespmsc"); 
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
       $this->c212_natdespestrut = ($this->c212_natdespestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c212_natdespestrut"]:$this->c212_natdespestrut);
       $this->c212_mscestrut = ($this->c212_mscestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c212_mscestrut"]:$this->c212_mscestrut);
        $this->c212_anousu = ($this->c212_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c212_anousu"]:$this->c212_anousu);
     } else {
     }
   }

  // funcao para inclusao
  function incluir ($c212_natdespestrut, $c212_mscestrut, $c212_anousu) {
    $this->atualizacampos();
    $this->c212_natdespestrut = $c212_natdespestrut; 
    $this->c212_mscestrut = $c212_mscestrut; 
     if (($this->c212_natdespestrut == null) || ($this->c212_natdespestrut == "") ) { 
       $this->erro_sql = " Campo c212_natdespestrut nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if (($this->c212_mscestrut == null) || ($this->c212_mscestrut == "") ) { 
       $this->erro_sql = " Campo c212_mscestrut nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into natdespmsc(
                                       c212_natdespestrut 
                                      ,c212_mscestrut 
                                      ,c212_anousu
                       )
                values (
                                '$this->c212_natdespestrut' 
                               ,'$this->c212_mscestrut' 
                               ,'$this->c212_anousu'
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "De/Para Orçamento MSC Natureza da Despesa () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "De/Para Orçamento MSC Natureza da Despesa já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "De/Para Orçamento MSC Natureza da Despesa () nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->c212_natdespestrut."-".$this->c212_mscestrut;
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
     $sql = " update natdespmsc set ";
     $virgula = "";
     if (trim($this->c212_natdespestrut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c212_natdespestrut"])) { 
       $sql  .= $virgula." c212_natdespestrut = '$this->c212_natdespestrut' ";
       $virgula = ",";
       if (trim($this->c212_natdespestrut) == null ) { 
         $this->erro_sql = " Campo E-Cidade não informado.";
         $this->erro_campo = "c212_natdespestrut";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c212_mscestrut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c212_mscestrut"])) { 
       $sql  .= $virgula." c212_mscestrut = '$this->c212_mscestrut' ";
       $virgula = ",";
       if (trim($this->c212_mscestrut) == null ) { 
         $this->erro_sql = " Campo MSC não informado.";
         $this->erro_campo = "c212_mscestrut";
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
       $this->erro_sql   = "De/Para Orçamento MSC Natureza da Despesa nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "De/Para Orçamento MSC Natureza da Despesa nao foi Alterado. Alteracao Executada.\\n";
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
  function excluir ($c212_natdespestrut=null,$c212_mscestrut=null,$c212_anousu=null,$dbwhere=null) {

    $sql = " delete from natdespmsc
                   where ";
    $sql2 = "";
    if ($dbwhere==null || $dbwhere =="") {
       if ($c212_natdespestrut != "") {
         if ($sql2!="") {
           $sql2 .= " and ";
         }
         $sql2 .= " c212_natdespestrut = '$c212_natdespestrut' ";
       }
       if ($c212_mscestrut != "") {
         if ($sql2!="") {
           $sql2 .= " and ";
         }
         $sql2 .= " c212_mscestrut = '$c212_mscestrut' ";
       }
       if ($c212_anousu != "") {
           if ($sql2 != "") {
               $sql2 .= " and ";
           }
           $sql2 .= " c212_anousu = '$c212_anousu' ";
       }
    } else {
      $sql2 = $dbwhere;
    }
    $result = db_query($sql.$sql2);
    if ($result==false) { 
      $this->erro_banco = str_replace("\n","",@pg_last_error());
      $this->erro_sql   = "Código da Receita MSC nao Excluído. Exclusão Abortada.\\n";
      $this->erro_sql .= "Valores : ".$c212_natdespestrut."-".$c212_mscestrut;
      $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
      $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
      $this->erro_status = "0";
      $this->numrows_excluir = 0;
      return false;
    } else {
      if (pg_affected_rows($result)==0) {
        $this->erro_banco = "";
        $this->erro_sql = "Código da Receita MSC nao Encontrado. Exclusão não Efetuada.\\n";
        $this->erro_sql .= "Valores : ".$c212_natdespestrut."-".$c212_mscestrut;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_excluir = 0;
        return true;
      } else {
        $this->erro_banco = "";
        $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
        $this->erro_sql .= "Valores : ".$c212_natdespestrut."-".$c212_mscestrut;
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
        $this->erro_sql   = "Record Vazio na Tabela:natdespmsc";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $oid = null,$campos=" * ",$ordem=null,$dbwhere="") { 
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
     $sql .= " from natdespmsc ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ( $oid != "" && $oid != null) {
          $sql2 = " where natdespmsc.oid = '$oid'";
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
     $sql .= " from natdespmsc ";
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