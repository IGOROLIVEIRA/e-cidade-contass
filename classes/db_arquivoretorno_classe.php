<?php
//MODULO: esocial
//CLASSE DA ENTIDADE arquivoretorno
class cl_arquivoretorno { 
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
  public $rh216_sequencial = 0; 
  public $rh216_arquivo = null; 
  public $rh216_dataimportacao_dia = null; 
  public $rh216_dataimportacao_mes = null; 
  public $rh216_dataimportacao_ano = null; 
  public $rh216_dataimportacao = null; 
  public $rh216_instit = null; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh216_sequencial = int8 = Código Sequencial 
                 rh216_arquivo = varchar(100) = Nome Arquivo 
                 rh216_dataimportacao = date = Data Importação 
                 rh216_instit = int4 = Instituição
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("arquivoretorno"); 
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
       $this->rh216_sequencial = ($this->rh216_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh216_sequencial"]:$this->rh216_sequencial);
       $this->rh216_arquivo = ($this->rh216_arquivo == ""?@$GLOBALS["HTTP_POST_VARS"]["rh216_arquivo"]:$this->rh216_arquivo);
       if ($this->rh216_dataimportacao == "") {
         $this->rh216_dataimportacao_dia = ($this->rh216_dataimportacao_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["rh216_dataimportacao_dia"]:$this->rh216_dataimportacao_dia);
         $this->rh216_dataimportacao_mes = ($this->rh216_dataimportacao_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["rh216_dataimportacao_mes"]:$this->rh216_dataimportacao_mes);
         $this->rh216_dataimportacao_ano = ($this->rh216_dataimportacao_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["rh216_dataimportacao_ano"]:$this->rh216_dataimportacao_ano);
         if ($this->rh216_dataimportacao_dia != "") {
            $this->rh216_dataimportacao = $this->rh216_dataimportacao_ano."-".$this->rh216_dataimportacao_mes."-".$this->rh216_dataimportacao_dia;
         }
       }
       $this->rh216_instit = ($this->rh216_instit == ""?@$GLOBALS["HTTP_POST_VARS"]["rh216_instit"]:$this->rh216_instit);
     } else {
       $this->rh216_sequencial = ($this->rh216_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh216_sequencial"]:$this->rh216_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh216_sequencial) { 
      $this->atualizacampos();
     if ($this->rh216_arquivo == null ) { 
       $this->erro_sql = " Campo Nome Arquivo não informado.";
       $this->erro_campo = "rh216_arquivo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh216_dataimportacao == null ) { 
       $this->erro_sql = " Campo Data Importação não informado.";
       $this->erro_campo = "rh216_dataimportacao_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh216_instit == null ) { 
       $this->erro_sql = " Campo Intituição não informado.";
       $this->erro_campo = "rh216_instit";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh216_sequencial == "" || $rh216_sequencial == null ) {
       $result = db_query("select nextval('arquivoretorno_rh216_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: arquivoretorno_rh216_sequencial_seq do campo: rh216_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh216_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from arquivoretorno_rh216_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh216_sequencial)) {
         $this->erro_sql = " Campo rh216_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh216_sequencial = $rh216_sequencial; 
       }
     }
     if (($this->rh216_sequencial == null) || ($this->rh216_sequencial == "") ) { 
       $this->erro_sql = " Campo rh216_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into arquivoretorno(
                                       rh216_sequencial 
                                      ,rh216_arquivo 
                                      ,rh216_dataimportacao 
                                      ,rh216_instit 
                       )
                values (
                                $this->rh216_sequencial 
                               ,'$this->rh216_arquivo' 
                               ,".($this->rh216_dataimportacao == "null" || $this->rh216_dataimportacao == ""?"null":"'".$this->rh216_dataimportacao."'")." 
                               ,$this->rh216_instit
                      )";
     $result = db_query($sql); 
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Controle Arquivo Retorno eSocial ($this->rh216_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Controle Arquivo Retorno eSocial já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Controle Arquivo Retorno eSocial ($this->rh216_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh216_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh216_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->rh216_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,0,'rh216_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,0,'rh216_arquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,0,'rh216_dataimportacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($rh216_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update arquivoretorno set ";
     $virgula = "";
     if (trim($this->rh216_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh216_sequencial"])) { 
       $sql  .= $virgula." rh216_sequencial = $this->rh216_sequencial ";
       $virgula = ",";
       if (trim($this->rh216_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "rh216_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh216_arquivo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh216_arquivo"])) { 
       $sql  .= $virgula." rh216_arquivo = '$this->rh216_arquivo' ";
       $virgula = ",";
       if (trim($this->rh216_arquivo) == null ) { 
         $this->erro_sql = " Campo Nome Arquivo não informado.";
         $this->erro_campo = "rh216_arquivo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh216_dataimportacao)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh216_dataimportacao_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["rh216_dataimportacao_dia"] !="") ) { 
       $sql  .= $virgula." rh216_dataimportacao = '$this->rh216_dataimportacao' ";
       $virgula = ",";
       if (trim($this->rh216_dataimportacao) == null ) { 
         $this->erro_sql = " Campo Data Importação não informado.";
         $this->erro_campo = "rh216_dataimportacao_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["rh216_dataimportacao_dia"])) { 
         $sql  .= $virgula." rh216_dataimportacao = null ";
         $virgula = ",";
         if (trim($this->rh216_dataimportacao) == null ) { 
           $this->erro_sql = " Campo Data Importação não informado.";
           $this->erro_campo = "rh216_dataimportacao_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if ($rh216_sequencial!=null) {
       $sql .= " rh216_sequencial = $this->rh216_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh216_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009244,'$this->rh216_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh216_sequencial"]) || $this->rh216_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009244,'".AddSlashes(pg_result($resaco,$conresaco,'rh216_sequencial'))."','$this->rh216_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh216_arquivo"]) || $this->rh216_arquivo != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009245,'".AddSlashes(pg_result($resaco,$conresaco,'rh216_arquivo'))."','$this->rh216_arquivo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh216_dataimportacao"]) || $this->rh216_dataimportacao != "")
             $resac = db_query("insert into db_acount values($acount,1010192,1009246,'".AddSlashes(pg_result($resaco,$conresaco,'rh216_dataimportacao'))."','$this->rh216_dataimportacao',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Controle Arquivo Retorno eSocial nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh216_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Controle Arquivo Retorno eSocial nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh216_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh216_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($rh216_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($rh216_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009244,'$rh216_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009244,'','".AddSlashes(pg_result($resaco,$iresaco,'rh216_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009245,'','".AddSlashes(pg_result($resaco,$iresaco,'rh216_arquivo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010192,1009246,'','".AddSlashes(pg_result($resaco,$iresaco,'rh216_dataimportacao'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from arquivoretorno
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($rh216_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " rh216_sequencial = $rh216_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Controle Arquivo Retorno eSocial nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh216_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Controle Arquivo Retorno eSocial nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh216_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh216_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:arquivoretorno";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh216_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from arquivoretorno ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh216_sequencial!=null ) {
         $sql2 .= " where arquivoretorno.rh216_sequencial = $rh216_sequencial "; 
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
  function sql_query_file ( $rh216_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from arquivoretorno ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh216_sequencial!=null ) {
         $sql2 .= " where arquivoretorno.rh216_sequencial = $rh216_sequencial "; 
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
