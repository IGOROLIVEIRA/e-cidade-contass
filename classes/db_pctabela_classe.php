<?php
//MODULO: compras
//CLASSE DA ENTIDADE pctabela
class cl_pctabela {
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
  public $pc94_sequencial = 0;
  public $pc94_codmater = 0;
  public $pc94_dt_cadastro_dia = null;
  public $pc94_dt_cadastro_mes = null;
  public $pc94_dt_cadastro_ano = null;
  public $pc94_dt_cadastro = null;
  // cria propriedade com as variaveis do arquivo
  public $campos = "
                 pc94_sequencial = int4 = Cód. Tabela
                 pc94_codmater = int4 = Código do Material
                 pc94_dt_cadastro = date = Data de Cadastro
                 ";

  //funcao construtor da classe
  function __construct() {
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("pctabela");
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
       $this->pc94_sequencial = ($this->pc94_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc94_sequencial"]:$this->pc94_sequencial);
       $this->pc94_codmater = ($this->pc94_codmater == ""?@$GLOBALS["HTTP_POST_VARS"]["pc94_codmater"]:$this->pc94_codmater);
       if ($this->pc94_dt_cadastro == "") {
         $this->pc94_dt_cadastro_dia = ($this->pc94_dt_cadastro_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["pc94_dt_cadastro_dia"]:$this->pc94_dt_cadastro_dia);
         $this->pc94_dt_cadastro_mes = ($this->pc94_dt_cadastro_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["pc94_dt_cadastro_mes"]:$this->pc94_dt_cadastro_mes);
         $this->pc94_dt_cadastro_ano = ($this->pc94_dt_cadastro_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["pc94_dt_cadastro_ano"]:$this->pc94_dt_cadastro_ano);
         if ($this->pc94_dt_cadastro_dia != "") {
            $this->pc94_dt_cadastro = $this->pc94_dt_cadastro_ano."-".$this->pc94_dt_cadastro_mes."-".$this->pc94_dt_cadastro_dia;
         }
       }
     } else {
       $this->pc94_sequencial = ($this->pc94_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["pc94_sequencial"]:$this->pc94_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($pc94_sequencial) {
      $this->atualizacampos();
     if ($this->pc94_codmater == null ) {
       $this->pc94_codmater = "0";
     }
     if ($this->pc94_dt_cadastro == null ) {
       $this->erro_sql = " Campo Data de Cadastro não informado.";
       $this->erro_campo = "pc94_dt_cadastro_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($pc94_sequencial == "" || $pc94_sequencial == null ) {
       $result = db_query("select nextval('pctabela_pc94_sequencial_seq')");
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: pctabela_pc94_sequencial_seq do campo: pc94_sequencial";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       $this->pc94_sequencial = pg_result($result,0,0);
     } else {
       $result = db_query("select last_value from pctabela_pc94_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $pc94_sequencial)) {
         $this->erro_sql = " Campo pc94_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->pc94_sequencial = $pc94_sequencial;
       }
     }
     if (($this->pc94_sequencial == null) || ($this->pc94_sequencial == "") ) {
       $this->erro_sql = " Campo pc94_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into pctabela(
                                       pc94_sequencial
                                      ,pc94_codmater
                                      ,pc94_dt_cadastro
                       )
                values (
                                $this->pc94_sequencial
                               ,$this->pc94_codmater
                               ,'$this->pc94_dt_cadastro'
                      )";

     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "pctabela ($this->pc94_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "pctabela já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "pctabela ($this->pc94_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc94_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->pc94_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009320,'$this->pc94_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010203,1009320,'','".AddSlashes(pg_result($resaco,0,'pc94_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,1009321,'','".AddSlashes(pg_result($resaco,0,'pc94_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010203,1009327,'','".AddSlashes(pg_result($resaco,0,'pc94_dt_cadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }
    return true;
  }

  // funcao para alteracao
  function alterar ($pc94_sequencial=null) {
      $this->atualizacampos();
     $sql = " update pctabela set ";
     $virgula = "";
     if (trim($this->pc94_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc94_sequencial"])) {
       $sql  .= $virgula." pc94_sequencial = $this->pc94_sequencial ";
       $virgula = ",";
       if (trim($this->pc94_sequencial) == null ) {
         $this->erro_sql = " Campo Cód. Tabela não informado.";
         $this->erro_campo = "pc94_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->pc94_codmater)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc94_codmater"])) {
        if (trim($this->pc94_codmater)=="" && isset($GLOBALS["HTTP_POST_VARS"]["pc94_codmater"])) {
           $this->pc94_codmater = "0" ;
        }
       $sql  .= $virgula." pc94_codmater = $this->pc94_codmater ";
       $virgula = ",";
     }
     if (trim($this->pc94_dt_cadastro)!="" || isset($GLOBALS["HTTP_POST_VARS"]["pc94_dt_cadastro_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["pc94_dt_cadastro_dia"] !="") ) {
       $sql  .= $virgula." pc94_dt_cadastro = '$this->pc94_dt_cadastro' ";
       $virgula = ",";
       if (trim($this->pc94_dt_cadastro) == null ) {
         $this->erro_sql = " Campo Data de Cadastro não informado.";
         $this->erro_campo = "pc94_dt_cadastro_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{
       if (isset($GLOBALS["HTTP_POST_VARS"]["pc94_dt_cadastro_dia"])) {
         $sql  .= $virgula." pc94_dt_cadastro = null ";
         $virgula = ",";
         if (trim($this->pc94_dt_cadastro) == null ) {
           $this->erro_sql = " Campo Data de Cadastro não informado.";
           $this->erro_campo = "pc94_dt_cadastro_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if ($pc94_sequencial!=null) {
       $sql .= " pc94_sequencial = $this->pc94_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->pc94_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009320,'$this->pc94_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["pc94_sequencial"]) || $this->pc94_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009320,'".AddSlashes(pg_result($resaco,$conresaco,'pc94_sequencial'))."','$this->pc94_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["pc94_codmater"]) || $this->pc94_codmater != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009321,'".AddSlashes(pg_result($resaco,$conresaco,'pc94_codmater'))."','$this->pc94_codmater',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["pc94_dt_cadastro"]) || $this->pc94_dt_cadastro != "")
             $resac = db_query("insert into db_acount values($acount,1010203,1009327,'".AddSlashes(pg_result($resaco,$conresaco,'pc94_dt_cadastro'))."','$this->pc94_dt_cadastro',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $result = db_query($sql);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "pctabela nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc94_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "pctabela nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->pc94_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->pc94_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao
  function excluir ($pc94_sequencial=null,$dbwhere=null) {

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($pc94_sequencial));
       } else {
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009320,'$pc94_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010203,1009320,'','".AddSlashes(pg_result($resaco,$iresaco,'pc94_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,1009321,'','".AddSlashes(pg_result($resaco,$iresaco,'pc94_codmater'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010203,1009327,'','".AddSlashes(pg_result($resaco,$iresaco,'pc94_dt_cadastro'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }
     $sql = " delete from pctabela
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($pc94_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " pc94_sequencial = $pc94_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) {
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "pctabela nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$pc94_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "pctabela nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$pc94_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$pc94_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:pctabela";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql
  function sql_query ( $pc94_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from pctabela ";
     $sql .= "      left  join pcmater  on  pcmater.pc01_codmater = pctabela.pc94_codmater";
     $sql .= "      inner join db_usuarios  on  db_usuarios.id_usuario = pcmater.pc01_id_usuario";
     $sql .= "      inner join pcsubgrupo  on  pcsubgrupo.pc04_codsubgrupo = pcmater.pc01_codsubgrupo";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($pc94_sequencial!=null ) {
         $sql2 .= " where pctabela.pc94_sequencial = $pc94_sequencial ";
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
  function sql_query_file ( $pc94_sequencial=null,$campos="*",$ordem=null,$dbwhere="") {
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
     $sql .= " from pctabela ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($pc94_sequencial!=null ) {
         $sql2 .= " where pctabela.pc94_sequencial = $pc94_sequencial ";
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
