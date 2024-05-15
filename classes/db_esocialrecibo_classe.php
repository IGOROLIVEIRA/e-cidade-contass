<?php
//MODULO: esocial
//CLASSE DA ENTIDADE esocialrecibo
class cl_esocialrecibo { 
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
  public $rh215_sequencial = 0; 
  public $rh215_esocialenvio = 0; 
  public $rh215_recibo = null; 
  public $rh215_dataentrega_dia = null; 
  public $rh215_dataentrega_mes = null; 
  public $rh215_dataentrega_ano = null; 
  public $rh215_dataentrega = null; 
  // cria propriedade com as variaveis do arquivo 
  public $campos = "
                 rh215_sequencial = int4 = Código Sequencial 
                 rh215_esocialenvio = int8 = Código eScoail Envio 
                 rh215_recibo = varchar(100) = Número Recibo eSocial 
                 rh215_dataentrega = date = Data da Entrega 
                 ";

  //funcao construtor da classe 
  function __construct() { 
    //classes dos rotulos dos campos
    $this->rotulo = new rotulo("esocialrecibo"); 
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
       $this->rh215_sequencial = ($this->rh215_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh215_sequencial"]:$this->rh215_sequencial);
       $this->rh215_esocialenvio = ($this->rh215_esocialenvio == ""?@$GLOBALS["HTTP_POST_VARS"]["rh215_esocialenvio"]:$this->rh215_esocialenvio);
       $this->rh215_recibo = ($this->rh215_recibo == ""?@$GLOBALS["HTTP_POST_VARS"]["rh215_recibo"]:$this->rh215_recibo);
       if ($this->rh215_dataentrega == "") {
         $this->rh215_dataentrega_dia = ($this->rh215_dataentrega_dia == ""?@$GLOBALS["HTTP_POST_VARS"]["rh215_dataentrega_dia"]:$this->rh215_dataentrega_dia);
         $this->rh215_dataentrega_mes = ($this->rh215_dataentrega_mes == ""?@$GLOBALS["HTTP_POST_VARS"]["rh215_dataentrega_mes"]:$this->rh215_dataentrega_mes);
         $this->rh215_dataentrega_ano = ($this->rh215_dataentrega_ano == ""?@$GLOBALS["HTTP_POST_VARS"]["rh215_dataentrega_ano"]:$this->rh215_dataentrega_ano);
         if ($this->rh215_dataentrega_dia != "") {
            $this->rh215_dataentrega = $this->rh215_dataentrega_ano."-".$this->rh215_dataentrega_mes."-".$this->rh215_dataentrega_dia;
         }
       }
     } else {
       $this->rh215_sequencial = ($this->rh215_sequencial == ""?@$GLOBALS["HTTP_POST_VARS"]["rh215_sequencial"]:$this->rh215_sequencial);
     }
   }

  // funcao para inclusao
  function incluir ($rh215_sequencial = null) { 
      $this->atualizacampos();
     if ($this->rh215_esocialenvio == null ) { 
       $this->erro_sql = " Campo Código eScoail Envio não informado.";
       $this->erro_campo = "rh215_esocialenvio";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh215_recibo == null ) { 
       $this->erro_sql = " Campo Número Recibo eSocial não informado.";
       $this->erro_campo = "rh215_recibo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($this->rh215_dataentrega == null ) { 
       $this->erro_sql = " Campo Data da Entrega não informado.";
       $this->erro_campo = "rh215_dataentrega_dia";
       $this->erro_banco = "";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if ($rh215_sequencial == "" || $rh215_sequencial == null ) {
       $result = db_query("select nextval('esocialrecibo_rh215_sequencial_seq')"); 
       if ($result==false) {
         $this->erro_banco = str_replace("\n","",@pg_last_error());
         $this->erro_sql   = "Verifique o cadastro da sequencia: esocialrecibo_rh215_sequencial_seq do campo: rh215_sequencial"; 
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false; 
       }
       $this->rh215_sequencial = pg_result($result,0,0); 
     } else {
       $result = db_query("select last_value from esocialrecibo_rh215_sequencial_seq");
       if (($result != false) && (pg_result($result,0,0) < $rh215_sequencial)) {
         $this->erro_sql = " Campo rh215_sequencial maior que último número da sequencia.";
         $this->erro_banco = "Sequencia menor que este número.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       } else {
         $this->rh215_sequencial = $rh215_sequencial; 
       }
     }
     if (($this->rh215_sequencial == null) || ($this->rh215_sequencial == "") ) { 
       $this->erro_sql = " Campo rh215_sequencial nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $sql = "insert into esocialrecibo(
                                       rh215_sequencial 
                                      ,rh215_esocialenvio 
                                      ,rh215_recibo 
                                      ,rh215_dataentrega 
                       )
                values (
                                $this->rh215_sequencial 
                               ,$this->rh215_esocialenvio 
                               ,'$this->rh215_recibo' 
                               ,".($this->rh215_dataentrega == "null" || $this->rh215_dataentrega == ""?"null":"'".$this->rh215_dataentrega."'")." 
                      )";
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if ( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ) {
         $this->erro_sql   = "Recibo eSocial ($this->rh215_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "Recibo eSocial já Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       } else {
         $this->erro_sql   = "Recibo eSocial ($this->rh215_sequencial) nao Incluído. Inclusao Abortada.";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       $this->numrows_incluir= 0;
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh215_sequencial;
     $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     $this->numrows_incluir= pg_affected_rows($result);
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh215_sequencial  ));
       if (($resaco!=false)||($this->numrows!=0)) {

         $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
         $acount = pg_result($resac,0,0);
         $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
         $resac = db_query("insert into db_acountkey values($acount,1009250,'$this->rh215_sequencial','I')");
         $resac = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,0,'rh215_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,0,'rh215_esocialenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,0,'rh215_recibo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         $resac = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,0,'rh215_dataentrega'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
       }
    }*/
    return true;
  }

  // funcao para alteracao
  function alterar ($rh215_sequencial=null) { 
      $this->atualizacampos();
     $sql = " update esocialrecibo set ";
     $virgula = "";
     if (trim($this->rh215_sequencial)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh215_sequencial"])) { 
       $sql  .= $virgula." rh215_sequencial = $this->rh215_sequencial ";
       $virgula = ",";
       if (trim($this->rh215_sequencial) == null ) { 
         $this->erro_sql = " Campo Código Sequencial não informado.";
         $this->erro_campo = "rh215_sequencial";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh215_esocialenvio)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh215_esocialenvio"])) { 
       $sql  .= $virgula." rh215_esocialenvio = $this->rh215_esocialenvio ";
       $virgula = ",";
       if (trim($this->rh215_esocialenvio) == null ) { 
         $this->erro_sql = " Campo Código eScoail Envio não informado.";
         $this->erro_campo = "rh215_esocialenvio";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh215_recibo)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh215_recibo"])) { 
       $sql  .= $virgula." rh215_recibo = '$this->rh215_recibo' ";
       $virgula = ",";
       if (trim($this->rh215_recibo) == null ) { 
         $this->erro_sql = " Campo Número Recibo eSocial não informado.";
         $this->erro_campo = "rh215_recibo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if (trim($this->rh215_dataentrega)!="" || isset($GLOBALS["HTTP_POST_VARS"]["rh215_dataentrega_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["rh215_dataentrega_dia"] !="") ) { 
       $sql  .= $virgula." rh215_dataentrega = '$this->rh215_dataentrega' ";
       $virgula = ",";
       if (trim($this->rh215_dataentrega) == null ) { 
         $this->erro_sql = " Campo Data da Entrega não informado.";
         $this->erro_campo = "rh215_dataentrega_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if (isset($GLOBALS["HTTP_POST_VARS"]["rh215_dataentrega_dia"])) { 
         $sql  .= $virgula." rh215_dataentrega = null ";
         $virgula = ",";
         if (trim($this->rh215_dataentrega) == null ) { 
           $this->erro_sql = " Campo Data da Entrega não informado.";
           $this->erro_campo = "rh215_dataentrega_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     $sql .= " where ";
     if ($rh215_sequencial!=null) {
       $sql .= " rh215_sequencial = $this->rh215_sequencial";
     }
     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       $resaco = $this->sql_record($this->sql_query_file($this->rh215_sequencial));
       if ($this->numrows>0) {

         for($conresaco=0;$conresaco<$this->numrows;$conresaco++) {

           $resac = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac = db_query("insert into db_acountkey values($acount,1009250,'$this->rh215_sequencial','A')");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh215_sequencial"]) || $this->rh215_sequencial != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009250,'".AddSlashes(pg_result($resaco,$conresaco,'rh215_sequencial'))."','$this->rh215_sequencial',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh215_esocialenvio"]) || $this->rh215_esocialenvio != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009251,'".AddSlashes(pg_result($resaco,$conresaco,'rh215_esocialenvio'))."','$this->rh215_esocialenvio',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh215_recibo"]) || $this->rh215_recibo != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009252,'".AddSlashes(pg_result($resaco,$conresaco,'rh215_recibo'))."','$this->rh215_recibo',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           if (isset($GLOBALS["HTTP_POST_VARS"]["rh215_dataentrega"]) || $this->rh215_dataentrega != "")
             $resac = db_query("insert into db_acount values($acount,1010193,1009253,'".AddSlashes(pg_result($resaco,$conresaco,'rh215_dataentrega'))."','$this->rh215_dataentrega',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $result = db_query($sql);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Recibo eSocial nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh215_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_alterar = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Recibo eSocial nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->rh215_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_alterar = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Alteração efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->rh215_sequencial;
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "1";
        $this->numrows_alterar = pg_affected_rows($result);
        return true;
      }
    }
  }

  // funcao para exclusao 
  function excluir ($rh215_sequencial=null,$dbwhere=null) { 

     $lSessaoDesativarAccount = db_getsession("DB_desativar_account", false);
     /*if (!isset($lSessaoDesativarAccount) || (isset($lSessaoDesativarAccount)
       && ($lSessaoDesativarAccount === false))) {

       if ($dbwhere==null || $dbwhere=="") {

         $resaco = $this->sql_record($this->sql_query_file($rh215_sequencial));
       } else { 
         $resaco = $this->sql_record($this->sql_query_file(null,"*",null,$dbwhere));
       }
       if (($resaco != false) || ($this->numrows!=0)) {

         for ($iresaco = 0; $iresaco < $this->numrows; $iresaco++) {

           $resac  = db_query("select nextval('db_acount_id_acount_seq') as acount");
           $acount = pg_result($resac,0,0);
           $resac  = db_query("insert into db_acountacesso values($acount,".db_getsession("DB_acessado").")");
           $resac  = db_query("insert into db_acountkey values($acount,1009250,'$rh215_sequencial','E')");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009250,'','".AddSlashes(pg_result($resaco,$iresaco,'rh215_sequencial'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009251,'','".AddSlashes(pg_result($resaco,$iresaco,'rh215_esocialenvio'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009252,'','".AddSlashes(pg_result($resaco,$iresaco,'rh215_recibo'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
           $resac  = db_query("insert into db_acount values($acount,1010193,1009253,'','".AddSlashes(pg_result($resaco,$iresaco,'rh215_dataentrega'))."',".db_getsession('DB_datausu').",".db_getsession('DB_id_usuario').")");
         }
       }
     }*/
     $sql = " delete from esocialrecibo
                    where ";
     $sql2 = "";
     if ($dbwhere==null || $dbwhere =="") {
        if ($rh215_sequencial != "") {
          if ($sql2!="") {
            $sql2 .= " and ";
          }
          $sql2 .= " rh215_sequencial = $rh215_sequencial ";
        }
     } else {
       $sql2 = $dbwhere;
     }
     $result = db_query($sql.$sql2);
     if ($result==false) { 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Recibo eSocial nao Excluído. Exclusão Abortada.\\n";
       $this->erro_sql .= "Valores : ".$rh215_sequencial;
       $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       $this->numrows_excluir = 0;
       return false;
     } else {
       if (pg_affected_rows($result)==0) {
         $this->erro_banco = "";
         $this->erro_sql = "Recibo eSocial nao Encontrado. Exclusão não Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$rh215_sequencial;
         $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         $this->numrows_excluir = 0;
         return true;
       } else {
         $this->erro_banco = "";
         $this->erro_sql = "Exclusão efetuada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$rh215_sequencial;
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
        $this->erro_sql   = "Record Vazio na Tabela:esocialrecibo";
        $this->erro_msg   = "Usuário: \\n\\n ".$this->erro_sql." \\n\\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
    return $result;
  }

  // funcao do sql 
  function sql_query ( $rh215_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from esocialrecibo ";
     $sql .= "      inner join esocialenvio  on  esocialenvio.rh213_sequencial = esocialrecibo.rh215_esocialenvio";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh215_sequencial!=null ) {
         $sql2 .= " where esocialrecibo.rh215_sequencial = $rh215_sequencial "; 
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
  function sql_query_file ( $rh215_sequencial=null,$campos="*",$ordem=null,$dbwhere="") { 
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
     $sql .= " from esocialrecibo ";
     $sql2 = "";
     if ($dbwhere=="") {
       if ($rh215_sequencial!=null ) {
         $sql2 .= " where esocialrecibo.rh215_sequencial = $rh215_sequencial "; 
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
