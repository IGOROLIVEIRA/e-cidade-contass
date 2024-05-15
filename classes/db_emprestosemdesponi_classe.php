<?php
//MODULO: contabilidade
//CLASSE DA ENTIDADE emprestosemdesponi
class cl_emprestosemdesponi { 
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
  public $c218_anousu = 0; 
  public $c218_numemp = 0; 
  public $c218_valorpago = 0; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 c218_anousu = int8 = Ano Sessão 
                 c218_numemp = int8 = Empenho 
                 c218_valorpago = float8 = Valor Pago 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("emprestosemdesponi"); 
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
       $this->c218_anousu = ($this->c218_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_anousu"]:$this->c218_anousu);
       $this->c218_numemp = ($this->c218_numemp == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_numemp"]:$this->c218_numemp);
       $this->c218_valorpago = ($this->c218_valorpago == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_valorpago"]:$this->c218_valorpago);
     } else {
       $this->c218_anousu = ($this->c218_anousu == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_anousu"]:$this->c218_anousu);
       $this->c218_numemp = ($this->c218_numemp == ""?@$GLOBALS["HTTP_POST_VARS"]["c218_numemp"]:$this->c218_numemp);
     }
   }

  // funcao para inclusao
  function incluir ($c218_numemp,$c218_anousu) { 
      $this->atualizacampos();
     if ($this->c218_valorpago == null ) { 
       $this->erro_sql = " Campo Valor Pago não informado.";
       $this->erro_campo = "c218_valorpago";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->c218_numemp = $c218_numemp; 
       $this->c218_anousu = $c218_anousu; 
     if (($this->c218_numemp == null) || ($this->c218_numemp == "") ) { 
       $this->erro_sql = " Campo c218_numemp nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if (($this->c218_anousu == null) || ($this->c218_anousu == "") ) { 
       $this->erro_sql = " Campo c218_anousu nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into emprestosemdesponi(
                                       c218_anousu 
                                      ,c218_numemp 
                                      ,c218_valorpago 
                       )
                values (
                                $this->c218_anousu 
                               ,$this->c218_numemp 
                               ,$this->c218_valorpago 
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "emprestosemdesponi ($this->c218_numemp."-".$this->c218_anousu) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "emprestosemdesponi já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "emprestosemdesponi ($this->c218_numemp."-".$this->c218_anousu) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c218_numemp."-".$this->c218_anousu;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c218_numemp,$this->c218_anousu  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,2011900,'$this->c218_numemp','I')");
         $resac = db_query("insert into db_acountkey values($acount,2011899,'$this->c218_anousu','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,2011899,'','".AddSlashes(pg_result($resaco,0,'c218_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011900,'','".AddSlashes(pg_result($resaco,0,'c218_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,2011901,'','".AddSlashes(pg_result($resaco,0,'c218_valorpago'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($c218_numemp=null,$c218_anousu=null) { 
      $this->atualizacampos();
     $sql = " update emprestosemdesponi set ";
     $virgula = "";
     if (trim($this->c218_anousu)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_anousu"])) { 
       $sql  .= $virgula." c218_anousu = $this->c218_anousu ";
       $virgula = ",";
       if (trim($this->c218_anousu) == null ) { 
         $this->erro_sql = " Campo Ano Sessão não informado.";
         $this->erro_campo = "c218_anousu";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c218_numemp)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_numemp"])) { 
       $sql  .= $virgula." c218_numemp = $this->c218_numemp ";
       $virgula = ",";
       if (trim($this->c218_numemp) == null ) { 
         $this->erro_sql = " Campo Empenho não informado.";
         $this->erro_campo = "c218_numemp";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->c218_valorpago)!="" || isset($GLOBALS["HTTP_POST_VARS"]["c218_valorpago"])) { 
       $sql  .= $virgula." c218_valorpago = $this->c218_valorpago ";
       $virgula = ",";
       if (trim($this->c218_valorpago) == null ) { 
         $this->erro_sql = " Campo Valor Pago não informado.";
         $this->erro_campo = "c218_valorpago";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($c218_numemp!=null) {
       $sql .= " c218_numemp = $this->c218_numemp";
     }
     if ($c218_anousu!=null) {
       $sql .= " and  c218_anousu = $this->c218_anousu";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->c218_numemp,$this->c218_anousu));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,2011900,'$this->c218_numemp','A')");
           $resac = db_query("insert into db_acountkey values($acount,2011899,'$this->c218_anousu','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c218_anousu"]) || $this->c218_anousu != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011899,'".AddSlashes(pg_result($resaco,$conresaco,'c218_anousu'))."','$this->c218_anousu',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c218_numemp"]) || $this->c218_numemp != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011900,'".AddSlashes(pg_result($resaco,$conresaco,'c218_numemp'))."','$this->c218_numemp',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["c218_valorpago"]) || $this->c218_valorpago != "")
             $resac = db_query("insert into db_acount values($acount,1010192,2011901,'".AddSlashes(pg_result($resaco,$conresaco,'c218_valorpago'))."','$this->c218_valorpago',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "emprestosemdesponi nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->c218_numemp."-".$this->c218_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "emprestosemdesponi nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->c218_numemp."-".$this->c218_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->c218_numemp."-".$this->c218_anousu;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($c218_numemp=null,$c218_anousu=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($c218_numemp,$c218_anousu));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,2011900,'$c218_numemp','E')");
           $resac  = db_query("insert into db_acountkey values($acount,2011899,'$c218_anousu','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011899,'','".AddSlashes(pg_result($resaco,$iresaco,'c218_anousu'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011900,'','".AddSlashes(pg_result($resaco,$iresaco,'c218_numemp'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,2011901,'','".AddSlashes(pg_result($resaco,$iresaco,'c218_valorpago'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from emprestosemdesponi
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($c218_numemp != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c218_numemp = $c218_numemp ";
        }
        if ($c218_anousu != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " c218_anousu = $c218_anousu ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "emprestosemdesponi nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$c218_numemp."-".$c218_anousu;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "emprestosemdesponi nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$c218_numemp."-".$c218_anousu;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$c218_numemp."-".$c218_anousu;
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
        $this->erro_sql   = "Record Vazio na Tabela:emprestosemdesponi";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $c218_numemp=null,$c218_anousu=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from emprestosemdesponi ";
     $sql .= "      inner join empempenho  on  empempenho.e60_numemp = emprestosemdesponi.c218_numemp";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = empempenho.e60_numcgm";
     $sql .= "      inner join db_config  on  db_config.codigo = empempenho.e60_instit";
     $sql .= "      inner join orcdotacao  on  orcdotacao.o58_anousu = empempenho.e60_anousu and  orcdotacao.o58_coddot = empempenho.e60_coddot";
     $sql .= "      inner join pctipocompra  on  pctipocompra.pc50_codcom = empempenho.e60_codcom";
     $sql .= "      inner join emptipo  on  emptipo.e41_codtipo = empempenho.e60_codtipo";
     $sql .= "      inner join concarpeculiar  on  concarpeculiar.c58_sequencial = empempenho.e60_concarpeculiar";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c218_numemp!=null ) {
         $sql2 .= " where emprestosemdesponi.c218_numemp = $c218_numemp "; 
       } 
       if ($c218_anousu!=null ) {
         if ($sql2!="") {
            $sql2 .= " and ";
         } else {
            $sql2 .= " where ";
         } 
         $sql2 .= " emprestosemdesponi.c218_anousu = $c218_anousu "; 
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
  function sql_query_file ( $c218_numemp=null,$c218_anousu=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from emprestosemdesponi ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($c218_numemp!=null ) {
         $sql2 .= " where emprestosemdesponi.c218_numemp = $c218_numemp "; 
       } 
       if ($c218_anousu!=null ) {
         if ($sql2!="") {
            $sql2 .= " and ";
         } else {
            $sql2 .= " where ";
         } 
         $sql2 .= " emprestosemdesponi.c218_anousu = $c218_anousu "; 
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
