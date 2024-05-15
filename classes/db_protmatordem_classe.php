<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE protmatordem
class cl_protmatordem {
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
  public $p104_sequencial = 0;
  public $p104_codordem = 0;
  public $p104_protocolo = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 p104_sequencial = int4 = Prot. Ord. Compra
                 p104_codordem = int8 = Codigo
                 p104_protocolo = int4 = Protocolo
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("protmatordem");
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
       $this->p104_sequencial = ($this->p104_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p104_sequencial"]:$this->p104_sequencial);
       $this->p104_codordem = ($this->p104_codordem == ""?@$GLOBALS["HTTP_POST_VARS"]["p104_codordem"]:$this->p104_codordem);
       $this->p104_protocolo = ($this->p104_protocolo == ""?@$GLOBALS["HTTP_POST_VARS"]["p104_protocolo"]:$this->p104_protocolo);
     } else {
       $this->p104_sequencial = ($this->p104_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p104_sequencial"]:$this->p104_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($p104_sequencial) {
      $this->atualizacampos();
     if ($this->p104_codordem == null ) {
       $this->erro_sql = " Campo Codigo não informado.";
       $this->erro_campo = "p104_codordem";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p104_protocolo == null ) {
       $this->erro_sql = " Campo Protocolo não informado.";
       $this->erro_campo = "p104_protocolo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($p104_sequencial == "" || $p104_sequencial == null ) {
       $result = db_query("select nextval('protmatordem_p104_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: protmatordem_p104_sequencial_seq do campo: p104_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->p104_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from protmatordem_p104_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $p104_sequencial)) {
         $this->erro_sql = " Campo p104_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->p104_sequencial = $p104_sequencial;
       }
     }
     if (($this->p104_sequencial == null) || ($this->p104_sequencial == "") ) {
       $this->erro_sql = " Campo p104_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into protmatordem(
                                       p104_sequencial
                                      ,p104_codordem
                                      ,p104_protocolo
                       )
                values (
                                $this->p104_sequencial
                               ,$this->p104_codordem
                               ,$this->p104_protocolo
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "protmatordem ($this->p104_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "protmatordem já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "protmatordem ($this->p104_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p104_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p104_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009262,'$this->p104_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010195,1009262,'','".AddSlashes(pg_result($resaco,0,'p104_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,1009263,'','".AddSlashes(pg_result($resaco,0,'p104_codordem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010195,1009264,'','".AddSlashes(pg_result($resaco,0,'p104_protocolo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($p104_sequencial=null) {
      $this->atualizacampos();
     $sql = " update protmatordem set ";
     $virgula = "";
     if (trim($this->p104_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p104_sequencial"])) {
       $sql  .= $virgula." p104_sequencial = $this->p104_sequencial ";
       $virgula = ",";
       if (trim($this->p104_sequencial) == null ) {
         $this->erro_sql = " Campo Prot. Ord. Compra não informado.";
         $this->erro_campo = "p104_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p104_codordem)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p104_codordem"])) {
       $sql  .= $virgula." p104_codordem = $this->p104_codordem ";
       $virgula = ",";
       if (trim($this->p104_codordem) == null ) {
         $this->erro_sql = " Campo Codigo não informado.";
         $this->erro_campo = "p104_codordem";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p104_protocolo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p104_protocolo"])) {
       $sql  .= $virgula." p104_protocolo = $this->p104_protocolo ";
       $virgula = ",";
       if (trim($this->p104_protocolo) == null ) {
         $this->erro_sql = " Campo Protocolo não informado.";
         $this->erro_campo = "p104_protocolo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($p104_sequencial!=null) {
       $sql .= " p104_sequencial = $this->p104_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p104_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009262,'$this->p104_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p104_sequencial"]) || $this->p104_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009262,'".AddSlashes(pg_result($resaco,$conresaco,'p104_sequencial'))."','$this->p104_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p104_codordem"]) || $this->p104_codordem != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009263,'".AddSlashes(pg_result($resaco,$conresaco,'p104_codordem'))."','$this->p104_codordem',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p104_protocolo"]) || $this->p104_protocolo != "")
             $resac = db_query("insert into db_acount values($acount,1010195,1009264,'".AddSlashes(pg_result($resaco,$conresaco,'p104_protocolo'))."','$this->p104_protocolo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protmatordem nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->p104_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protmatordem nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->p104_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p104_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($p104_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($p104_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009262,'$p104_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009262,'','".AddSlashes(pg_result($resaco,$iresaco,'p104_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009263,'','".AddSlashes(pg_result($resaco,$iresaco,'p104_codordem'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010195,1009264,'','".AddSlashes(pg_result($resaco,$iresaco,'p104_protocolo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from protmatordem
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($p104_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " p104_sequencial = $p104_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protmatordem nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$p104_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protmatordem nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$p104_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$p104_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:protmatordem";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $p104_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protmatordem ";
     $sql .= "      inner join matordem  on  matordem.m51_codordem = protmatordem.p104_codordem";
     $sql .= "      inner join protocolos  on  protocolos.p101_sequencial = protmatordem.p104_protocolo";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = matordem.m51_numcgm";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = matordem.m51_depto and  db_depart.coddepto = matordem.m51_deptoorigem";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = protocolos.p101_id_usuario";
     $sql .= "      inner join db_depart  as a on   a.coddepto = protocolos.p101_coddeptoorigem and   a.coddepto = protocolos.p101_coddeptodestino";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p104_sequencial!=null ) {
         $sql2 .= " where protmatordem.p104_sequencial = $p104_sequencial ";
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
  function sql_query_file ( $p104_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protmatordem ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p104_sequencial!=null ) {
         $sql2 .= " where protmatordem.p104_sequencial = $p104_sequencial ";
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
