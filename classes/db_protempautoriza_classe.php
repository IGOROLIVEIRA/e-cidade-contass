<?php
//MODULO: protocolo
//CLASSE DA ENTIDADE protempautoriza
class cl_protempautoriza {
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
  public $p102_sequencial = 0;
  public $p102_autorizacao = 0;
  public $p102_protocolo = 0;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 p102_sequencial = int4 = Prot. Aut. Empenho
                 p102_autorizacao = int4 = Autorizacao
                 p102_protocolo = int4 = Protocolo
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("protempautoriza");
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
       $this->p102_sequencial = ($this->p102_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p102_sequencial"]:$this->p102_sequencial);
       $this->p102_autorizacao = ($this->p102_autorizacao == ""?@$GLOBALS["HTTP_POST_VARS"]["p102_autorizacao"]:$this->p102_autorizacao);
       $this->p102_protocolo = ($this->p102_protocolo == ""?@$GLOBALS["HTTP_POST_VARS"]["p102_protocolo"]:$this->p102_protocolo);
     } else {
       $this->p102_sequencial = ($this->p102_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["p102_sequencial"]:$this->p102_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($p102_sequencial) {
      $this->atualizacampos();
     if ($this->p102_autorizacao == null ) {
       $this->erro_sql = " Campo Autorizacao não informado.";
       $this->erro_campo = "p102_autorizacao";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->p102_protocolo == null ) {
       $this->erro_sql = " Campo Protocolo não informado.";
       $this->erro_campo = "p102_protocolo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($p102_sequencial == "" || $p102_sequencial == null ) {
       $result = db_query("select nextval('protempautoriza_p102_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: protempautoriza_p102_sequencial_seq do campo: p102_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->p102_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from protempautoriza_p102_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $p102_sequencial)) {
         $this->erro_sql = " Campo p102_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->p102_sequencial = $p102_sequencial;
       }
     }
     if (($this->p102_sequencial == null) || ($this->p102_sequencial == "") ) {
       $this->erro_sql = " Campo p102_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into protempautoriza(
                                       p102_sequencial
                                      ,p102_autorizacao
                                      ,p102_protocolo
                       )
                values (
                                $this->p102_sequencial
                               ,$this->p102_autorizacao
                               ,$this->p102_protocolo
                      )";
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "protempautoriza ($this->p102_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "protempautoriza já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "protempautoriza ($this->p102_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p102_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p102_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009256,'$this->p102_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,0,'p102_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,0,'p102_autorizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,0,'p102_protocolo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($p102_sequencial=null) {
      $this->atualizacampos();
     $sql = " update protempautoriza set ";
     $virgula = "";
     if (trim($this->p102_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p102_sequencial"])) {
       $sql  .= $virgula." p102_sequencial = $this->p102_sequencial ";
       $virgula = ",";
       if (trim($this->p102_sequencial) == null ) {
         $this->erro_sql = " Campo Prot. Aut. Empenho não informado.";
         $this->erro_campo = "p102_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p102_autorizacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p102_autorizacao"])) {
       $sql  .= $virgula." p102_autorizacao = $this->p102_autorizacao ";
       $virgula = ",";
       if (trim($this->p102_autorizacao) == null ) {
         $this->erro_sql = " Campo Autorizacao não informado.";
         $this->erro_campo = "p102_autorizacao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->p102_protocolo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["p102_protocolo"])) {
       $sql  .= $virgula." p102_protocolo = $this->p102_protocolo ";
       $virgula = ",";
       if (trim($this->p102_protocolo) == null ) {
         $this->erro_sql = " Campo Protocolo não informado.";
         $this->erro_campo = "p102_protocolo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where ";
     if ($p102_sequencial!=null) {
       $sql .= " p102_sequencial = $this->p102_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->p102_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009256,'$this->p102_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p102_sequencial"]) || $this->p102_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009256,'".AddSlashes(pg_result($resaco,$conresaco,'p102_sequencial'))."','$this->p102_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p102_autorizacao"]) || $this->p102_autorizacao != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009257,'".AddSlashes(pg_result($resaco,$conresaco,'p102_autorizacao'))."','$this->p102_autorizacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["p102_protocolo"]) || $this->p102_protocolo != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009258,'".AddSlashes(pg_result($resaco,$conresaco,'p102_protocolo'))."','$this->p102_protocolo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protempautoriza nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->p102_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protempautoriza nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->p102_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->p102_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($p102_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($p102_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009256,'$p102_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009256,'','".AddSlashes(pg_result($resaco,$iresaco,'p102_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009257,'','".AddSlashes(pg_result($resaco,$iresaco,'p102_autorizacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009258,'','".AddSlashes(pg_result($resaco,$iresaco,'p102_protocolo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from protempautoriza
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($p102_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " p102_sequencial = $p102_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "protempautoriza nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$p102_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "protempautoriza nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$p102_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$p102_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:protempautoriza";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $p102_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protempautoriza ";
     $sql .= "      inner join empautoriza  on  empautoriza.e54_autori = protempautoriza.p102_autorizacao";
     $sql .= "      inner join protocolos  on  protocolos.p101_sequencial = protempautoriza.p102_protocolo";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = empautoriza.e54_numcgm";
     $sql .= "      inner join db_config  on  db_config.codigo = empautoriza.e54_instit";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = empautoriza.e54_login";
     $sql .= "      inner join db_depart  on  db_depart.coddepto = empautoriza.e54_depto";
     $sql .= "      inner join pctipocompra  on  pctipocompra.pc50_codcom = empautoriza.e54_codcom";
     $sql .= "      inner join concarpeculiar  on  concarpeculiar.c58_sequencial = empautoriza.e54_concarpeculiar";
     $sql .= "      inner join db_usuarios  as a on   a.id_usuario = protocolos.p101_id_usuario";
     $sql .= "      inner join db_depart  as b on   b.coddepto = protocolos.p101_coddeptoorigem and   b.coddepto = protocolos.p101_coddeptodestino";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p102_sequencial!=null ) {
         $sql2 .= " where protempautoriza.p102_sequencial = $p102_sequencial ";
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
  function sql_query_file ( $p102_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from protempautoriza ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($p102_sequencial!=null ) {
         $sql2 .= " where protempautoriza.p102_sequencial = $p102_sequencial ";
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
