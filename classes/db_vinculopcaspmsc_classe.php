<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE vinculopcaspmsc/
class cl_vinculopcaspmsc {
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
  public $c210_pcaspestrut = null;
  public $c210_mscestrut = null;
  public $c210_anousu = null;

  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 c210_pcaspestrut = varchar(9) = Estrutural Pcasp MSC
                 c210_mscestrut = varchar(9) = Estrutural MSC
                 c210_anousu = int4 = Ano
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("vinculopcaspmsc");
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
       $this->c210_pcaspestrut = ($this->c210_pcaspestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_pcaspestrut"]:$this->c210_pcaspestrut);
       $this->c210_mscestrut = ($this->c210_mscestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_mscestrut"]:$this->c210_mscestrut);
        $this->c210_anousu = ($this->c210_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_anousu"]:$this->c210_anousu);
     } else {
       $this->c210_pcaspestrut = ($this->c210_pcaspestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_pcaspestrut"]:$this->c210_pcaspestrut);
       $this->c210_mscestrut = ($this->c210_mscestrut == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_mscestrut"]:$this->c210_mscestrut);
        $this->c210_anousu = ($this->c210_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c210_anousu"]:$this->c210_anousu);
     }
   }

  // funcao para inclusao
  function incluir ($c210_pcaspestrut,$c210_mscestrut,$c210_anousu) {
      $this->atualizacampos();
       $this->c210_pcaspestrut = $c210_pcaspestrut;
       $this->c210_mscestrut = $c210_mscestrut;
     if (($this->c210_pcaspestrut == null) || ($this->c210_pcaspestrut == "") ) {
       $this->erro_sql = " Campo c210_pcaspestrut nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if (($this->c210_mscestrut == null) || ($this->c210_mscestrut == "") ) {
       $this->erro_sql = " Campo c210_mscestrut nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into vinculopcaspmsc(
                                       c210_pcaspestrut
                                      ,c210_mscestrut
                                      ,c210_anousu
                       )
                values (
                                '$this->c210_pcaspestrut'
                               ,'$this->c210_mscestrut'
                               ,'$this->c210_anousu'
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Vínculo Pcasp MSC ($this->c210_pcaspestrut."-".$this->c210_mscestrut) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Vínculo Pcasp MSC já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Vínculo Pcasp MSC ($this->c210_pcaspestrut."-".$this->c210_mscestrut) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c210_pcaspestrut."-".$this->c210_mscestrut;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c210_pcaspestrut,$this->c210_mscestrut  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->c210_pcaspestrut','I')");
         $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->c210_mscestrut','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'c210_pcaspestrut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'c210_mscestrut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
       }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($c210_pcaspestrut=null,$c210_mscestrut=null,$c210_pcaspestrutant=null,$c210_mscestrutant=null,$c210_anousu=null) {
      $this->atualizacampos();
     $sql = " update vinculopcaspmsc set ";
     $virgula = "";
     if (trim($this->c210_pcaspestrut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c210_pcaspestrut"])) {
       $sql  .= $virgula." c210_pcaspestrut = '$this->c210_pcaspestrut' ";
       $virgula = ",";
       if (trim($this->c210_pcaspestrut) == null ) {
         $this->erro_sql = " Campo Estrutural Pcasp MSC não informado.";
         $this->erro_campo = "c210_pcaspestrut";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (isset($GLOBALS["HTTP_POST_VARS"]["c210_pcaspestrutant"])) {
      $this->c210_pcaspestrutant = "'$this->c210_pcaspestrutant'";
     }
     if (trim($this->c210_mscestrut)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c210_mscestrut"])) {
       $sql  .= $virgula." c210_mscestrut = '$this->c210_mscestrut' ";
       $virgula = ",";
       if (trim($this->c210_mscestrut) == null ) {
         $this->erro_sql = " Campo Estrutural MSC não informado.";
         $this->erro_campo = "c210_mscestrut";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (isset($GLOBALS["HTTP_POST_VARS"]["c210_mscestrutant"])) {
      $this->c210_mscestrutant = "'$this->c210_mscestrutant'";
     }
     $sql .= " where ";
     if ($c210_pcaspestrut!=null) {
       $sql .= " c210_pcaspestrut = '$c210_pcaspestrutant'";
     }
     if ($c210_mscestrut!=null) {
       $sql .= " and  c210_mscestrut = '$c210_mscestrutant'";
     }
     if ($c210_anousu!=null) {
         $sql .= " and  c210_anousu = '$c210_anousu'";
     }
     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c210_pcaspestrut,$this->c210_mscestrut));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->c210_pcaspestrut','A')");
           $resac = db_query("insert into db_acountkey values($acount,1009245,'$this->c210_mscestrut','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c210_pcaspestrut"]) || $this->c210_pcaspestrut != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'c210_pcaspestrut'))."','$this->c210_pcaspestrut',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c210_mscestrut"]) || $this->c210_mscestrut != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'c210_mscestrut'))."','$this->c210_mscestrut',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Vínculo Pcasp MSC nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c210_pcaspestrut."-".$this->c210_mscestrut;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Vínculo Pcasp MSC nao foi Alterado. Alteracao Abortada.\\n$sql";
         $this->erro_sql .= "Valores : ".$this->c210_pcaspestrut."-".$this->c210_mscestrut;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c210_pcaspestrut."-".$this->c210_mscestrut;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($c210_pcaspestrut=null,$c210_mscestrut=null,$c210_anousu=null,$dbwhere=null) {

     /*$lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($c210_pcaspestrut,$c210_mscestrut));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009244,'$c210_pcaspestrut','E')");
           $resac  = db_query("insert into db_acountkey values($acount,1009245,'$c210_mscestrut','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'c210_pcaspestrut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'c210_mscestrut'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from vinculopcaspmsc
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($c210_pcaspestrut != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c210_pcaspestrut = '$c210_pcaspestrut' ";
        }
        if ($c210_mscestrut != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c210_mscestrut = '$c210_mscestrut' ";
        }
        if ($c210_anousu != "") {
            if ($sql2!="") {
                $sql2 .= " and ";
            }
            $sql2 .= " c210_anousu = '$c210_anousu' ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Vínculo Pcasp MSC nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c210_pcaspestrut."-".$c210_mscestrut."-".$c210_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Vínculo Pcasp MSC nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c210_pcaspestrut."-".$c210_mscestrut;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c210_pcaspestrut."-".$c210_mscestrut;
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
        $this->erro_sql   = "Record Vazio na Tabela:vinculopcaspmsc";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $c210_pcaspestrut=null,$c210_mscestrut=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from vinculopcaspmsc ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c210_pcaspestrut!=null ) {
         $sql2 .= " where vinculopcaspmsc.c210_pcaspestrut = '$c210_pcaspestrut' ";
       }
       if ($c210_mscestrut!=null ) {
         if ($sql2!="") {
            $sql2 .= " and ";
         } else {
            $sql2 .= " where ";
         }
         $sql2 .= " vinculopcaspmsc.c210_mscestrut = '$c210_mscestrut' ";
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
  function sql_query_file ( $c210_pcaspestrut=null,$c210_mscestrut=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from vinculopcaspmsc ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c210_pcaspestrut!=null ) {
         $sql2 .= " where vinculopcaspmsc.c210_pcaspestrut = '$c210_pcaspestrut' ";
       }
       if ($c210_mscestrut!=null ) {
         if ($sql2!="") {
            $sql2 .= " and ";
         } else {
            $sql2 .= " where ";
         }
         $sql2 .= " vinculopcaspmsc.c210_mscestrut = '$c210_mscestrut' ";
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
