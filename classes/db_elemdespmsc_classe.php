<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE elemdespmsc/
class cl_elemdespmsc {
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
  public $c211_elemdespestrut = null;
  public $c211_mscestrut = null;
  public $c211_anousu = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 c211_elemdespestrut = varchar(9) = Estrutural E-Cidade
                 c211_mscestrut = varchar(9) = Estrutural MSC
                 c211_anousu = int4 = Ano
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("elemdespmsc");
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
       $this->c211_elemdespestrut = ($this->c211_elemdespestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c211_elemdespestrut"]:$this->c211_elemdespestrut);
       $this->c211_mscestrut = ($this->c211_mscestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c211_mscestrut"]:$this->c211_mscestrut);
        $this->c211_anousu = ($this->c211_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c211_anousu"]:$this->c211_anousu);
     } else {
       $this->c211_elemdespestrut = ($this->c211_elemdespestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c211_elemdespestrut"]:$this->c211_elemdespestrut);
       $this->c211_mscestrut = ($this->c211_mscestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c211_mscestrut"]:$this->c211_mscestrut);
        $this->c211_anousu = ($this->c211_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c211_anousu"]:$this->c211_anousu);
     }
   }

  // funcao para inclusao
  function incluir ($c211_elemdespestrut,$c211_mscestrut,$c211_anousu) {
    $this->atualizacampos();
    $this->c211_elemdespestrut = $c211_elemdespestrut;
    $this->c211_mscestrut = $c211_mscestrut;
     if (($this->c211_elemdespestrut == null) || ($this->c211_elemdespestrut == "") ) {
       $this->erro_sql = " Campo c211_elemdespestrut nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if (($this->c211_mscestrut == null) || ($this->c211_mscestrut == "") ) {
       $this->erro_sql = " Campo c211_mscestrut nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into elemdespmsc(
                                       c211_elemdespestrut
                                      ,c211_mscestrut
                                      ,c211_anousu
                       )
                values (
                                '$this->c211_elemdespestrut'
                               ,'$this->c211_mscestrut'
                               ,'$this->c211_anousu'
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Elemento da despesa MSC ($this->c211_elemdespestrut."-".$this->c211_mscestrut) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Elemento da despesa MSC já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Elemento da despesa MSC ($this->c211_elemdespestrut."-".$this->c211_mscestrut) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
     $this->erro_sql .= "Valores : ".$this->c211_elemdespestrut."-".$this->c211_mscestrut;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c211_elemdespestrut,$this->c211_mscestrut  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->c211_elemdespestrut','I')");
         $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->c211_mscestrut','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'c211_elemdespestrut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'c211_mscestrut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($c211_elemdespestrut=null,$c211_mscestrut=null) {
      $this->atualizacampos();
     $sql = " update elemdespmsc set ";
     $virgula = "";
     if (trim($this->c211_elemdespestrut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c211_elemdespestrut"])) {
       $sql  .= $virgula." c211_elemdespestrut = '$this->c211_elemdespestrut' ";
       $virgula = ",";
       if (trim($this->c211_elemdespestrut) == null ) {
         $this->erro_sql = " Campo Estrutural elemdesp MSC não informado.";
         $this->erro_campo = "c211_elemdespestrut";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c211_mscestrut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c211_mscestrut"])) {
       $sql  .= $virgula." c211_mscestrut = '$this->c211_mscestrut' ";
       $virgula = ",";
       if (trim($this->c211_mscestrut) == null ) {
         $this->erro_sql = " Campo Estrutural MSC não informado.";
         $this->erro_campo = "c211_mscestrut";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " , c211_anousu = ".$this->c211_anousu." ";
     $sql .= " where ";
     if ($c211_elemdespestrut!=null) {
       $sql .= " c211_elemdespestrut = '$this->c211_elemdespestrut'";
     }
     if ($c211_mscestrut!=null) {
       $sql .= " and  c211_mscestrut = '$this->c211_mscestrut'";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c211_elemdespestrut,$this->c211_mscestrut));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->c211_elemdespestrut','A')");
           $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->c211_mscestrut','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c211_elemdespestrut"]) || $this->c211_elemdespestrut != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'c211_elemdespestrut'))."','$this->c211_elemdespestrut',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c211_mscestrut"]) || $this->c211_mscestrut != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'c211_mscestrut'))."','$this->c211_mscestrut',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Elemento da despesa MSC nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c211_elemdespestrut."-".$this->c211_mscestrut;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Elemento da despesa MSC nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c211_elemdespestrut."-".$this->c211_mscestrut;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c211_elemdespestrut."-".$this->c211_mscestrut;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($c211_elemdespestrut=null,$c211_mscestrut=null,$c211_anousu,$dbwhere=null) {

     $sql = " delete from elemdespmsc
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($c211_elemdespestrut != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c211_elemdespestrut = '$c211_elemdespestrut' ";
        }
        if ($c211_mscestrut != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c211_mscestrut = '$c211_mscestrut' ";
        }
        if ($c211_anousu != "") {
            if ($sql2!="") {
                $sql2 .= " and ";
            }
            $sql2 .= " c211_anousu = '$c211_anousu' ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Elemento da despesa MSC nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c211_elemdespestrut."-".$c211_mscestrut."-".$c211_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Elemento da despesa MSC nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c211_elemdespestrut."-".$c211_mscestrut;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c211_elemdespestrut."-".$c211_mscestrut;
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
        $this->erro_sql   = "Record Vazio na Tabela:elemdespmsc";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $c211_elemdespestrut=null,$c211_mscestrut=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from elemdespmsc ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c211_elemdespestrut!=null ) {
         $sql2 .= " where elemdespmsc.c211_elemdespestrut = '$c211_elemdespestrut' ";
       }
       if ($c211_mscestrut!=null ) {
         if ($sql2!="") {
            $sql2 .= " and ";
         } else {
            $sql2 .= " where ";
         }
         $sql2 .= " elemdespmsc.c211_mscestrut = '$c211_mscestrut' ";
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
  function sql_query_file ( $c211_elemdespestrut=null,$c211_mscestrut=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from elemdespmsc ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c211_elemdespestrut!=null ) {
         $sql2 .= " where elemdespmsc.c211_elemdespestrut = '$c211_elemdespestrut' ";
       }
       if ($c211_mscestrut!=null ) {
         if ($sql2!="") {
            $sql2 .= " and ";
         } else {
            $sql2 .= " where ";
         }
         $sql2 .= " elemdespmsc.c211_mscestrut = '$c211_mscestrut' ";
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
}
?>
